<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

// ── DB setup: categories table + new columns ─────────────────────────────────
try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_blog_categories (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        slug VARCHAR(100) NOT NULL UNIQUE,
        color VARCHAR(7) DEFAULT '#1d9e75',
        description VARCHAR(300) DEFAULT '',
        sort_order INT DEFAULT 0,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}
try { hc_db()->exec("ALTER TABLE hc_blog_posts ADD COLUMN category_id INT NULL"); } catch(Exception $e){}
try { hc_db()->exec("ALTER TABLE hc_blog_posts ADD COLUMN tags VARCHAR(500) NULL"); } catch(Exception $e){}

// ── Load data ────────────────────────────────────────────────────────────────
$id   = (int)($_GET['id'] ?? 0);
$post = $id ? hc_one("SELECT * FROM hc_blog_posts WHERE id=?", [$id]) : null;
$cats = hc_all("SELECT id,name,color FROM hc_blog_categories ORDER BY sort_order ASC, name ASC");

// ── Save ─────────────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title'] ?? '');
    $slug     = hc_slug(trim($_POST['slug'] ?? '') ?: $title);
    $excerpt  = trim($_POST['excerpt'] ?? '');
    $content  = $_POST['content'] ?? '';
    $author   = trim($_POST['author'] ?? 'Homecare Creators');
    $cat_id   = (int)($_POST['category_id'] ?? 0) ?: null;
    $tags     = trim($_POST['tags'] ?? '');
    $featured = trim($_POST['featured_image'] ?? '');
    $fkw      = trim($_POST['focus_keyword'] ?? '');
    $skw      = trim($_POST['secondary_keywords'] ?? '');
    $mtitle   = trim($_POST['meta_title'] ?? '') ?: $title;
    $mdesc    = trim($_POST['meta_desc'] ?? '') ?: $excerpt;
    $ogimg    = trim($_POST['og_image'] ?? '') ?: $featured;
    $status   = $_POST['status'] ?? 'draft';
    $pub_at   = $status === 'published'
              ? (($post['published_at'] ?? null) ?: date('Y-m-d H:i:s'))
              : null;

    if ($title) {
        try {
            if ($id) {
                hc_q("UPDATE hc_blog_posts SET title=?,slug=?,excerpt=?,content=?,author=?,category_id=?,tags=?,featured_image=?,focus_keyword=?,secondary_keywords=?,meta_title=?,meta_desc=?,og_image=?,status=?,published_at=?,updated_at=NOW() WHERE id=?",
                    [$title,$slug,$excerpt,$content,$author,$cat_id,$tags,$featured,$fkw,$skw,$mtitle,$mdesc,$ogimg,$status,$pub_at,$id]);
            } else {
                $base = $slug; $n = 1;
                while (hc_val("SELECT id FROM hc_blog_posts WHERE slug=?", [$slug])) $slug = $base.'-'.$n++;
                hc_q("INSERT INTO hc_blog_posts (title,slug,excerpt,content,author,category_id,tags,featured_image,focus_keyword,secondary_keywords,meta_title,meta_desc,og_image,status,published_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                    [$title,$slug,$excerpt,$content,$author,$cat_id,$tags,$featured,$fkw,$skw,$mtitle,$mdesc,$ogimg,$status,$pub_at]);
                $id = (int)hc_db()->lastInsertId();
                $post = hc_one("SELECT * FROM hc_blog_posts WHERE id=?", [$id]);
            }
            hc_flash('Post '.($status==='published'?'published':'saved as draft').'.');
            header('Location: /admin/blog/edit.php?id='.$id); exit;
        } catch (Exception $e) {
            hc_flash('Error: '.$e->getMessage(), 'error');
        }
    } else {
        hc_flash('Title is required.', 'error');
    }
}

