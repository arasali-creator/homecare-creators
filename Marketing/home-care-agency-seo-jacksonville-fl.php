<?php
$page_canonical = "https://homecarecreators.com/home-care-agency-seo-jacksonville-fl/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "Jacksonville Home Care Agency SEO & Marketing | Homecare Creators";
$page_desc = "SEO and web design for home care agencies in Jacksonville, FL. We get Duval County agencies ranking #1 on Google and filling their private-pay caseload.";
$og_title = "Jacksonville Home Care Agency SEO & Marketing | Homecare Creators";
$og_desc = "Jacksonville home care agencies: get found on Google, own local search, and grow faster with a marketing agency built 100% for homecare.";
$page_css = <<<CSS
/* HERO */
.hero{min-height:88vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:120px 80px 80px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-200px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-blob2{position:absolute;width:500px;height:500px;bottom:-150px;left:-100px;background:radial-gradient(circle,rgba(201,168,76,.1) 0%,transparent 65%);animation:float 13s ease-in-out infinite reverse}
.hero-content{position:relative;z-index:2;max-width:780px}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb span{color:var(--teal-lt)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:28px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(38px,5vw,64px);line-height:1.06;color:#fff;margin-bottom:22px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:19px;line-height:1.78;color:rgba(255,255,255,.65);max-width:560px;margin-bottom:40px;animation:fadeUp .8s .25s ease both}
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

/* MARKET SECTION */
.market-section{background:#fff}
.market-inner{display:flex;flex-direction:column;gap:40px}
.market-body{text-align:center;max-width:760px;margin:0 auto}
.market-body .section-label{justify-content:center}
.market-body p{font-size:18px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.market-facts{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:8px}
.fact-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r);padding:22px;border-left:4px solid var(--teal)}
.fact-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;color:var(--teal);line-height:1;margin-bottom:6px}
.fact-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--forest);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
.fact-card p{font-size:15px;color:var(--muted);line-height:1.6}

/* SERVICES */
.services-section{background:var(--cream)}
.services-intro{margin-bottom:52px}
.services-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.svc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;transition:transform .25s,box-shadow .25s}
.svc-card:hover{transform:translateY(-4px);box-shadow:0 16px 48px rgba(10,46,30,.1)}
.svc-card-img{height:180px;position:relative;overflow:hidden}
.svc-card-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.svc-card:hover .svc-card-img img{transform:scale(1.05)}
.svc-card-img-overlay{position:absolute;inset:0;background:linear-gradient(180deg,transparent 30%,rgba(10,46,30,.7))}
.svc-card-img-icon{position:absolute;top:14px;left:14px;width:36px;height:36px;background:var(--teal);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px}
.svc-card-body{padding:24px}
.svc-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--forest);margin-bottom:10px}
.svc-card-desc{font-size:16px;color:var(--muted);line-height:1.7;margin-bottom:16px}
.svc-card-features{list-style:none;display:flex;flex-direction:column;gap:7px}
.svc-card-features li{display:flex;align-items:flex-start;gap:9px;font-size:13px;color:var(--text)}
.svc-card-features li i{color:var(--teal);font-size:12px;margin-top:2px;flex-shrink:0}

/* KEYWORDS */
.kw-section{background:#fff}
.kw-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:12px;margin-top:36px}
.kw-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r);padding:16px 20px;display:flex;align-items:center;justify-content:space-between;gap:12px;transition:border-color .2s}
.kw-card:hover{border-color:var(--teal)}
.kw-term{font-size:14px;font-weight:500;color:var(--forest)}
.kw-intent{font-size:13px;color:var(--muted);margin-top:3px}
.kw-badge{font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;padding:4px 10px;border-radius:20px;white-space:nowrap}
.kw-high{background:rgba(29,158,117,.1);color:var(--forest-lt)}
.kw-med{background:rgba(201,168,76,.12);color:#7a5f18}

/* AREAS */
.areas-section{background:var(--cream)}
.areas-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(160px,1fr));gap:10px;margin-top:32px}
.area-pill{background:#fff;border:1px solid var(--border);border-radius:9px;padding:11px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--forest);display:flex;align-items:center;gap:8px;transition:all .2s}
.area-pill:hover{border-color:var(--teal);color:var(--teal);transform:translateY(-1px)}
.area-dot{width:7px;height:7px;border-radius:50%;background:var(--teal);flex-shrink:0}
.areas-note{margin-top:24px;background:rgba(201,168,76,.08);border:1px dashed rgba(201,168,76,.35);border-radius:var(--r);padding:14px 20px;font-size:13px;color:#7a5f18;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600}

/* WHY */
.why-section{background:var(--forest)}
.why-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:48px}
.why-card{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.09);border-radius:var(--r-lg);padding:28px;transition:background .2s}
.why-card:hover{background:rgba(255,255,255,.09)}
.why-card-icon{width:42px;height:42px;background:rgba(29,158,117,.18);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--teal-lt);font-size:17px;margin-bottom:16px}
.why-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:#fff;margin-bottom:10px}
.why-card p{font-size:15px;color:rgba(255,255,255,.6);line-height:1.75}

