<?php
$page_title    = "Homecare Creators: Marketing for Home Care Agencies";
$page_desc     = "A marketing agency built exclusively for home care agencies nationwide - SEO, websites, and AI search optimization.";
$page_canonical = "https://homecarecreators.com/";
$og_title      = "Homecare Creators: Marketing for Home Care Agencies";
$og_desc       = "A marketing agency built 100% for homecare - website design, local SEO, and AI search SEO.";

$page_css = <<<CSS
/* ── HERO ── */
.hero{min-height:100vh;background:var(--forest);position:relative;overflow:hidden;padding:0;display:grid;grid-template-columns:1fr 1fr;align-items:center}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-200px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-blob2{position:absolute;width:500px;height:500px;bottom:-150px;left:-100px;background:radial-gradient(circle,rgba(201,168,76,.1) 0%,transparent 65%);animation:float 13s ease-in-out infinite reverse}
.hero-left{position:relative;z-index:2;padding:140px 52px 80px 80px}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:32px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(42px,5.2vw,70px);line-height:1.04;color:#fff;margin-bottom:6px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-tagline{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(20px,2.4vw,30px);line-height:1.3;color:rgba(255,255,255,.5);margin-bottom:10px;animation:fadeUp .8s .18s ease both}
.hero-tagline em{color:var(--mint);font-style:normal}
.hero-desc{font-size:18.5px;line-height:1.75;color:rgba(255,255,255,.62);max-width:500px;margin-bottom:42px;animation:fadeUp .8s .3s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .4s ease both;margin-bottom:52px}
.hero-proof{display:flex;gap:32px;flex-wrap:wrap;animation:fadeUp .8s .55s ease both}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:34px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-proof-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch}
.hero-right{position:relative;z-index:2;height:100vh;min-height:700px;padding:120px 48px 60px 24px;display:grid;grid-template-columns:1fr 1fr;grid-template-rows:1fr 1fr;gap:14px}
.hero-img-card{border-radius:20px;overflow:hidden;position:relative;box-shadow:0 20px 60px rgba(0,0,0,.35)}
.hero-img-card img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .6s ease}
.hero-img-card:hover img{transform:scale(1.04)}
.hero-img-card::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 40%,rgba(5,25,14,.65) 100%);pointer-events:none}
.hero-img-card.tall{grid-row:span 2}
.hero-img-overlay{position:absolute;bottom:14px;left:14px;right:14px;z-index:2;background:rgba(10,46,30,.85);backdrop-filter:blur(10px);border:1px solid rgba(29,158,117,.25);border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:10px}
.hero-img-overlay-icon{width:30px;height:30px;border-radius:8px;background:var(--teal);display:flex;align-items:center;justify-content:center;font-size:13px;color:#fff;flex-shrink:0}
.hero-img-overlay-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:600;color:#fff;line-height:1.3}
.hero-img-overlay-sub{font-size:10px;color:rgba(255,255,255,.5)}
.hero-float-badge{position:absolute;z-index:3;background:rgba(201,168,76,.15);backdrop-filter:blur(16px);border:1px solid rgba(201,168,76,.4);border-radius:12px;padding:10px 16px;font-family:'Plus Jakarta Sans',sans-serif}
.hero-float-badge-num{font-size:22px;font-weight:800;color:var(--gold-lt);line-height:1}
.hero-float-badge-label{font-size:10px;color:rgba(255,255,255,.6)}

/* ── WHY US ── */
.why{background:#fff}

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

/* ── CASE STUDIES SLIDER ── */
.case-studies{background:var(--cream);overflow:hidden}
.case-card{background:#fff;border:1px solid var(--border);border-radius:22px;padding:32px;min-width:340px;max-width:340px;flex-shrink:0;box-shadow:0 8px 28px rgba(10,46,30,.06)}
.case-card-tag{display:inline-flex;align-items:center;gap:7px;background:rgba(29,158,117,.1);color:var(--teal);font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.4px;text-transform:uppercase;padding:6px 13px;border-radius:100px;margin-bottom:22px}
.case-card-stat{font-family:'Plus Jakarta Sans',sans-serif;font-size:38px;font-weight:800;color:var(--forest);line-height:1;margin-bottom:6px}
.case-card-stat-label{font-size:13px;color:var(--muted);margin-bottom:20px;line-height:1.5}
.case-card-desc{font-size:14.5px;line-height:1.7;color:var(--muted);margin-bottom:24px;padding-bottom:24px;border-bottom:1px solid var(--border)}
.case-card-client{display:flex;align-items:center;gap:12px}
.case-card-avatar{width:42px;height:42px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;flex-shrink:0}
.case-card-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--forest)}
.case-card-loc{font-size:12px;color:var(--muted)}

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
.cta-section{background:var(--forest);position:relative;overflow:hidden}
.cta-section::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 80% at 50% 50%,rgba(29,158,117,.14),transparent)}
.cta-inner{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.cta-content .section-h2{color:#fff}
.cta-content .section-h2 em{color:var(--mint)}
.cta-content .section-label{color:var(--mint)}
.cta-content .section-label::before{background:var(--mint)}
.cta-desc{font-size:18px;line-height:1.75;color:rgba(255,255,255,.6);margin-bottom:36px;max-width:460px}
.cta-actions{display:flex;gap:14px;flex-wrap:wrap}
.cta-guarantee{margin-top:24px;display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;color:rgba(255,255,255,.35)}
.cta-guarantee i{color:var(--teal)}
.cta-image{border-radius:24px;overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3);position:relative;aspect-ratio:4/5}
.cta-image img{width:100%;height:100%;object-fit:cover;display:block}
.cta-image::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,46,30,.6),transparent 60%)}
.cta-image-badge{position:absolute;top:24px;left:24px;z-index:2;background:rgba(10,46,30,.9);backdrop-filter:blur(16px);border:1px solid rgba(29,158,117,.3);border-radius:14px;padding:14px 18px}
.cta-image-badge-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:var(--mint);letter-spacing:.8px;text-transform:uppercase;margin-bottom:6px}
.cta-badge-row{display:flex;align-items:center;gap:8px;margin-top:6px}
.cta-badge-dot{width:6px;height:6px;border-radius:50%;background:var(--teal-lt)}
.cta-badge-text{font-size:12px;color:rgba(255,255,255,.65)}

