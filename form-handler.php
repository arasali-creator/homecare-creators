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

// Load DB settings — silently skip if DB unavailable
$notification_email = 'info@homecarecreators.com';
$notification_cc    = '';
$db_loaded = false;

try {
    $cfg = __DIR__ . '/admin/config.php';
    if (file_exists($cfg)) {
        require_once $cfg;
        require_once __DIR__ . '/admin/includes/db.php';
        require_once __DIR__ . '/admin/includes/functions.php';
        require_once __DIR__ . '/admin/includes/mailer.php';

        // Save submission to DB
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'] ?? $_SERVER['REMOTE_ADDR'] ?? '';
        hc_q("INSERT INTO hc_form_submissions (name,email,phone,agency_name,city,service,message,ip_address) VALUES (?,?,?,?,?,?,?,?)",
            [$name,$email,$phone,$agency,$city,$service,$message,$ip]);

        $db_email = hc_setting('notification_email', '');
        if ($db_email) $notification_email = $db_email;
        $notification_cc = hc_setting('notification_cc', '');
        $db_loaded = true;

        // WhatsApp notification
        $wa_msg  = "🔔 New lead on Homecare Creators!\n";
        $wa_msg .= "👤 Name: {$name}\n";
        $wa_msg .= "📧 Email: {$email}\n";
        if ($phone)   $wa_msg .= "📞 Phone: {$phone}\n";
        if ($agency)  $wa_msg .= "🏢 Agency: {$agency}\n";
        if ($city)    $wa_msg .= "📍 City: {$city}\n";
        if ($service) $wa_msg .= "🎯 Service: {$service}\n";
        hc_whatsapp_notify($wa_msg);
    }
} catch(Exception $e) { /* fail silently — still send email */ }

$site_name = $db_loaded ? hc_setting('site_name', 'Homecare Creators') : 'Homecare Creators';
$subject   = "New Inquiry — {$name} | {$site_name}";

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

// Send via SMTP (if configured) or fall back to mail()
$sent = false;
if ($db_loaded && class_exists('HcMailer')) {
    $sent = HcMailer::send($notification_email, $subject, $body, $email, $notification_cc);
} else {
    $from    = 'noreply@homecarecreators.com';
    $headers = "From: {$from}\r\nReply-To: {$email}\r\nMIME-Version: 1.0\r\nContent-Type: text/plain; charset=UTF-8\r\n";
    if ($notification_cc) $headers .= "Cc: {$notification_cc}\r\n";
    $sent = mail($notification_email, $subject, $body, $headers);
}

if ($sent) {
    echo json_encode(['success' => true]);
} else {
    // Submission saved to DB — don't return error to user, just log it
    error_log("HC form-handler: email send failed to {$notification_email} for submission from {$email}");
    // Still return success since we saved to DB — admin can see it in form log
    echo json_encode(['success' => true]);
}
