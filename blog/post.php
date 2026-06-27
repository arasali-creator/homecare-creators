<?php
// Load the post from DB
$slug = trim($_GET['slug'] ?? '');
$post = null;

try {
    require_once '../admin/config.php';
    require_once '../admin/includes/db.php';
    if ($slug) $post = hc_one("SELECT * FROM hc_blog_posts WHERE slug=? AND status='published'", [$slug]);
} catch(Exception $e){}

if (!$post) {
    http_response_code(404);
    header('Location: /blog');
    exit;
}

// Build breadcrumb from URL
$segments  = array_filter(explode('/', $post['slug']));
$bread_pos = 1;

$page_title    = $post['meta_title'] ?: ($post['title'] . ' | Homecare Creators Blog');
$page_desc     = $post['meta_desc'] ?: ($post['excerpt'] ?? '');
$page_canonical = "https://homecarecreators.com/blog/post?slug=" . urlencode($post['slug']);
$og_title      = $post['title'];
$og_desc       = $page_desc;

$page_css = <<<CSS
.post-hero{background:var(--forest);padding:120px 48px 72px;position:relative;overflow:hidden}
.post-hero::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.06) 1px,transparent 1px);background-size:60px 60px}
.post-hero-inner{max-width:760px;margin:0 auto;position:relative;z-index:1}
.post-cat{font-family:'Syne',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--teal);margin-bottom:14px;display:block}
.post-hero h1{font-family:'Instrument Serif',serif;font-size:clamp(30px,4.5vw,50px);color:#fff;line-height:1.2;margin-bottom:18px}
.post-meta{font-size:13px;color:rgba(255,255,255,.5);font-family:'Syne',sans-serif;display:flex;gap:16px;flex-wrap:wrap}
.post-body{padding:64px 48px;max-width:760px;margin:0 auto}
.post-body h2{font-family:'Syne',sans-serif;font-size:22px;font-weight:800;color:var(--forest);margin:40px 0 14px}
.post-body h3{font-family:'Syne',sans-serif;font-size:18px;font-weight:700;color:var(--forest);margin:30px 0 10px}
.post-body p{font-size:16px;line-height:1.85;color:var(--muted);margin-bottom:20px}
.post-body ul,.post-body ol{margin:0 0 20px 24px;display:flex;flex-direction:column;gap:8px}
.post-body li{font-size:16px;line-height:1.7;color:var(--muted)}
.post-body strong{color:var(--forest)}
.post-body a{color:var(--teal)}
.post-body img{max-width:100%;border-radius:var(--r);margin:20px 0}
.post-body blockquote{border-left:4px solid var(--teal);padding:16px 20px;margin:20px 0;background:rgba(29,158,117,.05);border-radius:0 8px 8px 0;font-style:italic;color:var(--forest)}
.post-featured{width:100%;height:360px;object-fit:cover;border-radius:var(--r);margin-bottom:40px;display:block;border:1px solid var(--border)}
.back-link{display:inline-flex;align-items:center;gap:6px;font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:rgba(255,255,255,.55);text-decoration:none;margin-bottom:20px;position:relative;z-index:1}
.back-link:hover{color:#fff}
.post-cta{background:var(--forest);border-radius:var(--r);padding:40px;margin-top:48px;text-align:center}
.post-cta h3{font-family:'Syne',sans-serif;font-size:20px;font-weight:800;color:#fff;margin-bottom:10px}
.post-cta p{color:rgba(255,255,255,.6);font-size:14px;margin-bottom:20px}
@media(max-width:640px){.post-hero{padding:100px 24px 60px}.post-body{padding:48px 20px}}
CSS;

include '../includes/header.php';
?>

<div class="post-hero">
  <div class="post-hero-inner">
    <a href="/blog" class="back-link">← Back to Blog</a>
    <?php if ($post['focus_keyword']): ?>
    <span class="post-cat"><?= htmlspecialchars($post['focus_keyword']) ?></span>
    <?php endif ?>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <div class="post-meta">
      <span>By <?= htmlspecialchars($post['author']) ?></span>
      <span><?= date('F j, Y', strtotime($post['published_at'] ?? $post['created_at'])) ?></span>
    </div>
  </div>
</div>

<div class="post-body">
  <?php if ($post['featured_image']): ?>
  <img class="post-featured" src="<?= htmlspecialchars($post['featured_image']) ?>" alt="<?= htmlspecialchars($post['title']) ?>" loading="eager">
  <?php endif ?>

  <?= $post['content'] ?>

  <div class="post-cta">
    <h3>Ready to grow your homecare agency in Florida?</h3>
    <p>Homecare Creators is the only marketing agency built exclusively for homecare businesses.</p>
    <button onclick="openPopup('audit')" style="background:var(--teal);color:#fff;border:none;padding:14px 28px;border-radius:50px;font-family:'Syne',sans-serif;font-size:14px;font-weight:700;cursor:pointer;transition:.2s">Get a Free SEO Audit →</button>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
