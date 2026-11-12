<?php
/**
 * Agency owner portal: /directory/account/
 *   ?p=login (default) | forgot | reset&token= | home | edit&id= | leads&id= | logout
 *   ?api=me  → JSON for the directory popups
 * All listing changes become edit requests that an admin approves.
 */
require_once '../../admin/config.php';
require_once '../../admin/includes/db.php';
require_once '../../admin/includes/functions.php';
require_once '../../admin/includes/mailer.php';
require_once '../../admin/includes/directory.php';
require_once '../../includes/directory-ui.php';
hc_dir_ensure_schema();
hc_dir_session();
header('Cache-Control: private, no-store, max-age=0');

$owner = hc_dir_owner();
$p     = $_GET['p'] ?? ($owner ? 'home' : 'login');
$plans = hc_dir_plans();

// ── JSON for popups on cached directory pages ──
if (isset($_GET['api'])) {
    header('Content-Type: application/json');
    if (!$owner) { echo json_encode(['loggedIn' => false]); exit; }
    $mine = hc_all("SELECT * FROM hc_directory_listings WHERE owner_account_id=?", [$owner['id']]);
    $free = array_values(array_filter($mine, fn($l) => hc_dir_tier($l) === 'free' && !in_array($l['requested_plan'], ['premium', 'featured'], true)));
    echo json_encode(['loggedIn' => true, 'name' => explode(' ', (string)$owner['name'])[0] ?: '', 'listings' => count($mine), 'freeListing' => $free ? ['id' => (int)$free[0]['id'], 'name' => $free[0]['company_name']] : null]);
    exit;
}

$flash = $_SESSION['hc_owner_flash'] ?? null; unset($_SESSION['hc_owner_flash']);
function own_flash(string $m, string $t = 'ok'): void { $_SESSION['hc_owner_flash'] = [$m, $t]; }
function own_go(string $q): void { header('Location: /directory/account/' . ($q ? '?' . $q : '')); exit; }
$err = '';

