<?php
// Shared template for Florida city pages at /home-care-agency-seo-{city}-fl/.
// Each Marketing/home-care-agency-seo-{city}-fl.php sets $city_key and includes this.
// City content lives in includes/florida-cities-data.php.
$_cities = require __DIR__ . '/florida-cities-data.php';
if (empty($city_key) || !isset($_cities[$city_key])) { http_response_code(404); exit; }
$C = $_cities[$city_key];
$_name = $C['name'];

$page_canonical = "https://homecarecreators.com/home-care-agency-seo-{$city_key}-fl/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "{$_name} Home Care Agency Marketing & SEO | Homecare Creators";
$page_desc  = $C['meta_desc'];
$og_title   = $page_title;
$og_desc    = $C['hero_desc'];
$og_image   = "https://homecarecreators.com/images/team/{$C['img_hero']}";

$_cases_all = require __DIR__ . '/case-studies-data.php';
$_cases = array_map(fn($i) => $_cases_all[$i], $C['cases']);
$_states = require __DIR__ . '/state-pages-data.php';

$_faqs = array_merge($C['faqs'], [
    ["How much does home care SEO cost for a {$_name} agency?", "Our home care SEO plans start at \$697 per month (Starter), with Care Plus at \$1,097 and Care Advanced at \$1,597 per month. The right plan depends on how many areas you serve and how competitive they are. We'll recommend one after a free audit."],
    ["How long until my {$_name} agency ranks on Google?", "Most agencies see Google Maps movement within 60 to 90 days, with stronger organic rankings building over 4 to 6 months. Timelines depend on your competition and your starting point. No honest agency can guarantee rankings."],
    ["Do you require a long-term contract?", "No. After an initial ramp-up period, every plan moves to month-to-month."],
]);

$page_css = (require __DIR__ . '/location-page-css.php') . <<<'CSS'

/* AREAS + KEYWORDS (Florida city pages) */
.areas-section{background:#fff}
.areas-grid{display:flex;flex-wrap:wrap;gap:10px;margin-top:28px}
.area-pill{display:inline-flex;align-items:center;gap:8px;background:var(--warm);border:1px solid var(--border);border-radius:100px;padding:9px 16px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--forest)}
.area-dot{width:7px;height:7px;border-radius:50%;background:var(--teal)}
.kw-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:14px;margin-top:28px}
.kw-card{background:var(--warm);border:1px solid var(--border);border-radius:14px;padding:16px 18px}
.kw-term{font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px;font-weight:700;color:var(--forest);margin-bottom:4px}
.kw-intent{font-size:13px;color:var(--muted)}
@media(max-width:1024px){.kw-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){.kw-grid{grid-template-columns:1fr}}
CSS;
include __DIR__ . '/header.php';

