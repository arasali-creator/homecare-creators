<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$file = SITE_ROOT . '/robots.txt';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $content = str_replace("\r\n", "\n", $_POST['robots_content'] ?? '');
    file_put_contents($file, $content);
    hc_flash('robots.txt saved successfully.');
    header('Location: /admin/technical/robots.php');
    exit;
}

$content = file_exists($file) ? file_get_contents($file) : "User-agent: *\nAllow: /\nDisallow: /includes/\nDisallow: /admin/includes/\nSitemap: " . SITE_URL . "/sitemap.xml\n";

hc_head('Robots.txt Editor');
hc_topbar('robots.txt Editor', '<a href="/admin/">Admin</a> › Technical SEO › robots.txt');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>robots.txt</h1><div class="sub">Controls how search engine crawlers access your site.</div></div>
  <a href="/robots.txt" target="_blank" class="btn btn-secondary">View robots.txt ↗</a>
</div>

<div class="card">
  <form method="POST">
    <div class="form-group">
      <label for="robots_content">robots.txt Content</label>
      <textarea id="robots_content" name="robots_content" rows="18" style="font-family:'SF Mono',Consolas,monospace;font-size:13px"><?= h($content) ?></textarea>
      <div class="form-hint">One directive per line. <code>User-agent: *</code> applies rules to all bots. <code>Disallow: /path/</code> blocks a path. Never block CSS/JS files Google needs for rendering.</div>
    </div>
    <div style="display:flex;gap:12px;align-items:center">
      <button class="btn btn-primary" type="submit">Save robots.txt</button>
      <span style="font-size:12px;color:var(--muted)">Saved directly to your server root — takes effect immediately.</span>
    </div>
  </form>
</div>

<div class="card" style="background:rgba(29,158,117,.04);border-color:rgba(29,158,117,.2)">
  <div class="card-title" style="margin-bottom:10px">Common Directives Reference</div>
  <div style="font-family:monospace;font-size:12.5px;line-height:2;color:var(--muted)">
    <div><code>User-agent: *</code> — applies to all crawlers</div>
    <div><code>Disallow: /admin/</code> — block entire admin section</div>
    <div><code>Disallow: /includes/</code> — block PHP includes</div>
    <div><code>Allow: /</code> — explicitly allow everything else</div>
    <div><code>Sitemap: https://example.com/sitemap.xml</code> — declare your sitemap</div>
  </div>
</div>

</div>
<?php hc_foot(); ?>
