<?php
$page_title = "Home Care SEO Services & Pricing | Homecare Creators";
$page_desc = "Home Care SEO plans starting at \$599/month. Google Maps optimization, keyword research, technical SEO, and monthly reporting built for home care agencies.";
$page_canonical = "https://homecarecreators.com/seo/home-care-seo/";
$og_title = "Home Care SEO Services & Pricing | Homecare Creators";
$og_desc = "Families searching for care find agencies on Google Maps and in local results. We help home care agencies show up for those searches, with plans starting at \$599/month.";
$page_css = <<<CSS
/* HERO */
.hero{background:var(--forest);position:relative;overflow:hidden;padding:0}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-grid{position:relative;z-index:2;max-width:1280px;margin:0 auto;display:grid;grid-template-columns:1.05fr .95fr;gap:56px;align-items:center;padding:150px 48px 80px}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb a:hover{color:rgba(255,255,255,.7)}
.hero-breadcrumb span{color:var(--teal-lt)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:24px;width:fit-content}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(32px,4vw,50px);line-height:1.12;color:#fff;margin-bottom:18px}
.hero-desc{font-size:17.5px;line-height:1.75;color:rgba(255,255,255,.65);max-width:500px;margin-bottom:28px}
.hero-check-list{display:flex;flex-direction:column;gap:12px;margin-bottom:36px}
.hero-check-item{display:flex;align-items:center;gap:10px;font-size:15px;color:rgba(255,255,255,.85);font-family:'Plus Jakarta Sans',sans-serif;font-weight:500}
.hero-check-item i{color:var(--teal-lt);font-size:14px;flex-shrink:0}
.hero-photo-wrap{position:relative}
.hero-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/4.3;box-shadow:0 30px 80px rgba(0,0,0,.4);position:relative}
.hero-photo img{width:100%;height:100%;object-fit:cover;display:block}
.hero-photo-badge{position:absolute;bottom:-22px;left:-22px;z-index:3;background:#fff;border-radius:16px;padding:16px 20px;box-shadow:0 20px 50px rgba(10,46,30,.3);display:flex;align-items:center;gap:12px}
.hero-photo-badge-icon{width:42px;height:42px;border-radius:12px;background:rgba(29,158,117,.1);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.hero-photo-badge-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;color:var(--forest);line-height:1.1}
.hero-photo-badge-label{font-size:11px;color:var(--muted);font-weight:600;font-family:'Plus Jakarta Sans',sans-serif}

/* WHAT'S INCLUDED */
.feature-intro{max-width:720px;margin:0 auto 48px;text-align:center}
.feature-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.feature-card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:22px;transition:.25s}
.feature-card:hover{border-color:rgba(29,158,117,.25);box-shadow:0 10px 32px rgba(10,46,30,.08)}
.feature-icon{width:44px;height:44px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:14px}
.feature-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15.5px;color:var(--forest);margin-bottom:8px}
.feature-desc{font-size:14px;line-height:1.65;color:var(--muted)}

/* TWO-COLUMN TEXT+IMAGE (shared by the process section) */
.why-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.why-visual{position:relative;align-self:start}
.why-img{border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(10,46,30,.18);aspect-ratio:4/5}
.why-img img{width:100%;height:100%;object-fit:cover;display:block}

/* TIMELINE (How the first six months work) */
.timeline{display:flex;flex-direction:column;gap:0;position:relative;margin-top:24px}
.timeline-item{display:flex;gap:20px;padding-bottom:36px;position:relative}
.timeline-item:last-child{padding-bottom:0}
.timeline-item::before{content:'';position:absolute;left:21px;top:46px;bottom:0;width:1px;background:var(--border)}
.timeline-item:last-child::before{display:none}
.timeline-num{width:44px;height:44px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;flex-shrink:0;position:relative;z-index:1}
.timeline-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;color:var(--forest);margin-bottom:6px}
.timeline-desc{font-size:15px;line-height:1.7;color:var(--muted)}
.timeline-note{font-size:15px;line-height:1.75;color:var(--muted);margin-top:8px;padding:20px 24px;background:var(--warm);border-radius:14px;border:1px solid var(--border)}