/* FAQ */
.faq-section{background:#fff}
.faq-list{margin-top:40px;display:flex;flex-direction:column;gap:12px}
.faq-item{border:1px solid var(--border);border-radius:var(--r);overflow:hidden;background:var(--warm)}
.faq-q{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 24px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest)}
.faq-q-icon{width:28px;height:28px;border-radius:50%;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:12px;flex-shrink:0;transition:transform .25s,background .2s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal);color:#fff}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease}
.faq-item.open .faq-a{max-height:400px}
.faq-a-inner{padding:0 24px 20px;font-size:16px;color:var(--muted);line-height:1.8}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:96px 40px}
.cta-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.cta-content .section-label{color:var(--teal-lt)}
.cta-content .section-label::before{background:var(--teal-lt)}
.cta-content .section-h2{color:#fff}
.cta-desc{font-size:18px;color:rgba(255,255,255,.68);line-height:1.78;margin-bottom:32px}
.cta-actions{margin-bottom:20px}
.cta-guarantee{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.45);display:flex;align-items:center;gap:8px}
.cta-guarantee i{color:var(--teal-lt)}
.cta-image{position:relative;border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3)}
.cta-image img{width:100%;height:380px;object-fit:cover;display:block}
.cta-image-badge{position:absolute;bottom:20px;left:20px;right:20px;background:rgba(10,46,30,.88);backdrop-filter:blur(12px);border:1px solid rgba(46,198,143,.22);border-radius:12px;padding:16px 18px}
.cta-image-badge-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#fff;margin-bottom:10px}
.cta-badge-row{display:flex;align-items:center;gap:8px;margin-bottom:6px}
.cta-badge-row:last-child{margin-bottom:0}
.cta-badge-dot{width:5px;height:5px;border-radius:50%;background:var(--teal-lt);flex-shrink:0}
.cta-badge-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.65)}

/* RESPONSIVE */
@media(max-width:900px){
  .market-inner,.cta-inner{grid-template-columns:1fr;gap:40px}
  .services-grid,.why-grid{grid-template-columns:1fr 1fr}
  .hero{padding:110px 40px 60px}
}
@media(max-width:640px){
  .services-grid,.why-grid{grid-template-columns:1fr}
  .hero{padding:100px 24px 60px}
  .cta-image{display:none}
  .market-facts{grid-template-columns:1fr}
}
CSS;
include '../includes/header.php';
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-blob1"></div>
  <div class="hero-blob2"></div>
  <div class="hero-content">
    <div class="hero-breadcrumb"><a href="https://homecarecreators.com">Home</a> / <span>Florida</span> / <span>Jacksonville</span></div>
    <div class="hero-badge"><div class="hero-badge-pulse"></div>Duval County, Florida</div>
    <h1 class="hero-h1">Jacksonville Home Care<br><em>Agencies, Ranked #1</em></h1>
    <p class="hero-desc">We put Jacksonville home care agencies at the top of Google, build websites that actually convert, and fill your private-pay pipeline across Duval County. When a family here searches for care, we want your name showing up first.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-rocket"></i>Get Your Free Jacksonville SEO Audit</button>
      <a href="https://homecarecreators.com/#services" class="btn-secondary"><i class="fa-solid fa-play"></i>View Our Services</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Homecare-Only Focus</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">SEO</div><div class="hero-proof-label">+ AI Search Visibility</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">30-Day</div><div class="hero-proof-label">Satisfaction Guarantee</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">$0</div><div class="hero-proof-label">Free Audit Cost</div></div>
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
    <div class="ticker-item"><i class="fa-solid fa-location-dot"></i>Jacksonville · Duval County</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass"></i>Local SEO Specialists</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>5-Star Review Growth</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-globe"></i>Homecare Website Design</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Google Maps #1 Rankings</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>AI Search SEO for ChatGPT &amp; Perplexity</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-location-dot"></i>Jacksonville · Duval County</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass"></i>Local SEO Specialists</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>5-Star Review Growth</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-globe"></i>Homecare Website Design</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Google Maps #1 Rankings</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>AI Search SEO for ChatGPT &amp; Perplexity</div>
  </div>
