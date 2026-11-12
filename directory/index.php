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


$stackAgencies = hc_all("SELECT company_name, logo FROM hc_directory_listings WHERE status='approved' ORDER BY RAND() LIMIT 4");
$activeCount = count($svcSel) + count($paySel) + ($verified ? 1 : 0) + ($loc !== '' ? 1 : 0);

$page_css = hc_dir_base_css() . <<<CSS
/* ── HERO PANEL ─────────────────────────── */
.hx{display:grid;grid-template-columns:1.15fr .85fr;gap:64px;align-items:center}
.hx .dx-label{margin-bottom:28px}
.hx .dx-h1{margin-bottom:24px}
.hx .dx-lead{max-width:520px;margin-bottom:36px}
.sb{display:flex;align-items:center;background:#fff;border:1px solid var(--hair);border-radius:100px;padding:7px 7px 7px 8px;max-width:640px;box-shadow:0 20px 50px rgba(10,46,30,.08)}
.sb label{flex:1;display:flex;align-items:center;gap:12px;padding:0 18px;min-width:0}
.sb label+label{border-left:1px solid var(--hair)}
.sb label i{color:var(--mut);font-size:14px}
.sb input{flex:1;min-width:0;border:0;outline:0;background:none;font:inherit;font-size:15.5px;color:var(--ink);padding:14px 0}
.sb input::placeholder{color:#8a968e}
.sb button{width:54px;height:54px;border-radius:50%;border:0;background:var(--ink);color:#fff;font-size:16px;cursor:pointer;flex-shrink:0;transition:background .2s}
.sb button:hover{background:var(--teal)}
.hx-pop{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-top:20px;font-size:13.5px;color:var(--mut)}
.hx-pop a{border:1px solid var(--hair);border-radius:100px;padding:7px 14px;color:var(--ink);font-size:13px;font-weight:500;transition:background .15s,border-color .15s}
.hx-pop a:hover{background:#fff;border-color:var(--ink)}

.hx-art{position:relative}
.hx-photo{border-radius:32px;overflow:hidden;aspect-ratio:4/4.6}
.hx-photo img{width:100%;height:100%;object-fit:cover;object-position:60% center;display:block;filter:saturate(.9)}
.hx-sticker{position:absolute;left:-36px;bottom:36px;background:#fff;border-radius:24px;padding:18px 20px;box-shadow:0 24px 60px rgba(10,46,30,.16);display:flex;align-items:center;gap:14px;max-width:290px}
.hx-stack{display:flex}
.hx-stack .dx-logo{border:3px solid #fff!important;margin-left:-12px}
.hx-stack .dx-logo:first-child{margin-left:0}
.hx-sticker b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;color:var(--ink);line-height:1.25}
.hx-sticker span{font-size:12.5px;color:var(--mut)}
.hx-tag{position:absolute;top:28px;right:-18px;background:var(--ink);color:#fff;border-radius:100px;padding:11px 18px 11px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;display:flex;align-items:center;gap:9px;box-shadow:0 16px 40px rgba(10,46,30,.25)}
.hx-tag i{color:var(--teal-lt)}

.hx-stats{display:grid;grid-template-columns:repeat(4,1fr);margin-top:72px;border-top:1px solid var(--hair)}
.hx-stats div{padding:28px 0 0}
.hx-stats div+div{padding-left:32px;border-left:1px solid var(--hair)}
.hx-stats b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:44px;font-weight:800;color:var(--ink);letter-spacing:-.04em;line-height:1}
.hx-stats span{display:block;font-size:14px;color:var(--mut);margin-top:8px}

/* ── BROWSE + FEATURED PANEL ────────────── */
.sh{display:flex;justify-content:space-between;align-items:flex-end;gap:24px;margin-bottom:36px}
.sh p{max-width:420px;color:var(--mut);font-size:15.5px;line-height:1.6}
.st-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.st{background:#fff;border-radius:28px;padding:26px 26px 24px;display:flex;flex-direction:column;justify-content:space-between;min-height:220px;transition:transform .25s}
.st:hover{transform:translateY(-4px)}
.st:hover .dx-arrow{background:var(--ink);color:#fff;border-color:var(--ink);transform:rotate(-45deg)}
.st-top{display:flex;justify-content:space-between;align-items:flex-start}
.st-code{font-family:'Plus Jakarta Sans',sans-serif;font-size:72px;font-weight:800;letter-spacing:-.06em;line-height:.9;color:var(--ink)}
.st h3{font-size:18px;font-weight:700;margin-bottom:2px}
.st p{font-size:14px;color:var(--mut)}

.fe-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px;margin-top:16px}
.fe{background:#fff;border-radius:28px;padding:10px;display:flex;flex-direction:column;transition:transform .25s}
.fe:hover{transform:translateY(-4px)}
.fe-cover{border-radius:20px;height:150px;position:relative;background-size:cover;background-position:center}
.fe-cover .dx-badge{position:absolute;top:14px;left:14px}
.fe-cover .dx-logo{position:absolute;left:18px;bottom:-28px;border:4px solid #fff!important}
.fe-body{padding:42px 16px 16px;display:flex;flex-direction:column;flex:1}
.fe-body h3{font-size:19px;font-weight:700;margin-bottom:4px}
.fe-loc{font-size:14px;color:var(--mut);margin-bottom:12px}
.fe-desc{font-size:14.5px;color:var(--txt);line-height:1.55;flex:1;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.fe-foot{display:flex;justify-content:space-between;align-items:center;margin-top:18px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--ink)}
.fe:hover .dx-arrow{background:var(--ink);color:#fff;border-color:var(--ink);transform:rotate(-45deg)}
.fe-empty{border:1.5px dashed rgba(10,46,30,.2);border-radius:28px;padding:30px;display:flex;flex-direction:column;justify-content:flex-end;min-height:330px;position:relative;transition:background .2s,border-color .2s}
.fe-empty:hover{background:rgba(255,255,255,.6);border-color:var(--ink)}
.fe-empty .big{position:absolute;top:26px;right:30px;font-family:'Plus Jakarta Sans',sans-serif;font-size:96px;font-weight:800;line-height:1;color:rgba(10,46,30,.06)}
.fe-empty h3{font-size:22px;font-weight:800;letter-spacing:-.03em;margin-bottom:8px}
.fe-empty p{font-size:14.5px;color:var(--mut);line-height:1.55;margin-bottom:18px;max-width:280px}
.fe-empty span{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--teal)}

/* ── RESULTS PANEL ─────────────────────── */
.rh{display:flex;justify-content:space-between;align-items:flex-end;gap:24px;margin-bottom:28px;flex-wrap:wrap}
.rh-count{font-size:15px;color:var(--mut)}
.fb{display:flex;flex-wrap:wrap;gap:8px;align-items:center;margin-bottom:20px}
.fb-dd{position:relative}
.fb-dd summary{list-style:none;display:inline-flex;align-items:center;gap:8px;cursor:pointer;background:#fff;border:1px solid var(--hair);border-radius:100px;padding:11px 16px 11px 18px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--ink);user-select:none;transition:border-color .15s}
.fb-dd summary::-webkit-details-marker{display:none}
.fb-dd summary:hover,.fb-dd[open] summary{border-color:var(--ink)}
.fb-dd summary i{font-size:10px;color:var(--mut);transition:transform .2s}
.fb-dd[open] summary i{transform:rotate(180deg)}
.fb-dd summary .n{background:var(--ink);color:#fff;border-radius:100px;font-size:11px;min-width:20px;height:20px;padding:0 6px;display:inline-flex;align-items:center;justify-content:center}
.fb-pop{position:absolute;top:calc(100% + 8px);left:0;z-index:40;background:#fff;border-radius:22px;box-shadow:0 24px 60px rgba(10,46,30,.18);padding:14px;min-width:270px;border:1px solid var(--hair-2)}
.fb-opt{display:flex;align-items:center;gap:12px;padding:10px 12px;border-radius:12px;font-size:14.5px;color:var(--txt);cursor:pointer}
.fb-opt:hover{background:var(--cream)}
.fb-opt input{width:17px;height:17px;accent-color:var(--ink);flex-shrink:0}
.fb-opt span{margin-left:auto;font-size:12px;color:var(--mut)}
.fb-tog{display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--hair);border-radius:100px;padding:11px 18px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--ink);cursor:pointer}
.fb-tog input{display:none}
.fb-tog .sw{width:30px;height:18px;border-radius:100px;background:rgba(10,46,30,.15);position:relative;transition:background .2s}
.fb-tog .sw::after{content:"";position:absolute;top:2px;left:2px;width:14px;height:14px;border-radius:50%;background:#fff;transition:transform .2s}
.fb-tog input:checked+.sw{background:var(--teal)}
.fb-tog input:checked+.sw::after{transform:translateX(12px)}
.fb-sort{margin-left:auto;display:flex;align-items:center;gap:8px;font-size:13.5px;color:var(--mut)}
.fb-sort select{appearance:none;-webkit-appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%230a2e1e' stroke-width='1.5' fill='none'/%3E%3C/svg%3E") no-repeat right 16px center;border:1px solid var(--hair);border-radius:100px;padding:11px 38px 11px 18px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--ink);cursor:pointer}
.fb-chips{display:flex;flex-wrap:wrap;gap:8px;margin:-6px 0 20px}
.fb-chips a{display:inline-flex;align-items:center;gap:8px;background:var(--ink);color:#fff;border-radius:100px;padding:8px 14px;font-size:13px;font-weight:500}
.fb-chips a i{font-size:10px;opacity:.7}
.fb-chips a.clear{background:none;color:var(--ink);text-decoration:underline!important;text-underline-offset:3px}

.sheet{background:#fff;border-radius:32px;padding:8px 0;overflow:hidden}
.rw{position:relative;display:grid;grid-template-columns:44px 64px 1fr auto;gap:22px;align-items:center;padding:26px 32px;transition:background .2s}
.rw+.rw{border-top:1px solid var(--hair-2)}
.rw:hover{background:#fbfaf6}
.rw.is-feat{background:linear-gradient(90deg,#fdf8ea,#fff 70%)}
.rw-n{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#a3ada6;font-variant-numeric:tabular-nums}
.rw-main{min-width:0}
.rw-title{display:flex;align-items:center;gap:10px;flex-wrap:wrap;margin-bottom:6px}
.rw h3{font-size:19px;font-weight:700;letter-spacing:-.02em;line-height:1.25}
.rw h3 a::after{content:"";position:absolute;inset:0;z-index:1}
.rw-meta{display:flex;flex-wrap:wrap;gap:4px 18px;font-size:14px;color:var(--mut);margin-bottom:6px}
.rw-meta i{font-size:11px;margin-right:6px;color:var(--teal)}
.rw-desc{font-size:14.5px;color:var(--txt);line-height:1.55;display:-webkit-box;-webkit-line-clamp:1;-webkit-box-orient:vertical;overflow:hidden;max-width:620px}
.rw-svcs{display:flex;flex-wrap:wrap;gap:6px;margin-top:10px}
.rw-svcs span{font-size:12.5px;color:var(--ink);border:1px solid var(--hair);border-radius:100px;padding:4px 11px}
.rw-act{display:flex;align-items:center;gap:10px;position:relative;z-index:2}
.rw-phone{display:inline-flex;align-items:center;gap:9px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--ink);border:1px solid var(--hair);border-radius:100px;padding:11px 16px;background:#fff;transition:border-color .15s}
.rw-phone i{font-size:12px;color:var(--teal)}
.rw-phone:hover{border-color:var(--ink)}
.rw:hover .rw-go{background:var(--ink);color:#fff;border-color:var(--ink);transform:rotate(-45deg)}

.r-empty{background:#fff;border-radius:32px;padding:72px 24px;text-align:center}
.r-empty h3{font-size:24px;font-weight:800;margin-bottom:8px}
.r-empty p{color:var(--mut);margin-bottom:22px}

.pg{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-top:24px;flex-wrap:wrap}
.pg-info{font-size:14px;color:var(--mut)}
.pg-nums{display:flex;gap:6px;flex-wrap:wrap}
.pg-nums a,.pg-nums span{min-width:44px;height:44px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:14px;color:var(--ink);border:1px solid var(--hair);background:#fff;padding:0 6px}
.pg-nums a:hover{border-color:var(--ink)}
.pg-nums .on{background:var(--ink);border-color:var(--ink);color:#fff}
.pg-nums .gap{border:0;background:none}

/* cities */
.ct{display:grid;grid-template-columns:repeat(4,1fr);gap:0 40px;margin-top:8px}
.ct a{display:flex;justify-content:space-between;align-items:center;padding:16px 0;border-bottom:1px solid var(--hair);font-size:15.5px;color:var(--ink);transition:padding .2s,color .2s}
.ct a span{font-size:13px;color:var(--mut)}
.ct a:hover{color:var(--teal);padding-left:6px}

/* ── OWNERS (on forest) ─────────────────── */
.ow{max-width:1400px;margin:0 auto;padding:110px 36px 90px}
.ow-head{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:end;max-width:1200px;margin:0 auto 56px}
.ow-head .dx-h2{color:#fff}
.ow-head .dx-h2 em{color:var(--teal-lt)}
.ow-head p{color:rgba(255,255,255,.6);font-size:17px;line-height:1.7}
.ow .dx-label{color:#fff;border-color:rgba(255,255,255,.18);background:rgba(255,255,255,.04);margin-bottom:22px}
.ow .dx-pricing{max-width:1200px;margin:0 auto}
.ow-foot{display:flex;justify-content:center;flex-wrap:wrap;gap:12px 36px;margin-top:40px;font-size:14px;color:rgba(255,255,255,.6)}
.ow-foot i{color:var(--teal-lt);margin-right:8px}

@media(max-width:1100px){
  .hx{grid-template-columns:1fr;gap:48px}
  .hx-art{max-width:520px}
  .hx-sticker{left:16px}
  .hx-tag{right:16px}
  .st-grid{grid-template-columns:1fr 1fr}
  .fe-grid{grid-template-columns:1fr 1fr}
  .ct{grid-template-columns:repeat(3,1fr)}
  .ow-head{grid-template-columns:1fr;gap:16px}
}
@media(max-width:760px){
  .sb{flex-direction:column;align-items:stretch;border-radius:28px;padding:8px}
  .sb label{padding:4px 14px}
  .sb label+label{border-left:0;border-top:1px solid var(--hair)}
  .sb button{width:100%;border-radius:100px;height:50px;margin-top:6px}
  .hx-art{display:none}
  .hx-stats{grid-template-columns:1fr 1fr;margin-top:48px}
  .hx-stats div:nth-child(3){padding-left:0;border-left:0}
  .hx-stats div:nth-child(n+3){margin-top:24px}
  .hx-stats b{font-size:34px}
  .sh{flex-direction:column;align-items:flex-start;gap:12px}
  .st{min-height:170px;border-radius:24px;padding:20px}
  .st-code{font-size:52px}
  .fe-grid{grid-template-columns:1fr}
  .fe-empty{min-height:220px}
  .fb-sort{margin-left:0;width:100%}
  .fb-pop{min-width:240px}
  .sheet{border-radius:24px}
  .rw{grid-template-columns:52px 1fr;gap:14px;padding:20px 18px}
  .rw-n{display:none}
  .rw .dx-logo{width:52px!important;height:52px!important;font-size:17px!important}
  .rw-act{grid-column:1/-1}
  .rw-phone{flex:1;justify-content:center}
  .ct{grid-template-columns:1fr 1fr;gap:0 20px}
  .ow{padding:72px 10px 56px}
}
CSS;
include '../includes/header.php';

$popular = ['Personal Care' => 'Personal Care', 'Companion Care' => 'Companion Care', 'Dementia Care' => 'Alzheimer\'s & Dementia Care', '24-Hour Care' => '24-Hour Care'];
?>
<div id="scrollProgress"></div>
<div class="dx">

<!-- HERO -->
<div class="dx-frame is-first">
  <section class="dx-panel">
    <div class="dx-in">
      <div class="hx">
        <div>
          <?php if ($isFiltered): ?>
          <div class="dx-crumbs"><a href="/directory/">Agency Directory</a><i class="fa-solid fa-chevron-right"></i>Search</div>
          <h1 class="dx-h1" style="font-size:clamp(36px,4.6vw,64px)"><?= htmlspecialchars($heading) ?></h1>
          <?php else: ?>
          <span class="dx-label">Home Care Agency Directory</span>
          <h1 class="dx-h1">Find home care<br>you can <em>trust.</em></h1>
          <?php endif ?>
          <p class="dx-lead">Compare local agencies by the care they offer, where they serve and how they're paid, then reach out directly. No sign-up needed.</p>
          <form class="sb" method="GET" action="/directory/#results" role="search">
            <label><i class="fa-solid fa-magnifying-glass"></i><input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Agency or type of care" aria-label="Agency or type of care"></label>
            <label><i class="fa-solid fa-location-dot"></i><input type="text" name="loc" value="<?= htmlspecialchars($loc) ?>" placeholder="City or state" list="dxLocs" aria-label="City or state"></label>
            <button type="submit" aria-label="Search"><i class="fa-solid fa-arrow-right"></i></button>
            <datalist id="dxLocs">
              <?php foreach ($statesUsed as $s): ?><option value="<?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?>"><?php endforeach ?>
              <?php foreach ($locOptions as $o): ?><option value="<?= htmlspecialchars($o['city'] . ', ' . $o['state']) ?>"><?php endforeach ?>
            </datalist>
          </form>
          <div class="hx-pop">Popular
            <?php foreach ($popular as $label => $svc): ?>
            <a href="<?= htmlspecialchars(dx_url(['q' => null, 'svc' => [$svc], 'page' => null])) ?>#results"><?= htmlspecialchars($label) ?></a>
            <?php endforeach ?>
          </div>
        </div>
        <div class="hx-art" aria-hidden="true">
          <div class="hx-photo"><img src="/images/home/hero-caregiver-elderly.jpg" alt=""></div>
          <div class="hx-tag"><i class="fa-solid fa-shield-heart"></i>Every listing reviewed</div>
          <div class="hx-sticker">
            <div class="hx-stack"><?php foreach ($stackAgencies as $a) echo hc_dir_logo($a, 40, false); ?></div>
            <div><b><?= $allCount ?> agencies</b><span>across <?= count($locOptions) ?> cities</span></div>
          </div>
        </div>
      </div>
      <?php if (!$isFiltered): ?>
      <div class="hx-stats">
        <div><b><?= $allCount ?></b><span>Agencies listed</span></div>
        <div><b><?= count($locOptions) ?></b><span>Cities covered</span></div>
        <div><b><?= $stateCount ?></b><span>States</span></div>
        <div><b>$0</b><span>Free for families, always</span></div>
      </div>
      <?php endif ?>
    </div>
  </section>

  <?php if (!$isFiltered && $page === 1): ?>
  <!-- BROWSE + FEATURED -->
  <section class="dx-panel">
    <div class="dx-in">
      <div class="sh">
        <div><div class="dx-kick" style="margin-bottom:14px">Browse by state</div><h2 class="dx-h2">Start <em>where you are.</em></h2></div>
        <p>Pick a state to see every agency we list there, or search for a city above.</p>
      </div>
      <div class="st-grid">
        <?php foreach (array_slice($statesUsed, 0, 4) as $s): ?>
        <a class="st" href="/directory/?loc=<?= urlencode($s['state']) ?>#results">
          <div class="st-top"><span class="st-code"><?= htmlspecialchars($s['state']) ?></span><span class="dx-arrow"><i class="fa-solid fa-arrow-right"></i></span></div>
          <div><h3><?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?></h3><p><?= (int)$s['n'] ?> agenc<?= $s['n'] == 1 ? 'y' : 'ies' ?></p></div>
        </a>
        <?php endforeach ?>
      </div>

      <div class="sh" style="margin:88px 0 0">
        <div><div class="dx-kick" style="margin-bottom:14px">Featured</div><h2 class="dx-h2">Agencies in <em>the spotlight.</em></h2></div>
        <p>Featured agencies are paid placements. They're reviewed like every other listing.</p>
      </div>
      <div class="fe-grid" style="margin-top:36px">
        <?php foreach ($spotlight as $l): $mc = hc_dir_mono_color($l['company_name']); ?>
        <a class="fe" href="/directory/<?= urlencode($l['slug']) ?>">
          <div class="fe-cover" style="<?= $l['cover_image'] ? "background-image:url('" . htmlspecialchars($l['cover_image']) . "')" : "background:linear-gradient(135deg,{$mc},#0a2e1e)" ?>">
            <span class="dx-badge is-featured"><i class="fa-solid fa-star"></i>Featured</span>
            <?= hc_dir_logo($l, 60) ?>
          </div>
          <div class="fe-body">
            <h3><?= htmlspecialchars($l['company_name']) ?></h3>
            <div class="fe-loc"><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></div>
            <div class="fe-desc"><?= htmlspecialchars($l['tagline'] ?: hc_dir_public_desc($l)) ?></div>
            <div class="fe-foot">View profile<span class="dx-arrow"><i class="fa-solid fa-arrow-right"></i></span></div>
          </div>
        </a>
        <?php endforeach ?>
        <?php for ($i = count($spotlight); $i < 3; $i++): ?>
        <a class="fe-empty" href="/directory/submit/?plan=featured">
          <span class="big">0<?= $i + 1 ?></span>
          <h3>Your agency here.</h3>
          <p>Featured agencies show up here and at the top of results in their city.</p>
          <span>Get featured →</span>
        </a>
        <?php endfor ?>
      </div>
    </div>
  </section>
  <?php endif ?>

  <!-- RESULTS -->
  <section class="dx-panel" id="results">
    <div class="dx-in">
      <div class="rh">
        <div>
          <div class="dx-kick" style="margin-bottom:14px">The directory</div>
          <h2 class="dx-h2"><?= $isFiltered ? number_format($total) . ' agenc' . ($total === 1 ? 'y' : 'ies') . ' <em>found.</em>' : 'Every agency, <em>one place.</em>' ?></h2>
        </div>
        <div class="rh-count"><?= $total ? 'Showing ' . ($offset + 1) . '–' . min($offset + $perPage, $total) . ' of ' . number_format($total) : '' ?></div>
      </div>

      <form class="fb" id="dxFilters" method="GET" action="/directory/#results">
        <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
        <input type="hidden" name="loc" value="<?= htmlspecialchars($loc) ?>">
        <details class="fb-dd">
          <summary>Type of care<?php if ($svcSel): ?><span class="n"><?= count($svcSel) ?></span><?php endif ?><i class="fa-solid fa-chevron-down"></i></summary>
          <div class="fb-pop">
            <?php foreach (HC_DIR_SERVICES as $s): ?>
            <label class="fb-opt"><input type="checkbox" name="svc[]" value="<?= htmlspecialchars($s) ?>" <?= in_array($s, $svcSel, true) ? 'checked' : '' ?>><?= htmlspecialchars($s) ?></label>
            <?php endforeach ?>
          </div>
        </details>
        <details class="fb-dd">
          <summary>Payment<?php if ($paySel): ?><span class="n"><?= count($paySel) ?></span><?php endif ?><i class="fa-solid fa-chevron-down"></i></summary>
          <div class="fb-pop">
            <?php foreach (HC_DIR_PAYMENTS as $p): ?>
            <label class="fb-opt"><input type="checkbox" name="pay[]" value="<?= htmlspecialchars($p) ?>" <?= in_array($p, $paySel, true) ? 'checked' : '' ?>><?= htmlspecialchars($p) ?></label>
            <?php endforeach ?>
          </div>
        </details>
        <details class="fb-dd">
          <summary><?= $locState && !$locCity ? htmlspecialchars($US_STATES[$locState] ?? $locState) : 'State' ?><i class="fa-solid fa-chevron-down"></i></summary>
          <div class="fb-pop">
            <a class="fb-opt" href="<?= htmlspecialchars(dx_url(['loc' => null, 'page' => null])) ?>#results">All states</a>
            <?php foreach ($statesUsed as $s): ?>
            <a class="fb-opt" href="<?= htmlspecialchars(dx_url(['loc' => $s['state'], 'page' => null])) ?>#results"><?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?><span><?= (int)$s['n'] ?></span></a>
            <?php endforeach ?>
          </div>
        </details>
        <label class="fb-tog"><input type="checkbox" name="verified" value="1" <?= $verified ? 'checked' : '' ?>><span class="sw"></span>Verified &amp; claimed</label>
        <div class="fb-sort">
          <select aria-label="Sort" onchange="location.href=this.value">
            <?php foreach (['recommended' => 'Recommended', 'az' => 'Name A–Z', 'newest' => 'Newest'] as $k => $v): ?>
            <option value="<?= htmlspecialchars(dx_url(['sort' => $k === 'recommended' ? null : $k, 'page' => null])) ?>#results" <?= $sort === $k ? 'selected' : '' ?>><?= $v ?></option>
            <?php endforeach ?>
          </select>
        </div>
        <?php if ($sort !== 'recommended'): ?><input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>"><?php endif ?>
        <noscript><button class="dx-btn is-dark" type="submit">Apply</button></noscript>
      </form>

      <?php if ($isFiltered): ?>
      <div class="fb-chips">
        <?php if ($q !== ''): ?><a href="<?= htmlspecialchars(dx_url(['q' => null, 'page' => null])) ?>#results">“<?= htmlspecialchars($q) ?>”<i class="fa-solid fa-xmark"></i></a><?php endif ?>
        <?php if ($loc !== ''): ?><a href="<?= htmlspecialchars(dx_url(['loc' => null, 'page' => null])) ?>#results"><?= htmlspecialchars($where_label ?: $loc) ?><i class="fa-solid fa-xmark"></i></a><?php endif ?>
        <?php foreach ($svcSel as $s): ?><a href="<?= htmlspecialchars(dx_url(['svc' => array_values(array_diff($svcSel, [$s])), 'page' => null])) ?>#results"><?= htmlspecialchars($s) ?><i class="fa-solid fa-xmark"></i></a><?php endforeach ?>
        <?php foreach ($paySel as $p): ?><a href="<?= htmlspecialchars(dx_url(['pay' => array_values(array_diff($paySel, [$p])), 'page' => null])) ?>#results"><?= htmlspecialchars($p) ?><i class="fa-solid fa-xmark"></i></a><?php endforeach ?>
        <?php if ($verified): ?><a href="<?= htmlspecialchars(dx_url(['verified' => null, 'page' => null])) ?>#results">Verified &amp; claimed<i class="fa-solid fa-xmark"></i></a><?php endif ?>
        <a class="clear" href="/directory/#results">Clear all</a>
      </div>
      <?php endif ?>

      <?php if ($listings): ?>
      <div class="sheet">
        <?php foreach ($listings as $i => $l):
          $tier = hc_dir_tier($l);
          $paid = $tier !== 'free';
          $svcs = hc_dir_lines($l['services']);
          $url  = '/directory/' . urlencode($l['slug']);
        ?>
        <article class="rw<?= $tier === 'featured' ? ' is-feat' : '' ?>">
          <span class="rw-n"><?= str_pad((string)($offset + $i + 1), 2, '0', STR_PAD_LEFT) ?></span>
          <?= hc_dir_logo($l, 64, $paid) ?>
          <div class="rw-main">
            <div class="rw-title"><h3><a href="<?= $url ?>"><?= htmlspecialchars($l['company_name']) ?></a></h3><?= hc_dir_badges($l, $tier, false) ?></div>
            <div class="rw-meta">
              <span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></span>
              <?php if ($l['years_in_business']): ?><span><?= htmlspecialchars($l['years_in_business']) ?> years in business</span><?php endif ?>
              <?php if ($l['license_number']): ?><span>Licensed</span><?php endif ?>
            </div>
            <?php if (($paid && $l['tagline']) || !hc_dir_is_placeholder_desc($l['description'])): ?>
            <p class="rw-desc"><?= htmlspecialchars(($paid && $l['tagline']) ? $l['tagline'] : $l['description']) ?></p>
            <?php endif ?>
            <?php if ($svcs): ?>
            <div class="rw-svcs"><?php foreach (array_slice($svcs, 0, 4) as $s): ?><span><?= htmlspecialchars($s) ?></span><?php endforeach ?><?php if (count($svcs) > 4): ?><span>+<?= count($svcs) - 4 ?></span><?php endif ?></div>
            <?php endif ?>
          </div>
          <div class="rw-act">
            <?php if ($l['phone']): ?><a class="rw-phone" href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $l['phone'])) ?>"><i class="fa-solid fa-phone"></i><?= htmlspecialchars($l['phone']) ?></a><?php endif ?>
            <span class="dx-arrow rw-go"><i class="fa-solid fa-arrow-right"></i></span>
          </div>
        </article>
        <?php endforeach ?>
      </div>

      <?php if ($pages > 1): ?>
      <div class="pg">
        <div class="pg-info">Page <?= $page ?> of <?= $pages ?></div>
        <div class="pg-nums" role="navigation" aria-label="Pages">
          <?php if ($page > 1): ?><a href="<?= htmlspecialchars(dx_url(['page' => $page - 1 > 1 ? $page - 1 : null])) ?>#results" aria-label="Previous"><i class="fa-solid fa-arrow-left" style="font-size:12px"></i></a><?php endif ?>
          <?php for ($p = 1; $p <= $pages; $p++):
            if ($p !== 1 && $p !== $pages && abs($p - $page) > 2) { if (abs($p - $page) === 3) echo '<span class="gap">…</span>'; continue; } ?>
            <?php if ($p === $page): ?><span class="on"><?= $p ?></span><?php else: ?><a href="<?= htmlspecialchars(dx_url(['page' => $p > 1 ? $p : null])) ?>#results"><?= $p ?></a><?php endif ?>
          <?php endfor ?>
          <?php if ($page < $pages): ?><a href="<?= htmlspecialchars(dx_url(['page' => $page + 1])) ?>#results" aria-label="Next"><i class="fa-solid fa-arrow-right" style="font-size:12px"></i></a><?php endif ?>
        </div>
      </div>
      <?php endif ?>

      <?php else: ?>
      <div class="r-empty">
        <h3>Nothing matches <em>just yet.</em></h3>
        <p>Try removing a filter, or search a nearby city.</p>
        <a href="/directory/#results" class="dx-btn is-dark">Clear filters</a>
      </div>
      <?php endif ?>

      <?php if ($topCities && !$isFiltered): ?>
      <div style="margin-top:96px">
        <div class="dx-kick" style="margin-bottom:14px">Browse by city</div>
        <h2 class="dx-h2" style="margin-bottom:28px">Home care <em>near you.</em></h2>
        <div class="ct">
          <?php foreach ($topCities as $c): ?>
          <a href="/directory/?loc=<?= urlencode($c['city'] . ', ' . $c['state']) ?>#results"><?= htmlspecialchars($c['city'] . ', ' . $c['state']) ?><span><?= (int)$c['n'] ?></span></a>
          <?php endforeach ?>
        </div>
      </div>
      <?php endif ?>
    </div>
  </section>

  <!-- FOR AGENCY OWNERS -->
  <section class="ow" id="list-your-agency">
    <div class="ow-head">
      <div>
        <span class="dx-label">For agency owners</span>
        <h2 class="dx-h2">Be the agency families <em>call first.</em></h2>
      </div>
      <p>Start with a free listing. Upgrade for a verified profile with your logo, photos and website link, top placement in your city, and inquiries sent straight to your inbox.</p>
    </div>
    <?= hc_dir_pricing_html(fn($k) => '/directory/submit/?plan=' . $k) ?>
    <div class="ow-foot">
      <span><i class="fa-solid fa-file-invoice"></i>Invoiced monthly, no card needed</span>
      <span><i class="fa-solid fa-rotate"></i>Change or cancel anytime</span>
      <span><i class="fa-solid fa-user-shield"></i>Every listing confirmed with the owner</span>
    </div>
  </section>
</div>

</div>
<?php
$page_js = <<<JS
(function(){
  var f = document.getElementById('dxFilters');
  if (!f) return;
  f.addEventListener('change', function(e){ if (e.target.matches('input[type=checkbox]')) f.submit(); });
  var dds = f.querySelectorAll('details');
  dds.forEach(function(d){ d.addEventListener('toggle', function(){ if (d.open) dds.forEach(function(o){ if (o !== d) o.open = false; }); }); });
  document.addEventListener('click', function(e){ if (!e.target.closest('.fb-dd')) dds.forEach(function(d){ d.open = false; }); });
})();
JS;
include '../includes/footer.php';
