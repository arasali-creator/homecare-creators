<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/mailer.php';
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

// Handle test WhatsApp
if (isset($_POST['action']) && $_POST['action'] === 'test_whatsapp') {
    $sent = hc_whatsapp_notify("✅ Test message from Homecare Creators admin. WhatsApp notifications are working!");
    hc_flash($sent ? 'Test WhatsApp sent — check your phone.' : 'Failed — check your phone number and API key.', $sent ? 'success' : 'error');
    header('Location: /admin/settings.php');
    exit;
}

// Handle test email
if (isset($_POST['action']) && $_POST['action'] === 'test_email') {
    $testTo = trim($_POST['test_to'] ?? hc_setting('notification_email','info@homecarecreators.com'));
    $sent   = HcMailer::send(
        $testTo,
        'Test Email — Homecare Creators Admin',
        "This is a test email from your Homecare Creators admin panel.\n\nIf you received this, your email delivery is working correctly.\n\nSMTP Host: " . hc_setting('smtp_host','(none — using PHP mail())'),
        '',''
    );
    if ($sent) {
        hc_flash("Test email sent to {$testTo} — check your inbox (and spam folder).", 'success');
    } else {
        $err = $GLOBALS['_hc_mailer_last_error'] ?? 'Unknown error — check SMTP settings.';
        hc_flash("Test email FAILED: {$err}", 'error');
    }
    header('Location: /admin/settings.php');
    exit;
}

// Handle save
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') !== 'test_email') {
    $keys = [
        'notification_email','notification_cc','reply_to_email','site_name',
        'smtp_host','smtp_port','smtp_enc','smtp_user','smtp_pass',
        'logo_url','favicon_url',
        'wa_phone','wa_apikey',
    ];
    foreach ($keys as $k) {
        if ($k === 'smtp_pass' && trim($_POST[$k] ?? '') === '') continue;
        hc_setting_save($k, trim($_POST[$k] ?? ''));
    }
    hc_flash('Settings saved.');
    header('Location: /admin/settings.php');
    exit;
}

hc_head('Settings');
hc_topbar('Settings', '<a href="/admin/">Admin</a> › Settings');

$smtp_host = hc_setting('smtp_host','');
$smtp_configured = !empty($smtp_host);
?>
<div class="page-content">

<?= hc_show_flash() ?>

<!-- Status banner -->
<div class="alert <?= $smtp_configured ? 'alert-success' : 'alert-info' ?>" style="margin-bottom:20px">
  <?php if ($smtp_configured): ?>
    <strong>SMTP configured</strong> — emails send via <code><?= h($smtp_host) ?>:<?= h(hc_setting('smtp_port','587')) ?></code> (<?= h(strtoupper(hc_setting('smtp_enc','tls'))) ?>)
  <?php else: ?>
    <strong>SMTP not configured</strong> — emails use PHP <code>mail()</code> which often fails on VPS servers. Set up SMTP below to fix email delivery.
  <?php endif ?>
</div>

<form method="POST">

<!-- Site Identity -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Site Identity</div>
      <div class="card-sub">Logo and favicon shown across the entire website</div>
    </div>
  </div>

  <div class="form-grid">
    <div class="form-group">
      <label for="logo_url">Logo Image URL</label>
      <input type="url" id="logo_url" name="logo_url"
             value="<?= h(hc_setting('logo_url','')) ?>"
             placeholder="https://homecarecreators.com/assets/logo.png">
      <div class="form-hint">PNG or SVG, recommended height 46px. Leave blank to use the built-in SVG logo. Appears in the header nav and footer.</div>
      <?php $lurl = hc_setting('logo_url',''); if ($lurl): ?>
      <div style="margin-top:10px;padding:12px;background:var(--forest);border-radius:8px;display:inline-block">
        <img src="<?= h($lurl) ?>" alt="Logo preview" style="height:46px;width:auto;display:block" onerror="this.style.display='none'">
      </div>
      <?php endif ?>
    </div>
    <div class="form-group">
      <label for="favicon_url">Favicon URL</label>
      <input type="url" id="favicon_url" name="favicon_url"
             value="<?= h(hc_setting('favicon_url','')) ?>"
             placeholder="https://homecarecreators.com/favicon.ico">
      <div class="form-hint">.ico, .png, or .svg. Shown in the browser tab. Recommended size: 32×32px or 64×64px.</div>
      <?php $furl = hc_setting('favicon_url',''); if ($furl): ?>
      <div style="margin-top:10px;display:flex;align-items:center;gap:10px;font-size:13px;color:var(--muted)">
        <img src="<?= h($furl) ?>" alt="Favicon preview" style="width:32px;height:32px;border:1px solid var(--border);border-radius:4px" onerror="this.style.display='none'">
        <span>Current favicon</span>
      </div>
      <?php endif ?>
    </div>
  </div>
