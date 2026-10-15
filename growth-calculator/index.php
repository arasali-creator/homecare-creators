<?php
$page_title = "Website Growth Calculator — See What You're Missing | Homecare Creators";
$page_desc = "See how many more clients and how much more revenue your home care agency could generate. Free, instant estimate.";
$page_canonical = "https://homecarecreators.com/growth-calculator/";
$og_title = "Website Growth Calculator | Homecare Creators";
$og_desc = "A free, 60-second tool to see what your home care agency could be missing.";

require_once '../admin/config.php';
require_once '../admin/includes/db.php';
require_once '../admin/includes/functions.php';

$offer_discount = (int) hc_setting('calc_offer_discount_pct', '50');
$offer_spots    = (int) hc_setting('calc_offer_spots_left', '3');

$page_css = <<<CSS
/* HERO */
.hero{min-height:36vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 56px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:760px;margin:0 auto;text-align:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(28px,4.2vw,46px);line-height:1.15;color:#fff;margin-bottom:14px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:17px;line-height:1.7;color:rgba(255,255,255,.65)}

/* CALCULATOR */
.calc-section{background:var(--cream);padding:56px 40px 72px}
.calc-grid{display:grid;grid-template-columns:1fr 1fr;gap:28px;max-width:1080px;margin:0 auto;align-items:start}
.calc-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px}
.calc-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:700;color:var(--forest);margin-bottom:6px}
.calc-card-sub{font-size:13.5px;color:var(--muted);margin-bottom:26px}

/* Inputs */
.cf-group{margin-bottom:24px}
.cf-group:last-child{margin-bottom:0}
.cf-label-row{display:flex;justify-content:space-between;align-items:center;margin-bottom:8px;gap:10px}
.cf-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:700;color:var(--forest)}
.cf-value{display:flex;align-items:center}
.cf-value input{width:92px;text-align:right;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--teal);border:1.5px solid var(--border);border-radius:8px;padding:6px 10px;outline:none}
.cf-value input:focus{border-color:var(--teal)}
.cf-group input[type=range]{width:100%;accent-color:var(--teal);height:6px;cursor:pointer}
.cf-range-labels{display:flex;justify-content:space-between;font-size:11px;color:var(--muted);margin-top:4px}
.cf-hint{font-size:12px;color:var(--muted);margin-top:6px;line-height:1.5}

/* Results — ungated headline stats */
.res-badge{display:inline-flex;align-items:center;gap:6px;background:rgba(29,158,117,.1);color:var(--teal);font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:5px 12px;border-radius:20px;margin-bottom:18px}
.res-stat-row{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-bottom:20px}
.res-stat{background:var(--warm);border:1px solid var(--border);border-radius:12px;padding:16px;text-align:center}
.res-stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:700;color:var(--forest)}
.res-stat-label{font-size:11.5px;color:var(--muted);margin-top:4px;line-height:1.4}
.res-delta{background:rgba(29,158,117,.08);border:1px solid rgba(29,158,117,.25);border-radius:12px;padding:16px;text-align:center;margin-bottom:24px}
.res-delta-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:30px;font-weight:700;color:var(--teal)}
.res-delta-label{font-size:12.5px;color:var(--forest);font-weight:600;margin-top:4px}

