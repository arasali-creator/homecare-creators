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

$view = in_array($_GET['view'] ?? '', ['pending', 'approved', 'rejected'], true) ? $_GET['view'] : 'pending';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $eid = (int)($_POST['id'] ?? 0);
    $e = hc_one("SELECT e.*, l.company_name, l.slug FROM hc_directory_edits e JOIN hc_directory_listings l ON l.id=e.listing_id WHERE e.id=? AND e.status='pending'", [$eid]);
    if ($e) {
        if (($_POST['do'] ?? '') === 'approve') {
            hc_dir_apply_edit($eid);
            hc_dir_notify_owner((int)$e['owner_id'], "Your changes are live — {$e['company_name']}", 'Changes approved',
                '<p>Good news: the changes you made to <strong>' . h($e['company_name']) . '</strong> were approved and are now live.</p>',
                "Good news: your changes to {$e['company_name']} were approved and are now live.");
            hc_flash('Changes approved and published.');
        } elseif (($_POST['do'] ?? '') === 'reject') {
            $note = mb_substr(trim((string)($_POST['admin_note'] ?? '')), 0, 500);
            hc_q("UPDATE hc_directory_edits SET status='rejected', admin_note=?, reviewed_at=NOW() WHERE id=?", [$note ?: null, $eid]);
            hc_dir_notify_owner((int)$e['owner_id'], "About your listing changes — {$e['company_name']}", 'Changes not approved',
                '<p>We couldn\'t approve the latest changes to <strong>' . h($e['company_name']) . '</strong>.</p>' . ($note ? '<p><strong>Note from our team:</strong> ' . h($note) . '</p>' : '') . '<p>You can update them and submit again from your dashboard.</p>',
                "We couldn't approve the latest changes to {$e['company_name']}." . ($note ? "\nNote: {$note}" : '') . "\nYou can update them and submit again.");
            hc_flash('Changes rejected. The owner was notified.');
        }
    }
    header('Location: /admin/directory/requests.php?view=' . $view); exit;
}

