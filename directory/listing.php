<?php
$slug = trim($_GET['slug'] ?? '');

require_once '../admin/config.php';
require_once '../admin/includes/db.php';
require_once '../admin/includes/functions.php';
require_once '../admin/includes/directory.php';
require_once '../includes/directory-ui.php';
hc_dir_ensure_schema();

$listing = $slug ? hc_one("SELECT * FROM hc_directory_listings WHERE slug=? AND status='approved'", [$slug]) : null;
if (!$listing) { header('Location: /directory/', true, 302); exit; }

$l        = $listing;
$tier     = hc_dir_tier($l);
$paid     = $tier !== 'free';
$featured = $tier === 'featured';
$services = hc_dir_lines($l['services']);
$areas    = hc_dir_areas($l['service_areas']);
$payments = hc_dir_lines($l['payment_accepted']);
$photos   = $paid ? array_slice(hc_dir_lines($l['photos']), 0, 9) : [];
$claimed  = !empty($l['owner_confirmed_at']); // claimed or claim in progress — hides the claim prompt
$canonical = "https://homecarecreators.com/directory/" . $l['slug'];
$mapQuery  = trim(($l['address'] ? $l['address'] . ', ' : '') . $l['city'] . ', ' . $l['state']);
$phoneHref = preg_replace('/[^0-9+]/', '', (string)$l['phone']);

// Nearby agencies (not on paid profiles — that's a Premium perk)
$nearby = $paid ? [] : hc_all(
    "SELECT * FROM hc_directory_listings WHERE status='approved' AND id<>? AND state=? ORDER BY (city=?) DESC, " . hc_dir_rank_sql() . " DESC, RAND() LIMIT 3",
    [$l['id'], $l['state'], $l['city']]
);

$descText   = $l['description'];
$page_title = $l['company_name'] . ' — Home Care in ' . $l['city'] . ', ' . $l['state'] . ' | Homecare Creators Directory';
$page_desc  = mb_strlen($descText) > 158 ? rtrim(mb_substr($descText, 0, 155)) . '…' : $descText;
$page_canonical = $canonical;
$og_title = $l['company_name'] . ' — Home Care in ' . $l['city'] . ', ' . $l['state'];
$og_desc  = $page_desc;
$og_image = $paid ? ($l['cover_image'] ?: ($l['logo'] ?: null)) : null;

$svcIcons = [
    'Personal Care' => 'fa-hand-holding-heart', 'Companion Care' => 'fa-people-arrows', 'Skilled Nursing' => 'fa-user-nurse',
    'Alzheimer\'s & Dementia Care' => 'fa-brain', '24-Hour Care' => 'fa-clock', 'Live-In Care' => 'fa-house-user',
    'Respite Care' => 'fa-mug-hot', 'Post-Hospital Care' => 'fa-hospital', 'Medication Management' => 'fa-pills',
    'Homemaker Services' => 'fa-broom', 'Transportation' => 'fa-car', 'Hospice Support' => 'fa-dove',
];

$page_css = hc_dir_base_css() . <<<CSS
body{background:#fff}
.lx-cover{height:260px;background:#0f3d28 center/cover no-repeat;margin-top:72px;position:relative}
.lx-cover.is-blank{background-color:var(--forest);background-image:radial-gradient(circle at 18% 120%,rgba(46,198,143,.22),transparent 45%),radial-gradient(circle at 90% -20%,rgba(201,168,76,.16),transparent 40%);height:180px}
.lx-cover::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(0,0,0,0) 40%,rgba(0,0,0,.28))}
.lx-cover.is-blank::after{display:none}
.lx-cover .dx-crumbs{position:absolute;top:18px;left:0;right:0;z-index:2}