// ── Structured data ─────────────────────────────────────────────
echo '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org",
    "@graph" => [
        ["@type" => "BreadcrumbList", "itemListElement" => [
            ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => "https://homecarecreators.com/"],
            ["@type" => "ListItem", "position" => 2, "name" => "Areas We Serve", "item" => "https://homecarecreators.com/areas-we-serve/"],
            ["@type" => "ListItem", "position" => 3, "name" => "{$_name}, FL", "item" => $page_canonical],
        ]],
        ["@type" => "Service",
         "name" => "Home Care Agency Marketing & SEO in {$_name}, FL",
         "serviceType" => "Home care agency marketing, local SEO and website design",
         "description" => $page_desc,
         "url" => $page_canonical,
         "provider" => ["@type" => "Organization", "@id" => "https://homecarecreators.com/#organization", "name" => "Homecare Creators", "url" => "https://homecarecreators.com/"],
         "areaServed" => ["@type" => "City", "name" => "{$_name}, FL",
             "containedInPlace" => ["@type" => "AdministrativeArea", "name" => "{$C['county']}, Florida"]],
         "audience" => ["@type" => "BusinessAudience", "name" => "Home care agencies in {$_name}, Florida"],
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
      <div class="hero-breadcrumb"><a href="/">Home</a> / <a href="/areas-we-serve/">Florida</a> / <span><?= htmlspecialchars($_name) ?></span></div>
      <div class="hero-badge"><i class="fa-solid fa-location-dot" style="margin-right:6px"></i><?= htmlspecialchars($C['county']) ?>, Florida</div>
      <h1 class="hero-h1">Home Care Agency Marketing &amp; SEO <em>in <?= htmlspecialchars($_name) ?>, FL</em></h1>
      <p class="hero-desc"><?= htmlspecialchars($C['hero_desc']) ?></p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Get Your Free <?= htmlspecialchars($_name) ?> SEO Audit</button>
        <a href="#ideas" class="btn-secondary"><i class="fa-solid fa-lightbulb"></i><?= htmlspecialchars($_name) ?> Marketing Ideas</a>
      </div>
      <div class="hero-proof">
        <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Homecare-Only Focus</div></div>
        <div class="hero-proof-item"><div class="hero-proof-num">$697</div><div class="hero-proof-label">SEO Plans From / Month</div></div>
        <div class="hero-proof-item"><div class="hero-proof-num">FL</div><div class="hero-proof-label">Based in Lady Lake, Florida</div></div>
      </div>
    </div>
    <div class="hero-photo-wrap" data-reveal style="transition-delay:.15s">
      <div class="hero-photo">
        <img src="/images/team/<?= htmlspecialchars($C['img_hero']) ?>" alt="Homecare Creators team planning local SEO for a <?= htmlspecialchars($_name) ?> home care agency" fetchpriority="high">
      </div>
      <div class="hero-photo-badge">
        <div class="hero-photo-badge-icon"><i class="fa-solid fa-map-location-dot"></i></div>
        <div>
          <div class="hero-photo-badge-num"><?= htmlspecialchars($_name) ?></div>
          <div class="hero-photo-badge-label"><?= htmlspecialchars($C['county']) ?></div>
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
      <?php foreach ($C['intro'] as $p): ?>
      <p class="lede"><?= htmlspecialchars($p) ?></p>
      <?php endforeach; ?>
      <button class="section-cta-btn" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>See Where You Rank in <?= htmlspecialchars($_name) ?></button>
    </div>
    <div class="intro-photo" data-reveal style="transition-delay:.15s">
      <img src="/images/team/<?= htmlspecialchars($C['img_intro']) ?>" alt="Homecare Creators reviewing local search results for a <?= htmlspecialchars($_name) ?> home care agency" loading="lazy">
    </div>
  </div>
</section>

<!-- FLORIDA FACTS -->
<section class="facts-section" id="florida">
  <div class="container">
    <div data-reveal style="max-width:760px">
      <p class="section-label">Know Your Market</p>
      <h2 class="section-h2">What shapes home care marketing in <?= htmlspecialchars($_name) ?></h2>
    </div>
    <div class="facts-grid" data-reveal style="transition-delay:.1s">
      <div class="fact-card">
        <div class="fact-icon"><i class="fa-solid fa-file-shield"></i></div>
        <h3>Florida licensing (AHCA)</h3>
        <p>Florida's Agency for Health Care Administration (AHCA) regulates home care in three main ways: homemaker and companion providers register with AHCA but can't provide hands-on personal care; nurse registries are licensed and usually place independent-contractor caregivers; and home health agencies are licensed and employ their caregivers.</p>
        <div class="fact-tip"><strong>Marketing tip:</strong> Say clearly which one you are. Families rarely know the difference, and explaining it builds trust.</div>
      </div>
      <div class="fact-card">
        <div class="fact-icon"><i class="fa-solid fa-hand-holding-dollar"></i></div>
        <h3>Who pays for care</h3>
        <p>Florida Medicaid funds long-term in-home care through the Statewide Medicaid Managed Care Long-Term Care (SMMC LTC) program, run by managed care plans. Most agencies grow through private pay, long-term care insurance and veterans' benefits alongside Medicaid work.</p>
      </div>
      <div class="fact-card">
        <div class="fact-icon"><i class="fa-solid fa-people-roof"></i></div>
        <h3>How <?= htmlspecialchars($_name) ?> families search</h3>
        <p><?= htmlspecialchars($C['families']) ?></p>
      </div>
    </div>
    <p class="facts-note">Regulations change. Always confirm current requirements with AHCA.</p>
  </div>
</section>

<!-- AREAS -->
<section class="areas-section" id="areas">
  <div class="container">
    <div data-reveal style="max-width:760px">
      <p class="section-label">Service Coverage</p>
      <h2 class="section-h2">Areas we help <?= htmlspecialchars($_name) ?> agencies rank in</h2>
      <p class="lede">We build pages and local SEO for the areas you actually staff, not every town on the map.</p>
    </div>
    <div class="areas-grid" data-reveal style="transition-delay:.1s">
      <?php foreach ($C['areas'] as $a): ?>
      <div class="area-pill"><div class="area-dot"></div><?= htmlspecialchars($a) ?></div>
      <?php endforeach; ?>
    </div>
    <div style="margin-top:56px" data-reveal>
      <p class="section-label">Keyword Strategy</p>
      <h2 class="section-h2">Searches <?= htmlspecialchars($_name) ?> families make</h2>
      <div class="kw-grid">
        <?php foreach ($C['keywords'] as $k): ?>
        <div class="kw-card"><div class="kw-term"><?= htmlspecialchars($k[0]) ?></div><div class="kw-intent"><?= htmlspecialchars($k[1]) ?></div></div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- IDEAS -->
<section class="ideas-section" id="ideas">
  <div class="container">
    <div data-reveal style="max-width:760px">
      <p class="section-label">Marketing Ideas</p>
      <h2 class="section-h2"><?= count($C['ideas']) ?> marketing ideas for <?= htmlspecialchars($_name) ?> home care agencies</h2>
      <p class="lede">Practical strategies you can start on this month, whether you work with us or not.</p>
    </div>
    <div class="ideas-grid" data-reveal style="transition-delay:.1s">
      <?php foreach ($C['ideas'] as $i => $idea): ?>
      <div class="idea-card">
        <div class="idea-num"><?= str_pad($i + 1, 2, '0', STR_PAD_LEFT) ?></div>
        <h3><?= htmlspecialchars($idea[0]) ?></h3>
        <p><?= htmlspecialchars($idea[1]) ?></p>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- SERVICES -->
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
      <p class="lede">Real lead dashboards from our client campaigns, including a Florida home care agency.</p>
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
      <h2 class="section-h2"><?= htmlspecialchars($_name) ?> home care marketing:<br><em>questions agency owners ask</em></h2>
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

<!-- OTHER LOCATIONS -->
<section class="states-section">
  <div class="container">
    <p class="section-label">Other Florida Cities</p>
    <div class="states-row">
      <?php foreach ($_cities as $k => $ct): if ($k === $city_key) continue; ?>
      <a href="/home-care-agency-seo-<?= htmlspecialchars($k) ?>-fl/"><?= htmlspecialchars($ct['name']) ?></a>
      <?php endforeach; ?>
    </div>
    <p class="section-label" style="margin-top:32px">Other States We Serve</p>
    <div class="states-row">
      <?php foreach ($_states as $k => $st): ?>
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
      <p class="cta-sub">In a free audit we'll show you where you rank across <?= htmlspecialchars($C['county']) ?>, what your top competitors do better, and the changes that would bring in the most inquiries.</p>
      <button class="cta-pill-btn" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Get Your Free Marketing Audit</button>
    </div>
  </div>
</section>

<?php include __DIR__ . '/footer.php'; ?>
