<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach ($_POST['field'] ?? [] as $key => $value) {
        hc_q("INSERT INTO hc_entity (field_key,field_value) VALUES (?,?) ON DUPLICATE KEY UPDATE field_value=VALUES(field_value)",
            [$key, trim($value)]);
    }
    hc_flash('Entity data saved.');
    header('Location: /admin/ai-geo/entity.php');
    exit;
}

$fields = hc_all("SELECT * FROM hc_entity ORDER BY field_key");
$data   = [];
foreach ($fields as $f) $data[$f['field_key']] = $f['field_value'];

$schema = [
    'Core Identity'    => ['business_name','business_description','business_type','specialty','founded_year'],
    'Contact & NAP'    => ['phone','email','address','city','state','zip'],
    'Service Coverage' => ['service_area','target_audience','geographic_focus'],
    'AI-Targeted Copy' => ['ai_description','ai_services_summary','ai_differentiator'],
];

hc_head('Entity Data');
hc_topbar('Entity Data', '<a href="/admin/">Admin</a> › AI / GEO Panel › Entity Data');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div>
    <h1>Entity Data</h1>
    <div class="sub">Structured business data used for AI systems (ChatGPT, Perplexity, Gemini), Knowledge Graph, and schema generation.</div>
  </div>
</div>

<div class="alert alert-info">
  <strong>Why this matters:</strong> AI search engines like Perplexity and Google AI Overviews pull structured entity data to answer questions like "Who is Homecare Creators?" Filling this out completely improves your GEO (Generative Engine Optimisation) visibility.
</div>

<form method="POST">
<?php foreach ($schema as $section => $keys): ?>
<div class="card">
  <div class="card-title" style="margin-bottom:16px"><?= $section ?></div>
  <?php foreach ($keys as $key): ?>
  <div class="form-group">
    <label><?= ucwords(str_replace('_',' ',$key)) ?></label>
    <?php if (in_array($key,['business_description','ai_description','ai_services_summary','ai_differentiator'])): ?>
    <textarea name="field[<?= $key ?>]" rows="3"><?= h($data[$key] ?? '') ?></textarea>
    <?php else: ?>
    <input type="text" name="field[<?= $key ?>]" value="<?= h($data[$key] ?? '') ?>">
    <?php endif ?>
  </div>
  <?php endforeach ?>
</div>
<?php endforeach ?>

<button class="btn btn-primary btn-lg" type="submit">Save Entity Data</button>
</form>

</div>
<?php hc_foot(); ?>
