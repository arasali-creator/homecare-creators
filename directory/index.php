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
$featSel  = array_values(array_intersect((array)($_GET['feat'] ?? []), array_keys(HC_DIR_FEATURES)));
$verified = !empty($_GET['verified']);
$openNow  = !empty($_GET['open']);
$minRate  = in_array((int)($_GET['rating'] ?? 0), [3, 4], true) ? (int)$_GET['rating'] : 0;
$sort     = in_array($_GET['sort'] ?? '', ['rating', 'reviews', 'az'], true) ? $_GET['sort'] : 'recommended';
$page     = max(1, (int)($_GET['page'] ?? 1));
$perPage  = 10;

$US_STATES = ['AL'=>'Alabama','AK'=>'Alaska','AZ'=>'Arizona','AR'=>'Arkansas','CA'=>'California','CO'=>'Colorado','CT'=>'Connecticut','DE'=>'Delaware','FL'=>'Florida','GA'=>'Georgia','HI'=>'Hawaii','ID'=>'Idaho','IL'=>'Illinois','IN'=>'Indiana','IA'=>'Iowa','KS'=>'Kansas','KY'=>'Kentucky','LA'=>'Louisiana','ME'=>'Maine','MD'=>'Maryland','MA'=>'Massachusetts','MI'=>'Michigan','MN'=>'Minnesota','MS'=>'Mississippi','MO'=>'Missouri','MT'=>'Montana','NE'=>'Nebraska','NV'=>'Nevada','NH'=>'New Hampshire','NJ'=>'New Jersey','NM'=>'New Mexico','NY'=>'New York','NC'=>'North Carolina','ND'=>'North Dakota','OH'=>'Ohio','OK'=>'Oklahoma','OR'=>'Oregon','PA'=>'Pennsylvania','RI'=>'Rhode Island','SC'=>'South Carolina','SD'=>'South Dakota','TN'=>'Tennessee','TX'=>'Texas','UT'=>'Utah','VT'=>'Vermont','VA'=>'Virginia','WA'=>'Washington','WV'=>'West Virginia','WI'=>'Wisconsin','WY'=>'Wyoming','DC'=>'District of Columbia'];

// ── Location parsing: "Orlando, FL" | "FL" | "Florida" | "Orlando" ──
$locCity = ''; $locState = '';
if ($loc !== '') {
    if (preg_match('/^(.+?),\s*([A-Za-z]{2})$/', $loc, $m)) { $locCity = trim($m[1]); $locState = strtoupper($m[2]); }
    elseif (preg_match('/^[A-Za-z]{2}$/', $loc)) { $locState = strtoupper($loc); }
    elseif ($code = array_search(strtolower($loc), array_map('strtolower', $US_STATES), true)) { $locState = $code; }
    else { $locCity = $loc; }
}

// ── Query (small table: filter in SQL, open-now + paging in PHP) ──
$where = ["status='approved'"]; $params = [];
if ($q !== '') {
    $where[] = "(company_name LIKE ? OR services LIKE ? OR tagline LIKE ? OR description LIKE ? OR features LIKE ?)";
    $like = '%' . $q . '%'; array_push($params, $like, $like, $like, $like, $like);
}
if ($locCity !== '')  { $where[] = "(city LIKE ? OR service_areas LIKE ?)"; array_push($params, $locCity . '%', '%' . $locCity . '%'); }
if ($locState !== '') { $where[] = "state = ?"; $params[] = $locState; }
foreach ($svcSel as $s)  { $where[] = "services LIKE ?"; $params[] = '%' . $s . '%'; }
foreach ($paySel as $p)  { $where[] = "payment_accepted LIKE ?"; $params[] = '%' . $p . '%'; }
foreach ($featSel as $f) { $where[] = "features LIKE ?"; $params[] = '%' . $f . '%'; }
if ($verified) $where[] = "(verified=1 OR owner_confirmed_at IS NOT NULL)";
if ($minRate)  { $where[] = "rating_avg >= ?"; $params[] = $minRate; }
$rank = hc_dir_rank_sql();
$order = match ($sort) {
    'rating'  => "rating_avg IS NULL, rating_avg DESC, rating_count DESC, company_name",
    'reviews' => "rating_count DESC, rating_avg DESC, company_name",
    'az'      => "company_name ASC",
    default   => "$rank DESC, rating_count > 0 DESC, rating_avg DESC, (owner_confirmed_at IS NOT NULL) DESC, (services IS NOT NULL AND services<>'') DESC, company_name ASC",
};
$all = hc_all("SELECT * FROM hc_directory_listings WHERE " . implode(' AND ', $where) . " ORDER BY $order", $params);
if ($openNow) $all = array_values(array_filter($all, fn($l) => (hc_dir_open_status($l)['open'] ?? false)));

$total    = count($all);
$pages    = max(1, (int)ceil($total / $perPage));
$page     = min($page, $pages);
$offset   = ($page - 1) * $perPage;
$listings = array_slice($all, $offset, $perPage);

