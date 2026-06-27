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

$status = $_GET['status'] ?? 'all';
$where  = $status !== 'all' ? "WHERE status='" . ($status==='published'?'published':'draft') . "'" : '';
$posts  = hc_all("SELECT id,title,slug,status,focus_keyword,published_at,created_at FROM hc_blog_posts $where ORDER BY created_at DESC");

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

<div style="display:flex;gap:8px;margin-bottom:16px">
  <a href="?status=all" class="btn btn-sm <?= $status==='all'?'btn-primary':'btn-secondary' ?>">All</a>
  <a href="?status=published" class="btn btn-sm <?= $status==='published'?'btn-primary':'btn-secondary' ?>">Published</a>
  <a href="?status=draft" class="btn btn-sm <?= $status==='draft'?'btn-primary':'btn-secondary' ?>">Drafts</a>
</div>

<div class="card">
  <?php if ($posts): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Title</th><th>Slug</th><th>Focus Keyword</th><th>Status</th><th>Date</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($posts as $p): ?>
      <tr>
        <td><strong><?= h($p['title']) ?></strong></td>
        <td class="td-path"><?= h($p['slug']) ?></td>
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
