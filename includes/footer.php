<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div>
      <div class="footer-logo">
        <?php if (!empty($_hc_logo_url)): ?>
        <img src="<?= htmlspecialchars($_hc_logo_url) ?>" alt="Homecare Creators — Home Care Agency Marketing Company" title="Homecare Creators" style="height:48px;width:auto;display:block">
        <?php else: ?>
        <img src="/images/home/homecarecreators-logo.png" alt="Homecare Creators — Home Care Agency Marketing Company" title="Homecare Creators" style="height:48px;width:auto;display:block">
        <?php endif ?>
      </div>
      <p class="footer-tagline">Market It. Manage It. Grow It — Built Exclusively for Homecare.</p>
      <div class="footer-socials">
        <a href="https://www.linkedin.com/company/homecare-creators/" target="_blank" rel="noopener" class="footer-social" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="mailto:info@homecarecreators.com" class="footer-social" aria-label="Email us"><i class="fa-solid fa-envelope"></i></a>
      </div>
    </div>
    <div>
      <div class="footer-col-title">Services</div>
      <ul class="footer-links">
        <li><a href="/seo/homecare-website-design">Website Design</a></li>
        <li><a href="/seo/local-seo-for-home-care-agencies">Local SEO</a></li>
        <li><a href="/#services">AI Search SEO</a></li>
        <li><a href="/#bundles">Pricing &amp; Packages</a></li>
        <li><a href="/#careos">CareOS Platform</a></li>
        <li><a href="/blog">Marketing Blog</a></li>
      </ul>
    </div>
    <div>
      <div class="footer-col-title">Florida Cities</div>
      <ul class="footer-links">
        <li><a href="/home-care-agency-seo-miami-fl/">Miami</a></li>
        <li><a href="/home-care-agency-seo-orlando-fl/">Orlando</a></li>
        <li><a href="/home-care-agency-seo-sarasota-fl/">Sarasota</a></li>
        <li><a href="/home-care-agency-seo-jacksonville-fl/">Jacksonville</a></li>
        <li><a href="/home-care-agency-seo-fort-lauderdale-fl/">Fort Lauderdale</a></li>
        <li><a href="/home-care-agency-seo-naples-fl/">Naples</a></li>
        <li><a href="/home-care-agency-seo-west-palm-beach-fl/">West Palm Beach</a></li>
        <li><a href="/home-care-agency-seo-boca-raton-fl/">Boca Raton</a></li>
        <li><a href="/home-care-agency-seo-clearwater-fl/">Clearwater</a></li>
        <li><a href="/home-care-agency-seo-tampa-fl/">Tampa</a></li>
      </ul>
    </div>
    <div>
      <div class="footer-col-title">Web Design Cities</div>
      <ul class="footer-links">
        <li><a href="/web-design/homecare-website-design-miami-fl">Miami Web Design</a></li>
        <li><a href="/web-design/homecare-website-design-orlando-fl">Orlando Web Design</a></li>
        <li><a href="/web-design/homecare-website-design-tampa-fl">Tampa Web Design</a></li>
        <li><a href="/web-design/homecare-website-design-jacksonville-fl">Jacksonville Web Design</a></li>
        <li><a href="/web-design/homecare-website-design-fort-lauderdale-fl">Fort Lauderdale Web Design</a></li>
        <li><a href="/web-design/homecare-website-design-naples-fl">Naples Web Design</a></li>
      </ul>
    </div>
  </div>
  <div class="footer-bottom">
    <div class="footer-copy">© 2026 Homecare Creators &middot; <a href="mailto:info@homecarecreators.com" style="color:inherit">info@homecarecreators.com</a> &middot; All rights reserved.</div>
    <div class="footer-bottom-links"><a href="/privacy-policy">Privacy Policy</a><a href="/terms-of-service">Terms of Service</a></div>
  </div>
</footer>

<script>
// Scroll progress + nav scroll class
window.addEventListener('scroll', function() {
  var pct = window.scrollY / (document.body.scrollHeight - window.innerHeight) * 100;
  document.getElementById('scrollProgress').style.width = pct + '%';
  document.getElementById('mainNav').classList.toggle('scrolled', window.scrollY > 40);
});

// Intersection observer for reveal animations
var revealObs = new IntersectionObserver(function(entries) {
  entries.forEach(function(e) {
    if (e.isIntersecting) {
      var delay = parseFloat(e.target.style.transitionDelay || '0') * 1000;
      setTimeout(function() { e.target.classList.add('visible'); }, delay);
    }
  });
}, { threshold: 0.08, rootMargin: '0px 0px -50px 0px' });
document.querySelectorAll('[data-reveal]').forEach(function(el) { revealObs.observe(el); });

// FAQ accordion
function toggleFaq(q) {
  var item = q.closest('.faq-item');
  var isOpen = item.classList.contains('open');
  document.querySelectorAll('.faq-item.open').forEach(function(i) { i.classList.remove('open'); });
  if (!isOpen) item.classList.add('open');
}

