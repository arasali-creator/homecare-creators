<?php
$page_canonical = "https://homecarecreators.com/home-care-agency-marketing-north-carolina/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "Home Care Agency Marketing in North Carolina | Homecare Creators";
$page_desc = "SEO, websites & AI search marketing for home care agencies across North Carolina. Free growth audit.";
$og_title = "Home Care Agency Marketing in North Carolina | Homecare Creators";
$og_desc = "SEO, website design, local SEO, AI search optimization, and marketing automation for home care agencies across North Carolina.";

$page_css = <<<CSS
.container{max-width:1280px}
.section-h2{font-size:clamp(24px,3.2vw,42px)}

/* HERO */
.hero{background:var(--forest);position:relative;overflow:hidden;padding:150px 0 72px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-grid{position:relative;z-index:2;max-width:1280px;margin:0 auto;display:grid;grid-template-columns:1.05fr .95fr;gap:64px;align-items:center;padding:0 48px}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:24px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(26px,3.4vw,42px);line-height:1.15;color:#fff;margin-bottom:20px}
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

/* SHARED TEXT */
.lede{font-size:17px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.lede strong{color:var(--forest)}
.section-cta-btn{display:inline-flex;align-items:center;gap:8px;background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;padding:14px 26px;border-radius:10px;border:none;cursor:pointer;transition:.2s;margin-top:8px}
.section-cta-btn:hover{background:var(--forest);transform:translateY(-2px)}

/* INTRO */
.intro-section{background:#fff}
.intro-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:64px;align-items:center}
.intro-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/4.6;box-shadow:0 24px 70px rgba(10,46,30,.15)}
.intro-photo img{width:100%;height:100%;object-fit:cover;display:block}

/* SERVICES */
.services-section{background:var(--cream)}
.svc-stack{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:40px}
.svc-block{background:#fff;border:1px solid var(--border);border-radius:20px;padding:28px}
.svc-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;color:#fff;background:var(--forest);width:36px;height:36px;border-radius:10px;display:flex;align-items:center;justify-content:center;flex-shrink:0;margin-bottom:16px}
.svc-block-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:6px}
.svc-block-tagline{font-size:15px;font-weight:600;color:var(--teal);margin-bottom:12px}
.svc-block-desc{font-size:15.5px;line-height:1.75;color:var(--muted);margin-bottom:14px}
.svc-block-list{list-style:none;display:flex;flex-direction:column;gap:8px;margin-bottom:14px}
.svc-block-list li{display:flex;align-items:flex-start;gap:9px;font-size:14px;color:var(--text);line-height:1.5}
.svc-block-list li i{color:var(--teal);font-size:11px;margin-top:4px;flex-shrink:0}

/* METRO CARDS */
.market-section{background:#fff}
.metro-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin:36px 0}
.metro-card{background:var(--warm);border:1px solid var(--border);border-left:4px solid var(--teal);border-radius:14px;padding:24px}
.metro-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--forest);margin-bottom:8px}
.metro-card p{font-size:14.5px;line-height:1.7;color:var(--muted)}

/* CTA CARD */
.cta-section{background:#fff;padding:0 24px 72px}
.cta-card{position:relative;max-width:1100px;margin:0 auto;background:var(--forest);border-radius:36px;padding:64px 48px;text-align:center;overflow:hidden}
.cta-card::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.07) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.07) 1px,transparent 1px);background-size:50px 50px}
.cta-card-inner{position:relative;z-index:2;max-width:620px;margin:0 auto}
.cta-headline{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(21px,2.9vw,30px);line-height:1.25;color:#fff;margin-bottom:18px}
.cta-headline em{font-style:italic;color:var(--mint)}
.cta-sub{font-size:16px;line-height:1.7;color:rgba(255,255,255,.62);margin:0 auto 28px}
.cta-pill-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;color:var(--forest);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;padding:17px 32px;border-radius:100px;border:none;cursor:pointer;transition:.2s}
.cta-pill-btn:hover{transform:translateY(-2px);box-shadow:0 12px 32px rgba(0,0,0,.3)}

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
.faq-a-inner a{color:var(--teal);font-weight:600;text-decoration:none}

