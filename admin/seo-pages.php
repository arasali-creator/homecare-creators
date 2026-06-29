<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

$pages   = hc_scan_pages();
// Resolve canonical URL path for each page (strips domain from $page_canonical)
foreach ($pages as &$page) {
    $meta = hc_extract_page_meta($page['file']);
    if (!empty($meta['page_canonical'])) {
        if (preg_match('#^https?://[^/]+(/.*)$#', $meta['page_canonical'], $m))
            $page['canonical'] = rtrim($m[1], '/') . '/';
        else
            $page['canonical'] = $meta['page_canonical'];
    } else {
        $page['canonical'] = $page['path'];
    }
}
unset($page);

$seo_map = [];
foreach (hc_all("SELECT page_path, meta_title, meta_desc, focus_keyword, robots_index, robots_follow, updated_at FROM hc_seo_pages") as $row) {
    $seo_map[$row['page_path']] = $row;
}

hc_head('SEO Pages');
hc_topbar('SEO Pages', '<a href="/admin/">Admin</a> › SEO Pages');
?>
<div class="page-content">

<div class="page-header">
  <div>
    <h1>SEO Pages</h1>
    <div class="sub">Edit meta tags, Open Graph, schema and robots settings for each page.</div>
  </div>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Page</th>
          <th>Path</th>
          <th>Meta Title</th>
          <th>Focus Keyword</th>
          <th>Robots</th>
          <th>Last Updated</th>
          <th></th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($pages as $page):
        $seo = $seo_map[$page['path']] ?? null;
      ?>
      <tr>
        <td><strong><?= h($page['name']) ?></strong></td>
        <td class="td-path"><?= h($page['canonical']) ?></td>
        <td>
          <?php if ($seo && $seo['meta_title']): ?>
            <span style="font-size:12.5px"><?= h(substr($seo['meta_title'],0,52)) ?><?= strlen($seo['meta_title'])>52?'…':'' ?></span>
          <?php else: ?>
            <span style="color:var(--muted);font-size:12px;font-style:italic">Using page default</span>
          <?php endif ?>
        </td>
        <td>
          <?php if ($seo && $seo['focus_keyword']): ?>
            <span class="tag"><?= h($seo['focus_keyword']) ?></span>
          <?php else: ?>
            <span style="color:var(--muted);font-size:12px">—</span>
          <?php endif ?>
        </td>
        <td>
          <?php if ($seo): ?>
            <span class="badge <?= ($seo['robots_index'] && $seo['robots_follow']) ? 'badge-green' : 'badge-gold' ?>">
              <?= $seo['robots_index'] ? 'index' : 'noindex' ?> / <?= $seo['robots_follow'] ? 'follow' : 'nofollow' ?>
            </span>
          <?php else: ?>
            <span class="badge badge-gray">default</span>
          <?php endif ?>
        </td>
        <td style="font-size:12px;color:var(--muted)">
          <?= $seo ? date('M j, Y', strtotime($seo['updated_at'])) : '—' ?>
        </td>
        <td class="td-actions">
          <a href="/admin/seo-page-edit.php?path=<?= urlencode($page['path']) ?>">Edit SEO</a>
          <a href="<?= h($page['canonical']) ?>" target="_blank" style="color:var(--muted)">↗</a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

</div>
<?php hc_foot(); ?>
