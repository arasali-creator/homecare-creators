<?php
$slug = trim($_GET['slug'] ?? '');
$post = null;
$related = [];

try {
    require_once '../admin/config.php';
    require_once '../admin/includes/db.php';
    if ($slug) $post = hc_one("SELECT * FROM hc_blog_posts WHERE slug=? AND status='published'", [$slug]);
    if ($post) $related = hc_all("SELECT id,title,slug,excerpt,featured_image,published_at FROM hc_blog_posts WHERE status='published' AND id != ? ORDER BY published_at DESC LIMIT 3", [$post['id']]);
} catch(Exception $e){}

if (!$post) { http_response_code(404); header('Location: /blog'); exit; }

// Reading time estimate (~200 words/min)
$word_count   = str_word_count(strip_tags($post['content'] ?? ''));
$reading_time = max(1, round($word_count / 200));

$page_title    = $post['meta_title'] ?: ($post['title'] . ' | Homecare Creators Blog');
$page_desc     = $post['meta_desc'] ?: ($post['excerpt'] ?? '');
$page_canonical = "https://homecarecreators.com/blog/" . $post['slug'];
$og_title      = $post['title'];
$og_desc       = $page_desc;

$page_css = <<<CSS
/* ── POST LAYOUT ── */
.post-wrap{background:#fff;min-height:100vh}
.post-hero{position:relative;background:var(--forest);min-height:480px;display:flex;align-items:flex-end;overflow:hidden}
.post-hero-bg{position:absolute;inset:0;background-size:cover;background-position:center;opacity:.3}
.post-hero-overlay{position:absolute;inset:0;background:linear-gradient(to top,rgba(10,46,30,1) 0%,rgba(10,46,30,.6) 60%,rgba(10,46,30,.2) 100%)}
.post-hero-content{position:relative;z-index:2;padding:80px 48px 56px;max-width:900px;width:100%;margin:0 auto;text-align:center}
.post-breadcrumb{display:flex;align-items:center;gap:6px;font-family:'Syne',sans-serif;font-size:12px;color:rgba(255,255,255,.45);margin-bottom:20px;text-decoration:none}
.post-breadcrumb a{color:rgba(255,255,255,.45);text-decoration:none}
.post-breadcrumb a:hover{color:rgba(255,255,255,.8)}
.post-breadcrumb span{opacity:.4}
.post-kw{font-family:'Syne',sans-serif;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--teal);background:rgba(29,158,117,.15);padding:5px 12px;border-radius:20px;display:inline-block;margin-bottom:16px}
.post-hero h1{font-family:'Instrument Serif',serif;font-size:clamp(28px,4vw,52px);color:#fff;line-height:1.18;margin-bottom:20px;max-width:800px}
.post-meta-row{display:flex;align-items:center;gap:20px;flex-wrap:wrap;justify-content:center}
.post-avatar{width:38px;height:38px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--forest));display:flex;align-items:center;justify-content:center;flex-shrink:0}
.post-avatar span{color:#fff;font-family:'Syne',sans-serif;font-size:13px;font-weight:700}
.post-author-info{display:flex;flex-direction:column}
.post-author-name{font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:#fff}
.post-author-meta{font-size:12px;color:rgba(255,255,255,.4)}
.post-sep{width:1px;height:24px;background:rgba(255,255,255,.15)}
.post-reading{font-size:12px;color:rgba(255,255,255,.45);font-family:'Syne',sans-serif}

/* ── TWO-COLUMN LAYOUT ── */
.post-body-wrap{max-width:1160px;margin:0 auto;padding:60px 48px;display:grid;grid-template-columns:1fr 320px;gap:60px;align-items:start}
.post-article{}
.post-article h2{font-family:'Instrument Serif',serif;font-size:clamp(22px,2.8vw,34px);font-weight:600;color:var(--forest);margin:52px 0 16px;line-height:1.25}
.post-article h3{font-family:'Instrument Serif',serif;font-size:clamp(19px,2.2vw,26px);font-weight:400;color:var(--forest);margin:36px 0 12px;line-height:1.3}
.post-article p{font-size:16px;line-height:1.88;color:#374151;margin-bottom:22px}
.post-article ul,.post-article ol{margin:0 0 22px 22px;display:flex;flex-direction:column;gap:10px}
.post-article li{font-size:16px;line-height:1.7;color:#374151}
.post-article strong{color:var(--forest);font-weight:700}
.post-article a{color:var(--teal);text-decoration:none;border-bottom:1px solid rgba(29,158,117,.3)}
.post-article a:hover{border-bottom-color:var(--teal)}
.post-article blockquote{border-left:4px solid var(--teal);padding:18px 24px;margin:28px 0;background:rgba(29,158,117,.05);border-radius:0 10px 10px 0;font-style:italic;font-size:17px;color:var(--forest);line-height:1.7}
.post-article img{max-width:100%;border-radius:var(--r);margin:24px 0;display:block;border:1px solid var(--border)}

/* ── IN-CONTENT CTA ── */
.inline-cta{background:linear-gradient(135deg,var(--forest) 0%,#0f3d28 100%);border-radius:14px;padding:28px 32px;margin:40px 0;display:flex;align-items:center;gap:24px}
.inline-cta-text h4{font-family:'Syne',sans-serif;font-size:16px;font-weight:800;color:#fff;margin-bottom:5px}
.inline-cta-text p{font-size:13px;color:rgba(255,255,255,.55);margin:0}
.inline-cta-btn{flex-shrink:0;background:var(--teal);color:#fff;border:none;padding:12px 22px;border-radius:50px;font-family:'Syne',sans-serif;font-size:13px;font-weight:700;cursor:pointer;white-space:nowrap;transition:.2s}
.inline-cta-btn:hover{background:#178a64;transform:translateY(-2px)}

/* ── SIDEBAR ── */
.post-sidebar{position:sticky;top:90px;display:flex;flex-direction:column;gap:20px}
.sidebar-cta-card{background:var(--forest);border-radius:16px;padding:28px;text-align:center}
.sidebar-cta-card .sc-icon{width:52px;height:52px;background:rgba(29,158,117,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
.sidebar-cta-card .sc-icon svg{width:24px;height:24px;color:var(--teal);stroke:var(--teal)}
.sidebar-cta-card h3{font-size:16px;font-weight:600;color:#fff;margin-bottom:8px;line-height:1.3}
.sidebar-cta-card p{font-size:12.5px;color:rgba(255,255,255,.5);margin-bottom:20px;line-height:1.6}
.sidebar-cta-btn{display:block;background:var(--teal);color:#fff;border:none;padding:13px 20px;border-radius:50px;font-family:'Syne',sans-serif;font-size:13px;font-weight:700;cursor:pointer;width:100%;transition:.2s;text-align:center}
.sidebar-cta-btn:hover{background:#178a64;transform:translateY(-2px)}
.sidebar-card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:22px}
.sidebar-card-title{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);margin-bottom:14px}
.toc-list{list-style:none;padding:0;margin:0;display:flex;flex-direction:column;gap:8px}
.toc-list li a{font-size:13px;color:var(--muted);text-decoration:none;line-height:1.4;border-left:2px solid var(--border);padding-left:10px;display:block;transition:.15s}
.toc-list li a:hover{color:var(--teal);border-left-color:var(--teal)}
.author-card{display:flex;flex-direction:column;align-items:center;text-align:center;gap:10px}
.author-avatar-lg{width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--forest));display:flex;align-items:center;justify-content:center}
.author-avatar-lg span{color:#fff;font-family:'Syne',sans-serif;font-size:20px;font-weight:700}
.author-name{font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:var(--forest)}
.author-title{font-size:12px;color:var(--muted)}
.author-bio{font-size:12.5px;color:var(--muted);line-height:1.65;text-align:left}

/* ── RELATED POSTS ── */
.related-section{background:var(--cream);padding:64px 48px}
.related-inner{max-width:1160px;margin:0 auto}
.related-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:32px}
.related-card{background:#fff;border:1px solid var(--border);border-radius:14px;overflow:hidden;transition:.2s;text-decoration:none;display:block}
.related-card:hover{transform:translateY(-3px);box-shadow:0 10px 30px rgba(10,46,30,.1)}
.related-card-img{width:100%;height:160px;object-fit:cover;background:var(--forest)}
.related-card-body{padding:18px}
.related-card-title{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--forest);line-height:1.35;margin-bottom:6px}
.related-card-date{font-size:12px;color:var(--muted)}

/* ── BOTTOM CTA ── */
.post-bottom-cta{background:var(--forest);padding:80px 48px;text-align:center;position:relative;overflow:hidden}
.post-bottom-cta::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px}
.post-bottom-cta-inner{position:relative;z-index:1;max-width:640px;margin:0 auto}
.post-bottom-cta .eyebrow{font-family:'Syne',sans-serif;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--teal);margin-bottom:16px}
.post-bottom-cta h2{font-family:'Instrument Serif',serif;font-size:clamp(28px,4vw,46px);color:#fff;margin-bottom:14px;line-height:1.2}
.post-bottom-cta p{font-size:16px;color:rgba(255,255,255,.55);margin-bottom:32px;line-height:1.7}
.post-bottom-cta-btns{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}
.btn-cta-primary{background:var(--teal);color:#fff;border:none;padding:16px 32px;border-radius:50px;font-family:'Syne',sans-serif;font-size:15px;font-weight:700;cursor:pointer;transition:.2s;text-decoration:none}
.btn-cta-primary:hover{background:#178a64;transform:translateY(-2px);box-shadow:0 8px 28px rgba(29,158,117,.4)}
.btn-cta-ghost{background:transparent;color:rgba(255,255,255,.7);border:1.5px solid rgba(255,255,255,.2);padding:15px 28px;border-radius:50px;font-family:'Syne',sans-serif;font-size:15px;font-weight:600;cursor:pointer;transition:.2s;text-decoration:none}
.btn-cta-ghost:hover{color:#fff;border-color:rgba(255,255,255,.5)}
.trust-row{display:flex;align-items:center;justify-content:center;gap:24px;margin-top:24px;flex-wrap:wrap}
.trust-item{display:flex;align-items:center;gap:6px;font-size:12.5px;color:rgba(255,255,255,.4);font-family:'Syne',sans-serif}
.trust-item svg{width:14px;height:14px;stroke:var(--teal);opacity:.8}

/* ── RESPONSIVE ── */
@media(max-width:960px){
  .post-body-wrap{grid-template-columns:1fr;gap:40px}
  .post-sidebar{position:static}
  .related-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:640px){
  .post-hero-content{padding:80px 24px 40px}
  .post-body-wrap{padding:40px 20px}
  .related-section,.post-bottom-cta{padding:56px 20px}
  .inline-cta{flex-direction:column;text-align:center;gap:16px}
  .related-grid{grid-template-columns:1fr}
}
CSS;

include '../includes/header.php';

// Extract H2 headings for table of contents
preg_match_all('/<h2[^>]*>(.*?)<\/h2>/i', $post['content'] ?? '', $headings);
$toc = $headings[1] ?? [];
?>

<div class="post-wrap">

<!-- HERO -->
<div class="post-hero">
  <?php if ($post['featured_image']): ?>
  <div class="post-hero-bg" style="background-image:url('<?= htmlspecialchars($post['featured_image']) ?>')"></div>
  <?php endif ?>
  <div class="post-hero-overlay"></div>
  <div class="post-hero-content">
    <div class="post-breadcrumb">
      <a href="/">Home</a><span>›</span><a href="/blog">Blog</a><span>›</span><span style="color:rgba(255,255,255,.65)"><?= htmlspecialchars($post['title']) ?></span>
    </div>
    <?php if ($post['focus_keyword']): ?>
    <div class="post-kw"><?= htmlspecialchars($post['focus_keyword']) ?></div>
    <?php endif ?>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <div class="post-meta-row">
      <div class="post-avatar"><span><?= strtoupper(substr($post['author'],0,1)) ?></span></div>
      <div class="post-author-info">
        <span class="post-author-name"><?= htmlspecialchars($post['author']) ?></span>
        <span class="post-author-meta">Homecare Marketing Expert</span>
      </div>
      <div class="post-sep"></div>
      <span class="post-reading"><?= date('M j, Y', strtotime($post['published_at'] ?? $post['created_at'])) ?></span>
      <div class="post-sep"></div>
      <span class="post-reading"><?= $reading_time ?> min read</span>
    </div>
  </div>
</div>

<!-- BODY -->
<div class="post-body-wrap">

  <!-- ARTICLE -->
  <article class="post-article">

    <?php if ($post['excerpt']): ?>
    <p style="font-size:18px;line-height:1.75;color:var(--forest);font-weight:400;margin-bottom:32px;padding-bottom:28px;border-bottom:2px solid var(--border)">
      <?= htmlspecialchars($post['excerpt']) ?>
    </p>
    <?php endif ?>

    <?= $post['content'] ?>

    <!-- IN-CONTENT CTA (appended after content) -->
    <div class="inline-cta">
      <div class="inline-cta-text">
        <h4>Ready to dominate local search in your Florida market?</h4>
        <p>Get a free SEO audit — we'll show you exactly where you're losing clients to competitors.</p>
      </div>
      <button class="inline-cta-btn" onclick="openPopup('audit')">Get Free Audit</button>
    </div>

  </article>

  <!-- SIDEBAR -->
  <aside class="post-sidebar">

    <!-- Primary CTA -->
    <div class="sidebar-cta-card">
      <div class="sc-icon">
        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      </div>
      <h3>Get Your Free Homecare SEO Audit</h3>
      <p>See where your agency ranks vs. competitors in your city. Takes 48 hours. No commitment.</p>
      <button class="sidebar-cta-btn" onclick="openPopup('audit')">
        Request Free Audit →
      </button>
    </div>

    <!-- Table of Contents -->
    <?php if (count($toc) > 1): ?>
    <div class="sidebar-card">
      <div class="sidebar-card-title">In This Article</div>
      <ul class="toc-list">
        <?php foreach ($toc as $h): ?>
        <li><a href="#<?= h(strtolower(preg_replace('/[^a-z0-9]+/i','-',strip_tags($h)))) ?>"><?= strip_tags($h) ?></a></li>
        <?php endforeach ?>
      </ul>
    </div>
    <?php endif ?>

    <!-- Mini CTA 2 -->
    <div class="sidebar-card" style="background:rgba(29,158,117,.05);border-color:rgba(29,158,117,.2)">
      <div style="font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:var(--forest);margin-bottom:8px">Struggling to get new clients?</div>
      <p style="font-size:12.5px;color:var(--muted);margin-bottom:14px;line-height:1.65">See the exact SEO strategy we use to rank homecare agencies on page 1 in Florida.</p>
      <button onclick="openPopup('starter')" style="background:var(--teal);color:#fff;border:none;padding:10px 18px;border-radius:50px;font-family:'Syne',sans-serif;font-size:13px;font-weight:700;cursor:pointer;width:100%;transition:.2s">View Our Packages</button>
    </div>

  </aside>
</div>

</div><!-- /post-wrap -->

<!-- RELATED POSTS -->
<?php if ($related): ?>
<div class="related-section">
  <div class="related-inner">
    <div style="font-family:'Syne',sans-serif;font-size:10px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--teal);margin-bottom:10px">Keep Reading</div>
    <div style="font-family:'Instrument Serif',serif;font-size:clamp(24px,3vw,36px);color:var(--forest)">More Homecare Marketing Insights</div>
    <div class="related-grid">
      <?php foreach ($related as $r): ?>
      <a href="/blog/<?= htmlspecialchars($r['slug']) ?>" class="related-card">
        <?php if ($r['featured_image']): ?>
        <img class="related-card-img" src="<?= htmlspecialchars($r['featured_image']) ?>" alt="<?= htmlspecialchars($r['title']) ?>" title="<?= htmlspecialchars($r['title']) ?>" loading="lazy">
        <?php else: ?>
        <div class="related-card-img" style="background:linear-gradient(135deg,var(--forest),var(--teal));display:flex;align-items:center;justify-content:center">
          <span style="font-family:'Instrument Serif',serif;color:rgba(255,255,255,.2);font-size:36px">HC</span>
        </div>
        <?php endif ?>
        <div class="related-card-body">
          <div class="related-card-title"><?= htmlspecialchars($r['title']) ?></div>
          <div class="related-card-date"><?= date('M j, Y', strtotime($r['published_at'] ?? '')) ?></div>
        </div>
      </a>
      <?php endforeach ?>
    </div>
  </div>
</div>
<?php endif ?>

<!-- BOTTOM CTA -->
<div class="post-bottom-cta">
  <div class="post-bottom-cta-inner">
    <div class="eyebrow">Ready to Grow?</div>
    <h2>Let's Get Your Homecare Agency to Page 1</h2>
    <p>We build and rank homecare websites across Florida — Miami, Tampa, Orlando, Jacksonville and beyond. Free SEO audit, no strings attached.</p>
    <div class="post-bottom-cta-btns">
      <button class="btn-cta-primary" onclick="openPopup('audit')">Get My Free SEO Audit</button>
      <button class="btn-cta-ghost" onclick="openPopup('scale')">View Packages</button>
    </div>
    <div class="trust-row">
      <span class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>Florida homecare specialists</span>
      <span class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>Results in 90 days</span>
      <span class="trust-item"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="20 6 9 17 4 12"/></svg>No long-term contracts</span>
    </div>
  </div>
</div>

<?php include '../includes/footer.php'; ?>
