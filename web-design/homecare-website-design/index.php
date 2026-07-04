<?php
$page_title = "Home Care Agency Website Design | Homecare Creators";
$page_desc = "We build fast, mobile-first websites made only for home care agencies. They rank on Google, convert families into callers, and start at $699.";
$page_canonical = "https://homecarecreators.com/web-design/homecare-website-design/";
$og_title = "Website Design for Home Care Agencies | Homecare Creators";
$og_desc = "The only web design agency built 100% for home care. Sites load fast, rank #1 on Google, and turn visitors into new clients, starting at $699.";
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

/* HERO RIGHT - Mockup */
.hero-right{position:relative;z-index:2;height:100vh;min-height:680px;padding:120px 48px 60px 24px;display:flex;align-items:center;justify-content:center}
.site-mockup{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 32px 96px rgba(0,0,0,.4);width:100%;max-width:480px;animation:fadeUp .9s .4s ease both}
.mockup-bar{background:var(--forest);padding:12px 16px;display:flex;align-items:center;gap:10px}
.mockup-dots{display:flex;gap:6px}
.mockup-dot{width:10px;height:10px;border-radius:50%}
.mockup-url{flex:1;background:rgba(255,255,255,.1);border-radius:6px;padding:5px 12px;font-family:'Syne',sans-serif;font-size:10px;color:rgba(255,255,255,.6)}
.mockup-body{padding:0}
.mockup-hero-strip{background:linear-gradient(135deg,var(--forest),var(--forest-lt));padding:28px 24px}
.mockup-nav-line{display:flex;justify-content:space-between;align-items:center;margin-bottom:20px}
.mockup-logo-block{width:80px;height:10px;background:rgba(255,255,255,.4);border-radius:3px}
.mockup-nav-links{display:flex;gap:8px}
.mockup-nav-link{width:32px;height:7px;background:rgba(255,255,255,.25);border-radius:3px}
.mockup-h1-block{width:180px;height:16px;background:#fff;border-radius:4px;margin-bottom:10px}
.mockup-h2-block{width:130px;height:12px;background:var(--teal-lt);border-radius:4px;margin-bottom:16px}
.mockup-desc-block{width:100%;height:6px;background:rgba(255,255,255,.3);border-radius:3px;margin-bottom:6px}
.mockup-desc-block.short{width:70%}
.mockup-cta-block{display:flex;gap:8px;margin-top:16px}
.mockup-btn{height:28px;border-radius:7px;background:var(--teal)}
.mockup-btn.primary{width:100px}
.mockup-btn.secondary{width:80px;background:rgba(255,255,255,.15)}
.mockup-content{padding:20px 24px;background:var(--cream)}
.mockup-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px;margin-bottom:16px}
.mockup-stat{background:#fff;border-radius:8px;padding:10px;text-align:center}
.mockup-stat-num{font-family:'Syne',sans-serif;font-size:14px;font-weight:800;color:var(--teal)}
.mockup-stat-label{font-size:8px;color:var(--muted);margin-top:2px}
.mockup-cards{display:grid;grid-template-columns:1fr 1fr;gap:8px}
.mockup-card{background:#fff;border-radius:8px;padding:12px}
.mockup-card-img{height:40px;background:linear-gradient(135deg,var(--forest),var(--teal));border-radius:6px;margin-bottom:8px}
.mockup-card-line{height:6px;background:var(--border);border-radius:3px;margin-bottom:4px}
.mockup-card-line.short{width:60%}
.mockup-speed-badge{position:absolute;top:30%;right:-10px;background:#fff;border-radius:12px;padding:10px 14px;box-shadow:0 8px 32px rgba(0,0,0,.2);border:1px solid var(--border);animation:floatR 4s ease-in-out infinite}
.mockup-speed-num{font-family:'Syne',sans-serif;font-size:18px;font-weight:800;color:var(--teal)}
.mockup-speed-label{font-size:9px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600}
.mockup-rank-badge{position:absolute;bottom:25%;left:-14px;background:var(--forest);border-radius:12px;padding:10px 14px;box-shadow:0 8px 32px rgba(0,0,0,.3);border:1px solid rgba(46,198,143,.3);animation:floatR 5s ease-in-out infinite 1s}
.mockup-rank-num{font-family:'Instrument Serif',serif;font-size:22px;color:var(--teal-lt);line-height:1}
.mockup-rank-label{font-size:9px;color:rgba(255,255,255,.5);font-family:'Syne',sans-serif;font-weight:600}

/* TICKER */
.ticker-wrap{background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);overflow:hidden;padding:14px 0}
.ticker-inner{display:flex;width:max-content;animation:ticker 32s linear infinite}
.ticker-item{display:flex;align-items:center;gap:10px;padding:0 38px;font-family:'Syne',sans-serif;font-size:12px;font-weight:600;color:var(--muted);letter-spacing:.4px;text-transform:uppercase;white-space:nowrap}
.ticker-dot{width:5px;height:5px;border-radius:50%;background:var(--teal);flex-shrink:0}
.ticker-item i{color:var(--teal);font-size:13px}

/* WHAT YOU GET */
.what-section{background:#fff}
.what-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.what-body p{font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.what-points{display:flex;flex-direction:column;gap:14px;margin-top:28px}
.what-point{display:flex;gap:16px;align-items:flex-start;padding:18px;border-radius:16px;border:1px solid var(--border);background:var(--warm);transition:.3s}
.what-point:hover{border-color:rgba(29,158,117,.3);box-shadow:0 8px 32px rgba(10,46,30,.08);transform:translateX(4px)}
.what-point-icon{width:44px;height:44px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.what-point-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15px;color:var(--forest);margin-bottom:4px}
.what-point-desc{font-size:13.5px;line-height:1.6;color:var(--muted)}
.what-visual{position:relative;align-self:start}
.what-img{border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(10,46,30,.18);aspect-ratio:4/5}
.what-img img{width:100%;height:100%;object-fit:cover;display:block}
.what-img::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(10,46,30,.55) 100%);border-radius:var(--r-lg)}
.what-stat-float{position:absolute;bottom:-20px;right:-20px;background:#fff;border-radius:16px;padding:18px 22px;box-shadow:0 12px 48px rgba(10,46,30,.18);text-align:center;min-width:130px;border:1px solid var(--border);animation:floatR 5s ease-in-out infinite}
.what-stat-num{font-family:'Instrument Serif',serif;font-size:38px;color:var(--teal);line-height:1}
.what-stat-label{font-size:11px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600;margin-top:3px}
.what-badge-float{position:absolute;top:24px;left:-18px;background:var(--forest);border-radius:14px;padding:12px 18px;min-width:160px;box-shadow:0 8px 32px rgba(0,0,0,.25);border:1px solid rgba(29,158,117,.3);animation:floatR 7s ease-in-out infinite 1s}
.what-badge-row{display:flex;align-items:center;gap:10px}
.what-badge-icon{font-size:18px;color:var(--teal-lt)}
.what-badge-text{font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:#fff}
.what-badge-sub{font-size:10px;color:rgba(255,255,255,.5)}

/* HOW IT WORKS */
.how-section{background:var(--cream)}
.how-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:72px;position:relative}
.how-grid::before{content:'';position:absolute;top:44px;left:12%;right:12%;height:1px;background:linear-gradient(90deg,transparent,var(--teal) 20%,var(--teal) 80%,transparent);opacity:.25}
.how-step{text-align:center;padding:0 20px 48px;position:relative}
.how-step-num{width:88px;height:88px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-family:'Syne',sans-serif;font-weight:800;font-size:26px;position:relative;z-index:1;box-shadow:0 0 0 10px rgba(29,158,117,.08),0 8px 32px rgba(10,46,30,.2);transition:.3s}
.how-step:hover .how-step-num{background:var(--teal);box-shadow:0 0 0 10px rgba(29,158,117,.15),0 12px 40px rgba(29,158,117,.35)}
.how-step-icon{position:absolute;bottom:-4px;right:-4px;width:28px;height:28px;border-radius:50%;background:var(--teal-lt);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;box-shadow:0 2px 8px rgba(0,0,0,.2)}
.how-step-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15.5px;color:var(--forest);margin-bottom:10px}
.how-step-desc{font-size:13.5px;line-height:1.65;color:var(--muted)}

/* PACKAGES */
.packages-section{background:#fff}
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

/* WHAT INCLUDED FULL */
.included-section{background:var(--cream)}
.included-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:48px}
.inc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:24px;transition:.25s}
.inc-card:hover{box-shadow:0 8px 32px rgba(10,46,30,.08);border-color:rgba(29,158,117,.2)}
.inc-icon{width:46px;height:46px;border-radius:12px;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:20px;margin-bottom:16px}
.inc-card h3{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:8px}
.inc-card p{font-size:13px;color:var(--muted);line-height:1.7}

/* COMPARISON */
.compare-section{background:#fff}
.compare-table{width:100%;border-collapse:collapse;margin-top:48px;font-size:14px}
.compare-table th{background:var(--forest);color:#fff;font-family:'Syne',sans-serif;font-size:12px;font-weight:700;padding:16px 20px;text-align:left;letter-spacing:.5px}
.compare-table th:first-child{border-radius:var(--r) 0 0 0}
.compare-table th:last-child{border-radius:0 var(--r) 0 0;background:var(--teal)}
.compare-table td{padding:14px 20px;border-bottom:1px solid var(--border);color:var(--text);vertical-align:middle}
.compare-table tr:nth-child(even) td{background:var(--cream)}
.compare-table td:last-child{font-weight:600;color:var(--teal)}
.compare-check{color:var(--teal);font-size:16px}
.compare-cross{color:#d4554a;font-size:16px}
.compare-hl{background:rgba(29,158,117,.06)!important}

/* RESULTS */
.results-section{background:var(--forest)}
.results-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:56px;border:1px solid rgba(255,255,255,.08);border-radius:var(--r-lg);overflow:hidden}
.result-item{padding:36px 28px;text-align:center;border-right:1px solid rgba(255,255,255,.08)}
.result-item:last-child{border-right:none}
.result-num{font-family:'Instrument Serif',serif;font-size:52px;color:var(--teal-lt);line-height:1;margin-bottom:8px}
.result-label{font-family:'Syne',sans-serif;font-size:12px;font-weight:600;color:rgba(255,255,255,.5);letter-spacing:.5px}

/* PORTFOLIO */
.portfolio-section{background:var(--cream)}
.portfolio-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:48px}
.portfolio-card{background:#fff;border-radius:var(--r-lg);overflow:hidden;border:1px solid var(--border);transition:.3s}
.portfolio-card:hover{transform:translateY(-6px);box-shadow:0 20px 60px rgba(10,46,30,.12)}
.portfolio-img{height:220px;overflow:hidden;position:relative}
.portfolio-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.portfolio-card:hover .portfolio-img img{transform:scale(1.05)}
.portfolio-overlay{position:absolute;inset:0;background:linear-gradient(180deg,transparent 40%,rgba(10,46,30,.75))}
.portfolio-tag{position:absolute;top:14px;left:14px;background:var(--teal);color:#fff;font-family:'Syne',sans-serif;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px;letter-spacing:.5px}
.portfolio-body{padding:20px}
.portfolio-name{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:4px}
.portfolio-meta{font-size:13px;color:var(--muted)}
.portfolio-stat{display:flex;align-items:center;gap:6px;margin-top:12px;font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:var(--teal)}

/* FAQ */
.faq-section{background:#fff}
.faq-list{margin-top:40px;display:flex;flex-direction:column;gap:12px}
.faq-item{border:1px solid var(--border);border-radius:var(--r);overflow:hidden;background:var(--warm)}
.faq-q{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 24px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--forest)}
.faq-q-icon{width:28px;height:28px;border-radius:50%;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:12px;flex-shrink:0;transition:transform .25s,background .2s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal);color:#fff}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease}
.faq-item.open .faq-a{max-height:400px}
.faq-a-inner{padding:0 24px 20px;font-size:14px;color:var(--muted);line-height:1.8}

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
@media(max-width:1024px){.hero{grid-template-columns:1fr;min-height:auto}.hero-right{display:none}.hero-left{padding:140px 48px 80px}.packages-grid,.included-grid,.portfolio-grid{grid-template-columns:1fr 1fr}.results-grid{grid-template-columns:repeat(2,1fr)}.what-grid{grid-template-columns:1fr;gap:48px}.how-grid{grid-template-columns:repeat(2,1fr)}.cta-inner{grid-template-columns:1fr}.cta-image{display:none}}
@media(max-width:640px){section{padding:64px 20px}.packages-grid,.included-grid,.portfolio-grid,.results-grid{grid-template-columns:1fr}.how-grid{grid-template-columns:1fr}.compare-table{font-size:12px}}
CSS;
include '../../includes/header.php';
?>

<!-- HERO -->
<section class="hero" id="home" style="padding:0">
  <div class="hero-bg-grid"></div>
  <div class="hero-blob1"></div>
  <div class="hero-blob2"></div>
  <div class="hero-left">
    <div class="hero-badge"><div class="hero-badge-pulse"></div>Homecare Website Design &amp; Development</div>
    <h1 class="hero-h1">Websites That Win<br><em>Families &amp; Rank #1</em></h1>
    <div class="hero-tagline"><em>Built 100% for Homecare Agencies.</em><br><em>Not Templates. Not Shortcuts.</em></div>
    <p class="hero-desc">We design and build fast, mobile-first homecare websites. They turn visitors into phone calls, help you find caregivers, and start ranking on Google right away. No generalist agencies. No WordPress themes. Just websites built specifically for homecare, starting at $699.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get a Free Website Quote</button>
      <a href="#packages" class="btn-secondary"><i class="fa-solid fa-layer-group"></i>View Packages</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item"><div class="hero-proof-num">312%</div><div class="hero-proof-label">Avg Lead Increase</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">&lt;2s</div><div class="hero-proof-label">Load Speed</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Mobile Optimized</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">SEO</div><div class="hero-proof-label">Ready Day One</div></div>
    </div>
  </div>
  <div class="hero-right">
    <div style="position:relative;width:100%;max-width:480px">
      <div class="site-mockup">
        <div class="mockup-bar">
          <div class="mockup-dots"><div class="mockup-dot" style="background:#ff5f57"></div><div class="mockup-dot" style="background:#febc2e"></div><div class="mockup-dot" style="background:#28c840"></div></div>
          <div class="mockup-url">homecarecreators.com/miami-homecare</div>
        </div>
        <div class="mockup-body">
          <div class="mockup-hero-strip">
            <div class="mockup-nav-line">
              <div class="mockup-logo-block"></div>
              <div class="mockup-nav-links"><div class="mockup-nav-link"></div><div class="mockup-nav-link"></div><div class="mockup-nav-link"></div></div>
            </div>
            <div class="mockup-h1-block"></div>
            <div class="mockup-h2-block"></div>
            <div class="mockup-desc-block"></div>
            <div class="mockup-desc-block short"></div>
            <div class="mockup-cta-block"><div class="mockup-btn primary"></div><div class="mockup-btn secondary"></div></div>
          </div>
          <div class="mockup-content">
            <div class="mockup-stats">
              <div class="mockup-stat"><div class="mockup-stat-num">312%</div><div class="mockup-stat-label">Lead Growth</div></div>
              <div class="mockup-stat"><div class="mockup-stat-num">#1</div><div class="mockup-stat-label">Google Rank</div></div>
              <div class="mockup-stat"><div class="mockup-stat-num">67+</div><div class="mockup-stat-label">Reviews</div></div>
            </div>
            <div class="mockup-cards">
              <div class="mockup-card"><div class="mockup-card-img"></div><div class="mockup-card-line"></div><div class="mockup-card-line short"></div></div>
              <div class="mockup-card"><div class="mockup-card-img" style="background:linear-gradient(135deg,var(--teal),var(--teal-lt))"></div><div class="mockup-card-line"></div><div class="mockup-card-line short"></div></div>
            </div>
          </div>
        </div>
      </div>
      <div class="mockup-speed-badge">
        <div class="mockup-speed-num">99</div>
        <div class="mockup-speed-label">PageSpeed Score</div>
      </div>
      <div class="mockup-rank-badge">
        <div class="mockup-rank-num">#1</div>
        <div class="mockup-rank-label">Google Maps</div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════
   CERTIFICATIONS / TRUST BADGES
══════════════════════════ -->
<section class="certs">
  <div class="container">
    <p class="certs-label">Certified &amp; Trusted By</p>
    <div class="certs-row">
      <div class="cert-item"><img src="/images/blog/Homecarecreators-BBB-Certified.png" alt="Homecare Creators BBB accredited business certification badge" title="BBB Accredited Business" loading="lazy"><span>BBB Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-Google-my-business-profile.png" alt="Homecare Creators verified Google Business Profile badge" title="Verified Google Business Profile" loading="lazy"><span>Google Business Profile</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-google-partner.jpg" alt="Homecare Creators Google Partner certification badge" title="Google Partner Certified Agency" loading="lazy"><span>Google Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-hubspot-partner.webp" alt="Homecare Creators HubSpot certified partner badge" title="HubSpot Certified Partner" loading="lazy"><span>HubSpot Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-meta-certificate.jpg" alt="Homecare Creators Meta certified marketing partner badge" title="Meta Certified Marketing Partner" loading="lazy"><span>Meta Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-semrush-ceticificate.png" alt="Homecare Creators SEMrush certified SEO partner badge" title="SEMrush Certified Agency Partner" loading="lazy"><span>SEMrush Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-NACH.webp" alt="Homecare Creators National Association for Home Care and Hospice member badge" title="NAHC Member Agency" loading="lazy"><span>NAHC Member</span></div>
    </div>
  </div>
</section>

<!-- TICKER -->
<div class="ticker-wrap" aria-hidden="true">
  <div class="ticker-inner">
    <div class="ticker-item"><i class="fa-solid fa-laptop-code"></i>Custom Homecare Website Design</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-mobile-screen"></i>Mobile-First Development</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>SEO-Ready From Day One</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-bolt"></i>Under 2-Second Load Speed</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>Google Reviews Widget Built In</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-map-location-dot"></i>Service Area Pages Included</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-users"></i>Caregiver Recruitment Page</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-laptop-code"></i>Custom Homecare Website Design</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-mobile-screen"></i>Mobile-First Development</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>SEO-Ready From Day One</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-bolt"></i>Under 2-Second Load Speed</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>Google Reviews Widget Built In</div>
  </div>
</div>

<!-- WHAT YOU GET -->
<section class="what-section">
  <div class="container">
    <div class="what-grid">
      <div data-reveal>
        <p class="section-label">Why It Matters</p>
        <h2 class="section-h2">Your Website Is Your<br><em>#1 Growth Asset</em></h2>
        <p style="font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:16px">Most homecare agency websites were built by generalist developers who have never heard of AHCA licensing, Medicaid waiver programs, or the specific trust signals families need before they call. The result? A website that looks okay but generates almost no leads.</p>
        <p style="font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:24px">We build every page and every word specifically for homecare, right down to which trust signal shows up first for a daughter searching for help at 11pm. Families in Miami, Tampa, Orlando, or anywhere else in Florida land on your site and feel like they found the right agency immediately. That's what a specialist gets you that a generalist can't.</p>
        <div class="what-points">
          <div class="what-point">
            <div class="what-point-icon"><i class="fa-solid fa-bolt"></i></div>
            <div><div class="what-point-title">Under 2-Second Load Speed Guaranteed</div><div class="what-point-desc">Slow sites lose families in under 3 seconds. We optimize every image, script, and element so your site loads fast on both mobile and desktop.</div></div>
          </div>
          <div class="what-point">
            <div class="what-point-icon"><i class="fa-brands fa-google"></i></div>
            <div><div class="what-point-title">SEO-Optimized From the Ground Up</div><div class="what-point-desc">Every page ships with your target keywords, schema markup, and local SEO structure already baked in, so you're ranking from day one instead of month six.</div></div>
          </div>
          <div class="what-point">
            <div class="what-point-icon"><i class="fa-solid fa-heart-pulse"></i></div>
            <div><div class="what-point-title">Built to Convert Families Into Clients</div><div class="what-point-desc">Trust signals, caregiver profiles, service pages, and clear CTAs all designed to turn website visitors into phone calls and inquiry form submissions.</div></div>
          </div>
          <div class="what-point">
            <div class="what-point-icon"><i class="fa-solid fa-users"></i></div>
            <div><div class="what-point-title">Caregiver Recruitment Built In</div><div class="what-point-desc">A dedicated caregiver careers page with job listings, an application form, and keyword optimization for "caregiver jobs [city]." It quietly becomes your best hiring tool.</div></div>
          </div>
        </div>
      </div>
      <div class="what-visual" data-reveal style="transition-delay:.15s">
        <div class="what-img">
          <img src="/images/home/hero-caregiver-elderly.jpg" alt="Professional home care agency website design showcasing a caregiver with an elderly client" title="Home care agency website design example">
        </div>
        <div class="what-stat-float">
          <div class="what-stat-num">312%</div>
          <div class="what-stat-label">Avg Lead Increase</div>
        </div>
        <div class="what-badge-float">
          <div class="what-badge-row">
            <div class="what-badge-icon"><i class="fa-solid fa-circle-check"></i></div>
            <div>
              <div class="what-badge-text">Website Live in 14 Days</div>
              <div class="what-badge-sub">From kickoff to launch</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">How It Works</p>
      <h2 class="section-h2" style="text-align:center">From Zero to <em>Live in 14 Days</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">A clear, structured process built around your agency. No back-and-forth confusion, no delays.</p>
    </div>
    <div class="how-grid" data-reveal style="transition-delay:.1s">
      <div class="how-step">
        <div class="how-step-num">1<div class="how-step-icon"><i class="fa-solid fa-comments"></i></div></div>
        <div class="how-step-title">Discovery Call</div>
        <div class="how-step-desc">We get to know your agency: the city you serve, the services you offer, and what you're actually trying to accomplish. This 30-minute call shapes every design and content decision that follows.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">2<div class="how-step-icon"><i class="fa-solid fa-pen-ruler"></i></div></div>
        <div class="how-step-title">Design &amp; Copy</div>
        <div class="how-step-desc">We write all the copy and design your site. No writing required from you. You get homecare-specific content that ranks on Google and converts families.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">3<div class="how-step-icon"><i class="fa-solid fa-eye"></i></div></div>
        <div class="how-step-title">Review &amp; Refine</div>
        <div class="how-step-desc">You review the full design and request any changes. We refine until it's exactly right. Most clients need only one round of revisions.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">4<div class="how-step-icon"><i class="fa-solid fa-rocket"></i></div></div>
        <div class="how-step-title">Launch &amp; Rank</div>
        <div class="how-step-desc">We launch your site, submit it to Google, and set up Analytics and Search Console. Your SEO journey starts the moment we hit publish.</div>
      </div>
    </div>
  </div>
</section>

<!-- PACKAGES -->
<section class="packages-section" id="packages">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Packages &amp; Pricing</p>
      <h2 class="section-h2" style="text-align:center">Simple, Transparent <em>Website Pricing</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">Three packages to match where your agency is today. Each one includes custom design, SEO setup, and mobile optimization on top of everything listed below. No hidden fees.</p>
    </div>
    <div class="packages-grid" data-reveal style="transition-delay:.1s">

      <div class="pkg-card">
        <div class="pkg-name">Starter</div>
        <div class="pkg-price">$699</div>
        <div class="pkg-price-note">one-time + $79/mo hosting</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features">
          <li><i class="fa-solid fa-check"></i>5 custom pages (Home, About, Services, Careers, Contact)</li>
          <li><i class="fa-solid fa-check"></i>Mobile-first design with your branding</li>
          <li><i class="fa-solid fa-check"></i>On-page SEO for all 5 pages</li>
          <li><i class="fa-solid fa-check"></i>Google Reviews widget</li>
          <li><i class="fa-solid fa-check"></i>Contact &amp; inquiry form</li>
          <li><i class="fa-solid fa-check"></i>Google Analytics + Search Console setup</li>
          <li><i class="fa-solid fa-check"></i>Under 2-second load speed</li>
          <li><i class="fa-solid fa-check"></i>SSL security certificate</li>
          <li><i class="fa-solid fa-check"></i>Live in 10–14 days</li>
        </ul>
        <button class="pkg-btn pkg-btn-default" onclick="openPopup()"><i class="fa-solid fa-arrow-right"></i>Get Started</button>
      </div>

      <div class="pkg-card featured">
        <div class="pkg-popular">Most Popular</div>
        <div class="pkg-name">Growth</div>
        <div class="pkg-price" style="color:#fff">$999</div>
        <div class="pkg-price-note">one-time + $79/mo hosting</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features">
          <li><i class="fa-solid fa-check"></i>Everything in Starter</li>
          <li><i class="fa-solid fa-check"></i>10 custom pages including service pages</li>
          <li><i class="fa-solid fa-check"></i>3 Florida city service area pages</li>
          <li><i class="fa-solid fa-check"></i>Caregiver careers &amp; jobs page (SEO-optimized)</li>
          <li><i class="fa-solid fa-check"></i>LocalBusiness schema markup</li>
          <li><i class="fa-solid fa-check"></i>Blog setup (ready for content)</li>
          <li><i class="fa-solid fa-check"></i>Google Business Profile optimization</li>
          <li><i class="fa-solid fa-check"></i>Formspree contact form integration</li>
          <li><i class="fa-solid fa-check"></i>Live chat widget setup</li>
          <li><i class="fa-solid fa-check"></i>Live in 14 days</li>
        </ul>
        <button class="pkg-btn pkg-btn-featured" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get Started</button>
      </div>

      <div class="pkg-card">
        <div class="pkg-name">Dominate</div>
        <div class="pkg-price">$1,699</div>
        <div class="pkg-price-note">one-time + $79/mo hosting</div>
        <div class="pkg-divider"></div>
        <ul class="pkg-features">
          <li><i class="fa-solid fa-check"></i>Everything in Growth</li>
          <li><i class="fa-solid fa-check"></i>15+ custom pages</li>
          <li><i class="fa-solid fa-check"></i>8 Florida city service area pages</li>
          <li><i class="fa-solid fa-check"></i>Custom brand identity (logo + colors)</li>
          <li><i class="fa-solid fa-check"></i>AI chatbot integration</li>
          <li><i class="fa-solid fa-check"></i>Video background hero section</li>
          <li><i class="fa-solid fa-check"></i>Team / caregiver profiles page</li>
          <li><i class="fa-solid fa-check"></i>FAQ page with schema markup</li>
          <li><i class="fa-solid fa-check"></i>Priority support &amp; 1 strategy call/mo</li>
          <li><i class="fa-solid fa-check"></i>Live in 21 days</li>
        </ul>
        <button class="pkg-btn pkg-btn-default" onclick="openPopup()"><i class="fa-solid fa-arrow-right"></i>Get Started</button>
      </div>

    </div>

    <!-- Internal link to Local SEO -->
    <div style="background:rgba(29,158,117,.06);border:1px solid rgba(29,158,117,.2);border-radius:16px;padding:28px 32px;margin-top:32px;display:flex;align-items:center;gap:20px;flex-wrap:wrap">
      <i class="fa-solid fa-magnifying-glass-chart" style="font-size:28px;color:var(--teal)"></i>
      <div style="flex:1"><div style="font-family:Syne,sans-serif;font-weight:700;font-size:16px;color:var(--forest);margin-bottom:4px">Rank Your New Website #1 on Google</div><p style="font-size:14px;color:var(--muted)">Pair your website with our <a href="/seo/local-seo-for-home-care-agencies" style="color:var(--teal);font-weight:600">Local SEO for Home Care Agencies</a> plan for Google Maps rankings, starting at $399/mo.</p></div>
      <a href="/seo/local-seo-for-home-care-agencies" class="btn-primary" style="white-space:nowrap;font-size:13px;padding:12px 20px"><i class="fa-solid fa-arrow-right"></i>View SEO Plans</a>
    </div>

  </div>
</section>

<!-- WHAT'S INCLUDED -->
<section class="included-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Every Website Includes</p>
      <h2 class="section-h2">Everything Built In.<br><em>Nothing Left Out.</em></h2>
      <p class="section-sub">Every homecare website we build includes these non-negotiables. Anything less and you're leaving leads and rankings on the table.</p>
    </div>
    <div class="included-grid" data-reveal style="transition-delay:.1s">
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-mobile-screen"></i></div><h3>100% Mobile-First Design</h3><p>Over 70% of families searching for homecare are doing it from a phone. We design for mobile first and scale up from there, not the other way around.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-brands fa-google"></i></div><h3>On-Page SEO Built In</h3><p>Proper H1/H2 structure, keyword-optimized meta titles and descriptions, image alt text, internal linking, clean URLs. We handle all of it.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-bolt"></i></div><h3>Sub-2 Second Load Speed</h3><p>Lazy-loaded images, minified code, efficient hosting, no bloated plugins slowing things down. Google rewards fast sites, and families won't wait around for a slow one.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-star"></i></div><h3>Google Reviews Widget</h3><p>Your real Google reviews, pulled live onto your homepage. It's the single strongest trust signal when a family is deciding between two agencies.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-map-location-dot"></i></div><h3>Service Area Pages</h3><p>A dedicated page for every city and neighborhood you serve, each one built to rank for searches like "[city] home care" in your market.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-users"></i></div><h3>Caregiver Recruitment Page</h3><p>A fully optimized careers page that ranks for "caregiver jobs [city]" searches, so your website is recruiting staff around the clock, not just generating client leads.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-code"></i></div><h3>Schema Markup</h3><p>LocalBusiness, FAQPage, and Service schema markup, implemented the right way. It tells Google exactly what your agency does and where, which improves your odds of showing up with rich results.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-chart-line"></i></div><h3>Analytics &amp; Search Console</h3><p>Google Analytics 4 and Search Console are connected and configured before launch, so you can see every visit, call, and form submission starting day one.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-shield-halved"></i></div><h3>SSL Security &amp; Hosting</h3><p>Secure HTTPS certificate, reliable hosting at 99.9% uptime, and daily backups, all part of your $79/mo hosting plan. Your site stays up.</p></div>
    </div>
  </div>
</section>

<!-- COMPARISON -->
<section class="compare-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">How We Compare</p>
      <h2 class="section-h2">Homecare Creators vs<br><em>Everyone Else</em></h2>
      <p class="section-sub">Here's what you get when you work with a specialist vs a generalist agency or a DIY website builder.</p>
    </div>
    <div style="overflow-x:auto;margin-top:0" data-reveal style="transition-delay:.1s">
      <table class="compare-table">
        <thead>
          <tr>
            <th>Feature</th>
            <th>DIY Builder (Wix/Squarespace)</th>
            <th>Generalist Agency</th>
            <th>Homecare Creators ✓</th>
          </tr>
        </thead>
        <tbody>
          <tr><td>Homecare-specific copy &amp; content</td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
          <tr class="compare-hl"><td>Florida local SEO built in</td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td>Sometimes</td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
          <tr><td>Service area pages per city</td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td>Extra cost</td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
          <tr class="compare-hl"><td>Caregiver recruitment page</td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
          <tr><td>Schema markup (LocalBusiness + FAQ)</td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td>Rarely</td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
          <tr class="compare-hl"><td>Google Reviews widget built in</td><td>Plugin only</td><td>Extra cost</td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
          <tr><td>Under 2-second load speed</td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td>Sometimes</td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
          <tr class="compare-hl"><td>Knows AHCA &amp; Florida homecare market</td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
          <tr><td>Live in 14 days</td><td>Self-paced</td><td>6–12 weeks</td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
          <tr class="compare-hl"><td>Ongoing SEO support available</td><td><i class="fa-solid fa-xmark compare-cross"></i></td><td>Yes (expensive)</td><td><i class="fa-solid fa-check compare-check"></i></td></tr>
        </tbody>
      </table>
    </div>
  </div>
</section>

<!-- RESULTS -->
<section class="results-section" style="padding:80px 40px">
  <div class="container">
    <div style="text-align:center;margin-bottom:0" data-reveal>
      <p class="section-label" style="justify-content:center;color:var(--teal-lt)"><span style="background:var(--teal-lt);display:inline-block;width:24px;height:2px;border-radius:2px;margin-right:8px;vertical-align:middle"></span>The Results</p>
      <h2 class="section-h2" style="color:#fff;text-align:center">What Happens After<br><em>Your Site Goes Live</em></h2>
    </div>
    <div class="results-grid" data-reveal style="transition-delay:.1s">
      <div class="result-item"><div class="result-num">312%</div><div class="result-label">Average lead increase in 6 months</div></div>
      <div class="result-item"><div class="result-num">#1</div><div class="result-label">Google Maps position within 5 months</div></div>
      <div class="result-item"><div class="result-num">67+</div><div class="result-label">New Google reviews in 90 days</div></div>
      <div class="result-item"><div class="result-num">14</div><div class="result-label">Days from kickoff to live website</div></div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Website Design,<br><em>Your Questions Answered</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do I need to write any content or copy myself?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">No. We write all the copy for your website: homepage, about page, service pages, careers page, everything in between. You give us the basics on your agency (services, areas covered, your story) and we turn that into content that ranks on Google and actually gets families to pick up the phone.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How long does it take to build my website?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">The Starter package goes live in 10–14 days from kickoff. Growth takes 14 days. Dominate takes up to 21 days. The only thing that can slow this down is a delay in getting basic agency info from you, like your logo, photos, or service list. We move fast because every day without a proper website is a day you're handing leads to your competitors.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Will my website rank on Google after it's built?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Your website is built with on-page SEO best practices from day one: proper keyword placement, meta tags, schema markup, clean URL structure, fast load speeds. That gives you the best possible foundation to start from. Most clients see Google Maps improvements within 60–90 days and organic growth within 4–6 months. Our Local SEO retainer ($399/mo) speeds this up considerably, handling citation building, review management, and ongoing content.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">What if I already have a website?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">We can rebuild your existing site or start over from scratch, whichever makes more sense for you. During our free audit, we check your current site's speed, SEO health, mobile performance, and conversion rate. If it's worth saving, we improve it. If it's holding you back, we replace it. Either way, we handle the migration so your existing Google rankings and traffic don't take a hit during the switch.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">What is the $79/mo hosting fee for?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">The $79/mo hosting covers fast, reliable hosting at 99.9% uptime, an SSL certificate, daily backups, software updates, basic security monitoring, and access to our support team for minor edits like text changes or photo swaps. It's an all-in maintenance package, so you're not the one who has to worry about the site going down or getting hacked.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How much does a homecare website cost?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Our homecare website packages start at $699 one-time for the Starter (5 pages), $999 for Growth (10 pages plus service area pages), and $1,699 for Dominate (15+ pages plus full brand identity). Each package is a one-time design fee plus $79/mo hosting. No hidden fees. The price you see is the price you pay.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you build websites for homecare agencies outside Florida?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes. Florida homecare agencies are our main focus, especially in Miami, Tampa, Orlando, Jacksonville, Fort Lauderdale, and Naples, but we also work with agencies across our other target states: Texas, California, and Pennsylvania. The homecare-specific expertise we bring applies no matter which US market you're in.</div></div>
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
        <h2 class="section-h2">Ready for a Website That<br><em>Actually Grows Your Agency?</em></h2>
        <p class="cta-desc">Book a free 30-minute call. We'll audit your current digital presence, show you what's actually costing you leads, and hand you a clear plan. No obligation, no sales pressure.</p>
        <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get My Free Website Quote</button>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free quote &nbsp;·&nbsp; No obligation &nbsp;·&nbsp; Live in 14 days guaranteed</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/home/service-website-dev.jpg" alt="Home care agency website design results delivered by Homecare Creators" title="Home care agency website design results">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Your Quote Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Current website audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Custom package recommendation</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Competitor analysis</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Fixed price, no surprises</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>