</div>

<!-- MARKET SECTION -->
<section class="market-section">
  <div class="container">
    <div class="market-inner">
      <div class="market-body" data-reveal>
        <p class="section-label">The Jacksonville Market</p>
        <h2 class="section-h2">Why Jacksonville Is One of Florida's <em>Fastest-Growing</em> Homecare Markets</h2>
        <p>Jacksonville and Duval County are growing fast, and the senior population is growing right along with it. Retirees keep moving down from the Northeast and Midwest. The greater Jacksonville area is now home to more than 1.5 million people, with one of the highest concentrations of adults 65+ anywhere in Florida. Demand for quality in-home care here has never been stronger.</p>
        <p>Families in Mandarin, Southside, Arlington, and all over Duval County search Google every day looking for a homecare agency they can trust. If your digital presence isn't strong, you don't show up. Those searches don't just disappear, though. They go to whichever competitor Google decided to show instead.</p>
        <p>Homecare Creators is a marketing agency built exclusively for homecare businesses. We know the Jacksonville market, we know what families actually type into Google when they need care, and we know how to get you to the top of Maps and organic results faster than a generalist marketing shop ever could.</p>
      </div>
      <div class="market-facts" data-reveal style="transition-delay:.15s">
        <div class="fact-card"><div class="fact-num">1.5M+</div><h4>Jacksonville area Population</h4><p>One of Florida's largest metros, and the senior population keeps climbing year after year</p></div>
        <div class="fact-card"><div class="fact-num">20%</div><h4>Residents Aged 65+</h4><p>1 in 5 Duval County residents are seniors. That's your core audience, right in your backyard</p></div>
        <div class="fact-card"><div class="fact-num">$5,900</div><h4>Avg Private-Pay Value</h4><p>Land one new private-pay client in Jacksonville and it's worth $3,000–$8,000 a year to your agency</p></div>
        <div class="fact-card"><div class="fact-num">High</div><h4>Market Competition</h4><p>Jacksonville isn't an easy market to rank in. It takes a specialist, not a generalist dabbling in local SEO</p></div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="services-section">
  <div class="container">
    <div class="services-intro" data-reveal>
      <p class="section-label">Our Services in Jacksonville</p>
      <h2 class="section-h2">Everything Your Jacksonville Agency Needs<br>to <em>Dominate Local Search</em></h2>
      <p class="section-sub">Website design, local SEO, and AI search optimization, done for you and built only for homecare agencies serving Jacksonville and Duval County.</p>
    </div>
    <div class="services-grid">
      <div class="svc-card" data-reveal style="transition-delay:.05s">
        <div class="svc-card-img">
          <img src="/images/home/service-website-dev.jpg" alt="Home care agency website design services in Jacksonville, FL" title="Website design for home care agencies in Jacksonville">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-laptop-code"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">Jacksonville Homecare Website Design</div>
          <div class="svc-card-desc">A fast, mobile-first site built to turn Jacksonville families into inquiries and help you recruit caregivers across Duval County. Every page on it doubles as a local SEO asset.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Custom design built around your branding</li>
            <li><i class="fa-solid fa-check"></i>Jacksonville-specific homepage copy and CTAs</li>
            <li><i class="fa-solid fa-check"></i>Dedicated service area pages for Jacksonville neighborhoods</li>
            <li><i class="fa-solid fa-check"></i>A careers page that helps you land caregivers</li>
            <li><i class="fa-solid fa-check"></i>Google Reviews widget built right in</li>
            <li><i class="fa-solid fa-check"></i>Built for fast, sub-2-second load speed</li>
          </ul>
        </div>
      </div>
      <div class="svc-card" data-reveal style="transition-delay:.1s">
        <div class="svc-card-img">
          <img src="/images/home/service-local-seo.jpg" alt="Local SEO services helping home care agencies rank on Google Maps in Jacksonville, FL" title="Local SEO for home care agencies in Jacksonville">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">Jacksonville Local SEO Domination</div>
          <div class="svc-card-desc">When families across Jacksonville search for home care, we want you showing up first, on Maps and in organic results. We handle every signal Google uses to decide who ranks.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Google Business Profile management</li>
            <li><i class="fa-solid fa-check"></i>Duval County citation building</li>
            <li><i class="fa-solid fa-check"></i>On-page SEO across all your Jacksonville service pages</li>
            <li><i class="fa-solid fa-check"></i>Review velocity management</li>
            <li><i class="fa-solid fa-check"></i>Monthly ranking reports covering 50–100 keywords</li>
            <li><i class="fa-solid fa-check"></i>Competitor gap analysis</li>
          </ul>
        </div>
      </div>
      <div class="svc-card" data-reveal style="transition-delay:.15s">
        <div class="svc-card-img">
          <img src="/images/home/service-ai-search-seo.jpg" alt="AI Search SEO (GEO) services helping Jacksonville home care agencies get cited by ChatGPT and Google AI" title="AI Search SEO for home care agencies in Jacksonville">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-brain"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">AI Search SEO for Jacksonville Agencies</div>
          <div class="svc-card-desc">More Jacksonville families than ever are asking ChatGPT, Google AI Overviews, and Perplexity for homecare recommendations. We make sure your agency is the answer they get.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Google AI Overviews optimization</li>
            <li><i class="fa-solid fa-check"></i>50+ FAQ schemas built around Jacksonville search intent</li>
            <li><i class="fa-solid fa-check"></i>E-E-A-T authority building</li>
            <li><i class="fa-solid fa-check"></i>Google Knowledge Graph entity creation</li>
            <li><i class="fa-solid fa-check"></i>ChatGPT and Perplexity citation tracking</li>
            <li><i class="fa-solid fa-check"></i>A monthly AI visibility audit report</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- AREAS -->
