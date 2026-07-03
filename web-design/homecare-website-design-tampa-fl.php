<?php
$page_title = "Homecare Website Design in Tampa, FL | Homecare Creators";
$page_desc = "Homecare website design for Tampa, FL agencies. We build fast, SEO-ready sites for home care agencies that rank on Google and recruit caregivers.";
$page_canonical = "https://homecarecreators.com/homecare-website-design-tampa-fl/";
$og_title = "Homecare Website Design Tampa FL | Homecare Creators";
$og_desc = "Tampa homecare website design built only for home care agencies. Rank on Google, win more families, recruit caregivers. Plans start at $699.";
$page_css = <<<CSS
/* HERO */
.hero{min-height:88vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:120px 80px 80px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-200px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-blob2{position:absolute;width:500px;height:500px;bottom:-150px;left:-100px;background:radial-gradient(circle,rgba(201,168,76,.1) 0%,transparent 65%);animation:float 13s ease-in-out infinite reverse}
.hero-content{position:relative;z-index:2;max-width:820px}
.hero-breadcrumb{font-family:'Syne',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb a:hover{color:rgba(255,255,255,.7)}
.hero-breadcrumb span{color:var(--teal-lt)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Syne',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:28px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite;flex-shrink:0}
.hero-h1{font-family:'Instrument Serif',serif;font-size:clamp(36px,5vw,64px);line-height:1.06;color:#fff;margin-bottom:22px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:17px;line-height:1.78;color:rgba(255,255,255,.65);max-width:580px;margin-bottom:40px;animation:fadeUp .8s .25s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .38s ease both;margin-bottom:52px}
.hero-proof{display:flex;gap:32px;flex-wrap:wrap;animation:fadeUp .8s .5s ease both}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Instrument Serif',serif;font-size:34px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-proof-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch}

/* TICKER */
.ticker-wrap{background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);overflow:hidden;padding:14px 0}
.ticker-inner{display:flex;width:max-content;animation:ticker 32s linear infinite}
.ticker-item{display:flex;align-items:center;gap:10px;padding:0 38px;font-family:'Syne',sans-serif;font-size:12px;font-weight:600;color:var(--muted);letter-spacing:.4px;text-transform:uppercase;white-space:nowrap}
.ticker-dot{width:5px;height:5px;border-radius:50%;background:var(--teal);flex-shrink:0}
.ticker-item i{color:var(--teal);font-size:13px}

/* TWO COL */
.two-col{display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:start}
.two-col-center{display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.body-text p{font-size:16px;line-height:1.82;color:var(--muted);margin-bottom:16px}

/* MARKET FACTS */
.market-facts{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:8px}
.fact-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r);padding:22px;border-left:4px solid var(--teal)}
.fact-num{font-family:'Instrument Serif',serif;font-size:32px;color:var(--teal);line-height:1;margin-bottom:6px}
.fact-card h4{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;color:var(--forest);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
.fact-card p{font-size:12.5px;color:var(--muted);line-height:1.6}

/* WHY POINTS */
.why-points{display:flex;flex-direction:column;gap:13px;margin-top:28px}
.why-point{display:flex;gap:16px;align-items:flex-start;padding:18px;border-radius:16px;border:1px solid var(--border);background:var(--warm);transition:.3s}
.why-point:hover{border-color:rgba(29,158,117,.3);box-shadow:0 8px 32px rgba(10,46,30,.08);transform:translateX(4px)}
.why-point-icon{width:44px;height:44px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.why-point-title{font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:var(--forest);margin-bottom:4px}
.why-point-desc{font-size:13px;line-height:1.65;color:var(--muted)}

/* HOW IT WORKS */
.how-section{background:#fff}
.how-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:72px;position:relative}
.how-grid::before{content:'';position:absolute;top:44px;left:12%;right:12%;height:1px;background:linear-gradient(90deg,transparent,var(--teal) 20%,var(--teal) 80%,transparent);opacity:.25}
.how-step{text-align:center;padding:0 20px 48px;position:relative}
.how-num{width:88px;height:88px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-family:'Syne',sans-serif;font-weight:800;font-size:26px;position:relative;z-index:1;box-shadow:0 0 0 10px rgba(29,158,117,.08),0 8px 32px rgba(10,46,30,.2);transition:.3s}
.how-step:hover .how-num{background:var(--teal);box-shadow:0 0 0 10px rgba(29,158,117,.15),0 12px 40px rgba(29,158,117,.35)}
.how-icon{position:absolute;bottom:-4px;right:-4px;width:28px;height:28px;border-radius:50%;background:var(--teal-lt);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;box-shadow:0 2px 8px rgba(0,0,0,.2)}
.how-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15px;color:var(--forest);margin-bottom:10px}
.how-desc{font-size:13.5px;line-height:1.65;color:var(--muted)}

/* WHAT'S INCLUDED */
.inc-section{background:var(--cream)}
.inc-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px;margin-top:44px}
.inc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:22px;transition:.25s}
.inc-card:hover{box-shadow:0 8px 32px rgba(10,46,30,.08);border-color:rgba(29,158,117,.2);transform:translateY(-2px)}
.inc-icon{width:44px;height:44px;border-radius:11px;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:19px;margin-bottom:14px}
.inc-card h3{font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:var(--forest);margin-bottom:7px}
.inc-card p{font-size:13px;color:var(--muted);line-height:1.7}

/* PACKAGES */
.pkg-section{background:#fff}
.pkg-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;margin-top:52px}
.pkg-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r-lg);padding:34px 30px;position:relative;transition:.3s}
.pkg-card:hover{transform:translateY(-6px);box-shadow:0 24px 64px rgba(10,46,30,.1)}
.pkg-card.featured{background:var(--forest);border-color:var(--teal);box-shadow:0 16px 64px rgba(10,46,30,.3)}
.pkg-pop{position:absolute;top:-13px;left:50%;transform:translateX(-50%);background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;font-family:'Syne',sans-serif;font-size:11px;font-weight:700;padding:5px 18px;border-radius:20px;white-space:nowrap}
.pkg-name{font-family:'Syne',sans-serif;font-size:12px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--teal);margin-bottom:10px}
.pkg-card.featured .pkg-name{color:var(--teal-lt)}
.pkg-price{font-family:'Instrument Serif',serif;font-size:50px;color:var(--forest);line-height:1;margin-bottom:4px}
.pkg-card.featured .pkg-price{color:#fff}
.pkg-note{font-family:'Syne',sans-serif;font-size:11px;color:var(--muted);margin-bottom:22px}
.pkg-card.featured .pkg-note{color:rgba(255,255,255,.5)}
.pkg-div{height:1px;background:var(--border);margin-bottom:22px}
.pkg-card.featured .pkg-div{background:rgba(255,255,255,.1)}
.pkg-list{list-style:none;display:flex;flex-direction:column;gap:9px;margin-bottom:28px}
.pkg-list li{display:flex;align-items:flex-start;gap:9px;font-size:13px;color:var(--muted);line-height:1.5}
.pkg-card.featured .pkg-list li{color:rgba(255,255,255,.7)}
.pkg-list li i{color:var(--teal);font-size:11px;margin-top:2px;flex-shrink:0}
.pkg-card.featured .pkg-list li i{color:var(--teal-lt)}
.pkg-btn{width:100%;padding:13px;border-radius:10px;font-family:'Syne',sans-serif;font-weight:700;font-size:14px;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:8px;transition:.2s}
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
.kw-intent{font-size:11px;color:var(--muted);margin-top:2px}
.kw-badge{font-family:'Syne',sans-serif;font-size:10px;font-weight:700;padding:3px 9px;border-radius:20px;white-space:nowrap}
.kw-high{background:rgba(29,158,117,.1);color:var(--forest-lt)}
.kw-med{background:rgba(201,168,76,.12);color:#7a5f18}

/* AREAS */
.areas-section{background:#fff}
.areas-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:10px;margin-top:30px}
.area-pill{background:var(--warm);border:1px solid var(--border);border-radius:9px;padding:11px 14px;font-family:'Syne',sans-serif;font-size:12px;font-weight:600;color:var(--forest);display:flex;align-items:center;gap:7px;transition:all .2s}
.area-pill:hover{border-color:var(--teal);color:var(--teal);transform:translateY(-1px)}
.area-dot{width:6px;height:6px;border-radius:50%;background:var(--teal);flex-shrink:0}

/* RESULTS */
.results-section{background:var(--forest);padding:72px 40px}
.results-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:48px;border:1px solid rgba(255,255,255,.08);border-radius:var(--r-lg);overflow:hidden}
.result-item{padding:32px 24px;text-align:center;border-right:1px solid rgba(255,255,255,.08)}
.result-item:last-child{border-right:none}
.result-num{font-family:'Instrument Serif',serif;font-size:48px;color:var(--teal-lt);line-height:1;margin-bottom:8px}
.result-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:600;color:rgba(255,255,255,.5);letter-spacing:.5px}

