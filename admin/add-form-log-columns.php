<?php
// ================================================================
//  Form Log Column Migration — Homecare Creators
//  Visit /admin/add-form-log-columns.php?run=1  to execute.
//  DELETE THIS FILE after running!
//
//  Adds source_page, user_agent, device_type, geo_city, geo_region,
//  geo_country to hc_form_submissions so every lead capture records
//  which page it came from, the visitor's IP-based location, and
//  their browser/device. Safe to re-run — checks information_schema
//  before adding each column, skips ones that already exist.
// ================================================================
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
hc_require_auth();

$run = isset($_GET['run']);
$log = [];

$columns = [
    'source_page'  => "VARCHAR(255) NULL",
    'user_agent'   => "TEXT NULL",
    'device_type'  => "VARCHAR(20) NULL",
    'geo_city'     => "VARCHAR(100) NULL",
    'geo_region'   => "VARCHAR(100) NULL",
    'geo_country'  => "VARCHAR(100) NULL",
];

if ($run) {
    foreach ($columns as $col => $def) {
        $exists = hc_one("SELECT COUNT(*) AS c FROM information_schema.columns WHERE table_schema = DATABASE() AND table_name = 'hc_form_submissions' AND column_name = ?", [$col]);
        if ($exists && (int)$exists['c'] > 0) {
            $log[] = "– {$col} already exists, skipped";
            continue;
        }
        try {
            hc_q("ALTER TABLE hc_form_submissions ADD COLUMN {$col} {$def}");
            $log[] = "✓ Added column: {$col} {$def}";
        } catch (Exception $e) {
            $log[] = "✗ Failed to add {$col}: " . $e->getMessage();
        }
    }
    $total = count($log);
}
?><!doctype html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Form Log Migration — Homecare Creators Admin</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0a2e1e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
.card{background:#fff;border-radius:16px;padding:36px 40px;max-width:640px;width:100%}
h1{font-size:22px;font-weight:800;color:#0a2e1e;margin-bottom:8px}
p{font-size:14px;color:#6b7280;margin-bottom:16px;line-height:1.75}
strong{color:#0a2e1e}
.log{background:#f3f4f6;border-radius:10px;padding:16px 20px;max-height:360px;overflow-y:auto;font-size:12px;font-family:monospace;line-height:2}
.log div{color:#1a5c3a}
.btn{display:inline-block;padding:13px 28px;background:#1d9e75;color:#fff;border-radius:9px;text-decoration:none;font-weight:700;font-size:15px;margin-top:16px;margin-right:8px}
.btn-outline{background:#fff;color:#1d9e75;border:2px solid #1d9e75}
.warn{background:#fff1f2;border:2px solid #fca5a5;border-radius:10px;padding:14px 18px;margin-top:20px;color:#7f1d1d;font-size:13px;line-height:1.9}
.count{font-size:34px;font-weight:900;color:#1d9e75;display:block;margin-bottom:4px}
code{background:#f3f4f6;padding:2px 7px;border-radius:4px;font-size:11.5px;word-break:break-all}
</style></head><body>
<div class="card">
<h1>Form Log Column Migration</h1>
<?php if (!$run): ?>
<p>Adds 6 columns to <strong>hc_form_submissions</strong> so every future form submission records the source page, IP-based location, and browser/device — safe to re-run, skips columns that already exist:</p>
<ul style="margin:0 0 16px 20px;font-size:13px;color:#374151;line-height:1.9">
  <li><code>source_page</code> — which page the lead submitted from</li>
  <li><code>user_agent</code> — raw browser/OS string</li>
  <li><code>device_type</code> — Desktop / Mobile / Tablet</li>
  <li><code>geo_city</code>, <code>geo_region</code>, <code>geo_country</code> — from IP lookup</li>
</ul>
<a href="?run=1" class="btn">&#9654; Run Migration</a>
<a href="/admin/form-log.php" class="btn btn-outline">View Form Log</a>
<?php else: ?>
<span class="count"><?= $total ?></span>
<p><strong>Migration complete.</strong></p>
<div class="log">
  <?php foreach ($log as $l): ?><div><?= htmlspecialchars($l) ?></div><?php endforeach ?>
</div>
<div class="warn">
  <strong>Security: delete this file after running.</strong>
</div>
<a href="/admin/form-log.php" class="btn" style="margin-top:20px">View Form Log &#8594;</a>
<?php endif ?>
</div>
</body></html>
