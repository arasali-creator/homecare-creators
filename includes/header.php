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
<?php
try {
    if (function_exists('hc_all')) {
        $rows = hc_all("SELECT code FROM hc_tracking_codes WHERE position='head' AND active=1 ORDER BY id ASC");
        foreach ($rows as $r) echo $r['code'] . "\n";
    }
} catch(Exception $e){}
?>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($page_title ?? 'Homecare Creators — Market It. Manage It. Grow It.') ?></title>
<meta name="description" content="<?= htmlspecialchars($page_desc ?? 'Homecare Creators is a marketing agency built exclusively for home care agencies nationwide. Website design, local SEO, and AI search optimization.') ?>">
<?php if (!empty($page_canonical)): ?><link rel="canonical" href="<?= htmlspecialchars($page_canonical) ?>">
<link rel="alternate" hreflang="en-us" href="<?= htmlspecialchars($page_canonical) ?>">
<link rel="alternate" hreflang="x-default" href="<?= htmlspecialchars($page_canonical) ?>"><?php endif; ?>
<?php if (!empty($og_title)): ?><meta property="og:title" content="<?= htmlspecialchars($og_title) ?>"><?php endif; ?>
<?php if (!empty($og_desc)): ?><meta property="og:description" content="<?= htmlspecialchars($og_desc) ?>"><?php endif; ?>
<?php if (!empty($page_canonical)): ?><meta property="og:url" content="<?= htmlspecialchars($page_canonical) ?>"><?php endif; ?>
<?php if (!empty($og_image)): ?><meta property="og:image" content="<?= htmlspecialchars($og_image) ?>"><meta name="twitter:card" content="summary_large_image"><meta name="twitter:image" content="<?= htmlspecialchars($og_image) ?>"><?php endif; ?>
<meta property="og:type" content="website">
<link rel="icon" href="/favicon.ico?v=3" sizes="any">
<link rel="icon" type="image/svg+xml" href="/images/home/favicon.svg?v=3">
<link rel="apple-touch-icon" href="/images/home/favicon-180.png?v=3">
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link rel="preconnect" href="https://cdnjs.cloudflare.com" crossorigin>
<link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" onload="this.onload=null;this.rel='stylesheet'">
<link rel="preload" as="style" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" onload="this.onload=null;this.rel='stylesheet'">
<noscript>
<link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:ital,wght@0,400;0,500;0,600;0,700;0,800;1,400;1,500;1,600;1,700;1,800&family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;1,9..40,300&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</noscript>
<style>
/* ── SHARED BASE STYLES ── */
:root{--forest:#0a2e1e;--forest-md:#0f3d28;--forest-lt:#1a5c3a;--teal:#1d9e75;--teal-lt:#2ec68f;--mint:#9fe1cb;--cream:#f5f2ec;--warm:#fffdf8;--gold:#c9a84c;--gold-lt:#e8c96a;--text:#1a1a14;--muted:#6b7b6e;--border:rgba(26,92,58,0.15);--r:14px;--r-lg:24px}
*,*::before,*::after{box-sizing:border-box;margin:0;padding:0}
html{scroll-behavior:smooth}
body{font-family:'DM Sans',sans-serif;background:var(--warm);color:var(--text);overflow-x:hidden}
p{font-size:18px}
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
.sr-only{position:absolute;width:1px;height:1px;padding:0;margin:-1px;overflow:hidden;clip:rect(0,0,0,0);white-space:nowrap;border:0}
.hp-field{position:absolute;left:-9999px;top:-9999px;width:1px;height:1px;overflow:hidden}

/* NAV */
nav{position:fixed;top:0;left:0;right:0;z-index:500;height:72px;padding:0 48px;display:flex;align-items:center;justify-content:space-between;background:rgba(8,36,22,.92);backdrop-filter:blur(20px);border-bottom:1px solid rgba(46,198,143,.12);transition:all .3s}
nav.scrolled{height:62px;background:rgba(8,36,22,.97);box-shadow:0 4px 32px rgba(0,0,0,.25)}
.nav-logo{display:flex;align-items:center;text-decoration:none;flex-shrink:0}
.nav-logo svg{height:46px;width:auto}
.nav-links{display:flex;gap:4px;list-style:none;align-items:center}
.nav-links a{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:500;color:rgba(255,255,255,.7);text-decoration:none;padding:7px 13px;border-radius:8px;transition:.2s}
.nav-links a:hover{color:#fff;background:rgba(255,255,255,.07)}
.nav-cta{background:linear-gradient(135deg,var(--teal),var(--teal-lt))!important;color:#fff!important;font-weight:700!important;padding:9px 20px!important;border-radius:9px!important;box-shadow:0 4px 16px rgba(29,158,117,.4)!important}
.nav-cta:hover{transform:translateY(-2px)!important;box-shadow:0 8px 24px rgba(29,158,117,.5)!important}
.nav-hamburger{display:none;background:none;border:none;color:#fff;font-size:22px;cursor:pointer;padding:8px}

/* NAV DROPDOWNS (Services mega menu, Resources menu) */
.nav-dropdown{position:relative}
.nav-dropdown-trigger{display:flex!important;align-items:center;gap:6px}
.nav-dropdown-trigger i{font-size:9px;transition:transform .2s}
.nav-dropdown.open .nav-dropdown-trigger i{transform:rotate(180deg)}
/* top:100% with zero gap — a gap here is the classic cause of a mega menu
   closing when the cursor moves from the trigger down into the panel */
.mega-menu,.simple-menu{display:none;position:absolute;top:100%;margin-top:14px;background:#fff;border:1px solid var(--border);border-radius:14px;box-shadow:0 10px 28px rgba(10,46,30,.1);z-index:10;overflow:hidden}
.nav-dropdown:hover .mega-menu,.nav-dropdown.open .mega-menu{display:flex}
.nav-dropdown:hover .simple-menu,.nav-dropdown.open .simple-menu{display:flex}
/* invisible bridge over the margin-top gap so hover never breaks */
.nav-dropdown::after{content:'';position:absolute;top:100%;left:0;right:0;height:14px}

.mega-menu{left:0;width:1020px;max-width:calc(100vw - 96px);padding:0}
.mega-menu-links{display:flex;align-items:flex-start;padding:32px 36px;flex-shrink:0}

/* Primary column — rich rows with icon + title + one-line description */
.mega-primary{display:flex;flex-direction:column;gap:4px;width:290px;flex-shrink:0}
.mega-primary a{display:flex;align-items:flex-start;gap:14px;text-decoration:none;padding:10px 4px}
.mega-primary a .mega-icon{width:44px;height:44px;border-radius:12px;background:rgba(29,158,117,.1);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0;transition:background .15s,color .15s}
.mega-primary a:hover .mega-icon{background:var(--teal);color:#fff}
.mega-primary a .mega-item-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px;font-weight:700;color:var(--forest);margin-bottom:3px;transition:color .15s}
.mega-primary a:hover .mega-item-title{color:var(--teal)}
.mega-primary a .mega-item-desc{font-size:12.5px;color:var(--muted);line-height:1.5}

/* Divider between primary rich column and the quick-link columns */
.mega-divider{width:1px;align-self:stretch;background:var(--border);margin:0 28px;flex-shrink:0}

/* Quick-link columns — plain, uncluttered */
.mega-quick-cols{display:flex;gap:28px;width:348px;flex-shrink:0}
.mega-col{display:flex;flex-direction:column;gap:2px;width:160px;flex-shrink:0}
.mega-col-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--teal);margin-bottom:12px}
.mega-col a{font-size:13.5px;font-weight:500;color:var(--text);text-decoration:none;padding:8px 0 8px 12px;border-left:2px solid transparent;transition:border-color .15s,color .15s}
.mega-col a:hover{border-left-color:var(--teal);color:var(--teal)}
.mega-col a.view-all{color:var(--teal);font-weight:700;margin-top:6px}

/* Featured side panel */
.mega-featured{flex:1;min-width:260px;background:var(--forest);padding:28px;display:flex;flex-direction:column}
.mega-featured img{width:100%;aspect-ratio:16/10;object-fit:cover;border-radius:14px;margin-bottom:18px}
.mega-featured-label{display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--teal-lt);margin-bottom:10px}
.mega-featured h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:16.5px;font-weight:700;color:#fff;margin-bottom:9px;line-height:1.3}
.mega-featured p{font-size:13px;color:rgba(255,255,255,.55);line-height:1.65;margin-bottom:18px;flex:1}
.mega-featured .featured-cta{display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--teal-lt);text-decoration:none}

/* Resources dropdown — same rich-row treatment, single column */
.simple-menu{left:0;flex-direction:column;padding:14px;gap:2px;width:300px}
.simple-menu a{display:flex;align-items:flex-start;gap:14px;text-decoration:none;padding:9px 8px}
.simple-menu a .mega-icon{width:38px;height:38px;border-radius:10px;background:rgba(29,158,117,.1);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:15px;flex-shrink:0;margin-top:1px;transition:background .15s,color .15s}
.simple-menu a:hover .mega-icon{background:var(--teal);color:#fff}
.simple-menu a .mega-item-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest);margin-bottom:2px;transition:color .15s}
.simple-menu a:hover .mega-item-title{color:var(--teal)}
.simple-menu a .mega-item-desc{font-size:12px;color:var(--muted);line-height:1.5}

