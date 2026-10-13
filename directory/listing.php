<?php
$slug = trim($_GET['slug'] ?? '');

require_once '../admin/config.php';
require_once '../admin/includes/db.php';

$listing = $slug ? hc_one("SELECT * FROM hc_directory_listings WHERE slug=? AND status='approved'", [$slug]) : null;
if (!$listing) { http_response_code(404); header('Location: /directory/'); exit; }

$services      = array_filter(array_map('trim', explode("\n", $listing['services'] ?? '')));
$service_areas = array_filter(array_map('trim', explode("\n", str_replace(',', "\n", $listing['service_areas'] ?? ''))));

$page_title    = $listing['company_name'] . ' — Home Care Agency in ' . $listing['city'] . ', ' . $listing['state'] . ' | Homecare Creators Directory';
$page_desc     = mb_strlen($listing['description']) > 160 ? mb_substr($listing['description'], 0, 157) . '...' : $listing['description'];
$page_canonical = "https://homecarecreators.com/directory/" . $listing['slug'];
$og_title      = $listing['company_name'] . ' — ' . $listing['city'] . ', ' . $listing['state'];
$og_desc       = $page_desc;
$og_image      = $listing['logo'] ?: null;

$page_css = <<<CSS
.hero{background:var(--forest);position:relative;overflow:hidden;padding:140px 40px 60px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:900px;margin:0 auto}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:24px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-top{display:flex;align-items:center;gap:20px}
.hero-logo{width:76px;height:76px;border-radius:16px;object-fit:contain;background:#fff;padding:8px;flex-shrink:0}
.hero-logo-fallback{width:76px;height:76px;border-radius:16px;background:rgba(29,158,117,.2);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:28px;flex-shrink:0}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(26px,3.6vw,40px);line-height:1.2;color:#fff;margin-bottom:8px}
.hero-city{font-size:15px;color:rgba(255,255,255,.6);display:flex;align-items:center;gap:8px}
.featured-pill{display:inline-flex;align-items:center;gap:4px;background:rgba(201,168,76,.18);color:#e9cf7a;font-size:10px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:4px 10px;border-radius:20px;margin-bottom:12px}

.listing-body{background:#fff}
.listing-grid{display:grid;grid-template-columns:1fr 340px;gap:56px;align-items:start}
.listing-desc p{font-size:16.5px;line-height:1.85;color:var(--muted);margin-bottom:18px;white-space:pre-line}
.svc-list{list-style:none;display:flex;flex-wrap:wrap;gap:10px;margin:16px 0 28px}
.svc-list li{background:rgba(29,158,117,.08);color:var(--forest);font-size:13.5px;font-weight:600;padding:8px 16px;border-radius:20px}
.area-list{list-style:none;display:flex;flex-wrap:wrap;gap:8px;margin:16px 0}
.area-list li{font-size:13px;color:var(--muted);border:1px solid var(--border);padding:6px 13px;border-radius:14px}

.dir-sidebar{display:flex;flex-direction:column;gap:20px;position:sticky;top:90px}
.contact-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r-lg);padding:26px}
.contact-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:var(--forest);margin-bottom:16px}
.contact-row{display:flex;align-items:center;gap:12px;margin-bottom:14px;font-size:14.5px;color:var(--text)}
.contact-row:last-child{margin-bottom:0}
.contact-row i{width:18px;color:var(--teal);flex-shrink:0}
.contact-row a{color:var(--text);text-decoration:none;word-break:break-word}
.contact-row a:hover{color:var(--teal)}
.license-note{font-size:12px;color:var(--muted);margin-top:16px;padding-top:16px;border-top:1px solid var(--border)}

