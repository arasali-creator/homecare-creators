<?php
$page_canonical = "https://homecarecreators.com/ai-search-seo/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "AI Search SEO for Home Care Agencies (GEO & AEO) | Homecare Creators";
$page_desc = "AI Search SEO for home care agencies: get found in ChatGPT, Google AI Overviews and Perplexity. Plans from \$797/month, with tracked family questions and monthly reports.";
$og_title = "AI Search SEO for Home Care Agencies (GEO & AEO) | Homecare Creators";
$og_desc = "Families can now ask AI tools for home care recommendations. We build the structured data and entity signals AI systems look for, so your agency has a real shot at being named.";
$og_image = "https://homecarecreators.com/images/home/service-ai-search-seo.jpg";
$ai = require __DIR__ . '/../includes/ai-search-seo-data.php';
$page_css = <<<CSS
/* HERO */
.hero{min-height:88vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:120px 80px 80px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-200px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-blob2{position:absolute;width:500px;height:500px;bottom:-150px;left:-100px;background:radial-gradient(circle,rgba(201,168,76,.1) 0%,transparent 65%);animation:float 13s ease-in-out infinite reverse}
.hero-grid{position:relative;z-index:2;max-width:1320px;margin:0 auto;width:100%;display:grid;grid-template-columns:1.1fr .9fr;gap:64px;align-items:center}
.hero-content{max-width:620px}
.hero-visual{position:relative}
.hero-visual-glow{position:absolute;inset:-30px;background:radial-gradient(circle,rgba(29,158,117,.3),transparent 70%);filter:blur(30px);z-index:-1}
.hero-visual img{width:100%;aspect-ratio:4/4.5;object-fit:cover;border-radius:var(--r-lg);display:block;box-shadow:0 30px 80px rgba(0,0,0,.4);border:1px solid rgba(255,255,255,.1)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:28px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(38px,5vw,64px);line-height:1.06;color:#fff;margin-bottom:22px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:19px;line-height:1.78;color:rgba(255,255,255,.65);max-width:600px;margin-bottom:40px;animation:fadeUp .8s .25s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .38s ease both;margin-bottom:52px}
.hero-proof{display:flex;gap:32px;flex-wrap:wrap;animation:fadeUp .8s .5s ease both}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:34px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-proof-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch}

/* WHAT-IS SECTION */
.market-section{background:#fff}
.market-inner{display:flex;flex-direction:column;gap:48px}
.market-header{max-width:680px}
.market-columns{display:grid;grid-template-columns:1.3fr 1fr;gap:48px;align-items:start}
.market-text p{font-size:17px;line-height:1.85;color:var(--muted);margin-bottom:18px}
.market-text p:last-child{margin-bottom:0}
.market-quote{display:flex;gap:16px;background:var(--warm);border-left:4px solid var(--gold);border-radius:0 var(--r) var(--r) 0;padding:20px 24px;margin-top:22px}
.market-quote i{color:var(--gold);font-size:18px;flex-shrink:0;margin-top:2px}
.market-quote p{font-size:16px;font-style:italic;color:var(--forest);line-height:1.7;margin:0}
.market-compare{background:var(--cream);border:1px solid var(--border);border-radius:var(--r-lg);padding:28px;position:sticky;top:110px}
.market-compare-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1.2px;color:var(--teal);margin-bottom:22px;display:flex;align-items:center;gap:8px}
.market-compare-title::before{content:'';width:18px;height:2px;background:var(--teal);border-radius:2px;flex-shrink:0}
.compare-head{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding-bottom:12px;margin-bottom:6px;border-bottom:2px solid var(--border)}
.compare-head div{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--muted)}
.compare-head div:last-child{color:var(--teal)}
.compare-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;padding:14px 0;border-bottom:1px solid var(--border)}
.compare-row:last-child{border-bottom:none;padding-bottom:0}
.compare-row div{font-size:13px;line-height:1.55}
.compare-row div:first-child{color:var(--muted)}
.compare-row div:last-child{color:var(--forest);font-weight:600}
.market-facts{display:grid;grid-template-columns:repeat(4,1fr);gap:16px}
.fact-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r);padding:22px;border-left:4px solid var(--teal)}
.fact-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:28px;color:var(--teal);line-height:1;margin-bottom:6px}
.fact-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--forest);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
.fact-card p{font-size:14px;color:var(--muted);line-height:1.6}

