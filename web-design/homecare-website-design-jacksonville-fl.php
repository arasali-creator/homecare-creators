<?php
$page_title = "Homecare Website Design in Jacksonville, FL | Homecare Creators";
$page_desc = "Homecare website design for Jacksonville, FL agencies. We build fast sites that rank on Google, win family trust, and fill caregiver openings.";
$page_canonical = "https://homecarecreators.com/homecare-website-design-jacksonville-fl/";
$og_title = "Homecare Website Design Jacksonville FL | Homecare Creators";
$og_desc = "Jacksonville, FL homecare website design from a team that works only with home care agencies. Rank on Google and recruit caregivers, from $699.";
$page_css = <<<CSS
/* HERO */
.hero{min-height:88vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:120px 80px 80px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-200px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-blob2{position:absolute;width:500px;height:500px;bottom:-150px;left:-100px;background:radial-gradient(circle,rgba(201,168,76,.1) 0%,transparent 65%);animation:float 13s ease-in-out infinite reverse}
.hero-content{position:relative;z-index:2;max-width:820px}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb a:hover{color:rgba(255,255,255,.7)}
.hero-breadcrumb span{color:var(--teal-lt)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:28px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite;flex-shrink:0}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(36px,5vw,64px);line-height:1.06;color:#fff;margin-bottom:22px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:19px;line-height:1.78;color:rgba(255,255,255,.65);max-width:580px;margin-bottom:40px;animation:fadeUp .8s .25s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .38s ease both;margin-bottom:52px}
.hero-proof{display:flex;gap:32px;flex-wrap:wrap;animation:fadeUp .8s .5s ease both}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:34px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-proof-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch}

/* TICKER */
.ticker-wrap{background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);overflow:hidden;padding:14px 0}
.ticker-inner{display:flex;width:max-content;animation:ticker 32s linear infinite}
.ticker-item{display:flex;align-items:center;gap:10px;padding:0 38px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--muted);letter-spacing:.4px;text-transform:uppercase;white-space:nowrap}
.ticker-dot{width:5px;height:5px;border-radius:50%;background:var(--teal);flex-shrink:0}
.ticker-item i{color:var(--teal);font-size:13px}

/* TWO COL */
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:start}
.two-col-center{display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.body-text p{font-size:18px;line-height:1.82;color:var(--muted);margin-bottom:16px}

/* MARKET FACTS */
.market-facts{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:8px}
.fact-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r);padding:22px;border-left:4px solid var(--teal)}
.fact-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;color:var(--teal);line-height:1;margin-bottom:6px}
.fact-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--forest);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
.fact-card p{font-size:14.5px;color:var(--muted);line-height:1.6}

/* WHY POINTS */
.why-points{display:flex;flex-direction:column;gap:13px;margin-top:28px}
.why-point{display:flex;gap:16px;align-items:flex-start;padding:18px;border-radius:16px;border:1px solid var(--border);background:var(--warm);transition:.3s}
.why-point:hover{border-color:rgba(29,158,117,.3);box-shadow:0 8px 32px rgba(10,46,30,.08);transform:translateX(4px)}
.why-point-icon{width:44px;height:44px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.why-point-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--forest);margin-bottom:4px}
.why-point-desc{font-size:15px;line-height:1.65;color:var(--muted)}

/* VISUAL FLOAT */
.visual-wrap{position:relative}
.visual-img{border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(10,46,30,.18);aspect-ratio:4/5}
.visual-img img{width:100%;height:100%;object-fit:cover;display:block}
.visual-img::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(10,46,30,.55) 100%);border-radius:var(--r-lg)}
.float-stat{position:absolute;bottom:-20px;right:-20px;background:#fff;border-radius:16px;padding:18px 22px;box-shadow:0 12px 48px rgba(10,46,30,.18);text-align:center;min-width:130px;border:1px solid var(--border);animation:floatR 5s ease-in-out infinite}
.float-stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:38px;color:var(--teal);line-height:1}
.float-stat-label{font-size:11px;color:var(--muted);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;margin-top:3px}
.float-badge{position:absolute;top:24px;left:-18px;background:var(--forest);border-radius:14px;padding:12px 18px;min-width:168px;box-shadow:0 8px 32px rgba(0,0,0,.25);border:1px solid rgba(29,158,117,.3);animation:floatR 7s ease-in-out infinite 1s}
.float-badge-row{display:flex;align-items:center;gap:10px}
.float-badge-icon{font-size:18px;color:var(--teal-lt)}
.float-badge-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#fff}
.float-badge-sub{font-size:10px;color:rgba(255,255,255,.5)}

