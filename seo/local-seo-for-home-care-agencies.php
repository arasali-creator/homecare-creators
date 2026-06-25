<?php
$page_title = "Local SEO for Home Care Agencies | Homecare Creators";
$page_desc = "Local SEO built exclusively for home care agencies. Rank #1 on Google Maps, dominate local search in Florida, and grow private-pay clients. Packages from $399/mo. No contracts. Results in 60–90 days.";
$page_canonical = "https://homecarecreators.com/local-seo-for-home-care-agencies/";
$og_title = "Local SEO for Home Care Agencies | Homecare Creators";
$og_desc = "The only local SEO agency built 100% for homecare. Rank #1 on Google Maps in Florida, grow private-pay clients, and beat every competitor in your city. Plans from $399/mo.";
$page_css = <<<CSS
/* HERO */
.hero{min-height:100vh;background:var(--forest);position:relative;overflow:hidden;display:grid;grid-template-columns:1fr 1fr;align-items:center;padding:0}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-200px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-blob2{position:absolute;width:500px;height:500px;bottom:-150px;left:-100px;background:radial-gradient(circle,rgba(201,168,76,.1) 0%,transparent 65%);animation:float 13s ease-in-out infinite reverse}
.hero-left{position:relative;z-index:2;padding:140px 52px 80px 80px}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Syne',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:32px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Instrument Serif',serif;font-size:clamp(38px,5vw,66px);line-height:1.04;color:#fff;margin-bottom:10px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-tagline{font-family:'Instrument Serif',serif;font-size:clamp(18px,2.2vw,26px);line-height:1.3;color:rgba(255,255,255,.5);margin-bottom:10px;animation:fadeUp .8s .18s ease both}
.hero-tagline em{color:var(--mint);font-style:normal}
.hero-desc{font-size:16.5px;line-height:1.75;color:rgba(255,255,255,.62);max-width:500px;margin-bottom:42px;animation:fadeUp .8s .3s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .4s ease both;margin-bottom:52px}
.hero-proof{display:flex;gap:32px;flex-wrap:wrap;animation:fadeUp .8s .55s ease both}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Instrument Serif',serif;font-size:34px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-proof-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch}

