<?php
// Public API for the site chat widget (includes/chat-widget.php).
// Actions: faq_search, start_expert, send_message, poll
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://homecarecreators.com');
header('Access-Control-Allow-Methods: GET, POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }

require_once __DIR__ . '/admin/config.php';
require_once __DIR__ . '/admin/includes/db.php';
require_once __DIR__ . '/admin/includes/functions.php';
require_once __DIR__ . '/admin/includes/mailer.php';

hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_chat_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(40) NOT NULL UNIQUE,
    visitor_name VARCHAR(150) DEFAULT '',
    visitor_email VARCHAR(190) DEFAULT '',
    type ENUM('expert','info') NOT NULL DEFAULT 'expert',
    status ENUM('pending','active','closed') NOT NULL DEFAULT 'pending',
    page_url VARCHAR(500) DEFAULT '',
    admin_unread TINYINT(1) NOT NULL DEFAULT 1,
    visitor_unread TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_message_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id INT NOT NULL,
    sender ENUM('visitor','admin') NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

function hc_chat_fail(string $msg, int $code = 400): void {
    http_response_code($code);
    echo json_encode(['success' => false, 'message' => $msg]);
    exit;
}

function hc_chat_session_for_token(int $id, string $token): ?array {
    if (!$id || !$token) return null;
    return hc_one("SELECT * FROM hc_chat_sessions WHERE id=? AND token=?", [$id, $token]);
}

$method = $_SERVER['REQUEST_METHOD'];
$raw    = file_get_contents('php://input');
$body   = json_decode($raw, true) ?: [];
$action = $_GET['action'] ?? $body['action'] ?? '';

switch ($action) {

    // ── Search the FAQ bank for the "Get Info from Website" path ──────────
    case 'faq_search': {
        $q = trim($_GET['q'] ?? $body['q'] ?? '');
        if (mb_strlen($q) < 2) { echo json_encode(['success' => true, 'results' => []]); exit; }

        $words = array_values(array_filter(preg_split('/\s+/', mb_strtolower($q)), fn($w) => mb_strlen($w) >= 3));
        if (!$words) { echo json_encode(['success' => true, 'results' => []]); exit; }

        $faqs = hc_all("SELECT id, question, answer FROM hc_faqs");
        $scored = [];
        foreach ($faqs as $f) {
            $hay = mb_strtolower($f['question'] . ' ' . $f['answer']);
            $score = 0;
            foreach ($words as $w) { if (mb_strpos($hay, $w) !== false) $score++; }
            if ($score > 0) $scored[] = ['score' => $score, 'id' => $f['id'], 'question' => $f['question'], 'answer' => $f['answer']];
        }
        usort($scored, fn($a, $b) => $b['score'] <=> $a['score']);
        $results = array_slice(array_map(fn($s) => ['question' => $s['question'], 'answer' => $s['answer']], $scored), 0, 3);
        echo json_encode(['success' => true, 'results' => $results]);
        exit;
    }

    // ── Start a "Talk with an Expert" session ──────────────────────────────
    case 'start_expert': {
        if ($method !== 'POST') hc_chat_fail('Method not allowed', 405);
        $name    = strip_tags(trim($body['name'] ?? ''));
        $email   = filter_var(trim($body['email'] ?? ''), FILTER_SANITIZE_EMAIL);
        $message = strip_tags(trim($body['message'] ?? ''));
        $page    = strip_tags(trim($body['page_url'] ?? ''));
        $honeypot = trim($body['website'] ?? '');

        if ($honeypot) { echo json_encode(['success' => true, 'session_id' => 0, 'token' => '']); exit; }
        if (!$name || !$email || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            hc_chat_fail('A valid name and email are required.');
        }

        $token = bin2hex(random_bytes(16));
        hc_q("INSERT INTO hc_chat_sessions (token, visitor_name, visitor_email, type, status, page_url) VALUES (?,?,?,'expert','pending',?)",
            [$token, $name, $email, $page]);
        $sessionId = (int)hc_db()->lastInsertId();

        if ($message) {
            hc_q("INSERT INTO hc_chat_messages (session_id, sender, message) VALUES (?,'visitor',?)", [$sessionId, $message]);
        }

        $notifyEmail = hc_setting('notification_email', 'info@homecarecreators.com');
        $siteUrl     = defined('SITE_URL') ? SITE_URL : 'https://homecarecreators.com';
        $subject     = "💬 New live chat request from {$name}";
        $plain  = "NEW LIVE CHAT REQUEST\n" . str_repeat('=', 30) . "\n\n";
        $plain .= "Name:  {$name}\nEmail: {$email}\nPage:  {$page}\n";
        if ($message) $plain .= "\nMessage:\n{$message}\n";
        $plain .= "\nReply here: {$siteUrl}/admin/chat/?session={$sessionId}\n";

        $html = '<div style="font-family:Arial,sans-serif;max-width:560px;margin:0 auto;padding:24px">'
            . '<div style="background:#0a2e1e;border-radius:14px 14px 0 0;padding:24px 28px"><span style="color:#fff;font-size:20px;font-weight:700">New Live Chat Request</span></div>'
            . '<div style="background:#fff;border:1px solid #e8ece8;border-top:none;border-radius:0 0 14px 14px;padding:24px 28px">'
            . '<p style="margin:0 0 10px"><strong>Name:</strong> ' . htmlspecialchars($name) . '</p>'
            . '<p style="margin:0 0 10px"><strong>Email:</strong> ' . htmlspecialchars($email) . '</p>'
            . '<p style="margin:0 0 16px"><strong>Page:</strong> ' . htmlspecialchars($page) . '</p>'
            . ($message ? '<div style="background:#f8faf8;border-left:3px solid #1d9e75;padding:12px 16px;margin-bottom:16px">' . nl2br(htmlspecialchars($message)) . '</div>' : '')
            . '<a href="' . htmlspecialchars($siteUrl) . '/admin/chat/?session=' . $sessionId . '" style="display:inline-block;background:#1d9e75;color:#fff;text-decoration:none;padding:12px 24px;border-radius:9px;font-weight:700">Reply Now →</a>'
            . '</div></div>';

        HcMailer::send($notifyEmail, $subject, $plain, $email, '', $html);

        echo json_encode(['success' => true, 'session_id' => $sessionId, 'token' => $token]);
        exit;
    }

    // ── Visitor sends a message in an existing session ─────────────────────
    case 'send_message': {
        if ($method !== 'POST') hc_chat_fail('Method not allowed', 405);
        $session = hc_chat_session_for_token((int)($body['session_id'] ?? 0), trim($body['token'] ?? ''));
        if (!$session) hc_chat_fail('Invalid session.', 404);
        $message = strip_tags(trim($body['message'] ?? ''));
        if (!$message) hc_chat_fail('Message is empty.');

        hc_q("INSERT INTO hc_chat_messages (session_id, sender, message) VALUES (?,'visitor',?)", [$session['id'], $message]);
        hc_q("UPDATE hc_chat_sessions SET admin_unread=1, last_message_at=NOW() WHERE id=?", [$session['id']]);

        echo json_encode(['success' => true]);
        exit;
    }

    // ── Visitor polls for admin replies ─────────────────────────────────────
    case 'poll': {
        $session = hc_chat_session_for_token((int)($_GET['session_id'] ?? 0), trim($_GET['token'] ?? ''));
        if (!$session) hc_chat_fail('Invalid session.', 404);
        $since = (int)($_GET['since'] ?? 0);

        $messages = hc_all("SELECT id, sender, message, created_at FROM hc_chat_messages WHERE session_id=? AND id>? ORDER BY id ASC", [$session['id'], $since]);
        hc_q("UPDATE hc_chat_sessions SET visitor_unread=0 WHERE id=?", [$session['id']]);

        echo json_encode(['success' => true, 'status' => $session['status'], 'messages' => $messages]);
        exit;
    }

    default:
        hc_chat_fail('Unknown action.');
}
