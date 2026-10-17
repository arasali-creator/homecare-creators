<?php
$page_title = "Home Care Agency Directory | Homecare Creators";
$page_desc = "Browse licensed home care agencies nationwide — personal care, companion care, skilled nursing, and more. Find an agency near you.";
$page_canonical = "https://homecarecreators.com/directory/";
$og_title = "Home Care Agency Directory | Homecare Creators";
$og_desc = "Browse licensed home care agencies nationwide, or list your own agency for free.";

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
/* HERO (same recipe as /events/, /case-studies/) */
.hero{min-height:40vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 64px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:860px;margin:0 auto;text-align:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(28px,4.2vw,46px);line-height:1.15;color:#fff;margin-bottom:14px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:17px;line-height:1.7;color:rgba(255,255,255,.65);margin-bottom:32px}

/* SEARCH CARD — sits inside the hero, same floating-white-card recipe as the case-studies privacy note */
.search-box{max-width:820px;margin:0 auto;background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:18px 22px;display:flex;gap:12px;flex-wrap:wrap;align-items:center;box-shadow:0 20px 56px rgba(0,0,0,.25);text-align:left}
.search-box input[type=text]{flex:2;min-width:200px;padding:12px 16px;border:1.5px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14.5px;outline:none;transition:border-color .2s}
.search-box select{flex:1;min-width:150px;padding:12px 16px;border:1.5px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14.5px;outline:none;background:#fff;transition:border-color .2s}
.search-box input:focus,.search-box select:focus{border-color:var(--teal)}
.search-box button{background:var(--teal);color:#fff;border:none;padding:12px 26px;border-radius:9px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;cursor:pointer;transition:.2s}
.search-box button:hover{background:#178a64}

/* LISTINGS GRID — same card recipe as .blog-card / .cs-card */
.dir-section{background:var(--cream);padding:72px 40px}
.dir-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:28px;max-width:1160px;margin:44px auto 0}
.dir-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);overflow:hidden;transition:.25s;text-decoration:none;display:flex;flex-direction:column}
.dir-card:hover{transform:translateY(-4px);box-shadow:0 12px 40px rgba(10,46,30,.1)}
.dir-card.is-featured{border-color:rgba(201,168,76,.45)}
.dir-card-body{padding:24px;flex:1;display:flex;flex-direction:column}
.dir-card-top{display:flex;align-items:center;gap:14px;margin-bottom:14px}
.dir-card-logo{width:48px;height:48px;border-radius:50%;object-fit:contain;background:var(--warm);border:1px solid var(--border);flex-shrink:0;padding:3px}
.dir-card-logo-fallback{width:48px;height:48px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--forest));color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:17px;flex-shrink:0}
.dir-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:700;color:var(--forest);line-height:1.3}
.dir-card-city{font-size:12.5px;color:var(--teal);font-weight:600;display:flex;align-items:center;gap:5px;margin-top:3px}
.dir-card-desc{font-size:14.5px;color:var(--muted);line-height:1.65;margin-bottom:14px}
.dir-contact-row{display:flex;align-items:center;gap:8px;font-size:13px;color:var(--text);margin-bottom:6px}
.dir-contact-row i{width:14px;color:var(--teal);flex-shrink:0;font-size:12px}
.dir-contact-rows{margin-bottom:16px}
.dir-chip-row{display:flex;flex-wrap:wrap;gap:6px;margin-bottom:16px}
.dir-chip{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:var(--forest);background:var(--warm);border:1px solid var(--border);padding:5px 11px;border-radius:100px}
.dir-card-meta{font-size:13px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif;color:var(--teal);border-top:1px solid var(--border);padding-top:14px;margin-top:auto}
.featured-pill{display:inline-flex;align-items:center;gap:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#7a5f18;background:rgba(201,168,76,.14);padding:6px 14px;margin-bottom:0}
.dir-card.is-featured .dir-card-body{padding-top:14px}

.empty-dir{text-align:center;padding:60px 20px;color:var(--muted);max-width:1160px;margin:44px auto 0}
.empty-dir svg{width:48px;height:48px;opacity:.3;margin:0 auto 16px;display:block}

/* CTA — same recipe as /case-studies/ */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:96px 40px;text-align:center}
.cta-inner{max-width:680px;margin:0 auto}
.cta-inner .section-h2{color:#fff}
.cta-desc{font-size:17.5px;color:rgba(255,255,255,.68);line-height:1.78;margin:16px 0 32px}

@media(max-width:960px){.dir-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){
  .hero{padding:120px 24px 40px}
  .search-box{padding:16px}
  .dir-section{padding:56px 20px}
  .dir-grid{grid-template-columns:1fr}
  .cta-section{padding:56px 20px}
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
    <p class="hero-desc">A directory of home care agencies nationwide — browse by city or service, or list your own agency for free.</p>
    <form class="search-box" method="GET" data-reveal>
      <input type="text" name="q" value="<?= htmlspecialchars($q) ?>" placeholder="Search by agency name or service...">
      <select name="city">
        <option value="">All Cities</option>
        <?php foreach ($cities as $c): ?>
        <option value="<?= htmlspecialchars($c['city']) ?>" <?= $city===$c['city']?'selected':'' ?>><?= htmlspecialchars($c['city']) ?></option>
        <?php endforeach ?>
      </select>
      <button type="submit">Search</button>
    </form>
  </div>
</section>

<!-- LISTINGS -->
<section class="dir-section">
  <div style="max-width:1160px;margin:0 auto" data-reveal>
    <p class="section-label" style="justify-content:center">Browse the Directory</p>
    <h2 class="section-h2" style="text-align:center"><?= count($listings) ?> Agenc<?= count($listings)===1?'y':'ies' ?> Listed</h2>
  </div>

  <?php if ($listings): ?>
  <div class="dir-grid" data-reveal style="transition-delay:.1s">
    <?php foreach ($listings as $l):
      $initials = strtoupper(substr($l['company_name'], 0, 1));
      $snippet  = mb_strlen($l['description']) > 120 ? mb_substr($l['description'], 0, 120) . '…' : $l['description'];
      $svc_chips = array_slice(array_filter(array_map('trim', explode("\n", $l['services'] ?? ''))), 0, 3);
    ?>
    <a href="/directory/<?= urlencode($l['slug']) ?>" class="dir-card<?= $l['featured'] ? ' is-featured' : '' ?>">
      <?php if ($l['featured']): ?><div class="featured-pill"><i class="fa-solid fa-star"></i> Featured</div><?php endif ?>
      <div class="dir-card-body">
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
        <?php if ($l['phone'] || $l['email']): ?>
        <div class="dir-contact-rows">
          <?php if ($l['phone']): ?><div class="dir-contact-row"><i class="fa-solid fa-phone"></i><?= htmlspecialchars($l['phone']) ?></div><?php endif ?>
          <?php if ($l['email']): ?><div class="dir-contact-row"><i class="fa-solid fa-envelope"></i><?= htmlspecialchars($l['email']) ?></div><?php endif ?>
        </div>
        <?php endif ?>
        <?php if ($svc_chips): ?>
        <div class="dir-chip-row">
          <?php foreach ($svc_chips as $s): ?><span class="dir-chip"><?= htmlspecialchars($s) ?></span><?php endforeach ?>
        </div>
        <?php endif ?>
        <div class="dir-card-meta">View More &rarr;</div>
      </div>
    </a>
    <?php endforeach ?>
  </div>
  <?php else: ?>
  <div class="empty-dir">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/></svg>
    <p><?= ($q || $city) ? 'No agencies match your search.' : 'No agencies listed yet — be the first.' ?></p>
  </div>
  <?php endif ?>
</section>

<!-- LIST YOUR AGENCY CTA — same recipe as the site's standard cta-section -->
<section class="cta-section">
  <div class="container cta-inner">
    <div data-reveal>
      <p class="section-label" style="justify-content:center;color:var(--teal-lt)">Own a Home Care Agency?</p>
      <h2 class="section-h2" style="text-align:center">Get a Free Profile<br><em>in Our Directory</em></h2>
      <p class="cta-desc">A simple way to be found by families searching for care in your area — reviewed and published within 1–2 business days.</p>
      <a href="/directory/submit/" class="btn-primary" style="font-size:15px;padding:16px 32px;text-decoration:none;display:inline-flex"><i class="fa-solid fa-plus"></i>List Your Agency Free</a>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