/* ── RESPONSIVE ── */
@media(max-width:1024px){
  .hero{grid-template-columns:1fr}
  .hero-right{display:none}
  .hero-left{padding:130px 40px 80px}
  .cta-inner{grid-template-columns:1fr}
}
@media(max-width:640px){
  .hero-left{padding:110px 24px 60px}
  section{padding:72px 24px}
  .review-card,.case-card{min-width:calc(100vw - 80px);max-width:calc(100vw - 80px)}
  .faq-list{padding:0}
}
CSS;

$page_js = <<<JS
// ── GENERIC CARD SLIDER (used by Reviews + Case Studies) ──
function makeSlider(trackId, dotsId, totalCards, visible, cardWidth) {
  var current = 0;
  var maxSlide = Math.max(0, totalCards - visible);
  var track = document.getElementById(trackId);
  var dotsWrap = document.getElementById(dotsId);

  function buildDots() {
    if (!dotsWrap) return;
    dotsWrap.innerHTML = '';
    for (var i = 0; i <= maxSlide; i++) {
      var d = document.createElement('button');
      d.className = 'slider-dot' + (i === 0 ? ' active' : '');
      d.setAttribute('aria-label', 'Slide ' + (i + 1));
      (function(idx) { d.addEventListener('click', function() { goSlide(idx); }); })(i);
      dotsWrap.appendChild(d);
    }
  }
  function goSlide(n) {
    current = Math.max(0, Math.min(n, maxSlide));
    if (track) track.style.transform = 'translateX(-' + (current * cardWidth) + 'px)';
    if (dotsWrap) Array.prototype.forEach.call(dotsWrap.children, function(d, i) {
      d.classList.toggle('active', i === current);
    });
  }
  buildDots();
  return { next: function() { goSlide(current + 1); }, prev: function() { goSlide(current - 1); } };
}
var reviewsSlider = makeSlider('sliderTrack', 'sliderDots', 6, 3, 360 + 24);
var caseSlider = makeSlider('caseSliderTrack', 'caseSliderDots', 4, 3, 340 + 24);
function slideReviews(dir) { dir < 0 ? reviewsSlider.prev() : reviewsSlider.next(); }
function slideCases(dir) { dir < 0 ? caseSlider.prev() : caseSlider.next(); }

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
  <div class="hero-blob1"></div>
  <div class="hero-blob2"></div>
  <div class="hero-left">
    <div class="hero-badge">
      <div class="hero-badge-pulse"></div>The Marketing Agency Built Exclusively for Homecare
    </div>
    <h1 class="hero-h1">Home Care <br><em>Marketing Agency</em></h1>
    <p class="hero-desc">Grow your home care agency with marketing built for your industry. We help agencies nationwide attract more qualified leads through SEO, high-converting websites, local SEO, and AI-powered marketing.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Book Free Growth
        Audit</button>
      <a href="#services" class="btn-secondary"><i class="fa-solid fa-play"></i>See Our Services</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item">
        <div class="hero-proof-num">100%</div>
        <div class="hero-proof-label">Homecare-Only Focus</div>
      </div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item">
        <div class="hero-proof-num">SEO</div>
        <div class="hero-proof-label">+ AI Search Visibility</div>
      </div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item">
        <div class="hero-proof-num">30-Day</div>
        <div class="hero-proof-label">Satisfaction Guarantee</div>
      </div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item">
        <div class="hero-proof-num">12h</div>
        <div class="hero-proof-label">Saved/Week via AI</div>
      </div>
    </div>
  </div>

  <div class="hero-right">
    <div class="hero-img-card tall" style="animation:scaleIn .9s .4s ease both">
      <img src="/images/home/hero-caregiver-elderly.jpg"
        alt="Professional caregiver assisting an elderly client at home for a home care agency"
        title="Home care agency caregiver assisting an elderly client">
      <div class="hero-img-overlay">
        <div class="hero-img-overlay-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <div>
          <div class="hero-img-overlay-text">Live Shift Active</div>
          <div class="hero-img-overlay-sub">AI monitoring in real-time</div>
        </div>
      </div>
    </div>
    <div class="hero-img-card" style="animation:scaleIn .9s .55s ease both">
      <img src="/images/home/hero-nurse-senior.jpg"
        alt="Home care nurse providing compassionate in-home senior care services"
        title="Home care nurse caring for a senior client">
      <div class="hero-float-badge" style="top:14px;left:12px">
        <div class="hero-float-badge-num">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
        <div class="hero-float-badge-label">Review Growth</div>
      </div>
    </div>
    <div class="hero-img-card" style="animation:scaleIn .9s .7s ease both">
      <img src="/images/home/hero-caregiver-woman.jpg"
        alt="Happy caregiver bonding with an elderly woman client, home care agency growing its Google visibility"
        title="Caregiver with elderly woman client — home care agency growing on Google">
      <div class="hero-img-overlay">
        <div class="hero-img-overlay-icon"><i class="fa-brands fa-google"></i></div>
        <div>
          <div class="hero-img-overlay-text">Google Search Visibility</div>
          <div class="hero-img-overlay-sub">Local SEO + AI Search</div>
        </div>
      </div>
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
  <div class="container" style="max-width:760px">
    <div data-reveal style="text-align:center">
      <p class="section-label" style="justify-content:center">Why Homecare Creators</p>
      <h2 class="section-h2" style="text-align:center">Built <em>100% for </em>Homecare</h2>
      <p class="section-sub" style="margin:0 auto">Generalist agencies don't get homecare. We do, and that focus is
        worth hundreds of thousands in growth most years. Every strategy, keyword, and page we build is for a
        homecare agency, nothing else — plus AI search visibility and automation most competitors haven't even
        heard of yet. All on month-to-month plans with no long-term lock-in, because one new client usually covers
        the entire retainer within 30 days.</p>
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
  <div class="container">
    <div class="cta-inner">
      <div class="cta-content" data-reveal>
        <p class="section-label">Get Started Today</p>
        <h2 class="section-h2">Ready to Grow Your<br><em>Homecare Agency?</em></h2>
        <p class="cta-desc">Book a free 30-minute growth audit and we'll walk through your digital presence with
          you, then show you exactly what needs fixing. No obligation, no sales pitch.</p>
        <div class="cta-actions">
          <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup('audit')"><i
              class="fa-solid fa-calendar-check"></i>Book Your Free Audit</button>
        </div>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free audit &nbsp;&middot;&nbsp; No
          obligation &nbsp;&middot;&nbsp; 30-day satisfaction guarantee</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/home/cta-business-owner.jpg"
          alt="Home care agency owner reviewing a free growth audit with Homecare Creators"
          title="Home care agency owner growing their business">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot"
              style="color:var(--teal-lt);margin-right:4px"></i>Audit Includes</div>
          <div class="cta-badge-row">
            <div class="cta-badge-dot"></div>
            <div class="cta-badge-text">Website & speed analysis</div>
          </div>
          <div class="cta-badge-row">
            <div class="cta-badge-dot"></div>
            <div class="cta-badge-text">Google ranking audit</div>
          </div>
          <div class="cta-badge-row">
            <div class="cta-badge-dot"></div>
            <div class="cta-badge-text">Competitor comparison</div>
          </div>
          <div class="cta-badge-row">
            <div class="cta-badge-dot"></div>
            <div class="cta-badge-text">90-day growth roadmap</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CASE STUDIES -->
