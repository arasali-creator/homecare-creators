<?php
// Shared template for /home-care-agency-marketing-{state}/ pages.
// Each state's index.php sets $state_key and includes this file.
// State-specific content lives in includes/state-pages-data.php.
$_states = require __DIR__ . '/state-pages-data.php';
if (empty($state_key) || !isset($_states[$state_key])) { http_response_code(404); exit; }
$S = $_states[$state_key];
$_name = $S['name'];

$page_canonical = "https://homecarecreators.com/home-care-agency-marketing-{$state_key}/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "Home Care Agency Marketing in {$_name} ({$S['abbr']}) | Homecare Creators";
$page_desc  = $S['meta_desc'];
$og_title   = $page_title;
$og_desc    = $S['hero_desc'];
$og_image   = "https://homecarecreators.com/images/team/{$S['img_hero']}";

$_cases_all = require __DIR__ . '/case-studies-data.php';
$_cases = array_map(fn($i) => $_cases_all[$i], $S['cases']);

// State FAQs first, then shared ones with real pricing.
$_faqs = array_merge($S['faqs'], [
    ["How much does home care agency marketing cost in {$_name}?", "Our home care SEO plans start at \$697 per month (Starter), with Care Plus at \$1,097 and Care Advanced at \$1,597 per month. The right plan depends on how many cities you serve and how competitive your market is. We'll recommend one after a free audit."],
    ["How long does home care SEO take to show results?", "Most agencies see Google Maps and search movement within a few months, with stronger results building over 4 to 6 months. Paid ads can bring inquiries sooner while SEO builds. No honest agency can guarantee rankings."],
    ["Can you help my agency show up in ChatGPT and Google AI Overviews?", "Yes. We structure your website content, FAQs, schema and business information so AI tools can understand what you do and where you operate. Inclusion can't be guaranteed, but clear, specific information makes it far more likely."],
]);