</div>

<!-- Email Recipients -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Email Recipients</div>
      <div class="card-sub">Where form submissions are sent</div>
    </div>
  </div>
  <div class="form-grid">
    <div class="form-group">
      <label for="notification_email">Notification Email <span>(required)</span></label>
      <input type="email" id="notification_email" name="notification_email"
             value="<?= h(hc_setting('notification_email','info@homecarecreators.com')) ?>">
      <div class="form-hint">Every contact form submission goes to this address.</div>
    </div>
    <div class="form-group">
      <label for="notification_cc">CC Email <span>(optional)</span></label>
      <input type="email" id="notification_cc" name="notification_cc"
             value="<?= h(hc_setting('notification_cc','')) ?>"
             placeholder="second@email.com">
      <div class="form-hint">Optional second recipient on every submission.</div>
    </div>
  </div>
  <div class="form-grid">
    <div class="form-group">
      <label for="reply_to_email">From / Reply-To Address</label>
      <input type="email" id="reply_to_email" name="reply_to_email"
             value="<?= h(hc_setting('reply_to_email','noreply@homecarecreators.com')) ?>">
    </div>
    <div class="form-group">
      <label for="site_name">Site Name</label>
      <input type="text" id="site_name" name="site_name"
             value="<?= h(hc_setting('site_name','Homecare Creators')) ?>">
    </div>
  </div>
</div>

<!-- SMTP Settings -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">SMTP Settings</div>
      <div class="card-sub">Required for reliable email delivery. Use Gmail, Outlook, or any SMTP provider.</div>
    </div>
  </div>

  <div style="background:var(--cream);border-radius:10px;padding:16px 20px;margin-bottom:20px;font-size:13px;line-height:1.9">
    <strong>Quick setup options:</strong><br>
    <strong>Gmail:</strong> Host <code>smtp.gmail.com</code> · Port <code>587</code> · TLS · Use a <a href="https://myaccount.google.com/apppasswords" target="_blank" style="color:var(--teal)">Google App Password</a> (not your normal password)<br>
    <strong>Outlook/Hotmail:</strong> Host <code>smtp-mail.outlook.com</code> · Port <code>587</code> · TLS<br>
    <strong>Brevo (free 300/day):</strong> Host <code>smtp-relay.brevo.com</code> · Port <code>587</code> · TLS<br>
    <strong>Mailgun:</strong> Host <code>smtp.mailgun.org</code> · Port <code>587</code> · TLS
  </div>

  <div class="form-grid">
    <div class="form-group">
      <label for="smtp_host">SMTP Host</label>
      <input type="text" id="smtp_host" name="smtp_host"
             value="<?= h(hc_setting('smtp_host','')) ?>"
             placeholder="smtp.gmail.com">
    </div>
    <div class="form-group">
      <label for="smtp_port">Port</label>
      <input type="number" id="smtp_port" name="smtp_port"
             value="<?= h(hc_setting('smtp_port','587')) ?>"
             placeholder="587">
    </div>
  </div>

  <div class="form-grid">
    <div class="form-group">
      <label for="smtp_enc">Encryption</label>
      <select id="smtp_enc" name="smtp_enc">
        <option value="tls"  <?= hc_setting('smtp_enc','tls')==='tls' ?'selected':'' ?>>TLS / STARTTLS (recommended — port 587)</option>
        <option value="ssl"  <?= hc_setting('smtp_enc')==='ssl' ?'selected':'' ?>>SSL (port 465)</option>
        <option value="none" <?= hc_setting('smtp_enc')==='none'?'selected':'' ?>>None (port 25 — not recommended)</option>
      </select>
    </div>
    <div class="form-group">
      <label for="smtp_user">SMTP Username</label>
      <input type="text" id="smtp_user" name="smtp_user"
             value="<?= h(hc_setting('smtp_user','')) ?>"
             placeholder="your@gmail.com" autocomplete="off">
    </div>
  </div>

  <div class="form-group" style="max-width:420px">
    <label for="smtp_pass">SMTP Password / App Password</label>
    <input type="password" id="smtp_pass" name="smtp_pass"
           value="" placeholder="<?= $smtp_configured ? '(saved — leave blank to keep)' : 'Enter password' ?>"
           autocomplete="new-password">
    <div class="form-hint">
      <?= $smtp_configured ? 'Password is saved. Only fill this in to change it.' : 'For Gmail, generate an App Password at myaccount.google.com/apppasswords' ?>
    </div>
  </div>