$word_count = str_word_count(strip_tags($post['content'] ?? ''));
$title_val  = $post ? 'Edit: '.($post['title'] ?? '') : 'New Post';
hc_head($title_val);
hc_topbar($title_val, '<a href="/admin/">Admin</a> › <a href="/admin/blog/">Blog</a> › '.($post ? 'Edit' : 'New'));
?>
<style>
/* ── Editor chrome ── */
.editor-toolbar{background:#f9f9f9;border:1.5px solid var(--border);border-bottom:none;border-radius:7px 7px 0 0;padding:6px 10px;display:flex;gap:3px;flex-wrap:wrap;align-items:center}
.editor-btn{padding:4px 10px;background:#fff;border:1px solid var(--border);border-radius:5px;cursor:pointer;font-size:12.5px;font-weight:600;line-height:1;color:var(--text);transition:.1s;font-family:inherit}
.editor-btn:hover{background:var(--teal);color:#fff;border-color:var(--teal)}
.editor-sep{width:1px;height:18px;background:var(--border);margin:0 3px;flex-shrink:0}
#blog-content{border-radius:0 0 7px 7px!important;border-top:none!important;min-height:480px;padding:20px;border:1.5px solid var(--border);outline:none;font-size:15px;line-height:1.85;color:var(--text);overflow-y:auto}
#blog-content h2{font-size:24px;font-weight:700;color:var(--forest);margin:28px 0 10px}
#blog-content h3{font-size:19px;font-weight:700;color:var(--forest);margin:20px 0 8px}
#blog-content p{margin-bottom:14px}
#blog-content img{max-width:100%;border-radius:8px;margin:10px 0;border:1px solid var(--border)}
#blog-content ul,#blog-content ol{margin:0 0 14px 22px}
#blog-content blockquote{border-left:4px solid var(--teal);padding:12px 18px;background:rgba(29,158,117,.05);border-radius:0 8px 8px 0;margin:16px 0;font-style:italic;color:var(--forest)}
#blog-content a{color:var(--teal)}
/* ── Featured image drop zone ── */
.feat-dropzone{width:100%;min-height:150px;border:2px dashed var(--border);border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;transition:.2s;position:relative;overflow:hidden;background:var(--cream)}
.feat-dropzone:hover,.feat-dropzone.drag{border-color:var(--teal);background:rgba(29,158,117,.04)}
.feat-dropzone img{width:100%;height:150px;object-fit:cover;display:block;border-radius:8px}
.feat-dropzone .dz-label{font-size:13px;color:var(--muted);text-align:center;padding:20px;pointer-events:none}
.feat-dropzone .dz-label svg{display:block;margin:0 auto 8px;opacity:.4}
.feat-actions{display:flex;gap:8px;margin-top:8px}
/* ── Tag input ── */
.tag-wrap{display:flex;flex-wrap:wrap;gap:6px;padding:6px 8px;border:1.5px solid var(--border);border-radius:7px;min-height:40px;align-items:center;background:#fff;cursor:text;transition:.12s}
.tag-wrap:focus-within{border-color:var(--teal);box-shadow:0 0 0 3px rgba(29,158,117,.09)}
.tag-chip{display:inline-flex;align-items:center;gap:5px;background:rgba(29,158,117,.1);color:var(--teal);border-radius:5px;padding:3px 9px;font-size:12.5px;font-weight:600}
.tag-chip button{background:none;border:none;cursor:pointer;color:var(--teal);font-size:13px;line-height:1;padding:0;opacity:.7}
.tag-chip button:hover{opacity:1}
.tag-input-field{border:none;outline:none;font-size:13px;flex:1;min-width:80px;background:transparent;font-family:inherit}
/* ── Word count bar ── */
.wc-bar{font-size:11.5px;color:var(--muted);display:flex;gap:16px;padding:6px 12px;background:#f9f9f9;border:1.5px solid var(--border);border-top:none;border-radius:0 0 7px 7px;margin-bottom:16px}
.wc-bar span{display:flex;align-items:center;gap:4px}
/* ── Media modal ── */
.media-modal-overlay{display:none;position:fixed;inset:0;background:rgba(0,0,0,.55);z-index:9999;align-items:center;justify-content:center}
.media-modal-overlay.open{display:flex}
.media-modal{background:#fff;border-radius:14px;width:90%;max-width:860px;max-height:88vh;display:flex;flex-direction:column;overflow:hidden}
.media-modal-head{display:flex;align-items:center;justify-content:space-between;padding:18px 24px;border-bottom:1px solid var(--border)}
.media-modal-head h3{font-size:15px;font-weight:700;color:var(--text)}
.media-tabs{display:flex;gap:0;border-bottom:2px solid var(--border)}
.media-tab{padding:10px 20px;font-size:13.5px;font-weight:600;color:var(--muted);cursor:pointer;border-bottom:2px solid transparent;margin-bottom:-2px;background:none;border-top:none;border-left:none;border-right:none;font-family:inherit;transition:.12s}
.media-tab.active{color:var(--teal);border-bottom-color:var(--teal)}
.media-modal-body{flex:1;overflow-y:auto;padding:20px}
.media-upload-zone{border:2px dashed var(--border);border-radius:12px;padding:48px 20px;text-align:center;cursor:pointer;transition:.2s;background:var(--cream)}
.media-upload-zone:hover,.media-upload-zone.drag{border-color:var(--teal);background:rgba(29,158,117,.04)}
.media-upload-zone svg{width:40px;height:40px;opacity:.3;margin:0 auto 12px;display:block}
.media-upload-zone p{font-size:14px;color:var(--muted);margin-bottom:6px}
.media-upload-zone small{font-size:12px;color:var(--muted);opacity:.7}
.media-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(120px,1fr));gap:10px}
.media-item{position:relative;border-radius:8px;overflow:hidden;border:2px solid transparent;cursor:pointer;transition:.15s;aspect-ratio:1;background:var(--cream)}
.media-item:hover{border-color:var(--teal)}
.media-item.selected{border-color:var(--teal);box-shadow:0 0 0 3px rgba(29,158,117,.2)}
.media-item img{width:100%;height:100%;object-fit:cover;display:block}
.media-item-del{position:absolute;top:4px;right:4px;background:rgba(0,0,0,.6);border:none;border-radius:50%;width:22px;height:22px;color:#fff;font-size:11px;cursor:pointer;display:none;align-items:center;justify-content:center;line-height:1}
.media-item:hover .media-item-del{display:flex}
.media-upload-prog{display:none;margin-top:16px}
.media-footer{padding:14px 24px;border-top:1px solid var(--border);display:flex;align-items:center;justify-content:space-between;gap:12px}
</style>

<!-- ── MEDIA MODAL ───────────────────────────────────────────────────────── -->
<div class="media-modal-overlay" id="mediaModal">
  <div class="media-modal">
    <div class="media-modal-head">
      <h3 id="mediaModalTitle">Insert Image</h3>
      <button onclick="closeMedia()" style="background:none;border:none;font-size:20px;cursor:pointer;color:var(--muted);line-height:1">×</button>
    </div>
    <div class="media-tabs">
      <button class="media-tab active" onclick="switchTab('upload',this)">Upload New</button>
      <button class="media-tab" onclick="switchTab('library',this)">Media Library</button>
    </div>
    <div class="media-modal-body">
      <!-- Upload tab -->
      <div id="tab-upload">
        <div class="media-upload-zone" id="modalDropZone" onclick="document.getElementById('modalFileInput').click()">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          <p>Drop an image here or <strong style="color:var(--teal)">click to browse</strong></p>
          <small>JPG, PNG, GIF, WebP — max 5 MB</small>
        </div>
        <input type="file" id="modalFileInput" accept="image/*" style="display:none" onchange="uploadModalFile(this.files[0])">
        <div class="media-upload-prog" id="uploadProgress">
          <div style="background:var(--border);border-radius:20px;height:6px;overflow:hidden">
            <div id="uploadBar" style="height:100%;background:var(--teal);width:0;transition:width .3s;border-radius:20px"></div>
          </div>
          <div style="font-size:12px;color:var(--muted);margin-top:6px;text-align:center" id="uploadStatus">Uploading…</div>
        </div>
      </div>
      <!-- Library tab -->
      <div id="tab-library" style="display:none">
        <div id="mediaGrid" class="media-grid"></div>
        <div id="mediaEmpty" style="display:none;text-align:center;padding:40px;color:var(--muted)">No images uploaded yet.</div>
        <div id="mediaLoading" style="text-align:center;padding:40px;color:var(--muted)">Loading…</div>
      </div>
    </div>
    <div class="media-footer">
      <div style="font-size:12px;color:var(--muted)" id="mediaSelected">No image selected</div>
      <div style="display:flex;gap:8px">
        <button onclick="closeMedia()" class="btn btn-secondary btn-sm">Cancel</button>
        <button onclick="insertSelectedMedia()" class="btn btn-primary btn-sm" id="mediaInsertBtn" disabled>Insert Image</button>
      </div>
    </div>
  </div>
</div>

<div class="page-content">
<?= hc_show_flash() ?>

<form method="POST" id="postForm">
<div style="display:grid;grid-template-columns:1fr 300px;gap:20px;align-items:start">

<!-- ── MAIN COLUMN ───────────────────────────────────────────────────── -->
<div>

  <!-- Title + Slug -->
  <div class="card" style="margin-bottom:0;border-radius:var(--r) var(--r) 0 0;border-bottom:none;padding-bottom:0">
    <div class="form-group" style="margin-bottom:10px">
      <input type="text" id="post-title" name="title"
             value="<?= h($post['title'] ?? '') ?>"
             placeholder="Post title…"
             required
             style="font-size:22px;font-weight:700;padding:14px 16px;border:1.5px solid var(--border);border-radius:9px;width:100%;outline:none;font-family:inherit"
             oninput="autoSlug(this.value)">
    </div>
    <div style="display:flex;align-items:center;gap:6px;padding:0 2px 14px">
      <span style="font-size:13px;color:var(--muted);white-space:nowrap">/blog/</span>
      <input type="text" id="post-slug" name="slug"
             value="<?= h($post['slug'] ?? '') ?>"
             <?= $post ? 'data-locked=1' : '' ?>
             placeholder="auto-generated-slug"
             style="flex:1;font-size:13px;font-family:monospace;padding:6px 10px;border:1.5px solid var(--border);border-radius:7px;outline:none"
             oninput="this.dataset.locked=1">
      <span id="slug-status" style="font-size:11px;color:var(--teal)"></span>
    </div>
  </div>

  <!-- Content editor -->
  <div style="border:1.5px solid var(--border);border-radius:0 0 9px 9px;margin-bottom:4px">
    <div class="editor-toolbar">
      <button class="editor-btn" type="button" onclick="cmd('bold')" title="Bold"><b>B</b></button>
      <button class="editor-btn" type="button" onclick="cmd('italic')" title="Italic"><i>I</i></button>
      <button class="editor-btn" type="button" onclick="cmd('underline')" title="Underline"><u>U</u></button>
      <div class="editor-sep"></div>
      <button class="editor-btn" type="button" onclick="cmd('formatBlock','h2')" title="Heading 2">H2</button>
      <button class="editor-btn" type="button" onclick="cmd('formatBlock','h3')" title="Heading 3">H3</button>
      <button class="editor-btn" type="button" onclick="cmd('formatBlock','p')" title="Paragraph">P</button>
      <div class="editor-sep"></div>
      <button class="editor-btn" type="button" onclick="cmd('insertUnorderedList')" title="Bullet list">• List</button>
      <button class="editor-btn" type="button" onclick="cmd('insertOrderedList')" title="Numbered list">1. List</button>
      <button class="editor-btn" type="button" onclick="cmd('formatBlock','blockquote')" title="Quote">❝</button>
      <div class="editor-sep"></div>
      <button class="editor-btn" type="button" onclick="insertLink()" title="Insert link">🔗 Link</button>
      <button class="editor-btn" type="button" onclick="openMedia('content')" title="Upload / insert image" style="background:var(--forest);color:#fff;border-color:var(--forest)">📷 Image</button>
      <div class="editor-sep"></div>
      <button class="editor-btn" type="button" onclick="cmd('removeFormat')" title="Clear formatting">✕ Clear</button>
    </div>
    <div id="blog-content"
         contenteditable="true"
         style="min-height:480px;padding:20px;border:none;outline:none;font-size:15px;line-height:1.85;color:var(--text)"></div>
    <input type="hidden" id="blog-html" name="content" value="<?= h($post['content'] ?? '') ?>">
  </div>

  <!-- Word count -->
  <div class="wc-bar">
    <span>📝 <strong id="wc-count">0</strong> words</span>
    <span>⏱ <strong id="rt-count">0</strong> min read</span>
    <span id="saved-indicator" style="margin-left:auto;color:var(--teal);display:none">✓ Saved</span>
  </div>

  <!-- Excerpt -->
  <div class="card">
    <div class="card-title" style="margin-bottom:10px">Excerpt</div>
    <textarea name="excerpt" rows="3" placeholder="A short summary shown on the blog listing page…"><?= h($post['excerpt'] ?? '') ?></textarea>
    <div class="form-hint">Shown on the blog listing and used as meta description fallback.</div>
  </div>

  <!-- SEO -->
  <div class="card">
    <div class="card-title" style="margin-bottom:16px">SEO Settings</div>
    <div class="form-grid">
      <div class="form-group">
        <label>Focus Keyword</label>
        <input type="text" name="focus_keyword" value="<?= h($post['focus_keyword'] ?? '') ?>" placeholder="Main keyword this post targets">
      </div>
      <div class="form-group">
        <label>Secondary Keywords <span>(comma-separated)</span></label>
        <input type="text" name="secondary_keywords" value="<?= h($post['secondary_keywords'] ?? '') ?>">
      </div>
    </div>
    <div class="form-group">
      <label>Meta Title <span>(50–60 chars recommended)</span></label>
      <input type="text" name="meta_title" id="meta-title"
             value="<?= h($post['meta_title'] ?? '') ?>"
             placeholder="Defaults to post title"
             oninput="updateCounter('meta-title','cnt-mt',50,60)">
      <div class="char-row"><span></span><span id="cnt-mt" class="char-count"></span></div>
    </div>
    <div class="form-group">
      <label>Meta Description <span>(150–160 chars recommended)</span></label>
      <textarea name="meta_desc" id="meta-desc" rows="2"
                placeholder="Defaults to excerpt"
                oninput="updateCounter('meta-desc','cnt-md',150,160)"><?= h($post['meta_desc'] ?? '') ?></textarea>
      <div class="char-row"><span></span><span id="cnt-md" class="char-count"></span></div>
    </div>
    <div class="form-group">
      <label>OG / Social Share Image URL</label>
      <input type="url" name="og_image" value="<?= h($post['og_image'] ?? '') ?>" placeholder="Defaults to featured image">
    </div>
  </div>

</div><!-- /main col -->

<!-- ── SIDEBAR ───────────────────────────────────────────────────────── -->
<div style="position:sticky;top:70px;display:flex;flex-direction:column;gap:16px">

  <!-- Publish -->
  <div class="card">
    <div class="card-title" style="margin-bottom:14px">Publish</div>
    <div class="form-group">
      <label>Status</label>
      <select name="status" id="status-sel">
        <option value="draft"     <?= ($post['status']??'draft')==='draft'?'selected':'' ?>>Draft</option>
        <option value="published" <?= ($post['status']??'')==='published'?'selected':'' ?>>Published</option>
      </select>
    </div>
    <div style="display:flex;flex-direction:column;gap:8px">
      <button type="submit" class="btn btn-primary btn-lg" id="saveBtn">
        <?= ($post['status']??'draft')==='published' ? 'Update Post' : 'Save Post' ?>
      </button>
      <?php if ($post && $post['status']==='published'): ?>
      <a href="/blog/<?= h($post['slug']) ?>" target="_blank" class="btn btn-secondary btn-sm" style="text-align:center">↗ View Live Post</a>
      <?php endif ?>
      <a href="/admin/blog/" class="btn btn-ghost btn-sm" style="text-align:center">← Back to Posts</a>
    </div>
    <?php if ($post): ?>
    <div style="margin-top:12px;padding-top:12px;border-top:1px solid var(--border);font-size:11.5px;color:var(--muted)">
      Created: <?= date('M j, Y', strtotime($post['created_at'] ?? 'now')) ?><br>
      <?php if ($post['published_at']): ?>Published: <?= date('M j, Y', strtotime($post['published_at'])) ?><br><?php endif ?>
      <?php if ($post['updated_at']): ?>Updated: <?= date('M j, Y g:i a', strtotime($post['updated_at'])) ?><?php endif ?>
    </div>
    <?php endif ?>
  </div>

  <!-- Featured Image -->
  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Featured Image</div>
    <div class="feat-dropzone" id="featDropZone" onclick="openMedia('featured')"
         ondragover="event.preventDefault();this.classList.add('drag')"
         ondragleave="this.classList.remove('drag')"
         ondrop="featDrop(event)">
      <?php if (!empty($post['featured_image'])): ?>
        <img src="<?= h($post['featured_image']) ?>" id="featPreviewImg" alt="Featured image preview" style="border-radius:8px">
      <?php else: ?>
        <div class="dz-label" id="featLabel">
          <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" style="width:32px;height:32px"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" y1="3" x2="12" y2="15"/></svg>
          Click to upload or drop image here
        </div>
      <?php endif ?>
    </div>
    <div class="feat-actions">
      <button type="button" class="btn btn-secondary btn-sm" onclick="openMedia('featured')" style="flex:1">
        <?= empty($post['featured_image']) ? 'Upload Image' : 'Replace Image' ?>
      </button>
      <?php if (!empty($post['featured_image'])): ?>
      <button type="button" class="btn btn-danger btn-sm" onclick="removeFeatured()">Remove</button>
      <?php endif ?>
    </div>
    <input type="hidden" id="feat-url" name="featured_image" value="<?= h($post['featured_image'] ?? '') ?>">
  </div>

  <!-- Category -->
  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Category</div>
    <?php if ($cats): ?>
    <select name="category_id">
      <option value="">— No category —</option>
      <?php foreach ($cats as $c): ?>
      <option value="<?= $c['id'] ?>"
        <?= ($post['category_id'] ?? '') == $c['id'] ? 'selected' : '' ?>
        style="color:<?= h($c['color']) ?>">
        <?= h($c['name']) ?>
      </option>
      <?php endforeach ?>
    </select>
    <?php else: ?>
    <div style="font-size:13px;color:var(--muted);margin-bottom:10px">No categories yet.</div>
    <?php endif ?>
    <a href="/admin/blog/categories.php" class="btn btn-ghost btn-sm" style="margin-top:8px;width:100%;justify-content:center">
      + Manage Categories
    </a>
  </div>

  <!-- Tags -->
  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Tags</div>
    <div class="tag-wrap" id="tagWrap" onclick="document.getElementById('tagInput').focus()">
      <!-- chips injected by JS -->
      <input type="text" id="tagInput" class="tag-input-field" placeholder="Add tag, press Enter…">
    </div>
    <input type="hidden" id="tags-hidden" name="tags" value="<?= h($post['tags'] ?? '') ?>">
    <div class="form-hint" style="margin-top:6px">Press Enter or comma to add. Click × to remove.</div>
  </div>

  <!-- Author -->
  <div class="card">
    <div class="card-title" style="margin-bottom:10px">Author</div>
    <input type="text" name="author" value="<?= h($post['author'] ?? 'Homecare Creators') ?>">
  </div>

</div><!-- /sidebar -->
</div><!-- /grid -->
</form>
</div>

<script>
// ── Init editor ──────────────────────────────────────────────────────────────
var editor = document.getElementById('blog-content');
var hiddenField = document.getElementById('blog-html');
var initialHTML = hiddenField.value;
if (initialHTML) editor.innerHTML = initialHTML;

editor.addEventListener('input', function() {
  hiddenField.value = editor.innerHTML;
  updateWordCount();
});
updateWordCount();

function cmd(command, value) {
  editor.focus();
  if (value) document.execCommand('formatBlock', false, value);
  else document.execCommand(command, false, null);
  hiddenField.value = editor.innerHTML;
}

function insertLink() {
  var url = prompt('Enter URL:');
  if (url) { editor.focus(); document.execCommand('createLink', false, url); hiddenField.value = editor.innerHTML; }
}

function updateWordCount() {
  var text = editor.innerText || editor.textContent || '';
  var words = text.trim() ? text.trim().split(/\s+/).length : 0;
  document.getElementById('wc-count').textContent = words.toLocaleString();
  document.getElementById('rt-count').textContent = Math.max(1, Math.round(words / 200));
}

// ── Slug auto-gen ────────────────────────────────────────────────────────────
function autoSlug(val) {
  var s = document.getElementById('post-slug');
  if (s.dataset.locked) return;
  s.value = val.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/[\s-]+/g,'-').replace(/^-|-$/g,'');
}

// ── Char counters ────────────────────────────────────────────────────────────
function updateCounter(inputId, counterId, lo, hi) {
  var el = document.getElementById(inputId);
  var len = el.value.length || el.textContent.length;
  var badge = document.getElementById(counterId);
  badge.textContent = len + ' chars';
  badge.className = 'char-count ' + (len < lo ? '' : len <= hi ? 'good' : 'over');
}
updateCounter('meta-title','cnt-mt',50,60);
updateCounter('meta-desc','cnt-md',150,160);

// ── Tag input ────────────────────────────────────────────────────────────────
var tags = (document.getElementById('tags-hidden').value || '').split(',').map(function(t){return t.trim();}).filter(Boolean);
renderTags();
function renderTags() {
  var wrap = document.getElementById('tagWrap');
  wrap.querySelectorAll('.tag-chip').forEach(function(el){el.remove();});
  tags.forEach(function(t) {
    var chip = document.createElement('span'); chip.className = 'tag-chip';
    chip.innerHTML = t + ' <button type="button" onclick="removeTag(\''+t+'\')">×</button>';
    wrap.insertBefore(chip, document.getElementById('tagInput'));
  });
  document.getElementById('tags-hidden').value = tags.join(',');
}
function addTag(val) {
  val = val.trim().toLowerCase().replace(/[^a-z0-9\s-]/g,'');
  if (val && !tags.includes(val)) { tags.push(val); renderTags(); }
}
function removeTag(t) { tags = tags.filter(function(x){return x!==t;}); renderTags(); }
document.getElementById('tagInput').addEventListener('keydown', function(e) {
  if (e.key === 'Enter' || e.key === ',') { e.preventDefault(); addTag(this.value); this.value = ''; }
  if (e.key === 'Backspace' && !this.value && tags.length) { tags.pop(); renderTags(); }
});

// ── Featured image ────────────────────────────────────────────────────────────
function setFeatured(url) {
  document.getElementById('feat-url').value = url;
  var zone = document.getElementById('featDropZone');
  zone.innerHTML = '<img src="'+url+'" alt="Featured" style="width:100%;height:150px;object-fit:cover;border-radius:8px;display:block">';
}
function removeFeatured() {
  document.getElementById('feat-url').value = '';
  var zone = document.getElementById('featDropZone');
  zone.innerHTML = '<div class="dz-label">Click to upload or drop image here</div>';
}
function featDrop(e) {
  e.preventDefault();
  document.getElementById('featDropZone').classList.remove('drag');
  var file = e.dataTransfer.files[0];
  if (file && file.type.startsWith('image/')) uploadFile(file, 'featured');
}

// ── Media modal ───────────────────────────────────────────────────────────────
var mediaTarget = 'content'; // 'content' or 'featured'
var selectedMediaUrl = null;

function openMedia(target) {
  mediaTarget = target;
  selectedMediaUrl = null;
  document.getElementById('mediaModalTitle').textContent = target === 'featured' ? 'Set Featured Image' : 'Insert Image';
  document.getElementById('mediaInsertBtn').disabled = true;
  document.getElementById('mediaSelected').textContent = 'No image selected';
  document.getElementById('mediaModal').classList.add('open');
  switchTab('upload', document.querySelector('.media-tab'));
}
function closeMedia() { document.getElementById('mediaModal').classList.remove('open'); }

function switchTab(tab, btn) {
  document.querySelectorAll('.media-tab').forEach(function(b){b.classList.remove('active');});
  btn.classList.add('active');
  document.getElementById('tab-upload').style.display = tab === 'upload' ? '' : 'none';
  document.getElementById('tab-library').style.display = tab === 'library' ? '' : 'none';
  if (tab === 'library') loadMediaLibrary();
}

function loadMediaLibrary() {
  var grid = document.getElementById('mediaGrid');
  var empty = document.getElementById('mediaEmpty');
  var loading = document.getElementById('mediaLoading');
  grid.innerHTML = ''; empty.style.display = 'none'; loading.style.display = '';
  fetch('/admin/blog/upload.php?action=list')
    .then(function(r){return r.json();})
    .then(function(d){
      loading.style.display = 'none';
      if (!d.items || !d.items.length) { empty.style.display = ''; return; }
      d.items.forEach(function(item) {
        var div = document.createElement('div'); div.className = 'media-item';
        div.dataset.url = item.url;
        div.innerHTML = '<img src="'+item.url+'" alt="'+item.original_name+'" loading="lazy">'
          + '<button class="media-item-del" title="Delete" onclick="deleteMedia(event,'+item.id+',this.closest(\'.media-item\'))">×</button>';
        div.addEventListener('click', function(e) {
          if (e.target.classList.contains('media-item-del')) return;
          document.querySelectorAll('.media-item').forEach(function(m){m.classList.remove('selected');});
          div.classList.add('selected');
          selectedMediaUrl = item.url;
          document.getElementById('mediaInsertBtn').disabled = false;
          document.getElementById('mediaSelected').textContent = item.original_name;
        });
        grid.appendChild(div);
      });
    })
    .catch(function(){ loading.style.display='none'; empty.style.display=''; });
}

function deleteMedia(e, id, el) {
  e.stopPropagation();
  if (!confirm('Delete this image?')) return;
  var fd = new FormData(); fd.append('action','delete'); fd.append('id',id);
  fetch('/admin/blog/upload.php', {method:'POST',body:fd})
    .then(function(r){return r.json();})
    .then(function(d){ if(d.success) el.remove(); });
}

function insertSelectedMedia() {
  if (!selectedMediaUrl) return;
  if (mediaTarget === 'featured') {
    setFeatured(selectedMediaUrl);
  } else {
    editor.focus();
    document.execCommand('insertHTML', false, '<img src="'+selectedMediaUrl+'" alt="" style="max-width:100%;border-radius:8px;margin:10px 0">');
    hiddenField.value = editor.innerHTML;
  }
  closeMedia();
}

// ── File upload (modal) ───────────────────────────────────────────────────────
var modalDZ = document.getElementById('modalDropZone');
modalDZ.addEventListener('dragover', function(e){e.preventDefault();this.classList.add('drag');});
modalDZ.addEventListener('dragleave', function(){this.classList.remove('drag');});
modalDZ.addEventListener('drop', function(e){
  e.preventDefault(); this.classList.remove('drag');
  var f = e.dataTransfer.files[0];
  if (f && f.type.startsWith('image/')) uploadModalFile(f);
});

function uploadModalFile(file) {
  uploadFile(file, mediaTarget, true);
}

function uploadFile(file, target, fromModal) {
  var prog = document.getElementById('uploadProgress');
  var bar  = document.getElementById('uploadBar');
  var stat = document.getElementById('uploadStatus');
  if (fromModal) { prog.style.display=''; bar.style.width='10%'; stat.textContent='Uploading…'; }

  var fd = new FormData(); fd.append('file', file);
  fetch('/admin/blog/upload.php', {method:'POST', body:fd})
    .then(function(r){return r.json();})
    .then(function(d){
      if (fromModal) { bar.style.width='100%'; }
      if (d.success) {
        if (target === 'featured') {
          setFeatured(d.url);
          if (fromModal) { setTimeout(function(){ prog.style.display='none'; bar.style.width='0'; closeMedia(); }, 500); }
        } else {
          editor.focus();
          document.execCommand('insertHTML', false, '<img src="'+d.url+'" alt="" style="max-width:100%;border-radius:8px;margin:10px 0">');
          hiddenField.value = editor.innerHTML;
          if (fromModal) { setTimeout(function(){ prog.style.display='none'; bar.style.width='0'; closeMedia(); }, 500); }
        }
      } else {
        if (fromModal) { stat.textContent = '❌ ' + d.error; bar.style.background='var(--red)'; }
        else alert(d.error);
      }
    })
    .catch(function(){
      if (fromModal) stat.textContent = '❌ Upload failed.';
    });
}

// ── Close modal on backdrop click ─────────────────────────────────────────────
document.getElementById('mediaModal').closest('.media-modal-overlay').addEventListener('click', function(e) {
  if (e.target === this) closeMedia();
});

// ── Prevent submit without syncing hidden field ───────────────────────────────
document.getElementById('postForm').addEventListener('submit', function() {
  hiddenField.value = editor.innerHTML;
});
</script>
<?php hc_foot(); ?>
