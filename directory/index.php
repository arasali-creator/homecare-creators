<?php
require_once '../admin/config.php';
require_once '../admin/includes/db.php';
require_once '../admin/includes/functions.php';
require_once '../admin/includes/directory.php';
require_once '../includes/directory-ui.php';
hc_dir_ensure_schema();

// ── Inputs ───────────────────────────────────────────────────
$q        = trim($_GET['q'] ?? '');
$loc      = trim($_GET['loc'] ?? '');
$svcSel   = array_values(array_intersect((array)($_GET['svc'] ?? []), HC_DIR_SERVICES));
$paySel   = array_values(array_intersect((array)($_GET['pay'] ?? []), HC_DIR_PAYMENTS));
$verified = !empty($_GET['verified']);
$sort     = in_array($_GET['sort'] ?? '', ['az', 'newest'], true) ? $_GET['sort'] : 'recommended';
$page     = max(1, (int)($_GET['page'] ?? 1));
$perPage  = 15;

$US_STATES = ['AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming','DC'=>'District of Columbia'];

// ── Location parsing: "Orlando, FL" | "FL" | "Florida" | "Orlando" ──
$locCity = ''; $locState = '';
if ($loc !== '') {
    if (preg_match('/^(.+?),\s*([A-Za-z]{2})$/', $loc, $m)) { $locCity = trim($m[1]); $locState = strtoupper($m[2]); }
    elseif (preg_match('/^[A-Za-z]{2}$/', $loc)) { $locState = strtoupper($loc); }
    elseif ($code = array_search(strtolower($loc), array_map('strtolower', $US_STATES), true)) { $locState = $code; }
    else { $locCity = $loc; }
}

// ── Query ────────────────────────────────────────────────────
$where = ["status='approved'"]; $params = [];
if ($q !== '') {
    $where[] = "(company_name LIKE ? OR services LIKE ? OR tagline LIKE ? OR description LIKE ?)";
    $like = '%' . $q . '%'; array_push($params, $like, $like, $like, $like);
}
if ($locCity !== '')  { $where[] = "(city LIKE ? OR service_areas LIKE ?)"; array_push($params, $locCity . '%', '%' . $locCity . '%'); }
if ($locState !== '') { $where[] = "state = ?"; $params[] = $locState; }
foreach ($svcSel as $s) { $where[] = "services LIKE ?"; $params[] = '%' . $s . '%'; }
foreach ($paySel as $p) { $where[] = "payment_accepted LIKE ?"; $params[] = '%' . $p . '%'; }
if ($verified) { $where[] = "(verified=1 OR owner_confirmed_at IS NOT NULL)"; }
$whereSql = implode(' AND ', $where);
$rank = hc_dir_rank_sql();
$order = match ($sort) {
    'az'     => "company_name ASC",
    'newest' => "approved_at DESC, id DESC",
    default  => "$rank DESC, (owner_confirmed_at IS NOT NULL) DESC, (logo IS NOT NULL AND logo<>'') DESC, company_name ASC",
};

$total   = (int)hc_val("SELECT COUNT(*) FROM hc_directory_listings WHERE $whereSql", $params);
$pages   = max(1, (int)ceil($total / $perPage));
$page    = min($page, $pages);
$offset  = ($page - 1) * $perPage;
$listings = hc_all("SELECT * FROM hc_directory_listings WHERE $whereSql ORDER BY $order LIMIT $perPage OFFSET $offset", $params);

$isFiltered = $q !== '' || $loc !== '' || $svcSel || $paySel || $verified;
$spotlight  = (!$isFiltered && $page === 1)
    ? hc_all("SELECT * FROM hc_directory_listings WHERE status='approved' AND $rank = 2 ORDER BY RAND() LIMIT 3")
    : [];

$allCount   = (int)hc_val("SELECT COUNT(*) FROM hc_directory_listings WHERE status='approved'");
$stateCount = (int)hc_val("SELECT COUNT(DISTINCT state) FROM hc_directory_listings WHERE status='approved'");
$topCities  = hc_all("SELECT city, state, COUNT(*) n FROM hc_directory_listings WHERE status='approved' GROUP BY city, state ORDER BY n DESC, city ASC LIMIT 16");
$locOptions = hc_all("SELECT DISTINCT city, state FROM hc_directory_listings WHERE status='approved' ORDER BY state, city");
$statesUsed = hc_all("SELECT state, COUNT(*) n FROM hc_directory_listings WHERE status='approved' GROUP BY state ORDER BY n DESC");

