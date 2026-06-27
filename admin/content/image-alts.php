<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['alts'])) {
    foreach ($_POST['alts'] as $key => $alt) {
        [$src, $page] = explode('||', base64_decode($key), 2);
        hc_q("INSERT INTO hc_image_alts (image_src,alt_text,page_path) VALUES (?,?,?) ON DUPLICATE KEY UPDATE alt_text=VALUES(alt_text)",
            [trim($src), trim($alt), trim($page)]);
    }
    hc_flash('Alt text saved.');
    header('Location: /admin/content/image-alts.php');
    exit;
}

// Scan all PHP pages for images
$pages   = hc_scan_pages();
$saved   = [];
foreach (hc_all("SELECT image_src, alt_text, page_path FROM hc_image_alts") as $r) {
    $saved[$r['image_src'] . '||' . $r['page_path']] = $r['alt_text'];
}

$all_images = [];
foreach ($pages as $page) {
    $imgs = hc_get_page_images($page['file']);
    foreach ($imgs as $img) {
        $key = $img['src'] . '||' . $page['path'];
        $all_images[] = [
            'src'       => $img['src'],
            'page'      => $page['name'],
            'page_path' => $page['path'],
            'key'       => base64_encode($key),
            'current'   => $saved[$key] ?? $img['alt'],
            'empty'     => empty($saved[$key] ?? $img['alt']),
        ];
    }
}

$empty_count = count(array_filter($all_images, fn($i) => $i['empty']));
$filter = $_GET['filter'] ?? 'all';
$display = $filter === 'missing' ? array_filter($all_images, fn($i) => $i['empty']) : $all_images;

hc_head('Image Alt Text');
hc_topbar('Image Alt Text Manager', '<a href="/admin/">Admin</a> › Content Tools › Image Alts');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div>
    <h1>Image Alt Text Manager</h1>
    <div class="sub"><?= count($all_images) ?> images found across <?= count($pages) ?> pages &mdash; <span style="color:var(--red)"><?= $empty_count ?> missing alt text</span></div>
  </div>
  <div class="page-actions">
    <a href="?filter=all" class="btn btn-sm <?= $filter==='all'?'btn-primary':'btn-secondary' ?>">All (<?= count($all_images) ?>)</a>
    <a href="?filter=missing" class="btn btn-sm <?= $filter==='missing'?'btn-primary':'btn-secondary' ?>">Missing (<?= $empty_count ?>)</a>
  </div>
</div>

<form method="POST">
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Image</th><th>Page</th><th>Alt Text</th></tr></thead>
      <tbody>
      <?php foreach ($display as $img): ?>
      <tr>
        <td style="max-width:200px">
          <?php if (str_starts_with($img['src'],'http')): ?>
          <img src="<?= h($img['src']) ?>" style="max-width:120px;max-height:70px;object-fit:cover;border-radius:6px;border:1px solid var(--border)" loading="lazy" onerror="this.style.display='none'">
          <?php else: ?>
          <span class="td-path" style="font-size:11px"><?= h(basename($img['src'])) ?></span>
          <?php endif ?>
        </td>
        <td style="font-size:12.5px;color:var(--muted)"><?= h($img['page']) ?></td>
        <td>
          <input type="text" name="alts[<?= h($img['key']) ?>]"
                 value="<?= h($img['current']) ?>"
                 placeholder="Describe this image for screen readers & SEO"
                 style="<?= $img['empty'] ? 'border-color:rgba(220,38,38,.4);background:rgba(220,38,38,.02)' : '' ?>">
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <div style="padding:16px 0 0">
    <button class="btn btn-primary" type="submit">Save Alt Text</button>
  </div>
</div>
</form>

</div>
<?php hc_foot(); ?>
