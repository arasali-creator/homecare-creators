<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$path = $_GET['path'] ?? '';
$pages = hc_scan_pages();

// Convert filesystem path → canonical path (stripped of domain).
// This keeps the DB consistent with what header.php uses for injection.
function schema_lookup_path(string $fs_path): string {
    if (!$fs_path) return '';
    $file = SITE_ROOT . $fs_path . '.php';
    $meta = hc_extract_page_meta($file);
    if (!empty($meta['page_canonical'])) {
        if (preg_match('#^https?://[^/]+(/.*)$#', $meta['page_canonical'], $m))
            return $m[1] ?: '/';
    }
    return $fs_path; // fallback: use filesystem path as-is
}

$schema_path = $path ? schema_lookup_path($path) : '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action    = $_POST['action'] ?? '';
    $schema_pg = $_POST['schema_path'] ?? '';  // canonical path — for DB
    $fs_pg     = $_POST['fs_path']     ?? '';  // filesystem path — for redirect

    if ($action === 'save') {
        $type = $_POST['schema_type'] ?? '';
        $data = json_encode(array_filter(array_map('trim', $_POST['schema'] ?? []), fn($v) => $v !== ''));
        if ($type && $schema_pg) {
            hc_q("INSERT INTO hc_page_schema (page_path,schema_type,schema_data,active) VALUES (?,?,?,1)
                  ON DUPLICATE KEY UPDATE schema_data=VALUES(schema_data),active=1",
                [$schema_pg,$type,$data]);
            hc_flash('Schema saved.');
        }
    }
    if ($action === 'toggle') {
        hc_q("UPDATE hc_page_schema SET active=1-active WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('Schema updated.');
    }
    if ($action === 'delete') {
        hc_q("DELETE FROM hc_page_schema WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('Schema deleted.');
    }
    header('Location: /admin/schema/' . ($fs_pg ? '?path='.urlencode($fs_pg) : ''));
    exit;
}

$existing = $schema_path ? hc_all("SELECT * FROM hc_page_schema WHERE page_path=? ORDER BY schema_type", [$schema_path]) : [];
$page_name = '';
foreach ($pages as $p) { if ($p['path'] === $path) { $page_name = $p['name']; break; } }

hc_head('Schema Manager');
hc_topbar('Schema / LD+JSON', '<a href="/admin/">Admin</a> › Schema');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Per-Page Schema Manager</h1><div class="sub">Add structured data blocks to individual pages. Injected as LD+JSON via the SEO override system.</div></div>
</div>

<!-- Page selector -->
<div class="card" style="margin-bottom:16px">
  <form method="GET">
    <div style="display:flex;gap:12px;align-items:flex-end">
      <div class="form-group" style="flex:1;margin:0">
        <label>Select Page</label>
        <select name="path" onchange="this.form.submit()">
          <option value="">— Choose a page —</option>
          <?php foreach ($pages as $p): ?>
          <option value="<?= h($p['path']) ?>" <?= $p['path']===$path?'selected':'' ?>><?= h($p['name']) ?></option>
          <?php endforeach ?>
        </select>
      </div>
    </div>
  </form>
</div>

<?php if (!$path): ?>
<div class="card"><div class="empty-state"><p>Select a page above to manage its schema blocks.</p></div></div>
<?php else: ?>

<!-- Existing schemas -->
<?php if ($existing): ?>
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Active Schema on: <?= h($page_name) ?></div>
      <?php if ($schema_path !== $path): ?>
      <div style="font-size:11.5px;color:var(--muted);margin-top:2px">Schema path: <code style="background:var(--cream);padding:1px 5px;border-radius:3px"><?= h($schema_path) ?></code></div>
      <?php endif ?>
    </div>
  </div>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Schema Type</th><th>Status</th><th>Preview</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($existing as $s): ?>
      <tr>
        <td><strong><?= h($s['schema_type']) ?></strong></td>
        <td><span class="badge <?= $s['active']?'badge-green':'badge-gray' ?>"><?= $s['active']?'active':'off' ?></span></td>
        <td style="font-size:11.5px;color:var(--muted);font-family:monospace;max-width:300px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= h(substr($s['schema_data']??'',0,80)) ?></td>
        <td class="td-actions">
          <form method="POST" style="display:inline"><input type="hidden" name="action" value="toggle"><input type="hidden" name="id" value="<?= $s['id'] ?>"><input type="hidden" name="schema_path" value="<?= h($schema_path) ?>"><input type="hidden" name="fs_path" value="<?= h($path) ?>"><button class="btn btn-ghost btn-sm"><?= $s['active']?'Disable':'Enable' ?></button></form>
          <form method="POST" style="display:inline"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $s['id'] ?>"><input type="hidden" name="schema_path" value="<?= h($schema_path) ?>"><input type="hidden" name="fs_path" value="<?= h($path) ?>"><button class="btn btn-ghost btn-sm danger" data-confirm="Delete this schema block?">Delete</button></form>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>
<?php endif ?>

<!-- Add schema -->
<div class="card">
  <div class="card-title" style="margin-bottom:16px">Add Schema Block</div>

  <div class="tabs">
    <button type="button" class="tab-btn active" data-tab="faq">FAQ</button>
    <button type="button" class="tab-btn" data-tab="service">Service</button>
    <button type="button" class="tab-btn" data-tab="review">Review</button>
    <button type="button" class="tab-btn" data-tab="breadcrumb">Breadcrumb</button>
    <button type="button" class="tab-btn" data-tab="article">Article</button>
    <button type="button" class="tab-btn" data-tab="localbiz">LocalBusiness</button>
  </div>

  <?php
  $faq_items = hc_all("SELECT question,answer FROM hc_faqs ORDER BY created_at DESC LIMIT 20");
  $schema_forms = [
    'faq'       => ['schema_type'=>'FAQPage',          'fields'=>[]],
    'service'   => ['schema_type'=>'Service',           'fields'=>['name','description','areaServed','serviceType','priceRange']],
    'review'    => ['schema_type'=>'AggregateRating',   'fields'=>['ratingValue','reviewCount','bestRating','worstRating']],
    'breadcrumb'=> ['schema_type'=>'BreadcrumbList',    'fields'=>['auto'=>'Auto-generated from URL structure']],
    'article'   => ['schema_type'=>'Article',           'fields'=>['headline','datePublished','dateModified','author']],
    'localbiz'  => ['schema_type'=>'LocalBusiness',     'fields'=>['name','telephone','email','addressStreet','addressCity','addressState','addressZip','priceRange']],
  ];
  ?>

  <!-- FAQ tab -->
  <div id="tab-faq" class="tab-panel active">
    <form method="POST">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="schema_type" value="FAQPage">
      <input type="hidden" name="schema_path" value="<?= h($schema_path) ?>">
      <input type="hidden" name="fs_path" value="<?= h($path) ?>">
      <div class="form-hint" style="margin-bottom:12px">Select FAQs from your FAQ Bank to include as FAQ schema on this page.</div>
      <?php foreach ($faq_items as $i => $faq): ?>
      <div style="display:flex;align-items:flex-start;gap:10px;padding:8px 0;border-bottom:1px solid var(--border)">
        <input type="checkbox" name="schema[faq_<?= $i ?>]" value="<?= h($faq['question']) ?>" id="fq<?= $i ?>" style="width:auto;margin-top:3px">
        <label for="fq<?= $i ?>" style="cursor:pointer;font-weight:400">
          <div style="font-weight:600;font-size:13.5px"><?= h($faq['question']) ?></div>
          <div style="font-size:12px;color:var(--muted)"><?= h(substr($faq['answer'],0,80)) ?>…</div>
        </label>
      </div>
      <?php endforeach ?>
      <?php if (!$faq_items): ?><div class="alert alert-info">No FAQs in bank. <a href="/admin/ai-geo/faq-bank.php">Add FAQs first →</a></div><?php endif ?>
      <button class="btn btn-primary" style="margin-top:14px" type="submit">Save FAQ Schema</button>
    </form>
  </div>

  <?php foreach (['service','review','article','localbiz'] as $tab):
    $sf = $schema_forms[$tab]; ?>
  <div id="tab-<?= $tab ?>" class="tab-panel">
    <form method="POST">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="schema_type" value="<?= h($sf['schema_type']) ?>">
      <input type="hidden" name="schema_path" value="<?= h($schema_path) ?>">
      <input type="hidden" name="fs_path" value="<?= h($path) ?>">
      <?php foreach ($sf['fields'] as $f): ?>
      <div class="form-group">
        <label><?= ucwords(str_replace(['address','Price','Rating','Count'],['Address ','Price ','Rating ','Count '],$f)) ?></label>
        <input type="text" name="schema[<?= $f ?>]" placeholder="<?= $f ?>">
      </div>
      <?php endforeach ?>
      <button class="btn btn-primary" type="submit">Save <?= h($sf['schema_type']) ?> Schema</button>
    </form>
  </div>
  <?php endforeach ?>

  <div id="tab-breadcrumb" class="tab-panel">
    <form method="POST">
      <input type="hidden" name="action" value="save">
      <input type="hidden" name="schema_type" value="BreadcrumbList">
      <input type="hidden" name="schema_path" value="<?= h($schema_path) ?>">
      <input type="hidden" name="fs_path" value="<?= h($path) ?>">
      <input type="hidden" name="schema[auto]" value="true">
      <div class="alert alert-info">BreadcrumbList is auto-generated from the page URL: <strong><?= h($path) ?></strong><br>It will be created as: Home → <?= implode(' → ', array_filter(array_map(fn($s)=>ucwords(str_replace('-',' ',$s)),explode('/',$path)))) ?></div>
      <button class="btn btn-primary" type="submit">Add Breadcrumb Schema</button>
    </form>
  </div>

</div>
<?php endif ?>

</div>
<?php hc_foot(); ?>
