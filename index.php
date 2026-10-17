<?php
$page_title    = "Homecare Creators: Marketing for Home Care Agencies";
$page_desc     = "A marketing agency built exclusively for home care agencies nationwide - SEO, websites, and AI search optimization.";
$page_canonical = "https://homecarecreators.com/";
$og_title      = "Homecare Creators: Marketing for Home Care Agencies";
$og_desc       = "A marketing agency built 100% for homecare - website design, local SEO, and AI search SEO.";

$page_css = <<<CSS
/* ── HERO ── */
.hero{background:var(--forest);position:relative;overflow:hidden;padding:0}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.06) 1px,transparent 1px);background-size:56px 56px;pointer-events:none}
.hero-grid{position:relative;z-index:2;max-width:1360px;margin:0 auto;display:grid;grid-template-columns:1.05fr .95fr;align-items:stretch;min-height:680px}
.hero-left{padding:150px 24px 72px 56px;display:flex;flex-direction:column;justify-content:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:24px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(30px,3.2vw,46px);line-height:1.1;margin:0;animation:fadeUp .8s .1s ease both;white-space:nowrap}
.hero-h1-line1{display:block;color:#fff}
.hero-rotator{display:block;position:relative;width:100%;height:1.2em;margin-top:12px;overflow:hidden}
.hero-rotator-word{position:absolute;inset:0;display:flex;align-items:center;justify-content:flex-start;color:var(--teal-lt);opacity:0;transform:translateY(45%);transition:transform .5s cubic-bezier(.4,0,.2,1),opacity .4s ease}
.hero-rotator-word.is-active{opacity:1;transform:translateY(0)}
.hero-rotator-word.is-leaving{opacity:0;transform:translateY(-45%)}
.hero-swoosh{display:block;margin:10px 0 0}
.hero-swoosh path{stroke:var(--gold-lt)}
.hero-desc{font-size:17px;line-height:1.7;color:rgba(255,255,255,.62);max-width:460px;margin:20px 0 32px;animation:fadeUp .8s .3s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .4s ease both}
.hero-actions .btn-primary{border-radius:100px;padding:16px 32px}
.hero-right{position:relative;min-height:560px;overflow:hidden}
.hero-right img{position:absolute;inset:0;width:100%;height:100%;object-fit:cover;object-position:center 22%;transform:scale(1.15);display:block}
.hero-right::before{content:'';position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,var(--forest) 0%,rgba(10,46,30,0) 8%);pointer-events:none}

/* ── WHY US ── */
.why{background:#fff}
.why-grid{display:grid;grid-template-columns:380px 1fr;gap:64px;align-items:center}
.why-photo-wrap{position:relative}
.why-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/5;box-shadow:0 24px 70px rgba(10,46,30,.15)}
.why-photo img{width:100%;height:100%;object-fit:cover;display:block}
.why-photo-stat{position:absolute;bottom:-20px;left:-20px;background:#fff;border-radius:16px;padding:18px 22px;box-shadow:0 12px 40px rgba(10,46,30,.16);border:1px solid var(--border)}
.why-photo-stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:30px;color:var(--teal);line-height:1}
.why-photo-stat-label{font-size:11px;color:var(--muted);font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;margin-top:4px;line-height:1.4}
.why-content .section-sub{margin-bottom:24px}

