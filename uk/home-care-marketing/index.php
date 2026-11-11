<?php
$page_title     = "Home Care Marketing UK | Domiciliary Care Agency Growth";
$page_desc      = "Marketing for UK domiciliary care providers: more self-funding clients, local carer recruitment and top Google Maps rankings. Real case studies inside.";
$page_canonical = "https://homecarecreators.com/uk/home-care-marketing/";
$og_title       = "Home Care Marketing for UK Domiciliary Care Providers | Homecare Creators";
$og_desc        = "We help UK care agencies win more self-funding clients, recruit carers locally and rank at the top of Google Maps.";
$og_image       = "https://homecarecreators.com/images/team/team-presenting-results-screen.jpg";
$page_hreflang         = "en-gb";
$page_hreflang_default = "https://homecarecreators.com/";
$intl_phone     = true; // booking popup accepts UK numbers
$last_updated_iso   = "2026-11-11";
$last_updated_human = "11 November 2026";

$page_css = <<<CSS
/* HERO */
.hero{background:var(--forest);position:relative;overflow:hidden;padding:0}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-grid{position:relative;z-index:2;max-width:1280px;margin:0 auto;display:grid;grid-template-columns:1.05fr .95fr;gap:56px;align-items:center;padding:150px 48px 80px}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb a:hover{color:rgba(255,255,255,.7)}
.hero-breadcrumb span{color:var(--teal-lt)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:24px;width:fit-content}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(32px,4vw,50px);line-height:1.12;color:#fff;margin-bottom:14px}
.hero-desc{font-size:17.5px;line-height:1.75;color:rgba(255,255,255,.68);max-width:520px;margin-bottom:30px}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap}
.hero-actions .btn-ghost{display:inline-flex;align-items:center;gap:8px;padding:14px 24px;border-radius:100px;border:1px solid rgba(255,255,255,.22);color:#fff;text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:14px;transition:.25s}
.hero-actions .btn-ghost:hover{border-color:var(--teal-lt);color:var(--mint)}
.trust-bar{display:flex;flex-wrap:wrap;gap:10px 22px;margin-top:30px;padding-top:24px;border-top:1px solid rgba(255,255,255,.1)}
.trust-item{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:rgba(255,255,255,.75);font-weight:500}
.trust-item i{color:var(--teal-lt)}
.trust-item strong{color:#fff}
.hero-photo-wrap{position:relative}
.hero-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/4.3;box-shadow:0 30px 80px rgba(0,0,0,.4)}
.hero-photo img{width:100%;height:100%;object-fit:cover;display:block}
.hero-photo-badge{position:absolute;bottom:-22px;left:-22px;z-index:3;background:#fff;border-radius:16px;padding:16px 20px;box-shadow:0 20px 50px rgba(10,46,30,.3);display:flex;align-items:center;gap:12px}
.hero-photo-badge-icon{width:42px;height:42px;border-radius:12px;background:rgba(29,158,117,.1);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.hero-photo-badge-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;color:var(--forest);line-height:1.1}
.hero-photo-badge-label{font-size:11px;color:var(--muted);font-weight:600;font-family:'Plus Jakarta Sans',sans-serif}

/* MARKET DATA */
.market-section{background:var(--cream)}
.market-intro{max-width:760px;margin-bottom:44px}
.market-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px}
.market-card{background:#fff;border:1px solid var(--border);border-radius:18px;padding:26px 22px;display:flex;flex-direction:column}
.market-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:36px;color:var(--teal);line-height:1;margin-bottom:12px}
.market-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15.5px;color:var(--forest);margin-bottom:8px}
.market-desc{font-size:14px;line-height:1.65;color:var(--muted);flex:1}
.market-src{font-size:11.5px;color:var(--muted);margin-top:14px;padding-top:12px;border-top:1px dashed var(--border);font-style:italic}
.market-takeaway{margin-top:32px;padding:22px 26px;background:var(--forest);color:rgba(255,255,255,.8);border-radius:16px;font-size:16px;line-height:1.7}
.market-takeaway strong{color:var(--mint)}

/* SERVICES */
.services-section{background:#fff}
.svc-intro{max-width:720px;margin:0 auto 48px;text-align:center}
.svc-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px}
.svc-card{background:#fff;border:1px solid var(--border);border-radius:18px;overflow:hidden;display:flex;flex-direction:column;transition:.25s}
.svc-card:hover{border-color:rgba(29,158,117,.3);box-shadow:0 14px 40px rgba(10,46,30,.09)}
.svc-card-img{aspect-ratio:16/9;overflow:hidden}
.svc-card-img img{width:100%;height:100%;object-fit:cover;display:block}
.svc-card-body{padding:22px 22px 26px}
.svc-card-icon{width:40px;height:40px;border-radius:11px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:16px;margin-bottom:12px}
.svc-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:17px;color:var(--forest);margin-bottom:8px}
.svc-card-desc{font-size:14.5px;line-height:1.7;color:var(--muted)}
.svc-card ul{list-style:none;margin-top:12px;display:flex;flex-direction:column;gap:7px}
.svc-card li{display:flex;gap:8px;font-size:13.5px;line-height:1.55;color:var(--text)}
.svc-card li i{color:var(--teal);font-size:11px;margin-top:5px;flex-shrink:0}

