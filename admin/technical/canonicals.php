<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['canonical'] ?? [] as $path => $url) {
        $url = trim($url);
        if ($url) {
            hc_q("INSERT INTO hc_seo_pages (page_path,canonical_url) VALUES (?,?) ON DUPLICATE KEY UPDATE canonical_url=VALUES(canonical_url)",
                [urldecode($path), $url]);
        }
    }
    hc_flash('Canonical URLs saved.');
    header('Location: /admin/technical/canonicals.php');
    exit;
}

$pages   = hc_scan_pages();
$seo_map = [];
foreach (hc_all("SELECT page_path, canonical_url FROM hc_seo_pages") as $r) {
    $seo_map[$r['page_path']] = $r['canonical_url'];
}

hc_head('Canonical URLs');
hc_topbar('Canonical URL Manager', '<a href="/admin/">Admin</a> › Technical SEO › Canonical URLs');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Canonical URL Manager</h1><div class="sub">View and override canonical URLs across all pages in one table.</div></div>
</div>

<form method="POST">
<div class="card">
  <div class="card-header">
    <div class="card-title">All Pages (<?= count($pages) ?>)</div>
    <button class="btn btn-primary" type="submit">Save All</button>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Page</th><th>Path</th><th>Canonical URL</th></tr></thead>
      <tbody>
      <?php foreach ($pages as $p):
        $default = SITE_URL . $p['path'];
        $saved   = $seo_map[$p['path']] ?? '';
      ?>
      <tr>
        <td><?= h($p['name']) ?></td>
        <td class="td-path"><?= h($p['path']) ?></td>
        <td>
          <input type="url" name="canonical[<?= urlencode($p['path']) ?>]"
                 value="<?= h($saved ?: $default) ?>"
                 style="font-size:12.5px;padding:6px 10px"
                 <?= !$saved ? 'style="color:var(--muted)"' : '' ?>>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <div style="padding:16px 0 0">
    <button class="btn btn-primary" type="submit">Save All Canonical URLs</button>
  </div>
</div>
</form>

</div>
<?php hc_foot(); ?>
