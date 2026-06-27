<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

// Status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id     = (int)($_POST['id'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['new','read','archived']) ? $_POST['status'] : 'read';
    hc_q("UPDATE hc_form_submissions SET status=? WHERE id=?", [$status, $id]);
    hc_flash('Status updated.');
    header('Location: /admin/form-log.php');
    exit;
}

// Delete
if (isset($_GET['delete'])) {
    hc_q("DELETE FROM hc_form_submissions WHERE id=?", [(int)$_GET['delete']]);
    hc_flash('Submission deleted.', 'success');
    header('Location: /admin/form-log.php');
    exit;
}

// Filter
$filter = $_GET['status'] ?? 'all';
$where  = $filter !== 'all' ? "WHERE status = " . hc_db()->quote($filter) : '';
$rows   = hc_all("SELECT * FROM hc_form_submissions $where ORDER BY submitted_at DESC");
$counts = ['all'=>0,'new'=>0,'read'=>0,'archived'=>0];
foreach (hc_all("SELECT status, COUNT(*) c FROM hc_form_submissions GROUP BY status") as $r) {
    $counts[$r['status']] = $r['c'];
    $counts['all'] += $r['c'];
}

// Single view
$view = null;
if (isset($_GET['view'])) {
    $view = hc_one("SELECT * FROM hc_form_submissions WHERE id=?", [(int)$_GET['view']]);
    if ($view && $view['status'] === 'new') {
        hc_q("UPDATE hc_form_submissions SET status='read' WHERE id=?", [$view['id']]);
    }
}

hc_head('Form Log');
hc_topbar('Form Submissions', '<a href="/admin/">Admin</a> › Form Log');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<?php if ($view): ?>
<div class="card">
  <div class="card-header">
    <div class="card-title">Submission #<?= $view['id'] ?> — <?= h($view['name']) ?></div>
    <a href="/admin/form-log.php" class="btn btn-secondary btn-sm">← Back to list</a>
  </div>
  <div class="form-grid">
    <div><label style="font-size:11px;color:var(--muted);display:block;margin-bottom:3px">NAME</label><?= h($view['name']) ?></div>
    <div><label style="font-size:11px;color:var(--muted);display:block;margin-bottom:3px">EMAIL</label><a href="mailto:<?= h($view['email']) ?>"><?= h($view['email']) ?></a></div>
    <div><label style="font-size:11px;color:var(--muted);display:block;margin-bottom:3px">PHONE</label><?= h($view['phone'] ?: '—') ?></div>
    <div><label style="font-size:11px;color:var(--muted);display:block;margin-bottom:3px">AGENCY</label><?= h($view['agency_name'] ?: '—') ?></div>
    <div><label style="font-size:11px;color:var(--muted);display:block;margin-bottom:3px">CITY</label><?= h($view['city'] ?: '—') ?></div>
    <div><label style="font-size:11px;color:var(--muted);display:block;margin-bottom:3px">SERVICE INTEREST</label><?= h($view['service'] ?: '—') ?></div>
  </div>
  <div class="divider"></div>
  <label style="font-size:11px;color:var(--muted);display:block;margin-bottom:6px">MESSAGE</label>
  <p style="font-size:14px;line-height:1.7;color:var(--text)"><?= nl2br(h($view['message'])) ?></p>
  <div class="divider"></div>
  <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
    <form method="POST" style="display:flex;gap:8px;align-items:center">
      <input type="hidden" name="id" value="<?= $view['id'] ?>">
      <select name="status"><option value="new" <?= $view['status']==='new'?'selected':'' ?>>New</option><option value="read" <?= $view['status']==='read'?'selected':'' ?>>Read</option><option value="archived" <?= $view['status']==='archived'?'selected':'' ?>>Archived</option></select>
      <button class="btn btn-primary btn-sm" type="submit">Update Status</button>
    </form>
    <a href="/admin/form-log.php?delete=<?= $view['id'] ?>" class="btn btn-danger btn-sm" data-confirm="Delete this submission permanently?">Delete</a>
    <a href="mailto:<?= h($view['email']) ?>?subject=Re: Your Homecare Creators Inquiry" class="btn btn-secondary btn-sm">Reply by Email</a>
    <span style="font-size:12px;color:var(--muted);margin-left:auto">Submitted: <?= date('F j, Y g:i a', strtotime($view['submitted_at'])) ?></span>
  </div>
</div>
<?php else: ?>

<div style="display:flex;gap:12px;margin-bottom:20px;flex-wrap:wrap;align-items:center">
  <?php foreach (['all','new','read','archived'] as $s): ?>
  <a href="?status=<?= $s ?>" class="btn <?= $filter===$s?'btn-primary':'btn-secondary' ?> btn-sm">
    <?= ucfirst($s) ?> <span style="opacity:.7">(<?= $counts[$s] ?>)</span>
  </a>
  <?php endforeach ?>
  <div style="margin-left:auto;font-size:12px;color:var(--muted)"><?= count($rows) ?> submission<?= count($rows)!==1?'s':'' ?></div>
</div>

<div class="card">
  <?php if ($rows): ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr><th>Date</th><th>Name</th><th>Email</th><th>Agency</th><th>City</th><th>Service</th><th>Status</th><th></th></tr>
      </thead>
      <tbody>
      <?php foreach ($rows as $r): ?>
      <tr>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= date('M j, Y<br>g:i a', strtotime($r['submitted_at'])) ?></td>
        <td><strong><?= h($r['name']) ?></strong></td>
        <td><a href="mailto:<?= h($r['email']) ?>"><?= h($r['email']) ?></a></td>
        <td><?= h($r['agency_name'] ?: '—') ?></td>
        <td><?= h($r['city'] ?: '—') ?></td>
        <td><?= h($r['service'] ?: '—') ?></td>
        <td><span class="badge <?= $r['status']==='new'?'badge-red':($r['status']==='read'?'badge-green':'badge-gray') ?>"><?= $r['status'] ?></span></td>
        <td class="td-actions">
          <a href="?view=<?= $r['id'] ?>">View</a>
          <a href="mailto:<?= h($r['email']) ?>">Reply</a>
          <a href="?delete=<?= $r['id'] ?>" class="danger" data-confirm="Delete this submission?">Delete</a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state"><p>No submissions found.</p></div>
  <?php endif ?>
</div>
<?php endif ?>

</div>
<?php hc_foot(); ?>
