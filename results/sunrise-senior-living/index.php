<?php
// Standalone case-study landing page. No header/footer include on purpose —
// this is a link sent directly to a prospect/client via email, not a page
// that should appear in nav, the footer, or search results.
$page_title = "Sunrise Senior Living Case Study | Homecare Creators";
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="robots" content="noindex, nofollow">
<title><?= htmlspecialchars($page_title) ?></title>
<link rel="icon" href="/favicon.ico?v=3" sizes="any">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,600&family=DM+Sans:ital,opsz,wght@0,9..40,400;0,9..40,500;1,9..40,400&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
:root{--forest:#0a2e1e;--forest-lt:#1a5c3a;--teal:#1d9e75;--teal-lt:#2ec68f;--mint:#9fe1cb;--cream:#f5f2ec;--warm:#fffdf8;--gold:#c9a84c;--gold-lt:#e8c96a;--text:#1a1a14;--muted:#6b7b6e;--border:rgba(26,92,58,0.15)}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'DM Sans',sans-serif;background:var(--warm);color:var(--text);overflow-x:hidden}
.container{max-width:1080px;margin:0 auto;padding:0 24px}
h1,h2,h3{font-family:'Plus Jakarta Sans',sans-serif}

/* TOP BAR — logo only, no nav */
.topbar{padding:28px 0;text-align:center;background:var(--forest)}
.topbar img{height:34px;width:auto}

/* HERO */
.hero{background:var(--forest);position:relative;overflow:hidden;padding:64px 24px 88px}
.hero::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.07) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.07) 1px,transparent 1px);background-size:56px 56px;mask-image:radial-gradient(ellipse 80% 80% at 50% 30%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:1;max-width:760px;margin:0 auto;text-align:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.14);border:1px solid rgba(29,158,117,.3);padding:8px 18px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:1px;text-transform:uppercase;margin-bottom:24px}
.hero-dot{width:7px;height:7px;border-radius:50%;background:var(--teal-lt)}
.hero h1{font-size:clamp(30px,4.6vw,48px);font-weight:800;color:#fff;line-height:1.15;margin-bottom:16px}
.hero h1 em{font-style:italic;color:var(--teal-lt)}
.hero-sub{font-size:17px;line-height:1.7;color:rgba(255,255,255,.65);max-width:580px;margin:0 auto}
.hero-range{margin-top:22px;display:inline-flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:rgba(255,255,255,.45)}

/* SEO HIGHLIGHT BANNER */
.seo-banner{background:var(--cream);padding:40px 24px 8px}
.seo-banner-inner{max-width:820px;margin:0 auto;background:#fff;border-radius:24px;padding:36px 40px;display:flex;align-items:center;gap:32px;box-shadow:0 14px 36px rgba(10,46,30,.1);position:relative;overflow:hidden}
.seo-banner-inner::before{content:'';position:absolute;left:0;top:0;bottom:0;width:6px;background:linear-gradient(180deg,var(--gold),var(--gold-lt))}
.seo-banner-figure{flex-shrink:0;text-align:center}
.seo-banner-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(46px,6vw,64px);color:var(--gold);line-height:1}
.seo-banner-figure-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-top:4px}
.seo-banner-divider{width:1px;align-self:stretch;background:var(--border);flex-shrink:0}
.seo-banner-text{font-size:16.5px;line-height:1.65;color:var(--text)}
.seo-banner-text strong{color:var(--forest)}

/* SCREENSHOT */
.screenshot-frame{max-width:900px;margin:0 auto;border-radius:18px;overflow:hidden;border:1px solid var(--border);box-shadow:0 24px 70px rgba(10,46,30,.15)}
.screenshot-bar{background:var(--forest);padding:12px 16px;display:flex;align-items:center;gap:8px}
.screenshot-dot{width:10px;height:10px;border-radius:50%}
.screenshot-frame img{width:100%;display:block}
.screenshot-caption{text-align:center;font-size:13px;color:var(--muted);margin-top:16px}

