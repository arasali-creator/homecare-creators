<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';

if (hc_is_logged_in()) { header('Location: /admin/'); exit; }

$error = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['username'] ?? '');
    $pass = $_POST['password'] ?? '';
    if (hc_login($user, $pass)) {
        $back = $_GET['back'] ?? '/admin/';
        header('Location: ' . $back);
        exit;
    }
    $error = 'Invalid username or password.';
    sleep(1);
}
?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title>Admin Login — Homecare Creators</title>
<meta name="robots" content="noindex,nofollow">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:-apple-system,BlinkMacSystemFont,'Segoe UI',sans-serif;background:#0a2e1e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.login-card{background:#fff;border-radius:14px;padding:40px;width:100%;max-width:380px;box-shadow:0 24px 60px rgba(0,0,0,.3)}
.login-logo{text-align:center;margin-bottom:28px}
.login-logo strong{display:block;font-size:18px;font-weight:800;color:#0a2e1e;letter-spacing:-.3px}
.login-logo small{font-size:12px;color:#6b7280;margin-top:3px;display:block}
.form-group{margin-bottom:16px}
label{display:block;font-size:12.5px;font-weight:700;color:#111827;margin-bottom:5px}
input{width:100%;padding:10px 12px;border:1.5px solid rgba(0,0,0,.12);border-radius:8px;font-size:14px;color:#111827;transition:.12s;font-family:inherit}
input:focus{outline:none;border-color:#1d9e75;box-shadow:0 0 0 3px rgba(29,158,117,.1)}
.error{background:rgba(220,38,38,.08);border:1px solid rgba(220,38,38,.2);color:#991b1b;padding:10px 14px;border-radius:8px;font-size:13px;margin-bottom:16px}
.btn-login{width:100%;padding:11px;background:#1d9e75;color:#fff;border:none;border-radius:8px;font-size:14px;font-weight:700;cursor:pointer;transition:.12s;font-family:inherit;letter-spacing:.2px}
.btn-login:hover{background:#178a64}
.login-grid{background:rgba(29,158,117,.055);border-radius:8px;padding:12px 14px;font-size:12px;color:#6b7280;margin-top:20px;text-align:center}
</style>
</head>
<body>
<div class="login-card">
  <div class="login-logo">
    <strong>Homecare Creators</strong>
    <small>Admin Panel</small>
  </div>
  <?php if ($error): ?>
  <div class="error"><?= htmlspecialchars($error) ?></div>
  <?php endif ?>
  <form method="POST">
    <div class="form-group">
      <label for="username">Username</label>
      <input type="text" id="username" name="username" autocomplete="username" required autofocus value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label for="password">Password</label>
      <input type="password" id="password" name="password" autocomplete="current-password" required>
    </div>
    <button type="submit" class="btn-login">Sign In</button>
  </form>
  <div class="login-grid">Restricted access — authorised users only</div>
</div>
</body>
</html>