/* CASE STUDIES */
.cases-section{background:var(--cream)}
.cases-intro{max-width:720px;margin:0 auto 44px;text-align:center}
.case-row{display:grid;grid-template-columns:1fr 1fr;gap:44px;align-items:center;background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px;margin-bottom:28px}
.case-row:nth-child(even) .case-img{order:2}
.case-img{border-radius:16px;overflow:hidden;border:1px solid var(--border);box-shadow:0 14px 40px rgba(10,46,30,.08)}
.case-img img{width:100%;display:block}
.case-badge{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--teal);margin-bottom:8px}
.case-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:22px;color:var(--forest);margin-bottom:14px}
.case-title span{color:var(--muted);font-weight:500}
.case-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--forest);text-transform:uppercase;letter-spacing:.6px;margin:14px 0 6px}
.case-text{font-size:15px;line-height:1.7;color:var(--muted)}
.case-tags{display:flex;flex-wrap:wrap;gap:6px}
.case-tag{font-size:12px;background:var(--warm);border:1px solid var(--border);border-radius:100px;padding:4px 11px;color:var(--forest);font-weight:500}
.case-table{width:100%;border-collapse:collapse;margin-top:8px;font-size:14.5px}
.case-table td{padding:9px 0;border-bottom:1px solid var(--border)}
.case-table td:last-child{text-align:right;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;color:var(--teal);font-size:17px}
.case-table tr:last-child td{border-bottom:none}
.cases-cta{text-align:center;margin-top:12px}

/* FOUNDER */
.founder-section{background:#fff}
.founder-grid{display:grid;grid-template-columns:.8fr 1.2fr;gap:64px;align-items:center}
.founder-photo{border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 70px rgba(10,46,30,.18);aspect-ratio:4/5}
.founder-photo img{width:100%;height:100%;object-fit:cover;display:block}
.founder-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:26px;color:var(--forest)}
.founder-role{font-size:14px;color:var(--teal);font-weight:600;margin-bottom:18px;font-family:'Plus Jakarta Sans',sans-serif}
.founder-bio p{font-size:16.5px;line-height:1.8;color:var(--text);margin-bottom:16px}
.founder-creds{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin:22px 0}
.founder-cred{display:flex;align-items:center;gap:10px;background:var(--warm);border:1px solid var(--border);border-radius:12px;padding:10px 12px;font-size:13.5px;color:var(--forest);font-weight:600}
.founder-cred img{width:34px;height:34px;object-fit:contain;border-radius:6px;background:#fff}
.founder-links{display:flex;gap:12px;flex-wrap:wrap}

/* PROCESS */
.process-section{background:var(--cream)}
.why-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.why-img{border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(10,46,30,.18);aspect-ratio:4/5}
.why-img img{width:100%;height:100%;object-fit:cover;display:block}
.timeline{display:flex;flex-direction:column;position:relative;margin-top:24px}
.timeline-item{display:flex;gap:20px;padding-bottom:32px;position:relative}
.timeline-item:last-child{padding-bottom:0}
.timeline-item::before{content:'';position:absolute;left:21px;top:46px;bottom:0;width:1px;background:var(--border)}
.timeline-item:last-child::before{display:none}
.timeline-num{width:44px;height:44px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:16px;flex-shrink:0;position:relative;z-index:1}
.timeline-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;color:var(--forest);margin-bottom:6px}
.timeline-desc{font-size:15px;line-height:1.7;color:var(--muted)}