/* RESPONSIVE */
@media(max-width:1024px){
  .hero-grid{grid-template-columns:1fr;gap:40px;padding:0 32px}
  .intro-grid{grid-template-columns:1fr;gap:32px}
  .intro-photo{max-width:420px;margin:0 auto}
  .metro-grid{grid-template-columns:1fr}
  .svc-stack{grid-template-columns:1fr}
}
@media(max-width:640px){
  .hero{padding:120px 0 56px}
  .hero-grid{padding:0 24px}
  section{padding:64px 24px}
  .cta-card{padding:48px 24px;border-radius:26px}
}
CSS;
include '../includes/header.php';

$_bc = [
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://homecarecreators.com/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Areas We Serve","item"=>"https://homecarecreators.com/areas-we-serve/"],
    ["@type"=>"ListItem","position"=>3,"name"=>"North Carolina","item"=>$page_canonical],
];
echo '<script type="application/ld+json">' . json_encode(["@context"=>"https://schema.org","@type"=>"BreadcrumbList","itemListElement"=>$_bc], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"LocalBusiness",
    "name"=>"Homecare Creators",
    "description"=>$page_desc,
    "url"=>$page_canonical,
    "telephone"=>"+1-409-419-3533",
    "email"=>"info@homecarecreators.com",
    "areaServed"=>["@type"=>"State","name"=>"North Carolina"],
    "geo"=>["@type"=>"GeoCoordinates","latitude"=>"35.7596","longitude"=>"-79.0193"],
    "priceRange"=>"$$",
], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"FAQPage",
    "mainEntity"=>array_map(fn($q)=>["@type"=>"Question","name"=>$q[0],"acceptedAnswer"=>["@type"=>"Answer","text"=>$q[1]]], [
        ["What is home care agency marketing?", "Home care agency marketing combines strategies such as SEO, website design, local search optimization, useful content, reputation management, and lead follow-up to help an agency reach prospective clients and communicate its services."],
        ["How can SEO help my North Carolina home care agency?", "SEO can help your website become more visible for relevant searches, explain your services more clearly, and attract visitors looking for the care you provide. Results depend on your website, competition, service areas, and the work involved."],
        ["How long does home care SEO take to produce results?", "SEO is an ongoing process, and the timeline varies. Some improvements may be noticed sooner, while meaningful organic growth often requires several months of consistent work."],
        ["Do you help home care agencies improve Google Maps visibility?", "Yes. Local SEO may include Google Business Profile optimization, accurate business information, relevant local content, and review-process guidance. No agency can guarantee a particular Google Maps position."],
        ["Do I need a new website to improve my marketing?", "Not necessarily. In some cases, your existing website can be improved through technical fixes, better content, stronger calls to action, and SEO updates."],
        ["Can you help my agency appear in AI search results?", "We can improve the clarity and structure of your website content and business information to support discoverability across AI-powered search experiences. Inclusion and placement cannot be guaranteed."],
        ["Can you help an agency serving multiple North Carolina cities?", "Yes. We can plan content and local SEO around the communities your agency genuinely serves, with useful, specific information rather than duplicate content."],
        ["How much does home care agency marketing cost in North Carolina?", "Pricing depends on the services required, your current online presence, the number of markets you target, and the scope of ongoing work."],
        ["How do I get started with Homecare Creators?", "Start by requesting a free marketing audit. Share your website, service area, and main growth goals so we can identify potential opportunities."],
    ]),
], JSON_UNESCAPED_SLASHES) . "</script>\n";
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-grid">
    <div data-reveal>
      <div class="hero-badge"><i class="fa-solid fa-location-dot" style="margin-right:6px"></i>North Carolina Home Care Marketing</div>
      <h1 class="hero-h1">Home Care Agency Marketing <em>in North Carolina</em></h1>
      <p class="hero-desc">Families across North Carolina search online before choosing a home care provider. If your agency isn't visible when that happens, the inquiry goes to a competitor instead.</p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Get Your Free Marketing Audit</button>
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
        <img src="/images/team/team-member-cafe-portrait.jpg" alt="Homecare Creators marketing specialist smiling in a cafe setting" title="Homecare Creators — home care marketing specialists">
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