/* PRICING */
.pricing-intro{max-width:680px;margin:0 auto 48px;text-align:center}
.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;align-items:stretch}
.price-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px 28px;display:flex;flex-direction:column;position:relative;transition:.25s}
.price-card.featured{border:2px solid var(--teal);box-shadow:0 20px 56px rgba(10,46,30,.12);transform:translateY(-8px)}
.price-featured-tag{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:6px 16px;border-radius:100px;white-space:nowrap}
.price-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:19px;color:var(--forest);margin-bottom:6px}
.price-amount{display:flex;align-items:baseline;gap:4px;margin-bottom:20px}
.price-amount-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:40px;color:var(--forest)}
.price-amount-period{font-size:14px;color:var(--muted);font-weight:600}
.price-feature-list{list-style:none;display:flex;flex-direction:column;gap:11px;margin-bottom:26px;flex:1}
.price-feature-list li{display:flex;align-items:flex-start;gap:9px;font-size:14px;color:var(--text);line-height:1.5}
.price-feature-list li i{color:var(--teal);font-size:12px;margin-top:4px;flex-shrink:0}
.price-feature-list li strong{color:var(--forest)}
.price-cta{width:100%;justify-content:center}
.price-cta.dark{background:var(--forest);color:#fff;border:none}
.addons-note{max-width:820px;margin:40px auto 0;text-align:center;font-size:14.5px;line-height:1.75;color:var(--muted);padding:22px 26px;background:var(--warm);border-radius:14px;border:1px solid var(--border)}

/* SECTIONS */
.included-section{background:#fff}
.process-section{background:var(--cream)}
.pricing-section{background:#fff}
.faq-section{background:var(--cream)}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:104px 40px}
.cta-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.cta-content .section-label{color:var(--teal-lt)}
.cta-content .section-label::before{background:var(--teal-lt)}
.cta-content .section-h2{color:#fff}
.cta-desc{font-size:18px;color:rgba(255,255,255,.68);line-height:1.78;margin-bottom:32px}
.cta-guarantee{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.45);display:flex;align-items:center;gap:8px;margin-top:18px}
.cta-guarantee i{color:var(--teal-lt)}
.cta-image{position:relative;border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3)}
.cta-image img{width:100%;height:400px;object-fit:cover;display:block}
.cta-image-badge{position:absolute;bottom:20px;left:20px;right:20px;background:rgba(10,46,30,.88);backdrop-filter:blur(12px);border:1px solid rgba(46,198,143,.22);border-radius:12px;padding:16px 18px}
.cta-image-badge-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#fff;margin-bottom:10px}
.cta-badge-row{display:flex;align-items:center;gap:8px;margin-bottom:6px}
.cta-badge-row:last-child{margin-bottom:0}
.cta-badge-dot{width:5px;height:5px;border-radius:50%;background:var(--teal-lt);flex-shrink:0}
.cta-badge-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.65)}

/* RESPONSIVE */
@media(max-width:1024px){
  .hero-grid{grid-template-columns:1fr;padding:140px 32px 64px;gap:40px}
  .hero-photo{max-width:420px;margin:0 auto;aspect-ratio:4/3.2}
  .hero-photo-badge{left:16px}
  .why-grid{grid-template-columns:1fr;gap:48px}
  .why-img{max-width:420px;margin:0 auto}
  .feature-grid{grid-template-columns:1fr 1fr}
  .pricing-grid{grid-template-columns:1fr;max-width:460px;margin:0 auto}
  .price-card.featured{transform:none}
  .cta-inner{grid-template-columns:1fr}
  .cta-image{display:none}
}
@media(max-width:640px){
  section{padding:64px 20px}
  .hero-grid{padding:120px 24px 48px}
  .feature-grid{grid-template-columns:1fr}
  .timeline-item{gap:16px}
}
CSS;
include '../../includes/header.php';