/* ── SERVICES ── */
.services{background:var(--cream)}
.services-header{text-align:center;max-width:720px;margin:0 auto 56px}
.svc-grid{display:flex;flex-wrap:wrap;justify-content:center;gap:28px}
.svc-grid-card{flex:1 1 calc(50% - 14px);min-width:320px;max-width:560px;background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;transition:.3s cubic-bezier(.34,1.56,.64,1);display:flex;flex-direction:column}
.svc-grid-card:hover{transform:translateY(-6px);box-shadow:0 20px 56px rgba(10,46,30,.12);border-color:rgba(29,158,117,.25)}
.svc-grid-img{height:200px;position:relative;overflow:hidden;flex-shrink:0}
.svc-grid-img img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .6s ease}
.svc-grid-card:hover .svc-grid-img img{transform:scale(1.06)}
.svc-grid-img-overlay{position:absolute;inset:0;background:linear-gradient(180deg,rgba(10,46,30,.15) 0%,rgba(10,46,30,.65) 100%)}
.svc-grid-icon{position:absolute;bottom:16px;left:18px;width:44px;height:44px;border-radius:12px;background:var(--teal);color:#fff;display:flex;align-items:center;justify-content:center;font-size:18px;box-shadow:0 4px 16px rgba(0,0,0,.25)}
.svc-grid-body{padding:28px;display:flex;flex-direction:column;flex:1}
.svc-grid-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--teal);margin-bottom:8px}
.svc-grid-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:23px;line-height:1.25;color:var(--forest);margin-bottom:12px}
.svc-grid-desc{font-size:16.5px;line-height:1.75;color:var(--muted);margin-bottom:20px}
.svc-grid-included{font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;text-transform:uppercase;letter-spacing:.6px;color:var(--forest);margin-bottom:12px}
.svc-grid-list{list-style:none;display:flex;flex-direction:column;gap:9px;margin-bottom:22px}
.svc-grid-list li{display:flex;align-items:center;gap:9px;font-size:13.5px;color:var(--muted)}
.svc-grid-list li i{color:var(--teal);font-size:11px;flex-shrink:0}
.svc-grid-link{display:inline-flex;align-items:center;gap:7px;margin-top:auto;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:700;color:var(--teal);text-decoration:none;transition:.2s;cursor:pointer}
.svc-grid-link:hover{color:var(--forest);gap:10px}
@media(max-width:768px){.svc-grid-card{flex:1 1 100%}}

/* ── REVIEWS SLIDER ── */
.reviews{background:var(--forest);overflow:hidden;position:relative}
.reviews::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;pointer-events:none}
.reviews .container{position:relative;z-index:1}
.reviews-header{text-align:center;margin-bottom:56px}
.reviews-header .section-label{justify-content:center;color:var(--mint)}
.reviews-header .section-label::before{background:var(--mint)}
.reviews-header .section-h2{color:#fff}
.reviews-header .section-h2 em{color:var(--mint)}
.slider-wrap{overflow:hidden;position:relative}
.slider-track{display:flex;gap:24px;transition:transform .5s cubic-bezier(.4,0,.2,1);will-change:transform}
.review-card{background:var(--cream);border:1px solid var(--border);border-radius:22px;padding:32px;min-width:360px;max-width:360px;position:relative;overflow:hidden;flex-shrink:0}
.review-card::before{content:'\201C';position:absolute;top:-12px;right:20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:120px;color:rgba(29,158,117,.08);line-height:1;pointer-events:none}
.review-stars{color:var(--gold);font-size:15px;margin-bottom:16px;letter-spacing:2px}
.review-quote{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;line-height:1.65;color:var(--forest);font-style:italic;margin-bottom:24px}
.review-author{display:flex;align-items:center;gap:13px}
.review-avatar{width:48px;height:48px;border-radius:50%;background:var(--teal);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;flex-shrink:0}
.review-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--forest)}
.review-role{font-size:12px;color:var(--muted);margin-top:2px}
.slider-controls{display:flex;justify-content:center;gap:12px;margin-top:40px;align-items:center}
.slider-btn{width:44px;height:44px;border-radius:50%;background:var(--forest);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;transition:.25s}
.slider-btn:hover{background:var(--teal);transform:scale(1.05)}
.slider-dots{display:flex;gap:8px;align-items:center}
.slider-dot{width:8px;height:8px;border-radius:50%;background:var(--border);cursor:pointer;transition:.3s;border:none}
.slider-dot.active{background:var(--teal);width:24px;border-radius:4px}
.reviews .slider-btn{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.16)}
.reviews .slider-btn:hover{background:var(--teal);border-color:var(--teal)}
.reviews .slider-dot{background:rgba(255,255,255,.2)}
.reviews .slider-dot.active{background:var(--mint)}

