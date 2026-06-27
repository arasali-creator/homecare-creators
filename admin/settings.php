<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

// Ensure hc_settings table exists
try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_settings (
        setting_key VARCHAR(100) PRIMARY KEY,
        setting_value TEXT,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $keys = ['notification_email','notification_cc','site_name','reply_to_email'];
    foreach ($keys as $k) {
        $val = trim($_POST[$k] ?? '');
        try { hc_setting_save($k, $val); } catch(Exception $e){}
    }
    hc_flash('Settings saved.');
    header('Location: /admin/settings.php');
    exit;
}

hc_head('Settings');
hc_topbar('Settings', '<a href="/admin/">Admin</a> › Settings');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<form method="POST">

<!-- Form Notifications -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Form Notifications</div>
      <div class="card-sub">Where enquiry form submissions are emailed</div>
    </div>
  </div>

  <div class="form-grid">
    <div class="form-group">
      <label for="notification_email">Notification Email <span>(required)</span></label>
      <input type="email" id="notification_email" name="notification_email"
             value="<?= h(hc_setting('notification_email','info@homecarecreators.com')) ?>"
             placeholder="info@homecarecreators.com">
      <div class="form-hint">All form submissions are sent to this address. Make sure it's correct or you'll miss leads.</div>
    </div>
    <div class="form-group">
      <label for="notification_cc">CC Email <span>(optional)</span></label>
      <input type="email" id="notification_cc" name="notification_cc"
             value="<?= h(hc_setting('notification_cc','')) ?>"
             placeholder="team@youragency.com">
      <div class="form-hint">Optional second address to CC on every submission.</div>
    </div>
  </div>

  <div class="form-grid">
    <div class="form-group">
      <label for="reply_to_email">Reply-To Email</label>
      <input type="email" id="reply_to_email" name="reply_to_email"
             value="<?= h(hc_setting('reply_to_email','noreply@homecarecreators.com')) ?>"
             placeholder="noreply@homecarecreators.com">
      <div class="form-hint">The From/Reply-To address on outgoing notification emails.</div>
    </div>
    <div class="form-group">
      <label for="site_name">Site Name</label>
      <input type="text" id="site_name" name="site_name"
             value="<?= h(hc_setting('site_name','Homecare Creators')) ?>">
      <div class="form-hint">Used in email subject lines and signatures.</div>
    </div>
  </div>
</div>

<!-- Test section -->
<div class="card">
  <div class="card-header">
    <div class="card-title">Test Email Delivery</div>
  </div>
  <p style="font-size:13px;color:var(--muted);margin-bottom:14px">
    Submit the contact form on the live site to test delivery. Check spam folders if emails don't arrive —
    most VPS setups need an SMTP relay (Mailgun, SendGrid, or Postmark) for reliable delivery.<br><br>
    On Bluehost/CloudPanel, PHP <code>mail()</code> may work out of the box via the server's local MTA.
    If emails consistently fail, configure an SMTP plugin or ask your host.
  </p>

  <div style="background:var(--cream);border-radius:10px;padding:16px 20px;font-size:13px;line-height:1.8">
    <strong>Current delivery path:</strong><br>
    form-handler.php → PHP <code>mail()</code> →
    <code><?= h(hc_setting('notification_email','info@homecarecreators.com')) ?></code>
    <?php if (hc_setting('notification_cc')): ?>
      + CC <code><?= h(hc_setting('notification_cc')) ?></code>
    <?php endif ?>
  </div>
</div>

<div style="display:flex;gap:12px;margin-top:4px">
  <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>
</div>

</form>
</div>
<?php hc_foot(); ?>
