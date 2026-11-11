<?php
// Shared template for /homecare-website-design-{city}-fl/ pages.
// Each web-design/homecare-website-design-{city}-fl.php sets $city_key and includes this.
// Website-specific copy: includes/web-design-cities-data.php
// City basics (county, areas, case studies): includes/florida-cities-data.php
$_wd     = require __DIR__ . '/web-design-cities-data.php';
$_cities = require __DIR__ . '/florida-cities-data.php';
if (empty($city_key) || !isset($_wd[$city_key], $_cities[$city_key])) { http_response_code(404); exit; }
$W = $_wd[$city_key];
$C = $_cities[$city_key];
$_name = $C['name'];

$page_canonical = "https://homecarecreators.com/homecare-website-design-{$city_key}-fl/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "{$_name} Home Care Website Design | Homecare Creators";
$page_desc  = $W['meta_desc'];
$og_title   = $page_title;
$og_desc    = $W['hero_desc'];
$og_image   = "https://homecarecreators.com/images/home/service-website-dev.jpg";

$_cases_all = require __DIR__ . '/case-studies-data.php';
$_cases = array_map(fn($i) => $_cases_all[$i], $C['cases']);

$_faqs = array_merge($W['faqs'], [
    ["How much does a home care website cost in {$_name}?", "Websites start at \$699 (Starter, 5 pages), with Growth at \$999 (10 pages, 3 area pages, careers page) and Dominate at \$1,699 (15+ pages, 8 area pages, brand identity). Hosting is \$79 per month and includes SSL, backups and updates to keep the site online."],
    ["How long does it take to build my website?", "Starter sites go live in 10 to 14 days, Growth in about 14 days and Dominate in up to 21 days. We write all the content; you review and approve it."],
    ["Can I add local SEO to my website?", "Yes. Our home care SEO plans start at \$697 per month and push your new site up Google Maps and local search. Most agencies get the best results by pairing the two."],
]);

$page_css = (require __DIR__ . '/location-page-css.php') . <<<'CSS'

/* WEB DESIGN CITY PAGES */
.areas-section{background:#fff}
.areas-grid{display:flex;flex-wrap:wrap;gap:10px;margin-top:28px}
.area-pill{display:inline-flex;align-items:center;gap:8px;background:var(--warm);border:1px solid var(--border);border-radius:100px;padding:9px 16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--forest)}
.area-dot{width:7px;height:7px;border-radius:50%;background:var(--teal)}
.pricing-section{background:var(--cream)}
.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;align-items:stretch;margin-top:40px}
.price-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px 28px;display:flex;flex-direction:column;position:relative}
.price-card.featured{border:2px solid var(--teal);box-shadow:0 20px 56px rgba(10,46,30,.12)}
.price-featured-tag{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;padding:6px 16px;border-radius:100px;white-space:nowrap}
.price-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:19px;color:var(--forest);margin-bottom:6px}
.price-amount{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:40px;color:var(--forest);line-height:1.1}
.price-period{font-size:13px;color:var(--muted);font-weight:600;margin-bottom:20px}
.price-list{list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:24px;flex:1}
.price-list li{display:flex;gap:9px;font-size:14px;line-height:1.5;color:var(--text)}
.price-list li i{color:var(--teal);font-size:12px;margin-top:4px}
.price-card .section-cta-btn{justify-content:center}
.process-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:18px;margin-top:32px}
.process-step{background:var(--warm);border:1px solid var(--border);border-radius:16px;padding:22px}
.process-step .idea-num{font-size:22px}
.process-step h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:6px}
.process-step p{font-size:14px;line-height:1.6;color:var(--muted)}
.seo-link{display:flex;align-items:center;gap:20px;flex-wrap:wrap;background:var(--warm);border:1px solid var(--border);border-radius:18px;padding:24px 28px;margin-top:32px}
.seo-link p{flex:1;font-size:15px;line-height:1.7;color:var(--muted);min-width:240px}
.seo-link strong{color:var(--forest)}
@media(max-width:1024px){.pricing-grid{grid-template-columns:1fr;max-width:460px;margin-left:auto;margin-right:auto}.process-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){.process-grid{grid-template-columns:1fr}}
CSS;
include __DIR__ . '/header.php';

