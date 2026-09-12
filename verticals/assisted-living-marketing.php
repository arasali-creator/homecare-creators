<?php
$page_canonical = "https://homecarecreators.com/assisted-living-marketing/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "Assisted Living Marketing Agency | Homecare Creators";
$page_desc = "Marketing built for assisted living communities. We help operators reach families comparing communities, book more tours, and rank on Google with a marketing partner built for senior care.";
$og_title = "Assisted Living Marketing Agency | Homecare Creators";
$og_desc = "Homecare Creators helps assisted living communities get found online, build family trust, and fill available units with a marketing partner built for senior care.";
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
    <div class="hero-breadcrumb"><a href="https://homecarecreators.com">Home</a> / <span>Assisted Living</span></div>
    <div class="hero-badge"><div class="hero-badge-pulse"></div>Assisted Living Community Marketing</div>
    <h1 class="hero-h1">Marketing for <em>Assisted Living</em><br>Communities</h1>
    <p class="hero-desc">Assisted living sits in the middle of a hard family decision: enough independence to feel like home, enough support to feel safe. Families researching assisted living compare multiple communities on care level, cost, and feel before ever booking a tour. We help assisted living communities show up clearly in that comparison and turn more of it into booked tours.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Get Your Free Assisted Living Marketing Audit</button>
      <a href="https://homecarecreators.com/#services" class="btn-secondary"><i class="fa-solid fa-play"></i>View Our Services</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Senior Care-Only Focus</div></div>
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
    <div class="ticker-item"><i class="fa-solid fa-hands-holding-circle"></i>Assisted Living Communities</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass"></i>Local SEO Specialists</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-calendar-check"></i>Tour Booking Optimization</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-globe"></i>Assisted Living Website Design</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>Google Maps Visibility</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>AI Search SEO for ChatGPT &amp; Perplexity</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-hands-holding-circle"></i>Assisted Living Communities</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass"></i>Local SEO Specialists</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-calendar-check"></i>Tour Booking Optimization</div>
    <div class="ticker-dot"></div>
    <div class="ticker-item"><i class="fa-solid fa-globe"></i>Assisted Living Website Design</div>
  </div>
</div>

<!-- MARKET SECTION -->
<section class="market-section">
  <div class="container">
    <div class="market-inner">
      <div class="market-body" data-reveal>
        <p class="section-label">The Assisted Living Market</p>
        <h2 class="section-h2">Why Assisted Living Marketing Needs <em>Both Sides of the Story</em></h2>
        <p>Assisted living searches blend independence and support in a way few other senior care categories do. Families want to know a loved one will keep their dignity and routine, while also getting help with medication, meals, and daily activities when needed. Sites that lean too far into "independent living" or too far into "medical care" both lose ground with families trying to picture their parent actually living there.</p>
        <p>Florida has one of the largest assisted living markets in the country, and communities compete for families comparing care level, cost, and community feel across several options before booking a single tour. A generic senior living website rarely answers the specific questions families ask about assisted living: what level of care is included, how staffing works, and what a typical day looks like.</p>
        <p>Homecare Creators builds marketing specifically for senior care operators. For assisted living, that means messaging that balances independence and support clearly, virtual tour content, and local SEO and AI search visibility that gets your community found and toured.</p>
      </div>
      <div class="market-facts" data-reveal style="transition-delay:.15s">
        <div class="fact-card"><div class="fact-num">Dual-Sided</div><h4>Search Intent</h4><p>Families weigh independence and support together, not care level alone, when comparing communities</p></div>
        <div class="fact-card"><div class="fact-num">Multi-Community</div><h4>Comparison Shopping</h4><p>Families typically shortlist and compare several communities on cost and care level before touring</p></div>
        <div class="fact-card"><div class="fact-num">Tour-First</div><h4>Conversion Point</h4><p>A booked tour is usually the real conversion event, not a phone call or form fill alone</p></div>
        <div class="fact-card"><div class="fact-num">Competitive</div><h4>Florida Market</h4><p>One of the country's largest assisted living markets means heavy competition for visibility</p></div>
      </div>
    </div>
  </div>
</section>