/* INDUSTRIES */
.industries-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;max-width:900px;margin:0 auto}
.industry-card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px 18px;display:flex;align-items:center;gap:12px}
.industry-icon{width:36px;height:36px;border-radius:9px;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:15px;flex-shrink:0}
.industry-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--forest)}

/* BIG STATS */
.stats-wrap{position:relative;z-index:1;margin-top:-56px;padding:0 24px 0}
.stats-grid{max-width:1000px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.stat-card{background:#fff;border-radius:20px;padding:30px 24px;text-align:center;box-shadow:0 10px 28px rgba(10,46,30,.1);border:1px solid var(--border)}
.stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(26px,3vw,34px);color:var(--forest);line-height:1}
.stat-num.accent{color:var(--teal)}
.stat-label{font-size:12.5px;color:var(--muted);font-weight:600;margin-top:8px}

/* SECTIONS */
section{padding:88px 24px}
.section-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--teal);margin-bottom:12px;display:flex;align-items:center;gap:8px;justify-content:center}
.section-label::before{content:'';width:22px;height:2px;background:var(--teal);border-radius:2px}
.section-h2{font-size:clamp(26px,3.4vw,38px);font-weight:800;color:var(--forest);text-align:center;margin-bottom:12px}
.section-sub{font-size:16px;color:var(--muted);text-align:center;max-width:560px;margin:0 auto 48px}

/* BREAKDOWN BARS */
.breakdown-section{background:var(--cream)}
.breakdown-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:900px;margin:0 auto}
.breakdown-card{background:#fff;border:1px solid var(--border);border-radius:20px;padding:28px}
.breakdown-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest);text-transform:uppercase;letter-spacing:.5px;margin-bottom:20px}
.bar-row{margin-bottom:16px}
.bar-row:last-child{margin-bottom:0}
.bar-head{display:flex;justify-content:space-between;align-items:baseline;margin-bottom:6px;font-family:'Plus Jakarta Sans',sans-serif}
.bar-name{font-size:14px;font-weight:600;color:var(--text)}
.bar-num{font-size:14px;font-weight:800;color:var(--forest)}
.bar-track{height:10px;background:var(--cream);border-radius:6px;overflow:hidden}
.bar-fill{height:100%;background:linear-gradient(90deg,var(--teal),var(--teal-lt));border-radius:6px}
.bar-fill.gold{background:linear-gradient(90deg,var(--gold),var(--gold-lt))}
.bar-fill.muted{background:var(--border)}

/* INSIGHT STRIP */
.insight-section{background:var(--cream)}
.insight-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;max-width:900px;margin:0 auto}
.insight-card{background:#fff;border:1px solid var(--border);border-radius:20px;padding:32px;text-align:center}
.insight-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:40px;color:var(--teal)}
.insight-label{font-size:14.5px;color:var(--muted);margin-top:8px;line-height:1.5}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:96px 24px}
.cta-inner{max-width:900px;margin:0 auto;display:grid;grid-template-columns:1.1fr .9fr;gap:56px;align-items:center}
.cta-content .section-label{justify-content:flex-start;color:var(--teal-lt)}
.cta-content .section-label::before{background:var(--teal-lt)}
.cta-content h2{font-size:clamp(26px,3.2vw,36px);font-weight:800;color:#fff;line-height:1.2;margin-bottom:16px;text-align:left}
.cta-content p{font-size:16px;line-height:1.75;color:rgba(255,255,255,.65);margin-bottom:28px}
.cta-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;color:var(--forest);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;padding:16px 30px;border-radius:100px;border:none;text-decoration:none;cursor:pointer;transition:.2s}
.cta-btn:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(0,0,0,.3)}
.cta-trust{margin-top:20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.4);display:flex;align-items:center;gap:8px}
.cta-trust i{color:var(--teal-lt)}
.cta-photo{border-radius:20px;overflow:hidden;aspect-ratio:4/4.6;box-shadow:0 24px 70px rgba(0,0,0,.35)}
.cta-photo img{width:100%;height:100%;object-fit:cover;display:block}