/* BUTTONS */
.btn-primary{display:inline-flex;align-items:center;gap:9px;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;text-decoration:none;padding:15px 30px;border-radius:11px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;box-shadow:0 4px 24px rgba(29,158,117,.45);transition:.3s cubic-bezier(.34,1.56,.64,1);border:none;cursor:pointer}
.btn-primary:hover{transform:translateY(-3px) scale(1.02);box-shadow:0 12px 40px rgba(29,158,117,.55)}
.btn-secondary{display:inline-flex;align-items:center;gap:9px;background:rgba(255,255,255,.06);border:1px solid rgba(255,255,255,.16);color:#fff;text-decoration:none;padding:15px 30px;border-radius:11px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:14.5px;backdrop-filter:blur(8px);transition:.25s;cursor:pointer}
.btn-secondary:hover{background:rgba(255,255,255,.11);transform:translateY(-2px)}

/* SECTION COMMONS */
section{padding:96px 40px}
.container{max-width:1180px;margin:0 auto}
.section-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:var(--teal);margin-bottom:12px;display:flex;align-items:center;gap:8px}
.section-label::before{content:'';width:24px;height:2px;background:var(--teal);border-radius:2px}
.section-h2{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(30px,4vw,52px);line-height:1.08;color:var(--forest);margin-bottom:16px}
.section-h2 em{font-style:italic;color:var(--teal)}
.section-sub{font-size:19px;line-height:1.75;color:var(--muted);max-width:620px}

