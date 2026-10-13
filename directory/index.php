<?php
$page_title = "Florida Home Care Agency Directory | Homecare Creators";
$page_desc = "Browse licensed home care agencies across Florida — personal care, companion care, skilled nursing, and more. Find an agency near you.";
$page_canonical = "https://homecarecreators.com/directory/";
$og_title = "Florida Home Care Agency Directory | Homecare Creators";
$og_desc = "Browse licensed home care agencies across Florida, or list your own agency for free.";

require_once '../admin/config.php';
require_once '../admin/includes/db.php';

$q    = trim($_GET['q'] ?? '');
$city = trim($_GET['city'] ?? '');

$where  = ["status='approved'"];
$params = [];
if ($q !== '') {
    $where[] = "(company_name LIKE ? OR description LIKE ? OR services LIKE ?)";
    $like = '%'.$q.'%';
    $params[] = $like; $params[] = $like; $params[] = $like;
}
if ($city !== '') {
    $where[] = "city = ?";
    $params[] = $city;
}
$sql = "SELECT * FROM hc_directory_listings WHERE " . implode(' AND ', $where) . " ORDER BY featured DESC, company_name ASC";
$listings = hc_all($sql, $params);
$cities   = hc_all("SELECT DISTINCT city FROM hc_directory_listings WHERE status='approved' ORDER BY city ASC");

