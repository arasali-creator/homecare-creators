<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/directory.php';
hc_require_auth();
hc_dir_ensure_schema();

$view = in_array($_GET['view'] ?? '', ['pending', 'approved', 'rejected', 'all'], true) ? $_GET['view'] : 'pending';
$back = '/admin/directory/reviews.php?view=' . $view;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rid = (int)($_POST['id'] ?? 0);
    $r = $rid ? hc_one("SELECT * FROM hc_directory_reviews WHERE id=?", [$rid]) : null;
    if ($r) {
        switch ($_POST['do'] ?? '') {
            case 'approve':
                hc_q("UPDATE hc_directory_reviews SET status='approved', approved_at=IFNULL(approved_at,NOW()) WHERE id=?", [$rid]);
                hc_flash('Review approved and published.');
                break;
            case 'reject':
                hc_q("UPDATE hc_directory_reviews SET status='rejected' WHERE id=?", [$rid]);
                hc_flash('Review rejected.');
                break;
            case 'delete':
                hc_q("DELETE FROM hc_directory_reviews WHERE id=?", [$rid]);
                hc_flash('Review deleted.');
                break;
            case 'respond':
                $resp = trim((string)($_POST['owner_response'] ?? ''));
                hc_q("UPDATE hc_directory_reviews SET owner_response=?, response_at=" . ($resp !== '' ? 'NOW()' : 'NULL') . " WHERE id=?", [$resp !== '' ? $resp : null, $rid]);
                hc_flash($resp !== '' ? 'Agency response saved.' : 'Agency response removed.');
                break;
        }
        hc_dir_recalc_rating((int)$r['listing_id']);
    }
    header('Location: ' . $back); exit;
}

$where = $view === 'all' ? '1=1' : 'r.status=?';
$reviews = hc_all("SELECT r.*, l.company_name, l.slug FROM hc_directory_reviews r LEFT JOIN hc_directory_listings l ON l.id=r.listing_id
                   WHERE $where ORDER BY r.created_at DESC LIMIT 300", $view === 'all' ? [] : [$view]);
$counts = ['pending' => 0, 'approved' => 0, 'rejected' => 0, 'all' => 0];
foreach (hc_all("SELECT status, COUNT(*) n FROM hc_directory_reviews GROUP BY status") as $c) { $counts[$c['status']] = (int)$c['n']; $counts['all'] += (int)$c['n']; }

hc_head('Directory Reviews');
hc_topbar('Directory Reviews', '<a href="/admin/">Admin</a> › <a href="/admin/directory/">Directory</a> › Reviews');
?>
<style>
.rvw{border-top:1px solid var(--border);padding:18px 0}
.rvw:first-child{border-top:0;padding-top:4px}
.rvw-h{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:6px}
.rvw-stars{color:#e0a020;letter-spacing:1px}
.rvw-body{font-size:14px;line-height:1.6;white-space:pre-line;margin:6px 0 10px}
.rvw-acts{display:flex;gap:8px;flex-wrap:wrap;align-items:flex-start}
.rvw-acts form{display:inline}
.rvw details summary{cursor:pointer;font-size:13px;color:var(--teal);margin-top:8px}
.rvw textarea{width:100%;margin-top:8px}
</style>
<div class="page-content">
<?= hc_show_flash() ?>
<div class="page-header">
  <div><h1>Reviews</h1><div class="sub">Approve family reviews before they appear on listings. Approving or rejecting updates the agency's star rating.</div></div>
  <a href="/admin/directory/" class="btn btn-secondary">← Directory</a>
</div>
<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
  <?php foreach (['pending' => 'Pending', 'approved' => 'Published', 'rejected' => 'Rejected', 'all' => 'All'] as $k => $lab): ?>
  <a href="?view=<?= $k ?>" class="btn btn-sm <?= $view === $k ? 'btn-primary' : 'btn-secondary' ?>"><?= $lab ?> <span style="opacity:.7">(<?= $counts[$k] ?>)</span></a>
  <?php endforeach ?>
</div>
<div class="card">
<?php if ($reviews): foreach ($reviews as $r): ?>
  <div class="rvw">
    <div class="rvw-h">
      <div>
        <span class="rvw-stars"><?= str_repeat('★', (int)$r['rating']) . str_repeat('☆', 5 - (int)$r['rating']) ?></span>
        <strong style="margin-left:8px"><?= h($r['title'] ?: '(no title)') ?></strong>
        <div style="font-size:12.5px;color:var(--muted);margin-top:3px">
          for <a href="/directory/<?= h($r['slug']) ?>" target="_blank"><?= h($r['company_name'] ?? '(deleted)') ?></a> ·
          <?= h($r['name']) ?> &lt;<?= h($r['email']) ?>&gt; · <?= h($r['relationship']) ?> · <?= date('M j, Y g:ia', strtotime($r['created_at'])) ?> · IP <?= h($r['ip_address']) ?>
        </div>
      </div>
      <span class="badge <?= $r['status'] === 'approved' ? 'badge-green' : ($r['status'] === 'rejected' ? 'badge-red' : 'badge-gold') ?>"><?= h($r['status']) ?></span>
    </div>
    <div class="rvw-body"><?= h($r['body']) ?></div>
    <div class="rvw-acts">
      <?php if ($r['status'] !== 'approved'): ?><form method="POST"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button class="btn btn-primary btn-sm" name="do" value="approve">Approve &amp; publish</button></form><?php endif ?>
      <?php if ($r['status'] !== 'rejected'): ?><form method="POST"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button class="btn btn-secondary btn-sm" name="do" value="reject">Reject</button></form><?php endif ?>
      <form method="POST"><input type="hidden" name="id" value="<?= $r['id'] ?>"><button class="btn btn-danger btn-sm" name="do" value="delete" data-confirm="Delete this review permanently?">Delete</button></form>
    </div>
    <details <?= $r['owner_response'] ? 'open' : '' ?>>
      <summary><?= $r['owner_response'] ? 'Agency response' : 'Add agency response (e.g. sent by the owner)' ?></summary>
      <form method="POST">
        <input type="hidden" name="id" value="<?= $r['id'] ?>">
        <textarea name="owner_response" rows="3" placeholder="Response shown under the review as 'Response from <?= h($r['company_name']) ?>'"><?= h($r['owner_response']) ?></textarea>
        <button class="btn btn-secondary btn-sm" name="do" value="respond" style="margin-top:6px">Save response</button>
      </form>
    </details>
  </div>
<?php endforeach; else: ?>
  <div class="empty-state"><p>No <?= $view === 'all' ? '' : h($view) ?> reviews.</p></div>
<?php endif ?>
</div>
</div>
<?php hc_foot(); ?>