/* SERVICES */
.services-section{background:var(--cream)}
.services-intro{margin-bottom:52px}
.services-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.svc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;transition:transform .25s,box-shadow .25s}
.svc-card:hover{transform:translateY(-4px);box-shadow:0 16px 48px rgba(10,46,30,.1)}
.svc-card-img{height:180px;position:relative;overflow:hidden}
.svc-card-img img{width:100%;height:100%;object-fit:cover;transition:transform .5s}
.svc-card:hover .svc-card-img img{transform:scale(1.05)}
.svc-card-img-overlay{position:absolute;inset:0;background:linear-gradient(180deg,transparent 30%,rgba(10,46,30,.7))}
.svc-card-img-icon{position:absolute;top:14px;left:14px;width:36px;height:36px;background:var(--teal);border-radius:9px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:15px}
.svc-card-body{padding:24px}
.svc-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--forest);margin-bottom:10px}
.svc-card-desc{font-size:16px;color:var(--muted);line-height:1.7;margin-bottom:16px}
.svc-card-features{list-style:none;display:flex;flex-direction:column;gap:7px}
.svc-card-features li{display:flex;align-items:flex-start;gap:9px;font-size:13px;color:var(--text)}
.svc-card-features li i{color:var(--teal);font-size:12px;margin-top:2px;flex-shrink:0}

/* WHY */
.why-section{background:var(--forest)}
.why-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:48px}
.why-card{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.09);border-radius:var(--r-lg);padding:28px;transition:background .2s}
.why-card:hover{background:rgba(255,255,255,.09)}
.why-card-icon{width:42px;height:42px;background:rgba(29,158,117,.18);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--teal-lt);font-size:17px;margin-bottom:16px}
.why-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:#fff;margin-bottom:10px}
.why-card p{font-size:15px;color:rgba(255,255,255,.6);line-height:1.75}

/* FAQ */
.faq-section{background:#fff}
.faq-list{margin-top:40px;display:flex;flex-direction:column;gap:12px}

/* CTA */
.cta-section{background:linear-gradient(135deg,var(--forest) 0%,var(--forest-lt) 100%);padding:96px 40px}
.cta-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.cta-content .section-label{color:var(--teal-lt)}
.cta-content .section-label::before{background:var(--teal-lt)}
.cta-content .section-h2{color:#fff}
.cta-desc{font-size:18px;color:rgba(255,255,255,.68);line-height:1.78;margin-bottom:32px}
.cta-actions{margin-bottom:20px}
.cta-guarantee{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.45);display:flex;align-items:center;gap:8px}
.cta-guarantee i{color:var(--teal-lt)}
.cta-image{position:relative;border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3)}
.cta-image img{width:100%;height:380px;object-fit:cover;display:block}
.cta-image-badge{position:absolute;bottom:20px;left:20px;right:20px;background:rgba(10,46,30,.88);backdrop-filter:blur(12px);border:1px solid rgba(46,198,143,.22);border-radius:12px;padding:16px 18px}
.cta-image-badge-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:#fff;margin-bottom:10px}
.cta-badge-row{display:flex;align-items:center;gap:8px;margin-bottom:6px}
.cta-badge-row:last-child{margin-bottom:0}
.cta-badge-dot{width:5px;height:5px;border-radius:50%;background:var(--teal-lt);flex-shrink:0}
.cta-badge-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.65)}

