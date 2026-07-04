<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/blocks.php';
require_once dirname(__DIR__) . '/includes/block-forms.php';
hc_require_auth();

function hc_slugify(string $s): string {
    return strtolower(trim(preg_replace('/[^a-z0-9]+/i', '-', $s), '-'));
}

$id = (int)($_GET['id'] ?? 0);

// Create a new page
if (!$id && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['create_page'])) {
    $title = trim($_POST['title'] ?? '');
    $slug  = hc_slugify(($_POST['slug'] ?? '') !== '' ? $_POST['slug'] : $title);
    if ($title === '' || $slug === '') {
        hc_flash('Title is required.', 'error');
        header('Location: /admin/pages/edit.php'); exit;
    }
    if (hc_val("SELECT id FROM hc_pages WHERE slug=?", [$slug])) {
        hc_flash('That URL slug is already in use.', 'error');
        header('Location: /admin/pages/edit.php'); exit;
    }
    try {
        hc_q("INSERT INTO hc_pages (slug,title,status) VALUES (?,?,'draft')", [$slug, $title]);
        $newId = (int)hc_db()->lastInsertId();
        hc_flash('Page created — now add some blocks below.');
        header('Location: /admin/pages/edit.php?id=' . $newId); exit;
    } catch (Exception $e) {
        hc_flash('Could not create page.', 'error');
        header('Location: /admin/pages/edit.php'); exit;
    }
}

// Save page settings
if ($id && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save_settings'])) {
    $title = trim($_POST['title'] ?? '');
    $slug  = hc_slugify($_POST['slug'] ?? '');
    $status = ($_POST['status'] ?? 'draft') === 'published' ? 'published' : 'draft';
    $metaTitle = trim($_POST['meta_title'] ?? '');
    $metaDesc  = trim($_POST['meta_desc'] ?? '');
    if ($title === '' || $slug === '') {
        hc_flash('Title and slug are required.', 'error');
    } elseif (hc_val("SELECT id FROM hc_pages WHERE slug=? AND id<>?", [$slug, $id])) {
        hc_flash('That URL slug is already used by another page.', 'error');
    } else {
        try {
            hc_q("UPDATE hc_pages SET title=?, slug=?, status=?, meta_title=?, meta_desc=? WHERE id=?",
                [$title, $slug, $status, $metaTitle, $metaDesc, $id]);
            hc_flash('Page settings saved.');
        } catch (Exception $e) {
            hc_flash('Could not save settings.', 'error');
        }
    }
    header('Location: /admin/pages/edit.php?id=' . $id); exit;
}

$page = $id ? hc_one("SELECT * FROM hc_pages WHERE id=?", [$id]) : null;
if ($id && !$page) {
    hc_flash('Page not found.', 'error');
    header('Location: /admin/pages/'); exit;
}

$blocks   = $page ? hc_all("SELECT * FROM hc_page_blocks WHERE page_id=? ORDER BY sort_order ASC", [$id]) : [];
$registry = hc_block_registry();

hc_head($page ? 'Edit: ' . $page['title'] : 'New Page');
?>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.2/Sortable.min.js"></script>
<style>
.pb-page-content{padding:0 !important;display:flex;flex-direction:column;height:calc(100vh - 54px)}
.pb-builder{display:flex;flex:1;min-height:0}