/* ── FAQ ── */
.faq{background:#fff}
.faq-header{text-align:center;margin-bottom:64px}
.faq-header .section-label{justify-content:center}
.faq-list{max-width:860px;margin:0 auto;display:flex;flex-direction:column;gap:12px}
.faq-item{background:var(--warm);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:border-color .3s}
.faq-item:hover{border-color:rgba(29,158,117,.3)}
.faq-q{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:20px 24px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;color:var(--forest)}
.faq-q-icon{width:28px;height:28px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;transition:transform .3s,background .3s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal)}
.faq-a{max-height:0;overflow:hidden;transition:max-height .4s ease}
.faq-item.open .faq-a{max-height:400px}
.faq-a-inner{padding:0 24px 20px;font-size:16px;line-height:1.75;color:var(--muted);border-top:1px solid var(--border)}
.faq-a-inner p{padding-top:16px}

/* ── CTA SECTION ── */
.cta-section{background:#fff;padding:64px 24px}
.cta-card{position:relative;max-width:1180px;margin:0 auto;background:var(--forest);border-radius:40px;padding:88px 48px;text-align:center;overflow:hidden}
.cta-card::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.07) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.07) 1px,transparent 1px);background-size:50px 50px}
.cta-decor{position:absolute;width:180px;height:150px;pointer-events:none;opacity:.8}
.cta-decor-tr{top:0;right:0}
.cta-decor-bl{bottom:0;left:0;transform:scaleX(-1) scaleY(-1)}
.cta-card-inner{position:relative;z-index:2;max-width:720px;margin:0 auto}
.cta-headline{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(32px,4.4vw,50px);line-height:1.18;color:#fff;margin-bottom:22px}
.cta-headline em{font-style:italic;color:var(--mint)}
.cta-headline i{color:var(--mint);margin-left:10px;font-size:.72em}
.cta-sub{font-size:17px;line-height:1.75;color:rgba(255,255,255,.62);margin:0 auto 36px;max-width:600px}
.cta-pill-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;color:var(--forest);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;padding:18px 36px;border-radius:100px;border:none;cursor:pointer;transition:.2s}
.cta-pill-btn:hover{transform:translateY(-2px);box-shadow:0 14px 36px rgba(0,0,0,.3)}
.cta-guarantee{position:relative;z-index:2;margin-top:24px;display:flex;align-items:center;justify-content:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.4)}
.cta-guarantee i{color:var(--mint)}

/* ── RESPONSIVE ── */
@media(max-width:1024px){
  .hero-grid{grid-template-columns:1fr;min-height:0}
  .hero-right{display:none}
  .hero-left{padding:140px 32px 64px}
  .hero-h1{font-size:clamp(28px,6vw,44px)}
  .why-grid{grid-template-columns:1fr;gap:56px}
  .why-photo{max-width:340px;margin:0 auto}
  .why-photo-stat{left:50%;transform:translateX(calc(-50% - 110px))}
}
@media(max-width:640px){
  .hero-left{padding:110px 24px 48px}
  .hero-h1{font-size:clamp(24px,7.2vw,32px)}
  .hero-rotator{margin-top:10px}
  section{padding:72px 24px}
  .cta-card{padding:56px 24px;border-radius:28px}
  .cta-decor{width:110px;height:90px}
  .review-card{min-width:calc(100vw - 80px);max-width:calc(100vw - 80px)}
  .faq-list{padding:0}
  .why-photo-stat{left:16px;transform:none}
}
CSS;

