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
<link href="https://assets.calendly.com/assets/external/widget.css" rel="stylesheet">
<style>
:root{--forest:#0a2e1e;--forest-lt:#1a5c3a;--teal:#1d9e75;--teal-lt:#2ec68f;--mint:#9fe1cb;--cream:#f5f2ec;--warm:#fffdf8;--gold:#c9a84c;--gold-lt:#e8c96a;--text:#1a1a14;--muted:#6b7b6e;--border:rgba(26,92,58,0.15)}
*{margin:0;padding:0;box-sizing:border-box}
body{font-family:'DM Sans',sans-serif;background:var(--warm);color:var(--text);overflow-x:hidden}
.container{max-width:1080px;margin:0 auto;padding:0 24px}
h1,h2,h3{font-family:'Plus Jakarta Sans',sans-serif}

/* TOP BAR — logo + CTA, no nav, sticky */
.topbar{padding:14px 0;background:var(--forest);position:sticky;top:0;z-index:200;box-shadow:0 2px 16px rgba(0,0,0,.2)}
.topbar-inner{max-width:1080px;margin:0 auto;padding:0 24px;display:flex;align-items:center;justify-content:space-between;gap:16px}
.topbar img{height:46px;width:auto;display:block}
.topbar-btn{display:inline-flex;align-items:center;gap:8px;background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;padding:10px 20px;border-radius:100px;border:none;cursor:pointer;white-space:nowrap;transition:.2s;flex-shrink:0}
.topbar-btn:hover{background:var(--teal-lt)}

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

/* RESULTS BAND — stat cards + SEO banner share one backdrop below the hero */
.results-band{background:var(--cream);padding-bottom:64px}
.seo-banner-wrap{padding:0 24px}
.seo-banner-inner{max-width:820px;margin:0 auto;background:#fff;border-radius:24px;padding:36px 40px;display:flex;align-items:center;gap:32px;box-shadow:0 14px 36px rgba(10,46,30,.1);position:relative;overflow:hidden}
.seo-banner-inner::before{content:'';position:absolute;left:0;top:0;bottom:0;width:6px;background:linear-gradient(180deg,var(--gold),var(--gold-lt))}
.seo-banner-figure{flex-shrink:0;text-align:center}
.seo-banner-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(46px,6vw,64px);color:var(--gold);line-height:1}
.seo-banner-figure-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-top:4px}
.seo-banner-divider{width:1px;align-self:stretch;background:var(--border);flex-shrink:0}
.seo-banner-text{font-size:16.5px;line-height:1.65;color:var(--text)}
.seo-banner-text strong{color:var(--forest)}

/* SCREENSHOT */
.screenshot-frame{max-width:900px;margin:0 auto;border-radius:18px;overflow:hidden;border:1px solid var(--border)}
.screenshot-bar{background:var(--forest);padding:12px 16px;display:flex;align-items:center;gap:8px}
.screenshot-dot{width:10px;height:10px;border-radius:50%}
.screenshot-scroll{overflow-x:auto;-webkit-overflow-scrolling:touch}
.screenshot-frame img{width:100%;display:block}
.screenshot-caption{text-align:center;font-size:13px;color:var(--muted);margin-top:16px}

/* SEARCH CONSOLE STATS */
.gsc-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;max-width:960px;margin:0 auto 44px}

/* INDUSTRIES */
.industries-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;max-width:900px;margin:0 auto}
.industry-card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px 18px;display:flex;align-items:center;gap:12px}
.industry-icon{width:36px;height:36px;border-radius:9px;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:15px;flex-shrink:0}
.industry-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--forest)}

/* BIG STATS */
.stats-wrap{position:relative;z-index:1;margin-top:-56px;padding:0 24px 40px}
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