// ── Structured data: BreadcrumbList, Service, FAQPage ──────────
$_bc = [
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://homecarecreators.com/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Services","item"=>"https://homecarecreators.com/#services"],
    ["@type"=>"ListItem","position"=>3,"name"=>"Home Care SEO","item"=>$page_canonical],
];
$_faqs = [
    ["How much does home care SEO cost?", "Plans start at \$599 per month. Care Plus is \$899 per month, and Care Advanced is \$1,599 per month. Optional add-ons are available. We'll recommend the right plan during your free strategy call."],
    ["How long until I see results?", "Results depend on your market and competition. Most agencies see movement in local visibility over several months, with growth building over time. We'll share a realistic timeline for your agency during the audit."],
    ["How many keywords will you target?", "Starter targets 5 keywords, Care Plus targets 10, and Care Advanced targets 15. We choose terms based on what families search for in your service areas."],
    ["Is Google Business Profile management included?", "Yes. Starter and Care Plus include management for one location, and Care Advanced includes two. Additional locations are available as an add-on."],
    ["Do you guarantee rankings?", "No. No ethical SEO provider can guarantee rankings, because search engines change constantly. We commit to a transparent process, proven best practices, and reporting you can check."],
    ["Can you optimize my existing website?", "Yes. Most plans improve your current site rather than starting from scratch. We'll confirm what your site needs during the audit."],
    ["What add-ons are available?", "Common add-ons include local citations, extra Google Business Profile locations, location pages, Bing Places setup, and entity optimization. Your plan can be expanded as your agency grows."],
];
echo '<script type="application/ld+json">' . json_encode(["@context"=>"https://schema.org","@type"=>"BreadcrumbList","itemListElement"=>$_bc], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"Service",
    "name"=>"Home Care SEO Services",
    "serviceType"=>"SEO Services",
    "provider"=>["@type"=>"Organization","name"=>"Homecare Creators","url"=>"https://homecarecreators.com/"],
    "areaServed"=>["@type"=>"Country","name"=>"United States"],
    "description"=>$page_desc,
    "url"=>$page_canonical,
    "offers"=>[
        ["@type"=>"Offer","name"=>"Starter","price"=>"599","priceCurrency"=>"USD","priceSpecification"=>["@type"=>"UnitPriceSpecification","price"=>"599","priceCurrency"=>"USD","unitText"=>"MONTH"]],
        ["@type"=>"Offer","name"=>"Care Plus","price"=>"899","priceCurrency"=>"USD","priceSpecification"=>["@type"=>"UnitPriceSpecification","price"=>"899","priceCurrency"=>"USD","unitText"=>"MONTH"]],
        ["@type"=>"Offer","name"=>"Care Advanced","price"=>"1599","priceCurrency"=>"USD","priceSpecification"=>["@type"=>"UnitPriceSpecification","price"=>"1599","priceCurrency"=>"USD","unitText"=>"MONTH"]],
    ],
], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"FAQPage",
    "mainEntity"=>array_map(function($f){ return ["@type"=>"Question","name"=>$f[0],"acceptedAnswer"=>["@type"=>"Answer","text"=>$f[1]]]; }, $_faqs),
], JSON_UNESCAPED_SLASHES) . "</script>\n";
?>

<!-- HERO -->
<section class="hero" id="home">
  <div class="hero-bg-grid"></div>
  <div class="hero-grid">
    <div>
      <div class="hero-breadcrumb"><a href="/">Home</a> / <a href="/#services">Services</a> / <span>Home Care SEO</span></div>
      <div class="hero-badge"><div class="hero-badge-pulse"></div>Home Care SEO Services</div>
      <h1 class="hero-h1">Home Care SEO That Brings Qualified Leads to Your Agency</h1>
      <p class="hero-desc">Families searching for care find agencies on Google Maps and in local results. We help home care agencies show up for those searches, with plans starting at $599 per month.</p>
      <div class="hero-check-list">
        <div class="hero-check-item"><i class="fa-solid fa-circle-check"></i>Google Maps and local search optimization</div>
        <div class="hero-check-item"><i class="fa-solid fa-circle-check"></i>Keyword research and on-page SEO</div>
        <div class="hero-check-item"><i class="fa-solid fa-circle-check"></i>Technical SEO and AI search readiness</div>
        <div class="hero-check-item"><i class="fa-solid fa-circle-check"></i>Monthly reporting on rankings and leads</div>
      </div>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-phone"></i>Book a Free Strategy Call</button>
      </div>
    </div>
    <div class="hero-photo-wrap" data-reveal>
      <div class="hero-photo">
        <img src="/images/team/team-presenting-results-screen.jpg" alt="Homecare Creators team presenting SEO rankings and results on screen" title="Presenting a home care agency's SEO results">
      </div>
      <div class="hero-photo-badge">
        <div class="hero-photo-badge-icon"><i class="fa-solid fa-tag"></i></div>
        <div>
          <div class="hero-photo-badge-num">$599/mo</div>
          <div class="hero-photo-badge-label">Plans Starting At</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CERTIFICATIONS / TRUST BADGES -->
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

