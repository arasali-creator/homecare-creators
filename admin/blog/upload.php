<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
hc_require_auth();

header('Content-Type: application/json');

// ── Ensure media table exists ────────────────────────────────────────────────
try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_blog_media (
        id INT AUTO_INCREMENT PRIMARY KEY,
        filename VARCHAR(255) NOT NULL,
        url VARCHAR(500) NOT NULL,
        original_name VARCHAR(255),
        file_size INT DEFAULT 0,
        mime_type VARCHAR(100),
        uploaded_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}

// ── List existing media ──────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'GET' && ($_GET['action'] ?? '') === 'list') {
    $media = hc_all("SELECT id,url,original_name,file_size,uploaded_at FROM hc_blog_media ORDER BY uploaded_at DESC LIMIT 60");
    echo json_encode(['success' => true, 'items' => $media]);
    exit;
}

// ── Delete media ─────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'delete') {
    $id  = (int)($_POST['id'] ?? 0);
    $row = hc_one("SELECT url FROM hc_blog_media WHERE id=?", [$id]);
    if ($row) {
        $file = SITE_ROOT . $row['url'];
        if (file_exists($file)) @unlink($file);
        hc_q("DELETE FROM hc_blog_media WHERE id=?", [$id]);
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Not found.']);
    }
    exit;
}

// ── Upload ───────────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] !== 'POST' || empty($_FILES['file'])) {
    echo json_encode(['success' => false, 'error' => 'No file received.']);
    exit;
}

$file    = $_FILES['file'];
$allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif', 'image/webp'];

if ($file['error'] !== UPLOAD_ERR_OK) {
    echo json_encode(['success' => false, 'error' => 'Upload error code: ' . $file['error']]);
    exit;
}
if (!in_array($file['type'], $allowed)) {
    echo json_encode(['success' => false, 'error' => 'Only JPG, PNG, GIF and WebP images are allowed.']);
    exit;
}
if ($file['size'] > 5 * 1024 * 1024) {
    echo json_encode(['success' => false, 'error' => 'Maximum file size is 5 MB.']);
    exit;
}

$subdir     = date('Y/m');
$upload_dir = SITE_ROOT . '/images/blog/' . $subdir . '/';
if (!is_dir($upload_dir) && !@mkdir($upload_dir, 0755, true) && !is_dir($upload_dir)) {
    echo json_encode(['success' => false, 'error' => 'Could not create folder /images/blog/' . $subdir . '/ — the web server user does not have write permission on /images/blog/. Run on the server: chmod -R 755 images/blog && chown -R $(whoami):$(whoami) images/blog']);
    exit;
}
if (!is_writable($upload_dir)) {
    echo json_encode(['success' => false, 'error' => 'Folder /images/blog/' . $subdir . '/ exists but is not writable by the web server. Run on the server: chmod -R 755 images/blog']);
    exit;
}

$ext      = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
$filename = uniqid('img_', true) . '.' . $ext;
$dest     = $upload_dir . $filename;

if (!move_uploaded_file($file['tmp_name'], $dest)) {
    $err = error_get_last();
    echo json_encode(['success' => false, 'error' => 'Could not save file: ' . ($err['message'] ?? 'unknown error') . '. Check that /images/blog/ is owned by the web server user.']);
    exit;
}

$url = '/images/blog/' . $subdir . '/' . $filename;

try {
    hc_q("INSERT INTO hc_blog_media (filename,url,original_name,file_size,mime_type) VALUES (?,?,?,?,?)",
        [$filename, $url, $file['name'], $file['size'], $file['type']]);
} catch(Exception $e){}

echo json_encode(['success' => true, 'url' => $url, 'filename' => $filename]);
