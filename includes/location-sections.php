<?php
// Shared section renderers for location pages (states, Florida SEO cities,
// Florida web-design cities). Templates call these with location-specific data
// so the structure stays consistent while the content stays local.
// Note: the function names are prefixed hc_loc_ to avoid collisions with admin helpers.

if (!function_exists('hc_loc_e')) {
function hc_loc_e($s) { return htmlspecialchars((string)$s, ENT_QUOTES, 'UTF-8'); }
}

// Date shown in the author box and used for dateModified.
if (!defined('HC_LOC_UPDATED_ISO')) {
    define('HC_LOC_UPDATED_ISO', '2026-11-11');
    define('HC_LOC_UPDATED_HUMAN', 'November 11, 2026');
}

// Blog posts used in "Further reading". slug => title
function hc_loc_posts(): array {
    return [
        'local-seo-home-care-agency-google-maps'          => 'Local SEO for home care agencies: how to rank on Google Maps',
        'google-business-profile-checklist-home-care'     => 'Google Business Profile checklist for home care agencies',
        'google-reviews-home-care-agency'                 => 'How to get more Google reviews for your home care agency',
        'why-home-care-agency-not-showing-up-google'      => 'Why your home care agency isn\'t showing up on Google',
        'home-care-agency-ai-search-chatgpt-optimization' => 'How to get your agency recommended by ChatGPT and AI search',
        'private-pay-home-care-clients-florida'           => 'How to get more private-pay home care clients in Florida',
        'home-care-website-design-must-haves'             => 'Home care website design: the must-haves',
        'home-care-website-design-vs-generic-website'     => 'Home care website vs a generic website',
        'home-care-agency-marketing-mistakes'             => 'Home care agency marketing mistakes to avoid',
    ];
}

function hc_loc_toc(array $items): void { ?>
<nav class="loc-toc" aria-label="On this page">
  <div class="container">
    <span class="loc-toc-label">On this page:</span>
    <?php foreach ($items as $id => $label): ?><a href="#<?= hc_loc_e($id) ?>"><?= hc_loc_e($label) ?></a><?php endforeach; ?>
  </div>
</nav>
<?php }

function hc_loc_quick_answer(string $question, string $answer, array $stats): void { ?>
<section class="loc-qa" id="quick-answer">
  <div class="container">
    <div class="loc-qa-box" data-reveal>
      <div class="loc-qa-label"><i class="fa-solid fa-bolt"></i> Quick answer</div>
      <h2 class="loc-qa-q"><?= hc_loc_e($question) ?></h2>
      <p class="loc-qa-a"><?= hc_loc_e($answer) ?></p>
      <?php if ($stats): ?>
      <div class="loc-stats">
        <?php foreach ($stats as $s): ?>
        <div class="loc-stat">
          <div class="loc-stat-num"><?= hc_loc_e($s[0]) ?></div>
          <div class="loc-stat-label"><?= hc_loc_e($s[1]) ?></div>
          <?php if (!empty($s[2])): ?><div class="loc-stat-src"><?= hc_loc_e($s[2]) ?></div><?php endif; ?>
        </div>
        <?php endforeach; ?>
      </div>
      <?php endif; ?>
    </div>
  </div>
</section>
<?php }

/**
 * 5-step local SEO playbook with concrete, location-filled examples.
 * $p = [place, areas(array), regulator_line, association, directories(optional array)]
 */
