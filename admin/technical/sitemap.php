<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$sitemap_file = SITE_ROOT . '/sitemap.xml';

// Sensible default priority/changefreq based on URL path, so auto-discovered
// pages don't all land at one flat priority.
function sitemap_priority_for(string $path): array {
    if ($path === '/') return ['1.0', 'weekly'];
    if ($path === '/seo/home-care-seo/') return ['1.0', 'monthly'];
    if (str_starts_with($path, '/web-design/homecare-website-design/') || $path === '/ai-search-seo/' || $path === '/ai-automation/') return ['0.9', 'monthly'];
    if (preg_match('#^/home-care-agency-(seo|marketing)-#', $path) || str_starts_with($path, '/homecare-website-design-')) return ['0.8', 'monthly'];
    if ($path === '/privacy-policy' || $path === '/terms-of-service') return ['0.3', 'yearly'];
    if (str_starts_with($path, '/blog/')) return ['0.5', 'monthly'];
    return ['0.7', 'monthly'];
}

// Scans the filesystem (same mechanism the public /sitemap/ page uses) for
// every real page, plus every published blog post. This is what makes new
// pages show up automatically instead of needing to be added by hand.
function sitemap_build_auto_urls(): array {
    $urls = [SITE_URL . '/' => sitemap_priority_for('/')];
    foreach (hc_scan_pages() as $p) {
        if ($p['path'] === '/') continue;
        $meta = hc_extract_page_meta($p['file']);
        if (empty($meta['page_canonical'])) continue; // redirect stubs have no real canonical
        $url = $meta['page_canonical'];
        $path = parse_url($url, PHP_URL_PATH) ?: '/';
        if (!isset($urls[$url])) $urls[$url] = sitemap_priority_for($path);
    }
    try {
        $urls[SITE_URL . '/blog'] = ['0.6', 'weekly'];
        foreach (hc_all("SELECT slug FROM hc_blog_posts WHERE status='published'") as $post) {
            $urls[SITE_URL . '/blog/' . $post['slug']] = sitemap_priority_for('/blog/' . $post['slug']);
        }
    } catch (Exception $e) { /* blog table may not exist yet */ }
    return $urls;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'regenerate') {
        $urls = sitemap_build_auto_urls();

        // Manual entries add new URLs or override the auto-assigned priority/frequency
        $manual = hc_all("SELECT * FROM hc_sitemap_entries WHERE active=1");
        foreach ($manual as $m) {
            $urls[$m['url']] = [$m['priority'] ?: '0.8', $m['changefreq'] ?: 'monthly'];
        }

        uasort($urls, fn($a, $b) => $b[0] <=> $a[0]);

        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n\n";
        foreach ($urls as $url => $meta) {
            [$priority, $changefreq] = $meta;
            $xml .= "  <url>\n    <loc>".htmlspecialchars($url)."</loc>\n    <lastmod>".date('Y-m-d')."</lastmod>\n    <changefreq>".htmlspecialchars($changefreq)."</changefreq>\n    <priority>".htmlspecialchars($priority)."</priority>\n  </url>\n";
        }
        $xml .= "\n</urlset>\n";
        file_put_contents($sitemap_file, $xml);
        hc_flash(count($urls) . ' URLs written to sitemap.xml — every page found on the site, plus published blog posts and any manual overrides below.');
    }
    if ($_POST['action'] === 'add') {
        $url = trim($_POST['url'] ?? '');
        if ($url) {
            try {
                hc_q("INSERT IGNORE INTO hc_sitemap_entries (url,priority,changefreq,lastmod,active) VALUES (?,?,?,?,1)",
                    [$url, $_POST['priority']??'0.8', $_POST['changefreq']??'monthly', date('Y-m-d')]);
                hc_flash('URL added. Click Regenerate to apply it.');
            } catch(Exception $e){ hc_flash('Error: '.$e->getMessage(),'error'); }
        }
    }
    if ($_POST['action'] === 'delete') {
        hc_q("DELETE FROM hc_sitemap_entries WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('Entry removed. Click Regenerate to apply it.');
    }
    header('Location: /admin/technical/sitemap.php');
    exit;
}