$page_js = <<<JS
// ── REVIEW SLIDER ──
var currentSlide = 0;
var TOTAL_CARDS = 6;
var VISIBLE = 3;
var MAX_SLIDE = TOTAL_CARDS - VISIBLE;
var CARD_W = 360 + 24;

function buildDots() {
  var dots = document.getElementById('sliderDots');
  if (!dots) return;
  dots.innerHTML = '';
  for (var i = 0; i <= MAX_SLIDE; i++) {
    var d = document.createElement('button');
    d.className = 'slider-dot' + (i === 0 ? ' active' : '');
    d.setAttribute('aria-label', 'Slide ' + (i + 1));
    (function(idx) { d.addEventListener('click', function() { goSlide(idx); }); })(i);
    dots.appendChild(d);
  }
}
function goSlide(n) {
  currentSlide = Math.max(0, Math.min(n, MAX_SLIDE));
  document.getElementById('sliderTrack').style.transform = 'translateX(-' + (currentSlide * CARD_W) + 'px)';
  document.querySelectorAll('.slider-dot').forEach(function(d, i) {
    d.classList.toggle('active', i === currentSlide);
  });
}
function slideReviews(dir) { goSlide(currentSlide + dir); }
buildDots();

// ── OPEN POPUP OVERRIDE (homepage title customization) ──
function openPopup(type) {
  var overlay  = document.getElementById('mainPopup');
  var formDiv  = document.getElementById('popupFormEl');
  var succDiv  = document.getElementById('popupSuccessEl');
  var titleEl  = document.getElementById('popupTitleEl');
  var btnLabel = document.getElementById('popupBtnLabel');
  var svcSel   = document.getElementById('pService');

  formDiv.style.display = 'block';
  succDiv.style.display = 'none';

  titleEl.textContent  = 'Book Your Free Growth Audit';
  btnLabel.textContent = 'Book My Free Audit';
  svcSel.value         = 'Free Growth Audit';

  generateCaptcha();
  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}

// ── HERO SERVICE ROTATOR ──
(function() {
  var rotator = document.getElementById('heroRotator');
  if (!rotator) return;
  var words = rotator.querySelectorAll('.hero-rotator-word');
  if (!words.length) return;
  words[0].classList.add('is-active');
  if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;
  var idx = 0;
  setInterval(function() {
    var current = words[idx];
    var nextIdx = (idx + 1) % words.length;
    var next = words[nextIdx];
    current.classList.remove('is-active');
    current.classList.add('is-leaving');
    next.classList.add('is-active');
    setTimeout(function() { current.classList.remove('is-leaving'); }, 550);
    idx = nextIdx;
  }, 2400);
})();
JS;

include 'includes/header.php';

$_next_event = null;
try {
    if (function_exists('hc_one')) {
        $_next_event = hc_one("SELECT title, slug, event_datetime, timezone FROM hc_events WHERE status='published' AND event_datetime >= NOW() ORDER BY event_datetime ASC LIMIT 1");
    }
} catch (Exception $e) { /* banner is optional — fail silently */ }
?>

<?php if ($_next_event):
    $_edt = new DateTime($_next_event['event_datetime'], new DateTimeZone($_next_event['timezone'] ?: 'America/New_York'));
?>
<a href="/events/<?= urlencode($_next_event['slug']) ?>" style="display:flex;align-items:center;justify-content:center;gap:10px;flex-wrap:wrap;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;text-decoration:none;padding:12px 20px;margin-top:72px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;text-align:center">
  <i class="fa-solid fa-calendar-days"></i>
  <span><strong>Free Live Event:</strong> <?= htmlspecialchars($_next_event['title']) ?> — <?= $_edt->format('F j, Y \a\t g:i A T') ?></span>
  <span style="text-decoration:underline;font-weight:700">Register Free &rarr;</span>
</a>
<?php endif; ?>

<!-- ══════════════════════════
   HERO
