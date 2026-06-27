<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

$new_leads  = (int)hc_val("SELECT COUNT(*) FROM hc_form_submissions WHERE status='new'") ?? 0;
$total_leads= (int)hc_val("SELECT COUNT(*) FROM hc_form_submissions") ?? 0;
$blog_count = (int)hc_val("SELECT COUNT(*) FROM hc_blog_posts WHERE status='published'") ?? 0;
$redirect_c = (int)hc_val("SELECT COUNT(*) FROM hc_redirects WHERE active=1") ?? 0;
$recent     = hc_all("SELECT * FROM hc_form_submissions ORDER BY submitted_at DESC LIMIT 5");
$recent_blog= hc_all("SELECT id,title,status,created_at FROM hc_blog_posts ORDER BY created_at DESC LIMIT 5");

hc_head('Dashboard');
hc_topbar('Dashboard', '<a href="/admin/">Admin</a>');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="stats-grid">
  <div class="stat-card red">
    <div class="stat-num"><?= $new_leads ?></div>
    <div class="stat-label">New Form Leads</div>
  </div>
  <div class="stat-card">
    <div class="stat-num"><?= $total_leads ?></div>
    <div class="stat-label">Total Submissions</div>
  </div>
  <div class="stat-card teal">
    <div class="stat-num"><?= $blog_count ?></div>
    <div class="stat-label">Published Posts</div>
  </div>
  <div class="stat-card gold">
    <div class="stat-num"><?= $redirect_c ?></div>
    <div class="stat-label">Active Redirects</div>
  </div>
</div>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px">

  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Recent Form Submissions</div>
        <div class="card-sub">Latest leads from the website</div>
      </div>
      <a href="/admin/form-log.php" class="btn btn-sm btn-secondary">View All</a>
    </div>
    <?php if ($recent): ?>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Name</th><th>Service</th><th>Date</th><th>Status</th></tr></thead>
        <tbody>
        <?php foreach ($recent as $r): ?>
        <tr>
          <td><a href="/admin/form-log.php?view=<?= $r['id'] ?>"><?= h($r['name']) ?></a><br><small style="color:var(--muted)"><?= h($r['email']) ?></small></td>
          <td><?= h($r['service'] ?? '—') ?></td>
          <td style="font-size:12px;color:var(--muted)"><?= date('M j, g:ia', strtotime($r['submitted_at'])) ?></td>
          <td><span class="badge <?= $r['status']==='new' ? 'badge-red' : ($r['status']==='read' ? 'badge-green' : 'badge-gray') ?>"><?= $r['status'] ?></span></td>
        </tr>
        <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
    <div class="empty-state"><p>No submissions yet.</p></div>
    <?php endif ?>
  </div>

  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Recent Blog Posts</div>
        <div class="card-sub">Latest content</div>
      </div>
      <a href="/admin/blog/edit.php" class="btn btn-sm btn-primary">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
        New Post
      </a>
    </div>
    <?php if ($recent_blog): ?>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Title</th><th>Status</th><th>Date</th></tr></thead>
        <tbody>
        <?php foreach ($recent_blog as $p): ?>
        <tr>
          <td><a href="/admin/blog/edit.php?id=<?= $p['id'] ?>"><?= h($p['title']) ?></a></td>
          <td><span class="badge <?= $p['status']==='published' ? 'badge-green' : 'badge-gray' ?>"><?= $p['status'] ?></span></td>
          <td style="font-size:12px;color:var(--muted)"><?= date('M j', strtotime($p['created_at'])) ?></td>
        </tr>
        <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <?php else: ?>
    <div class="empty-state"><p>No blog posts yet.</p></div>
    <?php endif ?>
  </div>

</div>

<div class="card" style="margin-top:20px">
  <div class="card-title" style="margin-bottom:16px">Quick Actions</div>
  <div style="display:flex;flex-wrap:wrap;gap:10px">
    <a href="/admin/seo-pages.php" class="btn btn-secondary">Edit Page SEO</a>
    <a href="/admin/technical/sitemap.php" class="btn btn-secondary">Sitemap Manager</a>
    <a href="/admin/technical/redirects.php" class="btn btn-secondary">Add Redirect</a>
    <a href="/admin/ai-geo/faq-bank.php" class="btn btn-secondary">FAQ Bank</a>
    <a href="/admin/content/broken-links.php" class="btn btn-secondary">Check Broken Links</a>
    <a href="/admin/blog/edit.php" class="btn btn-primary">Write Blog Post</a>
  </div>
</div>

</div>
<?php hc_foot(); ?>
