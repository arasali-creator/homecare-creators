<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

// ── DB setup ─────────────────────────────────────────────────────────────────
try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_directory_listings (
        id INT PRIMARY KEY AUTO_INCREMENT,
        company_name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        logo VARCHAR(500),
        description TEXT NOT NULL,
        services TEXT,
        city VARCHAR(100) NOT NULL,
        state VARCHAR(2) NOT NULL DEFAULT 'FL',
        service_areas TEXT,
        address VARCHAR(255),
        phone VARCHAR(50),
        email VARCHAR(255),
        website VARCHAR(500),
        license_number VARCHAR(100),
        years_in_business VARCHAR(50),
        featured TINYINT(1) NOT NULL DEFAULT 0,
        status VARCHAR(20) NOT NULL DEFAULT 'pending',
        rejection_reason VARCHAR(500),
        source_page VARCHAR(255),
        ip_address VARCHAR(64),
        user_agent TEXT,
        device_type VARCHAR(20),
        geo_city VARCHAR(100),
        geo_region VARCHAR(100),
        geo_country VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        approved_at TIMESTAMP NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        KEY idx_status (status),
        KEY idx_city (city)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}

// ── Actions ──────────────────────────────────────────────────────────────────
$action = $_GET['action'] ?? '';
$aid    = (int)($_GET['id'] ?? 0);

if ($action === 'approve' && $aid) {
    hc_q("UPDATE hc_directory_listings SET status='approved', approved_at=NOW(), rejection_reason=NULL WHERE id=?", [$aid]);
    hc_flash('Listing approved and now live.');
    header('Location: /admin/directory/'); exit;
}
if ($action === 'reject' && $aid) {
    hc_q("UPDATE hc_directory_listings SET status='rejected' WHERE id=?", [$aid]);
    hc_flash('Listing rejected.');
    header('Location: /admin/directory/'); exit;
}
if ($action === 'feature' && $aid) {
    hc_q("UPDATE hc_directory_listings SET featured = NOT featured WHERE id=?", [$aid]);
    header('Location: /admin/directory/'); exit;
}
if (isset($_GET['delete'])) {
    hc_q("DELETE FROM hc_directory_listings WHERE id=?", [(int)$_GET['delete']]);
    hc_flash('Listing deleted.');
    header('Location: /admin/directory/'); exit;
}

$filter = $_GET['status'] ?? 'pending';
$where  = $filter !== 'all' ? "WHERE status = " . hc_db()->quote($filter) : '';
$listings = hc_all("SELECT * FROM hc_directory_listings $where ORDER BY created_at DESC");

$counts = ['all' => 0, 'pending' => 0, 'approved' => 0, 'rejected' => 0];
foreach (hc_all("SELECT status, COUNT(*) c FROM hc_directory_listings GROUP BY status") as $r) {
    $counts[$r['status']] = $r['c'];
    $counts['all'] += $r['c'];
}

hc_head('Agency Directory');
hc_topbar('Agency Directory', '<a href="/admin/">Admin</a> › Directory');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Agency Directory</h1><div class="sub"><?= count($listings) ?> listing<?= count($listings)!==1?'s':'' ?></div></div>
  <a href="/admin/directory/edit.php" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    Add Listing
  </a>
</div>

<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;align-items:center">
  <?php foreach (['pending'=>'Pending Review','approved'=>'Approved','rejected'=>'Rejected','all'=>'All'] as $s=>$label): ?>
  <a href="?status=<?= $s ?>" class="btn btn-sm <?= $filter===$s?'btn-primary':'btn-secondary' ?>">
    <?= $label ?> <span style="opacity:.7">(<?= $counts[$s] ?>)</span>
  </a>
  <?php endforeach ?>
</div>

<div class="card">
  <?php if ($listings): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Company</th><th>City</th><th>Contact</th><th>Status</th><th>Submitted</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($listings as $l): ?>
      <tr>
        <td>
          <strong><?= h($l['company_name']) ?></strong>
          <?php if ($l['featured']): ?><span class="badge badge-gold" style="margin-left:6px">★ Featured</span><?php endif ?>
          <div style="font-size:11px;color:var(--muted);font-family:monospace;margin-top:2px">/directory/<?= h($l['slug']) ?></div>
        </td>
        <td><?= h($l['city']) ?>, <?= h($l['state']) ?></td>
        <td style="font-size:13px">
          <?= h($l['email']) ?><br>
          <span style="color:var(--muted)"><?= h($l['phone']) ?></span>
        </td>
        <td><span class="badge <?= $l['status']==='approved'?'badge-green':($l['status']==='rejected'?'badge-red':'badge-gray') ?>"><?= h($l['status']) ?></span></td>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= date('M j, Y', strtotime($l['created_at'])) ?></td>
        <td class="td-actions">
          <?php if ($l['status'] !== 'approved'): ?>
          <a href="?action=approve&id=<?= $l['id'] ?>">Approve</a>
          <?php endif ?>
          <?php if ($l['status'] !== 'rejected'): ?>
          <a href="?action=reject&id=<?= $l['id'] ?>" class="danger" data-confirm="Reject '<?= h($l['company_name']) ?>'?">Reject</a>
          <?php endif ?>
          <a href="?action=feature&id=<?= $l['id'] ?>"><?= $l['featured'] ? 'Unfeature' : 'Feature' ?></a>
          <a href="/admin/directory/edit.php?id=<?= $l['id'] ?>">Edit</a>
          <?php if ($l['status']==='approved'): ?>
          <a href="/directory/<?= urlencode($l['slug']) ?>" target="_blank">View</a>
          <?php endif ?>
          <a href="?delete=<?= $l['id'] ?>" class="danger" data-confirm="Permanently delete '<?= h($l['company_name']) ?>'?">Delete</a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
    <p>No listings <?= $filter!=='all' ? 'with status "'.h($filter).'"' : '' ?> yet.</p>
  </div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
