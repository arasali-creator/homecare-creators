<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

$path = $_GET['path'] ?? '';
if (!$path) { header('Location: /admin/seo-pages.php'); exit; }

// Load existing or create default
$seo = hc_one("SELECT * FROM hc_seo_pages WHERE page_path = ?", [$path]);

// Extract current values from the PHP file itself
$pages_list = hc_scan_pages();
$page_file  = '';
foreach ($pages_list as $p) { if ($p['path'] === $path) { $page_file = $p['file']; break; } }
$file_meta  = $page_file ? hc_extract_page_meta($page_file) : [];

// Handle Save
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $d = [
        'page_path'          => $path,
        'page_name'          => $_POST['page_name'] ?? '',
        'meta_title'         => trim($_POST['meta_title'] ?? ''),
        'meta_desc'          => trim($_POST['meta_desc'] ?? ''),
        'focus_keyword'      => trim($_POST['focus_keyword'] ?? ''),
        'secondary_keywords' => trim($_POST['secondary_keywords'] ?? ''),
        'h1_override'        => trim($_POST['h1_override'] ?? ''),
        'canonical_url'      => trim($_POST['canonical_url'] ?? ''),
        'robots_index'       => isset($_POST['robots_index']) ? 1 : 0,
        'robots_follow'      => isset($_POST['robots_follow']) ? 1 : 0,
        'og_title'           => trim($_POST['og_title'] ?? ''),
        'og_desc'            => trim($_POST['og_desc'] ?? ''),
        'og_image'           => trim($_POST['og_image'] ?? ''),
        'twitter_card'       => $_POST['twitter_card'] ?? 'summary_large_image',
        'twitter_title'      => trim($_POST['twitter_title'] ?? ''),
        'twitter_desc'       => trim($_POST['twitter_desc'] ?? ''),
        'twitter_image'      => trim($_POST['twitter_image'] ?? ''),
    ];

    $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($d)));
    $vals = implode(',', array_fill(0, count($d), '?'));
    $upd  = implode(',', array_map(fn($k) => "`$k`=VALUES(`$k`)", array_keys($d)));

    hc_q("INSERT INTO hc_seo_pages ($cols) VALUES ($vals) ON DUPLICATE KEY UPDATE $upd", array_values($d));

    hc_flash('SEO data saved successfully.');
    header('Location: /admin/seo-page-edit.php?path=' . urlencode($path));
    exit;
}

$name = $seo['page_name'] ?? ucwords(str_replace(['-','_','/',' '], [' ',' ',' ',' '], basename($path)));
hc_head('Edit SEO: ' . $name);
hc_topbar('Edit Page SEO', '<a href="/admin/">Admin</a> › <a href="/admin/seo-pages.php">SEO Pages</a> › ' . h($name));
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div>
    <h1><?= h($name) ?></h1>
    <div class="sub" style="font-family:monospace;font-size:12px;color:var(--muted)"><?= h($path) ?></div>
  </div>
  <div class="page-actions">
    <a href="<?= h($path) ?>" target="_blank" class="btn btn-secondary btn-sm">↗ View Page</a>
    <a href="/admin/seo-pages.php" class="btn btn-secondary btn-sm">← Back</a>
  </div>
</div>

<!-- SEO Preview (live) -->
<div class="seo-preview-box">
  <div class="prev-label">Google Search Preview</div>
  <div class="prev-site">
    <span class="prev-favicon"><span>H</span></span>
    <div>
      <div style="font-size:13px;color:#1a6634;font-weight:600">homecarecreators.com</div>
      <div id="prev-url" class="prev-url" style="font-size:12px;color:#1a6634"><?= h(SITE_URL . $path) ?></div>
    </div>
  </div>
  <div id="prev-title" class="prev-title"><?= h($seo['meta_title'] ?? $name) ?></div>
  <div id="prev-desc" class="prev-desc"><?= h($seo['meta_desc'] ?? 'No meta description set yet.') ?></div>
</div>

<form method="POST">
<div class="tabs">
  <button type="button" class="tab-btn active" data-tab="onpage">On-Page SEO</button>
  <button type="button" class="tab-btn" data-tab="social">Open Graph & Social</button>
  <button type="button" class="tab-btn" data-tab="schema">Schema / LD+JSON</button>
