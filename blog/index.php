<?php
$page_title    = "Homecare Agency Marketing Blog | Homecare Creators";
$page_desc     = "Expert marketing insights, SEO tips, and growth strategies exclusively for homecare agencies in Florida.";
$page_canonical = "https://homecarecreators.com/blog";
$og_title      = "Homecare Marketing Blog | Homecare Creators";
$og_desc       = $page_desc;

$page_css = <<<CSS
.blog-hero{background:var(--forest);padding:120px 48px 72px;text-align:center;position:relative;overflow:hidden}
.blog-hero::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.06) 1px,transparent 1px);background-size:60px 60px}
.blog-hero h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(36px,5vw,56px);color:#fff;position:relative;z-index:1;margin-bottom:12px}
.blog-hero p{font-size:18px;color:rgba(255,255,255,.55);position:relative;z-index:1;font-family:'Plus Jakarta Sans',sans-serif;max-width:500px;margin:0 auto}
.blog-section{padding:80px 48px;background:var(--cream)}
.blog-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px;max-width:1120px;margin:0 auto}
.blog-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);overflow:hidden;transition:.25s;display:flex;flex-direction:column}
.blog-card:hover{transform:translateY(-4px);box-shadow:0 12px 40px rgba(10,46,30,.1)}
.blog-card-img{width:100%;height:200px;object-fit:cover;display:block;background:var(--forest)}
.blog-card-body{padding:24px;flex:1;display:flex;flex-direction:column}
.blog-card-cat{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--teal);margin-bottom:10px}
.blog-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:700;color:var(--forest);line-height:1.35;margin-bottom:10px}
.blog-card-title a{color:inherit;text-decoration:none}
.blog-card-title a:hover{color:var(--teal)}
.blog-card-excerpt{font-size:16px;color:var(--muted);line-height:1.65;flex:1;margin-bottom:16px}
.blog-card-meta{font-size:12px;color:var(--muted);border-top:1px solid var(--border);padding-top:14px;display:flex;align-items:center;justify-content:space-between}
.empty-blog{text-align:center;padding:80px 20px;color:var(--muted)}
@media(max-width:900px){.blog-grid{grid-template-columns:1fr 1fr}}
@media(max-width:600px){.blog-section{padding:60px 20px}.blog-grid{grid-template-columns:1fr}.blog-hero{padding:100px 24px 60px}}
CSS;

include '../includes/header.php';

// Load blog posts from DB
$posts = [];
try {
    require_once '../admin/config.php';
    require_once '../admin/includes/db.php';
    $posts = hc_all("SELECT id,title,slug,excerpt,featured_image,author,focus_keyword,published_at FROM hc_blog_posts WHERE status='published' ORDER BY published_at DESC");
} catch(Exception $e){}
?>

<div class="blog-hero">
  <h1>The Homecare Marketing Blog</h1>
  <p>SEO, local search, and growth strategies — written exclusively for Florida homecare agencies.</p>
</div>

<section class="blog-section">
  <?php if ($posts): ?>
  <div class="blog-grid">
    <?php foreach ($posts as $p): ?>
    <div class="blog-card" data-reveal>
      <?php if ($p['featured_image']): ?>
      <img class="blog-card-img" src="<?= htmlspecialchars($p['featured_image']) ?>" alt="<?= htmlspecialchars($p['title']) ?>" title="<?= htmlspecialchars($p['title']) ?>" loading="lazy">
      <?php else: ?>
      <div class="blog-card-img" style="background:linear-gradient(135deg,var(--forest) 0%,var(--teal) 100%);display:flex;align-items:center;justify-content:center">
        <span style="font-family:'Plus Jakarta Sans',sans-serif;color:rgba(255,255,255,.2);font-size:48px">HC</span>
      </div>
      <?php endif ?>
      <div class="blog-card-body">
        <?php if ($p['focus_keyword']): ?>
        <div class="blog-card-cat"><?= htmlspecialchars($p['focus_keyword']) ?></div>
        <?php endif ?>
        <div class="blog-card-title"><a href="/blog/<?= htmlspecialchars($p['slug']) ?>"><?= htmlspecialchars($p['title']) ?></a></div>
        <div class="blog-card-excerpt"><?= htmlspecialchars($p['excerpt'] ?? '') ?></div>
        <div class="blog-card-meta">
          <span><?= htmlspecialchars($p['author']) ?></span>
          <span><?= date('M j, Y', strtotime($p['published_at'])) ?></span>
        </div>
      </div>
    </div>
    <?php endforeach ?>
  </div>
  <?php else: ?>
  <div class="empty-blog">
    <p style="font-size:18px;font-weight:600;color:var(--forest);margin-bottom:8px">Coming soon.</p>
    <p>Our homecare marketing blog is launching soon. Check back for expert SEO and growth insights.</p>
  </div>
  <?php endif ?>
</section>

<?php include '../includes/footer.php'; ?>