/* HERO RIGHT — GMB MOCKUP */
.hero-right{position:relative;z-index:2;height:100vh;min-height:680px;padding:120px 48px 60px 24px;display:flex;align-items:center;justify-content:center}
.gmb-mockup{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 32px 96px rgba(0,0,0,.4);width:100%;max-width:440px;animation:fadeUp .9s .4s ease both}
.gmb-bar{background:var(--forest);padding:12px 16px;display:flex;align-items:center;gap:10px}
.gmb-dots{display:flex;gap:6px}
.gmb-dot{width:10px;height:10px;border-radius:50%}
.gmb-url{flex:1;background:rgba(255,255,255,.1);border-radius:6px;padding:5px 12px;font-family:'Syne',sans-serif;font-size:10px;color:rgba(255,255,255,.6)}
.gmb-body{padding:16px}
.gmb-search{background:var(--cream);border-radius:28px;padding:10px 16px;display:flex;align-items:center;gap:10px;margin-bottom:14px;border:1px solid var(--border)}
.gmb-search-icon{color:var(--teal);font-size:14px}
.gmb-search-text{font-family:'Syne',sans-serif;font-size:12px;font-weight:600;color:var(--muted)}
.gmb-map{height:100px;background:linear-gradient(135deg,#e8f5e9,#c8e6c9);border-radius:12px;margin-bottom:14px;display:flex;align-items:center;justify-content:center;position:relative;overflow:hidden}
.gmb-map-pin{font-size:24px;position:relative;z-index:1}
.gmb-map::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.1) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.1) 1px,transparent 1px);background-size:20px 20px}
.gmb-results{display:flex;flex-direction:column;gap:8px}
.gmb-result{background:var(--warm);border:1px solid var(--border);border-radius:10px;padding:10px 12px;display:flex;align-items:center;gap:10px}
.gmb-result.top-result{background:rgba(29,158,117,.06);border-color:rgba(29,158,117,.25)}
.gmb-result-rank{width:24px;height:24px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-size:11px;font-weight:800;flex-shrink:0}
.gmb-result.top-result .gmb-result-rank{background:var(--teal)}
.gmb-result-info{flex:1}
.gmb-result-name{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;color:var(--forest)}
.gmb-result.top-result .gmb-result-name{color:var(--teal)}
.gmb-result-stars{font-size:9px;color:var(--gold);letter-spacing:1px}
.gmb-result-reviews{font-size:9px;color:var(--muted)}
.gmb-you-badge{font-family:'Syne',sans-serif;font-size:9px;font-weight:700;background:var(--teal);color:#fff;padding:2px 8px;border-radius:10px}
.gmb-rank-badge{position:absolute;top:28%;right:-12px;background:#fff;border-radius:12px;padding:10px 14px;box-shadow:0 8px 32px rgba(0,0,0,.2);border:1px solid var(--border);animation:floatR 4s ease-in-out infinite}
.gmb-rank-num{font-family:'Syne',sans-serif;font-size:18px;font-weight:800;color:var(--teal)}
.gmb-rank-label{font-size:9px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600}
.gmb-review-badge{position:absolute;bottom:22%;left:-16px;background:var(--forest);border-radius:12px;padding:10px 14px;box-shadow:0 8px 32px rgba(0,0,0,.3);border:1px solid rgba(46,198,143,.3);animation:floatR 5s ease-in-out infinite 1s;min-width:148px}
.gmb-review-num{font-family:'Instrument Serif',serif;font-size:22px;color:var(--teal-lt);line-height:1}
.gmb-review-label{font-size:9px;color:rgba(255,255,255,.5);font-family:'Syne',sans-serif;font-weight:600}

/* WHY VISUAL */
.why-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.why-body p{font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.why-points{display:flex;flex-direction:column;gap:14px;margin-top:28px}
.why-point{display:flex;gap:16px;align-items:flex-start;padding:18px;border-radius:16px;border:1px solid var(--border);background:var(--warm);transition:.3s}
.why-point:hover{border-color:rgba(29,158,117,.3);box-shadow:0 8px 32px rgba(10,46,30,.08);transform:translateX(4px)}
.why-point-icon{width:44px;height:44px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.why-point-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15px;color:var(--forest);margin-bottom:4px}
.why-point-desc{font-size:13.5px;line-height:1.6;color:var(--muted)}
.why-visual{position:relative}
.why-img{border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(10,46,30,.18);aspect-ratio:4/5}
.why-img img{width:100%;height:100%;object-fit:cover;display:block}
.why-img::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(10,46,30,.55) 100%);border-radius:var(--r-lg)}
.why-stat-float{position:absolute;bottom:-20px;right:-20px;background:#fff;border-radius:16px;padding:18px 22px;box-shadow:0 12px 48px rgba(10,46,30,.18);text-align:center;min-width:130px;border:1px solid var(--border);animation:floatR 5s ease-in-out infinite}
.why-stat-num{font-family:'Instrument Serif',serif;font-size:38px;color:var(--teal);line-height:1}
.why-stat-label{font-size:11px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600;margin-top:3px}
.why-badge-float{position:absolute;top:24px;left:-18px;background:var(--forest);border-radius:14px;padding:12px 18px;min-width:160px;box-shadow:0 8px 32px rgba(0,0,0,.25);border:1px solid rgba(29,158,117,.3);animation:floatR 7s ease-in-out infinite 1s}
.why-badge-row{display:flex;align-items:center;gap:10px}
.why-badge-icon{font-size:18px;color:var(--teal-lt)}
.why-badge-text{font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:#fff}
.why-badge-sub{font-size:10px;color:rgba(255,255,255,.5)}

/* INCLUDED GRID */
.included-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:48px}
.inc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:24px;transition:.25s}
.inc-card:hover{box-shadow:0 8px 32px rgba(10,46,30,.08);border-color:rgba(29,158,117,.2)}
.inc-icon{width:46px;height:46px;border-radius:12px;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:20px;margin-bottom:16px}
.inc-card h3{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:8px}
.inc-card p{font-size:13px;color:var(--muted);line-height:1.7}

/* HOW GRID */
.how-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:72px;position:relative}
.how-grid::before{content:'';position:absolute;top:44px;left:12%;right:12%;height:1px;background:linear-gradient(90deg,transparent,var(--teal) 20%,var(--teal) 80%,transparent);opacity:.25}
.how-step{text-align:center;padding:0 20px 48px;position:relative}
.how-step-num{width:88px;height:88px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-family:'Syne',sans-serif;font-weight:800;font-size:26px;position:relative;z-index:1;box-shadow:0 0 0 10px rgba(29,158,117,.08),0 8px 32px rgba(10,46,30,.2);transition:.3s}
.how-step:hover .how-step-num{background:var(--teal);box-shadow:0 0 0 10px rgba(29,158,117,.15),0 12px 40px rgba(29,158,117,.35)}
.how-step-icon{position:absolute;bottom:-4px;right:-4px;width:28px;height:28px;border-radius:50%;background:var(--teal-lt);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;box-shadow:0 2px 8px rgba(0,0,0,.2)}
.how-step-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15.5px;color:var(--forest);margin-bottom:10px}
.how-step-desc{font-size:13.5px;line-height:1.65;color:var(--muted)}

