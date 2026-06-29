<?php
// ── SEO Override + Redirect System ──────────────────────────
// Loads DB overrides if admin/config.php exists. Silently skips
// if DB is unavailable (site works normally without it).
$_hc_logo_url    = '';
$_hc_favicon_url = '';
(function() use (&$page_title, &$page_desc, &$page_canonical, &$og_title, &$og_desc, &$_hc_logo_url, &$_hc_favicon_url) {
    $cfg = dirname(__DIR__) . '/admin/config.php';
    if (!file_exists($cfg)) return;
    try {
        require_once $cfg;
        require_once dirname(__DIR__) . '/admin/includes/db.php';
        require_once dirname(__DIR__) . '/admin/includes/functions.php';

        // 301 Redirect check
        $uri = strtok($_SERVER['REQUEST_URI'] ?? '/', '?');
        $redir = hc_one("SELECT destination_url, code FROM hc_redirects WHERE source_path = ? AND active = 1", [$uri]);
        if ($redir && !headers_sent()) {
            header('Location: ' . $redir['destination_url'], true, (int)$redir['code']);
            exit;
        }

        // SEO overrides
        if (!empty($page_canonical)) {
            // Strip domain so lookup matches what seo-page-edit.php stores
            $_seo_path = $page_canonical;
            if (preg_match('#^https?://[^/]+(/.*)$#', $page_canonical, $_m)) $_seo_path = $_m[1];
            if (empty($_seo_path)) $_seo_path = '/';
            $seo = hc_one("SELECT * FROM hc_seo_pages WHERE page_path = ?", [$_seo_path]);
            if ($seo) {
                if (!empty($seo['meta_title']))    $page_title     = $seo['meta_title'];
                if (!empty($seo['meta_desc']))     $page_desc      = $seo['meta_desc'];
                if (!empty($seo['canonical_url'])) $page_canonical = $seo['canonical_url'];
                if (!empty($seo['og_title']))      $og_title       = $seo['og_title'];
                if (!empty($seo['og_desc']))       $og_desc        = $seo['og_desc'];
            }
        }

        // Site identity
        $_hc_logo_url    = hc_setting('logo_url', '');
        $_hc_favicon_url = hc_setting('favicon_url', '');
    } catch (Exception $e) { /* silently continue */ }
})();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title ?? 'Homecare Creators — Market It. Manage It. Grow It.') ?></title>
<meta name="description" content="<?= htmlspecialchars($page_desc ?? 'Homecare Creators is the only marketing agency built exclusively for home care agencies in Florida. Website design, local SEO, and AI search optimization.') ?>">
<?php if (!empty($page_canonical)): ?><link rel="canonical" href="<?= htmlspecialchars($page_canonical) ?>"><?php endif; ?>
<?php if (!empty($og_title)): ?><meta property="og:title" content="<?= htmlspecialchars($og_title) ?>"><?php endif; ?>
<?php if (!empty($og_desc)): ?><meta property="og:description" content="<?= htmlspecialchars($og_desc) ?>"><?php endif; ?>
<?php if (!empty($page_canonical)): ?><meta property="og:url" content="<?= htmlspecialchars($page_canonical) ?>"><?php endif; ?>
<meta property="og:type" content="website">
<?php if ($_hc_favicon_url): ?><link rel="icon" href="<?= htmlspecialchars($_hc_favicon_url) ?>"><?php else: ?><link rel="icon" href="/favicon.ico"><?php endif ?>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Instrument+Serif:ital@0;1&family=Syne:wght@400;500;600;700;800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
<style>
/* ── SHARED BASE STYLES ── */
:root{--forest:#0a2e1e;--forest-md:#0f3d28;--forest-lt:#1a5c3a;--teal:#1d9e75;--teal-lt:#2ec68f;--mint:#9fe1cb;--cream:#f5f2ec;--warm:#fffdf8;--gold:#c9a84c;--gold-lt:#e8c96a;--text:#1a1a14;--muted:#6b7b6e;--border:rgba(26,92,58,0.15);--r:14px;--r-lg:24px}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:var(--warm);color:var(--text);overflow-x:hidden}
#scrollProgress{position:fixed;top:0;left:0;height:3px;width:0;background:linear-gradient(90deg,var(--teal),var(--teal-lt),var(--gold));z-index:9999;transition:width .1s linear}
@keyframes fadeUp{from{opacity:0;transform:translateY(36px)}to{opacity:1;transform:translateY(0)}}
@keyframes fadeIn{from{opacity:0}to{opacity:1}}
@keyframes float{0%,100%{transform:translateY(0)}50%{transform:translateY(-14px)}}
@keyframes floatR{0%,100%{transform:translateY(-8px)}50%{transform:translateY(8px)}}
@keyframes pulse-ring{0%{box-shadow:0 0 0 0 rgba(46,198,143,.5)}70%{box-shadow:0 0 0 12px rgba(46,198,143,0)}100%{box-shadow:0 0 0 0 rgba(46,198,143,0)}}
@keyframes spin-slow{from{transform:rotate(0deg)}to{transform:rotate(360deg)}}
@keyframes ticker{0%{transform:translateX(0)}100%{transform:translateX(-50%)}}
@keyframes shimmer{0%,100%{opacity:.7}50%{opacity:1}}
@keyframes scaleIn{from{opacity:0;transform:scale(0.92)}to{opacity:1;transform:scale(1)}}
[data-reveal]{opacity:0;transform:translateY(32px);transition:opacity .75s ease,transform .75s ease}
[data-reveal].visible{opacity:1;transform:translateY(0)}

/* NAV */
nav{position:fixed;top:0;left:0;right:0;z-index:500;height:72px;padding:0 48px;display:flex;align-items:center;justify-content:space-between;background:rgba(8,36,22,.92);backdrop-filter:blur(20px);border-bottom:1px solid rgba(46,198,143,.12);transition:all .3s}
nav.scrolled{height:62px;background:rgba(8,36,22,.97);box-shadow:0 4px 32px rgba(0,0,0,.25)}
.nav-logo{display:flex;align-items:center;text-decoration:none;flex-shrink:0}
.nav-logo svg{height:46px;width:auto}
.nav-links{display:flex;gap:4px;list-style:none;align-items:center}
.nav-links a{font-family:'Syne',sans-serif;font-size:13px;font-weight:500;color:rgba(255,255,255,.7);text-decoration:none;padding:7px 13px;border-radius:8px;transition:.2s}
.nav-links a:hover{color:#fff;background:rgba(255,255,255,.07)}
.nav-cta{background:linear-gradient(135deg,var(--teal),var(--teal-lt))!important;color:#fff!important;font-weight:700!important;padding:9px 20px!important;border-radius:9px!important;box-shadow:0 4px 16px rgba(29,158,117,.4)!important}
.nav-cta:hover{transform:translateY(-2px)!important;box-shadow:0 8px 24px rgba(29,158,117,.5)!important}
.nav-hamburger{display:none;background:none;border:none;color:#fff;font-size:22px;cursor:pointer;padding:8px}

/* BUTTONS */
.btn-primary{display:inline-flex;align-items:center;gap:9px;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;text-decoration:none;padding:15px 30px;border-radius:11px;font-family:'Syne',sans-serif;font-weight:700;font-size:14.5px;box-shadow:0 4px 24px rgba(29,158,117,.45);transition:.3s cubic-bezier(.34,1.56,.64,1);border:none;cursor:pointer}
.btn-primary:hover{transform:translateY(-3px) scale(1.02);box-shadow:0 12px 40px rgba(29,158,117,.55)}
.btn-secondary{display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.16);color:#fff;text-decoration:none;padding:15px 30px;border-radius:11px;font-family:'Syne',sans-serif;font-weight:600;font-size:14.5px;backdrop-filter:blur(8px);transition:.25s;cursor:pointer}
.btn-secondary:hover{background:rgba(255,255,255,.11);transform:translateY(-2px)}

/* SECTION COMMONS */
section{padding:96px 40px}
.container{max-width:1180px;margin:0 auto}
.section-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--teal);margin-bottom:12px;display:flex;align-items:center;gap:8px}
.section-label::before{content:'';width:24px;height:2px;background:var(--teal);border-radius:2px}
.section-h2{font-family:'Instrument Serif',serif;font-size:clamp(30px,4vw,52px);line-height:1.08;color:var(--forest);margin-bottom:16px}
.section-h2 em{font-style:italic;color:var(--teal)}
.section-sub{font-size:17px;line-height:1.75;color:var(--muted);max-width:620px}

/* TICKER */
.ticker-wrap{background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);overflow:hidden;padding:14px 0}
.ticker-inner{display:flex;width:max-content;animation:ticker 32s linear infinite}
.ticker-item{display:flex;align-items:center;gap:10px;padding:0 38px;font-family:'Syne',sans-serif;font-size:12px;font-weight:600;color:var(--muted);letter-spacing:.4px;text-transform:uppercase;white-space:nowrap}
.ticker-dot{width:5px;height:5px;border-radius:50%;background:var(--teal);flex-shrink:0}
.ticker-item i{color:var(--teal);font-size:13px}

/* POPUP / FORM */
.popup-overlay{display:none;position:fixed;inset:0;background:rgba(5,20,12,.75);backdrop-filter:blur(8px);z-index:1000;align-items:center;justify-content:center;padding:20px}
.popup-overlay.open{display:flex}
.popup-box{background:#fff;border-radius:20px;padding:40px;width:100%;max-width:580px;position:relative;max-height:90vh;overflow-y:auto;animation:fadeUp .3s ease both}
.popup-close{position:absolute;top:16px;right:16px;background:var(--cream);border:none;border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);font-size:14px;transition:.2s}
.popup-close:hover{background:var(--border);color:var(--text)}
.popup-icon{width:52px;height:52px;background:linear-gradient(135deg,var(--teal),var(--teal-lt));border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:22px;margin-bottom:18px}
.popup-title{font-family:'Instrument Serif',serif;font-size:26px;color:var(--forest);margin-bottom:8px}
.popup-sub{font-size:14px;color:var(--muted);line-height:1.65;margin-bottom:24px}
.popup-form-group{margin-bottom:10px}
.popup-form-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
.form-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--muted);display:block;margin-bottom:6px}
.form-input,.form-select,.form-textarea{width:100%;padding:11px 14px;border:1px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);background:#fff;transition:border-color .2s;outline:none}
.form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--teal)}
.form-textarea{min-height:100px;resize:vertical}
.form-submit{width:100%;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;border:none;border-radius:11px;padding:14px 24px;font-family:'Syne',sans-serif;font-weight:700;font-size:15px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;transition:.2s}
.form-submit:hover{box-shadow:0 8px 28px rgba(29,158,117,.45)}
.popup-success{text-align:center;padding:20px 0;display:none}
.popup-success i{font-size:52px;color:var(--teal);margin-bottom:16px;display:block}
.popup-success-title{font-family:'Instrument Serif',serif;font-size:26px;color:var(--forest);margin-bottom:10px}
.popup-success-sub{font-size:14px;color:var(--muted);line-height:1.65}
.form-input.error{border-color:#e53e3e;background:#fff8f8}
.captcha-row{display:flex;align-items:center;gap:12px;margin-bottom:16px}
.captcha-question{font-family:'Syne',sans-serif;font-size:14px;font-weight:700;color:var(--forest);white-space:nowrap;background:var(--cream);border-radius:8px;padding:10px 14px;flex-shrink:0}
.captcha-input{width:90px!important;text-align:center;font-size:16px!important;font-weight:700}
.consent-row{display:flex;align-items:flex-start;gap:10px;margin-bottom:16px}
.consent-row input[type=checkbox]{width:18px;height:18px;accent-color:var(--teal);flex-shrink:0;margin-top:2px;cursor:pointer}
.consent-label{font-size:12px;color:var(--muted);line-height:1.6;cursor:pointer}

/* FOOTER */
footer{background:var(--forest);padding:64px 48px 0}
.footer-inner{max-width:1180px;margin:0 auto;display:grid;grid-template-columns:2fr 1fr 1fr 1fr;gap:48px;padding-bottom:48px;border-bottom:1px solid rgba(255,255,255,.08)}
.footer-logo svg{height:48px;width:auto}
.footer-tagline{font-size:13px;color:rgba(255,255,255,.45);margin-top:14px;margin-bottom:20px;line-height:1.6;max-width:220px}
.footer-socials{display:flex;gap:10px}
.footer-social{width:34px;height:34px;border-radius:8px;background:rgba(255,255,255,.07);border:1px solid rgba(255,255,255,.1);display:flex;align-items:center;justify-content:center;color:rgba(255,255,255,.6);font-size:14px;text-decoration:none;transition:.2s}
.footer-social:hover{background:var(--teal);color:#fff;border-color:var(--teal)}
.footer-col-title{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.5px;text-transform:uppercase;color:rgba(255,255,255,.35);margin-bottom:16px}
.footer-links{list-style:none;display:flex;flex-direction:column;gap:10px}
.footer-links a{font-size:13px;color:rgba(255,255,255,.6);text-decoration:none;transition:color .2s}
.footer-links a:hover{color:#fff}
.footer-bottom{max-width:1180px;margin:0 auto;padding:20px 0;display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px}
.footer-copy{font-size:12px;color:rgba(255,255,255,.3)}
.footer-bottom-links{display:flex;gap:20px}
.footer-bottom-links a{font-size:12px;color:rgba(255,255,255,.35);text-decoration:none}
.footer-bottom-links a:hover{color:rgba(255,255,255,.7)}

/* BREADCRUMB */
.hero-breadcrumb{font-family:'Syne',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb a:hover{color:rgba(255,255,255,.7)}
.hero-breadcrumb span{color:var(--teal-lt)}

/* FAQ */
.faq-item{border:1px solid var(--border);border-radius:var(--r);overflow:hidden;background:var(--warm)}
.faq-q{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 24px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--forest)}
.faq-q-icon{width:28px;height:28px;border-radius:50%;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:12px;flex-shrink:0;transition:transform .25s,background .2s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal);color:#fff}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease}
.faq-item.open .faq-a{max-height:500px}
.faq-a-inner{padding:0 24px 20px;font-size:14px;color:var(--muted);line-height:1.8}

/* RESPONSIVE */
@media(max-width:900px){
  .footer-inner{grid-template-columns:1fr 1fr;gap:32px}
}
@media(max-width:640px){
  nav{padding:0 20px}
  .nav-links{display:none}
  .nav-hamburger{display:block}
  section{padding:64px 24px}
  .footer-inner{grid-template-columns:1fr}
}
</style>
<?php if (!empty($page_css)): ?>
<style><?= $page_css ?></style>
<?php endif; ?>
<?php
// ── Inject LD+JSON schema from DB ───────────────────────────
try {
    if (!empty($page_canonical) && function_exists('hc_all')) {
        // Normalize to path-only so seeder/admin can store relative paths regardless of canonical format
        $_schema_path = $page_canonical;
        if (preg_match('#^https?://[^/]+(/.*)$#', $page_canonical, $_m)) $_schema_path = $_m[1];
        if ($_schema_path === '') $_schema_path = '/';
        $schemas = hc_all("SELECT schema_type, schema_data FROM hc_page_schema WHERE page_path = ? AND active = 1", [$_schema_path]);
        foreach ($schemas as $s) {
            if (empty($s['schema_data'])) continue;
            $data = json_decode($s['schema_data'], true);
            if (!$data) continue;
            echo '<script type="application/ld+json">' . json_encode(array_merge(['@context'=>'https://schema.org','@type'=>$s['schema_type']], $data), JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }
        // Org schema on every page
        $org_fields = hc_all("SELECT field_key, field_value FROM hc_org_schema");
        if ($org_fields) {
            $od = []; foreach($org_fields as $f) $od[$f['field_key']]=$f['field_value'];
            $kg = array_column(hc_all("SELECT url FROM hc_kg_links") ?? [], 'url');
            $org = array_filter(['@context'=>'https://schema.org','@type'=>$od['org_type']??'LocalBusiness','name'=>$od['org_name']??'','url'=>SITE_URL,'description'=>$od['org_desc']??'','telephone'=>$od['org_phone']??'','email'=>$od['org_email']??'','sameAs'=>$kg?:null]);
            if (!empty($od['org_name'])) echo '<script type="application/ld+json">' . json_encode($org, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }
    }
} catch(Exception $e) {}
?>
</head>
<body>

<div id="scrollProgress"></div>

<!-- CONTACT POPUP -->
<div class="popup-overlay" id="mainPopup">
  <div class="popup-box">
    <button class="popup-close" id="popupCloseBtn" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    <div id="popupFormEl">
      <h2 class="popup-title" id="popupTitleEl">Book Your Free Audit</h2>
      <div class="popup-form-group" style="margin-top:20px"><input type="text" class="form-input" id="pName" placeholder="Full Name *" autocomplete="name"></div>
      <div class="popup-form-row">
        <div class="popup-form-group" style="margin-bottom:0"><input type="email" class="form-input" id="pEmail" placeholder="Email *"></div>
        <div class="popup-form-group" style="margin-bottom:0"><input type="tel" class="form-input" id="pPhone" placeholder="Phone * (555) 000-0000" maxlength="15"></div>
      </div>
      <div class="popup-form-row" style="margin-top:12px">
        <div class="popup-form-group" style="margin-bottom:0"><input type="text" class="form-input" id="pAgency" placeholder="Agency Name"></div>
        <div class="popup-form-group" style="margin-bottom:0"><input type="text" class="form-input" id="pCity" placeholder="City You Serve"></div>
      </div>
      <div class="popup-form-group" style="margin-top:12px">
        <select class="form-select" id="pService">
          <option value="">What Do You Need Most?</option>
          <option>Website Design &amp; Development</option>
          <option>Local SEO — Google Maps Rankings</option>
          <option>AI Search SEO (ChatGPT &amp; Google AI)</option>
          <option>Full Bundle Package</option>
          <option>Free Growth Audit</option>
          <option>CareOS Waitlist</option>
        </select>
      </div>
      <div class="popup-form-group"><textarea class="form-textarea" id="pMsg" placeholder="Message (optional) — tell us about your agency..." style="min-height:80px"></textarea></div>
      <!-- Math CAPTCHA -->
      <div style="margin-bottom:12px">
        <div class="captcha-row">
          <div class="captcha-question" id="captchaQuestion"></div>
          <span style="font-size:18px;color:var(--muted)">=</span>
          <input type="number" class="form-input captcha-input" id="pCaptcha" placeholder="?" min="0" max="99" autocomplete="off">
        </div>
      </div>
      <!-- Consent -->
      <div class="consent-row">
        <input type="checkbox" id="pConsent">
        <label class="consent-label" for="pConsent">I agree to be contacted by Homecare Creators about my inquiry. We respect your privacy and will never share your information.</label>
      </div>
      <button class="form-submit" id="popupSubmitBtn"><i class="fa-solid fa-paper-plane"></i><span id="popupBtnLabel">Send My Request</span></button>
      <p style="text-align:center;margin-top:14px;font-size:12px;color:var(--muted)"><i class="fa-solid fa-lock" style="margin-right:4px;color:var(--teal)"></i>100% private. No spam, ever.</p>
    </div>
    <div class="popup-success" id="popupSuccessEl">
      <i class="fa-solid fa-circle-check"></i>
      <div class="popup-success-title">You're all set!</div>
      <p class="popup-success-sub">We've received your request and will reply within 24 hours.<br>Talk soon! — The Homecare Creators Team</p>
    </div>
  </div>
</div>

<!-- NAVIGATION -->
<nav id="mainNav">
  <a href="/" class="nav-logo" aria-label="Homecare Creators Home">
    <?php if ($_hc_logo_url): ?>
    <img src="<?= htmlspecialchars($_hc_logo_url) ?>" alt="Homecare Creators" style="height:46px;width:auto;display:block">
    <?php else: ?>
    <svg height="46" viewBox="0 0 690 290" xmlns="http://www.w3.org/2000/svg">
      <line x1="42" y1="28" x2="42" y2="248" stroke="white" stroke-width="8" stroke-linecap="round"/>
      <line x1="42" y1="248" x2="270" y2="248" stroke="white" stroke-width="8" stroke-linecap="round"/>
      <line x1="270" y1="248" x2="270" y2="218" stroke="white" stroke-width="8" stroke-linecap="round"/>
      <line x1="88" y1="28" x2="360" y2="28" stroke="white" stroke-width="8" stroke-linecap="round"/>
      <line x1="360" y1="28" x2="360" y2="62" stroke="white" stroke-width="8" stroke-linecap="round"/>
      <text x="58" y="170" font-family="'Arial Rounded MT Bold','Trebuchet MS',Arial,sans-serif" font-size="130" font-weight="900" fill="white" letter-spacing="-3">Homecare</text>
      <text x="345" y="218" font-family="Arial,Helvetica,sans-serif" font-size="30" font-weight="500" fill="#2ec68f" letter-spacing="10" text-anchor="middle">CREATORS</text>
    </svg>
    <?php endif ?>
  </a>
  <ul class="nav-links">
    <li><a href="/#why">Why Us</a></li>
    <li><a href="/seo/homecare-website-design">Web Design</a></li>
    <li><a href="/seo/local-seo-for-home-care-agencies">Local SEO</a></li>
    <li><a href="/blog">Blog</a></li>
    <li><a href="/#bundles">Pricing</a></li>
    <li><a href="/#reviews">Results</a></li>
    <li><a href="#" class="nav-cta" onclick="openPopup();return false;"><i class="fa-solid fa-calendar-check" style="font-size:12px"></i> Free Audit</a></li>
  </ul>
  <button class="nav-hamburger" id="navHamburger" aria-label="Open menu"><i class="fa-solid fa-bars"></i></button>
</nav>
