<?php
// ============================================================
//  Homecare Creators — Admin Installer
//  1. Fill in admin/config.php with your DB credentials
//  2. Visit /admin/install.php in your browser
//  3. DELETE this file after running!
// ============================================================

define('INSTALLER', true);

if (!file_exists(__DIR__ . '/config.php')) {
    die('<h2>Error:</h2><p>Create <code>admin/config.php</code> first with your DB credentials.</p>');
}
require_once __DIR__ . '/config.php';

$errors = $tables = [];

try {
    $pdo = new PDO(
        'mysql:host=' . DB_HOST . ';charset=utf8mb4',
        DB_USER, DB_PASS,
        [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
    );
    $pdo->exec("CREATE DATABASE IF NOT EXISTS `" . DB_NAME . "` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci");
    $pdo->exec("USE `" . DB_NAME . "`");

    $sql_tables = [
        'hc_seo_pages' => "CREATE TABLE IF NOT EXISTS hc_seo_pages (
            id INT PRIMARY KEY AUTO_INCREMENT,
            page_path VARCHAR(500) NOT NULL UNIQUE,
            page_name VARCHAR(200),
            meta_title VARCHAR(200),
            meta_desc TEXT,
            focus_keyword VARCHAR(200),
            secondary_keywords TEXT,
            h1_override VARCHAR(300),
            canonical_url VARCHAR(500),
            robots_index TINYINT DEFAULT 1,
            robots_follow TINYINT DEFAULT 1,
            og_title VARCHAR(200),
            og_desc TEXT,
            og_image VARCHAR(500),
            twitter_card VARCHAR(50) DEFAULT 'summary_large_image',
            twitter_title VARCHAR(200),
            twitter_desc TEXT,
            twitter_image VARCHAR(500),
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_page_schema' => "CREATE TABLE IF NOT EXISTS hc_page_schema (
            id INT PRIMARY KEY AUTO_INCREMENT,
            page_path VARCHAR(500) NOT NULL,
            schema_type VARCHAR(100) NOT NULL,
            schema_data LONGTEXT,
            active TINYINT DEFAULT 1,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            KEY(page_path)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_redirects' => "CREATE TABLE IF NOT EXISTS hc_redirects (
            id INT PRIMARY KEY AUTO_INCREMENT,
            source_path VARCHAR(500) NOT NULL UNIQUE,
            destination_url VARCHAR(500) NOT NULL,
            code SMALLINT DEFAULT 301,
            active TINYINT DEFAULT 1,
            hits INT DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_hreflang' => "CREATE TABLE IF NOT EXISTS hc_hreflang (
            id INT PRIMARY KEY AUTO_INCREMENT,
            page_path VARCHAR(500) NOT NULL,
            locale VARCHAR(20) NOT NULL,
            url VARCHAR(500) NOT NULL,
            UNIQUE KEY uq_page_locale (page_path, locale)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_entity' => "CREATE TABLE IF NOT EXISTS hc_entity (
            id INT PRIMARY KEY AUTO_INCREMENT,
            field_key VARCHAR(100) NOT NULL UNIQUE,
            field_value LONGTEXT,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_faqs' => "CREATE TABLE IF NOT EXISTS hc_faqs (
            id INT PRIMARY KEY AUTO_INCREMENT,
            question TEXT NOT NULL,
            answer LONGTEXT NOT NULL,
            pages TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_citations' => "CREATE TABLE IF NOT EXISTS hc_citations (
            id INT PRIMARY KEY AUTO_INCREMENT,
            source_name VARCHAR(200) NOT NULL,
            url VARCHAR(500),
            anchor_text VARCHAR(500),
            found_date DATE,
            notes TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_kg_links' => "CREATE TABLE IF NOT EXISTS hc_kg_links (
            id INT PRIMARY KEY AUTO_INCREMENT,
            platform VARCHAR(100) NOT NULL,
            url VARCHAR(500) NOT NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_blog_posts' => "CREATE TABLE IF NOT EXISTS hc_blog_posts (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(300) NOT NULL,
            slug VARCHAR(300) NOT NULL UNIQUE,
            excerpt TEXT,
            content LONGTEXT,
            featured_image VARCHAR(500),
            author VARCHAR(100) DEFAULT 'Homecare Creators',
            focus_keyword VARCHAR(200),
            secondary_keywords TEXT,
            meta_title VARCHAR(200),
            meta_desc TEXT,
            og_image VARCHAR(500),
            status ENUM('draft','published') DEFAULT 'draft',
            published_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_form_submissions' => "CREATE TABLE IF NOT EXISTS hc_form_submissions (
            id INT PRIMARY KEY AUTO_INCREMENT,
            name VARCHAR(200),
            email VARCHAR(200),
            phone VARCHAR(50),
            agency_name VARCHAR(200),
            city VARCHAR(100),
            service VARCHAR(100),
            message TEXT,
            status ENUM('new','read','archived') DEFAULT 'new',
            ip_address VARCHAR(50),
            submitted_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",

        'hc_image_alts' => "CREATE TABLE IF NOT EXISTS hc_image_alts (
            id INT PRIMARY KEY AUTO_INCREMENT,
            image_src VARCHAR(500) NOT NULL,
            alt_text VARCHAR(500) DEFAULT '',
            page_path VARCHAR(500),
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            UNIQUE KEY uq_src_page (image_src(200), page_path(200))
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4",
    ];

    foreach ($sql_tables as $name => $sql) {
        $pdo->exec($sql);
        $tables[] = $name;
    }

    // Seed entity fields if empty
    $count = (int)$pdo->query("SELECT COUNT(*) FROM hc_entity")->fetchColumn();
    if ($count === 0) {
        $fields = ['business_name','business_description','business_type','phone','email','address','city','state','zip','founded_year','service_area','specialty'];
        $ins = $pdo->prepare("INSERT IGNORE INTO hc_entity (field_key, field_value) VALUES (?,?)");
        foreach ($fields as $f) $ins->execute([$f,'']);
    }

} catch (PDOException $e) {
    $errors[] = $e->getMessage();
}
?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Installer — Homecare Creators</title>
<style>
body{font-family:-apple-system,sans-serif;background:#0a2e1e;min-height:100vh;display:flex;align-items:center;justify-content:center;padding:20px}
.card{background:#fff;border-radius:14px;padding:36px 40px;max-width:540px;width:100%}
h1{font-size:22px;font-weight:800;color:#0a2e1e;margin-bottom:6px}
p{font-size:14px;color:#6b7280;margin-bottom:20px}
.check{color:#1d9e75;font-size:14px;margin:4px 0}
.err{color:#dc2626;font-size:14px;background:rgba(220,38,38,.07);padding:10px 14px;border-radius:8px;margin:8px 0}
.warning{background:rgba(220,38,38,.08);border:2px solid rgba(220,38,38,.3);border-radius:10px;padding:16px;margin-top:20px;color:#7f1d1d;font-size:13px}
.warning strong{display:block;margin-bottom:4px;font-size:15px}
.next{display:inline-block;margin-top:20px;padding:11px 22px;background:#1d9e75;color:#fff;border-radius:8px;text-decoration:none;font-weight:700;font-size:14px}
code{background:#f3f4f6;padding:2px 6px;border-radius:4px;font-size:13px;color:#0a2e1e}
</style>
</head>
<body>
<div class="card">
  <h1>Homecare Creators Installer</h1>
  <p>Setting up your admin database on <strong><?= htmlspecialchars(DB_HOST) ?></strong> → <strong><?= htmlspecialchars(DB_NAME) ?></strong></p>

  <?php if ($errors): ?>
    <?php foreach($errors as $e): ?><div class="err">✗ <?= htmlspecialchars($e) ?></div><?php endforeach ?>
    <p style="color:#dc2626;margin-top:12px">Fix the errors above, then refresh this page.</p>
  <?php else: ?>
    <?php foreach($tables as $t): ?><div class="check">✓ Table <code><?= $t ?></code> ready</div><?php endforeach ?>

    <div class="warning">
      <strong>🔒 Delete this file now</strong>
      Run on your VPS: <code>rm /home/homecarecreators/htdocs/homecarecreators.com/admin/install.php</code><br><br>
      Then set your password: edit <code>admin/config.php</code> and update <code>ADMIN_PASS_HASH</code> — generate a hash with:<br>
      <code>php -r "echo password_hash('YourPassword', PASSWORD_DEFAULT);"</code>
    </div>

    <a href="/admin/" class="next">Go to Admin Panel →</a>
  <?php endif ?>
</div>
</body>
</html>