.pb-left-panel{width:400px;flex-shrink:0;border-right:1px solid var(--border);background:#fff;overflow-y:auto;padding:18px}
.pb-preview-pane{flex:1;display:flex;flex-direction:column;background:#e5e7eb;min-width:0}
.pb-preview-toolbar{padding:10px 16px;background:#fff;border-bottom:1px solid var(--border);display:flex;align-items:center;gap:10px;flex-shrink:0}
.pb-preview-toolbar .spacer{flex:1}
.pb-preview-frame-wrap{flex:1;overflow:auto;display:flex;justify-content:center;padding:20px}
#pbPreviewFrame{width:100%;height:100%;border:0;background:#fff;box-shadow:0 4px 24px rgba(0,0,0,.08);max-width:1400px}
.pb-preview-frame-wrap.pb-viewport-tablet #pbPreviewFrame{max-width:768px}
.pb-preview-frame-wrap.pb-viewport-mobile #pbPreviewFrame{max-width:390px}
.pb-viewport-btn{background:none;border:1px solid var(--border);border-radius:6px;padding:6px 9px;cursor:pointer;color:var(--muted)}
.pb-viewport-btn.active{color:var(--teal);border-color:var(--teal);background:rgba(29,158,117,.08)}

.pb-settings-toggle{display:flex;align-items:center;gap:8px;cursor:pointer;font-weight:700;font-size:13px;color:var(--text);padding:4px 0 12px}
.pb-settings-toggle i{transition:.2s;font-size:11px;color:var(--muted)}
.pb-settings-toggle.open i{transform:rotate(180deg)}
.pb-settings-body{display:none;margin-bottom:14px}
.pb-settings-body.open{display:block}

.pb-field{margin-bottom:14px}
.pb-field > label{display:block;font-size:12px;font-weight:600;color:var(--muted);margin-bottom:4px}
.pb-field input[type=text],.pb-field textarea,.pb-field select{width:100%;padding:8px 10px;border:1px solid var(--border);border-radius:6px;font-size:13px;font-family:inherit;background:#fff}
.pb-block-item{border:1px solid var(--border);border-radius:var(--r);margin-bottom:10px;background:#fff;overflow:hidden}
.pb-block-item.pb-ghost{opacity:.4}
.pb-block-item.pb-active-preview{border-color:var(--teal);box-shadow:0 0 0 1px var(--teal)}
.pb-block-header{display:flex;align-items:center;gap:10px;padding:12px 14px;background:#fafafa}
.pb-drag-handle{cursor:grab;color:var(--muted);font-size:14px}
.pb-block-icon{color:var(--teal);font-size:14px;width:20px;text-align:center}
.pb-block-label{font-weight:700;font-size:13px;color:var(--text)}
.pb-block-summary{color:var(--muted);font-size:12.5px;flex:1;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.pb-block-actions{display:flex;gap:6px}
.pb-block-actions button{background:none;border:1px solid var(--border);border-radius:6px;padding:5px 10px;font-size:12px;cursor:pointer;color:var(--text)}
.pb-block-actions button.danger{color:var(--red)}
.pb-block-actions button:hover{background:var(--bg)}
.pb-block-form-wrap{padding:16px 18px;border-top:1px solid var(--border)}
.pb-save-status{font-size:12px;color:var(--teal-dk);margin-left:10px}
.pb-repeater-item{border:1px solid var(--border);border-radius:8px;padding:14px;margin-bottom:10px;position:relative;background:var(--bg)}
.pb-repeater-remove{position:absolute;top:8px;right:8px;background:none;border:none;color:var(--muted);cursor:pointer;font-size:13px}
.pb-repeater-remove:hover{color:var(--red)}
.pb-subfield{margin-bottom:8px}
.pb-subfield label{display:block;font-size:11px;font-weight:600;color:var(--muted);margin-bottom:3px}
.pb-subfield input,.pb-subfield textarea{width:100%;padding:6px 8px;border:1px solid var(--border);border-radius:5px;font-size:12.5px;font-family:inherit}
.pb-image-field{display:flex;align-items:center;gap:10px}
.pb-image-field input{flex:1}
.pb-image-preview{width:44px;height:44px;object-fit:cover;border-radius:6px;border:1px solid var(--border)}
.pb-add-block{margin-top:16px;padding-top:16px;border-top:1px solid var(--border)}
.pb-add-block-label{font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.5px;margin-bottom:10px}
.pb-add-block-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(105px,1fr));gap:10px}
.pb-block-type-btn{display:flex;flex-direction:column;align-items:center;gap:6px;padding:14px 8px;border:1.5px dashed var(--border);border-radius:8px;background:#fff;cursor:pointer;font-size:11px;color:var(--text);text-align:center}
.pb-block-type-btn:hover{border-color:var(--teal);color:var(--teal);background:rgba(29,158,117,.05)}
.pb-block-type-btn i{font-size:16px;color:var(--teal)}

.pb-modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.5);z-index:1000;align-items:center;justify-content:center}
.pb-modal-overlay.open{display:flex}
.pb-modal{background:#fff;border-radius:12px;width:100%;max-width:640px;max-height:80vh;display:flex;flex-direction:column;overflow:hidden}
.pb-modal-header{display:flex;justify-content:space-between;align-items:center;padding:16px 20px;border-bottom:1px solid var(--border);font-weight:700}
.pb-modal-header button{background:none;border:none;font-size:20px;cursor:pointer;color:var(--muted)}
.pb-modal-tabs{display:flex;gap:4px;padding:12px 20px 0}
.pb-modal-tabs button{background:none;border:none;padding:8px 14px;font-size:12.5px;font-weight:600;color:var(--muted);cursor:pointer;border-bottom:2px solid transparent}
.pb-modal-tabs button.active{color:var(--teal);border-color:var(--teal)}
.pb-media-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:10px;padding:16px 20px;overflow-y:auto}
.pb-media-item{aspect-ratio:1;border-radius:6px;overflow:hidden;cursor:pointer;border:1px solid var(--border)}
.pb-media-item img{width:100%;height:100%;object-fit:cover;display:block}
.pb-media-item:hover{border-color:var(--teal)}
#pbMediaUpload{padding:20px}

.pb-addbar-overlay{position:absolute;bottom:16px;left:50%;transform:translateX(-50%);z-index:900}
</style>
<?php
hc_topbar($page ? 'Edit Page' : 'New Page', '<a href="/admin/">Admin</a> &rsaquo; <a href="/admin/pages/">Pages</a> &rsaquo; ' . ($page ? h($page['title']) : 'New'));
?>
<div class="page-content<?= $page ? ' pb-page-content' : '' ?>">
<?php if (!$page): ?>

<?= hc_show_flash() ?>
<div class="card" style="max-width:520px">
  <h3 style="margin-bottom:16px">Create a New Page</h3>
  <form method="POST">
    <div class="pb-field"><label>Page Title</label><input type="text" name="title" id="pbNewTitle" oninput="pbSyncSlug()" required></div>
    <div class="pb-field"><label>URL Slug</label><input type="text" name="slug" id="pbNewSlug" placeholder="auto-generated-from-title"></div>
    <button type="submit" name="create_page" value="1" class="btn btn-primary">Create &amp; Continue</button>
  </form>
</div>
<script>
document.getElementById('pbNewSlug').addEventListener('input', function() { this.dataset.touched = '1'; });
function pbSyncSlug() {
  var slugEl = document.getElementById('pbNewSlug');
  if (slugEl.dataset.touched) return;
  slugEl.value = document.getElementById('pbNewTitle').value.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/^-+|-+$/g, '');
}
</script>

<?php else: ?>

<div class="pb-builder">
  <div class="pb-left-panel">
    <?= hc_show_flash() ?>

    <div class="pb-settings-toggle" onclick="pbToggleSettings(this)">
      <i class="fa-solid fa-chevron-down"></i> Page Settings — <?= h($page['title']) ?>
    </div>
    <div class="pb-settings-body">
      <form method="POST" class="pb-settings-form">
        <div class="pb-field"><label>Page Title</label><input type="text" name="title" value="<?= h($page['title']) ?>"></div>
        <div class="pb-field"><label>URL Slug</label><input type="text" name="slug" value="<?= h($page['slug']) ?>"></div>
        <div class="pb-field"><label>Meta Title</label><input type="text" name="meta_title" value="<?= h($page['meta_title']) ?>"></div>
        <div class="pb-field"><label>Meta Description</label><input type="text" name="meta_desc" value="<?= h($page['meta_desc']) ?>"></div>
        <div class="pb-field">
          <label>Status</label>
          <select name="status">
            <option value="draft" <?= $page['status'] === 'draft' ? 'selected' : '' ?>>Draft</option>
            <option value="published" <?= $page['status'] === 'published' ? 'selected' : '' ?>>Published</option>
          </select>
        </div>
        <div style="display:flex;gap:10px;flex-wrap:wrap">
          <button type="submit" name="save_settings" value="1" class="btn btn-primary btn-sm">Save Settings</button>
          <?php if ($page['status'] === 'published'): ?>
          <a href="/<?= h($page['slug']) ?>/" target="_blank" class="btn btn-secondary btn-sm">View Live</a>
          <?php endif ?>
        </div>
      </form>
    </div>

    <div id="pbBlockList" data-page-id="<?= (int)$page['id'] ?>">
      <?php foreach ($blocks as $b):
          $data = json_decode($b['block_data'], true);
          if (!is_array($data)) $data = [];
          $type = $b['block_type'];
          $meta = $registry[$type] ?? ['label' => $type, 'icon' => 'fa-solid fa-cube'];
          $summaryRaw = $data['headline'] ?? $data['eyebrow'] ?? '';
      ?>
      <div class="pb-block-item" data-block-id="<?= (int)$b['id'] ?>" data-block-type="<?= h($type) ?>">
        <div class="pb-block-header">
          <span class="pb-drag-handle"><i class="fa-solid fa-grip-vertical"></i></span>
          <span class="pb-block-icon"><i class="<?= h($meta['icon']) ?>"></i></span>
          <span class="pb-block-label"><?= h($meta['label']) ?></span>
          <span class="pb-block-summary"><?= h(mb_strimwidth($summaryRaw, 0, 40, '…')) ?></span>
          <span class="pb-block-actions">
            <button type="button" onclick="pbToggleForm(this)"><i class="fa-solid fa-pen"></i></button>
            <button type="button" onclick="pbDeleteBlock(this)" class="danger"><i class="fa-solid fa-trash"></i></button>
          </span>
        </div>
        <div class="pb-block-form-wrap" style="display:none">
          <div class="pb-block-form"><?= hc_render_block_form((int)$b['id'], $type, $data) ?></div>
          <button type="button" class="btn btn-primary btn-sm" onclick="pbSaveBlock(this)">Save &amp; Update Preview</button>
          <span class="pb-save-status"></span>
        </div>
      </div>
      <?php endforeach ?>
    </div>
    <?php if (!$blocks): ?><p style="color:var(--muted);font-size:13px;padding:10px 0 0">No blocks yet — add one below to get started.</p><?php endif ?>

    <div class="pb-add-block">
      <div class="pb-add-block-label">Add a Block</div>
      <div class="pb-add-block-grid">
        <?php foreach ($registry as $type => $meta): ?>
        <button type="button" class="pb-block-type-btn" onclick="pbAddBlock('<?= h($type) ?>')">
          <i class="<?= h($meta['icon']) ?>"></i><span><?= h($meta['label']) ?></span>
        </button>
        <?php endforeach ?>
      </div>
    </div>
  </div>

  <div class="pb-preview-pane">
    <div class="pb-preview-toolbar">
      <strong style="font-size:12.5px"><i class="fa-solid fa-eye"></i> Live Preview</strong>
      <span class="spacer"></span>
      <button type="button" class="pb-viewport-btn active" onclick="pbSetViewport('desktop', this)" title="Desktop"><i class="fa-solid fa-desktop"></i></button>
      <button type="button" class="pb-viewport-btn" onclick="pbSetViewport('tablet', this)" title="Tablet"><i class="fa-solid fa-tablet-screen-button"></i></button>
      <button type="button" class="pb-viewport-btn" onclick="pbSetViewport('mobile', this)" title="Mobile"><i class="fa-solid fa-mobile-screen-button"></i></button>
      <button type="button" class="pb-viewport-btn" onclick="pbRefreshPreview()" title="Refresh"><i class="fa-solid fa-arrows-rotate"></i></button>
    </div>
    <div class="pb-preview-frame-wrap" id="pbPreviewWrap">
      <iframe id="pbPreviewFrame" src="/page.php?slug=<?= urlencode($page['slug']) ?>&preview=1"></iframe>
    </div>
  </div>
</div>

<?php endif ?>
</div>

<div id="pbMediaModal" class="pb-modal-overlay">
  <div class="pb-modal">
    <div class="pb-modal-header">Choose an Image<button type="button" onclick="pbCloseMedia()">&times;</button></div>
    <div class="pb-modal-tabs">
      <button type="button" class="active" onclick="pbMediaTab('library', this)">Media Library</button>
      <button type="button" onclick="pbMediaTab('upload', this)">Upload New</button>
    </div>
    <div id="pbMediaLibrary" class="pb-media-grid"></div>
    <div id="pbMediaUpload" style="display:none">
      <input type="file" id="pbFileInput" accept="image/*" onchange="pbUploadFile(this.files[0])">
    </div>
  </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
  var list = document.getElementById('pbBlockList');
  if (list && window.Sortable) {
    new Sortable(list, {
      handle: '.pb-drag-handle',
      animation: 150,
      ghostClass: 'pb-ghost',
      onEnd: pbSaveOrder
    });
  }
});

function pbToggleSettings(el) {
  el.classList.toggle('open');
  el.nextElementSibling.classList.toggle('open');
}

function pbRefreshPreview() {
  var frame = document.getElementById('pbPreviewFrame');
  frame.src = frame.src;
}

function pbSetViewport(mode, btn) {
  document.querySelectorAll('.pb-viewport-btn').forEach(function(b) { b.classList.remove('active'); });
  btn.classList.add('active');
  var wrap = document.getElementById('pbPreviewWrap');
  wrap.classList.remove('pb-viewport-tablet', 'pb-viewport-mobile');
  if (mode === 'tablet') wrap.classList.add('pb-viewport-tablet');
  if (mode === 'mobile') wrap.classList.add('pb-viewport-mobile');
}

function pbSaveOrder() {
  var ids = Array.from(document.querySelectorAll('#pbBlockList .pb-block-item')).map(function(el) { return el.dataset.blockId; });
  fetch('/admin/pages/ajax.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'action=reorder&order=' + encodeURIComponent(JSON.stringify(ids))
  }).then(function() { pbRefreshPreview(); });
}