<!-- WHAT'S INCLUDED -->
<section class="included-section" id="included">
  <div class="container">
    <div class="feature-intro" data-reveal>
      <p class="section-label" style="justify-content:center">What's Included</p>
      <h2 class="section-h2" style="text-align:center">What Our Home Care SEO Includes</h2>
      <p class="section-sub" style="margin:0 auto">Every plan covers the foundations of home care SEO. Higher plans add more keywords, pages, content, and depth.</p>
    </div>
    <div class="feature-grid" data-reveal style="transition-delay:.1s">
        <div class="feature-card">
          <div class="feature-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
          <div class="feature-title">Keyword research and intent mapping</div>
          <div class="feature-desc">We identify the terms families use, from "home care near me" to "how much does home care cost," and map them to the right pages. Starter targets 5 keywords, Care Plus targets 10, and Care Advanced targets 15.</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fa-brands fa-google"></i></div>
          <div class="feature-title">Google Maps and Business Profile management</div>
          <div class="feature-desc">We manage your profile, keep services and service areas accurate, and publish regular posts. Starter includes 2 posts per month, Care Plus includes 4, and Care Advanced includes 8.</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fa-solid fa-file-lines"></i></div>
          <div class="feature-title">On-page optimization</div>
          <div class="feature-desc">We optimize titles, meta descriptions, headings, URLs, and internal links on the pages that matter most. Starter covers 2 pages, Care Plus covers 4, and Care Advanced covers 6.</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fa-solid fa-gauge-high"></i></div>
          <div class="feature-title">Technical SEO</div>
          <div class="feature-desc">We audit how search engines crawl and index your site, then fix redirects, canonical tags, sitemaps, and page speed issues. Higher plans add Core Web Vitals work.</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fa-solid fa-robot"></i></div>
          <div class="feature-title">Schema and AI search readiness</div>
          <div class="feature-desc">Every plan includes local schema. Care Plus adds FAQ schema, and Care Advanced adds review and service schema plus an llms.txt file.</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fa-solid fa-pen-nib"></i></div>
          <div class="feature-title">Content that answers family questions</div>
          <div class="feature-desc">Starter includes 1 blog post per month, Care Plus includes 2, and Care Advanced includes 4, each written to 800–1,500 words depending on the plan.</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fa-solid fa-link"></i></div>
          <div class="feature-title">Backlinks and authority</div>
          <div class="feature-desc">We build links from relevant, authoritative sites and audit for harmful links. Starter includes 2 backlinks per month, Care Plus includes 4, and Care Advanced includes 6.</div>
        </div>
        <div class="feature-card">
          <div class="feature-icon"><i class="fa-solid fa-chart-line"></i></div>
          <div class="feature-title">Tracking and reporting</div>
          <div class="feature-desc">We set up Google Analytics 4 and Search Console from day one. Care Plus and Care Advanced also include Bing Search Console and Google Tag Manager.</div>
        </div>
    </div>
  </div>
</section>

