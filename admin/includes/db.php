<?php
if (!defined('DB_HOST')) {
    $cfg = dirname(__DIR__) . '/config.php';
    if (file_exists($cfg)) require_once $cfg;
    else return;
}

function hc_db(): PDO {
    static $pdo;
    if (!$pdo) {
        $pdo = new PDO(
            'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=utf8mb4',
            DB_USER, DB_PASS,
            [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
             PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
             PDO::ATTR_EMULATE_PREPARES => false]
        );
    }
    return $pdo;
}

function hc_q(string $sql, array $p = []): PDOStatement {
    $s = hc_db()->prepare($sql);
    $s->execute($p);
    return $s;
}

function hc_one(string $sql, array $p = []): ?array {
    try { return hc_q($sql, $p)->fetch() ?: null; }
    catch (Exception $e) { return null; }
}

function hc_all(string $sql, array $p = []): array {
    try { return hc_q($sql, $p)->fetchAll(); }
    catch (Exception $e) { return []; }
}

function hc_val(string $sql, array $p = []): mixed {
    try { $r = hc_q($sql, $p)->fetchColumn(); return $r === false ? null : $r; }
    catch (Exception $e) { return null; }
}