<!-- INTRO -->
<section class="intro-section">
  <div class="container intro-grid">
    <div data-reveal>
      <p class="section-label">Grow With a Smarter Strategy</p>
      <h2 class="section-h2">Grow Your Home Care Agency With a Smarter Digital Marketing Strategy</h2>
      <p class="lede">When families need help for an aging parent or a loved one, they turn to Google, compare local providers, read reviews, and visit websites before contacting an agency.</p>
      <p class="lede"><strong>Homecare Creators helps North Carolina home care agencies strengthen their online presence through home care SEO, website design, local SEO, AI search optimization, and marketing automation.</strong> Our goal is to help your agency become easier to discover, communicate your value clearly, and create a better path from an online search to a real inquiry.</p>
      <p class="lede">Whether you're launching a new agency or growing an established one, your marketing should reflect your services, your target market, and the communities you actually serve.</p>
      <button class="section-cta-btn" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Get Your Free Home Care Marketing Audit</button>
    </div>
    <div class="intro-photo" data-reveal style="transition-delay:.15s">
      <img src="/images/team/team-member-outdoor-market.jpg" alt="Homecare Creators team members discussing a North Carolina home care agency's marketing strategy" title="Reviewing a home care agency's growth strategy">
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="services-section" id="services">
  <div class="container">
    <div data-reveal style="max-width:720px">
      <p class="section-label">What We Do</p>
      <h2 class="section-h2">Digital Marketing Services for North Carolina Home Care Agencies</h2>
      <p class="lede">A successful strategy requires more than an attractive website or occasional social posts — your website, search visibility, local business information, and lead follow-up should work together.</p>
    </div>
    <div class="svc-stack">
      <div class="svc-block" data-reveal>
        <div class="svc-num">1</div>
        <div>
          <div class="svc-block-title">Home Care SEO in North Carolina</div>
          <div class="svc-block-tagline">Help more families discover your agency through organic search.</div>
          <p class="svc-block-desc">When families search for home care services, visibility can influence which agencies they consider. We focus on attracting people searching for services your agency actually provides, not traffic for its own sake.</p>
          <ul class="svc-block-list">
            <li><i class="fa-solid fa-check"></i>Keyword research based on your services and target locations</li>
            <li><i class="fa-solid fa-check"></i>On-page SEO for your homepage and core service pages</li>
            <li><i class="fa-solid fa-check"></i>Technical SEO, site structure, and performance improvements</li>
            <li><i class="fa-solid fa-check"></i>Local search optimization and Google Business Profile improvements</li>
          </ul>
          <button class="section-cta-btn" onclick="openPopup('audit')">Request Your Free SEO Audit</button>
        </div>
      </div>
      <div class="svc-block" data-reveal style="transition-delay:.05s">
        <div class="svc-num">2</div>
        <div>
          <div class="svc-block-title">Home Care Website Design</div>
          <div class="svc-block-tagline">Turn your website into a stronger first impression.</div>
          <p class="svc-block-desc">Your website is often the first place families visit when researching a provider. If it loads slowly or doesn't explain your services clearly, visitors leave without making contact.</p>
          <ul class="svc-block-list">
            <li><i class="fa-solid fa-check"></i>Mobile-friendly layouts for desktop, tablet, and smartphone</li>
            <li><i class="fa-solid fa-check"></i>Clear service pages and prominent calls to action</li>
            <li><i class="fa-solid fa-check"></i>SEO-friendly page structure and metadata</li>
            <li><i class="fa-solid fa-check"></i>Website speed and performance optimization</li>
          </ul>
          <button class="section-cta-btn" onclick="openPopup('audit')">Discuss Your Website With Our Team</button>
        </div>
      </div>
      <div class="svc-block" data-reveal style="transition-delay:.1s">
        <div class="svc-num">3</div>
        <div>
          <div class="svc-block-title">Local SEO and Google Maps Optimization</div>
          <div class="svc-block-tagline">Reach families searching in the communities you serve.</div>
          <p class="svc-block-desc">North Carolina has fast-growing metros like Charlotte and the Triangle alongside smaller communities with very different competitive conditions — a strategy that works in one market may not suit another.</p>
          <ul class="svc-block-list">
            <li><i class="fa-solid fa-check"></i>Google Business Profile optimization</li>
            <li><i class="fa-solid fa-check"></i>Accurate business name, address, phone, and service info</li>
            <li><i class="fa-solid fa-check"></i>Review-generation guidance and reputation improvements</li>
            <li><i class="fa-solid fa-check"></i>Local citation checks and consistency improvements</li>
          </ul>
          <button class="section-cta-btn" onclick="openPopup('audit')">Get Your Free Local Visibility Audit</button>
        </div>
      </div>
      <div class="svc-block" data-reveal style="transition-delay:.15s">
        <div class="svc-num">4</div>
        <div>
          <div class="svc-block-title">AI Search SEO (GEO)</div>
          <div class="svc-block-tagline">Prepare your agency for the changing search landscape.</div>
          <p class="svc-block-desc">People increasingly use AI-powered tools alongside traditional search. Clear, trustworthy information helps these systems understand what your agency does and where it operates.</p>
          <ul class="svc-block-list">
            <li><i class="fa-solid fa-check"></i>Clear, useful website content that answers relevant questions</li>
            <li><i class="fa-solid fa-check"></i>Consistent business and service information across sources</li>
            <li><i class="fa-solid fa-check"></i>Well-structured service pages and FAQs</li>
            <li><i class="fa-solid fa-check"></i>Appropriate structured data and technical SEO</li>
          </ul>
          <button class="section-cta-btn" onclick="openPopup('audit')">Request an AI Search Visibility Review</button>
        </div>
      </div>
      <div class="svc-block" data-reveal style="transition-delay:.2s">
        <div class="svc-num">5</div>
        <div>
          <div class="svc-block-title">AI and Marketing Automation</div>
          <div class="svc-block-tagline">Respond to inquiries consistently without extra manual work.</div>
          <p class="svc-block-desc">Generating an inquiry is only part of the process — if a prospective client doesn't get a timely response, the opportunity is lost. Automation helps your team follow up consistently.</p>
          <ul class="svc-block-list">
            <li><i class="fa-solid fa-check"></i>Automated notifications when a new inquiry arrives</li>
            <li><i class="fa-solid fa-check"></i>Follow-up email workflows and lead routing</li>
            <li><i class="fa-solid fa-check"></i>Appointment scheduling workflows</li>
            <li><i class="fa-solid fa-check"></i>Website chat and inquiry capture</li>
          </ul>
          <button class="section-cta-btn" onclick="openPopup('audit')">Discuss Automation for Your Agency</button>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- MARKET -->
