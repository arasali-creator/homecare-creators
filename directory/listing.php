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
$hasOwner = !empty($l['owner_confirmed_at']);           // claimed or claim in progress — hides the claim prompt
$isPlaceholder = hc_dir_is_placeholder_desc($l['description']);
$about    = hc_dir_public_desc($l);
$canonical = "https://homecarecreators.com/directory/" . $l['slug'];
$mapQuery  = trim(($l['address'] ? $l['address'] . ', ' : '') . $l['city'] . ', ' . $l['state']);
$phoneHref = preg_replace('/[^0-9+]/', '', (string)$l['phone']);
$cover     = ($paid && $l['cover_image']) ? $l['cover_image'] : '';

$nearby = $paid ? [] : hc_all(
    "SELECT * FROM hc_directory_listings WHERE status='approved' AND id<>? AND state=? ORDER BY (city=?) DESC, " . hc_dir_rank_sql() . " DESC, RAND() LIMIT 3",
    [$l['id'], $l['state'], $l['city']]
);

$page_title = $l['company_name'] . ' — Home Care in ' . $l['city'] . ', ' . $l['state'] . ' | Homecare Creators Directory';
$page_desc  = mb_strlen($about) > 158 ? rtrim(mb_substr($about, 0, 155)) . '…' : $about;
$page_canonical = $canonical;
$og_title = $l['company_name'] . ' — Home Care in ' . $l['city'] . ', ' . $l['state'];
$og_desc  = $page_desc;
$og_image = $paid ? ($cover ?: ($l['logo'] ?: null)) : null;

$svcIcons = [
    'Personal Care' => 'fa-hand-holding-heart', 'Companion Care' => 'fa-people-arrows', 'Skilled Nursing' => 'fa-user-nurse',
    'Alzheimer\'s & Dementia Care' => 'fa-brain', '24-Hour Care' => 'fa-clock', 'Live-In Care' => 'fa-house-user',
    'Respite Care' => 'fa-mug-hot', 'Post-Hospital Care' => 'fa-hospital', 'Medication Management' => 'fa-pills',
    'Homemaker Services' => 'fa-broom', 'Transportation' => 'fa-car', 'Hospice Support' => 'fa-dove',
];
$mono = hc_dir_mono_color($l['company_name']);

