<?php
// ============================================================
//  Homecare Creators — Admin Config
//  Fill in your MySQL credentials, then run /admin/install.php
//  DELETE install.php after first run.
// ============================================================

define('DB_HOST', 'localhost');
define('DB_NAME', 'YOUR_DB_NAME');
define('DB_USER', 'YOUR_DB_USER');
define('DB_PASS', 'YOUR_DB_PASS');

define('ADMIN_USER', 'admin');
// Generate a new hash:  php -r "echo password_hash('yourpassword', PASSWORD_DEFAULT);"
// Default password:  Homecare2024!
define('ADMIN_PASS_HASH', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi');

define('SITE_URL',  'https://homecarecreators.com');
define('SITE_ROOT', dirname(__DIR__));
define('ADMIN_URL', SITE_URL . '/admin');
