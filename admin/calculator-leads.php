<?php
require_once dirname(__DIR__) . '/admin/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

// ── DB setup ─────────────────────────────────────────────────────────────────
try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_calculator_submissions (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        city VARCHAR(100) NOT NULL,
        problem VARCHAR(100) NOT NULL,
        monthly_visitors INT NOT NULL,
        current_rate DECIMAL(5,2) NOT NULL,
        traffic_increase_pct DECIMAL(6,2) NOT NULL,
        monthly_value_per_client DECIMAL(10,2) NOT NULL,
        avg_length_months DECIMAL(6,2) NOT NULL,
        current_inquiries INT NOT NULL,
        potential_inquiries INT NOT NULL,
        additional_inquiries INT NOT NULL,
        client_ltv DECIMAL(10,2) NOT NULL,
        additional_annual_value DECIMAL(12,2) NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'new',
        source_page VARCHAR(255),
        ip_address VARCHAR(64),
        user_agent TEXT,
        device_type VARCHAR(20),
        geo_city VARCHAR(100),
        geo_region VARCHAR(100),
        geo_country VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        KEY idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}
// Migrate older deployments that still have the retired target_rate column
try { hc_db()->exec("ALTER TABLE hc_calculator_submissions CHANGE COLUMN target_rate traffic_increase_pct DECIMAL(6,2) NOT NULL"); } catch (Exception $e) {}

if (isset($_GET['delete'])) {
    hc_q("DELETE FROM hc_calculator_submissions WHERE id=?", [(int)$_GET['delete']]);
    hc_flash('Lead deleted.');
    header('Location: /admin/calculator-leads.php'); exit;
}
if (isset($_GET['mark_contacted'])) {
    hc_q("UPDATE hc_calculator_submissions SET status='contacted' WHERE id=?", [(int)$_GET['mark_contacted']]);
    header('Location: /admin/calculator-leads.php'); exit;
}

$leads = hc_all("SELECT * FROM hc_calculator_submissions ORDER BY created_at DESC");
$new_count = (int)hc_val("SELECT COUNT(*) FROM hc_calculator_submissions WHERE status='new'");

hc_head('Growth Calculator Leads');
hc_topbar('Growth Calculator Leads', '<a href="/admin/">Admin</a> › Growth Calculator Leads');
?>
<div class="page-content">
<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Growth Calculator Leads</h1><div class="sub"><?= count($leads) ?> submission<?= count($leads)!==1?'s':'' ?>, <?= $new_count ?> new</div></div>
  <a href="/growth-calculator/" target="_blank" class="btn btn-secondary">↗ View Live Tool</a>
</div>

<div class="card">
  <?php if ($leads): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Name</th><th>Contact</th><th>City</th><th>Problem</th><th>Opportunity</th><th>Status</th><th>Submitted</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($leads as $l): ?>
      <tr>
        <td><strong><?= h($l['name']) ?></strong></td>
        <td style="font-size:13px"><a href="mailto:<?= h($l['email']) ?>"><?= h($l['email']) ?></a><br><span style="color:var(--muted)"><?= h($l['phone']) ?></span></td>
        <td><?= h($l['city']) ?></td>
        <td style="font-size:13px"><?= h($l['problem']) ?></td>
        <td style="font-size:13px">
          <strong>+<?= (int)$l['additional_inquiries'] ?></strong> inquiries/mo<br>
          <span style="color:var(--teal);font-weight:700">$<?= number_format($l['additional_annual_value']) ?></span>/yr
        </td>
        <td><span class="badge <?= $l['status']==='contacted'?'badge-green':'badge-gray' ?>"><?= h($l['status']) ?></span></td>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= date('M j, Y g:i a', strtotime($l['created_at'])) ?></td>
        <td class="td-actions">
          <?php if ($l['status']!=='contacted'): ?><a href="?mark_contacted=<?= $l['id'] ?>">Mark Contacted</a><?php endif ?>
          <a href="?delete=<?= $l['id'] ?>" class="danger" data-confirm="Delete this lead?">Delete</a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state"><p>No submissions yet.</p></div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
