<?php
$page_title = "Care Scheduling — Shift Scheduling Built for Home Care | Homecare Creators";
$page_desc = "Care Scheduling is a shift scheduling system built for home care agencies — caregiver-to-client matching, conflict alerts, mobile clock-in/out, and family visibility. Coming soon.";
$page_canonical = "https://homecarecreators.com/products/care-scheduling/";
$og_title = "Care Scheduling — Shift Scheduling Built for Home Care";
$og_desc = "Caregiver-to-client matching, conflict alerts, and mobile clock-in/out, built specifically for home care agencies. Join the waitlist.";
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

/* FEATURE SHOWCASE (same recipe as /careos/) */
.showcase{background:#020d06;position:relative;overflow:hidden;padding:96px 40px}
.showcase-stars{position:absolute;inset:0;background-image:radial-gradient(1px 1px at 10% 20%,rgba(255,255,255,.4) 0%,transparent 100%),radial-gradient(1px 1px at 30% 60%,rgba(255,255,255,.3) 0%,transparent 100%),radial-gradient(1px 1px at 60% 15%,rgba(255,255,255,.5) 0%,transparent 100%),radial-gradient(2px 2px at 20% 45%,rgba(46,198,143,.6) 0%,transparent 100%),radial-gradient(2px 2px at 70% 30%,rgba(46,198,143,.5) 0%,transparent 100%)}
.showcase-glow{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:900px;height:500px;background:radial-gradient(ellipse,rgba(29,158,117,.12) 0%,transparent 70%)}
.showcase-grid-lines{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.06) 1px,transparent 1px);background-size:48px 48px}
.showcase-inner{position:relative;z-index:2}
.showcase-badge{display:inline-flex;align-items:center;gap:10px;background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.35);padding:10px 22px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--gold-lt);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:32px;animation:shimmer 3s ease-in-out infinite}
.showcase-badge-dot{width:8px;height:8px;border-radius:50%;background:var(--gold-lt);animation:pulse-ring 2s infinite}
.showcase-headline{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(32px,4.4vw,54px);line-height:1.08;color:#fff;margin-bottom:16px;text-align:center}
.showcase-headline em{font-style:italic;color:var(--teal-lt)}
.showcase-subhead{font-size:18px;line-height:1.75;color:rgba(255,255,255,.65);max-width:640px;margin:0 auto 56px;text-align:center}
.module-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;margin-bottom:64px}
.module{background:rgba(255,255,255,.03);border:1px solid rgba(29,158,117,.15);border-radius:var(--r);padding:24px;position:relative;overflow:hidden;transition:.3s}
.module::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--teal),var(--teal-lt));opacity:0;transition:.3s}
.module:hover{border-color:rgba(29,158,117,.35);background:rgba(255,255,255,.06);transform:translateY(-4px)}
.module:hover::before{opacity:1}
.module-icon{width:46px;height:46px;border-radius:13px;background:rgba(29,158,117,.12);display:flex;align-items:center;justify-content:center;color:var(--teal-lt);font-size:20px;margin-bottom:16px}
.module-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:#fff;margin-bottom:8px}
.module-desc{font-size:15px;line-height:1.65;color:rgba(255,255,255,.6)}
.module-badge{display:inline-block;margin-top:12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:9px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;padding:3px 9px;border-radius:5px}
.badge-ai{background:rgba(29,158,117,.2);color:var(--mint)}
.badge-new{background:rgba(201,168,76,.2);color:var(--gold-lt)}
.badge-core{background:rgba(255,255,255,.08);color:rgba(255,255,255,.5)}
.showcase-cta-box{background:rgba(29,158,117,.08);border:1px solid rgba(29,158,117,.25);border-radius:24px;padding:48px;text-align:center;position:relative;overflow:hidden}
.showcase-cta-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:32px;color:#fff;margin-bottom:12px;position:relative;z-index:1}
.showcase-cta-desc{font-size:18px;color:rgba(255,255,255,.6);margin-bottom:28px;position:relative;z-index:1;max-width:560px;margin-left:auto;margin-right:auto}

/* WHY SECTION */
.why-section{background:var(--cream)}
.why-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:48px}
.wc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:28px}
.wc-card-icon{width:42px;height:42px;background:rgba(29,158,117,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:17px;margin-bottom:16px}
.wc-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:10px}
.wc-card p{font-size:15px;color:var(--muted);line-height:1.75}