.promo-card{background:var(--forest);border-radius:var(--r-lg);padding:26px;text-align:center}
.promo-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;color:#fff;margin-bottom:8px;line-height:1.3}
.promo-card p{font-size:13.5px;color:rgba(255,255,255,.55);margin-bottom:18px;line-height:1.6}
.promo-card a{display:block;background:var(--teal);color:#fff;border:none;padding:12px 18px;border-radius:50px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;text-decoration:none;transition:.2s}
.promo-card a:hover{background:#178a64}

@media(max-width:1024px){
  .listing-grid{grid-template-columns:1fr}
  .dir-sidebar{position:static}
}
@media(max-width:640px){
  .hero{padding:120px 24px 40px}
  .hero-top{flex-direction:column;align-items:flex-start;gap:14px}
}
CSS;
include '../includes/header.php';
?>

<script type="application/ld+json">
<?php
$ld_address = array_filter([
    '@type' => 'PostalAddress',
    'streetAddress'  => $listing['address'] ?: null,
    'addressLocality' => $listing['city'],
    'addressRegion'  => $listing['state'],
    'addressCountry' => 'US',
]);
$ld = array_filter([
    '@context'    => 'https://schema.org',
    '@type'       => 'LocalBusiness',
    'name'        => $listing['company_name'],
    'description' => $listing['description'],
    'image'       => $listing['logo'] ?: 'https://homecarecreators.com/images/home/homecarecreators-logo.png',
    'telephone'   => $listing['phone'] ?: null,
    'email'       => $listing['email'] ?: null,
    'url'         => $listing['website'] ?: $page_canonical,
    'address'     => $ld_address,
    'areaServed'  => $service_areas ?: [$listing['city']],
]);
echo json_encode($ld, JSON_UNESCAPED_SLASHES);
?>
</script>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-breadcrumb"><a href="/">Home</a> / <a href="/directory/">Directory</a> / <span style="color:var(--teal-lt)"><?= htmlspecialchars($listing['company_name']) ?></span></div>
    <?php if ($listing['featured']): ?><div class="featured-pill"><i class="fa-solid fa-star"></i> Featured Agency</div><?php endif ?>
    <div class="hero-top">
      <?php if ($listing['logo']): ?>
      <img class="hero-logo" src="<?= htmlspecialchars($listing['logo']) ?>" alt="<?= htmlspecialchars($listing['company_name']) ?> logo">
      <?php else: ?>
      <div class="hero-logo-fallback"><?= htmlspecialchars(strtoupper(substr($listing['company_name'],0,1))) ?></div>
      <?php endif ?>
      <div>
        <h1 class="hero-h1"><?= htmlspecialchars($listing['company_name']) ?></h1>
        <div class="hero-city"><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($listing['city']) ?>, <?= htmlspecialchars($listing['state']) ?></div>
      </div>
    </div>
  </div>
</section>

<!-- BODY -->
<section class="listing-body">
  <div class="container listing-grid">
    <div class="listing-desc" data-reveal>
      <p><?= htmlspecialchars($listing['description']) ?></p>

      <?php if ($services): ?>
      <p class="section-label" style="margin-top:8px">Services Offered</p>
      <ul class="svc-list">
        <?php foreach ($services as $s): ?><li><?= htmlspecialchars($s) ?></li><?php endforeach ?>
      </ul>
      <?php endif ?>

      <?php if ($service_areas): ?>
      <p class="section-label">Service Areas</p>
      <ul class="area-list">
        <?php foreach ($service_areas as $a): ?><li><i class="fa-solid fa-location-dot" style="color:var(--teal);margin-right:5px;font-size:11px"></i><?= htmlspecialchars($a) ?></li><?php endforeach ?>
      </ul>
      <?php endif ?>
    </div>

    <div class="dir-sidebar" data-reveal style="transition-delay:.1s">
      <div class="contact-card">
        <div class="contact-card-title">Contact <?= htmlspecialchars($listing['company_name']) ?></div>
        <?php if ($listing['phone']): ?>
        <div class="contact-row"><i class="fa-solid fa-phone"></i><a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/','',$listing['phone'])) ?>"><?= htmlspecialchars($listing['phone']) ?></a></div>
        <?php endif ?>
        <?php if ($listing['email']): ?>
        <div class="contact-row"><i class="fa-solid fa-envelope"></i><a href="mailto:<?= htmlspecialchars($listing['email']) ?>"><?= htmlspecialchars($listing['email']) ?></a></div>
        <?php endif ?>
        <?php if ($listing['website']): ?>
        <div class="contact-row"><i class="fa-solid fa-globe"></i><a href="<?= htmlspecialchars($listing['website']) ?>" target="_blank" rel="noopener nofollow">Visit Website</a></div>
        <?php endif ?>
        <?php if ($listing['address']): ?>
        <div class="contact-row"><i class="fa-solid fa-map-pin"></i><span><?= htmlspecialchars($listing['address']) ?></span></div>
        <?php endif ?>
        <?php if ($listing['license_number'] || $listing['years_in_business']): ?>
        <div class="license-note">
          <?php if ($listing['license_number']): ?>License #<?= htmlspecialchars($listing['license_number']) ?><br><?php endif ?>
          <?php if ($listing['years_in_business']): ?><?= htmlspecialchars($listing['years_in_business']) ?> years in business<?php endif ?>
        </div>
        <?php endif ?>
      </div>

      <div class="promo-card">
        <h3>Want a profile that actually brings in clients?</h3>
        <p>We build full marketing systems for home care agencies — websites, SEO, and lead generation that go far beyond a directory listing.</p>
        <a href="/contact/">Get a Free SEO Audit &rarr;</a>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