.lx-head{border-bottom:1px solid var(--line);background:#fff}
.lx-head-in{display:grid;grid-template-columns:auto 1fr auto;gap:24px;align-items:end;padding-bottom:22px}
.lx-head .dx-logo{margin-top:-52px;position:relative;z-index:2;box-shadow:0 6px 20px rgba(0,0,0,.1);border:3px solid #fff}
.lx-title{padding-top:18px;min-width:0}
.lx-title h1{font-size:clamp(24px,3vw,34px);font-weight:800;line-height:1.15;margin-bottom:8px}
.lx-badges{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:10px}
.lx-meta{display:flex;gap:18px;flex-wrap:wrap;font-size:14px;color:var(--ink-3)}
.lx-meta i{margin-right:6px;color:var(--ink-3)}
.lx-actions{display:flex;gap:8px;flex-wrap:wrap}

.lx-tabs{position:sticky;top:62px;z-index:20;background:rgba(255,255,255,.96);backdrop-filter:blur(8px);border-bottom:1px solid var(--line)}
.lx-tabs .dx-wrap{display:flex;gap:4px;overflow-x:auto;scrollbar-width:none}
.lx-tabs a{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--ink-3);text-decoration:none;padding:14px 12px;border-bottom:2px solid transparent;white-space:nowrap}
.lx-tabs a:hover,.lx-tabs a.on{color:var(--ink);border-bottom-color:var(--teal)}

.lx-body{display:grid;grid-template-columns:1fr 360px;gap:48px;padding:36px 0 72px}
.lx-sec{padding:28px 0;border-bottom:1px solid var(--line-2);scroll-margin-top:130px}
.lx-sec:first-child{padding-top:0}
.lx-sec h2{font-size:20px;font-weight:800;margin-bottom:14px}
.lx-tagline{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:600;color:var(--ink);line-height:1.5;margin-bottom:12px}
.lx-about{font-size:16px;line-height:1.8;color:var(--ink-2);white-space:pre-line}
.lx-svc{display:grid;grid-template-columns:1fr 1fr;gap:10px 28px}
.lx-svc div{display:flex;align-items:center;gap:12px;font-size:15px;color:var(--ink-2);padding:6px 0}
.lx-svc i{width:34px;height:34px;border-radius:8px;background:#eef3ef;color:var(--forest);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.lx-facts{display:grid;grid-template-columns:repeat(2,1fr);border:1px solid var(--line);border-radius:12px;overflow:hidden}
.lx-fact{padding:16px 18px;border-bottom:1px solid var(--line-2)}
.lx-fact:nth-child(odd){border-right:1px solid var(--line-2)}
.lx-fact dt{font-size:12px;font-weight:700;text-transform:uppercase;letter-spacing:.06em;color:var(--ink-3);margin-bottom:4px;font-family:'Plus Jakarta Sans',sans-serif}
.lx-fact dd{font-size:15px;color:var(--ink);margin:0;line-height:1.5}
.lx-chips{display:flex;flex-wrap:wrap;gap:8px}
.lx-chips span{font-size:13.5px;color:var(--ink-2);border:1px solid var(--line);padding:6px 12px;border-radius:6px}
.lx-photos{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.lx-photos a{display:block;aspect-ratio:4/3;border-radius:8px;overflow:hidden;background:#eee}
.lx-photos img{width:100%;height:100%;object-fit:cover;transition:transform .3s}
.lx-photos a:hover img{transform:scale(1.04)}
.lx-map{border:1px solid var(--line);border-radius:12px;overflow:hidden}
.lx-map iframe{display:block;width:100%;height:280px;border:0}
.lx-map-foot{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:14px 16px;font-size:14px;color:var(--ink-2)}
.lx-locked{display:flex;gap:14px;align-items:flex-start;border:1px dashed #cfd6d1;border-radius:12px;padding:18px;color:var(--ink-3);font-size:14px;line-height:1.55}
.lx-locked i{color:var(--ink-3);margin-top:3px}

.lx-side{position:sticky;top:130px;align-self:start;display:flex;flex-direction:column;gap:16px}
.lx-card{border:1px solid var(--line);border-radius:14px;padding:22px;background:#fff}
.lx-card h3{font-size:16px;font-weight:800;margin-bottom:4px}
.lx-card-sub{font-size:13.5px;color:var(--ink-3);margin-bottom:16px;line-height:1.5}
.lx-crow{display:flex;align-items:center;justify-content:space-between;gap:12px;padding:13px 0;border-top:1px solid var(--line-2);font-size:14.5px}
.lx-crow:first-of-type{border-top:0;padding-top:0}
.lx-crow a{color:var(--teal);font-weight:700;text-decoration:none;word-break:break-word}
.lx-crow span{color:var(--ink-2);word-break:break-word}
.lx-crow i{color:var(--ink-3);font-size:15px;width:18px;text-align:center}
.lx-form label{display:block;font-size:12.5px;font-weight:700;color:var(--ink-2);margin:0 0 5px;font-family:'Plus Jakarta Sans',sans-serif}
.lx-form input,.lx-form select,.lx-form textarea{width:100%;font:inherit;font-size:14.5px;border:1px solid var(--line);border-radius:8px;padding:10px 12px;margin-bottom:12px;background:#fff;color:var(--ink);outline:0}
.lx-form input:focus,.lx-form select:focus,.lx-form textarea:focus{border-color:var(--teal)}
.lx-form .dx-btn{width:100%;padding:13px}
.lx-form small{display:block;font-size:11.5px;color:var(--ink-3);margin-top:10px;line-height:1.5}
.lx-ok{display:none;text-align:center;padding:12px 0}
.lx-ok i{font-size:34px;color:var(--teal);margin-bottom:10px}
.lx-claim{background:var(--bg);border:1px solid var(--line);border-radius:14px;padding:18px 20px;font-size:14px;color:var(--ink-2);line-height:1.55}
.lx-claim strong{display:block;font-family:'Plus Jakarta Sans',sans-serif;color:var(--ink);margin-bottom:4px}
.lx-claim a{color:var(--teal);font-weight:700;text-decoration:none}
.lx-report{font-size:12.5px;color:var(--ink-3);text-align:center}
.lx-report a{color:var(--ink-3)}

.lx-near{background:var(--bg);border-top:1px solid var(--line);padding:48px 0 64px}
.lx-near h2{font-size:19px;font-weight:800;margin-bottom:16px}
.lx-near-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.lx-near-card{display:flex;gap:14px;background:#fff;border:1px solid var(--line);border-radius:12px;padding:16px;text-decoration:none;transition:border-color .15s,box-shadow .15s}
.lx-near-card:hover{border-color:#cfd6d1;box-shadow:0 8px 24px rgba(20,32,26,.06)}
.lx-near-card h3{font-size:15px;font-weight:800;margin-bottom:3px;line-height:1.3}
.lx-near-card p{font-size:13px;color:var(--ink-3)}

@media(max-width:1024px){
  .lx-body{grid-template-columns:1fr}
  .lx-side{position:static}
  .lx-head-in{grid-template-columns:auto 1fr}
  .lx-actions{grid-column:1/-1}
}
@media(max-width:640px){
  .lx-cover{height:170px}
  .lx-cover.is-blank{height:130px}
  .lx-head-in{grid-template-columns:1fr;gap:0}
  .lx-head .dx-logo{width:84px!important;height:84px!important}
  .lx-title{padding-top:12px;margin-bottom:16px}
  .lx-actions .dx-btn{flex:1}
  .lx-svc,.lx-facts{grid-template-columns:1fr}
  .lx-fact:nth-child(odd){border-right:0}
  .lx-photos{grid-template-columns:1fr 1fr}
  .lx-near-grid{grid-template-columns:1fr}
}
CSS;
include '../includes/header.php';

$ld = array_filter([
    '@context'    => 'https://schema.org',
    '@type'       => 'LocalBusiness',
    '@id'         => $canonical . '#business',
    'name'        => $l['company_name'],
    'description' => $l['description'],
    'image'       => ($paid && $l['logo']) ? $l['logo'] : null,
    'telephone'   => $l['phone'] ?: null,
    'url'         => ($paid && $l['website']) ? $l['website'] : $canonical,
    'address'     => array_filter(['@type' => 'PostalAddress', 'streetAddress' => $l['address'] ?: null, 'addressLocality' => $l['city'], 'addressRegion' => $l['state'], 'addressCountry' => 'US']),
    'areaServed'  => $areas ?: [$l['city']],
    'paymentAccepted' => $payments ? implode(', ', $payments) : null,
    'makesOffer'  => $services ? array_map(fn($s) => ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $s]], $services) : null,
]);
$crumbs = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Directory', 'item' => 'https://homecarecreators.com/directory/'],
    ['@type' => 'ListItem', 'position' => 2, 'name' => $l['state'], 'item' => 'https://homecarecreators.com/directory/?loc=' . urlencode($l['state'])],
    ['@type' => 'ListItem', 'position' => 3, 'name' => $l['company_name'], 'item' => $canonical],
]];
?>
<script type="application/ld+json"><?= json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
<script type="application/ld+json"><?= json_encode($crumbs, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>

<div id="scrollProgress"></div>
<div class="dx">

<!-- COVER -->
<div class="lx-cover<?= ($paid && $l['cover_image']) ? '' : ' is-blank' ?>"<?= ($paid && $l['cover_image']) ? ' style="background-image:url(\'' . htmlspecialchars($l['cover_image']) . '\')"' : '' ?>>
  <div class="dx-wrap dx-crumbs">
    <a href="/directory/">Directory</a><span>/</span><a href="/directory/?loc=<?= urlencode($l['state']) ?>"><?= htmlspecialchars($l['state']) ?></a><span>/</span><a href="/directory/?loc=<?= urlencode($l['city'] . ', ' . $l['state']) ?>"><?= htmlspecialchars($l['city']) ?></a>
  </div>
</div>

<!-- HEADER -->
<header class="lx-head">
  <div class="dx-wrap lx-head-in">
    <?= hc_dir_logo($l, 116, $paid) ?>
    <div class="lx-title">
      <h1><?= htmlspecialchars($l['company_name']) ?></h1>
      <?php if ($b = hc_dir_badges($l, $tier)): ?><div class="lx-badges"><?= $b ?></div><?php endif ?>
      <div class="lx-meta">
        <span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></span>
        <?php if ($l['years_in_business']): ?><span><i class="fa-regular fa-calendar"></i><?= htmlspecialchars($l['years_in_business']) ?> years in business</span><?php endif ?>
        <?php if ($l['license_number']): ?><span><i class="fa-regular fa-id-card"></i>License #<?= htmlspecialchars($l['license_number']) ?></span><?php endif ?>
      </div>
    </div>
    <div class="lx-actions">
      <?php if ($l['phone']): ?><a class="dx-btn is-primary" href="tel:<?= htmlspecialchars($phoneHref) ?>"><i class="fa-solid fa-phone"></i>Call</a><?php endif ?>
      <?php if ($paid && $l['website']): ?><a class="dx-btn" href="<?= htmlspecialchars($l['website']) ?>" target="_blank" rel="noopener"><i class="fa-solid fa-globe"></i>Website</a><?php endif ?>
      <a class="dx-btn" href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode($mapQuery) ?>" target="_blank" rel="noopener nofollow"><i class="fa-solid fa-diamond-turn-right"></i>Directions</a>
      <button class="dx-btn" type="button" id="lxShare" aria-label="Share"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
    </div>
  </div>
</header>

<!-- SECTION NAV -->
<nav class="lx-tabs" aria-label="Sections">
  <div class="dx-wrap">
    <a href="#about">About</a>
    <?php if ($services): ?><a href="#services">Services</a><?php endif ?>
    <a href="#details">Details</a>
    <?php if ($photos): ?><a href="#photos">Photos</a><?php endif ?>
    <a href="#location">Location</a>
    <a href="#contact">Contact</a>
  </div>
</nav>

<div class="dx-wrap">
  <div class="lx-body">
    <main>
      <section class="lx-sec" id="about">
        <h2>About <?= htmlspecialchars($l['company_name']) ?></h2>
        <?php if ($paid && $l['tagline']): ?><p class="lx-tagline"><?= htmlspecialchars($l['tagline']) ?></p><?php endif ?>
        <div class="lx-about"><?= htmlspecialchars($l['description']) ?></div>
      </section>

      <?php if ($services): ?>
      <section class="lx-sec" id="services">
        <h2>Services offered</h2>
        <div class="lx-svc">
          <?php foreach ($services as $s): ?>
          <div><i class="fa-solid <?= $svcIcons[$s] ?? 'fa-check' ?>"></i><?= htmlspecialchars($s) ?></div>
          <?php endforeach ?>
        </div>
      </section>
      <?php endif ?>

      <section class="lx-sec" id="details">
        <h2>Agency details</h2>
        <dl class="lx-facts">
          <div class="lx-fact"><dt>Payment accepted</dt><dd><?= $payments ? htmlspecialchars(implode(', ', $payments)) : 'Contact agency' ?></dd></div>
          <div class="lx-fact"><dt>Languages</dt><dd><?= $l['languages'] ? htmlspecialchars($l['languages']) : 'English' ?></dd></div>
          <div class="lx-fact"><dt>Hours</dt><dd><?= $l['hours'] ? htmlspecialchars($l['hours']) : 'Contact agency' ?></dd></div>
          <div class="lx-fact"><dt>License</dt><dd><?= $l['license_number'] ? '#' . htmlspecialchars($l['license_number']) : 'Not provided' ?></dd></div>
        </dl>
        <?php if ($areas): ?>
        <h2 style="margin-top:26px;font-size:16px">Service area</h2>
        <div class="lx-chips"><?php foreach ($areas as $a): ?><span><?= htmlspecialchars($a) ?></span><?php endforeach ?></div>
        <?php endif ?>
      </section>

      <?php if ($photos): ?>
      <section class="lx-sec" id="photos">
        <h2>Photos</h2>
        <div class="lx-photos">
          <?php foreach ($photos as $p): ?><a href="<?= htmlspecialchars($p) ?>" target="_blank" rel="noopener"><img src="<?= htmlspecialchars($p) ?>" alt="<?= htmlspecialchars($l['company_name']) ?> photo" loading="lazy"></a><?php endforeach ?>
        </div>
      </section>
      <?php endif ?>

      <section class="lx-sec" id="location" style="border-bottom:0">
        <h2>Location</h2>
        <div class="lx-map">
          <iframe loading="lazy" title="Map of <?= htmlspecialchars($l['company_name']) ?>" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=<?= urlencode($mapQuery) ?>&z=<?= $l['address'] ? 14 : 11 ?>&output=embed"></iframe>
          <div class="lx-map-foot">
            <span><?= htmlspecialchars($mapQuery) ?></span>
            <a class="dx-btn" href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode($mapQuery) ?>" target="_blank" rel="noopener nofollow">Get directions</a>
          </div>
        </div>
      </section>
    </main>

    <aside class="lx-side" id="contact">
      <?php if ($featured): ?>
      <div class="lx-card">
        <h3>Request a free consultation</h3>
        <p class="lx-card-sub">Tell <?= htmlspecialchars($l['company_name']) ?> what you need. They usually respond within one business day.</p>
        <form class="lx-form" id="lxLead" onsubmit="return lxSend(event)">
          <div class="hp-field" aria-hidden="true"><input type="text" name="hp_website" tabindex="-1" autocomplete="off"></div>
          <label for="lxName">Your name</label><input id="lxName" name="name" required autocomplete="name">
          <label for="lxPhone">Phone</label><input id="lxPhone" name="phone" type="tel" required autocomplete="tel">
          <label for="lxEmail">Email</label><input id="lxEmail" name="email" type="email" autocomplete="email">
          <label for="lxFor">Care is for</label>
          <select id="lxFor" name="care_for"><option>A parent</option><option>A spouse or partner</option><option>Myself</option><option>Another relative</option><option>A client or patient</option></select>
          <label for="lxMsg">How can they help?</label><textarea id="lxMsg" name="message" rows="3" placeholder="Type of care, schedule, start date…"></textarea>
          <button class="dx-btn is-primary" type="submit" id="lxBtn">Send request</button>
          <small>Your details go only to this agency. No spam.</small>
        </form>
        <div class="lx-ok" id="lxOk"><i class="fa-solid fa-circle-check"></i><h3>Request sent</h3><p class="lx-card-sub" style="margin:6px 0 0">The agency will contact you shortly.</p></div>
      </div>
      <?php endif ?>

      <div class="lx-card">
        <?php if (!$featured): ?><h3>Contact</h3><p class="lx-card-sub">Reach out directly to ask about availability and rates.</p><?php endif ?>
        <?php if ($l['phone']): ?><div class="lx-crow"><a href="tel:<?= htmlspecialchars($phoneHref) ?>"><?= htmlspecialchars($l['phone']) ?></a><i class="fa-solid fa-phone"></i></div><?php endif ?>
        <?php if ($paid && $l['website']): ?><div class="lx-crow"><a href="<?= htmlspecialchars($l['website']) ?>" target="_blank" rel="noopener"><?= htmlspecialchars(hc_dir_domain($l['website'])) ?></a><i class="fa-solid fa-arrow-up-right-from-square"></i></div><?php endif ?>
        <?php if ($paid && $l['email']): ?><div class="lx-crow"><a href="mailto:<?= htmlspecialchars($l['email']) ?>"><?= htmlspecialchars($l['email']) ?></a><i class="fa-regular fa-envelope"></i></div><?php endif ?>
        <div class="lx-crow"><span><?= htmlspecialchars($mapQuery) ?></span><i class="fa-solid fa-location-dot"></i></div>
      </div>

      <?php if (!$claimed): ?>
      <div class="lx-claim">
        <strong>Is this your agency?</strong>
        Claim this listing to update your details, add photos and get a Verified badge. <a href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>">Claim it now&nbsp;&rarr;</a>
      </div>
      <?php elseif (!$paid): ?>
      <div class="lx-claim">
        <strong>Own this listing?</strong>
        Upgrade to add your logo, photos and website link, and get placed above other agencies. <a href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>&plan=premium">See plans&nbsp;&rarr;</a>
      </div>
      <?php endif ?>
      <div class="lx-report"><a href="mailto:info@homecarecreators.com?subject=<?= rawurlencode('Directory listing correction: ' . $l['company_name']) ?>">Suggest an edit or report this listing</a></div>
    </aside>
  </div>
</div>

<?php if ($nearby): ?>
<section class="lx-near">
  <div class="dx-wrap">
    <h2>Other home care agencies near <?= htmlspecialchars($l['city']) ?></h2>
    <div class="lx-near-grid">
      <?php foreach ($nearby as $n): $nt = hc_dir_tier($n); ?>
      <a class="lx-near-card" href="/directory/<?= urlencode($n['slug']) ?>">
        <?= hc_dir_logo($n, 52, $nt !== 'free') ?>
        <div>
          <h3><?= htmlspecialchars($n['company_name']) ?></h3>
          <p><?= htmlspecialchars($n['city'] . ', ' . $n['state']) ?><?= $nt === 'featured' ? ' · Featured' : '' ?></p>
        </div>
      </a>
      <?php endforeach ?>
    </div>
  </div>
</section>
<?php endif ?>

</div>
<?php
$lid = (int)$l['id'];
$page_js = <<<JS
(function(){
  // Share
  var sh = document.getElementById('lxShare');
  if (sh) sh.addEventListener('click', function(){
    if (navigator.share) { navigator.share({title: document.title, url: location.href}).catch(function(){}); }
    else if (navigator.clipboard) { navigator.clipboard.writeText(location.href); sh.innerHTML = '<i class="fa-solid fa-check"></i> Copied'; }
  });
  // Section nav highlight
  var links = Array.prototype.slice.call(document.querySelectorAll('.lx-tabs a'));
  var secs = links.map(function(a){ return document.querySelector(a.getAttribute('href')); }).filter(Boolean);
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function(es){
      es.forEach(function(e){ if (e.isIntersecting) { links.forEach(function(a){ a.classList.toggle('on', a.getAttribute('href') === '#' + e.target.id); }); } });
    }, {rootMargin: '-140px 0px -60% 0px'});
    secs.forEach(function(s){ io.observe(s); });
  }
})();
function lxSend(e){
  e.preventDefault();
  var f = e.target, btn = document.getElementById('lxBtn');
  var data = {listing_id: {$lid}};
  new FormData(f).forEach(function(v,k){ data[k] = v; });
  btn.disabled = true; btn.textContent = 'Sending…';
  fetch('/directory-lead-handler.php', {method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(data)})
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) { f.style.display = 'none'; document.getElementById('lxOk').style.display = 'block'; }
      else { alert(d.message || 'Something went wrong.'); btn.disabled = false; btn.textContent = 'Send request'; }
    })
    .catch(function(){ alert('Connection error — please call the agency directly.'); btn.disabled = false; btn.textContent = 'Send request'; });
  return false;
}
JS;
include '../includes/footer.php';