$page_css = <<<CSS
.container{max-width:1280px}
.section-h2{font-size:clamp(24px,3.2vw,42px)}
.hero{background:var(--forest);position:relative;overflow:hidden;padding:150px 0 72px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-grid{position:relative;z-index:2;max-width:1280px;margin:0 auto;display:grid;grid-template-columns:1.05fr .95fr;gap:64px;align-items:center;padding:0 48px}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:18px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb span{color:var(--teal-lt)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:24px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(26px,3.4vw,42px);line-height:1.15;color:#fff;margin-bottom:20px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:17.5px;line-height:1.75;color:rgba(255,255,255,.66);max-width:500px;margin-bottom:32px}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:36px}
.hero-proof{display:flex;gap:28px;flex-wrap:wrap}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.5)}
.hero-photo-wrap{position:relative}
.hero-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/4.4;position:relative;box-shadow:0 30px 80px rgba(0,0,0,.4)}
.hero-photo img{width:100%;height:100%;object-fit:cover;display:block}
.hero-photo-badge{position:absolute;bottom:-20px;left:-20px;z-index:3;background:#fff;border-radius:16px;padding:16px 20px;box-shadow:0 20px 50px rgba(10,46,30,.25);display:flex;align-items:center;gap:12px}
.hero-photo-badge-icon{width:40px;height:40px;border-radius:11px;background:rgba(29,158,117,.1);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0}
.hero-photo-badge-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:800;color:var(--forest);line-height:1.15}
.hero-photo-badge-label{font-size:11px;color:var(--muted);font-weight:600;font-family:'Plus Jakarta Sans',sans-serif}
.lede{font-size:17px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.lede strong{color:var(--forest)}
.section-cta-btn{display:inline-flex;align-items:center;gap:8px;background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;padding:14px 26px;border-radius:10px;border:none;cursor:pointer;transition:.2s;margin-top:8px;text-decoration:none}
.section-cta-btn:hover{background:var(--forest);transform:translateY(-2px)}
.intro-section{background:#fff}
.intro-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:64px;align-items:center}
.intro-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/4.6;box-shadow:0 24px 70px rgba(10,46,30,.15)}
.intro-photo img{width:100%;height:100%;object-fit:cover;display:block}
/* STATE FACTS */
.facts-section{background:var(--cream)}
.facts-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:36px}
.fact-card{background:#fff;border:1px solid var(--border);border-radius:18px;padding:26px;display:flex;flex-direction:column}
.fact-icon{width:42px;height:42px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:17px;margin-bottom:14px}
.fact-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--forest);margin-bottom:10px}
.fact-card p{font-size:14.5px;line-height:1.7;color:var(--muted)}
.fact-tip{margin-top:14px;padding:12px 14px;background:var(--warm);border-left:3px solid var(--teal);border-radius:8px;font-size:13.5px;line-height:1.6;color:var(--forest)}
.fact-tip strong{color:var(--teal)}
.facts-note{font-size:13px;color:var(--muted);margin-top:18px;font-style:italic}
/* METROS */
.market-section{background:#fff}
.metro-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:36px}
.metro-card{background:var(--warm);border:1px solid var(--border);border-left:4px solid var(--teal);border-radius:14px;padding:24px}
.metro-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--forest);margin-bottom:8px}
.metro-card p{font-size:14.5px;line-height:1.7;color:var(--muted)}
/* IDEAS */
.ideas-section{background:var(--cream)}
.ideas-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:36px}
.idea-card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:24px}
.idea-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:28px;color:var(--teal);line-height:1;margin-bottom:10px}
.idea-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:15.5px;font-weight:700;color:var(--forest);margin-bottom:8px}
.idea-card p{font-size:14px;line-height:1.65;color:var(--muted)}
/* SERVICES */
.services-section{background:#fff}
.svc-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-top:32px}
.svc-card{display:block;text-decoration:none;background:var(--warm);border:1px solid var(--border);border-radius:16px;padding:22px;transition:.25s}
.svc-card:hover{border-color:var(--teal);transform:translateY(-3px)}
.svc-card i{font-size:20px;color:var(--teal);margin-bottom:12px;display:block}
.svc-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:6px}
.svc-card p{font-size:13.5px;line-height:1.6;color:var(--muted)}
/* CASE STUDIES */
.cases-section{background:var(--cream)}
.case-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:36px}
.case-card{background:#fff;border:1px solid var(--border);border-radius:20px;overflow:hidden}
.case-card img{width:100%;display:block;border-bottom:1px solid var(--border)}
.case-body{padding:24px}
.case-badge{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--teal);margin-bottom:6px}
.case-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--forest);margin-bottom:10px}
.case-title span{color:var(--muted);font-weight:500}
.case-text{font-size:14.5px;line-height:1.65;color:var(--muted);margin-bottom:14px}
.case-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.case-stat{background:var(--warm);border:1px solid var(--border);border-radius:10px;padding:10px 6px;text-align:center}
.case-stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:800;color:var(--teal);line-height:1}
.case-stat-label{font-size:10.5px;color:var(--muted);font-weight:600;margin-top:4px}
.cases-cta{text-align:center;margin-top:28px}
/* PRICING STRIP */
.price-strip{background:#fff}
.price-strip-inner{display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap;background:var(--forest);border-radius:24px;padding:36px 40px}
.price-strip h2{font-family:'Plus Jakarta Sans',sans-serif;color:#fff;font-size:clamp(20px,2.4vw,28px);margin-bottom:8px}
.price-strip p{color:rgba(255,255,255,.7);font-size:15.5px;line-height:1.7;max-width:640px}
.price-strip strong{color:var(--mint)}
.price-strip a{background:#fff;color:var(--forest);text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;padding:15px 26px;border-radius:100px;white-space:nowrap}
/* FAQ */
.faq{background:var(--cream)}
.faq-header{text-align:center;margin-bottom:48px}
.faq-header .section-label{justify-content:center}
.faq-list{max-width:820px;margin:0 auto;display:flex;flex-direction:column;gap:12px}
.faq-item{background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden}
.faq-q{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:20px 24px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;color:var(--forest)}
.faq-q-icon{width:28px;height:28px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;transition:transform .3s,background .3s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal)}
.faq-a{max-height:0;overflow:hidden;transition:max-height .4s ease}
.faq-item.open .faq-a{max-height:500px}
.faq-a-inner{padding:16px 24px 20px;font-size:15px;line-height:1.75;color:var(--muted);border-top:1px solid var(--border)}
/* OTHER STATES */
.states-section{background:#fff;padding-bottom:40px}
.states-row{display:flex;flex-wrap:wrap;gap:10px;margin-top:20px}
.states-row a{text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:600;color:var(--forest);background:var(--warm);border:1px solid var(--border);border-radius:100px;padding:10px 18px;transition:.2s}
.states-row a:hover{border-color:var(--teal);color:var(--teal)}
/* CTA */
.cta-section{background:#fff;padding:24px 24px 72px}
.cta-card{position:relative;max-width:1100px;margin:0 auto;background:var(--forest);border-radius:36px;padding:64px 48px;text-align:center;overflow:hidden}
.cta-card-inner{position:relative;z-index:2;max-width:640px;margin:0 auto}
.cta-headline{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(21px,2.9vw,30px);line-height:1.25;color:#fff;margin-bottom:18px}
.cta-headline em{font-style:italic;color:var(--mint)}
.cta-sub{font-size:16px;line-height:1.7;color:rgba(255,255,255,.66);margin:0 auto 28px}
.cta-pill-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;color:var(--forest);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;padding:17px 32px;border-radius:100px;border:none;cursor:pointer;transition:.2s}
.cta-pill-btn:hover{transform:translateY(-2px)}
@media(max-width:1100px){.svc-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:1024px){
  .hero-grid{grid-template-columns:1fr;gap:40px;padding:0 32px}
  .intro-grid{grid-template-columns:1fr;gap:32px}
  .intro-photo{max-width:420px;margin:0 auto}
  .facts-grid,.ideas-grid{grid-template-columns:1fr 1fr}
  .metro-grid,.case-grid{grid-template-columns:1fr}
}
@media(max-width:640px){
  .hero{padding:120px 0 56px}
  .hero-grid{padding:0 20px}
  section{padding:64px 20px}
  .facts-grid,.ideas-grid,.svc-grid{grid-template-columns:1fr}
  .price-strip-inner{padding:28px 22px}
  .cta-card{padding:48px 22px;border-radius:26px}
}
CSS;
include __DIR__ . '/header.php';

// ── Structured data ─────────────────────────────────────────────
echo '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org",
    "@graph" => [
        ["@type" => "BreadcrumbList", "itemListElement" => [
            ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => "https://homecarecreators.com/"],
            ["@type" => "ListItem", "position" => 2, "name" => "Areas We Serve", "item" => "https://homecarecreators.com/areas-we-serve/"],
            ["@type" => "ListItem", "position" => 3, "name" => $_name, "item" => $page_canonical],
        ]],
        ["@type" => "Service",
         "name" => "Home Care Agency Marketing in {$_name}",
         "serviceType" => "Home care agency marketing, SEO and website design",
         "description" => $page_desc,
         "url" => $page_canonical,
         "provider" => ["@type" => "Organization", "@id" => "https://homecarecreators.com/#organization", "name" => "Homecare Creators", "url" => "https://homecarecreators.com/"],
         "areaServed" => ["@type" => "State", "name" => $_name, "containedInPlace" => ["@type" => "Country", "name" => "United States"]],
         "audience" => ["@type" => "BusinessAudience", "name" => "Home care agencies in {$_name}"],
         "offers" => ["@type" => "Offer", "price" => "697", "priceCurrency" => "USD", "priceSpecification" => ["@type" => "UnitPriceSpecification", "price" => "697", "priceCurrency" => "USD", "unitText" => "MONTH"]],
        ],
        ["@type" => "FAQPage", "mainEntity" => array_map(fn($f) => ["@type" => "Question", "name" => $f[0], "acceptedAnswer" => ["@type" => "Answer", "text" => $f[1]]], $_faqs)],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
?>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-grid">
    <div data-reveal>
      <div class="hero-breadcrumb"><a href="/">Home</a> / <a href="/areas-we-serve/">Areas We Serve</a> / <span><?= htmlspecialchars($_name) ?></span></div>
      <div class="hero-badge"><i class="fa-solid fa-location-dot" style="margin-right:6px"></i><?= htmlspecialchars($_name) ?> Home Care Marketing</div>
      <h1 class="hero-h1">Home Care Agency Marketing <em>in <?= htmlspecialchars($_name) ?></em></h1>
      <p class="hero-desc"><?= htmlspecialchars($S['hero_desc']) ?></p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Get Your Free Marketing Audit</button>
        <a href="#ideas" class="btn-secondary"><i class="fa-solid fa-lightbulb"></i><?= htmlspecialchars($S['abbr']) ?> Marketing Ideas</a>
      </div>
      <div class="hero-proof">
        <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Homecare-Only Focus</div></div>
        <div class="hero-proof-item"><div class="hero-proof-num">$697</div><div class="hero-proof-label">SEO Plans From / Month</div></div>
        <div class="hero-proof-item"><div class="hero-proof-num">30-Day</div><div class="hero-proof-label">Satisfaction Guarantee</div></div>
      </div>
    </div>
    <div class="hero-photo-wrap" data-reveal style="transition-delay:.15s">
      <div class="hero-photo">
        <img src="/images/team/<?= htmlspecialchars($S['img_hero']) ?>" alt="Homecare Creators team planning marketing for a <?= htmlspecialchars($_name) ?> home care agency" fetchpriority="high">
      </div>
      <div class="hero-photo-badge">
        <div class="hero-photo-badge-icon"><i class="fa-solid fa-map-location-dot"></i></div>
        <div>
          <div class="hero-photo-badge-num"><?= htmlspecialchars($S['metros'][0][0]) ?></div>
          <div class="hero-photo-badge-label">&amp; across <?= htmlspecialchars($_name) ?></div>
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
      <div class="cert-item"><img src="/images/blog/Homecarecreators-Google-my-business-profile.png" alt="Homecare Creators verified Google Business Profile badge" loading="lazy"><span>Google Business Profile</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-google-partner.jpg" alt="Homecare Creators Google Partner certification badge" loading="lazy"><span>Google Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-hubspot-partner.webp" alt="Homecare Creators HubSpot certified partner badge" loading="lazy"><span>HubSpot Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-meta-certificate.jpg" alt="Homecare Creators Meta certified marketing partner badge" loading="lazy"><span>Meta Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-semrush-ceticificate.png" alt="Homecare Creators SEMrush certified SEO partner badge" loading="lazy"><span>SEMrush Certified</span></div>
    </div>
  </div>
</section>

<!-- INTRO -->
<section class="intro-section">
  <div class="container intro-grid">
    <div data-reveal>
      <p class="section-label">The <?= htmlspecialchars($_name) ?> Market</p>
      <h2 class="section-h2">How families find home care in <?= htmlspecialchars($_name) ?></h2>
      <?php foreach ($S['intro'] as $p): ?>
      <p class="lede"><?= htmlspecialchars($p) ?></p>
      <?php endforeach; ?>
      <p class="lede"><strong>Homecare Creators helps <?= htmlspecialchars($_name) ?> home care agencies get found on Google Maps, in search and in AI tools, and turns those visits into calls.</strong></p>
      <button class="section-cta-btn" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Get Your Free <?= htmlspecialchars($_name) ?> Marketing Audit</button>
    </div>
    <div class="intro-photo" data-reveal style="transition-delay:.15s">
      <img src="/images/team/<?= htmlspecialchars($S['img_intro']) ?>" alt="Homecare Creators strategist reviewing a <?= htmlspecialchars($_name) ?> home care agency's local search results" loading="lazy">
    </div>
  </div>
</section>

<!-- WHAT'S DIFFERENT IN THIS STATE -->
<section class="facts-section" id="state">
  <div class="container">
    <div data-reveal style="max-width:760px">
      <p class="section-label">Know Your Market</p>
      <h2 class="section-h2">What's different about marketing home care in <?= htmlspecialchars($_name) ?></h2>
      <p class="lede">Licensing, funding and how families search all shape what your marketing should say. Here's what matters in <?= htmlspecialchars($_name) ?>.</p>
    </div>
    <div class="facts-grid" data-reveal style="transition-delay:.1s">
      <div class="fact-card">
        <div class="fact-icon"><i class="fa-solid fa-file-shield"></i></div>
        <h3>Licensing in <?= htmlspecialchars($_name) ?></h3>
        <p><?= htmlspecialchars($S['regulation']) ?></p>
        <div class="fact-tip"><strong>Marketing tip:</strong> <?= htmlspecialchars($S['regulation_tip']) ?></div>
      </div>
      <div class="fact-card">
        <div class="fact-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
        <h3>Who pays for care</h3>
        <p><?= htmlspecialchars($S['payers']) ?></p>
      </div>
      <div class="fact-card">
        <div class="fact-icon"><i class="fa-solid fa-people-roof"></i></div>
        <h3>How families search</h3>
        <p><?= htmlspecialchars($S['families']) ?></p>
      </div>
    </div>
    <p class="facts-note">Regulations change. Always confirm current requirements with the state agency before relying on them.</p>
  </div>
</section>

<!-- METROS -->
<section class="market-section" id="cities">
  <div class="container">
    <div data-reveal style="max-width:720px">
      <p class="section-label">Where We Work</p>
      <h2 class="section-h2">Home care marketing across <?= htmlspecialchars($_name) ?>'s key markets</h2>
      <p class="lede">Every region has different competitors and different search habits. Here's how we approach each one.</p>
    </div>
    <div class="metro-grid" data-reveal style="transition-delay:.1s">
      <?php foreach ($S['metros'] as $m): ?>
      <div class="metro-card">
        <h3><?= htmlspecialchars($m[0]) ?></h3>
        <p><?= htmlspecialchars($m[1]) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- IDEAS -->
<section class="ideas-section" id="ideas">
  <div class="container">
    <div data-reveal style="max-width:760px">
      <p class="section-label">Marketing Ideas</p>
      <h2 class="section-h2">6 marketing ideas for <?= htmlspecialchars($_name) ?> home care agencies</h2>
      <p class="lede">Practical strategies you can start on this month, whether you work with us or not.</p>
    </div>
    <div class="ideas-grid" data-reveal style="transition-delay:.1s">
      <?php foreach ($S['ideas'] as $i => $idea): ?>
      <div class="idea-card">
        <div class="idea-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></div>
        <h3><?= htmlspecialchars($idea[0]) ?></h3>
        <p><?= htmlspecialchars($idea[1]) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SERVICES (short; full detail lives on each service page) -->
<section class="services-section" id="services">
  <div class="container">
    <div data-reveal style="max-width:720px">
      <p class="section-label">What We Do</p>
      <h2 class="section-h2">Our services for <?= htmlspecialchars($_name) ?> agencies</h2>
    </div>
    <div class="svc-grid" data-reveal style="transition-delay:.1s">
      <a class="svc-card" href="/seo/home-care-seo/"><i class="fa-solid fa-magnifying-glass-chart"></i><h3>Home Care SEO</h3><p>Rank for the searches families make in your service area.</p></a>
      <a class="svc-card" href="/local-seo-for-home-care-agencies/"><i class="fa-solid fa-map-location-dot"></i><h3>Local SEO &amp; Google Maps</h3><p>Google Business Profile, reviews and citations.</p></a>
      <a class="svc-card" href="/web-design/homecare-website-design/"><i class="fa-solid fa-laptop"></i><h3>Website Design</h3><p>Fast, mobile-first sites that turn visits into calls.</p></a>
      <a class="svc-card" href="/ai-search-seo/"><i class="fa-solid fa-robot"></i><h3>AI Search SEO</h3><p>Get cited by ChatGPT and Google AI Overviews.</p></a>
      <a class="svc-card" href="/ai-automation/"><i class="fa-solid fa-bolt"></i><h3>AI &amp; Automation</h3><p>Instant follow-up so no inquiry goes cold.</p></a>
    </div>
  </div>
</section>

<!-- CASE STUDIES -->
<section class="cases-section" id="results">
  <div class="container">
    <div data-reveal style="max-width:760px">
      <p class="section-label">Real Results</p>
      <h2 class="section-h2">Results from home care agencies we work with</h2>
      <p class="lede">Real lead dashboards from our client campaigns. Your market will differ, but the approach is the same.</p>
    </div>
    <div class="case-grid" data-reveal style="transition-delay:.1s">
      <?php foreach ($_cases as $c): ?>
      <div class="case-card">
        <img src="/images/case-studies/<?= htmlspecialchars($c['img']) ?>" alt="<?= htmlspecialchars($c['name'] . ' lead dashboard showing ' . $c['stats'][0][0] . ' ' . strtolower($c['stats'][0][1])) ?>" loading="lazy">
        <div class="case-body">
          <div class="case-badge">Case Study <?= htmlspecialchars($c['num']) ?></div>
          <h3 class="case-title"><?= htmlspecialchars($c['name']) ?><?= $c['region'] ? ' <span>| ' . htmlspecialchars($c['region']) . '</span>' : '' ?></h3>
          <p class="case-text"><?= htmlspecialchars($c['challenge']) ?></p>
          <div class="case-stats">
            <?php foreach (array_slice($c['stats'], 0, 3) as $st): ?>
            <div class="case-stat"><div class="case-stat-num"><?= htmlspecialchars($st[0]) ?></div><div class="case-stat-label"><?= htmlspecialchars($st[1]) ?></div></div>
            <?php endforeach; ?>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
    <div class="cases-cta"><a href="/case-studies/" class="section-cta-btn">View all <?= count($_cases_all) ?> case studies <i class="fa-solid fa-arrow-right"></i></a></div>
  </div>
</section>

<!-- PRICING STRIP -->
<section class="price-strip">
  <div class="container">
    <div class="price-strip-inner" data-reveal>
      <div>
        <h2>Transparent pricing for <?= htmlspecialchars($_name) ?> agencies</h2>
        <p>Home care SEO plans start at <strong>$697/month</strong> (Starter), with Care Plus at <strong>$1,097</strong> and Care Advanced at <strong>$1,597</strong>. No long lock-in after the initial ramp-up period.</p>
      </div>
      <a href="/seo/home-care-seo/#pricing">Compare plans <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq" id="faq">
  <div class="container">
    <div class="faq-header" data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Questions about home care marketing<br><em>in <?= htmlspecialchars($_name) ?></em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">
      <?php foreach ($_faqs as $f): ?>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)" role="button" tabindex="0" aria-expanded="false"><span class="faq-q-text"><?= htmlspecialchars($f[0]) ?></span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><?= htmlspecialchars($f[1]) ?></div></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- OTHER STATES -->
<section class="states-section">
  <div class="container">
    <p class="section-label">Other States We Serve</p>
    <div class="states-row">
      <a href="/areas-we-serve/">Florida</a>
      <?php foreach ($_states as $k => $st): if ($k === $state_key) continue; ?>
      <a href="/home-care-agency-marketing-<?= htmlspecialchars($k) ?>/"><?= htmlspecialchars($st['name']) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FINAL CTA -->
<section class="cta-section">
  <div class="cta-card" data-reveal>
    <div class="cta-card-inner">
      <h2 class="cta-headline">Ready to grow your <em><?= htmlspecialchars($_name) ?></em> home care agency?</h2>
      <p class="cta-sub">In a free audit we'll show you where you rank in <?= htmlspecialchars($S['metros'][0][0]) ?> and your other service areas, what your top competitors do better, and the changes that would bring in the most inquiries.</p>
      <button class="cta-pill-btn" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Get Your Free Marketing Audit</button>
    </div>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
