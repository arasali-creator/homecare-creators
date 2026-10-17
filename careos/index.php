<?php
$page_title = "CareOS — AI Practice Management for Home Care Agencies | Homecare Creators";
$page_desc = "CareOS is an AI-powered management platform built for home care agencies — scheduling, billing, EVV compliance, voice journaling, and predictive intelligence in one login.";
$page_canonical = "https://homecarecreators.com/careos/";
$og_title = "CareOS — AI Practice Management for Home Care Agencies";
$og_desc = "The AI brain for your home care agency: scheduling, billing, family portals, and compliance in one platform.";
$page_css = <<<CSS
/* HERO — light, modern */
.p-hero{background:linear-gradient(180deg,#fff 0%,var(--cream) 100%);position:relative;overflow:hidden;padding:150px 40px 80px}
.p-hero-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.05) 1px,transparent 1px);background-size:50px 50px;mask-image:radial-gradient(ellipse 70% 70% at 30% 20%,black 0%,transparent 75%)}
.p-hero-inner{position:relative;z-index:2;display:grid;grid-template-columns:1.1fr 1fr;gap:56px;align-items:center;max-width:1180px;margin:0 auto}
.p-hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:var(--muted);margin-bottom:20px}
.p-hero-breadcrumb a{color:var(--muted);text-decoration:none}
.p-hero-badge{display:inline-flex;align-items:center;gap:8px;background:rgba(29,158,117,.1);border:1px solid rgba(29,158,117,.25);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--teal);letter-spacing:.8px;text-transform:uppercase;margin-bottom:20px}
.p-hero h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(32px,4.4vw,52px);line-height:1.1;color:var(--forest);margin-bottom:18px}
.p-hero h1 em{font-style:italic;color:var(--teal)}
.p-hero-desc{font-size:18px;line-height:1.75;color:var(--muted);margin-bottom:32px}
.p-hero-actions{display:flex;gap:14px;flex-wrap:wrap}

/* Mockup placeholder — swap for real screenshots later */
.mockup-frame{background:#fff;border:1px solid var(--border);border-radius:14px;box-shadow:0 4px 16px rgba(10,46,30,.06);overflow:hidden}
.mockup-bar{background:var(--cream);padding:12px 16px;display:flex;gap:6px;border-bottom:1px solid var(--border)}
.mockup-dot{width:10px;height:10px;border-radius:50%;background:var(--border)}
.mockup-body{aspect-ratio:4/3;background:linear-gradient(135deg,var(--cream) 0%,var(--warm) 100%);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:10px;color:var(--muted);text-align:center;padding:20px}
.mockup-body i{font-size:40px;opacity:.25}
.mockup-body span{font-size:12.5px;font-weight:700;opacity:.5;font-family:'Plus Jakarta Sans',sans-serif;letter-spacing:.5px;text-transform:uppercase}

/* Feature grid */
.feat-section{background:var(--cream)}
.feat-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:44px}
.feat-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:28px}
.feat-card-icon{width:46px;height:46px;background:rgba(29,158,117,.1);border-radius:12px;display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:19px;margin-bottom:18px}
.feat-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--forest);margin-bottom:10px}
.feat-card p{font-size:14.5px;color:var(--muted);line-height:1.7}

/* Feature showcase (zigzag) */
.showrow-section{background:#fff}
.showrow{display:grid;grid-template-columns:1fr 1fr;gap:56px;align-items:center}
.showrow + .showrow{margin-top:80px}
.showrow-eyebrow{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:var(--teal);margin-bottom:12px}
.showrow h2{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(24px,3vw,34px);color:var(--forest);margin-bottom:16px;line-height:1.2}
.showrow-list{list-style:none;display:flex;flex-direction:column;gap:12px}
.showrow-list li{display:flex;align-items:flex-start;gap:10px;font-size:15px;color:var(--muted);line-height:1.6}
.showrow-list li i{color:var(--teal);margin-top:4px;flex-shrink:0}

/* Why cards */
.why-section{background:var(--cream)}
.why-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:48px}
.wc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:28px}
.wc-card-icon{width:42px;height:42px;background:rgba(29,158,117,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:17px;margin-bottom:16px}
.wc-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:10px}
.wc-card p{font-size:15px;color:var(--muted);line-height:1.75}

