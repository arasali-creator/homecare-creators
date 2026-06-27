<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

// Ensure table exists
try {
    hc_q("CREATE TABLE IF NOT EXISTS hc_org_schema (
        id INT PRIMARY KEY AUTO_INCREMENT,
        field_key VARCHAR(100) NOT NULL UNIQUE,
        field_value TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['field'] ?? [] as $key => $value) {
        hc_q("INSERT INTO hc_org_schema (field_key,field_value) VALUES (?,?) ON DUPLICATE KEY UPDATE field_value=VALUES(field_value)",
            [$key, trim($value)]);
    }
    hc_flash('Organization schema saved.');
    header('Location: /admin/org-schema.php');
    exit;
}

$fields = hc_all("SELECT * FROM hc_org_schema");
$data   = [];
foreach ($fields as $f) $data[$f['field_key']] = $f['field_value'];

// Pull sameAs links
$same_as = array_column(hc_all("SELECT url FROM hc_kg_links ORDER BY platform"), 'url');

// Build preview JSON
$org_json = array_filter([
    '@context'    => 'https://schema.org',
    '@type'       => $data['org_type'] ?? 'LocalBusiness',
    'name'        => $data['org_name'] ?? 'Homecare Creators',
    'description' => $data['org_desc'] ?? '',
    'url'         => SITE_URL,
    'logo'        => $data['org_logo'] ?? '',
    'telephone'   => $data['org_phone'] ?? '',
    'email'       => $data['org_email'] ?? '',
    'address'     => array_filter(['@type'=>'PostalAddress','streetAddress'=>$data['org_address']??'','addressLocality'=>$data['org_city']??'','addressRegion'=>$data['org_state']??'','postalCode'=>$data['org_zip']??'','addressCountry'=>'US']),
    'areaServed'  => $data['org_area'] ?? 'Florida',
    'sameAs'      => $same_as ?: null,
]);

hc_head('Organization Schema');
hc_topbar('Organization Schema', '<a href="/admin/">Admin</a> › Schema › Organization');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Organization Schema</h1><div class="sub">Global schema injected into every page's &lt;head&gt;. Tells Google the core identity of your business.</div></div>
</div>

<div style="display:grid;grid-template-columns:1fr 380px;gap:20px;align-items:start">

<form method="POST">
<div class="card">
  <div class="card-title" style="margin-bottom:16px">Business Identity</div>
  <div class="form-grid">
    <div class="form-group"><label>Organization Name</label><input type="text" name="field[org_name]" value="<?= h($data['org_name']??'Homecare Creators') ?>"></div>
    <div class="form-group"><label>Schema Type</label>
      <select name="field[org_type]">
        <option value="LocalBusiness" <?= ($data['org_type']??'')!=='ProfessionalService'?'selected':'' ?>>LocalBusiness</option>
        <option value="ProfessionalService" <?= ($data['org_type']??'')==='ProfessionalService'?'selected':'' ?>>ProfessionalService</option>
        <option value="MarketingAgency" <?= ($data['org_type']??'')==='MarketingAgency'?'selected':'' ?>>MarketingAgency</option>
      </select>
    </div>
  </div>
  <div class="form-group"><label>Description</label><textarea name="field[org_desc]" rows="3"><?= h($data['org_desc']??'') ?></textarea></div>
  <div class="form-grid">
    <div class="form-group"><label>Phone</label><input type="text" name="field[org_phone]" value="<?= h($data['org_phone']??'') ?>" placeholder="+1-555-000-0000"></div>
    <div class="form-group"><label>Email</label><input type="email" name="field[org_email]" value="<?= h($data['org_email']??'info@homecarecreators.com') ?>"></div>
    <div class="form-group"><label>Logo URL</label><input type="url" name="field[org_logo]" value="<?= h($data['org_logo']??'') ?>"></div>
    <div class="form-group"><label>Founded Year</label><input type="text" name="field[org_founded]" value="<?= h($data['org_founded']??'') ?>"></div>
  </div>
</div>

<div class="card">
  <div class="card-title" style="margin-bottom:16px">Address & Coverage</div>
  <div class="form-group"><label>Street Address</label><input type="text" name="field[org_address]" value="<?= h($data['org_address']??'') ?>"></div>
  <div class="form-grid">
    <div class="form-group"><label>City</label><input type="text" name="field[org_city]" value="<?= h($data['org_city']??'') ?>"></div>
    <div class="form-group"><label>State</label><input type="text" name="field[org_state]" value="<?= h($data['org_state']??'FL') ?>"></div>
    <div class="form-group"><label>ZIP</label><input type="text" name="field[org_zip]" value="<?= h($data['org_zip']??'') ?>"></div>
  </div>
  <div class="form-group"><label>Area Served</label><input type="text" name="field[org_area]" value="<?= h($data['org_area']??'Florida') ?>" placeholder="Florida, Miami, Tampa..."></div>
</div>

<div style="display:flex;gap:12px;align-items:center">
  <button class="btn btn-primary btn-lg" type="submit">Save Organization Schema</button>
  <a href="/admin/ai-geo/knowledge-graph.php" class="btn btn-secondary">+ Add sameAs Links</a>
</div>
</form>

<!-- Preview -->
<div class="card" style="position:sticky;top:70px">
  <div class="card-title" style="margin-bottom:14px">Schema Preview (LD+JSON)</div>
  <pre style="background:#0a2e1e;color:#7dffc1;padding:16px;border-radius:8px;font-size:11.5px;overflow-x:auto;line-height:1.6;white-space:pre-wrap;word-break:break-word"><?= h(json_encode($org_json, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)) ?></pre>
  <div class="form-hint" style="margin-top:8px">This block is automatically injected via includes/header.php when SEO override is active.</div>
</div>

</div>

</div>
<?php hc_foot(); ?>
