<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'add') {
        $src  = '/' . ltrim(trim($_POST['source'] ?? ''), '/');
        $dest = trim($_POST['destination'] ?? '');
        $code = in_array((int)($_POST['code']??301),[301,302]) ? (int)$_POST['code'] : 301;
        if ($src && $dest) {
            try {
                hc_q("INSERT INTO hc_redirects (source_path,destination_url,code,active) VALUES (?,?,?,1) ON DUPLICATE KEY UPDATE destination_url=VALUES(destination_url),code=VALUES(code)",
                    [$src,$dest,$code]);
                hc_flash('Redirect added.');
            } catch(Exception $e){ hc_flash('Error: '.$e->getMessage(),'error'); }
        }
    }
    if ($action === 'toggle') {
        hc_q("UPDATE hc_redirects SET active=1-active WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('Redirect updated.');
    }
    if ($action === 'delete') {
        hc_q("DELETE FROM hc_redirects WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('Redirect deleted.');
    }
    header('Location: /admin/technical/redirects.php');
    exit;
}

$redirects = hc_all("SELECT * FROM hc_redirects ORDER BY created_at DESC");

hc_head('301 Redirects');
hc_topbar('301 Redirect Manager', '<a href="/admin/">Admin</a> › Technical SEO › Redirects');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>301 Redirect Manager</h1><div class="sub">PHP-based redirects — handled by header.php before page load. No Nginx changes needed.</div></div>
</div>

<div class="card">
  <div class="card-title" style="margin-bottom:16px">Add Redirect</div>
  <form method="POST">
    <input type="hidden" name="action" value="add">
    <div style="display:grid;grid-template-columns:1fr 1fr 100px auto;gap:12px;align-items:end">
      <div class="form-group" style="margin:0">
        <label>Source Path (from)</label>
        <input type="text" name="source" placeholder="/old-page" required>
      </div>
      <div class="form-group" style="margin:0">
        <label>Destination URL (to)</label>
        <input type="text" name="destination" placeholder="/new-page or https://..." required>
      </div>
      <div class="form-group" style="margin:0">
        <label>Code</label>
        <select name="code"><option value="301">301</option><option value="302">302</option></select>
      </div>
      <button class="btn btn-primary" type="submit" style="margin-bottom:0">Add</button>
    </div>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Active Redirects (<?= count($redirects) ?>)</div>
  </div>
  <?php if ($redirects): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Source</th><th></th><th>Destination</th><th>Code</th><th>Hits</th><th>Status</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($redirects as $r): ?>
      <tr style="<?= !$r['active']?'opacity:.5':'' ?>">
        <td class="td-path"><?= h($r['source_path']) ?></td>
        <td style="color:var(--muted)">→</td>
        <td style="font-size:12.5px;max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= h($r['destination_url']) ?></td>
        <td><span class="badge badge-<?= $r['code']===301?'green':'gold' ?>"><?= $r['code'] ?></span></td>
        <td style="color:var(--muted);font-size:12px"><?= number_format($r['hits']) ?></td>
        <td><span class="badge <?= $r['active']?'badge-green':'badge-gray' ?>"><?= $r['active']?'active':'off' ?></span></td>
        <td class="td-actions">
          <form method="POST" style="display:inline">
            <input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= $r['id'] ?>">
            <button class="btn btn-ghost btn-sm" type="submit"><?= $r['active']?'Disable':'Enable' ?></button>
          </form>
          <form method="POST" style="display:inline">
            <input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $r['id'] ?>">
            <button class="btn btn-ghost btn-sm danger" type="submit" data-confirm="Delete this redirect?">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state"><p>No redirects configured yet.</p></div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
