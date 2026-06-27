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
    hc_flash('E-E-A-T signals saved.');
    header('Location: /admin/ai-geo/eeat.php');
    exit;
}

$fields = hc_all("SELECT * FROM hc_entity WHERE field_key LIKE 'eeat_%'");
$data   = [];
foreach ($fields as $f) $data[$f['field_key']] = $f['field_value'];

hc_head('E-E-A-T Signals');
hc_topbar('E-E-A-T Signals', '<a href="/admin/">Admin</a> › AI / GEO Panel › E-E-A-T');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>E-E-A-T Signals</h1><div class="sub">Experience, Expertise, Authoritativeness, Trustworthiness — Google's quality framework for ranking content.</div></div>
</div>

<div class="alert alert-info">
  <strong>E-E-A-T is especially critical for healthcare-adjacent businesses.</strong> Fill out each section fully. These signals are referenced by schema generation, blog authorship, and AI GEO content.
</div>

<form method="POST">

<div class="card">
  <div class="card-title" style="margin-bottom:4px">Experience</div>
  <div class="card-sub" style="margin-bottom:16px">Real-world experience in the industry — personal involvement, not just knowledge.</div>
  <div class="form-group"><label>Years in homecare marketing industry</label><input type="text" name="field[eeat_experience_years]" value="<?= h($data['eeat_experience_years']??'') ?>" placeholder="e.g. 5+ years"></div>
  <div class="form-group"><label>Direct experience with homecare agencies</label><textarea name="field[eeat_experience_direct]" rows="2"><?= h($data['eeat_experience_direct']??'') ?></textarea><div class="form-hint">Describe how you've worked hands-on in or with homecare agencies.</div></div>
  <div class="form-group"><label>Case studies or results achieved</label><textarea name="field[eeat_experience_results]" rows="2"><?= h($data['eeat_experience_results']??'') ?></textarea></div>
</div>

<div class="card">
  <div class="card-title" style="margin-bottom:4px">Expertise</div>
  <div class="card-sub" style="margin-bottom:16px">Formal knowledge, credentials, and specialisation.</div>
  <div class="form-group"><label>Founder / Lead Expert Name</label><input type="text" name="field[eeat_expert_name]" value="<?= h($data['eeat_expert_name']??'') ?>"></div>
  <div class="form-group"><label>Expert Bio (for schema and author pages)</label><textarea name="field[eeat_expert_bio]" rows="3"><?= h($data['eeat_expert_bio']??'') ?></textarea></div>
  <div class="form-group"><label>Credentials / Certifications</label><input type="text" name="field[eeat_credentials]" value="<?= h($data['eeat_credentials']??'') ?>" placeholder="e.g. Google Partner, HubSpot Certified, etc."></div>
  <div class="form-group"><label>Areas of Specialisation</label><input type="text" name="field[eeat_specialisation]" value="<?= h($data['eeat_specialisation']??'') ?>" placeholder="e.g. Local SEO, homecare agency marketing, Google Business Profile"></div>
</div>

<div class="card">
  <div class="card-title" style="margin-bottom:4px">Authoritativeness</div>
  <div class="card-sub" style="margin-bottom:16px">External recognition — mentions, links, speaking, press.</div>
  <div class="form-group"><label>Publications / Media Mentions</label><textarea name="field[eeat_authority_mentions]" rows="2"><?= h($data['eeat_authority_mentions']??'') ?></textarea></div>
  <div class="form-group"><label>Industry Associations / Memberships</label><input type="text" name="field[eeat_authority_memberships]" value="<?= h($data['eeat_authority_memberships']??'') ?>" placeholder="e.g. HCAOA, HomeCare Association of Florida"></div>
  <div class="form-group"><label>Awards / Recognition</label><input type="text" name="field[eeat_authority_awards]" value="<?= h($data['eeat_authority_awards']??'') ?>"></div>
</div>

<div class="card">
  <div class="card-title" style="margin-bottom:4px">Trustworthiness</div>
  <div class="card-sub" style="margin-bottom:16px">Transparency signals that make visitors and AI trust you.</div>
  <div class="form-group"><label>Privacy Policy URL</label><input type="url" name="field[eeat_trust_privacy]" value="<?= h($data['eeat_trust_privacy']??SITE_URL.'/privacy-policy') ?>"></div>
  <div class="form-group"><label>Terms of Service URL</label><input type="url" name="field[eeat_trust_terms]" value="<?= h($data['eeat_trust_terms']??SITE_URL.'/terms-of-service') ?>"></div>
  <div class="form-group"><label>Guarantees / Commitments offered to clients</label><textarea name="field[eeat_trust_guarantees]" rows="2"><?= h($data['eeat_trust_guarantees']??'') ?></textarea></div>
  <div class="form-group"><label>Contact information visibility statement</label><input type="text" name="field[eeat_trust_contact]" value="<?= h($data['eeat_trust_contact']??'') ?>" placeholder="e.g. Reachable by email and phone, based in Florida"></div>
</div>

<button class="btn btn-primary btn-lg" type="submit">Save E-E-A-T Signals</button>
</form>

</div>
<?php hc_foot(); ?>
