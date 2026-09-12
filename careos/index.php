<?php
$page_title = "CareOS — AI Practice Management for Home Care Agencies | Homecare Creators";
$page_desc = "CareOS is an AI-powered management platform built for home care agencies — scheduling, billing, EVV compliance, voice journaling, and predictive intelligence in one login. Coming Q3 2026.";
$page_canonical = "https://homecarecreators.com/careos/";
$og_title = "CareOS — AI Practice Management for Home Care Agencies";
$og_desc = "The AI brain for your home care agency: scheduling, billing, family portals, and compliance in one platform. Join the waitlist.";
$page_css = <<<CSS
/* HERO */
.hero{min-height:40vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 60px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:760px;margin:0 auto;text-align:center}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(30px,4.4vw,50px);line-height:1.1;color:#fff;margin-bottom:16px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:18px;line-height:1.75;color:rgba(255,255,255,.65)}

/* CAREOS (reused from homepage) */
.careos{background:#020d06;position:relative;overflow:hidden;padding:96px 40px}
.careos-stars{position:absolute;inset:0;background-image:radial-gradient(1px 1px at 10% 20%,rgba(255,255,255,.4) 0%,transparent 100%),radial-gradient(1px 1px at 30% 60%,rgba(255,255,255,.3) 0%,transparent 100%),radial-gradient(1px 1px at 60% 15%,rgba(255,255,255,.5) 0%,transparent 100%),radial-gradient(1px 1px at 80% 70%,rgba(255,255,255,.3) 0%,transparent 100%),radial-gradient(2px 2px at 20% 45%,rgba(46,198,143,.6) 0%,transparent 100%),radial-gradient(2px 2px at 70% 30%,rgba(46,198,143,.5) 0%,transparent 100%)}
.careos-glow{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:900px;height:500px;background:radial-gradient(ellipse,rgba(29,158,117,.12) 0%,transparent 70%)}
.careos-grid-lines{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.06) 1px,transparent 1px);background-size:48px 48px}
.careos-inner{position:relative;z-index:2}
.careos-top-badge{display:inline-flex;align-items:center;gap:10px;background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.35);padding:10px 22px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--gold-lt);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:32px;animation:shimmer 3s ease-in-out infinite}
.careos-top-badge-dot{width:8px;height:8px;border-radius:50%;background:var(--gold-lt);animation:pulse-ring 2s infinite}
.careos-headline{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(34px,4.6vw,60px);line-height:1.05;color:#fff;margin-bottom:16px;text-align:center}
.careos-headline em{font-style:italic;color:var(--teal-lt)}
.careos-subhead{font-size:18px;line-height:1.75;color:rgba(255,255,255,.65);max-width:640px;margin:0 auto 16px;text-align:center}
.careos-tagline{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--teal-lt);letter-spacing:1px;text-transform:uppercase;text-align:center;margin-bottom:56px;opacity:.8}
.careos-modules-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;margin-bottom:64px}
.careos-module{background:rgba(255,255,255,.03);border:1px solid rgba(29,158,117,.15);border-radius:var(--r);padding:24px;position:relative;overflow:hidden;transition:.3s}
.careos-module::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--teal),var(--teal-lt));opacity:0;transition:.3s}
.careos-module:hover{border-color:rgba(29,158,117,.35);background:rgba(255,255,255,.06);transform:translateY(-4px)}
.careos-module:hover::before{opacity:1}
.careos-module-icon{width:46px;height:46px;border-radius:13px;background:rgba(29,158,117,.12);display:flex;align-items:center;justify-content:center;color:var(--teal-lt);font-size:20px;margin-bottom:16px}
.careos-module-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:#fff;margin-bottom:8px}
.careos-module-desc{font-size:15px;line-height:1.65;color:rgba(255,255,255,.6)}
.module-badge{display:inline-block;margin-top:12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:9px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;padding:3px 9px;border-radius:5px}
.badge-ai{background:rgba(29,158,117,.2);color:var(--mint)}
.badge-new{background:rgba(201,168,76,.2);color:var(--gold-lt)}
.badge-core{background:rgba(255,255,255,.08);color:rgba(255,255,255,.5)}
.careos-cta-box{background:rgba(29,158,117,.08);border:1px solid rgba(29,158,117,.25);border-radius:24px;padding:48px;text-align:center;position:relative;overflow:hidden}
.careos-cta-box::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:conic-gradient(from 0deg,transparent 0%,rgba(29,158,117,.05) 25%,transparent 50%);animation:spin-slow 20s linear infinite}
.careos-cta-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:36px;color:#fff;margin-bottom:12px;position:relative;z-index:1}
.careos-cta-desc{font-size:18px;color:rgba(255,255,255,.6);margin-bottom:28px;position:relative;z-index:1}
.careos-cta-perks{display:flex;justify-content:center;gap:32px;flex-wrap:wrap;margin-bottom:32px;position:relative;z-index:1}
.careos-cta-perk{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--mint)}
.careos-cta-perk i{color:var(--teal-lt)}

/* WHY CAREOS */
.why-careos{background:var(--cream)}
.why-careos-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:48px}
.wc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:28px}
.wc-card-icon{width:42px;height:42px;background:rgba(29,158,117,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:17px;margin-bottom:16px}
.wc-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:10px}
.wc-card p{font-size:15px;color:var(--muted);line-height:1.75}

@media(max-width:900px){ .why-careos-grid{grid-template-columns:1fr 1fr} }
@media(max-width:640px){ .hero{padding:120px 24px 50px} .why-careos-grid{grid-template-columns:1fr} }
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-breadcrumb"><a href="https://homecarecreators.com">Home</a> / <span>CareOS</span></div>
    <h1 class="hero-h1">The AI Brain<br>for <em>Your Home Care Agency</em></h1>
    <p class="hero-desc">One platform for scheduling, billing, compliance, and family communication — built specifically for home care, not adapted from generic practice-management software.</p>
  </div>