/* HOW IT WORKS */
.how-section{background:#fff}
.how-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:72px;position:relative}
.how-grid::before{content:'';position:absolute;top:44px;left:12%;right:12%;height:1px;background:linear-gradient(90deg,transparent,var(--teal) 20%,var(--teal) 80%,transparent);opacity:.25}
.how-step{text-align:center;padding:0 20px 48px;position:relative}
.how-num{width:88px;height:88px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:26px;position:relative;z-index:1;box-shadow:0 0 0 10px rgba(29,158,117,.08),0 8px 32px rgba(10,46,30,.2);transition:.3s}
.how-step:hover .how-num{background:var(--teal);box-shadow:0 0 0 10px rgba(29,158,117,.15),0 12px 40px rgba(29,158,117,.35)}
.how-icon{position:absolute;bottom:-4px;right:-4px;width:28px;height:28px;border-radius:50%;background:var(--teal-lt);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;box-shadow:0 2px 8px rgba(0,0,0,.2)}
.how-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--forest);margin-bottom:10px}
.how-desc{font-size:15.5px;line-height:1.65;color:var(--muted)}

/* WHAT'S INCLUDED */
.inc-section{background:var(--cream)}
.inc-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:44px}
.inc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:22px;transition:.25s}
.inc-card:hover{box-shadow:0 8px 32px rgba(10,46,30,.08);border-color:rgba(29,158,117,.2);transform:translateY(-2px)}
.inc-icon{width:44px;height:44px;border-radius:11px;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:19px;margin-bottom:14px}
.inc-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest);margin-bottom:7px}
.inc-card p{font-size:15px;color:var(--muted);line-height:1.7}

/* PACKAGES */
.pkg-section{background:#fff}
.pkg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:52px}
.pkg-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r-lg);padding:34px 30px;position:relative;transition:.3s}
.pkg-card:hover{transform:translateY(-6px);box-shadow:0 24px 64px rgba(10,46,30,.1)}
.pkg-card.featured{background:var(--forest);border-color:var(--teal);box-shadow:0 16px 64px rgba(10,46,30,.3)}
.pkg-pop{position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;padding:5px 18px;border-radius:20px;white-space:nowrap}
.pkg-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--teal);margin-bottom:10px}
.pkg-card.featured .pkg-name{color:var(--teal-lt)}
.pkg-price{font-family:'Plus Jakarta Sans',sans-serif;font-size:50px;color:var(--forest);line-height:1;margin-bottom:4px}
.pkg-card.featured .pkg-price{color:#fff}
.pkg-note{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;color:var(--muted);margin-bottom:22px}
.pkg-card.featured .pkg-note{color:rgba(255,255,255,.5)}
.pkg-div{height:1px;background:var(--border);margin-bottom:22px}
.pkg-card.featured .pkg-div{background:rgba(255,255,255,.1)}
.pkg-list{list-style:none;display:flex;flex-direction:column;gap:9px;margin-bottom:28px}
.pkg-list li{display:flex;align-items:flex-start;gap:9px;font-size:13px;color:var(--muted);line-height:1.5}
.pkg-card.featured .pkg-list li{color:rgba(255,255,255,.7)}
.pkg-list li i{color:var(--teal);font-size:11px;margin-top:2px;flex-shrink:0}
.pkg-card.featured .pkg-list li i{color:var(--teal-lt)}
.pkg-btn{width:100%;padding:13px;border-radius:10px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:.2s}
.pkg-btn-dark{background:var(--forest);color:#fff}
.pkg-btn-dark:hover{background:var(--teal)}
.pkg-btn-teal{background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;box-shadow:0 4px 20px rgba(29,158,117,.4)}
.pkg-btn-teal:hover{box-shadow:0 8px 32px rgba(29,158,117,.55);transform:translateY(-2px)}

/* KEYWORDS */
.kw-section{background:var(--cream)}
.kw-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:11px;margin-top:32px}
.kw-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:15px 18px;display:flex;align-items:center;justify-content:space-between;gap:12px;transition:border-color .2s}
.kw-card:hover{border-color:var(--teal)}
.kw-term{font-size:13.5px;font-weight:500;color:var(--forest)}
.kw-intent{font-size:13px;color:var(--muted);margin-top:2px}
.kw-badge{font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;white-space:nowrap}
.kw-high{background:rgba(29,158,117,.1);color:var(--forest-lt)}
.kw-med{background:rgba(201,168,76,.12);color:#7a5f18}

/* AREAS */
.areas-section{background:#fff}
.areas-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:10px;margin-top:30px}
.area-pill{background:var(--warm);border:1px solid var(--border);border-radius:9px;padding:11px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--forest);display:flex;align-items:center;gap:7px;transition:all .2s}
.area-pill:hover{border-color:var(--teal);color:var(--teal);transform:translateY(-1px)}
.area-dot{width:6px;height:6px;border-radius:50%;background:var(--teal);flex-shrink:0}

