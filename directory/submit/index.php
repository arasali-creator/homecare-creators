<?php
$page_title = "List Your Home Care Agency Free | Homecare Creators Directory";
$page_desc = "Add your home care agency to our free nationwide directory. Submit your listing — we'll review and publish it within 1-2 business days.";
$page_canonical = "https://homecarecreators.com/directory/submit/";
$og_title = "List Your Home Care Agency Free | Homecare Creators Directory";
$og_desc = "Get your agency listed in front of families searching for home care nationwide.";

$page_css = <<<CSS
.hero{background:var(--forest);position:relative;overflow:hidden;padding:140px 40px 60px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:700px;margin:0 auto;text-align:center}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(28px,4.2vw,42px);line-height:1.15;color:#fff;margin-bottom:14px}
.hero-desc{font-size:16.5px;line-height:1.7;color:rgba(255,255,255,.65)}

.submit-body{background:#fff}
.submit-form-card{max-width:720px;margin:0 auto;background:var(--warm);border:1px solid var(--border);border-radius:var(--r-lg);padding:40px;box-shadow:0 16px 48px rgba(10,46,30,.06)}
.sf-row{display:grid;grid-template-columns:1fr 1fr;gap:16px}
.sf-group{margin-bottom:18px}
.sf-group label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;letter-spacing:.4px;color:var(--forest);display:block;margin-bottom:7px}
.sf-group input,.sf-group textarea{width:100%;padding:12px 14px;border:1px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14.5px;background:#fff;outline:none;transition:border-color .2s}
.sf-group input:focus,.sf-group textarea:focus{border-color:var(--teal)}
.sf-hint{font-size:12px;color:var(--muted);margin-top:5px}
.sf-submit{width:100%;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;border:none;border-radius:11px;padding:16px 24px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15.5px;cursor:pointer;margin-top:6px;transition:.2s}
.sf-submit:hover{box-shadow:0 8px 28px rgba(29,158,117,.4)}
.sf-submit:disabled{opacity:.6;cursor:not-allowed}
.sf-privacy{font-size:11.5px;color:var(--muted);text-align:center;margin-top:14px}
.sf-success{display:none;text-align:center;padding:30px 0}
.sf-success i{font-size:50px;color:var(--teal);margin-bottom:16px;display:block}
.sf-success-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:700;color:var(--forest);margin-bottom:10px}
.sf-success p{font-size:15px;color:var(--muted);line-height:1.7}

@media(max-width:640px){
  .hero{padding:120px 24px 40px}
  .submit-form-card{padding:26px 20px}
  .sf-row{grid-template-columns:1fr}
}
CSS;
include '../../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-breadcrumb"><a href="/">Home</a> / <a href="/directory/">Directory</a> / <span style="color:var(--teal-lt)">List Your Agency</span></div>
    <div class="hero-badge"><i class="fa-solid fa-plus" style="margin-right:6px"></i>Free Listing</div>
    <h1 class="hero-h1">List Your Home Care<br>Agency — Free</h1>
    <p class="hero-desc">Submit your agency below. We review every listing before it goes live, usually within 1–2 business days.</p>
  </div>
</section>

