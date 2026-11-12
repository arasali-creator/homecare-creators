<?php
// Streams a private verification photo/video to logged-in admins only (supports Range for video seeking).
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/directory.php';
hc_require_auth();

$v = hc_one("SELECT file_path, file_mime FROM hc_directory_verifications WHERE id=?", [(int)($_GET['id'] ?? 0)]);
$path = $v['file_path'] ?? '';
$dir  = hc_dir_private_dir();
if (!$v || !$path || !is_file($path) || !$dir || strpos(realpath($path), realpath(dirname($path))) !== 0 || !isset(HC_DIR_VERIFY_TYPES[$v['file_mime']])) {
    http_response_code(404); exit('Not found');
}

$size = filesize($path); $start = 0; $end = $size - 1;
header('Content-Type: ' . $v['file_mime']);
header('Cache-Control: private, no-store');
header('X-Content-Type-Options: nosniff');
header('Accept-Ranges: bytes');
if (isset($_SERVER['HTTP_RANGE']) && preg_match('/bytes=(\d*)-(\d*)/', $_SERVER['HTTP_RANGE'], $m)) {
    if ($m[1] !== '') $start = (int)$m[1];
    if ($m[2] !== '') $end = min((int)$m[2], $size - 1);
    if ($m[1] === '' && $m[2] !== '') { $start = max(0, $size - (int)$m[2]); $end = $size - 1; }
    if ($start > $end || $start >= $size) { http_response_code(416); header("Content-Range: bytes */$size"); exit; }
    http_response_code(206);
    header("Content-Range: bytes $start-$end/$size");
}
header('Content-Length: ' . ($end - $start + 1));
$fh = fopen($path, 'rb'); fseek($fh, $start);
$left = $end - $start + 1;
while ($left > 0 && !feof($fh)) { $chunk = fread($fh, min(1048576, $left)); echo $chunk; $left -= strlen($chunk); flush(); }
fclose($fh);