// Latest approved review per listing on this page (for Yelp-style quote snippets)
$snips = [];
if ($listings) {
    $ids = array_column($listings, 'id');
    $ph  = implode(',', array_fill(0, count($ids), '?'));
    foreach (hc_all("SELECT r.listing_id, r.body, r.name FROM hc_directory_reviews r
                     JOIN (SELECT listing_id, MAX(id) mid FROM hc_directory_reviews WHERE status='approved' AND listing_id IN ($ph) GROUP BY listing_id) x ON x.mid=r.id", $ids) as $r) {
        $snips[$r['listing_id']] = $r;
    }
}

$isFiltered = $q !== '' || $loc !== '' || $svcSel || $paySel || $featSel || $verified || $openNow || $minRate;
$spotlight  = (!$isFiltered && $page === 1) ? hc_all("SELECT * FROM hc_directory_listings WHERE status='approved' AND $rank = 2 ORDER BY RAND() LIMIT 3") : [];
$allCount   = (int)hc_val("SELECT COUNT(*) FROM hc_directory_listings WHERE status='approved'");
$reviewCount = (int)hc_val("SELECT COUNT(*) FROM hc_directory_reviews WHERE status='approved'");
$topCities  = hc_all("SELECT city, state, COUNT(*) n FROM hc_directory_listings WHERE status='approved' GROUP BY city, state ORDER BY n DESC, city ASC LIMIT 16");
$locOptions = hc_all("SELECT DISTINCT city, state FROM hc_directory_listings WHERE status='approved' ORDER BY state, city");
$statesUsed = hc_all("SELECT state, COUNT(*) n FROM hc_directory_listings WHERE status='approved' GROUP BY state ORDER BY n DESC");

// Map pins for the current page
$pins = [];
foreach ($listings as $i => $l) {
    if ($l['lat'] !== null && $l['lng'] !== null) {
        $pins[] = ['n' => $offset + $i + 1, 'lat' => (float)$l['lat'], 'lng' => (float)$l['lng'], 'name' => $l['company_name'], 'url' => '/directory/' . $l['slug'], 'city' => $l['city'] . ', ' . $l['state'], 'feat' => hc_dir_tier($l) === 'featured'];
    }
}
$hasMap = count($pins) > 0;

// ── Page meta ────────────────────────────────────────────────
$where_label = $locCity ? $locCity . ($locState ? ', ' . $locState : '') : ($locState ? ($US_STATES[$locState] ?? $locState) : '');
$what = $svcSel ? $svcSel[0] : ($q !== '' ? ucfirst($q) : 'Home Care Agencies');
$heading = 'Top ' . min(10, max(1, $total)) . ' ' . ($svcSel || $q !== '' ? $what . ' Agencies' : 'Home Care Agencies') . ($where_label ? ' near ' . $where_label : '');
$page_title = $isFiltered ? $heading . ' | Homecare Creators Directory' : 'Home Care Agency Directory — Compare Local Home Care Agencies | Homecare Creators';
$page_desc  = "Compare {$allCount} home care agencies by services, reviews, hours and payment options. Personal care, companion care, skilled nursing, dementia care and more.";
$page_canonical = "https://homecarecreators.com/directory/";
$og_title = "Home Care Agency Directory | Homecare Creators";
$og_desc  = $page_desc;

function dx_url(array $over = []): string {
    $base = array_filter([
        'q' => $_GET['q'] ?? '', 'loc' => $_GET['loc'] ?? '', 'svc' => $_GET['svc'] ?? [], 'pay' => $_GET['pay'] ?? [], 'feat' => $_GET['feat'] ?? [],
        'verified' => $_GET['verified'] ?? '', 'open' => $_GET['open'] ?? '', 'rating' => $_GET['rating'] ?? '', 'sort' => $_GET['sort'] ?? '',
    ]);
    $p = array_filter(array_merge($base, $over), fn($v) => $v !== '' && $v !== [] && $v !== null);
    return '/directory/' . ($p ? '?' . http_build_query($p) : '') . '#results';
}
function dx_toggle_arr(string $key, string $val, array $cur): string {
    $next = in_array($val, $cur, true) ? array_values(array_diff($cur, [$val])) : array_merge($cur, [$val]);
    return dx_url([$key => $next ?: null, 'page' => null]);
}

$page_css = hc_dir_base_css() . hc_dir_extra_css() . <<<CSS
/* ── HERO (landing) / SEARCH HEAD (filtered) ── */
.hx{display:grid;grid-template-columns:1.15fr .85fr;gap:64px;align-items:center}
.hx .dx-label{margin-bottom:26px}
.hx .dx-h1{margin-bottom:22px}
.hx .dx-lead{max-width:520px;margin-bottom:34px}
.sb{display:flex;align-items:center;background:#fff;border:1px solid var(--hair);border-radius:100px;padding:7px 7px 7px 8px;max-width:660px;box-shadow:0 20px 50px rgba(10,46,30,.08)}
.sb label{flex:1;display:flex;align-items:center;gap:12px;padding:0 18px;min-width:0}
.sb label+label{border-left:1px solid var(--hair)}
.sb label i{color:var(--mut);font-size:14px}
.sb input{flex:1;min-width:0;border:0;outline:0;background:none;font:inherit;font-size:15.5px;color:var(--ink);padding:14px 0}
.sb button{width:54px;height:54px;border-radius:50%;border:0;background:var(--ink);color:#fff;font-size:16px;cursor:pointer;flex-shrink:0;transition:background .2s}
.sb button:hover{background:var(--teal)}
.hx-pop{display:flex;flex-wrap:wrap;align-items:center;gap:8px;margin-top:20px;font-size:13.5px;color:var(--mut)}
.hx-pop a{border:1px solid var(--hair);border-radius:100px;padding:7px 14px;color:var(--ink);font-size:13px;font-weight:500;transition:background .15s,border-color .15s}
.hx-pop a:hover{background:#fff;border-color:var(--ink)}
.hx-art{position:relative}
.hx-photo{border-radius:32px;overflow:hidden;aspect-ratio:4/4.4}
.hx-photo img{width:100%;height:100%;object-fit:cover;object-position:60% center;display:block}
.hx-card{position:absolute;left:-40px;bottom:32px;background:#fff;border-radius:22px;padding:16px 18px;box-shadow:0 24px 60px rgba(10,46,30,.16);width:290px}
.hx-card-top{display:flex;align-items:center;gap:12px}
.hx-card b{display:block;font-family:'Plus Jakarta Sans',sans-serif;color:var(--ink);font-size:14.5px;line-height:1.25}
.hx-card small{font-size:12.5px;color:var(--mut)}
.hx-tag{position:absolute;top:24px;right:-16px;background:var(--ink);color:#fff;border-radius:100px;padding:11px 18px 11px 14px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;display:flex;align-items:center;gap:9px;box-shadow:0 16px 40px rgba(10,46,30,.25)}
.hx-tag i{color:var(--teal-lt)}
.hx-stats{display:grid;grid-template-columns:repeat(4,1fr);margin-top:64px;border-top:1px solid var(--hair)}
.hx-stats div{padding:26px 0 0}
.hx-stats div+div{padding-left:32px;border-left:1px solid var(--hair)}
.hx-stats b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:42px;font-weight:800;color:var(--ink);letter-spacing:-.04em;line-height:1}
.hx-stats span{display:block;font-size:14px;color:var(--mut);margin-top:8px}
.sh-mini{display:flex;flex-wrap:wrap;align-items:center;justify-content:space-between;gap:20px}
.sh-mini .sb{flex:1;max-width:760px;box-shadow:none}

/* ── RESULTS (Yelp layout) ─────────────── */
.dx-panel.is-results{padding:44px 40px}
.rs{display:grid;grid-template-columns:230px minmax(0,1fr) 380px;gap:32px;align-items:start}
.rs.no-map{grid-template-columns:230px minmax(0,1fr)}
.rs-h{margin-bottom:16px}
.rs-h h1,.rs-h h2{font-size:clamp(24px,2.4vw,32px);font-weight:800;letter-spacing:-.035em;line-height:1.15}
.rs-h p{font-size:14px;color:var(--mut);margin-top:6px}
.qf{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:22px;align-items:center}
.qf a{display:inline-flex;align-items:center;gap:7px;background:#fff;border:1px solid var(--hair);border-radius:100px;padding:9px 15px;font-size:13.5px;font-weight:500;color:var(--ink);transition:border-color .15s,background .15s}
.qf a:hover{border-color:var(--ink)}
.qf a.on{background:var(--ink);border-color:var(--ink);color:#fff}
.qf a i{font-size:12px}
.qf select{margin-left:auto;appearance:none;-webkit-appearance:none;background:#fff url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='10' height='6'%3E%3Cpath d='M1 1l4 4 4-4' stroke='%230a2e1e' stroke-width='1.5' fill='none'/%3E%3C/svg%3E") no-repeat right 14px center;border:1px solid var(--hair);border-radius:100px;padding:9px 34px 9px 16px;font:inherit;font-size:13.5px;font-weight:600;color:var(--ink);cursor:pointer}

.fl{position:sticky;top:96px;max-height:calc(100vh - 110px);overflow:auto;scrollbar-width:thin;padding-right:4px}
.fl h3{font-size:22px;font-weight:800;letter-spacing:-.03em;margin-bottom:14px}
.fl-g{padding:16px 0;border-top:1px solid var(--hair)}
.fl-g h4{font-size:14px;font-weight:700;margin-bottom:10px}
.fl-o{display:flex;align-items:center;gap:10px;padding:5px 0;font-size:14px;color:var(--txt);cursor:pointer;line-height:1.35}
.fl-o input{width:16px;height:16px;accent-color:var(--ink);flex-shrink:0}
.fl-o:hover{color:var(--ink)}
.fl-more{display:none}
.fl-g.open .fl-more{display:flex}
.fl-t{background:none;border:0;padding:6px 0 0;color:var(--teal);font:inherit;font-size:13.5px;font-weight:600;cursor:pointer}
.fl-r{display:flex;gap:6px}
.fl-r a{flex:1;text-align:center;border:1px solid var(--hair);border-radius:100px;padding:8px 6px;font-size:13px;color:var(--ink);background:#fff}
.fl-r a.on{background:var(--ink);color:#fff;border-color:var(--ink)}
.fl-s a{display:flex;justify-content:space-between;padding:5px 0;font-size:14px;color:var(--txt)}
.fl-s a.on,.fl-s a:hover{color:var(--teal)}
.fl-s span{color:var(--mut);font-size:12.5px}
.fl-apply{display:none}
.fl-x{display:none;width:40px;height:40px;border-radius:50%;border:1px solid var(--hair);background:#fff;color:var(--ink);cursor:pointer}

.grp{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--mut);margin:6px 0 12px;display:flex;align-items:center;gap:8px}
.grp i{font-size:12px}
.cd{position:relative;display:grid;grid-template-columns:184px minmax(0,1fr);gap:22px;background:#fff;border-radius:26px;padding:16px;margin-bottom:12px;transition:box-shadow .2s;border:1px solid transparent}
.cd:hover{box-shadow:0 16px 44px rgba(10,46,30,.1)}
.cd.is-feat{border-color:#ead7a1}
.cd-img{border-radius:18px;overflow:hidden;aspect-ratio:1;position:relative;display:flex;align-items:center;justify-content:center;background-size:cover;background-position:center}
.cd-img .mono{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:52px;color:rgba(255,255,255,.92);letter-spacing:-.03em}
.cd-img img.logo{width:70%;height:70%;object-fit:contain}
.cd-img .spon{position:absolute;top:10px;left:10px;background:rgba(255,255,255,.92);color:var(--gold-ink);font-size:10.5px;font-weight:700;padding:4px 8px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif}
.cd-b{min-width:0;padding:4px 6px 4px 0;display:flex;flex-direction:column}
.cd h3{font-size:19.5px;font-weight:700;letter-spacing:-.02em;line-height:1.25;margin-bottom:6px}
.cd h3 a::after{content:"";position:absolute;inset:0;z-index:1}
.cd h3 a:hover{text-decoration:underline!important;text-underline-offset:3px}
.cd-rate{margin-bottom:8px}
.cd-tags{display:flex;flex-wrap:wrap;align-items:center;gap:6px;font-size:13.5px;color:var(--mut);margin-bottom:6px}
.cd-tags span.t{background:#f1efe8;color:var(--ink);border-radius:6px;padding:3px 8px;font-size:12.5px;font-weight:500}
.cd-line{display:flex;flex-wrap:wrap;gap:4px 14px;font-size:13.5px;color:var(--mut);margin-bottom:8px;align-items:center}
.cd-line .dx-badge{padding:4px 8px}
.cd-q{display:flex;gap:10px;font-size:14px;color:var(--txt);line-height:1.55;margin:4px 0 10px}
.cd-q i{color:var(--mut);margin-top:4px;font-size:12px}
.cd-q span{display:-webkit-box;-webkit-line-clamp:2;-webkit-box-orient:vertical;overflow:hidden}
.cd-q b{font-weight:600;color:var(--ink)}
.cd-ft{display:flex;flex-wrap:wrap;gap:4px 16px;font-size:13px;color:var(--txt);margin-bottom:12px}
.cd-ft i{color:#0b8a5a;margin-right:6px}
.cd-act{display:flex;flex-wrap:wrap;gap:8px;margin-top:auto;position:relative;z-index:2}
.cd-act .dx-btn{padding:11px 16px;font-size:13.5px}

.mp{position:sticky;top:96px;height:calc(100vh - 120px);min-height:460px;border-radius:26px;overflow:hidden;background:#e6e2d8}
#dxMap{position:absolute;inset:0}
.pin{background:var(--ink);color:#fff;border:2px solid #fff;border-radius:100px;font:700 12px 'Plus Jakarta Sans',sans-serif;min-width:28px;height:28px;padding:0 7px;display:flex;align-items:center;justify-content:center;box-shadow:0 4px 12px rgba(0,0,0,.25);transition:transform .15s,background .15s}
.pin.is-feat{background:#c9a84c}
.pin.hl{background:var(--teal);transform:scale(1.25)}
.leaflet-popup-content{font-family:'DM Sans',sans-serif;margin:12px 14px}
.leaflet-popup-content a{font-weight:700;color:var(--ink)}
.leaflet-container{font-family:'DM Sans',sans-serif}

.pg{display:flex;justify-content:space-between;align-items:center;gap:16px;margin-top:22px;flex-wrap:wrap}
.pg-info{font-size:14px;color:var(--mut)}
.pg-nums{display:flex;gap:6px;flex-wrap:wrap}
.pg-nums a,.pg-nums span{min-width:42px;height:42px;border-radius:50%;display:inline-flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:14px;color:var(--ink);border:1px solid var(--hair);background:#fff;padding:0 6px}
.pg-nums a:hover{border-color:var(--ink)}
.pg-nums .on{background:var(--ink);border-color:var(--ink);color:#fff}
.pg-nums .gap{border:0;background:none}
.rel{margin-top:36px;padding-top:28px;border-top:1px solid var(--hair)}
.rel h4{font-size:16px;font-weight:700;margin-bottom:12px}
.rel div{display:flex;flex-wrap:wrap;gap:8px}
.rel a{border:1px solid var(--hair);border-radius:100px;padding:8px 14px;font-size:13.5px;color:var(--ink);background:#fff}
.rel a:hover{border-color:var(--ink)}
.r-empty{background:#fff;border-radius:26px;padding:56px 24px;text-align:center}
.r-empty h3{font-size:22px;font-weight:800;margin-bottom:8px}
.r-empty p{color:var(--mut);margin-bottom:20px}

/* ── FEATURED + GUIDE ───────────────────── */
.sh{display:flex;justify-content:space-between;align-items:flex-end;gap:24px;margin-bottom:32px}
.sh p{max-width:420px;color:var(--mut);font-size:15.5px;line-height:1.6}
.fe-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:16px}
.fe{background:#fff;border-radius:28px;padding:10px;display:flex;flex-direction:column;transition:transform .25s}
.fe:hover{transform:translateY(-4px)}
.fe-cover{border-radius:20px;height:150px;position:relative;background-size:cover;background-position:center}
.fe-cover .dx-badge{position:absolute;top:14px;left:14px}
.fe-cover .dx-logo{position:absolute;left:18px;bottom:-28px;border:4px solid #fff!important}
.fe-body{padding:42px 16px 16px;display:flex;flex-direction:column;flex:1}
.fe-body h3{font-size:19px;font-weight:700;margin-bottom:6px}
.fe-loc{font-size:14px;color:var(--mut);margin-top:8px}
.fe-empty{border:1.5px dashed rgba(10,46,30,.2);border-radius:28px;padding:30px;display:flex;flex-direction:column;justify-content:flex-end;min-height:300px;position:relative;transition:background .2s,border-color .2s}
.fe-empty:hover{background:rgba(255,255,255,.6);border-color:var(--ink)}
.fe-empty .big{position:absolute;top:24px;right:28px;font-family:'Plus Jakarta Sans',sans-serif;font-size:90px;font-weight:800;line-height:1;color:rgba(10,46,30,.06)}
.fe-empty h3{font-size:22px;font-weight:800;letter-spacing:-.03em;margin-bottom:8px}
.fe-empty p{font-size:14.5px;color:var(--mut);line-height:1.55;margin-bottom:18px;max-width:280px}
.fe-empty span{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--teal)}
.gd{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.gd div{background:#fff;border-radius:26px;padding:26px}
.gd b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#a3ada6;margin-bottom:34px}
.gd h3{font-size:18px;font-weight:700;margin-bottom:8px;letter-spacing:-.02em}
.gd p{font-size:14.5px;color:var(--mut);line-height:1.6}
.fq{max-width:860px}
.fq details{border-bottom:1px solid var(--hair)}
.fq summary{list-style:none;cursor:pointer;display:flex;justify-content:space-between;align-items:center;gap:16px;padding:22px 0;font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:700;color:var(--ink)}
.fq summary::-webkit-details-marker{display:none}
.fq summary .dx-arrow{width:34px;height:34px;font-size:11px;transition:transform .25s}
.fq details[open] summary .dx-arrow{transform:rotate(45deg);background:var(--ink);color:#fff;border-color:var(--ink)}
.fq details p{font-size:15.5px;color:var(--mut);line-height:1.7;padding:0 48px 22px 0}
.ct{display:grid;grid-template-columns:repeat(4,1fr);gap:0 40px}
.ct a{display:flex;justify-content:space-between;align-items:center;padding:15px 0;border-bottom:1px solid var(--hair);font-size:15px;color:var(--ink);transition:padding .2s,color .2s}
.ct a span{font-size:13px;color:var(--mut)}
.ct a:hover{color:var(--teal);padding-left:6px}

/* owners */
.ow{max-width:1400px;margin:0 auto;padding:100px 36px 84px}
.ow-head{display:grid;grid-template-columns:1fr 1fr;gap:48px;align-items:end;max-width:1200px;margin:0 auto 52px}
.ow-head .dx-h2{color:#fff}
.ow-head .dx-h2 em{color:var(--teal-lt)}
.ow-head p{color:rgba(255,255,255,.6);font-size:17px;line-height:1.7}
.ow .dx-label{color:#fff;border-color:rgba(255,255,255,.18);background:rgba(255,255,255,.04);margin-bottom:22px}
.ow .dx-pricing{max-width:1200px;margin:0 auto}
.ow-foot{display:flex;justify-content:center;flex-wrap:wrap;gap:12px 36px;margin-top:40px;font-size:14px;color:rgba(255,255,255,.6)}
.ow-foot i{color:var(--teal-lt);margin-right:8px}

.m-filter{display:none!important}
@media(max-width:1280px){
  .rs{grid-template-columns:220px minmax(0,1fr) 320px}
  .cd{grid-template-columns:150px minmax(0,1fr)}
}
@media(max-width:1100px){
  .hx{grid-template-columns:1fr;gap:44px}
  .hx-art{max-width:520px}
  .hx-card{left:16px}
  .hx-tag{right:16px}
  .rs,.rs.no-map{grid-template-columns:minmax(0,1fr)}
  .mp{position:relative;top:0;height:300px;min-height:0;order:-1}
  .fl{position:fixed;inset:0;z-index:600;background:var(--cream);max-height:none;padding:24px 20px 100px;transform:translateX(-100%);transition:transform .3s}
  .fl.open{transform:none}
  .fl-apply{display:flex;position:fixed;left:20px;right:20px;bottom:20px;z-index:601}
  .fl-x{display:inline-flex;align-items:center;justify-content:center}
  .m-filter{display:inline-flex!important}
  .fe-grid{grid-template-columns:1fr 1fr}
  .gd{grid-template-columns:1fr 1fr}
  .ct{grid-template-columns:repeat(3,1fr)}
  .ow-head{grid-template-columns:1fr;gap:16px}
}
@media(max-width:700px){
  .dx-panel.is-results{padding:28px 14px}
  .sb{flex-direction:column;align-items:stretch;border-radius:28px;padding:8px}
  .sb label{padding:4px 14px}
  .sb label+label{border-left:0;border-top:1px solid var(--hair)}
  .sb button{width:100%;border-radius:100px;height:50px;margin-top:6px}
  .hx-art{display:none}
  .hx-stats{grid-template-columns:1fr 1fr;margin-top:44px}
  .hx-stats div:nth-child(3){padding-left:0;border-left:0}
  .hx-stats div:nth-child(n+3){margin-top:22px}
  .hx-stats b{font-size:32px}
  .qf{flex-wrap:nowrap;overflow-x:auto;margin-right:-14px;padding-right:14px;scrollbar-width:none}
  .qf a,.qf select{flex-shrink:0}
  .qf select{margin-left:0}
  .cd{grid-template-columns:96px minmax(0,1fr);gap:14px;padding:12px;border-radius:22px}
  .cd-img{border-radius:14px}
  .cd-img .mono{font-size:30px}
  .cd-img .spon{display:none}
  .cd h3{font-size:17px}
  .cd-act{grid-column:1/-1}
  .cd-act .dx-btn{flex:1}
  .cd-ft{display:none}
  .sh{flex-direction:column;align-items:flex-start;gap:10px}
  .fe-grid,.gd{grid-template-columns:1fr}
  .ct{grid-template-columns:1fr 1fr;gap:0 20px}
  .ow{padding:64px 10px 48px}
}
CSS;
include '../includes/header.php';
if ($hasMap) echo hc_dir_leaflet_head();

$quick = [
    ['open', '1', 'Open now', 'fa-regular fa-clock', $openNow],
    ['verified', '1', 'Verified & claimed', 'fa-solid fa-circle-check', $verified],
];
$quickFeat = ['Free in-home assessment' => 'Free assessment', 'Same or next-day start' => 'Fast start'];
$quickPay  = ['Medicaid' => 'Accepts Medicaid'];
$quickSvc  = ['Alzheimer\'s & Dementia Care' => 'Dementia care', '24-Hour Care' => '24-hour care'];
$faqs = [
    ['Is this directory free for families?', 'Yes. Searching, comparing and contacting agencies is completely free. Agencies can choose to pay for upgraded profiles, which are clearly labelled as Featured or Sponsored.'],
    ['How are agencies listed and checked?', 'Every listing is reviewed by our team before it goes live, and agency owners confirm their listing by email. Agencies marked Verified have had their license details checked.'],
    ['Are the reviews real?', 'Reviews are written by families and clients, and our team checks every review before it is published. We never publish reviews written or paid for by the agency.'],
    ['What is the difference between home care and home health care?', 'Home care helps with daily living: bathing, meals, companionship, errands. Home health care is medical care prescribed by a doctor, such as skilled nursing or therapy. Many agencies offer both, so check the services on each profile.'],
    ['I own an agency. How do I get listed?', 'Create a free listing in about five minutes, or claim your existing profile. Upgraded plans add photos, your website link, a Verified badge and top placement.'],
];
?>
<div id="scrollProgress"></div>
<div class="dx">
<div class="dx-frame is-first">

<?php if (!$isFiltered && $page === 1): ?>
  <!-- HERO -->
  <section class="dx-panel">
    <div class="dx-in">
      <div class="hx">
        <div>
          <span class="dx-label">Home Care Agency Directory</span>
          <h1 class="dx-h1">Find home care<br>you can <em>trust.</em></h1>
          <p class="dx-lead">Compare local agencies side by side: services, hours, payment options and reviews from real families. Then call or request info directly.</p>
          <form class="sb" method="GET" action="/directory/#results" role="search">
            <label><i class="fa-solid fa-magnifying-glass"></i><input type="text" name="q" placeholder="Type of care or agency name" aria-label="Type of care or agency name"></label>
            <label><i class="fa-solid fa-location-dot"></i><input type="text" name="loc" placeholder="City or state" list="dxLocs" aria-label="City or state"></label>
            <button type="submit" aria-label="Search"><i class="fa-solid fa-arrow-right"></i></button>
          </form>
          <div class="hx-pop">Popular
            <?php foreach (['Personal Care' => 'Personal Care', 'Companion Care' => 'Companion Care', 'Dementia Care' => 'Alzheimer\'s & Dementia Care', '24-Hour Care' => '24-Hour Care'] as $label => $svc): ?>
            <a href="<?= htmlspecialchars(dx_url(['svc' => [$svc]])) ?>"><?= htmlspecialchars($label) ?></a>
            <?php endforeach ?>
          </div>
        </div>
        <div class="hx-art" aria-hidden="true">
          <div class="hx-photo"><img src="/images/home/hero-caregiver-elderly.jpg" alt=""></div>
          <div class="hx-tag"><i class="fa-solid fa-shield-heart"></i>Every listing reviewed</div>
          <div class="hx-card">
            <div class="hx-card-top"><span class="dx-arrow is-dark" style="width:38px;height:38px"><i class="fa-solid fa-star"></i></span><div><b>Reviews from real families</b><small>Checked by our team before they're published</small></div></div>
          </div>
        </div>
      </div>
      <div class="hx-stats">
        <div><b><?= $allCount ?></b><span>Agencies listed</span></div>
        <div><b><?= count($locOptions) ?></b><span>Cities covered</span></div>
        <div><b><?= $reviewCount ?></b><span>Family reviews</span></div>
        <div><b>$0</b><span>Free for families, always</span></div>
      </div>
    </div>
  </section>
<?php endif ?>

  <!-- RESULTS -->
  <section class="dx-panel is-results" id="results">
    <?php if ($isFiltered || $page > 1): ?>
    <div class="sh-mini" style="margin-bottom:30px">
      <form class="sb" method="GET" action="/directory/#results" role="search">
        <label><i class="fa-solid fa-magnifying-glass"></i><input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Type of care or agency name"></label>
        <label><i class="fa-solid fa-location-dot"></i><input type="text" name="loc" value="<?= htmlspecialchars($loc) ?>" placeholder="City or state" list="dxLocs"></label>
        <button type="submit" aria-label="Search"><i class="fa-solid fa-arrow-right"></i></button>
      </form>
      <div class="dx-crumbs" style="margin:0"><a href="/directory/">Directory</a><i class="fa-solid fa-chevron-right"></i>Search results</div>
    </div>
    <?php endif ?>
    <datalist id="dxLocs">
      <?php foreach ($statesUsed as $s): ?><option value="<?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?>"><?php endforeach ?>
      <?php foreach ($locOptions as $o): ?><option value="<?= htmlspecialchars($o['city'] . ', ' . $o['state']) ?>"><?php endforeach ?>
    </datalist>

    <div class="rs<?= $hasMap ? '' : ' no-map' ?>">
      <!-- FILTERS -->
      <form class="fl" id="dxFilters" method="GET" action="/directory/#results">
        <input type="hidden" name="q" value="<?= htmlspecialchars($q) ?>">
        <input type="hidden" name="loc" value="<?= htmlspecialchars($loc) ?>">
        <?php if ($sort !== 'recommended'): ?><input type="hidden" name="sort" value="<?= htmlspecialchars($sort) ?>"><?php endif ?>
        <?php if ($minRate): ?><input type="hidden" name="rating" value="<?= $minRate ?>"><?php endif ?>
        <h3 style="display:flex;justify-content:space-between;align-items:center">Filters<button type="button" class="fl-x" aria-label="Close filters" onclick="document.getElementById('dxFilters').classList.remove('open')"><i class="fa-solid fa-xmark"></i></button></h3>
        <div class="fl-g">
          <label class="fl-o"><input type="checkbox" name="open" value="1" <?= $openNow ? 'checked' : '' ?>>Open now</label>
          <label class="fl-o"><input type="checkbox" name="verified" value="1" <?= $verified ? 'checked' : '' ?>>Verified &amp; claimed</label>
        </div>
        <div class="fl-g">
          <h4>Type of care</h4>
          <?php foreach (HC_DIR_SERVICES as $i => $s): ?>
          <label class="fl-o<?= $i >= 5 && !in_array($s, $svcSel, true) ? ' fl-more' : '' ?>"><input type="checkbox" name="svc[]" value="<?= htmlspecialchars($s) ?>" <?= in_array($s, $svcSel, true) ? 'checked' : '' ?>><?= htmlspecialchars($s) ?></label>
          <?php endforeach ?>
          <button type="button" class="fl-t" onclick="var g=this.parentNode;g.classList.toggle('open');this.textContent=g.classList.contains('open')?'See less':'See all'">See all</button>
        </div>
        <div class="fl-g">
          <h4>Rating</h4>
          <div class="fl-r">
            <a href="<?= htmlspecialchars(dx_url(['rating' => null, 'page' => null])) ?>" class="<?= !$minRate ? 'on' : '' ?>">Any</a>
            <a href="<?= htmlspecialchars(dx_url(['rating' => 3, 'page' => null])) ?>" class="<?= $minRate === 3 ? 'on' : '' ?>">3+ ★</a>
            <a href="<?= htmlspecialchars(dx_url(['rating' => 4, 'page' => null])) ?>" class="<?= $minRate === 4 ? 'on' : '' ?>">4+ ★</a>
          </div>
        </div>
        <div class="fl-g">
          <h4>Highlights</h4>
          <?php $fi = 0; foreach (HC_DIR_FEATURES as $f => $ic): ?>
          <label class="fl-o<?= $fi++ >= 5 && !in_array($f, $featSel, true) ? ' fl-more' : '' ?>"><input type="checkbox" name="feat[]" value="<?= htmlspecialchars($f) ?>" <?= in_array($f, $featSel, true) ? 'checked' : '' ?>><?= htmlspecialchars($f) ?></label>
          <?php endforeach ?>
          <button type="button" class="fl-t" onclick="var g=this.parentNode;g.classList.toggle('open');this.textContent=g.classList.contains('open')?'See less':'See all'">See all</button>
        </div>
        <div class="fl-g">
          <h4>Payment accepted</h4>
          <?php foreach (HC_DIR_PAYMENTS as $p): ?>
          <label class="fl-o"><input type="checkbox" name="pay[]" value="<?= htmlspecialchars($p) ?>" <?= in_array($p, $paySel, true) ? 'checked' : '' ?>><?= htmlspecialchars($p) ?></label>
          <?php endforeach ?>
        </div>
        <div class="fl-g fl-s">
          <h4>State</h4>
          <?php foreach ($statesUsed as $s): ?>
          <a class="<?= $locState === $s['state'] && !$locCity ? 'on' : '' ?>" href="<?= htmlspecialchars(dx_url(['loc' => $s['state'], 'page' => null])) ?>"><?= htmlspecialchars($US_STATES[$s['state']] ?? $s['state']) ?><span><?= (int)$s['n'] ?></span></a>
          <?php endforeach ?>
        </div>
        <div class="fl-g"><?= hc_dir_hc_ad('side') ?></div>
        <button type="submit" class="dx-btn is-dark fl-apply">Show results</button>
      </form>

      <!-- LIST -->
      <div>
        <div class="rs-h">
          <?php if ($isFiltered): ?><h1><?= htmlspecialchars($heading) ?></h1><?php else: ?><h2>Browse all home care agencies</h2><?php endif ?>
          <p><?= $total ? number_format($total) . ' result' . ($total === 1 ? '' : 's') . ($where_label ? ' in ' . htmlspecialchars($where_label) : '') : 'No results' ?></p>
        </div>
        <div class="qf">
          <a href="#" class="m-filter" onclick="document.getElementById('dxFilters').classList.add('open');return false"><i class="fa-solid fa-sliders"></i>Filters</a>
          <?php foreach ($quick as [$k, $v, $label, $ic, $on]): ?>
          <a class="<?= $on ? 'on' : '' ?>" href="<?= htmlspecialchars(dx_url([$k => $on ? null : $v, 'page' => null])) ?>"><i class="<?= $ic ?>"></i><?= $label ?></a>
          <?php endforeach ?>
          <?php foreach ($quickFeat as $f => $label): ?><a class="<?= in_array($f, $featSel, true) ? 'on' : '' ?>" href="<?= htmlspecialchars(dx_toggle_arr('feat', $f, $featSel)) ?>"><?= $label ?></a><?php endforeach ?>
          <?php foreach ($quickPay as $p => $label): ?><a class="<?= in_array($p, $paySel, true) ? 'on' : '' ?>" href="<?= htmlspecialchars(dx_toggle_arr('pay', $p, $paySel)) ?>"><?= $label ?></a><?php endforeach ?>
          <?php foreach ($quickSvc as $s => $label): ?><a class="<?= in_array($s, $svcSel, true) ? 'on' : '' ?>" href="<?= htmlspecialchars(dx_toggle_arr('svc', $s, $svcSel)) ?>"><?= $label ?></a><?php endforeach ?>
          <select aria-label="Sort" onchange="location.href=this.value">
            <?php foreach (['recommended' => 'Sort: Recommended', 'rating' => 'Sort: Highest rated', 'reviews' => 'Sort: Most reviewed', 'az' => 'Sort: Name A–Z'] as $k => $v): ?>
            <option value="<?= htmlspecialchars(dx_url(['sort' => $k === 'recommended' ? null : $k, 'page' => null])) ?>" <?= $sort === $k ? 'selected' : '' ?>><?= $v ?></option>
            <?php endforeach ?>
          </select>
        </div>

        <?php if ($listings): ?>
          <?php
          $shownSponsoredLabel = false; $shownAllLabel = false;
          foreach ($listings as $i => $l):
            $tier = hc_dir_tier($l);
            $paid = $tier !== 'free';
            $svcs = hc_dir_lines($l['services']);
            $feats = array_slice(hc_dir_lines($l['features']), 0, 3);
            $url  = '/directory/' . urlencode($l['slug']);
            $mc   = hc_dir_mono_color($l['company_name']);
            $imgSrc = $paid ? ($l['cover_image'] ?: (hc_dir_lines($l['photos'])[0] ?? '')) : '';
            $snip = $snips[$l['id']] ?? null;
            $num  = $offset + $i + 1;
            if ($tier === 'featured' && !$shownSponsoredLabel) { $shownSponsoredLabel = true; echo '<div class="grp"><i class="fa-solid fa-star" style="color:#c9a84c"></i>Sponsored</div>'; }
            if ($tier !== 'featured' && !$shownAllLabel && $shownSponsoredLabel) { $shownAllLabel = true; echo '<div class="grp" style="margin-top:22px">All results</div>'; }
          ?>
          <article class="cd<?= $tier === 'featured' ? ' is-feat' : '' ?>" data-pin="<?= $num ?>">
            <?php if ($imgSrc): ?>
            <div class="cd-img" style="background-image:url('<?= htmlspecialchars($imgSrc) ?>')"><?php if ($tier === 'featured'): ?><span class="spon">Sponsored</span><?php endif ?></div>
            <?php elseif ($l['logo']): ?>
            <div class="cd-img" style="background:#f4f1ea"><img class="logo" src="<?= htmlspecialchars($l['logo']) ?>" alt="<?= htmlspecialchars($l['company_name']) ?> logo" loading="lazy"><?php if ($tier === 'featured'): ?><span class="spon">Sponsored</span><?php endif ?></div>
            <?php else: ?>
            <div class="cd-img" style="background:linear-gradient(140deg,<?= $mc ?>,#0a2e1e)"><span class="mono"><?= htmlspecialchars(hc_dir_initials($l['company_name'])) ?></span><?php if ($tier === 'featured'): ?><span class="spon">Sponsored</span><?php endif ?></div>
            <?php endif ?>
            <div class="cd-b">
              <h3><a href="<?= $url ?>"><?= $num ?>. <?= htmlspecialchars($l['company_name']) ?></a></h3>
              <div class="cd-rate"><?= hc_dir_rating_line($l) ?></div>
              <div class="cd-tags">
                <?php foreach (array_slice($svcs, 0, 3) as $s): ?><span class="t"><?= htmlspecialchars($s) ?></span><?php endforeach ?>
                <span><?= $svcs ? '· ' : '' ?><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></span>
              </div>
              <div class="cd-line">
                <?= hc_dir_open_html($l) ?>
                <?= hc_dir_badges($l, $tier === 'featured' ? 'premium' : $tier, false) ?>
                <?php if ($l['years_in_business']): ?><span><?= htmlspecialchars($l['years_in_business']) ?> yrs in business</span><?php endif ?>
              </div>
              <?php if ($snip): ?>
              <div class="cd-q"><i class="fa-regular fa-comment"></i><span>“<?= htmlspecialchars(mb_strimwidth($snip['body'], 0, 220, '…')) ?>” <b>– <?= htmlspecialchars(explode(' ', $snip['name'])[0]) ?></b></span></div>
              <?php elseif (($paid && $l['tagline']) || !hc_dir_is_placeholder_desc($l['description'])): ?>
              <div class="cd-q"><span><?= htmlspecialchars(($paid && $l['tagline']) ? $l['tagline'] : $l['description']) ?></span></div>
              <?php endif ?>
              <?php if ($feats): ?>
              <div class="cd-ft"><?php foreach ($feats as $f): ?><span><i class="fa-solid fa-check"></i><?= htmlspecialchars($f) ?></span><?php endforeach ?></div>
              <?php endif ?>
              <div class="cd-act">
                <?php if ($tier === 'featured'): ?><a class="dx-btn is-teal" href="<?= $url ?>#contact">Request info</a><?php endif ?>
                <?php if ($l['phone']): ?><a class="dx-btn<?= $tier === 'featured' ? '' : ' is-dark' ?>" href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $l['phone'])) ?>"><i class="fa-solid fa-phone" style="font-size:12px"></i><?= htmlspecialchars($l['phone']) ?></a><?php endif ?>
                <a class="dx-btn" href="<?= $url ?>">View profile</a>
              </div>
            </div>
          </article>
          <?php if ($i === 3): ?><div style="margin:4px 0 16px"><?= hc_dir_hc_ad('row') ?></div><?php endif ?>
          <?php endforeach ?>

          <?php if ($pages > 1): ?>
          <div class="pg">
            <div class="pg-info">Page <?= $page ?> of <?= $pages ?></div>
            <div class="pg-nums" role="navigation" aria-label="Pages">
              <?php if ($page > 1): ?><a href="<?= htmlspecialchars(dx_url(['page' => $page - 1 > 1 ? $page - 1 : null])) ?>" aria-label="Previous"><i class="fa-solid fa-arrow-left" style="font-size:12px"></i></a><?php endif ?>
              <?php for ($p = 1; $p <= $pages; $p++):
                if ($p !== 1 && $p !== $pages && abs($p - $page) > 2) { if (abs($p - $page) === 3) echo '<span class="gap">…</span>'; continue; } ?>
                <?php if ($p === $page): ?><span class="on"><?= $p ?></span><?php else: ?><a href="<?= htmlspecialchars(dx_url(['page' => $p > 1 ? $p : null])) ?>"><?= $p ?></a><?php endif ?>
              <?php endfor ?>
              <?php if ($page < $pages): ?><a href="<?= htmlspecialchars(dx_url(['page' => $page + 1])) ?>" aria-label="Next"><i class="fa-solid fa-arrow-right" style="font-size:12px"></i></a><?php endif ?>
            </div>
          </div>
          <?php endif ?>
        <?php else: ?>
          <div class="r-empty">
            <h3>No agencies match <em>those filters.</em></h3>
            <p>Try removing a filter, or search a nearby city.</p>
            <a href="/directory/#results" class="dx-btn is-dark">Clear all filters</a>
          </div>
        <?php endif ?>

        <div class="rel">
          <h4>Related searches</h4>
          <div>
            <?php
            $relCity  = $locCity ?: ($topCities[0]['city'] ?? '');
            $relState = $locState ?: ($topCities[0]['state'] ?? '');
            foreach (['Personal Care', 'Companion Care', 'Alzheimer\'s & Dementia Care', 'Skilled Nursing', '24-Hour Care', 'Respite Care'] as $s):
              if (in_array($s, $svcSel, true)) continue; ?>
            <a href="/directory/?<?= htmlspecialchars(http_build_query(['svc' => [$s], 'loc' => $relCity ? $relCity . ', ' . $relState : null])) ?>#results"><?= htmlspecialchars(str_replace('Alzheimer\'s & ', '', $s)) ?><?= $relCity ? ' in ' . htmlspecialchars($relCity) : '' ?></a>
            <?php endforeach ?>
            <?php foreach (array_slice($topCities, 0, 4) as $c): if ($c['city'] === $locCity) continue; ?>
            <a href="/directory/?loc=<?= urlencode($c['city'] . ', ' . $c['state']) ?>#results">Home care in <?= htmlspecialchars($c['city']) ?></a>
            <?php endforeach ?>
          </div>
        </div>
      </div>

      <?php if ($hasMap): ?>
      <div class="mp"><div id="dxMap" aria-label="Map of results"></div></div>
      <?php endif ?>
    </div>
  </section>

<?php if (!$isFiltered && $page === 1): ?>
  <!-- FEATURED + GUIDE + FAQ -->
  <section class="dx-panel">
    <div class="dx-in">
      <div class="sh">
        <div><div class="dx-kick" style="margin-bottom:14px">Featured</div><h2 class="dx-h2">Agencies in <em>the spotlight.</em></h2></div>
        <p>Featured agencies are paid placements, reviewed like every other listing.</p>
      </div>
      <div class="fe-grid">
        <?php foreach ($spotlight as $l): $mc = hc_dir_mono_color($l['company_name']); ?>
        <a class="fe" href="/directory/<?= urlencode($l['slug']) ?>">
          <div class="fe-cover" style="<?= $l['cover_image'] ? "background-image:url('" . htmlspecialchars($l['cover_image']) . "')" : "background:linear-gradient(135deg,{$mc},#0a2e1e)" ?>">
            <span class="dx-badge is-featured"><i class="fa-solid fa-star"></i>Featured</span>
            <?= hc_dir_logo($l, 60) ?>
          </div>
          <div class="fe-body">
            <h3><?= htmlspecialchars($l['company_name']) ?></h3>
            <div><?= hc_dir_rating_line($l) ?></div>
            <div class="fe-loc"><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></div>
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

      <div class="sh" style="margin-top:96px">
        <div><div class="dx-kick" style="margin-bottom:14px">Family guide</div><h2 class="dx-h2">How to choose <em>the right agency.</em></h2></div>
        <p>Four things families ask about most when they compare home care agencies.</p>
      </div>
      <div class="gd">
        <div><b>01</b><h3>Check licensing</h3><p>Ask for the agency's state license number. Our directory shows it whenever the agency provides one.</p></div>
        <div><b>02</b><h3>Match the care</h3><p>Personal care, companionship and skilled nursing are different services. Filter by the type of care you need.</p></div>
        <div><b>03</b><h3>Ask about caregivers</h3><p>How are caregivers screened, trained and matched? Can you meet them first? What happens if one is sick?</p></div>
        <div><b>04</b><h3>Understand cost</h3><p>Ask about hourly rates, minimum hours, and whether they accept long-term care insurance, VA benefits or Medicaid.</p></div>
      </div>

      <div class="sh" style="margin-top:96px">
        <div><div class="dx-kick" style="margin-bottom:14px">FAQ</div><h2 class="dx-h2">Common <em>questions.</em></h2></div>
      </div>
      <div class="fq">
        <?php foreach ($faqs as [$fq, $fa]): ?>
        <details><summary><?= htmlspecialchars($fq) ?><span class="dx-arrow"><i class="fa-solid fa-plus"></i></span></summary><p><?= htmlspecialchars($fa) ?></p></details>
        <?php endforeach ?>
      </div>

      <?php if ($topCities): ?>
      <div style="margin-top:96px">
        <div class="dx-kick" style="margin-bottom:14px">Browse by city</div>
        <h2 class="dx-h2" style="margin-bottom:26px">Home care <em>near you.</em></h2>
        <div class="ct">
          <?php foreach ($topCities as $c): ?>
          <a href="/directory/?loc=<?= urlencode($c['city'] . ', ' . $c['state']) ?>#results"><?= htmlspecialchars($c['city'] . ', ' . $c['state']) ?><span><?= (int)$c['n'] ?></span></a>
          <?php endforeach ?>
        </div>
      </div>
      <?php endif ?>
    </div>
  </section>
  <script type="application/ld+json"><?= json_encode(['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(fn($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]], $faqs)], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG) ?></script>
<?php endif ?>

  <!-- FOR AGENCY OWNERS -->
  <section class="ow" id="list-your-agency">
    <div class="ow-head">
      <div>
        <span class="dx-label">For agency owners</span>
        <h2 class="dx-h2">Be the agency families <em>call first.</em></h2>
      </div>
      <p>Start with a free listing. Upgrade for a verified profile with photos and your website link, top placement in your city, and inquiries sent straight to your inbox.</p>
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
$pinsJson = json_encode($pins, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
$page_js = <<<JS
(function(){
  var f = document.getElementById('dxFilters');
  if (f) f.addEventListener('change', function(e){
    if (e.target.matches('input[type=checkbox]') && window.innerWidth > 1100) f.submit();
  });

  var PINS = {$pinsJson};
  var el = document.getElementById('dxMap');
  if (!el || !PINS.length || typeof L === 'undefined') return;
  var map = L.map(el, {scrollWheelZoom: false, zoomControl: true});
  L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {maxZoom: 18, attribution: '&copy; OpenStreetMap contributors'}).addTo(map);
  var bounds = [];
  PINS.forEach(function(p){
    var icon = L.divIcon({className: '', html: '<div class="pin' + (p.feat ? ' is-feat' : '') + '" data-n="' + p.n + '">' + p.n + '</div>', iconSize: [28, 28], iconAnchor: [14, 14]});
    var m = L.marker([p.lat, p.lng], {icon: icon}).addTo(map);
    var a = document.createElement('div');
    a.innerHTML = '<a></a><br><span style="color:#6b7b6e"></span>';
    a.querySelector('a').href = p.url;
    a.querySelector('a').textContent = p.n + '. ' + p.name;
    a.querySelector('span').textContent = p.city;
    m.bindPopup(a);
    bounds.push([p.lat, p.lng]);
  });
  if (bounds.length === 1) map.setView(bounds[0], 12); else map.fitBounds(bounds, {padding: [40, 40], maxZoom: 13});
  document.querySelectorAll('.cd[data-pin]').forEach(function(c){
    var n = c.getAttribute('data-pin');
    c.addEventListener('mouseenter', function(){ var p = el.querySelector('.pin[data-n="' + n + '"]'); if (p) p.classList.add('hl'); });
    c.addEventListener('mouseleave', function(){ var p = el.querySelector('.pin[data-n="' + n + '"]'); if (p) p.classList.remove('hl'); });
  });
})();
JS;
include '../includes/footer.php';
