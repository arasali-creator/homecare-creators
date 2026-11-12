<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/mailer.php';
require_once dirname(__DIR__) . '/includes/directory.php';
hc_require_auth();
hc_dir_ensure_schema();

function dir_return_url(string $qs): string {
    parse_str($qs, $r);
    $r = array_intersect_key($r, array_flip(['view', 'plan', 's']));
    $r = array_filter(array_map(fn($v) => is_string($v) ? $v : '', $r), 'strlen');
    return '/admin/directory/' . ($r ? '?' . http_build_query($r) : '');
}
$back = dir_return_url((string)($_GET['return'] ?? ''));

// ── Map geocoding in small batches (OpenStreetMap allows ~1 request/second) ──
if (($_GET['action'] ?? '') === 'geocode_batch') {
    @set_time_limit(90);
    $todo = hc_all("SELECT id FROM hc_directory_listings WHERE status='approved' AND lat IS NULL AND geocoded_at IS NULL ORDER BY id LIMIT 15");
    $ok = 0;
    foreach ($todo as $i => $t) { if ($i) usleep(1100000); if (hc_dir_geocode((int)$t['id'])) $ok++; }
    $left = (int)hc_val("SELECT COUNT(*) FROM hc_directory_listings WHERE status='approved' AND lat IS NULL AND geocoded_at IS NULL");
    hc_flash("Mapped {$ok} of " . count($todo) . " listings." . ($left ? " {$left} still to map — click \"Map listings\" again." : ' All live listings are mapped.'));
    header('Location: /admin/directory/'); exit;
}

// ── Logos: fetch from agency websites, or apply the researched logo pack ──
if (($_GET['action'] ?? '') === 'fetch_logos') {
    @set_time_limit(120);
    $todo = hc_all("SELECT id, company_name FROM hc_directory_listings WHERE (logo IS NULL OR logo='') AND website IS NOT NULL AND website<>'' ORDER BY status='approved' DESC, id LIMIT 8");
    $ok = 0; $miss = [];
    foreach ($todo as $t) { if (hc_dir_fetch_logo((int)$t['id'])) $ok++; else $miss[] = $t['company_name']; }
    hc_flash("Found logos for {$ok} of " . count($todo) . " listings." . ($miss ? ' No usable logo found for: ' . implode(', ', array_slice($miss, 0, 5)) . (count($miss) > 5 ? '…' : '') . ' — upload these manually.' : ''));
    header('Location: /admin/directory/'); exit;
}
$logoPackFile = dirname(dirname(__DIR__)) . '/images/directory/logos/manifest.json';
if (($_GET['action'] ?? '') === 'apply_logo_pack' && is_file($logoPackFile)) {
    $pack = json_decode((string)file_get_contents($logoPackFile), true) ?: [];
    $logos = 0; $sites = 0;
    foreach ($pack as $row) {
        if (empty($row['slug'])) continue;
        if (!empty($row['logo'])) $logos += hc_q("UPDATE hc_directory_listings SET logo=? WHERE slug=? AND (logo IS NULL OR logo='')", [$row['logo'], $row['slug']])->rowCount();
        if (!empty($row['website'])) $sites += hc_q("UPDATE hc_directory_listings SET website=? WHERE slug=? AND (website IS NULL OR website='')", [$row['website'], $row['slug']])->rowCount();
    }
    hc_flash("Logo pack applied: {$logos} logos and {$sites} websites added. Existing logos and websites were left unchanged.");
    header('Location: /admin/directory/'); exit;
}