</div>

<!-- TAB: On-Page SEO -->
<div id="tab-onpage" class="tab-panel active">
  <div class="card">
    <div class="card-header"><div class="card-title">Meta Tags</div></div>

    <?php if ($file_meta && !$seo): ?>
    <div class="alert alert-info" style="margin-bottom:16px">
      <div><strong>Current values from PHP file</strong> — shown as placeholders below. Fill in the fields to override them in the database (the DB value always wins).</div>
    </div>
    <?php elseif ($seo): ?>
    <div class="alert alert-success" style="margin-bottom:16px">
      <div><strong>DB override is active</strong> — these values are currently overriding the PHP file defaults on the live site.</div>
    </div>
    <?php endif ?>

    <?php if (!empty($file_meta['page_title'])): ?>
    <div style="background:rgba(29,158,117,.06);border:1px solid rgba(29,158,117,.2);border-radius:8px;padding:12px 14px;margin-bottom:16px;font-size:13px">
      <div style="font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--teal);margin-bottom:6px">Current PHP file values (read-only)</div>
      <div style="margin-bottom:4px"><span style="color:var(--muted);width:100px;display:inline-block">Title:</span> <strong><?= h($file_meta['page_title']) ?></strong> <span style="color:var(--muted);font-size:11px">(<?= strlen($file_meta['page_title']) ?> chars)</span></div>
      <?php if (!empty($file_meta['page_desc'])): ?>
      <div><span style="color:var(--muted);width:100px;display:inline-block">Description:</span> <?= h($file_meta['page_desc']) ?> <span style="color:var(--muted);font-size:11px">(<?= strlen($file_meta['page_desc']) ?> chars)</span></div>
      <?php endif ?>
    </div>
    <?php endif ?>

    <div class="form-group">
      <label for="meta_title">Meta Title Override <span>target 50–60 characters</span></label>
      <input type="text" id="meta_title" name="meta_title" value="<?= h($seo['meta_title'] ?? '') ?>"
             data-counter="cnt-title" data-range="50,60" maxlength="120"
             placeholder="<?= h($file_meta['page_title'] ?? 'Enter meta title override…') ?>">
      <div class="char-row">
        <span class="form-hint">Overrides the PHP file value. Leave blank to use the PHP default.</span>
        <span id="cnt-title" class="char-count"></span>
      </div>
    </div>

    <div class="form-group">
      <label for="meta_desc">Meta Description Override <span>target 150–160 characters</span></label>
      <textarea id="meta_desc" name="meta_desc" rows="3"
                data-counter="cnt-desc" data-range="150,160"
                placeholder="<?= h($file_meta['page_desc'] ?? 'Enter meta description override…') ?>"><?= h($seo['meta_desc'] ?? '') ?></textarea>
      <div class="char-row">
        <span class="form-hint">Leave blank to use the PHP default.</span>
        <span id="cnt-desc" class="char-count"></span>
      </div>
    </div>

    <div class="form-grid">
      <div class="form-group">
        <label for="focus_keyword">Focus Keyword</label>
        <input type="text" id="focus_keyword" name="focus_keyword" value="<?= h($seo['focus_keyword'] ?? '') ?>" placeholder="e.g. home care agency miami">
        <div class="form-hint">Primary keyword this page should rank for.</div>
      </div>
      <div class="form-group">
        <label for="secondary_keywords">Secondary Keywords <span>(comma-separated)</span></label>
        <input type="text" id="secondary_keywords" name="secondary_keywords" value="<?= h($seo['secondary_keywords'] ?? '') ?>">
        <div class="form-hint">Supporting keywords and variants.</div>
      </div>
    </div>

    <div class="form-grid">
      <div class="form-group">
        <label for="h1_override">H1 Override</label>
        <input type="text" id="h1_override" name="h1_override" value="<?= h($seo['h1_override'] ?? '') ?>" placeholder="Leave blank to use page default">
        <div class="form-hint">Overrides the page's H1 heading (if the theme supports it).</div>
      </div>
      <div class="form-group">
        <label for="canonical_url">Canonical URL</label>
        <input type="url" id="canonical_url" name="canonical_url" value="<?= h($seo['canonical_url'] ?? SITE_URL . $path) ?>">
        <div class="form-hint">The authoritative URL for this page.</div>
      </div>
    </div>

    <div class="divider"></div>

    <div class="card-title" style="margin-bottom:14px">Robots Meta</div>
    <div style="display:flex;gap:32px;flex-wrap:wrap">
      <div class="toggle-group">
        <label class="toggle">
          <input type="checkbox" name="robots_index" id="robots_index" <?= ($seo['robots_index'] ?? 1) ? 'checked' : '' ?>>
          <span class="toggle-slider"></span>
        </label>
        <div>
          <div class="toggle-label">Index this page</div>
          <div class="form-hint">Allow Google to index this page</div>
        </div>
      </div>
      <div class="toggle-group">
        <label class="toggle">
          <input type="checkbox" name="robots_follow" id="robots_follow" <?= ($seo['robots_follow'] ?? 1) ? 'checked' : '' ?>>
          <span class="toggle-slider"></span>
        </label>
        <div>
          <div class="toggle-label">Follow links</div>
          <div class="form-hint">Allow Google to follow links on this page</div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- TAB: Social -->
