<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/mailer.php';
require_once dirname(__DIR__) . '/includes/directory.php';
hc_require_auth();
hc_dir_ensure_schema();

$id      = (int)($_GET['id'] ?? 0);
$listing = $id ? hc_one("SELECT * FROM hc_directory_listings WHERE id=?", [$id]) : null;
$plans   = hc_dir_plans();

// ── Quick actions ────────────────────────────────────────────────────────────
$do = $_GET['do'] ?? '';
if ($listing && $do) {
    $back = '/admin/directory/edit.php?id=' . $id;
    switch ($do) {
        case 'approve':
            $was = $listing['status'] === 'approved';
            hc_q("UPDATE hc_directory_listings SET status='approved', approved_at=IFNULL(approved_at,NOW()), rejection_reason=NULL WHERE id=?", [$id]);
            hc_flash('Listing approved and live.' . (!$was && hc_dir_send_approved($id) ? ' The agency was emailed.' : ''));
            break;
        case 'invoiced':
            hc_q("UPDATE hc_directory_listings SET payment_status='invoiced' WHERE id=?", [$id]);
            hc_flash('Marked as invoiced.');
            break;
        case 'paid':
            $months = max(1, min(12, (int)($_GET['months'] ?? 1)));
            hc_dir_mark_paid($id, $months);
            hc_flash("Payment recorded. The paid plan is active for {$months} more month(s).");
            break;
        case 'resend':
            hc_flash(hc_dir_send_owner_confirmation($id) ? 'Confirmation email sent to ' . $listing['owner_email'] . '.' : 'Could not send. Check that there is an owner email and that SMTP is set up.', 'error');
            break;
        case 'fetch_logo':
            hc_flash(hc_dir_fetch_logo($id) ? 'Logo fetched from the website.' : 'No usable logo found on the website (or no website set). Upload one manually.', 'error');
            break;
        case 'geocode':
            hc_flash(hc_dir_geocode($id) ? 'Map location found.' : 'Could not find this address on the map.', 'error');
            break;
        case 'rv_approve': case 'rv_reject': case 'rv_delete':
            $rid = (int)($_GET['rid'] ?? 0);
            if ($do === 'rv_delete') hc_q("DELETE FROM hc_directory_reviews WHERE id=? AND listing_id=?", [$rid, $id]);
            else hc_q("UPDATE hc_directory_reviews SET status=?, approved_at=IF(?='approved', IFNULL(approved_at,NOW()), approved_at) WHERE id=? AND listing_id=?", [$do === 'rv_approve' ? 'approved' : 'rejected', $do === 'rv_approve' ? 'approved' : 'rejected', $rid, $id]);
            hc_dir_recalc_rating($id);
            hc_flash('Review updated.');
            $back .= '#reviews';
            break;
        case 'verify_request':
            $note = trim((string)($_POST['vnote'] ?? $_GET['vnote'] ?? ''));
            hc_q("INSERT INTO hc_directory_verifications (listing_id, request_note) VALUES (?, ?)", [$id, $note ?: null]);
            $to = $listing['owner_email'];
            if ($to) {
                $url = 'https://homecarecreators.com/directory/account/';
                $msgHtml = '<p>To keep our directory trustworthy, we\'d like a quick verification for <strong>' . h($listing['company_name']) . '</strong>.</p>'
                    . '<p style="background:#f6f8f6;border-radius:8px;padding:14px 16px">' . nl2br(h($note ?: 'Please upload a short video or photo that shows you represent this agency, for example a photo of you holding your agency license, or a short video of your office sign.')) . '</p>'
                    . '<p>Log in to your owner account to upload it from your phone or computer. Don\'t have an account yet? Use "Create an account" with this email address.</p>';
                HcMailer::send($to, "Verification request — {$listing['company_name']}", "We'd like a quick verification for {$listing['company_name']}.\n\n" . ($note ?: 'Please upload a short video or photo that shows you represent this agency.') . "\n\nUpload it here: {$url}\n", 'info@homecarecreators.com', '', hc_dir_email_html('Verification request', $listing['company_name'], $msgHtml, 'Upload verification', $url));
            }
            hc_flash('Verification requested' . ($to ? ' and the owner was emailed.' : '. Note: this listing has no owner email, so nobody was notified.'));
            $back .= '#verification';
            break;
        case 'verify_approve': case 'verify_reject':
            $vid = (int)($_GET['vid'] ?? 0);
            if ($do === 'verify_approve') {
                hc_q("UPDATE hc_directory_verifications SET status='approved', reviewed_at=NOW() WHERE id=? AND listing_id=?", [$vid, $id]);
                hc_q("UPDATE hc_directory_listings SET verified=1 WHERE id=?", [$id]);
                if ($listing['owner_account_id']) hc_dir_notify_owner((int)$listing['owner_account_id'], "You're verified — {$listing['company_name']}", 'Verification approved', '<p>Thanks! <strong>' . h($listing['company_name']) . '</strong> is now verified.</p>', "Thanks! {$listing['company_name']} is now verified.");
                hc_flash('Verification approved. The listing is marked as verified.');
            } else {
                $note = trim((string)($_GET['vnote'] ?? ''));
                hc_q("UPDATE hc_directory_verifications SET status='rejected', admin_note=?, reviewed_at=NOW() WHERE id=? AND listing_id=?", [$note ?: null, $vid, $id]);
                if ($listing['owner_account_id']) hc_dir_notify_owner((int)$listing['owner_account_id'], "Please re-send your verification — {$listing['company_name']}", 'Verification needs another try', '<p>We couldn\'t verify <strong>' . h($listing['company_name']) . '</strong> from the file you sent.</p>' . ($note ? '<p><strong>Note:</strong> ' . h($note) . '</p>' : '') . '<p>Please upload a new photo or video from your dashboard.</p>', "We couldn't verify {$listing['company_name']} from the file you sent." . ($note ? " Note: {$note}" : '') . " Please upload a new one.");
                hc_flash('Verification rejected. The owner can upload again.');
            }
            $back .= '#verification';
            break;
        case 'delete':
            hc_q("DELETE FROM hc_directory_leads WHERE listing_id=?", [$id]);
            hc_q("DELETE FROM hc_directory_reviews WHERE listing_id=?", [$id]);
            hc_q("DELETE FROM hc_directory_listings WHERE id=?", [$id]);
            hc_flash('Listing "' . $listing['company_name'] . '" deleted.');
            $back = '/admin/directory/';
            break;
    }
    header('Location: ' . $back); exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $f = fn($k) => trim((string)($_POST[$k] ?? ''));
    $company_name = $f('company_name');
    $slug         = hc_slug($f('slug') ?: $company_name);
    $state        = strtoupper(substr($f('state') ?: 'FL', 0, 2));
    $status       = in_array($_POST['status'] ?? '', ['pending', 'approved', 'rejected'], true) ? $_POST['status'] : 'pending';
    $plan         = isset($plans[$_POST['plan'] ?? '']) ? $_POST['plan'] : 'free';
    $requested    = isset($plans[$_POST['requested_plan'] ?? '']) ? $_POST['requested_plan'] : null;
    $pay_status   = isset(HC_DIR_PAYMENT_STATUSES[$_POST['payment_status'] ?? '']) ? $_POST['payment_status'] : 'none';
    $paid_until   = preg_match('/^\d{4}-\d{2}-\d{2}$/', $f('paid_until')) ? $f('paid_until') : null;
    $services     = implode("\n", array_unique(array_merge(
        array_values(array_intersect((array)($_POST['services'] ?? []), HC_DIR_SERVICES)),
        hc_dir_areas($f('services_other'))
    )));
    $payments     = implode("\n", array_values(array_intersect((array)($_POST['payment_accepted'] ?? []), HC_DIR_PAYMENTS)));
    $owner_email  = $f('owner_email');
    $owner_changed = $listing && strcasecmp((string)$listing['owner_email'], $owner_email) !== 0;
    $website      = $f('website');
    if ($website && !preg_match('#^https?://#i', $website)) $website = 'https://' . $website;

    $fields = [
        'company_name' => $company_name, 'slug' => $slug, 'logo' => $f('logo'), 'cover_image' => $f('cover_image'),
        'photos' => implode("\n", hc_dir_lines($_POST['photos'] ?? '')), 'tagline' => mb_substr($f('tagline'), 0, 160),
        'description' => $f('description'), 'services' => $services, 'payment_accepted' => $payments,
        'languages' => $f('languages'), 'hours' => $f('hours_text'),
        'city' => $f('city'), 'state' => $state, 'service_areas' => $f('service_areas'), 'address' => $f('address'),
        'phone' => $f('phone'), 'email' => $f('email'), 'website' => $website,
        'license_number' => $f('license_number'), 'years_in_business' => $f('years_in_business'),
        'verified' => isset($_POST['verified']) ? 1 : 0, 'status' => $status,
        'plan' => $plan, 'requested_plan' => $requested, 'payment_status' => $pay_status, 'paid_until' => $paid_until,
        'invoice_ref' => $f('invoice_ref'), 'featured' => $plan === 'featured' ? 1 : 0,
        'owner_name' => $f('owner_name'), 'owner_title' => $f('owner_title'), 'owner_email' => $owner_email, 'owner_phone' => $f('owner_phone'),
        'admin_notes' => $f('admin_notes'),
        'owner_authorized' => !empty($_POST['owner_authorized']) ? 1 : 0,
        'claim_status' => in_array($_POST['claim_status'] ?? '', ['pending', 'confirmed', 'verified'], true) ? $_POST['claim_status'] : null,
        'rejection_reason' => $status === 'rejected' ? (mb_substr($f('rejection_reason'), 0, 500) ?: null) : null,
        'features' => implode("\n", array_values(array_intersect((array)($_POST['features'] ?? []), array_keys(HC_DIR_FEATURES)))),
        'hours_json' => hc_dir_hours_from_input(!empty($_POST['hours_always']), (array)($_POST['hours'] ?? [])),
        'lat' => is_numeric($_POST['lat'] ?? '') ? (float)$_POST['lat'] : null,
        'lng' => is_numeric($_POST['lng'] ?? '') ? (float)$_POST['lng'] : null,
    ];
    $locChanged = !$listing || $listing['address'] !== $fields['address'] || $listing['city'] !== $fields['city'] || $listing['state'] !== $fields['state'];
    if ($owner_changed) { $fields['owner_confirmed_at'] = null; $fields['confirm_token'] = null; }
    if (!empty($_POST['mark_confirmed'])) { $fields['owner_confirmed_at'] = date('Y-m-d H:i:s'); $fields['confirm_token'] = null; }
    if (!empty($_POST['clear_confirmed'])) { $fields['owner_confirmed_at'] = null; }

    if (!$company_name || !$fields['description'] || !$fields['city']) {
        hc_flash('Agency name, description and city are required.', 'error');
    } elseif ($owner_email && !filter_var($owner_email, FILTER_VALIDATE_EMAIL)) {
        hc_flash('Owner email is not valid.', 'error');
    } else {
        try {
            $base = $slug; $n = 2;
            while (hc_val("SELECT id FROM hc_directory_listings WHERE slug=? AND id<>?", [$fields['slug'], $id])) $fields['slug'] = $base . '-' . $n++;
            $wasApproved = $listing && $listing['status'] === 'approved';
            if ($id) {
                $set = implode(',', array_map(fn($k) => "`$k`=?", array_keys($fields)));
                hc_q("UPDATE hc_directory_listings SET $set, approved_at=" . ($status === 'approved' ? "IFNULL(approved_at,NOW())" : "NULL") . " WHERE id=?",
                    [...array_values($fields), $id]);
            } else {
                $cols = implode(',', array_map(fn($k) => "`$k`", array_keys($fields)));
                $ph   = implode(',', array_fill(0, count($fields), '?'));
                hc_q("INSERT INTO hc_directory_listings ($cols, approved_at) VALUES ($ph, " . ($status === 'approved' ? "NOW()" : "NULL") . ")", array_values($fields));
                $id = (int)hc_db()->lastInsertId();
            }
            $msg = 'Listing saved.';
            $websiteChanged = !$listing || ($listing['website'] ?? '') !== $fields['website'];
            if ($fields['website'] && (!empty($_POST['do_logo']) || (!$fields['logo'] && $websiteChanged))) {
                $msg .= hc_dir_fetch_logo($id) ? ' Logo fetched from the website.' : ' (No usable logo found on the website. Upload one manually.)';
            } elseif ($fields['logo'] && preg_match('#^https?://#i', $fields['logo']) && !empty($_POST['do_logo'])) {
                if ($p = hc_dir_store_logo($fields['logo'], $fields['slug'])) { hc_q("UPDATE hc_directory_listings SET logo=? WHERE id=?", [$p, $id]); $msg .= ' Logo saved locally.'; }
            }
            if (!empty($_POST['do_geocode']) || ($locChanged && $fields['lat'] === null)) {
                $msg .= hc_dir_geocode($id) ? ' Map location found.' : ' (Could not find this address on the map.)';
            }
            if (!empty($_POST['send_confirm']) && $owner_email) {
                $msg .= hc_dir_send_owner_confirmation($id) ? ' Confirmation email sent to ' . $owner_email . '.' : ' (Confirmation email failed. Check SMTP.)';
            }
            if ($status === 'approved' && !$wasApproved && !empty($_POST['notify_approved'])) {
                $msg .= hc_dir_send_approved($id) ? ' Approval email sent.' : '';
            }
            hc_flash($msg);
            header('Location: /admin/directory/edit.php?id=' . $id); exit;
        } catch (Exception $e) {
            hc_flash('Error: ' . $e->getMessage(), 'error');
        }
    }
    $listing = array_merge($listing ?? [], $fields);
}

