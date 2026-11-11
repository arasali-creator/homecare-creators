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
 * $p = [place, places(array of 3+ sub-areas), regulator_line, association, extra_directories(array)]
 */
function hc_loc_playbook(array $p): void {
    $place = $p['place']; $areas = array_slice($p['areas'], 0, 4); $a0 = $areas[0] ?? $place; ?>
<section class="loc-playbook" id="playbook">
  <div class="container">
    <div data-reveal style="max-width:780px">
      <p class="section-label">Step-by-Step</p>
      <h2 class="section-h2">A 5-step local SEO playbook for <?= hc_loc_e($place) ?> home care agencies</h2>
      <p class="lede">This is the order we work in for agencies in <?= hc_loc_e($place) ?>. You can follow it yourself, or we can do it for you.</p>
    </div>
    <ol class="pb-steps" data-reveal style="transition-delay:.1s">
      <li class="pb-step">
        <h3>Fix your Google Business Profile</h3>
        <p>Use your real business name (no extra keywords), choose the most accurate primary category for the care you provide, list every service, and set your service areas to the places you actually staff.</p>
        <div class="pb-example"><span>Example service areas:</span> <?= hc_loc_e(implode(', ', $areas)) ?></div>
      </li>
      <li class="pb-step">
        <h3>Build one useful page per area you serve</h3>
        <p>Each page should cover the services you offer there, how fast you can start, caregiver availability and real local details. Changing only the place name doesn't work.</p>
        <div class="pb-example"><span>Example title tag:</span> Home Care in <?= hc_loc_e($a0) ?> | 24-Hour &amp; Companion Care | [Your Agency]</div>
      </li>
      <li class="pb-step">
        <h3>Ask every family for a review that names their town</h3>
        <p>Reviews are one of the strongest local ranking signals, and reviews that mention a town help you rank in that town. Ask after the first two weeks of care, when families are happiest.</p>
        <div class="pb-example"><span>Example request:</span> "Thank you for trusting us with your mom's care in <?= hc_loc_e($a0) ?>. Would you share a quick Google review about your experience? It helps other families nearby find us."</div>
      </li>
      <li class="pb-step">
        <h3>Get listed where families and Google look</h3>
        <p>Consistent name, address and phone details across trusted directories build confidence with Google. Start with these:</p>
        <ul class="pb-list">
          <?php foreach (array_merge([$p['association'] . ' (member directory)'], $p['directories'] ?? [], ['Caring.com', 'Care.com', 'Bing Places and Apple Business Connect', 'Better Business Bureau', 'Your local chamber of commerce']) as $d): ?>
          <li><i class="fa-solid fa-check"></i><?= hc_loc_e($d) ?></li>
          <?php endforeach; ?>
        </ul>
      </li>
      <li class="pb-step">
        <h3>Answer the questions families ask, in plain language</h3>
        <p>Publish clear answers on cost, licensing, what Medicaid or insurance covers and how to start care. <?= hc_loc_e($p['regulator_line']) ?> Clear answers also make it easier for AI tools like ChatGPT and Google AI Overviews to recommend you.</p>
      </li>
    </ol>
  </div>
</section>
<?php }

function hc_loc_reading(array $slugs): void {
    $posts = hc_loc_posts(); ?>
<section class="loc-reading" id="reading">
  <div class="container">
    <p class="section-label">Further Reading</p>
    <div class="loc-reading-grid">
      <?php foreach ($slugs as $s): if (!isset($posts[$s])) continue; ?>
      <a class="loc-reading-card" href="/blog/<?= hc_loc_e($s) ?>"><i class="fa-solid fa-book-open"></i><span><?= hc_loc_e($posts[$s]) ?></span><i class="fa-solid fa-arrow-right"></i></a>
      <?php endforeach; ?>
    </div>
  </div>
</section>
<?php }

function hc_loc_author(array $sources): void { ?>
<section class="loc-author" id="about-author">
  <div class="container">
    <div class="loc-author-box" data-reveal>
      <img src="/images/team/asifa-rani-founder-ceo.jpg" alt="Asifa Rani, Founder and CEO of Homecare Creators" width="88" height="88" loading="lazy">
      <div>
        <div class="loc-author-meta">Written and reviewed by</div>
        <div class="loc-author-name"><a href="/about/">Asifa Rani</a>, Founder &amp; CEO, Homecare Creators</div>
        <p>Asifa leads every client strategy at Homecare Creators, a marketing agency that works only with home care and senior care providers. <a href="https://www.linkedin.com/in/asifa-rani/" target="_blank" rel="noopener">LinkedIn</a></p>
        <div class="loc-author-date">Last updated: <time datetime="<?= HC_LOC_UPDATED_ISO ?>"><?= HC_LOC_UPDATED_HUMAN ?></time></div>
        <?php if ($sources): ?>
        <details class="loc-sources">
          <summary>Sources</summary>
          <ul>
            <?php foreach ($sources as $s): ?>
            <li><a href="<?= hc_loc_e($s[1]) ?>" target="_blank" rel="noopener"><?= hc_loc_e($s[0]) ?></a></li>
            <?php endforeach; ?>
          </ul>
        </details>
        <?php endif; ?>
      </div>
    </div>
  </div>
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