<div id="tab-social" class="tab-panel">
  <div class="card">
    <div class="card-header"><div class="card-title">Open Graph (Facebook / LinkedIn)</div></div>
    <div class="form-group">
      <label for="og_title">OG Title</label>
      <input type="text" id="og_title" name="og_title" value="<?= h($seo['og_title'] ?? '') ?>" placeholder="Defaults to meta title if blank">
    </div>
    <div class="form-group">
      <label for="og_desc">OG Description</label>
      <textarea name="og_desc" rows="2"><?= h($seo['og_desc'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
      <label for="og_image">OG Image URL</label>
      <input type="url" id="og_image" name="og_image" value="<?= h($seo['og_image'] ?? '') ?>" placeholder="https://homecarecreators.com/assets/og-image.jpg">
      <div class="form-hint">Recommended: 1200×630px. Shown when shared on social media.</div>
    </div>
  </div>
  <div class="card">
    <div class="card-header"><div class="card-title">Twitter / X Card</div></div>
    <div class="form-group">
      <label for="twitter_card">Card Type</label>
      <select id="twitter_card" name="twitter_card">
        <option value="summary_large_image" <?= ($seo['twitter_card']??'summary_large_image')==='summary_large_image'?'selected':'' ?>>Summary Large Image (recommended)</option>
        <option value="summary" <?= ($seo['twitter_card']??'')==='summary'?'selected':'' ?>>Summary</option>
      </select>
    </div>
    <div class="form-grid">
      <div class="form-group">
        <label>Twitter Title</label>
        <input type="text" name="twitter_title" value="<?= h($seo['twitter_title'] ?? '') ?>" placeholder="Defaults to meta title">
      </div>
      <div class="form-group">
        <label>Twitter Image URL</label>
        <input type="url" name="twitter_image" value="<?= h($seo['twitter_image'] ?? '') ?>">
      </div>
    </div>
    <div class="form-group">
      <label>Twitter Description</label>
      <textarea name="twitter_desc" rows="2"><?= h($seo['twitter_desc'] ?? '') ?></textarea>
    </div>
  </div>
</div>

<!-- TAB: Schema -->
<div id="tab-schema" class="tab-panel">
  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Schema / Structured Data</div>
        <div class="card-sub">Manage LD+JSON schema blocks for this page</div>
      </div>
      <a href="/admin/schema/?path=<?= urlencode($path) ?>" class="btn btn-primary btn-sm">Manage Schema</a>
    </div>
    <p style="color:var(--muted);font-size:13px">
      Click "Manage Schema" to add LocalBusiness, Service, FAQ, Review, BreadcrumbList, or Article schema blocks for this page.
      Schema is injected automatically into the page's &lt;head&gt; when the DB override is active.
    </p>
  </div>
</div>

<div style="display:flex;gap:12px;margin-top:4px">
  <button type="submit" class="btn btn-primary btn-lg">Save SEO Settings</button>
  <a href="/admin/seo-pages.php" class="btn btn-secondary btn-lg">Cancel</a>
</div>

</form>
</div>
<?php hc_foot(); ?>