// ── CAPTCHA ──────────────────────────────────────────────────
var _captchaA = 0, _captchaB = 0;
function generateCaptcha() {
  _captchaA = Math.floor(Math.random() * 9) + 1;
  _captchaB = Math.floor(Math.random() * 9) + 1;
  var el = document.getElementById('captchaQuestion');
  if (el) { el.textContent = 'What is ' + _captchaA + ' + ' + _captchaB + '?'; }
  var inp = document.getElementById('pCaptcha');
  if (inp) inp.value = '';
}
generateCaptcha();

// ── Phone formatting (US) ─────────────────────────────────────
document.getElementById('pPhone').addEventListener('input', function() {
  var digits = this.value.replace(/\D/g, '').substring(0, 10);
  var fmt = '';
  if (digits.length > 0) fmt = '(' + digits.substring(0, 3);
  if (digits.length >= 4) fmt += ') ' + digits.substring(3, 6);
  if (digits.length >= 7) fmt += '-' + digits.substring(6, 10);
  this.value = fmt;
  this.classList.toggle('error', digits.length > 0 && digits.length < 10);
});

// ── Popup open / close ────────────────────────────────────────
function openPopup() {
  document.getElementById('mainPopup').classList.add('open');
  document.body.style.overflow = 'hidden';
  generateCaptcha();
}
function closePopup() {
  document.getElementById('mainPopup').classList.remove('open');
  document.body.style.overflow = '';
}
document.getElementById('mainPopup').addEventListener('click', function(e) { if (e.target === this) closePopup(); });
document.getElementById('popupCloseBtn').addEventListener('click', closePopup);
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closePopup(); });

// ── Form submit ───────────────────────────────────────────────
document.getElementById('popupSubmitBtn').addEventListener('click', function() {
  var name    = (document.getElementById('pName').value  || '').trim();
  var email   = (document.getElementById('pEmail').value || '').trim();
  var phone   = (document.getElementById('pPhone').value || '').trim();
  var captcha = parseInt(document.getElementById('pCaptcha').value, 10);
  var consent = document.getElementById('pConsent').checked;

  // Validation
  if (!name)  { markError('pName',  'Please enter your full name.'); return; }
  if (!email || !email.includes('@') || !email.includes('.')) { markError('pEmail', 'Please enter a valid email address.'); return; }
  var phoneDigits = phone.replace(/\D/g, '');
  if (!phone || phoneDigits.length !== 10) { markError('pPhone', 'Please enter a valid 10-digit phone number.'); return; }
  if (isNaN(captcha) || captcha !== _captchaA + _captchaB) {
    markError('pCaptcha', 'Incorrect answer. Please try again.');
    generateCaptcha();
    return;
  }
  if (!consent) {
    var cb = document.getElementById('pConsent');
    cb.style.outline = '2px solid #e53e3e';
    setTimeout(function(){ cb.style.outline = ''; }, 2000);
    alert('Please check the consent box to continue.');
    return;
  }

  var btnLabel = document.getElementById('popupBtnLabel');
  btnLabel.textContent = 'Sending...';
  this.disabled = true;
  fetch('/form-handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      name:    name,
      email:   email,
      phone:   phone,
      agency:  document.getElementById('pAgency').value,
      city:    document.getElementById('pCity').value,
      service: document.getElementById('pService').value,
      message: document.getElementById('pMsg').value,
      source:  window.location.pathname
    })
  })
  .then(function(r) { return r.json(); })
  .then(function(d) {
    if (d.success) {
      document.getElementById('popupFormEl').style.display = 'none';
      document.getElementById('popupSuccessEl').style.display = 'block';
    } else {
      alert('Error: ' + (d.message || 'Please try again or email info@homecarecreators.com'));
      btnLabel.textContent = 'Send My Request';
      document.getElementById('popupSubmitBtn').disabled = false;
    }
  })
  .catch(function() {
    alert('Connection error. Please email info@homecarecreators.com directly.');
    btnLabel.textContent = 'Send My Request';
    document.getElementById('popupSubmitBtn').disabled = false;
  });
});

function markError(id, msg) {
  var el = document.getElementById(id);
  if (!el) { alert(msg); return; }
  el.classList.add('error');
  el.focus();
  el.addEventListener('input', function(){ el.classList.remove('error'); }, { once: true });
  // Show inline message below field
  var existing = el.parentNode.querySelector('.field-error-msg');
  if (existing) existing.remove();
  var err = document.createElement('div');
  err.className = 'field-error-msg';
  err.style.cssText = 'font-size:11px;color:#e53e3e;margin-top:4px;font-family:Arial,sans-serif';
  err.textContent = msg;
  el.parentNode.appendChild(err);
  setTimeout(function(){ if (err.parentNode) err.remove(); }, 3000);
}

// Mobile hamburger nav
document.getElementById('navHamburger').addEventListener('click', function() {
  var links = document.querySelector('.nav-links');
  if (links.style.display === 'flex') {
    links.style.display = '';
    links.style.flexDirection = '';
    links.style.position = '';
  } else {
    links.style.display = 'flex';
    links.style.flexDirection = 'column';
    links.style.position = 'absolute';
    links.style.top = '72px';
    links.style.left = '0';
    links.style.right = '0';
    links.style.background = 'rgba(8,36,22,.98)';
    links.style.padding = '20px';
    links.style.gap = '4px';
  }
});
</script>
<?php if (!empty($page_js)): ?>
<script><?= $page_js ?></script>
<?php endif; ?>
</body>
</html>