// Auto-create table if needed
try {
    hc_q("CREATE TABLE IF NOT EXISTS hc_sitemap_entries (
        id INT PRIMARY KEY AUTO_INCREMENT,
        url VARCHAR(500) NOT NULL UNIQUE,
        priority VARCHAR(5) DEFAULT '0.8',
        changefreq VARCHAR(20) DEFAULT 'monthly',
        lastmod DATE,
        active TINYINT DEFAULT 1
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}

$entries    = hc_all("SELECT * FROM hc_sitemap_entries ORDER BY CAST(priority AS DECIMAL(3,1)) DESC, url");
$auto_urls  = sitemap_build_auto_urls();
$auto_count = count($auto_urls);
$live_count = 0;
if (file_exists($sitemap_file)) {
    $live_xml = @simplexml_load_file($sitemap_file);
    if ($live_xml) $live_count = count($live_xml->url);
}

hc_head('Sitemap Manager');
hc_topbar('Sitemap Manager', '<a href="/admin/">Admin</a> › <a href="/admin/technical/sitemap.php">Technical SEO</a> › Sitemap');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Sitemap Manager</h1><div class="sub">sitemap.xml is generated automatically from every real page on the site, plus published blog posts — click Regenerate any time you add new pages.</div></div>
  <div class="page-actions">
    <form method="POST"><input type="hidden" name="action" value="regenerate">
      <button class="btn btn-primary" type="submit">↺ Regenerate sitemap.xml</button>
    </form>
    <a href="/sitemap.xml" target="_blank" class="btn btn-secondary">View sitemap.xml</a>
    <a href="/sitemap/" target="_blank" class="btn btn-secondary">View Public Sitemap Page</a>
  </div>
</div>

<div class="card" style="display:flex;gap:32px;align-items:center;flex-wrap:wrap">
  <div>
    <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;color:var(--teal)"><?= $auto_count ?></div>
    <div class="form-hint" style="margin:0">Pages found right now (auto-scan + blog)</div>
  </div>
  <div>
    <div style="font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;font-weight:800;color:<?= $live_count === $auto_count && $live_count > 0 ? 'var(--teal)' : '#d97706' ?>"><?= $live_count ?></div>
    <div class="form-hint" style="margin:0">URLs currently live in sitemap.xml</div>
  </div>
  <?php if ($live_count !== $auto_count): ?>
  <div class="form-hint" style="color:#d97706;margin:0">sitemap.xml is out of date — click Regenerate above.</div>
  <?php endif; ?>
</div>

<!-- Add manual override -->
<div class="card">
  <div class="card-title" style="margin-bottom:4px">Add a Manual URL or Override</div>
  <div class="card-sub" style="margin-bottom:14px">Every real page is already included automatically. Use this only to add a URL the scanner can't see (e.g. an external redirect target) or to override a page's default priority/frequency.</div>
  <form method="POST">
    <input type="hidden" name="action" value="add">
    <div class="form-grid">
      <div class="form-group" style="margin:0">
        <label>URL</label>
        <input type="url" name="url" required placeholder="https://homecarecreators.com/page">
      </div>
      <div class="form-group" style="margin:0">
        <label>Priority</label>
        <select name="priority">
          <option value="1.0">1.0 — Homepage</option>
          <option value="0.9">0.9 — Key service pages</option>
          <option value="0.8" selected>0.8 — City/state pages</option>
          <option value="0.7">0.7 — Supporting pages</option>
          <option value="0.5">0.5 — Blog posts</option>
          <option value="0.3">0.3 — Legal pages</option>
        </select>
      </div>
      <div class="form-group" style="margin:0">
        <label>Change Frequency</label>
        <select name="changefreq">
          <option value="weekly">Weekly</option>
          <option value="monthly" selected>Monthly</option>
          <option value="yearly">Yearly</option>
        </select>
      </div>
    </div>
    <button class="btn btn-primary" style="margin-top:14px" type="submit">Add Override</button>
  </form>
</div>

<!-- Manual entries list -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Manual Overrides &amp; Extra URLs (<?= count($entries) ?>)</div>
  </div>
  <?php if (empty($entries)): ?>
  <div class="empty-state">
    <p>None yet — every page is being picked up automatically. Add one above only if you need to override a priority or include a URL the scanner can't see.</p>
  </div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>URL</th><th>Priority</th><th>Frequency</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($entries as $e): ?>
      <tr>
        <td class="td-path"><?= h($e['url']) ?></td>
        <td><span class="badge <?= $e['priority']>='0.9'?'badge-green':($e['priority']>='0.7'?'badge-gold':'badge-gray') ?>"><?= h($e['priority']) ?></span></td>
        <td><?= h($e['changefreq']) ?></td>
        <td class="td-actions">
          <form method="POST" style="display:inline">
            <input type="hidden" name="action" value="delete">
            <input type="hidden" name="id" value="<?= $e['id'] ?>">
            <button class="btn btn-ghost btn-sm danger" type="submit" data-confirm="Remove this override?">Remove</button>
          </form>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
