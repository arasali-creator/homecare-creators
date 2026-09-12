<?php
$page_canonical = "https://homecarecreators.com/contact/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "Contact Us | Homecare Creators";
$page_desc = "Get in touch with Homecare Creators — call, email, or send us a message. We reply within 24 hours, Monday through Friday.";
$og_title = "Contact Us | Homecare Creators";
$og_desc = "Call, email, or message Homecare Creators — a marketing agency built exclusively for home care agencies in Florida.";
$page_css = <<<CSS
/* HERO */
.hero{min-height:42vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 60px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:720px;margin:0 auto;text-align:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(30px,4.4vw,50px);line-height:1.1;color:#fff;margin-bottom:16px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:18px;line-height:1.75;color:rgba(255,255,255,.65)}

/* CONTACT */
.contact-section{background:#fff}
.contact-inner{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start}
.contact-info{padding-top:8px}
.contact-details{display:flex;flex-direction:column;gap:20px;margin-top:28px}
.contact-detail{display:flex;align-items:center;gap:16px}
.contact-detail-icon{width:46px;height:46px;border-radius:13px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.contact-detail-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--muted);margin-bottom:2px}
.contact-detail-value{font-size:15px;font-weight:500;color:var(--forest)}
.contact-detail-value a{color:var(--teal);text-decoration:none}
.contact-detail-value a:hover{text-decoration:underline}
.contact-form-card{background:var(--warm);border:1px solid var(--border);border-radius:24px;padding:40px;box-shadow:0 16px 64px rgba(10,46,30,.1)}
.form-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:18px;color:var(--forest);margin-bottom:8px}
.form-subtitle{font-size:16px;color:var(--muted);margin-bottom:28px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
.form-success{display:none;text-align:center;padding:32px 16px;background:rgba(29,158,117,.06);border-radius:14px;border:1px solid rgba(29,158,117,.2)}
.form-success i{font-size:40px;color:var(--teal);margin-bottom:14px;display:block}
.form-success-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:18px;color:var(--forest);margin-bottom:6px}
.form-success p{font-size:16px;color:var(--muted)}

/* MAP */
.map-section{background:var(--cream)}
.map-wrap{border-radius:var(--r-lg);overflow:hidden;border:1px solid var(--border);box-shadow:0 16px 64px rgba(10,46,30,.08)}
.map-wrap iframe{width:100%;height:380px;display:block;border:0}

/* RESPONSIVE */
@media(max-width:900px){
  .contact-inner{grid-template-columns:1fr;gap:40px}
}
@media(max-width:640px){
  .hero{padding:120px 24px 50px}
  .form-row{grid-template-columns:1fr}
}
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-badge"><i class="fa-solid fa-comment-dots" style="margin-right:6px"></i>Contact Us</div>
    <h1 class="hero-h1">Let's Talk About<br><em>Growing Your Agency</em></h1>
    <p class="hero-desc">Call, email, or send us a message below. A real person replies within 24 hours, Monday through Friday.</p>
  </div>
</section>