/* PRICING */
.ai-pricing{background:var(--warm);border-top:1px solid var(--border)}
.ai-pricing-head{text-align:center;max-width:720px;margin:0 auto 52px}
.ai-pricing-head .section-label{justify-content:center}
.ai-pricing-head .section-sub{margin:0 auto}
.ai-plans{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;align-items:stretch}
.ai-plan{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:34px 30px;display:flex;flex-direction:column;position:relative}
.ai-plan.featured{border:2px solid var(--teal)}
.ai-plan-flag{position:absolute;top:-13px;left:30px;background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;padding:5px 12px;border-radius:6px}
.ai-plan-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:700;color:var(--forest)}
.ai-plan-for{font-size:14.5px;color:var(--muted);margin:6px 0 22px;line-height:1.5;min-height:44px}
.ai-plan-price{font-family:'Plus Jakarta Sans',sans-serif;font-size:44px;font-weight:700;color:var(--forest);line-height:1}
.ai-plan-price span{font-size:15px;font-weight:500;color:var(--muted)}
.ai-plan-intro{font-size:14.5px;font-weight:600;color:var(--forest);padding:16px 0;margin-top:22px;border-top:1px solid var(--border)}
.ai-plan ul{list-style:none;display:flex;flex-direction:column;gap:12px;flex:1;margin-bottom:28px}
.ai-plan li{display:grid;grid-template-columns:18px 1fr;gap:10px;font-size:14.5px;color:var(--text);line-height:1.55}
.ai-plan li i{color:var(--teal);font-size:13px;margin-top:4px}
.ai-plan-btn{display:flex;align-items:center;justify-content:center;gap:9px;width:100%;padding:15px;border-radius:11px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;cursor:pointer;border:1.5px solid var(--forest);background:#fff;color:var(--forest);transition:background .2s,color .2s}
.ai-plan-btn:hover{background:var(--forest);color:#fff}
.ai-plan.featured .ai-plan-btn{background:var(--teal);border-color:var(--teal);color:#fff}
.ai-plan.featured .ai-plan-btn:hover{background:#17875f;border-color:#17875f}
.ai-more{text-align:center;margin:28px auto 36px;max-width:760px;font-size:15.5px;color:var(--muted);line-height:1.6}
.ai-more i{color:var(--teal);margin-right:8px}
.ai-extras{display:grid;grid-template-columns:1fr 1fr;gap:24px}
.ai-extra{border-radius:var(--r-lg);padding:30px 32px}
.ai-extra.dark{background:var(--forest);color:#fff}
.ai-extra.light{background:#fff;border:1px solid var(--border)}
.ai-extra-top{display:flex;justify-content:space-between;align-items:baseline;gap:16px;flex-wrap:wrap;margin-bottom:6px}
.ai-extra h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:700}
.ai-extra.light h3{color:var(--forest)}
.ai-extra-price{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:700;color:var(--teal)}
.ai-extra.dark .ai-extra-price{color:var(--teal-lt)}
.ai-extra-price span{font-size:14px;font-weight:500;color:var(--muted)}
.ai-extra.dark .ai-extra-price span{color:rgba(255,255,255,.55)}
.ai-extra-sub{font-size:14.5px;color:var(--muted);margin-bottom:18px}
.ai-extra.dark .ai-extra-sub{color:rgba(255,255,255,.6)}
.ai-extra ul{list-style:none;display:flex;flex-direction:column;gap:10px}
.ai-extra li{display:grid;grid-template-columns:16px 1fr;gap:10px;font-size:14.5px;line-height:1.5;color:var(--text)}
.ai-extra.dark li{color:rgba(255,255,255,.82)}
.ai-extra li i{color:var(--teal);font-size:12px;margin-top:4px}
.ai-extra.dark li i{color:var(--teal-lt)}

/* REPORT */
.ai-report{background:#fff}
.ai-report-grid{display:grid;grid-template-columns:.9fr 1.1fr;gap:72px;align-items:start}
.ai-report-list{border-top:2px solid var(--forest)}
.ai-report-item{display:grid;grid-template-columns:48px 1fr;gap:16px;padding:22px 0;border-bottom:1px solid var(--border)}
.ai-report-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--teal);padding-top:2px}
.ai-report-item h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:17px;font-weight:700;color:var(--forest);margin-bottom:5px}
.ai-report-item p{font-size:15.5px;color:var(--muted);line-height:1.65}

/* RESPONSIVE */
@media(max-width:900px){
  .ai-plans{grid-template-columns:1fr;max-width:520px;margin:0 auto}
  .ai-extras,.ai-report-grid{grid-template-columns:1fr;gap:32px}
  .market-columns,.cta-inner{grid-template-columns:1fr;gap:40px}
  .hero-grid{grid-template-columns:1fr;gap:40px}
  .hero-visual{order:-1;max-width:420px;margin:0 auto}
  .services-grid,.why-grid{grid-template-columns:1fr 1fr}
  .market-facts{grid-template-columns:1fr 1fr}
  .hero{padding:110px 40px 60px}
}
@media(max-width:640px){
  .services-grid,.why-grid{grid-template-columns:1fr}
  .market-facts{grid-template-columns:1fr}
  .hero{padding:100px 24px 60px}
  .hero-visual{display:none}
  section{padding:64px 24px}
  .cta-image{display:none}
  .compare-head,.compare-row{grid-template-columns:1fr}
  .compare-head div:last-child{margin-top:6px}
}
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-blob1"></div>
  <div class="hero-blob2"></div>
  <div class="hero-grid">
    <div class="hero-content">
      <div class="hero-breadcrumb"><a href="https://homecarecreators.com">Home</a> / <span>AI Search SEO</span></div>
      <div class="hero-badge"><div class="hero-badge-pulse"></div>GEO &amp; AEO for Home Care</div>
      <h1 class="hero-h1">AI Search SEO<br>for <em>Home Care Agencies</em></h1>
      <p class="hero-desc">Families researching care for a parent can now ask ChatGPT, Google AI Overviews, and Perplexity for home care recommendations, and get one answer instead of a page of links. Most home care agencies are not set up to be part of that answer. We build the structured data, entity signals, and answer-formatted content that give your agency a real shot at being the one AI mentions.</p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-robot"></i>Get My Free AI Visibility Audit</button>
        <a href="#pricing" class="btn-secondary">See Pricing</a>
      </div>
      <div class="hero-proof">
        <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Homecare-Only Focus</div></div>
        <div class="hero-proof-divider"></div>
        <div class="hero-proof-item"><div class="hero-proof-num">$797/mo</div><div class="hero-proof-label">Plans Start At</div></div>
        <div class="hero-proof-divider"></div>
        <div class="hero-proof-item"><div class="hero-proof-num">30-Day</div><div class="hero-proof-label">Satisfaction Guarantee</div></div>
        <div class="hero-proof-divider"></div>
        <div class="hero-proof-item"><div class="hero-proof-num">$0</div><div class="hero-proof-label">Free Audit Cost</div></div>
      </div>
    </div>
    <div class="hero-visual">
      <div class="hero-visual-glow"></div>
      <img src="/images/home/hero-team-ai-search-strategy.jpg" alt="Homecare Creators team reviewing AI search visibility strategy for a home care agency" title="AI Search SEO strategy session">
    </div>
  </div>
</section>

<!-- ══════════════════════════
   CERTIFICATIONS / TRUST BADGES
══════════════════════════ -->
<section class="certs">
  <div class="container">
    <p class="certs-label">Certified &amp; Trusted By</p>
    <div class="certs-row">
      <div class="cert-item"><img src="/images/blog/Homecarecreators-Google-my-business-profile.png" alt="Homecare Creators verified Google Business Profile badge" title="Verified Google Business Profile" loading="lazy"><span>Google Business Profile</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-google-partner.jpg" alt="Homecare Creators Google Partner certification badge" title="Google Partner Certified Agency" loading="lazy"><span>Google Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-hubspot-partner.webp" alt="Homecare Creators HubSpot certified partner badge" title="HubSpot Certified Partner" loading="lazy"><span>HubSpot Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-meta-certificate.jpg" alt="Homecare Creators Meta certified marketing partner badge" title="Meta Certified Marketing Partner" loading="lazy"><span>Meta Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-semrush-ceticificate.png" alt="Homecare Creators SEMrush certified SEO partner badge" title="SEMrush Certified Agency Partner" loading="lazy"><span>SEMrush Certified</span></div>
    </div>
  </div>
</section>

<!-- TICKER -->
<div class="ticker-wrap" aria-hidden="true">
  <div class="ticker-inner">
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>AI Search SEO Specialists</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-brain"></i>Generative Engine Optimization (GEO)</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-circle-question"></i>Answer Engine Optimization (AEO)</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-house-medical"></i>Built for Home Care Only</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>ChatGPT &middot; Perplexity &middot; Google AI Overviews</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>AI Search SEO Specialists</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-brain"></i>Generative Engine Optimization (GEO)</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-circle-question"></i>Answer Engine Optimization (AEO)</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-house-medical"></i>Built for Home Care Only</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>ChatGPT &middot; Perplexity &middot; Google AI Overviews</div>
  </div>
</div>

<!-- WHAT IS AI SEARCH SEO -->
<section class="market-section">
  <div class="container">
    <div class="market-inner">
      <div class="market-header" data-reveal>
        <p class="section-label">What Is AI Search SEO?</p>
        <h2 class="section-h2">GEO, AEO, and Why <em>AI Search</em> Is Different</h2>
      </div>
      <div class="market-columns">
        <div class="market-text" data-reveal style="transition-delay:.05s">
          <p>AI Search SEO is the practice of structuring your agency's website and content so generative AI tools, like ChatGPT, Google's AI Overviews, and Perplexity, can accurately understand your agency, trust it, and cite it when someone asks a question. Inside the industry, you'll see this called GEO (Generative Engine Optimization) or AEO (Answer Engine Optimization). They describe the same shift: search results are no longer just a list of ten blue links, they're increasingly a single AI-written answer.</p>
          <p>Traditional SEO is built around ranking a specific page for a specific keyword. AI search optimization works differently. Generative models pull from structured data, entity information, third-party mentions, and clearly formatted answer content when they decide what to summarize and who to cite. That means the technical foundation, your schema markup, your Google Business Profile consistency, your FAQ content, and how clearly your site answers direct questions, matters just as much as the words on the page.</p>
          <p>This matters enormously for home care. Adult children researching care options for a parent often start with a conversational question, something like "what should I look for in a home care agency near me" or "how much does in-home care cost," typed directly into ChatGPT or asked through an AI Overview.</p>
          <div class="market-quote">
            <i class="fa-solid fa-quote-left"></i>
            <p>If your agency's site isn't built to be understood and cited by these tools, you're not in the conversation at all, no matter how good your Google Maps ranking is.</p>
          </div>
        </div>
        <div class="market-compare" data-reveal style="transition-delay:.15s">
          <div class="market-compare-title">Why It's Different</div>
          <div class="compare-head"><div>Traditional Search</div><div>AI Search</div></div>
          <div class="compare-row"><div>Ranks one page per keyword</div><div>Understands your whole agency as an entity</div></div>
          <div class="compare-row"><div>Ten blue links to click through</div><div>One AI-written answer</div></div>
          <div class="compare-row"><div>Success = where you rank</div><div>Success = being cited, or invisible</div></div>
        </div>
      </div>
      <div class="market-facts" data-reveal style="transition-delay:.2s">
        <div class="fact-card"><div class="fact-num">GEO</div><h4>Generative Engine Optimization</h4><p>Structuring content so generative AI tools can understand, summarize, and recommend your agency.</p></div>
        <div class="fact-card"><div class="fact-num">AEO</div><h4>Answer Engine Optimization</h4><p>Formatting your content, especially FAQs, to directly answer the exact questions families ask AI assistants.</p></div>
        <div class="fact-card"><div class="fact-num">Zero-Click</div><h4>A New Kind of Search</h4><p>Many searches now show an AI-written answer above the links. If you're not part of that answer, the family may never scroll down to you.</p></div>
        <div class="fact-card"><div class="fact-num">Early</div><h4>Still a Wide-Open Channel</h4><p>Very few home care agencies have optimized for AI search yet. Building the groundwork now is a real head start.</p></div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="services-section" id="services">
  <div class="container">
    <div class="services-intro" data-reveal>
      <p class="section-label">What's Included</p>
      <h2 class="section-h2">The Building Blocks of <em>AI Search Visibility</em></h2>
      <p class="section-sub">AI Search SEO isn't one single tactic, it's a combination of technical structure, entity data, and content built specifically so AI tools can find, understand, and cite your agency.</p>
    </div>
    <div class="services-grid">
      <div class="svc-card" data-reveal style="transition-delay:.05s">
        <div class="svc-card-img">
          <img src="/images/home/service-ai-search-seo.jpg" alt="AI Overviews and ChatGPT citation optimization for home care agencies" title="AI Overviews and ChatGPT citation optimization">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">AI Overviews &amp; ChatGPT Citation Optimization</div>
          <div class="svc-card-desc">We restructure your key pages so the content is easy for a generative model to extract, summarize, and cite, and we track how your agency shows up (or doesn't) across the AI tools families actually use.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Google AI Overviews on-page optimization</li>
            <li><i class="fa-solid fa-check"></i>Content structured for direct-answer extraction</li>
            <li><i class="fa-solid fa-check"></i>ChatGPT &amp; Perplexity citation tracking</li>
            <li><i class="fa-solid fa-check"></i>Conversational, long-tail keyword targeting</li>
            <li><i class="fa-solid fa-check"></i>Monthly AI visibility reporting</li>
          </ul>
        </div>
      </div>
      <div class="svc-card" data-reveal style="transition-delay:.1s">
        <div class="svc-card-img">
          <img src="/images/home/ai-seo-tech.jpg" alt="Entity and knowledge graph building for home care agency AI search visibility" title="Entity and knowledge graph building">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-diagram-project"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">Entity &amp; Knowledge Graph Building</div>
          <div class="svc-card-desc">AI systems need to recognize your agency as a real, consistent, trustworthy entity before they'll reference it. We build the citations, mentions, and profile consistency that establish exactly that.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Consistent NAP citations across the web</li>
            <li><i class="fa-solid fa-check"></i>Google Knowledge Panel groundwork</li>
            <li><i class="fa-solid fa-check"></i>Organization &amp; author schema markup</li>
            <li><i class="fa-solid fa-check"></i>E-E-A-T authority-building content</li>
            <li><i class="fa-solid fa-check"></i>Directory &amp; third-party mention building</li>
          </ul>
        </div>
      </div>
      <div class="svc-card" data-reveal style="transition-delay:.15s">
        <div class="svc-card-img">
          <img src="/images/home/service-website-dev.jpg" alt="FAQ schema and structured content for home care agency websites" title="FAQ schema and structured content">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-circle-question"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">FAQ Schema &amp; Structured Content</div>
          <div class="svc-card-desc">We write and mark up content in the exact question-and-answer format AI tools pull from, covering the real questions families ask about cost, availability, services, and how to get started.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>FAQ schema markup on key pages</li>
            <li><i class="fa-solid fa-check"></i>Question-based content mapped to real search queries</li>
            <li><i class="fa-solid fa-check"></i>Service &amp; HowTo schema where relevant</li>
            <li><i class="fa-solid fa-check"></i>Clear, scannable formatting built for AI parsing</li>
            <li><i class="fa-solid fa-check"></i>New answer-style pages or FAQ updates every month</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- PRICING -->
<section class="ai-pricing" id="pricing">
  <div class="container">
    <div class="ai-pricing-head" data-reveal>
      <p class="section-label">Pricing</p>
      <h2 class="section-h2">AI Search SEO <em>pricing</em></h2>
      <p class="section-sub">Clear monthly plans, measured by how many real family questions mention your agency.</p>
    </div>
    <div class="ai-plans" data-reveal style="transition-delay:.1s">
      <div class="ai-plan">
        <div class="ai-plan-name">Essentials</div>
        <div class="ai-plan-for">Agencies starting with AI search</div>
        <div class="ai-plan-price">$797<span>/month</span></div>
        <div class="ai-plan-intro">What you get each month:</div>
        <ul>
          <li><i class="fa-solid fa-check"></i>25 family questions tracked (like "best home care in [city]")</li>
          <li><i class="fa-solid fa-check"></i>ChatGPT, Google AI Overviews and Perplexity</li>
          <li><i class="fa-solid fa-check"></i>2 answer-style pages or FAQ updates</li>
          <li><i class="fa-solid fa-check"></i>Schema upkeep</li>
          <li><i class="fa-solid fa-check"></i>Monthly AI visibility report</li>
        </ul>
        <button class="ai-plan-btn" onclick="openPopup()">Book a Free AI Audit</button>
      </div>
      <div class="ai-plan featured">
        <div class="ai-plan-flag">Most popular</div>
        <div class="ai-plan-name">Growth</div>
        <div class="ai-plan-for">Agencies ready to be named more often</div>
        <div class="ai-plan-price">$1,297<span>/month</span></div>
        <div class="ai-plan-intro">Everything in Essentials, plus:</div>
        <ul>
          <li><i class="fa-solid fa-check"></i>50 family questions tracked</li>
          <li><i class="fa-solid fa-check"></i>4 content pieces a month</li>
          <li><i class="fa-solid fa-check"></i>3 third-party mentions or directory placements a month</li>
          <li><i class="fa-solid fa-check"></i>Competitor citation check</li>
        </ul>
        <button class="ai-plan-btn" onclick="openPopup()">Book a Free AI Audit <i class="fa-solid fa-arrow-right" style="font-size:12px"></i></button>
      </div>
      <div class="ai-plan">
        <div class="ai-plan-name">Authority</div>
        <div class="ai-plan-for">Competitive markets and multi-location agencies</div>
        <div class="ai-plan-price">$1,997<span>/month</span></div>
        <div class="ai-plan-intro">Everything in Growth, plus:</div>
        <ul>
          <li><i class="fa-solid fa-check"></i>100 family questions tracked</li>
          <li><i class="fa-solid fa-check"></i>8 content pieces and 5 mentions a month</li>
          <li><i class="fa-solid fa-check"></i>Gemini and Copilot tracking</li>
          <li><i class="fa-solid fa-check"></i>Review strategy</li>
          <li><i class="fa-solid fa-check"></i>Monthly strategy call</li>
        </ul>
        <button class="ai-plan-btn" onclick="openPopup()">Talk to Us About Authority</button>
      </div>
    </div>
    <p class="ai-more"><i class="fa-solid fa-circle-info"></i>These are the highlights. We'll walk you through everything included during your free AI visibility audit.</p>
    <div class="ai-extras" data-reveal>
      <div class="ai-extra light">
        <div class="ai-extra-top"><h3>AI Search Setup</h3><div class="ai-extra-price">$997<span> one-time</span></div></div>
        <p class="ai-extra-sub">The foundation most agencies start with.</p>
        <ul>
          <li><i class="fa-solid fa-check"></i>Full AI search audit</li>
          <li><i class="fa-solid fa-check"></i>Organization, Service, FAQ and author schema</li>
          <li><i class="fa-solid fa-check"></i>Entity and name, address and phone cleanup</li>
          <li><i class="fa-solid fa-check"></i>Google Knowledge Panel groundwork</li>
          <li><i class="fa-solid fa-check"></i>90-day roadmap</li>
        </ul>
      </div>
      <div class="ai-extra dark">
        <div class="ai-extra-top"><h3>Already an SEO client?</h3><div class="ai-extra-price">+$497<span>/month</span></div></div>
        <p class="ai-extra-sub">Add AI search to your current SEO plan.</p>
        <ul>
          <li><i class="fa-solid fa-check"></i>AI visibility tracking</li>
          <li><i class="fa-solid fa-check"></i>Schema setup and upkeep</li>
          <li><i class="fa-solid fa-check"></i>Answer-formatting of the content we already produce for you</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- REPORT -->
<section class="ai-report">
  <div class="container">
    <div class="ai-report-grid">
      <div data-reveal>
        <p class="section-label">Your Monthly Report</p>
        <h2 class="section-h2">What we <em>measure</em> every month</h2>
        <p class="section-sub">Every month we ask the AI tools the same set of real family questions for your area, then show you exactly where your agency appears.</p>
      </div>
      <div class="ai-report-list" data-reveal style="transition-delay:.1s">
        <div class="ai-report-item"><div class="ai-report-num">01</div><div><h3>How often you're mentioned</h3><p>How many of your tracked family questions name your agency, and how that number changes month to month.</p></div></div>
        <div class="ai-report-item"><div class="ai-report-num">02</div><div><h3>Which AI tools mention you</h3><p>Results for ChatGPT, Google AI Overviews and Perplexity, plus Gemini and Copilot on the Authority plan.</p></div></div>
        <div class="ai-report-item"><div class="ai-report-num">03</div><div><h3>How you compare with competitors</h3><p>Which local agencies get named when you don't, so we know where to focus next.</p></div></div>
        <div class="ai-report-item"><div class="ai-report-num">04</div><div><h3>What we did and what's next</h3><p>Pages published, schema updates, new mentions earned, and next month's plan.</p></div></div>
      </div>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="why-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label" style="color:var(--teal-lt)"><span style="background:var(--teal-lt);display:inline-block;width:24px;height:2px;border-radius:2px;margin-right:8px;vertical-align:middle"></span>Why This Matters</p>
      <h2 class="section-h2" style="color:#fff">Why AI Search Is <em>Worth Getting Ahead Of</em></h2>
      <p class="section-sub" style="color:rgba(255,255,255,.58)">We can't control what any AI model decides to say. What we can do is build the structured data and entity signals these systems look for, so your agency has a real, defensible shot at being part of the answer.</p>
    </div>
    <div class="why-grid" data-reveal style="transition-delay:.1s">
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-comments"></i></div><h4>Families Can Ask AI First</h4><p>A family can now start their search for care with a conversational question to ChatGPT or see a Google AI Overview before any search result. If your site isn't structured for that, you can be left out before the process even starts.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-handshake"></i></div><h4>Trust Before the First Call</h4><p>Being named or cited by an AI assistant carries a built-in credibility a plain search listing doesn't. Showing up in that first AI-generated answer can shape a family's shortlist before they ever land on your website.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-seedling"></i></div><h4>An Early, Low-Competition Channel</h4><p>Very few home care agencies have invested any real effort into AI search optimization yet. Building this groundwork now, while most competitors haven't started, is one of the more efficient ways to gain visibility.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-database"></i></div><h4>We Build the Signals AI Looks For</h4><p>Structured data, consistent entity information, and clear answer-formatted content are what generative models rely on when forming a recommendation. That's the work we do, honestly and without shortcuts.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-layer-group"></i></div><h4>Works Alongside Your Existing SEO</h4><p>AI search optimization complements local SEO and Google Maps rankings, it doesn't replace them. We build both together so your agency shows up whether a family searches, scrolls, or asks.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-chart-line"></i></div><h4>Built for Where Search Is Headed</h4><p>Search engines increasingly summarize answers directly on the results page. We keep your agency's content ready for whatever form the next generation of search takes, not just today's algorithm.</p></div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">AI Search SEO:<br><em>Questions Agency Owners Ask</em></h2>
      <p class="section-sub">Straight answers for home care agency owners deciding whether AI Search SEO is worth investing in right now.</p>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">
      <?php foreach ($ai['faqs'] as $f): ?>
      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text"><?= htmlspecialchars($f[0]) ?></span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner"><?= htmlspecialchars($f[1]) ?></div></div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<!-- INTERNAL LINKS -->
<section style="background:var(--cream);padding:48px 40px">
  <div class="container" style="text-align:center">
    <p class="section-label" style="justify-content:center">Our Services</p>
    <h2 class="section-h2" style="text-align:center">Get Found Everywhere Families Search</h2>
    <div style="display:flex;gap:20px;justify-content:center;flex-wrap:wrap;margin-top:32px">
      <a href="/seo/home-care-seo/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-bullhorn" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Home Care Agency SEO</div><div style="font-size:12px;color:var(--muted)">Full-service SEO built for home care</div></div>
      </a>
      <a href="/web-design/homecare-website-design/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-laptop-code" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Homecare Website Design</div><div style="font-size:12px;color:var(--muted)">Professional, SEO-optimized websites</div></div>
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
        <h2 class="section-h2">Ready to Show Up in <em>AI Search Results?</em></h2>
        <p class="cta-desc">Book a free AI visibility audit. We'll check how (and whether) your agency currently appears across ChatGPT, Google AI Overviews, and Perplexity, review your entity and schema data, and hand you a 90-day roadmap. No cost, no obligation.</p>
        <div class="cta-actions">
          <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup()"><i class="fa-solid fa-calendar-check"></i>Get My Free AI Visibility Audit</button>
        </div>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free audit &nbsp;·&nbsp; No obligation &nbsp;·&nbsp; 30-day satisfaction guarantee</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/home/cta-owner-ai-search-seo.jpg" alt="Home care agency owner reviewing their AI search visibility with Homecare Creators" title="Home care agency owner growth with AI Search SEO">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Audit Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">AI visibility snapshot</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Entity &amp; schema data audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Competitor AI-citation check</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">90-day roadmap</div></div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php include '../includes/footer.php'; ?>
