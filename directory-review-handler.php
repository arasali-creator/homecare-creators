<?php
header('Content-Type: application/json');
if ($_SERVER['REQUEST_METHOD'] !== 'POST') { http_response_code(405); echo json_encode(['success' => false]); exit; }

$data = json_decode(file_get_contents('php://input'), true) ?: $_POST;
if (!empty(trim($data['hp_website'] ?? ''))) { echo json_encode(['success' => true]); exit; }

function rv_fail(string $msg, int $code = 400): void { http_response_code($code); echo json_encode(['success' => false, 'message' => $msg]); exit; }

$c = fn($k, $max) => mb_substr(strip_tags(trim((string)($data[$k] ?? ''))), 0, $max);
$listing_id   = (int)($data['listing_id'] ?? 0);
$rating       = (int)($data['rating'] ?? 0);
$name         = $c('name', 120);
$email        = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$relationship = $c('relationship', 80);
$title        = $c('title', 150);
$body         = $c('body', 5000);

if (!$listing_id || $rating < 1 || $rating > 5) rv_fail('Please choose a star rating.');
if (!$name || !filter_var($email, FILTER_VALIDATE_EMAIL)) rv_fail('Please enter your name and a valid email.');
if (mb_strlen($body) < 40) rv_fail('Please write at least 40 characters about your experience.');
if (preg_match('#https?://|www\.#i', $body . ' ' . $title)) rv_fail('Please remove links from your review.');

require_once __DIR__ . '/admin/config.php';
require_once __DIR__ . '/admin/includes/db.php';
require_once __DIR__ . '/admin/includes/functions.php';
require_once __DIR__ . '/admin/includes/mailer.php';
require_once __DIR__ . '/admin/includes/directory.php';
hc_dir_ensure_schema();

$l = hc_one("SELECT id, company_name, slug, owner_email, email FROM hc_directory_listings WHERE id=? AND status='approved'", [$listing_id]);
if (!$l) rv_fail('This agency could not be found.');

// The agency can't review itself.
$own = array_filter([strtolower((string)$l['owner_email']), strtolower((string)$l['email'])]);
if (in_array(strtolower($email), $own, true)) rv_fail('Agency owners and staff can\'t review their own agency.');

$ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '')[0]) ?: ($_SERVER['REMOTE_ADDR'] ?? '');
if ($ip && (int)hc_val("SELECT COUNT(*) FROM hc_directory_reviews WHERE ip_address=? AND created_at > NOW() - INTERVAL 1 DAY", [$ip]) >= 5) {
    rv_fail('Too many reviews from your connection today. Please try again tomorrow.', 429);
}
if (hc_val("SELECT id FROM hc_directory_reviews WHERE listing_id=? AND LOWER(email)=LOWER(?) AND status<>'rejected'", [$listing_id, $email])) {
    rv_fail('You\'ve already reviewed this agency. Thank you!');
}

hc_q("INSERT INTO hc_directory_reviews (listing_id,name,email,relationship,rating,title,body,ip_address) VALUES (?,?,?,?,?,?,?,?)",
    [$listing_id, $name, $email, $relationship, $rating, $title, $body, $ip]);

$notification_email = hc_setting('notification_email', 'info@homecarecreators.com');
$msg  = "New review waiting for approval\n\nAgency: {$l['company_name']}\nRating: " . str_repeat('★', $rating) . str_repeat('☆', 5 - $rating) . " ({$rating}/5)\n";
$msg .= "From: {$name} <{$email}> — {$relationship}\n\n" . ($title ? $title . "\n" : '') . $body . "\n\nModerate: https://homecarecreators.com/admin/directory/reviews.php\n";
HcMailer::send($notification_email, "[Directory review] {$rating}★ for {$l['company_name']}", $msg, $email);

echo json_encode(['success' => true]);
