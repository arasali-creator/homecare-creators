<?php
$page_title = "Products for Home Care Agencies — CareOS, CareMails, Care Scheduling | Homecare Creators";
$page_desc = "Purpose-built software for home care agency owners: CareOS (full platform), CareMails (team email), and Care Scheduling — each built for home care, not retrofitted for it.";
$page_canonical = "https://homecarecreators.com/products/";
$og_title = "Products for Home Care Agencies | Homecare Creators";
$og_desc = "CareOS, CareMails, and Care Scheduling — software built specifically for home care agency owners.";

$page_css = <<<CSS
/* HERO */
.hero{min-height:36vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 60px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:760px;margin:0 auto;text-align:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(28px,4.2vw,46px);line-height:1.15;color:#fff;margin-bottom:14px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:17px;line-height:1.7;color:rgba(255,255,255,.65)}

/* PRODUCTS GRID */
.products-section{background:var(--cream)}
.products-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px;margin-top:48px}
.product-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px;display:flex;flex-direction:column;transition:.25s;text-decoration:none}
.product-card:hover{transform:translateY(-4px);box-shadow:0 20px 56px rgba(10,46,30,.1);border-color:rgba(29,158,117,.25)}
.product-card-icon{width:52px;height:52px;border-radius:14px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:20px}
.product-card-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(201,168,76,.12);color:#8a6800;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;padding:4px 10px;border-radius:20px;align-self:flex-start;margin-bottom:14px}
.product-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:700;color:var(--forest);margin-bottom:10px}
.product-card p{font-size:14.5px;color:var(--muted);line-height:1.65;flex:1;margin-bottom:20px}
.product-card-cta{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--teal)}

@media(max-width:960px){.products-grid{grid-template-columns:1fr}}
@media(max-width:640px){.hero{padding:120px 24px 46px}}
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-badge"><i class="fa-solid fa-layer-group" style="margin-right:6px"></i>Products</div>
    <h1 class="hero-h1">Software Built for <em>Home Care</em>,<br>Not Retrofitted for It</h1>
    <p class="hero-desc">We build marketing AND the tools agency owners actually run their business on. Start with one piece or get the full platform.</p>
  </div>
</section>

<!-- PRODUCTS -->
<section class="products-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Our Products</p>
      <h2 class="section-h2">Three Tools. <em>One Mission.</em></h2>
    </div>
    <div class="products-grid" data-reveal style="transition-delay:.1s">

      <a href="/careos/" class="product-card">
        <div class="product-card-badge"><i class="fa-solid fa-circle-dot"></i> Coming Q3 2026</div>
        <div class="product-card-icon"><i class="fa-solid fa-brain"></i></div>
        <h3>CareOS</h3>
        <p>The full AI-powered management platform — scheduling, billing, EVV compliance, family portals, and predictive intelligence in one login.</p>
        <div class="product-card-cta">Explore CareOS &rarr;</div>
      </a>

      <a href="/products/caremails/" class="product-card">
        <div class="product-card-badge"><i class="fa-solid fa-circle-dot"></i> Coming Soon</div>
        <div class="product-card-icon"><i class="fa-solid fa-envelope-open-text"></i></div>
        <h3>CareMails</h3>
        <p>An all-in-one email system built for homecare teams — one shared inbox for family communication and staff coordination instead of scattered personal inboxes.</p>
        <div class="product-card-cta">Explore CareMails &rarr;</div>
      </a>

      <a href="/products/care-scheduling/" class="product-card">
        <div class="product-card-badge"><i class="fa-solid fa-circle-dot"></i> Coming Soon</div>
        <div class="product-card-icon"><i class="fa-solid fa-calendar-check"></i></div>
        <h3>Care Scheduling</h3>
        <p>Shift scheduling built for home care — caregiver-to-client matching, conflict alerts, mobile clock-in/out, and family visibility into the schedule.</p>
        <div class="product-card-cta">Explore Care Scheduling &rarr;</div>
      </a>

    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
