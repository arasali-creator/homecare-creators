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
$features = array_values(array_filter(hc_dir_lines($l['features']), fn($f) => isset(HC_DIR_FEATURES[$f])));
$areas    = hc_dir_areas($l['service_areas']);
$payments = hc_dir_lines($l['payment_accepted']);
$photos   = $paid ? array_slice(hc_dir_lines($l['photos']), 0, 12) : [];
$hours    = hc_dir_hours($l);
$open     = hc_dir_open_status($l);
$hasOwner = !empty($l['owner_confirmed_at']);
$claimed  = hc_dir_is_claimed($l);
$about    = hc_dir_public_desc($l);
$canonical = "https://homecarecreators.com/directory/" . $l['slug'];
$addrLine  = trim(preg_replace('/,?\s*(United States|USA|US)\.?$/i', '', (string)$l['address']));
$addrHasCity = $addrLine !== '' && stripos($addrLine, (string)$l['city']) !== false;
$cityLine  = $l['city'] . ', ' . $l['state'];
$mapQuery  = $addrLine ? ($addrHasCity ? $addrLine : $addrLine . ', ' . $cityLine) : $cityLine;
$phoneHref = preg_replace('/[^0-9+]/', '', (string)$l['phone']);
$dirUrl    = 'https://www.google.com/maps/dir/?api=1&destination=' . urlencode($mapQuery);
$hasGeo    = $l['lat'] !== null && $l['lng'] !== null;

// Reviews
$rSort = in_array($_GET['rsort'] ?? '', ['high', 'low'], true) ? $_GET['rsort'] : 'new';
$rOrder = ['new' => 'created_at DESC', 'high' => 'rating DESC, created_at DESC', 'low' => 'rating ASC, created_at DESC'][$rSort];
$reviews = hc_all("SELECT * FROM hc_directory_reviews WHERE listing_id=? AND status='approved' ORDER BY $rOrder LIMIT 50", [$l['id']]);
$dist = array_fill(1, 5, 0);
foreach (hc_all("SELECT rating, COUNT(*) n FROM hc_directory_reviews WHERE listing_id=? AND status='approved' GROUP BY rating", [$l['id']]) as $r) $dist[(int)$r['rating']] = (int)$r['n'];
$rCount = array_sum($dist);

// People also viewed (Basic profiles only — no competitor ads on paid profiles)
$nearby = $paid ? [] : hc_all(
    "SELECT * FROM hc_directory_listings WHERE status='approved' AND id<>? AND state=? ORDER BY (city=?) DESC, " . hc_dir_rank_sql() . " DESC, rating_count DESC, RAND() LIMIT 4",
    [$l['id'], $l['state'], $l['city']]
);

// Data-driven FAQ (only questions we can actually answer)
$name = $l['company_name'];
$faq = [];
if ($services) $faq[] = ["What services does {$name} offer?", "{$name} offers " . strtolower(implode(', ', array_slice($services, 0, -1))) . (count($services) > 1 ? ' and ' : '') . strtolower(end($services)) . '.'];
$faq[] = ["Where is {$name} located?", "{$name} is based in {$l['city']}, {$l['state']}" . ($areas ? ' and serves ' . implode(', ', array_slice($areas, 0, 6)) . (count($areas) > 6 ? ' and nearby areas' : '') : '') . '.'];
if ($payments) $faq[] = ["What payment options does {$name} accept?", "{$name} accepts " . implode(', ', $payments) . '.'];
if ($hours) {
    if (!empty($hours['always'])) $faq[] = ["What are {$name}'s hours?", "{$name} is available 24 hours a day, 7 days a week."];
    else { $parts = []; foreach (HC_DIR_DAYS as $k => $d) $parts[] = $d . ' ' . ($hours[$k] ? hc_dir_fmt_time($hours[$k][0]) . '–' . hc_dir_fmt_time($hours[$k][1]) : 'closed'); $faq[] = ["What are {$name}'s office hours?", implode('; ', $parts) . '.']; }
}
if ($l['license_number']) $faq[] = ["Is {$name} licensed?", "{$name} lists state license number {$l['license_number']}. You can confirm it with your state's licensing agency."];
if ($l['phone']) $faq[] = ["How do I contact {$name}?", "Call {$name} at {$l['phone']}" . ($featured ? ', or send a consultation request from this page' : '') . '.'];

$page_title = $l['company_name'] . ' — Home Care in ' . $l['city'] . ', ' . $l['state'] . ($rCount ? ' (' . $rCount . ' Reviews)' : '') . ' | Homecare Creators';
$page_desc  = mb_strlen($about) > 158 ? rtrim(mb_substr($about, 0, 155)) . '…' : $about;
$page_canonical = $canonical;
$og_title = $l['company_name'] . ' — Home Care in ' . $l['city'] . ', ' . $l['state'];
$og_desc  = $page_desc;
$og_image = ($paid ? ($l['cover_image'] ?: ($photos[0] ?? '')) : '') ?: ($l['logo'] ?: null);
if ($og_image && !str_starts_with($og_image, 'http')) $og_image = 'https://homecarecreators.com' . $og_image;

$svcIcons = [
    'Personal Care' => 'fa-hand-holding-heart', 'Companion Care' => 'fa-people-arrows', 'Skilled Nursing' => 'fa-user-nurse',
    'Alzheimer\'s & Dementia Care' => 'fa-brain', '24-Hour Care' => 'fa-clock', 'Live-In Care' => 'fa-house-user',
    'Respite Care' => 'fa-mug-hot', 'Post-Hospital Care' => 'fa-hospital', 'Medication Management' => 'fa-pills',
    'Homemaker Services' => 'fa-broom', 'Transportation' => 'fa-car', 'Hospice Support' => 'fa-dove',
];
$gallery = $paid ? array_values(array_filter(array_merge([$l['cover_image']], $photos))) : [];