/* TICKER */
.ticker-wrap{background:#fff;border-top:1px solid var(--border);border-bottom:1px solid var(--border);overflow:hidden;padding:14px 0}
.ticker-inner{display:flex;width:max-content;animation:ticker 32s linear infinite}
.ticker-item{display:flex;align-items:center;gap:10px;padding:0 38px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:var(--muted);letter-spacing:.4px;text-transform:uppercase;white-space:nowrap}
.ticker-dot{width:5px;height:5px;border-radius:50%;background:var(--teal);flex-shrink:0}
.ticker-item i{color:var(--teal);font-size:13px}

/* POPUP / FORM */
.popup-overlay{display:none;position:fixed;inset:0;background:rgba(5,20,12,.75);backdrop-filter:blur(8px);z-index:1000;align-items:center;justify-content:center;padding:20px}
.popup-overlay.open{display:flex}
.popup-box{background:#fff;border-radius:20px;padding:40px;width:100%;max-width:580px;position:relative;max-height:90vh;overflow-y:auto;animation:fadeUp .3s ease both}
.popup-close{position:absolute;top:16px;right:16px;background:var(--cream);border:none;border-radius:50%;width:32px;height:32px;display:flex;align-items:center;justify-content:center;cursor:pointer;color:var(--muted);font-size:14px;transition:.2s}
.popup-close:hover{background:var(--border);color:var(--text)}
.popup-icon{width:52px;height:52px;background:linear-gradient(135deg,var(--teal),var(--teal-lt));border-radius:14px;display:flex;align-items:center;justify-content:center;color:#fff;font-size:22px;margin-bottom:18px}
.popup-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;color:var(--forest);margin-bottom:8px}
.popup-sub{font-size:16px;color:var(--muted);line-height:1.65;margin-bottom:24px}
.popup-form-group{margin-bottom:10px}
.popup-form-row{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-bottom:10px}
.form-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--muted);display:block;margin-bottom:6px}
.form-input,.form-select,.form-textarea{width:100%;padding:11px 14px;border:1px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);background:#fff;transition:border-color .2s;outline:none}
.form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--teal)}
.form-textarea{min-height:100px;resize:vertical}
.form-submit{width:100%;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;border:none;border-radius:11px;padding:14px 24px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;cursor:pointer;display:flex;align-items:center;justify-content:center;gap:9px;transition:.2s}
.form-submit:hover{box-shadow:0 8px 28px rgba(29,158,117,.45)}
.popup-success{text-align:center;padding:20px 0;display:none}
.popup-success i{font-size:52px;color:var(--teal);margin-bottom:16px;display:block}
.popup-success-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;color:var(--forest);margin-bottom:10px}
.popup-success-sub{font-size:16px;color:var(--muted);line-height:1.65}
.form-input.error{border-color:#e53e3e;background:#fff8f8}
.captcha-row{display:flex;align-items:center;gap:12px;margin-bottom:16px}
.captcha-question{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest);white-space:nowrap;background:var(--cream);border-radius:8px;padding:10px 14px;flex-shrink:0}
.captcha-input{width:90px!important;text-align:center;font-size:16px!important;font-weight:700}
.consent-row{display:flex;align-items:flex-start;gap:10px;margin-bottom:16px}
.consent-row input[type=checkbox]{width:18px;height:18px;accent-color:var(--teal);flex-shrink:0;margin-top:2px;cursor:pointer}
.consent-label{font-size:12px;color:var(--muted);line-height:1.6;cursor:pointer}