</section>

<!-- CAREOS -->
<section class="careos" id="careos">
  <div class="careos-stars"></div>
  <div class="careos-glow"></div>
  <div class="careos-grid-lines"></div>
  <div class="container careos-inner">
    <div style="text-align:center" data-reveal>
      <div class="careos-top-badge">
        <div class="careos-top-badge-dot"></div>Coming Q3 2026 — Join the Waitlist Now
      </div>
      <h2 class="careos-headline">Meet <em>CareOS</em>:<br>The AI Brain for Your Agency</h2>
      <p class="careos-subhead">It's the first AI-powered management platform built just for homecare agencies. Scheduling, billing, voice AI, family portals, growth tools. One login, not six.</p>
      <p class="careos-tagline"><i class="fa-solid fa-circle-dot" style="margin-right:8px;color:var(--teal-lt)"></i>Early access members save 40% for life</p>
    </div>
    <div class="careos-modules-grid" data-reveal style="transition-delay:.1s">
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-calendar-days"></i></div>
        <div class="careos-module-name">Smart Scheduling</div>
        <div class="careos-module-desc">AI matches shifts to the right caregiver, flags conflicts before they happen, and remembers everyone's preferences so double bookings stop being a thing.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-microphone"></i></div>
        <div class="careos-module-name">Voice Shift Journal</div>
        <div class="careos-module-desc">A caregiver talks for 60 seconds and the AI turns it into compliance logs, a family update, and incident flags in under 8 seconds flat.</div><span class="module-badge badge-ai">AI Feature</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-heart"></i></div>
        <div class="careos-module-name">Family Trust Portal</div>
        <div class="careos-module-desc">Families see shift updates as they happen, plus AI care summaries and mood timelines. It's the kind of transparency that keeps them from shopping around.</div><span class="module-badge badge-new">Unique</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
        <div class="careos-module-name">Billing &amp; Payroll</div>
        <div class="careos-module-desc">Handles private pay, Medicaid, and long-term care billing in one system. Invoices go out automatically, ERA reconciliation runs itself, and it connects straight to Stripe.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-star"></i></div>
        <div class="careos-module-name">Auto Review Engine</div>
        <div class="careos-module-desc">Sends review requests the moment satisfaction is running high, and catches negative feedback before it ever hits Google.</div><span class="module-badge badge-ai">AI Feature</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-brain"></i></div>
        <div class="careos-module-name">Predictive Intelligence</div>
        <div class="careos-module-desc">Flags which clients are at risk of leaving, warns you before a caregiver quits, and forecasts revenue 90 days out.</div><span class="module-badge badge-ai">AI Feature</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-map-pin"></i></div>
        <div class="careos-module-name">EVV &amp; Compliance</div>
        <div class="careos-module-desc">GPS check-in and check-out, HHAeXchange sync, and a mandate tracker that covers all 50 states so you're never caught off guard by a missed visit.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-people-group"></i></div>
        <div class="careos-module-name">Caregiver Wellness</div>
        <div class="careos-module-desc">Picks up on burnout from voice tone and shift patterns before a caregiver walks out, saving you the $4,500–$8,000 it typically costs to replace one.</div><span class="module-badge badge-new">Industry First</span>
      </div>
    </div>
    <div class="careos-cta-box" data-reveal style="transition-delay:.2s">
      <h3 class="careos-cta-title">Be First. Save 40% for Life.</h3>
      <p class="careos-cta-desc">Get on the CareOS waitlist now and you'll never pay full price. The 40% lifetime discount locks in the day you sign up.</p>
      <div class="careos-cta-perks">
        <div class="careos-cta-perk"><i class="fa-solid fa-check-circle"></i>40% lifetime discount</div>
        <div class="careos-cta-perk"><i class="fa-solid fa-check-circle"></i>Free onboarding &amp; migration</div>
        <div class="careos-cta-perk"><i class="fa-solid fa-check-circle"></i>Priority feature access</div>
        <div class="careos-cta-perk"><i class="fa-solid fa-check-circle"></i>Founding member badge</div>
      </div>
      <button class="btn-primary" style="font-size:15px;padding:16px 40px;display:inline-flex;position:relative;z-index:2;" onclick="openPopup('waitlist')">
        <i class="fa-solid fa-rocket"></i>Join the CareOS Waitlist
      </button>
      <p style="margin-top:16px;font-size:12px;color:rgba(255,255,255,.35);font-family:'Plus Jakarta Sans',sans-serif;position:relative;z-index:2;">
        <i class="fa-solid fa-users" style="margin-right:5px;color:var(--teal)"></i>Homecare agencies are already joining the waitlist &mdash; get in before general availability</p>
    </div>
  </div>
</section>

<!-- WHY CAREOS -->
<section class="why-careos">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Why It's Different</p>
      <h2 class="section-h2">Built for Home Care.<br>Not <em>Retrofitted for It.</em></h2>
    </div>
    <div class="why-careos-grid" data-reveal style="transition-delay:.1s">
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-layer-group"></i></div>
        <h4>One Login, Not Six</h4>
        <p>Scheduling, billing, EVV, reviews, and family communication live in one system instead of five disconnected tools that don't talk to each other.</p>
      </div>
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-robot"></i></div>
        <h4>AI That Does Real Work</h4>
        <p>Voice journaling, predictive churn flags, and automated review requests aren't gimmicks bolted onto old software — they're built into the core workflow.</p>
      </div>
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <h4>Compliance Built In</h4>
        <p>EVV and a 50-state mandate tracker mean you're not relying on a separate add-on or spreadsheet to stay compliant.</p>
      </div>
    </div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
