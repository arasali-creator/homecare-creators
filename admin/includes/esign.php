<?php
/**
 * E-signature (Contracts) helpers — shared by /admin/contracts/ and the public /sign/ page.
 * Requires config.php, db.php and functions.php to be loaded first.
 */

const HC_ES_MAX_PDF = 25 * 1024 * 1024; // 25 MB
const HC_ES_FIELD_TYPES = ['signature', 'name', 'date'];

/** Creates the contracts table (called from the admin pages, which own it). */
function hc_es_install(): void {
    static $done = false;
    if ($done) return;
    $done = true;
    try {
        hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_contracts (
            id INT PRIMARY KEY AUTO_INCREMENT,
            title VARCHAR(255) NOT NULL,
            token CHAR(48) NOT NULL UNIQUE,
            status VARCHAR(20) NOT NULL DEFAULT 'draft',
            original_file VARCHAR(255) NOT NULL,
            original_name VARCHAR(255),
            original_sha256 CHAR(64),
            signed_file VARCHAR(255),
            signed_sha256 CHAR(64),
            fields MEDIUMTEXT,
            sender_name VARCHAR(255),
            sender_email VARCHAR(255),
            signer_name VARCHAR(255),
            signer_email VARCHAR(255),
            message TEXT,
            sent_at DATETIME NULL,
            viewed_at DATETIME NULL,
            signed_at DATETIME NULL,
            signer_ip VARCHAR(64),
            signer_ua TEXT,
            mail_status VARCHAR(500),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            KEY idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
    } catch (Exception $e) {}
    // Columns added after the first release
    try {
        if (!hc_one("SHOW COLUMNS FROM hc_contracts LIKE 'payment_url'")) {
            hc_db()->exec("ALTER TABLE hc_contracts ADD COLUMN payment_url VARCHAR(1000) NULL AFTER message");
        }
    } catch (Exception $e) {}
    // Short link code (/sign/?Kx7mQ2pRtz); older ?t=TOKEN links keep working
    try {
        if (!hc_one("SHOW COLUMNS FROM hc_contracts LIKE 'code'")) {
            hc_db()->exec("ALTER TABLE hc_contracts ADD COLUMN code VARCHAR(16) NULL UNIQUE AFTER token");
        }
        foreach (hc_all("SELECT id FROM hc_contracts WHERE code IS NULL") as $r) {
            hc_q("UPDATE hc_contracts SET code=? WHERE id=?", [hc_es_new_code(), $r['id']]);
        }
    } catch (Exception $e) {}
}

/** New unique 10-character link code (no look-alike characters such as 0/O or 1/l/I). */
function hc_es_new_code(): string {
    $abc = '23456789abcdefghjkmnpqrstuvwxyzABCDEFGHJKLMNPQRSTUVWXYZ';
    do {
        $code = '';
        for ($i = 0; $i < 10; $i++) $code .= $abc[random_int(0, strlen($abc) - 1)];
    } while (hc_val("SELECT COUNT(*) FROM hc_contracts WHERE code=?", [$code]));
    return $code;
}

/** Returns a cleaned http(s) URL, or '' if it isn't one. */
function hc_es_clean_url(string $u): string {
    $u = trim($u);
    if ($u === '') return '';
    if (!preg_match('#^https?://#i', $u)) $u = 'https://' . $u;
    return (filter_var($u, FILTER_VALIDATE_URL) && preg_match('#^https?://[^\s"<>]+$#i', $u)) ? mb_substr($u, 0, 1000) : '';
}

/** Private storage folder for contract PDFs (outside the web root when possible). */
function hc_es_dir(): ?string {
    $root = defined('SITE_ROOT') ? SITE_ROOT : dirname(__DIR__, 2);
    foreach ([dirname($root) . '/hc-private/contracts', $root . '/admin/private-uploads/contracts'] as $d) {
        if ((is_dir($d) || @mkdir($d, 0750, true)) && is_writable($d)) {
            // Belt and braces for Apache in case the in-webroot fallback is used
            $ht = dirname($d) . '/.htaccess';
            if (str_contains($d, '/admin/private-uploads/') && !file_exists($ht)) @file_put_contents($ht, "Require all denied\nDeny from all\n");
            return $d;
        }
    }
    return null;
}

/** Absolute path of a stored contract file, or null. */
function hc_es_path(?string $name): ?string {
    if (!$name || !preg_match('/^[a-f0-9]{48}(-signed)?\.pdf$/', $name)) return null;
    $dir = hc_es_dir();
    $p = $dir ? $dir . '/' . $name : null;
    return ($p && is_file($p)) ? $p : null;
}

/** Saves PDF bytes to private storage. Returns the stored file name, or an error string prefixed with "!". */
function hc_es_save_pdf(string $bytes, string $suffix = ''): string {
    if (strlen($bytes) > HC_ES_MAX_PDF) return '!The PDF is larger than 25 MB.';
    if (strncmp(ltrim(substr($bytes, 0, 1024)), '%PDF', 4) !== 0) return '!That file is not a valid PDF.';
    $dir = hc_es_dir();
    if (!$dir) return '!Contract storage is not writable. Create the folder ' . dirname(defined('SITE_ROOT') ? SITE_ROOT : dirname(__DIR__, 2)) . '/hc-private/contracts and make it writable by the site user.';
    $name = bin2hex(random_bytes(24)) . $suffix . '.pdf';
    if (@file_put_contents($dir . '/' . $name, $bytes) === false) return '!Could not save the PDF.';
    return $name;
}

function hc_es_fields(array $c): array {
    $f = json_decode((string)($c['fields'] ?? ''), true);
    return is_array($f) ? $f : [];
}

/** Validates and normalises a field list posted from the browser. */
function hc_es_clean_fields($raw): array {
    if (!is_array($raw)) return [];
    $out = [];
    foreach (array_slice($raw, 0, 200) as $f) {
        if (!is_array($f) || !in_array($f['type'] ?? '', HC_ES_FIELD_TYPES, true)) continue;
        $num = fn($k) => max(0.0, min(1.0, (float)($f[$k] ?? 0)));
        $out[] = [
            'id'    => preg_replace('/[^a-z0-9]/i', '', (string)($f['id'] ?? '')) ?: ('f' . bin2hex(random_bytes(4))),
            'type'  => $f['type'],
            'party' => ($f['party'] ?? '') === 'sender' ? 'sender' : 'signer',
            'page'  => max(1, (int)($f['page'] ?? 1)),
            'x' => $num('x'), 'y' => $num('y'), 'w' => max(0.01, $num('w')), 'h' => max(0.005, $num('h')),
            'value' => hc_es_clean_value($f['type'], $f['value'] ?? ''),
        ];
    }
    return $out;
}

function hc_es_clean_value(string $type, $v): string {
    $v = (string)$v;
    if ($type === 'signature') {
        return (strlen($v) < 1500000 && preg_match('#^data:image/png;base64,[A-Za-z0-9+/=]+$#', $v)) ? $v : '';
    }
    return mb_substr(trim(preg_replace('/[\x00-\x1F\x7F]/u', '', $v)), 0, 120);
}

function hc_es_sign_url(array $c): string {
    $site = defined('SITE_URL') ? rtrim(SITE_URL, '/') : 'https://homecarecreators.com';
    return $site . '/sign/?' . (!empty($c['code']) ? $c['code'] : 't=' . $c['token']);
}

function hc_es_default_sender_email(): string {
    foreach ([hc_setting('notification_email', ''), hc_setting('reply_to_email', '')] as $v) {
        foreach (hc_csv_list($v) as $e) if (filter_var($e, FILTER_VALIDATE_EMAIL)) return $e;
    }
    return '';
}

function hc_es_download_name(array $c, bool $signed): string {
    $base = trim(preg_replace('/[^A-Za-z0-9]+/', '-', $c['title']), '-') ?: 'contract';
    return $base . ($signed ? '-signed' : '') . '.pdf';
}

/** Streams a PDF to the browser. */
function hc_es_stream(string $path, string $name, bool $download): void {
    header('Content-Type: application/pdf');
    header('Content-Length: ' . filesize($path));
    header('Cache-Control: private, no-store, max-age=0');
    header('X-Robots-Tag: noindex, nofollow');
    header('X-Content-Type-Options: nosniff');
    header('Content-Disposition: ' . ($download ? 'attachment' : 'inline') . '; filename="' . $name . '"');
    readfile($path);
    exit;
}

/** Simple branded HTML email wrapper. $bodyHtml must already be escaped. */
function hc_es_email_html(string $heading, string $bodyHtml, string $btnUrl = '', string $btnText = ''): string {
    $site = h(hc_setting('site_name', 'Homecare Creators'));
    $btn = $btnUrl ? '<p style="margin:26px 0"><a href="' . h($btnUrl) . '" style="background:#1d9e75;color:#fff;padding:13px 26px;border-radius:8px;text-decoration:none;font-weight:700;display:inline-block">' . h($btnText) . '</a></p>' : '';
    return '<!doctype html><html><body style="margin:0;background:#f2f3f5;font-family:-apple-system,Segoe UI,Roboto,Arial,sans-serif;color:#111827">'
        . '<div style="max-width:560px;margin:0 auto;padding:28px 16px">'
        . '<div style="background:#0a2e1e;color:#fff;padding:16px 24px;border-radius:10px 10px 0 0;font-weight:700">' . $site . '</div>'
        . '<div style="background:#fff;padding:26px 24px;border-radius:0 0 10px 10px;border:1px solid #e5e7eb;border-top:0">'
        . '<h2 style="margin:0 0 14px;font-size:20px;color:#0a2e1e">' . h($heading) . '</h2>'
        . '<div style="font-size:15px;line-height:1.6">' . $bodyHtml . '</div>' . $btn
        . '</div></div></body></html>';
}

/** Emails the signing link to the signer. Returns '' on success or an error message. */
function hc_es_send_invite(array $c): string {
    require_once __DIR__ . '/mailer.php';
    $url  = hc_es_sign_url($c);
    $from = $c['sender_name'] ?: hc_setting('site_name', 'Homecare Creators');
    $subj = "Please sign: {$c['title']}";
    $msg  = trim((string)$c['message']);
    $text = "Hi {$c['signer_name']},\n\n{$from} has sent you \"{$c['title']}\" to review and sign.\n\n"
          . ($msg ? $msg . "\n\n" : '') . "Open the document and sign here:\n{$url}\n\nThis link is private to you, so please don't forward it.";
    $html = hc_es_email_html('You have a document to sign',
        '<p>Hi ' . h($c['signer_name']) . ',</p><p><strong>' . h($from) . '</strong> has sent you <strong>' . h($c['title']) . '</strong> to review and sign.</p>'
        . ($msg ? '<p style="background:#f8f5ef;padding:12px 14px;border-radius:8px">' . nl2br(h($msg)) . '</p>' : ''),
        $url, 'Review & Sign')
        . '';
    $ok = HcMailer::send($c['signer_email'], $subj, $text, (string)$c['sender_email'], '', $html);
    return $ok ? '' : ('Email to ' . $c['signer_email'] . ' failed: ' . ($GLOBALS['_hc_mailer_last_error'] ?? 'mail() returned false'));
}

/** Emails the signed PDF to both parties. Returns a short status line for the log. */
function hc_es_send_completed(array $c, string $pdfBytes): string {
    require_once __DIR__ . '/mailer.php';
    $att  = [['name' => hc_es_download_name($c, true), 'data' => $pdfBytes, 'mime' => 'application/pdf']];
    $when = date('M j, Y g:i A T', strtotime($c['signed_at'] ?? 'now'));
    $from = $c['sender_name'] ?: hc_setting('site_name', 'Homecare Creators');
    $res  = [];

    // Signer copy
    $text = "Hi {$c['signer_name']},\n\nYou signed \"{$c['title']}\" on {$when}. Your signed copy is attached.\n\nThank you,\n{$from}";
    $pay  = (string)($c['payment_url'] ?? '');
    if ($pay) $text .= "\n\nNext step — complete your payment here:\n{$pay}";
    $html = hc_es_email_html('Your signed copy',
        '<p>Hi ' . h($c['signer_name']) . ',</p><p>You signed <strong>' . h($c['title']) . '</strong> on ' . h($when) . '. Your signed copy is attached to this email.</p>'
        . ($pay ? '<p><strong>Next step:</strong> please complete your payment using the button below.</p>' : '') . '<p>Thank you,<br>' . h($from) . '</p>',
        $pay, $pay ? 'Complete Payment' : '');
    $ok = HcMailer::send($c['signer_email'], "Signed: {$c['title']}", $text, (string)$c['sender_email'], '', $html, $att);
    $res[] = 'signer ' . ($ok ? 'sent' : 'FAILED');

    // Sender copy
    if ($c['sender_email']) {
        $site = defined('SITE_URL') ? rtrim(SITE_URL, '/') : 'https://homecarecreators.com';
        $text = "{$c['signer_name']} ({$c['signer_email']}) signed \"{$c['title']}\" on {$when}.\nIP address: {$c['signer_ip']}\n\nThe signed PDF is attached.";
        $html = hc_es_email_html('Contract signed',
            '<p><strong>' . h($c['signer_name']) . '</strong> (' . h($c['signer_email']) . ') signed <strong>' . h($c['title']) . '</strong> on ' . h($when) . '.</p><p style="color:#6b7280;font-size:13px">IP address: ' . h($c['signer_ip']) . '</p><p>The signed PDF is attached.</p>',
            $site . '/admin/contracts/edit.php?id=' . (int)$c['id'], 'View in admin');
        $ok2 = HcMailer::send($c['sender_email'], "Signed: {$c['title']} — {$c['signer_name']}", $text, (string)$c['signer_email'], '', $html, $att);
        $res[] = 'sender ' . ($ok2 ? 'sent' : 'FAILED');
    }
    $err = $GLOBALS['_hc_mailer_last_error'] ?? '';
    return 'Completion email: ' . implode(', ', $res) . ($err && str_contains(implode($res), 'FAILED') ? ' — ' . mb_substr($err, 0, 200) : '');
}

function hc_es_status_badge(string $s): string {
    $cls = ['draft' => 'badge-gray', 'sent' => 'badge-blue', 'signed' => 'badge-green', 'void' => 'badge-red'][$s] ?? 'badge-gray';
    $lbl = ['draft' => 'Draft', 'sent' => 'Awaiting signature', 'signed' => 'Signed', 'void' => 'Voided'][$s] ?? $s;
    return '<span class="badge ' . $cls . '">' . $lbl . '</span>';
}
