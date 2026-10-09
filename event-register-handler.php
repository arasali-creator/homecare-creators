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
if (!empty(trim($data['website'] ?? ''))) {
    echo json_encode(['success' => true]);
    exit;
}

$event_slug = trim($data['event_slug'] ?? '');
$name       = strip_tags(trim($data['name']   ?? ''));
$email      = filter_var(trim($data['email']  ?? ''), FILTER_SANITIZE_EMAIL);
$phone      = strip_tags(trim($data['phone']  ?? ''));
$agency     = strip_tags(trim($data['agency'] ?? ''));
$role       = strip_tags(trim($data['role']   ?? ''));
$source     = strip_tags(trim($data['source'] ?? '/events/'));

if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Name and a valid email are required.']);
    exit;
}
if (empty($event_slug)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Missing event.']);
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

$event = hc_one("SELECT * FROM hc_events WHERE slug=? AND status='published'", [$event_slug]);
if (!$event) {
    http_response_code(404);
    echo json_encode(['success' => false, 'message' => 'This event could not be found.']);
    exit;
}

// Capacity check
if ($event['max_attendees']) {
    $reg_count = (int)hc_val("SELECT COUNT(*) FROM hc_event_registrations WHERE event_id=?", [$event['id']]);
    if ($reg_count >= (int)$event['max_attendees']) {
        echo json_encode(['success' => false, 'message' => 'Sorry, this event is now full.']);
        exit;
    }
}

// Duplicate check — don't double-register the same email for the same event
$existing = hc_one("SELECT id FROM hc_event_registrations WHERE event_id=? AND email=?", [$event['id'], $email]);
if ($existing) {
    echo json_encode(['success' => true]); // already registered — treat as success, no duplicate email
    exit;
}

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

try {
    hc_q("INSERT INTO hc_event_registrations (event_id,name,email,phone,agency_name,role_title,source_page,ip_address,user_agent,device_type,geo_city,geo_region,geo_country) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?)",
        [$event['id'],$name,$email,$phone,$agency,$role,$source,$ip,$user_agent,$device_type,$geo_city,$geo_region,$geo_country]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Could not save your registration. Please try again.']);
    exit;
}

// ── Build event display details ──────────────────────────────
$dt = new DateTime($event['event_datetime'], new DateTimeZone($event['timezone'] ?: 'America/New_York'));
$date_str = $dt->format('l, F j, Y \a\t g:i A T');
$zoom_line = $event['zoom_link'] ? "Zoom Link: {$event['zoom_link']}" : "Your Zoom link will be sent separately before the event.";

// ── Confirmation email to registrant ──────────────────────────
$subject_attendee = "You're registered: {$event['title']}";
$body_attendee  = "Hi {$name},\n\n";
$body_attendee .= "You're confirmed for:\n{$event['title']}\n";
$body_attendee .= "{$date_str}\n\n";
$body_attendee .= "{$zoom_line}\n\n";
$body_attendee .= "We look forward to seeing you there!\n\n";
$body_attendee .= "— Homecare Creators\n";

$html_attendee = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#f4f6f4;font-family:Arial,sans-serif">'
    . '<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f4;padding:32px 16px"><tr><td align="center">'
    . '<table width="520" cellpadding="0" cellspacing="0" style="max-width:520px;width:100%;background:#fff;border-radius:16px;overflow:hidden">'
    . '<tr><td style="background:#0a2e1e;padding:32px 36px;text-align:center">'
    . '<div style="font-family:Arial,sans-serif;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#2ec68f;margin-bottom:10px">You\'re Registered</div>'
    . '<div style="font-family:Georgia,serif;font-size:22px;color:#ffffff">' . htmlspecialchars($event['title']) . '</div>'
    . '</td></tr>'
    . '<tr><td style="padding:28px 36px">'
    . '<p style="font-size:15px;color:#1a1a14;line-height:1.7">Hi ' . htmlspecialchars($name) . ',</p>'
    . '<p style="font-size:15px;color:#1a1a14;line-height:1.7">You\'re all set for <strong>' . htmlspecialchars($event['title']) . '</strong>:</p>'
    . '<div style="background:#f8faf8;border-left:3px solid #1d9e75;border-radius:0 8px 8px 0;padding:16px 20px;margin:16px 0">'
    . '<div style="font-size:14px;color:#1a1a14;font-weight:700;margin-bottom:6px">' . htmlspecialchars($date_str) . '</div>'
    . ($event['zoom_link'] ? '<div style="font-size:13px;color:#1d9e75"><a href="' . htmlspecialchars($event['zoom_link']) . '" style="color:#1d9e75;font-weight:700">Join via Zoom →</a></div>' : '<div style="font-size:13px;color:#6b7b6e">Your Zoom link will be sent before the event.</div>')
    . '</div>'
    . '<p style="font-size:14px;color:#6b7b6e;line-height:1.7">We look forward to seeing you there!</p>'
    . '</td></tr>'
    . '<tr><td style="background:#f8faf8;padding:18px 36px;text-align:center;font-size:12px;color:#9ca3af">Homecare Creators &middot; homecarecreators.com</td></tr>'
    . '</table></td></tr></table></body></html>';

$notification_email = hc_setting('notification_email', 'info@homecarecreators.com');
HcMailer::send($email, $subject_attendee, $body_attendee, $notification_email, '', $html_attendee);

// ── Notification to admin ──────────────────────────────────────
$subject_admin = "🎟️ New event registration: {$name} — {$event['title']}";
$body_admin  = "New registration for: {$event['title']}\n\n";
$body_admin .= "Name: {$name}\nEmail: {$email}\n";
if ($phone)  $body_admin .= "Phone: {$phone}\n";
if ($agency) $body_admin .= "Agency: {$agency}\n";
if ($role)   $body_admin .= "Role: {$role}\n";
$body_admin .= "\nSource: {$source}\nIP: {$ip}\n";
$geo_str = trim(implode(', ', array_filter([$geo_city, $geo_region, $geo_country])));
if ($geo_str) $body_admin .= "Location: {$geo_str}\n";
$body_admin .= "Device: {$device_type}\n";
$body_admin .= "\nView all registrations: https://homecarecreators.com/admin/events/registrations.php?event_id={$event['id']}\n";

HcMailer::send($notification_email, $subject_admin, $body_admin, $email);

echo json_encode(['success' => true]);
