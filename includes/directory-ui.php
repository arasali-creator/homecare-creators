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
.dx-logo img{width:100%;height:100%;object-fit:contain;padding:14%}
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
