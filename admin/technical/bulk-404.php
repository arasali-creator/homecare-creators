<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$created = 0;
$skipped = 0;
$errors  = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $mode        = $_POST['mode'] ?? 'single';
    $destination = trim($_POST['destination'] ?? '');
    $raw         = trim($_POST['urls'] ?? '');
    $code        = (int)($_POST['code'] ?? 301);
    $lines       = array_filter(array_map('trim', explode("\n", $raw)));

    foreach ($lines as $line) {
        $line = rtrim($line, "\r");
        if (!$line) continue;

        if ($mode === 'pairs') {
            // Format: /old-path, /new-path  OR  /old-path  /new-path
            $parts = preg_split('/[\t,]+/', $line, 2);
            $src   = trim($parts[0] ?? '');
            $dst   = trim($parts[1] ?? '');
        } else {
            $src = $line;
            $dst = $destination;
        }

        // Normalise source — must start with /
        if (!$src) continue;
        if (!str_starts_with($src, '/')) $src = '/' . $src;
        // Strip domain if pasted as full URL
        $src = preg_replace('#^https?://[^/]+#', '', $src);
        $src = strtok($src, '?'); // remove query string

        if (!$dst) { $errors[] = "No destination for: {$src}"; continue; }

        // Destination: allow full URL or path
        if (!str_starts_with($dst, 'http') && !str_starts_with($dst, '/')) {
            $dst = '/' . $dst;
        }

        try {
            $existing = hc_val("SELECT id FROM hc_redirects WHERE source_path=?", [$src]);
            if ($existing) { $skipped++; continue; }
            hc_q("INSERT INTO hc_redirects (source_path, destination_url, code, active) VALUES (?,?,?,1)",
                [$src, $dst, $code]);
            $created++;
        } catch (Exception $e) {
            $errors[] = $src . ': ' . $e->getMessage();
        }
    }

    if ($created || $skipped) {
        hc_flash("{$created} redirect(s) created" . ($skipped ? ", {$skipped} skipped (already exist)" : "") . ".");
    }
    if ($errors) {
        hc_flash(count($errors) . ' error(s): ' . implode(' | ', array_slice($errors, 0, 5)), 'error');
    }
    header('Location: /admin/technical/bulk-404.php');
    exit;
}

// Recent redirects
$recent = hc_all("SELECT * FROM hc_redirects ORDER BY id DESC LIMIT 50");

hc_head('Bulk 404 Fix');
hc_topbar('Bulk 404 Fix', '<a href="/admin/">Admin</a> › <a href="/admin/technical/redirects.php">Technical SEO</a> › Bulk 404 Fix');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div style="display:grid;grid-template-columns:1fr 1fr;gap:20px;align-items:start">

<!-- Mode A: many → one -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Redirect Many Pages → One URL</div>
      <div class="card-sub">Paste 404 URLs (one per line), all go to the same destination</div>
    </div>
  </div>
  <form method="POST">
    <input type="hidden" name="mode" value="single">
    <div class="form-group">
      <label>404 URLs to Fix <span>(one per line — path or full URL)</span></label>
      <textarea name="urls" rows="10" placeholder="/old-page-1&#10;/old-page-2&#10;https://homecarecreators.com/old-page-3&#10;/blog/old-article" style="font-family:monospace;font-size:12px"></textarea>
    </div>
    <div class="form-group">
      <label>Redirect All To</label>
      <input type="text" name="destination" placeholder="/ or /services or https://homecarecreators.com/new-page">
      <div class="form-hint">Path or full URL. All pasted URLs will redirect here.</div>
    </div>
    <div class="form-group">
      <label>Redirect Type</label>
      <select name="code">
        <option value="301">301 — Permanent (recommended for dead pages)</option>
        <option value="302">302 — Temporary</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Create Redirects</button>
  </form>
</div>

<!-- Mode B: pairs -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Redirect Pairs (source → destination)</div>
      <div class="card-sub">Each line maps one old URL to its specific new URL</div>
    </div>
  </div>
  <form method="POST">
    <input type="hidden" name="mode" value="pairs">
    <div class="form-group">
      <label>Source → Destination Pairs</label>
      <textarea name="urls" rows="10" placeholder="/old-service-page, /services&#10;/about-us-old, /about&#10;/blog/2023/post-title, /blog/post-title&#10;/miami-home-care, /Marketing/home-care-miami-fl" style="font-family:monospace;font-size:12px"></textarea>
      <div class="form-hint">One pair per line. Separate source and destination with a comma or tab.</div>
    </div>
    <div class="form-group">
      <label>Redirect Type</label>
      <select name="code">
        <option value="301">301 — Permanent</option>
        <option value="302">302 — Temporary</option>
      </select>
    </div>
    <button type="submit" class="btn btn-primary">Create Redirects</button>
  </form>
</div>

</div>

<!-- Hint box -->
<div style="background:var(--cream);border:1px solid var(--border);border-radius:12px;padding:18px 22px;margin:20px 0;font-size:13px;line-height:1.9">
  <strong>How to find your 404 errors:</strong><br>
  · <strong>Google Search Console</strong> → Pages → Not found (404) — most reliable source<br>
  · <strong>Ahrefs / Semrush</strong> → Site Audit → 4xx errors<br>
  · <strong>Server logs</strong>: <code>grep " 404 " /var/log/nginx/access.log | awk '{print $7}' | sort | uniq -c | sort -rn | head -50</code>
</div>

<!-- Active redirects table -->
<div class="card">
  <div class="card-header">
    <div class="card-title">All Active Redirects <span style="font-weight:400;color:var(--muted)">(<?= count($recent) ?>)</span></div>
    <a href="/admin/technical/redirects.php" class="btn btn-secondary btn-sm">Manage All →</a>
  </div>
  <?php if ($recent): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Source Path</th><th>→ Destination</th><th>Code</th><th>Hits</th><th>Status</th></tr></thead>
      <tbody>
      <?php foreach ($recent as $r): ?>
      <tr>
        <td class="td-path" style="font-size:12px"><?= h($r['source_path']) ?></td>
        <td style="font-size:12px;color:var(--teal);max-width:260px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap"><?= h($r['destination_url']) ?></td>
        <td><span class="badge <?= $r['code']==301?'badge-green':'badge-gray' ?>"><?= $r['code'] ?></span></td>
        <td style="font-size:12px;color:var(--muted)"><?= (int)$r['hits'] ?></td>
        <td><span class="badge <?= $r['active']?'badge-green':'badge-gray' ?>"><?= $r['active']?'Active':'Off' ?></span></td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state"><p>No redirects yet.</p></div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