// ── Page meta ────────────────────────────────────────────────
$where_label = $locCity ? $locCity . ($locState ? ', ' . $locState : '') : ($locState ? ($US_STATES[$locState] ?? $locState) : '');
$heading = ($svcSel ? $svcSel[0] . ' Agencies' : 'Home Care Agencies') . ($where_label ? ' in ' . $where_label : '');
$page_title = $isFiltered ? $heading . ' | Homecare Creators Directory' : 'Home Care Agency Directory — Find Trusted Home Care Near You | Homecare Creators';
$page_desc  = "Compare {$allCount} home care agencies by services, location and payment options. Personal care, companion care, skilled nursing, dementia care and more.";
$page_canonical = "https://homecarecreators.com/directory/";
$og_title = "Home Care Agency Directory | Homecare Creators";
$og_desc  = $page_desc;

function dx_url(array $over = []): string {
    $base = array_filter([
        'q' => $_GET['q'] ?? '', 'loc' => $_GET['loc'] ?? '', 'svc' => $_GET['svc'] ?? [], 'pay' => $_GET['pay'] ?? [],
        'verified' => $_GET['verified'] ?? '', 'sort' => $_GET['sort'] ?? '',
    ]);
    $p = array_filter(array_merge($base, $over), fn($v) => $v !== '' && $v !== [] && $v !== null);
    return '/directory/' . ($p ? '?' . http_build_query($p) : '');
}


