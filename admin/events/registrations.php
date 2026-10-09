<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$event_id = (int)($_GET['event_id'] ?? 0);
$event    = hc_one("SELECT * FROM hc_events WHERE id=?", [$event_id]);
if (!$event) { hc_flash('Event not found.', 'error'); header('Location: /admin/events/'); exit; }

// Status update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $rid    = (int)($_POST['id'] ?? 0);
    $status = in_array($_POST['status'] ?? '', ['registered','attended','cancelled','no_show']) ? $_POST['status'] : 'registered';
    hc_q("UPDATE hc_event_registrations SET status=? WHERE id=? AND event_id=?", [$status, $rid, $event_id]);
    header('Location: /admin/events/registrations.php?event_id='.$event_id);
    exit;
}

if (isset($_GET['delete'])) {
    hc_q("DELETE FROM hc_event_registrations WHERE id=? AND event_id=?", [(int)$_GET['delete'], $event_id]);
    hc_flash('Registration deleted.');
    header('Location: /admin/events/registrations.php?event_id='.$event_id);
    exit;
}

// CSV export
if (isset($_GET['export'])) {
    $rows = hc_all("SELECT * FROM hc_event_registrations WHERE event_id=? ORDER BY created_at ASC", [$event_id]);
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="'.$event['slug'].'-registrations.csv"');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Name','Email','Phone','Agency','Role','Status','Source Page','Location','Device','Registered At']);
    foreach ($rows as $r) {
        $loc = trim(implode(', ', array_filter([$r['geo_city'], $r['geo_region'], $r['geo_country']])));
        fputcsv($out, [$r['name'],$r['email'],$r['phone'],$r['agency_name'],$r['role_title'],$r['status'],$r['source_page'],$loc,$r['device_type'],$r['created_at']]);
    }
    fclose($out);
    exit;
}

$regs = hc_all("SELECT * FROM hc_event_registrations WHERE event_id=? ORDER BY created_at DESC", [$event_id]);

hc_head('Registrations — '.$event['title']);
hc_topbar('Registrations', '<a href="/admin/">Admin</a> › <a href="/admin/events/">Events</a> › '.h($event['title']));
?>
<div class="page-content">
<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1><?= h($event['title']) ?></h1><div class="sub"><?= count($regs) ?> registration<?= count($regs)!==1?'s':'' ?><?= $event['max_attendees'] ? ' of '.(int)$event['max_attendees'].' max' : '' ?></div></div>
  <div style="display:flex;gap:8px">
    <a href="?event_id=<?= $event_id ?>&export=1" class="btn btn-secondary">Export CSV</a>
    <a href="/admin/events/edit.php?id=<?= $event_id ?>" class="btn btn-primary">Edit Event</a>
  </div>
</div>

<div class="card">
  <?php if ($regs): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Email</th><th>Agency</th><th>Location</th><th>Device</th><th>Status</th><th>Registered</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($regs as $r): $loc = trim(implode(', ', array_filter([$r['geo_city'], $r['geo_region'], $r['geo_country']]))); ?>
      <tr>
        <td><strong><?= h($r['name']) ?></strong><?= $r['phone'] ? '<div style="font-size:11px;color:var(--muted)">'.h($r['phone']).'</div>' : '' ?></td>
        <td><a href="mailto:<?= h($r['email']) ?>"><?= h($r['email']) ?></a></td>
        <td><?= h($r['agency_name'] ?: '—') ?></td>
        <td style="font-size:12px;color:var(--muted)"><?= h($loc ?: '—') ?></td>
        <td style="font-size:12px;color:var(--muted)"><?= h($r['device_type'] ?: '—') ?></td>
        <td>
          <form method="POST" style="display:inline">
            <input type="hidden" name="id" value="<?= $r['id'] ?>">
            <select name="status" onchange="this.form.submit()" style="font-size:12px;padding:3px 6px">
              <option value="registered" <?= $r['status']==='registered'?'selected':'' ?>>Registered</option>
              <option value="attended" <?= $r['status']==='attended'?'selected':'' ?>>Attended</option>
              <option value="no_show" <?= $r['status']==='no_show'?'selected':'' ?>>No-show</option>
              <option value="cancelled" <?= $r['status']==='cancelled'?'selected':'' ?>>Cancelled</option>
            </select>
          </form>
        </td>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= date('M j, g:i a', strtotime($r['created_at'])) ?></td>
        <td class="td-actions">
          <a href="?event_id=<?= $event_id ?>&delete=<?= $r['id'] ?>" class="danger" data-confirm="Delete this registration?">Delete</a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state"><p>No registrations yet.</p></div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
