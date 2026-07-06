<?php
$page_title = "Home Care Marketing Case Studies | Real SEO & Lead Generation Results";
$page_desc = "Explore real home care marketing case studies showcasing SEO growth, website performance, local SEO success, and lead generation results from campaigns managed by HomeCareCreators.";
$page_canonical = "https://homecarecreators.com/case-studies/";
$og_title = "Home Care Marketing Case Studies | HomeCareCreators";
$og_desc = "Real campaigns, real numbers. See the SEO, local search, and lead generation results HomeCareCreators has delivered for home care agencies.";
$og_image = "https://homecarecreators.com/images/case-studies/case-study-01-florida-home-care.png";
$page_css = <<<CSS
/* HERO */
.hero{min-height:70vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 80px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 80% 80% at 50% 30%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-250px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-inner{position:relative;z-index:2;max-width:820px;margin:0 auto;text-align:center}
.hero-breadcrumb{font-family:'Syne',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb a:hover{color:rgba(255,255,255,.7)}
.hero-breadcrumb span{color:var(--teal-lt)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Syne',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:28px}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Instrument Serif',serif;font-size:clamp(36px,5vw,62px);line-height:1.06;color:#fff;margin-bottom:14px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-tagline{font-family:'Instrument Serif',serif;font-size:clamp(17px,2vw,23px);color:rgba(255,255,255,.5);margin-bottom:22px}
.hero-desc{font-size:16px;line-height:1.8;color:rgba(255,255,255,.62);max-width:640px;margin:0 auto 36px}
.hero-actions{display:flex;gap:14px;justify-content:center;flex-wrap:wrap}

/* PRIVACY NOTE */
.privacy-section{background:var(--cream);padding:44px 40px}
.privacy-box{max-width:900px;margin:0 auto;display:flex;gap:20px;align-items:flex-start;background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:28px 32px}
.privacy-icon{width:46px;height:46px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.privacy-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15.5px;color:var(--forest);margin-bottom:6px}
.privacy-text{font-size:13.5px;line-height:1.7;color:var(--muted)}

/* CASE STUDY CARDS */
.cs-section{background:#fff}
.cs-grid{display:grid;grid-template-columns:1fr 1fr;gap:32px;margin-top:44px}
.cs-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;display:flex;flex-direction:column;transition:.3s}
.cs-card:hover{box-shadow:0 20px 56px rgba(10,46,30,.12);transform:translateY(-4px)}
.cs-media img{width:100%;display:block;border-bottom:1px solid var(--border)}
.cs-card-body{padding:28px 28px 32px}
.cs-badge{display:inline-flex;align-items:center;gap:8px;font-family:'Syne',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--teal);background:rgba(29,158,117,.1);padding:6px 14px;border-radius:100px;margin-bottom:16px}
.cs-title{font-family:'Syne',sans-serif;font-size:20px;font-weight:700;color:var(--forest);margin-bottom:18px}
.cs-title span{color:var(--muted);font-weight:500}
.cs-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:8px;margin-top:20px}
.cs-label:first-of-type{margin-top:0}
.cs-challenge{font-size:14px;line-height:1.75;color:var(--muted)}
.cs-chip-row{display:flex;flex-wrap:wrap;gap:8px}
.cs-chip{font-family:'Syne',sans-serif;font-size:11.5px;font-weight:600;color:var(--forest);background:var(--warm);border:1px solid var(--border);padding:6px 13px;border-radius:100px}
.cs-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:22px}
.cs-stat{background:var(--warm);border:1px solid var(--border);border-radius:12px;padding:12px 8px;text-align:center}
.cs-stat-num{font-family:'Instrument Serif',serif;font-size:22px;color:var(--teal);line-height:1}
.cs-stat-label{font-size:10px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600;margin-top:4px}

/* MEANING / WHY SECTIONS */
.meaning-section{background:var(--cream)}
.meaning-inner{max-width:820px;margin:0 auto;text-align:center}
.meaning-inner .section-label{justify-content:center}
.meaning-inner .section-h2{text-align:center}
.meaning-inner p{font-size:15.5px;line-height:1.8;color:var(--muted);margin-top:16px}
.meaning-inner p a{color:var(--teal);font-weight:600;text-decoration:none}
.meaning-inner p a:hover{text-decoration:underline}