function pbToggleForm(btn) {
  var wrap = btn.closest('.pb-block-item').querySelector('.pb-block-form-wrap');
  wrap.style.display = wrap.style.display === 'none' ? 'block' : 'none';
}

function pbCollectBlockData(item) {
  var data = {};
  var form = item.querySelector('.pb-block-form');
  form.querySelectorAll(':scope > .pb-field').forEach(function(fieldDiv) {
    if (fieldDiv.classList.contains('pb-repeater')) {
      var key = fieldDiv.dataset.field;
      var items = [];
      fieldDiv.querySelectorAll(':scope > .pb-repeater-items > .pb-repeater-item').forEach(function(row) {
        var obj = {};
        row.querySelectorAll('[data-subfield]').forEach(function(input) { obj[input.dataset.subfield] = input.value; });
        items.push(obj);
      });
      data[key] = items;
    } else {
      var input = fieldDiv.querySelector('[data-field]');
      if (input) data[input.dataset.field] = input.value;
    }
  });
  return data;
}

function pbSaveBlock(btn) {
  var item = btn.closest('.pb-block-item');
  var status = btn.closest('.pb-block-form-wrap').querySelector('.pb-save-status');
  var data = pbCollectBlockData(item);
  status.textContent = 'Saving...';
  fetch('/admin/pages/ajax.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'action=save_block&block_id=' + item.dataset.blockId + '&data=' + encodeURIComponent(JSON.stringify(data))
  }).then(function(r) { return r.json(); }).then(function(res) {
    status.textContent = res.success ? 'Saved ✓' : (res.error || 'Error saving');
    if (res.success) {
      var summary = data.headline || data.eyebrow || '';
      item.querySelector('.pb-block-summary').textContent = summary.length > 40 ? summary.slice(0, 40) + '…' : summary;
      pbRefreshPreview();
    }
    setTimeout(function() { status.textContent = ''; }, 2500);
  }).catch(function() { status.textContent = 'Error saving'; });
}