$L = $listing ?? [];
$v = fn($k, $d = '') => h($L[$k] ?? $d);
$svcSel = hc_dir_lines($L['services'] ?? '');
$svcOther = array_values(array_diff($svcSel, HC_DIR_SERVICES));
$paySel = hc_dir_lines($L['payment_accepted'] ?? '');
$featSel = hc_dir_lines($L['features'] ?? '');
$hrs = hc_dir_hours($L) ?? [];
$tier = $listing ? hc_dir_tier($L) : 'free';
$leads = $id ? hc_all("SELECT * FROM hc_directory_leads WHERE listing_id=? ORDER BY created_at DESC LIMIT 10", [$id]) : [];
$reviewsAll = $id ? hc_all("SELECT * FROM hc_directory_reviews WHERE listing_id=? ORDER BY created_at DESC LIMIT 30", [$id]) : [];
$verifs = $id ? hc_all("SELECT * FROM hc_directory_verifications WHERE listing_id=? ORDER BY id DESC LIMIT 10", [$id]) : [];
$acct = !empty($L['owner_account_id']) ? hc_one("SELECT * FROM hc_directory_owners WHERE id=?", [$L['owner_account_id']]) : null;
$pendEdit = $id ? hc_one("SELECT id, created_at FROM hc_directory_edits WHERE listing_id=? AND status='pending' ORDER BY id DESC LIMIT 1", [$id]) : null;
$qa = fn($d, $extra = '') => '/admin/directory/edit.php?id=' . $id . '&do=' . $d . $extra;