// ── Single actions ───────────────────────────────────────────────────────────
$action = $_GET['action'] ?? '';
$aid    = (int)($_GET['id'] ?? 0);
if ($action && $aid) {
    $row = hc_one("SELECT * FROM hc_directory_listings WHERE id=?", [$aid]);
    if ($row) {
        switch ($action) {
            case 'approve':
                hc_q("UPDATE hc_directory_listings SET status='approved', approved_at=IFNULL(approved_at,NOW()), rejection_reason=NULL WHERE id=?", [$aid]);
                $sent = $row['status'] !== 'approved' ? hc_dir_send_approved($aid) : false;
                hc_flash('Listing approved and live.' . ($sent ? ' The agency was emailed.' : ''));
                break;
            case 'reject':
                hc_q("UPDATE hc_directory_listings SET status='rejected' WHERE id=?", [$aid]);
                hc_flash('Listing rejected.');
                break;
            case 'invoiced':
                hc_q("UPDATE hc_directory_listings SET payment_status='invoiced' WHERE id=?", [$aid]);
                hc_flash('Marked as invoiced.');
                break;
            case 'paid':
                hc_dir_mark_paid($aid, 1);
                hc_flash('Payment recorded. The paid plan is active for 1 month.');
                break;
            case 'resend':
                hc_flash(hc_dir_send_owner_confirmation($aid) ? 'Confirmation email re-sent to ' . $row['owner_email'] . '.' : 'Could not send. Check that the listing has an owner email and that SMTP is set up.', 'error');
                break;
            case 'claim_ok':
                hc_q("UPDATE hc_directory_listings SET claim_status='verified' WHERE id=?", [$aid]);
                hc_flash('Claim verified. The listing now shows as Claimed.');
                break;
            case 'claim_reject':
                hc_q("UPDATE hc_directory_listings SET claim_status=NULL, owner_name=NULL, owner_title=NULL, owner_email=NULL, owner_phone=NULL,
                      owner_authorized=0, owner_confirmed_at=NULL, confirm_token=NULL, requested_plan=NULL,
                      payment_status=IF(payment_status IN ('pending','invoiced'),'none',payment_status) WHERE id=?", [$aid]);
                hc_flash('Claim rejected and owner details cleared.');
                break;
            case 'delete':
                hc_q("DELETE FROM hc_directory_leads WHERE listing_id=?", [$aid]);
                hc_q("DELETE FROM hc_directory_listings WHERE id=?", [$aid]);
                hc_flash('Listing deleted.');
                break;
        }
    }
    header('Location: ' . $back); exit;
}

// ── Bulk actions ─────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['bulk_action'])) {
    $ids = array_values(array_filter(array_map('intval', $_POST['ids'] ?? [])));
    $ret = dir_return_url((string)($_POST['return'] ?? ''));
    if ($ids) {
        $ph = implode(',', array_fill(0, count($ids), '?'));
        switch ($_POST['bulk_action']) {
            case 'approve':
                $newly = array_column(hc_all("SELECT id FROM hc_directory_listings WHERE id IN ($ph) AND status<>'approved'", $ids), 'id');
                hc_q("UPDATE hc_directory_listings SET status='approved', approved_at=IFNULL(approved_at,NOW()), rejection_reason=NULL WHERE id IN ($ph)", $ids);
                foreach ($newly as $nid) hc_dir_send_approved((int)$nid);
                hc_flash(count($ids) . ' listing(s) approved.');
                break;
            case 'reject':
                hc_q("UPDATE hc_directory_listings SET status='rejected' WHERE id IN ($ph)", $ids);
                hc_flash(count($ids) . ' listing(s) rejected.');
                break;
            case 'delete':
                hc_q("DELETE FROM hc_directory_leads WHERE listing_id IN ($ph)", $ids);
                hc_q("DELETE FROM hc_directory_listings WHERE id IN ($ph)", $ids);
                hc_flash(count($ids) . ' listing(s) deleted.');
                break;
        }
    }
    header('Location: ' . $ret); exit;
}