function hc_loc_playbook(array $p): void {
    $place = $p['place']; $areas = array_slice($p['areas'], 0, 4); $a0 = $areas[0] ?? $place;
    $titles = ['Fix your Google Business Profile', 'Build one useful page per area', 'Collect reviews that name the town', 'Get listed where families look', 'Answer families\' questions']; ?>
<section class="loc-playbook" id="playbook">
  <div class="container pb-grid">
    <div class="pb-intro" data-reveal>
      <p class="section-label">Step-by-Step</p>
      <h2 class="section-h2">A 5-step local SEO playbook for <em><?= hc_loc_e($place) ?></em> home care agencies</h2>
      <p class="pb-lede">This is the exact order we work in for agencies in <?= hc_loc_e($place) ?>. Follow it yourself, or let us do it for you.</p>
      <ol class="pb-summary">
        <?php foreach ($titles as $i => $t): ?><li><span><?= $i + 1 ?></span><?= hc_loc_e($t) ?></li><?php endforeach; ?>
      </ol>
      <button class="pb-cta" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Have us do it for you</button>
    </div>
    <ol class="pb-steps" data-reveal style="transition-delay:.1s">
      <li class="pb-step">
        <div class="pb-num">01</div>
        <div class="pb-body">
          <h3>Fix your Google Business Profile</h3>
          <p>Use your real business name (no extra keywords), choose the most accurate primary category for the care you provide, list every service, and set your service areas to the places you actually staff.</p>
          <div class="pb-example"><span>Example service areas</span><?= hc_loc_e(implode(' · ', $areas)) ?></div>
        </div>
      </li>
      <li class="pb-step">
        <div class="pb-num">02</div>
        <div class="pb-body">
          <h3>Build one useful page per area you serve</h3>
          <p>Each page should cover the services you offer there, how fast you can start, caregiver availability and real local details. Changing only the place name doesn't work.</p>
          <div class="pb-example"><span>Example title tag</span>Home Care in <?= hc_loc_e($a0) ?> | 24-Hour &amp; Companion Care | [Your Agency]</div>
        </div>
      </li>
      <li class="pb-step">
        <div class="pb-num">03</div>
        <div class="pb-body">
          <h3>Ask every family for a review that names their town</h3>
          <p>Reviews are one of the strongest local ranking signals, and reviews that mention a town help you rank in that town. Ask after the first two weeks of care, when families are happiest.</p>
          <div class="pb-example"><span>Example request</span>"Thank you for trusting us with your mom's care in <?= hc_loc_e($a0) ?>. Would you share a quick Google review about your experience? It helps other families nearby find us."</div>
        </div>
      </li>
      <li class="pb-step">
        <div class="pb-num">04</div>
        <div class="pb-body">
          <h3>Get listed where families and Google look</h3>
          <p>Consistent name, address and phone details across trusted directories build confidence with Google. Start with these:</p>
          <ul class="pb-list">
            <?php foreach (array_merge([$p['association'] . ' (member directory)'], $p['directories'] ?? [], ['Caring.com', 'Care.com', 'Bing Places & Apple Business Connect', 'Better Business Bureau', 'Your local chamber of commerce']) as $d): ?>
            <li><i class="fa-solid fa-circle-check"></i><?= hc_loc_e($d) ?></li>
            <?php endforeach; ?>
          </ul>
        </div>
      </li>
      <li class="pb-step">
        <div class="pb-num">05</div>
        <div class="pb-body">
          <h3>Answer the questions families ask, in plain language</h3>
          <p>Publish clear answers on cost, licensing, what Medicaid or insurance covers and how to start care. <?= hc_loc_e($p['regulator_line']) ?> Clear answers also make it easier for AI tools like ChatGPT and Google AI Overviews to recommend you.</p>
        </div>
      </li>
    </ol>
  </div>
</section>
<?php }

// Blog post thumbnails for "Further reading" cards.
function hc_loc_post_img(string $slug): string {
    $m = [
        'local-seo-home-care-agency-google-maps' => '/images/blog/inline-analytics.jpg',
        'google-business-profile-checklist-home-care' => '/images/blog/inline-optimization-checklist.jpg',
        'google-reviews-home-care-agency' => '/images/blog/blog-google-reviews.jpg',
        'why-home-care-agency-not-showing-up-google' => '/images/blog/inline-seo-laptop.jpg',
        'home-care-agency-ai-search-chatgpt-optimization' => '/images/blog/inline-ai-content-strategy.jpg',
        'private-pay-home-care-clients-florida' => '/images/blog/blog-seo-google.jpg',
        'home-care-website-design-must-haves' => '/images/blog/blog-website-design.jpg',
        'home-care-website-design-vs-generic-website' => '/images/home/service-website-dev.jpg',
        'home-care-agency-marketing-mistakes' => '/images/blog/blog-marketing.jpg',
    ];
    return $m[$slug] ?? '/images/blog/blog-marketing.jpg';
}

