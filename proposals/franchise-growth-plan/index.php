<?php
// Private proposal page — not linked anywhere, not in the sitemap, and kept out of search engines.
header('X-Robots-Tag: noindex, nofollow, noarchive', true);
$page_canonical = "https://homecarecreators.com/proposals/franchise-growth-plan/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title   = "Franchise Growth Plan for 3 Territories | Homecare Creators";
$page_desc    = "Local SEO and AI Search SEO proposal for 3 franchise territories.";
$page_noindex = true;

$growth = [
    'Google Maps & Reviews' => ['Full Google Business Profile optimization', '8 profile posts + 5 photos a month', 'Services, Q&A and holiday hours kept updated', 'Apple Maps & Bing Places optimization', 'Review generation system with QR cards', 'Replies to every review within 48 hours', 'Spam and fake competitor listings reported'],
    'Citations, Links & Content' => ['50+ directory listings, duplicates fixed', '4 backlinks a month (DA 25–40)', '2 blogs + 1 blog refresh a month'],
    'AI Search SEO' => ['Schema and entity setup', '2 AI-ready FAQ pages a month', '25 family questions tracked in ChatGPT, Google AI & Perplexity'],
    'Tracking & Reporting' => ['Call tracking per territory', '20 keywords tracked', 'Monthly report per territory'],
];
$premium = [
    'Everything in Growth, plus' => ['12 profile posts a month', '4 blogs + 2 blog refreshes a month', '6 backlinks a month (DA 40+)', 'Referral partner listings (senior centers, community groups)', 'Caregiver recruitment posts + job listing optimization', 'Review sentiment insights', 'Quarterly citation audit'],
    'Advanced AI Search SEO' => ['50 family questions tracked', '4 AI-ready pages a month', '3 outside mentions a month', 'Gemini & Copilot tracking', 'See who AI recommends instead of you'],
    'Strategy & Support' => ['Top 3 competitor tracking', 'Maps ranking grid, 50 keywords', 'Dedicated account manager', 'Monthly strategy call + quarterly review', 'Priority support'],
];
$Y = '<i class="fa-solid fa-check"></i>';
$scope = [
    'Research & Setup' => [
        ['Keyword research', '10 keywords', '15 keywords'],
        ['Keyword intent mapping', 'Advanced', 'Full funnel'],
        ['Competitor analysis', '2 competitors', '2 competitors'],
        ['Google Analytics 4 + Search Console', $Y, $Y],
        ['Bing Webmaster Tools + Tag Manager', $Y, $Y],
    ],
    'Website SEO*' => [
        ['Pages optimized', '4', '6'],
        ['Meta titles, descriptions, headers, URLs', $Y, $Y],
        ['Internal linking', 'Advanced', 'Topic clusters'],
        ['Conversion CTA alignment', $Y, $Y],
    ],
    'Technical SEO*' => [
        ['Crawl & index audit', 'Monthly', 'Monthly'],
        ['Page speed + Core Web Vitals', 'Advanced', 'Under 5 seconds'],
        ['Redirect & canonical fixes', 'Moderate', 'Extensive'],
        ['Sitemap + robots.txt', $Y, $Y],
        ['Schema markup', 'Local + FAQ', 'Local + FAQ + Review + Service'],
    ],
    'AI Search SEO' => [
        ['llms.txt file', 'Basic', 'Detailed'],
        ['Advanced custom schema', $Y, $Y],
    ],
    'Content' => [
        ['Blogs per month', '2 (1,200–1,500 words)', '4 (1,200–1,500 words)'],
        ['Old blog refresh', '1 a month', '2 a month'],
        ['Keyword targeting', 'Primary + secondary', 'Topic clusters'],
        ['Community posts', '2 a month', '5 a month'],
    ],
    'Authority' => [
        ['Backlinks per month', '4 (DA 25–40)', '6 (DA 40+)'],
        ['Toxic link audit', $Y, $Y],
    ],
];