.endnote{text-align:center;padding:28px 24px;font-size:12px;color:var(--muted);background:var(--warm)}

/* POPUP / FORM (matches the main site's booking popup) */
.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
.hp-field{position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden}
.popup-overlay{display:none;position:fixed;inset:0;background:rgba(5,20,12,.75);backdrop-filter:blur(8px);z-index:1000;align-items:center;justify-content:center;padding:20px}
.popup-overlay.open{display:flex}
.popup-box{background:#fff;border-radius:20px;padding:40px;width:100%;max-width:580px;position:relative;max-height:90vh;overflow-y:auto;animation-name:popupFadeUp;animation-duration:.3s;animation-timing-function:ease;animation-fill-mode:both;text-align:left}
@keyframes popupFadeUp{from{opacity:0;transform:translateY(16px)}to{opacity:1;transform:translateY(0)}}
.popup-close{position:absolute;top:16px;right:16px;background:var(--cream);border:none;border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);font-size:14px;transition:.2s}
.popup-close:hover{background:var(--border);color:var(--text)}
.popup-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;color:var(--forest);margin-bottom:8px}
.popup-form-group{margin-bottom:10px}
.popup-form-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
.form-input,.form-select,.form-textarea{width:100%;padding:11px 14px;border:1px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);background:#fff;transition:border-color .2s;outline:none}
.form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--teal)}
.form-textarea{min-height:80px;resize:vertical}
.form-submit{width:100%;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;border:none;border-radius:11px;padding:14px 24px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;transition:.2s}
.form-submit:hover{box-shadow:0 8px 28px rgba(29,158,117,.45)}
.popup-success{text-align:center;padding:20px 0;display:none}
.popup-success i{font-size:52px;color:var(--teal);margin-bottom:16px;display:block}
.popup-success-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;color:var(--forest);margin-bottom:10px}
.popup-success-sub{font-size:16px;color:var(--muted);line-height:1.65}
.form-input.error{border-color:#e53e3e;background:#fff8f8}
.captcha-row{display:flex;align-items:center;gap:12px;margin-bottom:16px}
.captcha-question{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest);white-space:nowrap;background:var(--cream);border-radius:8px;padding:10px 14px;flex-shrink:0}
.captcha-input{width:90px!important;text-align:center;font-size:16px!important;font-weight:700}
.consent-row{display:flex;align-items:flex-start;gap:10px;margin-bottom:16px}
.consent-row input[type=checkbox]{width:18px;height:18px;accent-color:var(--teal);flex-shrink:0;margin-top:2px;cursor:pointer}
.consent-label{font-size:12px;color:var(--muted);line-height:1.6;cursor:pointer}
.field-error-msg{font-size:11px;color:#e53e3e;margin-top:4px;font-family:'DM Sans',sans-serif}

@media(max-width:900px){
  .seo-banner-inner{flex-direction:column;text-align:center;padding:32px 24px}
  .seo-banner-inner::before{top:0;left:0;right:0;bottom:auto;width:auto;height:6px;background:linear-gradient(90deg,var(--gold),var(--gold-lt))}
  .seo-banner-divider{width:100%;height:1px}
  .stats-grid{grid-template-columns:1fr 1fr}
  .breakdown-grid{grid-template-columns:1fr;gap:32px}
  .insight-grid{grid-template-columns:1fr}
  .cta-inner{grid-template-columns:1fr}
  .cta-photo{max-width:320px;margin:0 auto;order:-1}
  .cta-content h2,.cta-content p{text-align:center}
  .cta-content .section-label{justify-content:center}
}
@media(max-width:560px){
  .stats-grid{grid-template-columns:1fr 1fr;gap:12px}
  .stat-card{padding:22px 14px}
  section{padding:64px 20px}
}
</style>
</head>
<body>

<div class="topbar">
  <a href="https://homecarecreators.com/"><img src="/images/home/homecarecreators-logo.png" alt="Homecare Creators"></a>
</div>

<!-- HERO -->
<section class="hero" style="padding-bottom:88px">
  <div class="hero-inner">
    <div class="hero-badge"><div class="hero-dot"></div>Client Case Study</div>
    <h1>Sunrise Senior Living:<br><em>312 Leads in 90 Days From SEO</em></h1>
    <p class="hero-sub">A look at the real SEO-driven lead generation results for Sunrise Senior Living, straight from the dashboard, not projections or paid ads.</p>
    <div class="hero-range"><i class="fa-regular fa-calendar"></i>July 1 &ndash; October 1, 2026</div>
  </div>
</section>

<!-- BIG STATS -->
<div class="stats-wrap">
  <div class="stats-grid">
    <div class="stat-card">
      <div class="stat-num">679</div>
      <div class="stat-label">Total Leads</div>
    </div>
    <div class="stat-card">
      <div class="stat-num accent">621</div>
      <div class="stat-label">Quotable Leads</div>
    </div>
    <div class="stat-card">
      <div class="stat-num">$379.12K</div>
      <div class="stat-label">Total Quote Value</div>
    </div>
    <div class="stat-card">
      <div class="stat-num accent">$353.64K</div>
      <div class="stat-label">Total Sales Value</div>
    </div>
  </div>
</div>

<!-- SEO HIGHLIGHT -->
<section class="seo-banner">
  <div class="seo-banner-inner" data-reveal>
    <div class="seo-banner-figure">
      <div class="seo-banner-num">46%</div>
      <div class="seo-banner-figure-label">Of All Leads</div>
    </div>
    <div class="seo-banner-divider"></div>
    <div class="seo-banner-text"><i class="fa-solid fa-magnifying-glass" style="color:var(--gold);margin-right:6px"></i><strong>Nearly half of all leads came from organic SEO</strong> (312 of 679), not paid ads. That's the difference between renting visibility month to month and owning a search presence that keeps bringing in leads on its own.</div>
  </div>
</section>

<!-- SCREENSHOT -->
<section>
  <p class="section-label">The Proof</p>
  <h2 class="section-h2">Straight From the Dashboard</h2>
  <p class="section-sub">No slides, no cherry-picked numbers. This is the actual lead tracking dashboard for Sunrise Senior Living.</p>
  <div class="screenshot-frame">
    <div class="screenshot-bar">
      <div class="screenshot-dot" style="background:#ff5f57"></div>
      <div class="screenshot-dot" style="background:#febc2e"></div>
      <div class="screenshot-dot" style="background:#28c840"></div>
    </div>
    <img src="/images/case-studies/sunrise-senior-living-dashboard.png" alt="Sunrise Senior Living lead tracking dashboard showing 679 total leads and $379.12K total quote value" title="Sunrise Senior Living lead dashboard">
  </div>
  <p class="screenshot-caption">Lead Manager dashboard &middot; July 1 &ndash; October 1, 2026</p>
</section>

<!-- BREAKDOWN -->
<section class="breakdown-section">
  <p class="section-label">The Breakdown</p>
  <h2 class="section-h2">How the Leads Came In</h2>
  <p class="section-sub">679 total leads tracked by type and qualified by the Sunrise Senior Living team.</p>
  <div class="breakdown-grid">
    <div class="breakdown-card">
      <h3>Leads by Type</h3>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Appointments</span><span class="bar-num">454</span></div>
        <div class="bar-track"><div class="bar-fill" style="width:67%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Calls</span><span class="bar-num">190</span></div>
        <div class="bar-track"><div class="bar-fill" style="width:28%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Forms</span><span class="bar-num">29</span></div>
        <div class="bar-track"><div class="bar-fill" style="width:4%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Other Types</span><span class="bar-num">6</span></div>
        <div class="bar-track"><div class="bar-fill" style="width:1%"></div></div>
      </div>
    </div>
    <div class="breakdown-card">
      <h3>Leads by Status</h3>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Quotable</span><span class="bar-num">621</span></div>
        <div class="bar-track"><div class="bar-fill gold" style="width:91%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Not Quotable</span><span class="bar-num">50</span></div>
        <div class="bar-track"><div class="bar-fill muted" style="width:7%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Pending</span><span class="bar-num">8</span></div>
        <div class="bar-track"><div class="bar-fill muted" style="width:1%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Not Set</span><span class="bar-num">0</span></div>
        <div class="bar-track"><div class="bar-fill muted" style="width:0%"></div></div>
      </div>
    </div>
  </div>
</section>

<!-- INDUSTRIES -->
<section>
  <p class="section-label">Who This Works For</p>
  <h2 class="section-h2">Built for the Senior Care Industry</h2>
  <p class="section-sub">The same SEO approach behind these results applies across every corner of home care.</p>
  <div class="industries-grid">
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-house-chimney-medical"></i></div><div class="industry-name">Home Care Agencies</div></div>
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-user-nurse"></i></div><div class="industry-name">Home Health Agencies</div></div>
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-handshake-angle"></i></div><div class="industry-name">Companion Care Providers</div></div>
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-hand-holding-heart"></i></div><div class="industry-name">Personal Care Services</div></div>
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-people-roof"></i></div><div class="industry-name">Private Duty Care Agencies</div></div>
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-cane"></i></div><div class="industry-name">Senior Care Providers</div></div>
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-tree"></i></div><div class="industry-name">Elder Care Services</div></div>
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-brain"></i></div><div class="industry-name">Memory Care Providers</div></div>
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-dove"></i></div><div class="industry-name">Hospice Organizations</div></div>
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-building-user"></i></div><div class="industry-name">Assisted Living Communities</div></div>
  </div>
</section>

<!-- INSIGHTS -->
<section class="insight-section">
  <p class="section-label">What It Means</p>
  <h2 class="section-h2">Quality Leads, Not Just Volume</h2>
  <p class="section-sub">It's not just about how many leads come in. It's how many of them are worth following up on.</p>
  <div class="insight-grid">
    <div class="insight-card">
      <div class="insight-num">91%</div>
      <div class="insight-label">of all leads were marked <strong>quotable</strong> by the Sunrise Senior Living team</div>
    </div>
    <div class="insight-card">
      <div class="insight-num">93%</div>
      <div class="insight-label">of total quote value converted into <strong>closed sales value</strong></div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="cta-inner">
    <div class="cta-content">
      <p class="section-label">Let's Talk</p>
      <h2>Want SEO Results Like This for Your Agency?</h2>
      <p>This is what Home Care SEO looks like when it's built specifically for a senior care provider, not a generic campaign, not paid ads. We only work with home care, senior living, hospice, and memory care agencies, so there's no learning curve on our end.</p>
      <button type="button" class="cta-btn" onclick="openPopup()"><i class="fa-solid fa-magnifying-glass-chart"></i>Book Your Free SEO Strategy Call</button>
      <div class="cta-trust"><i class="fa-solid fa-shield-halved"></i>Free consultation &nbsp;&middot;&nbsp; No obligation</div>
    </div>
    <div class="cta-photo">
      <img src="/images/team/team-presenting-results-screen.jpg" alt="Homecare Creators team presenting campaign results" title="Presenting real client results">
    </div>
  </div>
</section>

<div class="endnote">&copy; <?= date('Y') ?> Homecare Creators &middot; Results shown are specific to Sunrise Senior Living and are not a guarantee of future results.</div>

<!-- BOOKING POPUP (same form/behavior as the main site) -->
<div class="popup-overlay" id="mainPopup">
  <div class="popup-box">
    <button class="popup-close" id="popupCloseBtn" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    <div id="popupFormEl">
      <h2 class="popup-title" id="popupTitleEl">Book Your Free SEO Strategy Call</h2>
      <div class="hp-field" aria-hidden="true"><label for="pWebsite">Website</label><input type="text" id="pWebsite" name="pWebsite" tabindex="-1" autocomplete="off"></div>
      <div class="popup-form-group" style="margin-top:20px"><label class="sr-only" for="pName">Full Name</label><input type="text" class="form-input" id="pName" placeholder="Full Name *" autocomplete="name"></div>
      <div class="popup-form-row">
        <div class="popup-form-group" style="margin-bottom:0"><label class="sr-only" for="pEmail">Email</label><input type="email" class="form-input" id="pEmail" placeholder="Email *" autocomplete="email"></div>
        <div class="popup-form-group" style="margin-bottom:0"><label class="sr-only" for="pPhone">Phone</label><input type="tel" class="form-input" id="pPhone" placeholder="Phone *" maxlength="15" autocomplete="tel"></div>
      </div>
      <div class="popup-form-row" style="margin-top:12px">
        <div class="popup-form-group" style="margin-bottom:0"><label class="sr-only" for="pAgency">Agency Name</label><input type="text" class="form-input" id="pAgency" placeholder="Agency Name" autocomplete="organization"></div>
        <div class="popup-form-group" style="margin-bottom:0"><label class="sr-only" for="pCity">City You Serve</label><input type="text" class="form-input" id="pCity" placeholder="City You Serve"></div>
      </div>
      <div class="popup-form-group" style="margin-top:12px">
        <label class="sr-only" for="pService">What Do You Need Most?</label>
        <select class="form-select" id="pService">
          <option value="Home Care SEO" selected>Home Care SEO</option>
          <option>Website Design &amp; Development</option>
          <option>AI Search SEO (ChatGPT &amp; Google AI)</option>
          <option>Full Bundle Package</option>
          <option>Free Growth Audit</option>
        </select>
      </div>
      <div class="popup-form-group"><label class="sr-only" for="pMsg">Message</label><textarea class="form-textarea" id="pMsg" placeholder="Message (optional) — tell us about your agency..."></textarea></div>
      <div style="margin-bottom:12px">
        <div class="captcha-row">
          <div class="captcha-question" id="captchaQuestion"></div>
          <span style="font-size:18px;color:var(--muted)">=</span>
          <label class="sr-only" for="pCaptcha">Answer</label>
          <input type="number" class="form-input captcha-input" id="pCaptcha" placeholder="?" min="0" max="99" autocomplete="off">
        </div>
      </div>
      <div class="consent-row">
        <input type="checkbox" id="pConsent">
        <label class="consent-label" for="pConsent">I agree to be contacted by Homecare Creators about my inquiry. We respect your privacy and will never share your information.</label>
      </div>
      <button class="form-submit" id="popupSubmitBtn"><i class="fa-solid fa-paper-plane"></i><span id="popupBtnLabel">Send My Request</span></button>
      <p style="text-align:center;margin-top:14px;font-size:12px;color:var(--muted)"><i class="fa-solid fa-lock" style="margin-right:4px;color:var(--teal)"></i>100% private. No spam, ever.</p>
    </div>
    <div class="popup-success" id="popupSuccessEl">
      <i class="fa-solid fa-circle-check"></i>
      <div class="popup-success-title">You're all set!</div>
      <p class="popup-success-sub">We've received your request and will reply within 24 hours.<br>Talk soon! The Homecare Creators Team</p>
    </div>
  </div>
</div>

<script>
var _captchaA = 0, _captchaB = 0;
function generateCaptcha() {
  _captchaA = Math.floor(Math.random() * 9) + 1;
  _captchaB = Math.floor(Math.random() * 9) + 1;
  var el = document.getElementById('captchaQuestion');
  if (el) el.textContent = 'What is ' + _captchaA + ' + ' + _captchaB + '?';
  var inp = document.getElementById('pCaptcha');
  if (inp) inp.value = '';
}
generateCaptcha();

document.getElementById('pPhone').addEventListener('input', function() {
  var digits = this.value.replace(/\D/g, '').substring(0, 10);
  var fmt = '';
  if (digits.length > 0) fmt = '(' + digits.substring(0, 3);
  if (digits.length >= 4) fmt += ') ' + digits.substring(3, 6);
  if (digits.length >= 7) fmt += '-' + digits.substring(6, 10);
  this.value = fmt;
  this.classList.toggle('error', digits.length > 0 && digits.length < 10);
});

function openPopup() {
  document.getElementById('mainPopup').classList.add('open');
  document.body.style.overflow = 'hidden';
  generateCaptcha();
}
function closePopup() {
  document.getElementById('mainPopup').classList.remove('open');
  document.body.style.overflow = '';
}
document.getElementById('mainPopup').addEventListener('click', function(e) { if (e.target === this) closePopup(); });
document.getElementById('popupCloseBtn').addEventListener('click', closePopup);
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closePopup(); });

