<?php
$page_title = "CareMails — Email Built for Home Care Teams | Homecare Creators";
$page_desc = "CareMails is an all-in-one email system for home care agencies — one shared inbox for family communication and staff coordination, with templates built for home care.";
$page_canonical = "https://homecarecreators.com/products/caremails/";
$og_title = "CareMails — Email Built for Home Care Teams";
$og_desc = "One shared inbox for family updates and staff coordination, built specifically for home care agencies.";
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
.p-cta-section{background:#fff;padding:0 40px 96px}
.p-cta-box{max-width:900px;margin:0 auto;background:var(--cream);border:2px solid var(--forest);border-radius:20px;padding:56px;text-align:center}
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
      <div class="p-hero-breadcrumb"><a href="/">Home</a> / <a href="/products/">Products</a> / <span style="color:var(--teal)">CareMails</span></div>
      <div class="p-hero-badge"><i class="fa-solid fa-circle-check" style="margin-right:4px"></i>Now Available</div>
      <h1>One Inbox for Your<br>Whole <em>Home Care Team</em></h1>
      <p class="p-hero-desc">CareMails replaces scattered personal inboxes with one shared, professional email system built for how home care agencies actually communicate — with families and with staff.</p>
      <div class="p-hero-actions">
        <button class="btn-primary" onclick="openPopup('caremails')"><i class="fa-solid fa-calendar-check"></i>Book a Demo</button>
        <a href="#features" class="btn-secondary" style="color:var(--forest);border-color:var(--border);background:#fff"><i class="fa-solid fa-arrow-down"></i>See What's Inside</a>
      </div>
    </div>
    <div data-reveal style="transition-delay:.1s">
      <div class="mockup-frame">
        <div class="mockup-bar"><span class="mockup-dot"></span><span class="mockup-dot"></span><span class="mockup-dot"></span></div>
        <div class="mockup-body"><i class="fa-solid fa-image"></i><span>CareMails Inbox — Screenshot Coming Soon</span></div>
      </div>
    </div>
  </div>
</section>

<!-- FEATURE GRID -->
<section class="feat-section" id="features">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">What's Inside</p>
      <h2 class="section-h2">Everything Your Team<br>Needs, <em>In One Inbox</em></h2>
    </div>
    <div class="feat-grid" data-reveal style="transition-delay:.1s">
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-inbox"></i></div>
        <h3>Shared Team Inbox</h3>
        <p>Every family and referral email lands in one place your whole team can see — not locked in one caregiver's personal account.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-file-lines"></i></div>
        <h3>Branded Templates</h3>
        <p>Welcome emails, schedule changes, and care plan updates go out looking professional every time.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-wand-magic-sparkles"></i></div>
        <h3>Automated Family Updates</h3>
        <p>Tie routine updates to shift completions so families hear from you consistently, without anyone having to remember.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-users-rectangle"></i></div>
        <h3>Internal Staff Threads</h3>
        <p>Keep staff coordination separate from family-facing messages, so internal notes never get forwarded to the wrong person.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-bell"></i></div>
        <h3>Follow-Up Reminders</h3>
        <p>Get flagged when a family email hasn't been answered, so inquiries and concerns stop slipping through the cracks.</p>
      </div>
      <div class="feat-card">
        <div class="feat-card-icon"><i class="fa-solid fa-robot"></i></div>
        <h3>Smart Reply Suggestions</h3>
        <p>Get a drafted response ready for common questions, so your team replies faster without starting from a blank screen.</p>
      </div>
    </div>
  </div>
</section>

<!-- FEATURE SHOWCASE -->
<section class="showrow-section">
  <div class="container">
    <div class="showrow" data-reveal>
      <div>
        <div class="showrow-eyebrow">Shared Team Inbox</div>
        <h2>Stop Losing Emails in <em style="color:var(--teal);font-style:italic">Someone's Personal Account.</em></h2>
        <ul class="showrow-list">
          <li><i class="fa-solid fa-circle-check"></i>Every family and referral email visible to the whole team</li>
          <li><i class="fa-solid fa-circle-check"></i>Nothing disappears when a caregiver changes roles or leaves</li>
          <li><i class="fa-solid fa-circle-check"></i>Full history stays with your agency, not an individual inbox</li>
        </ul>
      </div>
      <div class="mockup-frame">
        <div class="mockup-bar"><span class="mockup-dot"></span><span class="mockup-dot"></span><span class="mockup-dot"></span></div>
        <div class="mockup-body"><i class="fa-solid fa-inbox"></i><span>Shared Inbox — Screenshot Coming Soon</span></div>
      </div>
    </div>
    <div class="showrow" data-reveal>
      <div>
        <div class="showrow-eyebrow">Automated Family Updates</div>
        <h2>Consistent Updates, <em style="color:var(--teal);font-style:italic">Without the Reminders.</em></h2>
        <ul class="showrow-list">
          <li><i class="fa-solid fa-circle-check"></i>Routine updates tied directly to shift completions</li>
          <li><i class="fa-solid fa-circle-check"></i>Branded, consistent formatting every single time</li>
          <li><i class="fa-solid fa-circle-check"></i>One less thing for your office staff to remember to send</li>
        </ul>
      </div>
      <div class="mockup-frame">
        <div class="mockup-bar"><span class="mockup-dot"></span><span class="mockup-dot"></span><span class="mockup-dot"></span></div>
        <div class="mockup-body"><i class="fa-solid fa-wand-magic-sparkles"></i><span>Automated Updates — Screenshot Coming Soon</span></div>
      </div>
    </div>
  </div>
</section>

<!-- WHY -->
<section class="why-section">
  <div class="container">
    <div style="text-align:center" data-reveal>
      <p class="section-label" style="justify-content:center">Why It's Different</p>
      <h2 class="section-h2">Built for Home Care Email.<br><em>Not Generic Inbox Tools.</em></h2>
    </div>
    <div class="why-grid" data-reveal style="transition-delay:.1s">
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-inbox"></i></div>
        <h4>One Inbox, Not Six</h4>
        <p>Stop relying on individual caregivers' personal email accounts to represent your agency.</p>
      </div>
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-shield-halved"></i></div>
        <h4>Nothing Falls Through</h4>
        <p>Follow-up reminders and shared visibility mean a family inquiry never quietly disappears.</p>
      </div>
      <div class="wc-card">
        <div class="wc-card-icon"><i class="fa-solid fa-star"></i></div>
        <h4>Looks Professional, Every Time</h4>
        <p>Branded templates mean every family gets a consistent, polished experience.</p>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="p-cta-section">
  <div class="p-cta-box" data-reveal>
    <h2>See CareMails in Your Own Inbox</h2>
    <p>Book a free walkthrough and we'll show you exactly how CareMails fits your team's communication today.</p>
    <button class="btn-primary" onclick="openPopup('caremails')"><i class="fa-solid fa-calendar-check"></i>Book a Demo</button>
  </div>
</section>

<!-- CROSS-LINK -->
<div class="crosslink">
  <p>CareMails is part of our product family for home care agencies.</p>
  <a href="/products/">See all products &rarr;</a>
</div>

<?php include '../../includes/footer.php'; ?>