<!-- HOW THE FIRST SIX MONTHS WORK -->
<section class="process-section">
  <div class="container">
    <div class="why-grid">
      <div data-reveal>
        <p class="section-label">How It Works</p>
        <h2 class="section-h2">How the First Six Months Work</h2>
        <div class="timeline">
          <div class="timeline-item">
            <div class="timeline-num">1</div>
            <div>
              <div class="timeline-title">Month 1: Audit and Plan</div>
              <div class="timeline-desc">We review your Google Business Profile, website, current rankings, and competitors. You receive a written plan with priorities.</div>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-num">2</div>
            <div>
              <div class="timeline-title">Months 2–3: Foundations</div>
              <div class="timeline-desc">We optimize your Google profile, fix technical issues, improve your core service pages, and start publishing content.</div>
            </div>
          </div>
          <div class="timeline-item">
            <div class="timeline-num">3</div>
            <div>
              <div class="timeline-title">Months 4–6: Growth</div>
              <div class="timeline-desc">We expand your pages and content, refresh older posts on higher plans, and review what's working. You receive monthly reports covering rankings, calls, and leads.</div>
            </div>
          </div>
        </div>
        <p class="timeline-note">Timelines vary by market and competition. Most agencies see results build over several months, and the work compounds over time.</p>
      </div>
      <div class="why-visual" data-reveal style="transition-delay:.15s">
        <div class="why-img">
          <img src="/images/team/team-presenting-results-screen-2.jpg" alt="Homecare Creators team presenting a home care agency's SEO audit and plan" title="Presenting a home care agency's SEO audit and plan">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="pricing-section" id="pricing">
  <div class="container">
    <div class="pricing-intro" data-reveal>
      <p class="section-label" style="justify-content:center">Pricing</p>
      <h2 class="section-h2" style="text-align:center">Choose the Plan That Fits Your Market</h2>
      <p class="section-sub" style="margin:0 auto">Each plan includes a strategy call and a written plan. Choose the plan that matches the number of cities you serve and how competitive your market is.</p>
    </div>
    <div class="pricing-grid" data-reveal style="transition-delay:.1s">
      <div class="price-card">
        <div class="price-name">Starter</div>
        <div class="price-amount"><span class="price-amount-num">$599</span><span class="price-amount-period">/month</span></div>
        <ul class="price-feature-list">
          <li><i class="fa-solid fa-check"></i><span><strong>5</strong> keywords targeted</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>1</strong> competitor analyzed</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> pages optimized</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>1</strong> blog post per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>1</strong> Google Business Profile location</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> GBP posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> backlinks per month</span></li>
          <li><i class="fa-solid fa-check"></i><span>Local schema</span></li>
          <li><i class="fa-solid fa-check"></i><span>Standard reporting</span></li>
        </ul>
        <button class="btn-secondary price-cta dark" onclick="openPopup()">Book a Free Strategy Call</button>
      </div>
      <div class="price-card featured">
        <div class="price-featured-tag">Most Popular</div>
        <div class="price-name">Care Plus</div>
        <div class="price-amount"><span class="price-amount-num">$899</span><span class="price-amount-period">/month</span></div>
        <ul class="price-feature-list">
          <li><i class="fa-solid fa-check"></i><span><strong>10</strong> keywords targeted</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> competitors analyzed</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>4</strong> pages optimized</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> blog posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>1</strong> Google Business Profile location</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>4</strong> GBP posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>4</strong> backlinks per month</span></li>
          <li><i class="fa-solid fa-check"></i><span>Local + FAQ schema</span></li>
          <li><i class="fa-solid fa-check"></i><span>Core Web Vitals included</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>1</strong> blog refresh per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> community posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span>Custom reporting</span></li>
        </ul>
        <button class="btn-primary price-cta" onclick="openPopup()">Book a Free Strategy Call</button>
      </div>
      <div class="price-card">
        <div class="price-name">Care Advanced</div>
        <div class="price-amount"><span class="price-amount-num">$1,599</span><span class="price-amount-period">/month</span></div>
        <ul class="price-feature-list">
          <li><i class="fa-solid fa-check"></i><span><strong>15</strong> keywords targeted</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> competitors analyzed</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>6</strong> pages optimized</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>4</strong> blog posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> Google Business Profile locations</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>8</strong> GBP posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>6</strong> backlinks per month</span></li>
          <li><i class="fa-solid fa-check"></i><span>Local + FAQ + Review + Service schema</span></li>
          <li><i class="fa-solid fa-check"></i><span>Core Web Vitals included</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> blog refreshes per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>5</strong> community posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span>Advanced reporting</span></li>
        </ul>
        <button class="btn-secondary price-cta dark" onclick="openPopup()">Book a Free Strategy Call</button>
      </div>
    </div>
    <p class="addons-note">Optional add-ons are available for any plan, including a second Google Business Profile location ($100/month), a 50-citation local listing bundle ($100/month), a single location page ($200), and entity optimization ($1,500, one-time). Ask about add-ons on your strategy call.</p>
  </div>
</section>

<?php include '../../includes/case-study-slider.php'; ?>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Frequently Asked<br><em>Questions</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">
      <?php foreach ($_faqs as $f): ?>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text"><?= htmlspecialchars($f[0]) ?></span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><?= htmlspecialchars($f[1]) ?></div></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-content" data-reveal>
        <p class="section-label">Get Started Today</p>
        <h2 class="section-h2">Ready to Grow Your<br><em>Home Care Agency?</em></h2>
        <p class="cta-desc">Families are searching for home care every day. Let's make sure they find your agency. Book a free strategy call and we'll review your current visibility, your Google Business Profile, and the biggest opportunities in your market, then recommend the right plan.</p>
        <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-phone"></i>Book Your Free Strategy Call</button>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free strategy call &nbsp;·&nbsp; No obligation</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/team/team-coffee-break-laughing.jpg" alt="Homecare Creators team celebrating a home care agency's SEO growth" title="Growing a home care agency's SEO results">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Your Strategy Call Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Current visibility &amp; ranking review</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Google Business Profile audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Your biggest opportunities</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">A plan recommendation</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>
