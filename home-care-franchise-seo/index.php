<?php
$page_canonical = "https://homecarecreators.com/home-care-franchise-seo/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "Home Care Franchise SEO for Owners | Homecare Creators";
$page_desc  = "Local SEO, Google Maps, content, citations and social media for home care franchise owners. Rank in your territory within brand rules. Free audit.";
$og_title   = "Home Care Franchise SEO That Wins Your Territory | Homecare Creators";
$og_desc    = "Google Maps, reviews, citations, local content and AI search visibility for home care franchise owners, built inside your franchisor's brand rules.";
$og_image   = "https://homecarecreators.com/images/team/team-presenting-results-screen.jpg";

$case_studies = require __DIR__ . '/../includes/case-studies-data.php';

$faqs = [
    ['Will this break my franchise agreement or brand rules?', "No. We work inside your franchisor's brand guidelines and only touch what you're allowed to manage. If something needs corporate approval, we prepare it for you to submit."],
    ['Corporate already does marketing. Why do I need this?', 'Corporate marketing builds the national brand. Local rankings — your Google Maps profile, reviews and listings — are usually the owner\'s job, and they drive most local calls.'],
    ['I own more than one territory. How does pricing work?', 'Each territory gets its own profile work and its own report. Every additional territory on the same package gets 20% off.'],
    ['Is social media included?', 'Social media management is an add-on for $397/month per territory. You can add it to any package at any time.'],
    ['How long until I see results?', 'Google Business Profile improvements usually show in about 30 days. Broader ranking and lead gains usually come in 60–90 days.'],
    ['Do you also help with caregiver recruitment?', 'Yes. Active social pages and a strong local profile help caregivers find and trust you too. Ask about recruitment content during your audit.'],
    ['Is there a long contract?', "The first 90 days are the starting term. After that, it's month-to-month. Annual plans get an extra discount."],
    ['What is AI search optimization?', 'It helps your location appear when families ask ChatGPT, Google AI Overviews or Perplexity for home care in your area.'],
];

$page_css = <<<CSS
/* HERO */
.hero{min-height:84vh;background:var(--forest);position:relative;overflow:hidden;display:grid;grid-template-columns:minmax(0,1.2fr) minmax(0,.8fr);gap:56px;align-items:center;padding:120px 80px 80px}
.hero-content{position:relative;z-index:2;min-width:0}
.hero-kicker{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:1.6px;text-transform:uppercase;color:var(--mint);margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(30px,3.3vw,48px);line-height:1.46;color:#fff;margin-bottom:22px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:19px;line-height:1.78;color:rgba(255,255,255,.68);max-width:580px;margin-bottom:36px;animation:fadeUp .8s .25s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .38s ease both;margin-bottom:18px}
.hero-note{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:rgba(255,255,255,.5);margin-bottom:44px}
.hero-facts{display:flex;gap:0;border-top:1px solid rgba(255,255,255,.12);padding-top:24px;max-width:580px}
.hero-fact{flex:1;padding-right:20px}
.hero-fact + .hero-fact{padding-left:20px;border-left:1px solid rgba(255,255,255,.12)}
.hero-fact-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;font-weight:700;color:#fff;line-height:1.1}
.hero-fact-label{font-size:13px;color:rgba(255,255,255,.5);margin-top:4px;line-height:1.4}
.hero-media{position:relative;z-index:2;animation:fadeIn .8s .2s ease both}
.hero-media-img{width:100%;aspect-ratio:4/4.3;object-fit:cover;object-position:center 25%;display:block;border-radius:24px}
.hero-media-card{position:absolute;left:-28px;bottom:32px;background:#fff;border-radius:14px;padding:14px 18px;display:flex;align-items:center;gap:12px;max-width:290px}
.hero-media-card-icon{width:38px;height:38px;border-radius:10px;background:rgba(29,158,117,.12);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:16px;flex-shrink:0}
.hero-media-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest)}
.hero-media-card-sub{font-size:12px;color:var(--muted);margin-top:2px}