/* FOOTER — light rounded card floating on a dark surround */
footer{background:var(--forest);padding:28px}
.footer-card{max-width:1400px;margin:0 auto;background:var(--cream);border-radius:40px;padding:64px 64px 0;overflow:hidden}
.footer-top{display:grid;grid-template-columns:400px 1fr;gap:64px;padding-bottom:48px}

.footer-brand-row{display:flex;align-items:center;justify-content:space-between;gap:16px;margin-bottom:36px}
.footer-logo img{display:block}
.footer-socials{display:flex;gap:8px}
.footer-social{width:34px;height:34px;border-radius:50%;background:transparent;border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--forest);font-size:13px;text-decoration:none;transition:.18s}
.footer-social:hover{background:var(--forest);color:#fff;border-color:var(--forest)}
.footer-heading{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(24px,2.4vw,32px);line-height:1.2;color:var(--forest);margin-bottom:28px;max-width:420px}
.footer-heading em{font-style:italic;color:var(--teal)}
.footer-subscribe{display:flex;align-items:center;background:#fff;border:1px solid var(--border);border-radius:100px;padding:6px 6px 6px 22px;max-width:380px}
.footer-subscribe input{flex:1;min-width:0;border:none;background:none;font-size:14px;color:var(--forest);outline:none;font-family:'DM Sans',sans-serif}
.footer-subscribe input::placeholder{color:var(--muted)}
.footer-subscribe button{width:40px;height:40px;border-radius:50%;background:var(--forest);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0;transition:.2s}
.footer-subscribe button:hover{background:var(--teal)}

.footer-groups{display:grid;grid-template-columns:repeat(3,1fr);gap:24px}
.footer-group-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--muted);margin-bottom:18px}
.footer-links{list-style:none;display:flex;flex-direction:column;gap:12px}
.footer-links a{font-size:14px;color:var(--forest);text-decoration:none;transition:opacity .15s}
.footer-links a:hover{opacity:.6}
.footer-contact-pills{display:flex;flex-direction:column;gap:10px}
.footer-pill{display:inline-flex;align-items:center;gap:9px;background:#fff;border:1px solid var(--border);border-radius:100px;padding:10px 16px;font-size:12.5px;color:var(--forest);text-decoration:none;width:fit-content;max-width:100%;transition:.18s}
.footer-pill:hover{border-color:var(--teal);color:var(--teal)}
.footer-pill i{font-size:12px;color:var(--teal);flex-shrink:0}

.footer-bottom{display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:10px;padding:26px 0;border-top:1px solid var(--border)}
.footer-copy{font-size:12px;color:var(--muted)}
.footer-bottom-links{display:flex;align-items:center;gap:20px}
.footer-bottom-links a{font-size:12px;color:var(--muted);text-decoration:none;transition:color .15s}
.footer-bottom-links a:hover{color:var(--forest)}
.footer-top-btn{width:32px;height:32px;border-radius:50%;background:transparent;border:1px solid var(--border);color:var(--forest);display:flex;align-items:center;justify-content:center;text-decoration:none;font-size:12px;transition:.18s;flex-shrink:0}
.footer-top-btn:hover{background:var(--forest);color:#fff;border-color:var(--forest)}

/* CERTIFICATIONS / TRUST BADGES */
.certs{background:#fff;padding:52px 40px;border-bottom:1px solid var(--border)}
.certs-label{text-align:center;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--muted);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:28px}
.certs-row{display:flex;justify-content:center;align-items:center;gap:48px;flex-wrap:wrap}
.cert-item{display:flex;flex-direction:column;align-items:center;gap:10px;opacity:.85;transition:.3s}
.cert-item:hover{opacity:1;transform:translateY(-3px)}
.cert-item img{height:56px;width:auto;max-width:120px;object-fit:contain;filter:grayscale(15%)}
.cert-item span{font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:600;color:var(--muted);text-align:center}
@media(max-width:640px){
  .certs{padding:36px 20px}
  .certs-row{gap:28px}
  .cert-item img{height:42px}
}

/* BREADCRUMB */
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb a:hover{color:rgba(255,255,255,.7)}
.hero-breadcrumb span{color:var(--teal-lt)}

/* FAQ */
.faq-item{border:1px solid var(--border);border-radius:var(--r);overflow:hidden;background:var(--warm)}
.faq-q{display:flex;align-items:center;justify-content:space-between;gap:16px;padding:20px 24px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest)}
.faq-q-icon{width:28px;height:28px;border-radius:50%;background:rgba(29,158,117,.1);display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:12px;flex-shrink:0;transition:transform .25s,background .2s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal);color:#fff}
.faq-a{max-height:0;overflow:hidden;transition:max-height .35s ease}
.faq-item.open .faq-a{max-height:500px}
.faq-a-inner{padding:0 24px 20px;font-size:16px;color:var(--muted);line-height:1.8}

/* RESPONSIVE */
@media(max-width:1024px){
  .footer-top{grid-template-columns:1fr;gap:40px}
  .footer-groups{grid-template-columns:1fr 1fr}
}
@media(max-width:900px){
  .footer-card{padding:48px 36px 0;border-radius:28px}
}
@media(max-width:640px){
  nav{padding:0 20px}
  .nav-links{display:none}
.nav-links a{display:block;padding:14px 16px;font-size:15px}
  .nav-hamburger{display:block;min-width:44px;min-height:44px}
  section{padding:64px 24px}
  footer{padding:14px}
  .footer-card{padding:36px 22px 0;border-radius:22px}
  .footer-subscribe{max-width:none}
  .footer-groups{grid-template-columns:1fr;gap:32px}

  /* Dropdowns become inline accordions inside the mobile menu */
  .nav-dropdown:hover .mega-menu,.nav-dropdown:hover .simple-menu{display:none}
  .mega-menu,.simple-menu{position:static;transform:none;width:auto;max-width:none;min-width:0;box-shadow:none;border:none;background:rgba(255,255,255,.04);margin-top:4px;border-radius:8px}
  .mega-menu-links{flex-direction:column;gap:18px;padding:12px;width:auto}
  .mega-primary{width:auto}
  .mega-divider{display:none}
  .mega-quick-cols{flex-direction:column;gap:18px;width:auto}
  .mega-col{width:auto}
  .mega-featured{display:none}
  .simple-menu{padding:8px;width:auto}
  .mega-col-title{margin-bottom:6px;color:var(--teal-lt)}
  .mega-col a,.simple-menu a,.mega-primary a{color:rgba(255,255,255,.85)}
  .mega-primary a .mega-item-title,.simple-menu a .mega-item-title{color:#fff}
  .mega-primary a .mega-item-desc,.simple-menu a .mega-item-desc{color:rgba(255,255,255,.5)}
  .mega-primary a .mega-icon,.simple-menu a .mega-icon{background:rgba(255,255,255,.1);color:var(--teal-lt)}
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
            $org = hc_build_org_schema($od, $kg);
            if (!empty($od['org_name'])) echo '<script type="application/ld+json">' . json_encode($org, JSON_UNESCAPED_SLASHES) . '</script>' . "\n";
        }
    }
} catch(Exception $e) {}
?>
</head>
<body>
<?php
try {
    if (function_exists('hc_all')) {
        $rows = hc_all("SELECT code FROM hc_tracking_codes WHERE position='body' AND active=1 ORDER BY id ASC");
        foreach ($rows as $r) echo $r['code'] . "\n";
    }
} catch(Exception $e){}
?>