<!-- FORM -->
<section class="submit-body">
  <div class="container">
    <div class="submit-form-card" data-reveal>

      <div id="submitFormWrap">
        <div class="hp-field" aria-hidden="true"><label for="fWebsite2">Website</label><input type="text" id="fWebsite2" tabindex="-1" autocomplete="off"></div>

        <div class="sf-group"><label for="fName">Company Name *</label><input type="text" id="fName" required></div>

        <div class="sf-row">
          <div class="sf-group"><label for="fCity">City *</label><input type="text" id="fCity" required></div>
          <div class="sf-group"><label for="fState">State *</label><input type="text" id="fState" placeholder="e.g. FL" maxlength="2" required></div>
        </div>

        <div class="sf-group">
          <label for="fDesc">Description *</label>
          <textarea id="fDesc" rows="4" placeholder="Tell families about your agency — who you serve, your specialties, what makes you different." required></textarea>
          <div class="sf-hint">At least a couple of sentences — this is what visitors will read on your profile.</div>
        </div>

        <div class="sf-group">
          <label for="fServices">Services Offered</label>
          <textarea id="fServices" rows="3" placeholder="Personal Care&#10;Companion Care&#10;Skilled Nursing"></textarea>
          <div class="sf-hint">One service per line.</div>
        </div>

        <div class="sf-group">
          <label for="fAreas">Service Areas</label>
          <textarea id="fAreas" rows="2" placeholder="Orlando, Winter Park, Kissimmee"></textarea>
          <div class="sf-hint">Cities or counties you serve, separated by commas.</div>
        </div>

        <div class="sf-row">
          <div class="sf-group"><label for="fPhone">Phone *</label><input type="tel" id="fPhone" required></div>
          <div class="sf-group"><label for="fEmail">Email *</label><input type="email" id="fEmail" required></div>
        </div>

        <div class="sf-row">
          <div class="sf-group"><label for="fWebsite">Website</label><input type="url" id="fWebsite" placeholder="https://"></div>
          <div class="sf-group"><label for="fLicense">License Number</label><input type="text" id="fLicense" placeholder="AHCA license #"></div>
        </div>

        <div class="sf-group"><label for="fAddress">Address <span style="font-weight:400;color:var(--muted)">(optional)</span></label><input type="text" id="fAddress"></div>

        <button class="sf-submit" id="submitBtn" onclick="submitListing()">Submit for Review</button>
        <div class="sf-privacy"><i class="fa-solid fa-lock" style="margin-right:4px"></i>We review every submission before publishing. No spam, ever.</div>
      </div>

      <div class="sf-success" id="submitSuccess">
        <i class="fa-solid fa-circle-check"></i>
        <div class="sf-success-title">Thanks — your listing is under review!</div>
        <p>We'll review your submission and publish it within 1–2 business days. You'll get an email once it's live.</p>
      </div>

    </div>
  </div>
</section>

<?php
$page_js = <<<JS
function submitListing() {
  var payload = {
    company_name: (document.getElementById('fName').value || '').trim(),
    city: (document.getElementById('fCity').value || '').trim(),
    state: (document.getElementById('fState').value || '').trim(),
    description: (document.getElementById('fDesc').value || '').trim(),
    services: (document.getElementById('fServices').value || '').trim(),
    service_areas: (document.getElementById('fAreas').value || '').trim(),
    phone: (document.getElementById('fPhone').value || '').trim(),
    email: (document.getElementById('fEmail').value || '').trim(),
    website: (document.getElementById('fWebsite').value || '').trim(),
    license_number: (document.getElementById('fLicense').value || '').trim(),
    address: (document.getElementById('fAddress').value || '').trim(),
    source: window.location.pathname,
    hp_website: (document.getElementById('fWebsite2').value || '').trim()
  };

  if (!payload.company_name) { alert('Please enter your company name.'); document.getElementById('fName').focus(); return; }
  if (!payload.city) { alert('Please enter your city.'); document.getElementById('fCity').focus(); return; }
  if (!payload.description || payload.description.length < 20) { alert('Please write at least a short description of your agency.'); document.getElementById('fDesc').focus(); return; }
  if (!payload.phone) { alert('Please enter a phone number.'); document.getElementById('fPhone').focus(); return; }
  if (!payload.email || !payload.email.includes('@') || !payload.email.includes('.')) { alert('Please enter a valid email address.'); document.getElementById('fEmail').focus(); return; }

  var btn = document.getElementById('submitBtn');
  btn.disabled = true;
  btn.textContent = 'Submitting...';

  fetch('/directory-submit-handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify(payload)
  })
  .then(function(r) { return r.json(); })
  .then(function(d) {
    if (d.success) {
      document.getElementById('submitFormWrap').style.display = 'none';
      document.getElementById('submitSuccess').style.display = 'block';
    } else {
      alert(d.message || 'Something went wrong. Please try again.');
      btn.disabled = false;
      btn.textContent = 'Submit for Review';
    }
  })
  .catch(function() {
    alert('Connection error. Please try again or email info@homecarecreators.com.');
    btn.disabled = false;
    btn.textContent = 'Submit for Review';
  });
}
JS;
include '../../includes/footer.php';
?>
