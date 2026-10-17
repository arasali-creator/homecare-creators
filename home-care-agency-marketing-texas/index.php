<?php
$page_canonical = "https://homecarecreators.com/home-care-agency-marketing-texas/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "Home Care Agency Marketing in Texas | Homecare Creators";
$page_desc = "SEO, websites & AI search marketing for home care agencies across Texas. Free growth audit.";
$og_title = "Home Care Agency Marketing in Texas | Homecare Creators";
$og_desc = "SEO, website design, and AI search visibility for home care agencies across Texas — from Houston to El Paso.";

$page_css = <<<CSS
/* HERO */
.hero{background:var(--forest);position:relative;overflow:hidden;padding:150px 0 72px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-grid{position:relative;z-index:2;max-width:1280px;margin:0 auto;display:grid;grid-template-columns:1.05fr .95fr;gap:64px;align-items:center;padding:0 48px}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:24px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(34px,4.4vw,54px);line-height:1.12;color:#fff;margin-bottom:20px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:17.5px;line-height:1.75;color:rgba(255,255,255,.62);max-width:480px;margin-bottom:32px}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:36px}
.hero-proof{display:flex;gap:28px;flex-wrap:wrap}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-photo-wrap{position:relative}
.hero-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/4.4;position:relative;box-shadow:0 30px 80px rgba(0,0,0,.4)}
.hero-photo img{width:100%;height:100%;object-fit:cover;display:block}
.hero-photo::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 55%,rgba(5,25,14,.6) 100%)}
.hero-photo-badge{position:absolute;bottom:-20px;left:-20px;z-index:3;background:#fff;border-radius:16px;padding:16px 20px;box-shadow:0 20px 50px rgba(10,46,30,.25);display:flex;align-items:center;gap:12px}
.hero-photo-badge-icon{width:40px;height:40px;border-radius:11px;background:rgba(29,158,117,.1);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0}
.hero-photo-badge-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;color:var(--forest);line-height:1.15}
.hero-photo-badge-label{font-size:11px;color:var(--muted);font-weight:600;font-family:'Plus Jakarta Sans',sans-serif}

/* CERTIFICATIONS */
.certs{background:#fff;padding:52px 40px;border-bottom:1px solid var(--border)}
.certs-label{text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--muted);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:28px}
.certs-row{display:flex;justify-content:center;align-items:center;gap:48px;flex-wrap:wrap}
.cert-item{display:flex;flex-direction:column;align-items:center;gap:10px;opacity:.85;transition:.3s}
.cert-item:hover{opacity:1;transform:translateY(-3px)}
.cert-item img{height:56px;width:auto;max-width:120px;object-fit:contain;filter:grayscale(15%)}
.cert-item span{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:600;color:var(--muted);text-align:center}

/* SERVICES LIST */
.services-section{background:var(--cream)}
.services-list{display:grid;grid-template-columns:repeat(2,1fr);gap:16px;margin-top:40px}
.svc-row{background:#fff;border:1px solid var(--border);border-radius:16px;padding:22px 24px;display:flex;gap:16px;align-items:flex-start;transition:.2s}
.svc-row:hover{border-color:rgba(29,158,117,.3);box-shadow:0 8px 28px rgba(10,46,30,.06)}
.svc-row-icon{width:42px;height:42px;border-radius:11px;background:rgba(29,158,117,.1);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0}
.svc-row-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--forest);margin-bottom:4px}
.svc-row-desc{font-size:14px;color:var(--muted);line-height:1.6}

/* CTA */
.cta-section{background:#fff;padding:64px 24px}
.cta-card{position:relative;max-width:1100px;margin:0 auto;background:var(--forest);border-radius:36px;padding:64px 48px;text-align:center;overflow:hidden}
.cta-card::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.07) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.07) 1px,transparent 1px);background-size:50px 50px}
.cta-card-inner{position:relative;z-index:2;max-width:620px;margin:0 auto}
.cta-headline{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(26px,3.6vw,38px);line-height:1.2;color:#fff;margin-bottom:18px}
.cta-headline em{font-style:italic;color:var(--mint)}
.cta-sub{font-size:16px;line-height:1.7;color:rgba(255,255,255,.62);margin:0 auto 28px}
.cta-pill-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;color:var(--forest);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;padding:17px 32px;border-radius:100px;border:none;cursor:pointer;transition:.2s}
.cta-pill-btn:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(0,0,0,.3)}