</div>

<!-- WhatsApp Notifications -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">WhatsApp Notifications</div>
      <div class="card-sub">Get an instant WhatsApp message when someone submits the contact form</div>
    </div>
    <?php $wa_ok = hc_setting('wa_phone') && hc_setting('wa_apikey'); ?>
    <span class="badge <?= $wa_ok ? 'badge-green' : 'badge-gray' ?>" style="font-size:12px">
      <?= $wa_ok ? 'Active' : 'Not set up' ?>
    </span>
  </div>

  <div style="background:rgba(37,211,102,.07);border:1px solid rgba(37,211,102,.25);border-radius:10px;padding:16px 20px;margin-bottom:20px;font-size:13px;line-height:2">
    <strong>One-time setup (takes 2 minutes):</strong><br>
    1. Save this number in your phone contacts: <strong>+34 644 77 81 82</strong> (name it "CallMeBot")<br>
    2. Open WhatsApp and send this exact message to that contact:<br>
    &nbsp;&nbsp;&nbsp;<code style="background:#fff;padding:3px 8px;border-radius:4px;font-size:12px">I allow callmebot to send me messages</code><br>
    3. You'll receive your API key in reply — paste it below<br>
    4. Enter your WhatsApp number in international format (no + sign, e.g. <code>923411420970</code>)
  </div>

  <div class="form-grid">
    <div class="form-group">
      <label for="wa_phone">Your WhatsApp Number</label>
      <input type="text" id="wa_phone" name="wa_phone"
             value="<?= h(hc_setting('wa_phone','')) ?>"
             placeholder="923411420970">
      <div class="form-hint">International format without + or spaces. Your number: 923411420970</div>
    </div>
    <div class="form-group">
      <label for="wa_apikey">CallMeBot API Key</label>
      <input type="text" id="wa_apikey" name="wa_apikey"
             value="<?= h(hc_setting('wa_apikey','')) ?>"
             placeholder="e.g. 123456">
      <div class="form-hint">You receive this key via WhatsApp after sending the activation message.</div>
    </div>
  </div>
</div>

<div style="display:flex;gap:12px;margin-top:4px;flex-wrap:wrap">
  <button type="submit" class="btn btn-primary btn-lg">Save Settings</button>
</div>

</form>

<!-- Test WhatsApp -->
<?php if (hc_setting('wa_phone') && hc_setting('wa_apikey')): ?>
<div class="card" style="margin-top:20px">
  <div class="card-header">
    <div class="card-title">Test WhatsApp</div>
  </div>
  <form method="POST">
    <input type="hidden" name="action" value="test_whatsapp">
    <div style="display:flex;gap:12px;align-items:center;flex-wrap:wrap">
      <span style="font-size:13px;color:var(--muted)">Send a test WhatsApp message to <strong><?= h(hc_setting('wa_phone')) ?></strong></span>
      <button type="submit" class="btn btn-secondary">Send Test WhatsApp</button>
    </div>
  </form>
</div>
<?php endif ?>

<!-- Test Email -->
<div class="card" style="margin-top:20px">
  <div class="card-header">
    <div class="card-title">Send Test Email</div>
  </div>
  <form method="POST" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
    <input type="hidden" name="action" value="test_email">
    <div class="form-group" style="margin-bottom:0;flex:1;min-width:200px">
      <label>Send test to</label>
      <input type="email" name="test_to"
             value="<?= h(hc_setting('notification_email','info@homecarecreators.com')) ?>"
             placeholder="info@homecarecreators.com">
    </div>
    <button type="submit" class="btn btn-secondary">Send Test Email</button>
  </form>
  <div style="font-size:12px;color:var(--muted);margin-top:10px">
    Sends a test message using your current SMTP settings. Check spam/junk if it doesn't arrive.
  </div>
</div>

</div>
<?php hc_foot(); ?>
