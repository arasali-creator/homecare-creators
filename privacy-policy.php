<?php
$page_title    = "Privacy Policy | Homecare Creators";
$page_desc     = "Privacy Policy for Homecare Creators — learn how we collect, use, and protect your information.";
$page_canonical = "https://homecarecreators.com/privacy-policy";
$og_title      = "Privacy Policy | Homecare Creators";
$og_desc       = "Privacy Policy for Homecare Creators, the only marketing agency built exclusively for homecare agencies in Florida.";

$page_css = <<<CSS
.legal-hero{background:var(--forest);padding:140px 48px 80px;text-align:center;position:relative;overflow:hidden}
.legal-hero::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px}
.legal-hero h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(36px,5vw,56px);color:#fff;position:relative;z-index:1;margin-bottom:12px}
.legal-hero p{font-size:17px;color:rgba(255,255,255,.5);position:relative;z-index:1;font-family:'Plus Jakarta Sans',sans-serif}
.legal-body{max-width:820px;margin:0 auto;padding:80px 48px}
.legal-body h2{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest);margin:40px 0 12px;text-transform:uppercase;letter-spacing:1px;padding-bottom:8px;border-bottom:2px solid var(--border)}
.legal-body p{font-size:17px;line-height:1.85;color:var(--muted);margin-bottom:14px}
.legal-body ul{margin:0 0 16px 20px;display:flex;flex-direction:column;gap:8px}
.legal-body ul li{font-size:17px;line-height:1.75;color:var(--muted)}
.legal-body a{color:var(--teal);text-decoration:none}
.legal-body a:hover{text-decoration:underline}
.legal-body strong{color:var(--forest)}
@media(max-width:640px){.legal-body{padding:60px 24px}.legal-hero{padding:120px 24px 60px}}
CSS;

include 'includes/header.php';
?>

<div class="legal-hero">
  <h1>Privacy Policy</h1>
  <p>Effective: January 1, 2026 &nbsp;&middot;&nbsp; Last updated: June 2026</p>
</div>

<div class="legal-body">

  <h2>1. Who We Are</h2>
  <p>Homecare Creators ("we," "us," or "our") is a marketing agency serving homecare businesses exclusively. We operate at <a href="https://homecarecreators.com">homecarecreators.com</a> and can be reached at <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a>.</p>

  <h2>2. Information We Collect</h2>
  <p>We collect information you provide directly through our contact forms and inquiry submissions, including:</p>
  <ul>
    <li>Full name and email address</li>
    <li>Phone number (optional)</li>
    <li>Agency name and city served</li>
    <li>Service interest and any message you include</li>
  </ul>
  <p>We do not collect payment information directly on this website. We do not run analytics tracking scripts.</p>

  <h2>3. How We Use Your Information</h2>
  <ul>
    <li>To respond to your inquiry or service request</li>
    <li>To send information about services you requested</li>
    <li>To deliver onboarding and client communications if you become a client</li>
    <li>To send occasional marketing updates — you may opt out at any time by replying to any email</li>
  </ul>
  <p>We do not sell, rent, or trade your personal information to third parties.</p>

  <h2>4. Third-Party Services</h2>
  <p>Our website loads resources from the following third-party services, which may process your IP address or set cookies under their own privacy policies:</p>
  <ul>
    <li><strong>Google Fonts</strong> — typography rendering</li>
    <li><strong>Font Awesome (cdnjs.cloudflare.com)</strong> — icon rendering</li>
    <li><strong>Unsplash</strong> — stock photography served via their CDN</li>
  </ul>

  <h2>5. Data Retention</h2>
  <p>Inquiry data submitted through our forms is retained for as long as necessary to respond to your inquiry and for a reasonable record-keeping period thereafter. You may request deletion at any time by contacting us.</p>

  <h2>6. Your Rights</h2>
  <p>You have the right to request access to, correction of, or deletion of any personal data we hold about you. Contact us at <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a> — we will respond within 30 days.</p>

  <h2>7. Security</h2>
  <p>Our website uses HTTPS encryption for all data in transit. We take reasonable technical and organisational measures to protect your information from unauthorised access or misuse.</p>

  <h2>8. Children's Privacy</h2>
  <p>Our website is intended for business owners and professionals. We do not knowingly collect personal information from children under the age of 13.</p>

  <h2>9. Changes to This Policy</h2>
  <p>We may update this Privacy Policy from time to time. Changes will be posted on this page with an updated effective date. Continued use of our website after changes constitutes acceptance of the revised policy.</p>

  <h2>10. Contact</h2>
  <p><strong>Homecare Creators</strong><br>
  Email: <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a><br>
  Website: <a href="https://homecarecreators.com">homecarecreators.com</a></p>

</div>

<?php include 'includes/footer.php'; ?>