══════════════════════════ -->
<section class="hero" id="home">
  <div class="hero-bg-grid"></div>
  <div class="hero-grid">
    <div class="hero-left">
      <div class="hero-badge">
        <div class="hero-badge-pulse"></div>The Marketing Agency Built Exclusively for Homecare
      </div>
      <h1 class="hero-h1">
        <span class="hero-h1-line1">Marketing Built Around</span>
        <span class="hero-rotator" id="heroRotator">
          <span class="hero-rotator-word">Home Care SEO</span>
          <span class="hero-rotator-word">Website Design</span>
          <span class="hero-rotator-word">Local SEO &amp; Maps</span>
          <span class="hero-rotator-word">AI Search Optimization</span>
          <span class="hero-rotator-word">Marketing Automation</span>
        </span>
      </h1>
      <svg class="hero-swoosh" width="260" height="20" viewBox="0 0 260 20" fill="none" xmlns="http://www.w3.org/2000/svg" aria-hidden="true">
        <path d="M4 14C40 2 60 2 86 14C112 26 132 26 158 14C184 2 204 2 230 14C244 20 252 18 256 14" stroke-width="5" stroke-linecap="round"/>
      </svg>
      <p class="hero-desc">Grow your home care agency with marketing built for your industry. We help agencies nationwide attract more qualified leads through SEO, high-converting websites, local SEO, and AI-powered marketing.</p>
      <div class="hero-actions">
        <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Book Free Growth
          Audit</button>
      </div>
    </div>
    <div class="hero-right">
      <img src="/images/home/hero-team-homecare-creators.jpg" alt="The Homecare Creators marketing team, a digital marketing agency built exclusively for home care agencies" title="Meet the Homecare Creators team">
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

<!-- ══════════════════════════
   ABOUT US
══════════════════════════ -->
<section class="why" id="why">
  <div class="container">
    <div class="why-grid">
      <div class="why-photo-wrap" data-reveal>
        <div class="why-photo">
          <img src="/images/team/asifa-rani-founder-ceo.jpg" alt="Asifa Rani, Founder and CEO of Homecare Creators" title="Asifa Rani — Founder & CEO, Homecare Creators">
        </div>
        <div class="why-photo-stat">
          <div class="why-photo-stat-num">100%</div>
          <div class="why-photo-stat-label">Homecare-Only<br>Focus</div>
        </div>
      </div>
      <div class="why-content" data-reveal style="transition-delay:.1s">
        <p class="section-label">Why Homecare Creators</p>
        <h2 class="section-h2">Built <em>100% for</em> Homecare</h2>
        <p class="section-sub">Founded by Asifa Rani, Homecare Creators works exclusively with home care agencies
          nationwide — no restaurants, no law firms, no generic playbooks. Every strategy, keyword, and page we
          build is for this industry alone, paired with AI search visibility and automation most competitors
          haven't even heard of yet.</p>
        <a href="/about/" class="btn-primary" style="margin-top:8px">Learn More</a>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════
   SERVICES — 2-per-row card grid