/* FAQ */
.faq-section{background:var(--cream)}
.faq-list{margin-top:36px;display:flex;flex-direction:column;gap:11px}
.faq-item{border:1px solid var(--border);border-radius:var(--r);overflow:hidden;background:#fff}
.faq-q{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:18px 22px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:var(--forest)}
.faq-q-icon{width:26px;height:26px;border-radius:50%;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:11px;flex-shrink:0;transition:transform .25s,background .2s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal);color:#fff}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease}
.faq-item.open .faq-a{max-height:350px}
.faq-a-inner{padding:0 22px 18px;font-size:13.5px;color:var(--muted);line-height:1.8}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:96px 40px}
.cta-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.cta-h2{font-family:'Instrument Serif',serif;font-size:clamp(28px,4vw,48px);line-height:1.1;color:#fff;margin-bottom:16px}
.cta-h2 em{color:var(--teal-lt);font-style:italic}
.cta-desc{font-size:16px;color:rgba(255,255,255,.68);line-height:1.78;margin-bottom:30px}
.cta-guarantee{font-family:'Syne',sans-serif;font-size:12px;color:rgba(255,255,255,.45);display:flex;align-items:center;gap:8px;margin-top:16px}
.cta-guarantee i{color:var(--teal-lt)}
.cta-img-wrap{position:relative;border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3)}
.cta-img-wrap img{width:100%;height:380px;object-fit:cover;display:block}
.cta-img-badge{position:absolute;bottom:18px;left:18px;right:18px;background:rgba(10,46,30,.88);backdrop-filter:blur(12px);border:1px solid rgba(46,198,143,.22);border-radius:12px;padding:15px 17px}
.cta-img-badge-title{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;color:#fff;margin-bottom:9px}
.cta-badge-row{display:flex;align-items:center;gap:7px;margin-bottom:5px}
.cta-badge-row:last-child{margin-bottom:0}
.cta-badge-dot{width:5px;height:5px;border-radius:50%;background:var(--teal-lt);flex-shrink:0}
.cta-badge-text{font-family:'Syne',sans-serif;font-size:11px;color:rgba(255,255,255,.65)}

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
    <div class="hero-breadcrumb"><a href="https://homecarecreators.com">Home</a> / <a href="/homecare-website-design/">Website Design</a> / <span>Tampa, FL</span></div>
    <div class="hero-badge"><div class="hero-badge-pulse"></div>Homecare Website Design, Tampa FL</div>
    <h1 class="hero-h1">Homecare Website Design<br>in <em>Tampa, Florida</em></h1>
    <p class="hero-desc">We build fast, mobile-first websites for Tampa homecare agencies. Sites that rank on Google, turn Hillsborough County families into clients, and keep your careers page recruiting caregivers around the clock. Plans start at $699.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get Your Tampa Website Quote</button>
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
    <div class="ticker-item"><i class="fa-solid fa-laptop-code"></i>Tampa Homecare Website Design</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-map-location-dot"></i>Hillsborough County SEO</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-mobile-screen"></i>Mobile-First Development</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Rank #1 on Google Tampa</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-bolt"></i>Under 2-Second Load Speed</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>Google Reviews Widget Built In</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-laptop-code"></i>Tampa Homecare Website Design</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-map-location-dot"></i>Hillsborough County SEO</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-mobile-screen"></i>Mobile-First Development</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Rank #1 on Google Tampa</div><div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-bolt"></i>Under 2-Second Load Speed</div>
  </div>
</div>

<!-- TAMPA MARKET -->
<section style="background:#fff">
  <div class="container">
    <div class="two-col">
      <div class="body-text" data-reveal>
        <p class="section-label">The Tampa Market</p>
        <h2 class="section-h2">Why Tampa Homecare Agencies<br><em>Need a Specialist Website</em></h2>
        <p>Retirees keep moving to Hillsborough County from the Northeast and Midwest, and the senior population here is growing faster than almost anywhere else in Florida. Over 1.5 million people live in the greater Tampa Bay area now. For a homecare agency, that growth means your website isn't just a brochure. It's the tool that either brings in new clients every month or quietly loses them to a competitor with a better site.</p>
        <p>As a Google Partner and BBB-accredited agency that works exclusively with home care companies, we've reviewed a lot of Tampa homecare websites over the years, and the same problem keeps showing up: they were built by a generalist developer who's never heard of an AHCA license, and has no idea what a Tampa family actually wants to see before they pick up the phone. Traffic shows up. Leads don't.</p>
        <p>In our work building homecare-only websites, we've learned that Tampa families respond to specificity, not polish. So every site we build gets Hillsborough County neighborhood pages, keyword targeting tuned to how Tampa searches for care, and trust content written for families in Brandon, Riverview, Carrollwood and the rest of the communities you serve.</p>
        <div class="why-points" style="margin-top:24px">
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-language"></i></div>
            <div><div class="why-point-title">Hillsborough County Neighborhood Pages</div><div class="why-point-desc">We build a dedicated page for Brandon, Riverview, Carrollwood, Westchase, Temple Terrace and every other Tampa area you serve, so you show up neighborhood by neighborhood, not just for the city name.</div></div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-map-location-dot"></i></div>
            <div><div class="why-point-title">Tampa Family Trust Signals</div><div class="why-point-desc">Your AHCA license front and center, plain language about how you screen caregivers, a live Google Reviews widget and real team photos. These are the details Tampa families check before they'll call a stranger about their parent.</div></div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <div><div class="why-point-title">Caregiver Recruitment for Tampa</div><div class="why-point-desc">Your careers page gets built to rank for "caregiver jobs Tampa FL," so it keeps working as a recruiting tool across Hillsborough County long after we hand it off.</div></div>
          </div>
        </div>
      </div>
      <div data-reveal style="transition-delay:.15s">
        <div class="market-facts">
          <div class="fact-card"><div class="fact-num">1.5M+</div><h4>Tampa Bay Population</h4><p>One of Florida's largest metros, and the senior population here keeps growing year over year.</p></div>
          <div class="fact-card"><div class="fact-num">20%</div><h4>Residents 65+</h4><p>1 in 5 Hillsborough County residents is a senior. That's your core audience, right in your service area.</p></div>
          <div class="fact-card"><div class="fact-num">$5,900</div><h4>Avg Client Value/Year</h4><p>A single private-pay Tampa client is typically worth $3,000 to $8,000 a year to your agency.</p></div>
          <div class="fact-card"><div class="fact-num">High</div><h4>Competition Level</h4><p>Tampa ranks among Florida's top 5 homecare markets. A specialist-built site is how you outrank the pack.</p></div>
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
      <h2 class="section-h2" style="text-align:center">Tampa to <em>Live in 14 Days</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">Four steps. You give us the basics on your agency, we handle the rest.</p>
    </div>
    <div class="how-grid" data-reveal style="transition-delay:.1s">
      <div class="how-step"><div class="how-num">1<div class="how-icon"><i class="fa-solid fa-comments"></i></div></div><div class="how-title">Discovery Call</div><div class="how-desc">A 30-minute call where we learn about your Tampa agency: which neighborhoods you cover, what's worked so far, and what you actually want out of this site.</div></div>
      <div class="how-step"><div class="how-num">2<div class="how-icon"><i class="fa-solid fa-pen-ruler"></i></div></div><div class="how-title">Design &amp; Copy</div><div class="how-desc">We write the Tampa-specific content and design the full site ourselves. You don't need to write a word. Just review it when it's ready.</div></div>
      <div class="how-step"><div class="how-num">3<div class="how-icon"><i class="fa-solid fa-eye"></i></div></div><div class="how-title">Review &amp; Refine</div><div class="how-desc">You go through the finished site and tell us what to change. One revision round is usually all it takes for our Tampa clients.</div></div>
      <div class="how-step"><div class="how-num">4<div class="how-icon"><i class="fa-solid fa-rocket"></i></div></div><div class="how-title">Launch &amp; Rank</div><div class="how-desc">We launch the site, submit it to Google, and set up Analytics and Search Console. Your Tampa SEO clock starts the day we publish.</div></div>
    </div>
  </div>
</section>

<!-- PACKAGES -->
<section class="pkg-section" id="packages">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Packages &amp; Pricing</p>
      <h2 class="section-h2" style="text-align:center">Tampa Website Design <em>Packages</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">Every package includes custom Tampa design, SEO setup, and mobile optimization, built by a team that works only with home care agencies. Nothing hidden in the fine print.</p>
    </div>
    <div class="pkg-grid" data-reveal style="transition-delay:.1s">
      <div class="pkg-card">
        <div class="pkg-name">Starter</div>
        <div class="pkg-price">$699</div>
        <div class="pkg-note">one-time + $79/mo hosting</div>
        <div class="pkg-div"></div>
        <ul class="pkg-list">
          <li><i class="fa-solid fa-check"></i>5 custom Tampa-specific pages</li>
          <li><i class="fa-solid fa-check"></i>Mobile-first design with your branding</li>
          <li><i class="fa-solid fa-check"></i>On-page SEO for Tampa keywords</li>
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
          <li><i class="fa-solid fa-check"></i>3 Tampa neighborhood area pages</li>
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
          <li><i class="fa-solid fa-check"></i>8 Tampa neighborhood area pages</li>
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
      <h2 class="section-h2">Built for Tampa.<br><em>Nothing Left Out.</em></h2>
      <p class="section-sub">These aren't add-ons. Every Tampa homecare website we build ships with all of this, tuned for how Hillsborough County families actually search and what they need to see.</p>
    </div>
    <div class="inc-grid" data-reveal style="transition-delay:.1s">
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-mobile-screen"></i></div><h3>100% Mobile-First</h3><p>Most Tampa families are on their phone when they start looking for care. We design for that screen first, since Google's mobile-first indexing rewards it too, then scale up to desktop.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-brands fa-google"></i></div><h3>Tampa SEO Built In</h3><p>Keyword targeting, meta titles, and content structure all built around Tampa search terms, so you're already positioned for "home care agency Tampa" the day the site goes live.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-bolt"></i></div><h3>Sub-2 Second Load Speed</h3><p>We optimize images, keep the code clean, and host on fast servers because page speed is part of Core Web Vitals, and slow-loading sites lose Tampa families before they even read a word.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-star"></i></div><h3>Google Reviews Widget</h3><p>Your actual Tampa Google reviews, pulled live onto your homepage. It's the single trust signal that does the most work when a family is choosing between agencies.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-map-location-dot"></i></div><h3>Tampa Neighborhood Pages</h3><p>Each Tampa community you serve gets its own SEO page, ranked on its own, so neighborhood-level searches across Hillsborough County find you specifically.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-users"></i></div><h3>Caregiver Recruitment Page</h3><p>We build your careers page to rank for "caregiver jobs Tampa FL." It keeps recruiting for you around the clock, not just when you're actively hiring.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-code"></i></div><h3>Schema Markup</h3><p>LocalBusiness and FAQPage schema markup tell Google, in its own language, exactly who you are, where in Tampa you operate, and which services you provide.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-chart-line"></i></div><h3>Analytics &amp; Search Console</h3><p>Google Analytics 4 and Search Console get connected before we ever launch, so you can see every Tampa visit, call, and inquiry starting on day one.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-shield-halved"></i></div><h3>SSL &amp; Hosting</h3><p>HTTPS, 99.9% uptime hosting, and daily backups come standard in your $79/mo plan. Your Tampa site stays online, full stop.</p></div>
    </div>

    <!-- INTERNAL LINK: Local SEO -->
    <div style="background:rgba(29,158,117,.06);border:1px solid rgba(29,158,117,.2);border-radius:16px;padding:28px 32px;margin-top:32px;display:flex;align-items:center;gap:20px;flex-wrap:wrap">
      <div><i class="fa-solid fa-magnifying-glass-chart" style="font-size:28px;color:var(--teal)"></i></div>
      <div style="flex:1"><div style="font-family:Syne,sans-serif;font-weight:700;font-size:16px;color:var(--forest);margin-bottom:4px">Pair Your Website with Local SEO</div><div style="font-size:14px;color:var(--muted)">A great website still needs to be found. Our <a href="/seo/local-seo-for-home-care-agencies" style="color:var(--teal);font-weight:600">Local SEO for Home Care Agencies</a> service pushes your new Tampa site toward the top of Google Maps, so it starts driving leads instead of just sitting there.</div></div>
      <a href="/seo/local-seo-for-home-care-agencies" class="btn-primary" style="white-space:nowrap;font-size:13px;padding:12px 20px"><i class="fa-solid fa-arrow-right"></i>View SEO Packages</a>
    </div>
  </div>
</section>

<!-- KEYWORDS -->
<section class="kw-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Tampa Keyword Strategy</p>
      <h2 class="section-h2">Tampa Keywords We <em>Rank Your Site For</em></h2>
      <p class="section-sub">These are the actual phrases Hillsborough County families type into Google when they're looking for care, and the terms we build your site around.</p>
    </div>
    <div class="kw-grid" data-reveal style="transition-delay:.1s">
      <div class="kw-card"><div><div class="kw-term">homecare website design Tampa FL</div><div class="kw-intent">Agency owners searching for your service</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">home care agency Tampa FL</div><div class="kw-intent">Families ready to hire, highest intent</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">senior home care Tampa</div><div class="kw-intent">Family searching for elderly parent</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">homecare near me Tampa</div><div class="kw-intent">Local + near-me, highest conversion</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">caregiver jobs Tampa FL</div><div class="kw-intent">Builds your caregiver talent pipeline</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">home care Brandon / Riverview</div><div class="kw-intent">Neighborhood-level, lower competition</div></div><span class="kw-badge kw-med">MED</span></div>
      <div class="kw-card"><div><div class="kw-term">in-home care for elderly Tampa</div><div class="kw-intent">Informational → decision stage buyer</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">24-hour home care Tampa</div><div class="kw-intent">Urgent search, premium private-pay client</div></div><span class="kw-badge kw-high">HIGH</span></div>
      <div class="kw-card"><div><div class="kw-term">best home care agency Tampa 2025</div><div class="kw-intent">AI search &amp; voice search query</div></div><span class="kw-badge kw-med">MED</span></div>
    </div>
  </div>
</section>

<!-- TAMPA AREAS -->
<section class="areas-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Tampa Service Coverage</p>
      <h2 class="section-h2">We Build Pages for Every<br><em>Tampa Neighborhood You Serve</em></h2>
      <p class="section-sub">Each Tampa community you serve gets its own SEO-optimized page. That's how you rank neighborhood by neighborhood instead of hoping the city-wide page catches everyone.</p>
    </div>
    <div class="areas-grid" data-reveal style="transition-delay:.1s">
      <div class="area-pill"><div class="area-dot"></div>Brandon</div>
      <div class="area-pill"><div class="area-dot"></div>Riverview</div>
      <div class="area-pill"><div class="area-dot"></div>Temple Terrace</div>
      <div class="area-pill"><div class="area-dot"></div>Carrollwood</div>
      <div class="area-pill"><div class="area-dot"></div>Westchase</div>
      <div class="area-pill"><div class="area-dot"></div>Valrico</div>
      <div class="area-pill"><div class="area-dot"></div>Lutz</div>
      <div class="area-pill"><div class="area-dot"></div>Land O' Lakes</div>
      <div class="area-pill"><div class="area-dot"></div>Plant City</div>
      <div class="area-pill"><div class="area-dot"></div>South Tampa</div>
      <div class="area-pill"><div class="area-dot"></div>Hyde Park</div>
      <div class="area-pill"><div class="area-dot"></div>New Tampa</div>
      <div class="area-pill"><div class="area-dot"></div>Seminole Heights</div>
      <div class="area-pill"><div class="area-dot"></div>Sun City Center</div>
      <div class="area-pill"><div class="area-dot"></div>Ruskin</div>
      <div class="area-pill"><div class="area-dot"></div>Gibsonton</div>
      <div class="area-pill"><div class="area-dot"></div>Seffner</div>
      <div class="area-pill"><div class="area-dot"></div>Fishhawk Ranch</div>
      <div class="area-pill"><div class="area-dot"></div>Wimauma</div>
      <div class="area-pill"><div class="area-dot"></div>Palm River</div>
    </div>
  </div>
</section>

<!-- RESULTS -->
<section class="results-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center;color:var(--teal-lt)"><span style="background:var(--teal-lt);display:inline-block;width:24px;height:2px;border-radius:2px;margin-right:8px;vertical-align:middle"></span>Proven Results</p>
      <h2 class="section-h2" style="color:#fff;text-align:center">What Happens After Your<br><em>Tampa Website Goes Live</em></h2>
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
      <h2 class="section-h2">Tampa Homecare Website Design,<br><em>Your Questions Answered</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Why do I need a specialist website for my Tampa homecare agency?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Tampa is one of the most competitive homecare markets in Florida. A generic site just won't rank for Tampa-specific keywords, and it won't convince a Tampa family comparing three or four agencies at once. A site built specifically for your Hillsborough County market turns more of those visitors into phone calls, and phone calls are really the only number that matters.</div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Will my Tampa homecare website rank on Google?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes. Every Tampa page we build includes proper SEO for Hillsborough County keywords, schema markup, fast load speed, and mobile optimization from the start. Most clients start seeing Google Maps movement within 60 to 90 days. If you want to speed that up, our Local SEO retainer ($400/mo) covers Tampa citation building, review management, and ongoing content.</div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you build websites for agencies serving both Tampa and surrounding areas?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Absolutely, and it comes up a lot. Plenty of Tampa agencies also cover Clearwater, St. Petersburg, and Pinellas County. We build a separate service area page for each city and county you operate in, optimized on its own, so you're visible across Tampa and the wider Tampa Bay region.</div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How long does it take to build my Tampa homecare website?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Starter goes live in 10 to 14 days. Growth takes 14. Dominate runs up to 21. We handle all the writing, so you just hand us the basic agency details and sign off on the design. We move fast because every day without a real website is a day competitors are picking up leads that should've been yours, but we don't cut corners to get there.</div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can I add Local SEO to my Tampa website package?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes, and honestly, we'd recommend it. Our Tampa Local SEO retainer starts at $400/mo and covers Google Business Profile management, Hillsborough County citation building, review velocity, and ongoing content. Most of our clients bundle website design with Local SEO right from day one because it's the fastest route we've seen to the top of Google in Tampa.</div></div>
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
        <h2 class="cta-h2">Ready for a Tampa Website That<br><em>Actually Gets You Clients?</em></h2>
        <p class="cta-desc">Book a free 30-minute call. We'll take a look at your current Tampa presence and hand you an honest plan for it, no obligation and no pressure to sign anything.</p>
        <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get My Tampa Website Quote</button>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free quote &nbsp;·&nbsp; Live in 14 days &nbsp;·&nbsp; No hidden fees</div>
      </div>
      <div class="cta-img-wrap" data-reveal style="transition-delay:.15s">
        <img src="/images/home/service-website-dev.jpg" alt="Tampa home care agency website design results — fast, mobile-first site built by Homecare Creators" title="Tampa home care agency website design results">
        <div class="cta-img-badge">
          <div class="cta-img-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Your Quote Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Current website audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Tampa competitor analysis</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Custom package recommendation</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Fixed price, no surprises</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