/* REVIEWS */
.reviews{background:var(--forest);overflow:hidden;position:relative}
.reviews::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px}
.reviews .container{position:relative;z-index:1}
.reviews-header{text-align:center;margin-bottom:44px}
.reviews-header .section-label{justify-content:center;color:var(--mint)}
.reviews-header .section-label::before{background:var(--mint)}
.reviews-header .section-h2{color:#fff}
.reviews-header .section-h2 em{color:var(--mint)}
.review-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:24px;max-width:860px;margin:0 auto}
.review-card{background:var(--cream);border:1px solid var(--border);border-radius:22px;padding:32px;position:relative;overflow:hidden}
.review-card::before{content:'\201C';position:absolute;top:-12px;right:20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:110px;color:rgba(29,158,117,.08);line-height:1}
.review-stars{color:var(--gold);font-size:14px;margin-bottom:14px;letter-spacing:2px}
.review-quote{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;line-height:1.6;color:var(--forest);font-style:italic;margin-bottom:20px}
.review-author{display:flex;align-items:center;gap:12px}
.review-avatar{width:42px;height:42px;border-radius:50%;background:var(--teal);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;flex-shrink:0}
.review-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--forest)}
.review-role{font-size:11.5px;color:var(--muted);margin-top:2px}

/* FAQ */
.faq{background:#fff}
.faq-header{text-align:center;margin-bottom:48px}
.faq-header .section-label{justify-content:center}
.faq-list{max-width:820px;margin:0 auto;display:flex;flex-direction:column;gap:12px}
.faq-item{background:var(--warm);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:border-color .3s}
.faq-item:hover{border-color:rgba(29,158,117,.3)}
.faq-q{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:20px 24px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;color:var(--forest)}
.faq-q-icon{width:28px;height:28px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;transition:transform .3s,background .3s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal)}
.faq-a{max-height:0;overflow:hidden;transition:max-height .4s ease}
.faq-item.open .faq-a{max-height:400px}
.faq-a-inner{padding:0 24px 20px;font-size:15px;line-height:1.75;color:var(--muted);border-top:1px solid var(--border)}
.faq-a-inner p{padding-top:16px}

/* CITIES + MAP */
.cities-section{background:var(--cream)}
.cities-grid{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:start}
.cities-list{display:grid;grid-template-columns:repeat(2,1fr);gap:10px 20px;margin-top:28px}
.cities-list span{display:flex;align-items:center;gap:9px;font-size:14.5px;color:var(--forest);padding:8px 0}
.cities-list span i{color:var(--teal);font-size:11px;flex-shrink:0}
.cities-map{border-radius:20px;overflow:hidden;border:1px solid var(--border);box-shadow:0 16px 56px rgba(10,46,30,.1);aspect-ratio:1/1}
.cities-map iframe{width:100%;height:100%;display:block;border:0}

/* RESPONSIVE */
@media(max-width:1024px){
  .hero-grid{grid-template-columns:1fr;gap:40px;padding:0 32px}
  .services-list{grid-template-columns:1fr}
  .review-grid{grid-template-columns:1fr}
  .cities-grid{grid-template-columns:1fr;gap:32px}
  .cities-map{aspect-ratio:16/9}
}
@media(max-width:640px){
  .hero{padding:120px 0 56px}
  .hero-grid{padding:0 24px}
  section{padding:64px 24px}
  .cta-card{padding:48px 24px;border-radius:26px}
  .cities-list{grid-template-columns:1fr}
}
CSS;
include '../includes/header.php';