/** Guides (left) + author card (right) in one section. */
function hc_loc_trust(array $slugs, array $sources): void {
    $posts = hc_loc_posts(); ?>
<section class="loc-trust" id="reading">
  <div class="container loc-trust-grid">
    <div data-reveal>
      <p class="section-label">Free Guides</p>
      <h2 class="section-h2 loc-trust-h2">Keep learning</h2>
      <div class="loc-guides">
        <?php foreach ($slugs as $sl): if (!isset($posts[$sl])) continue; ?>
        <a class="loc-guide" href="/blog/<?= hc_loc_e($sl) ?>">
          <img src="<?= hc_loc_e(hc_loc_post_img($sl)) ?>" alt="" loading="lazy">
          <div class="loc-guide-body">
            <span class="loc-guide-tag">Guide</span>
            <span class="loc-guide-title"><?= hc_loc_e($posts[$sl]) ?></span>
            <span class="loc-guide-more">Read the guide <i class="fa-solid fa-arrow-right"></i></span>
          </div>
        </a>
        <?php endforeach; ?>
      </div>
    </div>
    <aside class="loc-author-card" id="about-author" data-reveal style="transition-delay:.1s">
      <div class="loc-author-top">
        <img src="/images/team/asifa-rani-founder-ceo.jpg" alt="Asifa Rani, Founder and CEO of Homecare Creators" width="96" height="96" loading="lazy">
        <div>
          <div class="loc-author-meta">Written &amp; reviewed by</div>
          <div class="loc-author-name"><a href="/about/">Asifa Rani</a></div>
          <div class="loc-author-role">Founder &amp; CEO, Homecare Creators</div>
        </div>
      </div>
      <p class="loc-author-bio">Asifa leads every client strategy at Homecare Creators, a marketing agency that works only with home care and senior care providers.</p>
      <div class="loc-author-pills">
        <span class="loc-pill"><i class="fa-regular fa-calendar"></i>Updated <time datetime="<?= HC_LOC_UPDATED_ISO ?>"><?= HC_LOC_UPDATED_HUMAN ?></time></span>
        <a class="loc-pill loc-pill-link" href="https://www.linkedin.com/in/asifa-rani/" target="_blank" rel="noopener"><i class="fa-brands fa-linkedin-in"></i>LinkedIn</a>
      </div>
      <?php if ($sources): ?>
      <details class="loc-sources">
        <summary><i class="fa-solid fa-book"></i>Sources (<?= count($sources) ?>)</summary>
        <ul>
          <?php foreach ($sources as $src): ?>
          <li><a href="<?= hc_loc_e($src[1]) ?>" target="_blank" rel="noopener"><?= hc_loc_e($src[0]) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </details>
      <?php endif; ?>
    </aside>
  </div>
</section>
<?php }

/**
 * "Where we work": US tile map (served states clickable, current highlighted)
 * + link cards. Optional Florida city links.
 * $o = ['current' => state key | 'florida', 'cities' => [[label, url, isCurrent], ...], 'cities_title' => string]
 */