.why-section{background:#fff}
.why-grid{display:grid;grid-template-columns:1fr 1fr;gap:64px;align-items:center}
.why-body p{font-size:15.5px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.why-body a{color:var(--teal);font-weight:600;text-decoration:none}
.why-stat-card{background:var(--forest);border-radius:var(--r-lg);padding:40px;color:#fff}
.why-stat-grid{display:grid;grid-template-columns:1fr 1fr;gap:20px 24px}
.why-stat-item{display:flex;flex-direction:column;gap:4px}
.why-stat-item-num{font-family:'Instrument Serif',serif;font-size:36px;color:var(--teal-lt);line-height:1}
.why-stat-item-label{font-size:11.5px;color:rgba(255,255,255,.5);font-family:'Syne',sans-serif;font-weight:600}

/* SERVICES GRID */
.services-section{background:var(--cream)}
.svc-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-top:44px}
.svc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:22px 18px;text-decoration:none;display:block;transition:.25s}
.svc-card:hover{border-color:rgba(29,158,117,.3);box-shadow:0 10px 28px rgba(10,46,30,.09);transform:translateY(-3px)}
.svc-card-icon{width:40px;height:40px;border-radius:11px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:14px}
.svc-card h3{font-family:'Syne',sans-serif;font-size:13.5px;font-weight:700;color:var(--forest);margin-bottom:6px}
.svc-card p{font-size:12px;color:var(--muted);line-height:1.55}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:96px 40px;text-align:center}
.cta-inner{max-width:680px;margin:0 auto}
.cta-inner .section-label{justify-content:center;color:var(--teal-lt)}
.cta-inner .section-label::before{background:var(--teal-lt)}
.cta-inner .section-h2{color:#fff;text-align:center}
.cta-desc{font-size:15.5px;color:rgba(255,255,255,.68);line-height:1.78;margin:16px 0 32px}

/* RESPONSIVE */
@media(max-width:900px){.cs-grid{grid-template-columns:1fr}}
@media(max-width:1024px){.why-grid{grid-template-columns:1fr;gap:40px}.svc-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:640px){section{padding:56px 20px}.cs-stats{grid-template-columns:1fr 1fr}.svc-grid{grid-template-columns:1fr 1fr}.privacy-box{flex-direction:column}}
CSS;
include '../includes/header.php';

$case_studies = [
    [
        'num' => '01', 'name' => 'Home Care Agency', 'region' => 'Florida',
        'img' => 'case-study-01-florida-home-care.png',
        'challenge' => "This established home care agency wanted to reduce its dependence on referrals and generate more qualified inquiries through Google Search and Google Maps.",
        'strategy' => ['Home Care SEO', 'Local SEO', 'Google Business Profile Optimization', 'Website Conversion Optimization'],
        'stats' => [['235', 'Qualified Leads'], ['231', 'Phone Calls'], ['100', 'Qualified Opportunities'], ['$51.68K', 'Total Quote Value'], ['$28.30K', 'Sales Generated']],
    ],
    [
        'num' => '02', 'name' => 'Senior Care Provider', 'region' => 'Southeastern United States',
        'img' => 'case-study-02-southeastern-senior-care.png',
        'challenge' => "The agency wanted consistent inbound leads from families searching for senior care services while improving its local search visibility.",
        'strategy' => ['Local SEO', 'Technical SEO', 'Google Business Profile', 'Content Optimization'],
        'stats' => [['181', 'Leads'], ['175', 'Phone Calls'], ['132', 'Qualified Opportunities'], ['$85.56K', 'Quote Value'], ['$39.94K', 'Sales Generated']],
    ],
    [
        'num' => '03', 'name' => 'Home Care Provider', 'region' => 'Texas',
        'img' => 'case-study-03-texas-home-care.png',
        'challenge' => "Although the agency had a strong reputation, it wasn't attracting enough inquiries through organic search.",
        'strategy' => ['Home Care SEO', 'Website Optimization', 'Local SEO', 'Content Strategy'],
        'stats' => [['101', 'Leads'], ['98', 'Phone Calls'], ['84', 'Qualified Opportunities'], ['$7.74K', 'Quote Value'], ['$4.57K', 'Sales Generated']],
    ],
    [
        'num' => '04', 'name' => 'Private Duty Home Care Agency', 'region' => '',
        'img' => 'case-study-04-private-duty.png',
        'challenge' => "The agency wanted to increase qualified inquiries while improving its visibility in a competitive local market.",
        'strategy' => ['Local SEO', 'Google Business Profile Optimization', 'Conversion Optimization', 'Technical SEO'],
        'stats' => [['49', 'Leads'], ['47', 'Phone Calls'], ['39', 'Qualified Opportunities'], ['$22.44K', 'Quote Value'], ['$12.54K', 'Sales Generated']],
    ],
    [
        'num' => '05', 'name' => 'Home Health Agency', 'region' => '',
        'img' => 'case-study-05-home-health.png',
        'challenge' => "The agency wanted more consistent organic leads without relying heavily on paid advertising.",
        'strategy' => ['Home Health SEO', 'Local SEO', 'Website Optimization', 'Google Business Profile'],
        'stats' => [['47', 'Leads'], ['46', 'Phone Calls'], ['39', 'Qualified Opportunities'], ['$24.37K', 'Quote Value'], ['$12.73K', 'Sales Generated']],
    ],
    [
        'num' => '06', 'name' => 'Local Home Care Startup', 'region' => '',
        'img' => 'case-study-06-startup.png',
        'challenge' => "As a newer agency, the goal was to establish local visibility quickly and generate qualified inquiries from nearby families.",
        'strategy' => ['Local SEO', 'Google Business Profile', 'Website SEO', 'Content Optimization'],
        'stats' => [['37', 'Leads'], ['34', 'Phone Calls'], ['3', 'Website Form Leads'], ['$1.79K', 'Quote Value']],
    ],
];

$_faqs = [
    ["Are these real results?", "Yes. Every metric shown on this page comes from real campaigns managed by HomeCareCreators. To protect our clients' privacy, identifying details have been removed or generalized."],
    ["Can you guarantee the same results?", "No. Every agency operates in a different market with different levels of competition. While we can't guarantee identical outcomes, we build every strategy around proven SEO, local marketing, and conversion best practices."],
    ["How long does it take to see SEO results?", "Most agencies begin seeing measurable improvements within three to six months, although timelines vary depending on competition, website health, and existing online visibility."],
    ["Do you only work with home care agencies?", "Yes. We specialize in marketing for home care, senior care, and home health agencies. This industry-focused approach allows us to build strategies that reflect how families search for and choose care providers."],
];

$_bc = [
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://homecarecreators.com/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Case Studies","item"=>$page_canonical],
];
echo '<script type="application/ld+json">' . json_encode(["@context"=>"https://schema.org","@type"=>"BreadcrumbList","itemListElement"=>$_bc], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"CollectionPage",
    "name"=>"Home Care Marketing Case Studies",
    "description"=>$page_desc,
    "url"=>$page_canonical,
    "hasPart"=>array_map(function($c){
        return ["@type"=>"CreativeWork","name"=>$c['name'].($c['region'] ? ' — '.$c['region'] : ''),"about"=>"Home care marketing campaign results"];
    }, $case_studies),
], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"WebPage",
    "name"=>$page_title,
    "description"=>$page_desc,
    "url"=>$page_canonical,
    "speakable"=>["@type"=>"SpeakableSpecification","cssSelector"=>[".hero-h1",".cs-title",".cs-challenge"]],
], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"FAQPage",
    "mainEntity"=>array_map(function($f){ return ["@type"=>"Question","name"=>$f[0],"acceptedAnswer"=>["@type"=>"Answer","text"=>$f[1]]]; }, $_faqs),
], JSON_UNESCAPED_SLASHES) . "</script>\n";
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-blob1"></div>
  <div class="hero-inner">
    <div class="hero-breadcrumb"><a href="/">Home</a> / <span>Case Studies</span></div>
    <div class="hero-badge"><div class="hero-badge-pulse"></div>Home Care Marketing Case Studies</div>
    <h1 class="hero-h1">Real Growth. Real Campaigns.<br><em>Real Results.</em></h1>
    <div class="hero-tagline">Home Care Marketing Case Studies</div>
    <p class="hero-desc">Growing a home care agency takes more than a great website or ranking higher on Google. It requires a marketing strategy that helps families find your agency, builds trust, and turns website visitors into qualified inquiries. At HomeCareCreators, we specialize in helping home care agencies grow through Home Care SEO, Local SEO, Website Design, AI Search Optimization (GEO), and AI Automation. Below are examples of real campaign results we've achieved for home care agencies across the United States.</p>
    <div class="hero-actions">
      <a href="/#services" class="btn-primary"><i class="fa-solid fa-layer-group"></i>View Our Services</a>
      <button class="btn-secondary" onclick="openPopup()"><i class="fa-solid fa-calendar-check"></i>Book a Strategy Call</button>
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

