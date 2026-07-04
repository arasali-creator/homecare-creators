<?php
$page_title = "Home Care SEO Services That Help Agencies Grow | HomeCareCreators";
$page_desc = "Improve your online visibility with Home Care SEO services designed for home care agencies. Attract more families, rank higher on Google, and generate qualified leads with SEO strategies built for the senior care industry.";
$page_canonical = "https://homecarecreators.com/seo/home-care-seo/";
$og_title = "Home Care SEO Services | HomeCareCreators";
$og_desc = "Help more families find your home care agency with SEO strategies designed specifically for the home care industry.";
$page_css = <<<CSS
/* HERO */
.hero{min-height:100vh;background:var(--forest);position:relative;overflow:hidden;display:grid;grid-template-columns:1fr 1fr;align-items:center;padding:0}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-200px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-blob2{position:absolute;width:500px;height:500px;bottom:-150px;left:-100px;background:radial-gradient(circle,rgba(201,168,76,.1) 0%,transparent 65%);animation:float 13s ease-in-out infinite reverse}
.hero-left{position:relative;z-index:2;padding:140px 52px 80px 80px}
.hero-breadcrumb{font-family:'Syne',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px;animation:fadeIn .6s ease both}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb a:hover{color:rgba(255,255,255,.7)}
.hero-breadcrumb span{color:var(--teal-lt)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Syne',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:32px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Instrument Serif',serif;font-size:clamp(36px,4.6vw,60px);line-height:1.06;color:#fff;margin-bottom:10px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-tagline{font-family:'Instrument Serif',serif;font-size:clamp(17px,2vw,23px);line-height:1.35;color:rgba(255,255,255,.5);margin-bottom:10px;animation:fadeUp .8s .18s ease both}
.hero-desc{font-size:16.5px;line-height:1.75;color:rgba(255,255,255,.62);max-width:510px;margin-bottom:42px;animation:fadeUp .8s .3s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .4s ease both;margin-bottom:52px}
.hero-proof{display:flex;gap:32px;flex-wrap:wrap;animation:fadeUp .8s .55s ease both}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Instrument Serif',serif;font-size:34px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-proof-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch}

/* HERO RIGHT — SEO GROWTH MOCKUP */
.hero-right{position:relative;z-index:2;height:100vh;min-height:680px;padding:120px 48px 60px 24px;display:flex;align-items:center;justify-content:center}
.seo-mockup{background:#fff;border-radius:20px;overflow:hidden;box-shadow:0 32px 96px rgba(0,0,0,.4);width:100%;max-width:440px;animation:fadeUp .9s .4s ease both}
.seo-bar{background:var(--forest);padding:12px 16px;display:flex;align-items:center;gap:10px}
.seo-dots{display:flex;gap:6px}
.seo-dot{width:10px;height:10px;border-radius:50%}
.seo-url{flex:1;background:rgba(255,255,255,.1);border-radius:6px;padding:5px 12px;font-family:'Syne',sans-serif;font-size:10px;color:rgba(255,255,255,.6)}
.seo-body{padding:18px}
.seo-search{background:var(--cream);border-radius:28px;padding:10px 16px;display:flex;align-items:center;gap:10px;margin-bottom:16px;border:1px solid var(--border)}
.seo-search-icon{color:var(--teal);font-size:14px}
.seo-search-text{font-family:'Syne',sans-serif;font-size:12px;font-weight:600;color:var(--muted)}
.seo-ai-box{background:rgba(29,158,117,.07);border:1px solid rgba(29,158,117,.22);border-radius:10px;padding:10px 12px;margin-bottom:14px}
.seo-ai-label{display:flex;align-items:center;gap:6px;font-family:'Syne',sans-serif;font-size:10px;font-weight:700;color:var(--teal);text-transform:uppercase;letter-spacing:.5px;margin-bottom:5px}
.seo-ai-text{font-size:10.5px;color:var(--muted);line-height:1.5}
.seo-results{display:flex;flex-direction:column;gap:8px}
.seo-result{background:var(--warm);border:1px solid var(--border);border-radius:10px;padding:11px 12px}
.seo-result.top-result{background:rgba(29,158,117,.06);border-color:rgba(29,158,117,.25)}
.seo-result-row{display:flex;align-items:center;gap:10px;margin-bottom:4px}
.seo-result-rank{width:22px;height:22px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-size:10.5px;font-weight:800;flex-shrink:0}
.seo-result.top-result .seo-result-rank{background:var(--teal)}
.seo-result-name{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;color:var(--forest);flex:1}
.seo-result.top-result .seo-result-name{color:var(--teal)}
.seo-you-badge{font-family:'Syne',sans-serif;font-size:9px;font-weight:700;background:var(--teal);color:#fff;padding:2px 8px;border-radius:10px;flex-shrink:0}
.seo-result-url{font-size:9px;color:var(--muted);padding-left:32px}
.seo-rank-badge{position:absolute;top:26%;right:-12px;background:#fff;border-radius:12px;padding:10px 14px;box-shadow:0 8px 32px rgba(0,0,0,.2);border:1px solid var(--border);animation:floatR 4s ease-in-out infinite;text-align:center}
.seo-rank-num{font-family:'Syne',sans-serif;font-size:18px;font-weight:800;color:var(--teal)}
.seo-rank-label{font-size:9px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600}
.seo-traffic-badge{position:absolute;bottom:20%;left:-16px;background:var(--forest);border-radius:12px;padding:10px 14px;box-shadow:0 8px 32px rgba(0,0,0,.3);border:1px solid rgba(46,198,143,.3);animation:floatR 5s ease-in-out infinite 1s;min-width:150px}
.seo-traffic-num{font-family:'Instrument Serif',serif;font-size:22px;color:var(--teal-lt);line-height:1}
.seo-traffic-label{font-size:9px;color:rgba(255,255,255,.5);font-family:'Syne',sans-serif;font-weight:600}

/* WHY / VISUAL GRID (reused for multiple sections) */
.why-grid{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.why-grid.rev .why-visual{order:2}
.why-grid.rev .why-copy{order:1}
.why-body p{font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.why-points{display:flex;flex-direction:column;gap:14px;margin-top:28px}
.why-point{display:flex;gap:16px;align-items:flex-start;padding:18px;border-radius:16px;border:1px solid var(--border);background:var(--warm);transition:.3s}
.why-point:hover{border-color:rgba(29,158,117,.3);box-shadow:0 8px 32px rgba(10,46,30,.08);transform:translateX(4px)}
.why-point-icon{width:44px;height:44px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.why-point-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15px;color:var(--forest);margin-bottom:4px}
.why-point-desc{font-size:13.5px;line-height:1.6;color:var(--muted)}
.why-visual{position:relative;align-self:start}
.why-img{border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(10,46,30,.18);aspect-ratio:4/5}
.why-img img{width:100%;height:100%;object-fit:cover;display:block}
.why-img::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(10,46,30,.55) 100%);border-radius:var(--r-lg)}
.why-stat-float{position:absolute;bottom:-20px;right:-20px;background:#fff;border-radius:16px;padding:18px 22px;box-shadow:0 12px 48px rgba(10,46,30,.18);text-align:center;min-width:130px;border:1px solid var(--border);animation:floatR 5s ease-in-out infinite}
.why-stat-num{font-family:'Instrument Serif',serif;font-size:38px;color:var(--teal);line-height:1}
.why-stat-label{font-size:11px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600;margin-top:3px}
.why-badge-float{position:absolute;top:24px;left:-18px;background:var(--forest);border-radius:14px;padding:12px 18px;min-width:170px;box-shadow:0 8px 32px rgba(0,0,0,.25);border:1px solid rgba(29,158,117,.3);animation:floatR 7s ease-in-out infinite 1s}
.why-badge-row{display:flex;align-items:center;gap:10px}
.why-badge-icon{font-size:18px;color:var(--teal-lt)}
.why-badge-text{font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:#fff}
.why-badge-sub{font-size:10px;color:rgba(255,255,255,.5)}
.authority-links{margin-top:20px;font-size:13px;color:var(--muted)}
.authority-links a{color:var(--teal);font-weight:600;text-decoration:none}
.authority-links a:hover{text-decoration:underline}

/* INCLUDED GRID */
.included-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:48px}
.inc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:24px;transition:.25s}
.inc-card:hover{box-shadow:0 8px 32px rgba(10,46,30,.08);border-color:rgba(29,158,117,.2)}
.inc-icon{width:46px;height:46px;border-radius:12px;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:20px;margin-bottom:16px}
.inc-card h3{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:8px}
.inc-card p{font-size:13px;color:var(--muted);line-height:1.7}

/* PROCESS GRID (5-step) */
.process-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:0;margin-top:72px;position:relative}
.process-grid::before{content:'';position:absolute;top:44px;left:8%;right:8%;height:1px;background:linear-gradient(90deg,transparent,var(--teal) 20%,var(--teal) 80%,transparent);opacity:.25}
.process-step{text-align:center;padding:0 14px 40px;position:relative}
.process-step-num{width:88px;height:88px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;margin:0 auto 22px;font-family:'Syne',sans-serif;font-weight:800;font-size:26px;position:relative;z-index:1;box-shadow:0 0 0 10px rgba(29,158,117,.08),0 8px 32px rgba(10,46,30,.2);transition:.3s}
.process-step:hover .process-step-num{background:var(--teal);box-shadow:0 0 0 10px rgba(29,158,117,.15),0 12px 40px rgba(29,158,117,.35)}
.process-step-icon{position:absolute;bottom:-4px;right:22px;width:26px;height:26px;border-radius:50%;background:var(--teal-lt);color:#fff;display:flex;align-items:center;justify-content:center;font-size:11px;box-shadow:0 2px 8px rgba(0,0,0,.2)}
.process-step-title{font-family:'Syne',sans-serif;font-weight:700;font-size:14.5px;color:var(--forest);margin-bottom:9px}
.process-step-desc{font-size:12.5px;line-height:1.6;color:var(--muted)}

/* OUTCOMES CHECKLIST */
.outcomes-grid{display:grid;grid-template-columns:1fr 1fr;gap:14px;margin-top:44px}
.outcome-item{display:flex;align-items:center;gap:14px;background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:18px 20px;transition:.2s}
.outcome-item:hover{border-color:rgba(29,158,117,.3);box-shadow:0 6px 24px rgba(10,46,30,.08)}
.outcome-item i{color:var(--teal);font-size:17px;flex-shrink:0}
.outcome-item span{font-size:14.5px;font-weight:600;color:var(--forest);font-family:'Syne',sans-serif}

/* WHO WE HELP */
.who-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(200px,1fr));gap:12px;margin-top:40px}
.who-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:18px 20px;display:flex;align-items:center;gap:12px;transition:all .2s}
.who-card:hover{border-color:var(--teal);transform:translateY(-2px);box-shadow:0 8px 24px rgba(10,46,30,.08)}
.who-icon{width:36px;height:36px;border-radius:9px;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:15px;flex-shrink:0}
.who-name{font-family:'Syne',sans-serif;font-size:13.5px;font-weight:700;color:var(--forest)}

/* RELATED SERVICES */
.related-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:48px}
.related-card{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:26px 22px;text-decoration:none;display:block;transition:.25s}
.related-card:hover{border-color:rgba(29,158,117,.3);box-shadow:0 10px 32px rgba(10,46,30,.1);transform:translateY(-3px)}
.related-icon{width:44px;height:44px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;margin-bottom:16px}
.related-card h3{font-family:'Syne',sans-serif;font-size:14.5px;font-weight:700;color:var(--forest);margin-bottom:8px}
.related-card p{font-size:12.5px;color:var(--muted);line-height:1.6;margin-bottom:12px}
.related-link{font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:var(--teal)}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:104px 40px}
.cta-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.cta-content .section-label{color:var(--teal-lt)}
.cta-content .section-label::before{background:var(--teal-lt)}
.cta-content .section-h2{color:#fff}
.cta-desc{font-size:16px;color:rgba(255,255,255,.68);line-height:1.78;margin-bottom:32px}
.cta-guarantee{font-family:'Syne',sans-serif;font-size:12px;color:rgba(255,255,255,.45);display:flex;align-items:center;gap:8px;margin-top:18px}
.cta-guarantee i{color:var(--teal-lt)}
.cta-image{position:relative;border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3)}
.cta-image img{width:100%;height:400px;object-fit:cover;display:block}
.cta-image-badge{position:absolute;bottom:20px;left:20px;right:20px;background:rgba(10,46,30,.88);backdrop-filter:blur(12px);border:1px solid rgba(46,198,143,.22);border-radius:12px;padding:16px 18px}
.cta-image-badge-title{font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:#fff;margin-bottom:10px}
.cta-badge-row{display:flex;align-items:center;gap:8px;margin-bottom:6px}
.cta-badge-row:last-child{margin-bottom:0}
.cta-badge-dot{width:5px;height:5px;border-radius:50%;background:var(--teal-lt);flex-shrink:0}
.cta-badge-text{font-family:'Syne',sans-serif;font-size:12px;color:rgba(255,255,255,.65)}

/* SECTION BACKGROUNDS */
.why-section{background:#fff}
.diff-section{background:var(--cream)}
.included-section{background:#fff}
.process-section{background:var(--cream)}
.outcomes-section{background:var(--forest)}
.outcomes-section .section-label,.outcomes-section .section-h2{color:#fff}
.outcomes-section .section-label{color:var(--teal-lt)}
.outcomes-section .section-label::before{background:var(--teal-lt)}
.outcomes-section .section-sub{color:rgba(255,255,255,.6)}
.who-section{background:#fff}
.faq-section{background:var(--cream)}
.related-section{background:#fff}

/* RESPONSIVE */
@media(max-width:1024px){.hero{grid-template-columns:1fr;min-height:auto}.hero-right{display:none}.hero-left{padding:140px 48px 80px}.included-grid,.related-grid{grid-template-columns:1fr 1fr}.why-grid{grid-template-columns:1fr;gap:48px}.why-grid.rev .why-visual,.why-grid.rev .why-copy{order:initial}.process-grid{grid-template-columns:repeat(3,1fr)}.process-grid::before{display:none}.cta-inner{grid-template-columns:1fr}.cta-image{display:none}.outcomes-grid{grid-template-columns:1fr}}
@media(max-width:640px){section{padding:64px 20px}.included-grid,.related-grid,.outcomes-grid{grid-template-columns:1fr}.process-grid{grid-template-columns:1fr 1fr}}
CSS;
include '../../includes/header.php';

// ── Structured data: BreadcrumbList, Service, FAQPage ──────────
$_bc = [
    ["@type"=>"ListItem","position"=>1,"name"=>"Home","item"=>"https://homecarecreators.com/"],
    ["@type"=>"ListItem","position"=>2,"name"=>"Services","item"=>"https://homecarecreators.com/#services"],
    ["@type"=>"ListItem","position"=>3,"name"=>"Home Care SEO","item"=>$page_canonical],
];
$_faqs = [
    ["How long does Home Care SEO take?", "SEO is a long-term strategy. While every agency is different, many begin seeing meaningful improvements within three to six months, with continued growth over time."],
    ["Is Local SEO included?", "Absolutely. Local SEO is a core part of every strategy and includes optimizing your Google Business Profile, improving local visibility, and helping your agency appear in Google Maps and location-based searches."],
    ["Can you optimize my existing website?", "Yes. Whether your website is built on WordPress, Webflow, Wix, Shopify, or another platform, we can optimize it without starting from scratch in most cases."],
    ["Do you work with agencies across Florida?", "Home care is one of our primary specialties and Florida is our home market. We build SEO strategies that reflect how families search for care and how agencies grow in competitive local Florida markets."],
    ["Do you guarantee rankings?", "No. No ethical SEO agency can guarantee rankings because search engines constantly change. What we do promise is a transparent process, best practices, and a strategy focused on sustainable long-term growth."],
];
echo '<script type="application/ld+json">' . json_encode(["@context"=>"https://schema.org","@type"=>"BreadcrumbList","itemListElement"=>$_bc], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"Service",
    "name"=>"Home Care SEO Services",
    "serviceType"=>"SEO Services",
    "provider"=>["@type"=>"Organization","name"=>"HomeCareCreators","url"=>"https://homecarecreators.com/"],
    "areaServed"=>["@type"=>"State","name"=>"Florida"],
    "description"=>$page_desc,
    "url"=>$page_canonical,
], JSON_UNESCAPED_SLASHES) . "</script>\n";
echo '<script type="application/ld+json">' . json_encode([
    "@context"=>"https://schema.org","@type"=>"FAQPage",
    "mainEntity"=>array_map(function($f){ return ["@type"=>"Question","name"=>$f[0],"acceptedAnswer"=>["@type"=>"Answer","text"=>$f[1]]]; }, $_faqs),
], JSON_UNESCAPED_SLASHES) . "</script>\n";
?>

<!-- HERO -->
<section class="hero" id="home">
  <div class="hero-bg-grid"></div>
  <div class="hero-blob1"></div>
  <div class="hero-blob2"></div>
  <div class="hero-left">
    <div class="hero-breadcrumb"><a href="/">Home</a> / <a href="/#services">Services</a> / <span>Home Care SEO</span></div>
    <div class="hero-badge"><div class="hero-badge-pulse"></div>Home Care SEO Services</div>
    <h1 class="hero-h1">Get Found by the Families<br><em>Who Need You Most</em></h1>
    <div class="hero-tagline"><em>SEO Strategies Built</em><br><em>for the Home Care Industry</em></div>
    <p class="hero-desc">Before a family ever picks up the phone, they search Google. We help home care agencies improve their online visibility with SEO built specifically for senior care, so more of those searches turn into real conversations.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-magnifying-glass-chart"></i>Book Free SEO Consultation</button>
      <a href="#included" class="btn-secondary"><i class="fa-solid fa-layer-group"></i>What's Included</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item"><div class="hero-proof-num">#1</div><div class="hero-proof-label">Google Maps in 5mo</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">312%</div><div class="hero-proof-label">Avg Lead Increase</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">$0</div><div class="hero-proof-label">Free Consultation</div></div>
    </div>
  </div>
  <div class="hero-right">
    <div style="position:relative;width:100%;max-width:440px">
      <div class="seo-mockup">
        <div class="seo-bar">
          <div class="seo-dots"><div class="seo-dot" style="background:#ff5f57"></div><div class="seo-dot" style="background:#febc2e"></div><div class="seo-dot" style="background:#28c840"></div></div>
          <div class="seo-url">google.com · home care agency near me</div>
        </div>
        <div class="seo-body">
          <div class="seo-search"><i class="fa-solid fa-magnifying-glass seo-search-icon"></i><span class="seo-search-text">best home care agency near me</span></div>
          <div class="seo-ai-box">
            <div class="seo-ai-label"><i class="fa-solid fa-sparkles"></i>AI Overview</div>
            <div class="seo-ai-text">Top-rated home care agencies known for compassionate, licensed caregivers include <strong>Your Homecare Agency</strong>...</div>
          </div>
          <div class="seo-results">
            <div class="seo-result top-result">
              <div class="seo-result-row"><div class="seo-result-rank">1</div><div class="seo-result-name">Your Homecare Agency</div><div class="seo-you-badge">YOU</div></div>
              <div class="seo-result-url">yourhomecareagency.com</div>
            </div>
            <div class="seo-result">
              <div class="seo-result-row"><div class="seo-result-rank">2</div><div class="seo-result-name">Competitor Agency A</div></div>
              <div class="seo-result-url">competitor-a.com</div>
            </div>
            <div class="seo-result">
              <div class="seo-result-row"><div class="seo-result-rank">3</div><div class="seo-result-name">Competitor Agency B</div></div>
              <div class="seo-result-url">competitor-b.com</div>
            </div>
          </div>
        </div>
      </div>
      <div class="seo-rank-badge">
        <div class="seo-rank-num">#1</div>
        <div class="seo-rank-label">Google &amp; AI Search</div>
      </div>
      <div class="seo-traffic-badge">
        <div class="seo-traffic-num">312%</div>
        <div class="seo-traffic-label">Avg. qualified lead increase</div>
      </div>
    </div>
  </div>
</section>

<!-- CERTIFICATIONS / TRUST BADGES -->
<section class="certs">
  <div class="container">
    <p class="certs-label">Certified &amp; Trusted By</p>
    <div class="certs-row">
      <div class="cert-item"><img src="/images/blog/Homecarecreators-BBB-Certified.png" alt="Homecare Creators BBB accredited business certification badge" title="BBB Accredited Business" loading="lazy"><span>BBB Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-Google-my-business-profile.png" alt="Homecare Creators verified Google Business Profile badge" title="Verified Google Business Profile" loading="lazy"><span>Google Business Profile</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-google-partner.jpg" alt="Homecare Creators Google Partner certification badge" title="Google Partner Certified Agency" loading="lazy"><span>Google Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-hubspot-partner.webp" alt="Homecare Creators HubSpot certified partner badge" title="HubSpot Certified Partner" loading="lazy"><span>HubSpot Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-meta-certificate.jpg" alt="Homecare Creators Meta certified marketing partner badge" title="Meta Certified Marketing Partner" loading="lazy"><span>Meta Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-semrush-ceticificate.png" alt="Homecare Creators SEMrush certified SEO partner badge" title="SEMrush Certified Agency Partner" loading="lazy"><span>SEMrush Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-NACH.webp" alt="Homecare Creators National Association for Home Care and Hospice member badge" title="NAHC Member Agency" loading="lazy"><span>NAHC Member</span></div>
    </div>
  </div>
</section>

<!-- TICKER -->
<div class="ticker-wrap" aria-hidden="true">
  <div class="ticker-inner">
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Local SEO &amp; Google Maps</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>Google Business Profile Management</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-pen-nib"></i>Content Families Trust</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-gauge-high"></i>Technical SEO &amp; Site Speed</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>AI Search SEO for ChatGPT &amp; Perplexity</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-chart-line"></i>Ongoing SEO Growth</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Local SEO &amp; Google Maps</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>Google Business Profile Management</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-pen-nib"></i>Content Families Trust</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-gauge-high"></i>Technical SEO &amp; Site Speed</div>
  </div>
</div>

<!-- WHY SEO MATTERS -->
<section class="why-section">
  <div class="container">
    <div class="why-grid">
      <div class="why-copy" data-reveal>
        <p class="section-label">Why SEO Matters</p>
        <h2 class="section-h2">Home Care Is Built on Trust.<br><em>So Is Getting Found.</em></h2>
        <div class="why-body">
          <p>Finding the right home care provider is one of the most important decisions a family can make. Before they pick up the phone, most start with a simple Google search. They compare agencies, read reviews, visit websites, and look for a provider they can trust.</p>
          <p>If your agency isn't showing up in those search results, you're missing opportunities to connect with families who are actively looking for care. Instead of relying only on referrals or paid advertising, SEO helps your website become a consistent source of qualified inquiries by connecting you with families already searching for the services you provide.</p>
          <p>At HomeCareCreators, our focus isn't just on increasing rankings — it's on helping your agency attract the right visitors, earn their trust, and turn more searches into conversations. Done right, SEO becomes one of the most valuable long-term investments for your agency.</p>
        </div>
        <div class="authority-links">Sources families and caregivers rely on: <a href="https://www.cms.gov/" target="_blank" rel="noopener noreferrer">Centers for Medicare &amp; Medicaid Services (CMS)</a> &middot; <a href="https://www.nia.nih.gov/" target="_blank" rel="noopener noreferrer">National Institute on Aging</a></div>
      </div>
      <div class="why-visual" data-reveal style="transition-delay:.15s">
        <div class="why-img">
          <img src="/images/seo/home-care-seo-services.jpg" alt="Home Care SEO services helping agencies rank higher on Google" title="Home Care SEO services">
        </div>
        <div class="why-stat-float">
          <div class="why-stat-num">75%</div>
          <div class="why-stat-label">Of clicks go to the top 3 results</div>
        </div>
        <div class="why-badge-float">
          <div class="why-badge-row">
            <div class="why-badge-icon"><i class="fa-solid fa-heart"></i></div>
            <div>
              <div class="why-badge-text">Trust-First Strategy</div>
              <div class="why-badge-sub">Built for how families search</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- HOME CARE SEO ISN'T LIKE TRADITIONAL SEO -->
<section class="diff-section">
  <div class="container">
    <div class="why-grid rev">
      <div class="why-visual" data-reveal>
        <div class="why-img">
          <img src="/images/seo/home-care-seo-process.jpg" alt="SEO strategy for home care agencies" title="SEO strategy for home care agencies">
        </div>
        <div class="why-stat-float">
          <div class="why-stat-num">100%</div>
          <div class="why-stat-label">Focused on home care</div>
        </div>
      </div>
      <div class="why-copy" data-reveal style="transition-delay:.15s">
        <p class="section-label">Not Like Traditional SEO</p>
        <h2 class="section-h2">Families Aren't Comparing<br><em>Prices. They're Comparing Trust.</em></h2>
        <div class="why-body">
          <p>Every industry has its own challenges. Home care is different because people aren't simply comparing prices — they're looking for compassion, professionalism, and confidence. That's why successful home care SEO is about much more than keywords.</p>
          <p>It requires understanding how families search, what information they need, and what builds trust before they ever contact your agency. We create SEO strategies that balance technical optimization with helpful, informative content designed for real people. Because better rankings mean very little if your website doesn't give families a reason to choose you.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WHAT'S INCLUDED -->
<section class="included-section" id="included">
  <div class="container">
    <div data-reveal>
      <p class="section-label">What's Included</p>
      <h2 class="section-h2">Everything That Goes Into<br><em>Home Care SEO That Works</em></h2>
      <p class="section-sub">Every agency serves different communities, offers different services, and has different growth goals. We build a custom strategy around yours instead of a one-size-fits-all approach.</p>
    </div>
    <div class="included-grid" data-reveal style="transition-delay:.1s">
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-compass"></i></div><h3>SEO Strategy Built Around Your Agency</h3><p>We build a custom SEO strategy based on your service areas, competition, and business objectives instead of using a one-size-fits-all approach.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-map-location-dot"></i></div><h3>Local SEO</h3><p>Most home care searches happen locally. Whether someone searches "home care near me" or a specific city, we help improve your local visibility so families can find you when they're ready to take the next step.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-brands fa-google"></i></div><h3>Google Business Profile Optimization</h3><p>Your Google Business Profile is often the first thing potential clients see. We optimize every part of it, from business information to categories and ongoing improvements, to help increase visibility in Google Maps.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-pen-nib"></i></div><h3>Content That Builds Trust</h3><p>Families have questions before making a decision. We create content that answers those questions clearly, helping your website become a trusted resource while improving your search visibility at the same time.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-gauge-high"></i></div><h3>Technical SEO</h3><p>Behind every successful website is a strong technical foundation. We improve site speed, structure, internal linking, crawlability, and mobile performance so search engines understand your site better.</p></div>
      <div class="inc-card"><div class="inc-icon"><i class="fa-solid fa-arrow-trend-up"></i></div><h3>Ongoing SEO Growth</h3><p>Search engines continue to evolve. We regularly monitor performance, identify new opportunities, and refine your strategy so your website keeps growing instead of standing still.</p></div>
    </div>
  </div>
</section>

<!-- OUR SEO PROCESS -->
<section class="process-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Our SEO Process</p>
      <h2 class="section-h2" style="text-align:center">From First Audit to<br><em>Long-Term Growth</em></h2>
    </div>
    <div class="process-grid" data-reveal style="transition-delay:.1s">
      <div class="process-step">
        <div class="process-step-num">1<div class="process-step-icon"><i class="fa-solid fa-ear-listen"></i></div></div>
        <div class="process-step-title">Learn About Your Agency</div>
        <div class="process-step-desc">We begin by understanding your services, service areas, ideal clients, and long-term business goals.</div>
      </div>
      <div class="process-step">
        <div class="process-step-num">2<div class="process-step-icon"><i class="fa-solid fa-magnifying-glass"></i></div></div>
        <div class="process-step-title">Research Your Market</div>
        <div class="process-step-desc">We analyze how families search for care, identify opportunities, and evaluate your local competition.</div>
      </div>
      <div class="process-step">
        <div class="process-step-num">3<div class="process-step-icon"><i class="fa-solid fa-screwdriver-wrench"></i></div></div>
        <div class="process-step-title">Optimize Your Website</div>
        <div class="process-step-desc">From technical improvements to content optimization, we strengthen every part of your website that impacts search visibility.</div>
      </div>
      <div class="process-step">
        <div class="process-step-num">4<div class="process-step-icon"><i class="fa-solid fa-shield-heart"></i></div></div>
        <div class="process-step-title">Build Authority</div>
        <div class="process-step-desc">We create valuable content and strengthen your online presence so search engines and clients see your agency as a trusted resource.</div>
      </div>
      <div class="process-step">
        <div class="process-step-num">5<div class="process-step-icon"><i class="fa-solid fa-chart-line"></i></div></div>
        <div class="process-step-title">Measure &amp; Improve</div>
        <div class="process-step-desc">SEO isn't a one-time project. We continue monitoring results and making improvements that support long-term growth.</div>
      </div>
    </div>
  </div>
</section>

<!-- WHY HOMECARECREATORS -->
<section class="why-section">
  <div class="container">
    <div class="why-grid">
      <div class="why-copy" data-reveal>
        <p class="section-label">Why HomeCareCreators</p>
        <h2 class="section-h2">Very Few Agencies<br><em>Understand Home Care.</em></h2>
        <div class="why-body">
          <p>There are thousands of marketing agencies. Very few understand the home care industry. At HomeCareCreators, we focus on helping home care agencies grow through thoughtful, long-term marketing strategies.</p>
          <p>We understand how families search for care. We understand how important trust is in healthcare decisions. And we understand that rankings only matter if they help your agency generate meaningful conversations with potential clients.</p>
          <p>Instead of chasing shortcuts, we focus on building a strong online presence that continues delivering value month after month.</p>
        </div>
      </div>
      <div class="why-visual" data-reveal style="transition-delay:.15s">
        <div class="why-img">
          <img src="/images/home/ai-seo-tech.jpg" alt="Home Care SEO process for Florida home care agencies" title="Home Care SEO process">
        </div>
        <div class="why-badge-float">
          <div class="why-badge-row">
            <div class="why-badge-icon"><i class="fa-solid fa-star"></i></div>
            <div>
              <div class="why-badge-text">Home Care Only</div>
              <div class="why-badge-sub">No other industry, no learning curve</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- RESULTS WE'RE WORKING TOWARD -->
<section class="outcomes-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">The Results We're Working Toward</p>
      <h2 class="section-h2" style="text-align:center">Every Agency Has Different Goals.<br><em>Most Want the Same Outcome.</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center">More qualified inquiries from families looking for care. SEO is a long-term investment, and every improvement builds on the last.</p>
    </div>
    <div class="outcomes-grid" data-reveal style="transition-delay:.1s">
      <div class="outcome-item"><i class="fa-solid fa-check-circle"></i><span>Increase visibility in Google Search</span></div>
      <div class="outcome-item"><i class="fa-solid fa-check-circle"></i><span>Improve local search rankings</span></div>
      <div class="outcome-item"><i class="fa-solid fa-check-circle"></i><span>Generate more qualified website traffic</span></div>
      <div class="outcome-item"><i class="fa-solid fa-check-circle"></i><span>Attract more inquiries from families</span></div>
      <div class="outcome-item"><i class="fa-solid fa-check-circle"></i><span>Build long-term online authority</span></div>
      <div class="outcome-item"><i class="fa-solid fa-check-circle"></i><span>Reduce dependence on paid advertising</span></div>
      <div class="outcome-item"><i class="fa-solid fa-check-circle"></i><span>Strengthen your online reputation</span></div>
    </div>
  </div>
</section>

<!-- WHO WE HELP -->
<section class="who-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Who We Help</p>
      <h2 class="section-h2">Built for the Senior Care<br><em>Industry — Nothing Else</em></h2>
      <p class="section-sub">If your mission is helping older adults live safely and comfortably, we can help more families find your business online.</p>
    </div>
    <div class="who-grid" data-reveal style="transition-delay:.1s">
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-house-chimney-medical"></i></div><div class="who-name">Home Care Agencies</div></div>
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-user-nurse"></i></div><div class="who-name">Home Health Agencies</div></div>
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-handshake-angle"></i></div><div class="who-name">Companion Care Providers</div></div>
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-hand-holding-heart"></i></div><div class="who-name">Personal Care Services</div></div>
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-people-roof"></i></div><div class="who-name">Private Duty Care Agencies</div></div>
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-cane"></i></div><div class="who-name">Senior Care Providers</div></div>
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-tree"></i></div><div class="who-name">Elder Care Services</div></div>
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-brain"></i></div><div class="who-name">Memory Care Providers</div></div>
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-dove"></i></div><div class="who-name">Hospice Organizations</div></div>
      <div class="who-card"><div class="who-icon"><i class="fa-solid fa-building-user"></i></div><div class="who-name">Assisted Living Communities</div></div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Home Care SEO<br><em>Your Questions Answered</em></h2>
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

<!-- RELATED SERVICES -->
<section class="related-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Related Services</p>
      <h2 class="section-h2">SEO Works Best as Part of<br><em>a Complete Strategy</em></h2>
      <p class="section-sub">SEO works best when it's part of a complete marketing strategy. You may also be interested in:</p>
    </div>
    <div class="related-grid" data-reveal style="transition-delay:.1s">
      <a href="/#services" class="related-card">
        <div class="related-icon"><i class="fa-solid fa-bullseye"></i></div>
        <h3>Home Care Marketing</h3>
        <p>Build a long-term marketing strategy that combines SEO, content, local marketing, and lead generation to help your agency grow consistently.</p>
        <span class="related-link">Explore Home Care Marketing <i class="fa-solid fa-arrow-right"></i></span>
      </a>
      <a href="/web-design/homecare-website-design/" class="related-card">
        <div class="related-icon"><i class="fa-solid fa-laptop-code"></i></div>
        <h3>Home Care Website Design</h3>
        <p>Create a website that builds trust, loads quickly, and turns visitors into inquiries.</p>
        <span class="related-link">Explore Website Design <i class="fa-solid fa-arrow-right"></i></span>
      </a>
      <a href="/#services" class="related-card">
        <div class="related-icon"><i class="fa-solid fa-brain"></i></div>
        <h3>AI Search Optimization (GEO)</h3>
        <p>Prepare your website for AI-powered search platforms like ChatGPT, Google AI, Gemini, and Perplexity with a future-focused optimization strategy.</p>
        <span class="related-link">Explore AI Search Optimization <i class="fa-solid fa-arrow-right"></i></span>
      </a>
      <a href="/#services" class="related-card">
        <div class="related-icon"><i class="fa-solid fa-gears"></i></div>
        <h3>AI &amp; Automation</h3>
        <p>Automate lead follow-ups, appointment scheduling, and routine tasks so your team can focus on providing exceptional care.</p>
        <span class="related-link">Explore AI &amp; Automation <i class="fa-solid fa-arrow-right"></i></span>
      </a>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-content" data-reveal>
        <p class="section-label">Get Started Today</p>
        <h2 class="section-h2">Ready to Grow Your<br><em>Home Care Agency?</em></h2>
        <p class="cta-desc">Families are searching for home care every day. The question is whether they're finding your agency or someone else's. Let's create an SEO strategy that helps your agency become more visible, earn more trust, and generate more qualified inquiries from the families who need your services.</p>
        <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-magnifying-glass-chart"></i>Book Your Free SEO Strategy Call</button>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free consultation &nbsp;·&nbsp; No obligation &nbsp;·&nbsp; No guaranteed-ranking gimmicks</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/home/cta-business-owner.jpg" alt="Florida home care agency owner growing their business with Home Care SEO" title="Home care agency growth through SEO">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Free Strategy Call Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Current visibility &amp; ranking review</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Where your biggest opportunities are</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Google Business Profile audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">A clear next-steps roadmap</div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include '../../includes/footer.php'; ?>
