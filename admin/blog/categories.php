<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

// Ensure table exists
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

$action = $_POST['action'] ?? $_GET['action'] ?? '';
$id     = (int)($_POST['id'] ?? $_GET['id'] ?? 0);

// Delete
if ($action === 'delete' && $id) {
    $inUse = (int)hc_val("SELECT COUNT(*) FROM hc_blog_posts WHERE category_id=?", [$id]);
    if ($inUse > 0) {
        hc_flash("Cannot delete — {$inUse} post(s) use this category. Reassign them first.", 'error');
    } else {
        hc_q("DELETE FROM hc_blog_categories WHERE id=?", [$id]);
        hc_flash('Category deleted.');
    }
    header('Location: /admin/blog/categories.php'); exit;
}

// Save (add or edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($action, ['add', 'edit'])) {
    $name  = trim($_POST['name'] ?? '');
    $slug  = hc_slug(trim($_POST['slug'] ?? '') ?: $name);
    $color = preg_match('/^#[0-9a-fA-F]{6}$/', $_POST['color'] ?? '') ? $_POST['color'] : '#1d9e75';
    $desc  = trim($_POST['description'] ?? '');
    $sort  = (int)($_POST['sort_order'] ?? 0);

    if (!$name) { hc_flash('Name is required.', 'error'); header('Location: /admin/blog/categories.php'); exit; }

    // Ensure unique slug on add
    if ($action === 'add') {
        $base = $slug; $n = 1;
        while (hc_val("SELECT id FROM hc_blog_categories WHERE slug=?", [$slug])) {
            $slug = $base . '-' . $n++;
        }
        hc_q("INSERT INTO hc_blog_categories (name,slug,color,description,sort_order) VALUES (?,?,?,?,?)",
            [$name, $slug, $color, $desc, $sort]);
        hc_flash("Category "{$name}" created.");
    } else {
        hc_q("UPDATE hc_blog_categories SET name=?,slug=?,color=?,description=?,sort_order=? WHERE id=?",
            [$name, $slug, $color, $desc, $sort, $id]);
        hc_flash("Category "{$name}" updated.");
    }
    header('Location: /admin/blog/categories.php'); exit;
}

$cats = hc_all("SELECT c.*, (SELECT COUNT(*) FROM hc_blog_posts p WHERE p.category_id=c.id) AS post_count
                FROM hc_blog_categories c ORDER BY c.sort_order ASC, c.name ASC");
$edit = $id ? hc_one("SELECT * FROM hc_blog_categories WHERE id=?", [$id]) : null;

hc_head('Blog Categories');
hc_topbar('Blog Categories', '<a href="/admin/">Admin</a> › <a href="/admin/blog/">Blog</a> › Categories');
?>
<div class="page-content">
<?= hc_show_flash() ?>

<div style="display:grid;grid-template-columns:1fr 380px;gap:20px;align-items:start">

  <!-- Category list -->
  <div class="card">
    <div class="card-header">
      <div><div class="card-title">All Categories</div><div class="card-sub"><?= count($cats) ?> categor<?= count($cats)===1?'y':'ies' ?></div></div>
      <a href="/admin/blog/categories.php" class="btn btn-secondary btn-sm">Clear Edit</a>
    </div>
    <?php if ($cats): ?>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Name</th><th>Slug</th><th>Color</th><th>Posts</th><th class="td-actions">Actions</th></tr></thead>
        <tbody>
        <?php foreach ($cats as $c): ?>
        <tr>
          <td>
            <div style="display:flex;align-items:center;gap:10px">
              <span style="width:14px;height:14px;border-radius:50%;background:<?= h($c['color']) ?>;flex-shrink:0;display:inline-block"></span>
              <strong><?= h($c['name']) ?></strong>
            </div>
            <?php if ($c['description']): ?>
            <div style="font-size:12px;color:var(--muted);margin-top:2px;margin-left:24px"><?= h($c['description']) ?></div>
            <?php endif ?>
          </td>
          <td class="td-path"><?= h($c['slug']) ?></td>
          <td><code style="font-size:11px"><?= h($c['color']) ?></code></td>
          <td><span class="badge badge-gray"><?= $c['post_count'] ?></span></td>
          <td class="td-actions">
            <a href="?id=<?= $c['id'] ?>">Edit</a>
            <a href="?action=delete&id=<?= $c['id'] ?>" class="danger"
               onclick="return confirm('Delete category \'<?= h($c['name']) ?>\'?')">Delete</a>
          </td>
        </tr>
        <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
    <div class="empty-state">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M22 19a2 2 0 0 1-2 2H4a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h5l2 3h9a2 2 0 0 1 2 2z"/></svg>
      <p>No categories yet. Add your first one →</p>
    </div>
    <?php endif ?>
  </div>

  <!-- Add / Edit form -->
  <div class="card" style="position:sticky;top:70px">
    <div class="card-header">
      <div class="card-title"><?= $edit ? 'Edit Category' : 'Add New Category' ?></div>
    </div>
    <form method="POST">
      <input type="hidden" name="action" value="<?= $edit ? 'edit' : 'add' ?>">
      <?php if ($edit): ?><input type="hidden" name="id" value="<?= $edit['id'] ?>"><?php endif ?>

      <div class="form-group">
        <label>Name <span>(required)</span></label>
        <input type="text" name="name" id="cat-name" required placeholder="e.g. Local SEO"
               value="<?= h($edit['name'] ?? '') ?>" oninput="autoSlug()">
      </div>
      <div class="form-group">
        <label>Slug</label>
        <input type="text" name="slug" id="cat-slug" placeholder="auto-generated"
               value="<?= h($edit['slug'] ?? '') ?>">
        <div class="form-hint">Used in the URL: /blog/category/slug</div>
      </div>
      <div class="form-group">
        <label>Color</label>
        <div style="display:flex;gap:10px;align-items:center">
          <input type="color" name="color" id="cat-color"
                 value="<?= h($edit['color'] ?? '#1d9e75') ?>"
                 style="width:48px;height:36px;border:1.5px solid var(--border);border-radius:7px;cursor:pointer;padding:2px">
          <span style="font-size:13px;color:var(--muted)">Badge color for this category</span>
        </div>
      </div>
      <div class="form-group">
        <label>Description <span>(optional)</span></label>
        <textarea name="description" rows="2" placeholder="What topics does this category cover?"><?= h($edit['description'] ?? '') ?></textarea>
      </div>
      <div class="form-group">
        <label>Sort Order</label>
        <input type="number" name="sort_order" value="<?= h($edit['sort_order'] ?? 0) ?>" min="0" style="max-width:100px">
        <div class="form-hint">Lower numbers appear first</div>
      </div>
      <div style="display:flex;gap:10px">
        <button type="submit" class="btn btn-primary"><?= $edit ? 'Save Changes' : 'Add Category' ?></button>
        <?php if ($edit): ?>
        <a href="/admin/blog/categories.php" class="btn btn-secondary">Cancel</a>
        <?php endif ?>
      </div>
    </form>
  </div>
</div>

</div>
<script>
function autoSlug() {
  var s = document.getElementById('cat-slug');
  if (s.dataset.locked) return;
  var v = document.getElementById('cat-name').value.toLowerCase()
    .replace(/[^a-z0-9\s-]/g,'').replace(/[\s-]+/g,'-').replace(/^-|-$/g,'');
  s.value = v;
}
document.getElementById('cat-slug').addEventListener('input', function(){ this.dataset.locked = 1; });
</script>
<?php hc_foot(); ?>