@media(max-width:900px){
  .seo-banner-inner{flex-direction:column;text-align:center;padding:32px 24px}
  .seo-banner-inner::before{top:0;left:0;right:0;bottom:auto;width:auto;height:6px;background:linear-gradient(90deg,var(--gold),var(--gold-lt))}
  .seo-banner-divider{width:100%;height:1px}
  .stats-grid{grid-template-columns:1fr 1fr}
  .gsc-grid{grid-template-columns:1fr 1fr}
  .breakdown-grid{grid-template-columns:1fr;gap:32px}
  .insight-grid{grid-template-columns:1fr}
  .cta-inner{grid-template-columns:1fr}
  .cta-photo{max-width:320px;margin:0 auto;order:-1}
  .cta-content h2,.cta-content p{text-align:center}
  .cta-content .section-label{justify-content:center}
}
@media(max-width:700px){
  .screenshot-scroll img{width:640px;max-width:none}
}
@media(max-width:560px){
  .topbar{padding:12px 0}
  .topbar img{height:34px}
  .hero{padding:44px 20px 60px}
  .stats-wrap{margin-top:-40px;padding-bottom:28px}
  .stats-grid{grid-template-columns:1fr 1fr;gap:12px}
  .stat-card{padding:22px 14px}
  section{padding:64px 20px}
  .gsc-grid{grid-template-columns:1fr 1fr;gap:12px}
  .industries-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:480px){
  .topbar-inner{gap:10px}
  .topbar-btn{padding:9px 14px;font-size:12.5px}
  .topbar-btn i{display:none}
}
@media(max-width:380px){
  .industries-grid{grid-template-columns:1fr}
  .stats-grid{grid-template-columns:1fr}
  .gsc-grid{grid-template-columns:1fr}
}
</style>
</head>
<body>

<div class="topbar">
  <div class="topbar-inner">
    <a href="https://homecarecreators.com/"><img src="/images/home/homecarecreators-logo.png" alt="Homecare Creators"></a>
    <button type="button" class="topbar-btn" onclick="openPopup()"><i class="fa-solid fa-phone"></i>Book a Free Call</button>
  </div>
</div>

<!-- HERO -->
<section class="hero">
  <div class="hero-inner">
    <div class="hero-badge"><div class="hero-dot"></div>Client Case Study</div>
    <h1>Sunrise Senior Living<br><em>137 Leads in 90 Days, 100% Organic</em></h1>
    <p class="hero-sub">Every lead below came from organic search, not a paid ad. A look at the real SEO-driven lead generation results for Sunrise Senior Living, straight from the dashboard.</p>
    <div class="hero-range"><i class="fa-regular fa-calendar"></i>July 1 &ndash; October 1, 2026</div>
  </div>
</section>

<!-- BIG STATS + SEO HIGHLIGHT (one shared backdrop below the hero) -->
<div class="results-band">
  <div class="stats-wrap">
    <div class="stats-grid">
      <div class="stat-card">
        <div class="stat-num">137</div>
        <div class="stat-label">Organic Leads</div>
      </div>
      <div class="stat-card">
        <div class="stat-num accent">106</div>
        <div class="stat-label">Quotable Leads</div>
      </div>
      <div class="stat-card">
        <div class="stat-num">$40.66K</div>
        <div class="stat-label">Total Quote Value</div>
      </div>
      <div class="stat-card">
        <div class="stat-num accent">$33.25K</div>
        <div class="stat-label">Total Sales Value</div>
      </div>
    </div>
  </div>
  <div class="seo-banner-wrap">
    <div class="seo-banner-inner" data-reveal>
      <div class="seo-banner-figure">
        <div class="seo-banner-num">$0</div>
        <div class="seo-banner-figure-label">Ad Spend</div>
      </div>
      <div class="seo-banner-divider"></div>
      <div class="seo-banner-text"><strong>All 137 of these leads came from organic search</strong>, with zero dollars spent on paid ads. That's the difference between renting visibility month to month and owning a search presence that keeps bringing in leads on its own.</div>
    </div>
  </div>
</div>

<!-- SCREENSHOT -->
<section style="padding-bottom:48px">
  <p class="section-label">The Proof</p>
  <h2 class="section-h2">Straight From the Dashboard</h2>
  <p class="section-sub">No slides, no cherry-picked numbers. This is the actual lead tracking dashboard for Sunrise Senior Living, filtered to organic search only.</p>
  <div class="screenshot-frame">
    <div class="screenshot-bar">
      <div class="screenshot-dot" style="background:#ff5f57"></div>
      <div class="screenshot-dot" style="background:#febc2e"></div>
      <div class="screenshot-dot" style="background:#28c840"></div>
    </div>
    <div class="screenshot-scroll"><img src="/images/case-studies/sunrise-senior-living-organic-dashboard.png" alt="Sunrise Senior Living lead tracking dashboard filtered to organic search showing 137 total leads and $40.66K total quote value" title="Sunrise Senior Living organic search lead dashboard"></div>
  </div>
  <p class="screenshot-caption">Lead Manager dashboard &middot; Medium: Organic &middot; July 1 &ndash; October 1, 2026</p>