/* FAQ */
.faq-section{background:var(--cream)}
.faq-list{margin-top:36px;display:flex;flex-direction:column;gap:11px}
.faq-item{border:1px solid var(--border);border-radius:var(--r);overflow:hidden;background:#fff}
.faq-q{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:18px 22px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest)}
.faq-q-icon{width:26px;height:26px;border-radius:50%;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:11px;flex-shrink:0;transition:transform .25s,background .2s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal);color:#fff}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease}
.faq-item.open .faq-a{max-height:350px}
.faq-a-inner{padding:0 22px 18px;font-size:15.5px;color:var(--muted);line-height:1.8}

/* RESULTS */
.results-section{background:var(--forest);padding:72px 40px}
.results-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:48px;border:1px solid rgba(255,255,255,.08);border-radius:var(--r-lg);overflow:hidden}
.result-item{padding:32px 24px;text-align:center;border-right:1px solid rgba(255,255,255,.08)}
.result-item:last-child{border-right:none}
.result-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:48px;color:var(--teal-lt);line-height:1;margin-bottom:8px}
.result-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:rgba(255,255,255,.5);letter-spacing:.5px}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:96px 40px}
.cta-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.cta-h2{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(28px,4vw,48px);line-height:1.1;color:#fff;margin-bottom:16px}
.cta-h2 em{color:var(--teal-lt);font-style:italic}
.cta-desc{font-size:18px;color:rgba(255,255,255,.68);line-height:1.78;margin-bottom:30px}
.cta-guarantee{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.45);display:flex;align-items:center;gap:8px;margin-top:16px}
.cta-guarantee i{color:var(--teal-lt)}
.cta-img-wrap{position:relative;border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3)}
.cta-img-wrap img{width:100%;height:380px;object-fit:cover;display:block}
.cta-img-badge{position:absolute;bottom:18px;left:18px;right:18px;background:rgba(10,46,30,.88);backdrop-filter:blur(12px);border:1px solid rgba(46,198,143,.22);border-radius:12px;padding:15px 17px}
.cta-img-badge-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:#fff;margin-bottom:9px}
.cta-badge-row{display:flex;align-items:center;gap:7px;margin-bottom:5px}
.cta-badge-row:last-child{margin-bottom:0}
.cta-badge-dot{width:5px;height:5px;border-radius:50%;background:var(--teal-lt);flex-shrink:0}
.cta-badge-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;color:rgba(255,255,255,.65)}