══════════════════════════ -->
<section class="services" id="services">
  <div class="container">
    <div class="services-header">
      <div data-reveal>
        <p class="section-label" style="justify-content:center">What We Do</p>
        <h2 class="section-h2">Everything Your Agency<br>Needs to <em>Dominate</em></h2>
      </div>
      <p class="section-sub" data-reveal style="transition-delay:.1s;margin:0 auto">Five done-for-you service lines, built around
        what actually moves the needle for a homecare agency.</p>
    </div>

    <div class="svc-grid">
      <div class="svc-grid-card" data-reveal style="transition-delay:.05s">
        <div class="svc-grid-img">
          <img src="/images/home/results-growth.jpg" alt="Home care agency SEO results and growth" title="Home Care SEO">
          <div class="svc-grid-img-overlay"></div>
          <div class="svc-grid-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
        </div>
        <div class="svc-grid-body">
          <div class="svc-grid-label">Home Care SEO</div>
          <h3 class="svc-grid-title">Get Found by Families Looking for Care in Your Community</h3>
          <p class="svc-grid-desc">When families search for home care, your agency should be one of the first names they see. We help home care agencies nationwide improve their visibility on Google with SEO strategies tailored to the senior care industry, so you can attract more qualified inquiries, build trust online, and grow without relying only on referrals.</p>
          <a href="/seo/home-care-seo/" class="svc-grid-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="svc-grid-card" data-reveal style="transition-delay:.1s">
        <div class="svc-grid-img">
          <img src="/images/home/service-website-dev.jpg" alt="Home care agency website design" title="Home Care Website Design">
          <div class="svc-grid-img-overlay"></div>
          <div class="svc-grid-icon"><i class="fa-solid fa-laptop-code"></i></div>
        </div>
        <div class="svc-grid-body">
          <div class="svc-grid-label">Home Care Website Design</div>
          <h3 class="svc-grid-title">Build Trust Before the First Phone Call</h3>
          <p class="svc-grid-desc">Your website is often a family's first impression of your agency. We design clean, modern websites that clearly explain your services, build confidence, and make it easy for visitors to contact you. Every website is designed with SEO, speed, and lead generation in mind.</p>
          <a href="/web-design/homecare-website-design/" class="svc-grid-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="svc-grid-card" data-reveal style="transition-delay:.05s">
        <div class="svc-grid-img">
          <img src="/images/home/service-local-seo.jpg" alt="Local SEO for home care agencies" title="Local SEO">
          <div class="svc-grid-img-overlay"></div>
          <div class="svc-grid-icon"><i class="fa-solid fa-map-location-dot"></i></div>
        </div>
        <div class="svc-grid-body">
          <div class="svc-grid-label">Local SEO</div>
          <h3 class="svc-grid-title">Help Families Find You Nearby</h3>
          <p class="svc-grid-desc">Most families search for care close to home. We improve your local visibility by optimizing your Google Business Profile, strengthening your presence in Google Maps, and helping your agency rank in the cities and communities you serve.</p>
          <a href="/seo/home-care-seo/" class="svc-grid-link">Learn More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="svc-grid-card" data-reveal style="transition-delay:.1s">
        <div class="svc-grid-img">
          <img src="/images/home/service-ai-search-seo.jpg" alt="AI search optimization for home care agencies" title="AI Search Optimization (GEO)">
          <div class="svc-grid-img-overlay"></div>
          <div class="svc-grid-icon"><i class="fa-solid fa-brain"></i></div>
        </div>
        <div class="svc-grid-body">
          <div class="svc-grid-label">AI Search Optimization (GEO)</div>
          <h3 class="svc-grid-title">Stay Visible in the Next Generation of Search</h3>
          <p class="svc-grid-desc">More people are using AI tools like ChatGPT and Google AI to find businesses. We prepare your website for this shift by creating AI-friendly content, improving your site's structure, and building the authority needed to increase your chances of being recommended in AI-powered search experiences.</p>
          <a class="svc-grid-link" href="/ai-search-seo/">Learn More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>

      <div class="svc-grid-card" data-reveal style="transition-delay:.15s">
        <div class="svc-grid-img">
          <img src="/images/home/ai-seo-tech.jpg" alt="AI and automation for home care agencies" title="AI & Automation">
          <div class="svc-grid-img-overlay"></div>
          <div class="svc-grid-icon"><i class="fa-solid fa-gears"></i></div>
        </div>
        <div class="svc-grid-body">
          <div class="svc-grid-label">AI & Automation</div>
          <h3 class="svc-grid-title">Work Smarter, Respond Faster</h3>
          <p class="svc-grid-desc">Never miss another inquiry. We automate follow-ups, appointment requests, and repetitive tasks so your team can focus on what matters most: providing exceptional care while every lead receives a timely response.</p>
          <a class="svc-grid-link" href="/ai-automation/">Learn More <i class="fa-solid fa-arrow-right"></i></a>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section" id="bundles">
  <div class="cta-card" data-reveal>
    <div class="cta-decor cta-decor-tr">
      <svg viewBox="0 0 180 150" fill="none" width="100%" height="100%">
        <path d="M10 145 C 55 100, 35 45, 95 25 S 165 55, 172 8" style="stroke:var(--teal-lt)" stroke-width="3" stroke-linecap="round" opacity="0.55"/>
        <circle cx="95" cy="25" r="3.5" style="fill:var(--mint)"/>
        <circle cx="172" cy="8" r="3.5" style="fill:var(--mint)"/>
        <path d="M140 55 l4 11 l11 4 l-11 4 l-4 11 l-4-11 l-11-4 l11-4 Z" style="fill:var(--mint)" opacity="0.8"/>
      </svg>
    </div>
    <div class="cta-decor cta-decor-bl">
      <svg viewBox="0 0 180 150" fill="none" width="100%" height="100%">
        <path d="M10 145 C 55 100, 35 45, 95 25 S 165 55, 172 8" style="stroke:var(--teal-lt)" stroke-width="3" stroke-linecap="round" opacity="0.55"/>
        <circle cx="95" cy="25" r="3.5" style="fill:var(--mint)"/>
        <circle cx="172" cy="8" r="3.5" style="fill:var(--mint)"/>
        <path d="M140 55 l4 11 l11 4 l-11 4 l-4 11 l-4-11 l-11-4 l11-4 Z" style="fill:var(--mint)" opacity="0.8"/>
      </svg>
    </div>
    <div class="cta-card-inner">
      <h2 class="cta-headline">Let's Grow Your Home Care<br>Agency's <em>Online Presence</em><i class="fa-solid fa-bullhorn"></i></h2>
      <p class="cta-sub">Whether you're just getting started with SEO or ready to scale across search, your
        website, and AI search visibility, our team builds a growth strategy around your agency's goals, not a generic template.</p>
      <button class="cta-pill-btn" onclick="openPopup('audit')"><i class="fa-solid fa-calendar-check"></i>Book a Free Growth Audit</button>
      <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free audit &nbsp;&middot;&nbsp; No
        obligation &nbsp;&middot;&nbsp; 30-day satisfaction guarantee</div>
    </div>
  </div>