$title_val = $listing && $id ? 'Edit: ' . $L['company_name'] : 'Add Listing';
hc_head($title_val);
hc_topbar($title_val, '<a href="/admin/">Admin</a> › <a href="/admin/directory/">Directory</a> › ' . ($id ? 'Edit' : 'New'));
?>
<style>
.feat-dropzone{width:100%;min-height:110px;border:2px dashed var(--border);border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;transition:.2s;position:relative;overflow:hidden;background:var(--cream)}
.feat-dropzone:hover,.feat-dropzone.drag{border-color:var(--teal);background:rgba(29,158,117,.04)}
.feat-dropzone img{max-width:100%;max-height:140px;display:block;border-radius:8px}
.feat-dropzone .dz-label{font-size:13px;color:var(--muted);text-align:center;padding:20px;pointer-events:none}
.chk-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:6px 14px}
.chk-grid label{display:flex;align-items:center;gap:8px;font-size:13.5px;font-weight:400;cursor:pointer;margin:0}
.chk-grid input{width:auto}
.owner-status{display:flex;align-items:center;gap:8px;padding:10px 12px;border-radius:8px;font-size:13px;margin-bottom:14px}
.owner-status.ok{background:rgba(29,158,117,.1);color:#0d7a57}
.owner-status.no{background:rgba(217,119,6,.1);color:#92400e}
.photo-strip{display:flex;gap:6px;flex-wrap:wrap;margin-top:8px}
.photo-strip img{width:64px;height:48px;object-fit:cover;border-radius:6px;border:1px solid var(--border)}
.lead-row{padding:10px 0;border-top:1px solid var(--border);font-size:13px}
.lead-row:first-child{border-top:0}
.qa{display:flex;flex-wrap:wrap;gap:6px}
.meta{display:grid;grid-template-columns:105px 1fr;gap:6px 10px;margin:0;font-size:12.5px}
.meta dt{color:var(--muted)}
.meta dd{margin:0;min-width:0;overflow-wrap:anywhere}
.tier-pill{display:inline-block;font-size:11px;font-weight:700;padding:3px 8px;border-radius:5px;margin-left:6px}
@media(max-width:1100px){.dir-edit-grid{grid-template-columns:1fr!important}.chk-grid{grid-template-columns:1fr 1fr}}
</style>
<div class="page-content">
<?= hc_show_flash() ?>
<?php if (!empty($pendEdit)): ?><div class="alert alert-info">The owner submitted changes on <?= date('M j, g:ia', strtotime($pendEdit['created_at'])) ?> that are waiting for approval. <a href="/admin/directory/requests.php"><strong>Review changes →</strong></a></div><?php endif ?>

<form method="POST">
<div class="dir-edit-grid" style="display:grid;grid-template-columns:1fr 340px;gap:20px;align-items:start">

<!-- MAIN COLUMN -->
<div>
  <div class="card">
    <div class="form-group" style="margin-bottom:10px">
      <label>Agency Name</label>
      <input type="text" name="company_name" value="<?= $v('company_name') ?>" placeholder="e.g. Sunshine Home Care Services" required
             style="font-size:18px;font-weight:700;padding:12px 14px" oninput="autoSlug(this.value)">
    </div>
    <div style="display:flex;align-items:center;gap:6px;padding:0 2px 4px">
      <span style="font-size:13px;color:var(--muted);white-space:nowrap">/directory/</span>
      <input type="text" id="co-slug" name="slug" value="<?= $v('slug') ?>" <?= $id ? 'data-locked=1' : '' ?>
             placeholder="auto-generated-slug" style="flex:1;font-size:13px;font-family:monospace;padding:6px 10px" oninput="this.dataset.locked=1">
    </div>
  </div>

  <div class="card">
    <div class="form-group">
      <label>Tagline <span>(Premium/Featured only, max 160 chars)</span></label>
      <input type="text" name="tagline" maxlength="160" value="<?= $v('tagline') ?>" placeholder="Compassionate in-home care across Central Florida since 2014">
    </div>
    <div class="form-group">
      <label>Description <span>(required, shown on the listing page)</span></label>
      <textarea name="description" rows="6" required><?= $v('description') ?></textarea>
    </div>
    <div class="form-group">
      <label>Services</label>
      <div class="chk-grid">
        <?php foreach (HC_DIR_SERVICES as $s): ?>
        <label><input type="checkbox" name="services[]" value="<?= h($s) ?>" <?= in_array($s, $svcSel, true) ? 'checked' : '' ?>><?= h($s) ?></label>
        <?php endforeach ?>
      </div>
      <input type="text" name="services_other" value="<?= h(implode(', ', $svcOther)) ?>" placeholder="Other services, comma-separated" style="margin-top:10px">
    </div>
    <div class="form-group" style="margin-bottom:0">
      <label>Payment accepted</label>
      <div class="chk-grid">
        <?php foreach (HC_DIR_PAYMENTS as $p): ?>
        <label><input type="checkbox" name="payment_accepted[]" value="<?= h($p) ?>" <?= in_array($p, $paySel, true) ? 'checked' : '' ?>><?= h($p) ?></label>
        <?php endforeach ?>
      </div>
    </div>
  </div>

  <div class="card">
    <div class="form-group">
      <label>Highlights <span>(shown with icons, and used as search filters)</span></label>
      <div class="chk-grid">
        <?php foreach (HC_DIR_FEATURES as $fk => $ic): ?>
        <label><input type="checkbox" name="features[]" value="<?= h($fk) ?>" <?= in_array($fk, $featSel, true) ? 'checked' : '' ?>><?= h($fk) ?></label>
        <?php endforeach ?>
      </div>
    </div>
    <div class="form-group" style="margin-bottom:0">
      <label>Office hours <span>(powers "Open now")</span></label>
      <label style="display:flex;align-items:center;gap:8px;font-weight:400;margin:6px 0 10px;cursor:pointer"><input type="checkbox" name="hours_always" value="1" style="width:auto" <?= !empty($hrs['always']) ? 'checked' : '' ?> onchange="document.getElementById('hrsGrid').style.opacity=this.checked?.4:1">Open 24 hours, 7 days</label>
      <div id="hrsGrid" style="display:grid;grid-template-columns:60px 1fr 1fr 90px;gap:6px 10px;align-items:center;max-width:520px;<?= !empty($hrs['always']) ? 'opacity:.4' : '' ?>">
        <?php foreach (HC_DIR_DAYS as $dk => $dl): $v = empty($hrs['always']) ? ($hrs[$dk] ?? null) : null; ?>
        <strong style="font-size:13px"><?= $dl ?></strong>
        <input type="time" name="hours[<?= $dk ?>][open]" value="<?= h($v[0] ?? '') ?>">
        <input type="time" name="hours[<?= $dk ?>][close]" value="<?= h($v[1] ?? '') ?>">
        <label style="display:flex;align-items:center;gap:6px;font-weight:400;font-size:13px;margin:0"><input type="checkbox" name="hours[<?= $dk ?>][closed]" value="1" style="width:auto" <?= $hrs && empty($hrs['always']) && !$v ? 'checked' : '' ?>>Closed</label>
        <?php endforeach ?>
      </div>
      <div class="form-hint">Leave all times empty if hours are unknown.</div>
      <input type="text" name="hours_text" value="<?= $v('hours') ?>" placeholder="Optional note, e.g. 'Care available 24/7, office Mon–Fri'" style="margin-top:10px">
    </div>
  </div>

  <div class="card">
    <div class="form-grid">
      <div class="form-group"><label>City</label><input type="text" name="city" value="<?= $v('city') ?>" required></div>
      <div class="form-group"><label>State</label><input type="text" name="state" value="<?= $v('state', 'FL') ?>" maxlength="2" style="text-transform:uppercase"></div>
    </div>
    <div class="form-group"><label>Street address <span>(optional)</span></label><input type="text" name="address" value="<?= $v('address') ?>"></div>
    <div class="form-group"><label>Service areas <span>(comma-separated)</span></label><textarea name="service_areas" rows="2"><?= $v('service_areas') ?></textarea></div>
    <div class="form-grid">
      <div class="form-group"><label>Map latitude</label><input type="text" name="lat" value="<?= $v('lat') ?>" placeholder="auto"></div>
      <div class="form-group"><label>Map longitude</label><input type="text" name="lng" value="<?= $v('lng') ?>" placeholder="auto"></div>
    </div>
    <label style="display:flex;align-items:center;gap:8px;font-size:13px;margin:-6px 0 14px;cursor:pointer"><input type="checkbox" name="do_geocode" value="1" style="width:auto">Look up map location from address on save <span style="color:var(--muted)">(happens automatically when the address changes)</span></label>
    <div class="form-grid">
      <div class="form-group"><label>Languages</label><input type="text" name="languages" value="<?= $v('languages') ?>" placeholder="English, Spanish"></div>
      <div class="form-group"><label>Hours</label><input type="text" name="hours" value="<?= $v('hours') ?>" placeholder="24/7"></div>
    </div>
    <div class="form-grid">
      <div class="form-group"><label>Agency phone</label><input type="text" name="phone" value="<?= $v('phone') ?>"></div>
      <div class="form-group"><label>Agency email <span>(shown on paid plans)</span></label><input type="email" name="email" value="<?= $v('email') ?>"></div>
    </div>
    <div class="form-group"><label>Website <span>(linked on paid plans)</span></label><input type="text" name="website" value="<?= $v('website') ?>" placeholder="https://"></div>
    <div class="form-grid" style="margin-bottom:0">
      <div class="form-group" style="margin-bottom:0"><label>License number</label><input type="text" name="license_number" value="<?= $v('license_number') ?>"></div>
      <div class="form-group" style="margin-bottom:0"><label>Years in business</label><input type="text" name="years_in_business" value="<?= $v('years_in_business') ?>"></div>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:4px">Images <span style="font-weight:400;color:var(--muted)">(logo shows on every plan; cover &amp; gallery on Premium/Featured)</span></div>
    <div class="form-hint" style="margin-bottom:14px">Drop an image or paste a URL.</div>
    <div class="form-grid">
      <div>
        <label style="font-size:13px;font-weight:600">Logo</label>
        <div class="feat-dropzone" data-target="logo" onclick="pick('logo')" ondragover="event.preventDefault();this.classList.add('drag')" ondragleave="this.classList.remove('drag')" ondrop="dropImg(event,'logo')">
          <?= !empty($L['logo']) ? '<img src="' . h($L['logo']) . '" alt="">' : '<div class="dz-label">Upload logo</div>' ?>
        </div>
        <input type="text" id="f-logo" name="logo" value="<?= $v('logo') ?>" placeholder="Image URL" style="margin-top:8px">
        <label style="display:flex;align-items:center;gap:8px;font-size:12.5px;margin-top:8px;cursor:pointer;font-weight:400"><input type="checkbox" name="do_logo" value="1" style="width:auto">Fetch logo from website on save</label>
      </div>
      <div>
        <label style="font-size:13px;font-weight:600">Cover photo <span style="font-weight:400;color:var(--muted)">(wide, 1600×500+)</span></label>
        <div class="feat-dropzone" data-target="cover_image" onclick="pick('cover_image')" ondragover="event.preventDefault();this.classList.add('drag')" ondragleave="this.classList.remove('drag')" ondrop="dropImg(event,'cover_image')">
          <?= !empty($L['cover_image']) ? '<img src="' . h($L['cover_image']) . '" alt="">' : '<div class="dz-label">Upload cover</div>' ?>
        </div>
        <input type="text" id="f-cover_image" name="cover_image" value="<?= $v('cover_image') ?>" placeholder="Image URL" style="margin-top:8px">
      </div>
    </div>
    <div class="form-group" style="margin:14px 0 0">
      <label>Gallery photos <span>(one URL per line, up to 9)</span> · <a href="#" onclick="pick('photos');return false">upload</a></label>
      <textarea id="f-photos" name="photos" rows="3" style="font-family:monospace;font-size:12px"><?= $v('photos') ?></textarea>
      <div class="photo-strip" id="photoStrip"><?php foreach (hc_dir_lines($L['photos'] ?? '') as $p): ?><img src="<?= h($p) ?>" alt=""><?php endforeach ?></div>
    </div>
    <input type="file" id="imgPicker" accept="image/*" style="display:none">
    <div class="form-hint" id="imgStatus"></div>
  </div>
</div>

<!-- SIDEBAR -->
<div style="display:flex;flex-direction:column;gap:16px">

  <div class="card">
    <div class="card-title" style="margin-bottom:14px">Publish</div>
    <div class="form-group">
      <label>Status</label>
      <select name="status">
        <?php foreach (['pending' => 'Pending review', 'approved' => 'Approved (live)', 'rejected' => 'Rejected'] as $k => $lab): ?>
        <option value="<?= $k ?>" <?= ($L['status'] ?? 'pending') === $k ? 'selected' : '' ?>><?= $lab ?></option>
        <?php endforeach ?>
      </select>
    </div>
    <div class="form-group" id="rejWrap" style="<?= ($L['status'] ?? '') === 'rejected' ? '' : 'display:none' ?>">
      <label>Rejection reason <span>(internal)</span></label>
      <input type="text" name="rejection_reason" value="<?= $v('rejection_reason') ?>" placeholder="e.g. Duplicate, no license, no logo">
    </div>
    <?php if (($L['status'] ?? '') !== 'approved'): ?>
    <label style="display:flex;align-items:center;gap:8px;font-size:13px;margin-bottom:10px;cursor:pointer"><input type="checkbox" name="notify_approved" value="1" checked style="width:auto">Email the agency when approved</label>
    <?php endif ?>
    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer"><input type="checkbox" name="verified" value="1" <?= !empty($L['verified']) ? 'checked' : '' ?> style="width:auto">License verified <span style="color:var(--muted)">(Verified badge on paid plans)</span></label>
    <?php if ($id): ?><div class="form-hint" style="margin-top:10px">Rating: <strong><?= !empty($L['rating_count']) ? h($L['rating_avg']) . '★ from ' . (int)$L['rating_count'] . ' review(s)' : 'no reviews yet' ?></strong> · <a href="/admin/directory/reviews.php?view=all">Manage reviews</a></div><?php endif ?>
    <div style="display:flex;flex-direction:column;gap:8px;margin-top:16px">
      <button type="submit" class="btn btn-primary btn-lg"><?= $id ? 'Save Changes' : 'Add Listing' ?></button>
      <?php if ($id && ($L['status'] ?? '') === 'approved'): ?>
      <a href="/directory/<?= h($L['slug']) ?>" target="_blank" class="btn btn-secondary btn-sm" style="text-align:center">↗ View live listing</a>
      <?php endif ?>
      <a href="/admin/directory/" class="btn btn-ghost btn-sm" style="text-align:center">← Back to Directory</a>
    </div>
  </div>

  <?php if ($id): ?>
  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Quick actions</div>
    <div class="qa">
      <?php if (($L['status'] ?? '') !== 'approved'): ?><a class="btn btn-primary btn-sm" href="<?= $qa('approve') ?>" <?= empty($L['owner_confirmed_at']) && !empty($L['owner_email']) ? 'data-confirm="The owner hasn\'t confirmed by email yet. Approve anyway?"' : '' ?>>Approve &amp; publish</a><?php endif ?>
      <?php if (($L['payment_status'] ?? '') === 'pending'): ?><a class="btn btn-secondary btn-sm" href="<?= $qa('invoiced') ?>">Mark invoiced</a><?php endif ?>
      <?php if (($L['requested_plan'] ?? '') || ($L['plan'] ?? 'free') !== 'free'): ?>
      <a class="btn btn-secondary btn-sm" href="<?= $qa('paid', '&months=1') ?>" data-confirm="Record a 1-month payment?"><?= ($L['payment_status'] ?? '') === 'paid' ? 'Renew +1 month' : 'Mark paid (1 month)' ?></a>
      <a class="btn btn-secondary btn-sm" href="<?= $qa('paid', '&months=12') ?>" data-confirm="Record a 12-month payment?">Mark paid (12 months)</a>
      <?php endif ?>
      <?php if (!empty($L['owner_email'])): ?><a class="btn btn-secondary btn-sm" href="<?= $qa('resend') ?>">Send confirmation email</a><?php endif ?>
      <?php if (!empty($L['website'])): ?><a class="btn btn-secondary btn-sm" href="<?= $qa('fetch_logo') ?>">Fetch logo from website</a><?php endif ?>
      <a class="btn btn-secondary btn-sm" href="<?= $qa('geocode') ?>">Find map location</a>
      <?php if (!empty($L['owner_email'])): ?><a class="btn btn-ghost btn-sm" href="mailto:<?= $v('owner_email') ?>">Email owner</a><?php endif ?>
      <?php if (!empty($L['owner_phone'])): ?><a class="btn btn-ghost btn-sm" href="tel:<?= h(preg_replace('/[^0-9+]/', '', $L['owner_phone'])) ?>">Call owner</a><?php endif ?>
      <a class="btn btn-danger btn-sm" href="<?= $qa('delete') ?>" data-confirm="Permanently delete this listing, its reviews and inquiries? This cannot be undone.">Delete listing</a>
    </div>
  </div>
  <?php endif ?>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Plan &amp; billing
      <span class="tier-pill badge <?= $tier === 'featured' ? 'badge-gold' : ($tier === 'premium' ? 'badge-green' : 'badge-gray') ?>">Active: <?= h($plans[$tier]['name']) ?></span>
    </div>
    <div class="form-grid">
      <div class="form-group"><label>Plan</label>
        <select name="plan"><?php foreach ($plans as $k => $p): ?><option value="<?= $k ?>" <?= ($L['plan'] ?? 'free') === $k ? 'selected' : '' ?>><?= h($p['name']) ?><?= $p['price'] ? ' $' . $p['price'] : '' ?></option><?php endforeach ?></select>
      </div>
      <div class="form-group"><label>Requested</label>
        <select name="requested_plan"><option value="">—</option><?php foreach ($plans as $k => $p): ?><option value="<?= $k ?>" <?= ($L['requested_plan'] ?? '') === $k ? 'selected' : '' ?>><?= h($p['name']) ?></option><?php endforeach ?></select>
      </div>
    </div>
    <div class="form-group"><label>Payment status</label>
      <select name="payment_status"><?php foreach (HC_DIR_PAYMENT_STATUSES as $k => $lab): ?><option value="<?= $k ?>" <?= ($L['payment_status'] ?? 'none') === $k ? 'selected' : '' ?>><?= h($lab) ?></option><?php endforeach ?></select>
    </div>
    <div class="form-grid" style="margin-bottom:0">
      <div class="form-group" style="margin-bottom:0"><label>Paid until</label><input type="date" name="paid_until" value="<?= $v('paid_until') ?>"></div>
      <div class="form-group" style="margin-bottom:0"><label>Invoice #</label><input type="text" name="invoice_ref" value="<?= $v('invoice_ref') ?>"></div>
    </div>
    <div class="form-hint" style="margin-top:10px">A paid plan only shows publicly when the status is <strong>Paid</strong> or <strong>Complimentary</strong> and “paid until” hasn't passed. Leave “paid until” blank for no expiry.</div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Owner / authorized rep <span style="font-weight:400;color:var(--muted)">(private)</span></div>
    <?php if (!empty($L['owner_email'])): ?>
      <?php if (!empty($L['owner_confirmed_at'])): ?>
      <div class="owner-status ok">✓ Confirmed by email <?= date('M j, Y', strtotime($L['owner_confirmed_at'])) ?></div>
      <?php else: ?>
      <div class="owner-status no">Not confirmed<?= !empty($L['confirm_sent_at']) ? ' · link sent ' . date('M j', strtotime($L['confirm_sent_at'])) : '' ?></div>
      <?php endif ?>
      <?php if (hc_dir_domain_match($L)): ?><div class="form-hint" style="margin:-6px 0 12px;color:#0d7a57">✓ Email domain matches the agency website</div><?php endif ?>
      <?php if (in_array($L['claim_status'] ?? '', ['pending', 'confirmed'], true)): ?><div class="form-hint" style="margin:-6px 0 12px">Claim of an existing listing: <strong><?= h($L['claim_status']) ?></strong>. Verify it from the directory list.</div><?php endif ?>
    <?php endif ?>
    <div class="form-group"><label>Name</label><input type="text" name="owner_name" value="<?= $v('owner_name') ?>"></div>
    <div class="form-group"><label>Role</label><input type="text" name="owner_title" value="<?= $v('owner_title') ?>" placeholder="Owner"></div>
    <div class="form-group"><label>Email</label><input type="email" name="owner_email" value="<?= $v('owner_email') ?>"></div>
    <div class="form-group"><label>Direct phone</label><input type="text" name="owner_phone" value="<?= $v('owner_phone') ?>"></div>
    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;margin-bottom:6px"><input type="checkbox" name="send_confirm" value="1" style="width:auto">Send (or re-send) confirmation email on save</label>
    <?php if (empty($L['owner_confirmed_at'])): ?>
    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;margin-bottom:6px"><input type="checkbox" name="mark_confirmed" value="1" style="width:auto">Mark confirmed manually (verified by phone)</label>
    <?php else: ?>
    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;margin-bottom:6px"><input type="checkbox" name="clear_confirmed" value="1" style="width:auto">Remove confirmation (owner must confirm again)</label>
    <?php endif ?>
    <label style="display:flex;align-items:center;gap:8px;font-size:13px;cursor:pointer;margin-bottom:12px"><input type="checkbox" name="owner_authorized" value="1" style="width:auto" <?= !empty($L['owner_authorized']) ? 'checked' : '' ?>>Owner attested they're authorized</label>
    <div class="form-group" style="margin-bottom:0"><label>Claim status <span>(for claims of existing listings)</span></label>
      <select name="claim_status">
        <?php foreach (['' => '— Not a claim', 'pending' => 'Pending (owner not confirmed)', 'confirmed' => 'Confirmed by owner, needs your check', 'verified' => 'Verified'] as $ck => $cl): ?>
        <option value="<?= $ck ?>" <?= ($L['claim_status'] ?? '') === $ck ? 'selected' : '' ?>><?= $cl ?></option>
        <?php endforeach ?>
      </select>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:10px">Internal notes</div>
    <textarea name="admin_notes" rows="4" placeholder="Call notes, invoice history…"><?= $v('admin_notes') ?></textarea>
  </div>

  <?php if ($id):
    $dt = fn($k) => !empty($L[$k]) ? date('M j, Y g:ia', strtotime($L[$k])) : '—'; ?>
  <div class="card">
    <div class="card-title" style="margin-bottom:10px">Submission details</div>
    <dl class="meta">
      <dt>Submitted</dt><dd><?= $dt('created_at') ?></dd>
      <dt>Approved</dt><dd><?= $dt('approved_at') ?></dd>
      <dt>Last updated</dt><dd><?= $dt('updated_at') ?></dd>
      <dt>Confirm sent</dt><dd><?= $dt('confirm_sent_at') ?></dd>
      <dt>Source page</dt><dd><?= $v('source_page') ?: '—' ?></dd>
      <dt>IP address</dt><dd><?= $v('ip_address') ?: '—' ?></dd>
      <dt>Location (IP)</dt><dd><?= h(trim(implode(', ', array_filter([$L['geo_city'] ?? '', $L['geo_region'] ?? '', $L['geo_country'] ?? ''])))) ?: '—' ?></dd>
      <dt>Device</dt><dd><?= $v('device_type') ?: '—' ?></dd>
      <dt>Browser</dt><dd style="font-size:11px;word-break:break-all"><?= $v('user_agent') ?: '—' ?></dd>
      <dt>Map looked up</dt><dd><?= $dt('geocoded_at') ?></dd>
    </dl>
  </div>

  <div class="card" id="verification">
    <div class="card-title" style="margin-bottom:8px">Owner verification <?= !empty($L['verified']) ? '<span class="badge badge-green" style="margin-left:6px">Verified</span>' : '' ?></div>
    <?php if ($acct): ?><div class="form-hint" style="margin-bottom:10px">Owner account: <strong><?= h($acct['email']) ?></strong> · created <?= date('M j, Y', strtotime($acct['created_at'])) ?><?= $acct['last_login_at'] ? ' · last login ' . date('M j', strtotime($acct['last_login_at'])) : '' ?></div>
    <?php else: ?><div class="form-hint" style="margin-bottom:10px">No owner account linked yet<?= !empty($L['owner_email']) ? '. The owner can create one with ' . h($L['owner_email']) : '' ?>.</div><?php endif ?>
    <?php foreach ($verifs as $vf): ?>
    <div class="lead-row">
      <span class="badge <?= ['approved' => 'badge-green', 'rejected' => 'badge-red', 'submitted' => 'badge-gold'][$vf['status']] ?? 'badge-gray' ?>"><?= h($vf['status'] === 'requested' ? 'waiting for owner' : $vf['status']) ?></span>
      <span style="color:var(--muted);margin-left:6px">requested <?= date('M j', strtotime($vf['requested_at'])) ?><?= $vf['submitted_at'] ? ' · uploaded ' . date('M j', strtotime($vf['submitted_at'])) : '' ?></span>
      <?php if ($vf['request_note']): ?><div style="margin-top:4px;color:var(--muted)">Asked: <?= h($vf['request_note']) ?></div><?php endif ?>
      <?php if ($vf['file_path']): $src = '/admin/directory/verify-file.php?id=' . $vf['id']; ?>
        <div style="margin-top:8px">
          <?php if (str_starts_with((string)$vf['file_mime'], 'video/')): ?><video src="<?= $src ?>" controls preload="metadata" style="width:100%;max-height:260px;border-radius:8px;background:#000"></video>
          <?php else: ?><a href="<?= $src ?>" target="_blank"><img src="<?= $src ?>" alt="Verification upload" style="width:100%;max-height:260px;object-fit:contain;border-radius:8px;background:#f2f3f5"></a><?php endif ?>
        </div>
        <?php if ($vf['owner_note']): ?><div style="margin-top:4px">Owner's note: <?= h($vf['owner_note']) ?></div><?php endif ?>
        <a href="<?= $src ?>" target="_blank" style="font-size:12px">Open full size ↗</a>
      <?php endif ?>
      <?php if ($vf['status'] === 'submitted'): ?>
      <div style="display:flex;gap:8px;flex-wrap:wrap;margin-top:8px">
        <a class="btn btn-primary btn-sm" href="<?= $qa('verify_approve', '&vid=' . $vf['id']) ?>">Approve, mark verified</a>
        <a class="btn btn-secondary btn-sm" href="#" onclick="var n=prompt('Reason (sent to the owner):','');if(n!==null)location.href='<?= $qa('verify_reject', '&vid=' . $vf['id']) ?>&vnote='+encodeURIComponent(n);return false">Reject / ask again</a>
      </div>
      <?php elseif ($vf['admin_note']): ?><div style="margin-top:4px;color:var(--muted)">Your note: <?= h($vf['admin_note']) ?></div><?php endif ?>
    </div>
    <?php endforeach ?>
    <div style="margin-top:10px">
      <textarea id="vnote" rows="2" placeholder="What should they send? e.g. A 15-second video showing your office sign and you saying today's date. Leave blank for the standard request."></textarea>
      <a class="btn btn-secondary btn-sm" style="margin-top:6px" href="#" onclick="location.href='<?= $qa('verify_request') ?>&vnote='+encodeURIComponent(document.getElementById('vnote').value);return false">Request photo / video verification</a>
    </div>
  </div>

  <div class="card" id="reviews">
    <div class="card-title" style="margin-bottom:6px">Reviews <span style="font-weight:400;color:var(--muted)">(<?= !empty($L['rating_count']) ? h($L['rating_avg']) . '★ · ' . (int)$L['rating_count'] . ' published' : 'none published' ?>)</span></div>
    <?php if ($reviewsAll): foreach ($reviewsAll as $rv): ?>
    <div class="lead-row">
      <span style="color:#e0a020"><?= str_repeat('★', (int)$rv['rating']) . str_repeat('☆', 5 - (int)$rv['rating']) ?></span>
      <span class="badge <?= $rv['status'] === 'approved' ? 'badge-green' : ($rv['status'] === 'rejected' ? 'badge-red' : 'badge-gold') ?>" style="margin-left:6px"><?= h($rv['status']) ?></span>
      <div style="margin:4px 0"><strong><?= h($rv['title'] ?: '') ?></strong> <?= h(mb_strimwidth($rv['body'], 0, 160, '…')) ?></div>
      <span style="color:var(--muted)"><?= h($rv['name']) ?> &lt;<?= h($rv['email']) ?>&gt; · <?= date('M j, Y', strtotime($rv['created_at'])) ?></span>
      <div style="display:flex;gap:10px;margin-top:4px">
        <?php if ($rv['status'] !== 'approved'): ?><a href="<?= $qa('rv_approve', '&rid=' . $rv['id']) ?>">Approve</a><?php endif ?>
        <?php if ($rv['status'] !== 'rejected'): ?><a href="<?= $qa('rv_reject', '&rid=' . $rv['id']) ?>">Reject</a><?php endif ?>
        <a href="<?= $qa('rv_delete', '&rid=' . $rv['id']) ?>" style="color:var(--red)" data-confirm="Delete this review?">Delete</a>
      </div>
    </div>
    <?php endforeach; else: ?>
    <div class="form-hint">No reviews yet.</div>
    <?php endif ?>
    <a href="/admin/directory/reviews.php?view=all" class="btn btn-ghost btn-sm" style="margin-top:8px">All reviews & agency responses →</a>
  </div>
  <?php endif ?>

  <?php if ($leads): ?>
  <div class="card">
    <div class="card-title" style="margin-bottom:6px">Recent inquiries</div>
    <?php foreach ($leads as $ld): ?>
    <div class="lead-row"><strong><?= h($ld['name']) ?></strong> · <?= h($ld['phone']) ?><br><span style="color:var(--muted)"><?= date('M j, g:ia', strtotime($ld['created_at'])) ?> · <?= $ld['emailed'] ? 'emailed to agency' : 'NOT emailed' ?></span></div>
    <?php endforeach ?>
    <a href="/admin/directory/leads.php?listing=<?= $id ?>" class="btn btn-ghost btn-sm" style="margin-top:8px">All inquiries →</a>
  </div>
  <?php endif ?>

</div>
</div>
</form>
</div>

<script>
document.querySelector('select[name=status]').addEventListener('change', function(){ document.getElementById('rejWrap').style.display = this.value === 'rejected' ? '' : 'none'; });
function autoSlug(val) {
  var s = document.getElementById('co-slug');
  if (s.dataset.locked) return;
  s.value = val.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/[\s-]+/g,'-').replace(/^-|-$/g,'');
}
var pickTarget = null, picker = document.getElementById('imgPicker');
function pick(t){ pickTarget = t; picker.value = ''; picker.click(); }
picker.addEventListener('change', function(){ if (this.files[0]) upload(this.files[0], pickTarget); });
function dropImg(e, t){ e.preventDefault(); e.currentTarget.classList.remove('drag'); var f = e.dataTransfer.files[0]; if (f && f.type.indexOf('image/') === 0) upload(f, t); }
function setImg(t, url){
  if (t === 'photos') {
    var ta = document.getElementById('f-photos'); ta.value = (ta.value.trim() ? ta.value.trim() + '\n' : '') + url;
    var img = document.createElement('img'); img.src = url; document.getElementById('photoStrip').appendChild(img);
    return;
  }
  document.getElementById('f-' + t).value = url;
  document.querySelector('.feat-dropzone[data-target="' + t + '"]').innerHTML = '<img src="' + url + '" alt="">';
}
function upload(file, t){
  var st = document.getElementById('imgStatus'); st.textContent = 'Uploading…';
  var fd = new FormData(); fd.append('file', file);
  fetch('/admin/blog/upload.php', {method:'POST', body:fd})
    .then(function(r){ return r.json(); })
    .then(function(d){ if (d.success) { setImg(t, d.url); st.textContent = ''; } else st.textContent = '❌ ' + d.error; })
    .catch(function(){ st.textContent = '❌ Upload failed.'; });
}
</script>
<?php hc_foot(); ?>