/* RESPONSIVE */
@media(max-width:960px){.two-col,.two-col-center,.cta-inner{grid-template-columns:1fr;gap:40px}.inc-grid,.pkg-grid{grid-template-columns:1fr 1fr}.results-grid{grid-template-columns:repeat(2,1fr)}.how-grid{grid-template-columns:repeat(2,1fr)}.cta-img-wrap{display:none}.hero{padding:110px 40px 60px}}
@media(max-width:640px){section{padding:60px 20px}.inc-grid,.pkg-grid,.results-grid{grid-template-columns:1fr}.how-grid{grid-template-columns:1fr}.hero{padding:100px 20px 60px}.market-facts{grid-template-columns:1fr}}
CSS;
include '../includes/header.php';
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-blob1"></div>
  <div class="hero-blob2"></div>
  <div class="hero-content">
    <div class="hero-breadcrumb"><a href="https://homecarecreators.com">Home</a> / <a href="/homecare-website-design/">Website Design</a> / <span>Jacksonville, FL</span></div>
    <div class="hero-badge"><div class="hero-badge-pulse"></div>Homecare Website Design for Jacksonville, FL</div>
    <h1 class="hero-h1">Homecare Website Design<br>in <em>Jacksonville, Florida</em></h1>
    <p class="hero-desc">We build homecare websites for Jacksonville agencies, and only homecare websites. Mobile-first sites that rank on Google, earn trust with Duval County families, and keep caregiver applications coming in. Packages start at $699.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get Your Jacksonville Website Quote</button>
      <a href="/homecare-website-design/" class="btn-secondary"><i class="fa-solid fa-arrow-left"></i>View All Packages</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item"><div class="hero-proof-num">312%</div><div class="hero-proof-label">Avg Lead Increase</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">&lt;2s</div><div class="hero-proof-label">Load Speed</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">14</div><div class="hero-proof-label">Days to Live</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">$0</div><div class="hero-proof-label">Free Quote</div></div>
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
    <div class="ticker-item"><i class="fa-solid fa-laptop-code"></i>Jacksonville Homecare Website Design</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-map-location-dot"></i>Duval County SEO</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-mobile-screen"></i>Mobile-First Development</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Rank #1 on Google Jacksonville</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-bolt"></i>Under 2-Second Load Speed</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>Google Reviews Widget Built In</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-laptop-code"></i>Jacksonville Homecare Website Design</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-map-location-dot"></i>Duval County SEO</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-mobile-screen"></i>Mobile-First Development</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Rank #1 on Google Jacksonville</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-bolt"></i>Under 2-Second Load Speed</div>
  </div>
</div>

<!-- JACKSONVILLE MARKET -->
<section style="background:#fff">
  <div class="container">
    <div class="two-col">
      <div class="body-text" data-reveal>
        <p class="section-label">The Jacksonville Market</p>
        <h2 class="section-h2">Why Jacksonville Homecare Agencies<br><em>Need a Specialist Website</em></h2>
        <p>Jacksonville is Florida's largest city by area, and it's growing fast. Duval County is closing in on 1 million residents, and a good chunk of that growth is retirees moving down from the Northeast and Midwest. More seniors settling in means more families searching for homecare, often on short notice.</p>
        <p>Here's what we've noticed working with agencies in this market: Jacksonville homecare sites, as a group, are behind. A lot of them are still running templated designs from five or six years ago. That's not a knock on the agencies, it's just an opening. Show up with a site built specifically for this market and you're not fighting a crowded field the way you would in Miami or Orlando.</p>
        <p>So that's how we build every page. Duval County neighborhood pages, Jacksonville keyword targeting, and copy written for the families actually searching in Mandarin, Southside, Ponte Vedra Beach, and St. Johns County, not generic homecare boilerplate swapped in with a city name.</p>
        <div class="why-points" style="margin-top:24px">
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-language"></i></div>
            <div><div class="why-point-title">Duval County Neighborhood Pages</div><div class="why-point-desc">We build a dedicated SEO page for Mandarin, Arlington, Southside, Riverside, Jacksonville Beach, Ponte Vedra, and anywhere else you serve, so you rank neighborhood by neighborhood instead of getting buried under the citywide search.</div></div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-map-location-dot"></i></div>
            <div><div class="why-point-title">Jacksonville Family Trust Signals</div><div class="why-point-desc">AHCA license display, caregiver screening content, a live Google Reviews widget, real team photos. These are the things a Jacksonville family checks before they'll pick up the phone and call an agency.</div></div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <div><div class="why-point-title">Caregiver Recruitment for Jacksonville</div><div class="why-point-desc">A careers page built to rank for "caregiver jobs Jacksonville FL," so it's pulling in applicants around the clock instead of sitting quiet on your site.</div></div>
          </div>
        </div>
      </div>
      <div data-reveal style="transition-delay:.15s">
        <div class="market-facts">
          <div class="fact-card"><div class="fact-num">970K+</div><h4>Duval County Population</h4><p>Florida's largest city by area, and still filling in with retirees moving down from up north</p></div>
          <div class="fact-card"><div class="fact-num">18%</div><h4>Residents 65+</h4><p>That share keeps climbing, especially in Ponte Vedra and St. Johns where private-pay demand runs strong</p></div>
          <div class="fact-card"><div class="fact-num">$5,700</div><h4>Avg Client Value/Year</h4><p>A single private-pay client here can be worth $3,000 to $8,000 a year to your agency</p></div>
          <div class="fact-card"><div class="fact-num">Low</div><h4>Digital Competition</h4><p>Most Jacksonville agencies are still under-invested online, which is exactly why this is a good time to fix that</p></div>
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
      <h2 class="section-h2" style="text-align:center">Jacksonville to <em>Live in 14 Days</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">Four steps. You hand us the basics about your agency, we handle the rest.</p>
    </div>
    <div class="how-grid" data-reveal style="transition-delay:.1s">
      <div class="how-step"><div class="how-num">1<div class="how-icon"><i class="fa-solid fa-comments"></i></div></div><div class="how-title">Discovery Call</div><div class="how-desc">A 30-minute call where we ask about your Jacksonville agency, which neighborhoods you cover, and what you actually want the site to do. Everything else gets built around your answers.</div></div>
      <div class="how-step"><div class="how-num">2<div class="how-icon"><i class="fa-solid fa-pen-ruler"></i></div></div><div class="how-title">Design &amp; Copy</div><div class="how-desc">We write the Jacksonville-specific content and design the full site ourselves. You don't need to write a word. Just look it over when it's ready.</div></div>
      <div class="how-step"><div class="how-num">3<div class="how-icon"><i class="fa-solid fa-eye"></i></div></div><div class="how-title">Review &amp; Refine</div><div class="how-desc">You go through the finished site and flag whatever you want changed. Most Jacksonville clients only need one round of revisions.</div></div>
      <div class="how-step"><div class="how-num">4<div class="how-icon"><i class="fa-solid fa-rocket"></i></div></div><div class="how-title">Launch &amp; Rank</div><div class="how-desc">We publish, submit the site to Google, and wire up Analytics and Search Console. Your Jacksonville SEO clock starts the day we hit publish.</div></div>
    </div>
  </div>