<section class="areas-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Service Coverage</p>
      <h2 class="section-h2">Jacksonville Neighborhoods We Help<br>Your Agency <em>Rank In</em></h2>
      <p class="section-sub">We build dedicated landing pages and local SEO signals for every specific area you serve across Jacksonville, so you rank neighborhood by neighborhood, not just city-wide.</p>
    </div>
    <div class="areas-grid" data-reveal style="transition-delay:.1s">
      <div class="area-pill"><div class="area-dot"></div>Riverside</div>
      <div class="area-pill"><div class="area-dot"></div>San Marco</div>
      <div class="area-pill"><div class="area-dot"></div>Mandarin</div>
      <div class="area-pill"><div class="area-dot"></div>Southside</div>
      <div class="area-pill"><div class="area-dot"></div>Arlington</div>
      <div class="area-pill"><div class="area-dot"></div>Avondale</div>
      <div class="area-pill"><div class="area-dot"></div>Baymeadows</div>
      <div class="area-pill"><div class="area-dot"></div>Jacksonville Beach</div>
      <div class="area-pill"><div class="area-dot"></div>Atlantic Beach</div>
      <div class="area-pill"><div class="area-dot"></div>Neptune Beach</div>
      <div class="area-pill"><div class="area-dot"></div>Ponte Vedra Beach</div>
      <div class="area-pill"><div class="area-dot"></div>Orange Park</div>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="why-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label" style="color:var(--teal-lt)"><span style="background:var(--teal-lt);display:inline-block;width:24px;height:2px;border-radius:2px;margin-right:8px;vertical-align:middle"></span>Why Homecare Creators</p>
      <h2 class="section-h2" style="color:#fff">Built to Truly<br><em>Understand Jacksonville Homecare</em></h2>
      <p class="section-sub" style="color:rgba(255,255,255,.58)">Generalist agencies don't understand homecare, Florida's AHCA licensing, Medicaid waiver nuances, or the demographics driving senior care demand across Jacksonville. We do, because we're built exclusively for homecare.</p>
    </div>
    <div class="why-grid" data-reveal style="transition-delay:.1s">
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-bullseye"></i></div><h4>100% Homecare-Only</h4><p>Every keyword, page, and strategy we build is purpose-built for homecare agencies. We don't take on restaurants or dentists, and that focus is exactly why competitors can't match us.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-map-location-dot"></i></div><h4>Jacksonville Market Knowledge</h4><p>We know Duval County's demographics inside and out: the retirement migration from the Northeast, the strong private-pay demand in Riverside and San Marco, and a Medicaid landscape that trips up outsiders.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-robot"></i></div><h4>AI Search Optimization</h4><p>We optimize for ChatGPT, Google AI Overviews, and Perplexity. Jacksonville families are already asking AI "what's the best homecare agency near me?" We make sure it's your name that comes back.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-dollar-sign"></i></div><h4>ROI You Can Measure</h4><p>One new private-pay client in Jacksonville is worth $3,000–$8,000 per year. Most of the time, our SEO retainer pays for itself within 30 days of that first client inquiry.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-handshake"></i></div><h4>No Long-Term Contracts</h4><p>We keep clients because of results, not paperwork. Every plan goes month-to-month after the first 90 days, and we're confident enough in the work to let you walk away anytime.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-layer-group"></i></div><h4>Website + SEO + AI in One</h4><p>Stop juggling three different vendors. We design your site, manage your Google Business Profile, and build AI search authority in one retainer, with one strategy call a month.</p></div>
    </div>
  </div>
