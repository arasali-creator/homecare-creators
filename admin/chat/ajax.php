<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
hc_require_auth();

header('Content-Type: application/json');

// Passive presence heartbeat — every admin chat poll counts as "online",
// so the visitor widget can show a live "We're online" status with no
// separate toggle to remember to flip.
hc_setting_save('chat_admin_last_seen', (string)time());

$raw    = file_get_contents('php://input');
$body   = json_decode($raw, true) ?: [];
$action = $_GET['action'] ?? $body['action'] ?? '';

switch ($action) {

    case 'list': {
        $sessions = hc_all("SELECT id, visitor_name, visitor_email, type, status, admin_unread, last_message_at,
            visitor_typing_until > NOW() AS visitor_typing,
            (SELECT message FROM hc_chat_messages m WHERE m.session_id=s.id ORDER BY m.id DESC LIMIT 1) AS last_message
            FROM hc_chat_sessions s ORDER BY last_message_at DESC LIMIT 100");
        echo json_encode(['success' => true, 'sessions' => $sessions]);
        exit;
    }

    case 'thread': {
        $id = (int)($_GET['id'] ?? 0);
        $session = hc_one("SELECT *, visitor_typing_until > NOW() AS visitor_typing FROM hc_chat_sessions WHERE id=?", [$id]);
        if (!$session) { http_response_code(404); echo json_encode(['success' => false]); exit; }
        $messages = hc_all("SELECT id, sender, message, created_at FROM hc_chat_messages WHERE session_id=? ORDER BY id ASC", [$id]);
        hc_q("UPDATE hc_chat_sessions SET admin_unread=0 WHERE id=?", [$id]);
        echo json_encode(['success' => true, 'session' => $session, 'messages' => $messages]);
        exit;
    }

    case 'reply': {
        $id      = (int)($body['session_id'] ?? 0);
        $message = trim($body['message'] ?? '');
        $session = hc_one("SELECT * FROM hc_chat_sessions WHERE id=?", [$id]);
        if (!$session || !$message) { http_response_code(400); echo json_encode(['success' => false]); exit; }

        hc_q("INSERT INTO hc_chat_messages (session_id, sender, message) VALUES (?,'admin',?)", [$id, $message]);
        hc_q("UPDATE hc_chat_sessions SET status='active', visitor_unread=1, admin_unread=0, admin_typing_until=NULL, last_message_at=NOW() WHERE id=?", [$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    // ── Admin is actively typing a reply — lets the visitor see a live indicator ──
    case 'typing': {
        $id = (int)($body['session_id'] ?? 0);
        if ($id) hc_q("UPDATE hc_chat_sessions SET admin_typing_until=DATE_ADD(NOW(), INTERVAL 5 SECOND) WHERE id=?", [$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    case 'close': {
        $id = (int)($body['session_id'] ?? 0);
        hc_q("UPDATE hc_chat_sessions SET status='closed' WHERE id=?", [$id]);
        echo json_encode(['success' => true]);
        exit;
    }

    default:
        http_response_code(400);
        echo json_encode(['success' => false, 'message' => 'Unknown action']);
}