document.getElementById('popupSubmitBtn').addEventListener('click', function() {
  var name    = (document.getElementById('pName').value  || '').trim();
  var email   = (document.getElementById('pEmail').value || '').trim();
  var phone   = (document.getElementById('pPhone').value || '').trim();
  var captcha = parseInt(document.getElementById('pCaptcha').value, 10);
  var consent = document.getElementById('pConsent').checked;
  var honeypot = (document.getElementById('pWebsite').value || '').trim();

  if (honeypot) {
    document.getElementById('popupFormEl').style.display = 'none';
    document.getElementById('popupSuccessEl').style.display = 'block';
    return;
  }

  if (!name)  { markError('pName',  'Please enter your full name.'); return; }
  if (!email || !email.includes('@') || !email.includes('.')) { markError('pEmail', 'Please enter a valid email address.'); return; }
  var phoneDigits = phone.replace(/\D/g, '');
  if (!phone || phoneDigits.length !== 10) { markError('pPhone', 'Please enter a valid 10-digit phone number.'); return; }
  if (isNaN(captcha) || captcha !== _captchaA + _captchaB) {
    markError('pCaptcha', 'Incorrect answer. Please try again.');
    generateCaptcha();
    return;
  }
  if (!consent) {
    var cb = document.getElementById('pConsent');
    cb.style.outline = '2px solid #e53e3e';
    setTimeout(function(){ cb.style.outline = ''; }, 2000);
    alert('Please check the consent box to continue.');
    return;
  }

  var btnLabel = document.getElementById('popupBtnLabel');
  btnLabel.textContent = 'Sending...';
  this.disabled = true;
  fetch('https://homecarecreators.com/form-handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      name:    name,
      email:   email,
      phone:   phone,
      agency:  document.getElementById('pAgency').value,
      city:    document.getElementById('pCity').value,
      service: document.getElementById('pService').value,
      message: document.getElementById('pMsg').value,
      source:  'results/sunrise-senior-living (case study email link)',
      website: honeypot
    })
  })
  .then(function(r) { return r.json(); })
  .then(function(d) {
    if (d.success) {
      document.getElementById('popupFormEl').style.display = 'none';
      document.getElementById('popupSuccessEl').style.display = 'block';
    } else {
      alert('Error: ' + (d.message || 'Please try again or email info@homecarecreators.com'));
      btnLabel.textContent = 'Send My Request';
      document.getElementById('popupSubmitBtn').disabled = false;
    }
  })
  .catch(function() {
    alert('Connection error. Please email info@homecarecreators.com directly.');
    btnLabel.textContent = 'Send My Request';
    document.getElementById('popupSubmitBtn').disabled = false;
  });
});

function markError(id, msg) {
  var el = document.getElementById(id);
  if (!el) { alert(msg); return; }
  el.classList.add('error');
  el.focus();
  el.addEventListener('input', function(){ el.classList.remove('error'); }, { once: true });
  var existing = el.parentNode.querySelector('.field-error-msg');
  if (existing) existing.remove();
  var err = document.createElement('div');
  err.className = 'field-error-msg';
  err.setAttribute('role', 'alert');
  err.setAttribute('aria-live', 'assertive');
  err.textContent = msg;
  el.parentNode.appendChild(err);
  setTimeout(function(){ if (err.parentNode) err.remove(); }, 6000);
}
</script>

</body>
</html>
