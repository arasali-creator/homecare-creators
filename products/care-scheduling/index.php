<?php
$page_title = "Care Scheduling — Shift Scheduling Built for Home Care | Homecare Creators";
$page_desc = "Care Scheduling is a shift scheduling system built for home care agencies — caregiver-to-client matching, conflict alerts, mobile clock-in/out, and family visibility.";
$page_canonical = "https://homecarecreators.com/products/care-scheduling/";
$og_title = "Care Scheduling — Shift Scheduling Built for Home Care";
$og_desc = "Caregiver-to-client matching, conflict alerts, and mobile clock-in/out, built specifically for home care agencies.";
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
.mockup-frame{background:#fff;border:1px solid var(--border);border-radius:18px;box-shadow:0 30px 80px rgba(10,46,30,.1);overflow:hidden}
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
.p-cta-section{background:#fff;padding:0 40px 96px}
.p-cta-box{max-width:900px;margin:0 auto;background:linear-gradient(135deg,rgba(29,158,117,.06),rgba(201,168,76,.06));border:1px solid rgba(29,158,117,.2);border-radius:28px;padding:56px;text-align:center}
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
include '../../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="p-hero">
  <div class="p-hero-grid"></div>
  <div class="p-hero-inner">
    <div data-reveal>
      <div class="p-hero-breadcrumb"><a href="/">Home</a> / <a href="/products/">Products</a> / <span style="color:var(--teal)">Care Scheduling</span></div>
      <div class="p-hero-badge"><i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Now Available</div>
      <h1>Scheduling Built for<br><em>Home Care Shifts</em></h1>
      <p class="p-hero-desc">Care Scheduling matches caregivers to clients, flags conflicts before they happen, and gives families visibility into who's coming and when — built for home care, not adapted from a generic calendar app.</p>
      <div class="p-hero-actions">
        <button class="btn-primary" onclick="openPopup('care-scheduling')"><i class="fa-solid fa-calendar-check"></i>Book a Demo</button>
        <a href="#features" class="btn-secondary" style="color:var(--forest);border-color:var(--border);background:#fff"><i class="fa-solid fa-arrow-down"></i>See What's Inside</a>
      </div>
    </div>
    <div data-reveal style="transition-delay:.1s">
      <div class="mockup-frame">
        <div class="mockup-bar"><span class="mockup-dot"></span><span class="mockup-dot"></span><span class="mockup-dot"></span></div>
        <div class="mockup-body"><i class="fa-solid fa-image"></i><span>Care Scheduling Calendar — Screenshot Coming Soon</span></div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURE GRID -->
<section class="feat-section" id="features">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">What's Inside</p>
      <h2 class="section-h2">Every Shift, <em>Covered</em><br>— Without the Chaos</h2>
    </div>
    <div class="feat-grid" data-reveal style="transition-delay:.1s">
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-people-arrows"></i></div>
        <h3>Caregiver-Client Matching</h3>
        <p>Matches shifts to caregivers based on skills, location, and client preference instead of whoever happens to be free.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <h3>Conflict &amp; Double-Booking Alerts</h3>
        <p>Flags scheduling conflicts the moment they're created, before a caregiver shows up to find someone else already there.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-mobile-screen"></i></div>
        <h3>Mobile Clock In/Out</h3>
        <p>Caregivers clock in and out from their phone at every visit, so you always know a shift actually happened.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
        <h3>Shift Swap Requests</h3>
        <p>Caregivers can request a swap or cover from their phone, and you approve it in one tap.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-heart"></i></div>
        <h3>Family Schedule Visibility</h3>
        <p>Families can see who's scheduled to visit and when, cutting down on "is someone coming today?" calls.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-chart-line"></i></div>
        <h3>Predictive Coverage Gaps</h3>
        <p>Spots upcoming shifts that don't have a caregiver assigned yet, so you can fill them days ahead.</p>
      </div>
    </div>
  </div>
</section>

<!-- FEATURE SHOWCASE -->
<section class="showrow-section">
  <div class="container">
    <div class="showrow" data-reveal>
      <div>
        <div class="showrow-eyebrow">Caregiver-Client Matching</div>
        <h2>Matching, <em style="color:var(--teal);font-style:italic">Not Just Booking.</em></h2>
        <ul class="showrow-list">
          <li><i class="fa-solid fa-circle-check"></i>Matches on skills, location, and client preference — not just availability</li>
          <li><i class="fa-solid fa-circle-check"></i>Keeps continuity of care intact across repeat visits</li>
          <li><i class="fa-solid fa-circle-check"></i>Conflict alerts catch problems before they reach a client's door</li>
        </ul>
      </div>
      <div class="mockup-frame">
        <div class="mockup-bar"><span class="mockup-dot"></span><span class="mockup-dot"></span><span class="mockup-dot"></span></div>
        <div class="mockup-body"><i class="fa-solid fa-people-arrows"></i><span>Matching View — Screenshot Coming Soon</span></div>
      </div>
    </div>
    <div class="showrow" data-reveal>
      <div>
        <div class="showrow-eyebrow">Mobile Clock In/Out</div>
        <h2>Caregivers Can <em style="color:var(--teal);font-style:italic">Self-Serve.</em></h2>
        <ul class="showrow-list">
          <li><i class="fa-solid fa-circle-check"></i>Clock in and out from their own phone at every visit</li>
          <li><i class="fa-solid fa-circle-check"></i>Request shift swaps without a chain of phone calls to the office</li>
          <li><i class="fa-solid fa-circle-check"></i>Fewer routine schedule questions landing on your front desk</li>
        </ul>
      </div>
      <div class="mockup-frame">
        <div class="mockup-bar"><span class="mockup-dot"></span><span class="mockup-dot"></span><span class="mockup-dot"></span></div>
        <div class="mockup-body"><i class="fa-solid fa-mobile-screen"></i><span>Mobile App — Screenshot Coming Soon</span></div>
      </div>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="why-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Why It's Different</p>
      <h2 class="section-h2">Built for Home Care Shifts.<br><em>Not a Generic Calendar.</em></h2>
    </div>
    <div class="why-grid" data-reveal style="transition-delay:.1s">
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-people-arrows"></i></div>
        <h4>Matching, Not Just Booking</h4>
        <p>It's built around who should go to a visit, not just when a slot is free — so continuity of care stays intact.</p>
      </div>
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-mobile-screen"></i></div>
        <h4>Caregivers Can Self-Serve</h4>
        <p>Clock-ins and shift swaps happen from a caregiver's own phone, cutting down on calls to the office.</p>
      </div>
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-heart"></i></div>
        <h4>Families See What's Coming</h4>
        <p>Schedule visibility for families builds trust and cuts down on the "who's coming today?" calls.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="p-cta-section">
  <div class="p-cta-box" data-reveal>
    <h2>See Care Scheduling on Your Own Shifts</h2>
    <p>Book a free walkthrough and we'll show you exactly how Care Scheduling fits your agency's workflow.</p>
    <button class="btn-primary" onclick="openPopup('care-scheduling')"><i class="fa-solid fa-calendar-check"></i>Book a Demo</button>
  </div>
</section>

<!-- CROSS-LINK -->
<div class="crosslink">
  <p>Care Scheduling is part of our product family for home care agencies.</p>
  <a href="/products/">See all products &rarr;</a>
</div>

<?php include '../../includes/footer.php'; ?>