<section class="market-section">
  <div class="container">
    <div data-reveal style="max-width:720px">
      <p class="section-label">Where We Work</p>
      <h2 class="section-h2">Home Care Marketing Across North Carolina</h2>
      <p class="lede">North Carolina is a diverse market, and your digital marketing strategy should reflect the locations and services that matter to your agency — not a copy-paste template.</p>
    </div>
    <div class="metro-grid" data-reveal style="transition-delay:.1s">
      <div class="metro-card">
        <h3>Charlotte</h3>
        <p>Charlotte and its surrounding suburbs cover a broad, fast-growing service area. Local SEO and useful service-area content help clarify where your agency operates and which communities you serve.</p>
      </div>
      <div class="metro-card">
        <h3>Raleigh &amp; the Triangle</h3>
        <p>Raleigh and the surrounding Triangle region blend established neighborhoods with rapidly expanding suburbs. A thoughtful strategy helps prioritize the services and locations that align with your capacity.</p>
      </div>
      <div class="metro-card">
        <h3>Greensboro</h3>
        <p>Agencies serving Greensboro and the Piedmont Triad benefit from a website that clearly explains their care offerings and service boundaries, with keyword research identifying which local searches matter most.</p>
      </div>
      <div class="metro-card">
        <h3>Durham</h3>
        <p>For agencies serving Durham and nearby communities, accurate business information, relevant service pages, and a consistent online presence support visibility among families researching care.</p>
      </div>
    </div>
    <p class="lede" data-reveal>We also help agencies serving other North Carolina locations, depending on their needs and target markets. Our approach is to create useful, locally relevant content based on the areas your agency genuinely serves — not simply swap a city name across dozens of similar pages.</p>
    <button class="section-cta-btn" onclick="openPopup('audit')" data-reveal>Find Marketing Opportunities in Your North Carolina Market</button>
  </div>
