<?php
$page_title = "Home Care Website Design & Pricing | Homecare Creators";
$page_desc = "Home care website design packages starting at \$699, plus \$79/month hosting. Mobile-first, SEO-ready websites built to turn visitors into inquiries.";
$page_canonical = "https://homecarecreators.com/web-design/homecare-website-design/";
$og_title = "Home Care Website Design & Pricing | Homecare Creators";
$og_desc = "Custom websites built specifically for home care agencies, designed to help families trust your services, contact your team, and find the care they need.";
$page_css = <<<CSS
/* HERO */
.hero{background:var(--forest);position:relative;overflow:hidden;padding:0}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-grid{position:relative;z-index:2;max-width:1280px;margin:0 auto;display:grid;grid-template-columns:1.05fr .95fr;gap:56px;align-items:center;padding:150px 48px 80px}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:24px;width:fit-content}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(32px,3.8vw,48px);line-height:1.14;color:#fff;margin-bottom:16px}
.hero-subhead{font-size:18px;line-height:1.7;color:#fff;font-weight:600;max-width:520px;margin-bottom:16px}
.hero-desc{font-size:16.5px;line-height:1.75;color:rgba(255,255,255,.62);max-width:520px;margin-bottom:28px}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:28px}
.hero-trust-line{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:rgba(255,255,255,.5)}
.hero-photo-wrap{position:relative}
.hero-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/4.3;box-shadow:0 30px 80px rgba(0,0,0,.4);position:relative}
.hero-photo img{width:100%;height:100%;object-fit:cover;display:block}
.hero-photo-badge{position:absolute;bottom:-22px;left:-22px;z-index:3;background:#fff;border-radius:16px;padding:16px 20px;box-shadow:0 20px 50px rgba(10,46,30,.3);display:flex;align-items:center;gap:12px}
.hero-photo-badge-icon{width:42px;height:42px;border-radius:12px;background:rgba(29,158,117,.1);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.hero-photo-badge-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;color:var(--forest);line-height:1.1}
.hero-photo-badge-label{font-size:11px;color:var(--muted);font-weight:600;font-family:'Plus Jakarta Sans',sans-serif}

/* FEATURE GRID */
.feature-intro{max-width:960px;margin:0 auto 48px;text-align:center}
.feature-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.feature-card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:26px;transition:.25s}
.feature-card:hover{border-color:rgba(29,158,117,.25);box-shadow:0 10px 32px rgba(10,46,30,.08)}
.feature-icon{width:46px;height:46px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:19px;margin-bottom:16px}
.feature-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;color:var(--forest);margin-bottom:8px}
.feature-desc{font-size:14.5px;line-height:1.65;color:var(--muted)}

/* TWO-COLUMN TEXT+IMAGE */
.why-grid{display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:start}
.why-visual{position:relative;align-self:start}
.why-img{border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(10,46,30,.18);aspect-ratio:4/5}
.why-img img{width:100%;height:100%;object-fit:cover;display:block}
.why-questions{list-style:none;display:flex;flex-direction:column;gap:10px;margin:20px 0}
.why-questions li{display:flex;align-items:flex-start;gap:10px;font-size:15.5px;color:var(--text);line-height:1.5}
.why-questions li i{color:var(--teal);font-size:12px;margin-top:5px;flex-shrink:0}
.designed-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:14px;margin-top:28px}
.designed-card{background:var(--warm);border:1px solid var(--border);border-radius:14px;padding:18px}
.designed-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--forest);margin-bottom:6px}
.designed-card p{font-size:13px;line-height:1.55;color:var(--muted)}

/* PROCESS */
.process-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:24px;margin-top:40px}
.process-step{text-align:center;padding:0 10px}
.process-num{width:52px;height:52px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;margin:0 auto 14px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:18px}
.process-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;color:var(--forest);margin-bottom:6px}
.process-desc{font-size:13.5px;line-height:1.55;color:var(--muted)}