$page_css = hc_dir_base_css() . <<<CSS
body{background:var(--bg,#f4f5f1)}
.dx{background:var(--bg)}

/* ── HEADER ─────────────────────────────── */
.lh{position:relative;background:var(--forest);padding:104px 0 0;overflow:hidden}
.lh-bg{position:absolute;inset:0;background-size:cover;background-position:center}
.lh-bg::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,46,30,.55),rgba(10,46,30,.92))}
.lh-glow{position:absolute;inset:0;background:radial-gradient(800px 380px at 90% 0%,rgba(46,198,143,.16),transparent 60%),radial-gradient(600px 320px at 0% 100%,rgba(201,168,76,.10),transparent 60%)}
.lh .dx-wrap{position:relative}
.lh-top{display:grid;grid-template-columns:auto 1fr auto;gap:28px;align-items:center;padding:26px 0 34px}
.lh-top .dx-logo{border:4px solid rgba(255,255,255,.95);box-shadow:0 14px 36px rgba(0,0,0,.3)}
.lh h1{color:#fff;font-size:clamp(28px,3.6vw,44px);font-weight:800;line-height:1.08;letter-spacing:-.03em;margin-bottom:12px}
.lh-badges{display:flex;gap:8px;flex-wrap:wrap;margin-bottom:12px}
.lh-meta{display:flex;flex-wrap:wrap;gap:8px 22px;color:rgba(255,255,255,.72);font-size:15px}
.lh-meta i{color:var(--teal-lt);margin-right:7px}
.lh-actions{display:flex;gap:10px;flex-wrap:wrap;justify-content:flex-end}
.lh-actions .dx-btn{padding:13px 18px}

/* glance strip */
.lg{display:grid;grid-template-columns:repeat(4,1fr);background:#fff;border-radius:18px 18px 0 0;box-shadow:0 -10px 30px rgba(0,0,0,.08)}
.lg-item{display:flex;gap:14px;align-items:center;padding:20px 22px;min-width:0}
.lg-item+.lg-item{border-left:1px solid var(--line-2)}
.lg-ic{width:42px;height:42px;border-radius:12px;background:#eef4f0;color:var(--forest);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.lg-item small{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-3);margin-bottom:2px}
.lg-item b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--ink);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.lg-item a b:hover{color:var(--teal)}

/* sticky tabs */
.lt{position:sticky;top:62px;z-index:30;background:#fff;border-bottom:1px solid var(--line);box-shadow:0 6px 16px rgba(16,26,21,.04)}
.lt-in{display:flex;gap:6px;overflow-x:auto;scrollbar-width:none}
.lt-in::-webkit-scrollbar{display:none}
.lt-in a{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--ink-3);padding:16px 14px;border-bottom:2.5px solid transparent;white-space:nowrap;transition:color .15s}
.lt-in a:hover{color:var(--ink)}
.lt-in a.on{color:var(--ink);border-bottom-color:var(--teal)}

/* body */
.lb{display:grid;grid-template-columns:1fr 380px;gap:28px;padding:28px 0 88px;align-items:start}
.lc{background:#fff;border-radius:18px;box-shadow:var(--shadow);padding:30px;margin-bottom:18px;scroll-margin-top:140px}
.lc h2{font-size:21px;font-weight:800;margin-bottom:16px}
.lc-tagline{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:700;color:var(--ink);line-height:1.45;margin-bottom:12px}
.lc-about{font-size:16.5px;line-height:1.8;color:var(--ink-2);white-space:pre-line}
.lc-note{display:flex;gap:14px;align-items:flex-start;background:#f6f7f3;border-radius:14px;padding:16px 18px;margin-top:20px;font-size:14px;color:var(--ink-2);line-height:1.55}
.lc-note i{color:var(--gold);font-size:16px;margin-top:2px}
.lc-note a{color:var(--teal);font-weight:700}
.sv{display:grid;grid-template-columns:repeat(2,1fr);gap:12px}
.sv div{display:flex;align-items:center;gap:14px;padding:14px 16px;border-radius:14px;background:#f6f8f5;font-size:15px;font-weight:600;color:var(--ink)}
.sv i{width:38px;height:38px;border-radius:11px;background:#fff;color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;box-shadow:0 1px 3px rgba(0,0,0,.06)}
.sv-empty{font-size:15px;color:var(--ink-3)}
.fx{display:grid;grid-template-columns:repeat(2,1fr);gap:0;border:1px solid var(--line-2);border-radius:14px;overflow:hidden}
.fx div{padding:18px 20px}
.fx div:nth-child(odd){border-right:1px solid var(--line-2)}
.fx div:nth-child(n+3){border-top:1px solid var(--line-2)}
.fx small{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-3);margin-bottom:5px}
.fx p{font-size:15px;color:var(--ink);line-height:1.5}
.fx p.muted{color:var(--ink-3)}
.ar{display:flex;flex-wrap:wrap;gap:8px;margin-top:6px}
.ar span{font-size:14px;color:var(--ink-2);background:#f6f8f5;padding:8px 14px;border-radius:100px}
.ar i{color:var(--teal);margin-right:6px;font-size:11px}
.ph{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.ph a{display:block;aspect-ratio:4/3;border-radius:12px;overflow:hidden;background:#eee}
.ph img{width:100%;height:100%;object-fit:cover;transition:transform .35s}
.ph a:hover img{transform:scale(1.05)}
.mp{border-radius:14px;overflow:hidden;background:#e9ece7}
.mp iframe{display:block;width:100%;height:320px;border:0}
.mp-foot{display:flex;justify-content:space-between;align-items:center;gap:14px;margin-top:16px;font-size:15px;color:var(--ink-2)}
.mp-foot i{color:var(--teal);margin-right:8px}

/* sidebar */
.ls{position:sticky;top:140px;display:flex;flex-direction:column;gap:16px}
.sc{background:#fff;border-radius:18px;box-shadow:var(--shadow);padding:26px}
.sc h3{font-size:18px;font-weight:800;margin-bottom:6px}
.sc-sub{font-size:14px;color:var(--ink-3);line-height:1.55;margin-bottom:18px}
.sc-row{display:flex;align-items:center;gap:14px;padding:14px 0;border-top:1px solid var(--line-2);font-size:15px;min-width:0}
.sc-row:first-of-type{border-top:0;padding-top:4px}
.sc-row .ic{width:38px;height:38px;border-radius:11px;background:#eef4f0;color:var(--forest);display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.sc-row small{display:block;font-size:12px;color:var(--ink-3)}
.sc-row b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--ink);word-break:break-word}
.sc-row a:hover b{color:var(--teal)}
.sc-call{width:100%;padding:15px;font-size:15px;margin-top:6px}
.lf label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--ink);margin:0 0 6px}
.lf input,.lf select,.lf textarea{width:100%;font:inherit;font-size:15px;border:1px solid var(--line);border-radius:10px;padding:12px 14px;margin-bottom:14px;background:#fff;color:var(--ink);outline:0;transition:border-color .15s,box-shadow .15s}
.lf input:focus,.lf select:focus,.lf textarea:focus{border-color:var(--teal);box-shadow:0 0 0 3px rgba(29,158,117,.12)}
.lf-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.lf .dx-btn{width:100%;padding:15px;font-size:15px}
.lf small{display:block;font-size:12px;color:var(--ink-3);margin-top:12px;text-align:center}
.lf-ok{display:none;text-align:center;padding:16px 0}
.lf-ok .ic{width:56px;height:56px;border-radius:50%;background:#e3f4ec;color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 14px}
.cl{background:var(--forest);border-radius:18px;padding:24px;color:#fff;position:relative;overflow:hidden}
.cl::after{content:"";position:absolute;right:-40px;top:-40px;width:140px;height:140px;border-radius:50%;background:rgba(46,198,143,.14)}
.cl h3{color:#fff;font-size:17px;margin-bottom:6px;position:relative}
.cl p{font-size:14px;color:rgba(255,255,255,.68);line-height:1.55;margin-bottom:16px;position:relative}
.cl .dx-btn{position:relative}
.rp{text-align:center;font-size:13px;color:var(--ink-3)}
.rp a{text-decoration:underline!important;text-underline-offset:3px}

/* nearby */
.nb{padding:0 0 88px}
.nb h2{font-size:22px;font-weight:800;margin-bottom:18px}
.nb-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.nb-card{display:flex;gap:16px;align-items:center;background:#fff;border-radius:18px;box-shadow:var(--shadow);padding:18px;transition:transform .2s,box-shadow .2s}
.nb-card:hover{transform:translateY(-3px);box-shadow:0 14px 34px rgba(16,26,21,.1)}
.nb-card h3{font-size:16px;font-weight:800;line-height:1.3;margin-bottom:3px}
.nb-card p{font-size:13.5px;color:var(--ink-3)}

@media(max-width:1100px){
  .lb{grid-template-columns:1fr}
  .ls{position:static}
  .lh-top{grid-template-columns:auto 1fr}
  .lh-actions{grid-column:1/-1;justify-content:flex-start}
  .lg{grid-template-columns:1fr 1fr}
  .lg-item:nth-child(3){border-left:0}
  .lg-item:nth-child(n+3){border-top:1px solid var(--line-2)}
}
@media(max-width:700px){
  .lh{padding-top:88px}
  .lh-top{grid-template-columns:1fr;gap:16px;padding:18px 0 26px}
  .lh-top .dx-logo{width:84px!important;height:84px!important;font-size:28px!important}
  .lh-actions .dx-btn{flex:1}
  .lg{grid-template-columns:1fr;border-radius:18px 18px 0 0}
  .lg-item+.lg-item{border-left:0;border-top:1px solid var(--line-2)}
  .lg-item{padding:14px 18px}
  .lc,.sc{padding:22px 18px}
  .sv,.fx,.lf-row{grid-template-columns:1fr}
  .fx div:nth-child(odd){border-right:0}
  .fx div:nth-child(n+2){border-top:1px solid var(--line-2)}
  .ph{grid-template-columns:1fr 1fr}
  .nb-grid{grid-template-columns:1fr}
  .mp-foot{flex-direction:column;align-items:flex-start}
}
CSS;
include '../includes/header.php';

$ld = array_filter([
    '@context'    => 'https://schema.org',
    '@type'       => 'LocalBusiness',
    '@id'         => $canonical . '#business',
    'name'        => $l['company_name'],
    'description' => $about,
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

<!-- HEADER -->
<header class="lh">
  <?php if ($cover): ?><div class="lh-bg" style="background-image:url('<?= htmlspecialchars($cover) ?>')"></div><?php else: ?><div class="lh-glow"></div><?php endif ?>
  <div class="dx-wrap">
    <div class="dx-crumbs">
      <a href="/directory/">Directory</a><i class="fa-solid fa-chevron-right"></i>
      <a href="/directory/?loc=<?= urlencode($l['state']) ?>"><?= htmlspecialchars($l['state']) ?></a><i class="fa-solid fa-chevron-right"></i>
      <a href="/directory/?loc=<?= urlencode($l['city'] . ', ' . $l['state']) ?>"><?= htmlspecialchars($l['city']) ?></a>
    </div>
    <div class="lh-top">
      <?= hc_dir_logo($l, 112, $paid) ?>
      <div style="min-width:0">
        <?php if ($b = hc_dir_badges($l, $tier)): ?><div class="lh-badges"><?= $b ?></div><?php endif ?>
        <h1><?= htmlspecialchars($l['company_name']) ?></h1>
        <div class="lh-meta">
          <span><i class="fa-solid fa-location-dot"></i>Home care in <?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></span>
          <?php if ($l['years_in_business']): ?><span><i class="fa-regular fa-calendar"></i><?= htmlspecialchars($l['years_in_business']) ?> years in business</span><?php endif ?>
        </div>
      </div>
      <div class="lh-actions">
        <?php if ($l['phone']): ?><a class="dx-btn is-primary" href="tel:<?= htmlspecialchars($phoneHref) ?>"><i class="fa-solid fa-phone"></i>Call now</a><?php endif ?>
        <?php if ($paid && $l['website']): ?><a class="dx-btn is-ghost-light" href="<?= htmlspecialchars($l['website']) ?>" target="_blank" rel="noopener"><i class="fa-solid fa-globe"></i>Website</a><?php endif ?>
        <a class="dx-btn is-ghost-light" href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode($mapQuery) ?>" target="_blank" rel="noopener nofollow"><i class="fa-solid fa-diamond-turn-right"></i>Directions</a>
        <button class="dx-btn is-ghost-light" type="button" id="lxShare" aria-label="Share"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
      </div>
    </div>
    <div class="lg">
      <div class="lg-item"><span class="lg-ic"><i class="fa-solid fa-location-dot"></i></span><div style="min-width:0"><small>Location</small><b><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></b></div></div>
      <div class="lg-item"><span class="lg-ic"><i class="fa-solid fa-phone"></i></span><div style="min-width:0"><small>Phone</small><?php if ($l['phone']): ?><a href="tel:<?= htmlspecialchars($phoneHref) ?>"><b><?= htmlspecialchars($l['phone']) ?></b></a><?php else: ?><b style="color:var(--ink-3)">Not listed</b><?php endif ?></div></div>
      <div class="lg-item"><span class="lg-ic"><i class="fa-solid fa-hand-holding-heart"></i></span><div style="min-width:0"><small>Services</small><b><?= $services ? count($services) . ' type' . (count($services) === 1 ? '' : 's') . ' of care' : 'Contact agency' ?></b></div></div>
      <div class="lg-item"><span class="lg-ic"><i class="fa-regular fa-id-card"></i></span><div style="min-width:0"><small>License</small><b><?= $l['license_number'] ? '#' . htmlspecialchars($l['license_number']) : 'Not provided' ?></b></div></div>
    </div>
  </div>
</header>

<!-- SECTION TABS -->
<div class="lt">
  <div class="dx-wrap lt-in" role="navigation" aria-label="Sections">
    <a href="#about">Overview</a>
    <a href="#services">Services</a>
    <a href="#details">Details</a>
    <?php if ($photos): ?><a href="#photos">Photos</a><?php endif ?>
    <a href="#location">Location</a>
    <a href="#contact">Contact</a>
  </div>
</div>

<div class="dx-wrap">
  <div class="lb">
    <main>
      <section class="lc" id="about">
        <h2>About <?= htmlspecialchars($l['company_name']) ?></h2>
        <?php if ($paid && $l['tagline']): ?><p class="lc-tagline"><?= htmlspecialchars($l['tagline']) ?></p><?php endif ?>
        <div class="lc-about"><?= htmlspecialchars($about) ?></div>
        <?php if (!$hasOwner): ?>
        <div class="lc-note"><i class="fa-solid fa-circle-info"></i><div>This profile hasn't been claimed by the agency yet, so some details may be incomplete. Please confirm services and availability when you call. <a href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>">Own this agency? Claim it.</a></div></div>
        <?php endif ?>
      </section>

      <section class="lc" id="services">
        <h2>Services offered</h2>
        <?php if ($services): ?>
        <div class="sv">
          <?php foreach ($services as $s): ?><div><i class="fa-solid <?= $svcIcons[$s] ?? 'fa-check' ?>"></i><?= htmlspecialchars($s) ?></div><?php endforeach ?>
        </div>
        <?php else: ?>
        <p class="sv-empty">This agency hasn't listed its services yet. Call <?= $l['phone'] ? '<a href="tel:' . htmlspecialchars($phoneHref) . '" style="color:var(--teal);font-weight:700">' . htmlspecialchars($l['phone']) . '</a>' : 'them' ?> to ask about personal care, companion care, skilled nursing and more.</p>
        <?php endif ?>
      </section>

      <section class="lc" id="details">
        <h2>Agency details</h2>
        <div class="fx">
          <div><small>Payment accepted</small><p class="<?= $payments ? '' : 'muted' ?>"><?= $payments ? htmlspecialchars(implode(', ', $payments)) : 'Ask the agency' ?></p></div>
          <div><small>Languages</small><p class="<?= $l['languages'] ? '' : 'muted' ?>"><?= $l['languages'] ? htmlspecialchars($l['languages']) : 'Ask the agency' ?></p></div>
          <div><small>Hours</small><p class="<?= $l['hours'] ? '' : 'muted' ?>"><?= $l['hours'] ? htmlspecialchars($l['hours']) : 'Ask the agency' ?></p></div>
          <div><small>Years in business</small><p class="<?= $l['years_in_business'] ? '' : 'muted' ?>"><?= $l['years_in_business'] ? htmlspecialchars($l['years_in_business']) . ' years' : 'Not provided' ?></p></div>
        </div>
        <?php if ($areas): ?>
        <h2 style="font-size:16px;margin:24px 0 8px">Areas served</h2>
        <div class="ar"><?php foreach ($areas as $a): ?><span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($a) ?></span><?php endforeach ?></div>
        <?php endif ?>
      </section>

      <?php if ($photos): ?>
      <section class="lc" id="photos">
        <h2>Photos</h2>
        <div class="ph">
          <?php foreach ($photos as $p): ?><a href="<?= htmlspecialchars($p) ?>" target="_blank" rel="noopener"><img src="<?= htmlspecialchars($p) ?>" alt="<?= htmlspecialchars($l['company_name']) ?> photo" loading="lazy"></a><?php endforeach ?>
        </div>
      </section>
      <?php endif ?>

      <section class="lc" id="location">
        <h2>Location</h2>
        <div class="mp"><iframe loading="lazy" title="Map of <?= htmlspecialchars($l['company_name']) ?>" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=<?= urlencode($mapQuery) ?>&z=<?= $l['address'] ? 14 : 11 ?>&output=embed"></iframe></div>
        <div class="mp-foot">
          <span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($mapQuery) ?></span>
          <a class="dx-btn" href="https://www.google.com/maps/dir/?api=1&destination=<?= urlencode($mapQuery) ?>" target="_blank" rel="noopener nofollow"><i class="fa-solid fa-diamond-turn-right"></i>Get directions</a>
        </div>
      </section>
    </main>

    <aside class="ls" id="contact">
      <?php if ($featured): ?>
      <div class="sc">
        <h3>Request a free consultation</h3>
        <p class="sc-sub">Tell <?= htmlspecialchars($l['company_name']) ?> what you need. Your request goes straight to the agency.</p>
        <form class="lf" id="lxLead" onsubmit="return lxSend(event)">
          <div class="hp-field" aria-hidden="true"><input type="text" name="hp_website" tabindex="-1" autocomplete="off"></div>
          <label for="lxName">Your name</label><input id="lxName" name="name" required autocomplete="name">
          <div class="lf-row">
            <div><label for="lxPhone">Phone</label><input id="lxPhone" name="phone" type="tel" required autocomplete="tel"></div>
            <div><label for="lxEmail">Email</label><input id="lxEmail" name="email" type="email" autocomplete="email"></div>
          </div>
          <label for="lxFor">Care is for</label>
          <select id="lxFor" name="care_for"><option>A parent</option><option>A spouse or partner</option><option>Myself</option><option>Another relative</option><option>A client or patient</option></select>
          <label for="lxMsg">How can they help?</label><textarea id="lxMsg" name="message" rows="3" placeholder="Type of care, schedule, start date…"></textarea>
          <button class="dx-btn is-primary" type="submit" id="lxBtn">Send request</button>
          <small><i class="fa-solid fa-lock" style="margin-right:5px"></i>Shared only with this agency</small>
        </form>
        <div class="lf-ok" id="lxOk"><div class="ic"><i class="fa-solid fa-check"></i></div><h3>Request sent</h3><p class="sc-sub" style="margin:6px 0 0">The agency will be in touch shortly.</p></div>
      </div>
      <?php endif ?>

      <div class="sc">
        <?php if (!$featured): ?><h3>Contact this agency</h3><p class="sc-sub">Call to ask about availability, rates and how they match caregivers.</p><?php endif ?>
        <?php if ($l['phone']): ?><a class="sc-row" href="tel:<?= htmlspecialchars($phoneHref) ?>"><span class="ic"><i class="fa-solid fa-phone"></i></span><span><small>Phone</small><b><?= htmlspecialchars($l['phone']) ?></b></span></a><?php endif ?>
        <?php if ($paid && $l['website']): ?><a class="sc-row" href="<?= htmlspecialchars($l['website']) ?>" target="_blank" rel="noopener"><span class="ic"><i class="fa-solid fa-globe"></i></span><span><small>Website</small><b><?= htmlspecialchars(hc_dir_domain($l['website'])) ?></b></span></a><?php endif ?>
        <?php if ($paid && $l['email']): ?><a class="sc-row" href="mailto:<?= htmlspecialchars($l['email']) ?>"><span class="ic"><i class="fa-regular fa-envelope"></i></span><span><small>Email</small><b><?= htmlspecialchars($l['email']) ?></b></span></a><?php endif ?>
        <div class="sc-row"><span class="ic"><i class="fa-solid fa-location-dot"></i></span><span><small>Location</small><b><?= htmlspecialchars($mapQuery) ?></b></span></div>
        <?php if ($l['phone'] && !$featured): ?><a class="dx-btn is-primary sc-call" href="tel:<?= htmlspecialchars($phoneHref) ?>"><i class="fa-solid fa-phone"></i>Call <?= htmlspecialchars($l['phone']) ?></a><?php endif ?>
      </div>

      <?php if (!$hasOwner): ?>
      <div class="cl">
        <h3>Is this your agency?</h3>
        <p>Claim this free profile to update your details, add your logo and photos, and earn a Verified badge.</p>
        <a class="dx-btn is-primary" href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>">Claim this listing</a>
      </div>
      <?php elseif (!$paid): ?>
      <div class="cl">
        <h3>Own this listing?</h3>
        <p>Upgrade to add your logo, photos and website link, and appear above other agencies in <?= htmlspecialchars($l['city']) ?>.</p>
        <a class="dx-btn is-primary" href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>&plan=premium">See upgrade options</a>
      </div>
      <?php endif ?>
      <div class="rp"><a href="mailto:info@homecarecreators.com?subject=<?= rawurlencode('Directory listing correction: ' . $l['company_name']) ?>">Suggest an edit or report this listing</a></div>
    </aside>
  </div>
</div>

<?php if ($nearby): ?>
<section class="nb">
  <div class="dx-wrap">
    <h2>More home care agencies near <?= htmlspecialchars($l['city']) ?></h2>
    <div class="nb-grid">
      <?php foreach ($nearby as $n): $nt = hc_dir_tier($n); ?>
      <a class="nb-card" href="/directory/<?= urlencode($n['slug']) ?>">
        <?= hc_dir_logo($n, 56, $nt !== 'free') ?>
        <div style="min-width:0">
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
  var sh = document.getElementById('lxShare');
  if (sh) sh.addEventListener('click', function(){
    if (navigator.share) { navigator.share({title: document.title, url: location.href}).catch(function(){}); }
    else if (navigator.clipboard) { navigator.clipboard.writeText(location.href); sh.innerHTML = '<i class="fa-solid fa-check"></i>'; }
  });
  var links = Array.prototype.slice.call(document.querySelectorAll('.lt-in a'));
  var secs = links.map(function(a){ return document.querySelector(a.getAttribute('href')); }).filter(Boolean);
  if ('IntersectionObserver' in window) {
    var io = new IntersectionObserver(function(es){
      es.forEach(function(e){ if (e.isIntersecting) { links.forEach(function(a){ a.classList.toggle('on', a.getAttribute('href') === '#' + e.target.id); }); } });
    }, {rootMargin: '-150px 0px -60% 0px'});
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