// ── Listing query ────────────────────────────────────────────────────────────
$views = [
    'pending'  => ['Pending review', "status='pending'"],
    'claims'   => ['Claims',         "claim_status IN ('pending','confirmed')"],
    'billing'  => ['Billing',        "(payment_status IN ('pending','invoiced','overdue') OR (payment_status='paid' AND paid_until < CURDATE() + INTERVAL 7 DAY))"],
    'approved' => ['Live',           "status='approved'"],
    'rejected' => ['Rejected',       "status='rejected'"],
    'all'      => ['All',            "1=1"],
];
$view = isset($views[$_GET['view'] ?? '']) ? $_GET['view'] : (isset($views[$_GET['status'] ?? '']) ? $_GET['status'] : 'pending');
$planF = in_array($_GET['plan'] ?? '', ['free', 'premium', 'featured'], true) ? $_GET['plan'] : '';
$s = trim($_GET['s'] ?? '');

$where = [$views[$view][1]]; $params = [];
if ($planF === 'free') $where[] = hc_dir_rank_sql() . " = 0";
if ($planF === 'premium') $where[] = hc_dir_rank_sql() . " = 1";
if ($planF === 'featured') $where[] = hc_dir_rank_sql() . " = 2";
if ($s !== '') {
    $where[] = "(company_name LIKE ? OR city LIKE ? OR owner_name LIKE ? OR owner_email LIKE ? OR email LIKE ?)";
    $like = '%' . $s . '%'; array_push($params, $like, $like, $like, $like, $like);
}
$listings = hc_all("SELECT l.*, (SELECT COUNT(*) FROM hc_directory_leads d WHERE d.listing_id=l.id) lead_count
                    FROM hc_directory_listings l WHERE " . implode(' AND ', $where) . " ORDER BY created_at DESC LIMIT 500", $params);

$counts = [];
foreach ($views as $k => $v) $counts[$k] = (int)hc_val("SELECT COUNT(*) FROM hc_directory_listings WHERE {$v[1]}");
$rank = hc_dir_rank_sql();
$stats = hc_one("SELECT SUM($rank=1) prem, SUM($rank=2) feat, SUM(owner_confirmed_at IS NOT NULL) confirmed FROM hc_directory_listings WHERE status='approved'") ?: [];
$plans = hc_dir_plans();
$mrr = (int)($stats['prem'] ?? 0) * $plans['premium']['price'] + (int)($stats['feat'] ?? 0) * $plans['featured']['price'];
$leads30 = (int)hc_val("SELECT COUNT(*) FROM hc_directory_leads WHERE created_at > NOW() - INTERVAL 30 DAY");

$returnQs = http_build_query(array_filter(['view' => $view, 'plan' => $planF, 's' => $s]));
$payBadge = ['none' => 'badge-gray', 'pending' => 'badge-red', 'invoiced' => 'badge-blue', 'paid' => 'badge-green', 'comp' => 'badge-green', 'overdue' => 'badge-red'];

hc_head('Agency Directory');
hc_topbar('Agency Directory', '<a href="/admin/">Admin</a> › Directory');
?>
<style>
.dir-owner{font-size:12.5px;line-height:1.5}
.dir-owner .ok{color:#0d7a57;font-weight:600}
.dir-owner .no{color:#b45309;font-weight:600}
.dir-sub{font-size:11.5px;color:var(--muted);margin-top:2px}
.dir-toolbar{display:flex;gap:8px;flex-wrap:wrap;align-items:center;margin-bottom:16px}
.dir-toolbar form{display:flex;gap:8px;margin-left:auto}
.dir-toolbar input,.dir-toolbar select{padding:7px 10px;border:1px solid var(--border);border-radius:8px;font-size:13px;font-family:inherit;background:#fff}
.td-actions a{white-space:nowrap}
</style>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Agency Directory</h1><div class="sub">Listings, owner confirmations, claims and invoicing</div></div>
  <div style="display:flex;gap:8px;flex-wrap:wrap">
    <?php $pendRev = (int)hc_val("SELECT COUNT(*) FROM hc_directory_reviews WHERE status='pending'"); $unmapped = (int)hc_val("SELECT COUNT(*) FROM hc_directory_listings WHERE status='approved' AND lat IS NULL AND geocoded_at IS NULL"); ?>
    <a href="/admin/directory/reviews.php" class="btn btn-secondary">Reviews<?php if ($pendRev): ?> <span class="badge badge-red" style="margin-left:4px"><?= $pendRev ?></span><?php endif ?></a>
    <?php
      $noLogo = (int)hc_val("SELECT COUNT(*) FROM hc_directory_listings WHERE (logo IS NULL OR logo='') AND website IS NOT NULL AND website<>''");
      $packPending = 0;
      if (is_file($logoPackFile)) {
          $packSlugs = array_column(array_filter(json_decode((string)file_get_contents($logoPackFile), true) ?: [], fn($r) => !empty($r['logo'])), 'slug');
          if ($packSlugs) $packPending = (int)hc_val("SELECT COUNT(*) FROM hc_directory_listings WHERE (logo IS NULL OR logo='') AND slug IN (" . implode(',', array_fill(0, count($packSlugs), '?')) . ")", $packSlugs);
      }
    ?>
    <?php if ($packPending): ?><a href="/admin/directory/?action=apply_logo_pack" class="btn btn-primary" data-confirm="Add researched logos (and websites) to <?= $packPending ?> listings that don't have one yet?">Apply logo pack (<?= $packPending ?>)</a><?php endif ?>
    <?php if ($noLogo): ?><a href="/admin/directory/?action=fetch_logos" class="btn btn-secondary" title="Finds the logo on each agency's website, 8 at a time">Fetch logos (<?= $noLogo ?>)</a><?php endif ?>
    <?php if ($unmapped): ?><a href="/admin/directory/?action=geocode_batch" class="btn btn-secondary" title="Looks up map pins for listings (15 at a time, takes ~20 seconds)">Map listings (<?= $unmapped ?>)</a><?php endif ?>
    <a href="/admin/directory/leads.php" class="btn btn-secondary">Inquiries</a>
    <a href="/admin/directory/settings.php" class="btn btn-secondary">Plans &amp; pricing</a>
    <a href="/admin/directory/edit.php" class="btn btn-primary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      Add Listing
    </a>
  </div>
</div>

<div class="stats-grid" style="margin-bottom:18px">
  <div class="stat-card"><div class="stat-label">Live listings</div><div class="stat-num"><?= $counts['approved'] ?></div></div>
  <div class="stat-card"><div class="stat-label">Paid (Premium / Featured)</div><div class="stat-num"><?= (int)($stats['prem'] ?? 0) ?> / <?= (int)($stats['feat'] ?? 0) ?></div></div>
  <div class="stat-card"><div class="stat-label">Monthly recurring (est.)</div><div class="stat-num">$<?= number_format($mrr) ?></div></div>
  <div class="stat-card"><div class="stat-label">Owner-confirmed</div><div class="stat-num"><?= (int)($stats['confirmed'] ?? 0) ?></div></div>
  <div class="stat-card"><div class="stat-label">Inquiries (30 days)</div><div class="stat-num"><?= $leads30 ?></div></div>
</div>

<div class="dir-toolbar">
  <?php foreach ($views as $k => $v): ?>
  <a href="?<?= http_build_query(array_filter(['view' => $k, 'plan' => $planF, 's' => $s])) ?>" class="btn btn-sm <?= $view === $k ? 'btn-primary' : 'btn-secondary' ?>">
    <?= $v[0] ?> <span style="opacity:.7">(<?= $counts[$k] ?>)</span>
  </a>
  <?php endforeach ?>
  <form method="GET">
    <input type="hidden" name="view" value="<?= h($view) ?>">
    <select name="plan" onchange="this.form.submit()">
      <option value="">All plans</option>
      <?php foreach ($plans as $k => $p): ?><option value="<?= $k ?>" <?= $planF === $k ? 'selected' : '' ?>><?= h($p['name']) ?> (active)</option><?php endforeach ?>
    </select>
    <input type="search" name="s" value="<?= h($s) ?>" placeholder="Search agency, city, owner…">
  </form>
</div>

<div class="card">
  <?php if ($listings): ?>
  <form method="POST" id="bulkForm">
    <input type="hidden" name="return" value="<?= h($returnQs) ?>">
    <div style="display:flex;align-items:center;gap:10px;margin-bottom:12px">
      <span style="font-size:12.5px;color:var(--muted)" id="bulkCount">0 selected</span>
      <button type="submit" name="bulk_action" value="approve" class="btn btn-secondary btn-sm bulk-btn" disabled>Approve</button>
      <button type="submit" name="bulk_action" value="reject" class="btn btn-secondary btn-sm bulk-btn" disabled data-confirm="Reject all selected listings?">Reject</button>
      <button type="submit" name="bulk_action" value="delete" class="btn btn-danger btn-sm bulk-btn" disabled data-confirm="Permanently delete all selected listings?">Delete</button>
    </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th style="width:30px"><input type="checkbox" id="selectAll"></th><th>Agency</th><th>Plan &amp; billing</th><th>Owner / rep</th><th>Status</th><th>Submitted</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($listings as $l):
        $tier = hc_dir_tier($l);
        $req  = $l['requested_plan'];
        $ps   = $l['payment_status'] ?: 'none';
        $act  = fn($a) => '?action=' . $a . '&id=' . $l['id'] . '&return=' . urlencode($returnQs);
      ?>
      <tr>
        <td><input type="checkbox" class="row-check" name="ids[]" value="<?= $l['id'] ?>"></td>
        <td>
          <strong><a href="/admin/directory/edit.php?id=<?= $l['id'] ?>" style="color:inherit;text-decoration:none"><?= h($l['company_name']) ?></a></strong>
          <div class="dir-sub"><?= h($l['city']) ?>, <?= h($l['state']) ?> · <span style="font-family:monospace">/directory/<?= h($l['slug']) ?></span></div>
          <?php if ($l['lead_count']): ?><div class="dir-sub"><?= (int)$l['lead_count'] ?> inquir<?= $l['lead_count'] == 1 ? 'y' : 'ies' ?></div><?php endif ?>
        </td>
        <td style="font-size:12.5px">
          <span class="badge <?= $tier === 'featured' ? 'badge-gold' : ($tier === 'premium' ? 'badge-green' : 'badge-gray') ?>"><?= h($plans[$tier]['name']) ?></span>
          <?php if ($req && $req !== $tier): ?><div class="dir-sub">Requested: <strong style="color:var(--text)"><?= h($plans[$req]['name'] ?? $req) ?></strong></div><?php endif ?>
          <?php if ($ps !== 'none'): ?><div style="margin-top:4px"><span class="badge <?= $payBadge[$ps] ?? 'badge-gray' ?>"><?= h(HC_DIR_PAYMENT_STATUSES[$ps] ?? $ps) ?></span></div><?php endif ?>
          <?php if ($l['paid_until']): ?><div class="dir-sub" style="<?= strtotime($l['paid_until']) < time() ? 'color:var(--red)' : '' ?>">Paid until <?= date('M j, Y', strtotime($l['paid_until'])) ?></div><?php endif ?>
        </td>
        <td class="dir-owner">
          <?php if ($l['owner_email']): ?>
            <strong><?= h($l['owner_name']) ?></strong> <span style="color:var(--muted)">· <?= h($l['owner_title']) ?></span><br>
            <a href="mailto:<?= h($l['owner_email']) ?>"><?= h($l['owner_email']) ?></a><?php if ($l['owner_phone']): ?> · <?= h($l['owner_phone']) ?><?php endif ?><br>
            <?php if ($l['owner_confirmed_at']): ?><span class="ok">✓ Email confirmed</span><?php else: ?><span class="no">Not confirmed</span> · <a href="<?= $act('resend') ?>">resend</a><?php endif ?>
            <?php if (hc_dir_domain_match($l)): ?> · <span class="ok" title="Owner email is on the agency website's domain">domain match</span><?php endif ?>
            <?php if (in_array($l['claim_status'], ['pending', 'confirmed'], true)): ?><br><span class="badge badge-blue">Claim <?= h($l['claim_status']) ?></span><?php endif ?>
          <?php else: ?>
            <span style="color:var(--muted)">No owner on file</span>
          <?php endif ?>
        </td>
        <td><span class="badge <?= $l['status'] === 'approved' ? 'badge-green' : ($l['status'] === 'rejected' ? 'badge-red' : 'badge-gray') ?>"><?= h($l['status'] === 'approved' ? 'live' : $l['status']) ?></span></td>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= date('M j, Y', strtotime($l['created_at'])) ?></td>
        <td class="td-actions">
          <?php if ($l['status'] !== 'approved'): ?>
          <a href="<?= $act('approve') ?>" <?= !$l['owner_confirmed_at'] && $l['owner_email'] ? 'data-confirm="The owner hasn\'t confirmed by email yet. Approve anyway?"' : '' ?>>Approve</a>
          <?php endif ?>
          <?php if (in_array($l['claim_status'], ['pending', 'confirmed'], true)): ?>
          <a href="<?= $act('claim_ok') ?>" <?= $l['claim_status'] === 'pending' ? 'data-confirm="The claimant hasn\'t confirmed by email yet. Verify anyway?"' : '' ?>>Verify claim</a>
          <a href="<?= $act('claim_reject') ?>" class="danger" data-confirm="Reject this claim and clear the owner details?">Reject claim</a>
          <?php endif ?>
          <?php if ($ps === 'pending'): ?><a href="<?= $act('invoiced') ?>">Mark invoiced</a><?php endif ?>
          <?php if (in_array($ps, ['pending', 'invoiced', 'overdue', 'paid'], true) && ($req || $l['plan'] !== 'free')): ?>
          <a href="<?= $act('paid') ?>" data-confirm="Record a 1-month payment for <?= h($plans[$req ?: $l['plan']]['name'] ?? '') ?>?"><?= $ps === 'paid' ? 'Renew +1 mo' : 'Mark paid' ?></a>
          <?php endif ?>
          <a href="/admin/directory/edit.php?id=<?= $l['id'] ?>">Edit</a>
          <?php if ($l['status'] === 'approved'): ?><a href="/directory/<?= urlencode($l['slug']) ?>" target="_blank">View</a><?php endif ?>
          <?php if ($l['status'] !== 'rejected'): ?><a href="<?= $act('reject') ?>" class="danger" data-confirm="Reject '<?= h($l['company_name']) ?>'?">Reject</a><?php endif ?>
          <a href="<?= $act('delete') ?>" class="danger" data-confirm="Permanently delete '<?= h($l['company_name']) ?>'?">Delete</a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  </form>
  <script>
  (function(){
    var selectAll = document.getElementById('selectAll');
    var checks = document.querySelectorAll('.row-check');
    var countEl = document.getElementById('bulkCount');
    var btns = document.querySelectorAll('.bulk-btn');
    function update() {
      var n = document.querySelectorAll('.row-check:checked').length;
      countEl.textContent = n + ' selected';
      btns.forEach(function(b){ b.disabled = n === 0; });
    }
    selectAll.addEventListener('change', function(){ checks.forEach(function(c){ c.checked = selectAll.checked; }); update(); });
    checks.forEach(function(c){ c.addEventListener('change', update); });
  })();
  </script>
  <?php else: ?>
  <div class="empty-state">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    <p>Nothing in “<?= h($views[$view][0]) ?>”<?= $s !== '' ? ' matching “' . h($s) . '”' : '' ?>.</p>
  </div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
