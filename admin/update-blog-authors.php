<?php
// ================================================================
//  Blog Author Updater — Homecare Creators
//  Visit /admin/update-blog-authors.php?run=1  to execute.
//  DELETE THIS FILE after running!
//
//  Sets author = 'Asifa Rani' on every row in hc_blog_posts.
//  Safe to re-run. Does not touch title/content/slug/status —
//  only the author column.
// ================================================================
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
hc_require_auth();

$run = isset($_GET['run']);
$updated = null;
$posts = hc_all("SELECT id, title, author FROM hc_blog_posts ORDER BY id ASC");

if ($run) {
    hc_q("UPDATE hc_blog_posts SET author = ?", ['Asifa Rani']);
    $updated = count($posts);
}
?><!doctype html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Blog Author Updater — Homecare Creators Admin</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0a2e1e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
.card{background:#fff;border-radius:16px;padding:36px 40px;max-width:640px;width:100%}
h1{font-size:22px;font-weight:800;color:#0a2e1e;margin-bottom:8px}
p{font-size:14px;color:#6b7280;margin-bottom:16px;line-height:1.75}
strong{color:#0a2e1e}
.log{background:#f3f4f6;border-radius:10px;padding:16px 20px;max-height:360px;overflow-y:auto;font-size:12px;font-family:monospace;line-height:2}
.log div{color:#1a5c3a}
.btn{display:inline-block;padding:13px 28px;background:#1d9e75;color:#fff;border-radius:9px;text-decoration:none;font-weight:700;font-size:15px;margin-top:16px;margin-right:8px}
.btn-outline{background:#fff;color:#1d9e75;border:2px solid #1d9e75}
.warn{background:#fff1f2;border:2px solid #fca5a5;border-radius:10px;padding:14px 18px;margin-top:20px;color:#7f1d1d;font-size:13px;line-height:1.9}
.count{font-size:34px;font-weight:900;color:#1d9e75;display:block;margin-bottom:4px}
code{background:#f3f4f6;padding:2px 7px;border-radius:4px;font-size:11.5px;word-break:break-all}
</style></head><body>
<div class="card">
<h1>Blog Author Updater</h1>
<?php if (!$run): ?>
<p>Sets <strong>author = "Asifa Rani"</strong> on all <strong><?= count($posts) ?> blog post(s)</strong> currently in <code>hc_blog_posts</code>. The public blog template already displays "Asifa Rani" regardless of this field, but running this keeps the underlying data (RSS feeds, admin listings, exports) consistent.</p>
<div class="log">
  <?php foreach ($posts as $p): ?><div><?= htmlspecialchars($p['title']) ?> — currently: <?= htmlspecialchars($p['author'] ?: '(empty)') ?></div><?php endforeach ?>
</div>
<a href="?run=1" class="btn">&#9654; Update All to "Asifa Rani"</a>
<a href="/admin/blog/" class="btn btn-outline">View Blog Manager</a>
<?php else: ?>
<span class="count"><?= $updated ?></span>
<p><strong><?= $updated ?> post(s)</strong> updated to author "Asifa Rani".</p>
<div class="warn">
  <strong>Security: delete this file after running.</strong>
</div>
<a href="/admin/blog/" class="btn" style="margin-top:20px">View Blog Manager &#8594;</a>
<?php endif ?>
</div>
</body></html>