/* PACKAGES GRID */
.packages-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:56px}
.pkg-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r-lg);padding:36px 32px;position:relative;transition:.3s}
.pkg-card:hover{transform:translateY(-6px);box-shadow:0 24px 64px rgba(10,46,30,.1)}
.pkg-card.featured{background:var(--forest);border-color:var(--teal);box-shadow:0 16px 64px rgba(10,46,30,.3)}
.pkg-popular{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;font-family:'Syne',sans-serif;font-size:11px;font-weight:700;padding:5px 18px;border-radius:20px;letter-spacing:.5px;white-space:nowrap}
.pkg-name{font-family:'Syne',sans-serif;font-size:13px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--teal);margin-bottom:10px}
.pkg-card.featured .pkg-name{color:var(--teal-lt)}
.pkg-price{font-family:'Instrument Serif',serif;font-size:52px;color:var(--forest);line-height:1;margin-bottom:4px}
.pkg-card.featured .pkg-price{color:#fff}
.pkg-price-note{font-family:'Syne',sans-serif;font-size:12px;color:var(--muted);margin-bottom:24px}
.pkg-card.featured .pkg-price-note{color:rgba(255,255,255,.5)}
.pkg-divider{height:1px;background:var(--border);margin-bottom:24px}
.pkg-card.featured .pkg-divider{background:rgba(255,255,255,.1)}
.pkg-features{list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:32px}
.pkg-features li{display:flex;align-items:flex-start;gap:10px;font-size:13.5px;color:var(--muted);line-height:1.5}
.pkg-card.featured .pkg-features li{color:rgba(255,255,255,.7)}
.pkg-features li i{color:var(--teal);font-size:12px;margin-top:2px;flex-shrink:0}
.pkg-card.featured .pkg-features li i{color:var(--teal-lt)}
.pkg-btn{width:100%;padding:14px;border-radius:10px;font-family:'Syne',sans-serif;font-weight:700;font-size:14px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:.2s}
.pkg-btn-default{background:var(--forest);color:#fff}
.pkg-btn-default:hover{background:var(--teal)}
.pkg-btn-featured{background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;box-shadow:0 4px 20px rgba(29,158,117,.4)}
.pkg-btn-featured:hover{box-shadow:0 8px 32px rgba(29,158,117,.55);transform:translateY(-2px)}

/* CITIES GRID */
.cities-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-top:36px}
.city-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:18px 20px;display:flex;align-items:center;gap:12px;text-decoration:none;transition:all .2s}
.city-card:hover{border-color:var(--teal);transform:translateY(-2px);box-shadow:0 8px 24px rgba(10,46,30,.08)}
.city-icon{width:36px;height:36px;border-radius:9px;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:15px;flex-shrink:0}
.city-name{font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:var(--forest)}
.city-county{font-size:12px;color:var(--muted);margin-top:2px}

