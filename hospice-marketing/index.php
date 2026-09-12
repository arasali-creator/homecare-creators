<?php
$page_canonical = "https://homecarecreators.com/hospice-marketing/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "Hospice Marketing Agency | Homecare Creators";
$page_desc = "Respectful, compassionate marketing for hospice providers. We help hospice organizations improve online visibility, support referral relationships, and reach families with care and clarity.";
$og_title = "Hospice Marketing Agency | Homecare Creators";
$og_desc = "Homecare Creators helps hospice providers build trust online, strengthen referral relationships with hospitals and physicians, and be found by families with compassion, not sales pressure.";
$page_css = <<<CSS
/* HERO */
.hero{min-height:88vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:120px 80px 80px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-200px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-blob2{position:absolute;width:500px;height:500px;bottom:-150px;left:-100px;background:radial-gradient(circle,rgba(201,168,76,.1) 0%,transparent 65%);animation:float 13s ease-in-out infinite reverse}
.hero-content{position:relative;z-index:2;max-width:780px}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:28px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(38px,5vw,64px);line-height:1.06;color:#fff;margin-bottom:22px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:19px;line-height:1.78;color:rgba(255,255,255,.65);max-width:560px;margin-bottom:40px;animation:fadeUp .8s .25s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .38s ease both;margin-bottom:52px}
.hero-proof{display:flex;gap:32px;flex-wrap:wrap;animation:fadeUp .8s .5s ease both}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:30px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-proof-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch}

/* TICKER */
.ticker-wrap{background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);overflow:hidden;padding:14px 0}
.ticker-inner{display:flex;width:max-content;animation:ticker 32s linear infinite}
.ticker-item{display:flex;align-items:center;gap:10px;padding:0 38px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--muted);letter-spacing:.4px;text-transform:uppercase;white-space:nowrap}
.ticker-dot{width:5px;height:5px;border-radius:50%;background:var(--teal);flex-shrink:0}
.ticker-item i{color:var(--teal);font-size:13px}

/* MARKET SECTION */
.market-section{background:#fff}
.market-inner{display:flex;flex-direction:column;gap:40px}
.market-body{text-align:center;max-width:760px;margin:0 auto}
.market-body .section-label{justify-content:center}
.market-body p{font-size:18px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.market-facts{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-top:8px}
.fact-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r);padding:22px;border-left:4px solid var(--teal)}
.fact-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;color:var(--teal);line-height:1.2;margin-bottom:6px}
.fact-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--forest);margin-bottom:6px;text-transform:uppercase;letter-spacing:.5px}
.fact-card p{font-size:15px;color:var(--muted);line-height:1.6}

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
.why-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:20px;margin-top:48px}
.why-card{background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.09);border-radius:var(--r-lg);padding:28px;transition:background .2s}
.why-card:hover{background:rgba(255,255,255,.09)}
.why-card-icon{width:42px;height:42px;background:rgba(29,158,117,.18);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--teal-lt);font-size:17px;margin-bottom:16px}
.why-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:#fff;margin-bottom:10px}
.why-card p{font-size:15px;color:rgba(255,255,255,.6);line-height:1.75}