$rows = hc_all("SELECT e.*, l.*, e.id AS edit_id, e.status AS edit_status, e.created_at AS edit_created, o.email AS acct_email, o.name AS acct_name
                FROM hc_directory_edits e JOIN hc_directory_listings l ON l.id=e.listing_id LEFT JOIN hc_directory_owners o ON o.id=e.owner_id
                WHERE e.status=? ORDER BY e.created_at " . ($view === 'pending' ? 'ASC' : 'DESC') . " LIMIT 200", [$view]);
$counts = [];
foreach (['pending', 'approved', 'rejected'] as $k) $counts[$k] = (int)hc_val("SELECT COUNT(*) FROM hc_directory_edits WHERE status=?", [$k]);

function req_fmt(string $k, $v): string {
    if ($v === null || $v === '') return '<span style="color:var(--muted)">(empty)</span>';
    if ($k === 'hours_json') {
        $h = hc_dir_hours(['hours_json' => $v]);
        if (!$h) return '<span style="color:var(--muted)">(none)</span>';
        if (!empty($h['always'])) return 'Open 24/7';
        $o = []; foreach (HC_DIR_DAYS as $d => $lab) $o[] = $lab . ' ' . ($h[$d] ? hc_dir_fmt_time($h[$d][0]) . '–' . hc_dir_fmt_time($h[$d][1]) : 'closed');
        return h(implode(' · ', $o));
    }
    if (in_array($k, ['logo', 'cover_image'], true)) return '<img src="' . h($v) . '" alt="" style="max-height:56px;max-width:180px;border:1px solid var(--border);border-radius:6px;background:#fff;padding:3px"><div style="font-size:11px;color:var(--muted);word-break:break-all">' . h($v) . '</div>';
    return nl2br(h($v));
}

hc_head('Listing Edit Requests');
hc_topbar('Edit Requests', '<a href="/admin/">Admin</a> › <a href="/admin/directory/">Directory</a> › Edit requests');
?>
<style>
.rq{border-top:1px solid var(--border);padding:20px 0}
.rq:first-child{border-top:0;padding-top:4px}
.rq-h{display:flex;justify-content:space-between;gap:12px;flex-wrap:wrap;margin-bottom:12px}
.rq table{width:100%;border-collapse:collapse;font-size:13px}
.rq th{text-align:left;font-size:11px;letter-spacing:.06em;text-transform:uppercase;color:var(--muted);padding:6px 10px;background:#fafbf9}
.rq td{padding:10px;border-top:1px solid var(--border);vertical-align:top}
.rq td.old{background:rgba(220,38,38,.04)}
.rq td.new{background:rgba(29,158,117,.06)}
.rq-acts{display:flex;gap:8px;align-items:flex-start;flex-wrap:wrap;margin-top:12px}
.rq-acts input{min-width:280px}
</style>
<div class="page-content">
<?= hc_show_flash() ?>
<div class="page-header">
  <div><h1>Edit requests</h1><div class="sub">Changes agency owners made from their account. Nothing goes live until you approve it.</div></div>
  <a href="/admin/directory/" class="btn btn-secondary">← Directory</a>
</div>
<div style="display:flex;gap:8px;margin-bottom:16px">
  <?php foreach (['pending' => 'Waiting', 'approved' => 'Approved', 'rejected' => 'Rejected'] as $k => $lab): ?>
  <a href="?view=<?= $k ?>" class="btn btn-sm <?= $view === $k ? 'btn-primary' : 'btn-secondary' ?>"><?= $lab ?> <span style="opacity:.7">(<?= $counts[$k] ?>)</span></a>
  <?php endforeach ?>
</div>
<div class="card">
<?php if (!$rows): ?>
  <div class="empty-state"><p>No <?= $view === 'pending' ? 'waiting' : h($view) ?> edit requests.</p></div>
<?php endif ?>
<?php foreach ($rows as $r): $data = json_decode($r['data'], true) ?: []; ?>
  <div class="rq">
    <div class="rq-h">
      <div>
        <strong style="font-size:15px"><a href="/admin/directory/edit.php?id=<?= (int)$r['listing_id'] ?>"><?= h($r['company_name']) ?></a></strong>
        <div style="font-size:12.5px;color:var(--muted);margin-top:3px">by <?= h($r['acct_name'] ?: '') ?> &lt;<?= h($r['acct_email']) ?>&gt; · <?= date('M j, Y g:ia', strtotime($r['edit_created'])) ?> · <?= count($data) ?> field(s) changed</div>
      </div>
      <?php if ($r['status'] === 'approved'): ?><a href="/directory/<?= h($r['slug']) ?>" target="_blank" class="btn btn-ghost btn-sm">View live listing ↗</a><?php endif ?>
    </div>
    <table>
      <thead><tr><th style="width:150px">Field</th><th>Current</th><th>Requested</th></tr></thead>
      <tbody>
      <?php foreach ($data as $k => $v): if (!isset(HC_DIR_OWNER_FIELDS[$k])) continue; ?>
      <tr><td><strong><?= h(HC_DIR_OWNER_FIELDS[$k]) ?></strong></td><td class="old"><?= req_fmt($k, $r[$k] ?? null) ?></td><td class="new"><?= req_fmt($k, $v) ?></td></tr>
      <?php endforeach ?>
      </tbody>
    </table>
    <?php if ($view === 'pending'): ?>
    <div class="rq-acts">
      <form method="POST"><input type="hidden" name="id" value="<?= $r['edit_id'] ?>"><button class="btn btn-primary btn-sm" name="do" value="approve">Approve &amp; publish</button></form>
      <form method="POST" style="display:flex;gap:8px;flex-wrap:wrap"><input type="hidden" name="id" value="<?= $r['edit_id'] ?>"><input type="text" name="admin_note" placeholder="Reason (sent to the owner)"><button class="btn btn-danger btn-sm" name="do" value="reject">Reject</button></form>
    </div>
    <?php elseif ($r['admin_note']): ?><div class="form-hint" style="margin-top:8px">Note: <?= h($r['admin_note']) ?></div><?php endif ?>
  </div>
<?php endforeach ?>
</div>
</div>
<?php hc_foot(); ?>