$_bc = [
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://homecarecreators.com/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Areas We Serve","item"=>"https://homecarecreators.com/areas-we-serve/"],
    ["@type"=>"ListItem","position"=>3,"name"=>"Texas","item"=>$page_canonical],
];
echo '<script type="application/ld+json">' . json_encode(["@context"=>"https://schema.org","@type"=>"BreadcrumbList","itemListElement"=>$_bc], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"LocalBusiness",
    "name"=>"Homecare Creators",
    "description"=>$page_desc,
    "url"=>$page_canonical,
    "telephone"=>"+1-409-419-3533",
    "email"=>"info@homecarecreators.com",
    "areaServed"=>["@type"=>"State","name"=>"Texas"],
    "geo"=>["@type"=>"GeoCoordinates","latitude"=>"31.9686","longitude"=>"-99.9018"],
    "priceRange"=>"$$",
], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"FAQPage",
    "mainEntity"=>array_map(fn($q)=>["@type"=>"Question","name"=>$q[0],"acceptedAnswer"=>["@type"=>"Answer","text"=>$q[1]]], [
        ["Do you work with home care agencies throughout Texas?", "Yes. We work with home care agencies across Texas, from major metros like Houston, Dallas, San Antonio, and Austin to smaller markets throughout the state."],
        ["How is marketing for a Texas home care agency different?", "Texas is a large, fast-growing state with a mix of dense urban metros and sprawling suburbs, so local SEO has to account for wide service areas and heavy competition from national franchises. We build strategy around your specific Texas market, not a generic template."],
        ["What services are included for Texas home care agencies?", "Local SEO, Google Business Profile optimization, website design, AI search visibility, and AI-powered follow-up automation — the same specialist services we provide nationwide, tailored to your Texas market."],
        ["How much does home care marketing cost in Texas?", "Plans typically range from $800 to $3,000 per month depending on how many Texas markets you target and which services are included. Book a free audit and we'll give you exact numbers for your agency."],
        ["Do you require a long-term contract?", "No. Every plan goes month-to-month after a 90-day ramp-up period, and every engagement is backed by a 30-day satisfaction guarantee."],
    ]),
], JSON_UNESCAPED_SLASHES) . "</script>\n";
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-grid">
    <div data-reveal>
      <div class="hero-badge"><i class="fa-solid fa-location-dot" style="margin-right:6px"></i>Texas Home Care Marketing</div>
      <h1 class="hero-h1">Home Care Agency Marketing<br><em>in Texas</em></h1>
      <p class="hero-desc">SEO, website design, and AI search visibility built exclusively for home care agencies across Texas — from Houston and Dallas to Austin, San Antonio, and beyond.</p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Book Free Growth Audit</button>
        <a href="#services" class="btn-secondary"><i class="fa-solid fa-play"></i>See Our Services</a>
      </div>
      <div class="hero-proof">
        <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Homecare-Only Focus</div></div>
        <div class="hero-proof-item"><div class="hero-proof-num">SEO</div><div class="hero-proof-label">+ AI Search Visibility</div></div>
        <div class="hero-proof-item"><div class="hero-proof-num">30-Day</div><div class="hero-proof-label">Satisfaction Guarantee</div></div>
      </div>
    </div>
    <div class="hero-photo-wrap" data-reveal style="transition-delay:.15s">
      <div class="hero-photo">
        <img src="/images/home/hero-nurse-senior.jpg" alt="Home care nurse providing in-home senior care for a Texas home care agency" title="Home care marketing for Texas agencies">
      </div>
      <div class="hero-photo-badge">
        <div class="hero-photo-badge-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <div>
          <div class="hero-photo-badge-num">30-Day</div>
          <div class="hero-photo-badge-label">Satisfaction Guarantee</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CERTIFICATIONS -->
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

<!-- SERVICES -->
<section class="services-section" id="services">
  <div class="container">
    <div data-reveal style="text-align:center;max-width:620px;margin:0 auto">
      <p class="section-label" style="justify-content:center">What We Do</p>
      <h2 class="section-h2" style="text-align:center">Marketing Built for <em>Texas</em> Home Care Agencies</h2>
    </div>
    <div class="services-list">
      <div class="svc-row" data-reveal>
        <div class="svc-row-icon"><i class="fa-solid fa-magnifying-glass"></i></div>
        <div><div class="svc-row-title">Home Care SEO</div><div class="svc-row-desc">Rank higher on Google and Google Maps in your Texas market.</div></div>
      </div>
      <div class="svc-row" data-reveal style="transition-delay:.05s">
        <div class="svc-row-icon"><i class="fa-solid fa-display"></i></div>
        <div><div class="svc-row-title">Website Design</div><div class="svc-row-desc">Fast, mobile-first websites that turn Texas visitors into inquiries.</div></div>
      </div>
      <div class="svc-row" data-reveal style="transition-delay:.1s">
        <div class="svc-row-icon"><i class="fa-solid fa-location-dot"></i></div>
        <div><div class="svc-row-title">Local SEO</div><div class="svc-row-desc">Google Business Profile optimization for the cities and counties you serve.</div></div>
      </div>
      <div class="svc-row" data-reveal style="transition-delay:.15s">
        <div class="svc-row-icon"><i class="fa-solid fa-brain"></i></div>
        <div><div class="svc-row-title">AI Search SEO (GEO)</div><div class="svc-row-desc">Get found in ChatGPT, Google AI Overviews, and beyond.</div></div>
      </div>
      <div class="svc-row" data-reveal style="transition-delay:.2s">
        <div class="svc-row-icon"><i class="fa-solid fa-gears"></i></div>
        <div><div class="svc-row-title">AI &amp; Automation</div><div class="svc-row-desc">Automated follow-ups and scheduling, so no lead slips through.</div></div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="cta-card" data-reveal>
    <div class="cta-card-inner">
      <h2 class="cta-headline">Ready to Grow Your <em>Texas</em> Home Care Agency?</h2>
      <p class="cta-sub">Book a free 30-minute growth audit and we'll show you exactly what's holding your agency back in your market. No obligation.</p>
      <button class="cta-pill-btn" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Book a Free Growth Audit</button>
    </div>
  </div>
