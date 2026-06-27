<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://homecarecreators.com');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true);
if (!$data) {
    $data = $_POST;
}

$name    = strip_tags(trim($data['name']    ?? ''));
$email   = filter_var(trim($data['email']   ?? ''), FILTER_SANITIZE_EMAIL);
$phone   = strip_tags(trim($data['phone']   ?? ''));
$agency  = strip_tags(trim($data['agency']  ?? ''));
$city    = strip_tags(trim($data['city']    ?? ''));
$service = strip_tags(trim($data['service'] ?? ''));
$message = strip_tags(trim($data['message'] ?? ''));
$source  = strip_tags(trim($data['source']  ?? 'website'));

if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Name and valid email are required']);
    exit;
}

// Load DB settings (notification email etc.) — silently skip if DB unavailable
$notification_email = 'info@homecarecreators.com';
$notification_cc    = '';
$reply_from         = 'noreply@homecarecreators.com';
$site_name          = 'Homecare Creators';

try {
    $cfg = __DIR__ . '/admin/config.php';
    if (file_exists($cfg)) {
        require_once $cfg;
        require_once __DIR__ . '/admin/includes/db.php';
        require_once __DIR__ . '/admin/includes/functions.php';

        // Save submission first
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
        hc_q("INSERT INTO hc_form_submissions (name,email,phone,agency_name,city,service,message,ip_address) VALUES (?,?,?,?,?,?,?,?)",
            [$name,$email,$phone,$agency,$city,$service,$message,$ip]);

        // Read settings
        $db_email = hc_setting('notification_email', '');
        if ($db_email) $notification_email = $db_email;
        $notification_cc = hc_setting('notification_cc', '');
        $reply_from      = hc_setting('reply_to_email', 'noreply@homecarecreators.com');
        $site_name       = hc_setting('site_name', 'Homecare Creators');
    }
} catch(Exception $e) { /* fail silently */ }

$subject = "New Inquiry — {$name} | {$site_name}";

$body  = "New inquiry received from the {$site_name} website.\n\n";
$body .= "Name:    {$name}\n";
$body .= "Email:   {$email}\n";
if ($phone)   $body .= "Phone:   {$phone}\n";
if ($agency)  $body .= "Agency:  {$agency}\n";
if ($city)    $body .= "City:    {$city}\n";
if ($service) $body .= "Service: {$service}\n";
if ($message) $body .= "\nMessage:\n{$message}\n";
$body .= "\nSource: {$source}\n";
$body .= "\n---\nSent from homecarecreators.com\n";

$headers  = "From: {$reply_from}\r\n";
$headers .= "Reply-To: {$email}\r\n";
if ($notification_cc) $headers .= "Cc: {$notification_cc}\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($notification_email, $subject, $body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send message. Please email info@homecarecreators.com directly.']);
}