/* PRICING */
.pricing-intro{max-width:700px;margin:0 auto 48px;text-align:center}
.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;align-items:stretch}
.price-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px 28px;display:flex;flex-direction:column;position:relative;transition:.25s}
.price-card.featured{border:2px solid var(--teal);box-shadow:0 20px 56px rgba(10,46,30,.12);transform:translateY(-8px)}
.price-featured-tag{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:6px 16px;border-radius:100px;white-space:nowrap}
.price-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:19px;color:var(--forest);margin-bottom:6px}
.price-sub{font-size:14px;color:var(--muted);line-height:1.5;margin-bottom:18px}
.price-amount{display:flex;align-items:baseline;gap:4px;margin-bottom:4px}
.price-amount-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:40px;color:var(--forest)}
.price-amount-period{font-size:13px;color:var(--muted);font-weight:600}
.price-hosting-note{font-size:12.5px;color:var(--muted);margin-bottom:20px}
.price-feature-list{list-style:none;display:flex;flex-direction:column;gap:11px;margin-bottom:26px;flex:1}
.price-feature-list li{display:flex;align-items:flex-start;gap:9px;font-size:14px;color:var(--text);line-height:1.5}
.price-feature-list li i{color:var(--teal);font-size:12px;margin-top:4px;flex-shrink:0}
.price-cta{width:100%;justify-content:center}
.price-cta.dark{background:var(--forest);color:#fff;border:none}
.pricing-footnote{max-width:820px;margin:32px auto 0;text-align:center;font-size:13.5px;line-height:1.7;color:var(--muted);font-style:italic}

/* SECTIONS */
.feature-section{background:#fff}
.why-section{background:var(--cream)}
.process-section{background:#fff}
.pricing-section{background:var(--cream)}
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
  .feature-grid{grid-template-columns:1fr 1fr}
  .why-grid{grid-template-columns:1fr;gap:48px}
  .why-img{max-width:480px;margin:0 auto}
  .process-grid{grid-template-columns:1fr 1fr}
  .pricing-grid{grid-template-columns:1fr;max-width:460px;margin:0 auto}
  .price-card.featured{transform:none}
  .cta-inner{grid-template-columns:1fr}
  .cta-image{display:none}
}
@media(max-width:640px){
  section{padding:64px 20px}
  .hero-grid{padding:120px 24px 48px}
  .feature-grid,.process-grid,.designed-grid{grid-template-columns:1fr}
}
CSS;
include '../../includes/header.php';

// ── Structured data: BreadcrumbList, Service, FAQPage ──────────
$_bc = [
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://homecarecreators.com/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Services","item"=>"https://homecarecreators.com/#services"],
    ["@type"=>"ListItem","position"=>3,"name"=>"Home Care Website Design","item"=>$page_canonical],
];
$_faqs = [
    ["Do I need to write any content or copy myself?", "Website copy can be included in the agreed project scope. We work with you to confirm your services, service area, business information, and other details so the final content accurately represents your agency."],
    ["How long does it take to build a home care website?", "Our target timelines are 10–14 days for Starter and Growth, and up to 21 days for Dominate. Timing depends on the agreed scope, receipt of required information, feedback, and approvals."],
    ["Will my website rank on Google?", "We build the agreed SEO foundations into your website, but no developer can honestly guarantee a particular Google ranking from a website launch alone. Results depend on your market, competition, website history, local presence, content, authority, and ongoing SEO work."],
    ["Can you redesign my existing home care website?", "Yes. We can review your current website and discuss whether a redesign or targeted improvements are the better option. Where relevant, we plan URL redirects and migration steps to help protect existing search visibility."],
    ["Can you create pages for the cities we serve?", "Yes. The Growth package includes three city or service-area pages, and Dominate includes eight. Additional pages can be discussed separately. Each page should provide useful, location-specific information rather than simply repeating the same content with a different city name."],
    ["Can my website help recruit caregivers?", "Yes. A dedicated careers page can describe open positions, explain the application process, and collect applications. Recruitment results depend on factors beyond the website, including job availability, pay, competition, and your hiring process."],
    ["What is included in the \$79 monthly hosting fee?", "The hosting fee is \$79/month. We will specify the included hosting resources, SSL, backups, security, updates, support, and maintenance in your package agreement. Any exclusions or third-party fees should be disclosed before work begins."],
    ["How much does a home care website cost?", "Our website design packages start at \$699 for Starter, \$999 for Growth, and \$1,699 for Dominate. Hosting is \$79/month. The final scope, any additional features, and any third-party costs should be confirmed in your quote."],
    ["Can you help with SEO after the website launches?", "Yes. Our Home Care SEO Services are available for agencies that want continued support with local search visibility, website optimization, content, and other agreed SEO activities."],
];
echo '<script type="application/ld+json">' . json_encode(["@context"=>"https://schema.org","@type"=>"BreadcrumbList","itemListElement"=>$_bc], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"Service",
    "name"=>"Home Care Website Design",
    "serviceType"=>"Website Design",
    "provider"=>["@type"=>"Organization","name"=>"Homecare Creators","url"=>"https://homecarecreators.com/"],
    "areaServed"=>["@type"=>"Country","name"=>"United States"],
    "description"=>$page_desc,
    "url"=>$page_canonical,
    "offers"=>[
        ["@type"=>"Offer","name"=>"Starter","price"=>"699","priceCurrency"=>"USD"],
        ["@type"=>"Offer","name"=>"Growth","price"=>"999","priceCurrency"=>"USD"],
        ["@type"=>"Offer","name"=>"Dominate","price"=>"1699","priceCurrency"=>"USD"],
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
      <div class="hero-badge"><div class="hero-badge-pulse"></div>Home Care Website Design &amp; Development</div>
      <h1 class="hero-h1">Home Care Website Design That Turns Visitors Into Inquiries</h1>
      <p class="hero-subhead">Custom websites built specifically for home care agencies, designed to help families trust your services, contact your team, and find the care they need.</p>
      <p class="hero-desc">At Homecare Creators, we design and develop websites specifically for home care agencies. From custom page design and mobile optimization to on-page SEO and caregiver recruitment, we build the essential features your agency needs to establish a stronger online presence. Home care website packages start at $699, plus $79/month for hosting.</p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-laptop-code"></i>Get a Free Website Quote</button>
        <a href="#packages" class="btn-secondary"><i class="fa-solid fa-layer-group"></i>Compare Website Packages</a>
      </div>
      <div class="hero-trust-line">Built for home care agencies &middot; Mobile-first design &middot; SEO foundations &middot; Clear pricing</div>
    </div>
    <div class="hero-photo-wrap" data-reveal>
      <div class="hero-photo">
        <img src="/images/team/team-member-desk-openplan-office.jpg" alt="Homecare Creators designer working on a home care agency website" title="Designing a home care agency website">
      </div>
      <div class="hero-photo-badge">
        <div class="hero-photo-badge-icon"><i class="fa-solid fa-tag"></i></div>
        <div>
          <div class="hero-photo-badge-num">$699</div>
          <div class="hero-photo-badge-label">Packages Starting At</div>
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

<!-- A WEBSITE BUILT AROUND YOUR NEEDS -->
<section class="feature-section" id="included">
  <div class="container">
    <div class="feature-intro" data-reveal>
      <p class="section-label" style="justify-content:center">What We Build</p>
      <h2 class="section-h2" style="text-align:center">A Website Built Around the Needs of Your Home Care Agency</h2>
      <p class="section-sub" style="margin:0 auto">Families choosing care for a parent or loved one need clear information and reasons to trust an agency. Potential caregivers need to understand your job opportunities and how to apply. Your website should serve both audiences without making either one work to find what they need. We build home care websites around these real-world needs.</p>
    </div>
    <div class="feature-grid" data-reveal style="transition-delay:.1s">
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-palette"></i></div>
        <div class="feature-title">Custom Home Care Website Design</div>
        <div class="feature-desc">Get a website that reflects your agency's services, brand, values, and service area instead of a generic template adapted to the care industry.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-mobile-screen"></i></div>
        <div class="feature-title">Mobile-Friendly Website Development</div>
        <div class="feature-desc">Your website should be easy to navigate on smartphones, tablets, and desktop computers. We prioritize mobile usability, readable content, clear contact options, and straightforward navigation.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-brands fa-google"></i></div>
        <div class="feature-title">On-Page SEO Setup</div>
        <div class="feature-desc">We establish a strong SEO foundation with relevant page titles, meta descriptions, heading structure, clean URLs, image optimization, internal links, and appropriate structured data.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-map-location-dot"></i></div>
        <div class="feature-title">Local Service Area Pages</div>
        <div class="feature-desc">Help potential clients understand where you provide care. Depending on your package, we create dedicated pages for the cities or communities your agency genuinely serves.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-user-nurse"></i></div>
        <div class="feature-title">Caregiver Recruitment Pages</div>
        <div class="feature-desc">Make it easier for prospective caregivers to explore your opportunities, learn about your agency, and submit an application through a dedicated careers page.</div>
      </div>
      <div class="feature-card">
        <div class="feature-icon"><i class="fa-solid fa-comment-dots"></i></div>
        <div class="feature-title">Contact Forms and Trust Features</div>
        <div class="feature-desc">Give visitors clear next steps with inquiry forms, phone links, service information, testimonials or reviews where available, and calls to action throughout the site.</div>
      </div>
    </div>
    <div style="text-align:center;margin-top:40px"><button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-comments"></i>Discuss Your Website Project</button></div>
  </div>
</section>

<!-- WHY SPECIALIZED WEBSITE DESIGN -->
<section class="why-section">
  <div class="container">
    <div class="why-grid">
      <div data-reveal>
        <p class="section-label">Why It Matters</p>
        <h2 class="section-h2">Why Home Care Agencies Need Specialized Website Design</h2>
        <p style="font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:12px">A home care website should answer the questions families ask before they call:</p>
        <ul class="why-questions">
          <li><i class="fa-solid fa-circle-question"></i>What services do you provide, and where?</li>
          <li><i class="fa-solid fa-circle-question"></i>What makes your agency different?</li>
          <li><i class="fa-solid fa-circle-question"></i>How do I get in touch with your team?</li>
        </ul>
        <div class="designed-grid">
          <div class="designed-card">
            <h3>Designed for Families</h3>
            <p>Content organized around your services and the questions families ask.</p>
          </div>
          <div class="designed-card">
            <h3>Designed for Inquiries</h3>
            <p>Clear calls to action and simple forms help visitors take the next step.</p>
          </div>
          <div class="designed-card">
            <h3>Designed for Recruitment</h3>
            <p>A dedicated careers page makes it easy for job seekers to apply.</p>
          </div>
          <div class="designed-card">
            <h3>Designed for Search Visibility</h3>
            <p>Strong content and structure help search engines understand your services.</p>
          </div>
        </div>
      </div>
      <div class="why-visual" data-reveal style="transition-delay:.15s">
        <div class="why-img">
          <img src="/images/team/team-member-working-laptop-office.jpg" alt="Homecare Creators web developer building a home care agency website" title="Building a home care agency website">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PROCESS -->
<section class="process-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Our Process</p>
      <h2 class="section-h2" style="text-align:center">Our Home Care Website Design Process</h2>
    </div>
    <div class="process-grid" data-reveal style="transition-delay:.1s">
      <div class="process-step">
        <div class="process-num">1</div>
        <div class="process-title">Discovery and Planning</div>
        <div class="process-desc">We learn about your agency, services, audience, and goals.</div>
      </div>
      <div class="process-step">
        <div class="process-num">2</div>
        <div class="process-title">Structure, Content &amp; Design</div>
        <div class="process-desc">We plan your pages and design a site that reflects your brand.</div>
      </div>
      <div class="process-step">
        <div class="process-num">3</div>
        <div class="process-title">Development and Review</div>
        <div class="process-desc">We build the site, test it, and you review before launch.</div>
      </div>
      <div class="process-step">
        <div class="process-num">4</div>
        <div class="process-title">SEO Setup and Launch</div>
        <div class="process-desc">We finalize SEO, test forms, and launch your site.</div>
      </div>
    </div>
    <p class="section-sub" style="text-align:center;margin:28px auto 0">Standard timelines are 10–14 days for Starter and Growth, up to 21 days for Dominate.</p>
  </div>
</section>

<!-- PACKAGES -->
<section class="pricing-section" id="packages">
  <div class="container">
    <div class="pricing-intro" data-reveal>
      <p class="section-label" style="justify-content:center">Pricing</p>
      <h2 class="section-h2" style="text-align:center">Home Care Website Design Packages</h2>
      <p class="section-sub" style="margin:0 auto">Choose a package based on your agency's current needs, the number of pages you require, and the markets you serve.</p>
    </div>
    <div class="pricing-grid" data-reveal style="transition-delay:.1s">
      <div class="price-card">
        <div class="price-name">Starter</div>
        <div class="price-sub">A practical starting point for a new or small home care agency.</div>
        <div class="price-amount"><span class="price-amount-num">$699</span></div>
        <div class="price-hosting-note">Hosting: $79/month</div>
        <ul class="price-feature-list">
          <li><i class="fa-solid fa-check"></i><span>5 custom pages: Home, About, Services, Careers, Contact</span></li>
          <li><i class="fa-solid fa-check"></i><span>Mobile-first design using your branding</span></li>
          <li><i class="fa-solid fa-check"></i><span>On-page SEO setup for all 5 pages</span></li>
          <li><i class="fa-solid fa-check"></i><span>Google Reviews widget integration</span></li>
          <li><i class="fa-solid fa-check"></i><span>Contact and inquiry form</span></li>
          <li><i class="fa-solid fa-check"></i><span>Google Analytics and Search Console setup</span></li>
          <li><i class="fa-solid fa-check"></i><span>Performance optimization</span></li>
          <li><i class="fa-solid fa-check"></i><span>SSL certificate</span></li>
          <li><i class="fa-solid fa-check"></i><span>Target launch in 10–14 days</span></li>
        </ul>
        <button class="btn-secondary price-cta dark" onclick="openPopup()">Get a Starter Quote</button>
      </div>
      <div class="price-card featured">
        <div class="price-featured-tag">Most Popular</div>
        <div class="price-name">Growth</div>
        <div class="price-sub">For agencies that need more service detail and local coverage.</div>
        <div class="price-amount"><span class="price-amount-num">$999</span></div>
        <div class="price-hosting-note">Hosting: $79/month</div>
        <ul class="price-feature-list">
          <li><i class="fa-solid fa-check"></i><span><strong>Everything in Starter</strong>, plus:</span></li>
          <li><i class="fa-solid fa-check"></i><span>Up to 10 custom pages</span></li>
          <li><i class="fa-solid fa-check"></i><span>Three city or service-area pages</span></li>
          <li><i class="fa-solid fa-check"></i><span>SEO-focused caregiver careers page</span></li>
          <li><i class="fa-solid fa-check"></i><span>LocalBusiness structured data where appropriate</span></li>
          <li><i class="fa-solid fa-check"></i><span>Blog setup</span></li>
          <li><i class="fa-solid fa-check"></i><span>Google Business Profile optimization</span></li>
          <li><i class="fa-solid fa-check"></i><span>Live chat setup</span></li>
          <li><i class="fa-solid fa-check"></i><span>Additional service and conversion content</span></li>
        </ul>
        <button class="btn-primary price-cta" onclick="openPopup()">Get a Growth Quote</button>
      </div>
      <div class="price-card">
        <div class="price-name">Dominate</div>
        <div class="price-sub">For growing agencies that need a larger website and more advanced features.</div>
        <div class="price-amount"><span class="price-amount-num">$1,699</span></div>
        <div class="price-hosting-note">Hosting: $79/month</div>
        <ul class="price-feature-list">
          <li><i class="fa-solid fa-check"></i><span><strong>Everything in Growth</strong>, plus:</span></li>
          <li><i class="fa-solid fa-check"></i><span>15 or more custom pages, as agreed in the project scope</span></li>
          <li><i class="fa-solid fa-check"></i><span>Eight city or service-area pages</span></li>
          <li><i class="fa-solid fa-check"></i><span>Custom brand identity, including logo and colors</span></li>
          <li><i class="fa-solid fa-check"></i><span>AI chatbot integration</span></li>
          <li><i class="fa-solid fa-check"></i><span>Team or caregiver profiles page</span></li>
          <li><i class="fa-solid fa-check"></i><span>FAQ page with appropriate structured data</span></li>
          <li><i class="fa-solid fa-check"></i><span>Priority support</span></li>
          <li><i class="fa-solid fa-check"></i><span>One strategy call per month</span></li>
          <li><i class="fa-solid fa-check"></i><span>Target launch up to 21 days</span></li>
        </ul>
        <button class="btn-secondary price-cta dark" onclick="openPopup()">Get a Dominate Quote</button>
      </div>
    </div>
    <p class="pricing-footnote">All packages are subject to a confirmed project scope. We will clarify any third-party subscription fees, ongoing service costs, and additional work before the project begins.</p>
  </div>
</section>

<?php include '../../includes/reviews-slider.php'; ?>

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
        <div class="faq-a"><div class="faq-a-inner"><?php if ($f[0] === "Can you help with SEO after the website launches?"): ?>Yes. Our <a href="/seo/home-care-seo/">Home Care SEO Services</a> are available for agencies that want continued support with local search visibility, website optimization, content, and other agreed SEO activities.<?php else: ?><?= htmlspecialchars($f[1]) ?><?php endif; ?></div></div>
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
        <h2 class="section-h2">Let's Build a Better<br><em>Website for Your Agency</em></h2>
        <p class="cta-desc">Your website should help families understand your services, build confidence in your agency, and take the next step toward contacting your team. Tell us about your agency, the services you provide, and the areas you serve. We'll review your needs and recommend a website package that fits your goals.</p>
        <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-laptop-code"></i>Get My Free Website Quote</button>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free quote &nbsp;·&nbsp; No obligation</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/team/team-member-cafe-portrait.jpg" alt="Homecare Creators team member discussing a home care agency's new website" title="Discussing a home care agency's new website">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Your Free Quote Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">A review of your current website, if you have one</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">A recommended package based on your needs</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">An initial review of relevant competitors</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Clear project pricing and scope</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>
