<?php
$page_canonical = "https://homecarecreators.com/ai-search-seo/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "AI Search SEO for Home Care Agencies (GEO & AEO) | Homecare Creators";
$page_desc = "AI Search SEO for home care agencies: get found in ChatGPT, Google AI Overviews, and Perplexity. Entity building, FAQ schema, and GEO/AEO built for homecare.";
$og_title = "AI Search SEO for Home Care Agencies (GEO & AEO) | Homecare Creators";
$og_desc = "Families now ask AI tools for home care recommendations. We build the structured data and entity signals AI systems look for, so your agency has a real shot at being named.";
$og_image = "https://homecarecreators.com/images/home/service-ai-search-seo.jpg";
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
.hero-desc{font-size:19px;line-height:1.78;color:rgba(255,255,255,.65);max-width:600px;margin-bottom:40px;animation:fadeUp .8s .25s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .38s ease both;margin-bottom:52px}
.hero-proof{display:flex;gap:32px;flex-wrap:wrap;animation:fadeUp .8s .5s ease both}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:34px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-proof-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch}

/* WHAT-IS SECTION */
.market-section{background:#fff}
.market-inner{display:flex;flex-direction:column;gap:40px}
.market-body{text-align:center;max-width:780px;margin:0 auto}
.market-body .section-label{justify-content:center}
.market-body p{font-size:18px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.market-facts{display:grid;grid-template-columns:repeat(4,1fr);gap:16px;margin-top:8px}
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

/* RESPONSIVE */
@media(max-width:900px){
  .market-inner,.cta-inner{grid-template-columns:1fr;gap:40px}
  .services-grid,.why-grid{grid-template-columns:1fr 1fr}
  .market-facts{grid-template-columns:1fr 1fr}
  .hero{padding:110px 40px 60px}
}
@media(max-width:640px){
  .services-grid,.why-grid{grid-template-columns:1fr}
  .market-facts{grid-template-columns:1fr}
  .hero{padding:100px 24px 60px}
  section{padding:64px 24px}
  .cta-image{display:none}
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
    <div class="hero-breadcrumb"><a href="https://homecarecreators.com">Home</a> / <span>AI Search SEO</span></div>
    <div class="hero-badge"><div class="hero-badge-pulse"></div>GEO &amp; AEO for Home Care</div>
    <h1 class="hero-h1">AI Search SEO<br>for <em>Home Care Agencies</em></h1>
    <p class="hero-desc">Families researching care for a parent are increasingly asking ChatGPT, Google AI Overviews, and Perplexity for home care recommendations instead of scrolling through search results. Most home care agencies are completely invisible to these tools. We build the structured data, entity signals, and answer-formatted content that give your agency a real shot at being the one AI mentions.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup()"><i class="fa-solid fa-robot"></i>Get My Free AI Visibility Audit</button>
      <a href="#services" class="btn-secondary"><i class="fa-solid fa-play"></i>See What's Included</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item"><div class="hero-proof-num">100%</div><div class="hero-proof-label">Homecare-Only Focus</div></div>
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
      <div class="market-body" data-reveal>
        <p class="section-label">What Is AI Search SEO?</p>
        <h2 class="section-h2">GEO, AEO, and Why <em>AI Search</em> Is Different</h2>
        <p>AI Search SEO is the practice of structuring your agency's website and content so generative AI tools, like ChatGPT, Google's AI Overviews, and Perplexity, can accurately understand your agency, trust it, and cite it when someone asks a question. Inside the industry, you'll see this called GEO (Generative Engine Optimization) or AEO (Answer Engine Optimization). They describe the same shift: search results are no longer just a list of ten blue links, they're increasingly a single AI-written answer.</p>
        <p>Traditional SEO is built around ranking a specific page for a specific keyword. AI search optimization works differently. Generative models pull from structured data, entity information, third-party mentions, and clearly formatted answer content when they decide what to summarize and who to cite. That means the technical foundation, your schema markup, your Google Business Profile consistency, your FAQ content, and how clearly your site answers direct questions, matters just as much as the words on the page.</p>
        <p>This matters enormously for home care. Adult children researching care options for a parent often start with a conversational question, something like "what should I look for in a home care agency near me" or "how much does in-home care cost," typed directly into ChatGPT or asked through an AI Overview. If your agency's site isn't built to be understood and cited by those tools, you're not in the conversation at all, no matter how good your Google Maps ranking is.</p>
      </div>
      <div class="market-facts" data-reveal style="transition-delay:.15s">
        <div class="fact-card"><div class="fact-num">GEO</div><h4>Generative Engine Optimization</h4><p>Structuring content so generative AI tools can understand, summarize, and recommend your agency.</p></div>
        <div class="fact-card"><div class="fact-num">AEO</div><h4>Answer Engine Optimization</h4><p>Formatting your content, especially FAQs, to directly answer the exact questions families ask AI assistants.</p></div>
        <div class="fact-card"><div class="fact-num">Zero-Click</div><h4>A New Kind of Search</h4><p>More searches now end with an AI-generated answer instead of a list of links. If you're not part of that answer, the click never happens.</p></div>
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
            <li><i class="fa-solid fa-check"></i>Ongoing content expansion every month</li>
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
      <p class="section-label" style="color:var(--teal-lt)"><span style="background:var(--teal-lt);display:inline-block;width:24px;height:2px;border-radius:2px;margin-right:8px;vertical-align:middle"></span>Why This Matters</p>
      <h2 class="section-h2" style="color:#fff">Why AI Search Is <em>Worth Getting Ahead Of</em></h2>
      <p class="section-sub" style="color:rgba(255,255,255,.58)">We can't control what any AI model decides to say. What we can do is build the structured data and entity signals these systems look for, so your agency has a real, defensible shot at being part of the answer.</p>
    </div>
    <div class="why-grid" data-reveal style="transition-delay:.1s">
      <div class="why-card"><div class="why-card-icon"><i class="fa-solid fa-comments"></i></div><h4>Families Ask AI First</h4><p>A growing number of families now start their search for care with a conversational question to ChatGPT or a Google AI Overview instead of a traditional keyword search. If your site isn't structured for that, you're invisible before the process even starts.</p></div>
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

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">What is AI Search SEO (GEO/AEO), exactly?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Generative Engine Optimization (GEO) and Answer Engine Optimization (AEO) are the practices of structuring your website and content so tools like ChatGPT, Google AI Overviews, and Perplexity can understand, trust, and cite your agency when a family asks for a home care recommendation. Think of it as the AI-era counterpart to traditional SEO, built around how these tools actually pull and summarize information.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How is this different from regular local SEO?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Traditional SEO is built around ranking a page in a list of results for specific keywords. AI search optimization leans much more heavily on structured data, entity consistency, clear direct-answer content, and third-party authority signals, since that's what a generative model relies on to decide what to summarize and who to cite. We run both together, since they reinforce each other rather than compete.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">How long does it take to show up in AI answers?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Honestly, there's no fixed timeline the way there is for something like Google Maps rankings, since this is such a new field. Most agencies see early signals, like being pulled into an AI Overview or referenced by a chatbot, within a few months of consistent work. But the AI platforms control their own models and update them on their own schedule, so visibility can shift as those models change, not just based on our work.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you guarantee my agency will be cited by ChatGPT?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">No, and we won't pretend otherwise. No agency can honestly guarantee a placement inside a system it doesn't control. What we do guarantee is the work itself: building the structured data, entity signals, and answer-formatted content that give your agency a real, defensible shot at being included. Every engagement is also backed by our standard 30-day satisfaction guarantee.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">What's included in the AI Search SEO service?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">AI Overviews and ChatGPT citation optimization, entity and knowledge graph building, FAQ schema and structured content, and a monthly AI visibility report showing what's changed. We also coordinate this work with your local SEO so both channels reinforce each other instead of working in isolation.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Can this be bundled with local SEO or website design?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">Yes. Most agencies bundle AI Search SEO with local SEO and/or website design, since all three draw on the same technical foundation and content. If you're already a local SEO client, we can also add AI Search SEO on to your existing retainer.</div></div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">Do you require a long-term contract?</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div>
        <div class="faq-a"><div class="faq-a-inner">No. Like the rest of our services, AI Search SEO starts with a 90-day ramp-up period so the foundational work, schema, entity data, and structured content, can be built properly. After that, everything moves to month-to-month.</div></div>
      </div>

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
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Home Care Agency SEO</div><div style="font-size:12px;color:var(--muted)">Full-service SEO built for home care</div></div>
      </a>
      <a href="/web-design/homecare-website-design/" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-laptop-code" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Homecare Website Design</div><div style="font-size:12px;color:var(--muted)">Professional, SEO-optimized websites</div></div>
      </a>
      <a href="/seo/local-seo-for-home-care-agencies" style="display:inline-flex;align-items:center;gap:10px;background:#fff;border:1px solid var(--border);border-radius:14px;padding:20px 28px;text-decoration:none;transition:.25s" onmouseover="this.style.borderColor='var(--teal)'" onmouseout="this.style.borderColor='var(--border)'">
        <i class="fa-solid fa-magnifying-glass-chart" style="font-size:20px;color:var(--teal)"></i>
        <div><div style="font-family:Syne,sans-serif;font-weight:700;font-size:14px;color:var(--forest)">Local SEO for Homecare</div><div style="font-size:12px;color:var(--muted)">Rank on Google Maps in your service area</div></div>
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
        <img src="/images/home/cta-business-owner.jpg" alt="Home care agency owner reviewing their AI search visibility with Homecare Creators" title="Home care agency owner growth with AI Search SEO">
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
