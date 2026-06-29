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
$subject   = "🔔 New Lead: {$name}" . ($agency ? " — {$agency}" : '') . " | Homecare Creators";

// Plain text fallback
$body  = "NEW LEAD — HOMECARE CREATORS\n";
$body .= str_repeat('=', 40) . "\n\n";
$body .= "Name:    {$name}\n";
$body .= "Email:   {$email}\n";
if ($phone)   $body .= "Phone:   {$phone}\n";
if ($agency)  $body .= "Agency:  {$agency}\n";
if ($city)    $body .= "City:    {$city}\n";
if ($service) $body .= "Service: {$service}\n";
if ($message) $body .= "\nMessage:\n{$message}\n";
$body .= "\nSource: {$source}\n";
$body .= "\nView all leads: https://homecarecreators.com/admin/\n";
$body .= "\n---\nSent from homecarecreators.com\n";

// HTML email
function hc_field_row(string $label, string $value, string $icon = ''): string {
    if (!$value) return '';
    $v = htmlspecialchars($value);
    $l = htmlspecialchars($label);
    return "
    <tr>
      <td style=\"padding:12px 16px;border-bottom:1px solid #f0f0f0;width:130px;vertical-align:top\">
        <span style=\"font-family:Arial,sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#6b7b6e\">{$l}</span>
      </td>
      <td style=\"padding:12px 16px;border-bottom:1px solid #f0f0f0;vertical-align:top\">
        <span style=\"font-family:Arial,sans-serif;font-size:15px;color:#1a1a14;font-weight:500\">{$v}</span>
      </td>
    </tr>";
}

$date_str = date('l, F j, Y \a\t g:i A');
$source_url = 'https://homecarecreators.com' . $source;
$source_label = htmlspecialchars(trim($source, '/') ?: 'homepage');

$html = '<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1"></head>
<body style="margin:0;padding:0;background:#f4f6f4;font-family:Arial,sans-serif">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f4;padding:32px 16px">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="max-width:600px;width:100%">

  <!-- Header -->
  <tr>
    <td style="background:#0a2e1e;border-radius:16px 16px 0 0;padding:36px 40px;text-align:center">
      <div style="display:inline-block;background:rgba(46,198,143,0.15);border:1px solid rgba(46,198,143,0.3);border-radius:50px;padding:6px 18px;margin-bottom:20px">
        <span style="font-family:Arial,sans-serif;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#2ec68f">New Lead Alert</span>
      </div>
      <div style="font-family:Georgia,serif;font-size:28px;color:#ffffff;font-weight:400;margin-bottom:6px">You have a new inquiry</div>
      <div style="font-family:Arial,sans-serif;font-size:13px;color:rgba(255,255,255,0.5)">' . htmlspecialchars($date_str) . '</div>
    </td>
  </tr>

  <!-- Lead name banner -->
  <tr>
    <td style="background:linear-gradient(135deg,#1d9e75,#2ec68f);padding:20px 40px">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <div style="font-family:Arial,sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:rgba(255,255,255,0.7);margin-bottom:4px">From</div>
            <div style="font-family:Georgia,serif;font-size:24px;color:#ffffff">' . htmlspecialchars($name) . '</div>
            ' . ($agency ? '<div style="font-family:Arial,sans-serif;font-size:14px;color:rgba(255,255,255,0.8);margin-top:2px">' . htmlspecialchars($agency) . '</div>' : '') . '
          </td>
          <td align="right" style="vertical-align:top">
            <div style="background:rgba(255,255,255,0.2);border-radius:50%;width:52px;height:52px;display:inline-flex;align-items:center;justify-content:center;font-family:Georgia,serif;font-size:22px;color:#fff;line-height:52px;text-align:center">' . mb_strtoupper(mb_substr($name, 0, 1)) . '</div>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  <!-- Lead details card -->
  <tr>
    <td style="background:#ffffff;padding:0 40px">
      <table width="100%" cellpadding="0" cellspacing="0" style="margin:24px 0;border:1px solid #e8ece8;border-radius:12px;overflow:hidden">
        ' . hc_field_row('Email', $email)
        . hc_field_row('Phone', $phone)
        . hc_field_row('City', $city)
        . hc_field_row('Service', $service) . '
      </table>
    </td>
  </tr>

  <!-- Message block -->
  ' . ($message ? '
  <tr>
    <td style="background:#ffffff;padding:0 40px">
      <div style="background:#f8faf8;border-left:3px solid #1d9e75;border-radius:0 8px 8px 0;padding:16px 20px;margin-bottom:24px">
        <div style="font-family:Arial,sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:#6b7b6e;margin-bottom:8px">Message</div>
        <div style="font-family:Arial,sans-serif;font-size:15px;color:#1a1a14;line-height:1.65">' . nl2br(htmlspecialchars($message)) . '</div>
      </div>
    </td>
  </tr>' : '') . '

  <!-- CTA button -->
  <tr>
    <td style="background:#ffffff;padding:4px 40px 36px;text-align:center">
      <a href="https://homecarecreators.com/admin/" style="display:inline-block;background:linear-gradient(135deg,#1d9e75,#2ec68f);color:#ffffff;text-decoration:none;font-family:Arial,sans-serif;font-size:14px;font-weight:700;padding:14px 32px;border-radius:10px;letter-spacing:0.3px">View All Leads in Admin →</a>
    </td>
  </tr>

  <!-- Source + Footer -->
  <tr>
    <td style="background:#f8faf8;border-top:1px solid #e8ece8;border-radius:0 0 16px 16px;padding:20px 40px">
      <table width="100%" cellpadding="0" cellspacing="0">
        <tr>
          <td>
            <span style="font-family:Arial,sans-serif;font-size:12px;color:#9ca3af">Source page: </span>
            <a href="' . htmlspecialchars($source_url) . '" style="font-family:Arial,sans-serif;font-size:12px;color:#1d9e75;text-decoration:none">' . $source_label . '</a>
          </td>
          <td align="right">
            <span style="font-family:Arial,sans-serif;font-size:12px;color:#9ca3af">homecarecreators.com</span>
          </td>
        </tr>
      </table>
    </td>
  </tr>

</table>
</td></tr>
</table>
</body>
</html>';

// Send via SMTP (if configured) or fall back to mail()
$sent = false;
if ($db_loaded && class_exists('HcMailer')) {
    $sent = HcMailer::send($notification_email, $subject, $body, $email, $notification_cc, $html);
} else {
    $from    = 'noreply@homecarecreators.com';
    $boundary = 'hcbnd_' . md5(uniqid());
    $headers  = "From: {$from}\r\nReply-To: {$email}\r\nMIME-Version: 1.0\r\n";
    $headers .= "Content-Type: multipart/alternative; boundary=\"{$boundary}\"\r\n";
    if ($notification_cc) $headers .= "Cc: {$notification_cc}\r\n";
    $mbody  = "--{$boundary}\r\nContent-Type: text/plain; charset=UTF-8\r\n\r\n{$body}\r\n";
    $mbody .= "--{$boundary}\r\nContent-Type: text/html; charset=UTF-8\r\n\r\n{$html}\r\n";
    $mbody .= "--{$boundary}--";
    $sent = mail($notification_email, $subject, $mbody, $headers);
}

if ($sent) {
    echo json_encode(['success' => true]);
} else {
    // Submission saved to DB — don't return error to user, just log it
    error_log("HC form-handler: email send failed to {$notification_email} for submission from {$email}");
    // Still return success since we saved to DB — admin can see it in form log
    echo json_encode(['success' => true]);
}