</section>

<!-- CASE STUDIES -->
<?php include 'includes/case-study-slider.php'; ?>

<!-- ══════════════════════════
   REVIEWS SLIDER
══════════════════════════ -->
<section class="reviews" id="reviews">
  <div class="container">
    <div class="reviews-header" data-reveal>
      <p class="section-label">What Owners Say</p>
      <h2 class="section-h2">Homecare Owners<br><em>Love the Results</em></h2>
    </div>
    <div class="slider-wrap" data-reveal style="transition-delay:.1s">
      <div class="slider-track" id="sliderTrack">
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"We had 6 Google reviews before Homecare Creators and almost no website traffic
            to speak of. Four months later we're at 52 reviews, ranked #1 in our city, and our inquiry calls have
            tripled. Worth every penny."</p>
          <div class="review-author">
            <div class="review-avatar">SR</div>
            <div>
              <div class="review-name">Sarah R.</div>
              <div class="review-role">Owner, Comfort Home Care &middot; Chicago, IL</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"I'd tried two other marketing agencies before this one, and neither understood
            homecare at all. Homecare Creators knew exactly what we needed. Their SEO strategy was nothing like
            what we'd seen, and it worked."</p>
          <div class="review-author">
            <div class="review-avatar">MJ</div>
            <div>
              <div class="review-name">Marcus J.</div>
              <div class="review-role">Founder, Golden Years Care &middot; Atlanta, GA</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"Their AI Search SEO is unlike anything I've seen from a marketing agency. We
            show up now when families search on ChatGPT and Google AI, and honestly, I don't think our competitors
            even know this is possible yet."</p>
          <div class="review-author">
            <div class="review-avatar">LD</div>
            <div>
              <div class="review-name">Linda D.</div>
              <div class="review-role">CEO, Caring Hands Agency &middot; Houston, TX</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"Zero to 28 private-pay clients in 7 months. The website redesign paired with
            local SEO is genuinely a powerful combination, and the monthly strategy calls keep us honest."</p>
          <div class="review-author">
            <div class="review-avatar">TW</div>
            <div>
              <div class="review-name">Tamara W.</div>
              <div class="review-role">Owner, Sunrise Senior Care &middot; Phoenix, AZ</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"The follow-up automation alone paid for the retainer. Leads used to sit for days,
            now they get a response in minutes, day or night."</p>
          <div class="review-author">
            <div class="review-avatar">RB</div>
            <div>
              <div class="review-name">Robert B.</div>
              <div class="review-role">CEO, Premier Home Health &middot; Dallas, TX</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"Three months in, a family told us they found us through ChatGPT. I was floored,
            honestly. This team is ahead of the curve, and homecare is the only thing they do."</p>
          <div class="review-author">
            <div class="review-avatar">AC</div>
            <div>
              <div class="review-name">Angela C.</div>
              <div class="review-role">Director, CareFirst Agency &middot; Miami, FL</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slider-controls">
      <button class="slider-btn" onclick="slideReviews(-1)" aria-label="Previous"><i
          class="fa-solid fa-chevron-left"></i></button>
      <div class="slider-dots" id="sliderDots"></div>
      <button class="slider-btn" onclick="slideReviews(1)" aria-label="Next"><i
          class="fa-solid fa-chevron-right"></i></button>
    </div>
  </div>
