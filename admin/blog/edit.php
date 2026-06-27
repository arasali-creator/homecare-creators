<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$id   = (int)($_GET['id'] ?? 0);
$post = $id ? hc_one("SELECT * FROM hc_blog_posts WHERE id=?", [$id]) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title    = trim($_POST['title'] ?? '');
    $slug     = hc_slug(trim($_POST['slug'] ?? '') ?: $title);
    $excerpt  = trim($_POST['excerpt'] ?? '');
    $content  = $_POST['content'] ?? '';
    $author   = trim($_POST['author'] ?? 'Homecare Creators');
    $featured = trim($_POST['featured_image'] ?? '');
    $fkw      = trim($_POST['focus_keyword'] ?? '');
    $skw      = trim($_POST['secondary_keywords'] ?? '');
    $mtitle   = trim($_POST['meta_title'] ?? '') ?: $title;
    $mdesc    = trim($_POST['meta_desc'] ?? '') ?: $excerpt;
    $ogimg    = trim($_POST['og_image'] ?? '') ?: $featured;
    $status   = $_POST['status'] ?? 'draft';
    $pub_at   = $status === 'published' ? (($post['published_at'] ?? null) ?: date('Y-m-d H:i:s')) : null;

    if ($title) {
        try {
            if ($id) {
                hc_q("UPDATE hc_blog_posts SET title=?,slug=?,excerpt=?,content=?,author=?,featured_image=?,focus_keyword=?,secondary_keywords=?,meta_title=?,meta_desc=?,og_image=?,status=?,published_at=?,updated_at=NOW() WHERE id=?",
                    [$title,$slug,$excerpt,$content,$author,$featured,$fkw,$skw,$mtitle,$mdesc,$ogimg,$status,$pub_at,$id]);
            } else {
                // Ensure unique slug
                $base = $slug; $n = 1;
                while (hc_val("SELECT id FROM hc_blog_posts WHERE slug=?", [$slug])) {
                    $slug = $base . '-' . $n++;
                }
                hc_q("INSERT INTO hc_blog_posts (title,slug,excerpt,content,author,featured_image,focus_keyword,secondary_keywords,meta_title,meta_desc,og_image,status,published_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)",
                    [$title,$slug,$excerpt,$content,$author,$featured,$fkw,$skw,$mtitle,$mdesc,$ogimg,$status,$pub_at]);
                $id = (int)hc_db()->lastInsertId();
            }
            hc_flash('Post ' . ($status==='published'?'published':'saved as draft') . '.');
            header('Location: /admin/blog/edit.php?id=' . $id);
            exit;
        } catch (Exception $e) {
            hc_flash('Database error: ' . $e->getMessage(), 'error');
        }
    } else {
        hc_flash('Title is required.', 'error');
    }
}

$title_val = $post ? 'Edit: ' . $post['title'] : 'New Blog Post';
hc_head($title_val);
hc_topbar($title_val, '<a href="/admin/">Admin</a> › <a href="/admin/blog/">Blog</a> › ' . ($post ? 'Edit' : 'New'));
?>
<div class="page-content">

<?= hc_show_flash() ?>

<form method="POST">
<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start">