/* FAQ */
.faq-section{background:#fff}
.faq-list{margin-top:40px;display:flex;flex-direction:column;gap:12px}
.faq-a-inner{padding:0 24px 20px;font-size:16px;color:var(--muted);line-height:1.8}

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

/* RESPONSIVE */
@media(max-width:900px){
  .market-inner,.cta-inner{grid-template-columns:1fr;gap:40px}
  .services-grid,.why-grid{grid-template-columns:1fr 1fr}
  .hero{padding:110px 40px 60px}
}
@media(max-width:640px){
  .services-grid,.why-grid{grid-template-columns:1fr}
  .hero{padding:100px 24px 60px}
  section{padding:64px 24px}
  .cta-image{display:none}
  .market-facts{grid-template-columns:1fr}
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
  <div class="hero-content">
    <div class="hero-breadcrumb"><a href="https://homecarecreators.com">Home</a> / <span>Hospice</span></div>
    <div class="hero-badge"><div class="hero-badge-pulse"></div>Hospice &amp; End-of-Life Care Marketing</div>
    <h1 class="hero-h1">Marketing for <em>Hospice</em><br>Providers</h1>
    <p class="hero-desc">Hospice marketing calls for a different tone than the rest of senior care. Families searching these terms are navigating one of the hardest moments of their lives, and physicians and discharge planners are trusting you with their patients. We help hospice organizations build an online presence that's found easily, feels respectful, and supports the referral relationships that matter most.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Get Your Free Hospice Marketing Audit</button>
      <a href="https://homecarecreators.com/#services" class="btn-secondary"><i class="fa-solid fa-play"></i>View Our Services</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Hospice-Only Focus</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">SEO</div><div class="hero-proof-label">+ AI Search Visibility</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">30-Day</div><div class="hero-proof-label">Satisfaction Guarantee</div></div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item"><div class="hero-proof-num">$0</div><div class="hero-proof-label">Free Audit Cost</div></div>
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
    <div class="ticker-item"><i class="fa-solid fa-hand-holding-heart"></i>Hospice &amp; End-of-Life Care</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass"></i>Local SEO Specialists</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-hospital-user"></i>Referral Relationship Support</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-globe"></i>Hospice Website Design</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Google Maps Visibility</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>AI Search SEO for ChatGPT &amp; Perplexity</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-hand-holding-heart"></i>Hospice &amp; End-of-Life Care</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass"></i>Local SEO Specialists</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-hospital-user"></i>Referral Relationship Support</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-globe"></i>Hospice Website Design</div>
  </div>
</div>

<!-- MARKET SECTION -->
<section class="market-section">
  <div class="container">
    <div class="market-inner">
      <div class="market-body" data-reveal>
        <p class="section-label">The Hospice Landscape</p>
        <h2 class="section-h2">Marketing Hospice Care Requires <em>Care Itself</em></h2>
        <p>Search terms around hospice, like "hospice care near me" or "what does hospice do," are some of the most emotionally sensitive in all of healthcare. Families searching them are often exhausted, frightened, and looking for reassurance more than a sales pitch. A marketing approach that feels even slightly aggressive or promotional can do real harm to how a family perceives your organization at the worst possible moment.</p>
        <p>At the same time, hospice growth rarely comes from search alone. Referrals from hospital discharge planners, physicians, skilled nursing facilities, and case managers are just as important as where you rank on Google, if not more so. A strong online presence backs up those referral relationships: when a physician or discharge planner recommends your organization, families search your name to confirm it, and what they find needs to build confidence, not doubt.</p>
        <p>Homecare Creators builds hospice marketing with both audiences in mind: a respectful, informative web presence for families, and clear, professional content and visibility that supports the referral partners who send patients your way. Every word is chosen with the sensitivity this work deserves.</p>
      </div>
      <div class="market-facts" data-reveal style="transition-delay:.15s">
        <div class="fact-card"><div class="fact-num">Sensitive</div><h4>Search Intent</h4><p>Hospice searches happen during some of the hardest moments a family will face</p></div>
        <div class="fact-card"><div class="fact-num">Referral-Driven</div><h4>Growth Channel</h4><p>Physicians, hospitals, and discharge planners remain central to hospice patient referrals</p></div>
        <div class="fact-card"><div class="fact-num">Reputation-First</div><h4>Family Research</h4><p>Families often verify a physician's referral online before making a final decision</p></div>
        <div class="fact-card"><div class="fact-num">Respectful Tone</div><h4>Required Approach</h4><p>Aggressive or salesy messaging can damage trust in hospice marketing more than any other vertical</p></div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="services-section">
  <div class="container">
    <div class="services-intro" data-reveal>
      <p class="section-label">Our Services for Hospice Providers</p>
      <h2 class="section-h2">A Respectful, Effective Online Presence<br>for <em>Your Hospice Organization</em></h2>
      <p class="section-sub">We build websites, run local SEO, and handle AI search optimization for hospice providers, all with the compassionate tone this work requires.</p>
    </div>
    <div class="services-grid">
      <div class="svc-card" data-reveal style="transition-delay:.05s">
        <div class="svc-card-img">
          <img src="/images/home/service-website-dev.jpg" alt="Hospice provider website design services" title="Website design for hospice providers">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-laptop-code"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">Hospice Website Design</div>
          <div class="svc-card-desc">A calm, informative website that explains your services clearly for families while giving referral partners the professional resources they need to feel confident sending patients your way.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Compassionate, jargon-free messaging</li>
            <li><i class="fa-solid fa-check"></i>Dedicated referral partner resource pages</li>
            <li><i class="fa-solid fa-check"></i>Clear explanations of levels of hospice care</li>
            <li><i class="fa-solid fa-check"></i>Simple, low-pressure contact pathways</li>
            <li><i class="fa-solid fa-check"></i>Accreditation and certification display</li>
            <li><i class="fa-solid fa-check"></i>Built for fast, mobile-first loading</li>
          </ul>
        </div>
      </div>
      <div class="svc-card" data-reveal style="transition-delay:.1s">
        <div class="svc-card-img">
          <img src="/images/home/service-local-seo.jpg" alt="Local SEO services helping hospice providers appear in Google search" title="Local SEO for hospice providers">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">Local SEO &amp; Referral Visibility</div>
          <div class="svc-card-desc">We help your organization appear when families search for hospice care, and make sure your online presence reinforces the trust physicians and discharge planners place in you when they refer.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Google Business Profile management</li>
            <li><i class="fa-solid fa-check"></i>Hospice-specific keyword targeting</li>
            <li><i class="fa-solid fa-check"></i>On-page SEO across service pages</li>
            <li><i class="fa-solid fa-check"></i>Reputation management and review growth</li>
            <li><i class="fa-solid fa-check"></i>Monthly visibility reports</li>
            <li><i class="fa-solid fa-check"></i>Referral-partner-facing content support</li>
          </ul>
        </div>
      </div>
      <div class="svc-card" data-reveal style="transition-delay:.15s">
        <div class="svc-card-img">
          <img src="/images/home/service-ai-search-seo.jpg" alt="AI Search SEO helping hospice providers get cited by ChatGPT and Google AI" title="AI Search SEO for hospice providers">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-brain"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">AI Search SEO for Hospice</div>
          <div class="svc-card-desc">Families and even clinicians increasingly ask ChatGPT and Google AI Overviews questions about hospice care. We help make sure your organization's information is accurate, findable, and represented respectfully.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Google AI Overviews optimization</li>
            <li><i class="fa-solid fa-check"></i>Sensitive, accurate FAQ schema content</li>
            <li><i class="fa-solid fa-check"></i>E-E-A-T authority building</li>
            <li><i class="fa-solid fa-check"></i>Google Knowledge Graph entity creation</li>
            <li><i class="fa-solid fa-check"></i>ChatGPT and Perplexity citation tracking</li>
            <li><i class="fa-solid fa-check"></i>Monthly AI visibility audit report</li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="why-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label" style="color:var(--teal-lt)"><span style="background:var(--teal-lt);display:inline-block;width:24px;height:2px;border-radius:2px;margin-right:8px;vertical-align:middle"></span>Why Homecare Creators</p>
      <h2 class="section-h2" style="color:#fff">Marketing Built With<br><em>the Care This Work Deserves</em></h2>
      <p class="section-sub" style="color:rgba(255,255,255,.58)">Generalist agencies often push hospice marketing the same way they push any other healthcare service. We take a different, more careful approach.</p>
    </div>
    <div class="why-grid" data-reveal style="transition-delay:.1s">
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-hand-holding-heart"></i></div><h4>Compassionate, Non-Salesy Messaging</h4><p>Every page we write is reviewed for tone, not just keywords. Hospice marketing should inform and reassure, never pressure a family in crisis.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-hospital-user"></i></div><h4>Referral Relationship Support</h4><p>We build content and visibility that supports the trust physicians, hospitals, and discharge planners already place in your organization, not just direct-to-family marketing.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-certificate"></i></div><h4>Credibility &amp; Accreditation Signals</h4><p>Licensing, accreditation, and years of service are highlighted clearly, because trust matters more here than almost anywhere else in senior care.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-handshake"></i></div><h4>No Long-Term Contracts</h4><p>We keep clients through results, not contracts. Every plan moves to month-to-month after an initial 90-day ramp-up period.</p></div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Hospice Marketing:<br><em>Questions Providers Ask</em></h2>
      <p class="section-sub">Answers to what hospice administrators and owners want to know before they sign on.</p>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How is marketing for hospice different from home care marketing?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Hospice search intent is far more sensitive, and tone matters as much as ranking position. Hospice growth also depends heavily on referral relationships with hospitals, physicians, and discharge planners, alongside direct family search. We build strategy and content around both audiences, with a respectful, non-promotional voice throughout.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How do you handle the sensitivity of hospice search terms?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Every piece of content is written and reviewed with tone in mind first. We avoid pressure tactics, aggressive calls to action, or anything that could feel dismissive of what a family is going through. The goal is always to inform and reassure.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How much does hospice marketing cost?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Pricing is a flat monthly retainer with no hidden setup fees. What you pay depends on your local market and whether you need a new website built alongside SEO. Book a free audit and we'll walk you through exact numbers for your organization.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How long until we see results?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Timelines vary based on your starting point and local competition, but most organizations see meaningful movement in visibility and inquiry volume within the first few months as SEO, content, and reputation work build up. We report on progress every month.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you require a long-term contract?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">No. After an initial 90-day ramp-up period, every plan moves to month-to-month. We'd rather earn your business every month than lock you into a contract.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can this be bundled with website design?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes. Most hospice clients bundle website design with SEO since the two work best together, but we also support organizations who already have a site and just want SEO and AI search optimization managed.</div></div>
      </div>

    </div>
  </div>
</section>

<!-- INTERNAL LINKS -->
<section style="background:var(--cream);padding:48px 40px">
  <div class="container" style="text-align:center">
    <p class="section-label" style="justify-content:center">Related Services</p>
    <h2 class="section-h2" style="text-align:center">Explore More Ways We Help Senior Care Providers Grow</h2>
    <div style="display:flex;gap:20px;justify-content:center;flex-wrap:wrap;margin-top:32px">
      <a href="/web-design/homecare-website-design/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-laptop-code" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Homecare Website Design</div><div style="font-size:12px;color:var(--muted)">Professional, SEO-optimized websites</div></div>
      </a>
      <a href="/seo/home-care-seo/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-bullhorn" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Home Care Agency Marketing</div><div style="font-size:12px;color:var(--muted)">Full-service SEO built for home care</div></div>
      </a>
      <a href="/memory-care-marketing/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-brain" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Memory Care Marketing</div><div style="font-size:12px;color:var(--muted)">Marketing for memory care communities</div></div>
      </a>
      <a href="/nursing-home-marketing/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-house-medical" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Nursing Home Marketing</div><div style="font-size:12px;color:var(--muted)">Marketing for skilled nursing facilities</div></div>
      </a>
      <a href="/senior-living-marketing/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-building-columns" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Senior Living Marketing</div><div style="font-size:12px;color:var(--muted)">Marketing for independent &amp; retirement communities</div></div>
      </a>
      <a href="/assisted-living-marketing/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-hands-holding-circle" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Assisted Living Marketing</div><div style="font-size:12px;color:var(--muted)">Marketing for assisted living communities</div></div>
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
        <h2 class="section-h2">Let's Strengthen How Families<br>and Referral Partners <em>Find You</em></h2>
        <p class="cta-desc">Book a free 30-minute audit. We'll review your current digital presence, show you how it compares to other hospice providers in your area, and hand you a clear, respectful roadmap forward. No cost, no obligation.</p>
        <div class="cta-actions">
          <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Get My Free Hospice Marketing Audit</button>
        </div>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free audit &nbsp;·&nbsp; No obligation &nbsp;·&nbsp; 30-day satisfaction guarantee</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/home/cta-business-owner.jpg" alt="Hospice provider administrator growing their organization with Homecare Creators" title="Hospice provider growth">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Audit Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Website &amp; tone review</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Google visibility audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Referral-partner content review</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Growth roadmap</div></div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php include '../includes/footer.php'; ?>