/* PRICING */
.pricing-section{background:#fff}
.pricing-intro{max-width:700px;margin:0 auto 48px;text-align:center}
.pricing-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;align-items:stretch}
.price-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px 28px;display:flex;flex-direction:column;position:relative}
.price-card.featured{border:2px solid var(--teal);box-shadow:0 20px 56px rgba(10,46,30,.12);transform:translateY(-8px)}
.price-featured-tag{position:absolute;top:-14px;left:50%;transform:translateX(-50%);background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:6px 16px;border-radius:100px;white-space:nowrap}
.price-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:19px;color:var(--forest);margin-bottom:4px}
.price-best{font-size:13.5px;color:var(--muted);margin-bottom:14px;min-height:40px}
.price-amount{display:flex;align-items:baseline;gap:4px;margin-bottom:20px}
.price-amount-from{font-size:13px;color:var(--muted);font-weight:600;margin-right:4px}
.price-amount-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:40px;color:var(--forest)}
.price-amount-period{font-size:14px;color:var(--muted);font-weight:600}
.price-feature-list{list-style:none;display:flex;flex-direction:column;gap:11px;margin-bottom:26px;flex:1}
.price-feature-list li{display:flex;align-items:flex-start;gap:9px;font-size:14px;color:var(--text);line-height:1.5}
.price-feature-list li i{color:var(--teal);font-size:12px;margin-top:4px;flex-shrink:0}
.price-feature-list li strong{color:var(--forest)}
.price-cta{width:100%;justify-content:center}
.price-cta.dark{background:var(--forest);color:#fff;border:none}
.addons-note{max-width:840px;margin:40px auto 0;text-align:center;font-size:14.5px;line-height:1.75;color:var(--muted);padding:22px 26px;background:var(--warm);border-radius:14px;border:1px solid var(--border)}

/* FAQ */
.faq-section{background:var(--cream)}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:104px 40px}
.cta-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.cta-content .section-label{color:var(--teal-lt)}
.cta-content .section-label::before{background:var(--teal-lt)}
.cta-content .section-h2{color:#fff}
.cta-desc{font-size:18px;color:rgba(255,255,255,.7);line-height:1.78;margin-bottom:32px}
.cta-contact{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;color:rgba(255,255,255,.6);margin-top:22px;line-height:1.9}
.cta-contact a{color:var(--mint);text-decoration:none;font-weight:600}
.cta-image{position:relative;border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3)}
.cta-image img{width:100%;height:420px;object-fit:cover;display:block}
.cta-image-badge{position:absolute;bottom:20px;left:20px;right:20px;background:rgba(10,46,30,.88);backdrop-filter:blur(12px);border:1px solid rgba(46,198,143,.22);border-radius:12px;padding:16px 18px}
.cta-image-badge-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#fff;margin-bottom:10px}
.cta-badge-row{display:flex;align-items:center;gap:8px;margin-bottom:6px}
.cta-badge-row:last-child{margin-bottom:0}
.cta-badge-dot{width:5px;height:5px;border-radius:50%;background:var(--teal-lt);flex-shrink:0}
.cta-badge-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.7)}

/* RESPONSIVE */
@media(max-width:1024px){
  .hero-grid{grid-template-columns:1fr;padding:140px 32px 64px;gap:40px}
  .hero-photo{max-width:420px;margin:0 auto;aspect-ratio:4/3.2}
  .hero-photo-badge{left:16px}
  .market-grid{grid-template-columns:1fr 1fr}
  .svc-grid{grid-template-columns:1fr 1fr}
  .case-row{grid-template-columns:1fr;gap:24px}
  .case-row:nth-child(even) .case-img{order:0}
  .founder-grid,.why-grid{grid-template-columns:1fr;gap:44px}
  .founder-photo,.why-img{max-width:420px;margin:0 auto}
  .pricing-grid{grid-template-columns:1fr;max-width:460px;margin:0 auto}
  .price-card.featured{transform:none}
  .cta-inner{grid-template-columns:1fr}
  .cta-image{display:none}
}
@media(max-width:640px){
  section{padding:64px 20px}
  .hero-grid{padding:120px 20px 48px}
  .market-grid,.svc-grid,.founder-creds{grid-template-columns:1fr}
  .case-row{padding:20px}
  .cta-section{padding:72px 20px}
}
CSS;
include '../../includes/header.php';

// ── Real case studies (shared with /case-studies/) ──────────────
$_cases_all = require __DIR__ . '/../../includes/case-studies-data.php';
$_cases     = array_slice($_cases_all, 0, 3);
$_total_leads = 0; $_total_calls = 0;
foreach ($_cases_all as $_c) {
    foreach ($_c['stats'] as $_s) {
        if ($_s[1] === 'Leads' || $_s[1] === 'Qualified Leads') $_total_leads += (int)$_s[0];
        if ($_s[1] === 'Phone Calls') $_total_calls += (int)$_s[0];
    }
}

// ── FAQs (single source for the page and the FAQPage schema) ────
$_faqs = [
    ["How do care agencies get more private clients in the UK?", "Most self-funding families start with a Google search. The agencies that appear in the Google Maps pack, have strong reviews and clearly explain their care get most of the enquiries. Local SEO and targeted ads are the most reliable ways to get there."],
    ["How long does it take to rank on Google Maps?", "Most agencies see movement within 6 to 10 weeks, and stronger, steadier rankings after 4 to 6 months. Ads can bring enquiries in the first few weeks while SEO builds."],
    ["How much does care agency marketing cost?", "SEO plans start at £549 per month. Care Plus is £849 per month and Care Advanced is £1,249 per month. Prices exclude VAT. Ad spend, if you run ads, is paid directly to Google or Meta. We'll give you a fixed quote after your free audit."],
    ["Can marketing help with carer recruitment?", "Yes. A strong careers page, local job ads and real carer stories bring in more local applicants. That matters more now that international recruitment is harder."],
    ["Do you work with agencies in Scotland, Wales and Northern Ireland?", "Yes. We work with providers across the UK and adapt messaging to each regulator: CQC, Care Inspectorate, CIW or RQIA."],
    ["Do you only work with home care agencies?", "We work only in care: domiciliary care, live-in care, senior care, memory care, hospice and supported living. We don't take clients outside the sector."],
    ["Can you work with my franchise brand guidelines?", "Yes. We regularly work within franchisor rules on branding, ads and website changes."],
    ["Do I need to sign a long contract?", "No. After an initial ramp-up period, every plan moves to a rolling monthly basis."],
    ["You're not based in the UK. Is that a problem?", "We work UK business hours and run regular video calls. Our clients care about results, and we report them every month."],
];

