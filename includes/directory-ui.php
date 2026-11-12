<?php
/**
 * Directory UI partials shared by /directory/, /directory/{slug}, /directory/submit/ and /directory-confirm.php.
 * Requires admin/includes/directory.php.
 */

function hc_dir_base_css(): string {
    return <<<CSS
/* ── Directory base (shared) ─────────────────────────────── */
.dx{--ink:#14201a;--ink-2:#3d4a43;--ink-3:#6b7770;--line:#e3e6e1;--line-2:#eef0ec;--bg:#f7f7f5;--gold-ink:#7a5c12;--gold-bg:#fbf4e1;--gold-line:#ead7a1;font-family:'DM Sans',sans-serif;color:var(--ink)}
.dx a{color:inherit}
.dx-wrap{max-width:1200px;margin:0 auto;padding:0 32px}
.dx h1,.dx h2,.dx h3{font-family:'Plus Jakarta Sans',sans-serif;letter-spacing:-.01em}

/* top search band */
.dx-band{background:var(--forest);padding:104px 0 28px;position:relative}
.dx-band::after{content:"";position:absolute;inset:auto 0 0 0;height:1px;background:rgba(255,255,255,.06)}
.dx-crumbs{font-size:12.5px;color:rgba(255,255,255,.5);margin-bottom:14px}
.dx-crumbs a{color:rgba(255,255,255,.7);text-decoration:none}
.dx-crumbs a:hover{color:#fff}
.dx-crumbs span{margin:0 7px;opacity:.5}

.dx-search{display:flex;background:#fff;border-radius:10px;overflow:hidden;box-shadow:0 1px 0 rgba(0,0,0,.04),0 10px 30px rgba(0,0,0,.18);max-width:860px}
.dx-search label{flex:1;display:flex;align-items:center;gap:10px;padding:0 16px;min-width:0}
.dx-search label+label{border-left:1px solid var(--line)}
.dx-search label i{color:var(--ink-3);font-size:14px}
.dx-search small{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:12.5px;color:var(--ink);white-space:nowrap}
.dx-search input{flex:1;min-width:0;border:0;outline:0;padding:17px 0;font:inherit;font-size:15px;color:var(--ink);background:transparent}
.dx-search button{border:0;background:var(--teal);color:#fff;padding:0 26px;font-size:16px;cursor:pointer;transition:background .15s}
.dx-search button:hover{background:#178a64}

/* badges */
.dx-badge{display:inline-flex;align-items:center;gap:5px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;line-height:1;padding:5px 8px;border-radius:5px;white-space:nowrap}
.dx-badge i{font-size:10.5px}
.dx-badge.is-featured{background:var(--gold-bg);color:var(--gold-ink);border:1px solid var(--gold-line)}
.dx-badge.is-verified{background:#e7f5ef;color:#0d6e4d;border:1px solid #c6e7d9}
.dx-badge.is-claimed{background:#f1f3f2;color:var(--ink-2);border:1px solid var(--line)}

/* logo tiles */
.dx-logo{display:flex;align-items:center;justify-content:center;background:#fff;border:1px solid var(--line);border-radius:10px;overflow:hidden;flex-shrink:0}
.dx-logo img{width:100%;height:100%;object-fit:contain;padding:8px}
.dx-logo.is-mono{background:#eef3ef;border-color:#dfe8e2;color:var(--forest);font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;letter-spacing:.02em}

/* buttons */
.dx-btn{display:inline-flex;align-items:center;justify-content:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;padding:10px 16px;border-radius:8px;text-decoration:none;border:1px solid var(--line);background:#fff;color:var(--ink);cursor:pointer;transition:border-color .15s,background .15s,color .15s;white-space:nowrap}
.dx-btn:hover{border-color:#b9c2bc}
.dx-btn.is-primary{background:var(--teal);border-color:var(--teal);color:#fff}
.dx-btn.is-primary:hover{background:#178a64;border-color:#178a64}
.dx-btn.is-dark{background:var(--forest);border-color:var(--forest);color:#fff}
.dx-btn.is-dark:hover{background:var(--forest-lt)}

/* pricing */
.dx-pricing{display:grid;grid-template-columns:repeat(3,1fr);gap:0;border:1px solid var(--line);border-radius:14px;overflow:hidden;background:#fff}
.dx-plan{padding:30px 28px;display:flex;flex-direction:column;position:relative}
.dx-plan+.dx-plan{border-left:1px solid var(--line)}
.dx-plan.is-pop{background:#fbfdfc;box-shadow:inset 0 3px 0 var(--teal)}
.dx-plan-tag{position:absolute;top:16px;right:18px;font-family:'Plus Jakarta Sans',sans-serif;font-size:10.5px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--teal)}
.dx-plan h3{font-size:16px;margin-bottom:4px;color:var(--ink)}
.dx-plan-blurb{font-size:13.5px;color:var(--ink-3);min-height:40px}
.dx-price{font-family:'Plus Jakarta Sans',sans-serif;font-size:38px;font-weight:800;color:var(--ink);margin:16px 0 18px;letter-spacing:-.02em}
.dx-price small{font-size:14px;font-weight:600;color:var(--ink-3);letter-spacing:0}
.dx-plan ul{list-style:none;padding:0;margin:0 0 24px;flex:1}
.dx-plan li{display:flex;gap:10px;font-size:14px;color:var(--ink-2);padding:6px 0;line-height:1.45}
.dx-plan li i{color:var(--teal);font-size:12px;margin-top:4px}
.dx-plan .dx-btn{width:100%}

@media(max-width:900px){
  .dx-pricing{grid-template-columns:1fr}
  .dx-plan+.dx-plan{border-left:0;border-top:1px solid var(--line)}
}
@media(max-width:640px){
  .dx-wrap{padding:0 16px}
  .dx-band{padding:92px 0 20px}
  .dx-search{flex-direction:column;border-radius:10px}
  .dx-search label+label{border-left:0;border-top:1px solid var(--line)}
  .dx-search button{padding:14px}
}
CSS;
}

function hc_dir_logo(array $l, int $size = 72, bool $allowImage = true): string {
    $fs = max(14, (int)round($size * .32));
    $style = "width:{$size}px;height:{$size}px";
    if ($allowImage && !empty($l['logo'])) {
        return '<div class="dx-logo" style="' . $style . '"><img src="' . htmlspecialchars($l['logo']) . '" alt="' . htmlspecialchars($l['company_name']) . ' logo" loading="lazy"></div>';
    }
    return '<div class="dx-logo is-mono" style="' . $style . ';font-size:' . $fs . 'px" aria-hidden="true">' . htmlspecialchars(hc_dir_initials($l['company_name'])) . '</div>';
}

function hc_dir_badges(array $l, string $tier): string {
    $out = '';
    if ($tier === 'featured') $out .= '<span class="dx-badge is-featured"><i class="fa-solid fa-star"></i>Featured</span>';
    if ($tier !== 'free' && !empty($l['verified'])) $out .= '<span class="dx-badge is-verified"><i class="fa-solid fa-circle-check"></i>Verified</span>';
    elseif (hc_dir_is_claimed($l)) $out .= '<span class="dx-badge is-claimed"><i class="fa-solid fa-user-check"></i>Claimed</span>';
    return $out;
}

/** Pricing table. $hrefFor(planKey) returns the CTA link. */
function hc_dir_pricing_html(callable $hrefFor): string {
    $html = '<div class="dx-pricing">';
    foreach (hc_dir_plans() as $key => $p) {
        $pop = $key === 'premium';
        $html .= '<div class="dx-plan' . ($pop ? ' is-pop' : '') . '" data-plan="' . $key . '">';
        if ($pop) $html .= '<span class="dx-plan-tag">Most popular</span>';
        $html .= '<h3>' . htmlspecialchars($p['name']) . '</h3><div class="dx-plan-blurb">' . htmlspecialchars($p['blurb']) . '</div>';
        $html .= '<div class="dx-price">' . ($p['price'] ? '$' . $p['price'] . '<small>/month</small>' : 'Free') . '</div><ul>';
        foreach ($p['features'] as $f) $html .= '<li><i class="fa-solid fa-check"></i><span>' . htmlspecialchars($f) . '</span></li>';
        $html .= '</ul>';
        $cta = $p['price'] ? 'Choose ' . $p['name'] : 'List for free';
        $html .= '<a class="dx-btn ' . ($pop ? 'is-primary' : '') . '" href="' . htmlspecialchars($hrefFor($key)) . '">' . $cta . '</a>';
        $html .= '</div>';
    }
    return $html . '</div>';
}