<!-- CONTACT -->
<section class="contact-section">
  <div class="container contact-inner">
    <div class="contact-info" data-reveal>
      <p class="section-label">Get in Touch</p>
      <h2 class="section-h2">We'd Love to Hear<br><em>From You</em></h2>
      <p class="section-sub">Have a question about our services, pricing, or CareOS? Reach out directly or fill out the form — either way, you'll hear back from a real person within 24 hours.</p>
      <div class="contact-details">
        <div class="contact-detail">
          <div class="contact-detail-icon"><i class="fa-solid fa-phone"></i></div>
          <div>
            <div class="contact-detail-label">Call or Text</div>
            <div class="contact-detail-value"><a href="tel:+14094193533">+1 (409) 419-3533</a></div>
          </div>
        </div>
        <div class="contact-detail">
          <div class="contact-detail-icon"><i class="fa-solid fa-envelope"></i></div>
          <div>
            <div class="contact-detail-label">Email Us</div>
            <div class="contact-detail-value"><a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a></div>
          </div>
        </div>
        <div class="contact-detail">
          <div class="contact-detail-icon"><i class="fa-solid fa-location-dot"></i></div>
          <div>
            <div class="contact-detail-label">Based In</div>
            <div class="contact-detail-value">Lady Lake, FL 32159, United States</div>
          </div>
        </div>
        <div class="contact-detail">
          <div class="contact-detail-icon"><i class="fa-brands fa-linkedin-in"></i></div>
          <div>
            <div class="contact-detail-label">LinkedIn</div>
            <div class="contact-detail-value"><a href="https://www.linkedin.com/company/homecare-creators/" target="_blank" rel="noopener">linkedin.com/company/homecare-creators</a></div>
          </div>
        </div>
        <div class="contact-detail">
          <div class="contact-detail-icon"><i class="fa-solid fa-clock"></i></div>
          <div>
            <div class="contact-detail-label">Response Time</div>
            <div class="contact-detail-value">Within 24 hours, Monday&ndash;Friday</div>
          </div>
        </div>
      </div>
    </div>
    <div class="contact-form-card" data-reveal style="transition-delay:.15s">
      <div class="form-title">Send Us a Message</div>
      <div class="form-subtitle">We'll get back to you within 24 hours.</div>
      <div id="contactFormWrap">
        <div class="form-row">
          <div class="form-group" style="margin-bottom:0"><label class="form-label" for="cfFirst">First Name *</label><input type="text" class="form-input" id="cfFirst" placeholder="Sarah" autocomplete="given-name"></div>
          <div class="form-group" style="margin-bottom:0"><label class="form-label" for="cfLast">Last Name *</label><input type="text" class="form-input" id="cfLast" placeholder="Johnson" autocomplete="family-name"></div>
        </div>
        <div class="form-group"><label class="form-label" for="cfEmail">Email Address *</label><input type="email" class="form-input" id="cfEmail" placeholder="sarah@agency.com" autocomplete="email"></div>
        <div class="form-group"><label class="form-label" for="cfPhone">Phone Number</label><input type="tel" class="form-input" id="cfPhone" placeholder="+1 (555) 000-0000" autocomplete="tel"></div>
        <div class="form-group"><label class="form-label" for="cfAgency">Agency Name</label><input type="text" class="form-input" id="cfAgency" placeholder="Comfort Home Care LLC"></div>
        <div class="form-group"><label class="form-label" for="cfService">How Can We Help?</label>
          <select class="form-select" id="cfService">
            <option value="">Select a topic...</option>
            <option>Free Growth Audit</option>
            <option>Website Development</option>
            <option>Local SEO</option>
            <option>AI Search SEO</option>
            <option>Full Bundle Package</option>
            <option>CareOS Waitlist</option>
            <option>General Enquiry</option>
          </select>
        </div>
        <div class="form-group"><label class="form-label" for="cfMessage">Message</label><textarea class="form-textarea" id="cfMessage" placeholder="Tell us about your agency and what you'd like to achieve..."></textarea></div>
        <button class="form-submit" onclick="submitContact()"><i class="fa-solid fa-paper-plane"></i>Send Message</button>
      </div>
      <div class="form-success" id="contactSuccess">
        <i class="fa-solid fa-circle-check"></i>
        <div class="form-success-title">Message Received!</div>
        <p>Thank you! We'll reply within 24 hours.</p>
      </div>
    </div>
  </div>
</section>

<!-- MAP -->
<section class="map-section">
  <div class="container">
    <div style="text-align:center;margin-bottom:32px" data-reveal>
      <p class="section-label" style="justify-content:center">Find Us</p>
      <h2 class="section-h2">Based in Lady Lake, <em>Florida</em></h2>
    </div>
    <div class="map-wrap" data-reveal style="transition-delay:.1s">
      <iframe src="https://www.google.com/maps?q=Lady+Lake,+FL+32159&output=embed" loading="lazy" referrerpolicy="no-referrer-when-downgrade" title="Map showing Lady Lake, FL 32159"></iframe>
    </div>
  </div>
</section>

<?php
$page_js = <<<JS
function submitContact() {
  var first   = (document.getElementById('cfFirst').value || '').trim();
  var last    = (document.getElementById('cfLast').value || '').trim();
  var email   = (document.getElementById('cfEmail').value || '').trim();
  var phone   = (document.getElementById('cfPhone').value || '').trim();
  var agency  = (document.getElementById('cfAgency').value || '').trim();
  var service = document.getElementById('cfService').value;
  var msg     = (document.getElementById('cfMessage').value || '').trim();

  if (!first) { alert('Please enter your first name.'); document.getElementById('cfFirst').focus(); return; }
  if (!email || !email.includes('@')) { alert('Please enter a valid email.'); document.getElementById('cfEmail').focus(); return; }

  var submitBtn = document.querySelector('#contactFormWrap .form-submit');
  var originalHTML = submitBtn.innerHTML;
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i>Sending...';

  fetch('/form-handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      name:    first + ' ' + last,
      email:   email,
      phone:   phone || 'Not provided',
      agency:  agency || 'Not provided',
      service: service || 'Not specified',
      message: msg || '(none)',
      source:  'contact_page'
    })
  })
  .then(function(res) { return res.json(); })
  .then(function(d) {
    if (d.success) {
      document.getElementById('contactFormWrap').style.display = 'none';
      document.getElementById('contactSuccess').style.display = 'block';
    } else {
      alert('There was an error sending your message. Please try again.');
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalHTML;
    }
  })
  .catch(function(err) {
    console.error('Error:', err);
    alert('There was an error sending your message. Please try again.');
    submitBtn.disabled = false;
    submitBtn.innerHTML = originalHTML;
  });
}
JS;
include '../includes/footer.php';
?>
