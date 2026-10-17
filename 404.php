<?php
http_response_code(404);
$page_title = "Page Not Found | Homecare Creators";
$page_desc = "The page you're looking for doesn't exist or has moved.";
$page_canonical = "https://homecarecreators.com/404.php";
$og_title = "Page Not Found | Homecare Creators";
$og_desc = "The page you're looking for doesn't exist or has moved.";

$page_css = <<<CSS
/* HERO */
.hero{min-height:72vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 80px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 50% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:640px;margin:0 auto;text-align:center}
.error-code{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(70px,12vw,140px);font-weight:800;line-height:1;color:var(--teal);margin-bottom:8px}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(26px,3.6vw,40px);line-height:1.2;color:#fff;margin-bottom:16px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:17px;line-height:1.75;color:rgba(255,255,255,.65);margin-bottom:36px}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;justify-content:center;margin-bottom:40px}
.quick-links{display:flex;gap:10px;flex-wrap:wrap;justify-content:center}
.quick-links a{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:rgba(255,255,255,.55);text-decoration:none;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.1);padding:9px 16px;border-radius:100px;transition:.2s}
.quick-links a:hover{color:#fff;border-color:rgba(29,158,117,.4);background:rgba(29,158,117,.12)}

@media(max-width:640px){
  .hero{padding:120px 24px 60px;min-height:80vh}
}
CSS;
include 'includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="error-code">404</div>
    <div class="hero-badge"><i class="fa-solid fa-triangle-exclamation" style="margin-right:6px"></i>Page Not Found</div>
    <h1 class="hero-h1">This Page Took a <em>Wrong Turn.</em></h1>
    <p class="hero-desc">The page you're looking for doesn't exist, was moved, or the link may be outdated. Let's get you back on track.</p>
    <div class="hero-actions">
      <a href="/" class="btn-primary"><i class="fa-solid fa-house"></i>Back to Homepage</a>
      <a href="/sitemap/" class="btn-secondary"><i class="fa-solid fa-sitemap"></i>Browse the Sitemap</a>
    </div>
    <div class="quick-links">
      <a href="/seo/home-care-seo/">Home Care SEO</a>
      <a href="/web-design/homecare-website-design/">Website Design</a>
      <a href="/case-studies/">Case Studies</a>
      <a href="/blog">Blog</a>
      <a href="/contact/">Contact Us</a>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
