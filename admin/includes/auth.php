<?php
if (session_status() === PHP_SESSION_NONE) session_start();

function hc_is_logged_in(): bool {
    return !empty($_SESSION['hc_admin']) && $_SESSION['hc_admin'] === true;
}

function hc_require_auth(): void {
    if (!hc_is_logged_in()) {
        $back = urlencode($_SERVER['REQUEST_URI'] ?? '/admin/');
        header('Location: /admin/login.php?back=' . $back);
        exit;
    }
}

function hc_login(string $user, string $pass): bool {
    if (!defined('ADMIN_USER')) {
        $cfg = dirname(__DIR__) . '/config.php';
        if (file_exists($cfg)) require_once $cfg;
    }
    if ($user === ADMIN_USER && password_verify($pass, ADMIN_PASS_HASH)) {
        session_regenerate_id(true);
        $_SESSION['hc_admin'] = true;
        $_SESSION['hc_user']  = $user;
        return true;
    }
    return false;
}

function hc_logout(): void {
    $_SESSION = [];
    if (ini_get('session.use_cookies')) {
        $p = session_get_cookie_params();
        setcookie(session_name(), '', time() - 42000,
            $p['path'], $p['domain'], $p['secure'], $p['httponly']);
    }
    session_destroy();
}
