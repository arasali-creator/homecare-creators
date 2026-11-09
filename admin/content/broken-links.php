<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$scanning = isset($_GET['scan']);

// Does an internal link resolve to a real page? Mirrors how the server
// actually serves URLs, not just the literal on-disk path:
//  - /foo, /foo.php, /foo/index.php on disk
//  - flat URLs for files in Marketing/, web-design/, seo/ (e.g.
//    /home-care-agency-seo-miami-fl/ -> Marketing/home-care-agency-seo-miami-fl.php)
//  - /blog/<slug> -> a published row in hc_blog_posts
function hc_internal_link_exists(string $path): bool {
    $file_path = SITE_ROOT . $path;
    $base      = rtrim($file_path, '/');
    if (file_exists($file_path) || file_exists($base . '.php') || file_exists($base . '/index.php')) return true;

    $slug = trim($path, '/');
    if ($slug !== '' && !str_contains($slug, '/')) {
        foreach (['Marketing', 'web-design', 'seo'] as $folder) {
            if (file_exists(SITE_ROOT . "/$folder/$slug.php") || file_exists(SITE_ROOT . "/$folder/$slug/index.php")) return true;
        }
    }
    if (preg_match('#^/blog/([a-z0-9-]+)/?$#i', $path, $m)) {
        try {
            if (hc_val("SELECT id FROM hc_blog_posts WHERE slug=? AND status='published'", [$m[1]])) return true;
        } catch (Throwable $e) {}
    }
    return false;
}
$results  = [];

if ($scanning) {
    set_time_limit(120);
    $pages = hc_scan_pages();
    $checked = [];

    foreach ($pages as $page) {
        if (!file_exists($page['file'])) continue;
        $html = file_get_contents($page['file']);
        preg_match_all('/href=["\']([^"\'#?]+)["\']/', $html, $m);
        foreach ($m[1] as $href) {
            if (!str_starts_with($href,'/') || str_starts_with($href,'//') || str_starts_with($href,'/admin')) continue;
            $path = '/' . ltrim($href, '/');
            if (isset($checked[$path])) {
                if ($checked[$path] !== 200) {
                    $results[] = ['from'=>$page['path'],'href'=>$path,'code'=>$checked[$path]];
                }
                continue;
            }
            if (hc_internal_link_exists($path)) {
                $checked[$path] = 200;
            } else {
                $checked[$path] = 404;
                $results[] = ['from'=>$page['path'],'href'=>$path,'code'=>404];
            }
        }
    }
}

hc_head('Broken Links');
hc_topbar('Broken Link Checker', '<a href="/admin/">Admin</a> › Content Tools › Broken Links');
?>
<div class="page-content">

<div class="page-header">
  <div><h1>Broken Link Checker</h1><div class="sub">Scans all PHP pages for internal links that resolve to missing files (404s).</div></div>
  <a href="?scan=1" class="btn btn-primary">▶ Run Scan</a>
</div>

<?php if (!$scanning): ?>
<div class="card">
  <div class="empty-state">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M10 13a5 5 0 0 0 7.54.54l3-3a5 5 0 0 0-7.07-7.07l-1.72 1.71"/><path d="M14 11a5 5 0 0 0-7.54-.54l-3 3a5 5 0 0 0 7.07 7.07l1.71-1.71"/></svg>
    <p>Click "Run Scan" to check all internal links across your site.</p>
    <p style="font-size:12px;margin-top:6px;color:var(--muted)">Scans file paths locally — fast, no HTTP requests needed.</p>
  </div>
</div>
<?php elseif (empty($results)): ?>
<div class="card">
  <div class="alert alert-success" style="margin:0">All internal links are valid — no broken links found!</div>
</div>
<?php else: ?>
<div class="alert alert-error"><?= count($results) ?> broken link<?= count($results)!==1?'s':'' ?> found — these pages return 404.</div>
<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Found on page</th><th>Broken link</th><th>Code</th><th>Fix</th></tr></thead>
      <tbody>
      <?php foreach ($results as $r): ?>
      <tr>
        <td class="td-path"><?= h($r['from']) ?></td>
        <td class="td-path" style="color:var(--red)"><?= h($r['href']) ?></td>
        <td><span class="badge badge-red"><?= $r['code'] ?></span></td>
        <td><a href="/admin/technical/redirects.php" class="btn btn-sm btn-secondary">Add Redirect</a></td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif ?>

</div>
<?php hc_foot(); ?>