<section class="case-studies" id="results">
  <div class="container">
    <div class="reviews-header" data-reveal>
      <p class="section-label">Case Studies</p>
      <h2 class="section-h2">Real Agencies.<br><em>Real Growth.</em></h2>
    </div>
    <div class="slider-wrap" data-reveal style="transition-delay:.1s">
      <div class="slider-track" id="caseSliderTrack">
        <div class="case-card">
          <div class="case-card-tag"><i class="fa-solid fa-magnifying-glass-dollar"></i>Website + Local SEO</div>
          <div class="case-card-stat">0&nbsp;&rarr;&nbsp;28</div>
          <div class="case-card-stat-label">Private-pay clients in 7 months</div>
          <p class="case-card-desc">A full website redesign paired with local SEO took this agency from zero
            private-pay inquiries to a steady monthly pipeline.</p>
          <div class="case-card-client">
            <div class="case-card-avatar">TW</div>
            <div>
              <div class="case-card-name">Sunrise Senior Care</div>
              <div class="case-card-loc">Phoenix, AZ</div>
            </div>
          </div>
        </div>
        <div class="case-card">
          <div class="case-card-tag"><i class="fa-solid fa-gears"></i>AI &amp; Automation</div>
          <div class="case-card-stat">12 hrs</div>
          <div class="case-card-stat-label">Saved per week on follow-ups</div>
          <p class="case-card-desc">Automated lead response and scheduling freed up a full workday every week that
            used to go to manual phone tag.</p>
          <div class="case-card-client">
            <div class="case-card-avatar">RB</div>
            <div>
              <div class="case-card-name">Premier Home Health</div>
              <div class="case-card-loc">Dallas, TX</div>
            </div>
          </div>
        </div>
        <div class="case-card">
          <div class="case-card-tag"><i class="fa-brands fa-google"></i>Local SEO + Reviews</div>
          <div class="case-card-stat">6&nbsp;&rarr;&nbsp;52</div>
          <div class="case-card-stat-label">Google reviews, #1 local ranking in 4 months</div>
          <p class="case-card-desc">Review automation plus a Google Business Profile overhaul moved this agency to
            the top of the local map pack in its city.</p>
          <div class="case-card-client">
            <div class="case-card-avatar">SR</div>
            <div>
              <div class="case-card-name">Comfort Home Care</div>
              <div class="case-card-loc">Chicago, IL</div>
            </div>
          </div>
        </div>
        <div class="case-card">
          <div class="case-card-tag"><i class="fa-solid fa-arrow-trend-up"></i>AI Search SEO</div>
          <div class="case-card-stat">3x</div>
          <div class="case-card-stat-label">Increase in inquiry calls</div>
          <p class="case-card-desc">Getting cited by ChatGPT and Google AI Overviews put this agency in front of
            families before competitors even showed up.</p>
          <div class="case-card-client">
            <div class="case-card-avatar">LD</div>
            <div>
              <div class="case-card-name">Caring Hands Agency</div>
              <div class="case-card-loc">Houston, TX</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slider-controls">
      <button class="slider-btn" onclick="slideCases(-1)" aria-label="Previous"><i
          class="fa-solid fa-chevron-left"></i></button>
      <div class="slider-dots" id="caseSliderDots"></div>
      <button class="slider-btn" onclick="slideCases(1)" aria-label="Next"><i
          class="fa-solid fa-chevron-right"></i></button>
    </div>
  </div>
</section>

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
