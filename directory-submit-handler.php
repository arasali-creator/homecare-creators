<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://homecarecreators.com');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

function dir_fail(string $msg, int $code = 400): void {
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true) ?: $_POST;

// Honeypot — real visitors never fill this field. Pretend success, do nothing.
if (!empty(trim($data['hp_website'] ?? ''))) {
    echo json_encode(['success' => true]);
    exit;
}

$clean = fn($k, $max = 5000) => mb_substr(strip_tags(trim((string)($data[$k] ?? ''))), 0, $max);

$mode         = ($data['mode'] ?? '') === 'claim' ? 'claim' : 'new';
$claim_slug   = $clean('claim_slug', 255);
$plan         = in_array($data['plan'] ?? '', ['free', 'premium', 'featured'], true) ? $data['plan'] : 'free';

// Owner / authorized representative
$owner_name   = $clean('owner_name', 150);
$owner_title  = $clean('owner_title', 100);
$owner_email  = filter_var(trim($data['owner_email'] ?? ''), FILTER_SANITIZE_EMAIL);
$owner_phone  = $clean('owner_phone', 50);
$authorized   = !empty($data['owner_authorized']);

if (!$owner_name || !$owner_title || !$owner_phone || !filter_var($owner_email, FILTER_VALIDATE_EMAIL)) {
    dir_fail('Please complete the owner / authorized representative section with a valid email.');
}
if (!$authorized) {
    dir_fail('Please confirm you are the owner or an authorized representative of this agency.');
}

try {
    require_once __DIR__ . '/admin/config.php';
    require_once __DIR__ . '/admin/includes/db.php';
    require_once __DIR__ . '/admin/includes/functions.php';
    require_once __DIR__ . '/admin/includes/mailer.php';
    require_once __DIR__ . '/admin/includes/directory.php';
    hc_dir_ensure_schema();
} catch (Throwable $e) {
    dir_fail('Server error. Please try again.', 500);
}

// ── Visitor context: IP, device, and IP-based location ──────────
$ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '')[0]) ?: ($_SERVER['REMOTE_ADDR'] ?? '');
$user_agent = strip_tags(trim($_SERVER['HTTP_USER_AGENT'] ?? ''));
$device_type = preg_match('/tablet|ipad/i', $user_agent) ? 'Tablet' : (preg_match('/mobile|android|iphone/i', $user_agent) ? 'Mobile' : 'Desktop');

// Light rate limit: max 5 submissions per IP per hour.
if ($ip && (int)hc_val("SELECT COUNT(*) FROM hc_directory_listings WHERE ip_address=? AND created_at > NOW() - INTERVAL 1 HOUR", [$ip]) >= 5) {
    dir_fail('Too many submissions from your connection. Please try again later or email info@homecarecreators.com.', 429);
}

$geo_city = ''; $geo_region = ''; $geo_country = '';
$is_private_ip = !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
if ($ip && !$is_private_ip) {
    $ctx = stream_context_create(['http' => ['timeout' => 3]]);
    $geo_raw = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city", false, $ctx);
    $geo = $geo_raw ? json_decode($geo_raw, true) : null;
    if (($geo['status'] ?? '') === 'success') {
        $geo_city = $geo['city'] ?? ''; $geo_region = $geo['regionName'] ?? ''; $geo_country = $geo['country'] ?? '';
    }
}

$payment_status = $plan === 'free' ? 'none' : 'pending';