// ── Structured data ─────────────────────────────────────────────
$_offer = fn($n, $p) => ["@type" => "Offer", "name" => $n, "price" => $p, "priceCurrency" => "USD"];
echo '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org",
    "@graph" => [
        ["@type" => "BreadcrumbList", "itemListElement" => [
            ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => "https://homecarecreators.com/"],
            ["@type" => "ListItem", "position" => 2, "name" => "Website Design", "item" => "https://homecarecreators.com/web-design/homecare-website-design/"],
            ["@type" => "ListItem", "position" => 3, "name" => "{$_name}, FL", "item" => $page_canonical],
        ]],
        ["@type" => "Service",
         "name" => "Home Care Website Design in {$_name}, FL",
         "serviceType" => "Website design for home care agencies",
         "description" => $page_desc,
         "url" => $page_canonical,
         "provider" => ["@type" => "Organization", "@id" => "https://homecarecreators.com/#organization", "name" => "Homecare Creators", "url" => "https://homecarecreators.com/"],
         "areaServed" => ["@type" => "City", "name" => "{$_name}, FL", "containedInPlace" => ["@type" => "AdministrativeArea", "name" => "{$C['county']}, Florida"]],
         "offers" => [$_offer('Starter', '699'), $_offer('Growth', '999'), $_offer('Dominate', '1699')],
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
      <div class="hero-breadcrumb"><a href="/">Home</a> / <a href="/web-design/homecare-website-design/">Website Design</a> / <span><?= htmlspecialchars($_name) ?>, FL</span></div>
      <div class="hero-badge"><i class="fa-solid fa-laptop-code" style="margin-right:6px"></i>Home Care Website Design · <?= htmlspecialchars($C['county']) ?></div>
      <h1 class="hero-h1">Home Care Website Design <em>in <?= htmlspecialchars($_name) ?>, FL</em></h1>
      <p class="hero-desc"><?= htmlspecialchars($W['hero_desc']) ?></p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Get Your <?= htmlspecialchars($_name) ?> Website Quote</button>
        <a href="#pricing" class="btn-secondary"><i class="fa-solid fa-tag"></i>View Packages</a>
      </div>
      <div class="hero-proof">
        <div class="hero-proof-item"><div class="hero-proof-num">$699</div><div class="hero-proof-label">Websites From</div></div>
        <div class="hero-proof-item"><div class="hero-proof-num">10–21</div><div class="hero-proof-label">Days to Launch</div></div>
        <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Homecare-Only Focus</div></div>
      </div>
    </div>
    <div class="hero-photo-wrap" data-reveal style="transition-delay:.15s">
      <div class="hero-photo">
        <img src="/images/home/service-website-dev.jpg" alt="Mobile-first home care agency website designed for <?= htmlspecialchars($_name) ?> families" fetchpriority="high">
      </div>
      <div class="hero-photo-badge">
        <div class="hero-photo-badge-icon"><i class="fa-solid fa-mobile-screen"></i></div>
        <div>
          <div class="hero-photo-badge-num">Mobile-first</div>
          <div class="hero-photo-badge-label">Built for <?= htmlspecialchars($_name) ?> families</div>
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
      <p class="section-label">Websites for <?= htmlspecialchars($_name) ?> Agencies</p>
      <h2 class="section-h2">What <?= htmlspecialchars($_name) ?> families need from your website</h2>
      <?php foreach ($W['intro'] as $p): ?>
      <p class="lede"><?= htmlspecialchars($p) ?></p>
      <?php endforeach; ?>
      <button class="section-cta-btn" onclick="openPopup('audit')"><i class="fa-solid fa-magnifying-glass"></i>Get a Free Review of Your Current Site</button>
    </div>
    <div class="intro-photo" data-reveal style="transition-delay:.15s">
      <img src="/images/blog/inline-laptop-website.jpg" alt="Home care agency website reviewed on a laptop" loading="lazy">
    </div>
  </div>
</section>

<!-- MUST-HAVES -->
<section class="ideas-section" id="features">
  <div class="container">
    <div data-reveal style="max-width:760px">
      <p class="section-label">Built for <?= htmlspecialchars($_name) ?></p>
      <h2 class="section-h2"><?= count($W['must_haves']) ?> things every <?= htmlspecialchars($_name) ?> home care website needs</h2>
      <p class="lede">On top of the essentials every site gets: mobile-first design, fast loading, SEO setup, schema, Google Analytics and Search Console.</p>
    </div>
    <div class="ideas-grid" data-reveal style="transition-delay:.1s">
      <?php foreach ($W['must_haves'] as $i => $m): ?>
      <div class="idea-card">
        <div class="idea-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></div>
        <h3><?= htmlspecialchars($m[0]) ?></h3>
        <p><?= htmlspecialchars($m[1]) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- AREA PAGES -->
<section class="areas-section" id="areas">
  <div class="container">
    <div data-reveal style="max-width:760px">
      <p class="section-label">Area Pages</p>
      <h2 class="section-h2">Area pages we can build for <?= htmlspecialchars($_name) ?> agencies</h2>
      <p class="lede">Growth includes 3 area pages and Dominate includes 8. We pick the areas you actually staff so each page can rank on its own.</p>
    </div>
    <div class="areas-grid" data-reveal style="transition-delay:.1s">
      <?php foreach ($C['areas'] as $a): ?>
      <div class="area-pill"><div class="area-dot"></div><?= htmlspecialchars($a) ?></div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="pricing-section" id="pricing">
  <div class="container">
    <div data-reveal style="max-width:720px">
      <p class="section-label">Packages &amp; Pricing</p>
      <h2 class="section-h2">Home care website packages</h2>
      <p class="lede">One-time build price plus $79/month hosting (SSL, backups and uptime monitoring). No hidden fees.</p>
    </div>
    <div class="pricing-grid" data-reveal style="transition-delay:.1s">
      <div class="price-card">
        <div class="price-name">Starter</div>
        <div class="price-amount">$699</div><div class="price-period">one-time + $79/mo hosting</div>
        <ul class="price-list">
          <li><i class="fa-solid fa-check"></i>5 custom pages</li>
          <li><i class="fa-solid fa-check"></i>Mobile-first design with your branding</li>
          <li><i class="fa-solid fa-check"></i>On-page SEO for <?= htmlspecialchars($_name) ?> searches</li>
          <li><i class="fa-solid fa-check"></i>Google Reviews widget</li>
          <li><i class="fa-solid fa-check"></i>Inquiry form, Analytics + Search Console</li>
          <li><i class="fa-solid fa-check"></i>Live in 10–14 days</li>
        </ul>
        <button class="section-cta-btn" onclick="openPopup('audit')">Get Started</button>
      </div>
      <div class="price-card featured">
        <div class="price-featured-tag">Most Popular</div>
        <div class="price-name">Growth</div>
        <div class="price-amount">$999</div><div class="price-period">one-time + $79/mo hosting</div>
        <ul class="price-list">
          <li><i class="fa-solid fa-check"></i>Everything in Starter</li>
          <li><i class="fa-solid fa-check"></i>10 custom pages, including 3 area pages</li>
          <li><i class="fa-solid fa-check"></i>Caregiver careers page</li>
          <li><i class="fa-solid fa-check"></i>LocalBusiness schema markup</li>
          <li><i class="fa-solid fa-check"></i>Blog setup</li>
          <li><i class="fa-solid fa-check"></i>Google Business Profile optimization</li>
          <li><i class="fa-solid fa-check"></i>Live in about 14 days</li>
        </ul>
        <button class="section-cta-btn" onclick="openPopup('audit')">Get Started</button>
      </div>
      <div class="price-card">
        <div class="price-name">Dominate</div>
        <div class="price-amount">$1,699</div><div class="price-period">one-time + $79/mo hosting</div>
        <ul class="price-list">
          <li><i class="fa-solid fa-check"></i>Everything in Growth</li>
          <li><i class="fa-solid fa-check"></i>15+ custom pages, including 8 area pages</li>
          <li><i class="fa-solid fa-check"></i>Custom brand identity (logo + colors)</li>
          <li><i class="fa-solid fa-check"></i>AI chatbot integration</li>
          <li><i class="fa-solid fa-check"></i>Team and caregiver profiles page</li>
          <li><i class="fa-solid fa-check"></i>Priority support + monthly strategy call</li>
          <li><i class="fa-solid fa-check"></i>Live in up to 21 days</li>
        </ul>
        <button class="section-cta-btn" onclick="openPopup('audit')">Get Started</button>
      </div>
    </div>
    <div class="seo-link" data-reveal>
      <p><strong>A website still needs to be found.</strong> Pair your new site with <?= htmlspecialchars($_name) ?> home care SEO to move up Google Maps and local search. SEO plans start at $697/month.</p>
      <a href="/home-care-agency-seo-<?= htmlspecialchars($city_key) ?>-fl/" class="section-cta-btn"><?= htmlspecialchars($_name) ?> SEO <i class="fa-solid fa-arrow-right"></i></a>
    </div>
  </div>
</section>

<!-- PROCESS -->
<section class="services-section" id="process">
  <div class="container">
    <div data-reveal style="max-width:720px">
      <p class="section-label">How It Works</p>
      <h2 class="section-h2">From first call to live website</h2>
    </div>
    <div class="process-grid" data-reveal style="transition-delay:.1s">
      <div class="process-step"><div class="idea-num">01</div><h3>Discovery call</h3><p>30 minutes on the areas you cover, your services and what you want the site to do.</p></div>
      <div class="process-step"><div class="idea-num">02</div><h3>Design and copy</h3><p>We write every page and design the full site. You don't need to write anything.</p></div>
      <div class="process-step"><div class="idea-num">03</div><h3>Review</h3><p>You review the finished site and tell us what to change.</p></div>
      <div class="process-step"><div class="idea-num">04</div><h3>Launch</h3><p>We launch, submit the site to Google and connect Analytics and Search Console.</p></div>
    </div>
  </div>
</section>

<!-- CASE STUDIES -->
<section class="cases-section" id="results">
  <div class="container">
    <div data-reveal style="max-width:760px">
      <p class="section-label">Real Results</p>
      <h2 class="section-h2">Results from home care agencies we work with</h2>
      <p class="lede">Real lead dashboards from client campaigns that combined website optimization with local SEO.</p>
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

<!-- FAQ -->
<section class="faq" id="faq">
  <div class="container">
    <div class="faq-header" data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2"><?= htmlspecialchars($_name) ?> home care website design:<br><em>your questions answered</em></h2>
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

<!-- OTHER CITIES -->
<section class="states-section">
  <div class="container">
    <p class="section-label">Website Design in Other Florida Cities</p>
    <div class="states-row">
      <a href="/web-design/homecare-website-design/">All website packages</a>
      <?php foreach ($_wd as $k => $_x): if ($k === $city_key) continue; ?>
      <a href="/homecare-website-design-<?= htmlspecialchars($k) ?>-fl/"><?= htmlspecialchars($_cities[$k]['name']) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- FINAL CTA -->
<section class="cta-section">
  <div class="cta-card" data-reveal>
    <div class="cta-card-inner">
      <h2 class="cta-headline">Ready for a website that wins <em><?= htmlspecialchars($_name) ?></em> families?</h2>
      <p class="cta-sub">Book a free 30-minute call. We'll review your current site, show what top <?= htmlspecialchars($_name) ?> agencies do better and give you a fixed quote.</p>
      <button class="cta-pill-btn" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Get My Free Website Quote</button>
    </div>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
