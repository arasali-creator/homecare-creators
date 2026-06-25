<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: *');
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

$to      = 'info@homecarecreators.com';
$subject = "New Inquiry — {$name} | Homecare Creators";

$body  = "New inquiry received from the Homecare Creators website.\n\n";
$body .= "Name:    {$name}\n";
$body .= "Email:   {$email}\n";
if ($phone)   $body .= "Phone:   {$phone}\n";
if ($agency)  $body .= "Agency:  {$agency}\n";
if ($city)    $body .= "City:    {$city}\n";
if ($service) $body .= "Service: {$service}\n";
if ($message) $body .= "\nMessage:\n{$message}\n";
$body .= "\nSource: {$source}\n";
$body .= "\n---\nSent from homecarecreators.com\n";

$headers  = "From: noreply@homecarecreators.com\r\n";
$headers .= "Reply-To: {$email}\r\n";
$headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";
$headers .= "MIME-Version: 1.0\r\n";
$headers .= "Content-Type: text/plain; charset=UTF-8\r\n";

if (mail($to, $subject, $body, $headers)) {
    echo json_encode(['success' => true, 'message' => 'Message sent successfully']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Failed to send message. Please email info@homecarecreators.com directly.']);
}
