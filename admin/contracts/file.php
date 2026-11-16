<?php
// Streams a contract PDF (original or signed) to logged-in admins only.
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/esign.php';
hc_require_auth();

$c      = hc_one("SELECT * FROM hc_contracts WHERE id=?", [(int)($_GET['id'] ?? 0)]);
$signed = ($_GET['kind'] ?? '') === 'signed';
$path   = $c ? hc_es_path($signed ? $c['signed_file'] : $c['original_file']) : null;
if (!$path) { http_response_code(404); exit('Not found'); }
hc_es_stream($path, hc_es_download_name($c, $signed), !empty($_GET['dl']));
