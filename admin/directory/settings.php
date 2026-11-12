<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/directory.php';
hc_require_auth();
hc_dir_ensure_schema();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    foreach (['dir_price_premium', 'dir_price_featured'] as $k) {
        hc_setting_save($k, (string)max(0, (int)($_POST[$k] ?? 0)));
    }
    hc_flash('Pricing saved.');
    header('Location: /admin/directory/settings.php'); exit;
}

$plans = hc_dir_plans();
hc_head('Directory Plans');
hc_topbar('Directory Plans', '<a href="/admin/">Admin</a> › <a href="/admin/directory/">Directory</a> › Plans');
?>
<div class="page-content">
<?= hc_show_flash() ?>
<div class="page-header"><div><h1>Plans &amp; pricing</h1><div class="sub">Monthly prices shown on /directory/ and the submit form. Paid plans are invoiced manually.</div></div></div>

<form method="POST" style="max-width:720px">
  <div class="card">
    <div class="form-grid">
      <div class="form-group"><label>Premium: $ per month</label><input type="number" min="0" name="dir_price_premium" value="<?= (int)$plans['premium']['price'] ?>"></div>
      <div class="form-group"><label>Featured: $ per month</label><input type="number" min="0" name="dir_price_featured" value="<?= (int)$plans['featured']['price'] ?>"></div>
    </div>
    <button class="btn btn-primary">Save pricing</button>
  </div>
</form>

<div class="card" style="max-width:720px">
  <div class="card-title" style="margin-bottom:10px">How billing works</div>
  <ol style="font-size:13.5px;line-height:1.8;padding-left:18px;margin:0;color:var(--text)">
    <li>An agency submits (or claims) a listing and picks Premium or Featured. Its billing status is set to <span class="badge badge-red">Invoice to send</span>.</li>
    <li>The owner confirms by email, and you get a notification. The dashboard shows “Directory invoices to send.”</li>
    <li>Send the invoice from your billing tool, then click <strong>Mark invoiced</strong> in the Directory → Billing view.</li>
    <li>When they pay, click <strong>Mark paid</strong>. That activates the plan for one month (Renew adds another month). You can also set any “paid until” date on the edit page.</li>
    <li>If “paid until” passes without renewal, the listing automatically drops back to Basic. Its data isn't deleted.</li>
  </ol>
</div>
</div>
<?php hc_foot(); ?>