/* RESULTS GRID */
.results-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:56px;border:1px solid rgba(255,255,255,.08);border-radius:var(--r-lg);overflow:hidden}
.result-item{padding:36px 28px;text-align:center;border-right:1px solid rgba(255,255,255,.08)}
.result-item:last-child{border-right:none}
.result-num{font-family:'Instrument Serif',serif;font-size:52px;color:var(--teal-lt);line-height:1;margin-bottom:8px}
.result-label{font-family:'Syne',sans-serif;font-size:12px;font-weight:600;color:rgba(255,255,255,.5);letter-spacing:.5px}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:104px 40px}
.cta-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.cta-content .section-label{color:var(--teal-lt)}
.cta-content .section-label::before{background:var(--teal-lt)}
.cta-content .section-h2{color:#fff}
.cta-desc{font-size:16px;color:rgba(255,255,255,.68);line-height:1.78;margin-bottom:32px}
.cta-guarantee{font-family:'Syne',sans-serif;font-size:12px;color:rgba(255,255,255,.45);display:flex;align-items:center;gap:8px;margin-top:18px}
.cta-guarantee i{color:var(--teal-lt)}
.cta-image{position:relative;border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3)}
.cta-image img{width:100%;height:400px;object-fit:cover;display:block}
.cta-image-badge{position:absolute;bottom:20px;left:20px;right:20px;background:rgba(10,46,30,.88);backdrop-filter:blur(12px);border:1px solid rgba(46,198,143,.22);border-radius:12px;padding:16px 18px}
.cta-image-badge-title{font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:#fff;margin-bottom:10px}
.cta-badge-row{display:flex;align-items:center;gap:8px;margin-bottom:6px}
.cta-badge-row:last-child{margin-bottom:0}
.cta-badge-dot{width:5px;height:5px;border-radius:50%;background:var(--teal-lt);flex-shrink:0}
.cta-badge-text{font-family:'Syne',sans-serif;font-size:12px;color:rgba(255,255,255,.65)}

/* RESPONSIVE */
@media(max-width:1024px){.hero{grid-template-columns:1fr;min-height:auto}.hero-right{display:none}.hero-left{padding:140px 48px 80px}.packages-grid,.included-grid{grid-template-columns:1fr 1fr}.results-grid{grid-template-columns:repeat(2,1fr)}.why-grid{grid-template-columns:1fr;gap:48px}.how-grid{grid-template-columns:repeat(2,1fr)}.cta-inner{grid-template-columns:1fr}.cta-image{display:none}}
@media(max-width:640px){section{padding:64px 20px}.packages-grid,.included-grid,.results-grid{grid-template-columns:1fr}.how-grid{grid-template-columns:1fr}}
CSS;
include '../includes/header.php';
?>

<!-- HERO -->
<section class="hero" id="home" style="padding:0">
  <div class="hero-bg-grid"></div>
  <div class="hero-blob1"></div>
  <div class="hero-blob2"></div>
  <div class="hero-left">
    <div class="hero-badge"><div class="hero-badge-pulse"></div>Local SEO for Home Care Agencies</div>
    <h1 class="hero-h1">Rank #1. Get Found.<br><em>Grow Faster.</em></h1>
    <div class="hero-tagline"><em>The Only Local SEO Agency</em><br><em>Built 100% for Homecare.</em></div>
    <p class="hero-desc">We get your homecare agency to the top of Google Maps and organic search in your city — so families searching for care find you first, not your competitors. Specialized homecare SEO. Real results in 60–90 days.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-magnifying-glass-chart"></i>Book Free SEO Audit</button>
      <a href="#packages" class="btn-secondary"><i class="fa-solid fa-layer-group"></i>View Packages</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item"><div class="hero-proof-num">#1</div><div class="hero-proof-label">Google Maps in 5mo</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">312%</div><div class="hero-proof-label">Avg Lead Increase</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">67+</div><div class="hero-proof-label">Reviews in 90 Days</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">$0</div><div class="hero-proof-label">Free Audit Cost</div></div>
    </div>
  </div>
  <div class="hero-right">
    <div style="position:relative;width:100%;max-width:440px">
      <div class="gmb-mockup">
        <div class="gmb-bar">
          <div class="gmb-dots"><div class="gmb-dot" style="background:#ff5f57"></div><div class="gmb-dot" style="background:#febc2e"></div><div class="gmb-dot" style="background:#28c840"></div></div>
          <div class="gmb-url">google.com/maps · home care Miami FL</div>
        </div>
        <div class="gmb-body">
          <div class="gmb-search"><i class="fa-solid fa-magnifying-glass gmb-search-icon"></i><span class="gmb-search-text">home care agency near me Miami FL</span></div>
          <div class="gmb-map"><div class="gmb-map-pin">📍</div></div>
          <div class="gmb-results">
            <div class="gmb-result top-result">
              <div class="gmb-result-rank">1</div>
              <div class="gmb-result-info">
                <div class="gmb-result-name">Your Homecare Agency</div>
                <div class="gmb-result-stars">★★★★★</div>
                <div class="gmb-result-reviews">4.9 · 84 reviews · Open now</div>
              </div>
              <div class="gmb-you-badge">YOU</div>
            </div>
            <div class="gmb-result">
              <div class="gmb-result-rank">2</div>
              <div class="gmb-result-info">
                <div class="gmb-result-name">Competitor Agency A</div>
                <div class="gmb-result-stars" style="color:#ccc">★★★★☆</div>
                <div class="gmb-result-reviews">4.1 · 31 reviews</div>
              </div>
            </div>
            <div class="gmb-result">
              <div class="gmb-result-rank">3</div>
              <div class="gmb-result-info">
                <div class="gmb-result-name">Competitor Agency B</div>
                <div class="gmb-result-stars" style="color:#ccc">★★★☆☆</div>
                <div class="gmb-result-reviews">3.8 · 19 reviews</div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <div class="gmb-rank-badge">
        <div class="gmb-rank-num">#1</div>
        <div class="gmb-rank-label">Google Maps</div>
      </div>
      <div class="gmb-review-badge">
        <div class="gmb-review-num">+67</div>
        <div class="gmb-review-label">New reviews in 90 days</div>
      </div>
    </div>
  </div>
</section>

<!-- TICKER -->
<div class="ticker-wrap" aria-hidden="true">
  <div class="ticker-inner">
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Google Maps #1 Rankings</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>5-Star Review Velocity</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-map-location-dot"></i>40+ Citation Directories/mo</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass"></i>50–100 Keywords Tracked</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>AI Search SEO — ChatGPT &amp; Perplexity</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-chart-line"></i>Monthly Ranking Reports</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Google Maps #1 Rankings</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>5-Star Review Velocity</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-map-location-dot"></i>40+ Citation Directories/mo</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass"></i>50–100 Keywords Tracked</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>AI Search SEO — ChatGPT &amp; Perplexity</div>
  </div>
</div>

<!-- WHY LOCAL SEO -->
<section class="why-section">
  <div class="container">
    <div class="why-grid">
      <div data-reveal>
        <p class="section-label">Why Local SEO Matters</p>
        <h2 class="section-h2">Families Don't Scroll Past<br><em>the First Three Results</em></h2>
        <p style="font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:16px">When a family in Miami types "home care agency near me" into Google, the top three results in the Google Maps Local Pack get over 75% of all the clicks. If your agency isn't in those three spots, you're effectively invisible to that family — and they'll call your competitor instead.</p>
        <p style="font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:16px">Local SEO is the process of optimizing every signal Google uses to decide which three homecare agencies to show in that Local Pack — your Google Business Profile, your reviews, your website, your citations across the web, and the content on your pages.</p>
        <p style="font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:24px">Homecare Creators manages all of it exclusively for homecare agencies. No other industry. No learning curve. Just the deep homecare-specific SEO knowledge that gets your Florida agency to position #1 faster than any generalist can.</p>
        <div class="why-points">
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-brands fa-google"></i></div>
            <div><div class="why-point-title">Google Business Profile Management</div><div class="why-point-desc">Your GBP is your single most powerful local ranking asset. We fully optimize it, post weekly updates, respond to reviews, and monitor it daily so Google always sees an active, trustworthy business.</div></div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-star"></i></div>
            <div><div class="why-point-title">Review Velocity Strategy</div><div class="why-point-desc">67+ new 5-star Google reviews in 90 days — using our proven review request system built around homecare workflows. Reviews are a top-3 Google Maps ranking factor, and we systematically generate them.</div></div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-map-location-dot"></i></div>
            <div><div class="why-point-title">Citation Building — 40+ Per Month</div><div class="why-point-desc">We submit your agency to 40+ high-authority directories every month — healthcare-specific platforms like Caring.com and HomeCare.com, plus general directories, and local Florida business listings.</div></div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-robot"></i></div>
            <div><div class="why-point-title">AI Search SEO (GEO)</div><div class="why-point-desc">Families now search on ChatGPT, Google AI Overviews, and Perplexity. We're the only homecare SEO agency optimizing for AI-generated answers — your competitors haven't even heard of this yet.</div></div>
          </div>
        </div>
      </div>
      <div class="why-visual" data-reveal style="transition-delay:.15s">
        <div class="why-img">
          <img src="https://images.unsplash.com/photo-1504868584819-f8e8b4b6d7e3?w=600&q=80&fit=crop" alt="Local SEO for homecare agencies Florida">
        </div>
        <div class="why-stat-float">
          <div class="why-stat-num">#1</div>
          <div class="why-stat-label">Google Rank in 5mo</div>
        </div>
        <div class="why-badge-float">
          <div class="why-badge-row">
            <div class="why-badge-icon"><i class="fa-solid fa-chart-line"></i></div>
            <div>
              <div class="why-badge-text">Results in 60–90 Days</div>
              <div class="why-badge-sub">Google Maps improvements</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WHAT'S INCLUDED -->
<section class="included-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">What's Included Every Month</p>
      <h2 class="section-h2">Every Signal Google Uses.<br><em>All Managed for You.</em></h2>
      <p class="section-sub">Our local SEO retainer covers every ranking factor Google uses to decide which homecare agencies appear at the top — nothing outsourced, nothing skipped.</p>
    </div>
    <div class="included-grid" data-reveal style="transition-delay:.1s">
      <div class="inc-card"><div class="inc-icon"><i class="fa-brands fa-google"></i></div><h3>Google Business Profile Management</h3><p>Full GBP optimization plus weekly posts, photo uploads, Q&amp;A management, and review responses — keeping your profile active and authoritative in Google's eyes every single week.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-star"></i></div><h3>Review Velocity Management</h3><p>Our proven 3-touch review request system generates a consistent flow of 5-star Google reviews from your real clients — the single highest-impact ranking and conversion factor for homecare agencies.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-map-location-dot"></i></div><h3>40+ Citation Submissions/mo</h3><p>We submit your NAP (name, address, phone) to 40+ high-quality directories monthly — including healthcare-specific platforms, Florida business directories, and general authority sites like Yelp and BBB.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-file-code"></i></div><h3>On-Page SEO Updates</h3><p>Monthly updates to your website pages — refreshing keyword targets, updating meta descriptions, improving internal linking, and adding location-specific content that keeps your pages ranking and climbing.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-chart-bar"></i></div><h3>Monthly Ranking Reports</h3><p>A clear, easy-to-read report every month showing exactly where you rank for your 50–100 target keywords, your Google Maps position, traffic trends, and what we're working on next.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-shield-halved"></i></div><h3>NAP Consistency Audit</h3><p>We scan the web for incorrect or duplicate listings of your agency's name, address, and phone number — and fix every inconsistency, because NAP mismatches silently hurt your Google Maps rankings.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-users-viewfinder"></i></div><h3>Competitor Gap Analysis</h3><p>Every quarter we benchmark your rankings against your top 3–5 local competitors and identify exactly what they're doing that you aren't — then close those gaps faster than they can respond.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-robot"></i></div><h3>AI Search Optimization (GEO)</h3><p>We optimize your website and content to appear in ChatGPT answers, Google AI Overviews, and Perplexity results when families ask "what's the best homecare agency in [city]?" — a first-mover advantage your competitors don't have.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-phone"></i></div><h3>Monthly Strategy Call</h3><p>A 30-minute call every month with your dedicated strategist to review results, discuss opportunities, and plan the next 30 days. You always know exactly what we're doing and why.</p></div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">How It Works</p>
      <h2 class="section-h2" style="text-align:center">From Audit to <em>#1 in 5 Months</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">A proven 4-phase process that consistently delivers top Google Maps positions for Florida homecare agencies.</p>
    </div>
    <div class="how-grid" data-reveal style="transition-delay:.1s">
      <div class="how-step">
        <div class="how-step-num">1<div class="how-step-icon"><i class="fa-solid fa-magnifying-glass"></i></div></div>
        <div class="how-step-title">Deep Audit</div>
        <div class="how-step-desc">We audit your Google Business Profile, current rankings, website SEO health, citation accuracy, review profile, and every competitor in your city. This becomes your growth roadmap.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">2<div class="how-step-icon"><i class="fa-solid fa-wrench"></i></div></div>
        <div class="how-step-title">Foundation Fix</div>
        <div class="how-step-desc">Month 1 we fix everything broken — GBP optimization, NAP consistency, on-page SEO, schema markup, and citation cleanup. This is what moves the needle fastest.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">3<div class="how-step-icon"><i class="fa-solid fa-rocket"></i></div></div>
        <div class="how-step-title">Authority Build</div>
        <div class="how-step-desc">Months 2–4 we build your authority — citations, reviews, content, backlinks, and AI search optimization. Rankings climb consistently as Google recognizes your agency as the area's most trusted provider.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">4<div class="how-step-icon"><i class="fa-solid fa-trophy"></i></div></div>
        <div class="how-step-title">Dominate &amp; Hold</div>
        <div class="how-step-desc">Month 5+ you're at #1. We maintain your position, expand to new cities and neighborhoods, and ensure no competitor can displace you from the top spot.</div>
      </div>
    </div>
  </div>
</section>

<!-- PACKAGES -->
<section class="packages-section" id="packages">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Packages &amp; Pricing</p>
      <h2 class="section-h2" style="text-align:center">Simple Monthly SEO <em>Packages</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">Month-to-month after 90 days. No long-term contracts. Choose the package that matches your current market and goals.</p>
    </div>
    <div class="packages-grid" data-reveal style="transition-delay:.1s">

      <div class="pkg-card">
        <div class="pkg-name">Local</div>
        <div class="pkg-price">$399</div>
        <div class="pkg-price-note">per month · cancel anytime after 90 days</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features">
          <li><i class="fa-solid fa-check"></i>Google Business Profile full optimization</li>
          <li><i class="fa-solid fa-check"></i>20 citation submissions per month</li>
          <li><i class="fa-solid fa-check"></i>Review request system setup</li>
          <li><i class="fa-solid fa-check"></i>NAP consistency audit &amp; fixes</li>
          <li><i class="fa-solid fa-check"></i>On-page SEO for 3 pages/month</li>
          <li><i class="fa-solid fa-check"></i>Monthly ranking report (30 keywords)</li>
          <li><i class="fa-solid fa-check"></i>Monthly 20-min strategy call</li>
          <li><i class="fa-solid fa-check"></i>Best for: 1-city agencies starting out</li>
        </ul>
        <button class="pkg-btn pkg-btn-default" onclick="openPopup()"><i class="fa-solid fa-arrow-right"></i>Get Started</button>
      </div>

      <div class="pkg-card featured">
        <div class="pkg-popular">Most Popular</div>
        <div class="pkg-name">Growth</div>
        <div class="pkg-price" style="color:#fff">$699</div>
        <div class="pkg-price-note">per month · cancel anytime after 90 days</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features">
          <li><i class="fa-solid fa-check"></i>Everything in Local</li>
          <li><i class="fa-solid fa-check"></i>40+ citation submissions per month</li>
          <li><i class="fa-solid fa-check"></i>Active review velocity management</li>
          <li><i class="fa-solid fa-check"></i>On-page SEO for 6 pages/month</li>
          <li><i class="fa-solid fa-check"></i>2 blog posts per month (SEO-targeted)</li>
          <li><i class="fa-solid fa-check"></i>AI Search SEO (GEO) optimization</li>
          <li><i class="fa-solid fa-check"></i>Monthly ranking report (75 keywords)</li>
          <li><i class="fa-solid fa-check"></i>Competitor gap analysis quarterly</li>
          <li><i class="fa-solid fa-check"></i>Monthly 30-min strategy call</li>
          <li><i class="fa-solid fa-check"></i>Best for: agencies in competitive FL cities</li>
        </ul>
        <button class="pkg-btn pkg-btn-featured" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get Started</button>
      </div>

      <div class="pkg-card">
        <div class="pkg-name">Dominate</div>
        <div class="pkg-price">$1,200</div>
        <div class="pkg-price-note">per month · cancel anytime after 90 days</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features">
          <li><i class="fa-solid fa-check"></i>Everything in Growth</li>
          <li><i class="fa-solid fa-check"></i>60+ citation submissions per month</li>
          <li><i class="fa-solid fa-check"></i>Multi-city SEO (up to 3 cities)</li>
          <li><i class="fa-solid fa-check"></i>4 blog posts per month</li>
          <li><i class="fa-solid fa-check"></i>Advanced AI Search SEO (full GEO)</li>
          <li><i class="fa-solid fa-check"></i>Monthly ranking report (100+ keywords)</li>
          <li><i class="fa-solid fa-check"></i>Link building outreach</li>
          <li><i class="fa-solid fa-check"></i>Weekly GBP updates &amp; posts</li>
          <li><i class="fa-solid fa-check"></i>Priority support + bi-weekly calls</li>
          <li><i class="fa-solid fa-check"></i>Best for: multi-location FL agencies</li>
        </ul>
        <button class="pkg-btn pkg-btn-default" onclick="openPopup()"><i class="fa-solid fa-arrow-right"></i>Get Started</button>
      </div>

    </div>

    <div style="text-align:center;margin-top:32px">
      <p style="font-size:14px;color:var(--muted);margin-bottom:16px">Need a website first? <a href="/seo/homecare-website-design.php" style="color:var(--teal);font-weight:600">See our Homecare Website Design packages starting at $699</a></p>
    </div>

  </div>
</section>

<!-- KEYWORDS WE TARGET -->
<section class="kw-section">
  <div class="container">
    <div class="kw-intro" data-reveal>
      <p class="section-label">Keyword Strategy</p>
      <h2 class="section-h2">The Florida Homecare Keywords<br><em>We Rank You For</em></h2>
      <p class="section-sub">We don't guess at keywords. Every term we target is researched for search volume, buying intent, and local competition — then mapped to the right page on your website.</p>
    </div>
    <div class="kw-grid" data-reveal style="transition-delay:.1s">
      <div class="kw-card"><div><div class="kw-term">home care agency [city] FL</div><div class="kw-intent">Highest commercial intent — ready to hire</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">homecare near me [city]</div><div class="kw-intent">Local + near-me — highest conversion rate</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">senior home care [city] Florida</div><div class="kw-intent">Family searching for an elderly parent</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">in-home care for elderly [city]</div><div class="kw-intent">Informational → decision stage buyer</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">24-hour home care [city]</div><div class="kw-intent">High urgency — premium private-pay client</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">caregiver jobs [city] FL</div><div class="kw-intent">Recruitment — attract quality caregivers</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">home health aide [county] FL</div><div class="kw-intent">County-level — broader service area reach</div></div><span class="kw-badge kw-med">MED</span></div>
      <div class="kw-card"><div><div class="kw-term">companion care services [city]</div><div class="kw-intent">Service-specific, non-medical care</div></div><span class="kw-badge kw-med">MED</span></div>
      <div class="kw-card"><div><div class="kw-term">personal care assistance [city]</div><div class="kw-intent">ADL support, Medicaid waiver keyword</div></div><span class="kw-badge kw-med">MED</span></div>
      <div class="kw-card"><div><div class="kw-term">homecare [neighborhood] FL</div><div class="kw-intent">Hyper-local — lower competition, high intent</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">best home care agency [city] 2025</div><div class="kw-intent">AI search &amp; voice search query</div></div><span class="kw-badge kw-med">MED</span></div>
      <div class="kw-card"><div><div class="kw-term">how to choose a home care agency [city]</div><div class="kw-intent">Blog + FAQ — educational, trust builder</div></div><span class="kw-badge kw-med">MED</span></div>
    </div>
  </div>
</section>

<!-- RESULTS -->
<section class="results-section" style="padding:80px 40px">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center;color:var(--teal-lt)"><span style="background:var(--teal-lt);display:inline-block;width:24px;height:2px;border-radius:2px;margin-right:8px;vertical-align:middle"></span>Proven Results</p>
      <h2 class="section-h2" style="color:#fff;text-align:center">What Our Florida Clients<br><em>Achieve in 6 Months</em></h2>
    </div>
    <div class="results-grid" data-reveal style="transition-delay:.1s">
      <div class="result-item"><div class="result-num">312%</div><div class="result-label">Average lead increase after 6 months of SEO</div></div>
      <div class="result-item"><div class="result-num">#1</div><div class="result-label">Google Maps position achieved within 5 months</div></div>
      <div class="result-item"><div class="result-num">67+</div><div class="result-label">New 5-star Google reviews in the first 90 days</div></div>
      <div class="result-item"><div class="result-num">60d</div><div class="result-label">Days to first visible Google Maps improvement</div></div>
    </div>
  </div>
</section>

<!-- FLORIDA CITIES -->
<section class="cities-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Florida Markets We Serve</p>
      <h2 class="section-h2">Local SEO for Homecare Agencies<br><em>Across Florida</em></h2>
      <p class="section-sub">We specialize in Florida's most competitive homecare markets — with city-specific keyword strategies, local knowledge, and proven results in each metro.</p>
    </div>
    <div class="cities-grid" data-reveal style="transition-delay:.1s">
      <a href="/home-care-miami-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">Miami</div><div class="city-county">Miami-Dade County</div></div></a>
      <a href="/home-care-orlando-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">Orlando</div><div class="city-county">Orange County</div></div></a>
      <a href="/home-care-tampa-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">Tampa</div><div class="city-county">Hillsborough County</div></div></a>
      <a href="/home-care-jacksonville-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">Jacksonville</div><div class="city-county">Duval County</div></div></a>
      <a href="/home-care-fort-lauderdale-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">Fort Lauderdale</div><div class="city-county">Broward County</div></div></a>
      <a href="/home-care-naples-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">Naples</div><div class="city-county">Collier County</div></div></a>
      <a href="/home-care-sarasota-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">Sarasota</div><div class="city-county">Sarasota County</div></div></a>
      <a href="/home-care-west-palm-beach-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">West Palm Beach</div><div class="city-county">Palm Beach County</div></div></a>
      <a href="/home-care-boca-raton-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">Boca Raton</div><div class="city-county">Palm Beach County</div></div></a>
      <a href="/home-care-clearwater-fl/" class="city-card"><div class="city-icon"><i class="fa-solid fa-location-dot"></i></div><div><div class="city-name">Clearwater</div><div class="city-county">Pinellas County</div></div></a>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Local SEO for Homecare —<br><em>Your Questions Answered</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How long before I see results from homecare SEO?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Most of our Florida homecare clients see meaningful Google Maps improvements within 60–90 days of starting. Organic search rankings typically follow within 4–6 months. The exact timeline depends on your current starting point, the competitiveness of your city, and how consistently we can execute the strategy. Miami and Fort Lauderdale are more competitive than Naples or Sarasota — but we've ranked agencies in all of them. Month 1 results are always visible because we track 50–100 keywords from day one.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">What makes homecare SEO different from general SEO?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Homecare agencies have a very specific keyword universe — terms like "personal care assistance," "companion care," "Medicaid waiver homecare," and "AHCA licensed home health agency" that a generalist agency wouldn't know to target. The trust signals families look for (caregiver background checks, state licensing, Google reviews) are different from other industries. The directories that matter for homecare citations (Caring.com, HomeCare.com, A Place for Mom) are industry-specific. Everything about homecare SEO is different — which is exactly why working with a homecare-only specialist produces dramatically better results.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do I need a website to start local SEO?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">You need at minimum a basic website — even a simple 3-page site gives Google something to evaluate. Without any website, local SEO is significantly limited. We offer <a href="/seo/homecare-website-design.php" style="color:var(--teal);font-weight:600">website design as a separate service starting at $699</a>, and many clients combine our website design and local SEO services for maximum results. If you already have a website, we'll audit it during our free review and let you know if any improvements are needed to support the SEO work.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Is there a long-term contract?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">No long-term contracts. All plans are month-to-month after the first 90 days. We ask for 90 days upfront because SEO requires a minimum runway to produce measurable results — anyone promising results in 30 days is not being honest with you. After those 90 days, you can cancel with 30 days notice. We keep clients through results, not contracts — and our retention rate reflects that.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can you help me get more Google reviews?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes — review management is one of our core services and one of the highest-impact things we do. We set up a systematic review request process built around homecare workflows — using email, SMS, and QR codes at the right moments in the client journey. Most of our Florida agencies generate 15–25 new 5-star Google reviews per month using this system. Reviews are a top-3 Google Maps ranking factor, so this alone can move your rankings significantly within 60–90 days.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">What is AI Search SEO and why does it matter for homecare?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">AI Search SEO (also called GEO — Generative Engine Optimization) is the practice of optimizing your content to appear in AI-generated answers on ChatGPT, Google AI Overviews, and Perplexity. In 2026, a growing number of families researching homecare ask AI tools "what's the best home care agency in Miami?" or "how do I find a caregiver for my mom in Tampa?" — and AI systems recommend specific agencies. We make sure your agency is the one they recommend. Your competitors almost certainly haven't optimized for this yet, giving you a significant first-mover advantage.</div></div>
      </div>

    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-content" data-reveal>
        <p class="section-label">Get Started Today</p>
        <h2 class="section-h2">Ready to Rank #1 in<br><em>Your Florida City?</em></h2>
        <p class="cta-desc">Book a free 30-minute SEO audit. We'll analyze your current Google Maps ranking, show you exactly what your top competitors are doing, and give you a 90-day roadmap to reach #1 — completely free, no obligation.</p>
        <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-magnifying-glass-chart"></i>Book My Free SEO Audit</button>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free audit &nbsp;·&nbsp; No obligation &nbsp;·&nbsp; No long-term contracts</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="https://images.unsplash.com/photo-1573496359142-b8d87734a5a2?w=600&q=80&fit=crop" alt="Homecare agency growing with local SEO in Florida">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Free Audit Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Google Maps ranking analysis</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Competitor comparison</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Citation &amp; review audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">90-day growth roadmap</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
