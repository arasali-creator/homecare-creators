<?php
$new_submissions = 0;
try { $new_submissions = (int)hc_val("SELECT COUNT(*) FROM hc_form_submissions WHERE status='new'"); } catch(Exception $e){}
$cur = $_SERVER['REQUEST_URI'] ?? '';

function is_active(string ...$paths): bool {
    global $cur;
    foreach ($paths as $p) { if (str_contains($cur, $p)) return true; }
    return false;
}
?>
<nav class="sidebar">
  <div class="sidebar-logo">
    <strong>Homecare Creators</strong>
    <small>Admin Panel</small>
  </div>

  <div class="nav-group">
    <a href="/admin/" class="nav-item <?= ($cur==='/admin/'||$cur==='/admin/index.php') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <a href="/admin/form-log.php" class="nav-item <?= is_active('form-log') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      Form Log
      <?php if ($new_submissions > 0): ?><span class="badge badge-red" style="margin-left:auto;font-size:9px"><?= $new_submissions ?></span><?php endif ?>
    </a>
    <a href="/admin/blog/" class="nav-item <?= is_active('/admin/blog') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Blog Posts
    </a>
  </div>

  <div class="nav-group">
    <div class="nav-group-label">SEO</div>

    <a href="/admin/seo-pages.php" class="nav-item <?= is_active('seo-page') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      Page SEO
    </a>

    <!-- Technical SEO toggle -->
    <div class="nav-item nav-toggle <?= is_active('technical') ? 'open' : '' ?>" onclick="toggleNav(this)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5M2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      Technical SEO
      <svg class="toggle-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:12px;height:12px;margin-left:auto;transition:.2s"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
    <div class="nav-sub-group <?= is_active('technical') ? 'open' : '' ?>">
      <a href="/admin/technical/sitemap.php" class="nav-item <?= is_active('sitemap') ? 'active' : '' ?>">Sitemap</a>
      <a href="/admin/technical/robots.php" class="nav-item <?= is_active('robots') ? 'active' : '' ?>">Robots.txt</a>
      <a href="/admin/technical/redirects.php" class="nav-item <?= is_active('redirects') ? 'active' : '' ?>">301 Redirects</a>
      <a href="/admin/technical/canonicals.php" class="nav-item <?= is_active('canonicals') ? 'active' : '' ?>">Canonical URLs</a>
      <a href="/admin/technical/hreflang.php" class="nav-item <?= is_active('hreflang') ? 'active' : '' ?>">Hreflang</a>
    </div>

    <!-- AI / GEO toggle -->
    <div class="nav-item nav-toggle <?= is_active('ai-geo') ? 'open' : '' ?>" onclick="toggleNav(this)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><line x1="2" y1="12" x2="22" y2="12"/><path d="M12 2a15.3 15.3 0 0 1 4 10 15.3 15.3 0 0 1-4 10 15.3 15.3 0 0 1-4-10 15.3 15.3 0 0 1 4-10z"/></svg>
      AI / GEO Panel
      <svg class="toggle-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:12px;height:12px;margin-left:auto;transition:.2s"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
    <div class="nav-sub-group <?= is_active('ai-geo') ? 'open' : '' ?>">
      <a href="/admin/ai-geo/entity.php" class="nav-item <?= is_active('entity') ? 'active' : '' ?>">Entity Data</a>
      <a href="/admin/ai-geo/eeat.php" class="nav-item <?= is_active('eeat') ? 'active' : '' ?>">E-E-A-T Signals</a>
      <a href="/admin/ai-geo/faq-bank.php" class="nav-item <?= is_active('faq-bank') ? 'active' : '' ?>">FAQ Bank</a>
      <a href="/admin/ai-geo/citations.php" class="nav-item <?= is_active('citations') ? 'active' : '' ?>">Citations</a>
      <a href="/admin/ai-geo/knowledge-graph.php" class="nav-item <?= is_active('knowledge-graph') ? 'active' : '' ?>">Knowledge Graph</a>
    </div>

    <!-- Content Tools toggle -->
    <div class="nav-item nav-toggle <?= is_active('content/') ? 'open' : '' ?>" onclick="toggleNav(this)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
      Content Tools
      <svg class="toggle-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:12px;height:12px;margin-left:auto;transition:.2s"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
    <div class="nav-sub-group <?= is_active('content/') ? 'open' : '' ?>">
      <a href="/admin/content/image-alts.php" class="nav-item <?= is_active('image-alts') ? 'active' : '' ?>">Image Alt Text</a>
      <a href="/admin/content/internal-links.php" class="nav-item <?= is_active('internal-links') ? 'active' : '' ?>">Internal Links</a>
      <a href="/admin/content/broken-links.php" class="nav-item <?= is_active('broken-links') ? 'active' : '' ?>">Broken Links</a>
    </div>

    <!-- Schema toggle -->
    <div class="nav-item nav-toggle <?= is_active('schema','org-schema') ? 'open' : '' ?>" onclick="toggleNav(this)">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><line x1="16" y1="13" x2="8" y2="13"/><line x1="16" y1="17" x2="8" y2="17"/></svg>
      Schema / LD+JSON
      <svg class="toggle-arrow" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" style="width:12px;height:12px;margin-left:auto;transition:.2s"><polyline points="6 9 12 15 18 9"/></svg>
    </div>
    <div class="nav-sub-group <?= is_active('schema','org-schema') ? 'open' : '' ?>">
      <a href="/admin/org-schema.php" class="nav-item <?= is_active('org-schema') ? 'active' : '' ?>">Organization</a>
      <a href="/admin/schema/" class="nav-item <?= is_active('/admin/schema/') ? 'active' : '' ?>">Per-Page Schema</a>
    </div>
  </div>

  <div class="nav-group" style="margin-top:auto;border-top:1px solid rgba(255,255,255,.08);padding-top:8px">
    <a href="/admin/settings.php" class="nav-item <?= is_active('settings') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1-2.83 2.83l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-4 0v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83-2.83l.06-.06A1.65 1.65 0 0 0 4.68 15a1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1 0-4h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 2.83-2.83l.06.06A1.65 1.65 0 0 0 9 4.68a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 4 0v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 2.83l-.06.06A1.65 1.65 0 0 0 19.4 9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 0 4h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
      Settings
    </a>
    <a href="/" target="_blank" class="nav-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M18 13v6a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2h6"/><polyline points="15 3 21 3 21 9"/><line x1="10" y1="14" x2="21" y2="3"/></svg>
      View Site
    </a>
    <a href="/admin/logout.php" class="nav-item">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" y1="12" x2="9" y2="12"/></svg>
      Logout
    </a>
  </div>
</nav>

<style>
.nav-sub-group{display:none;background:rgba(0,0,0,.15)}
.nav-sub-group.open{display:block}
.nav-sub-group .nav-item{padding:7px 18px 7px 44px;font-size:12.5px}
.nav-toggle{cursor:pointer}
.nav-toggle.open .toggle-arrow{transform:rotate(180deg)}
</style>
<script>
function toggleNav(el) {
  const sub = el.nextElementSibling;
  const isOpen = sub.classList.contains('open');
  // Close all
  document.querySelectorAll('.nav-sub-group').forEach(s => s.classList.remove('open'));
  document.querySelectorAll('.nav-toggle').forEach(t => t.classList.remove('open'));
  // Open clicked (unless it was already open)
  if (!isOpen) { sub.classList.add('open'); el.classList.add('open'); }
}
</script>
