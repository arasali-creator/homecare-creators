<!-- FOOTER -->
<footer>
  <div class="footer-card">
    <div class="footer-top">
      <div class="footer-brand" data-reveal>
        <div class="footer-brand-row">
          <div class="footer-logo">
            <?php if (!empty($_hc_logo_url)): ?>
            <img src="<?= htmlspecialchars($_hc_logo_url) ?>" alt="Homecare Creators — Home Care Agency Marketing Company" title="Homecare Creators" style="height:36px;width:auto;display:block;border-radius:12px">
            <?php else: ?>
            <img src="/images/home/homecarecreators-logo.png" alt="Homecare Creators — Home Care Agency Marketing Company" title="Homecare Creators" style="height:36px;width:auto;display:block;border-radius:12px">
            <?php endif ?>
          </div>
          <div class="footer-socials">
            <a href="https://www.linkedin.com/company/homecare-creators/" target="_blank" rel="noopener" class="footer-social" aria-label="LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
            <a href="https://www.instagram.com/homecare_creators/" target="_blank" rel="noopener" class="footer-social" aria-label="Instagram"><i class="fa-brands fa-instagram"></i></a>
            <a href="https://web.facebook.com/people/Homecare-Creators/61594535490703/" target="_blank" rel="noopener" class="footer-social" aria-label="Facebook"><i class="fa-brands fa-facebook-f"></i></a>
            <a href="https://wa.me/14094193533" target="_blank" rel="noopener" class="footer-social" aria-label="Message us on WhatsApp"><i class="fa-brands fa-whatsapp"></i></a>
          </div>
        </div>
        <h3 class="footer-heading">Ready to Grow Your <em>Homecare Agency?</em></h3>
        <form class="footer-subscribe" id="footerSubscribeForm">
          <input type="email" id="footerEmailInput" placeholder="Enter your email" required autocomplete="email">
          <button type="submit" aria-label="Get started"><i class="fa-solid fa-arrow-right"></i></button>
        </form>
      </div>

      <div class="footer-groups">
        <div class="footer-group" data-reveal style="transition-delay:.05s">
          <div class="footer-group-title">Company</div>
          <ul class="footer-links">
            <li><a href="/about/">About Us</a></li>
            <li><a href="/contact/">Contact</a></li>
            <li><a href="/case-studies/">Case Studies</a></li>
            <li><a href="/events/">Events</a></li>
            <li><a href="/blog">Marketing Blog</a></li>
            <li><a href="/sitemap/">Sitemap</a></li>
          </ul>
        </div>
        <div class="footer-group" data-reveal style="transition-delay:.1s">
          <div class="footer-group-title">Services</div>
          <ul class="footer-links">
            <li><a href="/seo/home-care-seo/">Home Care SEO</a></li>
            <li><a href="/web-design/homecare-website-design/">Website Design</a></li>
            <li><a href="/ai-search-seo/">AI Search SEO</a></li>
            <li><a href="/ai-automation/">AI &amp; Automation</a></li>
            <li><a href="/#bundles">Pricing &amp; Packages</a></li>
            <li><a href="/products/">Products</a></li>
            <li><a href="/directory/">Agency Directory</a></li>
            <li><a href="/growth-calculator/">Growth Calculator</a></li>
          </ul>
        </div>
        <div class="footer-group" data-reveal style="transition-delay:.15s">
          <div class="footer-group-title">Get In Touch</div>
          <ul class="footer-links" style="margin-bottom:16px">
            <li><a href="/memory-care-marketing/">Memory Care</a></li>
            <li><a href="/hospice-marketing/">Hospice</a></li>
            <li><a href="/nursing-home-marketing/">Nursing Homes</a></li>
            <li><a href="/senior-living-marketing/">Senior Living</a></li>
            <li><a href="/assisted-living-marketing/">Assisted Living</a></li>
          </ul>
          <div class="footer-contact-pills">
            <a href="mailto:info@homecarecreators.com" class="footer-pill"><i class="fa-solid fa-envelope"></i>info@homecarecreators.com</a>
            <a href="https://wa.me/14094193533" target="_blank" rel="noopener" class="footer-pill"><i class="fa-brands fa-whatsapp"></i>+1 (409) 419-3533</a>
          </div>
        </div>
      </div>
    </div>

    <div class="footer-bottom">
      <div class="footer-copy">© 2026 Homecare Creators &middot; Lady Lake, FL 32159, United States &middot; All rights reserved.</div>
      <div class="footer-bottom-links">
        <a href="/privacy-policy">Privacy Policy</a>
        <a href="/terms-of-service">Terms of Service</a>
        <a href="#" class="footer-top-btn" aria-label="Back to top" onclick="window.scrollTo({top:0,behavior:'smooth'});return false;"><i class="fa-solid fa-arrow-up"></i></a>
      </div>
    </div>
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
  document.querySelectorAll('.faq-item.open').forEach(function(i) {
    i.classList.remove('open');
    var btn = i.querySelector('.faq-q');
    if (btn) btn.setAttribute('aria-expanded', 'false');
  });
  if (!isOpen) {
    item.classList.add('open');
    q.setAttribute('aria-expanded', 'true');
  }
}
document.addEventListener('keydown', function(e) {
  if ((e.key === 'Enter' || e.key === ' ') && e.target.classList && e.target.classList.contains('faq-q')) {
    e.preventDefault();
    toggleFaq(e.target);
  }
});

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