/* CTA (light) */
.p-cta-section{background:#fff;padding:96px 40px}
.p-cta-box{max-width:900px;margin:0 auto;background:var(--cream);border-radius:20px;padding:56px;text-align:center}
.p-cta-box h2{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(26px,3.4vw,38px);color:var(--forest);margin-bottom:14px}
.p-cta-box p{font-size:17px;color:var(--muted);margin-bottom:28px;max-width:560px;margin-left:auto;margin-right:auto}

/* Cross-link */
.crosslink{background:var(--cream);padding:48px 40px;text-align:center}
.crosslink p{font-size:15px;color:var(--muted);margin-bottom:12px}
.crosslink a{color:var(--teal);font-weight:700;text-decoration:none}

@media(max-width:960px){
  .p-hero-inner{grid-template-columns:1fr}
  .feat-grid{grid-template-columns:1fr 1fr}
  .showrow{grid-template-columns:1fr}
  .showrow .mockup-frame{order:-1}
  .why-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:640px){
  .p-hero{padding:120px 24px 56px}
  .feat-grid{grid-template-columns:1fr}
  .why-grid{grid-template-columns:1fr}
  .p-cta-box{padding:36px 24px}
}
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="p-hero">
  <div class="p-hero-grid"></div>
  <div class="p-hero-inner">
    <div data-reveal>
      <div class="p-hero-breadcrumb"><a href="/">Home</a> / <a href="/products/">Products</a> / <span style="color:var(--teal)">CareOS</span></div>
      <div class="p-hero-badge"><i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Now Available</div>
      <h1>The AI Brain for<br><em>Your Home Care Agency</em></h1>
      <p class="p-hero-desc">One platform for scheduling, billing, compliance, and family communication — built specifically for home care, not adapted from generic practice-management software.</p>
      <div class="p-hero-actions">
        <button class="btn-primary" onclick="openPopup('careos')"><i class="fa-solid fa-calendar-check"></i>Book a Demo</button>
        <a href="#features" class="btn-secondary" style="color:var(--forest);border-color:var(--border);background:#fff"><i class="fa-solid fa-arrow-down"></i>See What's Inside</a>
      </div>
    </div>
    <div data-reveal style="transition-delay:.1s">
      <div class="mockup-frame">
        <div class="mockup-bar"><span class="mockup-dot"></span><span class="mockup-dot"></span><span class="mockup-dot"></span></div>
        <div class="mockup-body"><i class="fa-solid fa-image"></i><span>CareOS Dashboard — Screenshot Coming Soon</span></div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURE GRID -->
<section class="feat-section" id="features">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">What's Inside</p>
      <h2 class="section-h2">Everything Your Agency<br>Runs On, <em>In One Login</em></h2>
    </div>
    <div class="feat-grid" data-reveal style="transition-delay:.1s">
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-calendar-days"></i></div>
        <h3>Smart Scheduling</h3>
        <p>Matches shifts to the right caregiver, flags conflicts before they happen, and remembers everyone's preferences.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-microphone"></i></div>
        <h3>Voice Shift Journal</h3>
        <p>A caregiver talks for 60 seconds and it becomes a compliance log, a family update, and incident flags automatically.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-heart"></i></div>
        <h3>Family Trust Portal</h3>
        <p>Families see shift updates as they happen, plus care summaries — the transparency that keeps them from shopping around.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
        <h3>Billing &amp; Payroll</h3>
        <p>Private pay, Medicaid, and long-term care billing in one system, with invoices and reconciliation running automatically.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-map-pin"></i></div>
        <h3>EVV &amp; Compliance</h3>
        <p>GPS check-in/out and a mandate tracker across all 50 states, so you're never caught off guard by a missed visit.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-brain"></i></div>
        <h3>Predictive Intelligence</h3>
        <p>Flags which clients are at risk of leaving, warns you before a caregiver quits, and forecasts revenue ahead of time.</p>
      </div>
    </div>
  </div>
</section>

<!-- FEATURE SHOWCASE -->
<section class="showrow-section">
  <div class="container">
    <div class="showrow" data-reveal>
      <div>
        <div class="showrow-eyebrow">Voice Shift Journal</div>
        <h2>Caregivers Talk. <em style="color:var(--teal);font-style:italic">CareOS Handles the Rest.</em></h2>
        <ul class="showrow-list">
          <li><i class="fa-solid fa-circle-check"></i>60-second voice note becomes a structured compliance log</li>
          <li><i class="fa-solid fa-circle-check"></i>Automatically drafts a family-friendly update from the same note</li>
          <li><i class="fa-solid fa-circle-check"></i>Flags incidents or concerns for office review in real time</li>
        </ul>
      </div>
      <div class="mockup-frame">
        <div class="mockup-bar"><span class="mockup-dot"></span><span class="mockup-dot"></span><span class="mockup-dot"></span></div>
        <div class="mockup-body"><i class="fa-solid fa-microphone"></i><span>Voice Journal — Screenshot Coming Soon</span></div>
      </div>
    </div>
    <div class="showrow" data-reveal>
      <div>
        <div class="showrow-eyebrow">Family Trust Portal</div>
        <h2>Give Families a <em style="color:var(--teal);font-style:italic">Reason to Stay.</em></h2>
        <ul class="showrow-list">
          <li><i class="fa-solid fa-circle-check"></i>Real-time shift updates families can check anytime</li>
          <li><i class="fa-solid fa-circle-check"></i>Care summaries that build confidence in your agency</li>
          <li><i class="fa-solid fa-circle-check"></i>Fewer "how's mom doing?" phone calls tying up your office</li>
        </ul>
      </div>
      <div class="mockup-frame">
        <div class="mockup-bar"><span class="mockup-dot"></span><span class="mockup-dot"></span><span class="mockup-dot"></span></div>
        <div class="mockup-body"><i class="fa-solid fa-heart"></i><span>Family Portal — Screenshot Coming Soon</span></div>
      </div>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="why-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Why It's Different</p>
      <h2 class="section-h2">Built for Home Care.<br>Not <em>Retrofitted for It.</em></h2>
    </div>
    <div class="why-grid" data-reveal style="transition-delay:.1s">
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-layer-group"></i></div>
        <h4>One Login, Not Six</h4>
        <p>Scheduling, billing, EVV, reviews, and family communication live in one system instead of five disconnected tools.</p>
      </div>
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-robot"></i></div>
        <h4>AI That Does Real Work</h4>
        <p>Voice journaling and predictive flags aren't gimmicks bolted onto old software — they're built into the core workflow.</p>
      </div>
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <h4>Compliance Built In</h4>
        <p>EVV and a 50-state mandate tracker mean you're not relying on a separate add-on or spreadsheet to stay compliant.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="p-cta-section">
  <div class="p-cta-box" data-reveal>
    <h2>See CareOS on Your Own Agency's Data</h2>
    <p>Book a free walkthrough and we'll show you exactly how CareOS fits your current workflow.</p>
    <button class="btn-primary" onclick="openPopup('careos')"><i class="fa-solid fa-calendar-check"></i>Book a Demo</button>
  </div>
</section>

<!-- CROSS-LINK -->
<div class="crosslink">
  <p>CareOS is part of our product family for home care agencies.</p>
  <a href="/products/">See all products &rarr;</a>
</div>

<?php include '../includes/footer.php'; ?>