function pbDeleteBlock(btn) {
  if (!confirm('Delete this block? This cannot be undone.')) return;
  var item = btn.closest('.pb-block-item');
  fetch('/admin/pages/ajax.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'action=delete_block&block_id=' + item.dataset.blockId
  }).then(function(r) { return r.json(); }).then(function(res) {
    if (res.success) { item.remove(); pbRefreshPreview(); }
  });
}

function pbAddBlock(type) {
  var list = document.getElementById('pbBlockList');
  fetch('/admin/pages/ajax.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: 'action=add_block&page_id=' + list.dataset.pageId + '&type=' + encodeURIComponent(type)
  }).then(function(r) { return r.json(); }).then(function(res) {
    if (!res.success) { alert(res.error || 'Could not add block'); return; }
    var div = document.createElement('div');
    div.className = 'pb-block-item';
    div.dataset.blockId = res.block_id;
    div.dataset.blockType = type;
    div.innerHTML =
      '<div class="pb-block-header">' +
        '<span class="pb-drag-handle"><i class="fa-solid fa-grip-vertical"></i></span>' +
        '<span class="pb-block-icon"><i class="' + res.icon + '"></i></span>' +
        '<span class="pb-block-label">' + res.label + '</span>' +
        '<span class="pb-block-summary"></span>' +
        '<span class="pb-block-actions">' +
          '<button type="button" onclick="pbToggleForm(this)"><i class="fa-solid fa-pen"></i></button>' +
          '<button type="button" onclick="pbDeleteBlock(this)" class="danger"><i class="fa-solid fa-trash"></i></button>' +
        '</span>' +
      '</div>' +
      '<div class="pb-block-form-wrap" style="display:block">' +
        '<div class="pb-block-form">' + res.form + '</div>' +
        '<button type="button" class="btn btn-primary btn-sm" onclick="pbSaveBlock(this)">Save &amp; Update Preview</button>' +
        '<span class="pb-save-status"></span>' +
      '</div>';
    list.appendChild(div);
    div.scrollIntoView({behavior: 'smooth', block: 'center'});
    pbRefreshPreview();
  });
}

