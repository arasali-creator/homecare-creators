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
/* ── HEADER PANEL ───────────────────────── */
.lh{display:grid;grid-template-columns:1.1fr .9fr;gap:56px;align-items:stretch}
.lh-id{display:flex;flex-direction:column;justify-content:center}
.lh-badges{display:flex;gap:8px;flex-wrap:wrap;margin:26px 0 18px}
.lh .dx-h1{font-size:clamp(38px,5vw,68px);margin-bottom:20px;overflow-wrap:anywhere}
.lh-meta{display:flex;flex-wrap:wrap;gap:8px 24px;font-size:16px;color:var(--mut);margin-bottom:34px}
.lh-meta i{color:var(--teal);margin-right:8px;font-size:13px}
.lh-actions{display:flex;flex-wrap:wrap;gap:10px}
.lh-actions .dx-btn{padding:16px 24px;font-size:15px}
.lh-vis{position:relative;border-radius:32px;overflow:hidden;min-height:420px;background:#e6e2d8}
.lh-vis iframe{position:absolute;inset:0;width:100%;height:100%;border:0;filter:grayscale(.35) contrast(1.02)}
.lh-vis.is-cover{background-size:cover;background-position:center}
.lh-pin{position:absolute;left:20px;bottom:20px;right:20px;background:#fff;border-radius:22px;padding:16px 18px;display:flex;align-items:center;gap:14px;box-shadow:0 20px 50px rgba(10,46,30,.18)}
.lh-pin b{display:block;font-family:'Plus Jakarta Sans',sans-serif;color:var(--ink);font-size:15px}
.lh-pin span{font-size:13px;color:var(--mut)}
.lh-pin .dx-arrow{margin-left:auto}

/* ── BODY PANEL ─────────────────────────── */
.lb{display:grid;grid-template-columns:1fr 400px;gap:64px;align-items:start}
.sec{display:grid;grid-template-columns:72px 1fr;gap:16px;padding:44px 0;border-top:1px solid var(--hair);scroll-margin-top:100px}
.sec:first-child{border-top:0;padding-top:0}
.sec-n{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#a3ada6;padding-top:9px}
.sec h2{font-size:30px;font-weight:800;letter-spacing:-.035em;margin-bottom:18px}
.sec h2 em{font-weight:700}
.ab-tag{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:600;line-height:1.45;color:var(--ink);letter-spacing:-.01em;margin-bottom:14px}
.ab{font-size:17px;line-height:1.8;color:var(--txt);white-space:pre-line}
.note{display:flex;gap:16px;align-items:flex-start;background:#fff;border-radius:22px;padding:20px 22px;margin-top:24px;font-size:14.5px;color:var(--txt);line-height:1.6}
.note .dx-arrow{width:36px;height:36px;font-size:12px;background:var(--gold-bg);border:0;color:var(--gold-ink)}
.note a{color:var(--teal);font-weight:600;text-decoration:underline!important;text-underline-offset:3px}
.sv{display:grid;grid-template-columns:1fr 1fr;gap:0 32px}
.sv div{display:flex;align-items:center;gap:14px;padding:16px 0;border-bottom:1px solid var(--hair);font-size:16px;color:var(--ink);font-weight:500}
.sv i{color:var(--teal);width:20px;text-align:center}
.sv-empty{font-size:16px;color:var(--mut);line-height:1.7}
.sv-empty a{color:var(--ink);font-weight:700;text-decoration:underline!important;text-underline-offset:3px}
.dl{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.dl div{background:#fff;border-radius:22px;padding:20px 22px}
.dl small{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--mut);margin-bottom:8px}
.dl p{font-size:16px;color:var(--ink);font-weight:500;line-height:1.45}
.dl p.muted{color:#9aa49d;font-weight:400}
.ar{display:flex;flex-wrap:wrap;gap:8px}
.ar span{border:1px solid var(--hair);border-radius:100px;padding:9px 16px;font-size:14.5px;color:var(--ink)}
.ph{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.ph a{aspect-ratio:1;border-radius:20px;overflow:hidden;display:block}
.ph img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.ph a:hover img{transform:scale(1.05)}

/* sidebar */
.sd{position:sticky;top:96px;display:flex;flex-direction:column;gap:12px}
.cc{background:#fff;border-radius:32px;padding:30px}
.cc .dx-kick{margin-bottom:12px}
.cc-phone{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;font-weight:800;letter-spacing:-.035em;color:var(--ink);line-height:1.1;margin-bottom:22px}
.cc-phone:hover{color:var(--teal)}
.cc .dx-btn{width:100%;padding:16px}
.cc-links{margin-top:18px;border-top:1px solid var(--hair)}
.cc-links a,.cc-links div{display:flex;justify-content:space-between;align-items:center;gap:12px;padding:15px 0;border-bottom:1px solid var(--hair-2);font-size:15px;color:var(--ink);min-width:0}
.cc-links span{overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.cc-links small{color:var(--mut);font-size:13px;flex-shrink:0}
.cc-links a:hover span{color:var(--teal)}
.cc h3{font-size:24px;font-weight:800;letter-spacing:-.03em;margin-bottom:6px}
.cc-sub{font-size:14.5px;color:var(--mut);line-height:1.55;margin-bottom:22px}
.lf label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--ink);margin:0 0 7px 4px}
.lf input,.lf select,.lf textarea{width:100%;font:inherit;font-size:15px;border:1px solid var(--hair);border-radius:16px;padding:13px 16px;margin-bottom:14px;background:var(--cream);color:var(--ink);outline:0;transition:border-color .15s,background .15s}
.lf input:focus,.lf select:focus,.lf textarea:focus{border-color:var(--ink);background:#fff}
.lf-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.lf small{display:block;text-align:center;font-size:12.5px;color:var(--mut);margin-top:12px}
.lf-ok{display:none;text-align:center;padding:20px 0}
.lf-ok .dx-arrow{width:60px;height:60px;font-size:20px;background:var(--teal);color:#fff;border:0;margin-bottom:16px}
.claim{background:var(--ink);border-radius:32px;padding:30px;position:relative;overflow:hidden}
.claim::after{content:"";position:absolute;width:220px;height:220px;border-radius:50%;border:1px solid rgba(255,255,255,.08);right:-80px;top:-90px;box-shadow:0 0 0 30px rgba(255,255,255,.02),0 0 0 60px rgba(255,255,255,.015)}
.claim h3{color:#fff;font-size:22px;font-weight:800;letter-spacing:-.03em;margin-bottom:8px;position:relative}
.claim h3 em{color:var(--teal-lt)}
.claim p{color:rgba(255,255,255,.62);font-size:14.5px;line-height:1.6;margin-bottom:22px;position:relative}
.claim .dx-btn{position:relative}
.rp{text-align:center;font-size:13px;color:var(--mut);padding-top:6px}
.rp a{text-decoration:underline!important;text-underline-offset:3px}

/* nearby (on forest) */
.nb{max-width:1400px;margin:0 auto;padding:96px 36px 72px}
.nb-head{max-width:1200px;margin:0 auto 36px;display:flex;justify-content:space-between;align-items:flex-end;gap:24px;flex-wrap:wrap}
.nb .dx-h2{color:#fff}
.nb .dx-h2 em{color:var(--teal-lt)}
.nb-grid{max-width:1200px;margin:0 auto;display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.nb-card{background:var(--cream);border-radius:28px;padding:24px;display:flex;flex-direction:column;gap:28px;transition:transform .25s}
.nb-card:hover{transform:translateY(-4px)}
.nb-card:hover .dx-arrow{background:var(--ink);color:#fff;border-color:var(--ink);transform:rotate(-45deg)}
.nb-top{display:flex;justify-content:space-between;align-items:flex-start}
.nb-card h3{font-size:19px;font-weight:700;margin-bottom:4px}
.nb-card p{font-size:14px;color:var(--mut)}

@media(max-width:1100px){
  .lh{grid-template-columns:1fr;gap:36px}
  .lh-vis{min-height:320px}
  .lb{grid-template-columns:1fr;gap:24px}
  .sd{position:static}
  .nb-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:700px){
  .lh-actions .dx-btn{flex:1;padding:15px 18px}
  .lh-vis{min-height:280px;border-radius:24px}
  .sec{grid-template-columns:1fr;gap:6px;padding:34px 0}
  .sec h2{font-size:25px}
  .sv,.dl,.lf-row{grid-template-columns:1fr}
  .ph{grid-template-columns:1fr 1fr}
  .cc,.claim{padding:24px;border-radius:26px}
  .cc-phone{font-size:28px}
  .nb{padding:64px 10px 48px}
  .nb-grid{grid-template-columns:1fr}
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
$dirUrl = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($mapQuery);
$n = 0;
$num = function () use (&$n) { return str_pad((string)++$n, 2, '0', STR_PAD_LEFT); };
?>
<script type="application/ld+json"><?= json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
<script type="application/ld+json"><?= json_encode($crumbs, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>

<div id="scrollProgress"></div>
<div class="dx">
<div class="dx-frame is-first">

  <!-- HEADER -->
  <header class="dx-panel">
    <div class="dx-in lh">
      <div class="lh-id">
        <div class="dx-crumbs" style="margin-bottom:28px">
          <a href="/directory/">Directory</a><i class="fa-solid fa-chevron-right"></i>
          <a href="/directory/?loc=<?= urlencode($l['state']) ?>#results"><?= htmlspecialchars($l['state']) ?></a><i class="fa-solid fa-chevron-right"></i>
          <a href="/directory/?loc=<?= urlencode($l['city'] . ', ' . $l['state']) ?>#results"><?= htmlspecialchars($l['city']) ?></a>
        </div>
        <?= hc_dir_logo($l, 96, $paid) ?>
        <?php $b = hc_dir_badges($l, $tier); ?>
        <div class="lh-badges"><?= $b ?: '<span class="dx-badge is-licensed">Home care agency</span>' ?></div>
        <h1 class="dx-h1"><?= htmlspecialchars($l['company_name']) ?></h1>
        <div class="lh-meta">
          <span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></span>
          <?php if ($l['years_in_business']): ?><span><?= htmlspecialchars($l['years_in_business']) ?> years in business</span><?php endif ?>
          <?php if ($l['license_number']): ?><span>License #<?= htmlspecialchars($l['license_number']) ?></span><?php endif ?>
        </div>
        <div class="lh-actions">
          <?php if ($l['phone']): ?><a class="dx-btn is-dark" href="tel:<?= htmlspecialchars($phoneHref) ?>"><i class="fa-solid fa-phone"></i><?= htmlspecialchars($l['phone']) ?></a><?php endif ?>
          <?php if ($featured): ?><a class="dx-btn is-teal" href="#contact">Request a consultation</a><?php endif ?>
          <?php if ($paid && $l['website']): ?><a class="dx-btn" href="<?= htmlspecialchars($l['website']) ?>" target="_blank" rel="noopener">Website <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:11px"></i></a><?php endif ?>
          <button class="dx-btn" type="button" id="lxShare" aria-label="Share"><i class="fa-solid fa-arrow-up-from-bracket"></i></button>
        </div>
      </div>
      <?php if ($cover): ?>
      <div class="lh-vis is-cover" style="background-image:url('<?= htmlspecialchars($cover) ?>')"></div>
      <?php else: ?>
      <div class="lh-vis">
        <iframe loading="lazy" title="Map of <?= htmlspecialchars($l['company_name']) ?>" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=<?= urlencode($mapQuery) ?>&z=<?= $l['address'] ? 14 : 11 ?>&output=embed"></iframe>
        <a class="lh-pin" href="<?= htmlspecialchars($dirUrl) ?>" target="_blank" rel="noopener nofollow">
          <?= hc_dir_logo($l, 44, $paid) ?>
          <div style="min-width:0"><b><?= htmlspecialchars($l['address'] ?: $l['city'] . ', ' . $l['state']) ?></b><span>Get directions</span></div>
          <span class="dx-arrow is-dark"><i class="fa-solid fa-arrow-right"></i></span>
        </a>
      </div>
      <?php endif ?>
    </div>
  </header>

  <!-- BODY -->
  <section class="dx-panel">
    <div class="dx-in lb">
      <main>
        <div class="sec" id="about">
          <div class="sec-n"><?= $num() ?></div>
          <div>
            <h2>Overview</h2>
            <?php if ($paid && $l['tagline']): ?><p class="ab-tag"><?= htmlspecialchars($l['tagline']) ?></p><?php endif ?>
            <div class="ab"><?= htmlspecialchars($about) ?></div>
            <?php if (!$hasOwner): ?>
            <div class="note"><span class="dx-arrow"><i class="fa-solid fa-info"></i></span><div>This profile hasn't been claimed by the agency yet, so some details may be incomplete. Please confirm services and availability when you call. <a href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>">Is this your agency?</a></div></div>
            <?php endif ?>
          </div>
        </div>

        <div class="sec" id="services">
          <div class="sec-n"><?= $num() ?></div>
          <div>
            <h2>Services</h2>
            <?php if ($services): ?>
            <div class="sv"><?php foreach ($services as $s): ?><div><i class="fa-solid <?= $svcIcons[$s] ?? 'fa-check' ?>"></i><?= htmlspecialchars($s) ?></div><?php endforeach ?></div>
            <?php else: ?>
            <p class="sv-empty">This agency hasn't listed its services yet. <?= $l['phone'] ? 'Call <a href="tel:' . htmlspecialchars($phoneHref) . '">' . htmlspecialchars($l['phone']) . '</a>' : 'Contact them' ?> to ask about personal care, companion care, skilled nursing and more.</p>
            <?php endif ?>
          </div>
        </div>

        <div class="sec" id="details">
          <div class="sec-n"><?= $num() ?></div>
          <div>
            <h2>Details</h2>
            <div class="dl">
              <div><small>Payment</small><p class="<?= $payments ? '' : 'muted' ?>"><?= $payments ? htmlspecialchars(implode(', ', $payments)) : 'Ask the agency' ?></p></div>
              <div><small>Languages</small><p class="<?= $l['languages'] ? '' : 'muted' ?>"><?= $l['languages'] ? htmlspecialchars($l['languages']) : 'Ask the agency' ?></p></div>
              <div><small>Hours</small><p class="<?= $l['hours'] ? '' : 'muted' ?>"><?= $l['hours'] ? htmlspecialchars($l['hours']) : 'Ask the agency' ?></p></div>
              <div><small>License</small><p class="<?= $l['license_number'] ? '' : 'muted' ?>"><?= $l['license_number'] ? '#' . htmlspecialchars($l['license_number']) : 'Not provided' ?></p></div>
            </div>
          </div>
        </div>

        <?php if ($areas): ?>
        <div class="sec" id="areas">
          <div class="sec-n"><?= $num() ?></div>
          <div>
            <h2>Areas served</h2>
            <div class="ar"><?php foreach ($areas as $a): ?><span><?= htmlspecialchars($a) ?></span><?php endforeach ?></div>
          </div>
        </div>
        <?php endif ?>

        <?php if ($photos): ?>
        <div class="sec" id="photos">
          <div class="sec-n"><?= $num() ?></div>
          <div>
            <h2>Photos</h2>
            <div class="ph"><?php foreach ($photos as $p): ?><a href="<?= htmlspecialchars($p) ?>" target="_blank" rel="noopener"><img src="<?= htmlspecialchars($p) ?>" alt="<?= htmlspecialchars($l['company_name']) ?> photo" loading="lazy"></a><?php endforeach ?></div>
          </div>
        </div>
        <?php endif ?>
      </main>

      <aside class="sd" id="contact">
        <?php if ($featured): ?>
        <div class="cc">
          <h3>Request a <em>free</em> consultation</h3>
          <p class="cc-sub">Tell <?= htmlspecialchars($l['company_name']) ?> what you need. Your request goes straight to the agency.</p>
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
            <button class="dx-btn is-dark" type="submit" id="lxBtn">Send request <i class="fa-solid fa-arrow-right" style="font-size:12px"></i></button>
            <small>Shared only with this agency. No spam.</small>
          </form>
          <div class="lf-ok" id="lxOk"><span class="dx-arrow"><i class="fa-solid fa-check"></i></span><h3>Request sent</h3><p class="cc-sub" style="margin:0">The agency will be in touch shortly.</p></div>
        </div>
        <?php endif ?>

        <div class="cc">
          <div class="dx-kick">Contact</div>
          <?php if ($l['phone']): ?>
          <a class="cc-phone" href="tel:<?= htmlspecialchars($phoneHref) ?>"><?= htmlspecialchars($l['phone']) ?></a>
          <a class="dx-btn is-dark" href="tel:<?= htmlspecialchars($phoneHref) ?>"><i class="fa-solid fa-phone"></i>Call the agency</a>
          <?php else: ?>
          <p class="cc-sub">No phone number listed yet.</p>
          <?php endif ?>
          <div class="cc-links">
            <?php if ($paid && $l['website']): ?><a href="<?= htmlspecialchars($l['website']) ?>" target="_blank" rel="noopener"><span><?= htmlspecialchars(hc_dir_domain($l['website'])) ?></span><small>Website ↗</small></a><?php endif ?>
            <?php if ($paid && $l['email']): ?><a href="mailto:<?= htmlspecialchars($l['email']) ?>"><span><?= htmlspecialchars($l['email']) ?></span><small>Email</small></a><?php endif ?>
            <a href="<?= htmlspecialchars($dirUrl) ?>" target="_blank" rel="noopener nofollow"><span><?= htmlspecialchars($mapQuery) ?></span><small>Directions ↗</small></a>
          </div>
        </div>

        <?php if (!$hasOwner): ?>
        <div class="claim">
          <h3>Is this <em>your</em> agency?</h3>
          <p>Claim this free profile to update your details, add your logo and photos, and earn a Verified badge.</p>
          <a class="dx-btn is-teal" href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>">Claim this listing <i class="fa-solid fa-arrow-right" style="font-size:12px"></i></a>
        </div>
        <?php elseif (!$paid): ?>
        <div class="claim">
          <h3>Stand out in <em><?= htmlspecialchars($l['city']) ?>.</em></h3>
          <p>Add your logo, photos and website link, and appear above other agencies nearby.</p>
          <a class="dx-btn is-teal" href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>&plan=premium">See upgrade options <i class="fa-solid fa-arrow-right" style="font-size:12px"></i></a>
        </div>
        <?php endif ?>
        <div class="rp"><a href="mailto:info@homecarecreators.com?subject=<?= rawurlencode('Directory listing correction: ' . $l['company_name']) ?>">Suggest an edit or report this listing</a></div>
      </aside>
    </div>
  </section>

  <?php if ($nearby): ?>
  <section class="nb">
    <div class="nb-head">
      <h2 class="dx-h2">More agencies <em>near <?= htmlspecialchars($l['city']) ?>.</em></h2>
      <a class="dx-btn is-line-light" href="/directory/?loc=<?= urlencode($l['state']) ?>#results">See all in <?= htmlspecialchars($l['state']) ?></a>
    </div>
    <div class="nb-grid">
      <?php foreach ($nearby as $nb): $nt = hc_dir_tier($nb); ?>
      <a class="nb-card" href="/directory/<?= urlencode($nb['slug']) ?>">
        <div class="nb-top"><?= hc_dir_logo($nb, 56, $nt !== 'free') ?><span class="dx-arrow"><i class="fa-solid fa-arrow-right"></i></span></div>
        <div><h3><?= htmlspecialchars($nb['company_name']) ?></h3><p><?= htmlspecialchars($nb['city'] . ', ' . $nb['state']) ?><?= $nt === 'featured' ? ' · Featured' : '' ?></p></div>
      </a>
      <?php endforeach ?>
    </div>
  </section>
  <?php endif ?>

</div>
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
