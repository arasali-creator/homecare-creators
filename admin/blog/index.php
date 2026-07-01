<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

if (isset($_GET['delete'])) {
    hc_q("DELETE FROM hc_blog_posts WHERE id=?", [(int)$_GET['delete']]);
    hc_flash('Post deleted.');
    header('Location: /admin/blog/');
    exit;
}

$status  = $_GET['status'] ?? 'all';
$cat_flt = (int)($_GET['cat'] ?? 0);

$where_parts = [];
if ($status !== 'all') $where_parts[] = "p.status='" . ($status==='published'?'published':'draft') . "'";
if ($cat_flt) $where_parts[] = "p.category_id=" . $cat_flt;
$where = $where_parts ? 'WHERE '.implode(' AND ', $where_parts) : '';

$posts = hc_all("SELECT p.id,p.title,p.slug,p.status,p.focus_keyword,p.published_at,p.created_at,p.category_id,
                        c.name AS cat_name, c.color AS cat_color
                 FROM hc_blog_posts p
                 LEFT JOIN hc_blog_categories c ON c.id=p.category_id
                 $where ORDER BY p.created_at DESC");

$cats = hc_all("SELECT id,name,color FROM hc_blog_categories ORDER BY sort_order ASC, name ASC");

hc_head('Blog Posts');
hc_topbar('Blog Posts', '<a href="/admin/">Admin</a> › Blog');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Blog Posts</h1><div class="sub"><?= count($posts) ?> post<?= count($posts)!==1?'s':'' ?></div></div>
  <a href="/admin/blog/edit.php" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Post
  </a>
</div>

<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px;align-items:center">
  <a href="?status=all" class="btn btn-sm <?= $status==='all'&&!$cat_flt?'btn-primary':'btn-secondary' ?>">All</a>
  <a href="?status=published" class="btn btn-sm <?= $status==='published'&&!$cat_flt?'btn-primary':'btn-secondary' ?>">Published</a>
  <a href="?status=draft" class="btn btn-sm <?= $status==='draft'&&!$cat_flt?'btn-primary':'btn-secondary' ?>">Drafts</a>
  <?php if ($cats): ?>
  <div style="width:1px;height:20px;background:var(--border);margin:0 4px"></div>
  <?php foreach ($cats as $c): ?>
  <a href="?cat=<?= $c['id'] ?>" class="btn btn-sm <?= $cat_flt==$c['id']?'btn-primary':'btn-secondary' ?>"
     style="<?= $cat_flt==$c['id']?'':'border-left:3px solid '.$c['color'] ?>">
    <?= h($c['name']) ?>
  </a>
  <?php endforeach ?>
  <?php endif ?>
</div>

<div class="card">
  <?php if ($posts): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Title</th><th>Category</th><th>Focus Keyword</th><th>Status</th><th>Date</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($posts as $p): ?>
      <tr>
        <td>
          <strong><?= h($p['title']) ?></strong>
          <div style="font-size:11px;color:var(--muted);font-family:monospace;margin-top:2px">/blog/<?= h($p['slug']) ?></div>
        </td>
        <td>
          <?php if ($p['cat_name']): ?>
          <span style="display:inline-flex;align-items:center;gap:5px;font-size:12px;background:<?= h($p['cat_color']) ?>20;color:<?= h($p['cat_color']) ?>;border-radius:5px;padding:2px 8px;font-weight:600;white-space:nowrap">
            <span style="width:6px;height:6px;border-radius:50%;background:<?= h($p['cat_color']) ?>"></span>
            <?= h($p['cat_name']) ?>
          </span>
          <?php else: ?>
          <span style="color:var(--muted);font-size:12px">—</span>
          <?php endif ?>
        </td>
        <td><?= $p['focus_keyword'] ? '<span class="tag">'.h($p['focus_keyword']).'</span>' : '<span style="color:var(--muted);font-size:12px">—</span>' ?></td>
        <td><span class="badge <?= $p['status']==='published'?'badge-green':'badge-gray' ?>"><?= $p['status'] ?></span></td>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap">
          <?= $p['published_at'] ? date('M j, Y', strtotime($p['published_at'])) : date('M j, Y', strtotime($p['created_at'])) ?>
        </td>
        <td class="td-actions">
          <a href="/admin/blog/edit.php?id=<?= $p['id'] ?>">Edit</a>
          <?php if($p['status']==='published'): ?>
          <a href="/blog/post.php?slug=<?= urlencode($p['slug']) ?>" target="_blank">View</a>
          <?php endif ?>
          <a href="?delete=<?= $p['id'] ?>" class="danger" data-confirm="Delete '<?= h($p['title']) ?>'?">Delete</a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
    <p>No blog posts yet.</p>
    <a href="/admin/blog/edit.php" class="btn btn-primary" style="margin-top:12px">Write your first post</a>
  </div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
