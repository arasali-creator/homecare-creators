<?php
$new_submissions = 0;
try { $new_submissions = (int)hc_val("SELECT COUNT(*) FROM hc_form_submissions WHERE status='new'"); } catch(Exception $e){}
$cur = $_SERVER['REQUEST_URI'] ?? '';
function na(string $href): string {
    global $cur;
    return (str_starts_with($cur, $href)) ? ' class="nav-item active"' : ' class="nav-item"';
}
?>
<nav class="sidebar">
  <div class="sidebar-logo">
    <span>Homecare Creators</span>
    <small>Admin Panel</small>
  </div>

  <div class="nav-group">
    <div class="nav-group-label">Overview</div>
    <a href="/admin/"<?= na('/admin/index') ?> class="nav-item <?= $cur==='/admin/' || $cur==='/admin/index.php' ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><rect x="3" y="14" width="7" height="7"/></svg>
      Dashboard
    </a>
    <a href="/admin/form-log.php" class="nav-item <?= str_contains($cur,'form-log') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M4 4h16c1.1 0 2 .9 2 2v12c0 1.1-.9 2-2 2H4c-1.1 0-2-.9-2-2V6c0-1.1.9-2 2-2z"/><polyline points="22,6 12,13 2,6"/></svg>
      Form Log <?php if ($new_submissions > 0): ?><span class="badge badge-red" style="margin-left:auto"><?= $new_submissions ?></span><?php endif ?>
    </a>
  </div>

  <div class="nav-group">
    <div class="nav-group-label">SEO</div>
    <a href="/admin/seo-pages.php" class="nav-item <?= str_contains($cur,'seo-page') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
      Pages
    </a>

    <div class="nav-item" style="cursor:default;font-size:12px;opacity:.6;padding-bottom:2px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2L2 7l10 5 10-5-10-5M2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
      Technical SEO
    </div>
    <div class="nav-sub">
      <a href="/admin/technical/sitemap.php" class="nav-item <?= str_contains($cur,'sitemap') ? 'active' : '' ?>">Sitemap Manager</a>
      <a href="/admin/technical/robots.php" class="nav-item <?= str_contains($cur,'robots') ? 'active' : '' ?>">Robots.txt</a>
      <a href="/admin/technical/redirects.php" class="nav-item <?= str_contains($cur,'redirects') ? 'active' : '' ?>">301 Redirects</a>
      <a href="/admin/technical/canonicals.php" class="nav-item <?= str_contains($cur,'canonicals') ? 'active' : '' ?>">Canonical URLs</a>
      <a href="/admin/technical/hreflang.php" class="nav-item <?= str_contains($cur,'hreflang') ? 'active' : '' ?>">Hreflang</a>
    </div>

    <div class="nav-item" style="cursor:default;font-size:12px;opacity:.6;padding-bottom:2px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2a10 10 0 1 0 10 10A10 10 0 0 0 12 2zm0 18a8 8 0 1 1 8-8 8 8 0 0 1-8 8z"/><path d="M12 6v6l4 2"/></svg>
      AI / GEO Panel
    </div>
    <div class="nav-sub">
      <a href="/admin/ai-geo/entity.php" class="nav-item <?= str_contains($cur,'entity') ? 'active' : '' ?>">Entity Data</a>
      <a href="/admin/ai-geo/eeat.php" class="nav-item <?= str_contains($cur,'eeat') ? 'active' : '' ?>">E-E-A-T Signals</a>
      <a href="/admin/ai-geo/faq-bank.php" class="nav-item <?= str_contains($cur,'faq-bank') ? 'active' : '' ?>">FAQ Bank</a>
      <a href="/admin/ai-geo/citations.php" class="nav-item <?= str_contains($cur,'citations') ? 'active' : '' ?>">Citations</a>
      <a href="/admin/ai-geo/knowledge-graph.php" class="nav-item <?= str_contains($cur,'knowledge-graph') ? 'active' : '' ?>">Knowledge Graph</a>
    </div>

    <div class="nav-item" style="cursor:default;font-size:12px;opacity:.6;padding-bottom:2px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
      Content Tools
    </div>
    <div class="nav-sub">
      <a href="/admin/content/image-alts.php" class="nav-item <?= str_contains($cur,'image-alts') ? 'active' : '' ?>">Image Alt Text</a>
      <a href="/admin/content/internal-links.php" class="nav-item <?= str_contains($cur,'internal-links') ? 'active' : '' ?>">Internal Links</a>
      <a href="/admin/content/broken-links.php" class="nav-item <?= str_contains($cur,'broken-links') ? 'active' : '' ?>">Broken Links</a>
    </div>

    <div class="nav-item" style="cursor:default;font-size:12px;opacity:.6;padding-bottom:2px">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
      Schema / LD+JSON
    </div>
    <div class="nav-sub">
      <a href="/admin/org-schema.php" class="nav-item <?= str_contains($cur,'org-schema') ? 'active' : '' ?>">Organization</a>
      <a href="/admin/schema/" class="nav-item <?= str_contains($cur,'/schema/') ? 'active' : '' ?>">Per-Page Schema</a>
    </div>
  </div>

  <div class="nav-group">
    <div class="nav-group-label">Content</div>
    <a href="/admin/blog/" class="nav-item <?= str_contains($cur,'/admin/blog') ? 'active' : '' ?>">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
      Blog Posts
    </a>
  </div>

  <div class="nav-group" style="margin-top:auto;border-top:1px solid rgba(255,255,255,.08);padding-top:12px">
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
