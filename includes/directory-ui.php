<?php
/**
 * Directory UI partials shared by /directory/, /directory/{slug}, /directory/submit/ and /directory-confirm.php.
 * Requires admin/includes/directory.php.
 *
 * Design language: matches the site footer — forest "frame" with large cream rounded panels,
 * italic teal accents in headlines, pill inputs/buttons and round arrow buttons.
 *
 * NOTE: never use <nav> inside directory markup — the site's global `nav{position:fixed}` rule hijacks it.
 */

function hc_dir_base_css(): string {
    return <<<CSS
/* ── Directory design system ─────────────────────────────── */
body{background:var(--forest)}
.dx{--ink:#0a2e1e;--txt:#2b342f;--mut:#6b7b6e;--hair:rgba(10,46,30,.1);--hair-2:rgba(10,46,30,.06);--paper:#fff;--panel:var(--cream);--gold-ink:#7a5c12;--gold-bg:#f6ecd0;font-family:'DM Sans',sans-serif;color:var(--txt);-webkit-font-smoothing:antialiased}
.dx a{color:inherit;text-decoration:none}
.dx h1,.dx h2,.dx h3,.dx h4{font-family:'Plus Jakarta Sans',sans-serif;color:var(--ink);letter-spacing:-.02em}
.dx em{font-style:italic;color:var(--teal)}

/* frame + panels (same recipe as the footer) */
.dx-frame{background:var(--forest);padding:0 28px 28px}
.dx-frame.is-first{padding-top:96px}
.dx-panel{max-width:1400px;margin:0 auto;background:var(--panel);border-radius:40px;padding:72px 64px;position:relative;overflow:hidden}
.dx-panel+.dx-panel{margin-top:28px}
.dx-in{max-width:1200px;margin:0 auto;position:relative}

/* type */
.dx-h1{font-size:clamp(40px,5.6vw,80px);font-weight:800;line-height:1;letter-spacing:-.045em}
.dx-h1 em{font-weight:700;letter-spacing:-.04em}
.dx-h2{font-size:clamp(30px,3.4vw,48px);font-weight:800;line-height:1.05;letter-spacing:-.035em}
.dx-h2 em{font-weight:700}
.dx-lead{font-size:18px;line-height:1.65;color:var(--mut)}
.dx-label{display:inline-flex;align-items:center;gap:10px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:var(--ink);border:1px solid var(--hair);border-radius:100px;padding:7px 15px 7px 12px;background:rgba(255,255,255,.5)}
.dx-label::before{content:"";width:7px;height:7px;border-radius:50%;background:var(--teal);box-shadow:0 0 0 4px rgba(29,158,117,.15)}
.dx-kick{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:var(--mut)}

/* crumbs */
.dx-crumbs{display:flex;flex-wrap:wrap;align-items:center;gap:8px;font-size:13px;color:var(--mut);margin-bottom:28px}
.dx-crumbs a{color:var(--ink);font-weight:500}
.dx-crumbs a:hover{color:var(--teal)}
.dx-crumbs i{font-size:8px;opacity:.5}

/* pills & buttons */
.dx-btn{display:inline-flex;align-items:center;justify-content:center;gap:9px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;line-height:1;padding:14px 22px;border-radius:100px;border:1px solid var(--hair);background:#fff;color:var(--ink)!important;cursor:pointer;transition:background .18s,border-color .18s,color .18s;white-space:nowrap}
.dx-btn:hover{border-color:var(--ink)}
.dx-btn.is-dark{background:var(--ink);border-color:var(--ink);color:#fff!important}
.dx-btn.is-dark:hover{background:var(--teal);border-color:var(--teal)}
.dx-btn.is-teal{background:var(--teal);border-color:var(--teal);color:#fff!important}
.dx-btn.is-teal:hover{background:var(--ink);border-color:var(--ink)}
.dx-btn.is-line-light{background:transparent;border-color:rgba(255,255,255,.25);color:#fff!important}
.dx-btn.is-line-light:hover{border-color:#fff}
.dx-arrow{width:42px;height:42px;border-radius:50%;border:1px solid var(--hair);display:inline-flex;align-items:center;justify-content:center;color:var(--ink);font-size:13px;flex-shrink:0;transition:background .2s,color .2s,border-color .2s,transform .25s}
.dx-arrow.is-dark{background:var(--ink);border-color:var(--ink);color:#fff}

/* badges */
.dx-badge{display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;line-height:1;padding:6px 10px;border-radius:100px;white-space:nowrap;border:1px solid transparent}
.dx-badge i{font-size:10px}
.dx-badge.is-featured{background:var(--gold-bg);color:var(--gold-ink)}
.dx-badge.is-verified{background:rgba(29,158,117,.12);color:#0b6646}
.dx-badge.is-claimed{background:rgba(10,46,30,.06);color:var(--ink)}
.dx-badge.is-licensed{border-color:var(--hair);color:var(--mut)}

/* monograms / logos — circles, like the footer socials */
.dx-logo{display:flex;align-items:center;justify-content:center;background:#fff;border-radius:50%;overflow:hidden;flex-shrink:0;border:1px solid var(--hair)}
.dx-logo:not(.is-mono){border-radius:24%!important;background:#fff}
.dx-logo img{width:100%;height:100%;object-fit:contain;padding:9%}
.dx-logo.is-mono{color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;letter-spacing:.01em;border:0}

/* pricing (inside a forest frame) */
.dx-pricing{display:grid;grid-template-columns:repeat(3,1fr);gap:20px}
.dx-plan{background:var(--cream);border-radius:32px;padding:36px 32px 32px;display:flex;flex-direction:column;position:relative}
.dx-plan.is-pop{background:#fff;box-shadow:0 0 0 2px var(--teal-lt)}
.dx-plan-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:28px}
.dx-plan-top h3{font-size:15px;font-weight:700}
.dx-plan-tag{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;color:#fff;background:var(--teal);padding:6px 11px;border-radius:100px}
.dx-price{font-family:'Plus Jakarta Sans',sans-serif;font-size:56px;font-weight:800;color:var(--ink);letter-spacing:-.05em;line-height:1}
.dx-price small{font-size:15px;font-weight:600;color:var(--mut);letter-spacing:0;margin-left:4px}
.dx-plan-blurb{font-size:15px;color:var(--mut);margin:12px 0 26px;line-height:1.5}
.dx-plan ul{list-style:none;padding:24px 0 0;margin:0 0 30px;border-top:1px solid var(--hair);flex:1}
.dx-plan li{display:flex;gap:12px;font-size:14.5px;color:var(--txt);padding:7px 0;line-height:1.45}
.dx-plan li i{color:var(--teal);font-size:12px;margin-top:4px}
.dx-plan .dx-btn{width:100%;padding:16px}

@media(max-width:1024px){
  .dx-panel{padding:56px 36px}
  .dx-pricing{grid-template-columns:1fr;max-width:480px;margin:0 auto}
}
@media(max-width:640px){
  .dx-frame{padding:0 10px 10px}
  .dx-frame.is-first{padding-top:80px}
  .dx-panel{padding:40px 20px;border-radius:28px}
  .dx-panel+.dx-panel{margin-top:10px}
  .dx-lead{font-size:16px}
  .dx-plan{padding:28px 24px;border-radius:24px}
}
CSS;
}

/** Deterministic, muted brand colour per agency for monogram circles. */
function hc_dir_mono_color(string $name): string {
    $palette = ['#0a2e1e', '#1a5c3a', '#7a5c12', '#2e4a6b', '#6b3a4b', '#2a6070', '#4a5a28', '#5b4530'];
    return $palette[abs(crc32(strtolower($name))) % count($palette)];
}

function hc_dir_logo(array $l, int $size = 72, bool $allowImage = true): string {
    $fs = max(13, (int)round($size * .32));
    $style = "width:{$size}px;height:{$size}px";
    if ($allowImage && !empty($l['logo'])) {
        return '<div class="dx-logo" style="' . $style . '"><img src="' . htmlspecialchars($l['logo']) . '" alt="' . htmlspecialchars($l['company_name']) . ' logo" loading="lazy"></div>';
    }
    $bg = hc_dir_mono_color($l['company_name']);
    return '<div class="dx-logo is-mono" style="' . $style . ';font-size:' . $fs . 'px;background:' . $bg . '" aria-hidden="true">' . htmlspecialchars(hc_dir_initials($l['company_name'])) . '</div>';
}

function hc_dir_badges(array $l, string $tier, bool $withLicense = true): string {
    $out = '';
    if ($tier === 'featured') $out .= '<span class="dx-badge is-featured"><i class="fa-solid fa-star"></i>Featured</span>';
    if ($tier !== 'free' && !empty($l['verified'])) $out .= '<span class="dx-badge is-verified"><i class="fa-solid fa-circle-check"></i>Verified</span>';
    elseif (hc_dir_is_claimed($l)) $out .= '<span class="dx-badge is-claimed"><i class="fa-solid fa-user-check"></i>Claimed</span>';
    if ($withLicense && !empty($l['license_number'])) $out .= '<span class="dx-badge is-licensed">Licensed</span>';
    return $out;
}

/** Pricing cards (designed to sit on the forest frame). $hrefFor(planKey) returns the CTA link. */
function hc_dir_pricing_html(callable $hrefFor): string {
    $html = '<div class="dx-pricing">';
    foreach (hc_dir_plans() as $key => $p) {
        $pop = $key === 'premium';
        $html .= '<div class="dx-plan' . ($pop ? ' is-pop' : '') . '">';
        $html .= '<div class="dx-plan-top"><h3>' . htmlspecialchars($p['name']) . '</h3>' . ($pop ? '<span class="dx-plan-tag">Most popular</span>' : '') . '</div>';
        $html .= '<div class="dx-price">' . ($p['price'] ? '$' . $p['price'] . '<small>/ month</small>' : 'Free') . '</div>';
        $html .= '<p class="dx-plan-blurb">' . htmlspecialchars($p['blurb']) . '</p><ul>';
        foreach ($p['features'] as $f) $html .= '<li><i class="fa-solid fa-check"></i><span>' . htmlspecialchars($f) . '</span></li>';
        $html .= '</ul>';
        $cta = $p['price'] ? 'Choose ' . $p['name'] : 'Create a free listing';
        $html .= '<a class="dx-btn ' . ($pop ? 'is-teal' : 'is-dark') . '" href="' . htmlspecialchars($hrefFor($key)) . '">' . $cta . ' <i class="fa-solid fa-arrow-right" style="font-size:12px"></i></a>';
        $html .= '</div>';
    }
    return $html . '</div>';
}

/* ── Ratings, status, ads ─────────────────────────────────── */

function hc_dir_extra_css(): string {
    return <<<CSS
.st-row{display:inline-flex;gap:2px;vertical-align:middle}
.st-row i{width:20px;height:20px;border-radius:4px;background:#d9d6cc;color:#fff;font-size:11px;display:inline-flex;align-items:center;justify-content:center}
.st-row i.on{background:#e0a020}
.st-row i.half{background:linear-gradient(90deg,#e0a020 50%,#d9d6cc 50%)}
.st-row.is-sm i{width:16px;height:16px;font-size:9px;border-radius:3px}
.st-row.is-lg i{width:30px;height:30px;font-size:15px;border-radius:6px}
.st-txt{font-size:14px;color:var(--mut);margin-left:8px;vertical-align:middle}
.st-txt b{color:var(--ink);font-family:'Plus Jakarta Sans',sans-serif}
.os{font-size:14px;font-weight:600}
.os.is-open{color:#0b8a5a}
.os.is-closed{color:#c2410c}
.os span{color:var(--mut);font-weight:400}
.ad{position:relative;background:var(--ink);border-radius:28px;padding:26px;color:#fff;overflow:hidden}
.ad::after{content:"";position:absolute;width:240px;height:240px;border-radius:50%;right:-90px;bottom:-110px;border:1px solid rgba(255,255,255,.08);box-shadow:0 0 0 34px rgba(255,255,255,.025),0 0 0 68px rgba(255,255,255,.015)}
.ad-lab{position:relative;display:inline-flex;align-items:center;gap:8px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,.5);margin-bottom:14px}
.ad-lab b{background:rgba(255,255,255,.12);color:#fff;border-radius:4px;padding:2px 6px;letter-spacing:.5px}
.ad h4{position:relative;color:#fff;font-size:21px;font-weight:800;letter-spacing:-.03em;line-height:1.2;margin-bottom:8px}
.ad h4 em{color:var(--teal-lt)}
.ad p{position:relative;font-size:14px;color:rgba(255,255,255,.65);line-height:1.6;margin-bottom:18px}
.ad ul{position:relative;list-style:none;margin:0 0 20px;padding:0}
.ad li{font-size:13.5px;color:rgba(255,255,255,.8);padding:4px 0;display:flex;gap:10px}
.ad li i{color:var(--teal-lt);font-size:11px;margin-top:4px}
.ad .dx-btn{position:relative}
.ad.is-row{display:grid;grid-template-columns:1fr auto;gap:24px;align-items:center;border-radius:24px;padding:24px 28px}
.ad.is-row p{margin-bottom:0}
@media(max-width:700px){.ad.is-row{grid-template-columns:1fr}}
CSS;
}

/** Yelp-style star squares. */
function hc_dir_stars(?float $avg, string $size = ''): string {
    $avg = (float)$avg;
    $out = '<span class="st-row' . ($size ? ' is-' . $size : '') . '" role="img" aria-label="' . ($avg ? number_format($avg, 1) . ' out of 5 stars' : 'No rating yet') . '">';
    for ($i = 1; $i <= 5; $i++) {
        $cls = $avg >= $i ? 'on' : ($avg >= $i - .5 ? 'half' : '');
        $out .= '<i class="fa-solid fa-star ' . $cls . '"></i>';
    }
    return $out . '</span>';
}

function hc_dir_rating_line(array $l, string $size = 'sm', string $suffix = ''): string {
    $n = (int)($l['rating_count'] ?? 0);
    if (!$n) return hc_dir_stars(0, $size) . '<span class="st-txt">No reviews yet' . $suffix . '</span>';
    return hc_dir_stars((float)$l['rating_avg'], $size) . '<span class="st-txt"><b>' . number_format((float)$l['rating_avg'], 1) . '</b> (' . $n . ' review' . ($n === 1 ? '' : 's') . ')' . $suffix . '</span>';
}

function hc_dir_open_html(array $l, bool $withToday = true): string {
    $s = hc_dir_open_status($l);
    if (!$s) return '';
    $html = '<span class="os ' . ($s['open'] ? 'is-open' : 'is-closed') . '">' . ($s['open'] ? 'Open' : 'Closed');
    $html .= ' <span>· ' . htmlspecialchars($s['label']) . '</span></span>';
    return $html;
}

/** Homecare Creators promo card, aimed at agency owners browsing the directory. */
function hc_dir_hc_ad(string $variant = 'side'): string {
    if ($variant === 'row') {
        return '<aside class="ad is-row"><div><div class="ad-lab">Homecare Creators</div>'
            . '<h4>Own a home care agency? <em>Get more private-pay clients.</em></h4>'
            . '<p>We build websites, local SEO and Google Maps rankings for home care agencies, so families find you first.</p></div>'
            . '<a class="dx-btn is-teal" href="/contact/?ref=directory">Get a free marketing audit <i class="fa-solid fa-arrow-right" style="font-size:12px"></i></a></aside>';
    }
    return '<aside class="ad"><div class="ad-lab">Homecare Creators</div>'
        . '<h4>Grow your agency with <em>more client calls.</em></h4>'
        . '<p>Marketing built only for home care agencies.</p>'
        . '<ul><li><i class="fa-solid fa-check"></i>Websites that turn visits into calls</li><li><i class="fa-solid fa-check"></i>Rank higher on Google Maps</li><li><i class="fa-solid fa-check"></i>Show up in AI search results</li></ul>'
        . '<a class="dx-btn is-teal" href="/contact/?ref=directory" style="width:100%">Free marketing audit <i class="fa-solid fa-arrow-right" style="font-size:12px"></i></a></aside>';
}

/** Leaflet assets (cdnjs, pinned version). */
function hc_dir_leaflet_head(): string {
    return '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.css" crossorigin="anonymous" referrerpolicy="no-referrer">'
        . '<script src="https://cdnjs.cloudflare.com/ajax/libs/leaflet/1.9.4/leaflet.min.js" crossorigin="anonymous" referrerpolicy="no-referrer"></script>';
}

/**
 * Bottom-right popup for directory pages. Pages are cached, so it asks the account API who is visiting:
 *  - logged-in owner with a free listing  → "Go Premium" upgrade popup
 *  - everyone else                        → "Own an agency? List or claim free" popup (after a short delay)
 * Dismissals are remembered per browser for 7 days.
 */
function hc_dir_popup_html(): string {
    $plans = hc_dir_plans();
    $prem  = (int)$plans['premium']['price'];
    return <<<HTML
<style>
.dxp{position:fixed;right:24px;bottom:24px;z-index:450;width:360px;max-width:calc(100vw - 32px);background:#0a2e1e;color:#fff;border-radius:26px;padding:24px 24px 22px;box-shadow:0 30px 80px rgba(0,0,0,.35);font-family:'DM Sans',sans-serif;transform:translateY(24px);opacity:0;pointer-events:none;transition:transform .35s cubic-bezier(.2,.8,.2,1),opacity .35s;overflow:hidden}
.dxp.show{transform:none;opacity:1;pointer-events:auto}
.dxp::after{content:"";position:absolute;width:200px;height:200px;border-radius:50%;right:-80px;top:-90px;border:1px solid rgba(255,255,255,.08);box-shadow:0 0 0 30px rgba(255,255,255,.025)}
.dxp-x{position:absolute;top:14px;right:14px;z-index:1;width:32px;height:32px;border-radius:50%;border:1px solid rgba(255,255,255,.2);background:transparent;color:#fff;cursor:pointer;font-size:13px}
.dxp-x:hover{background:rgba(255,255,255,.1)}
.dxp-k{position:relative;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#9fe1cb;margin-bottom:10px;font-family:'Plus Jakarta Sans',sans-serif}
.dxp h4{position:relative;font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;letter-spacing:-.03em;line-height:1.2;margin:0 34px 8px 0;color:#fff}
.dxp h4 em{font-style:italic;color:#2ec68f}
.dxp p{position:relative;font-size:14px;line-height:1.55;color:rgba(255,255,255,.7);margin:0 0 16px}
.dxp ul{position:relative;list-style:none;margin:0 0 18px;padding:0}
.dxp li{font-size:13.5px;color:rgba(255,255,255,.85);padding:3px 0;display:flex;gap:9px}
.dxp li:before{content:"✓";color:#2ec68f;font-weight:700}
.dxp-a{position:relative;display:flex;gap:8px}
.dxp-a a{flex:1;display:inline-flex;justify-content:center;align-items:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;padding:13px 16px;border-radius:100px;text-decoration:none!important;transition:background .2s}
.dxp-a a.p{background:#1d9e75;color:#fff}.dxp-a a.p:hover{background:#2ec68f}
.dxp-a a.s{border:1px solid rgba(255,255,255,.25);color:#fff}.dxp-a a.s:hover{border-color:#fff}
@media(max-width:700px){.dxp{right:16px;left:16px;bottom:84px;width:auto;border-radius:22px;padding:20px}}
</style>
<div class="dxp" id="dxPop" role="dialog" aria-live="polite" aria-label="Agency owners">
  <button class="dxp-x" type="button" aria-label="Close" onclick="dxPopClose()">✕</button>
  <div id="dxPopBody"></div>
</div>
<script>
(function(){
  var KEY='dxPopHide', pop=document.getElementById('dxPop'), body=document.getElementById('dxPopBody');
  function hidden(k){ try { return (+localStorage.getItem(KEY+k)||0) > Date.now(); } catch(e){ return false; } }
  window.dxPopClose=function(){ pop.classList.remove('show'); try { localStorage.setItem(KEY+(pop.dataset.k||''), Date.now()+7*864e5); } catch(e){} };
  function esc(s){ var d=document.createElement('div'); d.textContent=s||''; return d.innerHTML; }
  function show(k, html, delay){ if (hidden(k)) return; pop.dataset.k=k; body.innerHTML=html; setTimeout(function(){ pop.classList.add('show'); }, delay); }
  fetch('/directory/account/?api=me', {credentials:'same-origin', cache:'no-store'}).then(function(r){ return r.json(); }).then(function(me){
    if (me.loggedIn && me.freeListing) {
      show('pro', '<div class="dxp-k">Upgrade '+esc(me.freeListing.name)+'</div><h4>Get more families calling <em>you first.</em></h4>'
        + '<ul><li>Logo, photos &amp; website link</li><li>Verified badge &amp; higher ranking</li><li>No competitor ads on your profile</li></ul>'
        + '<div class="dxp-a"><a class="p" href="/directory/account/#upgrade">Go Premium · \${$prem}/mo</a></div>', 1500);
    } else if (!me.loggedIn) {
      show('owner', '<div class="dxp-k">For agency owners</div><h4>Is your agency <em>listed?</em></h4>'
        + '<p>Families use this directory to find home care. Add your agency free, or claim your existing listing.</p>'
        + '<div class="dxp-a"><a class="p" href="/directory/submit/">List free</a><a class="s" href="/directory/account/">Owner log in</a></div>', 9000);
    }
  }).catch(function(){});
})();
</script>
HTML;
}

