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
/* HERO — same recipe as /events/event.php */
.hero{background:var(--forest);position:relative;overflow:hidden;padding:140px 40px 56px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:760px;margin:0 auto;text-align:center}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-logo-row{display:flex;justify-content:center;margin-bottom:18px}
.hero-logo{width:64px;height:64px;border-radius:50%;object-fit:contain;background:#fff;padding:6px}
.hero-logo-fallback{width:64px;height:64px;border-radius:50%;background:rgba(29,158,117,.18);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:24px}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(201,168,76,.15);border:1px solid rgba(201,168,76,.35);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--gold-lt);letter-spacing:.9px;text-transform:uppercase;margin-bottom:18px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(28px,4.2vw,44px);line-height:1.15;color:#fff;margin-bottom:14px}
.hero-meta{display:flex;gap:24px;justify-content:center;flex-wrap:wrap}
.hero-meta-item{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;color:#fff;font-weight:600}
.hero-meta-item i{color:var(--teal-lt)}

/* BODY — same two-column recipe as the event page / blog post */
.listing-body{background:#fff}
.listing-grid{display:grid;grid-template-columns:1fr 340px;gap:56px;align-items:start}
.listing-desc p{font-size:16.5px;line-height:1.85;color:var(--muted);margin-bottom:18px;white-space:pre-line}
.cs-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--muted);margin-bottom:10px;margin-top:28px}
.cs-label:first-of-type{margin-top:0}
.cs-chip-row{display:flex;flex-wrap:wrap;gap:8px}
.cs-chip{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--forest);background:var(--warm);border:1px solid var(--border);padding:7px 15px;border-radius:100px}

/* SIDEBAR — same recipe as blog/post.php */
.dir-sidebar{display:flex;flex-direction:column;gap:20px;position:sticky;top:90px}
.sidebar-card{background:#fff;border:1px solid var(--border);border-radius:14px;padding:22px}
.sidebar-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--muted);margin-bottom:14px}
.contact-row{display:flex;align-items:center;gap:12px;margin-bottom:13px;font-size:14.5px;color:var(--text)}
.contact-row:last-child{margin-bottom:0}
.contact-row i{width:16px;color:var(--teal);flex-shrink:0}
.contact-row a{color:var(--text);text-decoration:none;word-break:break-word}
.contact-row a:hover{color:var(--teal)}
.sidebar-cta-card{background:var(--forest);border-radius:16px;padding:28px;text-align:center}
.sidebar-cta-card .sc-icon{width:52px;height:52px;background:rgba(29,158,117,.2);border-radius:12px;display:flex;align-items:center;justify-content:center;margin:0 auto 16px}
.sidebar-cta-card .sc-icon svg{width:24px;height:24px;color:var(--teal);stroke:var(--teal)}
.sidebar-cta-card h3{font-size:16px;font-weight:600;color:#fff;margin-bottom:8px;line-height:1.3}
.sidebar-cta-card p{font-size:14.5px;color:rgba(255,255,255,.5);margin-bottom:20px;line-height:1.6}
.sidebar-cta-btn{display:block;background:var(--teal);color:#fff;border:none;padding:13px 20px;border-radius:50px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;cursor:pointer;width:100%;transition:.2s;text-align:center;text-decoration:none}
.sidebar-cta-btn:hover{background:#178a64;transform:translateY(-2px)}

@media(max-width:1024px){
  .listing-grid{grid-template-columns:1fr}
  .dir-sidebar{position:static}
}
@media(max-width:640px){
  .hero{padding:120px 24px 40px}
  .hero-meta{gap:14px}
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
    <div class="hero-logo-row">
      <?php if ($listing['logo']): ?>
      <img class="hero-logo" src="<?= htmlspecialchars($listing['logo']) ?>" alt="<?= htmlspecialchars($listing['company_name']) ?> logo">
      <?php else: ?>
      <div class="hero-logo-fallback"><?= htmlspecialchars(strtoupper(substr($listing['company_name'],0,1))) ?></div>
      <?php endif ?>
    </div>
    <?php if ($listing['featured']): ?><div class="hero-badge"><i class="fa-solid fa-star" style="margin-right:6px"></i>Featured Agency</div><?php endif ?>
    <h1 class="hero-h1"><?= htmlspecialchars($listing['company_name']) ?></h1>
    <div class="hero-meta">
      <div class="hero-meta-item"><i class="fa-solid fa-location-dot"></i><?= htmlspecialchars($listing['city']) ?>, <?= htmlspecialchars($listing['state']) ?></div>
      <?php if ($listing['license_number']): ?>
      <div class="hero-meta-item"><i class="fa-solid fa-certificate"></i>License #<?= htmlspecialchars($listing['license_number']) ?></div>
      <?php endif ?>
      <?php if ($listing['years_in_business']): ?>
      <div class="hero-meta-item"><i class="fa-solid fa-calendar"></i><?= htmlspecialchars($listing['years_in_business']) ?> yrs in business</div>
      <?php endif ?>
    </div>
  </div>
</section>

<!-- BODY -->
<section class="listing-body">
  <div class="container listing-grid">
    <div class="listing-desc" data-reveal>
      <p class="cs-label" style="margin-top:0">About</p>
      <p><?= htmlspecialchars($listing['description']) ?></p>

      <?php if ($services): ?>
      <p class="cs-label">Services Offered</p>
      <div class="cs-chip-row">
        <?php foreach ($services as $s): ?><span class="cs-chip"><?= htmlspecialchars($s) ?></span><?php endforeach ?>
      </div>
      <?php endif ?>

      <?php if ($service_areas): ?>
      <p class="cs-label">Service Areas</p>
      <div class="cs-chip-row">
        <?php foreach ($service_areas as $a): ?><span class="cs-chip"><i class="fa-solid fa-location-dot" style="color:var(--teal);margin-right:5px;font-size:10px"></i><?= htmlspecialchars($a) ?></span><?php endforeach ?>
      </div>
      <?php endif ?>
    </div>

    <div class="dir-sidebar" data-reveal style="transition-delay:.1s">
      <div class="sidebar-card">
        <div class="sidebar-card-title">Contact Info</div>
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
      </div>

      <div class="sidebar-cta-card">
        <div class="sc-icon"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg></div>
        <h3>Want a profile that actually brings in clients?</h3>
        <p>We build full marketing systems for home care agencies — websites, SEO, and lead generation that go far beyond a directory listing.</p>
        <a href="/contact/" class="sidebar-cta-btn">Get a Free SEO Audit &rarr;</a>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