/* CORPORATE VS TERRITORY */
.split-section{background:#fff}
.split{display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:start}
.split p.lead{font-size:18px;line-height:1.8;color:var(--muted);margin-bottom:18px}
.compare{border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;background:var(--warm)}
.compare-head{display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid var(--border)}
.compare-head div{padding:18px 22px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--muted)}
.compare-head div:last-child{color:var(--teal);border-left:1px solid var(--border);background:#fff}
.compare-row{display:grid;grid-template-columns:1fr 1fr;border-bottom:1px solid var(--border)}
.compare-row:last-child{border-bottom:none}
.compare-row div{padding:16px 22px;font-size:15px;line-height:1.55;color:var(--text)}
.compare-row div:first-child{color:var(--muted)}
.compare-row div:last-child{border-left:1px solid var(--border);background:#fff;font-weight:500}
.compare-foot{padding:18px 22px;background:var(--forest);color:rgba(255,255,255,.8);font-size:15px;line-height:1.6}
.compare-foot strong{color:#fff}

/* RULES */
.rules-section{background:var(--cream)}
.rules{display:grid;grid-template-columns:.85fr 1.15fr;gap:72px;align-items:center}
.rules-img{width:100%;aspect-ratio:4/4.4;object-fit:cover;object-position:center 30%;border-radius:var(--r-lg);display:block}
.rules-points{margin-top:32px;display:flex;flex-direction:column}
.rules-point{display:grid;grid-template-columns:44px 1fr;gap:16px;padding:20px 0;border-top:1px solid var(--border)}
.rules-point:last-child{border-bottom:1px solid var(--border)}
.rules-point i{width:44px;height:44px;border-radius:12px;background:#fff;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:17px}
.rules-point h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--forest);margin-bottom:4px}
.rules-point p{font-size:15px;color:var(--muted);line-height:1.65}

/* SERVICES */
.svc-section{background:#fff}
.svc-head{display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:end;margin-bottom:56px}
.svc-head p{font-size:18px;line-height:1.8;color:var(--muted)}
.svc-list{display:grid;grid-template-columns:1fr 1fr;border-top:1px solid var(--border)}
.svc-item{display:grid;grid-template-columns:56px 1fr;gap:18px;padding:30px 28px 30px 0;border-bottom:1px solid var(--border)}
.svc-item:nth-child(even){padding-left:28px;border-left:1px solid var(--border)}
.svc-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--teal);padding-top:3px}
.svc-item h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:700;color:var(--forest);margin-bottom:8px;display:flex;align-items:center;gap:10px;flex-wrap:wrap}
.svc-item p{font-size:15.5px;color:var(--muted);line-height:1.7}
.tag{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:#8a6d1f;background:rgba(201,168,76,.16);padding:4px 9px;border-radius:6px}

/* RESULTS */
.results-section{background:var(--forest)}
.results-section .section-h2{color:#fff}
.results-section .section-label{color:var(--teal-lt)}
.results-section .section-label::before{background:var(--teal-lt)}
.results-head{display:flex;justify-content:space-between;align-items:end;gap:40px;margin-bottom:40px;flex-wrap:wrap}
.results-head p{font-size:17px;color:rgba(255,255,255,.62);line-height:1.75;max-width:520px}
.results-table{width:100%;border-collapse:collapse}
.results-table th{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.4px;text-transform:uppercase;color:rgba(255,255,255,.45);text-align:left;padding:0 0 14px;border-bottom:1px solid rgba(255,255,255,.14)}
.results-table th.num,.results-table td.num{text-align:right}
.results-table td{padding:20px 0;border-bottom:1px solid rgba(255,255,255,.1);color:#fff;font-size:16px}
.results-table td small{display:block;color:rgba(255,255,255,.45);font-size:13px;margin-top:3px}
.results-table td.num{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:700;color:var(--teal-lt)}
.results-table td.num.calls{color:#fff}
.results-link{display:inline-flex;align-items:center;gap:8px;margin-top:28px;color:var(--teal-lt);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;text-decoration:none}
.results-link:hover{color:#fff}

/* TESTIMONIALS */
.quotes-section{background:var(--cream)}
.quotes{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:48px}
.quote{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px;display:flex;flex-direction:column}
.quote-stars{color:var(--gold);font-size:14px;letter-spacing:2px;margin-bottom:16px}
.quote p{font-size:17px;line-height:1.75;color:var(--text);flex:1;margin-bottom:24px}
.quote-who{display:flex;align-items:center;gap:12px;padding-top:20px;border-top:1px solid var(--border)}
.quote-avatar{width:40px;height:40px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700}
.quote-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest)}
.quote-role{font-size:13px;color:var(--muted)}

/* BRANDS */
.brands-section{background:#fff;padding:80px 40px}
.brands{display:grid;grid-template-columns:.8fr 1.2fr;gap:64px;align-items:start}
.brands p.lead{font-size:17px;line-height:1.75;color:var(--muted)}
.brand-list{display:flex;flex-wrap:wrap;gap:10px}
.brand-list span{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:600;color:var(--forest);border:1px solid var(--border);border-radius:100px;padding:10px 18px;background:var(--warm)}
.brand-disclaimer{font-size:12.5px;color:var(--muted);line-height:1.6;margin-top:22px}

/* PRICING */
.pricing-section{background:var(--warm);border-top:1px solid var(--border)}
.pricing-head{text-align:center;max-width:720px;margin:0 auto 56px}
.pricing-head .section-label{justify-content:center}
.pricing-head .section-sub{margin:0 auto}
.plans{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;align-items:stretch}
.plan{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:34px 30px;display:flex;flex-direction:column;position:relative}
.plan.featured{border:2px solid var(--teal)}
.plan-flag{position:absolute;top:-13px;left:30px;background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:5px 12px;border-radius:6px}
.plan-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:700;color:var(--forest)}
.plan-for{font-size:14.5px;color:var(--muted);margin:6px 0 22px;line-height:1.5;min-height:44px}
.plan-price{font-family:'Plus Jakarta Sans',sans-serif;font-size:44px;font-weight:700;color:var(--forest);line-height:1}
.plan-price span{font-size:15px;font-weight:500;color:var(--muted)}
.plan-unit{font-size:13px;color:var(--muted);margin:8px 0 24px}
.plan-intro{font-size:14.5px;font-weight:600;color:var(--forest);padding:16px 0;border-top:1px solid var(--border);line-height:1.55}
.plan ul{list-style:none;display:flex;flex-direction:column;gap:11px;flex:1;margin-bottom:28px}
.plan li{display:grid;grid-template-columns:18px 1fr;gap:10px;font-size:14.5px;color:var(--text);line-height:1.55}
.plan li i{color:var(--teal);font-size:13px;margin-top:4px}
.plan-btn{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;padding:15px;border-radius:11px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;cursor:pointer;border:1.5px solid var(--forest);background:#fff;color:var(--forest);transition:background .2s,color .2s}
.plan-btn:hover{background:var(--forest);color:#fff}
.plan.featured .plan-btn{background:var(--teal);border-color:var(--teal);color:#fff}
.plan.featured .plan-btn:hover{background:#17875f;border-color:#17875f}

.compare-wrap{margin-top:56px;background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden}
.compare-toggle{width:100%;display:flex;justify-content:space-between;align-items:center;padding:22px 28px;background:none;border:none;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--forest)}
.compare-toggle i{transition:transform .25s;color:var(--teal)}
.compare-wrap.open .compare-toggle i{transform:rotate(180deg)}
.compare-body{display:none;overflow-x:auto;border-top:1px solid var(--border)}
.compare-wrap.open .compare-body{display:block}
.ptable{width:100%;border-collapse:collapse;min-width:640px}
.ptable th,.ptable td{padding:15px 20px;text-align:center;font-size:14.5px;border-bottom:1px solid var(--border)}
.ptable th{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;color:var(--forest);background:var(--warm)}
.ptable td:first-child,.ptable th:first-child{text-align:left;color:var(--text)}
.ptable td.hl,.ptable th.hl{background:rgba(29,158,117,.06)}
.ptable .yes{color:var(--teal)}
.ptable .no{color:#b8c2ba}
.ptable tr:last-child td{border-bottom:none}

.addons{display:grid;grid-template-columns:1.3fr 1fr;gap:24px;margin-top:24px}
.addon-card{background:var(--forest);border-radius:var(--r-lg);padding:32px;color:#fff}
.addon-top{display:flex;justify-content:space-between;align-items:baseline;gap:16px;flex-wrap:wrap;margin-bottom:6px}
.addon-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:700}
.addon-price{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:700;color:var(--teal-lt)}
.addon-price span{font-size:14px;color:rgba(255,255,255,.55);font-weight:500}
.addon-card > p{font-size:14.5px;color:rgba(255,255,255,.6);margin-bottom:20px}
.addon-card ul{list-style:none;display:grid;grid-template-columns:1fr 1fr;gap:10px 22px}
.addon-card li{display:grid;grid-template-columns:16px 1fr;gap:10px;font-size:14px;color:rgba(255,255,255,.82);line-height:1.5}
.addon-card li i{color:var(--teal-lt);font-size:12px;margin-top:4px}
.extras{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:8px 28px}
.extra{display:flex;justify-content:space-between;gap:16px;padding:18px 0;border-bottom:1px solid var(--border)}
.extra:last-child{border-bottom:none}
.extra-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest)}
.extra-desc{font-size:13.5px;color:var(--muted);margin-top:3px;line-height:1.5}
.extra-val{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--teal);white-space:nowrap}

.terms{display:flex;justify-content:center;gap:12px 32px;flex-wrap:wrap;margin-top:36px}
.terms span{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:600;color:var(--forest)}
.terms i{color:var(--teal)}
.payback{max-width:760px;margin:36px auto 0;text-align:center;font-size:17px;line-height:1.75;color:var(--muted)}
.payback strong{color:var(--forest)}
.pricing-cta{text-align:center;margin-top:28px}

/* PROCESS */
.process-section{background:#fff}
.steps{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:52px;border-top:2px solid var(--forest)}
.step{padding:28px 26px 0 0}
.step + .step{padding-left:26px;border-left:1px solid var(--border)}
.step-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--teal);letter-spacing:1px;margin-bottom:14px}
.step h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:700;color:var(--forest);margin-bottom:4px}
.step-when{font-size:13px;font-weight:600;color:var(--muted);margin-bottom:12px}
.step p{font-size:15px;color:var(--muted);line-height:1.7}
.process-note{margin-top:44px;padding:20px 24px;background:var(--cream);border-radius:var(--r);font-size:16px;color:var(--forest);display:flex;gap:12px;align-items:center}
.process-note i{color:var(--teal)}

/* WHY */
.why-section{background:var(--cream)}
.why{display:grid;grid-template-columns:1.1fr .9fr;gap:72px;align-items:center}
.why-list{margin-top:32px;display:flex;flex-direction:column;gap:24px}
.why-item h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:700;color:var(--forest);margin-bottom:6px}
.why-item p{font-size:15.5px;color:var(--muted);line-height:1.7}
.why-img{width:100%;aspect-ratio:4/4.6;object-fit:cover;border-radius:var(--r-lg);display:block}
.creds{display:flex;flex-wrap:wrap;gap:8px;margin-top:10px}
.creds span{font-size:12.5px;font-weight:600;color:var(--forest);background:#fff;border:1px solid var(--border);border-radius:6px;padding:6px 10px}

/* FAQ */
.faq-section{background:#fff}
.faq-wrap{display:grid;grid-template-columns:.8fr 1.2fr;gap:64px;align-items:start}
.faq-list{display:flex;flex-direction:column;gap:12px}

/* RELATED */
.related-section{background:var(--cream);padding:64px 40px}
.related{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-top:28px}
.related a{display:flex;align-items:center;gap:12px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:18px 20px;text-decoration:none;transition:border-color .2s}
.related a:hover{border-color:var(--teal)}
.related i{font-size:18px;color:var(--teal)}
.related-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--forest)}
.related-sub{font-size:12.5px;color:var(--muted)}

/* CTA */
.cta-section{background:var(--forest);padding:96px 40px}
.cta-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.cta-content .section-label{color:var(--teal-lt)}
.cta-content .section-label::before{background:var(--teal-lt)}
.cta-content .section-h2{color:#fff}
.cta-desc{font-size:18px;color:rgba(255,255,255,.68);line-height:1.78;margin-bottom:28px}
.cta-checks{list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:32px}
.cta-checks li{display:flex;gap:10px;align-items:center;font-size:15.5px;color:rgba(255,255,255,.82)}
.cta-checks i{color:var(--teal-lt)}
.cta-guarantee{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;color:rgba(255,255,255,.5);margin-top:18px}
.cta-image{position:relative;border-radius:var(--r-lg);overflow:hidden}
.cta-image img{width:100%;height:520px;object-fit:cover;object-position:center 28%;display:block}
.cta-image-cap{position:absolute;left:20px;bottom:20px;background:#fff;border-radius:12px;padding:12px 16px}
.cta-image-cap strong{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;color:var(--forest)}
.cta-image-cap span{font-size:12.5px;color:var(--muted)}

/* RESPONSIVE */
@media(max-width:1024px){
  .hero{padding:110px 40px 64px;grid-template-columns:1fr;gap:44px}
  .hero-media{max-width:460px;width:100%}
  .hero-media-card{left:16px}
  .split,.rules,.svc-head,.why,.faq-wrap,.brands,.cta-inner{grid-template-columns:1fr;gap:40px}
  .plans{grid-template-columns:1fr;max-width:520px;margin:0 auto}
  .addons{grid-template-columns:1fr}
  .steps{grid-template-columns:1fr 1fr}
  .step:nth-child(3){padding-left:0;border-left:none}
  .step{padding-bottom:28px}
  .related{grid-template-columns:1fr 1fr}
  .rules-img,.why-img{max-width:520px;aspect-ratio:4/3.4}
}
@media(max-width:640px){
  .hero{padding:100px 24px 56px}
  .hero-facts{flex-direction:column;gap:14px}
  .hero-fact + .hero-fact{padding-left:0;border-left:none}
  .svc-list,.quotes,.related{grid-template-columns:1fr}
  .svc-item,.svc-item:nth-child(even){padding:26px 0;border-left:none}
  .steps{grid-template-columns:1fr}
  .step + .step{padding-left:0;border-left:none;border-top:1px solid var(--border)}
  .addon-card ul{grid-template-columns:1fr}
  .results-table th.hide,.results-table td.hide{display:none}
  .results-table td.num{font-size:22px}
  .compare-row div,.compare-head div{padding:14px 14px;font-size:14px}
  .brands-section,.related-section{padding:56px 24px}
  .cta-section{padding:64px 24px}
  .cta-image img{height:400px}
}
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-content">
    <div class="hero-breadcrumb"><a href="https://homecarecreators.com">Home</a> / <span>Home Care Franchise SEO</span></div>
    <p class="hero-kicker">For home care franchise owners</p>
    <h1 class="hero-h1">Home Care Franchise SEO That<br>Wins <em>Your Territory</em></h1>
    <p class="hero-desc">You bought the franchise for the brand. But families don't search for the brand — they search "home care near me." Our home care franchise SEO package helps owners like you show up first on Google Maps, Google search and AI tools like ChatGPT in your own territory, without breaking your franchisor's brand rules.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup('audit')">Book Free Territory Audit <i class="fa-solid fa-arrow-right" style="font-size:13px"></i></button>
      <a href="#pricing" class="btn-secondary">See Pricing</a>
    </div>
    <p class="hero-note">No cost, no obligation. Month-to-month after the first 90 days.</p>
    <div class="hero-facts">
      <div class="hero-fact"><div class="hero-fact-num">100%</div><div class="hero-fact-label">Home care &amp; senior care clients</div></div>
      <div class="hero-fact"><div class="hero-fact-num">~30 days</div><div class="hero-fact-label">To first Google profile gains</div></div>
      <div class="hero-fact"><div class="hero-fact-num">Per territory</div><div class="hero-fact-label">Work, reporting &amp; pricing</div></div>
    </div>
  </div>
  <div class="hero-media">
    <img class="hero-media-img" src="/images/team/team-presenting-results-screen.jpg" alt="Homecare Creators team presenting Google Maps ranking results for a home care franchise territory" width="765" height="1024" fetchpriority="high">
    <div class="hero-media-card">
      <div class="hero-media-card-icon"><i class="fa-solid fa-map-location-dot"></i></div>
      <div>
        <div class="hero-media-card-title">Free Territory SEO Audit</div>
        <div class="hero-media-card-sub">Maps · Reviews · Listings · AI search</div>
      </div>
    </div>
  </div>
</section>

<!-- CERTIFICATIONS -->
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

<!-- CORPORATE VS TERRITORY -->
<section class="split-section">
  <div class="container">
    <div class="split">
      <div data-reveal>
        <p class="section-label">The Franchise Gap</p>
        <h2 class="section-h2">Corporate builds the brand. <em>Your territory is up to you.</em></h2>
        <p class="lead">Your franchisor runs the national website and national campaigns. But the local results that bring calls into your office depend on things corporate usually leaves to you.</p>
        <p class="lead">Another owner in the next territory, or an independent agency down the street, is competing for the same families. We help you win that local race.</p>
      </div>
      <div class="compare" data-reveal style="transition-delay:.12s">
        <div class="compare-head"><div>Corporate handles</div><div>Usually left to you</div></div>
        <div class="compare-row"><div>National website</div><div>Your Google Business Profile ranking in your service area</div></div>
        <div class="compare-row"><div>Brand reputation</div><div>How many reviews you have, and how fast you reply</div></div>
        <div class="compare-row"><div>Brand identity</div><div>Your name, address and phone being correct across directories</div></div>
        <div class="compare-row"><div>National campaigns</div><div>Social pages that look active and trustworthy to families</div></div>
        <div class="compare-row"><div>Brand awareness</div><div>Showing up when someone asks ChatGPT or Google AI for home care in your city</div></div>
        <div class="compare-foot"><strong>The right column drives most local calls.</strong> That's where we work.</div>
      </div>
    </div>
  </div>
</section>

<!-- BRAND RULES -->
<section class="rules-section">
  <div class="container">
    <div class="rules">
      <img class="rules-img" src="/images/team/team-reviewing-laptop-collaboration.jpg" alt="Homecare Creators team reviewing a franchise owner's Google Business Profile against brand guidelines" width="765" height="1024" loading="lazy" data-reveal>
      <div data-reveal style="transition-delay:.12s">
        <p class="section-label">Brand-Safe SEO</p>
        <h2 class="section-h2">Built for franchise rules, <em>not against them</em></h2>
        <p class="section-sub">Most owners can't freely edit their website — corporate controls the location pages. So our work focuses on what you are allowed to control, and we follow your brand guidelines on every post, profile and listing.</p>
        <div class="rules-points">
          <div class="rules-point"><i class="fa-solid fa-book-open"></i><div><h3>Your brand guidelines, followed</h3><p>Every post, profile and listing uses your approved name, colors and voice.</p></div></div>
          <div class="rules-point"><i class="fa-solid fa-sliders"></i><div><h3>Only what you control</h3><p>We focus on your Google profile, reviews, listings, content and social pages.</p></div></div>
          <div class="rules-point"><i class="fa-solid fa-file-signature"></i><div><h3>We prepare it, you send it</h3><p>If something needs corporate approval, we prepare it and you send it.</p></div></div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="svc-section">
  <div class="container">
    <div class="svc-head" data-reveal>
      <div>
        <p class="section-label">What We Do</p>
        <h2 class="section-h2">What we do for <em>franchise owners</em></h2>
      </div>
      <p>Seven pieces of local work, managed by one team and reported per territory — so you know exactly what moved and why.</p>
    </div>
    <div class="svc-list" data-reveal style="transition-delay:.1s">
      <div class="svc-item"><div class="svc-num">01</div><div><h3>Google Business Profile optimization</h3><p>Full profile setup and cleanup, correct categories and service areas, weekly posts, photos and Q&amp;A — so you rank in the Google Maps "3-pack" for your territory.</p></div></div>
      <div class="svc-item"><div class="svc-num">02</div><div><h3>Review generation and responses</h3><p>A simple system to ask happy families for reviews, plus professional replies to every review, good or bad.</p></div></div>
      <div class="svc-item"><div class="svc-num">03</div><div><h3>Local citations</h3><p>We build and clean up your listings on the directories that matter for home care, and fix duplicate or wrong listings — a common problem with franchise locations.</p></div></div>
      <div class="svc-item"><div class="svc-num">04</div><div><h3>Local content</h3><p>Four content pieces a month written for families in your territory: local care guides, service explainers and GBP posts, written in your brand voice.</p></div></div>
      <div class="svc-item"><div class="svc-num">05</div><div><h3>Social media management <span class="tag">Add-on</span></h3><p>Three to four posts a week on Facebook and Instagram, so families and caregivers see an active, caring local team. Add it to any package.</p></div></div>
      <div class="svc-item"><div class="svc-num">06</div><div><h3>AI search visibility (GEO)</h3><p>We help your location appear in ChatGPT, Google AI Overviews and Perplexity answers for home care in your area.</p></div></div>
      <div class="svc-item"><div class="svc-num">07</div><div><h3>Monthly reporting</h3><p>One clear report: rankings, calls, direction requests, reviews and social growth, per territory.</p></div></div>
      <div class="svc-item"><div class="svc-num"><i class="fa-solid fa-arrow-right"></i></div><div><h3>Not sure where to start?</h3><p>The free territory audit shows which of these will move the needle first in your market. <a href="#" onclick="openPopup('audit');return false" style="color:var(--teal);font-weight:600">Book your audit</a>.</p></div></div>
    </div>
  </div>
</section>

<!-- RESULTS -->
<section class="results-section">
  <div class="container">
    <div class="results-head" data-reveal>
      <div>
        <p class="section-label">Results</p>
        <h2 class="section-h2">Results we've driven for <em>home care providers</em></h2>
      </div>
      <p>We work only with home care and senior care — 100% of our clients are in this industry. Recent results:</p>
    </div>
    <table class="results-table" data-reveal style="transition-delay:.1s">
      <thead><tr><th>Client</th><th class="hide">Focus</th><th class="num">Leads</th><th class="num">Phone calls</th></tr></thead>
      <tbody>
      <?php foreach ($case_studies as $cs): ?>
        <tr>
          <td><?= htmlspecialchars($cs['name']) ?><?php if ($cs['region']): ?><small><?= htmlspecialchars($cs['region']) ?></small><?php endif; ?></td>
          <td class="hide" style="color:rgba(255,255,255,.55);font-size:14px"><?= htmlspecialchars(implode(' · ', array_slice($cs['strategy'], 0, 2))) ?></td>
          <td class="num"><?= htmlspecialchars($cs['stats'][0][0]) ?></td>
          <td class="num calls"><?= htmlspecialchars($cs['stats'][1][0]) ?></td>
        </tr>
      <?php endforeach; ?>
      </tbody>
    </table>
    <a href="/case-studies/" class="results-link">View all case studies <i class="fa-solid fa-arrow-right"></i></a>
  </div>
</section>

<!-- TESTIMONIALS -->
<section class="quotes-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Owner Reviews</p>
      <h2 class="section-h2">What home care <em>owners say</em></h2>
    </div>
    <div class="quotes" data-reveal style="transition-delay:.1s">
      <div class="quote">
        <div class="quote-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p>"We had 6 Google reviews before Homecare Creators and almost no website traffic to speak of. Four months later we're at 52 reviews, ranked #1 in our city, and our inquiry calls have tripled. Worth every penny."</p>
        <div class="quote-who"><div class="quote-avatar">SR</div><div><div class="quote-name">Sarah R.</div><div class="quote-role">Owner, Comfort Home Care · Chicago, IL</div></div></div>
      </div>
      <div class="quote">
        <div class="quote-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p>"Zero to 28 private-pay clients in 7 months. The website redesign paired with local SEO is genuinely a powerful combination, and the monthly strategy calls keep us honest."</p>
        <div class="quote-who"><div class="quote-avatar">TW</div><div><div class="quote-name">Tamara W.</div><div class="quote-role">Owner, Sunrise Senior Care · Phoenix, AZ</div></div></div>
      </div>
      <div class="quote">
        <div class="quote-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p>"Three months in, a family told us they found us through ChatGPT. I was floored, honestly. This team is ahead of the curve, and homecare is the only thing they do."</p>
        <div class="quote-who"><div class="quote-avatar">AC</div><div><div class="quote-name">Angela C.</div><div class="quote-role">Director, CareFirst Agency · Miami, FL</div></div></div>
      </div>
      <div class="quote">
        <div class="quote-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <p>"The follow-up automation alone paid for the retainer. Leads used to sit for days, now they get a response in minutes, day or night."</p>
        <div class="quote-who"><div class="quote-avatar">RB</div><div><div class="quote-name">Robert B.</div><div class="quote-role">CEO, Premier Home Health · Dallas, TX</div></div></div>
      </div>
    </div>
  </div>
</section>

<!-- BRANDS -->
<section class="brands-section">
  <div class="container">
    <div class="brands">
      <div data-reveal>
        <p class="section-label">Franchise Systems</p>
        <h2 class="section-h2" style="font-size:clamp(28px,3.2vw,40px)">Franchise brands <em>we understand</em></h2>
        <p class="lead">We know how the major home care franchise systems work, including their territory setups and brand guidelines. We help owners of locations such as:</p>
      </div>
      <div data-reveal style="transition-delay:.1s">
        <div class="brand-list">
          <span>Home Instead</span><span>Visiting Angels</span><span>Right at Home</span><span>Comfort Keepers</span><span>Senior Helpers</span><span>BrightStar Care</span><span>Seniors Helping Seniors</span><span>FirstLight Home Care</span><span>Griswold Home Care</span><span>Always Best Care</span><span>Amada Senior Care</span><span>Assisting Hands</span>
        </div>
        <p class="brand-disclaimer">Homecare Creators is an independent marketing agency. We are not affiliated with, endorsed by or sponsored by any of the franchise brands named on this page. All trademarks belong to their owners.</p>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="pricing-section" id="pricing">
  <div class="container">
    <div class="pricing-head" data-reveal>
      <p class="section-label">Pricing</p>
      <h2 class="section-h2">Simple, <em>per-territory</em> pricing</h2>
      <p class="section-sub">Three packages, one partner for local growth, and social media whenever you want it.</p>
    </div>

    <div class="plans" data-reveal style="transition-delay:.1s">
      <div class="plan">
        <div class="plan-name">Starter</div>
        <div class="plan-for">New owners who need to get found on Google Maps</div>
        <div class="plan-price">$697<span>/month</span></div>
        <div class="plan-unit">per territory</div>
        <div class="plan-intro">Get found on Google Maps in your territory.</div>
        <ul>
          <li><i class="fa-solid fa-check"></i>Full Google Business Profile audit and optimization: categories, services, service areas, business description, hours and attributes, all within your brand guidelines</li>
          <li><i class="fa-solid fa-check"></i>4 Google Business Profile posts a month (one a week)</li>
          <li><i class="fa-solid fa-check"></i>5 new photos a month added to your profile</li>
          <li><i class="fa-solid fa-check"></i>Google Q&amp;A set up with common family questions and answers</li>
          <li><i class="fa-solid fa-check"></i>Replies to every new Google review within 48 hours</li>
          <li><i class="fa-solid fa-check"></i>Core citations: your name, address and phone made correct on the top 20 directories (Google, Bing, Apple Maps, Yelp, Facebook and more)</li>
          <li><i class="fa-solid fa-check"></i>Duplicate or wrong listing removal</li>
          <li><i class="fa-solid fa-check"></i>Monthly report: Maps rankings, calls, direction requests, website clicks and reviews</li>
        </ul>
        <button class="plan-btn" onclick="openPopup('audit')">Start with a Free Audit</button>
      </div>

      <div class="plan featured">
        <div class="plan-flag">Most popular</div>
        <div class="plan-name">Growth</div>
        <div class="plan-for">Owners ready to grow calls and leads</div>
        <div class="plan-price">$1,097<span>/month</span></div>
        <div class="plan-unit">per territory</div>
        <div class="plan-intro">Everything in Starter, plus more reviews, content and AI visibility.</div>
        <ul>
          <li><i class="fa-solid fa-check"></i>8 Google Business Profile posts a month (two a week)</li>
          <li><i class="fa-solid fa-check"></i>Review generation system: text and email review requests with QR code cards for your caregivers and office team</li>
          <li><i class="fa-solid fa-check"></i>Replies to every review on Google, Facebook and Yelp</li>
          <li><i class="fa-solid fa-check"></i>Full citation build: 50+ directories, including senior care and home care directories (Caring.com, A Place for Mom, SeniorAdvisor and others)</li>
          <li><i class="fa-solid fa-check"></i>4 local content pieces a month: local care guides, service explainers and city-focused articles in your brand voice, ready for your blog or for corporate approval</li>
          <li><i class="fa-solid fa-check"></i>AI search visibility: profile and content set up so ChatGPT, Google AI Overviews and Perplexity can recommend your location</li>
          <li><i class="fa-solid fa-check"></i>Local keyword rank tracking (up to 20 keywords)</li>
          <li><i class="fa-solid fa-check"></i>Monthly report with what we did, what changed and next month's plan</li>
        </ul>
        <button class="plan-btn" onclick="openPopup('audit')">Book Free Territory Audit <i class="fa-solid fa-arrow-right" style="font-size:12px"></i></button>
      </div>

      <div class="plan">
        <div class="plan-name">Premium</div>
        <div class="plan-for">Competitive markets and multi-territory owners</div>
        <div class="plan-price">$1,597<span>/month</span></div>
        <div class="plan-unit">per territory</div>
        <div class="plan-intro">Everything in Growth, built for competitive markets and multi-territory owners.</div>
        <ul>
          <li><i class="fa-solid fa-check"></i>12 Google Business Profile posts a month (three a week)</li>
          <li><i class="fa-solid fa-check"></i>8 local content pieces a month</li>
          <li><i class="fa-solid fa-check"></i>Local competitor tracking: see how you compare with the top 3 competitors in your territory every month</li>
          <li><i class="fa-solid fa-check"></i>Caregiver recruitment content: 2 hiring posts a month and job listing optimization to help you attract caregivers</li>
          <li><i class="fa-solid fa-check"></i>Quarterly citation audit to catch new wrong or duplicate listings</li>
          <li><i class="fa-solid fa-check"></i>Rank tracking for up to 50 keywords, with a Maps ranking grid for your whole territory</li>
          <li><i class="fa-solid fa-check"></i>Monthly 30-minute strategy call</li>
          <li><i class="fa-solid fa-check"></i>Priority support: replies within 1 business day</li>
        </ul>
        <button class="plan-btn" onclick="openPopup('audit')">Talk to Us About Premium</button>
      </div>
    </div>

    <div class="compare-wrap" data-reveal>
      <button class="compare-toggle" onclick="this.parentElement.classList.toggle('open')" aria-expanded="false">Compare all plan features <i class="fa-solid fa-chevron-down"></i></button>
      <div class="compare-body">
        <table class="ptable">
          <thead><tr><th>Feature</th><th>Starter</th><th class="hl">Growth</th><th>Premium</th></tr></thead>
          <tbody>
            <tr><td>Price per territory</td><td>$697/mo</td><td class="hl">$1,097/mo</td><td>$1,597/mo</td></tr>
            <tr><td>Google Business Profile optimization + weekly posts</td><td><i class="fa-solid fa-check yes"></i></td><td class="hl"><i class="fa-solid fa-check yes"></i></td><td><i class="fa-solid fa-check yes"></i></td></tr>
            <tr><td>Replies to every review</td><td><i class="fa-solid fa-check yes"></i></td><td class="hl"><i class="fa-solid fa-check yes"></i></td><td><i class="fa-solid fa-check yes"></i></td></tr>
            <tr><td>Review generation system</td><td><span class="no">—</span></td><td class="hl"><i class="fa-solid fa-check yes"></i></td><td><i class="fa-solid fa-check yes"></i></td></tr>
            <tr><td>Local citations</td><td>Core listings</td><td class="hl">Full build and cleanup</td><td>Full build, cleanup + quarterly audit</td></tr>
            <tr><td>Local content pieces per month</td><td><span class="no">—</span></td><td class="hl">4</td><td>8</td></tr>
            <tr><td>AI search visibility (ChatGPT, Google AI)</td><td><span class="no">—</span></td><td class="hl"><i class="fa-solid fa-check yes"></i></td><td><i class="fa-solid fa-check yes"></i></td></tr>
            <tr><td>Local competitor tracking</td><td><span class="no">—</span></td><td class="hl"><span class="no">—</span></td><td><i class="fa-solid fa-check yes"></i></td></tr>
            <tr><td>Caregiver recruitment content</td><td><span class="no">—</span></td><td class="hl"><span class="no">—</span></td><td><i class="fa-solid fa-check yes"></i></td></tr>
            <tr><td>Monthly report per territory</td><td><i class="fa-solid fa-check yes"></i></td><td class="hl"><i class="fa-solid fa-check yes"></i></td><td><i class="fa-solid fa-check yes"></i></td></tr>
          </tbody>
        </table>
      </div>
    </div>

    <div class="addons">
      <div class="addon-card" data-reveal>
        <div class="addon-top"><h3>Social Media Add-on</h3><div class="addon-price">+$397<span>/month per territory</span></div></div>
        <p>Available with any package.</p>
        <ul>
          <li><i class="fa-solid fa-check"></i>12–16 posts a month on Facebook and Instagram (3–4 a week)</li>
          <li><i class="fa-solid fa-check"></i>Custom branded graphics that follow your franchise brand guidelines</li>
          <li><i class="fa-solid fa-check"></i>Care tips, team spotlights, review highlights, local community posts and hiring posts</li>
          <li><i class="fa-solid fa-check"></i>Captions and hashtags written for families in your area</li>
          <li><i class="fa-solid fa-check"></i>Monthly content calendar sent to you for approval before posting</li>
          <li><i class="fa-solid fa-check"></i>Monthly social report: reach, engagement and follower growth</li>
        </ul>
      </div>
      <div class="extras" data-reveal style="transition-delay:.1s">
        <div class="extra"><div><div class="extra-name">Extra territories</div><div class="extra-desc">On the same package</div></div><div class="extra-val">20% off each</div></div>
        <div class="extra"><div><div class="extra-name">One-time setup</div><div class="extra-desc">Audit, citation cleanup, GBP setup and fixes</div></div><div class="extra-val">$497</div></div>
        <div class="extra"><div><div class="extra-name">Annual commitment</div><div class="extra-desc">Pay yearly, save more</div></div><div class="extra-val">Extra discount</div></div>
      </div>
    </div>

    <div class="terms">
      <span><i class="fa-solid fa-calendar-check"></i>Month-to-month after the first 90 days</span>
      <span><i class="fa-solid fa-tag"></i>Extra discount for annual commitment</span>
      <span><i class="fa-solid fa-shield-halved"></i>30-day satisfaction guarantee</span>
    </div>
    <p class="payback"><strong>Why it pays for itself:</strong> one new private-pay client can stay with your agency for many months. If our work brings you even one extra client, the package has more than paid for itself.</p>
    <div class="pricing-cta"><button class="btn-primary" onclick="openPopup('audit')">Book Free Territory Audit <i class="fa-solid fa-arrow-right" style="font-size:13px"></i></button></div>
  </div>
</section>

<!-- PROCESS -->
<section class="process-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">How It Works</p>
      <h2 class="section-h2">From audit to <em>more local calls</em></h2>
    </div>
    <div class="steps" data-reveal style="transition-delay:.1s">
      <div class="step"><div class="step-num">STEP 01</div><h3>Free Territory Audit</h3><div class="step-when">Week 1</div><p>We check your Google Business Profile, reviews, listings, local competitors and website speed, then give you a 90-day growth roadmap.</p></div>
      <div class="step"><div class="step-num">STEP 02</div><h3>Setup</h3><div class="step-when">First 30 days</div><p>We fix your profile, clean up citations and set up your social pages and review system.</p></div>
      <div class="step"><div class="step-num">STEP 03</div><h3>Grow</h3><div class="step-when">Days 30–90</div><p>Weekly posts, content, reviews and social media start building your rankings.</p></div>
      <div class="step"><div class="step-num">STEP 04</div><h3>Report and improve</h3><div class="step-when">Every month</div><p>You get a monthly report per territory, and we adjust the plan.</p></div>
    </div>
    <div class="process-note" data-reveal><i class="fa-solid fa-clock"></i>Most owners see Google Business Profile improvements in about 30 days, and broader gains in 60–90 days.</div>
  </div>
</section>

<!-- WHY -->
<section class="why-section">
  <div class="container">
    <div class="why">
      <div data-reveal>
        <p class="section-label">Why Homecare Creators</p>
        <h2 class="section-h2">Why owners choose <em>Homecare Creators</em></h2>
        <div class="why-list">
          <div class="why-item"><h3>Home care only.</h3><p>We don't market restaurants or roofers. Every strategy is built for how families choose care.</p></div>
          <div class="why-item"><h3>A real team, not just software.</h3><p>Automated tools post content. We plan, write, reply and report.</p></div>
          <div class="why-item"><h3>Pick the plan that fits.</h3><p>Three packages, one partner for local growth, and social media whenever you want it.</p></div>
          <div class="why-item"><h3>Verified credentials.</h3>
            <div class="creds"><span>BBB Accredited</span><span>Google Partner</span><span>HubSpot Partner</span><span>Meta Certified Marketing Partner</span><span>SEMrush Certified Agency Partner</span><span>NAHC Member Agency</span></div>
          </div>
        </div>
      </div>
      <img class="why-img" src="/images/team/team-coffee-break-meeting.jpg" alt="The Homecare Creators team, a real marketing team that works only with home care agencies" width="765" height="1024" loading="lazy" data-reveal style="transition-delay:.12s">
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div class="faq-wrap">
      <div data-reveal>
        <p class="section-label">FAQ</p>
        <h2 class="section-h2">Frequently asked <em>questions</em></h2>
        <p class="section-sub">Still unsure? The free territory audit is the fastest way to get answers for your market.</p>
      </div>
      <div class="faq-list" data-reveal style="transition-delay:.1s">
        <?php foreach ($faqs as $f): ?>
        <div class="faq-item">
          <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text"><?= htmlspecialchars($f[0]) ?></span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
          <div class="faq-a"><div class="faq-a-inner"><?= htmlspecialchars($f[1]) ?></div></div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </div>
</section>

<!-- RELATED -->
<section class="related-section">
  <div class="container">
    <p class="section-label">Related Services</p>
    <div class="related">
      <a href="/seo/home-care-seo/"><i class="fa-solid fa-magnifying-glass-chart"></i><div><div class="related-title">Home Care SEO</div><div class="related-sub">For independent agencies</div></div></a>
      <a href="/local-seo-for-home-care-agencies/"><i class="fa-solid fa-map-location-dot"></i><div><div class="related-title">Local SEO</div><div class="related-sub">Google Maps rankings</div></div></a>
      <a href="/ai-search-seo/"><i class="fa-solid fa-brain"></i><div><div class="related-title">AI Search SEO</div><div class="related-sub">ChatGPT &amp; Google AI</div></div></a>
      <a href="/blog/google-business-profile-checklist-home-care"><i class="fa-solid fa-list-check"></i><div><div class="related-title">GBP Checklist</div><div class="related-sub">Free guide on our blog</div></div></a>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="cta-inner">
    <div class="cta-content" data-reveal>
      <p class="section-label">Free Territory Audit</p>
      <h2 class="section-h2">Get your free <em>Territory Audit</em></h2>
      <p class="cta-desc">See where your territory stands on Google Maps, reviews and listings, and get a 90-day plan. No cost, no obligation. We reply within 24 hours.</p>
      <ul class="cta-checks">
        <li><i class="fa-solid fa-check"></i>Google Business Profile and Maps ranking check</li>
        <li><i class="fa-solid fa-check"></i>Reviews and listings review</li>
        <li><i class="fa-solid fa-check"></i>Local competitor comparison</li>
        <li><i class="fa-solid fa-check"></i>90-day growth roadmap</li>
      </ul>
      <button class="btn-primary" style="font-size:15px;padding:16px 32px" onclick="openPopup('audit')">Book Free Territory Audit <i class="fa-solid fa-arrow-right" style="font-size:13px"></i></button>
      <div class="cta-guarantee">Free audit · No obligation · 30-day satisfaction guarantee</div>
    </div>
    <div class="cta-image" data-reveal style="transition-delay:.15s">
      <img src="/images/team/team-presenting-results-screen-2.jpg" alt="Homecare Creators team walking a home care franchise owner through their territory audit" width="765" height="1024" loading="lazy">
      <div class="cta-image-cap"><strong>Talk to our team</strong><span>We reply within 24 hours</span></div>
    </div>
  </div>
</section>

<?php
$_faq_schema = ['@context' => 'https://schema.org', '@type' => 'FAQPage', 'mainEntity' => array_map(fn($f) => ['@type' => 'Question', 'name' => $f[0], 'acceptedAnswer' => ['@type' => 'Answer', 'text' => $f[1]]], $faqs)];
$_svc_schema = [
    '@context' => 'https://schema.org', '@type' => 'Service',
    'name' => 'Home Care Franchise SEO', 'serviceType' => 'Local SEO for home care franchise owners',
    'url' => $page_canonical, 'areaServed' => ['@type' => 'Country', 'name' => 'United States'],
    'provider' => ['@type' => 'Organization', 'name' => 'Homecare Creators', 'url' => 'https://homecarecreators.com/'],
    'audience' => ['@type' => 'BusinessAudience', 'audienceType' => 'Home care franchise owners'],
    'offers' => array_map(fn($p) => ['@type' => 'Offer', 'name' => $p[0], 'price' => $p[1], 'priceCurrency' => 'USD',
        'priceSpecification' => ['@type' => 'UnitPriceSpecification', 'price' => $p[1], 'priceCurrency' => 'USD', 'unitText' => 'MONTH']],
        [['Starter', '697'], ['Growth', '1097'], ['Premium', '1597']]),
];
$_crumb_schema = ['@context' => 'https://schema.org', '@type' => 'BreadcrumbList', 'itemListElement' => [
    ['@type' => 'ListItem', 'position' => 1, 'name' => 'Home', 'item' => 'https://homecarecreators.com/'],
    ['@type' => 'ListItem', 'position' => 2, 'name' => 'Home Care Franchise SEO', 'item' => $page_canonical],
]];
foreach ([$_svc_schema, $_faq_schema, $_crumb_schema] as $_s) {
    echo '<script type="application/ld+json">' . json_encode($_s, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE) . '</script>' . "\n";
}
?>

<?php include '../includes/footer.php'; ?>