<!-- PRIVACY NOTE -->
<section class="privacy-section">
  <div class="container">
    <div class="privacy-box" data-reveal>
      <div class="privacy-icon"><i class="fa-solid fa-shield-halved"></i></div>
      <div>
        <div class="privacy-title">Respecting Our Clients' Privacy</div>
        <div class="privacy-text">Every result featured on this page comes from a real campaign we've managed. To respect our clients' privacy and maintain confidentiality, we've removed or generalized names, locations, and other identifying details. While some information has been anonymized, the results and performance metrics are genuine and reflect the work we've delivered for home care agencies.</div>
      </div>
    </div>
  </div>
</section>

<!-- CASE STUDIES -->
<section class="cs-section">
  <div class="container">
    <div style="text-align:center;margin-bottom:8px" data-reveal>
      <p class="section-label" style="justify-content:center">Real Results From Real Campaigns</p>
      <h2 class="section-h2" style="text-align:center">Whether the Goal Is Leads,<br><em>Visibility, or Growth</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">Our approach is always built around measurable business growth — not vanity metrics.</p>
    </div>
    <div class="cs-grid">
      <?php foreach ($case_studies as $c): ?>
      <div class="cs-card" data-reveal>
        <div class="cs-media">
          <img src="/images/case-studies/<?= htmlspecialchars($c['img']) ?>" alt="<?= htmlspecialchars($c['name'].' lead generation dashboard showing '.$c['stats'][0][0].' '.$c['stats'][0][1]) ?>" title="<?= htmlspecialchars($c['name'].' campaign results') ?>" loading="lazy">
        </div>
        <div class="cs-card-body">
          <div class="cs-badge">Case Study <?= htmlspecialchars($c['num']) ?></div>
          <h3 class="cs-title"><?= htmlspecialchars($c['name']) ?><?= $c['region'] ? ' <span>| '.htmlspecialchars($c['region']).'</span>' : '' ?></h3>
          <div class="cs-label">The Challenge</div>
          <p class="cs-challenge"><?= htmlspecialchars($c['challenge']) ?></p>
          <div class="cs-label">Our Strategy</div>
          <div class="cs-chip-row">
            <?php foreach ($c['strategy'] as $s): ?><span class="cs-chip"><?= htmlspecialchars($s) ?></span><?php endforeach; ?>
          </div>
          <div class="cs-label">Campaign Results</div>
          <div class="cs-stats">
            <?php foreach ($c['stats'] as $s): ?>
            <div class="cs-stat"><div class="cs-stat-num"><?= htmlspecialchars($s[0]) ?></div><div class="cs-stat-label"><?= htmlspecialchars($s[1]) ?></div></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- WHAT THESE RESULTS MEAN -->