</section>

<!-- PACKAGES -->
<section class="pkg-section" id="packages">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Packages &amp; Pricing</p>
      <h2 class="section-h2" style="text-align:center">Jacksonville Website Design <em>Packages</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">Every tier gets custom Jacksonville design, SEO setup, and mobile optimization built in. What you see below is what you pay.</p>
    </div>
    <div class="pkg-grid" data-reveal style="transition-delay:.1s">
      <div class="pkg-card">
        <div class="pkg-name">Starter</div>
        <div class="pkg-price">$699</div>
        <div class="pkg-note">one-time + $79/mo hosting</div>
        <div class="pkg-div"></div>
        <ul class="pkg-list">
          <li><i class="fa-solid fa-check"></i>5 custom Jacksonville-specific pages</li>
          <li><i class="fa-solid fa-check"></i>Mobile-first design with your branding</li>
          <li><i class="fa-solid fa-check"></i>On-page SEO for Jacksonville keywords</li>
          <li><i class="fa-solid fa-check"></i>Google Reviews widget</li>
          <li><i class="fa-solid fa-check"></i>Contact &amp; inquiry form</li>
          <li><i class="fa-solid fa-check"></i>Google Analytics + Search Console</li>
          <li><i class="fa-solid fa-check"></i>Under 2-second load speed</li>
          <li><i class="fa-solid fa-check"></i>Live in 10–14 days</li>
        </ul>
        <button class="pkg-btn pkg-btn-dark" onclick="openPopup()"><i class="fa-solid fa-arrow-right"></i>Get Started</button>
      </div>
      <div class="pkg-card featured">
        <div class="pkg-pop">Most Popular</div>
        <div class="pkg-name">Growth</div>
        <div class="pkg-price" style="color:#fff">$999</div>
        <div class="pkg-note">one-time + $79/mo hosting</div>
        <div class="pkg-div"></div>
        <ul class="pkg-list">
          <li><i class="fa-solid fa-check"></i>Everything in Starter</li>
          <li><i class="fa-solid fa-check"></i>10 custom pages</li>
          <li><i class="fa-solid fa-check"></i>3 Jacksonville neighborhood area pages</li>
          <li><i class="fa-solid fa-check"></i>Caregiver careers page (SEO-optimized)</li>
          <li><i class="fa-solid fa-check"></i>LocalBusiness schema markup</li>
          <li><i class="fa-solid fa-check"></i>Blog setup ready for content</li>
          <li><i class="fa-solid fa-check"></i>Google Business Profile optimization</li>
          <li><i class="fa-solid fa-check"></i>Live in 14 days</li>
        </ul>
        <button class="pkg-btn pkg-btn-teal" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get Started</button>
      </div>
      <div class="pkg-card">
        <div class="pkg-name">Dominate</div>
        <div class="pkg-price">$1,699</div>
        <div class="pkg-note">one-time + $79/mo hosting</div>
        <div class="pkg-div"></div>
        <ul class="pkg-list">
          <li><i class="fa-solid fa-check"></i>Everything in Growth</li>
          <li><i class="fa-solid fa-check"></i>15+ custom pages</li>
          <li><i class="fa-solid fa-check"></i>8 Jacksonville neighborhood area pages</li>
          <li><i class="fa-solid fa-check"></i>Custom brand identity (logo + colors)</li>
          <li><i class="fa-solid fa-check"></i>AI chatbot integration</li>
          <li><i class="fa-solid fa-check"></i>Team &amp; caregiver profiles page</li>
          <li><i class="fa-solid fa-check"></i>Priority support + monthly strategy call</li>
          <li><i class="fa-solid fa-check"></i>Live in 21 days</li>
        </ul>
        <button class="pkg-btn pkg-btn-dark" onclick="openPopup()"><i class="fa-solid fa-arrow-right"></i>Get Started</button>
      </div>
    </div>
  </div>