// ── Actions ──
if ($p === 'logout') { unset($_SESSION['hc_owner_id']); own_flash('You have been logged out.'); own_go(''); }

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!hc_dir_csrf_ok()) { $err = 'Your session expired. Please try again.'; }
    elseif ($p === 'login') {
        $o = hc_one("SELECT * FROM hc_directory_owners WHERE LOWER(email)=LOWER(?)", [trim($_POST['email'] ?? '')]);
        if ($o && $o['password_hash'] && $o['verified_at'] && password_verify((string)($_POST['password'] ?? ''), $o['password_hash'])) {
            hc_dir_owner_login($o); own_go('p=home');
        }
        usleep(700000);
        $err = 'That email and password don\'t match. If you haven\'t set a password yet, use "Set up or reset password".';
    }
    elseif ($p === 'register') {
        $email = trim($_POST['email'] ?? ''); $name = mb_substr(strip_tags(trim($_POST['name'] ?? '')), 0, 150);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL) || !$name) $err = 'Please enter your name and a valid email.';
        else {
            $ex = hc_one("SELECT * FROM hc_directory_owners WHERE LOWER(email)=LOWER(?)", [$email]);
            if (!$ex || !$ex['verified_at']) hc_dir_send_password_link($email, $name);
            own_flash('Check your inbox: we sent a link to verify your email and set your password. (If you already have an account, just log in.)');
            own_go('p=login');
        }
    }
    elseif ($p === 'setup') {
        $st = $_SESSION['hc_dir_setup'] ?? null;
        $pw = (string)($_POST['password'] ?? '');
        if (!$st || $st['exp'] < time()) $err = 'This setup window has expired. Use "Create account" to get a new link.';
        elseif (strlen($pw) < 8) $err = 'Please use at least 8 characters.';
        elseif ($pw !== ($_POST['password2'] ?? '')) $err = 'The passwords don\'t match.';
        else {
            $ex = hc_one("SELECT * FROM hc_directory_owners WHERE LOWER(email)=LOWER(?)", [$st['email']]);
            if ($ex) hc_q("UPDATE hc_directory_owners SET password_hash=?, verified_at=IFNULL(verified_at,NOW()), name=COALESCE(name,?) WHERE id=?", [password_hash($pw, PASSWORD_DEFAULT), $st['name'], $ex['id']]);
            else hc_q("INSERT INTO hc_directory_owners (email, name, password_hash, verified_at) VALUES (?,?,?,NOW())", [strtolower($st['email']), $st['name'], password_hash($pw, PASSWORD_DEFAULT)]);
            unset($_SESSION['hc_dir_setup']);
            hc_dir_owner_login(hc_one("SELECT * FROM hc_directory_owners WHERE LOWER(email)=LOWER(?)", [$st['email']]));
            own_flash('Your account is ready. You can manage your listing from here.');
            own_go('p=home');
        }
    }
    elseif ($owner && $p === 'verify') {
        $vid = (int)($_POST['vid'] ?? 0);
        $vr  = hc_one("SELECT v.*, l.company_name FROM hc_directory_verifications v JOIN hc_directory_listings l ON l.id=v.listing_id WHERE v.id=? AND l.owner_account_id=? AND v.status IN ('requested','rejected')", [$vid, $owner['id']]);
        if (!$vr) { own_flash('That verification request was not found.', 'err'); own_go('p=home'); }
        $res = hc_dir_store_verification($_FILES['file'] ?? []);
        if (is_string($res)) { own_flash($res, 'err'); own_go('p=home'); }
        if ($vr['file_path'] && is_file($vr['file_path'])) @unlink($vr['file_path']);
        hc_q("UPDATE hc_directory_verifications SET file_path=?, file_mime=?, file_name=?, owner_note=?, status='submitted', submitted_at=NOW() WHERE id=?",
            [$res[0], $res[1], $res[2], mb_substr(strip_tags(trim($_POST['owner_note'] ?? '')), 0, 2000), $vid]);
        HcMailer::send(hc_setting('notification_email', 'info@homecarecreators.com'), "[Directory] Verification submitted: {$vr['company_name']}",
            "{$owner['email']} uploaded their verification file for {$vr['company_name']}.\n\nReview it: https://homecarecreators.com/admin/directory/edit.php?id={$vr['listing_id']}#verification\n", $owner['email']);
        own_flash('Thank you! Your verification was uploaded. We\'ll review it shortly.');
        own_go('p=home');
    }
    elseif ($p === 'forgot') {
        $email = trim($_POST['email'] ?? '');
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $known = hc_val("SELECT id FROM hc_directory_owners WHERE LOWER(email)=LOWER(?)", [$email])
                  || hc_val("SELECT id FROM hc_directory_listings WHERE LOWER(owner_email)=LOWER(?) AND owner_confirmed_at IS NOT NULL", [$email]);
            if ($known) hc_dir_send_password_link($email);
        }
        own_flash('If that email belongs to a confirmed agency owner, we\'ve sent a link to set your password. Check your inbox.');
        own_go('p=login');
    }
    elseif ($p === 'reset') {
        $o = hc_one("SELECT * FROM hc_directory_owners WHERE reset_token=? AND reset_sent_at > NOW() - INTERVAL 1 DAY", [preg_replace('/[^a-f0-9]/', '', $_GET['token'] ?? '')]);
        $pw = (string)($_POST['password'] ?? '');
        if (!$o) $err = 'This link has expired. Please request a new one.';
        elseif (strlen($pw) < 8) $err = 'Please use at least 8 characters.';
        elseif ($pw !== ($_POST['password2'] ?? '')) $err = 'The passwords don\'t match.';
        else {
            hc_q("UPDATE hc_directory_owners SET password_hash=?, verified_at=IFNULL(verified_at,NOW()), reset_token=NULL, name=COALESCE(NULLIF(?,''),name) WHERE id=?", [password_hash($pw, PASSWORD_DEFAULT), trim($_POST['name'] ?? ''), $o['id']]);
            hc_dir_owner_login(hc_one("SELECT * FROM hc_directory_owners WHERE id=?", [$o['id']]));
            own_flash('Your password is set. Welcome to your dashboard.');
            own_go('p=home');
        }
    }
    elseif ($owner && $p === 'edit') {
        $id = (int)($_GET['id'] ?? 0);
        $l  = hc_one("SELECT * FROM hc_directory_listings WHERE id=? AND owner_account_id=?", [$id, $owner['id']]);
        if ($l) {
            $t = fn($k, $max = 5000) => mb_substr(strip_tags(trim((string)($_POST[$k] ?? ''))), 0, $max);
            $url = function ($k) use ($t) { $u = $t($k, 500); if ($u && !preg_match('#^https?://#i', $u)) $u = 'https://' . $u; return filter_var($u, FILTER_VALIDATE_URL) ? $u : ''; };
            $hm = fn($k) => preg_match('/^\d{2}:\d{2}$/', (string)($_POST[$k] ?? '')) ? $_POST[$k] : '';
            $rows = [];
            foreach (array_keys(HC_DIR_DAYS) as $d) $rows[$d] = ['open' => $hm("h_{$d}_open"), 'close' => $hm("h_{$d}_close"), 'closed' => !empty($_POST["h_{$d}_closed"])];
            $new = [
                'tagline' => $t('tagline', 160), 'description' => $t('description'),
                'services' => implode("\n", array_unique(array_merge(array_values(array_intersect((array)($_POST['services'] ?? []), HC_DIR_SERVICES)), hc_dir_areas($t('services_other', 500))))),
                'payment_accepted' => implode("\n", array_values(array_intersect((array)($_POST['payment_accepted'] ?? []), HC_DIR_PAYMENTS))),
                'features' => implode("\n", array_values(array_intersect((array)($_POST['features'] ?? []), array_keys(HC_DIR_FEATURES)))),
                'hours_json' => hc_dir_hours_from_input(!empty($_POST['hours_always']), $rows), 'hours' => $t('hours', 255),
                'phone' => $t('phone', 50), 'email' => filter_var($t('email', 255), FILTER_VALIDATE_EMAIL) ?: '', 'website' => $url('website'),
                'address' => $t('address', 255), 'service_areas' => $t('service_areas', 2000), 'languages' => $t('languages', 255),
                'license_number' => $t('license_number', 100), 'years_in_business' => $t('years_in_business', 50),
            ];
            // Images: uploaded files (validated) + previously approved/pending images the owner kept.
            $pendRow = hc_one("SELECT data FROM hc_directory_edits WHERE listing_id=? AND status='pending' ORDER BY id DESC LIMIT 1", [$id]);
            $base = array_merge($l, $pendRow ? (json_decode($pendRow['data'], true) ?: []) : []);
            $imgErr = '';
            foreach (['logo' => 'logo', 'cover_image' => 'cover'] as $col => $fld) {
                $up = hc_dir_files($fld . '_file')[0] ?? null;
                $saved = $up ? hc_dir_save_upload($up, $l['slug'], $fld) : '';
                if ($saved && str_starts_with($saved, '/')) $new[$col] = $saved;
                elseif ($saved) $imgErr = $saved;
                elseif (!empty($_POST[$fld . '_remove'])) $new[$col] = '';
                else $new[$col] = (string)($base[$col] ?? '');
            }
            $photos = hc_dir_keep_paths((array)($_POST['photos_keep'] ?? []), array_merge(hc_dir_lines($l['photos'] ?? ''), hc_dir_lines($base['photos'] ?? '')));
            foreach (hc_dir_files('photos_file') as $up) {
                if (count($photos) >= 12) break;
                $saved = hc_dir_save_upload($up, $l['slug'], 'photo');
                if ($saved && str_starts_with($saved, '/')) $photos[] = $saved; elseif ($saved) $imgErr = $saved;
            }
            $new['photos'] = implode("\n", $photos);
            // Keep only what actually changed.
            $changes = [];
            foreach ($new as $k => $v) { if ((string)($l[$k] ?? '') !== (string)$v) $changes[$k] = $v === '' ? null : $v; }
            $digits = preg_replace('/\D/', '', (string)$new['phone']);
            if ($imgErr) $err = $imgErr;
            elseif (mb_strlen((string)$new['description']) < 40) $err = 'Please keep the description at least 40 characters.';
            elseif ($new['phone'] && strlen(ltrim($digits, '1')) !== 10 && strlen($digits) !== 10) $err = 'Please enter a 10-digit phone number.';
            elseif (!empty($_POST['email']) && !$new['email']) $err = 'Please enter a valid email address.';
            elseif (!empty($_POST['website']) && !$new['website']) $err = 'Please enter a valid website address.';
            elseif ($new['years_in_business'] !== '' && !preg_match('/^\d{1,3}$/', (string)$new['years_in_business'])) $err = 'Years in business should be a number.';
            elseif (!$changes) { own_flash('Nothing changed, so there was nothing to send for review.'); own_go('p=home'); }
            else {
                hc_q("UPDATE hc_directory_edits SET status='replaced', reviewed_at=NOW() WHERE listing_id=? AND status='pending'", [$id]);
                hc_q("INSERT INTO hc_directory_edits (listing_id, owner_id, data) VALUES (?,?,?)", [$id, $owner['id'], json_encode($changes)]);
                $labels = implode(', ', array_map(fn($k) => HC_DIR_OWNER_FIELDS[$k] ?? $k, array_keys($changes)));
                HcMailer::send(hc_setting('notification_email', 'info@homecarecreators.com'), "[Directory] Edit request: {$l['company_name']}",
                    "{$owner['email']} asked to update {$l['company_name']}.\n\nChanged: {$labels}\n\nReview: https://homecarecreators.com/admin/directory/requests.php\n", $owner['email']);
                own_flash('Thanks! Your changes were sent for review. They go live as soon as our team approves them, usually within 1 business day.');
                own_go('p=home');
            }
        }
    }
    elseif ($owner && $p === 'upgrade') {
        $id = (int)($_POST['id'] ?? 0); $plan = $_POST['plan'] ?? '';
        $l  = hc_one("SELECT * FROM hc_directory_listings WHERE id=? AND owner_account_id=?", [$id, $owner['id']]);
        if ($l && in_array($plan, ['premium', 'featured'], true)) {
            hc_q("UPDATE hc_directory_listings SET requested_plan=?, payment_status=IF(payment_status IN ('paid','comp'), payment_status, 'pending') WHERE id=?", [$plan, $id]);
            HcMailer::send(hc_setting('notification_email', 'info@homecarecreators.com'), "[Directory] Upgrade request: {$l['company_name']} → {$plans[$plan]['name']}",
                "{$owner['email']} wants {$plans[$plan]['name']} (\${$plans[$plan]['price']}/mo) for {$l['company_name']}.\nSend the invoice, then mark it paid:\nhttps://homecarecreators.com/admin/directory/edit.php?id={$id}\n", $owner['email']);
            own_flash("Great choice! We'll email your {$plans[$plan]['name']} invoice within 1 business day. Your upgrade goes live once it's paid.");
        }
        own_go('p=home');
    }
}

