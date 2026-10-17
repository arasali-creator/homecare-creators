<?php
$page_canonical = "https://homecarecreators.com/sitemap/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "Sitemap | Homecare Creators";
$page_desc = "A complete, always up-to-date overview of every page on the Homecare Creators website.";
$og_title = "Sitemap | Homecare Creators";
$og_desc = "Browse every page on the Homecare Creators website.";

require_once __DIR__ . '/../admin/config.php';
require_once __DIR__ . '/../admin/includes/db.php';
require_once __DIR__ . '/../admin/includes/functions.php';

// Build the sitemap by scanning the filesystem on every request, so any new
// page added to the site shows up here automatically with no manual step.
$_sitemap_groups = [];
$_home_url = SITE_URL . '/';

$_label_map = [
    'marketing'                 => 'Florida SEO City Pages',
    'web-design'                => 'Florida Web Design City Pages',
    'seo'                       => 'SEO Services',
    'about'                     => 'Company',
    'contact'                   => 'Company',
    'areas-we-serve'            => 'Company',
    'products'                  => 'Products',
    'careos'                    => 'Products',
    'directory'                 => 'Directory',
    'events'                    => 'Events',
    'case-studies'              => 'Case Studies',
    'growth-calculator'         => 'Tools',
    'ai-automation'             => 'Services',
    'ai-search-seo'             => 'Services',
    'memory-care-marketing'     => 'Senior Care Marketing',
    'hospice-marketing'         => 'Senior Care Marketing',
    'nursing-home-marketing'    => 'Senior Care Marketing',
    'senior-living-marketing'   => 'Senior Care Marketing',
    'assisted-living-marketing' => 'Senior Care Marketing',
];
$_preferred_order = ['Main Pages','Company','Services','Senior Care Marketing','Products','Content','Blog Posts','Tools',
    'Case Studies','Directory','Events','Florida SEO City Pages','Florida Web Design City Pages'];

try {
    foreach (hc_scan_pages() as $p) {
        if ($p['path'] === '/') continue; // homepage is linked separately above the groups

        $meta = hc_extract_page_meta($p['file']);
        if (empty($meta['page_canonical'])) continue; // retired URLs are pure redirect stubs, not real pages

        $url   = $meta['page_canonical'];
        $title = $meta['page_title'] ?? $p['name'];
        $title = preg_replace('/\s*[|\x{2014}]\s*Home ?[Cc]are Creators.*$/u', '', $title);

        $prefix = null;
        if (strpos($p['name'], ' › ') !== false) {
            [$rawPrefix] = explode(' › ', $p['name'], 2);
            $prefix = strtolower(str_replace(' ', '-', $rawPrefix));
        }
        $group = $prefix !== null
            ? ($_label_map[$prefix] ?? ucwords(str_replace('-', ' ', $prefix)))
            : 'Main Pages';

        $_sitemap_groups[$group][] = ['url' => $url, 'title' => $title ?: $p['name']];
    }
} catch (Exception $e) { /* render with whatever we have */ }

// Blog is DB-driven content, not a scanned file, so it's pulled in separately.
$_sitemap_groups['Content'][] = ['url' => SITE_URL . '/blog', 'title' => 'Marketing Blog'];
try {
    $_posts = hc_all("SELECT title, slug FROM hc_blog_posts WHERE status='published' ORDER BY published_at DESC");
    foreach ($_posts as $_post) {
        $_sitemap_groups['Blog Posts'][] = ['url' => SITE_URL . '/blog/' . $_post['slug'], 'title' => $_post['title']];
    }
} catch (Exception $e) { /* blog table may not exist yet — skip silently */ }

foreach ($_sitemap_groups as &$_g) {
    usort($_g, fn($a, $b) => strcmp($a['title'], $b['title']));
}
unset($_g);

uksort($_sitemap_groups, function ($a, $b) use ($_preferred_order) {
    $ia = array_search($a, $_preferred_order); $ia = $ia === false ? 999 : $ia;
    $ib = array_search($b, $_preferred_order); $ib = $ib === false ? 999 : $ib;
    return $ia === $ib ? strcmp($a, $b) : $ia <=> $ib;
});

$page_css = <<<CSS
/* HERO */
.hero{min-height:38vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 56px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:720px;margin:0 auto;text-align:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(30px,4.4vw,50px);line-height:1.1;color:#fff;margin-bottom:16px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:18px;line-height:1.75;color:rgba(255,255,255,.65)}

/* SITEMAP */
.sitemap-section{background:#fff}
.sitemap-home{text-align:center;margin-bottom:48px}
.sitemap-home a{display:inline-flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--teal);text-decoration:none}
.sitemap-home a:hover{color:var(--forest)}
.sitemap-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(260px,1fr));gap:24px}
.sitemap-group{background:var(--cream);border:1px solid var(--border);border-radius:18px;padding:26px}
.sitemap-group-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13px;letter-spacing:.4px;color:var(--forest);margin-bottom:16px;padding-bottom:12px;border-bottom:1px solid var(--border)}
.sitemap-links{list-style:none;display:flex;flex-direction:column;gap:10px;max-height:340px;overflow-y:auto}
.sitemap-links a{font-size:14px;color:var(--muted);text-decoration:none;transition:color .15s}
.sitemap-links a:hover{color:var(--teal)}

/* RESPONSIVE */
@media(max-width:640px){
  .hero{padding:120px 24px 48px}
  .sitemap-grid{grid-template-columns:1fr}
}
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-badge"><i class="fa-solid fa-sitemap" style="margin-right:6px"></i>Sitemap</div>
    <h1 class="hero-h1">Every Page on <em>Homecare Creators</em></h1>
    <p class="hero-desc">A complete, always up-to-date map of the site — generated automatically, so new pages show up here the moment they go live.</p>
  </div>
</section>

<!-- SITEMAP -->
<section class="sitemap-section">
  <div class="container">
    <div class="sitemap-home">
      <a href="<?= htmlspecialchars($_home_url) ?>"><i class="fa-solid fa-house"></i>Homepage</a>
    </div>
    <div class="sitemap-grid">
      <?php foreach ($_sitemap_groups as $_group => $_links): ?>
      <div class="sitemap-group" data-reveal>
        <div class="sitemap-group-title"><?= htmlspecialchars($_group) ?> (<?= count($_links) ?>)</div>
        <ul class="sitemap-links">
          <?php foreach ($_links as $_link): ?>
          <li><a href="<?= htmlspecialchars($_link['url']) ?>"><?= htmlspecialchars($_link['title']) ?></a></li>
          <?php endforeach; ?>
        </ul>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