</section>

<!-- WHAT'S INCLUDED -->
<section class="inc-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Everything Included</p>
      <h2 class="section-h2">Built for Jacksonville.<br><em>Nothing Left Out.</em></h2>
      <p class="section-sub">These aren't add-ons. Every Jacksonville homecare site we build ships with all of this, tuned to how Duval County families actually search.</p>
    </div>
    <div class="inc-grid" data-reveal style="transition-delay:.1s">
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-mobile-screen"></i></div><h3>100% Mobile-First</h3><p>Over 70% of Jacksonville families search for homecare from a phone, not a laptop. We design for that screen first, since Google's mobile-first indexing judges your site the same way.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-brands fa-google"></i></div><h3>Jacksonville SEO Built In</h3><p>Keyword targeting, meta titles, descriptions, and content structure all built around Jacksonville from the start, so your site is already positioned for "home care agency Jacksonville" searches at launch.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-bolt"></i></div><h3>Sub-2 Second Load Speed</h3><p>Compressed images, clean code, fast hosting. Page speed is a Core Web Vitals factor Google uses directly in ranking, and it's one of the first things Jacksonville families notice too.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-star"></i></div><h3>Google Reviews Widget</h3><p>We pull your real Jacksonville reviews onto the homepage, live. In our experience it's the single fastest way to earn a family's trust before they've even picked up the phone.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-map-location-dot"></i></div><h3>Jacksonville Neighborhood Pages</h3><p>Each Jacksonville community you serve gets its own page, ranked on its own, instead of one citywide page trying to cover all of Duval County at once.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-users"></i></div><h3>Caregiver Recruitment Page</h3><p>A careers page built to rank for "caregiver jobs Jacksonville FL," bringing in applicants while you sleep.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-code"></i></div><h3>Schema Markup</h3><p>We add LocalBusiness and FAQPage schema markup so Google can read, in structured data, exactly who you are, where in Jacksonville you operate, and what you offer.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-chart-line"></i></div><h3>Analytics &amp; Search Console</h3><p>Google Analytics 4 and Search Console get connected before launch, not after, so you can see every Jacksonville visit, call, and inquiry from the first day live.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-shield-halved"></i></div><h3>SSL &amp; Hosting</h3><p>HTTPS, 99.9% uptime hosting, and daily backups. It's all part of the $79/mo plan, so your Jacksonville site just stays up.</p></div>
    </div>

    <!-- INTERNAL LINK: Local SEO -->
    <div style="background:rgba(29,158,117,.06);border:1px solid rgba(29,158,117,.2);border-radius:16px;padding:28px 32px;margin-top:32px;display:flex;align-items:center;gap:20px;flex-wrap:wrap">
      <div><i class="fa-solid fa-magnifying-glass-chart" style="font-size:28px;color:var(--teal)"></i></div>
      <div style="flex:1"><div style="font-family:Syne,sans-serif;font-weight:700;font-size:16px;color:var(--forest);margin-bottom:4px">Pair Your Website with Local SEO</div><div style="font-size:14px;color:var(--muted)">A great website still needs to be found. Our <a href="/seo/local-seo-for-home-care-agencies" style="color:var(--teal);font-weight:600">Local SEO for Home Care Agencies</a> service is built to push your new Jacksonville site toward the #1 spot on Google Maps, so the leads start earlier.</div></div>
      <a href="/seo/local-seo-for-home-care-agencies" class="btn-primary" style="white-space:nowrap;font-size:13px;padding:12px 20px"><i class="fa-solid fa-arrow-right"></i>View SEO Packages</a>
    </div>
  </div>