</section>

<?php include '../includes/case-study-slider.php'; ?>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Jacksonville Homecare Marketing:<br><em>Questions Agency Owners Ask</em></h2>
      <p class="section-sub">Answers to what Jacksonville home care agency owners want to know before they sign on.</p>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How much does home care SEO cost for a Jacksonville agency?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Every plan is a flat monthly retainer, no hidden setup fees. What you pay depends on how competitive your specific service area is and whether you need a new website built alongside SEO. Book a free audit and we'll walk you through exact numbers for your agency.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How long until my Jacksonville agency starts ranking on Google?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Starting from zero, most Jacksonville clients see Google Maps movement within 60–90 days, with organic rankings building over the following months. Timelines vary with how competitive your service area is and how much content and citation work your site needs.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you only work with agencies in Jacksonville?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">No, we work with home care agencies throughout Duval County and across Florida. If you serve multiple cities, we build out a dedicated strategy and pages for each market you operate in.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">What's included in the monthly retainer?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Local SEO (Google Business Profile management, citations, review growth), on-page optimization across your site, monthly ranking reports, and a strategy call every month. Website design and AI search optimization are available as add-ons or bundled in, depending on the plan.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you require a long-term contract?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">No. After an initial 90-day ramp-up period, every plan moves to month-to-month. We'd rather earn your business every month than lock you into a contract.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can you also build or redesign my agency's website?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes. Most Jacksonville clients bundle website design with SEO since the two work best together, but we also support agencies who already have a site and just want SEO and AI search optimization managed.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can ChatGPT and Google AI recommend my Jacksonville agency to families?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes, and it's a fast-growing channel. We optimize your site's structure, entity data, and FAQ content so AI tools like ChatGPT, Google AI Overviews, and Perplexity can accurately cite and recommend your agency, not just traditional Google search.</div></div>
      </div>

    </div>
  </div>
</section>

<!-- INTERNAL LINKS -->
<section style="background:var(--cream);padding:48px 40px">
  <div class="container" style="text-align:center">
    <p class="section-label" style="justify-content:center">Our Services</p>
    <h2 class="section-h2" style="text-align:center">Grow Your Jacksonville Homecare Agency</h2>
    <div style="display:flex;gap:20px;justify-content:center;flex-wrap:wrap;margin-top:32px">
      <a href="/homecare-website-design-jacksonville-fl/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-laptop-code" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Jacksonville Website Design</div><div style="font-size:12px;color:var(--muted)">Your dedicated Jacksonville web design page</div></div>
      </a>
      <a href="/seo/local-seo-for-home-care-agencies" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-magnifying-glass-chart" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Local SEO for Homecare</div><div style="font-size:12px;color:var(--muted)">Rank #1 on Google Maps in Jacksonville</div></div>
      </a>
      <a href="/seo/home-care-seo/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-bullhorn" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Home Care Agency Marketing</div><div style="font-size:12px;color:var(--muted)">Full-service SEO built for home care</div></div>
      </a>
    </div>
  </div>
</section>
<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-content" data-reveal>
        <p class="section-label">Get Started Today</p>
        <h2 class="section-h2">Ready to Dominate Jacksonville<br>Homecare <em>Search Results?</em></h2>
        <p class="cta-desc">Book a free 30-minute audit and we'll dig into your current Jacksonville digital presence, show you what your competitors are actually doing, and hand you a 90-day roadmap to rank #1. No cost, no obligation.</p>
        <div class="cta-actions">
          <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-calendar-check"></i>Get My Free Jacksonville SEO Audit</button>
        </div>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free audit &nbsp;·&nbsp; No obligation &nbsp;·&nbsp; 30-day satisfaction guarantee</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/home/cta-business-owner.jpg" alt="Jacksonville home care agency owner growing their business with Homecare Creators" title="Jacksonville home care agency owner growth">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Audit Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Website &amp; speed analysis</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Google Maps ranking audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Competitor comparison</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">90-day growth roadmap</div></div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php include '../includes/footer.php'; ?>