// ── Structured data ─────────────────────────────────────────────
$_founder_id = "https://homecarecreators.com/about/#founder";
$_org_id     = "https://homecarecreators.com/#org";
echo '<script type="application/ld+json">' . json_encode([
    "@context" => "https://schema.org",
    "@graph" => [
        [
            "@type" => "Person", "@id" => $_founder_id,
            "name" => "Asifa Rani", "jobTitle" => "Founder & CEO",
            "image" => "https://homecarecreators.com/images/team/asifa-rani-founder-ceo.jpg",
            "url" => "https://homecarecreators.com/about/",
            "worksFor" => ["@type" => "Organization", "@id" => $_org_id, "name" => "Homecare Creators", "url" => "https://homecarecreators.com/"],
            "sameAs" => ["https://www.linkedin.com/in/asifa-rani/"],
        ],
        [
            "@type" => "Service",
            "name" => "Home Care Marketing for UK Domiciliary Care Providers",
            "serviceType" => "Healthcare marketing",
            "provider" => ["@type" => "Organization", "@id" => $_org_id, "name" => "Homecare Creators", "url" => "https://homecarecreators.com/"],
            "areaServed" => ["@type" => "Country", "name" => "United Kingdom"],
            "audience" => ["@type" => "BusinessAudience", "name" => "Domiciliary care agencies"],
            "url" => $page_canonical,
        ],
        [
            "@type" => "WebPage", "url" => $page_canonical,
            "name" => $page_title, "inLanguage" => "en-GB",
            "author" => ["@id" => $_founder_id],
            "dateModified" => $last_updated_iso,
            "breadcrumb" => ["@type" => "BreadcrumbList", "itemListElement" => [
                ["@type" => "ListItem", "position" => 1, "name" => "Home", "item" => "https://homecarecreators.com/"],
                ["@type" => "ListItem", "position" => 2, "name" => "UK Home Care Marketing", "item" => $page_canonical],
            ]],
        ],
        [
            "@type" => "FAQPage",
            "mainEntity" => array_map(function ($f) {
                return ["@type" => "Question", "name" => $f[0], "acceptedAnswer" => ["@type" => "Answer", "text" => $f[1]]];
            }, $_faqs),
        ],
    ],
], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . "</script>\n";
?>

<!-- HERO -->
<section class="hero" id="home">
  <div class="hero-bg-grid"></div>
  <div class="hero-grid">
    <div>
      <div class="hero-breadcrumb"><a href="/">Home</a> / <span>UK Home Care Marketing</span></div>
      <div class="hero-badge"><div class="hero-badge-pulse"></div>For UK Domiciliary Care Providers</div>
      <h1 class="hero-h1">Home Care Marketing for UK Domiciliary Care Providers</h1>
      <p class="hero-desc">We help UK care agencies win more self-funding clients, recruit carers locally and rank at the top of Google Maps, with marketing built only for care providers.</p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-magnifying-glass-chart"></i>Book a Free Marketing Audit</button>
        <a href="#results" class="btn-ghost">See our case studies <i class="fa-solid fa-arrow-down"></i></a>
      </div>
      <div class="trust-bar">
        <div class="trust-item"><i class="fa-solid fa-chart-line"></i><span><strong><?= number_format($_total_leads) ?>+</strong> leads generated for featured clients</span></div>
        <div class="trust-item"><i class="fa-solid fa-phone-volume"></i><span><strong><?= number_format($_total_calls) ?>+</strong> calls from Google</span></div>
        <div class="trust-item"><i class="fa-brands fa-google"></i><span><strong>Google Partner</strong> certified</span></div>
        <div class="trust-item"><i class="fa-solid fa-heart-pulse"></i><span>Specialists in <strong>home care only</strong></span></div>
      </div>
    </div>
    <div class="hero-photo-wrap" data-reveal>
      <div class="hero-photo">
        <img src="/images/team/team-presenting-results-screen.jpg" alt="Homecare Creators team presenting a care agency's Google ranking results" fetchpriority="high">
      </div>
      <div class="hero-photo-badge">
        <div class="hero-photo-badge-icon"><i class="fa-solid fa-location-dot"></i></div>
        <div>
          <div class="hero-photo-badge-num">Map Pack</div>
          <div class="hero-photo-badge-label">Where families pick their agency</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CERTIFICATIONS -->
<section class="certs">
  <div class="container">
    <p class="certs-label">Certified &amp; Trusted By</p>
    <div class="certs-row">
      <div class="cert-item"><img src="/images/blog/Homecarecreators-Google-my-business-profile.png" alt="Homecare Creators verified Google Business Profile badge" loading="lazy"><span>Google Business Profile</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-google-partner.jpg" alt="Homecare Creators Google Partner certification badge" loading="lazy"><span>Google Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-hubspot-partner.webp" alt="Homecare Creators HubSpot certified partner badge" loading="lazy"><span>HubSpot Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-meta-certificate.jpg" alt="Homecare Creators Meta certified marketing partner badge" loading="lazy"><span>Meta Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-semrush-ceticificate.png" alt="Homecare Creators SEMrush certified SEO partner badge" loading="lazy"><span>SEMrush Certified</span></div>
    </div>
  </div>
</section>

<!-- WHY UK AGENCIES NEED MARKETING -->
<section class="market-section" id="why-marketing">
  <div class="container">
    <div class="market-intro" data-reveal>
      <p class="section-label">The UK Market</p>
      <h2 class="section-h2">Why UK care agencies need marketing in 2026</h2>
      <p class="section-sub">The UK home care market is crowded, under-funded and short of staff, and most agencies are barely visible online. That's exactly why the agencies that market well grow fastest.</p>
    </div>
    <div class="market-grid" data-reveal style="transition-delay:.1s">
      <div class="market-card">
        <div class="market-num">13,000+</div>
        <div class="market-title">Competition is high</div>
        <div class="market-desc">Registered home care providers across the UK, including 11,951 in England. That means more agencies competing in every town.</div>
        <div class="market-src">Source: <a href="https://www.homecare.co.uk/advice/home-care-facts-and-stats-number-of-providers-service-users-workforce" style="color:inherit;text-decoration:underline" target="_blank" rel="noopener">homecare.co.uk</a> (June 2026)</div>
      </div>
      <div class="market-card">
        <div class="market-num">48.8%</div>
        <div class="market-title">Half the market is invisible</div>
        <div class="market-desc">Of England's registered home care agencies list no website on the CQC register. Families searching "home care near me" simply can't find them.</div>
        <div class="market-src">Source: <a href="https://whito.co.uk/research/cqc-register-missing-websites/" style="color:inherit;text-decoration:underline" target="_blank" rel="noopener">Whito analysis of the CQC register</a> (August 2026)</div>
      </div>
      <div class="market-card">
        <div class="market-num">9.1%</div>
        <div class="market-title">Recruitment is the bottleneck</div>
        <div class="market-desc">Domiciliary care vacancy rate in 2025/26, over four times the economy-wide average. With tighter immigration rules, agencies increasingly need to recruit locally.</div>
        <div class="market-src">Source: Skills for Care, via the <a href="https://www.homecareassociation.org.uk/resource/homecare-workers-need-secure-income-not-just-a-higher-hourly-rate.html" style="color:inherit;text-decoration:underline" target="_blank" rel="noopener">Homecare Association</a></div>
      </div>
      <div class="market-card">
        <div class="market-num"><i class="fa-solid fa-sterling-sign"></i></div>
        <div class="market-title">Council fees don't keep up</div>
        <div class="market-desc">Many agencies depend on local authority contracts with tight margins. Self-funding clients usually pay better rates, but you have to market to reach them.</div>
      </div>
    </div>
    <div class="market-takeaway" data-reveal><strong>What this means for you:</strong> an agency with a strong Google presence, real reviews and a clear careers page has a measurable advantage over the competitors around it.</div>
  </div>
</section>

<!-- SERVICES -->
<section class="services-section" id="services">
  <div class="container">
    <div class="svc-intro" data-reveal>
      <p class="section-label" style="justify-content:center">What We Do</p>
      <h2 class="section-h2" style="text-align:center">Our marketing services for UK care providers</h2>
    </div>
    <div class="svc-grid" data-reveal style="transition-delay:.1s">
      <div class="svc-card">
        <div class="svc-card-img"><img src="/images/home/service-local-seo.jpg" alt="Google Maps local SEO for a UK domiciliary care agency" loading="lazy"></div>
        <div class="svc-card-body">
          <div class="svc-card-icon"><i class="fa-solid fa-map-location-dot"></i></div>
          <h3 class="svc-card-title">Google Business Profile and local SEO</h3>
          <p class="svc-card-desc">When a daughter in Leeds searches "home care near me" for her mum, Google shows three agencies in the map pack. Those three get most of the calls. We get you into that pack.</p>
          <ul>
            <li><i class="fa-solid fa-check"></i>Full profile optimisation: categories, services, service areas, photos, weekly posts</li>
            <li><i class="fa-solid fa-check"></i>Listings on homecare.co.uk, Lottie, Autumna and the NHS service finder</li>
            <li><i class="fa-solid fa-check"></i>A simple system to collect genuine reviews from families</li>
            <li><i class="fa-solid fa-check"></i>Town and service pages, e.g. "Live-in care in [Town]"</li>
          </ul>
        </div>
      </div>
      <div class="svc-card">
        <div class="svc-card-img"><img src="/images/home/hero-caregiver-elderly.jpg" alt="Carer supporting an older client at home" loading="lazy"></div>
        <div class="svc-card-body">
          <div class="svc-card-icon"><i class="fa-solid fa-user-group"></i></div>
          <h3 class="svc-card-title">Self-funding client growth</h3>
          <p class="svc-card-desc">Private clients give you better margins and more control. We reach adult children aged 40–65, the people who usually arrange a parent's care, through Google Ads and Facebook ads. Every ad leads to a landing page that explains your care, your CQC rating and what happens after they call.</p>
        </div>
      </div>
      <div class="svc-card">
        <div class="svc-card-img"><img src="/images/home/hero-caregiver-woman.jpg" alt="Smiling care worker, representing local carer recruitment" loading="lazy"></div>
        <div class="svc-card-body">
          <div class="svc-card-icon"><i class="fa-solid fa-id-badge"></i></div>
          <h3 class="svc-card-title">Local carer recruitment marketing</h3>
          <p class="svc-card-desc">You can't take on new clients without carers. We build a careers page that sells the job (pay, travel time, training, rota flexibility), run local recruitment ads on Facebook and Indeed, and share real carer stories that make people want to join you.</p>
        </div>
      </div>
      <div class="svc-card">
        <div class="svc-card-img"><img src="/images/home/service-website-dev.jpg" alt="Mobile-first website for a care agency" loading="lazy"></div>
        <div class="svc-card-body">
          <div class="svc-card-icon"><i class="fa-solid fa-laptop"></i></div>
          <h3 class="svc-card-title">Websites built for care agencies</h3>
          <p class="svc-card-desc">Your website should answer three questions within ten seconds: Do you cover my area? Can I trust you? How do I start? We build fast, mobile-first sites with your CQC rating widget, clear service pages and click-to-call on every page.</p>
        </div>
      </div>
      <div class="svc-card">
        <div class="svc-card-img"><img src="/images/home/hero-nurse-senior.jpg" alt="Nurse with a senior client, representing CQC-rated care" loading="lazy"></div>
        <div class="svc-card-body">
          <div class="svc-card-icon"><i class="fa-solid fa-award"></i></div>
          <h3 class="svc-card-title">CQC rating and reputation marketing</h3>
          <p class="svc-card-desc">A "Good" or "Outstanding" CQC rating is the strongest trust signal you have, yet most agencies hide it. We display it on your site, Google profile and ads, and turn your inspection highlights into content families can understand.</p>
        </div>
      </div>
      <div class="svc-card">
        <div class="svc-card-img"><img src="/images/home/service-brand-identity.jpg" alt="Brand-consistent marketing for a care franchise" loading="lazy"></div>
        <div class="svc-card-body">
          <div class="svc-card-icon"><i class="fa-solid fa-store"></i></div>
          <h3 class="svc-card-title">Franchise marketing</h3>
          <p class="svc-card-desc">Running a franchise location? We help you dominate your territory locally while staying within your franchisor's brand guidelines. See our <a href="/home-care-franchise-seo/" style="color:var(--teal);font-weight:600">franchise SEO</a> approach.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- RESULTS -->
<section class="cases-section" id="results">
  <div class="container">
    <div class="cases-intro" data-reveal>
      <p class="section-label" style="justify-content:center">Case Studies</p>
      <h2 class="section-h2" style="text-align:center">Results we've delivered for care agencies</h2>
      <p class="section-sub" style="margin:0 auto">We don't just talk about results. Here's what happened when care agencies like yours worked with us. These are US clients, shown with their real lead dashboards.</p>
    </div>
    <?php foreach ($_cases as $c): ?>
    <div class="case-row" data-reveal>
      <div class="case-img">
        <img src="/images/case-studies/<?= htmlspecialchars($c['img']) ?>" alt="<?= htmlspecialchars($c['name'] . ' lead dashboard showing ' . $c['stats'][0][0] . ' ' . strtolower($c['stats'][0][1])) ?>" loading="lazy">
      </div>
      <div>
        <div class="case-badge">Case Study <?= htmlspecialchars($c['num']) ?></div>
        <h3 class="case-title"><?= htmlspecialchars($c['name']) ?><?= $c['region'] ? ' <span>| ' . htmlspecialchars($c['region']) . ', USA</span>' : '' ?></h3>
        <div class="case-label">The challenge</div>
        <p class="case-text"><?= htmlspecialchars($c['challenge']) ?></p>
        <div class="case-label">What we did</div>
        <div class="case-tags"><?php foreach ($c['strategy'] as $t): ?><span class="case-tag"><?= htmlspecialchars($t) ?></span><?php endforeach; ?></div>
        <div class="case-label">The results</div>
        <table class="case-table">
          <?php foreach ($c['stats'] as $s): ?>
          <tr><td><?= htmlspecialchars($s[1]) ?></td><td><?= htmlspecialchars($s[0]) ?></td></tr>
          <?php endforeach; ?>
        </table>
      </div>
    </div>
    <?php endforeach; ?>
    <div class="cases-cta"><a href="/case-studies/" class="btn-primary">View all <?= count($_cases_all) ?> case studies <i class="fa-solid fa-arrow-right"></i></a></div>
  </div>
</section>

<!-- REVIEWS (same reviews as the homepage) -->
<?php include '../../includes/reviews-slider.php'; ?>

<!-- FOUNDER -->
<section class="founder-section" id="founder">
  <div class="container">
    <div class="founder-grid">
      <div data-reveal>
        <div class="founder-photo"><img src="/images/team/asifa-rani-founder-ceo.jpg" alt="Asifa Rani, Founder and CEO of Homecare Creators" loading="lazy"></div>
      </div>
      <div class="founder-bio" data-reveal style="transition-delay:.1s">
        <p class="section-label">Who's Behind Homecare Creators</p>
        <h2 class="section-h2" style="margin-bottom:12px">Who's behind Homecare Creators</h2>
        <div class="founder-name">Asifa Rani</div>
        <div class="founder-role">Founder &amp; CEO, Homecare Creators</div>
        <p>Before starting Homecare Creators, Asifa co-founded a web solutions company helping businesses across industries build their digital presence. Again and again, home care agencies were being marketed like any other local business: same templates, same generic SEO playbook, no understanding of how families actually search for care.</p>
        <p>Homecare Creators works only with care providers, so we know the difference between live-in and visiting care, how CQC ratings shape trust, and why recruitment marketing matters as much as client marketing. Asifa personally oversees every client strategy, from Google Business Profile audits to website builds.</p>
        <div class="founder-creds">
          <div class="founder-cred"><img src="/images/blog/Homecarecreators-google-partner.jpg" alt="" loading="lazy">Google Partner</div>
          <div class="founder-cred"><img src="/images/blog/Homecarecreators-meta-certificate.jpg" alt="" loading="lazy">Meta Certified</div>
          <div class="founder-cred"><img src="/images/blog/Homecarecreators-hubspot-partner.webp" alt="" loading="lazy">HubSpot Partner</div>
          <div class="founder-cred"><img src="/images/blog/Homecarecreators-semrush-ceticificate.png" alt="" loading="lazy">SEMrush Certified</div>
        </div>
        <div class="founder-links">
          <a href="/about/" class="btn-primary">Read Asifa's full story</a>
          <a href="https://www.linkedin.com/in/asifa-rani/" target="_blank" rel="noopener" class="btn-secondary" style="background:var(--cream);border-color:var(--border);color:var(--forest)"><i class="fa-brands fa-linkedin-in"></i>Connect on LinkedIn</a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HOW WE WORK -->
<section class="process-section" id="process">
  <div class="container">
    <div class="why-grid">
      <div data-reveal>
        <p class="section-label">How It Works</p>
        <h2 class="section-h2">How we work</h2>
        <div class="timeline">
          <div class="timeline-item"><div class="timeline-num">1</div><div>
            <div class="timeline-title">Free 30-minute audit</div>
            <div class="timeline-desc">We review your website, Google Business Profile, reviews and your top three local competitors, then show you exactly where you're losing enquiries.</div>
          </div></div>
          <div class="timeline-item"><div class="timeline-num">2</div><div>
            <div class="timeline-title">A 90-day plan</div>
            <div class="timeline-desc">A clear plan focused on what you need most: self-funding clients, carers, or both.</div>
          </div></div>
          <div class="timeline-item"><div class="timeline-num">3</div><div>
            <div class="timeline-title">Build and launch</div>
            <div class="timeline-desc">We fix your profile, build pages and launch campaigns, usually within 2–4 weeks.</div>
          </div></div>
          <div class="timeline-item"><div class="timeline-num">4</div><div>
            <div class="timeline-title">Monthly reporting</div>
            <div class="timeline-desc">One plain-English report: enquiries, calls, applicants and rankings. No jargon, no vanity metrics.</div>
          </div></div>
        </div>
      </div>
      <div data-reveal style="transition-delay:.15s">
        <div class="why-img"><img src="/images/team/team-reviewing-seo-dashboard.jpg" alt="Homecare Creators team reviewing a care agency's SEO dashboard" loading="lazy"></div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING (same plans as /seo/home-care-seo/) -->
<section class="pricing-section" id="pricing">
  <div class="container">
    <div class="pricing-intro" data-reveal>
      <p class="section-label" style="justify-content:center">Pricing</p>
      <h2 class="section-h2" style="text-align:center">How much does care agency marketing cost?</h2>
      <p class="section-sub" style="margin:0 auto">Your investment depends on how many towns you cover and how competitive your area is. Ad spend, if you run ads, is paid directly to Google or Meta. We'll give you a fixed quote after your free audit, with no long lock-in contract.</p>
    </div>
    <div class="pricing-grid" data-reveal style="transition-delay:.1s">
      <div class="price-card">
        <div class="price-name">Starter</div>
        <div class="price-best">Best for a single-town agency getting into the map pack</div>
        <div class="price-amount"><span class="price-amount-from">From</span><span class="price-amount-num">£549</span><span class="price-amount-period">/month</span></div>
        <ul class="price-feature-list">
          <li><i class="fa-solid fa-check"></i><span><strong>5</strong> keywords targeted</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>1</strong> Google Business Profile location</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> GBP posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> pages optimised</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>1</strong> blog post per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> backlinks per month</span></li>
          <li><i class="fa-solid fa-check"></i><span>Local schema &amp; standard reporting</span></li>
        </ul>
        <button class="btn-secondary price-cta dark" onclick="openPopup()">Book a Free Audit</button>
      </div>
      <div class="price-card featured">
        <div class="price-featured-tag">Most Popular</div>
        <div class="price-name">Care Plus</div>
        <div class="price-best">Best for agencies covering several towns</div>
        <div class="price-amount"><span class="price-amount-from">From</span><span class="price-amount-num">£849</span><span class="price-amount-period">/month</span></div>
        <ul class="price-feature-list">
          <li><i class="fa-solid fa-check"></i><span><strong>10</strong> keywords targeted</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>1</strong> Google Business Profile location</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>4</strong> GBP posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>4</strong> pages optimised</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> blog posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>4</strong> backlinks per month</span></li>
          <li><i class="fa-solid fa-check"></i><span>Local + FAQ schema, Core Web Vitals</span></li>
          <li><i class="fa-solid fa-check"></i><span>Custom reporting</span></li>
        </ul>
        <button class="btn-primary price-cta" onclick="openPopup()">Book a Free Audit</button>
      </div>
      <div class="price-card">
        <div class="price-name">Care Advanced</div>
        <div class="price-best">Best for competitive areas or two branches</div>
        <div class="price-amount"><span class="price-amount-from">From</span><span class="price-amount-num">£1,249</span><span class="price-amount-period">/month</span></div>
        <ul class="price-feature-list">
          <li><i class="fa-solid fa-check"></i><span><strong>15</strong> keywords targeted</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>2</strong> Google Business Profile locations</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>8</strong> GBP posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>6</strong> pages optimised</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>4</strong> blog posts per month</span></li>
          <li><i class="fa-solid fa-check"></i><span><strong>6</strong> backlinks per month</span></li>
          <li><i class="fa-solid fa-check"></i><span>Local + FAQ + Review + Service schema</span></li>
          <li><i class="fa-solid fa-check"></i><span>Advanced reporting</span></li>
        </ul>
        <button class="btn-secondary price-cta dark" onclick="openPopup()">Book a Free Audit</button>
      </div>
    </div>
    <p class="addons-note">Prices exclude VAT. Recruitment campaigns and paid ads management are quoted separately after your audit. Optional add-ons include a second Google Business Profile location (£79/month), a 50-citation directory bundle (£79/month), a single town page (£159) and entity optimisation (£1,190, one-time).</p>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section" id="faq">
  <div class="container">
    <div data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Frequently asked <em>questions</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">
      <?php foreach ($_faqs as $f): ?>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text"><?= htmlspecialchars($f[0]) ?></span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><?= htmlspecialchars($f[1]) ?></div></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" id="audit">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-content" data-reveal>
        <p class="section-label">Free Marketing Audit</p>
        <h2 class="section-h2">Book your free <em>marketing audit</em></h2>
        <p class="cta-desc">Find out why families aren't finding you, and how to fix it. In 30 minutes we'll show you where you rank, what your competitors are doing better and the three changes that would bring in the most enquiries. It's free, with no obligation.</p>
        <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-calendar-check"></i>Book My Free Audit</button>
        <div class="cta-contact">
          Prefer to talk? Call <a href="tel:+15514307387">+1 (551) 430-7387</a>,
          <a href="https://wa.me/14094193533" target="_blank" rel="noopener"><i class="fa-brands fa-whatsapp"></i> WhatsApp us</a>
          or email <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a>.
        </div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/team/asifa-presenting-whiteboard-session.jpg" alt="Asifa Rani presenting a care agency marketing plan" loading="lazy">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Your Free Audit Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Where you rank in the Google Maps pack</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Google Business Profile and reviews review</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Your top three local competitors</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">The three highest-impact changes</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>
