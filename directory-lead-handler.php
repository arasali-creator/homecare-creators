<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['success' => false]); exit; }

$data = json_decode(file_get_contents('php://input'), true) ?: $_POST;
if (!empty(trim($data['hp_website'] ?? ''))) { echo json_encode(['success' => true]); exit; }

$c = fn($k, $max) => mb_substr(strip_tags(trim((string)($data[$k] ?? ''))), 0, $max);
$listing_id = (int)($data['listing_id'] ?? 0);
$name     = $c('name', 150);
$phone    = $c('phone', 50);
$email    = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$care_for = $c('care_for', 100);
$message  = $c('message', 3000);

if (!$listing_id || !$name || strlen(preg_replace('/\D/', '', $phone)) < 7 || ($email && !filter_var($email, FILTER_VALIDATE_EMAIL))) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please enter your name and a valid phone number.']);
    exit;
}

require_once __DIR__ . '/admin/config.php';
require_once __DIR__ . '/admin/includes/db.php';
require_once __DIR__ . '/admin/includes/functions.php';
require_once __DIR__ . '/admin/includes/mailer.php';
require_once __DIR__ . '/admin/includes/directory.php';
hc_dir_ensure_schema();

$l = hc_one("SELECT * FROM hc_directory_listings WHERE id=? AND status='approved'", [$listing_id]);
if (!$l || hc_dir_tier($l) !== 'featured') {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'This agency isn\'t accepting online requests. Please call them directly.']);
    exit;
}

$ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '')[0]) ?: ($_SERVER['REMOTE_ADDR'] ?? '');
if ($ip && (int)hc_val("SELECT COUNT(*) FROM hc_directory_leads WHERE ip_address=? AND created_at > NOW() - INTERVAL 1 HOUR", [$ip]) >= 5) {
    http_response_code(429);
    echo json_encode(['success' => false, 'message' => 'Too many requests — please call the agency directly.']);
    exit;
}

hc_q("INSERT INTO hc_directory_leads (listing_id,name,phone,email,care_for,message,ip_address) VALUES (?,?,?,?,?,?,?)",
    [$listing_id, $name, $phone, $email, $care_for, $message, $ip]);
$lead_id = (int)hc_db()->lastInsertId();

$to = $l['owner_email'] ?: $l['email'];
$subject = "New care inquiry from {$name} — via Homecare Creators Directory";
$body  = "You have a new inquiry from your directory profile:\n\n";
$body .= "Name: {$name}\nPhone: {$phone}\n" . ($email ? "Email: {$email}\n" : '') . "Care is for: {$care_for}\n\n";
if ($message) $body .= "Message:\n{$message}\n\n";
$body .= "Reply quickly — families usually contact several agencies.\n\n— Homecare Creators Directory\n";
$rows = '<p>You have a new inquiry from your directory profile.</p><table cellpadding="0" cellspacing="0" style="width:100%;font-size:15px;margin:8px 0 4px">'
    . '<tr><td style="padding:6px 0;color:#6b7280;width:120px">Name</td><td style="padding:6px 0"><strong>' . htmlspecialchars($name) . '</strong></td></tr>'
    . '<tr><td style="padding:6px 0;color:#6b7280">Phone</td><td style="padding:6px 0"><a href="tel:' . htmlspecialchars(preg_replace('/[^0-9+]/', '', $phone)) . '">' . htmlspecialchars($phone) . '</a></td></tr>'
    . ($email ? '<tr><td style="padding:6px 0;color:#6b7280">Email</td><td style="padding:6px 0"><a href="mailto:' . htmlspecialchars($email) . '">' . htmlspecialchars($email) . '</a></td></tr>' : '')
    . '<tr><td style="padding:6px 0;color:#6b7280">Care is for</td><td style="padding:6px 0">' . htmlspecialchars($care_for) . '</td></tr></table>'
    . ($message ? '<p style="background:#f6f8f6;border-radius:8px;padding:14px 16px;white-space:pre-line">' . htmlspecialchars($message) . '</p>' : '')
    . '<p style="color:#6b7280;font-size:13.5px">Reply quickly — families usually contact several agencies.</p>';
$html = hc_dir_email_html('New care inquiry', $l['company_name'], $rows);

$sent = $to ? HcMailer::send($to, $subject, $body, $email ?: '', '', $html) : false;
if ($sent) hc_q("UPDATE hc_directory_leads SET emailed=1 WHERE id=?", [$lead_id]);

// Copy to admin so you can show the agency the value they're getting.
$notification_email = hc_setting('notification_email', 'info@homecarecreators.com');
HcMailer::send($notification_email, "[Directory lead] {$l['company_name']} ← {$name}", $body . "\nAgency emailed: " . ($sent ? $to : 'NO — no email on file') . "\n");

echo json_encode(['success' => true]);