</section>

<!-- KEYWORDS -->
<section class="kw-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Jacksonville Keyword Strategy</p>
      <h2 class="section-h2">Jacksonville Keywords We <em>Rank Your Site For</em></h2>
      <p class="section-sub">These are the actual phrases Duval County families type into Google when they're looking for care, and we build every Jacksonville site to target them directly.</p>
    </div>
    <div class="kw-grid" data-reveal style="transition-delay:.1s">
      <div class="kw-card"><div><div class="kw-term">homecare website design Jacksonville FL</div><div class="kw-intent">Agency owners searching for your service</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">home care agency Jacksonville FL</div><div class="kw-intent">Families ready to hire — highest intent</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">senior home care Jacksonville</div><div class="kw-intent">Family searching for elderly parent</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">homecare near me Jacksonville</div><div class="kw-intent">Local + near-me, highest conversion</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">caregiver jobs Jacksonville FL</div><div class="kw-intent">Caregiver recruitment — talent pipeline</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">home care Mandarin / Southside</div><div class="kw-intent">Neighborhood-level, lower competition</div></div><span class="kw-badge kw-med">MED</span></div>
      <div class="kw-card"><div><div class="kw-term">in-home care for elderly Jacksonville</div><div class="kw-intent">Informational → decision stage buyer</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">24-hour home care Jacksonville</div><div class="kw-intent">High urgency — premium private-pay</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">best home care agency Jacksonville 2025</div><div class="kw-intent">AI search &amp; voice search query</div></div><span class="kw-badge kw-med">MED</span></div>
    </div>
  </div>
</section>

<!-- JACKSONVILLE AREAS -->
<section class="areas-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Jacksonville Service Coverage</p>
      <h2 class="section-h2">We Build Pages for Every<br><em>Jacksonville Neighborhood You Serve</em></h2>
      <p class="section-sub">Every Jacksonville community you cover gets its own dedicated, SEO-built page. That way you rank neighborhood by neighborhood, not just for the city as a whole.</p>
    </div>
    <div class="areas-grid" data-reveal style="transition-delay:.1s">
      <div class="area-pill"><div class="area-dot"></div>Mandarin</div>
      <div class="area-pill"><div class="area-dot"></div>Arlington</div>
      <div class="area-pill"><div class="area-dot"></div>Southside</div>
      <div class="area-pill"><div class="area-dot"></div>Riverside</div>
      <div class="area-pill"><div class="area-dot"></div>Avondale</div>
      <div class="area-pill"><div class="area-dot"></div>San Marco</div>
      <div class="area-pill"><div class="area-dot"></div>Jacksonville Beach</div>
      <div class="area-pill"><div class="area-dot"></div>Neptune Beach</div>
      <div class="area-pill"><div class="area-dot"></div>Atlantic Beach</div>
      <div class="area-pill"><div class="area-dot"></div>Ponte Vedra Beach</div>
      <div class="area-pill"><div class="area-dot"></div>Nocatee</div>
      <div class="area-pill"><div class="area-dot"></div>St. Johns</div>
      <div class="area-pill"><div class="area-dot"></div>Yulee</div>
      <div class="area-pill"><div class="area-dot"></div>Fernandina Beach</div>
      <div class="area-pill"><div class="area-dot"></div>Baymeadows</div>
      <div class="area-pill"><div class="area-dot"></div>Orange Park</div>
      <div class="area-pill"><div class="area-dot"></div>Fleming Island</div>
      <div class="area-pill"><div class="area-dot"></div>Green Cove Springs</div>
      <div class="area-pill"><div class="area-dot"></div>Middleburg</div>
      <div class="area-pill"><div class="area-dot"></div>Palatka</div>
    </div>
  </div>
