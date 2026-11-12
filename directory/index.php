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
body{background:#fff}
.dx-band h1{color:#fff;font-size:clamp(26px,3.2vw,36px);font-weight:800;margin-bottom:6px;line-height:1.15}
.dx-band-sub{color:rgba(255,255,255,.62);font-size:15.5px;margin-bottom:22px}
.dx-cats{display:flex;gap:8px;flex-wrap:wrap;margin-top:16px}
.dx-cats a{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:rgba(255,255,255,.8);text-decoration:none;padding:7px 12px;border-radius:6px;border:1px solid rgba(255,255,255,.14);transition:.15s}
.dx-cats a:hover,.dx-cats a.on{background:rgba(255,255,255,.1);color:#fff;border-color:rgba(255,255,255,.28)}

.dx-stats{display:flex;gap:28px;margin-top:22px;color:rgba(255,255,255,.55);font-size:13px}
.dx-stats b{color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;margin-right:5px}

/* spotlight */
.dx-spot{padding:36px 0 8px}
.dx-sec-h{display:flex;align-items:baseline;justify-content:space-between;gap:12px;margin-bottom:16px}
.dx-sec-h h2{font-size:19px;font-weight:800}
.dx-sec-h span{font-size:12.5px;color:var(--ink-3)}
.dx-spot-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:18px}
.dx-spot-card{border:1px solid var(--line);border-radius:12px;overflow:hidden;text-decoration:none;background:#fff;transition:box-shadow .2s,border-color .2s;display:flex;flex-direction:column}
.dx-spot-card:hover{border-color:#cfd6d1;box-shadow:0 10px 30px rgba(20,32,26,.08)}
.dx-spot-cover{height:120px;background:#dfe9e3 center/cover no-repeat;position:relative}
.dx-spot-cover.is-blank{background:linear-gradient(120deg,#0f3d28,#1a5c3a)}
.dx-spot-cover .dx-logo{position:absolute;left:18px;bottom:-26px;box-shadow:0 4px 14px rgba(0,0,0,.08)}
.dx-spot-body{padding:36px 18px 18px}
.dx-spot-body h3{font-size:16px;font-weight:800;margin-bottom:3px}
.dx-spot-loc{font-size:13px;color:var(--ink-3);margin-bottom:10px}
.dx-spot-tag{font-size:14px;color:var(--ink-2);line-height:1.5;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}

/* layout */
.dx-main{display:grid;grid-template-columns:248px 1fr;gap:40px;padding:32px 0 72px}
.dx-filters{position:sticky;top:90px;align-self:start;font-size:14px}
.dx-fgroup{padding:18px 0;border-bottom:1px solid var(--line-2)}
.dx-fgroup:first-child{padding-top:0}
.dx-fgroup h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:800;margin-bottom:10px;color:var(--ink)}
.dx-check{display:flex;align-items:center;gap:9px;padding:4px 0;color:var(--ink-2);cursor:pointer;line-height:1.35}
.dx-check input{width:16px;height:16px;accent-color:var(--teal);flex-shrink:0}
.dx-fmore{display:none}
.dx-fgroup.open .dx-fmore{display:flex}
.dx-ftoggle{background:none;border:0;color:var(--teal);font-weight:700;font-size:13px;padding:6px 0 0;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif}
.dx-states a{display:flex;justify-content:space-between;padding:4px 0;text-decoration:none;color:var(--ink-2)}
.dx-states a:hover,.dx-states a.on{color:var(--teal)}
.dx-states a span{color:var(--ink-3);font-size:12.5px}
.dx-promo{margin-top:20px;border:1px solid var(--line);border-radius:12px;padding:18px;background:var(--bg)}
.dx-promo h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;margin-bottom:6px}
.dx-promo p{font-size:13px;color:var(--ink-3);line-height:1.55;margin-bottom:12px}

.dx-resbar{display:flex;align-items:center;justify-content:space-between;gap:16px;padding-bottom:14px;border-bottom:1px solid var(--line);flex-wrap:wrap}
.dx-resbar h2{font-size:21px;font-weight:800}
.dx-resbar p{font-size:13px;color:var(--ink-3);margin-top:2px}
.dx-sort{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--ink-3)}
.dx-sort select{font:inherit;font-size:13.5px;font-weight:600;color:var(--ink);border:1px solid var(--line);border-radius:7px;padding:7px 10px;background:#fff}
.dx-active{display:flex;gap:6px;flex-wrap:wrap;padding-top:12px}
.dx-active a{font-size:12.5px;font-weight:600;text-decoration:none;background:#eef3ef;color:var(--forest);padding:5px 10px;border-radius:5px}
.dx-active a i{margin-left:6px;opacity:.6;font-size:11px}

.dx-res{display:grid;grid-template-columns:88px 1fr 168px;gap:20px;padding:22px 0;border-bottom:1px solid var(--line-2);position:relative}
.dx-res.is-feat{background:linear-gradient(90deg,#fffcf3,#fff 60%);margin:0 -18px;padding:22px 18px;border-bottom-color:var(--gold-line);border-top:1px solid var(--gold-line)}
.dx-res.is-feat+.dx-res.is-feat{border-top:0}
.dx-res-label{position:absolute;top:10px;right:18px;font-size:10.5px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--gold-ink);font-family:'Plus Jakarta Sans',sans-serif}
.dx-res h3{font-size:18px;font-weight:800;line-height:1.25;margin-bottom:6px}
.dx-res h3 a{text-decoration:none}
.dx-res h3 a:hover{color:var(--teal)}
.dx-res-num{color:var(--ink-3);font-weight:700;margin-right:4px}
.dx-res-badges{display:flex;gap:6px;flex-wrap:wrap;margin-bottom:8px}
.dx-res-meta{font-size:13.5px;color:var(--ink-3);display:flex;gap:14px;flex-wrap:wrap;margin-bottom:8px}
.dx-res-meta i{margin-right:5px;font-size:12px}
.dx-res-desc{font-size:14.5px;color:var(--ink-2);line-height:1.55;display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden;margin-bottom:10px}
.dx-res-svcs{display:flex;gap:6px;flex-wrap:wrap}
.dx-res-svcs span{font-size:12px;font-weight:600;color:var(--ink-2);background:#f2f4f2;padding:4px 9px;border-radius:5px}
.dx-res-svcs span.more{background:none;color:var(--ink-3)}
.dx-res-side{display:flex;flex-direction:column;gap:8px;align-items:stretch;padding-top:2px}
.dx-res-phone{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--ink);text-decoration:none;text-align:right;margin-bottom:4px}
.dx-res-phone i{color:var(--teal);margin-right:6px;font-size:12px}

.dx-empty{padding:56px 0;text-align:center;color:var(--ink-3)}
.dx-empty h3{color:var(--ink);font-size:18px;margin-bottom:6px}

.dx-pager{display:flex;gap:6px;justify-content:center;padding-top:32px;flex-wrap:wrap}
.dx-pager a,.dx-pager span{min-width:38px;height:38px;display:inline-flex;align-items:center;justify-content:center;padding:0 10px;border:1px solid var(--line);border-radius:8px;font-weight:700;font-size:13.5px;text-decoration:none;color:var(--ink-2);font-family:'Plus Jakarta Sans',sans-serif}
.dx-pager .on{background:var(--forest);border-color:var(--forest);color:#fff}
.dx-pager a:hover{border-color:#b9c2bc}

/* cities + owners */
.dx-cities{background:var(--bg);border-top:1px solid var(--line);padding:56px 0}
.dx-city-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:4px 24px}
.dx-city-grid a{display:flex;justify-content:space-between;padding:9px 0;border-bottom:1px solid var(--line);text-decoration:none;font-size:14.5px;color:var(--ink-2)}
.dx-city-grid a:hover{color:var(--teal)}
.dx-city-grid a span{color:var(--ink-3);font-size:13px}
.dx-owners{padding:80px 0;background:#fff}
.dx-owners-head{display:grid;grid-template-columns:1fr 1fr;gap:40px;align-items:end;margin-bottom:32px}
.dx-eyebrow{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:800;letter-spacing:.1em;text-transform:uppercase;color:var(--teal);margin-bottom:10px}
.dx-owners h2{font-size:clamp(26px,3vw,36px);font-weight:800;line-height:1.15}
.dx-owners-head p{font-size:15.5px;color:var(--ink-3);line-height:1.65}
.dx-owners-foot{display:flex;gap:28px;flex-wrap:wrap;justify-content:center;margin-top:22px;font-size:13.5px;color:var(--ink-3)}
.dx-owners-foot i{color:var(--teal);margin-right:6px}

.dx-mfilter{display:none}

@media(max-width:1024px){
  .dx-main{grid-template-columns:1fr}
  .dx-filters{position:static;display:none;border:1px solid var(--line);border-radius:12px;padding:18px}
  .dx-filters.open{display:block}
  .dx-mfilter{display:inline-flex}
  .dx-spot-grid{grid-template-columns:1fr 1fr}
  .dx-city-grid{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:720px){
  .dx-res{grid-template-columns:60px 1fr;gap:14px}
  .dx-res .dx-logo{width:60px!important;height:60px!important}
  .dx-res-side{grid-column:1/-1;flex-direction:row}
  .dx-res-side .dx-btn{flex:1}
  .dx-res-phone{display:none}
  .dx-res.is-feat{margin:0 -16px;padding:22px 16px}
  .dx-spot-grid{grid-template-columns:1fr}
  .dx-city-grid{grid-template-columns:1fr 1fr}
  .dx-owners-head{grid-template-columns:1fr;gap:12px}
  .dx-stats{gap:18px;flex-wrap:wrap}
}
CSS;
include '../includes/header.php';
?>
<div id="scrollProgress"></div>
<div class="dx">

<!-- SEARCH BAND -->
<section class="dx-band">
  <div class="dx-wrap">
    <div class="dx-crumbs"><a href="/">Home</a><span>/</span><?= $isFiltered ? '<a href="/directory/">Directory</a><span>/</span>Search' : 'Agency Directory' ?></div>
    <h1><?= $isFiltered ? htmlspecialchars($heading) : 'Find a home care agency you can trust' ?></h1>
    <p class="dx-band-sub">Compare licensed agencies by the care they provide, where they serve and how they're paid.</p>
    <form class="dx-search" method="GET" action="/directory/" role="search">
      <label><small>Find</small><input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Agency name or type of care" aria-label="Agency name or type of care"></label>
      <label><i class="fa-solid fa-location-dot"></i><input type="text" name="loc" value="<?= htmlspecialchars($loc) ?>" placeholder="City, state" list="dxLocs" aria-label="City or state"></label>
      <button type="submit" aria-label="Search"><i class="fa-solid fa-magnifying-glass"></i></button>
      <datalist id="dxLocs">
        <?php foreach ($statesUsed as $s): ?><option value="<?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?>"><?php endforeach ?>
        <?php foreach ($locOptions as $o): ?><option value="<?= htmlspecialchars($o['city'] . ', ' . $o['state']) ?>"><?php endforeach ?>
      </datalist>
    </form>
    <nav class="dx-cats" aria-label="Popular care types">
      <?php foreach (['Personal Care', 'Companion Care', 'Skilled Nursing', 'Alzheimer\'s & Dementia Care', '24-Hour Care', 'Respite Care', 'Live-In Care'] as $c): ?>
      <a href="<?= htmlspecialchars(dx_url(['svc' => [$c], 'page' => null])) ?>" class="<?= in_array($c, $svcSel, true) ? 'on' : '' ?>"><?= htmlspecialchars($c) ?></a>
      <?php endforeach ?>
    </nav>
    <?php if (!$isFiltered): ?>
    <div class="dx-stats"><span><b><?= $allCount ?></b>agencies listed</span><span><b><?= $stateCount ?></b>states</span><span><b><?= count($locOptions) ?></b>cities</span></div>
    <?php endif ?>
  </div>
</section>

<?php if ($spotlight): ?>
<!-- FEATURED SPOTLIGHT -->
<section class="dx-spot">
  <div class="dx-wrap">
    <div class="dx-sec-h"><h2>Featured agencies</h2><span>Paid placement</span></div>
    <div class="dx-spot-grid">
      <?php foreach ($spotlight as $l): ?>
      <a class="dx-spot-card" href="/directory/<?= urlencode($l['slug']) ?>">
        <div class="dx-spot-cover<?= $l['cover_image'] ? '' : ' is-blank' ?>"<?= $l['cover_image'] ? ' style="background-image:url(\'' . htmlspecialchars($l['cover_image']) . '\')"' : '' ?>>
          <?= hc_dir_logo($l, 56) ?>
        </div>
        <div class="dx-spot-body">
          <h3><?= htmlspecialchars($l['company_name']) ?></h3>
          <div class="dx-spot-loc"><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></div>
          <div class="dx-spot-tag"><?= htmlspecialchars($l['tagline'] ?: $l['description']) ?></div>
        </div>
      </a>
      <?php endforeach ?>
    </div>
  </div>
</section>
<?php endif ?>

<!-- RESULTS -->
<div class="dx-wrap">
  <div class="dx-main">

    <form class="dx-filters" id="dxFilters" method="GET" action="/directory/">
      <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
      <input type="hidden" name="loc" value="<?= htmlspecialchars($loc) ?>">
      <input type="hidden" name="sort" value="<?= htmlspecialchars($sort === 'recommended' ? '' : $sort) ?>">

      <div class="dx-fgroup">
        <h4>Type of care</h4>
        <?php foreach (HC_DIR_SERVICES as $i => $s): ?>
        <label class="dx-check<?= $i >= 6 && !in_array($s, $svcSel, true) ? ' dx-fmore' : '' ?>"><input type="checkbox" name="svc[]" value="<?= htmlspecialchars($s) ?>" <?= in_array($s, $svcSel, true) ? 'checked' : '' ?>><?= htmlspecialchars($s) ?></label>
        <?php endforeach ?>
        <button type="button" class="dx-ftoggle" onclick="var g=this.parentNode;g.classList.toggle('open');this.textContent=g.classList.contains('open')?'Show less':'Show all'">Show all</button>
      </div>

      <div class="dx-fgroup">
        <h4>Payment accepted</h4>
        <?php foreach (HC_DIR_PAYMENTS as $p): ?>
        <label class="dx-check"><input type="checkbox" name="pay[]" value="<?= htmlspecialchars($p) ?>" <?= in_array($p, $paySel, true) ? 'checked' : '' ?>><?= htmlspecialchars($p) ?></label>
        <?php endforeach ?>
      </div>

      <div class="dx-fgroup">
        <h4>Trust</h4>
        <label class="dx-check"><input type="checkbox" name="verified" value="1" <?= $verified ? 'checked' : '' ?>>Verified or owner-claimed</label>
      </div>

      <div class="dx-fgroup dx-states">
        <h4>State</h4>
        <?php foreach ($statesUsed as $s): ?>
        <a href="<?= htmlspecialchars(dx_url(['loc' => $s['state'], 'page' => null])) ?>" class="<?= $locState === $s['state'] && !$locCity ? 'on' : '' ?>"><?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?><span><?= (int)$s['n'] ?></span></a>
        <?php endforeach ?>
      </div>

      <noscript><button type="submit" class="dx-btn is-primary" style="margin-top:14px;width:100%">Apply filters</button></noscript>

      <div class="dx-promo">
        <h4>Own a home care agency?</h4>
        <p>Add your agency, or claim your existing listing, so families can find you.</p>
        <a href="/directory/submit/" class="dx-btn is-dark" style="width:100%">List your agency</a>
      </div>
    </form>

    <div>
      <div class="dx-resbar">
        <div>
          <h2><?= $isFiltered ? number_format($total) . ' result' . ($total === 1 ? '' : 's') : 'All agencies' ?></h2>
          <p><?= $total ? 'Showing ' . ($offset + 1) . '–' . min($offset + $perPage, $total) . ' of ' . number_format($total) : 'No matches' ?></p>
        </div>
        <div style="display:flex;gap:10px;align-items:center">
          <button type="button" class="dx-btn dx-mfilter" onclick="document.getElementById('dxFilters').classList.toggle('open')"><i class="fa-solid fa-sliders"></i>Filters</button>
          <label class="dx-sort">Sort
            <select onchange="location.href=this.value">
              <?php foreach (['recommended' => 'Recommended', 'az' => 'Name (A–Z)', 'newest' => 'Newest'] as $k => $v): ?>
              <option value="<?= htmlspecialchars(dx_url(['sort' => $k === 'recommended' ? null : $k, 'page' => null])) ?>" <?= $sort === $k ? 'selected' : '' ?>><?= $v ?></option>
              <?php endforeach ?>
            </select>
          </label>
        </div>
      </div>

      <?php if ($isFiltered): ?>
      <div class="dx-active">
        <?php if ($q !== ''): ?><a href="<?= htmlspecialchars(dx_url(['q' => null, 'page' => null])) ?>">“<?= htmlspecialchars($q) ?>”<i class="fa-solid fa-xmark"></i></a><?php endif ?>
        <?php if ($loc !== ''): ?><a href="<?= htmlspecialchars(dx_url(['loc' => null, 'page' => null])) ?>"><?= htmlspecialchars($where_label ?: $loc) ?><i class="fa-solid fa-xmark"></i></a><?php endif ?>
        <?php foreach ($svcSel as $s): ?><a href="<?= htmlspecialchars(dx_url(['svc' => array_values(array_diff($svcSel, [$s])), 'page' => null])) ?>"><?= htmlspecialchars($s) ?><i class="fa-solid fa-xmark"></i></a><?php endforeach ?>
        <?php foreach ($paySel as $p): ?><a href="<?= htmlspecialchars(dx_url(['pay' => array_values(array_diff($paySel, [$p])), 'page' => null])) ?>"><?= htmlspecialchars($p) ?><i class="fa-solid fa-xmark"></i></a><?php endforeach ?>
        <?php if ($verified): ?><a href="<?= htmlspecialchars(dx_url(['verified' => null, 'page' => null])) ?>">Verified<i class="fa-solid fa-xmark"></i></a><?php endif ?>
        <a href="/directory/" style="background:none;color:var(--teal)">Clear all</a>
      </div>
      <?php endif ?>

      <?php if ($listings): ?>
      <?php foreach ($listings as $i => $l):
        $tier = hc_dir_tier($l);
        $paid = $tier !== 'free';
        $svcs = hc_dir_lines($l['services']);
        $desc = $l['tagline'] ?: $l['description'];
      ?>
      <article class="dx-res<?= $tier === 'featured' ? ' is-feat' : '' ?>">
        <?php if ($tier === 'featured'): ?><span class="dx-res-label">Featured</span><?php endif ?>
        <a href="/directory/<?= urlencode($l['slug']) ?>" tabindex="-1" aria-hidden="true"><?= hc_dir_logo($l, 88, $paid) ?></a>
        <div style="min-width:0">
          <h3><span class="dx-res-num"><?= $offset + $i + 1 ?>.</span><a href="/directory/<?= urlencode($l['slug']) ?>"><?= htmlspecialchars($l['company_name']) ?></a></h3>
          <?php if ($b = hc_dir_badges($l, $tier)): ?><div class="dx-res-badges"><?= $b ?></div><?php endif ?>
          <div class="dx-res-meta">
            <span><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></span>
            <?php if ($l['years_in_business']): ?><span><i class="fa-regular fa-calendar"></i><?= htmlspecialchars($l['years_in_business']) ?> yrs in business</span><?php endif ?>
            <?php if ($l['license_number']): ?><span><i class="fa-regular fa-id-card"></i>Licensed</span><?php endif ?>
          </div>
          <p class="dx-res-desc"><?= htmlspecialchars($desc) ?></p>
          <?php if ($svcs): ?>
          <div class="dx-res-svcs">
            <?php foreach (array_slice($svcs, 0, 4) as $s): ?><span><?= htmlspecialchars($s) ?></span><?php endforeach ?>
            <?php if (count($svcs) > 4): ?><span class="more">+<?= count($svcs) - 4 ?> more</span><?php endif ?>
          </div>
          <?php endif ?>
        </div>
        <div class="dx-res-side">
          <?php if ($l['phone']): ?>
          <a class="dx-res-phone" href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $l['phone'])) ?>"><i class="fa-solid fa-phone"></i><?= htmlspecialchars($l['phone']) ?></a>
          <?php endif ?>
          <a class="dx-btn <?= $tier === 'featured' ? 'is-primary' : '' ?>" href="/directory/<?= urlencode($l['slug']) ?><?= $tier === 'featured' ? '#contact' : '' ?>"><?= $tier === 'featured' ? 'Request info' : 'View profile' ?></a>
          <?php if ($paid && $l['website']): ?>
          <a class="dx-btn" href="<?= htmlspecialchars($l['website']) ?>" target="_blank" rel="noopener">Website <i class="fa-solid fa-arrow-up-right-from-square" style="font-size:10px"></i></a>
          <?php endif ?>
        </div>
      </article>
      <?php endforeach ?>

      <?php if ($pages > 1): ?>
      <nav class="dx-pager" aria-label="Pages">
        <?php if ($page > 1): ?><a href="<?= htmlspecialchars(dx_url(['page' => $page - 1])) ?>" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></a><?php endif ?>
        <?php for ($p = 1; $p <= $pages; $p++):
          if ($p !== 1 && $p !== $pages && abs($p - $page) > 2) { if (abs($p - $page) === 3) echo '<span>…</span>'; continue; } ?>
          <?php if ($p === $page): ?><span class="on"><?= $p ?></span><?php else: ?><a href="<?= htmlspecialchars(dx_url(['page' => $p > 1 ? $p : null])) ?>"><?= $p ?></a><?php endif ?>
        <?php endfor ?>
        <?php if ($page < $pages): ?><a href="<?= htmlspecialchars(dx_url(['page' => $page + 1])) ?>" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></a><?php endif ?>
      </nav>
      <?php endif ?>

      <?php else: ?>
      <div class="dx-empty">
        <h3>No agencies match those filters</h3>
        <p>Try removing a filter or searching a nearby city.</p>
        <p style="margin-top:16px"><a href="/directory/" class="dx-btn">Clear filters</a></p>
      </div>
      <?php endif ?>
    </div>
  </div>
</div>

<?php if ($topCities): ?>
<!-- BROWSE BY CITY -->
<section class="dx-cities">
  <div class="dx-wrap">
    <div class="dx-sec-h"><h2>Browse by city</h2></div>
    <div class="dx-city-grid">
      <?php foreach ($topCities as $c): ?>
      <a href="/directory/?loc=<?= urlencode($c['city'] . ', ' . $c['state']) ?>"><?= htmlspecialchars($c['city'] . ', ' . $c['state']) ?><span><?= (int)$c['n'] ?></span></a>
      <?php endforeach ?>
    </div>
  </div>
</section>
<?php endif ?>

<!-- FOR AGENCY OWNERS -->
<section class="dx-owners" id="list-your-agency">
  <div class="dx-wrap">
    <div class="dx-owners-head">
      <div>
        <div class="dx-eyebrow">For agency owners</div>
        <h2>Put your agency in front of families who are ready to choose care.</h2>
      </div>
      <p>Start with a free listing, or upgrade for a verified profile, your logo and photos, a link to your website and top placement in your city. Every listing is confirmed with the agency owner before it goes live.</p>
    </div>
    <?= hc_dir_pricing_html(fn($k) => '/directory/submit/?plan=' . $k) ?>
    <div class="dx-owners-foot">
      <span><i class="fa-solid fa-file-invoice"></i>Paid plans are invoiced, so there's no card needed to sign up</span>
      <span><i class="fa-solid fa-rotate"></i>Cancel or change plans anytime</span>
      <span><i class="fa-solid fa-user-shield"></i>Owner-confirmed listings only</span>
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
