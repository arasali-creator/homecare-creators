<?php
require_once __DIR__ . '/includes/auth.php';
hc_logout();
header('Location: /admin/login.php');
exit;
