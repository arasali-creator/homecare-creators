<?php
// Shared template for /home-care-agency-marketing-{state}/ pages.
// Each state's index.php sets $state_key and includes this file.
// State-specific content lives in includes/state-pages-data.php.
require_once __DIR__ . '/location-sections.php';
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

$_pct = (float)$S['pct65'];
$_cmp = $_pct >= 18.5 ? 'above' : ($_pct <= 17.5 ? 'below' : 'close to');
$_m = array_map(fn($x) => $x[0], $S['metros']);
$_qa_q = "How do you market a home care agency in {$_name}?";
$_qa_a = "Focus on three things: rank in the Google Maps pack for the areas you actually staff (for example {$S['example_areas'][0]}, {$S['example_areas'][1]}, {$S['example_areas'][2]} or {$S['example_areas'][3]}), make your {$S['license_short']} and caregiver quality obvious on your website and Google profile, and follow up on every inquiry within minutes. {$S['pct65']}% of {$_name} residents are 65 or older, {$_cmp} the U.S. average of 18.0%, so demand is there. The agencies that win are the easiest to find and to trust online.";

// State FAQs first, then shared ones with real pricing.
$_faqs = array_merge($S['faqs'], [
    ["Which directories should a {$_name} home care agency be listed in?", "Start with the {$S['association']} member directory, then Google Business Profile, Bing Places, Apple Business Connect, Caring.com, Care.com, the Better Business Bureau and your local chamber of commerce. Keep your business name, address and phone number identical everywhere."],
    ["How do I get more private-pay clients in {$_name}?", "Rank in Google Maps for the areas you staff, show your {$S['license_short']} and caregiver quality clearly, collect detailed reviews, give honest pricing guidance and respond to every inquiry within minutes. {$S['pct65']}% of {$_name} residents are 65 or older, so demand is steady; visibility and trust decide who gets the call."],
    ["How much does home care agency marketing cost in {$_name}?", "Our home care SEO plans start at \$697 per month (Starter), with Care Plus at \$1,097 and Care Advanced at \$1,597 per month. The right plan depends on how many cities you serve and how competitive your market is. We'll recommend one after a free audit."],
    ["How long does home care SEO take to show results?", "Most agencies see Google Maps and search movement within a few months, with stronger results building over 4 to 6 months. Paid ads can bring inquiries sooner while SEO builds. No honest agency can guarantee rankings."],
    ["Can you help my agency show up in ChatGPT and Google AI Overviews?", "Yes. We structure your website content, FAQs, schema and business information so AI tools can understand what you do and where you operate. Inclusion can't be guaranteed, but clear, specific information makes it far more likely."],
]);

$page_css = require __DIR__ . '/location-page-css.php';
$skip_db_page_schema = true; // this template outputs its own schema
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
        hc_loc_webpage_schema($page_canonical, $page_title),
        hc_loc_author_schema(),
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

<?php
hc_loc_toc(['quick-answer' => 'Quick answer', 'state' => 'Licensing & funding', 'cities' => 'Key markets', 'playbook' => 'Playbook', 'ideas' => 'Marketing ideas', 'results' => 'Results', 'faq' => 'FAQ']);
hc_loc_quick_answer($_qa_q, $_qa_a, [
    [$S['pct65'] . '%', "of {$_name} residents are 65 or older", 'U.S. Census Bureau, 2024 estimates'],
    ['18.0%', 'U.S. average, for comparison', 'U.S. Census Bureau, 2024 estimates'],
    ['$697/mo', 'Our home care SEO plans start at', ''],
]);
?>

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

<?php hc_loc_playbook([
    'place' => $_name,
    'areas' => $S['example_areas'],
    'association' => $S['association'],
    'regulator_line' => "In {$_name}, that includes explaining your {$S['license_short']} in plain language.",
]); ?>

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

<?php
hc_loc_reading(['local-seo-home-care-agency-google-maps', 'google-business-profile-checklist-home-care', 'home-care-agency-ai-search-chatgpt-optimization']);
hc_loc_author(array_merge([hc_loc_src_census(), hc_loc_src_assoc()], $S['sources'] ?? []));
?>

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