</section>

<!-- SEARCH CONSOLE -->
<section style="padding-top:40px">
  <p class="section-label">Search Visibility</p>
  <h2 class="section-h2">The Visibility Behind the Leads</h2>
  <p class="section-sub">Pulled directly from Google Search Console for the same 3-month window, this is the organic search growth driving the leads above.</p>
  <div class="gsc-grid">
    <div class="stat-card">
      <div class="stat-num">3.34K</div>
      <div class="stat-label">Total Clicks</div>
    </div>
    <div class="stat-card">
      <div class="stat-num accent">301K</div>
      <div class="stat-label">Total Impressions</div>
    </div>
    <div class="stat-card">
      <div class="stat-num">1.11%</div>
      <div class="stat-label">Average CTR</div>
    </div>
    <div class="stat-card">
      <div class="stat-num accent">1.9</div>
      <div class="stat-label">Average Position</div>
    </div>
  </div>
  <div class="screenshot-frame">
    <div class="screenshot-bar">
      <div class="screenshot-dot" style="background:#ff5f57"></div>
      <div class="screenshot-dot" style="background:#febc2e"></div>
      <div class="screenshot-dot" style="background:#28c840"></div>
    </div>
    <div class="screenshot-scroll"><img src="/images/case-studies/sunrise-senior-living-search-console.png" alt="Google Search Console performance report for Sunrise Senior Living showing 3.34K total clicks, 301K total impressions, 1.11% average CTR, and 1.9 average position" title="Sunrise Senior Living Google Search Console performance"></div>
  </div>
  <p class="screenshot-caption">Google Search Console &middot; Performance report &middot; 3 months</p>
</section>

<!-- BREAKDOWN -->
<section class="breakdown-section">
  <p class="section-label">The Breakdown</p>
  <h2 class="section-h2">How the Leads Came In</h2>
  <p class="section-sub">137 organic leads tracked by type and qualified by the Sunrise Senior Living team.</p>
  <div class="breakdown-grid">
    <div class="breakdown-card">
      <h3>Leads by Type</h3>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Calls</span><span class="bar-num">126</span></div>
        <div class="bar-track"><div class="bar-fill" style="width:92%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Forms</span><span class="bar-num">6</span></div>
        <div class="bar-track"><div class="bar-fill" style="width:4%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Messages</span><span class="bar-num">5</span></div>
        <div class="bar-track"><div class="bar-fill" style="width:4%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Other Types</span><span class="bar-num">0</span></div>
        <div class="bar-track"><div class="bar-fill" style="width:0%"></div></div>
      </div>
    </div>
    <div class="breakdown-card">
      <h3>Leads by Status</h3>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Quotable</span><span class="bar-num">106</span></div>
        <div class="bar-track"><div class="bar-fill gold" style="width:77%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Not Quotable</span><span class="bar-num">25</span></div>
        <div class="bar-track"><div class="bar-fill muted" style="width:18%"></div></div>
      </div>
      <div class="bar-row">
        <div class="bar-head"><span class="bar-name">Pending</span><span class="bar-num">6</span></div>
        <div class="bar-track"><div class="bar-fill muted" style="width:4%"></div></div>
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
    <div class="industry-card"><div class="industry-icon"><i class="fa-solid fa-wheelchair"></i></div><div class="industry-name">Senior Care Providers</div></div>
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
      <div class="insight-num">77%</div>
      <div class="insight-label">of all organic leads were marked <strong>quotable</strong> by the Sunrise Senior Living team</div>
    </div>
    <div class="insight-card">
      <div class="insight-num">82%</div>
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
      <img src="/images/team/team-reviewing-seo-dashboard.jpg" alt="Homecare Creators team reviewing SEO dashboard results" title="Reviewing real client results">
    </div>
  </div>
</section>


<script src="https://assets.calendly.com/assets/external/widget.js" type="text/javascript"></script>
<script>
function openPopup() {
  if (window.Calendly) {
    Calendly.initPopupWidget({ url: 'https://calendly.com/homecarecreators/30min' });
  }
  return false;
}
</script>

</body>
</html>