.res-breakdown{font-size:13.5px;color:var(--muted);line-height:2;background:var(--warm);border:1px dashed var(--border);border-radius:12px;padding:16px 18px;margin-bottom:20px}
.res-breakdown strong{color:var(--forest)}
.res-unlocked{text-align:center}
.res-unlocked-eyebrow{font-size:12px;color:var(--muted);font-weight:600;margin-bottom:6px}
.res-unlocked-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(30px,5vw,42px);font-weight:700;color:var(--forest);margin-bottom:14px}
.res-cta-btn{display:inline-flex;align-items:center;gap:8px;background:var(--teal);color:#fff;border:none;padding:14px 26px;border-radius:50px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;cursor:pointer;text-decoration:none;transition:.2s}
.res-cta-btn:hover{background:#178a64;transform:translateY(-2px)}

/* Offer banner */
.offer-banner{display:flex;align-items:center;gap:12px;background:rgba(201,168,76,.1);border:1px dashed rgba(201,168,76,.4);border-radius:12px;padding:14px 16px;margin-bottom:18px;text-align:left}
.offer-banner i{font-size:20px;color:#c9a84c;flex-shrink:0}
.offer-banner strong{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;color:#7a5f18}
.offer-banner span{font-size:12px;color:#8a6800}

/* Blur-until-unlocked — plain stack, no absolute positioning (avoids overlap bugs) */
.blurred-preview{filter:blur(6px);user-select:none;pointer-events:none;margin-bottom:20px}
.unlock-prompt{text-align:center;margin-bottom:16px}
.unlock-prompt i{font-size:24px;color:var(--teal);margin-bottom:8px;display:block}
.unlock-prompt p{font-size:13.5px;color:var(--forest);font-weight:600;max-width:320px;margin:0 auto}

/* Gate form */
.gate-form{display:flex;flex-direction:column;gap:10px;text-align:left;width:100%;max-width:340px;margin:0 auto}
.gate-form input,.gate-form select{width:100%;padding:12px 14px;border:1.5px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14px;outline:none;background:#fff;transition:border-color .2s}
.gate-form input:focus,.gate-form select:focus{border-color:var(--teal)}
.gate-row{display:grid;grid-template-columns:1fr 1fr;gap:10px}
.gate-submit{background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;border:none;padding:14px 20px;border-radius:9px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px;font-weight:700;cursor:pointer;transition:.2s;margin-top:4px}
.gate-submit:hover{box-shadow:0 8px 28px rgba(29,158,117,.4)}
.gate-submit:disabled{opacity:.6;cursor:not-allowed}
.gate-privacy{font-size:11.5px;color:var(--muted);text-align:center;margin-top:2px}

/* CHECKLIST */
.checklist-section{background:#fff;padding:56px 40px;border-top:1px solid var(--border)}
.checklist-inner{max-width:1080px;margin:0 auto}
.checklist-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:14px;margin-top:24px}
.checklist-item{display:flex;align-items:flex-start;gap:8px;font-size:13.5px;color:var(--text);line-height:1.5}
.checklist-item i{color:var(--teal);margin-top:2px;flex-shrink:0}

.calc-disclaimer{max-width:1080px;margin:28px auto 0;text-align:center;font-size:12px;color:var(--muted);line-height:1.6}

@media(max-width:960px){
  .calc-grid{grid-template-columns:1fr}
  .checklist-grid{grid-template-columns:repeat(2,1fr)}
}
@media(max-width:640px){
  .hero{padding:120px 24px 40px}
  .calc-section{padding:40px 20px 56px}
  .calc-card{padding:22px}
  .gate-row{grid-template-columns:1fr}
  .checklist-section{padding:40px 20px}
  .checklist-grid{grid-template-columns:1fr}
}
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-badge"><i class="fa-solid fa-calculator" style="margin-right:6px"></i>Website Growth Calculator</div>
    <h1 class="hero-h1">How Many Clients Could<br>Your Agency Be <em>Missing?</em></h1>
    <p class="hero-desc">Answer a few quick questions about your inquiries and close rate to see your estimated growth opportunity — takes about 60 seconds.</p>
  </div>
</section>

<!-- CALCULATOR -->
<section class="calc-section">
  <div class="calc-grid">

    <!-- INPUTS -->
    <div class="calc-card" data-reveal>
      <div class="calc-card-title">Your Agency Today</div>
      <div class="calc-card-sub">Rough estimates are fine — this just helps size the opportunity.</div>

      <div class="cf-group">
        <div class="cf-label-row">
          <span class="cf-label">Inquiries you get per month</span>
          <span class="cf-value"><input type="number" id="numInquiries" value="20" min="1" max="150" step="1"></span>
        </div>
        <input type="range" id="rngInquiries" min="1" max="150" step="1" value="20">
        <div class="cf-range-labels"><span>1</span><span>150</span></div>
      </div>

      <div class="cf-group">
        <div class="cf-label-row">
          <span class="cf-label">% of inquiries that become clients</span>
          <span class="cf-value"><input type="number" id="numCloseRate" value="33" min="5" max="70" step="1"> %</span>
        </div>
        <input type="range" id="rngCloseRate" min="5" max="70" step="1" value="33">
        <div class="cf-range-labels"><span>5%</span><span>70%</span></div>
        <div class="cf-hint">This is just a fact about your intake process today — the industry average is around 33% (Home Care Pulse benchmark data).</div>
      </div>

      <div class="cf-group">
        <div class="cf-label-row">
          <span class="cf-label">More inquiries stronger visibility could bring</span>
          <span class="cf-value">+<input type="number" id="numAdditionalInq" value="10" min="0" max="100" step="1"></span>
        </div>
        <input type="range" id="rngAdditionalInq" min="0" max="100" step="1" value="10">
        <div class="cf-range-labels"><span>+0</span><span>+100</span></div>
        <div class="cf-hint">Extra monthly inquiries from more people finding and trusting your agency online — your close rate stays the same, you're just reaching more people.</div>
      </div>

      <div class="cf-group">
        <div class="cf-label-row">
          <span class="cf-label">Average monthly value per client</span>
          <span class="cf-value">$<input type="number" id="numValue" value="2500" min="500" max="8000" step="100"></span>
        </div>
        <input type="range" id="rngValue" min="500" max="8000" step="100" value="2500">
        <div class="cf-range-labels"><span>$500</span><span>$8,000</span></div>
      </div>

      <div class="cf-group">
        <div class="cf-label-row">
          <span class="cf-label">Average length of care</span>
          <span class="cf-value"><input type="number" id="numLength" value="6" min="1" max="24" step="1"> mo</span>
        </div>
        <input type="range" id="rngLength" min="1" max="24" step="1" value="6">
        <div class="cf-range-labels"><span>1 mo</span><span>24 mo</span></div>
        <div class="cf-hint">How long a typical client stays with your agency.</div>
      </div>
    </div>

    <!-- RESULTS -->
    <div class="calc-card" data-reveal style="transition-delay:.1s">
      <div class="res-badge"><i class="fa-solid fa-chart-line"></i> Your Results</div>

      <!-- Ungated: real, live, simple counts -->
      <div class="res-stat-row">
        <div class="res-stat"><div class="res-stat-num" id="outCurrent">7</div><div class="res-stat-label">Current clients per month</div></div>
        <div class="res-stat"><div class="res-stat-num" id="outPotential">10</div><div class="res-stat-label">Potential clients per month</div></div>
      </div>
      <div class="res-delta">
        <div class="res-delta-num" id="outDelta">+3</div>
        <div class="res-delta-label">Additional clients per month</div>
      </div>

      <!-- Gated: dollar value + recommendation -->
      <div id="realResults" style="display:none">
        <div class="res-breakdown">
          <strong id="brkDelta">+3</strong> extra clients/mo &times; 12 months = <strong id="brkYearClients">+36</strong> new clients/year<br>
          &times; <strong id="brkLtv">$15,000</strong> average client lifetime value
        </div>
        <div class="res-unlocked">
          <div class="offer-banner">
            <i class="fa-solid fa-fire"></i>
            <div><strong><?= $offer_discount ?>% Off Your Free Audit</strong><span>Only <?= $offer_spots ?> spot<?= $offer_spots===1?'':'s' ?> left this month</span></div>
          </div>
          <div class="res-unlocked-eyebrow">Your Estimated Annual Opportunity</div>
          <div class="res-unlocked-num" id="unlockedNum">$0</div>
          <p style="font-size:13.5px;color:var(--muted);margin-bottom:20px" id="unlockedProblem"></p>
          <a href="#" id="unlockedCta" class="res-cta-btn">Claim My Discounted Audit &rarr;</a>
        </div>
      </div>

      <div id="lockedState">
        <div class="blurred-preview">
          <div class="res-breakdown">
            <strong>+3</strong> extra clients/mo &times; 12 months = <strong>+36</strong> new clients/year<br>
            &times; <strong>$15,000</strong> average client lifetime value
          </div>
          <div class="res-unlocked">
            <div class="res-unlocked-eyebrow">Your Estimated Annual Opportunity</div>
            <div class="res-unlocked-num">$540,000</div>
          </div>
        </div>

        <div class="unlock-prompt">
          <i class="fa-solid fa-lock"></i>
          <p>Enter your info to unlock your full growth report + a free personalized recommendation.</p>
        </div>
        <div class="offer-banner">
          <i class="fa-solid fa-fire"></i>
          <div><strong><?= $offer_discount ?>% Off Your Free Audit</strong><span>Only <?= $offer_spots ?> spot<?= $offer_spots===1?'':'s' ?> left this month</span></div>
        </div>
        <form class="gate-form" id="gateForm">
          <div class="hp-field" aria-hidden="true"><label for="gHp">Website</label><input type="text" id="gHp" tabindex="-1" autocomplete="off"></div>
          <input type="text" id="gName" placeholder="Your name" autocomplete="name" required>
          <div class="gate-row">
            <input type="email" id="gEmail" placeholder="Email" autocomplete="email" required>
            <input type="tel" id="gPhone" placeholder="Phone" autocomplete="tel" required>
          </div>
          <input type="text" id="gCity" placeholder="City your agency serves" autocomplete="address-level2" required>
          <input type="url" id="gWebsiteUrl" placeholder="Your website URL" autocomplete="url" required>
          <select id="gProblem" required>
            <option value="" disabled selected>What's your biggest challenge right now?</option>
            <option value="seo">Not showing up on Google</option>
            <option value="website">Website doesn't turn visitors into leads</option>
            <option value="ai">Not showing up in AI search (ChatGPT, etc.)</option>
            <option value="strategy">Not sure / need an overall strategy</option>
          </select>
          <button type="submit" class="gate-submit" id="gateSubmitBtn">Unlock My Full Report</button>
          <div class="gate-privacy"><i class="fa-solid fa-lock" style="margin-right:4px"></i>100% private. No spam, ever.</div>
        </form>
      </div>
    </div>

  </div>

  <p class="calc-disclaimer">This calculator provides estimates based on the information you enter — it is not a guarantee of results. Actual outcomes vary by market, competition, and execution. All figures are approximate.</p>
</section>

<!-- CHECKLIST -->
<section class="checklist-section">
  <div class="checklist-inner" data-reveal>
    <p class="section-label">Quick Check</p>
    <h2 class="section-h2" style="font-size:clamp(22px,3vw,32px)">Does Your Website Have These?</h2>
    <div class="checklist-grid">
      <div class="checklist-item"><i class="fa-solid fa-circle-check"></i>Clear, simple contact form</div>
      <div class="checklist-item"><i class="fa-solid fa-circle-check"></i>Mobile-friendly experience</div>
      <div class="checklist-item"><i class="fa-solid fa-circle-check"></i>Easy-to-find services &amp; service areas</div>
      <div class="checklist-item"><i class="fa-solid fa-circle-check"></i>Fast loading speed</div>
      <div class="checklist-item"><i class="fa-solid fa-circle-check"></i>Licensing &amp; trust signals visible</div>
    </div>
  </div>
</section>

<?php
$page_js = <<<JS
// ── Sync range + number inputs ──────────────────────────────
function syncPair(rangeId, numId, onChange) {
  var r = document.getElementById(rangeId), n = document.getElementById(numId);
  r.addEventListener('input', function(){ n.value = r.value; onChange(); });
  n.addEventListener('input', function(){
    var v = parseFloat(n.value);
    if (!isNaN(v)) { v = Math.min(Math.max(v, parseFloat(r.min)), parseFloat(r.max)); r.value = v; }
    onChange();
  });
}

var unlocked = false;
var lastResults = null;

function calc() {
  var inquiries = parseFloat(document.getElementById('numInquiries').value) || 0;
  var closeRate = parseFloat(document.getElementById('numCloseRate').value) || 0;
  var additionalInq = parseFloat(document.getElementById('numAdditionalInq').value) || 0;
  var value = parseFloat(document.getElementById('numValue').value) || 0;
  var length = parseFloat(document.getElementById('numLength').value) || 0;

  var currentClients = Math.round(inquiries * closeRate / 100);
  var potentialClients = Math.round((inquiries + additionalInq) * closeRate / 100);
  var deltaClients = Math.max(0, potentialClients - currentClients);
  var ltv = Math.round(value * length);
  var yearClients = deltaClients * 12;
  var annualOpportunity = yearClients * ltv;

  document.getElementById('outCurrent').textContent = currentClients.toLocaleString();
  document.getElementById('outPotential').textContent = potentialClients.toLocaleString();
  document.getElementById('outDelta').textContent = '+' + deltaClients.toLocaleString();

  lastResults = { monthly_inquiries: inquiries, close_rate: closeRate, additional_inquiries_target: additionalInq, monthly_value_per_client: value, avg_length_months: length };

  if (unlocked) {
    document.getElementById('brkDelta').textContent = '+' + deltaClients.toLocaleString();
    document.getElementById('brkYearClients').textContent = '+' + yearClients.toLocaleString();
    document.getElementById('brkLtv').textContent = '\$' + ltv.toLocaleString();
    document.getElementById('unlockedNum').textContent = '\$' + annualOpportunity.toLocaleString();
  }
}

syncPair('rngInquiries', 'numInquiries', calc);
syncPair('rngCloseRate', 'numCloseRate', calc);
syncPair('rngAdditionalInq', 'numAdditionalInq', calc);
syncPair('rngValue', 'numValue', calc);
syncPair('rngLength', 'numLength', calc);
calc();

var problemCtas = {
  seo: { url: '/seo/home-care-seo/', label: "Based on your answer, your biggest lever is stronger local SEO so more families find you on Google." },
  website: { url: '/web-design/homecare-website-design/', label: "Based on your answer, your biggest lever is a website redesign built to convert visitors into inquiries." },
  ai: { url: '/ai-search-seo/', label: "Based on your answer, your biggest lever is optimizing for AI search (ChatGPT, Google AI, etc.)." },
  strategy: { url: '/contact/', label: "Based on your answer, let's build a full strategy together." }
};

document.getElementById('gateForm').addEventListener('submit', function(e) {
  e.preventDefault();
  var name = document.getElementById('gName').value.trim();
  var email = document.getElementById('gEmail').value.trim();
  var phone = document.getElementById('gPhone').value.trim();
  var city = document.getElementById('gCity').value.trim();
  var website = document.getElementById('gWebsiteUrl').value.trim();
  var problem = document.getElementById('gProblem').value;
  var honeypot = document.getElementById('gHp').value.trim();

  if (!name) { alert('Please enter your name.'); return; }
  if (!email || !email.includes('@') || !email.includes('.')) { alert('Please enter a valid email address.'); return; }
  if (!phone) { alert('Please enter your phone number.'); return; }
  if (!city) { alert('Please enter your city.'); return; }
  if (!website) { alert('Please enter your website URL.'); return; }
  if (!problem) { alert("Please select your biggest challenge."); return; }

  var btn = document.getElementById('gateSubmitBtn');
  btn.disabled = true;
  btn.textContent = 'Calculating...';

  fetch('/calculator-submit-handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      name: name, email: email, phone: phone, city: city, website: website, problem: problem,
      monthly_inquiries: lastResults.monthly_inquiries,
      close_rate: lastResults.close_rate,
      additional_inquiries_target: lastResults.additional_inquiries_target,
      monthly_value_per_client: lastResults.monthly_value_per_client,
      avg_length_months: lastResults.avg_length_months,
      source: window.location.pathname,
      hp_website: honeypot
    })
  })
  .then(function(r){ return r.json(); })
  .then(function(d){
    if (d.success) {
      unlocked = true;
      document.getElementById('lockedState').style.display = 'none';
      document.getElementById('realResults').style.display = 'block';

      document.getElementById('brkDelta').textContent = '+' + d.results.additional_clients.toLocaleString();
      document.getElementById('brkYearClients').textContent = '+' + (d.results.additional_clients * 12).toLocaleString();
      document.getElementById('brkLtv').textContent = '\$' + Math.round(d.results.client_ltv).toLocaleString();
      document.getElementById('unlockedNum').textContent = '\$' + Math.round(d.results.additional_annual_value).toLocaleString();

      var pc = problemCtas[problem] || problemCtas.strategy;
      document.getElementById('unlockedProblem').textContent = pc.label;
      document.getElementById('unlockedCta').href = pc.url;
    } else {
      alert(d.message || 'Something went wrong. Please try again.');
      btn.disabled = false;
      btn.textContent = 'Unlock My Full Report';
    }
  })
  .catch(function(){
    alert('Connection error. Please try again or email info@homecarecreators.com.');
    btn.disabled = false;
    btn.textContent = 'Unlock My Full Report';
  });
});
JS;
include '../includes/footer.php';
?>
