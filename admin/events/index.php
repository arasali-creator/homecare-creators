<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

// ── DB setup ─────────────────────────────────────────────────────────────────
try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_events (
        id INT PRIMARY KEY AUTO_INCREMENT,
        title VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        badge_text VARCHAR(100) DEFAULT 'FREE LIVE MASTERCLASS',
        subtitle VARCHAR(255),
        description TEXT,
        highlights TEXT,
        event_datetime DATETIME NOT NULL,
        timezone VARCHAR(50) NOT NULL DEFAULT 'America/New_York',
        location_type VARCHAR(20) NOT NULL DEFAULT 'zoom',
        zoom_link VARCHAR(500),
        banner_image VARCHAR(500),
        giveaway_text TEXT,
        cta_text VARCHAR(100) DEFAULT 'Register Free',
        max_attendees INT,
        status VARCHAR(20) NOT NULL DEFAULT 'draft',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}
try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_event_registrations (
        id INT PRIMARY KEY AUTO_INCREMENT,
        event_id INT NOT NULL,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50),
        agency_name VARCHAR(255),
        role_title VARCHAR(255),
        status VARCHAR(20) NOT NULL DEFAULT 'registered',
        source_page VARCHAR(255),
        ip_address VARCHAR(64),
        user_agent TEXT,
        device_type VARCHAR(20),
        geo_city VARCHAR(100),
        geo_region VARCHAR(100),
        geo_country VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        KEY idx_event (event_id)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    hc_q("DELETE FROM hc_event_registrations WHERE event_id=?", [$id]);
    hc_q("DELETE FROM hc_events WHERE id=?", [$id]);
    hc_flash('Event deleted.');
    header('Location: /admin/events/');
    exit;
}

$filter = $_GET['status'] ?? 'all';
$where  = $filter !== 'all' ? "WHERE e.status = " . hc_db()->quote($filter) : '';
$events = hc_all("SELECT e.*, (SELECT COUNT(*) FROM hc_event_registrations r WHERE r.event_id = e.id) AS reg_count
                  FROM hc_events e $where ORDER BY e.event_datetime DESC");

$counts = ['all' => 0, 'draft' => 0, 'published' => 0, 'completed' => 0, 'cancelled' => 0];
foreach (hc_all("SELECT status, COUNT(*) c FROM hc_events GROUP BY status") as $r) {
    $counts[$r['status']] = $r['c'];
    $counts['all'] += $r['c'];
}

hc_head('Events');
hc_topbar('Events', '<a href="/admin/">Admin</a> › Events');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Events</h1><div class="sub"><?= count($events) ?> event<?= count($events)!==1?'s':'' ?></div></div>
  <a href="/admin/events/edit.php" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Event
  </a>
</div>

<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;align-items:center">
  <?php foreach (['all'=>'All','draft'=>'Draft','published'=>'Published','completed'=>'Completed','cancelled'=>'Cancelled'] as $s=>$label): ?>
  <a href="?status=<?= $s ?>" class="btn btn-sm <?= $filter===$s?'btn-primary':'btn-secondary' ?>">
    <?= $label ?> <span style="opacity:.7">(<?= $counts[$s] ?>)</span>
  </a>
  <?php endforeach ?>
</div>

<div class="card">
  <?php if ($events): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Event</th><th>Date &amp; Time</th><th>Status</th><th>Registrations</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($events as $e):
        $dt = new DateTime($e['event_datetime'], new DateTimeZone($e['timezone'] ?: 'America/New_York'));
        $is_past = $dt->getTimestamp() < time();
      ?>
      <tr>
        <td>
          <strong><?= h($e['title']) ?></strong>
          <div style="font-size:11px;color:var(--muted);font-family:monospace;margin-top:2px">/events/event?slug=<?= h($e['slug']) ?></div>
        </td>
        <td style="font-size:13px;white-space:nowrap">
          <?= $dt->format('M j, Y g:i A') ?> <span style="color:var(--muted)"><?= h($e['timezone']) ?></span>
          <?php if ($is_past): ?><div style="font-size:11px;color:var(--muted)">Past</div><?php endif ?>
        </td>
        <td><span class="badge <?= $e['status']==='published'?'badge-green':($e['status']==='cancelled'?'badge-red':'badge-gray') ?>"><?= h($e['status']) ?></span></td>
        <td>
          <a href="/admin/events/registrations.php?event_id=<?= $e['id'] ?>" style="font-weight:700">
            <?= (int)$e['reg_count'] ?><?= $e['max_attendees'] ? ' / '.(int)$e['max_attendees'] : '' ?>
          </a>
        </td>
        <td class="td-actions">
          <a href="/admin/events/edit.php?id=<?= $e['id'] ?>">Edit</a>
          <a href="/admin/events/registrations.php?event_id=<?= $e['id'] ?>">Registrations</a>
          <?php if ($e['status']==='published'): ?>
          <a href="/events/event?slug=<?= urlencode($e['slug']) ?>" target="_blank">View</a>
          <?php endif ?>
          <a href="?delete=<?= $e['id'] ?>" class="danger" data-confirm="Delete '<?= h($e['title']) ?>' and all its registrations?">Delete</a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    <p>No events yet.</p>
    <a href="/admin/events/edit.php" class="btn btn-primary" style="margin-top:12px">Create your first event</a>
  </div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
