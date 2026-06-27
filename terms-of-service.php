<?php
$page_title    = "Terms of Service | Homecare Creators";
$page_desc     = "Terms of Service for Homecare Creators. Read our terms and conditions for using our marketing services.";
$page_canonical = "https://homecarecreators.com/terms-of-service";
$og_title      = "Terms of Service | Homecare Creators";
$og_desc       = "Terms of Service for Homecare Creators, the only marketing agency built exclusively for homecare agencies in Florida.";

$page_css = <<<CSS
.legal-hero{background:var(--forest);padding:140px 48px 80px;text-align:center;position:relative;overflow:hidden}
.legal-hero::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px}
.legal-hero h1{font-family:'Instrument Serif',serif;font-size:clamp(36px,5vw,56px);color:#fff;position:relative;z-index:1;margin-bottom:12px}
.legal-hero p{font-size:15px;color:rgba(255,255,255,.5);position:relative;z-index:1;font-family:'Syne',sans-serif}
.legal-body{max-width:820px;margin:0 auto;padding:80px 48px}
.legal-body h2{font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:var(--forest);margin:40px 0 12px;text-transform:uppercase;letter-spacing:1px;padding-bottom:8px;border-bottom:2px solid var(--border)}
.legal-body p{font-size:15px;line-height:1.85;color:var(--muted);margin-bottom:14px}
.legal-body ul{margin:0 0 16px 20px;display:flex;flex-direction:column;gap:8px}
.legal-body ul li{font-size:15px;line-height:1.75;color:var(--muted)}
.legal-body a{color:var(--teal);text-decoration:none}
.legal-body a:hover{text-decoration:underline}
.legal-body strong{color:var(--forest)}
@media(max-width:640px){.legal-body{padding:60px 24px}.legal-hero{padding:120px 24px 60px}}
CSS;

include 'includes/header.php';
?>

<div class="legal-hero">
  <h1>Terms of Service</h1>
  <p>Effective: January 1, 2026 &nbsp;&middot;&nbsp; Last updated: June 2026</p>
</div>

<div class="legal-body">

  <h2>1. Acceptance of Terms</h2>
  <p>By accessing or using the Homecare Creators website at homecarecreators.com or any of our services, you agree to be bound by these Terms of Service ("Terms"). If you do not agree, please do not use our website or services.</p>

  <h2>2. Services</h2>
  <p>Homecare Creators provides marketing, web design, search engine optimisation (SEO), and platform services tailored for homecare agencies. Specific scopes, deliverables, timelines, and pricing are defined in individual client agreements and statements of work signed between Homecare Creators and each client.</p>

  <h2>3. Use of This Website</h2>
  <p>You agree to use this website only for lawful purposes and in a manner consistent with these Terms. You must not:</p>
  <ul>
    <li>Scrape, copy, or reproduce website content without written permission</li>
    <li>Submit false, misleading, or fraudulent information through our forms</li>
    <li>Attempt to gain unauthorised access to our systems or servers</li>
    <li>Use our website in any way that could damage, disable, or impair it</li>
  </ul>

  <h2>4. Intellectual Property</h2>
  <p>All content on this website — including text, graphics, logos, code, and design — is the property of Homecare Creators and is protected by applicable copyright and intellectual property laws. You may not reproduce, distribute, or create derivative works without our express written consent.</p>
  <p>Upon full payment for client deliverables (websites, brand assets, etc.), clients receive a licence to use those deliverables for their business. Underlying templates, frameworks, and proprietary tools remain the property of Homecare Creators.</p>

  <h2>5. Payment Terms</h2>
  <p>Specific payment schedules are outlined in individual client agreements. General terms:</p>
  <ul>
    <li>Setup fees are due before project commencement</li>
    <li>Monthly retainer payments are due on the agreed billing date</li>
    <li>Late payments may result in suspension of services after a 7-day grace period</li>
    <li>All fees are non-refundable unless otherwise stated in writing</li>
  </ul>

  <h2>6. Disclaimer of Warranties</h2>
  <p>This website and all information on it are provided "as is" without warranties of any kind, express or implied. While we strive for accuracy, we make no guarantees about the completeness or accuracy of any information. Search engine rankings and marketing results are not guaranteed and may vary based on market conditions, competition, and algorithm changes outside our control.</p>

  <h2>7. Limitation of Liability</h2>
  <p>To the maximum extent permitted by applicable law, Homecare Creators shall not be liable for any indirect, incidental, consequential, or punitive damages arising from your use of our website or services. Our total liability for any claim shall not exceed the amount paid by you for the relevant service in the three months preceding the claim.</p>

  <h2>8. Governing Law</h2>
  <p>These Terms are governed by and construed in accordance with the laws of the State of Florida, United States. Any disputes shall be subject to the exclusive jurisdiction of the courts of Florida.</p>

  <h2>9. Changes to These Terms</h2>
  <p>We reserve the right to update these Terms at any time. Changes will be posted on this page with an updated effective date. Continued use of our website after changes are posted constitutes acceptance of the revised Terms.</p>

  <h2>10. Contact</h2>
  <p>For questions about these Terms, please contact us:</p>
  <p><strong>Homecare Creators</strong><br>
  Email: <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a><br>
  Website: <a href="https://homecarecreators.com">homecarecreators.com</a></p>

</div>

<?php include 'includes/footer.php'; ?>
