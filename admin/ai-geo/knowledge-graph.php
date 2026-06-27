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
        $plat = trim($_POST['platform'] ?? '');
        $url  = trim($_POST['url'] ?? '');
        if ($plat && $url) {
            hc_q("INSERT IGNORE INTO hc_kg_links (platform,url) VALUES (?,?)", [$plat,$url]);
            hc_flash('Same-as link added.');
        }
    }
    if ($action === 'delete') {
        hc_q("DELETE FROM hc_kg_links WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('Link deleted.');
    }
    header('Location: /admin/ai-geo/knowledge-graph.php');
    exit;
}

$links = hc_all("SELECT * FROM hc_kg_links ORDER BY platform");

$presets = ['Google Business Profile','LinkedIn Company Page','Facebook Page','Yelp','BBB','HCAOA Directory','HomeAdvisor','Clutch','Crunchbase','Wikipedia','Wikidata'];

hc_head('Knowledge Graph');
hc_topbar('Knowledge Graph Links', '<a href="/admin/">Admin</a> › AI / GEO Panel › Knowledge Graph');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Knowledge Graph — sameAs Links</h1><div class="sub">sameAs links in your Organization schema tell Google (and AI engines) which external profiles represent your business. Builds entity authority.</div></div>
</div>

<div class="alert alert-info">
  <strong>How it works:</strong> These URLs are automatically injected into your Organization schema as <code>"sameAs": [...]</code> links. The more authoritative profiles you link, the stronger Google's understanding of your business entity.
</div>

<div class="card">
  <div class="card-title" style="margin-bottom:16px">Add sameAs Link</div>
  <form method="POST">
    <input type="hidden" name="action" value="add">
    <div class="form-grid">
      <div class="form-group">
        <label>Platform / Source</label>
        <input type="text" name="platform" list="presets" placeholder="e.g. Google Business Profile" required>
        <datalist id="presets"><?php foreach($presets as $p): ?><option value="<?= h($p) ?>"><?php endforeach ?></datalist>
      </div>
      <div class="form-group">
        <label>Profile URL</label>
        <input type="url" name="url" placeholder="https://..." required>
      </div>
    </div>
    <button class="btn btn-primary" type="submit">Add Link</button>
  </form>
</div>

<?php if ($links): ?>
<div class="card">
  <div class="card-title" style="margin-bottom:14px">sameAs Links (<?= count($links) ?>)</div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Platform</th><th>URL</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($links as $l): ?>
      <tr>
        <td><strong><?= h($l['platform']) ?></strong></td>
        <td><a href="<?= h($l['url']) ?>" target="_blank" style="font-size:12.5px;color:var(--teal)"><?= h($l['url']) ?></a></td>
        <td class="td-actions">
          <form method="POST" style="display:inline">
            <input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $l['id'] ?>">
            <button class="btn btn-ghost btn-sm danger" type="submit" data-confirm="Delete this link?">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<?php else: ?>
<div class="card"><div class="empty-state"><p>No sameAs links yet. Start with your Google Business Profile.</p></div></div>
<?php endif ?>

</div>
<?php hc_foot(); ?>