/* CROSS-LINK */
.crosslink{background:#fff;padding:56px 40px;text-align:center;border-top:1px solid var(--border)}
.crosslink p{font-size:15px;color:var(--muted);margin-bottom:16px}
.crosslink a{color:var(--teal);font-weight:700;text-decoration:none}

@media(max-width:900px){.why-grid{grid-template-columns:1fr 1fr}}
@media(max-width:640px){.hero{padding:120px 24px 50px}.why-grid{grid-template-columns:1fr}}
CSS;
include '../../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-breadcrumb"><a href="/">Home</a> / <a href="/products/">Products</a> / <span style="color:var(--teal-lt)">Care Scheduling</span></div>
    <h1 class="hero-h1">Scheduling Built for<br><em>Home Care Shifts</em></h1>
    <p class="hero-desc">Care Scheduling matches caregivers to clients, flags conflicts before they happen, and gives families visibility into who's coming and when — built for home care, not adapted from a generic calendar app.</p>
  </div>
</section>

<!-- FEATURE SHOWCASE -->
<section class="showcase">
  <div class="showcase-stars"></div>
  <div class="showcase-glow"></div>
  <div class="showcase-grid-lines"></div>
  <div class="container showcase-inner">
    <div style="text-align:center" data-reveal>
      <div class="showcase-badge"><div class="showcase-badge-dot"></div>Coming Soon — Join the Waitlist Now</div>
      <h2 class="showcase-headline">Meet <em>Care Scheduling</em>:<br>Shift Scheduling for Home Care</h2>
      <p class="showcase-subhead">Double bookings, missed shifts, and scheduling by spreadsheet cost agencies time and trust. Care Scheduling is built around how home care shifts actually work.</p>
    </div>
    <div class="module-grid" data-reveal style="transition-delay:.1s">
      <div class="module">
        <div class="module-icon"><i class="fa-solid fa-people-arrows"></i></div>
        <div class="module-name">Caregiver-Client Matching</div>
        <div class="module-desc">Matches shifts to caregivers based on skills, location, and client preference instead of whoever happens to be free.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="module">
        <div class="module-icon"><i class="fa-solid fa-triangle-exclamation"></i></div>
        <div class="module-name">Conflict &amp; Double-Booking Alerts</div>
        <div class="module-desc">Flags scheduling conflicts the moment they're created, before a caregiver shows up to find someone else already there.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="module">
        <div class="module-icon"><i class="fa-solid fa-mobile-screen"></i></div>
        <div class="module-name">Mobile Clock In/Out</div>
        <div class="module-desc">Caregivers clock in and out from their phone at the start and end of every visit, so you always know a shift actually happened.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="module">
        <div class="module-icon"><i class="fa-solid fa-arrow-right-arrow-left"></i></div>
        <div class="module-name">Shift Swap Requests</div>
        <div class="module-desc">Caregivers can request a swap or cover from their phone, and you approve it in one tap instead of a chain of phone calls.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="module">
        <div class="module-icon"><i class="fa-solid fa-heart"></i></div>
        <div class="module-name">Family Schedule Visibility</div>
        <div class="module-desc">Families can see who's scheduled to visit and when, cutting down on "is someone coming today?" phone calls to the office.</div><span class="module-badge badge-new">Unique</span>
      </div>
      <div class="module">
        <div class="module-icon"><i class="fa-solid fa-chart-line"></i></div>
        <div class="module-name">Predictive Coverage Gaps</div>
        <div class="module-desc">Spots upcoming shifts that don't have a caregiver assigned yet, so you can fill them days ahead instead of scrambling same-day.</div><span class="module-badge badge-ai">AI Feature</span>
      </div>
    </div>
    <div class="showcase-cta-box" data-reveal style="transition-delay:.2s">
      <h3 class="showcase-cta-title">Be First to Try Care Scheduling</h3>
      <p class="showcase-cta-desc">Join the waitlist and we'll reach out as soon as early access opens for home care agencies.</p>
      <button class="btn-primary" style="font-size:15px;padding:16px 40px;display:inline-flex;position:relative;z-index:2" onclick="openPopup('waitlist')">
        <i class="fa-solid fa-rocket"></i>Join the Care Scheduling Waitlist
      </button>
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
        <p>Clock-ins and shift swaps happen from a caregiver's own phone, cutting down on calls to the office for routine schedule changes.</p>
      </div>
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-heart"></i></div>
        <h4>Families See What's Coming</h4>
        <p>Schedule visibility for families builds trust and cuts down on the "who's coming today?" calls your office handles every day.</p>
      </div>
    </div>
  </div>
</section>

<!-- CROSS-LINK -->
<div class="crosslink">
  <p>Care Scheduling is part of the CareOS family of tools built for home care agencies.</p>
  <a href="/careos/">See the full CareOS platform &rarr;</a>
</div>

<?php include '../../includes/footer.php'; ?>