</section>

<!-- CASE STUDIES -->
<?php include '../includes/case-study-slider.php'; ?>

<!-- REVIEWS -->
<section class="reviews" id="reviews">
  <div class="container">
    <div class="reviews-header" data-reveal>
      <p class="section-label">What Owners Say</p>
      <h2 class="section-h2">Texas Agencies<br><em>Love the Results</em></h2>
    </div>
    <div class="review-grid" data-reveal style="transition-delay:.1s">
      <div class="review-card">
        <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="review-quote">"Their AI Search SEO is unlike anything I've seen from a marketing agency. We show up now when families search on ChatGPT and Google AI, and I don't think our competitors even know this is possible yet."</p>
        <div class="review-author">
          <div class="review-avatar">LD</div>
          <div><div class="review-name">Linda D.</div><div class="review-role">CEO, Caring Hands Agency &middot; Houston, TX</div></div>
        </div>
      </div>
      <div class="review-card">
        <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p class="review-quote">"The follow-up automation alone paid for the retainer. Leads used to sit for days, now they get a response in minutes, day or night."</p>
        <div class="review-author">
          <div class="review-avatar">RB</div>
          <div><div class="review-name">Robert B.</div><div class="review-role">CEO, Premier Home Health &middot; Dallas, TX</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq">
  <div class="container">
    <div class="faq-header" data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Texas Home Care<br><em>Marketing Questions</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you work with home care agencies throughout Texas?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Yes. We work with home care agencies across Texas, from major metros like Houston, Dallas, San Antonio, and Austin to smaller markets throughout the state.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How is marketing for a Texas home care agency different?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Texas is a large, fast-growing state with a mix of dense urban metros and sprawling suburbs, so local SEO has to account for wide service areas and heavy competition from national franchises. We build strategy around your specific Texas market, not a generic template.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">What services are included for Texas home care agencies?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Local SEO, Google Business Profile optimization, website design, AI search visibility, and AI-powered follow-up automation — the same specialist services we provide nationwide, tailored to your Texas market.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How much does home care marketing cost in Texas?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Plans typically range from $800 to $3,000 per month depending on how many Texas markets you target and which services are included. Book a free audit and we'll give you exact numbers for your agency.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you require a long-term contract?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>No. Every plan goes month-to-month after a 90-day ramp-up period, and every engagement is backed by a 30-day satisfaction guarantee.</p></div></div>
      </div>
    </div>
  </div>
</section>

<!-- CITIES + MAP -->
<section class="cities-section">
  <div class="container">
    <div class="cities-grid">
      <div data-reveal>
        <p class="section-label">Where We Work</p>
        <h2 class="section-h2">Texas Cities <em>We Serve</em></h2>
        <p class="section-sub">We work with home care agencies across Texas — here are some of the markets we support most often.</p>
        <div class="cities-list">
          <span><i class="fa-solid fa-location-dot"></i>Houston</span>
          <span><i class="fa-solid fa-location-dot"></i>San Antonio</span>
          <span><i class="fa-solid fa-location-dot"></i>Dallas</span>
          <span><i class="fa-solid fa-location-dot"></i>Austin</span>
          <span><i class="fa-solid fa-location-dot"></i>Fort Worth</span>
          <span><i class="fa-solid fa-location-dot"></i>El Paso</span>
          <span><i class="fa-solid fa-location-dot"></i>Arlington</span>
          <span><i class="fa-solid fa-location-dot"></i>Corpus Christi</span>
          <span><i class="fa-solid fa-location-dot"></i>Plano</span>
          <span><i class="fa-solid fa-location-dot"></i>Laredo</span>
          <span><i class="fa-solid fa-location-dot"></i>Lubbock</span>
          <span><i class="fa-solid fa-location-dot"></i>Garland</span>
          <span><i class="fa-solid fa-location-dot"></i>Irving</span>
          <span><i class="fa-solid fa-location-dot"></i>Amarillo</span>
          <span><i class="fa-solid fa-location-dot"></i>Grand Prairie</span>
          <span><i class="fa-solid fa-location-dot"></i>McKinney</span>
          <span><i class="fa-solid fa-location-dot"></i>Frisco</span>
          <span><i class="fa-solid fa-location-dot"></i>Brownsville</span>
          <span><i class="fa-solid fa-location-dot"></i>Pasadena</span>
          <span><i class="fa-solid fa-location-dot"></i>Mesquite</span>
        </div>
      </div>
      <div class="cities-map" data-reveal style="transition-delay:.15s">
        <iframe src="https://www.google.com/maps?q=Texas&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map of Texas service area"></iframe>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
