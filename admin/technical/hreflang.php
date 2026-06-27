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
        $path   = trim($_POST['page_path'] ?? '');
        $locale = trim($_POST['locale'] ?? '');
        $url    = trim($_POST['url'] ?? '');
        if ($path && $locale && $url) {
            try {
                hc_q("INSERT INTO hc_hreflang (page_path,locale,url) VALUES (?,?,?) ON DUPLICATE KEY UPDATE url=VALUES(url)",
                    [$path,$locale,$url]);
                hc_flash('Hreflang entry added.');
            } catch(Exception $e){ hc_flash('Error: '.$e->getMessage(),'error'); }
        }
    }
    if ($action === 'delete') {
        hc_q("DELETE FROM hc_hreflang WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('Entry deleted.');
    }
    header('Location: /admin/technical/hreflang.php');
    exit;
}

$entries = hc_all("SELECT * FROM hc_hreflang ORDER BY page_path, locale");
$pages   = array_column(hc_scan_pages(), 'path');

hc_head('Hreflang');
hc_topbar('Hreflang Settings', '<a href="/admin/">Admin</a> › Technical SEO › Hreflang');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Hreflang Settings</h1><div class="sub">For multi-language or multi-region variants of pages. Currently not active — add entries here if you expand to additional languages or regional sites.</div></div>
</div>

<div class="card" style="background:rgba(59,130,246,.04);border-color:rgba(59,130,246,.2)">
  <div class="alert alert-info" style="margin:0">
    <strong>Note:</strong> Hreflang tags tell Google about language/region variants of your pages. They are only needed if you launch additional language versions (e.g. Spanish). Entries saved here are injected into the &lt;head&gt; via the SEO override system.
  </div>
</div>

<div class="card">
  <div class="card-title" style="margin-bottom:16px">Add Hreflang Entry</div>
  <form method="POST">
    <input type="hidden" name="action" value="add">
    <div class="form-grid">
      <div class="form-group">
        <label>Page Path</label>
        <input type="text" name="page_path" placeholder="/seo/local-seo-for-home-care-agencies" list="page-paths">
        <datalist id="page-paths"><?php foreach($pages as $p): ?><option value="<?= h($p) ?>"><?php endforeach ?></datalist>
      </div>
      <div class="form-group">
        <label>Locale (e.g. en-US, es-MX)</label>
        <input type="text" name="locale" placeholder="en-US" list="locales">
        <datalist id="locales">
          <option value="en-US"><option value="en-GB"><option value="es-MX"><option value="es-US"><option value="fr-CA"><option value="x-default">
        </datalist>
      </div>
      <div class="form-group">
        <label>Alternate URL</label>
        <input type="url" name="url" placeholder="https://es.homecarecreators.com/page">
      </div>
    </div>
    <button class="btn btn-primary" type="submit">Add Entry</button>
  </form>
</div>

<?php if ($entries): ?>
<div class="card">
  <div class="card-title" style="margin-bottom:14px">Hreflang Entries (<?= count($entries) ?>)</div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Page Path</th><th>Locale</th><th>Alternate URL</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($entries as $e): ?>
      <tr>
        <td class="td-path"><?= h($e['page_path']) ?></td>
        <td><span class="badge badge-blue"><?= h($e['locale']) ?></span></td>
        <td style="font-size:12.5px"><?= h($e['url']) ?></td>
        <td class="td-actions">
          <form method="POST" style="display:inline">
            <input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $e['id'] ?>">
            <button class="btn btn-ghost btn-sm danger" type="submit" data-confirm="Delete this hreflang entry?">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<?php else: ?>
<div class="card"><div class="empty-state"><p>No hreflang entries yet. Add them above when you expand to additional languages.</p></div></div>
<?php endif ?>

</div>
<?php hc_foot(); ?>
