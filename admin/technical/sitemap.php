<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$sitemap_file = SITE_ROOT . '/sitemap.xml';

// Save individual entry changes
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    if ($_POST['action'] === 'regenerate') {
        // Build sitemap from DB entries if any, else from pages scan
        $urls = hc_all("SELECT url, priority, changefreq, lastmod FROM hc_seo_pages WHERE canonical_url != '' ORDER BY priority DESC") ;
        // Fall back to scanning if no DB entries
        if (empty($urls)) {
            $pages = hc_scan_pages();
            $entries = [];
            foreach ($pages as $p) {
                $entries[] = ['loc'=>SITE_URL.$p['path'],'priority'=>'0.8','changefreq'=>'monthly','lastmod'=>date('Y-m-d')];
            }
        } else {
            $entries = array_map(fn($r)=>['loc'=>$r['canonical_url'],'priority'=>$r['priority']?:'0.8','changefreq'=>$r['changefreq']?:'monthly','lastmod'=>date('Y-m-d')],$urls);
        }

        // Also add manually added sitemap rows
        $manual = hc_all("SELECT * FROM hc_sitemap_entries WHERE active=1 ORDER BY CAST(priority AS DECIMAL(3,1)) DESC");
        // Build XML
        $xml = "<?xml version=\"1.0\" encoding=\"UTF-8\"?>\n<urlset xmlns=\"http://www.sitemaps.org/schemas/sitemap/0.9\">\n\n";
        foreach ($manual as $m) {
            $xml .= "  <url>\n    <loc>".htmlspecialchars($m['url'])."</loc>\n    <lastmod>".date('Y-m-d')."</lastmod>\n    <changefreq>".htmlspecialchars($m['changefreq'])."</changefreq>\n    <priority>".htmlspecialchars($m['priority'])."</priority>\n  </url>\n";
        }
        $xml .= "\n</urlset>\n";
        file_put_contents($sitemap_file, $xml);
        hc_flash('Sitemap regenerated successfully.');
    }
    if ($_POST['action'] === 'add') {
        $url = trim($_POST['url'] ?? '');
        if ($url) {
            try {
                hc_q("INSERT IGNORE INTO hc_sitemap_entries (url,priority,changefreq,lastmod,active) VALUES (?,?,?,?,1)",
                    [$url, $_POST['priority']??'0.8', $_POST['changefreq']??'monthly', date('Y-m-d')]);
                hc_flash('URL added to sitemap.');
            } catch(Exception $e){ hc_flash('Error: '.$e->getMessage(),'error'); }
        }
    }
    if ($_POST['action'] === 'delete') {
        hc_q("DELETE FROM hc_sitemap_entries WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('Entry removed.');
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

// Seed from existing sitemap.xml if table is empty
$count = (int)hc_val("SELECT COUNT(*) FROM hc_sitemap_entries");
if ($count === 0 && file_exists($sitemap_file)) {
    $xml = simplexml_load_file($sitemap_file);
    if ($xml) foreach ($xml->url as $u) {
        try { hc_q("INSERT IGNORE INTO hc_sitemap_entries (url,priority,changefreq,lastmod,active) VALUES (?,?,?,?,1)",
            [(string)$u->loc, (string)($u->priority??'0.8'), (string)($u->changefreq??'monthly'), date('Y-m-d')]); }
        catch(Exception $e){}
    }
}

$entries = hc_all("SELECT * FROM hc_sitemap_entries ORDER BY CAST(priority AS DECIMAL(3,1)) DESC, url");

hc_head('Sitemap Manager');
hc_topbar('Sitemap Manager', '<a href="/admin/">Admin</a> › <a href="/admin/technical/sitemap.php">Technical SEO</a> › Sitemap');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Sitemap Manager</h1><div class="sub">Manage URLs included in sitemap.xml</div></div>
  <div class="page-actions">
    <form method="POST"><input type="hidden" name="action" value="regenerate">
      <button class="btn btn-primary" type="submit">↺ Regenerate sitemap.xml</button>
    </form>
    <a href="/sitemap.xml" target="_blank" class="btn btn-secondary">View sitemap.xml</a>
  </div>
</div>

<!-- Add URL -->
<div class="card">
  <div class="card-title" style="margin-bottom:14px">Add URL</div>
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
          <option value="0.8" selected>0.8 — City pages</option>
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
    <button class="btn btn-primary" style="margin-top:14px" type="submit">Add to Sitemap</button>
  </form>
</div>

<!-- Entries list -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Sitemap Entries (<?= count($entries) ?>)</div>
  </div>
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
            <button class="btn btn-ghost btn-sm danger" type="submit" data-confirm="Remove this URL from sitemap?">Remove</button>
          </form>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

</div>
<?php hc_foot(); ?>
