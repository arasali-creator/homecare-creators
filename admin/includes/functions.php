<?php

function hc_scan_pages(): array {
    $root  = SITE_ROOT;
    $pages = [];
    $skip  = ['admin','blog','includes','assets'];

    $scan = function(string $dir, string $prefix) use (&$scan, $root, $skip, &$pages) {
        foreach (glob("$dir/*.php") as $f) {
            $base = basename($f, '.php');
            if (in_array($base, ['form-handler','install'])) continue;
            $path  = str_replace($root, '', $f);
            $path  = str_replace(['\\','.php'], ['/',  ''], $path);
            $name  = ucwords(str_replace(['-','_'], ' ', $base));
            $pages[] = ['path' => $path, 'name' => ($prefix ? $prefix . ' › ' : '') . $name, 'file' => $f];
        }
        foreach (glob("$dir/*", GLOB_ONLYDIR) as $sub) {
            $d = basename($sub);
            if (!in_array($d, $skip)) $scan($sub, ucfirst($d));
        }
    };

    $scan($root, '');
    usort($pages, fn($a,$b) => strcmp($a['path'], $b['path']));
    return $pages;
}

function hc_get_page_images(string $file): array {
    if (!file_exists($file)) return [];
    $html   = file_get_contents($file);
    $images = [];
    preg_match_all('/<img[^>]+>/i', $html, $m);
    foreach ($m[0] as $tag) {
        preg_match('/src=["\']([^"\']+)["\']/', $tag, $s);
        preg_match('/alt=["\']([^"\']*)["\']/', $tag, $a);
        if (!empty($s[1])) {
            $images[] = ['src' => $s[1], 'alt' => $a[1] ?? ''];
        }
    }
    return $images;
}

function hc_count_internal_links(string $html, string $base = 'homecarecreators.com'): int {
    preg_match_all('/href=["\']([^"\']+)["\']/', $html, $m);
    $count = 0;
    foreach ($m[1] as $url) {
        if (str_starts_with($url, '/') || str_contains($url, $base)) $count++;
    }
    return $count;
}

function hc_flash(string $msg, string $type = 'success'): void {
    $_SESSION['hc_flash'] = ['msg' => $msg, 'type' => $type];
}

function hc_show_flash(): string {
    if (empty($_SESSION['hc_flash'])) return '';
    ['msg' => $msg, 'type' => $type] = $_SESSION['hc_flash'];
    unset($_SESSION['hc_flash']);
    $cls = $type === 'success' ? 'alert-success' : 'alert-error';
    return '<div class="alert ' . $cls . '">' . htmlspecialchars($msg) . '</div>';
}

function h(mixed $v): string {
    return htmlspecialchars((string)($v ?? ''), ENT_QUOTES, 'UTF-8');
}

function hc_extract_page_meta(string $file): array {
    if (!file_exists($file)) return [];
    $src = file_get_contents($file);
    $out = [];
    foreach (['page_title','page_desc','page_canonical','og_title','og_desc'] as $var) {
        if (preg_match('/\$' . $var . '\s*=\s*["\']([^"\']+)["\']/', $src, $m)) {
            $out[$var] = $m[1];
        }
    }
    return $out;
}

function hc_setting(string $key, string $default = ''): string {
    static $cache = [];
    if (array_key_exists($key, $cache)) return $cache[$key];
    try {
        $v = hc_val("SELECT setting_value FROM hc_settings WHERE setting_key=?", [$key]);
        $cache[$key] = ($v !== null && $v !== '') ? (string)$v : $default;
    } catch (Exception $e) { $cache[$key] = $default; }
    return $cache[$key];
}

function hc_setting_save(string $key, string $value): void {
    hc_q("INSERT INTO hc_settings (setting_key,setting_value) VALUES (?,?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)", [$key, $value]);
}

function hc_whatsapp_notify(string $message): bool {
    $phone  = hc_setting('wa_phone', '');
    $apikey = hc_setting('wa_apikey', '');
    if (!$phone || !$apikey) return false;

    $url = 'https://api.callmebot.com/whatsapp.php?phone=' . urlencode($phone)
         . '&text=' . urlencode($message)
         . '&apikey=' . urlencode($apikey);

    $ctx = stream_context_create(['http' => [
        'timeout'        => 8,
        'ignore_errors'  => true,
    ]]);
    @file_get_contents($url, false, $ctx);
    return true;
}

function hc_slug(string $text): string {
    $text = strtolower(trim($text));
    $text = preg_replace('/[^a-z0-9\s-]/', '', $text);
    $text = preg_replace('/[\s-]+/', '-', $text);
    return trim($text, '-');
}
