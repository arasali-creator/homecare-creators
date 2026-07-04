<?php
// ============================================================
//  Page Builder — Public Renderer
//  Renders any page created through Admin > Pages. Reached via
//  /page.php?slug=X directly, or via the clean URL rewrite in
//  .htaccess for any path that isn't a real file (e.g. /about/).
// ============================================================
require_once __DIR__ . '/admin/config.php';
require_once __DIR__ . '/admin/includes/db.php';
require_once __DIR__ . '/admin/includes/functions.php';
require_once __DIR__ . '/admin/includes/blocks.php';

$slug = trim($_GET['slug'] ?? '', '/');
$isPreview = isset($_GET['preview']) && $_GET['preview'] === '1';

if ($slug === '') { header('Location: /'); exit; }

if ($isPreview) {
    require_once __DIR__ . '/admin/includes/auth.php';
    hc_require_auth();
    $page = hc_one("SELECT * FROM hc_pages WHERE slug = ?", [$slug]);
} else {
    $page = hc_one("SELECT * FROM hc_pages WHERE slug = ? AND status = 'published'", [$slug]);
}

if (!$page) {
    http_response_code(404);
    $page_title = 'Page Not Found | Homecare Creators';
    $page_desc  = '';
    include __DIR__ . '/includes/header.php';
    echo '<section style="padding:140px 40px 120px;text-align:center"><p class="section-label" style="justify-content:center">404</p><h1 class="section-h2">This Page Doesn\'t Exist</h1><p class="section-sub" style="margin:16px auto 0">The page you\'re looking for may have been moved or removed.</p><div style="margin-top:32px"><a href="/" class="btn-primary">Back to Homepage</a></div></section>';
    include __DIR__ . '/includes/footer.php';
    exit;
}

$page_title      = $page['meta_title'] ?: $page['title'];
$page_desc       = $page['meta_desc'] ?: '';
$page_canonical  = rtrim(SITE_URL, '/') . '/' . $page['slug'] . '/';
$og_title        = $page_title;
$og_desc         = $page_desc;

$page_css = <<<CSS
/* ── PAGE BUILDER BLOCKS ── */
.pb-hero{background:var(--forest);padding:140px 40px 100px}
.pb-hero-inner{max-width:760px;margin:0 auto;text-align:center}
.pb-hero-inner .section-label{justify-content:center;color:var(--mint)}
.pb-hero-h1{font-family:'Instrument Serif',serif;font-size:clamp(36px,5vw,58px);line-height:1.1;color:#fff;margin-bottom:16px}
.pb-hero-sub{font-family:'Instrument Serif',serif;font-size:22px;color:rgba(255,255,255,.6);margin-bottom:12px}
.pb-hero-desc{font-size:16px;line-height:1.75;color:rgba(255,255,255,.65);max-width:560px;margin:0 auto 32px}
.pb-hero-actions{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}

.pb-text-image{background:#fff}
.pb-text-image-grid{display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center}
.pb-text-image.pb-reverse .pb-text-image-grid{direction:rtl}
.pb-text-image.pb-reverse .pb-text-image-grid > *{direction:ltr}
.pb-text-image-visual img{width:100%;border-radius:var(--r-lg);display:block;box-shadow:0 24px 64px rgba(10,46,30,.14)}
@media(max-width:900px){.pb-text-image-grid{grid-template-columns:1fr}.pb-text-image.pb-reverse .pb-text-image-grid{direction:ltr}}

.pb-feature-grid{background:var(--cream)}
.pb-section-header{max-width:640px;margin:0 auto 48px;text-align:center}
.pb-feature-cards{display:grid;gap:22px}
.pb-feature-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px}
.pb-feature-icon{width:48px;height:48px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:20px;margin-bottom:18px}
.pb-feature-card h3{font-family:'Syne',sans-serif;font-size:17px;color:var(--forest);margin-bottom:8px}
.pb-feature-card p{font-size:14px;line-height:1.7;color:var(--muted)}
@media(max-width:900px){.pb-feature-cards{grid-template-columns:1fr !important}}

.pb-stats{background:var(--forest)}
.pb-stats-row{display:flex;justify-content:center;gap:64px;flex-wrap:wrap;text-align:center}
.pb-stat-num{font-family:'Instrument Serif',serif;font-size:44px;color:var(--teal-lt);line-height:1}
.pb-stat-label{font-family:'Syne',sans-serif;font-size:12px;color:rgba(255,255,255,.5);margin-top:6px}

.pb-testimonials{background:#fff}
.pb-testimonial-grid{display:grid;grid-template-columns:repeat(auto-fit,minmax(300px,1fr));gap:24px}
.pb-testimonial{background:var(--warm);border:1px solid var(--border);border-radius:var(--r-lg);padding:28px}
.pb-testimonial-quote{font-family:'Instrument Serif',serif;font-style:italic;font-size:17px;color:var(--forest);margin-bottom:16px;line-height:1.6}
.pb-testimonial-name{font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:var(--forest)}
.pb-testimonial-role{font-size:12px;color:var(--muted);margin-top:2px}

.pb-faq{background:var(--cream)}

.pb-cta{background:var(--forest)}
.pb-cta-inner{max-width:640px;margin:0 auto;text-align:center}
.pb-cta-inner .section-label{justify-content:center;color:var(--mint)}
.pb-cta-inner .section-h2{color:#fff}
CSS;

$page_js = <<<JS
function toggleFaq(q) {
  var item = q.closest('.faq-item');
  var wasOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(function(i) { i.classList.remove('open'); });
  if (!wasOpen) item.classList.add('open');
}
JS;

include __DIR__ . '/includes/header.php';

if ($isPreview) {
    echo '<div style="background:#c9a84c;color:#0a2e1e;text-align:center;padding:10px;font-family:Syne,sans-serif;font-weight:700;font-size:13px;position:relative;z-index:600">PREVIEW MODE — this page is ' . h($page['status']) . ' and not visible to the public at this URL until published</div>';
}

$blocks = hc_all("SELECT * FROM hc_page_blocks WHERE page_id = ? ORDER BY sort_order ASC", [$page['id']]);
foreach ($blocks as $block) {
    $data = json_decode($block['block_data'], true);
    if (!is_array($data)) $data = [];
    echo hc_render_block($block['block_type'], $data);
}

include __DIR__ . '/includes/footer.php';