function hc_loc_coverage(array $o): void {
    $states = require __DIR__ . '/state-pages-data.php';
    $served = ['FL' => ['Florida', '/areas-we-serve/', 'florida']];
    foreach ($states as $k => $st) $served[$st['abbr']] = [$st['name'], "/home-care-agency-marketing-{$k}/", $k];
    ksort($served);
    $cur = $o['current'] ?? '';
    // Tile-grid layout: abbr => [col, row]
    $grid = ['AK'=>[0,0],'ME'=>[11,0],'VT'=>[10,1],'NH'=>[11,1],
      'WA'=>[1,2],'ID'=>[2,2],'MT'=>[3,2],'ND'=>[4,2],'MN'=>[5,2],'IL'=>[6,2],'WI'=>[7,2],'MI'=>[8,2],'NY'=>[9,2],'RI'=>[10,2],'MA'=>[11,2],
      'OR'=>[1,3],'NV'=>[2,3],'WY'=>[3,3],'SD'=>[4,3],'IA'=>[5,3],'IN'=>[6,3],'OH'=>[7,3],'PA'=>[8,3],'NJ'=>[9,3],'CT'=>[10,3],
      'CA'=>[1,4],'UT'=>[2,4],'CO'=>[3,4],'NE'=>[4,4],'MO'=>[5,4],'KY'=>[6,4],'WV'=>[7,4],'VA'=>[8,4],'MD'=>[9,4],'DE'=>[10,4],
      'AZ'=>[2,5],'NM'=>[3,5],'KS'=>[4,5],'AR'=>[5,5],'TN'=>[6,5],'NC'=>[7,5],'SC'=>[8,5],'DC'=>[9,5],
      'OK'=>[4,6],'LA'=>[5,6],'MS'=>[6,6],'AL'=>[7,6],'GA'=>[8,6],
      'HI'=>[1,7],'TX'=>[4,7],'FL'=>[9,7]]; ?>
<section class="loc-coverage" id="where-we-work">
  <div class="container cov-grid">
    <div class="cov-text" data-reveal>
      <p class="section-label">Where We Work</p>
      <h2 class="section-h2">Home care marketing in <em><?= count($served) ?> states</em></h2>
      <p class="lede">We're based in Lady Lake, Florida, and work with home care agencies across the U.S. Each state page covers local licensing, funding programs, key markets and marketing ideas.</p>
      <div class="cov-links">
        <?php foreach ($served as $ab => $sv): $isCur = ($sv[2] === $cur); ?>
        <a class="cov-link<?= $isCur ? ' is-current' : '' ?>" href="<?= hc_loc_e($sv[1]) ?>"<?= $isCur ? ' aria-current="page"' : '' ?>><span class="cov-abbr"><?= $ab ?></span><?= hc_loc_e($sv[0]) ?><i class="fa-solid fa-arrow-right"></i></a>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="cov-map-wrap" data-reveal style="transition-delay:.1s">
      <div class="cov-map" role="img" aria-label="Map of U.S. states where Homecare Creators works">
        <?php foreach ($grid as $ab => $pos):
            $col = $pos[0] + 1; $row = $pos[1] + 1;
            $style = "grid-column:{$col};grid-row:{$row}";
            if (isset($served[$ab])):
                $isCur = ($served[$ab][2] === $cur); ?>
        <a class="cov-tile is-served<?= $isCur ? ' is-current' : '' ?>" style="<?= $style ?>" href="<?= hc_loc_e($served[$ab][1]) ?>" title="<?= hc_loc_e($served[$ab][0]) ?>"><?= $ab ?></a>
            <?php else: ?>
        <span class="cov-tile" style="<?= $style ?>" aria-hidden="true"><?= $ab ?></span>
            <?php endif; endforeach; ?>
      </div>
      <div class="cov-legend">
        <span><i class="cov-key is-current"></i>This page</span>
        <span><i class="cov-key is-served"></i>States we serve</span>
        <span><i class="cov-key"></i>Other states</span>
      </div>
    </div>
  </div>
  <?php if (!empty($o['cities'])): ?>
  <div class="container cov-cities" data-reveal>
    <h3 class="cov-cities-title"><?= hc_loc_e($o['cities_title'] ?? 'Florida cities') ?></h3>
    <div class="cov-city-grid">
      <?php foreach ($o['cities'] as $c): ?>
      <a class="cov-city<?= !empty($c[2]) ? ' is-current' : '' ?>" href="<?= hc_loc_e($c[1]) ?>"<?= !empty($c[2]) ? ' aria-current="page"' : '' ?>><i class="fa-solid fa-location-dot"></i><?= hc_loc_e($c[0]) ?></a>
      <?php endforeach; ?>
    </div>
  </div>
  <?php endif; ?>
</section>
<?php }

// Person node for schema (used as WebPage author).
function hc_loc_author_schema(): array {
    return [
        "@type" => "Person", "@id" => "https://homecarecreators.com/about/#founder",
        "name" => "Asifa Rani", "jobTitle" => "Founder & CEO",
        "url" => "https://homecarecreators.com/about/",
        "image" => "https://homecarecreators.com/images/team/asifa-rani-founder-ceo.jpg",
        "sameAs" => ["https://www.linkedin.com/in/asifa-rani/"],
        "worksFor" => ["@id" => "https://homecarecreators.com/#organization"],
    ];
}

function hc_loc_webpage_schema(string $url, string $title): array {
    return [
        "@type" => "WebPage", "url" => $url, "name" => $title, "inLanguage" => "en-US",
        "author" => ["@id" => "https://homecarecreators.com/about/#founder"],
        "dateModified" => HC_LOC_UPDATED_ISO,
    ];
}

// Common sources
function hc_loc_src_census(): array { return ["America's Health Rankings: population age 65+ by state (U.S. Census Bureau 2024 estimates)", "https://www.americashealthrankings.org/explore/measures/pct_65plus"]; }
function hc_loc_src_assoc(): array { return ["Alliance for Care at Home: Assembly of State Associations", "https://allianceforcareathome.org/state-associations"]; }