<!-- SERVICES -->
<section class="services-section">
  <div class="container">
    <div class="services-intro" data-reveal>
      <p class="section-label">Our Services for Assisted Living</p>
      <h2 class="section-h2">Everything Your Assisted Living Community Needs<br>to <em>Earn Family Trust Online</em></h2>
      <p class="section-sub">We build websites, run local SEO, and handle AI search optimization for assisted living communities, all built around how families actually compare independence and support.</p>
    </div>
    <div class="services-grid">
      <div class="svc-card" data-reveal style="transition-delay:.05s">
        <div class="svc-card-img">
          <img src="/images/home/service-website-dev.jpg" alt="Assisted living community website design services" title="Website design for assisted living communities">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-laptop-code"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">Assisted Living Website Design</div>
          <div class="svc-card-desc">A website that clearly explains care levels, staffing, and daily life, with a simple, low-friction path from browsing to booking a tour.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Care-level and pricing clarity built in</li>
            <li><i class="fa-solid fa-check"></i>Virtual tour and photo gallery integration</li>
            <li><i class="fa-solid fa-check"></i>Simple, low-friction tour request forms</li>
            <li><i class="fa-solid fa-check"></i>Staff and community life content</li>
            <li><i class="fa-solid fa-check"></i>Google Reviews widget built in</li>
            <li><i class="fa-solid fa-check"></i>Built for fast, mobile-first loading</li>
          </ul>
        </div>
      </div>
      <div class="svc-card" data-reveal style="transition-delay:.1s">
        <div class="svc-card-img">
          <img src="/images/home/service-local-seo.jpg" alt="Local SEO services helping assisted living communities rank on Google Maps" title="Local SEO for assisted living communities">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">Local SEO for Assisted Living</div>
          <div class="svc-card-desc">When a family searches "assisted living near me" or "assisted living facility [your city]," we work to get your community showing up on Google Maps and in organic search.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Google Business Profile management</li>
            <li><i class="fa-solid fa-check"></i>Assisted living-specific keyword targeting</li>
            <li><i class="fa-solid fa-check"></i>On-page SEO for every care-level and amenity page</li>
            <li><i class="fa-solid fa-check"></i>Review growth and reputation management</li>
            <li><i class="fa-solid fa-check"></i>Monthly ranking and visibility reports</li>
            <li><i class="fa-solid fa-check"></i>Competitor gap analysis</li>
          </ul>
        </div>
      </div>
      <div class="svc-card" data-reveal style="transition-delay:.15s">
        <div class="svc-card-img">
          <img src="/images/home/service-ai-search-seo.jpg" alt="AI Search SEO helping assisted living communities get cited by ChatGPT and Google AI" title="AI Search SEO for assisted living communities">
          <div class="svc-card-img-overlay"></div>
          <div class="svc-card-img-icon"><i class="fa-solid fa-brain"></i></div>
        </div>
        <div class="svc-card-body">
          <div class="svc-card-title">AI Search SEO for Assisted Living</div>
          <div class="svc-card-desc">Families now ask ChatGPT, Google AI Overviews, and Perplexity questions like "what's the difference between assisted living and independent living." We optimize your site so your community can be part of that answer.</div>
          <ul class="svc-card-features">
            <li><i class="fa-solid fa-check"></i>Google AI Overviews optimization</li>
            <li><i class="fa-solid fa-check"></i>FAQ schema built around assisted living search intent</li>
            <li><i class="fa-solid fa-check"></i>E-E-A-T authority and credential building</li>
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
      <h2 class="section-h2" style="color:#fff">Built to Understand<br><em>Assisted Living Marketing</em></h2>
      <p class="section-sub" style="color:rgba(255,255,255,.58)">Generalist marketing agencies treat assisted living like a hotel or generic healthcare facility. We build campaigns around the real, dual-sided decision families are making.</p>
    </div>
    <div class="why-grid" data-reveal style="transition-delay:.1s">
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-scale-balanced"></i></div><h4>Independence + Support Messaging</h4><p>We write and design around the real balance families are weighing, not generic "senior living" copy that leans too far either direction.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-calendar-check"></i></div><h4>Built for Tour Conversion</h4><p>We optimize your site and forms around getting a tour booked, the real conversion event for assisted living, not just a phone call or form fill.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-shield-heart"></i></div><h4>Trust Signal Building</h4><p>Staffing ratios, care plans, and reviews all matter heavily in this decision. We make sure those signals are clear and easy to find.</p></div>
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-handshake"></i></div><h4>No Long-Term Contracts</h4><p>We keep clients through results, not contracts. Every plan moves to month-to-month after an initial 90-day ramp-up period.</p></div>
    </div>
  </div>