<div id="scrollProgress"></div>

<!-- CONTACT POPUP -->
<div class="popup-overlay" id="mainPopup">
  <div class="popup-box">
    <button class="popup-close" id="popupCloseBtn" aria-label="Close"><i class="fa-solid fa-xmark"></i></button>
    <div id="popupFormEl">
      <h2 class="popup-title" id="popupTitleEl">Book Your Free Audit</h2>
      <div class="hp-field" aria-hidden="true"><label for="pWebsite">Website</label><input type="text" id="pWebsite" name="pWebsite" tabindex="-1" autocomplete="off"></div>
      <div class="popup-form-group" style="margin-top:20px"><label class="sr-only" for="pName">Full Name</label><input type="text" class="form-input" id="pName" placeholder="Full Name *" autocomplete="name"></div>
      <div class="popup-form-row">
        <div class="popup-form-group" style="margin-bottom:0"><label class="sr-only" for="pEmail">Email</label><input type="email" class="form-input" id="pEmail" placeholder="Email *" autocomplete="email"></div>
        <div class="popup-form-group" style="margin-bottom:0"><label class="sr-only" for="pPhone">Phone</label><input type="tel" class="form-input" id="pPhone" placeholder="Phone *" maxlength="15" autocomplete="tel"></div>
      </div>
      <div class="popup-form-row" style="margin-top:12px">
        <div class="popup-form-group" style="margin-bottom:0"><label class="sr-only" for="pAgency">Agency Name</label><input type="text" class="form-input" id="pAgency" placeholder="Agency Name" autocomplete="organization"></div>
        <div class="popup-form-group" style="margin-bottom:0"><label class="sr-only" for="pCity">City You Serve</label><input type="text" class="form-input" id="pCity" placeholder="City You Serve"></div>
      </div>
      <div class="popup-form-group" style="margin-top:12px">
        <label class="sr-only" for="pService">What Do You Need Most?</label>
        <select class="form-select" id="pService">
          <option value="">What Do You Need Most?</option>
          <option>Website Design &amp; Development</option>
          <option>Local SEO — Google Maps Rankings</option>
          <option>AI Search SEO (ChatGPT &amp; Google AI)</option>
          <option>Full Bundle Package</option>
          <option>Free Growth Audit</option>
          <option>CareOS Demo</option>
          <option>CareMails Demo</option>
          <option>Care Scheduling Demo</option>
        </select>
      </div>
      <div class="popup-form-group"><label class="sr-only" for="pMsg">Message</label><textarea class="form-textarea" id="pMsg" placeholder="Message (optional) — tell us about your agency..." style="min-height:80px"></textarea></div>
      <!-- Math CAPTCHA -->
      <div style="margin-bottom:12px">
        <div class="captcha-row">
          <div class="captcha-question" id="captchaQuestion"></div>
          <span style="font-size:18px;color:var(--muted)">=</span>
          <label class="sr-only" for="pCaptcha">Answer</label>
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
    <img src="<?= htmlspecialchars($_hc_logo_url) ?>" alt="Homecare Creators — Home Care Agency Marketing Company" title="Homecare Creators" style="height:46px;width:auto;display:block;border-radius:12px">
    <?php else: ?>
    <img src="/images/home/homecarecreators-logo.png" alt="Homecare Creators — Home Care Agency Marketing Company" title="Homecare Creators" width="160" height="46" style="height:46px;width:auto;display:block;border-radius:12px">
    <?php endif ?>
  </a>
  <ul class="nav-links">
    <li><a href="/about/">About Us</a></li>
    <li class="nav-dropdown">
      <a href="#" class="nav-dropdown-trigger">Services <i class="fa-solid fa-chevron-down"></i></a>
      <div class="mega-menu">
        <div class="mega-menu-links">
          <div class="mega-primary">
            <div class="mega-col-title">Marketing Services</div>
            <a href="/seo/home-care-seo/">
              <div class="mega-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
              <div><div class="mega-item-title">Home Care SEO</div><div class="mega-item-desc">Rank higher on Google Maps and local search.</div></div>
            </a>
            <a href="/web-design/homecare-website-design/">
              <div class="mega-icon"><i class="fa-solid fa-laptop-code"></i></div>
              <div><div class="mega-item-title">Website Design</div><div class="mega-item-desc">Conversion-focused sites that turn visitors into inquiries.</div></div>
            </a>
            <a href="/ai-search-seo/">
              <div class="mega-icon"><i class="fa-solid fa-brain"></i></div>
              <div><div class="mega-item-title">AI Search SEO (GEO)</div><div class="mega-item-desc">Get found in ChatGPT, Google AI, and beyond.</div></div>
            </a>
            <a href="/ai-automation/">
              <div class="mega-icon"><i class="fa-solid fa-gears"></i></div>
              <div><div class="mega-item-title">AI &amp; Automation</div><div class="mega-item-desc">AI chat, automated follow-ups, and scheduling.</div></div>
            </a>
          </div>
          <div class="mega-divider"></div>
          <div class="mega-quick-cols">
            <div class="mega-col" style="width:100%">
              <div class="mega-col-title">Senior Care Marketing</div>
              <a href="/memory-care-marketing/">Memory Care</a>
              <a href="/hospice-marketing/">Hospice</a>
              <a href="/nursing-home-marketing/">Nursing Homes</a>
              <a href="/senior-living-marketing/">Senior Living</a>
              <a href="/assisted-living-marketing/">Assisted Living</a>
            </div>
          </div>
        </div>
        <div class="mega-featured">
          <img src="/images/home/results-growth.jpg" alt="Website Growth Calculator">
          <div class="mega-featured-label"><i class="fa-solid fa-bolt"></i>Free Tool</div>
          <h4>Website Growth Calculator</h4>
          <p>See how many more clients your agency's website could be missing — free, 60-second estimate.</p>
          <a href="/growth-calculator/" class="featured-cta">Try It Free &rarr;</a>
        </div>
      </div>
    </li>
    <li><a href="/case-studies/">Case Studies</a></li>
    <li class="nav-dropdown">
      <a href="#" class="nav-dropdown-trigger">Resources <i class="fa-solid fa-chevron-down"></i></a>
      <div class="simple-menu">
        <a href="/products/">
          <div class="mega-icon"><i class="fa-solid fa-layer-group"></i></div>
          <div><div class="mega-item-title">Products</div><div class="mega-item-desc">CareOS, CareMails &amp; Care Scheduling</div></div>
        </a>
        <a href="/#bundles">
          <div class="mega-icon"><i class="fa-solid fa-tags"></i></div>
          <div><div class="mega-item-title">Pricing</div><div class="mega-item-desc">Packages and bundles for every agency size</div></div>
        </a>
        <a href="/blog">
          <div class="mega-icon"><i class="fa-solid fa-newspaper"></i></div>
          <div><div class="mega-item-title">Blog</div><div class="mega-item-desc">SEO and growth tips for home care agencies</div></div>
        </a>
        <a href="/events/">
          <div class="mega-icon"><i class="fa-solid fa-calendar-days"></i></div>
          <div><div class="mega-item-title">Events</div><div class="mega-item-desc">Free live masterclasses and webinars</div></div>
        </a>
        <a href="/directory/">
          <div class="mega-icon"><i class="fa-solid fa-building-shield"></i></div>
          <div><div class="mega-item-title">Directory</div><div class="mega-item-desc">Browse licensed home care agencies</div></div>
        </a>
      </div>
    </li>
    <li><a href="/contact/">Contact Us</a></li>
    <li><a href="#" class="nav-cta" onclick="openPopup();return false;"><i class="fa-solid fa-calendar-check" style="font-size:12px"></i> Free Audit</a></li>
  </ul>
  <button class="nav-hamburger" id="navHamburger" aria-label="Open menu" aria-expanded="false"><i class="fa-solid fa-bars"></i></button>
</nav>