</section>

<!-- RESULTS -->
<section class="results-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center;color:var(--teal-lt)"><span style="background:var(--teal-lt);display:inline-block;width:24px;height:2px;border-radius:2px;margin-right:8px;vertical-align:middle"></span>Proven Results</p>
      <h2 class="section-h2" style="color:#fff;text-align:center">What Happens After Your<br><em>Jacksonville Website Goes Live</em></h2>
    </div>
    <div class="results-grid" data-reveal style="transition-delay:.1s">
      <div class="result-item"><div class="result-num">312%</div><div class="result-label">Average lead increase in 6 months</div></div>
      <div class="result-item"><div class="result-num">#1</div><div class="result-label">Google Maps position in 5 months</div></div>
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
      <h2 class="section-h2">Jacksonville Homecare Website Design:<br><em>Your Questions Answered</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Why do I need a specialist website for my Jacksonville homecare agency?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Jacksonville is growing fast, and homecare competition is catching up with it. A generic site built by a general web designer usually doesn't target Duval County keywords at all, and it rarely converts the families who land on it. We've also found Jacksonville is one of Florida's less digitally saturated homecare markets right now. Agencies that build a specialist site early tend to hold that ranking position for years, simply because fewer competitors are fighting for it.</div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Will my Jacksonville homecare website rank on Google?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">It should, yes. Every Jacksonville page we build gets proper SEO for Duval County homecare keywords, schema markup, fast load speed, and mobile optimization from the start. Because competition here is lighter than in Miami or Tampa, we've generally seen Jacksonville agencies reach top Google Maps positions quicker than agencies in those bigger metros, which makes the timing especially good right now.</div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you build websites for agencies serving both Jacksonville and surrounding areas like St. Johns County?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">We do. A lot of the Jacksonville agencies we work with also cover St. Johns, Clay, Nassau, and Baker counties, and we build a separate service area page for each one you serve. Every page gets its own optimization, so you're ranking across Northeast Florida instead of just the Jacksonville city limits.</div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How long does it take to build my Jacksonville homecare website?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Starter goes live in 10 to 14 days. Growth takes 14. Dominate runs up to 21 days since there's more built into it. We handle the writing, so all you're doing is sending over your agency details and approving the design when it's ready. We move quickly because every day without a proper site is a day of Jacksonville leads going somewhere else, but we won't cut a corner just to hit a date.</div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can I add Local SEO to my Jacksonville website package?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">You can. Lower competition in Jacksonville tends to make Local SEO go further here than it would in Miami or Tampa. Our Jacksonville Local SEO retainer starts at $400/mo, and most of our clients add it on from day one since pairing it with the website build is the fastest route to #1 on Google Maps in Jacksonville.</div></div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <div class="cta-inner">
      <div data-reveal>
        <p class="section-label" style="color:var(--teal-lt)"><span style="background:var(--teal-lt);display:inline-block;width:24px;height:2px;border-radius:2px;margin-right:8px;vertical-align:middle"></span>Get Started Today</p>
        <h2 class="cta-h2">Ready for a Jacksonville Website That<br><em>Actually Gets You Clients?</em></h2>
        <p class="cta-desc">Book a free 30-minute call. We'll look at your current Jacksonville digital presence and walk you through a clear plan. No obligation, no pressure, no sales script.</p>
        <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get My Jacksonville Website Quote</button>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free quote &nbsp;·&nbsp; Live in 14 days &nbsp;·&nbsp; No hidden fees</div>
      </div>
      <div class="cta-img-wrap" data-reveal style="transition-delay:.15s">
        <img src="/images/home/service-website-dev.jpg" alt="Jacksonville home care agency website design results — fast, mobile-first site built by Homecare Creators" title="Jacksonville home care agency website design results">
        <div class="cta-img-badge">
          <div class="cta-img-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Your Quote Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Current website audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Jacksonville competitor analysis</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Custom package recommendation</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Fixed price, no surprises</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