if ($mode === 'claim') {
    // ── Claim an existing listing ──────────────────────────────────
    $listing = hc_one("SELECT * FROM hc_directory_listings WHERE slug=? AND status='approved'", [$claim_slug]);
    if (!$listing) dir_fail('We couldn\'t find that listing. Please contact us at info@homecarecreators.com.');
    if (!empty($listing['owner_confirmed_at'])) {
        dir_fail('This listing has already been claimed. If you believe that\'s a mistake, email info@homecarecreators.com and we\'ll sort it out.');
    }
    $notes = $clean('claim_notes', 2000);
    $admin_note = trim(($listing['admin_notes'] ?? '') . "\n[" . date('Y-m-d H:i') . "] Claim request by {$owner_name} <{$owner_email}> from IP {$ip}" . ($notes ? "\nNotes: {$notes}" : ''));
    try {
        hc_q("UPDATE hc_directory_listings SET owner_name=?, owner_title=?, owner_email=?, owner_phone=?, owner_authorized=1,
                owner_confirmed_at=NULL, claim_status='pending', requested_plan=?,
                payment_status=IF(plan='free' OR payment_status IN ('none',''), ?, payment_status),
                admin_notes=? WHERE id=?",
            [$owner_name, $owner_title, $owner_email, $owner_phone, $plan, $payment_status, $admin_note, $listing['id']]);
    } catch (Exception $e) {
        dir_fail('Could not save your claim. Please try again.', 500);
    }
    $id = (int)$listing['id'];
    $company_name = $listing['company_name'];
    $city = $listing['city']; $state = $listing['state'];
    $slug = $listing['slug'];
    $description = '';
} else {
    // ── New listing ────────────────────────────────────────────────
    $company_name  = $clean('company_name', 255);
    $city          = $clean('city', 100);
    $state         = strtoupper(substr($clean('state', 2), 0, 2)) ?: 'FL';
    $tagline       = $clean('tagline', 160);
    $description   = $clean('description', 5000);
    $phone         = $clean('phone', 50);
    $email         = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $website       = filter_var(trim($data['website'] ?? ''), FILTER_SANITIZE_URL);
    $license       = $clean('license_number', 100);
    $years         = $clean('years_in_business', 50);
    $address       = $clean('address', 255);
    $service_areas = $clean('service_areas', 2000);
    $languages     = $clean('languages', 255);
    $hours         = $clean('hours', 255);
    $logo          = filter_var(trim($data['logo'] ?? ''), FILTER_SANITIZE_URL);
    $source        = $clean('source', 255) ?: '/directory/submit/';

    $listify = function ($arr, $allowed = null) {
        $arr = is_array($arr) ? $arr : preg_split('/\r?\n/', (string)$arr);
        $out = [];
        foreach ($arr as $v) {
            $v = mb_substr(strip_tags(trim((string)$v)), 0, 80);
            if ($v === '' || ($allowed && !in_array($v, $allowed, true))) continue;
            $out[] = $v;
        }
        return implode("\n", array_unique($out));
    };
    $services = $listify(array_merge((array)($data['services'] ?? []), preg_split('/[\r\n,]+/', (string)($data['services_other'] ?? ''))));
    $payments = $listify($data['payment_accepted'] ?? [], HC_DIR_PAYMENTS);
    $features = $listify($data['features'] ?? [], array_keys(HC_DIR_FEATURES));
    $hoursMode = $data['hours_mode'] ?? 'skip';
    $hm = fn($k) => preg_match('/^\d{2}:\d{2}$/', (string)($data[$k] ?? '')) ? $data[$k] : '';
    $rows = [];
    foreach (['mon', 'tue', 'wed', 'thu', 'fri'] as $d) $rows[$d] = ['open' => $hm('wk_open'), 'close' => $hm('wk_close')];
    $rows['sat'] = ['open' => $hm('sat_open'), 'close' => $hm('sat_close')];
    $rows['sun'] = ['open' => $hm('sun_open'), 'close' => $hm('sun_close')];
    $hours_json = $hoursMode === 'always' ? hc_dir_hours_from_input(true, []) : ($hoursMode === 'set' ? hc_dir_hours_from_input(false, $rows) : null);

    if ($website && !preg_match('#^https?://#i', $website)) $website = 'https://' . $website;
    if ($logo && !preg_match('#^https?://#i', $logo)) $logo = '';

    if (!$company_name || !$city || !$state || mb_strlen($description) < 40 || !$phone
        || !filter_var($email, FILTER_VALIDATE_EMAIL) || !$services) {
        dir_fail('Agency name, city, state, a description (40+ characters), phone, a valid email and at least one service are required.');
    }

    // Duplicate guard: same name in same city already listed/pending.
    $dup = hc_one("SELECT slug,status FROM hc_directory_listings WHERE LOWER(company_name)=LOWER(?) AND LOWER(city)=LOWER(?) AND status<>'rejected'", [$company_name, $city]);
    if ($dup) {
        dir_fail($dup['status'] === 'approved'
            ? 'This agency is already in our directory. Use "Claim this listing" on its profile page to take ownership or upgrade.'
            : 'A listing for this agency is already under review. We\'ll be in touch shortly.');
    }

    $slug = hc_slug($company_name . '-' . $city);
    $base = $slug; $n = 2;
    while (hc_val("SELECT id FROM hc_directory_listings WHERE slug=?", [$slug])) $slug = $base . '-' . $n++;

    try {
        hc_q("INSERT INTO hc_directory_listings
            (company_name,slug,logo,tagline,description,services,payment_accepted,features,hours_json,languages,hours,city,state,service_areas,address,phone,email,website,license_number,years_in_business,
             plan,requested_plan,payment_status,owner_name,owner_title,owner_email,owner_phone,owner_authorized,
             source_page,ip_address,user_agent,device_type,geo_city,geo_region,geo_country)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1,?,?,?,?,?,?,?)",
            [$company_name,$slug,$logo,$tagline,$description,$services,$payments,$features,$hours_json,$languages,$hours,$city,$state,$service_areas,$address,$phone,$email,$website,$license,$years,
             $plan,$plan,$payment_status,$owner_name,$owner_title,$owner_email,$owner_phone,
             $source,$ip,$user_agent,$device_type,$geo_city,$geo_region,$geo_country]);
        $id = (int)hc_db()->lastInsertId();
    } catch (Exception $e) {
        dir_fail('Could not save your listing. Please try again.', 500);
    }
    hc_dir_geocode($id);
    // Profile picture: store the supplied logo locally, or find it on their website.
    $savedLogo = $logo ? hc_dir_store_logo($logo, $slug) : null;
    if ($savedLogo) hc_q("UPDATE hc_directory_listings SET logo=? WHERE id=?", [$savedLogo, $id]);
    elseif ($website) { if (!hc_dir_fetch_logo($id) && $logo) hc_q("UPDATE hc_directory_listings SET logo=NULL WHERE id=?", [$id]); }
}