</section>

<!-- FAQ -->
<section class="faq-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Assisted Living Marketing:<br><em>Questions Operators Ask</em></h2>
      <p class="section-sub">Answers to what assisted living community owners and administrators want to know before they sign on.</p>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How is marketing for assisted living different from home care marketing?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Assisted living marketing has to balance independence and support messaging clearly, since families are comparing a community lifestyle alongside a level of care. Prospects also typically compare several communities on cost and care level before booking a tour, so the site and content need to be built around that side-by-side comparison, not just an inquiry form.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How much does assisted living marketing cost?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Pricing is a flat monthly retainer with no hidden setup fees. What you pay depends on how competitive your local market is and whether you need a new website built alongside SEO. Book a free audit and we'll walk you through exact numbers for your community.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How long until we see results?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Timelines vary based on your starting point and how competitive your area is, but most communities begin seeing measurable movement in visibility and tour requests within the first few months as local SEO, content, and reputation work take hold. We report on progress every month so you always know where things stand.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you require a long-term contract?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">No. After an initial 90-day ramp-up period, every plan moves to month-to-month. We'd rather earn your business every month than lock you into a contract.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can this be bundled with website design?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes. Most assisted living clients bundle website design with SEO since the two work best together, but we also support communities who already have a site and just want SEO and AI search optimization managed.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can ChatGPT and Google AI recommend our community to families?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes, and it's a fast-growing channel. We optimize your site's structure, entity data, and FAQ content so AI tools like ChatGPT, Google AI Overviews, and Perplexity can accurately cite and recommend your community, not just traditional Google search.</div></div>
      </div>

    </div>
  </div>
</section>

<!-- INTERNAL LINKS -->
<section style="background:var(--cream);padding:48px 40px">
  <div class="container" style="text-align:center">
    <p class="section-label" style="justify-content:center">Related Services</p>
    <h2 class="section-h2" style="text-align:center">Explore More Ways We Help Senior Care Operators Grow</h2>
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
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Memory Care Marketing</div><div style="font-size:12px;color:var(--muted)">Marketing for memory &amp; dementia care</div></div>
      </a>
      <a href="/hospice-marketing/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-heart" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Hospice Marketing</div><div style="font-size:12px;color:var(--muted)">Compassionate marketing for hospice providers</div></div>
      </a>
      <a href="/nursing-home-marketing/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-house-medical" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Nursing Home Marketing</div><div style="font-size:12px;color:var(--muted)">Marketing for skilled nursing facilities</div></div>
      </a>
      <a href="/senior-living-marketing/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-building-columns" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Senior Living Marketing</div><div style="font-size:12px;color:var(--muted)">Marketing for independent &amp; retirement communities</div></div>
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
        <h2 class="section-h2">Ready to Help More Families<br>Choose Your <em>Community?</em></h2>
        <p class="cta-desc">Book a free 30-minute audit. We'll dig into your current digital presence, show you exactly what nearby communities are doing, and hand you a clear roadmap to earn more family trust online. No cost, no obligation.</p>
        <div class="cta-actions">
          <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Get My Free Assisted Living Marketing Audit</button>
        </div>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free audit &nbsp;·&nbsp; No obligation &nbsp;·&nbsp; 30-day satisfaction guarantee</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/home/cta-business-owner.jpg" alt="Assisted living community operator growing their business with Homecare Creators" title="Assisted living community operator growth">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot" style="color:var(--teal-lt);margin-right:4px"></i>Audit Includes</div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Website &amp; trust-signal analysis</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Google Maps visibility audit</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Competitor comparison</div></div>
          <div class="cta-badge-row"><div class="cta-badge-dot"></div><div class="cta-badge-text">Growth roadmap</div></div>
        </div>
      </div>
    </div>
  </div>
</section>


<?php include '../includes/footer.php'; ?>
