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

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true) ?: $_POST;

// Honeypot — real visitors never fill this field. Pretend success, do nothing.
if (!empty(trim($data['hp_website'] ?? ''))) {
    echo json_encode(['success' => true]);
    exit;
}

$company_name  = strip_tags(trim($data['company_name']  ?? ''));
$city          = strip_tags(trim($data['city']           ?? ''));
$state         = strtoupper(substr(strip_tags(trim($data['state'] ?? 'FL')), 0, 2)) ?: 'FL';
$description   = strip_tags(trim($data['description']    ?? ''));
$services      = strip_tags(trim($data['services']       ?? ''));
$service_areas = strip_tags(trim($data['service_areas']  ?? ''));
$phone         = strip_tags(trim($data['phone']          ?? ''));
$email         = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$website       = filter_var(trim($data['website'] ?? ''), FILTER_SANITIZE_URL);
$license       = strip_tags(trim($data['license_number'] ?? ''));
$address       = strip_tags(trim($data['address']        ?? ''));
$source        = strip_tags(trim($data['source']         ?? '/directory/submit/'));

if (empty($company_name) || empty($city) || empty($description) || mb_strlen($description) < 20
    || empty($phone) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Company name, city, a short description, phone, and a valid email are all required.']);
    exit;
}

try {
    require_once __DIR__ . '/admin/config.php';
    require_once __DIR__ . '/admin/includes/db.php';
    require_once __DIR__ . '/admin/includes/functions.php';
    require_once __DIR__ . '/admin/includes/mailer.php';
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again.']);
    exit;
}

try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_directory_listings (
        id INT PRIMARY KEY AUTO_INCREMENT,
        company_name VARCHAR(255) NOT NULL,
        slug VARCHAR(255) NOT NULL UNIQUE,
        logo VARCHAR(500),
        description TEXT NOT NULL,
        services TEXT,
        city VARCHAR(100) NOT NULL,
        state VARCHAR(2) NOT NULL DEFAULT 'FL',
        service_areas TEXT,
        address VARCHAR(255),
        phone VARCHAR(50),
        email VARCHAR(255),
        website VARCHAR(500),
        license_number VARCHAR(100),
        years_in_business VARCHAR(50),
        featured TINYINT(1) NOT NULL DEFAULT 0,
        status VARCHAR(20) NOT NULL DEFAULT 'pending',
        rejection_reason VARCHAR(500),
        source_page VARCHAR(255),
        ip_address VARCHAR(64),
        user_agent TEXT,
        device_type VARCHAR(20),
        geo_city VARCHAR(100),
        geo_region VARCHAR(100),
        geo_country VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        approved_at TIMESTAMP NULL,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        KEY idx_status (status),
        KEY idx_city (city)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}

// ── Visitor context: IP, device, and IP-based location ──────────
$ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '')[0]) ?: ($_SERVER['REMOTE_ADDR'] ?? '');
$user_agent = strip_tags(trim($_SERVER['HTTP_USER_AGENT'] ?? ''));

$device_type = 'Desktop';
if (preg_match('/tablet|ipad/i', $user_agent)) {
    $device_type = 'Tablet';
} elseif (preg_match('/mobile|android|iphone/i', $user_agent)) {
    $device_type = 'Mobile';
}

$geo_city = ''; $geo_region = ''; $geo_country = '';
$is_private_ip = !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
if ($ip && !$is_private_ip) {
    try {
        $ctx = stream_context_create(['http' => ['timeout' => 3]]);
        $geo_raw = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city", false, $ctx);
        if ($geo_raw) {
            $geo = json_decode($geo_raw, true);
            if (($geo['status'] ?? '') === 'success') {
                $geo_city    = $geo['city'] ?? '';
                $geo_region  = $geo['regionName'] ?? '';
                $geo_country = $geo['country'] ?? '';
            }
        }
    } catch (Exception $e) { /* geolocation is best-effort — fail silently */ }
}

// ── Unique slug ───────────────────────────────────────────────
$slug = hc_slug($company_name);
$base = $slug; $n = 1;
while (hc_val("SELECT id FROM hc_directory_listings WHERE slug=?", [$slug])) $slug = $base . '-' . $n++;

try {
    hc_q("INSERT INTO hc_directory_listings (company_name,slug,description,services,city,state,service_areas,address,phone,email,website,license_number,source_page,ip_address,user_agent,device_type,geo_city,geo_region,geo_country) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
        [$company_name,$slug,$description,$services,$city,$state,$service_areas,$address,$phone,$email,$website,$license,$source,$ip,$user_agent,$device_type,$geo_city,$geo_region,$geo_country]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Could not save your listing. Please try again.']);
    exit;
}

// ── Confirmation email to submitter ──────────────────────────
$subject_sub = "We've received your listing — {$company_name}";
$body_sub  = "Hi,\n\nThanks for submitting {$company_name} to the Homecare Creators Agency Directory.\n\n";
$body_sub .= "Our team will review it and, once approved, it'll go live at homecarecreators.com/directory/{$slug}\n\n";
$body_sub .= "This usually takes 1-2 business days.\n\n— Homecare Creators\n";

$html_sub = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#f4f6f4;font-family:Arial,sans-serif">'
    . '<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f4;padding:32px 16px"><tr><td align="center">'
    . '<table width="520" cellpadding="0" cellspacing="0" style="max-width:520px;width:100%;background:#fff;border-radius:16px;overflow:hidden">'
    . '<tr><td style="background:#0a2e1e;padding:32px 36px;text-align:center">'
    . '<div style="font-family:Arial,sans-serif;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#2ec68f;margin-bottom:10px">Listing Received</div>'
    . '<div style="font-family:Georgia,serif;font-size:22px;color:#ffffff">' . htmlspecialchars($company_name) . '</div>'
    . '</td></tr>'
    . '<tr><td style="padding:28px 36px">'
    . '<p style="font-size:15px;color:#1a1a14;line-height:1.7">Thanks for submitting <strong>' . htmlspecialchars($company_name) . '</strong> to our Agency Directory.</p>'
    . '<p style="font-size:15px;color:#1a1a14;line-height:1.7">We review every listing before it goes live — usually within 1–2 business days. You\'ll get an email once it\'s approved.</p>'
    . '</td></tr>'
    . '<tr><td style="background:#f8faf8;padding:18px 36px;text-align:center;font-size:12px;color:#9ca3af">Homecare Creators &middot; homecarecreators.com</td></tr>'
    . '</table></td></tr></table></body></html>';

HcMailer::send($email, $subject_sub, $body_sub, 'info@homecarecreators.com', '', $html_sub);

// ── Notification to admin ──────────────────────────────────────
$notification_email = hc_setting('notification_email', 'info@homecarecreators.com');
$subject_admin = "📋 New directory listing submitted: {$company_name}";
$body_admin  = "New agency directory submission:\n\n";
$body_admin .= "Company: {$company_name}\nCity: {$city}, {$state}\n";
$body_admin .= "Phone: {$phone}\nEmail: {$email}\n";
if ($website) $body_admin .= "Website: {$website}\n";
$body_admin .= "\nDescription:\n{$description}\n";
$geo_str = trim(implode(', ', array_filter([$geo_city, $geo_region, $geo_country])));
$body_admin .= "\nSource: {$source}\nIP: {$ip}\n";
if ($geo_str) $body_admin .= "Location: {$geo_str}\n";
$body_admin .= "Device: {$device_type}\n";
$body_admin .= "\nReview it: https://homecarecreators.com/admin/directory/\n";

HcMailer::send($notification_email, $subject_admin, $body_admin, $email);

echo json_encode(['success' => true]);