</section>

<!-- CASE STUDIES -->
<?php include '../includes/case-study-slider.php'; ?>

<!-- FAQ -->
<section class="faq">
  <div class="container">
    <div class="faq-header" data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Questions About Home Care<br><em>Marketing in North Carolina</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">What is home care agency marketing?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Home care agency marketing combines strategies such as SEO, website design, local search optimization, useful content, reputation management, and lead follow-up to help an agency reach prospective clients and communicate its services.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How can SEO help my North Carolina home care agency?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>SEO can help your website become more visible for relevant searches, explain your services more clearly, and attract visitors looking for the care you provide. Results depend on your website, competition, service areas, and the work involved. Read more about our <a href="/seo/home-care-seo/">Home Care SEO Services</a>.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How long does home care SEO take to produce results?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>SEO is an ongoing process, and the timeline varies. Some improvements may be noticed sooner, while meaningful organic growth often requires several months of consistent work. Competition, website condition, and local demand all influence progress.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you help home care agencies improve Google Maps visibility?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Yes. Local SEO may include Google Business Profile optimization, accurate business information, relevant local content, and review-process guidance. No agency can guarantee a particular Google Maps position.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do I need a new website to improve my marketing?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Not necessarily. In some cases, your existing website can be improved through technical fixes, better content, stronger calls to action, and SEO updates. A redesign may be appropriate when the current site has deeper usability or structural problems.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can you help my agency appear in AI search results?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>We can improve the clarity and structure of your website content and business information to support discoverability across AI-powered search experiences. AI platforms determine their own results, so inclusion and placement cannot be guaranteed.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can you help an agency serving multiple North Carolina cities?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Yes. We can plan content and local SEO around the communities your agency genuinely serves. Each location page should offer useful, specific information rather than duplicate the same content with only the city name changed.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How much does home care agency marketing cost in North Carolina?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Pricing depends on the services required, your current online presence, the number of markets you target, and the scope of ongoing work. We recommend reviewing your goals before deciding on a suitable scope.</p></div></div>
      </div>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How do I get started with Homecare Creators?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><p>Start by requesting a free marketing audit. Share your website, service area, and main growth goals so we can better understand your agency and identify potential opportunities.</p></div></div>
      </div>
    </div>
  </div>
</section>

<!-- FINAL CTA -->
<section class="cta-section">
  <div class="cta-card" data-reveal>
    <div class="cta-card-inner">
      <h2 class="cta-headline">Ready to Grow Your <em>North Carolina</em> Home Care Agency?</h2>
      <p class="cta-sub">Your agency deserves a marketing strategy built around its services, target market, and goals — not a generic plan copied from another industry.</p>
      <button class="cta-pill-btn" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Get Your Free Home Care Marketing Audit</button>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