<!-- Main content -->
<div>
  <div class="card">
    <div class="form-group">
      <label for="post-title">Title</label>
      <input type="text" id="post-title" name="title" value="<?= h($post['title']??'') ?>" placeholder="Enter post title" required style="font-size:18px;font-weight:600;padding:12px">
    </div>
    <div class="form-group">
      <label for="post-slug">Slug <span>(URL)</span></label>
      <div style="display:flex;gap:8px;align-items:center">
        <span style="color:var(--muted);font-size:13px;white-space:nowrap">/blog/</span>
        <input type="text" id="post-slug" name="slug" value="<?= h($post['slug']??'') ?>" <?= $post?'data-locked=1':'' ?> placeholder="auto-generated">
      </div>
    </div>
    <div class="form-group">
      <label for="excerpt">Excerpt <span>(shown in blog listing)</span></label>
      <textarea id="excerpt" name="excerpt" rows="2" placeholder="A short summary of this post..."><?= h($post['excerpt']??'') ?></textarea>
    </div>

    <!-- Editor -->
    <div class="form-group">
      <label>Content</label>
      <div class="editor-toolbar">
        <button class="editor-btn" data-cmd="bold" title="Bold"><b>B</b></button>
        <button class="editor-btn" data-cmd="italic" title="Italic"><i>I</i></button>
        <button class="editor-btn" data-cmd="underline" title="Underline"><u>U</u></button>
        <div class="editor-sep"></div>
        <button class="editor-btn" data-cmd="formatBlock" data-val="h2" title="Heading 2">H2</button>
        <button class="editor-btn" data-cmd="formatBlock" data-val="h3" title="Heading 3">H3</button>
        <button class="editor-btn" data-cmd="formatBlock" data-val="p" title="Paragraph">P</button>
        <div class="editor-sep"></div>
        <button class="editor-btn" data-cmd="insertUnorderedList" title="Bullet list">• List</button>
        <button class="editor-btn" data-cmd="insertOrderedList" title="Numbered list">1. List</button>
        <div class="editor-sep"></div>
        <button class="editor-btn" data-cmd="createLink" data-val="prompt" title="Link" onclick="var u=prompt('URL:');if(u)document.execCommand('createLink',false,u);return false;">Link</button>
        <button class="editor-btn" data-cmd="removeFormat" title="Clear formatting">✕</button>
      </div>
      <div id="blog-content" contenteditable="true" style="min-height:400px;padding:16px;border:1.5px solid var(--border);border-top:none;border-radius:0 0 7px 7px;outline:none;font-size:15px;line-height:1.8;color:var(--text)"></div>
      <input type="hidden" id="blog-html" name="content" value="<?= h($post['content']??'') ?>">
    </div>
  </div>

  <!-- SEO tab -->
  <div class="card">
    <div class="card-title" style="margin-bottom:16px">SEO Settings</div>
    <div class="form-group">
      <label for="focus_keyword">Focus Keyword</label>
      <input type="text" id="focus_keyword" name="focus_keyword" value="<?= h($post['focus_keyword']??'') ?>" placeholder="Main keyword this post targets">
      <?php if ($post && $post['focus_keyword']): ?>
      <div style="margin-top:8px" class="keyword-density">
        Keyword density: <div class="density-bar"><div class="density-fill"></div></div>
        <span class="density-label">calculating…</span>
      </div>
      <?php endif ?>
    </div>
    <div class="form-group">
      <label>Secondary Keywords <span>(comma-separated)</span></label>
      <input type="text" name="secondary_keywords" value="<?= h($post['secondary_keywords']??'') ?>">
    </div>
    <div class="form-group">
      <label>Meta Title <span>(50–60 chars)</span></label>
      <input type="text" name="meta_title" value="<?= h($post['meta_title']??'') ?>" data-counter="cnt-mtitle" data-range="50,60" placeholder="Defaults to post title">
      <div class="char-row"><span></span><span id="cnt-mtitle" class="char-count"></span></div>
    </div>
    <div class="form-group">
      <label>Meta Description <span>(150–160 chars)</span></label>
      <textarea name="meta_desc" data-counter="cnt-mdesc" data-range="150,160" rows="2"><?= h($post['meta_desc']??'') ?></textarea>
      <div class="char-row"><span></span><span id="cnt-mdesc" class="char-count"></span></div>
    </div>
    <div class="form-group">
      <label>OG / Social Image URL</label>
      <input type="url" name="og_image" value="<?= h($post['og_image']??'') ?>" placeholder="https://...">
    </div>
  </div>
</div>

<!-- Sidebar -->
<div>
  <div class="card" style="position:sticky;top:70px">
    <div class="card-title" style="margin-bottom:14px">Publish</div>

    <div class="form-group">
      <label>Status</label>
      <select name="status">
        <option value="draft" <?= ($post['status']??'draft')==='draft'?'selected':'' ?>>Draft</option>
        <option value="published" <?= ($post['status']??'')==='published'?'selected':'' ?>>Published</option>
      </select>
    </div>

    <div style="display:flex;gap:8px;flex-direction:column">
      <button class="btn btn-primary btn-lg" type="submit">Save Post</button>
      <a href="/admin/blog/" class="btn btn-secondary">Cancel</a>
    </div>

    <div class="divider"></div>

    <div class="form-group">
      <label>Author</label>
      <input type="text" name="author" value="<?= h($post['author']??'Homecare Creators') ?>">
    </div>
    <div class="form-group">
      <label>Featured Image URL</label>
      <input type="url" name="featured_image" value="<?= h($post['featured_image']??'') ?>" placeholder="https://...">
      <?php if ($post['featured_image']??''): ?>
      <img src="<?= h($post['featured_image']) ?>" style="margin-top:8px;width:100%;height:120px;object-fit:cover;border-radius:6px;border:1px solid var(--border)" onerror="this.style.display='none'">
      <?php endif ?>
    </div>

    <?php if ($post && $post['status']==='published'): ?>
    <div class="divider"></div>
    <div style="font-size:12px;color:var(--muted)">
      Published: <?= date('M j, Y', strtotime($post['published_at']??$post['created_at'])) ?><br>
      Updated: <?= date('M j, Y', strtotime($post['updated_at']??$post['created_at'])) ?>
    </div>
    <a href="/blog/post.php?slug=<?= urlencode($post['slug']) ?>" target="_blank" class="btn btn-ghost btn-sm" style="margin-top:8px;width:100%;justify-content:center">↗ View live post</a>
    <?php endif ?>
  </div>
</div>

</div>
</form>
</div>
<?php hc_foot(); ?>
