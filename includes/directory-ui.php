<?php
/**
 * Directory UI partials shared by /directory/, /directory/{slug}, /directory/submit/ and /directory-confirm.php.
 * Requires admin/includes/directory.php.
 *
 * NOTE: never use <nav> inside directory markup — the site's global `nav{position:fixed}` rule hijacks it.
 */

function hc_dir_base_css(): string {
    return <<<CSS
/* ── Directory base (shared) ─────────────────────────────── */
.dx{--ink:#101a15;--ink-2:#3a4741;--ink-3:#6c7872;--line:#e2e5df;--line-2:#eceee9;--bg:#f4f5f1;--card:#fff;--gold-ink:#7a5c12;--gold-bg:#fbf3dc;--gold-line:#e9d39a;--shadow:0 1px 2px rgba(16,26,21,.04),0 4px 16px rgba(16,26,21,.05);font-family:'DM Sans',sans-serif;color:var(--ink);-webkit-font-smoothing:antialiased}
.dx a{color:inherit;text-decoration:none}
.dx-wrap{max-width:1240px;margin:0 auto;padding:0 32px}
.dx h1,.dx h2,.dx h3,.dx h4{font-family:'Plus Jakarta Sans',sans-serif;letter-spacing:-.015em;color:var(--ink)}
.dx-crumbs{font-size:13px;color:rgba(255,255,255,.55);display:flex;flex-wrap:wrap;align-items:center;gap:8px}
.dx-crumbs a{color:rgba(255,255,255,.78)}
.dx-crumbs a:hover{color:#fff}
.dx-crumbs i{font-size:9px;opacity:.6}

/* badges */
.dx-badge{display:inline-flex;align-items:center;gap:6px;font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;line-height:1;padding:6px 10px;border-radius:100px;white-space:nowrap}
.dx-badge i{font-size:11px}
.dx-badge.is-featured{background:var(--gold-bg);color:var(--gold-ink)}
.dx-badge.is-verified{background:#e3f4ec;color:#0b6646}
.dx-badge.is-claimed{background:#e9eef9;color:#2c4a8a}
.dx-badge.is-licensed{background:#f0f2ee;color:var(--ink-2)}

/* logo tiles */
.dx-logo{display:flex;align-items:center;justify-content:center;background:#fff;border-radius:14px;overflow:hidden;flex-shrink:0;box-shadow:inset 0 0 0 1px rgba(16,26,21,.08)}
.dx-logo img{width:100%;height:100%;object-fit:contain;padding:10%}
.dx-logo.is-mono{color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;letter-spacing:.02em;box-shadow:none}

/* buttons */
.dx-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;padding:11px 18px;border-radius:10px;border:1px solid var(--line);background:#fff;color:var(--ink)!important;cursor:pointer;transition:border-color .15s,background .15s,transform .15s;white-space:nowrap}
.dx-btn:hover{border-color:#b6bfb9;background:#fafbf9}
.dx-btn.is-primary{background:var(--teal);border-color:var(--teal);color:#fff!important}
.dx-btn.is-primary:hover{background:#178a64;border-color:#178a64}
.dx-btn.is-dark{background:var(--forest);border-color:var(--forest);color:#fff!important}
.dx-btn.is-dark:hover{background:#13432d}
.dx-btn.is-ghost-light{background:rgba(255,255,255,.08);border-color:rgba(255,255,255,.2);color:#fff!important}
.dx-btn.is-ghost-light:hover{background:rgba(255,255,255,.14)}

/* pricing (on dark band) */
.dx-pricing{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;align-items:stretch}
.dx-plan{background:#fff;border-radius:20px;padding:32px 28px;display:flex;flex-direction:column;position:relative}
.dx-plan.is-pop{box-shadow:0 0 0 2px var(--teal-lt),0 24px 60px rgba(0,0,0,.3);transform:translateY(-8px)}
.dx-plan-tag{position:absolute;top:-13px;left:28px;background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;padding:6px 12px;border-radius:100px}
.dx-plan h3{font-size:18px;margin-bottom:6px}
.dx-plan-blurb{font-size:14px;color:var(--ink-3);min-height:42px;line-height:1.5}
.dx-price{font-family:'Plus Jakarta Sans',sans-serif;font-size:44px;font-weight:800;color:var(--ink);margin:18px 0 20px;letter-spacing:-.03em;line-height:1}
.dx-price small{font-size:15px;font-weight:600;color:var(--ink-3);letter-spacing:0}
.dx-plan ul{list-style:none;padding:20px 0 0;margin:0 0 26px;flex:1;border-top:1px solid var(--line-2)}
.dx-plan li{display:flex;gap:11px;font-size:14.5px;color:var(--ink-2);padding:6px 0;line-height:1.45}
.dx-plan li i{color:var(--teal);font-size:13px;margin-top:3px}
.dx-plan .dx-btn{width:100%;padding:14px}

@media(max-width:960px){
  .dx-pricing{grid-template-columns:1fr;max-width:460px;margin:0 auto}
  .dx-plan.is-pop{transform:none}
}
@media(max-width:640px){
  .dx-wrap{padding:0 16px}
}
CSS;
}

/** Deterministic, muted brand colour per agency for monogram tiles. */
function hc_dir_mono_color(string $name): string {
    $palette = ['#0f3d28', '#1c6b55', '#8a6a1f', '#344a72', '#6d3a4e', '#2c6577', '#4b5a2a', '#5a4632'];
    return $palette[abs(crc32(strtolower($name))) % count($palette)];
}

function hc_dir_logo(array $l, int $size = 72, bool $allowImage = true): string {
    $fs = max(14, (int)round($size * .34));
    $r  = max(10, (int)round($size * .2));
    $style = "width:{$size}px;height:{$size}px;border-radius:{$r}px";
    if ($allowImage && !empty($l['logo'])) {
        return '<div class="dx-logo" style="' . $style . '"><img src="' . htmlspecialchars($l['logo']) . '" alt="' . htmlspecialchars($l['company_name']) . ' logo" loading="lazy"></div>';
    }
    $bg = hc_dir_mono_color($l['company_name']);
    return '<div class="dx-logo is-mono" style="' . $style . ';font-size:' . $fs . 'px;background:' . $bg . '" aria-hidden="true">' . htmlspecialchars(hc_dir_initials($l['company_name'])) . '</div>';
}

function hc_dir_badges(array $l, string $tier): string {
    $out = '';
    if ($tier === 'featured') $out .= '<span class="dx-badge is-featured"><i class="fa-solid fa-star"></i>Featured</span>';
    if ($tier !== 'free' && !empty($l['verified'])) $out .= '<span class="dx-badge is-verified"><i class="fa-solid fa-circle-check"></i>Verified</span>';
    elseif (hc_dir_is_claimed($l)) $out .= '<span class="dx-badge is-claimed"><i class="fa-solid fa-user-check"></i>Claimed</span>';
    if (!empty($l['license_number'])) $out .= '<span class="dx-badge is-licensed"><i class="fa-regular fa-id-card"></i>Licensed</span>';
    return $out;
}

/** Pricing cards. $hrefFor(planKey) returns the CTA link. */
function hc_dir_pricing_html(callable $hrefFor): string {
    $html = '<div class="dx-pricing">';
    foreach (hc_dir_plans() as $key => $p) {
        $pop = $key === 'premium';
        $html .= '<div class="dx-plan' . ($pop ? ' is-pop' : '') . '">';
        if ($pop) $html .= '<span class="dx-plan-tag">Most popular</span>';
        $html .= '<h3>' . htmlspecialchars($p['name']) . '</h3><div class="dx-plan-blurb">' . htmlspecialchars($p['blurb']) . '</div>';
        $html .= '<div class="dx-price">' . ($p['price'] ? '$' . $p['price'] . '<small> / month</small>' : '$0<small> forever</small>') . '</div>';
        $cta = $p['price'] ? 'Get ' . $p['name'] : 'Create free listing';
        $html .= '<a class="dx-btn ' . ($pop ? 'is-primary' : 'is-dark') . '" href="' . htmlspecialchars($hrefFor($key)) . '">' . $cta . '</a><ul style="margin:22px 0 0">';
        foreach ($p['features'] as $f) $html .= '<li><i class="fa-solid fa-check"></i><span>' . htmlspecialchars($f) . '</span></li>';
        $html .= '</ul></div>';
    }
    return $html . '</div>';
}
