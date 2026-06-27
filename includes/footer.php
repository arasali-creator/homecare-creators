<!-- FOOTER -->
<footer>
  <div class="footer-inner">
    <div>
      <div class="footer-logo">
        <svg height="48" viewBox="0 0 690 290" xmlns="http://www.w3.org/2000/svg">
          <line x1="42" y1="28" x2="42" y2="248" stroke="white" stroke-width="8" stroke-linecap="round"/>
          <line x1="42" y1="248" x2="270" y2="248" stroke="white" stroke-width="8" stroke-linecap="round"/>
          <line x1="270" y1="248" x2="270" y2="218" stroke="white" stroke-width="8" stroke-linecap="round"/>
          <line x1="88" y1="28" x2="360" y2="28" stroke="white" stroke-width="8" stroke-linecap="round"/>
          <line x1="360" y1="28" x2="360" y2="62" stroke="white" stroke-width="8" stroke-linecap="round"/>
          <text x="58" y="170" font-family="'Arial Rounded MT Bold','Trebuchet MS',Arial,sans-serif" font-size="130" font-weight="900" fill="white" letter-spacing="-3">Homecare</text>
          <text x="345" y="218" font-family="Arial,Helvetica,sans-serif" font-size="30" font-weight="500" fill="#2ec68f" letter-spacing="10" text-anchor="middle">CREATORS</text>
        </svg>
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
      </ul>
    </div>
    <div>
      <div class="footer-col-title">Florida Cities</div>
      <ul class="footer-links">
        <li><a href="/Marketing/home-care-miami-fl">Miami</a></li>
        <li><a href="/Marketing/home-care-orlando-fl">Orlando</a></li>
        <li><a href="/Marketing/home-care-sarasota-fl">Sarasota</a></li>
        <li><a href="/Marketing/home-care-jacksonville-fl">Jacksonville</a></li>
        <li><a href="/Marketing/home-care-fort-lauderdale-fl">Fort Lauderdale</a></li>
        <li><a href="/Marketing/home-care-naples-fl">Naples</a></li>
        <li><a href="/Marketing/home-care-west-palm-beach-fl">West Palm Beach</a></li>
        <li><a href="/Marketing/home-care-boca-raton-fl">Boca Raton</a></li>
        <li><a href="/Marketing/home-care-clearwater-fl">Clearwater</a></li>
        <li><a href="/Marketing/home-care-tampa-fl">Tampa</a></li>
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

// Popup open / close
function openPopup() {
  document.getElementById('mainPopup').classList.add('open');
  document.body.style.overflow = 'hidden';
}
function closePopup() {
  document.getElementById('mainPopup').classList.remove('open');
  document.body.style.overflow = '';
}
document.getElementById('mainPopup').addEventListener('click', function(e) { if (e.target === this) closePopup(); });
document.getElementById('popupCloseBtn').addEventListener('click', closePopup);
document.addEventListener('keydown', function(e) { if (e.key === 'Escape') closePopup(); });

// Popup form submit — sends to PHP handler which emails info@homecarecreators.com
document.getElementById('popupSubmitBtn').addEventListener('click', function() {
  var name  = (document.getElementById('pName').value  || '').trim();
  var email = (document.getElementById('pEmail').value || '').trim();
  if (!name)  { alert('Please enter your full name.'); return; }
  if (!email || !email.includes('@')) { alert('Please enter a valid email address.'); return; }
  var btnLabel = document.getElementById('popupBtnLabel');
  btnLabel.textContent = 'Sending...';
  this.disabled = true;
  fetch('/form-handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      name:    name,
      email:   email,
      phone:   document.getElementById('pPhone').value,
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
