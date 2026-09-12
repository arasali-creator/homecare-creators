<?php
// ================================================================
//  Organization Schema Seeder — Homecare Creators
//  Visit /admin/seed-org-schema.php?run=1  to execute.
//  DELETE THIS FILE after running!
//
//  Populates hc_org_schema + hc_kg_links so the sitewide
//  Organization block in includes/header.php actually renders
//  (it silently no-ops until org_name is set). Safe to re-run —
//  uses ON DUPLICATE KEY / INSERT IGNORE, doesn't touch other data.
// ================================================================
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
hc_require_auth();

$run = isset($_GET['run']);
$log = [];

if ($run) {
    hc_q("CREATE TABLE IF NOT EXISTS hc_org_schema (
        id INT PRIMARY KEY AUTO_INCREMENT,
        field_key VARCHAR(100) NOT NULL UNIQUE,
        field_value TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

    $fields = [
        'org_name'    => 'Homecare Creators',
        'org_type'    => 'MarketingAgency',
        'org_desc'    => 'Homecare Creators is a digital marketing agency built exclusively for home care agencies in Florida — local SEO, Google Maps optimization, website design, and AI search visibility.',
        'org_phone'   => '+1-409-419-3533',
        'org_email'   => 'info@homecarecreators.com',
        'org_logo'    => 'https://homecarecreators.com/images/home/homecarecreators-logo.png',
        'org_founded' => '2026',
        'org_address' => '',
        'org_city'    => 'Lady Lake',
        'org_state'   => 'FL',
        'org_zip'     => '32159',
        'org_area'    => 'Florida',
    ];
    foreach ($fields as $key => $value) {
        hc_q("INSERT INTO hc_org_schema (field_key,field_value) VALUES (?,?) ON DUPLICATE KEY UPDATE field_value=VALUES(field_value)", [$key, $value]);
        $log[] = "✓ hc_org_schema.{$key} = " . ($value !== '' ? $value : '(empty)');
    }

    $kg_links = [
        'LinkedIn (Company)' => 'https://www.linkedin.com/company/homecare-creators/',
        'LinkedIn (Founder — Asifa Rani)' => 'https://www.linkedin.com/in/asifa-rani/',
    ];
    foreach ($kg_links as $platform => $url) {
        hc_q("INSERT IGNORE INTO hc_kg_links (platform,url) VALUES (?,?)", [$platform, $url]);
        $log[] = "✓ hc_kg_links: {$platform} → {$url}";
    }

    $total = count($log);
}
?><!doctype html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Org Schema Seeder — Homecare Creators Admin</title>
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0a2e1e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:24px}
.card{background:#fff;border-radius:16px;padding:36px 40px;max-width:640px;width:100%}
h1{font-size:22px;font-weight:800;color:#0a2e1e;margin-bottom:8px}
p{font-size:14px;color:#6b7280;margin-bottom:16px;line-height:1.75}
strong{color:#0a2e1e}
.log{background:#f3f4f6;border-radius:10px;padding:16px 20px;max-height:420px;overflow-y:auto;font-size:12px;font-family:monospace;line-height:2}
.log div{color:#1a5c3a}
.btn{display:inline-block;padding:13px 28px;background:#1d9e75;color:#fff;border-radius:9px;text-decoration:none;font-weight:700;font-size:15px;margin-top:16px;margin-right:8px}
.btn-outline{background:#fff;color:#1d9e75;border:2px solid #1d9e75}
.warn{background:#fff1f2;border:2px solid #fca5a5;border-radius:10px;padding:14px 18px;margin-top:20px;color:#7f1d1d;font-size:13px;line-height:1.9}
.count{font-size:34px;font-weight:900;color:#1d9e75;display:block;margin-bottom:4px}
code{background:#f3f4f6;padding:2px 7px;border-radius:4px;font-size:11.5px;word-break:break-all}
</style></head><body>
<div class="card">
<h1>Organization Schema Seeder</h1>
<?php if (!$run): ?>
<p>Populates <strong>hc_org_schema</strong> (business identity, phone, address) and <strong>hc_kg_links</strong> (LinkedIn) with real values, so the sitewide Organization JSON-LD block in <code>includes/header.php</code> starts rendering on every page. It currently no-ops silently because these tables are empty. Safe to re-run.</p>
<a href="?run=1" class="btn">&#9654; Run Seeder</a>
<a href="/admin/org-schema.php" class="btn btn-outline">View Organization Schema Page</a>
<?php else: ?>
<span class="count"><?= $total ?></span>
<p><strong><?= $total ?> fields</strong> written successfully.</p>
<div class="log">
  <?php foreach ($log as $l): ?><div><?= htmlspecialchars($l) ?></div><?php endforeach ?>
</div>
<div class="warn">
  <strong>Security: delete this file after running.</strong> Also review/edit the values anytime at <code>/admin/org-schema.php</code>.
</div>
<a href="/admin/org-schema.php" class="btn" style="margin-top:20px">Review in Organization Schema Page &#8594;</a>
<?php endif ?>
</div>
</body></html>