<section class="meaning-section">
  <div class="container meaning-inner" data-reveal>
    <p class="section-label">What These Results Mean</p>
    <h2 class="section-h2">No One-Size-Fits-All<br><em>Marketing Here</em></h2>
    <p>Every home care agency is different. Some focus on private-pay clients, while others serve multiple locations or compete in highly competitive markets. That's why we don't believe in one-size-fits-all marketing.</p>
    <p>Instead, we build customized strategies based on your agency's goals, local competition, and the way families search for care. Whether we're improving your <a href="/web-design/homecare-website-design/">website</a>, strengthening your <a href="/seo/local-seo-for-home-care-agencies">local SEO</a>, or optimizing for AI-powered search, every recommendation is designed to help generate more qualified inquiries — not just more traffic.</p>
  </div>
</section>

<!-- WHY HOMECARECREATORS -->
<section class="why-section">
  <div class="container">
    <div class="why-grid">
      <div data-reveal>
        <p class="section-label">Why Home Care Agencies Choose Us</p>
        <h2 class="section-h2">We Only Work With<br><em>the Home Care Industry</em></h2>
        <div class="why-body">
          <p>Unlike general marketing agencies, we work exclusively with the home care industry. That means we understand how families research care providers, what builds trust online, and how local search influences their decisions.</p>
          <p>Our strategies combine technical SEO, high-converting <a href="/web-design/homecare-website-design/">website design</a>, Google Business Profile optimization, and <a href="/seo/home-care-seo/">AI Search Optimization (GEO)</a> to help agencies grow with confidence.</p>
        </div>
      </div>
      <div data-reveal style="transition-delay:.15s">
        <div class="why-stat-card">
          <div class="why-stat-grid">
            <div class="why-stat-item"><div class="why-stat-item-num">6</div><div class="why-stat-item-label">Campaigns Featured Above</div></div>
            <div class="why-stat-item"><div class="why-stat-item-num">650+</div><div class="why-stat-item-label">Combined Leads Generated</div></div>
            <div class="why-stat-item"><div class="why-stat-item-num">$193K+</div><div class="why-stat-item-label">Combined Quote Value</div></div>
            <div class="why-stat-item"><div class="why-stat-item-num">100%</div><div class="why-stat-item-label">Home Care Focused</div></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- OUR SERVICES -->
