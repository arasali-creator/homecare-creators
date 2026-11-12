<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/directory.php';
hc_require_auth();
hc_dir_ensure_schema();

if (isset($_GET['delete'])) {
    hc_q("DELETE FROM hc_directory_leads WHERE id=?", [(int)$_GET['delete']]);
    hc_flash('Inquiry deleted.');
    header('Location: /admin/directory/leads.php' . (!empty($_GET['listing']) ? '?listing=' . (int)$_GET['listing'] : '')); exit;
}

$lid = (int)($_GET['listing'] ?? 0);
$leads = hc_all("SELECT d.*, l.company_name, l.slug FROM hc_directory_leads d LEFT JOIN hc_directory_listings l ON l.id=d.listing_id"
    . ($lid ? " WHERE d.listing_id=?" : "") . " ORDER BY d.created_at DESC LIMIT 300", $lid ? [$lid] : []);
$agency = $lid ? hc_val("SELECT company_name FROM hc_directory_listings WHERE id=?", [$lid]) : null;

hc_head('Directory Inquiries');
hc_topbar('Directory Inquiries', '<a href="/admin/">Admin</a> › <a href="/admin/directory/">Directory</a> › Inquiries');
?>
<div class="page-content">
<?= hc_show_flash() ?>
<div class="page-header"><div><h1>Inquiries<?= $agency ? ': ' . h($agency) : '' ?></h1><div class="sub">Consultation requests sent from Featured listing pages</div></div>
<?php if ($lid): ?><a href="/admin/directory/leads.php" class="btn btn-secondary">All agencies</a><?php endif ?></div>
<div class="card">
<?php if ($leads): ?>
  <div class="table-wrap"><table>
    <thead><tr><th>Date</th><th>Agency</th><th>Family contact</th><th>Care for</th><th>Message</th><th>Delivered</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($leads as $d): ?>
    <tr>
      <td style="white-space:nowrap;font-size:12.5px;color:var(--muted)"><?= date('M j, Y g:ia', strtotime($d['created_at'])) ?></td>
      <td><a href="/admin/directory/edit.php?id=<?= (int)$d['listing_id'] ?>"><?= h($d['company_name'] ?? '(deleted)') ?></a></td>
      <td style="font-size:13px"><strong><?= h($d['name']) ?></strong><br><?= h($d['phone']) ?><?= $d['email'] ? '<br>' . h($d['email']) : '' ?></td>
      <td style="font-size:13px"><?= h($d['care_for']) ?></td>
      <td style="font-size:13px;max-width:320px"><?= nl2br(h($d['message'])) ?></td>
      <td><span class="badge <?= $d['emailed'] ? 'badge-green' : 'badge-red' ?>"><?= $d['emailed'] ? 'Emailed' : 'Not sent' ?></span></td>
      <td class="td-actions"><a href="?delete=<?= $d['id'] ?><?= $lid ? '&listing=' . $lid : '' ?>" class="danger" data-confirm="Delete this inquiry?">Delete</a></td>
    </tr>
    <?php endforeach ?>
    </tbody>
  </table></div>
<?php else: ?>
  <div class="empty-state"><p>No inquiries yet. They appear here when families use the consultation form on a Featured listing.</p></div>
<?php endif ?>
</div>
</div>
<?php hc_foot(); ?>
