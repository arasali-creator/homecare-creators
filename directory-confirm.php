<?php
require_once __DIR__ . '/admin/config.php';
require_once __DIR__ . '/admin/includes/db.php';
require_once __DIR__ . '/admin/includes/functions.php';
require_once __DIR__ . '/admin/includes/mailer.php';
require_once __DIR__ . '/admin/includes/directory.php';
require_once __DIR__ . '/includes/directory-ui.php';
hc_dir_ensure_schema();

$token = preg_replace('/[^a-f0-9]/', '', $_GET['token'] ?? '');
$l = strlen($token) === 48 ? hc_one("SELECT * FROM hc_directory_listings WHERE confirm_token=?", [$token]) : null;

$state = 'invalid';
if ($l) {
    if ($l['confirm_sent_at'] && strtotime($l['confirm_sent_at']) < time() - 14 * 86400) {
        $state = 'expired';
    } else {
        $state = 'ok';
        $wasClaim = ($l['claim_status'] ?? '') === 'pending';
        hc_q("UPDATE hc_directory_listings SET owner_confirmed_at=NOW(), confirm_token=NULL, claim_status=IF(claim_status='pending','confirmed',claim_status) WHERE id=?", [$l['id']]);

        $plans = hc_dir_plans();
        $req = $l['requested_plan'] ?: $l['plan'];
        $planName = $plans[$req]['name'] ?? 'Basic';
        $notification_email = hc_setting('notification_email', 'info@homecarecreators.com');
        $msg  = "Owner confirmed: {$l['company_name']} ({$l['city']}, {$l['state']})\n\n";
        $msg .= "{$l['owner_name']} — {$l['owner_title']}\n{$l['owner_email']} · {$l['owner_phone']}\n";
        $msg .= "Plan requested: {$planName}" . ($req !== 'free' ? " — send the invoice, then mark it paid in admin." : '') . "\n";
        $msg .= ($wasClaim ? "This was a CLAIM of an existing listing.\n" : "Listing status: {$l['status']}\n");
        $msg .= "Email domain matches website: " . (hc_dir_domain_match($l) ? 'YES' : 'no') . "\n\n";
        $msg .= "Open: https://homecarecreators.com/admin/directory/edit.php?id={$l['id']}\n";
        HcMailer::send($notification_email, "✓ Owner confirmed: {$l['company_name']}" . ($req !== 'free' ? " [{$planName}]" : ''), $msg, $l['owner_email']);
    }
}

$page_title = 'Confirm Your Listing | Homecare Creators Directory';
$page_desc  = 'Confirm ownership of your home care agency listing.';
$page_css = hc_dir_base_css() . <<<CSS
body{background:#f7f7f5}
.cf{min-height:70vh;display:flex;align-items:center;justify-content:center;padding:130px 16px 80px}
.cf-card{max-width:540px;width:100%;background:#fff;border:1px solid var(--line);border-radius:16px;padding:40px;text-align:center}
.cf-icon{width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 18px;font-size:26px}
.cf-icon.ok{background:#e7f5ef;color:var(--teal)}
.cf-icon.bad{background:#fdf0ef;color:#c2410c}
.cf h1{font-size:24px;font-weight:800;margin-bottom:10px}
.cf p{font-size:15.5px;color:var(--ink-2);line-height:1.65;margin-bottom:10px}
.cf-steps{text-align:left;border-top:1px solid var(--line);margin-top:24px;padding-top:20px}
.cf-steps div{display:flex;gap:12px;padding:8px 0;font-size:14.5px;color:var(--ink-2);line-height:1.5}
.cf-steps b{width:24px;height:24px;border-radius:50%;background:var(--forest);color:#fff;font-size:12px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.cf .dx-btn{margin-top:22px}
CSS;
$page_noindex = true;
include __DIR__ . '/includes/header.php';
?>
<div id="scrollProgress"></div>
<div class="dx cf">
  <div class="cf-card">
  <?php if ($state === 'ok'):
      $req = $l['requested_plan'] ?: $l['plan'];
      $plan = hc_dir_plans()[$req] ?? hc_dir_plans()['free']; ?>
    <div class="cf-icon ok"><i class="fa-solid fa-check"></i></div>
    <h1>Thanks, <?= htmlspecialchars(explode(' ', (string)$l['owner_name'])[0] ?: 'you') ?>, you're confirmed</h1>
    <p>You're confirmed as the representative for <strong><?= htmlspecialchars($l['company_name']) ?></strong>.</p>
    <div class="cf-steps">
      <?php if ($req !== 'free'): ?>
      <div><b>1</b><span>We'll email your <strong><?= htmlspecialchars($plan['name']) ?></strong> invoice ($<?= (int)$plan['price'] ?>/month) to <?= htmlspecialchars($l['owner_email']) ?> within 1 business day.</span></div>
      <div><b>2</b><span>Reply to that email with your logo, cover photo and any gallery photos.</span></div>
      <div><b>3</b><span>Once the invoice is paid, your upgraded profile goes live.</span></div>
      <?php else: ?>
      <div><b>1</b><span>Our team reviews your listing, usually within 1–2 business days.</span></div>
      <div><b>2</b><span>You'll get an email as soon as it's live.</span></div>
      <?php endif ?>
    </div>
    <a href="/directory/" class="dx-btn is-dark">Back to the directory</a>
  <?php elseif ($state === 'expired'): ?>
    <div class="cf-icon bad"><i class="fa-regular fa-clock"></i></div>
    <h1>This link has expired</h1>
    <p>Confirmation links are valid for 14 days. Email <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a> and we'll send you a new one.</p>
  <?php else: ?>
    <div class="cf-icon bad"><i class="fa-solid fa-link-slash"></i></div>
    <h1>This link isn't valid</h1>
    <p>It may have already been used. If your listing still isn't confirmed, email <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a>.</p>
    <a href="/directory/" class="dx-btn">Go to the directory</a>
  <?php endif ?>
  </div>
</div>
<?php include __DIR__ . '/includes/footer.php'; ?>