// ── Owner confirmation email ───────────────────────────────────
hc_dir_send_owner_confirmation($id);

// ── Notification to admin ──────────────────────────────────────
$plans = hc_dir_plans();
$planLabel = $plans[$plan]['name'] . ($plan !== 'free' ? ' ($' . $plans[$plan]['price'] . '/mo) — SEND INVOICE' : ' (free)');
$notification_email = hc_setting('notification_email', 'info@homecarecreators.com');
$subject_admin = ($mode === 'claim' ? "Directory claim: " : "New directory listing: ") . $company_name . ($plan !== 'free' ? " [{$plans[$plan]['name']}]" : '');
$body_admin  = ($mode === 'claim' ? "Someone wants to claim an existing listing:\n\n" : "New agency directory submission:\n\n");
$body_admin .= "Agency: {$company_name}\nLocation: {$city}, {$state}\nPlan requested: {$planLabel}\n\n";
$body_admin .= "OWNER / AUTHORIZED REP\n{$owner_name} — {$owner_title}\nEmail: {$owner_email}\nPhone: {$owner_phone}\n";
$body_admin .= "Ownership confirmation email sent — you'll get another notice once they click it.\n";
if ($description) $body_admin .= "\nDescription:\n{$description}\n";
$geo_str = trim(implode(', ', array_filter([$geo_city, $geo_region, $geo_country])));
$body_admin .= "\nIP: {$ip}" . ($geo_str ? " ({$geo_str})" : '') . "\nDevice: {$device_type}\n";
$body_admin .= "\nReview it: https://homecarecreators.com/admin/directory/edit.php?id={$id}\n";
HcMailer::send($notification_email, $subject_admin, $body_admin, $owner_email);
if (function_exists('hc_whatsapp_notify')) {
    hc_whatsapp_notify(($mode === 'claim' ? 'Directory claim' : 'New directory listing') . ": {$company_name} ({$city}, {$state}) — {$plans[$plan]['name']}");
}

echo json_encode(['success' => true, 'plan' => $plan, 'owner_email' => $owner_email]);
