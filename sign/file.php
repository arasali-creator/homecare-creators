<?php
// Streams a contract PDF to whoever holds the private signing link.
// While awaiting signature: the original. After signing: the signed copy.
require_once dirname(__DIR__) . '/admin/config.php';
require_once dirname(__DIR__) . '/admin/includes/db.php';
require_once dirname(__DIR__) . '/admin/includes/functions.php';
require_once dirname(__DIR__) . '/admin/includes/esign.php';

$token = (string)($_GET['t'] ?? '');
$c = preg_match('/^[a-f0-9]{48}$/', $token) ? hc_one("SELECT * FROM hc_contracts WHERE token=?", [$token]) : null;
$path = null;
if ($c && $c['status'] === 'sent')   $path = hc_es_path($c['original_file']);
if ($c && $c['status'] === 'signed') $path = hc_es_path($c['signed_file']);
if (!$path) { http_response_code(404); header('Cache-Control: no-store'); exit('Not found'); }
hc_es_stream($path, hc_es_download_name($c, $c['status'] === 'signed'), !empty($_GET['dl']));