$page_css = <<<CSS
body{background:#f5f2ec}
.pp{font-family:'DM Sans',sans-serif;color:#1a1a14}
.pp h1,.pp h2,.pp h3{font-family:'Plus Jakarta Sans',sans-serif;color:var(--forest);letter-spacing:-.02em}
.pp-wrap{max-width:1040px;margin:0 auto;padding:0 24px}

/* cover */
.pp-cover{background:var(--forest);padding:150px 0 110px;position:relative;overflow:hidden}
.pp-cover::before{content:"";position:absolute;inset:0;background:radial-gradient(700px 400px at 85% 10%,rgba(46,198,143,.14),transparent 60%)}
.pp-cover .pp-wrap{position:relative}
.pp-logo{height:64px;margin-bottom:56px;display:block}
.pp-cover h1{color:#fff;font-size:clamp(38px,5.4vw,64px);font-weight:800;line-height:1.05;margin-bottom:18px}
.pp-cover h1 span{display:block;color:var(--teal-lt)}
.pp-cover p{color:rgba(255,255,255,.75);font-size:19px;line-height:1.6;max-width:560px;margin-bottom:34px}
.pp-pills{display:flex;flex-wrap:wrap;gap:10px}
.pp-pills span{border:1.5px solid var(--teal-lt);color:var(--teal-lt);border-radius:100px;padding:9px 18px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:14px}

.pp-sec{padding:84px 0;border-bottom:1px solid rgba(10,46,30,.08)}
.pp-sec:nth-of-type(even){background:#fff}
.pp-h{margin-bottom:34px}
.pp-h h2{font-size:clamp(28px,3.4vw,40px);font-weight:800;margin-bottom:8px}
.pp-h p{font-size:17px;color:#6b7b6e}

/* packages */
.pk{display:grid;grid-template-columns:1fr 1fr;gap:22px;align-items:start}
.pk-c{background:#fff;border:1.5px solid rgba(10,46,30,.12);border-radius:22px;padding:32px}
.pk-c.rec{border:2px solid var(--teal-lt);box-shadow:0 0 0 6px rgba(46,198,143,.12)}
.pk-tag{display:inline-block;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase;border-radius:100px;padding:6px 14px;margin-bottom:18px}
.pk-c.rec .pk-tag{background:var(--teal-lt);color:var(--forest)}
.pk-c.max .pk-tag{background:var(--forest);color:var(--teal-lt)}
.pk-c h3{font-size:26px;font-weight:800;margin-bottom:6px}
.pk-price{font-family:'Plus Jakarta Sans',sans-serif;font-size:48px;font-weight:800;color:var(--forest);letter-spacing:-.03em;line-height:1.1;margin-bottom:22px}
.pk-price small{font-size:15px;font-weight:500;color:#6b7b6e;letter-spacing:0}
.pk-g h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:800;letter-spacing:1.2px;text-transform:uppercase;color:var(--teal);margin:18px 0 8px}
.pk-g ul{list-style:none;margin:0;padding:0}
.pk-g li{display:flex;gap:10px;font-size:15px;line-height:1.45;padding:4px 0;color:#2b342f}
.pk-g li i{color:var(--teal);font-size:12px;margin-top:5px}

/* tables */
.tb{width:100%;border-collapse:collapse;background:#fff;border-radius:16px;overflow:hidden;font-size:15px}
.tb thead th{background:var(--forest);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;padding:16px 18px;text-align:center}
.tb thead th:first-child{text-align:left}
.tb td{padding:13px 18px;border-bottom:1px solid rgba(10,46,30,.08);text-align:center;color:#2b342f}
.tb td:first-child{text-align:left}
.tb td i{color:var(--teal)}
.tb tr.grp td{background:#e3f4ec;color:var(--teal);font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:12.5px;letter-spacing:1.2px;text-transform:uppercase;text-align:left}
.tb.money td,.tb.money th{text-align:right}
.tb.money td:first-child,.tb.money th:first-child{text-align:left}
.tb tr.total td{background:#e3f4ec;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:17px;color:var(--forest)}
.tb tr.save td{color:var(--teal);font-size:14px}
.tb .off{color:var(--teal)}
.tb + .tb{margin-top:20px}
.pp-note{font-size:13px;color:#6b7b6e;margin-top:16px;line-height:1.6}
.pp-terms{background:#eaf3ee;border-radius:16px;padding:22px 26px;margin-top:22px;list-style:none}
.pp-terms li{display:flex;gap:12px;font-size:15.5px;padding:4px 0}
.pp-terms li i{color:var(--teal);margin-top:4px;font-size:13px}

/* timeline */
.tl{display:grid;grid-template-columns:repeat(4,1fr);gap:14px}
.tl div{background:#eaf3ee;border-radius:16px;padding:22px}
.tl b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:800;letter-spacing:1.2px;color:var(--teal);margin-bottom:10px}
.tl p{font-size:15.5px;line-height:1.5;color:#2b342f}
.why{margin:40px 0 0}
.why h3{font-size:24px;font-weight:800;margin-bottom:14px}
.why li{display:flex;gap:12px;font-size:16.5px;padding:5px 0}
.why li i{color:var(--teal);margin-top:5px;font-size:13px}
.cta{background:var(--forest);border-radius:20px;padding:40px;margin-top:40px}
.cta h2{color:#fff;font-size:30px;font-weight:800;margin-bottom:10px}
.cta p{color:rgba(255,255,255,.85);font-size:17px;margin-bottom:18px}
.cta p b{color:#fff}
.cta-links{display:flex;flex-wrap:wrap;gap:8px 18px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:16px}
.cta-links a{color:var(--teal-lt);text-decoration:none}
.cta-links a:hover{text-decoration:underline}
.pp-dis{font-size:13px;color:#6b7b6e;margin-top:18px;line-height:1.6}

@media(max-width:860px){
  .pk{grid-template-columns:1fr}
  .tl{grid-template-columns:1fr 1fr}
  .tb{font-size:13.5px}
  .tb td,.tb thead th{padding:11px 10px}
}
@media(max-width:560px){
  .pp-cover{padding:120px 0 72px}
  .pp-logo{height:48px;margin-bottom:36px}
  .tl{grid-template-columns:1fr}
  .pk-c{padding:24px}
  .pk-price{font-size:40px}
  .tb-scroll{overflow-x:auto;margin:0 -24px;padding:0 24px}
  .tb-scroll .tb{min-width:520px}
  .cta{padding:28px}
}
@media print{
  nav,footer,#scrollProgress{display:none!important}
  .pp-cover{padding:60px 0}
  .pp-sec{break-inside:avoid;padding:40px 0}
}
CSS;
include '../../includes/header.php';
?>
<div id="scrollProgress"></div>
<div class="pp">

  <!-- COVER -->
  <section class="pp-cover">
    <div class="pp-wrap">
      <img class="pp-logo" src="/images/home/homecarecreators-logo.png" alt="Homecare Creators">
      <h1>Franchise Growth Plan <span>for 3 Territories</span></h1>
      <p>Local SEO and AI Search SEO to get every territory found by more families.</p>
      <div class="pp-pills"><span>Google Maps</span><span>Reviews</span><span>Citations</span><span>Local Content</span><span>AI Search</span></div>
    </div>
  </section>

  <!-- PACKAGES -->
  <section class="pp-sec">
    <div class="pp-wrap">
      <div class="pp-h"><h2>Choose your package</h2><p>Priced per territory. Both include Local SEO and AI Search SEO.</p></div>
      <div class="pk">
        <div class="pk-c rec">
          <span class="pk-tag">Recommended</span>
          <h3>Growth</h3>
          <div class="pk-price">$1,397 <small>/mo per territory</small></div>
          <div class="pk-g">
            <?php foreach ($growth as $g => $items): ?>
            <h4><?= htmlspecialchars($g) ?></h4>
            <ul><?php foreach ($items as $it): ?><li><i class="fa-solid fa-check"></i><span><?= htmlspecialchars($it) ?></span></li><?php endforeach ?></ul>
            <?php endforeach ?>
          </div>
        </div>
        <div class="pk-c max">
          <span class="pk-tag">Maximum Growth</span>
          <h3>Premium</h3>
          <div class="pk-price">$1,997 <small>/mo per territory</small></div>
          <div class="pk-g">
            <?php foreach ($premium as $g => $items): ?>
            <h4><?= htmlspecialchars($g) ?></h4>
            <ul><?php foreach ($items as $it): ?><li><i class="fa-solid fa-check"></i><span><?= htmlspecialchars($it) ?></span></li><?php endforeach ?></ul>
            <?php endforeach ?>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- FULL SCOPE -->
  <section class="pp-sec">
    <div class="pp-wrap">
      <div class="pp-h"><h2>Full scope, side by side</h2><p>On top of the Google Maps, reviews and AI search work above.</p></div>
      <div class="tb-scroll">
        <table class="tb">
          <thead><tr><th>Per territory</th><th>Growth</th><th>Premium</th></tr></thead>
          <tbody>
          <?php foreach ($scope as $grp => $rows): ?>
            <tr class="grp"><td colspan="3"><?= htmlspecialchars($grp) ?></td></tr>
            <?php foreach ($rows as $r): ?><tr><td><?= htmlspecialchars($r[0]) ?></td><td><?= $r[1] === $Y ? $Y : htmlspecialchars($r[1]) ?></td><td><?= $r[2] === $Y ? $Y : htmlspecialchars($r[2]) ?></td></tr><?php endforeach ?>
          <?php endforeach ?>
          </tbody>
        </table>
      </div>
      <p class="pp-note">*Website and technical work is done on pages your franchisor allows you to edit. If corporate controls your site, we prepare the changes for approval. Add-ons: voice search optimization ($100/mo), log file analysis and entity optimization (quoted on request).</p>
    </div>
  </section>

  <!-- INVESTMENT -->
  <section class="pp-sec">
    <div class="pp-wrap">
      <div class="pp-h"><h2>Your investment</h2><p>20% off every extra territory.</p></div>
      <div class="tb-scroll">
        <table class="tb money">
          <thead><tr><th>Monthly</th><th>Growth</th><th>Premium</th></tr></thead>
          <tbody>
            <tr><td>Territory 1</td><td>$1,397.00</td><td>$1,997.00</td></tr>
            <tr><td>Territory 2 <span class="off">(20% off)</span></td><td>$1,117.60</td><td>$1,597.60</td></tr>
            <tr><td>Territory 3 <span class="off">(20% off)</span></td><td>$1,117.60</td><td>$1,597.60</td></tr>
            <tr class="total"><td>Total per month</td><td>$3,632.20</td><td>$5,192.20</td></tr>
            <tr class="save"><td>You save every month</td><td>$558.80</td><td>$798.80</td></tr>
          </tbody>
        </table>
        <table class="tb money">
          <thead><tr><th>One-time setup</th><th>Growth</th><th>Premium</th></tr></thead>
          <tbody><tr><td>All 3 territories</td><td>$800.00</td><td>$800.00</td></tr></tbody>
        </table>
        <table class="tb money">
          <thead><tr><th>Optional: Social Media Add-on</th><th>Per territory</th><th>3 territories</th></tr></thead>
          <tbody><tr><td>12–16 Facebook &amp; Instagram posts a month</td><td>$397/mo</td><td>$1,191/mo</td></tr></tbody>
        </table>
      </div>
      <ul class="pp-terms">
        <li><i class="fa-solid fa-check"></i>90 days, then month-to-month</li>
        <li><i class="fa-solid fa-check"></i>Extra discount for annual commitment</li>
        <li><i class="fa-solid fa-check"></i>30-day satisfaction guarantee</li>
      </ul>
    </div>
  </section>

  <!-- 90 DAYS + CTA -->
  <section class="pp-sec">
    <div class="pp-wrap">
      <div class="pp-h"><h2>Your first 90 days</h2><p>Most owners see Google Maps gains in about 30 days.</p></div>
      <div class="tl">
        <div><b>WEEK 1–2</b><p>Audit all 3 territories and build your roadmap</p></div>
        <div><b>DAYS 1–30</b><p>Fix profiles, listings and schema. Launch reviews</p></div>
        <div><b>DAYS 30–90</b><p>Posts, content and AI search work build rankings</p></div>
        <div><b>MONTHLY</b><p>One clear report per territory</p></div>
      </div>

      <div class="why">
        <h3>Why Homecare Creators</h3>
        <ul style="list-style:none;margin:0;padding:0">
        <li><i class="fa-solid fa-check"></i><span><b>Home care only.</b> We know how families choose care.</span></li>
        <li><i class="fa-solid fa-check"></i><span><b>Franchise-friendly.</b> We follow your brand guidelines.</span></li>
        <li><i class="fa-solid fa-check"></i><span><b>A real team.</b> Not just software.</span></li>
        </ul>
      </div>

      <div class="cta">
        <h2>Ready to start?</h2>
        <p>Reply with <b>Growth</b> or <b>Premium</b>, and we'll start your audit within 2 business days.</p>
        <div class="cta-links">
          <a href="tel:+15514307387">+1 (551) 430-7387</a><span style="color:rgba(255,255,255,.4)">·</span>
          <a href="mailto:info@homecarecreators.com?subject=Franchise%20Growth%20Plan">info@homecarecreators.com</a><span style="color:rgba(255,255,255,.4)">·</span>
          <a href="https://homecarecreators.com">homecarecreators.com</a>
        </div>
      </div>
      <p class="pp-dis">Prices in USD. AI search placement can't be guaranteed by any agency; we track and report progress monthly. Homecare Creators is not affiliated with any franchisor.</p>
    </div>
  </section>

</div>
<?php include '../../includes/footer.php'; ?>