$page_css = hc_dir_base_css() . hc_dir_extra_css() . <<<CSS
/* ── GALLERY (paid with photos) ─────────── */
.gl{display:grid;grid-template-columns:2fr 1fr 1fr;grid-template-rows:180px 180px;gap:8px;border-radius:28px;overflow:hidden;margin-bottom:32px;position:relative}
.gl a{display:block;background-size:cover;background-position:center}
.gl a:first-child{grid-row:1/3}
.gl .all{position:absolute;right:16px;bottom:16px;background:#fff;color:var(--ink);border-radius:100px;padding:10px 16px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;box-shadow:0 8px 20px rgba(0,0,0,.15)}

/* ── HEADER ─────────────────────────────── */
.bh{display:grid;grid-template-columns:auto 1fr;gap:26px;align-items:start}
.bh h1{font-size:clamp(32px,4.2vw,54px);font-weight:800;letter-spacing:-.045em;line-height:1.02;margin-bottom:12px;overflow-wrap:anywhere}
.bh-rate{display:flex;flex-wrap:wrap;align-items:center;gap:8px 14px;margin-bottom:10px}
.bh-rate a{font-size:14px;color:var(--mut)}
.bh-rate a:hover{color:var(--ink);text-decoration:underline!important}
.cl-yes{display:inline-flex;align-items:center;gap:6px;font-size:14px;font-weight:600;color:#2c62c9}
.cl-no{display:inline-flex;align-items:center;gap:6px;font-size:14px;color:var(--mut)}
.cl-no a{color:var(--ink);text-decoration:underline!important;text-underline-offset:3px}
.bh-cats{font-size:15px;color:var(--txt);margin-bottom:8px}
.bh-cats a{color:var(--ink);font-weight:500}
.bh-cats a:hover{color:var(--teal)}
.bh-open{display:flex;flex-wrap:wrap;align-items:center;gap:6px 14px;font-size:15px}
.bh-open a{color:var(--ink);font-weight:600;text-decoration:underline!important;text-underline-offset:3px;font-size:14px}
.bh-acts{display:flex;flex-wrap:wrap;gap:10px;margin-top:28px;padding-top:28px;border-top:1px solid var(--hair)}
.bh-acts .dx-btn{padding:14px 20px}
.bh-acts .dx-btn.saved i{color:#d6455d}

/* ── BODY ───────────────────────────────── */
.bz{display:grid;grid-template-columns:minmax(0,1fr) 380px;gap:56px;align-items:start}
.bs{padding:40px 0;border-top:1px solid var(--hair);scroll-margin-top:100px}
.bs:first-child{border-top:0;padding-top:0}
.bs h2{font-size:26px;font-weight:800;letter-spacing:-.035em;margin-bottom:20px}
.bs h2 em{font-weight:700}
.bs h2 small{font-family:'DM Sans',sans-serif;font-size:14px;font-weight:400;color:var(--mut);letter-spacing:0;margin-left:8px}
.am{display:grid;grid-template-columns:1fr 1fr;gap:0 32px}
.am div{display:flex;align-items:center;gap:14px;padding:14px 0;font-size:15.5px;color:var(--ink)}
.am i{width:22px;text-align:center;font-size:17px;color:var(--ink)}
.am .more{display:none}
.am.open .more{display:flex}
.am-btn{margin-top:14px}
.empty-txt{font-size:15.5px;color:var(--mut);line-height:1.7}
.empty-txt a{color:var(--ink);font-weight:600;text-decoration:underline!important;text-underline-offset:3px}
.lo{background:#fff;border-radius:26px;overflow:hidden}
.lo-map{height:260px;position:relative;background:#e6e2d8}
.lo-map iframe,.lo-map #bizMap{position:absolute;inset:0;width:100%;height:100%;border:0}
.lo-body{display:grid;grid-template-columns:1fr 1fr}
.lo-addr{display:flex;gap:16px;padding:26px 28px}
.lo-ic{width:46px;height:46px;border-radius:50%;background:var(--ink);color:#fff;display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.lo-addr small,.lo-hrs-h small{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.1px;text-transform:uppercase;color:var(--mut);margin-bottom:6px}
.lo-addr b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:700;color:var(--ink);letter-spacing:-.02em;line-height:1.3}
.lo-addr span{display:block;font-size:15px;color:var(--mut);margin-top:3px}
.lo-btns{display:flex;flex-wrap:wrap;gap:8px;margin-top:18px}
.lo-btns .dx-btn{padding:11px 16px;font-size:13.5px}
.lo-hrs{padding:26px 28px;border-left:1px solid var(--hair-2)}
.lo-hrs-h{display:flex;justify-content:space-between;align-items:flex-start;gap:10px}
.lo-chip{display:inline-flex;align-items:center;gap:7px;border-radius:100px;padding:6px 12px;font-size:12.5px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}
.lo-chip i{width:7px;height:7px;border-radius:50%;background:currentColor}
.lo-chip.is-open{background:#e3f4ec;color:#0b8a5a}
.lo-chip.is-closed{background:#fdeee6;color:#c2410c}
.lo-days{list-style:none;margin:6px 0 0;padding:0}
.lo-days li{display:flex;justify-content:space-between;gap:12px;padding:9px 12px;margin:0 -12px;border-radius:12px;font-size:14.5px;color:var(--txt)}
.lo-days li span:first-child{font-weight:600;color:var(--ink)}
.lo-days li.off span:last-child{color:var(--mut)}
.lo-days li.today{background:var(--cream)}
.lo-days li.today span{font-weight:700;color:var(--ink)}
.lo-days em{font-style:normal;font-size:11px;font-weight:700;color:var(--teal);margin-left:6px;text-transform:uppercase;letter-spacing:.6px}
.lo-247{display:flex;align-items:center;gap:16px;margin-top:10px}
.lo-247 b{font-family:'Plus Jakarta Sans',sans-serif;font-size:40px;font-weight:800;letter-spacing:-.04em;color:var(--ink)}
.lo-247 span{font-size:14.5px;color:var(--mut);line-height:1.5}
.lo-none{font-size:14.5px;color:var(--mut);line-height:1.65;margin-top:8px}
.lo-none a{color:var(--ink);font-weight:600;text-decoration:underline!important;text-underline-offset:3px}
.lo-note{font-size:13.5px;color:var(--mut);margin-top:12px;padding-top:12px;border-top:1px solid var(--hair-2)}
.ar-grid{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:10px}
.ar{display:flex;align-items:center;gap:12px;background:#fff;border-radius:18px;padding:14px 16px;font-size:15px;font-weight:500;color:var(--ink);min-width:0}
.ar span:last-child{min-width:0;overflow-wrap:anywhere}
.ar small{display:block;font-size:11.5px;font-weight:600;color:var(--teal);margin-top:1px}
.ar-ic{width:34px;height:34px;border-radius:50%;background:var(--cream);color:var(--ink);display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0}
.ar.is-home{background:var(--ink);color:#fff}
.ar.is-home .ar-ic{background:rgba(255,255,255,.12);color:#fff}
.ar.is-home small{color:var(--teal-lt)}
.ar.more{display:none}
.ar-grid.open .ar.more{display:flex}
.ar-note{display:flex;gap:10px;align-items:center;font-size:13.5px;color:var(--mut);margin-top:16px}
.ab-tag{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:600;line-height:1.45;color:var(--ink);margin-bottom:14px}
.ab{font-size:16.5px;line-height:1.8;color:var(--txt);white-space:pre-line}
.facts{display:grid;grid-template-columns:repeat(3,1fr);gap:10px;margin-top:22px}
.facts div{background:#fff;border-radius:20px;padding:18px 20px}
.facts small{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.1px;text-transform:uppercase;color:var(--mut);margin-bottom:6px}
.facts p{font-size:15px;color:var(--ink);font-weight:500;line-height:1.4}
.chips{display:flex;flex-wrap:wrap;gap:8px}
.chips span{border:1px solid var(--hair);border-radius:100px;padding:8px 15px;font-size:14px;color:var(--ink);background:#fff}
.note{display:flex;gap:14px;align-items:flex-start;background:#fff;border-radius:20px;padding:18px 20px;margin-top:22px;font-size:14.5px;color:var(--txt);line-height:1.6}
.note i{color:#c9a84c;margin-top:4px}
.note a{color:var(--ink);font-weight:600;text-decoration:underline!important;text-underline-offset:3px}
.ph{display:grid;grid-template-columns:repeat(4,1fr);gap:8px}
.ph a{aspect-ratio:1;border-radius:16px;overflow:hidden;display:block}
.ph img{width:100%;height:100%;object-fit:cover;transition:transform .4s}
.ph a:hover img{transform:scale(1.05)}

/* reviews */
.rv-sum{display:grid;grid-template-columns:220px 1fr;gap:36px;align-items:center;background:#fff;border-radius:26px;padding:28px;margin-bottom:22px}
.rv-big b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:56px;font-weight:800;letter-spacing:-.05em;color:var(--ink);line-height:1;margin-bottom:10px}
.rv-big span{display:block;font-size:14px;color:var(--mut);margin-top:8px}
.rv-bars div{display:grid;grid-template-columns:52px 1fr 30px;gap:12px;align-items:center;font-size:13.5px;color:var(--mut);padding:3px 0}
.rv-bar{height:10px;border-radius:100px;background:#efece4;overflow:hidden}
.rv-bar i{display:block;height:100%;background:#e0a020;border-radius:100px}
.rv-tools{display:flex;justify-content:space-between;align-items:center;gap:12px;flex-wrap:wrap;margin-bottom:6px}
.rv-tools select{appearance:none;-webkit-appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%230a2e1e' stroke-width='1.5' fill='none'/%3E%3C/svg%3E") no-repeat right 14px center;border:1px solid var(--hair);border-radius:100px;padding:10px 34px 10px 16px;font:inherit;font-size:13.5px;font-weight:600;color:var(--ink);cursor:pointer}
.rv{padding:26px 0;border-bottom:1px solid var(--hair)}
.rv-who{display:flex;align-items:center;gap:12px;margin-bottom:12px}
.rv-av{width:46px;height:46px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;flex-shrink:0}
.rv-who b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;color:var(--ink)}
.rv-who span{font-size:13px;color:var(--mut)}
.rv-meta{display:flex;align-items:center;gap:10px;margin-bottom:10px;font-size:13.5px;color:var(--mut)}
.rv h4{font-size:16.5px;font-weight:700;margin-bottom:6px}
.rv p{font-size:15.5px;line-height:1.7;color:var(--txt);white-space:pre-line}
.rv-resp{margin-top:14px;background:#fff;border-radius:18px;padding:16px 18px;border-left:3px solid var(--teal)}
.rv-resp b{display:block;font-size:13.5px;color:var(--ink);margin-bottom:4px;font-family:'Plus Jakarta Sans',sans-serif}
.rv-resp p{font-size:14.5px}
.rv-empty{background:#fff;border-radius:26px;padding:36px;text-align:center}
.rv-empty h3{font-size:20px;font-weight:800;margin-bottom:6px}
.rv-empty p{color:var(--mut);margin-bottom:18px;font-size:15px}
.wr{display:none;background:#fff;border-radius:26px;padding:28px;margin-bottom:22px}
.wr.open{display:block}
.wr h3{font-size:22px;font-weight:800;letter-spacing:-.03em;margin-bottom:4px}
.wr-sub{font-size:14px;color:var(--mut);margin-bottom:18px}
.wr-stars{display:flex;gap:6px;margin-bottom:6px}
.wr-stars button{width:44px;height:44px;border-radius:8px;border:0;background:#d9d6cc;color:#fff;font-size:20px;cursor:pointer;transition:background .12s,transform .12s}
.wr-stars button.on{background:#e0a020}
.wr-stars button:hover{transform:scale(1.06)}
.wr-hint{font-size:13.5px;color:var(--mut);margin-bottom:18px;min-height:20px}
.fm label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--ink);margin:0 0 7px 4px}
.fm input,.fm select,.fm textarea{width:100%;font:inherit;font-size:15px;border:1px solid var(--hair);border-radius:16px;padding:13px 16px;margin-bottom:14px;background:var(--cream);color:var(--ink);outline:0;transition:border-color .15s,background .15s}
.fm input:focus,.fm select:focus,.fm textarea:focus{border-color:var(--ink);background:#fff}
.fm-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.fm small{display:block;font-size:12.5px;color:var(--mut);margin-top:10px;line-height:1.5}
.fm-ok{display:none;text-align:center;padding:16px 0}
.fm-ok .dx-arrow{width:56px;height:56px;font-size:20px;background:var(--teal);color:#fff;border:0;margin-bottom:14px}
.fq details{border-bottom:1px solid var(--hair)}
.fq summary{list-style:none;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px;padding:18px 0;font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--ink)}
.fq summary::-webkit-details-marker{display:none}
.fq summary .dx-arrow{width:32px;height:32px;font-size:11px;transition:transform .25s}
.fq details[open] summary .dx-arrow{transform:rotate(45deg);background:var(--ink);color:#fff;border-color:var(--ink)}
.fq details p{font-size:15px;color:var(--mut);line-height:1.7;padding:0 40px 18px 0}
.pv{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.pv a{display:flex;gap:14px;align-items:center;background:#fff;border-radius:22px;padding:16px;transition:box-shadow .2s}
.pv a:hover{box-shadow:0 12px 30px rgba(10,46,30,.08)}
.pv b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:15.5px;color:var(--ink);margin-bottom:4px;line-height:1.3}
.pv span{font-size:13px;color:var(--mut)}

/* sidebar */
.sd{position:sticky;top:96px;display:flex;flex-direction:column;gap:12px}
.cc{background:#fff;border-radius:28px;padding:26px}
.cc h3{font-size:22px;font-weight:800;letter-spacing:-.03em;margin-bottom:6px}
.cc-sub{font-size:14.5px;color:var(--mut);line-height:1.55;margin-bottom:18px}
.cr{display:flex;justify-content:space-between;align-items:center;gap:14px;padding:16px 0;border-top:1px solid var(--hair-2);min-width:0}
.cr:first-child{border-top:0;padding-top:2px}
.cr div{min-width:0}
.cr b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:15.5px;color:var(--ink);overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.cr span{font-size:13px;color:var(--mut)}
.cr i{color:var(--ink);font-size:16px;flex-shrink:0}
a.cr:hover b{color:var(--teal)}
.cc-edit{display:block;text-align:center;font-size:13.5px;color:var(--mut);padding-top:12px;border-top:1px solid var(--hair-2);margin-top:4px}
.cc-edit:hover{color:var(--ink)}
.claim{background:#fff;border-radius:28px;padding:24px;display:flex;gap:14px;align-items:flex-start}
.claim b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;color:var(--ink);margin-bottom:4px}
.claim p{font-size:14px;color:var(--mut);line-height:1.55;margin-bottom:12px}
.claim a.go{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--teal)}
.mbar{display:none}

@media(max-width:1100px){
  .bz{grid-template-columns:1fr;gap:12px}
  .sd{position:static}
  .lo-body{grid-template-columns:1fr}
  .lo-hrs{border-left:0;border-top:1px solid var(--hair-2)}
  .ar-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:700px){
  .gl{grid-template-columns:1fr 1fr;grid-template-rows:160px 100px;border-radius:22px}
  .gl a:first-child{grid-column:1/3;grid-row:1}
  .gl a:nth-child(n+4){display:none}
  .bh{grid-template-columns:1fr;gap:16px}
  .bh .dx-logo{width:72px!important;height:72px!important;font-size:24px!important}
  .bh-acts .dx-btn{flex:1 1 auto}
  .am,.fm-row,.pv{grid-template-columns:1fr}
  .facts{grid-template-columns:1fr 1fr}
  .rv-sum{grid-template-columns:1fr;gap:18px;padding:22px}
  .ph{grid-template-columns:repeat(3,1fr)}
  .cc,.claim{border-radius:24px;padding:22px}
  .mbar{display:flex;gap:8px;position:fixed;left:10px;right:10px;bottom:10px;z-index:400;background:#fff;border-radius:100px;padding:8px;box-shadow:0 12px 40px rgba(10,46,30,.25)}
  .mbar .dx-btn{flex:1;padding:14px}
  footer{padding-bottom:90px!important}
}
CSS;
include '../includes/header.php';
if ($hasGeo) echo hc_dir_leaflet_head();

$ld = array_filter([
    '@context'    => 'https://schema.org',
    '@type'       => 'LocalBusiness',
    '@id'         => $canonical . '#business',
    'name'        => $l['company_name'],
    'description' => $about,
    'image'       => $l['logo'] ? (str_starts_with($l['logo'], 'http') ? $l['logo'] : 'https://homecarecreators.com' . $l['logo']) : null,
    'telephone'   => $l['phone'] ?: null,
    'url'         => ($paid && $l['website']) ? $l['website'] : $canonical,
    'address'     => array_filter(['@type' => 'PostalAddress', 'streetAddress' => $l['address'] ?: null, 'addressLocality' => $l['city'], 'addressRegion' => $l['state'], 'addressCountry' => 'US']),
    'geo'         => $hasGeo ? ['@type' => 'GeoCoordinates', 'latitude' => (float)$l['lat'], 'longitude' => (float)$l['lng']] : null,
    'areaServed'  => $areas ?: [$l['city']],
    'paymentAccepted' => $payments ? implode(', ', $payments) : null,
    'aggregateRating' => $rCount ? ['@type' => 'AggregateRating', 'ratingValue' => (float)$l['rating_avg'], 'reviewCount' => $rCount, 'bestRating' => 5, 'worstRating' => 1] : null,
    'review'      => $reviews ? array_map(fn($r) => ['@type' => 'Review', 'author' => ['@type' => 'Person', 'name' => explode(' ', $r['name'])[0]], 'datePublished' => date('Y-m-d', strtotime($r['created_at'])), 'reviewRating' => ['@type' => 'Rating', 'ratingValue' => (int)$r['rating'], 'bestRating' => 5], 'reviewBody' => $r['body']], array_slice($reviews, 0, 5)) : null,
    'makesOffer'  => $services ? array_map(fn($s) => ['@type' => 'Offer', 'itemOffered' => ['@type' => 'Service', 'name' => $s]], $services) : null,
]);
$crumbs = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Directory', 'item' => 'https://homecarecreators.com/directory/'],
    ['@type' => 'ListItem', 'position' => 2, 'name' => $l['city'] . ', ' . $l['state'], 'item' => 'https://homecarecreators.com/directory/?loc=' . urlencode($l['city'] . ', ' . $l['state'])],
    ['@type' => 'ListItem', 'position' => 3, 'name' => $l['company_name'], 'item' => $canonical],
]];
$cityLink = '/directory/?loc=' . urlencode($l['city'] . ', ' . $l['state']) . '#results';
?>
<script type="application/ld+json"><?= json_encode($ld, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
<script type="application/ld+json"><?= json_encode($crumbs, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>

<div id="scrollProgress"></div>
<div class="dx">
<div class="dx-frame is-first">

  <!-- HEADER -->
  <header class="dx-panel" style="padding-top:48px;padding-bottom:48px">
    <div class="dx-in">
      <div class="dx-crumbs">
        <a href="/directory/">Directory</a><i class="fa-solid fa-chevron-right"></i>
        <a href="/directory/?loc=<?= urlencode($l['state']) ?>#results"><?= htmlspecialchars($l['state']) ?></a><i class="fa-solid fa-chevron-right"></i>
        <a href="<?= htmlspecialchars($cityLink) ?>"><?= htmlspecialchars($l['city']) ?></a><i class="fa-solid fa-chevron-right"></i>
        <span><?= htmlspecialchars($l['company_name']) ?></span>
      </div>

      <?php if (count($gallery) >= 3): ?>
      <div class="gl">
        <?php foreach (array_slice($gallery, 0, 5) as $g): ?><a href="<?= htmlspecialchars($g) ?>" target="_blank" rel="noopener" style="background-image:url('<?= htmlspecialchars($g) ?>')" aria-label="Photo"></a><?php endforeach ?>
        <a class="all" href="#photos">See all <?= count($gallery) ?> photos</a>
      </div>
      <?php endif ?>

      <div class="bh">
        <?= hc_dir_logo($l, 104) ?>
        <div style="min-width:0">
          <h1><?= htmlspecialchars($l['company_name']) ?></h1>
          <div class="bh-rate">
            <span><?= hc_dir_rating_line($l, 'lg') ?></span>
            <?php if ($claimed): ?><span class="cl-yes"><i class="fa-solid fa-circle-check"></i>Claimed</span>
            <?php elseif (!$hasOwner): ?><span class="cl-no"><i class="fa-regular fa-circle"></i>Unclaimed · <a href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>">Claim this business</a></span><?php endif ?>
            <?= hc_dir_badges($l, $tier, true) ?>
          </div>
          <div class="bh-cats">
            <?php if ($services): ?>
              <?php foreach (array_slice($services, 0, 4) as $i => $s): ?><?= $i ? ', ' : '' ?><a href="/directory/?<?= htmlspecialchars(http_build_query(['svc' => [$s], 'loc' => $l['city'] . ', ' . $l['state']])) ?>#results"><?= htmlspecialchars($s) ?></a><?php endforeach ?>
              <?= count($services) > 4 ? ' <span style="color:var(--mut)">+' . (count($services) - 4) . ' more</span>' : '' ?>
            <?php else: ?>Home care agency<?php endif ?>
            <span style="color:var(--mut)"> · <?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></span>
          </div>
          <div class="bh-open">
            <?php if ($open): ?><?= hc_dir_open_html($l) ?> <a href="#hours">See hours</a><?php else: ?><span style="color:var(--mut);font-size:14.5px">Hours not listed</span><?php endif ?>
            <?php if ($l['years_in_business']): ?><span style="color:var(--mut);font-size:14.5px">· <?= htmlspecialchars($l['years_in_business']) ?> years in business</span><?php endif ?>
          </div>
        </div>
      </div>

      <div class="bh-acts">
        <button class="dx-btn is-dark" type="button" onclick="openReview()"><i class="fa-regular fa-star"></i>Write a review</button>
        <?php if ($featured): ?><a class="dx-btn is-teal" href="#contact"><i class="fa-regular fa-paper-plane"></i>Request a consultation</a><?php endif ?>
        <?php if ($l['phone']): ?><a class="dx-btn" href="tel:<?= htmlspecialchars($phoneHref) ?>"><i class="fa-solid fa-phone"></i>Call</a><?php endif ?>
        <a class="dx-btn" href="<?= htmlspecialchars($dirUrl) ?>" target="_blank" rel="noopener nofollow"><i class="fa-solid fa-diamond-turn-right"></i>Directions</a>
        <button class="dx-btn" type="button" id="bzShare"><i class="fa-solid fa-arrow-up-from-bracket"></i>Share</button>
        <button class="dx-btn" type="button" id="bzSave" data-slug="<?= htmlspecialchars($l['slug']) ?>"><i class="fa-regular fa-heart"></i><span>Save</span></button>
      </div>
    </div>
  </header>

  <!-- BODY -->
  <section class="dx-panel">
    <div class="dx-in bz">
      <main>
        <div class="bs" id="services">
          <h2>Services offered</h2>
          <?php if ($services): ?>
          <div class="am" id="svcList">
            <?php foreach ($services as $i => $s): ?><div class="<?= $i >= 8 ? 'more' : '' ?>"><i class="fa-solid <?= $svcIcons[$s] ?? 'fa-check' ?>"></i><?= htmlspecialchars($s) ?></div><?php endforeach ?>
          </div>
          <?php if (count($services) > 8): ?><button class="dx-btn am-btn" type="button" onclick="var a=document.getElementById('svcList');a.classList.toggle('open');this.textContent=a.classList.contains('open')?'Show less':'Show all <?= count($services) ?> services'">Show all <?= count($services) ?> services</button><?php endif ?>
          <?php else: ?>
          <p class="empty-txt">This agency hasn't listed its services yet. <?= $l['phone'] ? 'Call <a href="tel:' . htmlspecialchars($phoneHref) . '">' . htmlspecialchars($l['phone']) . '</a> to ask' : 'Contact them to ask' ?> about personal care, companion care, skilled nursing and more.</p>
          <?php endif ?>
        </div>

        <div class="bs" id="hours">
          <h2>Location &amp; hours</h2>
          <div class="lo">
            <div class="lo-map">
              <?php if ($hasGeo): ?><div id="bizMap"></div>
              <?php else: ?><iframe loading="lazy" title="Map of <?= htmlspecialchars($l['company_name']) ?>" referrerpolicy="no-referrer-when-downgrade" src="https://maps.google.com/maps?q=<?= urlencode($mapQuery) ?>&z=<?= $addrLine ? 14 : 11 ?>&output=embed"></iframe><?php endif ?>
            </div>
            <div class="lo-body">
              <div class="lo-addr">
                <span class="lo-ic"><i class="fa-solid fa-location-dot"></i></span>
                <div>
                  <small><?= $addrLine ? 'Office address' : 'Based in' ?></small>
                  <?php if ($addrLine): ?>
                  <b><?= htmlspecialchars($addrHasCity ? preg_replace('/,\s*' . preg_quote($l['city'], '/') . '.*$/i', '', $addrLine) : $addrLine) ?></b>
                  <span><?= htmlspecialchars($addrHasCity ? ltrim(substr($addrLine, stripos($addrLine, (string)$l['city'])), ', ') : $cityLine) ?></span>
                  <?php else: ?>
                  <b><?= htmlspecialchars($cityLine) ?></b>
                  <span>Provides care in clients' homes</span>
                  <?php endif ?>
                  <div class="lo-btns">
                    <a class="dx-btn is-dark" href="<?= htmlspecialchars($dirUrl) ?>" target="_blank" rel="noopener nofollow"><i class="fa-solid fa-diamond-turn-right"></i>Directions</a>
                    <button class="dx-btn" type="button" data-copy="<?= htmlspecialchars($mapQuery) ?>" onclick="var b=this;navigator.clipboard&&navigator.clipboard.writeText(b.dataset.copy).then(function(){b.innerHTML='<i class=&quot;fa-solid fa-check&quot;></i>Copied'})"><i class="fa-regular fa-copy"></i>Copy address</button>
                  </div>
                </div>
              </div>
              <div class="lo-hrs">
                <div class="lo-hrs-h">
                  <small>Office hours</small>
                  <?php if ($open): ?><span class="lo-chip <?= $open['open'] ? 'is-open' : 'is-closed' ?>"><i></i><?= $open['open'] ? 'Open now' : 'Closed now' ?></span><?php endif ?>
                </div>
                <?php if ($hours && !empty($hours['always'])): ?>
                  <div class="lo-247"><b>24/7</b><span>Care and on-call support around the clock, every day of the year.</span></div>
                <?php elseif ($hours): ?>
                  <ul class="lo-days">
                    <?php foreach (HC_DIR_DAYS as $k => $d): $isToday = ($open['today'] ?? '') === $k; ?>
                    <li class="<?= $isToday ? 'today' : '' ?><?= $hours[$k] ? '' : ' off' ?>"><span><?= $d ?><?= $isToday ? ' <em>Today</em>' : '' ?></span><span><?= $hours[$k] ? hc_dir_fmt_time($hours[$k][0]) . ' – ' . hc_dir_fmt_time($hours[$k][1]) : 'Closed' ?></span></li>
                    <?php endforeach ?>
                  </ul>
                <?php else: ?>
                  <p class="lo-none">Hours aren't listed yet. Most home care agencies can arrange care any day of the week<?= $l['phone'] ? ', so <a href="tel:' . htmlspecialchars($phoneHref) . '">call ' . htmlspecialchars($l['phone']) . '</a> to ask about availability' : '' ?>.</p>
                <?php endif ?>
                <?php if ($l['hours']): ?><p class="lo-note"><?= htmlspecialchars($l['hours']) ?></p><?php endif ?>
              </div>
            </div>
          </div>
        </div>

        <?php if ($areas): ?>
        <div class="bs" id="areas">
          <h2>Areas served <small><?= count($areas) ?> area<?= count($areas) === 1 ? '' : 's' ?> around <?= htmlspecialchars($l['city']) ?></small></h2>
          <div class="ar-grid" id="arGrid">
            <?php
            $areasSorted = $areas;
            usort($areasSorted, fn($a, $b) => (stripos($b, $l['city']) === 0) <=> (stripos($a, $l['city']) === 0));
            foreach ($areasSorted as $i => $a): $home = stripos($a, $l['city']) === 0; ?>
            <div class="ar<?= $home ? ' is-home' : '' ?><?= $i >= 12 ? ' more' : '' ?>"><span class="ar-ic"><i class="fa-solid <?= $home ? 'fa-house' : 'fa-location-dot' ?>"></i></span><span><?= htmlspecialchars($a) ?><?= $home ? '<small>Based here</small>' : '' ?></span></div>
            <?php endforeach ?>
          </div>
          <?php if (count($areas) > 12): ?><button class="dx-btn am-btn" type="button" onclick="var g=document.getElementById('arGrid');g.classList.toggle('open');this.textContent=g.classList.contains('open')?'Show fewer':'Show all <?= count($areas) ?> areas'">Show all <?= count($areas) ?> areas</button><?php endif ?>
          <p class="ar-note"><i class="fa-solid fa-circle-info"></i>Not on the list? Many agencies travel further. Ask when you call.</p>
        </div>
        <?php endif ?>

        <?php if ($features): ?>
        <div class="bs" id="highlights">
          <h2>Highlights</h2>
          <div class="am">
            <?php foreach ($features as $f): ?><div><i class="fa-solid <?= HC_DIR_FEATURES[$f] ?>"></i><?= htmlspecialchars($f) ?></div><?php endforeach ?>
          </div>
        </div>
        <?php endif ?>

        <div class="bs" id="about">
          <h2>About the business</h2>
          <?php if ($paid && $l['tagline']): ?><p class="ab-tag"><?= htmlspecialchars($l['tagline']) ?></p><?php endif ?>
          <div class="ab"><?= htmlspecialchars($about) ?></div>
          <div class="facts">
            <div><small>Payment</small><p><?= $payments ? htmlspecialchars(implode(', ', $payments)) : '<span style="color:var(--mut);font-weight:400">Ask the agency</span>' ?></p></div>
            <div><small>Languages</small><p><?= $l['languages'] ? htmlspecialchars($l['languages']) : '<span style="color:var(--mut);font-weight:400">Ask the agency</span>' ?></p></div>
            <div><small>License</small><p><?= $l['license_number'] ? '#' . htmlspecialchars($l['license_number']) : '<span style="color:var(--mut);font-weight:400">Not provided</span>' ?></p></div>
          </div>
        </div>

        <?php if ($photos): ?>
        <div class="bs" id="photos">
          <h2>Photos <small><?= count($photos) ?></small></h2>
          <div class="ph"><?php foreach ($photos as $p): ?><a href="<?= htmlspecialchars($p) ?>" target="_blank" rel="noopener"><img src="<?= htmlspecialchars($p) ?>" alt="<?= htmlspecialchars($l['company_name']) ?> photo" loading="lazy"></a><?php endforeach ?></div>
        </div>
        <?php endif ?>

        <div class="bs" id="reviews">
          <h2>Reviews <small><?= $rCount ? $rCount . ' from families and clients' : '' ?></small></h2>

          <?php if ($rCount): ?>
          <div class="rv-sum">
            <div class="rv-big"><b><?= number_format((float)$l['rating_avg'], 1) ?></b><?= hc_dir_stars((float)$l['rating_avg'], 'lg') ?><span><?= $rCount ?> review<?= $rCount === 1 ? '' : 's' ?></span></div>
            <div class="rv-bars">
              <?php for ($s = 5; $s >= 1; $s--): ?>
              <div><span><?= $s ?> stars</span><span class="rv-bar"><i style="width:<?= $rCount ? round($dist[$s] / $rCount * 100) : 0 ?>%"></i></span><span><?= $dist[$s] ?></span></div>
              <?php endfor ?>
            </div>
          </div>
          <?php endif ?>

          <div class="wr" id="writeReview">
            <h3>Write a review</h3>
            <p class="wr-sub">Share your experience with <?= htmlspecialchars($l['company_name']) ?> to help other families. Reviews are checked before they're published.</p>
            <form class="fm" id="rvForm" onsubmit="return sendReview(event)">
              <div class="hp-field" aria-hidden="true"><input type="text" name="hp_website" tabindex="-1" autocomplete="off"></div>
              <input type="hidden" name="rating" id="rvRating" value="0">
              <div class="wr-stars" id="rvStars">
                <?php for ($s = 1; $s <= 5; $s++): ?><button type="button" data-v="<?= $s ?>" aria-label="<?= $s ?> star<?= $s > 1 ? 's' : '' ?>"><i class="fa-solid fa-star"></i></button><?php endfor ?>
              </div>
              <div class="wr-hint" id="rvHint">Select your rating</div>
              <div class="fm-row">
                <div><label for="rvName">Your name</label><input id="rvName" name="name" required maxlength="120" autocomplete="name"></div>
                <div><label for="rvEmail">Email <span style="font-weight:400;color:var(--mut)">(not published)</span></label><input id="rvEmail" name="email" type="email" required autocomplete="email"></div>
              </div>
              <label for="rvRel">Your relationship to the agency</label>
              <select id="rvRel" name="relationship">
                <option>Family member of a client</option><option>Client</option><option>Former client or family</option><option>Healthcare professional</option><option>Caregiver or employee</option>
              </select>
              <label for="rvTitle">Title</label><input id="rvTitle" name="title" maxlength="150" placeholder="Sum up your experience">
              <label for="rvBody">Your review</label><textarea id="rvBody" name="body" rows="5" required minlength="40" placeholder="What care did you receive? How were the caregivers and communication?"></textarea>
              <button class="dx-btn is-dark" type="submit" id="rvBtn" style="width:100%;padding:16px">Submit review</button>
              <small>By submitting, you confirm this review reflects your own genuine experience. We don't publish reviews from agency owners or paid reviewers.</small>
            </form>
            <div class="fm-ok" id="rvOk"><span class="dx-arrow"><i class="fa-solid fa-check"></i></span><h3>Thank you!</h3><p class="wr-sub" style="margin:4px 0 0">Your review will appear once our team has checked it.</p></div>
          </div>

          <?php if ($reviews): ?>
          <div class="rv-tools">
            <button class="dx-btn" type="button" onclick="openReview()"><i class="fa-regular fa-star"></i>Write a review</button>
            <select aria-label="Sort reviews" onchange="location.href=this.value">
              <?php foreach (['new' => 'Newest first', 'high' => 'Highest rated', 'low' => 'Lowest rated'] as $k => $v): ?>
              <option value="?rsort=<?= $k ?>#reviews" <?= $rSort === $k ? 'selected' : '' ?>><?= $v ?></option>
              <?php endforeach ?>
            </select>
          </div>
          <?php foreach ($reviews as $r): ?>
          <div class="rv">
            <div class="rv-who">
              <span class="rv-av" style="background:<?= hc_dir_mono_color($r['name']) ?>"><?= htmlspecialchars(strtoupper(mb_substr($r['name'], 0, 1))) ?></span>
              <div><b><?= htmlspecialchars(explode(' ', trim($r['name']))[0] . (count(explode(' ', trim($r['name']))) > 1 ? ' ' . mb_substr(explode(' ', trim($r['name']))[1], 0, 1) . '.' : '')) ?></b><span><?= htmlspecialchars($r['relationship'] ?: 'Reviewer') ?></span></div>
            </div>
            <div class="rv-meta"><?= hc_dir_stars((float)$r['rating'], 'sm') ?><span><?= date('M j, Y', strtotime($r['created_at'])) ?></span></div>
            <?php if ($r['title']): ?><h4><?= htmlspecialchars($r['title']) ?></h4><?php endif ?>
            <p><?= htmlspecialchars($r['body']) ?></p>
            <?php if ($r['owner_response']): ?>
            <div class="rv-resp"><b>Response from <?= htmlspecialchars($l['company_name']) ?></b><p><?= htmlspecialchars($r['owner_response']) ?></p></div>
            <?php endif ?>
          </div>
          <?php endforeach ?>
          <?php else: ?>
          <div class="rv-empty" id="rvEmpty">
            <?= hc_dir_stars(0, 'lg') ?>
            <h3 style="margin-top:16px">No reviews yet</h3>
            <p>Have you used <?= htmlspecialchars($l['company_name']) ?>? Help other families by sharing your experience.</p>
            <button class="dx-btn is-dark" type="button" onclick="openReview()">Be the first to review</button>
          </div>
          <?php endif ?>
        </div>

        <?php if ($faq): ?>
        <div class="bs" id="faq">
          <h2>Frequently asked questions</h2>
          <div class="fq">
            <?php foreach ($faq as [$fq, $fa]): ?><details><summary><?= htmlspecialchars($fq) ?><span class="dx-arrow"><i class="fa-solid fa-plus"></i></span></summary><p><?= htmlspecialchars($fa) ?></p></details><?php endforeach ?>
          </div>
        </div>
        <?php endif ?>

        <?php if ($nearby): ?>
        <div class="bs" id="also">
          <h2>People also viewed</h2>
          <div class="pv">
            <?php foreach ($nearby as $nb): $nt = hc_dir_tier($nb); ?>
            <a href="/directory/<?= urlencode($nb['slug']) ?>">
              <?= hc_dir_logo($nb, 58) ?>
              <div style="min-width:0"><b><?= htmlspecialchars($nb['company_name']) ?></b><div style="margin-bottom:4px"><?= hc_dir_rating_line($nb) ?></div><span><?= htmlspecialchars($nb['city'] . ', ' . $nb['state']) ?><?= $nt === 'featured' ? ' · Sponsored' : '' ?></span></div>
            </a>
            <?php endforeach ?>
          </div>
        </div>
        <?php endif ?>
      </main>

      <aside class="sd" id="contact">
        <?php if ($featured): ?>
        <div class="cc">
          <h3>Request a <em>free</em> consultation</h3>
          <p class="cc-sub">Tell <?= htmlspecialchars($l['company_name']) ?> what you need. Your request goes straight to the agency.</p>
          <form class="fm" id="lxLead" onsubmit="return lxSend(event)">
            <div class="hp-field" aria-hidden="true"><input type="text" name="hp_website" tabindex="-1" autocomplete="off"></div>
            <label for="lxName">Your name</label><input id="lxName" name="name" required autocomplete="name">
            <div class="fm-row">
              <div><label for="lxPhone">Phone</label><input id="lxPhone" name="phone" type="tel" required autocomplete="tel"></div>
              <div><label for="lxEmail">Email</label><input id="lxEmail" name="email" type="email" autocomplete="email"></div>
            </div>
            <label for="lxFor">Care is for</label>
            <select id="lxFor" name="care_for"><option>A parent</option><option>A spouse or partner</option><option>Myself</option><option>Another relative</option><option>A client or patient</option></select>
            <label for="lxMsg">How can they help?</label><textarea id="lxMsg" name="message" rows="3" placeholder="Type of care, schedule, start date…"></textarea>
            <button class="dx-btn is-teal" type="submit" id="lxBtn" style="width:100%;padding:16px">Send request</button>
            <small style="text-align:center">Shared only with this agency. No spam.</small>
          </form>
          <div class="fm-ok" id="lxOk"><span class="dx-arrow"><i class="fa-solid fa-check"></i></span><h3>Request sent</h3><p class="cc-sub" style="margin:4px 0 0">The agency will be in touch shortly.</p></div>
        </div>
        <?php endif ?>

        <div class="cc">
          <?php if ($paid && $l['website']): ?><a class="cr" href="<?= htmlspecialchars($l['website']) ?>" target="_blank" rel="noopener"><div><b><?= htmlspecialchars(hc_dir_domain($l['website'])) ?></b><span>Website</span></div><i class="fa-solid fa-arrow-up-right-from-square"></i></a><?php endif ?>
          <?php if ($l['phone']): ?><a class="cr" href="tel:<?= htmlspecialchars($phoneHref) ?>"><div><b><?= htmlspecialchars($l['phone']) ?></b><span>Phone</span></div><i class="fa-solid fa-phone"></i></a><?php endif ?>
          <?php if ($paid && $l['email']): ?><a class="cr" href="mailto:<?= htmlspecialchars($l['email']) ?>"><div><b><?= htmlspecialchars($l['email']) ?></b><span>Email</span></div><i class="fa-regular fa-envelope"></i></a><?php endif ?>
          <a class="cr" href="<?= htmlspecialchars($dirUrl) ?>" target="_blank" rel="noopener nofollow"><div><b>Get directions</b><span><?= htmlspecialchars($mapQuery) ?></span></div><i class="fa-solid fa-diamond-turn-right"></i></a>
          <a class="cc-edit" href="mailto:info@homecarecreators.com?subject=<?= rawurlencode('Suggest an edit: ' . $l['company_name']) ?>"><i class="fa-regular fa-pen-to-square" style="margin-right:6px"></i>Suggest an edit</a>
        </div>

        <?php if ($hasOwner && !$paid): ?>
        <div class="claim">
          <span class="dx-arrow" style="background:var(--gold-bg);border:0;color:var(--gold-ink)"><i class="fa-solid fa-arrow-trend-up"></i></span>
          <div><b>Stand out in <?= htmlspecialchars($l['city']) ?></b><p>Add photos and your website, and rank above nearby agencies.</p><a class="go" href="/directory/submit/?claim=<?= urlencode($l['slug']) ?>&plan=premium">See upgrade options →</a></div>
        </div>
        <?php endif ?>

        <?= hc_dir_hc_ad('side') ?>
      </aside>
    </div>
  </section>
</div>
</div>

<div class="mbar">
  <?php if ($l['phone']): ?><a class="dx-btn is-dark" href="tel:<?= htmlspecialchars($phoneHref) ?>"><i class="fa-solid fa-phone"></i>Call</a><?php endif ?>
  <?php if ($featured): ?><a class="dx-btn is-teal" href="#contact">Request info</a><?php else: ?><a class="dx-btn" href="<?= htmlspecialchars($dirUrl) ?>" target="_blank" rel="noopener nofollow"><i class="fa-solid fa-diamond-turn-right"></i>Directions</a><?php endif ?>
</div>
<?php
$lid = (int)$l['id'];
$geoJson = json_encode($hasGeo ? ['lat' => (float)$l['lat'], 'lng' => (float)$l['lng']] : null);
$page_js = <<<JS
(function(){
  // Share
  var sh = document.getElementById('bzShare');
  if (sh) sh.addEventListener('click', function(){
    if (navigator.share) { navigator.share({title: document.title, url: location.href}).catch(function(){}); }
    else if (navigator.clipboard) { navigator.clipboard.writeText(location.href); sh.innerHTML = '<i class="fa-solid fa-check"></i>Link copied'; }
  });
  // Save (per-browser)
  var sv = document.getElementById('bzSave');
  if (sv) {
    var slug = sv.getAttribute('data-slug'), saved = [];
    try { saved = JSON.parse(localStorage.getItem('dxSaved') || '[]'); } catch(e) {}
    function paint(){ var on = saved.indexOf(slug) > -1; sv.classList.toggle('saved', on); sv.querySelector('i').className = on ? 'fa-solid fa-heart' : 'fa-regular fa-heart'; sv.querySelector('span').textContent = on ? 'Saved' : 'Save'; }
    paint();
    sv.addEventListener('click', function(){
      var i = saved.indexOf(slug); if (i > -1) saved.splice(i, 1); else saved.push(slug);
      try { localStorage.setItem('dxSaved', JSON.stringify(saved)); } catch(e) {}
      paint();
    });
  }
  // Map
  var G = {$geoJson}, mEl = document.getElementById('bizMap');
  if (G && mEl && typeof L !== 'undefined') {
    var map = L.map(mEl, {scrollWheelZoom: false, zoomControl: false, attributionControl: true}).setView([G.lat, G.lng], 13);
    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18, attribution: '&copy; OpenStreetMap'}).addTo(map);
    L.marker([G.lat, G.lng], {icon: L.divIcon({className: '', html: '<div style="width:30px;height:30px;border-radius:50% 50% 50% 0;background:#0a2e1e;transform:rotate(-45deg);border:3px solid #fff;box-shadow:0 4px 12px rgba(0,0,0,.3)"></div>', iconSize: [30, 30], iconAnchor: [15, 30]})}).addTo(map);
  }
  // Review stars
  var hints = ['Select your rating', 'Not good', 'Could have been better', 'OK', 'Good', 'Great'];
  var stars = document.querySelectorAll('#rvStars button'), rv = document.getElementById('rvRating'), hint = document.getElementById('rvHint');
  function paintStars(n){ stars.forEach(function(b){ b.classList.toggle('on', +b.getAttribute('data-v') <= n); }); }
  stars.forEach(function(b){
    b.addEventListener('mouseenter', function(){ paintStars(+b.getAttribute('data-v')); hint.textContent = hints[+b.getAttribute('data-v')]; });
    b.addEventListener('mouseleave', function(){ paintStars(+rv.value); hint.textContent = hints[+rv.value]; });
    b.addEventListener('click', function(){ rv.value = b.getAttribute('data-v'); paintStars(+rv.value); hint.textContent = hints[+rv.value]; });
  });
  if (location.hash === '#write-review') openReview();
})();
function openReview(){
  var w = document.getElementById('writeReview'), e = document.getElementById('rvEmpty');
  w.classList.add('open'); if (e) e.style.display = 'none';
  w.scrollIntoView({behavior: 'smooth', block: 'start'});
}
function sendReview(e){
  e.preventDefault();
  var f = e.target, btn = document.getElementById('rvBtn');
  var data = {listing_id: {$lid}};
  new FormData(f).forEach(function(v,k){ data[k] = v; });
  if (!(+data.rating >= 1)) { alert('Please choose a star rating.'); return false; }
  if ((data.body || '').trim().length < 40) { alert('Please write at least 40 characters about your experience.'); return false; }
  btn.disabled = true; btn.textContent = 'Submitting…';
  fetch('/directory-review-handler.php', {method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(data)})
    .then(function(r){ return r.json(); })
    .then(function(d){
      if (d.success) { f.style.display = 'none'; document.getElementById('rvOk').style.display = 'block'; }
      else { alert(d.message || 'Something went wrong.'); btn.disabled = false; btn.textContent = 'Submit review'; }
    })
    .catch(function(){ alert('Connection error. Please try again.'); btn.disabled = false; btn.textContent = 'Submit review'; });
  return false;
}
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
echo hc_dir_popup_html();
include '../includes/footer.php';