if (in_array($p, ['home', 'edit', 'leads', 'upgrade'], true) && !$owner) own_go('p=login');

$csrf = hc_dir_csrf();
$page_title = 'Agency Owner Account | Homecare Creators Directory';
$page_desc  = 'Manage your home care agency listing.';
$page_noindex = true;

$mine = $owner ? hc_all("SELECT l.*, (SELECT COUNT(*) FROM hc_directory_leads d WHERE d.listing_id=l.id) leads,
                          (SELECT COUNT(*) FROM hc_directory_edits e WHERE e.listing_id=l.id AND e.status='pending') pending_edit,
                          (SELECT status FROM hc_directory_edits e WHERE e.listing_id=l.id ORDER BY id DESC LIMIT 1) last_edit
                          FROM hc_directory_listings l WHERE owner_account_id=? ORDER BY company_name", [$owner['id']]) : [];

$page_css = hc_dir_base_css() . hc_dir_extra_css() . <<<CSS
.ac-auth{max-width:460px;margin:0 auto;background:#fff;border-radius:32px;padding:40px}
.ac-auth h1{font-size:34px;font-weight:800;letter-spacing:-.04em;line-height:1.1;margin-bottom:10px}
.ac-auth p.sub{color:var(--mut);font-size:15px;line-height:1.6;margin-bottom:24px}
.fm label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--ink);margin:0 0 7px 4px}
.fm label em{font-style:normal;font-weight:400;color:var(--mut)}
.fm input,.fm select,.fm textarea{width:100%;font:inherit;font-size:15px;border:1px solid var(--hair);border-radius:16px;padding:13px 16px;margin-bottom:16px;background:var(--cream);color:var(--ink);outline:0}
.fm input:focus,.fm textarea:focus{border-color:var(--ink);background:#fff}
.fm .dx-btn{width:100%;padding:16px}
.ac-links{display:flex;justify-content:space-between;gap:12px;margin-top:18px;font-size:14px}
.ac-links a{color:var(--ink);text-decoration:underline!important;text-underline-offset:3px}
.msg{border-radius:18px;padding:14px 18px;font-size:14.5px;margin-bottom:18px;line-height:1.55}
.msg.ok{background:#e3f4ec;color:#0b5c3f}
.msg.err{background:#fdecea;color:#9b2c1f}
.ac-top{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;flex-wrap:wrap;margin-bottom:32px}
.ac-top h1{font-size:clamp(32px,4vw,52px);font-weight:800;letter-spacing:-.045em;line-height:1.05}
.ac-card{background:#fff;border-radius:28px;padding:26px;margin-bottom:14px;display:grid;grid-template-columns:auto 1fr auto;gap:22px;align-items:center}
.ac-card h3{font-size:21px;font-weight:800;letter-spacing:-.03em;margin-bottom:6px}
.ac-meta{display:flex;flex-wrap:wrap;gap:6px 16px;font-size:14px;color:var(--mut);margin-bottom:8px;align-items:center}
.ac-acts{display:flex;flex-direction:column;gap:8px;min-width:200px}
.ac-acts .dx-btn{padding:12px 18px}
.ac-stats{display:flex;gap:22px;margin-top:6px}
.ac-stats b{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:22px;color:var(--ink);line-height:1}
.ac-stats span{font-size:12.5px;color:var(--mut)}
.pill{display:inline-flex;align-items:center;gap:6px;border-radius:100px;padding:5px 11px;font-size:12px;font-weight:700;font-family:'Plus Jakarta Sans',sans-serif}
.pill.g{background:#e3f4ec;color:#0b6646}.pill.y{background:var(--gold-bg);color:var(--gold-ink)}.pill.r{background:#fdecea;color:#9b2c1f}.pill.n{background:#efece4;color:var(--ink)}
.ed{display:grid;grid-template-columns:minmax(0,1fr) 340px;gap:24px;align-items:start}
.ed-s{background:#fff;border-radius:28px;padding:30px;margin-bottom:14px}
.ed-s h2{font-size:22px;font-weight:800;letter-spacing:-.03em;margin-bottom:18px}
.row2{display:grid;grid-template-columns:1fr 1fr;gap:12px}
.chks{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:16px}
.chk{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--hair);border-radius:100px;padding:9px 15px;font-size:14px;cursor:pointer;background:#fff;user-select:none}
.chk input{display:none}
.chk:has(input:checked){background:var(--ink);border-color:var(--ink);color:#fff}
.hrs{display:grid;grid-template-columns:60px 1fr 1fr auto;gap:8px 10px;align-items:center;margin-bottom:12px}
.hrs input[type=time]{margin:0;padding:10px 12px}
.hrs label{margin:0;font-weight:400;display:flex;gap:6px;align-items:center;font-size:13.5px}
.hrs label input{width:auto;margin:0}
.ed-side{position:sticky;top:96px}
.ed-side .ed-s p{font-size:14px;color:var(--mut);line-height:1.6;margin-bottom:14px}
.lt{width:100%;border-collapse:collapse;background:#fff;border-radius:24px;overflow:hidden}
.lt th,.lt td{text-align:left;padding:14px 18px;border-bottom:1px solid var(--hair-2);font-size:14px;vertical-align:top}
.lt th{font-size:11.5px;letter-spacing:1px;text-transform:uppercase;color:var(--mut)}
.up{display:grid;grid-template-columns:1fr 1fr;gap:12px;margin-top:28px}
.up form{background:#fff;border-radius:24px;padding:22px;border:1.5px solid transparent}
.up form.pop{border-color:var(--teal)}
.up h4{font-size:18px;font-weight:800;margin-bottom:4px}
.up .pr{font-family:'Plus Jakarta Sans',sans-serif;font-size:30px;font-weight:800;letter-spacing:-.04em;color:var(--ink)}
.up ul{list-style:none;padding:0;margin:12px 0 16px;font-size:13.5px;color:var(--txt)}
.up li{padding:3px 0}
.up li i{color:var(--teal);margin-right:8px;font-size:11px}
@media(max-width:900px){.ac-card{grid-template-columns:auto 1fr}.ac-acts{grid-column:1/-1;flex-direction:row;flex-wrap:wrap}.ed{grid-template-columns:1fr}.ed-side{position:static}.up{grid-template-columns:1fr}}
@media(max-width:600px){.ac-auth{padding:28px 20px;border-radius:24px}.row2{grid-template-columns:1fr}.hrs{grid-template-columns:44px 1fr 1fr}.hrs label{grid-column:2/-1}.ed-s{padding:22px 18px}}
CSS;
include '../../includes/header.php';
$F = fn() => $flash ? '<div class="msg ' . ($flash[1] === 'ok' ? 'ok' : 'err') . '">' . htmlspecialchars($flash[0]) . '</div>' : '';
$E = fn() => $err ? '<div class="msg err">' . htmlspecialchars($err) . '</div>' : '';
?>
<div id="scrollProgress"></div>
<div class="dx"><div class="dx-frame is-first"><section class="dx-panel"><div class="dx-in">

<?php if ($p === 'login'): ?>
  <div class="ac-auth">
    <span class="dx-label" style="margin-bottom:18px">Agency owners</span>
    <h1>Log in to <em>your listing.</em></h1>
    <p class="sub">Update your details, see inquiries and manage your plan.</p>
    <?= $F() ?><?= $E() ?>
    <form class="fm" method="POST" action="?p=login" data-validate>
      <input type="hidden" name="csrf" value="<?= $csrf ?>">
      <label for="e">Email</label><input id="e" name="email" type="email" required autocomplete="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
      <label for="pw">Password</label><input id="pw" name="password" type="password" required autocomplete="current-password">
      <button class="dx-btn is-dark" type="submit">Log in</button>
    </form>
    <div class="ac-links"><a href="?p=forgot">Forgot password?</a><a href="?p=register">Create an account</a></div>
  </div>

<?php elseif ($p === 'register'): ?>
  <div class="ac-auth">
    <span class="dx-label" style="margin-bottom:18px">Agency owners</span>
    <h1>Create your <em>account.</em></h1>
    <p class="sub">Manage your listing, see inquiries and upgrade your plan. We'll email you a link to verify your address and set your password.</p>
    <?= $E() ?>
    <form class="fm" method="POST" action="?p=register" data-validate>
      <input type="hidden" name="csrf" value="<?= $csrf ?>">
      <label for="n">Your name</label><input id="n" name="name" required minlength="2" maxlength="150" autocomplete="name">
      <label for="e">Email <em>(use the owner email from your listing)</em></label><input id="e" name="email" type="email" required autocomplete="email">
      <button class="dx-btn is-dark" type="submit">Send verification link</button>
    </form>
    <div class="ac-links"><a href="?p=login">I already have an account</a></div>
  </div>

<?php elseif ($p === 'setup'): $st = $_SESSION['hc_dir_setup'] ?? null; ?>
  <div class="ac-auth">
    <?php if ($st && $st['exp'] >= time()): ?>
    <span class="dx-label" style="margin-bottom:18px">Email verified ✓</span>
    <h1>Set your <em>password.</em></h1>
    <p class="sub">For <?= htmlspecialchars($st['email']) ?>. You'll use this to manage your listing.</p>
    <?= $E() ?>
    <form class="fm" method="POST" action="?p=setup" data-validate>
      <input type="hidden" name="csrf" value="<?= $csrf ?>">
      <label for="pw">Password <em>(8+ characters)</em></label><input id="pw" name="password" type="password" minlength="8" required autocomplete="new-password">
      <label for="pw2">Confirm password</label><input id="pw2" name="password2" type="password" minlength="8" required autocomplete="new-password" data-match="#pw" data-label="your password again">
      <button class="dx-btn is-dark" type="submit">Create my account</button>
    </form>
    <?php else: ?>
    <h1>This setup link <em>expired.</em></h1>
    <p class="sub">No problem. Create your account and we'll email you a fresh link.</p>
    <a class="dx-btn is-dark" href="?p=register" style="width:100%">Create an account</a>
    <?php endif ?>
  </div>

<?php elseif ($p === 'forgot'): ?>
  <div class="ac-auth">
    <h1>Reset your <em>password.</em></h1>
    <p class="sub">Enter your account email and we'll send you a link to choose a new password.</p>
    <?= $E() ?>
    <form class="fm" method="POST" action="?p=forgot" data-validate>
      <input type="hidden" name="csrf" value="<?= $csrf ?>">
      <label for="e">Owner email</label><input id="e" name="email" type="email" required autocomplete="email">
      <button class="dx-btn is-dark" type="submit">Email me a link</button>
    </form>
    <div class="ac-links"><a href="?p=login">Back to log in</a></div>
  </div>

<?php elseif ($p === 'reset'):
  $tok = preg_replace('/[^a-f0-9]/', '', $_GET['token'] ?? '');
  $ro = $tok ? hc_one("SELECT * FROM hc_directory_owners WHERE reset_token=? AND reset_sent_at > NOW() - INTERVAL 1 DAY", [$tok]) : null; ?>
  <div class="ac-auth">
    <?php if ($ro): ?>
    <h1>Choose a <em>password.</em></h1>
    <p class="sub">For <?= htmlspecialchars($ro['email']) ?></p>
    <?= $E() ?>
    <form class="fm" method="POST" action="?p=reset&token=<?= $tok ?>" data-validate>
      <input type="hidden" name="csrf" value="<?= $csrf ?>">
      <?php if (!$ro['name']): ?><label for="n">Your name</label><input id="n" name="name" autocomplete="name"><?php endif ?>
      <label for="pw">New password <em>(8+ characters)</em></label><input id="pw" name="password" type="password" minlength="8" required autocomplete="new-password">
      <label for="pw2">Confirm password</label><input id="pw2" name="password2" type="password" minlength="8" required autocomplete="new-password" data-match="#pw" data-label="your password again">
      <button class="dx-btn is-dark" type="submit">Save password &amp; continue</button>
    </form>
    <?php else: ?>
    <h1>This link has <em>expired.</em></h1>
    <p class="sub">Password links work for 24 hours. Request a new one below.</p>
    <a class="dx-btn is-dark" href="?p=forgot" style="width:100%">Request a new link</a>
    <?php endif ?>
  </div>

<?php elseif ($p === 'home'): ?>
  <div class="ac-top">
    <div><span class="dx-label" style="margin-bottom:16px">Owner dashboard</span><h1>Hi<?= $owner['name'] ? ' ' . htmlspecialchars(explode(' ', $owner['name'])[0]) : '' ?>, <em>welcome back.</em></h1></div>
    <div style="display:flex;gap:8px"><a class="dx-btn" href="/directory/submit/">Add another agency</a><a class="dx-btn" href="?p=logout">Log out</a></div>
  </div>
  <?= $F() ?>
  <?php if (!$mine): ?>
  <div class="ac-auth" style="max-width:none;text-align:center">
    <h1 style="font-size:28px">No listings linked yet</h1>
    <p class="sub">Listings appear here once you've confirmed ownership from the email we sent. If you submitted a listing with a different email, log in with that one.</p>
    <a class="dx-btn is-dark" href="/directory/submit/">List or claim your agency</a>
  </div>
  <?php endif ?>
  <?php foreach ($mine as $l): $tier = hc_dir_tier($l); ?>
  <div class="ac-card">
    <?= hc_dir_logo($l, 80) ?>
    <div style="min-width:0">
      <h3><?= htmlspecialchars($l['company_name']) ?></h3>
      <div class="ac-meta">
        <span><?= htmlspecialchars($l['city'] . ', ' . $l['state']) ?></span>
        <?php if ($l['status'] === 'approved'): ?><span class="pill g">Live</span><?php elseif ($l['status'] === 'pending'): ?><span class="pill y">Under review</span><?php else: ?><span class="pill r">Not published</span><?php endif ?>
        <span class="pill n"><?= htmlspecialchars($plans[$tier]['name']) ?> plan</span>
        <?php if ($l['requested_plan'] && $l['requested_plan'] !== $tier): ?><span class="pill y"><?= htmlspecialchars($plans[$l['requested_plan']]['name']) ?> requested · invoice <?= $l['payment_status'] === 'invoiced' ? 'sent' : 'coming' ?></span><?php endif ?>
        <?php if ($l['pending_edit']): ?><span class="pill y">Changes waiting for approval</span><?php elseif ($l['last_edit'] === 'rejected'): ?><span class="pill r">Last changes not approved</span><?php endif ?>
      </div>
      <div><?= hc_dir_rating_line($l) ?></div>
      <div class="ac-stats"><div><b><?= (int)$l['leads'] ?></b><span>inquiries</span></div><div><b><?= (int)$l['rating_count'] ?></b><span>reviews</span></div></div>
    </div>
    <div class="ac-acts">
      <a class="dx-btn is-dark" href="?p=edit&id=<?= $l['id'] ?>"><i class="fa-regular fa-pen-to-square"></i>Edit listing</a>
      <?php if ($l['status'] === 'approved'): ?><a class="dx-btn" href="/directory/<?= urlencode($l['slug']) ?>" target="_blank">View live page</a><?php endif ?>
      <?php if ($l['leads']): ?><a class="dx-btn" href="?p=leads&id=<?= $l['id'] ?>">Inquiries</a><?php endif ?>
    </div>
  </div>
  <?php foreach (hc_all("SELECT * FROM hc_directory_verifications WHERE listing_id=? AND status IN ('requested','rejected','submitted') ORDER BY id DESC LIMIT 1", [$l['id']]) as $vr): ?>
  <div class="ed-s" style="border:1.5px solid <?= $vr['status'] === 'submitted' ? 'var(--hair)' : '#e0a020' ?>">
    <?php if ($vr['status'] === 'submitted'): ?>
      <h2 style="margin-bottom:6px">Verification received ✓</h2>
      <p style="color:var(--mut);font-size:14.5px">We got your file on <?= date('M j', strtotime($vr['submitted_at'])) ?> and will review it shortly.</p>
    <?php else: ?>
      <h2 style="margin-bottom:6px"><?= $vr['status'] === 'rejected' ? 'Please send verification again' : 'Verification requested' ?></h2>
      <p style="color:var(--txt);font-size:15px;line-height:1.6;margin-bottom:6px"><?= nl2br(htmlspecialchars($vr['request_note'] ?: 'Please upload a short video or photo that shows you represent this agency, for example a photo of you holding your agency license, or a short video of your office sign.')) ?></p>
      <?php if ($vr['status'] === 'rejected' && $vr['admin_note']): ?><p style="color:#9b2c1f;font-size:14px;margin-bottom:6px">Note from our team: <?= htmlspecialchars($vr['admin_note']) ?></p><?php endif ?>
      <form class="fm" method="POST" action="?p=verify" enctype="multipart/form-data" style="margin-top:14px">
        <input type="hidden" name="csrf" value="<?= $csrf ?>"><input type="hidden" name="vid" value="<?= $vr['id'] ?>">
        <label>Photo or video <em>(JPG, PNG, HEIC, MP4, MOV · max <?= htmlspecialchars(ini_get('upload_max_filesize')) ?>)</em></label>
        <input type="file" name="file" accept="image/*,video/*" capture="environment" required>
        <label>Note <em>(optional)</em></label><input name="owner_note" maxlength="2000">
        <button class="dx-btn is-dark" type="submit" style="width:auto">Upload verification</button>
      </form>
    <?php endif ?>
  </div>
  <?php endforeach ?>
  <?php if ($tier === 'free' && !$l['requested_plan']): ?>
  <div class="up" id="upgrade">
    <?php foreach (['premium', 'featured'] as $pk): $pl = $plans[$pk]; ?>
    <form method="POST" action="?p=upgrade" class="<?= $pk === 'premium' ? 'pop' : '' ?>">
      <input type="hidden" name="csrf" value="<?= $csrf ?>"><input type="hidden" name="id" value="<?= $l['id'] ?>"><input type="hidden" name="plan" value="<?= $pk ?>">
      <h4><?= htmlspecialchars($pl['name']) ?> for <?= htmlspecialchars($l['company_name']) ?></h4>
      <div class="pr">$<?= $pl['price'] ?><small style="font-size:14px;color:var(--mut);font-weight:600"> / month</small></div>
      <ul><?php foreach (array_slice($pl['features'], 1, 4) as $ft): ?><li><i class="fa-solid fa-check"></i><?= htmlspecialchars($ft) ?></li><?php endforeach ?></ul>
      <button class="dx-btn <?= $pk === 'premium' ? 'is-teal' : 'is-dark' ?>" type="submit" style="width:100%">Upgrade to <?= htmlspecialchars($pl['name']) ?></button>
    </form>
    <?php endforeach ?>
  </div>
  <?php endif ?>
  <?php endforeach ?>

<?php elseif ($p === 'edit'):
  $id = (int)($_GET['id'] ?? 0);
  $l  = hc_one("SELECT * FROM hc_directory_listings WHERE id=? AND owner_account_id=?", [$id, $owner['id']]);
  if (!$l) { echo '<p>Listing not found.</p>'; } else {
    $pend = hc_one("SELECT * FROM hc_directory_edits WHERE listing_id=? AND status='pending' ORDER BY id DESC LIMIT 1", [$id]);
    // Show the pending version so owners keep editing on top of what they sent.
    $V = $pend ? array_merge($l, json_decode($pend['data'], true) ?: []) : $l;
    if ($_SERVER['REQUEST_METHOD'] === 'POST') $V = array_merge($V, array_map(fn($x) => is_array($x) ? implode("\n", $x) : $x, $_POST));
    $val = fn($k) => htmlspecialchars((string)($V[$k] ?? ''));
    $svc = hc_dir_lines($V['services'] ?? ''); $pay = hc_dir_lines($V['payment_accepted'] ?? ''); $fea = hc_dir_lines($V['features'] ?? '');
    $hrs = hc_dir_hours($V) ?? []; $paid = hc_dir_tier($l) !== 'free'; ?>
  <div class="ac-top">
    <div><div class="dx-crumbs" style="margin-bottom:14px"><a href="?p=home">Dashboard</a><i class="fa-solid fa-chevron-right"></i>Edit listing</div><h1>Edit <em><?= htmlspecialchars($l['company_name']) ?>.</em></h1></div>
  </div>
  <?= $E() ?>
  <?php if ($pend): ?><div class="msg ok">You have changes waiting for approval (sent <?= date('M j', strtotime($pend['created_at'])) ?>). The form shows them; saving again replaces that request.</div><?php endif ?>
  <form class="fm ed" method="POST" action="?p=edit&id=<?= $id ?>" enctype="multipart/form-data" data-validate>
    <input type="hidden" name="csrf" value="<?= $csrf ?>">
    <div>
      <div class="ed-s">
        <h2>About</h2>
        <label>Tagline <em><?= $paid ? '' : '(shows on Premium & Featured)' ?></em></label><input name="tagline" maxlength="160" value="<?= $val('tagline') ?>">
        <label for="o_desc">Description</label><textarea id="o_desc" name="description" rows="7" required minlength="40" maxlength="5000" data-label="a description of your agency"><?= $val('description') ?></textarea>
        <div class="row2">
          <div><label>License number</label><input name="license_number" value="<?= $val('license_number') ?>"></div>
          <div><label for="o_years">Years in business</label><input id="o_years" name="years_in_business" type="number" min="0" max="150" inputmode="numeric" value="<?= $val('years_in_business') ?>"></div>
        </div>
        <label>Languages spoken</label><input name="languages" data-tags value="<?= $val('languages') ?>" placeholder="Type a language and press Enter">
      </div>
      <div class="ed-s">
        <h2>Services &amp; highlights</h2>
        <label>Services</label>
        <div class="chks" data-min-checked="1" data-also-field="#o_svc_other" data-req="Please choose at least one service."><?php foreach (HC_DIR_SERVICES as $x): ?><label class="chk"><input type="checkbox" name="services[]" value="<?= htmlspecialchars($x) ?>" <?= in_array($x, $svc, true) ? 'checked' : '' ?>><?= htmlspecialchars($x) ?></label><?php endforeach ?></div>
        <input id="o_svc_other" name="services_other" value="<?= htmlspecialchars(implode(', ', array_diff($svc, HC_DIR_SERVICES))) ?>" placeholder="Other services, comma separated">
        <label>Highlights</label>
        <div class="chks"><?php foreach (HC_DIR_FEATURES as $x => $ic): ?><label class="chk"><input type="checkbox" name="features[]" value="<?= htmlspecialchars($x) ?>" <?= in_array($x, $fea, true) ? 'checked' : '' ?>><?= htmlspecialchars($x) ?></label><?php endforeach ?></div>
        <label>Payment accepted</label>
        <div class="chks"><?php foreach (HC_DIR_PAYMENTS as $x): ?><label class="chk"><input type="checkbox" name="payment_accepted[]" value="<?= htmlspecialchars($x) ?>" <?= in_array($x, $pay, true) ? 'checked' : '' ?>><?= htmlspecialchars($x) ?></label><?php endforeach ?></div>
      </div>
      <div class="ed-s">
        <h2>Contact &amp; location</h2>
        <div class="row2">
          <div><label for="o_phone">Phone</label><input id="o_phone" name="phone" type="tel" data-phone required autocomplete="tel" value="<?= $val('phone') ?>" placeholder="(555) 123-4567"></div>
          <div><label for="o_email">Email <em><?= $paid ? '' : '(shows on Premium & Featured)' ?></em></label><input id="o_email" name="email" type="email" value="<?= $val('email') ?>" placeholder="office@youragency.com"></div>
        </div>
        <label for="o_web">Website <em><?= $paid ? '' : '(linked on Premium & Featured)' ?></em></label><input id="o_web" name="website" data-url value="<?= $val('website') ?>" placeholder="youragency.com">
        <label>Street address <em>(leave blank if you only serve clients at home)</em></label><input name="address" value="<?= $val('address') ?>">
        <label>Service areas <em>(cities or counties you serve)</em></label><input name="service_areas" data-tags value="<?= $val('service_areas') ?>" placeholder="Type a city and press Enter">
      </div>
      <div class="ed-s">
        <h2>Office hours</h2>
        <label class="chk" style="margin-bottom:14px"><input type="checkbox" name="hours_always" value="1" <?= !empty($hrs['always']) ? 'checked' : '' ?>>Open 24 hours, 7 days</label>
        <div class="hrs">
          <?php foreach (HC_DIR_DAYS as $dk => $dl): $hv = empty($hrs['always']) ? ($hrs[$dk] ?? null) : null; ?>
          <b style="font-size:14px"><?= $dl ?></b>
          <input type="time" name="h_<?= $dk ?>_open" value="<?= htmlspecialchars($hv[0] ?? '') ?>" aria-label="<?= $dl ?> opens">
          <input type="time" name="h_<?= $dk ?>_close" value="<?= htmlspecialchars($hv[1] ?? '') ?>" aria-label="<?= $dl ?> closes">
          <label><input type="checkbox" name="h_<?= $dk ?>_closed" value="1" <?= $hrs && empty($hrs['always']) && !$hv ? 'checked' : '' ?>>Closed</label>
          <?php endforeach ?>
        </div>
        <label>Hours note <em>(optional)</em></label><input name="hours" value="<?= $val('hours') ?>" placeholder="e.g. Care available 24/7, office Mon–Fri">
      </div>
      <div class="ed-s">
        <h2>Photos</h2>
        <div class="row2">
          <div><?= hc_dir_image_field('logo', 'Logo', false, array_filter([$V['logo'] ?? '']), 'Square or wide logo · PNG, JPG or WEBP · up to 5 MB') ?></div>
          <div><?= hc_dir_image_field('cover', 'Cover photo' . ($paid ? '' : ' (Premium & Featured)'), false, array_filter([$V['cover_image'] ?? '']), 'Wide photo, 1600×600 or larger') ?></div>
        </div>
        <?= hc_dir_image_field('photos', 'Gallery' . ($paid ? '' : ' (Premium & Featured)'), true, hc_dir_lines($V['photos'] ?? ''), 'PNG, JPG or WEBP · up to 5 MB each', 12) ?>
      </div>
    </div>
    <div class="ed-side">
      <div class="ed-s">
        <h2>Send for review</h2>
        <p>Your changes go to our team first and appear on your live listing once they're approved, usually within 1 business day. We'll email you when they're live.</p>
        <button class="dx-btn is-dark" type="submit">Submit changes</button>
        <a class="dx-btn" href="?p=home" style="width:100%;margin-top:8px">Cancel</a>
      </div>
      <?php if (!$paid): ?><?= hc_dir_hc_ad('side') ?><?php endif ?>
    </div>
  </form>
  <?php } ?>

<?php elseif ($p === 'leads'):
  $id = (int)($_GET['id'] ?? 0);
  $l  = hc_one("SELECT * FROM hc_directory_listings WHERE id=? AND owner_account_id=?", [$id, $owner['id']]);
  $rows = $l ? hc_all("SELECT * FROM hc_directory_leads WHERE listing_id=? ORDER BY created_at DESC LIMIT 200", [$id]) : []; ?>
  <div class="ac-top"><div><div class="dx-crumbs" style="margin-bottom:14px"><a href="?p=home">Dashboard</a><i class="fa-solid fa-chevron-right"></i>Inquiries</div><h1>Inquiries for <em><?= htmlspecialchars($l['company_name'] ?? '') ?>.</em></h1></div></div>
  <table class="lt">
    <thead><tr><th>Date</th><th>Name</th><th>Contact</th><th>Care for</th><th>Message</th></tr></thead>
    <tbody>
    <?php foreach ($rows as $r): ?>
    <tr><td><?= date('M j, Y g:ia', strtotime($r['created_at'])) ?></td><td><?= htmlspecialchars($r['name']) ?></td>
        <td><a href="tel:<?= htmlspecialchars(preg_replace('/[^0-9+]/', '', $r['phone'])) ?>"><?= htmlspecialchars($r['phone']) ?></a><?= $r['email'] ? '<br><a href="mailto:' . htmlspecialchars($r['email']) . '">' . htmlspecialchars($r['email']) . '</a>' : '' ?></td>
        <td><?= htmlspecialchars($r['care_for']) ?></td><td><?= nl2br(htmlspecialchars($r['message'])) ?></td></tr>
    <?php endforeach ?>
    <?php if (!$rows): ?><tr><td colspan="5" style="color:var(--mut)">No inquiries yet.</td></tr><?php endif ?>
    </tbody>
  </table>
<?php endif ?>

</div></section></div></div>
<?php if ($owner && $p === 'home'): echo hc_dir_popup_html(); endif; ?>
<?= hc_dir_form_kit() ?>
<?php include '../../includes/footer.php'; ?>