$page_css = hc_dir_base_css() . <<<CSS
body{background:var(--bg,#f4f5f1)}
.dx{background:var(--bg)}

/* ── HERO ───────────────────────────────── */
.dh{background:var(--forest);position:relative;overflow:hidden;padding:120px 0 120px}
.dh::before{content:"";position:absolute;inset:0;background:radial-gradient(900px 500px at 85% 10%,rgba(46,198,143,.16),transparent 60%),radial-gradient(700px 400px at 0% 100%,rgba(201,168,76,.10),transparent 60%)}
.dh-grid{position:relative;display:grid;grid-template-columns:1.25fr .75fr;gap:56px;align-items:center}
.dh .dx-crumbs{margin-bottom:22px}
.dh h1{color:#fff;font-size:clamp(34px,4.4vw,56px);font-weight:800;line-height:1.04;letter-spacing:-.035em;margin-bottom:18px}
.dh h1 span{color:var(--teal-lt)}
.dh-sub{color:rgba(255,255,255,.7);font-size:18px;line-height:1.6;max-width:560px;margin-bottom:30px}
.dh-search{background:#fff;border-radius:18px;padding:8px;display:grid;grid-template-columns:1.2fr 1fr auto;box-shadow:0 30px 70px rgba(0,0,0,.35);max-width:720px}
.dh-field{display:flex;flex-direction:column;justify-content:center;padding:10px 18px;min-width:0}
.dh-field+.dh-field{border-left:1px solid var(--line)}
.dh-field small{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-3);margin-bottom:2px}
.dh-field input{border:0;outline:0;font:inherit;font-size:16px;color:var(--ink);padding:4px 0;background:transparent;min-width:0}
.dh-search button{border:0;background:var(--teal);color:#fff;border-radius:12px;padding:0 28px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:15px;cursor:pointer;display:flex;align-items:center;gap:10px;transition:background .15s}
.dh-search button:hover{background:#178a64}
.dh-pop{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-top:18px;font-size:13.5px;color:rgba(255,255,255,.55)}
.dh-pop a{color:rgba(255,255,255,.85);border:1px solid rgba(255,255,255,.18);padding:6px 12px;border-radius:100px;font-size:13px;transition:.15s}
.dh-pop a:hover{background:rgba(255,255,255,.1);color:#fff}
.dh-art{position:relative;justify-self:end;width:100%;max-width:420px}
.dh-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/5;box-shadow:0 30px 80px rgba(0,0,0,.4)}
.dh-photo img{width:100%;height:100%;object-fit:cover;object-position:62% center;display:block}
.dh-float{position:absolute;background:#fff;border-radius:16px;box-shadow:0 20px 50px rgba(0,0,0,.25);padding:14px 16px;display:flex;align-items:center;gap:12px}
.dh-float b{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;font-weight:800;color:var(--ink);display:block;line-height:1}
.dh-float span{font-size:12.5px;color:var(--ink-3)}
.dh-float .ic{width:40px;height:40px;border-radius:12px;display:flex;align-items:center;justify-content:center;font-size:16px}
.dh-float.f1{left:-48px;bottom:56px}
.dh-float.f1 .ic{background:#e3f4ec;color:var(--teal)}
.dh-float.f2{right:-24px;top:40px}
.dh-float.f2 .ic{background:var(--gold-bg);color:var(--gold-ink)}

/* ── STATE TILES (overlap hero) ─────────── */
.ds{margin-top:-64px;position:relative;z-index:2}
.ds-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.ds-tile{background:#fff;border-radius:18px;padding:22px 22px 20px;box-shadow:var(--shadow);position:relative;overflow:hidden;transition:transform .2s,box-shadow .2s}
.ds-tile:hover{transform:translateY(-3px);box-shadow:0 14px 36px rgba(16,26,21,.1)}
.ds-tile .code{position:absolute;right:-6px;bottom:-22px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:96px;letter-spacing:-.06em;color:#f0f2ed;line-height:1}
.ds-tile small{position:relative;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--teal)}
.ds-tile h3{position:relative;font-size:20px;font-weight:800;margin:6px 0 2px}
.ds-tile p{position:relative;font-size:14px;color:var(--ink-3)}

/* ── SECTION HEADINGS ───────────────────── */
.dx-sec{padding:64px 0 0}
.dx-sec-h{display:flex;align-items:flex-end;justify-content:space-between;gap:16px;margin-bottom:22px}
.dx-sec-h h2{font-size:26px;font-weight:800}
.dx-sec-h p{font-size:14.5px;color:var(--ink-3);margin-top:4px}
.dx-kicker{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--teal);margin-bottom:8px}

/* ── FEATURED SPOTLIGHT ─────────────────── */
.sp-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.sp-card{background:#fff;border-radius:20px;overflow:hidden;box-shadow:var(--shadow);display:flex;flex-direction:column;transition:transform .2s,box-shadow .2s}
.sp-card:hover{transform:translateY(-4px);box-shadow:0 18px 44px rgba(16,26,21,.12)}
.sp-cover{height:132px;background:#0f3d28 center/cover;position:relative}
.sp-cover::after{content:"";position:absolute;inset:0;background:linear-gradient(180deg,transparent 40%,rgba(0,0,0,.25))}
.sp-cover .dx-badge{position:absolute;top:14px;left:14px;z-index:1}
.sp-cover .dx-logo{position:absolute;left:20px;bottom:-30px;z-index:1;border:4px solid #fff;box-shadow:0 6px 18px rgba(0,0,0,.15)}
.sp-body{padding:42px 22px 22px;flex:1;display:flex;flex-direction:column}
.sp-body h3{font-size:18px;font-weight:800;margin-bottom:4px}
.sp-loc{font-size:13.5px;color:var(--ink-3);margin-bottom:12px}
.sp-loc i{color:var(--teal);margin-right:5px}
.sp-desc{font-size:14.5px;color:var(--ink-2);line-height:1.55;display:-webkit-box;-webkit-line-clamp:3;-webkit-box-orient:vertical;overflow:hidden;flex:1}
.sp-foot{display:flex;justify-content:space-between;align-items:center;border-top:1px solid var(--line-2);margin-top:18px;padding-top:14px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--teal)}
.sp-empty{border:2px dashed #cdd5cf;border-radius:20px;display:flex;flex-direction:column;align-items:flex-start;justify-content:center;padding:30px;background:transparent;transition:border-color .2s,background .2s}
.sp-empty:hover{border-color:var(--teal);background:#fff}
.sp-empty .ic{width:46px;height:46px;border-radius:14px;background:var(--gold-bg);color:var(--gold-ink);display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:16px}
.sp-empty h3{font-size:18px;font-weight:800;margin-bottom:6px}
.sp-empty p{font-size:14px;color:var(--ink-3);line-height:1.55;margin-bottom:16px}
.sp-empty span{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:14px;color:var(--teal)}

/* ── RESULTS LAYOUT ─────────────────────── */
.dr{display:grid;grid-template-columns:270px 1fr;gap:28px;align-items:start;padding-bottom:88px}
.df{background:#fff;border-radius:18px;box-shadow:var(--shadow);padding:6px 22px 22px;position:sticky;top:88px}
.df-group{padding:18px 0;border-bottom:1px solid var(--line-2)}
.df-group:last-of-type{border-bottom:0}
.df-group h4{font-size:14px;font-weight:800;margin-bottom:10px;display:flex;justify-content:space-between}
.df-check{display:flex;align-items:center;gap:10px;padding:5px 0;color:var(--ink-2);font-size:14px;cursor:pointer;line-height:1.35}
.df-check input{width:17px;height:17px;accent-color:var(--teal);flex-shrink:0}
.df-more{display:none}
.df-group.open .df-more{display:flex}
.df-toggle{background:none;border:0;color:var(--teal);font-weight:700;font-size:13px;padding:6px 0 0;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif}
.df-state{display:flex;justify-content:space-between;align-items:center;padding:6px 0;color:var(--ink-2);font-size:14px}
.df-state:hover,.df-state.on{color:var(--teal)}
.df-state span{font-size:12px;font-weight:700;color:var(--ink-3);background:#f0f2ee;border-radius:100px;padding:2px 8px}
.df-promo{margin-top:6px;background:var(--forest);border-radius:14px;padding:20px;color:#fff}
.df-promo h4{color:#fff;font-size:15px;margin-bottom:6px}
.df-promo p{font-size:13.5px;color:rgba(255,255,255,.65);line-height:1.55;margin-bottom:14px}
.df-promo .dx-btn{width:100%}

.rb{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:16px;flex-wrap:wrap}
.rb h2{font-size:22px;font-weight:800}
.rb p{font-size:13.5px;color:var(--ink-3);margin-top:2px}
.rb-right{display:flex;gap:10px;align-items:center}
.rb select{font:inherit;font-size:14px;font-weight:600;color:var(--ink);border:1px solid var(--line);border-radius:10px;padding:9px 12px;background:#fff;cursor:pointer}
.rb-chips{display:flex;gap:8px;flex-wrap:wrap;margin:-4px 0 16px}
.rb-chips a{font-size:13px;font-weight:600;background:#fff;box-shadow:inset 0 0 0 1px var(--line);color:var(--ink);padding:7px 12px;border-radius:100px}
.rb-chips a i{margin-left:7px;color:var(--ink-3);font-size:11px}
.rb-chips a.clear{background:none;box-shadow:none;color:var(--teal)}

.rc{background:#fff;border-radius:18px;box-shadow:var(--shadow);padding:24px;display:grid;grid-template-columns:auto 1fr auto;gap:22px;margin-bottom:14px;position:relative;transition:box-shadow .2s}
.rc:hover{box-shadow:0 12px 34px rgba(16,26,21,.09)}
.rc.is-feat{box-shadow:0 0 0 1.5px var(--gold-line),var(--shadow)}
.rc.is-feat::before{content:"";position:absolute;left:0;top:22px;bottom:22px;width:4px;border-radius:0 4px 4px 0;background:var(--gold)}
.rc-main{min-width:0}
.rc h3{font-size:19px;font-weight:800;line-height:1.25;margin-bottom:6px}
.rc h3 a:hover{color:var(--teal)}
.rc-loc{font-size:14px;color:var(--ink-3);display:flex;flex-wrap:wrap;gap:6px 16px;margin-bottom:10px}
.rc-loc i{color:var(--teal);margin-right:6px;font-size:12.5px}
.rc-badges{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:12px}
.rc-desc{font-size:15px;color:var(--ink-2);line-height:1.6;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.rc-svcs{display:flex;gap:6px;flex-wrap:wrap;margin-top:12px}
.rc-svcs span{font-size:12.5px;font-weight:600;color:var(--forest);background:#eef4f0;padding:5px 10px;border-radius:8px}
.rc-svcs span.more{background:none;color:var(--ink-3)}
.rc-act{display:flex;flex-direction:column;gap:8px;min-width:180px;padding-left:22px;border-left:1px solid var(--line-2);justify-content:center}
.rc-phone{display:flex;align-items:center;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:15px;color:var(--ink);margin-bottom:6px}
.rc-phone i{width:32px;height:32px;border-radius:10px;background:#e3f4ec;color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:13px}
.rc-phone:hover{color:var(--teal)}
.rc-tag{position:absolute;top:14px;right:18px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--gold-ink)}

.r-empty{background:#fff;border-radius:18px;box-shadow:var(--shadow);padding:56px 24px;text-align:center}
.r-empty .ic{width:56px;height:56px;border-radius:16px;background:#eef4f0;color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:22px;margin:0 auto 16px}
.r-empty h3{font-size:19px;font-weight:800;margin-bottom:6px}
.r-empty p{color:var(--ink-3);margin-bottom:18px}

.pg{display:flex;gap:6px;justify-content:center;padding-top:26px;flex-wrap:wrap}
.pg a,.pg span{min-width:42px;height:42px;display:inline-flex;align-items:center;justify-content:center;padding:0 12px;background:#fff;box-shadow:inset 0 0 0 1px var(--line);border-radius:12px;font-weight:700;font-size:14px;color:var(--ink-2);font-family:'Plus Jakarta Sans',sans-serif}
.pg .on{background:var(--forest);box-shadow:none;color:#fff}
.pg a:hover{box-shadow:inset 0 0 0 1px #aab4ad}
.pg .gap{background:none;box-shadow:none}

/* ── CITIES ─────────────────────────────── */
.dc{background:#fff;padding:64px 0}
.dc-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0 32px}
.dc-grid a{display:flex;justify-content:space-between;align-items:center;padding:13px 0;border-bottom:1px solid var(--line-2);font-size:15px;color:var(--ink-2);transition:color .15s}
.dc-grid a:hover{color:var(--teal)}
.dc-grid a span{font-size:12.5px;color:var(--ink-3)}

/* ── OWNERS / PRICING ───────────────────── */
.do{background:var(--forest);padding:96px 0 104px;position:relative;overflow:hidden}
.do::before{content:"";position:absolute;inset:0;background:radial-gradient(800px 420px at 50% -10%,rgba(46,198,143,.18),transparent 65%)}
.do .dx-wrap{position:relative}
.do-head{text-align:center;max-width:680px;margin:0 auto 56px}
.do-head h2{color:#fff;font-size:clamp(30px,3.6vw,44px);font-weight:800;line-height:1.1;letter-spacing:-.03em;margin-bottom:14px}
.do-head p{color:rgba(255,255,255,.65);font-size:17px;line-height:1.65}
.do-foot{display:flex;gap:32px;flex-wrap:wrap;justify-content:center;margin-top:40px;font-size:14px;color:rgba(255,255,255,.65)}
.do-foot i{color:var(--teal-lt);margin-right:8px}

.df-mtoggle{display:none}

@media(max-width:1100px){
  .dh-grid{grid-template-columns:1fr}
  .dh-art{display:none}
  .dr{grid-template-columns:1fr}
  .df{position:static;display:none}
  .df.open{display:block}
  .df-mtoggle{display:inline-flex}
  .sp-grid{grid-template-columns:1fr 1fr}
  .dc-grid{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:760px){
  .dh{padding:100px 0 96px}
  .dh-search{grid-template-columns:1fr;padding:6px}
  .dh-field+.dh-field{border-left:0;border-top:1px solid var(--line)}
  .dh-search button{padding:15px;justify-content:center}
  .ds-grid{grid-template-columns:1fr 1fr;gap:10px}
  .ds-tile{padding:18px}
  .ds-tile h3{font-size:17px}
  .sp-grid{grid-template-columns:1fr}
  .rc{grid-template-columns:auto 1fr;padding:18px;gap:14px}
  .rc .dx-logo{width:56px!important;height:56px!important;font-size:19px!important}
  .rc-act{grid-column:1/-1;border-left:0;padding-left:0;border-top:1px solid var(--line-2);padding-top:14px;flex-direction:row;flex-wrap:wrap;min-width:0}
  .rc-act .dx-btn{flex:1}
  .rc-phone{width:100%;margin-bottom:2px}
  .dc-grid{grid-template-columns:1fr 1fr}
  .do{padding:72px 0}
}
CSS;
include '../includes/header.php';

$popular = ['Personal Care', 'Companion Care', 'Dementia Care' => 'Alzheimer\'s & Dementia Care', '24-Hour Care'];
?>
<div id="scrollProgress"></div>
<div class="dx">

<!-- HERO -->
<section class="dh">
  <div class="dx-wrap dh-grid">
    <div>
      <div class="dx-crumbs"><a href="/">Home</a><i class="fa-solid fa-chevron-right"></i><?= $isFiltered ? '<a href="/directory/">Agency Directory</a><i class="fa-solid fa-chevron-right"></i>Search' : 'Agency Directory' ?></div>
      <?php if ($isFiltered): ?>
      <h1><?= htmlspecialchars($heading) ?></h1>
      <?php else: ?>
      <h1>Find home care <span>you can trust</span>, close to home.</h1>
      <?php endif ?>
      <p class="dh-sub">Compare home care agencies by the care they provide, the areas they serve and how they're paid, then contact them directly.</p>
      <form class="dh-search" method="GET" action="/directory/" role="search">
        <label class="dh-field"><small>Looking for</small><input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Agency name or type of care"></label>
        <label class="dh-field"><small>Location</small><input type="text" name="loc" value="<?= htmlspecialchars($loc) ?>" placeholder="City or state" list="dxLocs"></label>
        <button type="submit"><i class="fa-solid fa-magnifying-glass"></i>Search</button>
        <datalist id="dxLocs">
          <?php foreach ($statesUsed as $s): ?><option value="<?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?>"><?php endforeach ?>
          <?php foreach ($locOptions as $o): ?><option value="<?= htmlspecialchars($o['city'] . ', ' . $o['state']) ?>"><?php endforeach ?>
        </datalist>
      </form>
      <div class="dh-pop">Popular:
        <?php foreach ($popular as $label => $svc): $label = is_int($label) ? $svc : $label; ?>
        <a href="<?= htmlspecialchars(dx_url(['q' => null, 'svc' => [$svc], 'page' => null])) ?>"><?= htmlspecialchars($label) ?></a>
        <?php endforeach ?>
      </div>
    </div>
    <div class="dh-art" aria-hidden="true">
      <div class="dh-photo"><img src="/images/home/hero-caregiver-elderly.jpg" alt=""></div>
      <div class="dh-float f1"><div class="ic"><i class="fa-solid fa-house-medical"></i></div><div><b><?= $allCount ?></b><span>agencies listed</span></div></div>
      <div class="dh-float f2"><div class="ic"><i class="fa-solid fa-location-dot"></i></div><div><b><?= count($locOptions) ?></b><span>cities covered</span></div></div>
    </div>
  </div>
</section>

<!-- STATES -->
<section class="ds">
  <div class="dx-wrap">
    <div class="ds-grid">
      <?php foreach (array_slice($statesUsed, 0, 4) as $s): ?>
      <a class="ds-tile" href="<?= htmlspecialchars('/directory/?loc=' . urlencode($s['state'])) ?>">
        <span class="code"><?= htmlspecialchars($s['state']) ?></span>
        <small>Browse</small>
        <h3><?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?></h3>
        <p><?= (int)$s['n'] ?> agenc<?= $s['n'] == 1 ? 'y' : 'ies' ?></p>
      </a>
      <?php endforeach ?>
    </div>
  </div>
</section>

<?php if (!$isFiltered && $page === 1): ?>
<!-- FEATURED -->
<section class="dx-sec">
  <div class="dx-wrap">
    <div class="dx-sec-h">
      <div><div class="dx-kicker">Featured</div><h2>Featured agencies</h2></div>
    </div>
    <div class="sp-grid">
      <?php foreach ($spotlight as $l): ?>
      <a class="sp-card" href="/directory/<?= urlencode($l['slug']) ?>">
        <div class="sp-cover"<?= $l['cover_image'] ? ' style="background-image:url(\'' . htmlspecialchars($l['cover_image']) . '\')"' : ' style="background:linear-gradient(135deg,' . hc_dir_mono_color($l['company_name']) . ',#0a2e1e)"' ?>>
          <span class="dx-badge is-featured"><i class="fa-solid fa-star"></i>Featured</span>
          <?= hc_dir_logo($l, 64) ?>
        </div>
        <div class="sp-body">
          <h3><?= htmlspecialchars($l['company_name']) ?></h3>
          <div class="sp-loc"><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></div>
          <div class="sp-desc"><?= htmlspecialchars($l['tagline'] ?: hc_dir_public_desc($l)) ?></div>
          <div class="sp-foot">View profile <i class="fa-solid fa-arrow-right"></i></div>
        </div>
      </a>
      <?php endforeach ?>
      <?php for ($i = count($spotlight); $i < 3; $i++): ?>
      <a class="sp-empty" href="/directory/submit/?plan=featured">
        <div class="ic"><i class="fa-solid fa-star"></i></div>
        <h3>Your agency here</h3>
        <p>Featured agencies appear here and at the top of results in their city.</p>
        <span>Get featured <i class="fa-solid fa-arrow-right"></i></span>
      </a>
      <?php endfor ?>
    </div>
  </div>
</section>
<?php endif ?>

<!-- RESULTS -->
<section class="dx-sec" id="results">
  <div class="dx-wrap dr">

    <form class="df" id="dxFilters" method="GET" action="/directory/#results">
      <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
      <input type="hidden" name="loc" value="<?= htmlspecialchars($loc) ?>">
      <?php if ($sort !== 'recommended'): ?><input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>"><?php endif ?>

      <div class="df-group">
        <h4>Type of care</h4>
        <?php foreach (HC_DIR_SERVICES as $i => $s): ?>
        <label class="df-check<?= $i >= 6 && !in_array($s, $svcSel, true) ? ' df-more' : '' ?>"><input type="checkbox" name="svc[]" value="<?= htmlspecialchars($s) ?>" <?= in_array($s, $svcSel, true) ? 'checked' : '' ?>><?= htmlspecialchars($s) ?></label>
        <?php endforeach ?>
        <button type="button" class="df-toggle" onclick="var g=this.parentNode;g.classList.toggle('open');this.textContent=g.classList.contains('open')?'Show less':'Show all 12'">Show all 12</button>
      </div>

      <div class="df-group">
        <h4>Payment accepted</h4>
        <?php foreach (HC_DIR_PAYMENTS as $p): ?>
        <label class="df-check"><input type="checkbox" name="pay[]" value="<?= htmlspecialchars($p) ?>" <?= in_array($p, $paySel, true) ? 'checked' : '' ?>><?= htmlspecialchars($p) ?></label>
        <?php endforeach ?>
      </div>

      <div class="df-group">
        <h4>Trust</h4>
        <label class="df-check"><input type="checkbox" name="verified" value="1" <?= $verified ? 'checked' : '' ?>>Verified or owner-claimed</label>
      </div>

      <div class="df-group">
        <h4>State</h4>
        <?php foreach ($statesUsed as $s): ?>
        <a class="df-state<?= $locState === $s['state'] && !$locCity ? ' on' : '' ?>" href="<?= htmlspecialchars(dx_url(['loc' => $s['state'], 'page' => null])) ?>#results"><?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?><span><?= (int)$s['n'] ?></span></a>
        <?php endforeach ?>
      </div>

      <noscript><button type="submit" class="dx-btn is-primary" style="width:100%;margin-bottom:14px">Apply filters</button></noscript>

      <div class="df-promo">
        <h4>Own a home care agency?</h4>
        <p>Get listed for free, or claim your existing profile so families can find you.</p>
        <a href="/directory/submit/" class="dx-btn is-primary">List your agency</a>
      </div>
    </form>

    <div>
      <div class="rb">
        <div>
          <h2><?= $isFiltered ? number_format($total) . ' agenc' . ($total === 1 ? 'y' : 'ies') . ' found' : 'All home care agencies' ?></h2>
          <p><?= $total ? 'Showing ' . ($offset + 1) . '–' . min($offset + $perPage, $total) . ' of ' . number_format($total) : 'No matches' ?></p>
        </div>
        <div class="rb-right">
          <button type="button" class="dx-btn df-mtoggle" onclick="document.getElementById('dxFilters').classList.toggle('open')"><i class="fa-solid fa-sliders"></i>Filters</button>
          <select aria-label="Sort" onchange="location.href=this.value">
            <?php foreach (['recommended' => 'Sort: Recommended', 'az' => 'Sort: Name (A–Z)', 'newest' => 'Sort: Newest'] as $k => $v): ?>
            <option value="<?= htmlspecialchars(dx_url(['sort' => $k === 'recommended' ? null : $k, 'page' => null])) ?>#results" <?= $sort === $k ? 'selected' : '' ?>><?= $v ?></option>
            <?php endforeach ?>
          </select>
        </div>
      </div>

      <?php if ($isFiltered): ?>
      <div class="rb-chips">
        <?php if ($q !== ''): ?><a href="<?= htmlspecialchars(dx_url(['q' => null, 'page' => null])) ?>">“<?= htmlspecialchars($q) ?>”<i class="fa-solid fa-xmark"></i></a><?php endif ?>
        <?php if ($loc !== ''): ?><a href="<?= htmlspecialchars(dx_url(['loc' => null, 'page' => null])) ?>"><?= htmlspecialchars($where_label ?: $loc) ?><i class="fa-solid fa-xmark"></i></a><?php endif ?>
        <?php foreach ($svcSel as $s): ?><a href="<?= htmlspecialchars(dx_url(['svc' => array_values(array_diff($svcSel, [$s])), 'page' => null])) ?>"><?= htmlspecialchars($s) ?><i class="fa-solid fa-xmark"></i></a><?php endforeach ?>
        <?php foreach ($paySel as $p): ?><a href="<?= htmlspecialchars(dx_url(['pay' => array_values(array_diff($paySel, [$p])), 'page' => null])) ?>"><?= htmlspecialchars($p) ?><i class="fa-solid fa-xmark"></i></a><?php endforeach ?>
        <?php if ($verified): ?><a href="<?= htmlspecialchars(dx_url(['verified' => null, 'page' => null])) ?>">Verified<i class="fa-solid fa-xmark"></i></a><?php endif ?>
        <a class="clear" href="/directory/#results">Clear all</a>
      </div>
      <?php endif ?>

      <?php if ($listings): ?>
      <?php foreach ($listings as $l):
        $tier = hc_dir_tier($l);
        $paid = $tier !== 'free';
        $svcs = hc_dir_lines($l['services']);
        $url  = '/directory/' . urlencode($l['slug']);
      ?>
      <article class="rc<?= $tier === 'featured' ? ' is-feat' : '' ?>">
        <?php if ($tier === 'featured'): ?><span class="rc-tag">Featured</span><?php endif ?>
        <a href="<?= $url ?>" tabindex="-1" aria-hidden="true"><?= hc_dir_logo($l, 76, $paid) ?></a>
        <div class="rc-main">
          <h3><a href="<?= $url ?>"><?= htmlspecialchars($l['company_name']) ?></a></h3>
          <div class="rc-loc">
            <span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></span>
            <?php if ($l['years_in_business']): ?><span><i class="fa-regular fa-calendar"></i><?= htmlspecialchars($l['years_in_business']) ?> years in business</span><?php endif ?>
          </div>
          <?php if ($b = hc_dir_badges($l, $tier)): ?><div class="rc-badges"><?= $b ?></div><?php endif ?>
          <p class="rc-desc"><?= htmlspecialchars(($paid && $l['tagline']) ? $l['tagline'] : hc_dir_public_desc($l)) ?></p>
          <?php if ($svcs): ?>
          <div class="rc-svcs">
            <?php foreach (array_slice($svcs, 0, 4) as $s): ?><span><?= htmlspecialchars($s) ?></span><?php endforeach ?>
            <?php if (count($svcs) > 4): ?><span class="more">+<?= count($svcs) - 4 ?> more</span><?php endif ?>
          </div>
          <?php endif ?>
        </div>
        <div class="rc-act">
          <?php if ($l['phone']): ?>
          <a class="rc-phone" href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $l['phone'])) ?>"><i class="fa-solid fa-phone"></i><?= htmlspecialchars($l['phone']) ?></a>
          <?php endif ?>
          <?php if ($tier === 'featured'): ?>
          <a class="dx-btn is-primary" href="<?= $url ?>#contact">Request info</a>
          <?php endif ?>
          <a class="dx-btn<?= $tier === 'featured' ? '' : ' is-dark' ?>" href="<?= $url ?>">View profile</a>
        </div>
      </article>
      <?php endforeach ?>

      <?php if ($pages > 1): ?>
      <div class="pg" role="navigation" aria-label="Pages">
        <?php if ($page > 1): ?><a href="<?= htmlspecialchars(dx_url(['page' => $page - 1 > 1 ? $page - 1 : null])) ?>#results" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></a><?php endif ?>
        <?php for ($p = 1; $p <= $pages; $p++):
          if ($p !== 1 && $p !== $pages && abs($p - $page) > 2) { if (abs($p - $page) === 3) echo '<span class="gap">…</span>'; continue; } ?>
          <?php if ($p === $page): ?><span class="on"><?= $p ?></span><?php else: ?><a href="<?= htmlspecialchars(dx_url(['page' => $p > 1 ? $p : null])) ?>#results"><?= $p ?></a><?php endif ?>
        <?php endfor ?>
        <?php if ($page < $pages): ?><a href="<?= htmlspecialchars(dx_url(['page' => $page + 1])) ?>#results" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></a><?php endif ?>
      </div>
      <?php endif ?>

      <?php else: ?>
      <div class="r-empty">
        <div class="ic"><i class="fa-solid fa-magnifying-glass"></i></div>
        <h3>No agencies match those filters yet</h3>
        <p>Try removing a filter or searching a nearby city.</p>
        <a href="/directory/#results" class="dx-btn is-dark">Clear filters</a>
      </div>
      <?php endif ?>
    </div>
  </div>
</section>

<?php if ($topCities): ?>
<!-- CITIES -->
<section class="dc">
  <div class="dx-wrap">
    <div class="dx-sec-h"><div><div class="dx-kicker">Browse</div><h2>Home care by city</h2></div></div>
    <div class="dc-grid">
      <?php foreach ($topCities as $c): ?>
      <a href="/directory/?loc=<?= urlencode($c['city'] . ', ' . $c['state']) ?>#results"><?= htmlspecialchars($c['city'] . ', ' . $c['state']) ?><span><?= (int)$c['n'] ?> agenc<?= $c['n'] == 1 ? 'y' : 'ies' ?></span></a>
      <?php endforeach ?>
    </div>
  </div>
</section>
<?php endif ?>

<!-- FOR AGENCY OWNERS -->
<section class="do" id="list-your-agency">
  <div class="dx-wrap">
    <div class="do-head">
      <div class="dx-kicker" style="color:var(--teal-lt)">For agency owners</div>
      <h2>Get found by families who are choosing care right now.</h2>
      <p>Start free, or upgrade for a verified profile with your logo, photos, website link and top placement in your city.</p>
    </div>
    <?= hc_dir_pricing_html(fn($k) => '/directory/submit/?plan=' . $k) ?>
    <div class="do-foot">
      <span><i class="fa-solid fa-file-invoice"></i>No card needed: paid plans are invoiced</span>
      <span><i class="fa-solid fa-rotate"></i>Change or cancel anytime</span>
      <span><i class="fa-solid fa-user-shield"></i>Every listing confirmed with the owner</span>
    </div>
  </div>
</section>

</div>
<?php
$page_js = <<<JS
(function(){
  var f = document.getElementById('dxFilters');
  if (!f) return;
  f.addEventListener('change', function(e){ if (e.target.matches('input[type=checkbox]')) f.submit(); });
})();
JS;
include '../includes/footer.php';