<section class="services-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Our Services</p>
      <h2 class="section-h2" style="text-align:center">The Strategies Behind<br><em>These Results</em></h2>
    </div>
    <div class="svc-grid" data-reveal style="transition-delay:.1s">
      <a href="/seo/home-care-seo/" class="svc-card">
        <div class="svc-card-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
        <h3>Home Care SEO</h3>
        <p>Improve your visibility in Google Search and attract families actively looking for care.</p>
      </a>
      <a href="/web-design/homecare-website-design/" class="svc-card">
        <div class="svc-card-icon"><i class="fa-solid fa-laptop-code"></i></div>
        <h3>Home Care Website Design</h3>
        <p>Build a professional, conversion-focused website that earns trust and generates more inquiries.</p>
      </a>
      <a href="/seo/local-seo-for-home-care-agencies" class="svc-card">
        <div class="svc-card-icon"><i class="fa-solid fa-map-location-dot"></i></div>
        <h3>Local SEO</h3>
        <p>Appear in Google Maps and local search results where families are searching for nearby care providers.</p>
      </a>
      <a href="/#services" class="svc-card">
        <div class="svc-card-icon"><i class="fa-solid fa-brain"></i></div>
        <h3>AI Search Optimization (GEO)</h3>
        <p>Prepare your website for the future of search by improving visibility in AI-powered platforms like ChatGPT and Google AI.</p>
      </a>
      <a href="/#services" class="svc-card">
        <div class="svc-card-icon"><i class="fa-solid fa-gears"></i></div>
        <h3>AI Automation</h3>
        <p>Automate repetitive tasks, streamline operations, and improve your agency's efficiency with practical AI solutions.</p>
      </a>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Frequently Asked Questions</p>
      <h2 class="section-h2">Case Studies<br><em>Your Questions Answered</em></h2>
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
  <div class="container cta-inner">
    <div data-reveal>
      <p class="section-label">Get Started Today</p>
      <h2 class="section-h2">Ready to Become Our<br><em>Next Success Story?</em></h2>
      <p class="cta-desc">Whether you're launching a new home care agency or looking to generate more qualified private-pay leads, we'll build a marketing strategy designed around your goals — not a generic template. Let's grow your agency together.</p>
      <button class="btn-primary" style="font-size:15px;padding:16px 32px" onclick="openPopup()"><i class="fa-solid fa-calendar-check"></i>Schedule Your Free Strategy Call</button>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
