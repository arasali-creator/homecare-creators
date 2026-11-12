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
body{background:var(--cream)}
.dx{--ink:#0a2e1e;--txt:#2b342f;--mut:#6b7b6e;--hair:rgba(10,46,30,.1);--hair-2:rgba(10,46,30,.06);--paper:#fff;--panel:var(--cream);--gold-ink:#7a5c12;--gold-bg:#f6ecd0;font-family:'DM Sans',sans-serif;color:var(--txt);-webkit-font-smoothing:antialiased}
.dx a{color:inherit;text-decoration:none}
.dx h1,.dx h2,.dx h3,.dx h4{font-family:'Plus Jakarta Sans',sans-serif;color:var(--ink);letter-spacing:-.02em}
.dx em{font-style:italic;color:var(--teal)}

/* frame + panels (same recipe as the footer) */
.dx-frame{background:var(--cream);padding:0}
.dx-frame.is-first{padding-top:72px}
.dx-panel{max-width:none;margin:0;background:var(--cream);border-radius:0;padding:72px 32px;position:relative}
.dx-panel+.dx-panel{border-top:1px solid var(--hair)}
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
.dx-plan{background:#fff;border-radius:32px;padding:36px 32px 32px;display:flex;flex-direction:column;position:relative}
.dx-plan.is-pop{background:#fff;box-shadow:0 0 0 2px var(--teal),0 24px 60px rgba(10,46,30,.08)}
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
  .dx-panel{padding:56px 24px}
  .dx-pricing{grid-template-columns:1fr;max-width:480px;margin:0 auto}
}
@media(max-width:640px){
  .dx-frame.is-first{padding-top:62px}
  .dx-panel{padding:40px 16px}
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
.ad{position:relative;background:#fff;border:1px solid var(--hair);border-radius:28px;padding:26px;color:var(--ink);overflow:hidden}
.ad-lab{position:relative;display:inline-flex;align-items:center;gap:8px;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--teal);margin-bottom:12px}
.ad h4{position:relative;color:var(--ink);font-size:20px;font-weight:800;letter-spacing:-.03em;line-height:1.2;margin-bottom:8px}
.ad h4 em{color:var(--teal)}
.ad p{position:relative;font-size:14px;color:var(--mut);line-height:1.6;margin-bottom:16px}
.ad ul{position:relative;list-style:none;margin:0 0 18px;padding:0}
.ad li{font-size:13.5px;color:var(--txt);padding:4px 0;display:flex;gap:10px}
.ad li i{color:var(--teal);font-size:11px;margin-top:4px}
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
            . '</div>'
            . '<a class="dx-btn is-teal" href="/contact/?ref=directory">Get a free marketing audit <i class="fa-solid fa-arrow-right" style="font-size:12px"></i></a></aside>';
    }
    return '<aside class="ad"><div class="ad-lab">Homecare Creators</div>'
        . '<h4>Grow your agency with <em>more client calls.</em></h4>'
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
.dxp{position:fixed;right:24px;bottom:24px;z-index:450;width:360px;max-width:calc(100vw - 32px);background:#fff;color:#0a2e1e;border:1px solid rgba(10,46,30,.1);border-radius:26px;padding:24px 24px 22px;box-shadow:0 30px 80px rgba(0,0,0,.35);font-family:'DM Sans',sans-serif;transform:translateY(24px);opacity:0;pointer-events:none;transition:transform .35s cubic-bezier(.2,.8,.2,1),opacity .35s;overflow:hidden}
.dxp.show{transform:none;opacity:1;pointer-events:auto}
.dxp-x{position:absolute;top:14px;right:14px;z-index:1;width:32px;height:32px;border-radius:50%;border:1px solid rgba(10,46,30,.15);background:transparent;color:#0a2e1e;cursor:pointer;font-size:13px}
.dxp-x:hover{background:#f5f2ec}
.dxp-k{position:relative;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:#1d9e75;margin-bottom:10px;font-family:'Plus Jakarta Sans',sans-serif}
.dxp h4{position:relative;font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;letter-spacing:-.03em;line-height:1.2;margin:0 34px 14px 0;color:#0a2e1e}
.dxp h4 em{font-style:italic;color:#1d9e75}
.dxp p{position:relative;font-size:14px;line-height:1.55;color:#6b7b6e;margin:0 0 16px}
.dxp ul{position:relative;list-style:none;margin:0 0 18px;padding:0}
.dxp li{font-size:13.5px;color:#2b342f;padding:3px 0;display:flex;gap:9px}
.dxp li:before{content:"✓";color:#1d9e75;font-weight:700}
.dxp-a{position:relative;display:flex;gap:8px}
.dxp-a a{flex:1;display:inline-flex;justify-content:center;align-items:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;padding:13px 16px;border-radius:100px;text-decoration:none!important;transition:background .2s}
.dxp-a a.p{background:#0a2e1e;color:#fff}.dxp-a a.p:hover{background:#1d9e75}
.dxp-a a.s{border:1px solid rgba(10,46,30,.2);color:#0a2e1e}.dxp-a a.s:hover{border-color:#0a2e1e}
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
        + '<div class="dxp-a"><a class="p" href="/directory/submit/">List free</a><a class="s" href="/directory/account/">Owner log in</a></div>', 9000);
    }
  }).catch(function(){});
})();
</script>
HTML;
}


/* ── Form kit: validation, phone formatting, tag inputs, image uploads ── */

function hc_dir_state_options(string $sel = ''): string {
    $o = '<option value="">State</option>';
    foreach (HC_DIR_STATES as $k => $n) $o .= '<option value="' . $k . '"' . (strtoupper($sel) === $k ? ' selected' : '') . '>' . htmlspecialchars($n) . '</option>';
    return $o;
}

/** Image upload field. $existing = list of current image paths (kept unless removed). */
function hc_dir_image_field(string $name, string $label, bool $multiple = false, array $existing = [], string $hint = 'PNG, JPG or WEBP · up to 5 MB', int $max = 1): string {
    $max = $multiple ? max(1, $max) : 1;
    $h = '<div class="iu" data-name="' . $name . '" data-max="' . $max . '"' . ($multiple ? ' data-multiple="1"' : '') . '>';
    $h .= '<div class="iu-label">' . htmlspecialchars($label) . '</div>';
    $h .= '<div class="iu-grid">';
    foreach ($existing as $src) {
        if (!$src) continue;
        $h .= '<div class="iu-item"><img src="' . htmlspecialchars($src) . '" alt=""><input type="hidden" name="' . $name . '_keep[]" value="' . htmlspecialchars($src) . '"><button type="button" class="iu-rm" aria-label="Remove image">✕</button></div>';
    }
    $h .= '<label class="iu-drop"><input type="file" name="' . $name . '_file' . ($multiple ? '[]' : '') . '" accept="image/png,image/jpeg,image/webp"' . ($multiple ? ' multiple' : '') . ' hidden>'
        . '<span class="iu-ic"><i class="fa-solid fa-arrow-up-from-bracket"></i></span><b>' . ($multiple ? 'Add photos' : 'Upload') . '</b><small>or drag &amp; drop</small></label>';
    $h .= '</div><div class="iu-hint">' . htmlspecialchars($hint) . ($multiple ? ' · up to ' . $max . ' photos' : '') . '</div></div>';
    return $h;
}

function hc_dir_form_kit(): string {
    return <<<'HTML'
<style>
.fe-err{display:none;color:#c0392b;font-size:12.5px;font-weight:500;margin:-8px 0 14px 4px;line-height:1.4}
.fe-err.show{display:block}
.is-invalid{border-color:#e05a47!important;background:#fff8f7!important}
.fe-group-err{border-radius:14px;outline:1.5px solid #e05a47;outline-offset:6px}
.fe-banner{display:none;background:#fdecea;color:#9b2c1f;border-radius:16px;padding:14px 18px;font-size:14.5px;margin-bottom:18px;line-height:1.5}
.fe-banner.show{display:block}
.fe-ok{position:relative}
.tg{display:flex;flex-wrap:wrap;gap:6px;align-items:center;border:1px solid var(--hair,#ddd);border-radius:16px;padding:8px 10px;background:var(--cream,#f5f2ec);margin-bottom:16px;cursor:text;min-height:50px}
.tg:focus-within{border-color:var(--ink,#0a2e1e);background:#fff}
.tg span{display:inline-flex;align-items:center;gap:6px;background:var(--ink,#0a2e1e);color:#fff;border-radius:100px;padding:6px 8px 6px 12px;font-size:13.5px}
.tg span button{border:0;background:rgba(255,255,255,.18);color:#fff;width:18px;height:18px;border-radius:50%;font-size:10px;cursor:pointer;line-height:1}
.tg input{flex:1;width:auto!important;min-width:140px;border:0!important;outline:0;background:transparent!important;padding:6px 4px!important;margin:0!important;font:inherit;font-size:15px}
.iu{margin-bottom:18px}
.iu-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--ink,#0a2e1e);margin:0 0 8px 4px}
.iu-grid{display:flex;flex-wrap:wrap;gap:10px}
.iu-item{position:relative;width:120px;height:120px;border-radius:18px;overflow:hidden;background:#fff;border:1px solid var(--hair,#ddd)}
.iu-item img{width:100%;height:100%;object-fit:contain;background:#fff}
.iu[data-multiple] .iu-item img{object-fit:cover}
.iu-rm{position:absolute;top:6px;right:6px;width:26px;height:26px;border-radius:50%;border:0;background:rgba(10,46,30,.85);color:#fff;font-size:11px;cursor:pointer}
.iu-drop{width:120px;height:120px;border-radius:18px;border:1.5px dashed rgba(10,46,30,.25);display:flex;flex-direction:column;align-items:center;justify-content:center;gap:4px;cursor:pointer;background:var(--cream,#f5f2ec);text-align:center;transition:border-color .15s,background .15s}
.iu-drop:hover,.iu-drop.drag{border-color:var(--ink,#0a2e1e);background:#fff}
.iu-drop b{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;color:var(--ink,#0a2e1e)}
.iu-drop small{font-size:11.5px;color:var(--mut,#6b7b6e)}
.iu-ic{width:32px;height:32px;border-radius:50%;background:var(--ink,#0a2e1e);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px}
.iu.full .iu-drop{display:none}
.iu-hint{font-size:12px;color:var(--mut,#6b7b6e);margin:8px 0 0 4px}
.pfx{display:flex;align-items:stretch;margin-bottom:16px}
.pfx span{display:flex;align-items:center;padding:0 12px 0 16px;border:1px solid var(--hair,#ddd);border-right:0;border-radius:16px 0 0 16px;background:#efece4;color:var(--mut,#6b7b6e);font-size:14px}
.pfx input{margin:0!important;border-radius:0 16px 16px 0!important}
</style>
<script>
(function(){
  if (window.DXF) return;
  var D = window.DXF = {};
  var reEmail = /^[^\s@]+@[^\s@]+\.[^\s@]{2,}$/;
  function label(el){
    if (el.dataset.label) return el.dataset.label;
    var l = el.id && document.querySelector('label[for="' + el.id + '"]');
    var t = l ? l.childNodes[0].textContent.trim() : (el.placeholder || el.name || 'this field');
    return t.replace(/[:*]$/, '').toLowerCase();
  }
  function errEl(el){
    var anchor = el.closest('.tg, .pfx, .iu') || el;
    var n = anchor.nextElementSibling;
    if (!n || !n.classList.contains('fe-err')) { n = document.createElement('div'); n.className = 'fe-err'; anchor.parentNode.insertBefore(n, anchor.nextSibling); }
    return n;
  }
  D.setErr = function(el, msg){
    var e = errEl(el); var box = el.closest('.tg, .pfx') || el;
    if (msg) { e.textContent = msg; e.classList.add('show'); box.classList.add('is-invalid'); if (el !== box) el.classList.add('is-invalid'); }
    else { e.classList.remove('show'); box.classList.remove('is-invalid'); el.classList.remove('is-invalid'); }
    return !msg;
  };
  D.check = function(el){
    if (el.disabled || el.type === 'hidden' && !el.dataset.validate || el.closest('[hidden]') || (el.offsetParent === null && el.type !== 'hidden' && !el.closest('.tg'))) return true;
    var v = (el.value || '').trim(), msg = '';
    if (el.required && !v) msg = el.dataset.req || ('Please enter ' + (/^(a|an|the|your)\s/.test(label(el)) ? '' : 'your ') + label(el) + '.');
    else if (v && el.type === 'email' && !reEmail.test(v)) msg = 'Please enter a valid email address, like name@agency.com.';
    else if (v && el.hasAttribute('data-phone') && v.replace(/\D/g,'').replace(/^1/,'').length !== 10) msg = 'Please enter a 10-digit US phone number.';
    else if (v && el.hasAttribute('data-url') && !/^(https?:\/\/)?([a-z0-9-]+\.)+[a-z]{2,}(\/\S*)?$/i.test(v)) msg = 'Please enter a valid website, like youragency.com.';
    else if (v && el.minLength > 0 && v.length < el.minLength) msg = 'Please write at least ' + el.minLength + ' characters (' + v.length + ' so far).';
    else if (v && el.dataset.match) { var o = document.querySelector(el.dataset.match); if (o && o.value !== el.value) msg = 'The passwords don’t match.'; }
    else if (v && el.type === 'number' && ((el.min !== '' && +v < +el.min) || (el.max !== '' && +v > +el.max))) msg = 'Please enter a number between ' + el.min + ' and ' + el.max + '.';
    else if (v && el.pattern && !(new RegExp('^(?:' + el.pattern + ')$')).test(v)) msg = el.title || 'Please check this field.';
    return D.setErr(el, msg);
  };
  D.checkGroups = function(form){
    var ok = true;
    form.querySelectorAll('[data-min-checked]').forEach(function(g){
      if (g.closest('[hidden]')) return;
      var n = g.querySelectorAll('input:checked').length + ((g.dataset.alsoField && (document.querySelector(g.dataset.alsoField) || {}).value || '').trim() ? 1 : 0);
      var bad = n < +g.dataset.minChecked;
      g.classList.toggle('fe-group-err', bad);
      var e = g.nextElementSibling;
      if (!e || !e.classList.contains('fe-err')) { e = document.createElement('div'); e.className = 'fe-err'; g.parentNode.insertBefore(e, g.nextSibling); }
      e.textContent = bad ? (g.dataset.req || 'Please choose at least one option.') : ''; e.style.marginTop = '10px';
      e.classList.toggle('show', bad);
      if (bad) ok = false;
    });
    return ok;
  };
  D.validate = function(form){
    var first = null, ok = true;
    form.querySelectorAll('input, select, textarea').forEach(function(el){ if (!D.check(el)) { ok = false; first = first || el; } });
    if (!D.checkGroups(form)) { ok = false; first = first || form.querySelector('.fe-group-err'); }
    form.querySelectorAll('input[type=checkbox][required]').forEach(function(cb){ if (!cb.checked) { ok = false; var e = errEl(cb.closest('label') || cb); e.textContent = cb.dataset.req || 'Please tick this box to continue.'; e.classList.add('show'); first = first || cb; } });
    if (first) { (first.closest('.tg') ? first.closest('.tg').querySelector('input') : first).focus({preventScroll: true}); first.scrollIntoView({behavior: 'smooth', block: 'center'}); }
    return ok;
  };
  D.banner = function(form, msg){
    var b = form.querySelector('.fe-banner');
    if (!b) { b = document.createElement('div'); b.className = 'fe-banner'; form.insertBefore(b, form.firstChild); }
    b.textContent = msg || ''; b.classList.toggle('show', !!msg);
    if (msg) b.scrollIntoView({behavior: 'smooth', block: 'center'});
  };
  function fmtPhone(v){
    var d = v.replace(/\D/g, ''); if (d.length === 11 && d[0] === '1') d = d.slice(1); d = d.slice(0, 10);
    if (d.length < 4) return d; if (d.length < 7) return '(' + d.slice(0,3) + ') ' + d.slice(3);
    return '(' + d.slice(0,3) + ') ' + d.slice(3,6) + '-' + d.slice(6);
  }
  function initTags(inp){
    if (inp.dataset.tagReady) return; inp.dataset.tagReady = 1;
    var box = document.createElement('div'); box.className = 'tg';
    var typer = document.createElement('input'); typer.type = 'text'; typer.placeholder = inp.placeholder || 'Type and press Enter';
    inp.type = 'hidden'; inp.parentNode.insertBefore(box, inp); box.appendChild(typer); box.appendChild(inp);
    var tags = inp.value.split(/[,\n]+/).map(function(s){ return s.trim(); }).filter(Boolean);
    function sync(){ inp.value = tags.join(', '); box.querySelectorAll('span').forEach(function(s){ s.remove(); });
      tags.forEach(function(t, i){ var s = document.createElement('span'); s.textContent = t; var b = document.createElement('button'); b.type = 'button'; b.textContent = '✕'; b.setAttribute('aria-label', 'Remove ' + t); b.onclick = function(){ tags.splice(i, 1); sync(); }; s.appendChild(b); box.insertBefore(s, typer); });
      if (inp.required) typer.required = !tags.length; }
    function add(){ typer.value.split(',').map(function(s){ return s.trim(); }).filter(Boolean).forEach(function(t){ if (tags.map(function(x){return x.toLowerCase();}).indexOf(t.toLowerCase()) < 0 && t.length <= 60 && tags.length < 40) tags.push(t); }); typer.value = ''; sync(); D.setErr(typer, ''); }
    typer.addEventListener('keydown', function(e){ if (e.key === 'Enter' || e.key === ',') { e.preventDefault(); add(); } else if (e.key === 'Backspace' && !typer.value && tags.length) { tags.pop(); sync(); } });
    typer.addEventListener('blur', add);
    box.addEventListener('click', function(e){ if (e.target === box) typer.focus(); });
    typer.dataset.label = inp.dataset.label || 'at least one area';
    sync();
  }
  function initUpload(w){
    if (w.dataset.ready) return; w.dataset.ready = 1;
    var input = w.querySelector('input[type=file]'), grid = w.querySelector('.iu-grid'), drop = w.querySelector('.iu-drop');
    var max = +w.dataset.max || 1, multi = !!w.dataset.multiple, dt = new DataTransfer();
    function count(){ return grid.querySelectorAll('.iu-item').length; }
    function refresh(){ w.classList.toggle('full', count() >= max); }
    function err(m){ var e = w.nextElementSibling; if (!e || !e.classList.contains('fe-err')) { e = document.createElement('div'); e.className = 'fe-err'; w.parentNode.insertBefore(e, w.nextSibling); } e.textContent = m || ''; e.style.marginTop = '0'; e.classList.toggle('show', !!m); }
    grid.addEventListener('click', function(e){
      var b = e.target.closest('.iu-rm'); if (!b) return;
      var it = b.closest('.iu-item');
      if (it.dataset.fileIdx !== undefined) { var nd = new DataTransfer(); Array.prototype.forEach.call(dt.files, function(f, i){ if (String(i) !== it.dataset.fileIdx) nd.items.add(f); }); dt = nd; input.files = dt.files; grid.querySelectorAll('.iu-item[data-file-idx]').forEach(function(x){ x.remove(); }); Array.prototype.forEach.call(dt.files, addPreview); }
      else it.remove();
      if (!multi && !count()) { var rm = document.createElement('input'); rm.type = 'hidden'; rm.name = w.dataset.name + '_remove'; rm.value = '1'; w.appendChild(rm); }
      refresh();
    });
    function addPreview(f, i){
      var it = document.createElement('div'); it.className = 'iu-item'; it.dataset.fileIdx = i;
      var img = document.createElement('img'); img.src = URL.createObjectURL(f); img.alt = '';
      var b = document.createElement('button'); b.type = 'button'; b.className = 'iu-rm'; b.textContent = '✕'; b.setAttribute('aria-label', 'Remove image');
      it.appendChild(img); it.appendChild(b); grid.insertBefore(it, drop);
    }
    function take(files){
      err('');
      Array.prototype.forEach.call(files, function(f){
        if (!/^image\/(png|jpe?g|webp)$/.test(f.type)) return err('“' + f.name + '” isn’t a PNG, JPG or WEBP image.');
        if (f.size > 5 * 1048576) return err('“' + f.name + '” is larger than 5 MB.');
        if (!multi) { grid.querySelectorAll('.iu-item').forEach(function(x){ x.remove(); }); dt = new DataTransfer(); }
        if (count() >= max) return err('You can add up to ' + max + ' photos.');
        dt.items.add(f); addPreview(f, dt.files.length - 1);
      });
      input.files = dt.files; refresh();
    }
    input.addEventListener('change', function(){ var fs = Array.prototype.slice.call(input.files); input.value = ''; input.files = dt.files; take(fs); });
    drop.addEventListener('dragover', function(e){ e.preventDefault(); drop.classList.add('drag'); });
    drop.addEventListener('dragleave', function(){ drop.classList.remove('drag'); });
    drop.addEventListener('drop', function(e){ e.preventDefault(); drop.classList.remove('drag'); take(e.dataTransfer.files); });
    refresh();
  }
  D.init = function(root){
    root = root || document;
    root.querySelectorAll('input[data-phone]').forEach(function(el){ el.addEventListener('input', function(){ var p = el.selectionStart === el.value.length; el.value = fmtPhone(el.value); }); if (el.value) el.value = fmtPhone(el.value); });
    root.querySelectorAll('[data-tags]').forEach(initTags);
    root.querySelectorAll('.iu').forEach(initUpload);
    root.querySelectorAll('form[data-validate]').forEach(function(f){
      f.setAttribute('novalidate', '');
      f.addEventListener('blur', function(e){ if (e.target.matches('input, select, textarea') && e.target.value) D.check(e.target); }, true);
      f.addEventListener('input', function(e){ if (e.target.classList.contains('is-invalid') || (e.target.closest('.tg') || {}).classList && e.target.closest('.tg') && e.target.closest('.tg').classList.contains('is-invalid')) D.check(e.target); });
      f.addEventListener('change', function(e){ if (e.target.type === 'checkbox') D.checkGroups(f); if (e.target.type === 'checkbox' && e.target.required && e.target.checked) { var er = (e.target.closest('label') || e.target).nextElementSibling; if (er && er.classList.contains('fe-err')) er.classList.remove('show'); } });
      if (!f.dataset.jsSubmit) f.addEventListener('submit', function(e){ if (!D.validate(f)) e.preventDefault(); });
    });
  };
  if (document.readyState !== 'loading') D.init(); else document.addEventListener('DOMContentLoaded', function(){ D.init(); });
})();
</script>
HTML;
}