function pbAddRepeaterItem(btn) {
  var repeaterDiv = btn.closest('.pb-repeater');
  var container = repeaterDiv.querySelector('.pb-repeater-items');
  var temp = document.createElement('div');
  temp.innerHTML = repeaterDiv.dataset.template;
  container.appendChild(temp.firstElementChild);
}

function pbRemoveRepeaterItem(btn) {
  btn.closest('.pb-repeater-item').remove();
}

var pbMediaTarget = null;

function pbOpenMedia(btn) {
  pbMediaTarget = btn.parentElement.querySelector('[data-field]');
  document.getElementById('pbMediaModal').classList.add('open');
  pbLoadMediaLibrary();
}

function pbCloseMedia() {
  document.getElementById('pbMediaModal').classList.remove('open');
}

function pbMediaTab(tab, btn) {
  document.querySelectorAll('.pb-modal-tabs button').forEach(function(b) { b.classList.remove('active'); });
  btn.classList.add('active');
  document.getElementById('pbMediaLibrary').style.display = tab === 'library' ? 'grid' : 'none';
  document.getElementById('pbMediaUpload').style.display = tab === 'upload' ? 'block' : 'none';
}

function pbLoadMediaLibrary() {
  fetch('/admin/blog/upload.php?action=list').then(function(r) { return r.json(); }).then(function(res) {
    var grid = document.getElementById('pbMediaLibrary');
    grid.innerHTML = '';
    (res.items || []).forEach(function(item) {
      var div = document.createElement('div');
      div.className = 'pb-media-item';
      div.innerHTML = '<img src="' + item.url + '" loading="lazy">';
      div.onclick = function() { pbSelectMedia(item.url); };
      grid.appendChild(div);
    });
  });
}

function pbSelectMedia(url) {
  if (pbMediaTarget) {
    pbMediaTarget.value = url;
    var preview = pbMediaTarget.closest('.pb-image-field').querySelector('.pb-image-preview');
    preview.src = url;
    preview.style.display = 'block';
  }
  pbCloseMedia();
}

function pbUploadFile(file) {
  if (!file) return;
  var fd = new FormData();
  fd.append('file', file);
  fetch('/admin/blog/upload.php', {method: 'POST', body: fd})
    .then(function(r) { return r.json(); })
    .then(function(res) {
      if (res.success) { pbSelectMedia(res.url); } else { alert('Upload failed: ' + (res.error || '')); }
    });
}
</script>
<?php hc_foot(); ?>