$page_css = <<<CSS
/* HERO */
.hero{min-height:36vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 50px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:760px;margin:0 auto;text-align:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(28px,4.2vw,46px);line-height:1.15;color:#fff;margin-bottom:14px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:17px;line-height:1.7;color:rgba(255,255,255,.65);margin-bottom:28px}
.hero-cta{display:inline-flex;align-items:center;gap:8px;background:var(--teal);color:#fff;border:none;padding:14px 28px;border-radius:50px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;cursor:pointer;text-decoration:none;transition:.2s}
.hero-cta:hover{background:#178a64;transform:translateY(-2px)}

/* FILTER BAR */
.dir-filter{background:#fff;border-bottom:1px solid var(--border);padding:24px 40px;position:sticky;top:72px;z-index:50}
.dir-filter-inner{max-width:1100px;margin:0 auto;display:flex;gap:12px;flex-wrap:wrap;align-items:center}
.dir-filter input[type=text]{flex:1;min-width:200px;padding:11px 16px;border:1.5px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14px;outline:none}
.dir-filter select{padding:11px 16px;border:1.5px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14px;outline:none;background:#fff}
.dir-filter button{background:var(--forest);color:#fff;border:none;padding:11px 22px;border-radius:9px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer}

/* LISTINGS GRID */
.dir-section{background:var(--warm)}
.dir-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(300px,1fr));gap:24px;margin-top:8px}
.dir-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:26px;transition:.2s;text-decoration:none;display:flex;flex-direction:column;gap:12px}
.dir-card:hover{transform:translateY(-3px);box-shadow:0 16px 48px rgba(10,46,30,.1);border-color:rgba(29,158,117,.25)}
.dir-card.is-featured{border-color:rgba(201,168,76,.4);background:linear-gradient(180deg,rgba(201,168,76,.04),#fff 60px)}
.dir-card-top{display:flex;align-items:center;gap:14px}
.dir-card-logo{width:52px;height:52px;border-radius:12px;object-fit:contain;background:var(--cream);border:1px solid var(--border);flex-shrink:0;padding:4px}
.dir-card-logo-fallback{width:52px;height:52px;border-radius:12px;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:18px;flex-shrink:0}
.dir-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:700;color:var(--forest);line-height:1.3}
.dir-card-city{font-size:12.5px;color:var(--teal);font-weight:600;display:flex;align-items:center;gap:5px}
.dir-card-desc{font-size:14px;color:var(--muted);line-height:1.6;flex:1}
.dir-card-cta{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--teal)}
.featured-pill{display:inline-flex;align-items:center;gap:4px;background:rgba(201,168,76,.15);color:#8a6800;font-size:10px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:4px 10px;border-radius:20px;align-self:flex-start}

.empty-dir{text-align:center;padding:60px 20px;color:var(--muted)}
.empty-dir svg{width:48px;height:48px;opacity:.3;margin:0 auto 16px;display:block}

/* LIST-YOUR-AGENCY CTA */
.dir-list-cta{background:var(--forest);padding:64px 40px;text-align:center}
.dir-list-cta h2{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(24px,3.2vw,36px);color:#fff;margin-bottom:12px}
.dir-list-cta p{font-size:16px;color:rgba(255,255,255,.6);margin-bottom:26px;max-width:560px;margin-left:auto;margin-right:auto}

@media(max-width:640px){
  .hero{padding:120px 24px 40px}
  .dir-filter{padding:16px 20px;position:static}
  .dir-grid{grid-template-columns:1fr}
}
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-badge"><i class="fa-solid fa-building-shield" style="margin-right:6px"></i>Agency Directory</div>
    <h1 class="hero-h1">Find a <em>Home Care Agency</em><br>Near You</h1>
    <p class="hero-desc">A directory of licensed home care agencies across Florida — browse by city or service, or list your own agency for free.</p>
    <a href="/directory/submit/" class="hero-cta"><i class="fa-solid fa-plus"></i> List Your Agency Free</a>
  </div>
</section>

<!-- FILTER -->
<section class="dir-filter">
  <form class="dir-filter-inner" method="GET">
    <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search by agency name or service...">
    <select name="city">
      <option value="">All Cities</option>
      <?php foreach ($cities as $c): ?>
      <option value="<?= htmlspecialchars($c['city']) ?>" <?= $city===$c['city']?'selected':'' ?>><?= htmlspecialchars($c['city']) ?></option>
      <?php endforeach ?>
    </select>
    <button type="submit">Search</button>
  </form>
</section>

<!-- LISTINGS -->
<section class="dir-section">
  <div class="container">
    <?php if ($listings): ?>
    <div class="dir-grid" data-reveal>
      <?php foreach ($listings as $l):
        $initials = strtoupper(substr($l['company_name'], 0, 1));
        $snippet  = mb_strlen($l['description']) > 140 ? mb_substr($l['description'], 0, 140) . '…' : $l['description'];
      ?>
      <a href="/directory/<?= urlencode($l['slug']) ?>" class="dir-card<?= $l['featured'] ? ' is-featured' : '' ?>">
        <?php if ($l['featured']): ?><div class="featured-pill"><i class="fa-solid fa-star"></i> Featured</div><?php endif ?>
        <div class="dir-card-top">
          <?php if ($l['logo']): ?>
          <img class="dir-card-logo" src="<?= htmlspecialchars($l['logo']) ?>" alt="<?= htmlspecialchars($l['company_name']) ?> logo" loading="lazy">
          <?php else: ?>
          <div class="dir-card-logo-fallback"><?= htmlspecialchars($initials) ?></div>
          <?php endif ?>
          <div>
            <div class="dir-card-title"><?= htmlspecialchars($l['company_name']) ?></div>
            <div class="dir-card-city"><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($l['city']) ?>, <?= htmlspecialchars($l['state']) ?></div>
          </div>
        </div>
        <div class="dir-card-desc"><?= htmlspecialchars($snippet) ?></div>
        <div class="dir-card-cta">View Profile &rarr;</div>
      </a>
      <?php endforeach ?>
    </div>
    <?php else: ?>
    <div class="empty-dir">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
      <p><?= ($q || $city) ? 'No agencies match your search.' : 'No agencies listed yet — be the first.' ?></p>
    </div>
    <?php endif ?>
  </div>
</section>

<!-- LIST YOUR AGENCY CTA -->
<div class="dir-list-cta">
  <h2>Own a Home Care Agency?</h2>
  <p>Get a free profile in our directory — a simple way to be found by families searching for care in your area.</p>
  <a href="/directory/submit/" class="hero-cta">List Your Agency Free &rarr;</a>
</div>

<?php include '../includes/footer.php'; ?>