</section>

<!-- ══════════════════════════
   FAQ
══════════════════════════ -->
<section class="faq" id="faq">
  <div class="container">
    <div class="faq-header" data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Frequently Asked<br><em>Questions</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">How long before I see results?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>Google My Business results usually show up first, often within 30 days. Broader ranking improvements
              tend to follow in the 60–90 day range, and most clients see website leads pick up within that first
              90-day window after launch.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">Do you work with any type of homecare agency?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>Yes. Companion care, personal care, skilled nursing, Medicaid waiver, private-pay, it doesn't matter.
              We build the strategy around your specific payer mix and service area, not a one-size-fits-all
              template.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">What is AI Search SEO and why does it matter?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>People also call it GEO. It's the process of shaping your content so it gets pulled into AI-generated
              answers on ChatGPT, Google AI Overviews, and Perplexity. Millions of families are already using AI to
              search for homecare, and this is how we make sure they land on your agency.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">Is there a long-term contract?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>No. Every plan goes month-to-month after the first 90 days, because we'd rather keep you as a client
              through results than a contract. If you want to commit annually, there are extra discounts for that
              too.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">What does the AI & Automation service actually do?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>We set up automated follow-ups, lead response, and scheduling workflows so inquiries get answered
              within minutes instead of sitting in an inbox. It runs quietly in the background and plugs into the
              marketing work we're already doing for you.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">How is Homecare Creators different from other agencies?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>We don't touch restaurants, dentists, or e-commerce. Homecare is the only thing we do, so every
              strategy, keyword, and piece of content is built specifically for it. On top of that, we're the ones
              building the software platform that runs the agencies we market for.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">What does the free audit include?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>We look at your website speed and SEO health, audit your Google Maps and GMB profile, compare you
              against local competitors, and go through your review profile. You walk away with a 90-day growth
              roadmap. No strings attached, no cost.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">Do you guarantee results?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>Every plan comes with a 30-day satisfaction guarantee. Not happy after the first month? We'll refund
              it, no questions asked. We can offer that because we know the work holds up.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
