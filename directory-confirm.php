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
        // Owner account: link if one exists, otherwise offer instant setup (this link already proved the email).
        hc_dir_session();
        $acct = hc_one("SELECT * FROM hc_directory_owners WHERE LOWER(email)=LOWER(?) AND verified_at IS NOT NULL", [$l['owner_email']]);
        if ($acct) { hc_dir_owner_link((int)$acct['id'], $acct['email']); }
        else { $_SESSION['hc_dir_setup'] = ['email' => $l['owner_email'], 'name' => $l['owner_name'], 'exp' => time() + 3600]; }
    }
}

$page_title = 'Confirm Your Listing | Homecare Creators Directory';
$page_desc  = 'Confirm ownership of your home care agency listing.';
$page_css = hc_dir_base_css() . <<<CSS
.cf{min-height:58vh;display:flex;align-items:center;justify-content:center}
.cf-card{max-width:620px;width:100%;text-align:center}
.cf-icon{width:72px;height:72px;border-radius:50%;display:flex;align-items:center;justify-content:center;margin:0 auto 26px;font-size:24px}
.cf-icon.ok{background:var(--teal);color:#fff}
.cf-icon.bad{background:var(--gold-bg);color:var(--gold-ink)}
.cf h1{font-size:clamp(32px,4vw,52px);font-weight:800;letter-spacing:-.04em;line-height:1.05;margin-bottom:16px}
.cf p{font-size:17px;color:var(--mut);line-height:1.65;margin-bottom:10px}
.cf p a{color:var(--ink);text-decoration:underline!important;text-underline-offset:3px}
.cf-steps{text-align:left;background:#fff;border-radius:28px;padding:10px 28px;margin-top:32px}
.cf-steps div{display:grid;grid-template-columns:40px 1fr;gap:6px;padding:16px 0;font-size:15px;color:var(--txt);line-height:1.55;border-top:1px solid var(--hair-2)}
.cf-steps div:first-child{border-top:0}
.cf-steps b{font-family:'Plus Jakarta Sans',sans-serif;font-size:12.5px;font-weight:600;color:#a3ada6;padding-top:2px}
.cf .dx-btn{margin-top:30px}
CSS;
$page_noindex = true;
include __DIR__ . '/includes/header.php';
?>
<div id="scrollProgress"></div>
<div class="dx"><div class="dx-frame is-first"><section class="dx-panel cf">
  <div class="cf-card">
  <?php if ($state === 'ok'):
      $req = $l['requested_plan'] ?: $l['plan'];
      $plan = hc_dir_plans()[$req] ?? hc_dir_plans()['free']; ?>
    <div class="cf-icon ok"><i class="fa-solid fa-check"></i></div>
    <h1>You're confirmed, <em><?= htmlspecialchars(explode(' ', (string)$l['owner_name'])[0] ?: 'thank you') ?>.</em></h1>
    <p>You're confirmed as the representative for <strong><?= htmlspecialchars($l['company_name']) ?></strong>.</p>
    <div class="cf-steps">
      <?php if ($req !== 'free'): ?>
      <div><b>01</b><span>We'll email your <strong><?= htmlspecialchars($plan['name']) ?></strong> invoice ($<?= (int)$plan['price'] ?>/month) to <?= htmlspecialchars($l['owner_email']) ?> within 1 business day.</span></div>
      <div><b>02</b><span>Reply to that email with your logo, cover photo and any gallery photos.</span></div>
      <div><b>03</b><span>Once the invoice is paid, your upgraded profile goes live.</span></div>
      <?php else: ?>
      <div><b>01</b><span>Our team reviews your listing, usually within 1–2 business days.</span></div>
      <div><b>02</b><span>You'll get an email as soon as it's live.</span></div>
      <?php endif ?>
    </div>
    <?php if (!empty($acct)): ?>
    <p style="margin-top:24px">This listing is now linked to your owner account.</p>
    <a href="/directory/account/" class="dx-btn is-dark">Go to my dashboard</a>
    <?php else: ?>
    <div class="cf-steps" style="margin-top:16px"><div><b>✓</b><span><strong>Create your free owner account</strong> to update your listing, see inquiries and manage your plan any time.</span></div></div>
    <a href="/directory/account/?p=setup" class="dx-btn is-dark">Create my account</a>
    <a href="/directory/" class="dx-btn" style="margin-left:8px">Maybe later</a>
    <?php endif ?>
  <?php elseif ($state === 'expired'): ?>
    <div class="cf-icon bad"><i class="fa-regular fa-clock"></i></div>
    <h1>This link has <em>expired.</em></h1>
    <p>Confirmation links are valid for 14 days. Email <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a> and we'll send you a new one.</p>
  <?php else: ?>
    <div class="cf-icon bad"><i class="fa-solid fa-link-slash"></i></div>
    <h1>This link isn't <em>valid.</em></h1>
    <p>It may have already been used. If your listing still isn't confirmed, email <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a>.</p>
    <a href="/directory/" class="dx-btn">Go to the directory</a>
  <?php endif ?>
  </div>
</section></div></div>
<?php include __DIR__ . '/includes/footer.php'; ?>