// ── Footer quick-start (pre-fills the booking popup's email) ──
var footerSubscribeForm = document.getElementById('footerSubscribeForm');
if (footerSubscribeForm) {
  footerSubscribeForm.addEventListener('submit', function(e) {
    e.preventDefault();
    var val = (document.getElementById('footerEmailInput').value || '').trim();
    var pEmail = document.getElementById('pEmail');
    if (pEmail) pEmail.value = val;
    openPopup();
  });
}

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
  var honeypot = (document.getElementById('pWebsite').value || '').trim();

  // Honeypot: real users never fill this field. Pretend success and stop.
  if (honeypot) {
    document.getElementById('popupFormEl').style.display = 'none';
    document.getElementById('popupSuccessEl').style.display = 'block';
    return;
  }

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
      source:  window.location.pathname,
      website: honeypot
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
  err.setAttribute('role', 'alert');
  err.setAttribute('aria-live', 'assertive');
  err.style.cssText = 'font-size:11px;color:#e53e3e;margin-top:4px;font-family:Arial,sans-serif';
  err.textContent = msg;
  el.parentNode.appendChild(err);
  setTimeout(function(){ if (err.parentNode) err.remove(); }, 6000);
}

// Mobile hamburger nav
document.getElementById('navHamburger').addEventListener('click', function() {
  var links = document.querySelector('.nav-links');
  var isOpen = links.style.display === 'flex';
  if (isOpen) {
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
  this.setAttribute('aria-expanded', isOpen ? 'false' : 'true');
  this.setAttribute('aria-label', isOpen ? 'Open menu' : 'Close menu');
});
document.addEventListener('keydown', function(e) {
  if (e.key === 'Escape') {
    var links = document.querySelector('.nav-links');
    var hamburger = document.getElementById('navHamburger');
    if (links.style.display === 'flex') {
      links.style.display = '';
      links.style.flexDirection = '';
      links.style.position = '';
      hamburger.setAttribute('aria-expanded', 'false');
      hamburger.setAttribute('aria-label', 'Open menu');
    }
  }
});

// Nav dropdowns (Services mega menu, Resources menu) — click-toggle,
// works alongside the CSS :hover reveal used on desktop pointer devices.
// Delegated from document (rather than bound per-trigger) so it's immune
// to any binding-order edge cases.
document.addEventListener('click', function(e) {
  var trigger = e.target.closest('.nav-dropdown-trigger');
  if (trigger) {
    e.preventDefault();
    var parent = trigger.closest('.nav-dropdown');
    var wasOpen = parent.classList.contains('open');
    document.querySelectorAll('.nav-dropdown.open').forEach(function(d) { d.classList.remove('open'); });
    if (!wasOpen) { parent.classList.add('open'); positionDropdownPanel(parent); }
    return;
  }
  if (!e.target.closest('.nav-dropdown')) {
    document.querySelectorAll('.nav-dropdown.open').forEach(function(d) { d.classList.remove('open'); });
  }
});

// Keep wide dropdown panels (the Services mega menu especially) from
// running off the right edge of the viewport -- the panel is anchored
// to its trigger's position, not the viewport, so CSS alone can't know
// whether it needs to shift left to stay fully visible.
function positionDropdownPanel(dropdown) {
  var panel = dropdown.querySelector('.mega-menu, .simple-menu');
  if (!panel || window.innerWidth <= 1024) return;
  panel.style.left = '0px';
  var rect = panel.getBoundingClientRect();
  var margin = 16;
  var overflowRight = rect.right - (window.innerWidth - margin);
  if (overflowRight > 0) panel.style.left = (-overflowRight) + 'px';
}
document.querySelectorAll('.nav-dropdown').forEach(function(dropdown) {
  dropdown.addEventListener('mouseenter', function() { positionDropdownPanel(dropdown); });
});
window.addEventListener('resize', function() {
  document.querySelectorAll('.nav-dropdown.open').forEach(function(d) { positionDropdownPanel(d); });
});
</script>
<?php if (!empty($page_js)): ?>
<script><?= $page_js ?></script>
<?php endif; ?>
</body>
</html>
