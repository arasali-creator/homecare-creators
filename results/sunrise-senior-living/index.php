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

/* BIG STATS */
.stats-wrap{position:relative;z-index:1;margin-top:-56px;padding:0 24px 0}
.stats-grid{max-width:1000px;margin:0 auto;display:grid;grid-template-columns:repeat(4,1fr);gap:18px}
.stat-card{background:#fff;border-radius:20px;padding:30px 24px;text-align:center;box-shadow:0 24px 60px rgba(10,46,30,.16);border:1px solid var(--border)}
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
.breakdown-grid{display:grid;grid-template-columns:1fr 1fr;gap:40px;max-width:900px;margin:0 auto}
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
.cta-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;color:var(--forest);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;padding:16px 30px;border-radius:100px;text-decoration:none;transition:.2s}
.cta-btn:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(0,0,0,.3)}
.cta-trust{margin-top:20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.4);display:flex;align-items:center;gap:8px}
.cta-trust i{color:var(--teal-lt)}
.cta-photo{border-radius:20px;overflow:hidden;aspect-ratio:4/4.6;box-shadow:0 24px 70px rgba(0,0,0,.35)}
.cta-photo img{width:100%;height:100%;object-fit:cover;display:block}

.endnote{text-align:center;padding:28px 24px;font-size:12px;color:var(--muted);background:var(--warm)}

@media(max-width:900px){
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
    <h1>Sunrise Senior Living:<br><em>679 Leads in 90 Days</em></h1>
    <p class="hero-sub">A look at the real lead-generation results from our marketing campaign for Sunrise Senior Living, straight from the numbers, not projections.</p>
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

<!-- BREAKDOWN -->
<section>
  <p class="section-label">The Breakdown</p>
  <h2 class="section-h2">Where the Leads Came From</h2>
  <p class="section-sub">679 total leads tracked across every channel and qualified by our team's review process.</p>
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
      <h2>Want Results Like This for Your Agency?</h2>
      <p>This is what a 90-day campaign built specifically for a senior care provider looks like. We only work with home care, senior living, and hospice agencies, no other industries, no learning curve.</p>
      <a href="https://homecarecreators.com/contact/" class="cta-btn"><i class="fa-solid fa-phone"></i>Book Your Free Strategy Call</a>
      <div class="cta-trust"><i class="fa-solid fa-shield-halved"></i>Free consultation &nbsp;&middot;&nbsp; No obligation</div>
    </div>
    <div class="cta-photo">
      <img src="/images/team/team-presenting-results-screen.jpg" alt="Homecare Creators team presenting campaign results" title="Presenting real client results">
    </div>
  </div>
</section>

<div class="endnote">&copy; <?= date('Y') ?> Homecare Creators &middot; Results shown are specific to Sunrise Senior Living and are not a guarantee of future results.</div>

</body>
</html>
