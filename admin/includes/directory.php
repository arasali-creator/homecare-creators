<?php
/**
 * Agency Directory — shared schema, plan definitions and helpers.
 * Used by the public directory pages, the submit/confirm/lead handlers and /admin/directory/.
 *
 * Requires admin/config.php + admin/includes/db.php (+ functions.php for hc_setting) to be loaded first.
 */

const HC_DIR_SCHEMA_VERSION = '4';

/** Standard service list — submit form checkboxes + directory filters. */
const HC_DIR_SERVICES = [
    'Personal Care', 'Companion Care', 'Skilled Nursing', 'Alzheimer\'s & Dementia Care',
    '24-Hour Care', 'Live-In Care', 'Respite Care', 'Post-Hospital Care',
    'Medication Management', 'Homemaker Services', 'Transportation', 'Hospice Support',
];

const HC_DIR_PAYMENTS = [
    'Private Pay', 'Long-Term Care Insurance', 'Medicaid', 'Medicare',
    'VA Benefits', 'Private Health Insurance',
];

/** "Highlights" — Yelp-style amenities for home care agencies. key => [label, Font Awesome icon]. */
const HC_DIR_FEATURES = [
    'Free in-home assessment'         => 'fa-clipboard-check',
    'Background-checked caregivers'   => 'fa-user-shield',
    'Bonded & insured'                => 'fa-shield-halved',
    'Nurse on staff'                  => 'fa-user-nurse',
    'No minimum hours'                => 'fa-hourglass-half',
    'Same or next-day start'          => 'fa-bolt',
    'Caregiver matching'              => 'fa-people-arrows',
    '24/7 on-call support'            => 'fa-headset',
    'Bilingual caregivers'            => 'fa-language',
    'Family care updates'             => 'fa-mobile-screen',
    'Hospital discharge coordination' => 'fa-hospital-user',
    'Veteran-owned'                   => 'fa-flag-usa',
];

const HC_DIR_DAYS = ['mon' => 'Mon', 'tue' => 'Tue', 'wed' => 'Wed', 'thu' => 'Thu', 'fri' => 'Fri', 'sat' => 'Sat', 'sun' => 'Sun'];

const HC_DIR_PAYMENT_STATUSES = [
    'none'     => 'No payment (free)',
    'pending'  => 'Invoice to send',
    'invoiced' => 'Invoiced — awaiting payment',
    'paid'     => 'Paid',
    'comp'     => 'Complimentary',
    'overdue'  => 'Overdue',
];

/** Plan definitions. Prices come from hc_settings so they can be changed in admin. */
function hc_dir_plans(): array {
    $fn = function_exists('hc_setting') ? 'hc_setting' : fn($k, $d) => $d;
    return [
        'free' => [
            'name'  => 'Basic',
            'price' => 0,
            'blurb' => 'Get found by families searching your area.',
            'features' => [
                'Agency profile page',
                'Phone number & service area',
                'Services list',
                'Map location',
            ],
        ],
        'premium' => [
            'name'  => 'Premium',
            'price' => (int)$fn('dir_price_premium', '49'),
            'blurb' => 'A complete, trusted profile that converts.',
            'features' => [
                'Everything in Basic',
                'Cover photo & photo gallery',
                'Website link (do-follow) & email',
                'Verified Agency badge',
                'Ranked above Basic listings',
                'No competitor ads on your profile',
            ],
        ],
        'featured' => [
            'name'  => 'Featured',
            'price' => (int)$fn('dir_price_featured', '99'),
            'blurb' => 'Top placement and direct client inquiries.',
            'features' => [
                'Everything in Premium',
                'Top-of-results placement in your city',
                'Spotlight on the directory home page',
                'Consultation request form on your profile',
                'Inquiries emailed straight to you',
            ],
        ],
    ];
}

/** Create / upgrade the directory tables. Cheap after the first run (one cached settings read). */
function hc_dir_ensure_schema(): void {
    static $done = false;
    if ($done) return;
    $done = true;

    $current = '';
    try { $current = (string)hc_val("SELECT setting_value FROM hc_settings WHERE setting_key='dir_schema_v'"); } catch (Exception $e) {}
    if ($current === HC_DIR_SCHEMA_VERSION) return;

    try {
        hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_directory_listings (
            id INT PRIMARY KEY AUTO_INCREMENT,
            company_name VARCHAR(255) NOT NULL,
            slug VARCHAR(255) NOT NULL UNIQUE,
            logo VARCHAR(500),
            description TEXT NOT NULL,
            services TEXT,
            city VARCHAR(100) NOT NULL,
            state VARCHAR(2) NOT NULL DEFAULT 'FL',
            service_areas TEXT,
            address VARCHAR(255),
            phone VARCHAR(50),
            email VARCHAR(255),
            website VARCHAR(500),
            license_number VARCHAR(100),
            years_in_business VARCHAR(50),
            featured TINYINT(1) NOT NULL DEFAULT 0,
            status VARCHAR(20) NOT NULL DEFAULT 'pending',
            rejection_reason VARCHAR(500),
            source_page VARCHAR(255),
            ip_address VARCHAR(64),
            user_agent TEXT,
            device_type VARCHAR(20),
            geo_city VARCHAR(100),
            geo_region VARCHAR(100),
            geo_country VARCHAR(100),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            approved_at TIMESTAMP NULL,
            updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
            KEY idx_status (status),
            KEY idx_city (city)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        $cols = array_column(hc_all("SHOW COLUMNS FROM hc_directory_listings"), 'Field');
        $add = [
            // Plan & billing (manual invoicing)
            'plan'               => "VARCHAR(20) NOT NULL DEFAULT 'free'",
            'requested_plan'     => "VARCHAR(20) NULL",
            'payment_status'     => "VARCHAR(20) NOT NULL DEFAULT 'none'",
            'paid_until'         => "DATE NULL",
            'invoice_ref'        => "VARCHAR(100) NULL",
            // Owner / authorized representative
            'owner_name'         => "VARCHAR(150) NULL",
            'owner_title'        => "VARCHAR(100) NULL",
            'owner_email'        => "VARCHAR(255) NULL",
            'owner_phone'        => "VARCHAR(50) NULL",
            'owner_authorized'   => "TINYINT(1) NOT NULL DEFAULT 0",
            'owner_confirmed_at' => "TIMESTAMP NULL",
            'confirm_token'      => "VARCHAR(64) NULL",
            'confirm_sent_at'    => "TIMESTAMP NULL",
            'claim_status'       => "VARCHAR(20) NULL",
            // Richer profile
            'tagline'            => "VARCHAR(160) NULL",
            'cover_image'        => "VARCHAR(500) NULL",
            'photos'             => "TEXT NULL",
            'payment_accepted'   => "TEXT NULL",
            'languages'          => "VARCHAR(255) NULL",
            'hours'              => "VARCHAR(255) NULL",
            'verified'           => "TINYINT(1) NOT NULL DEFAULT 0",
            'admin_notes'        => "TEXT NULL",
            // v3: Yelp-style data
            'features'           => "TEXT NULL",
            'hours_json'         => "TEXT NULL",
            'lat'                => "DECIMAL(10,7) NULL",
            'lng'                => "DECIMAL(10,7) NULL",
            'geocoded_at'        => "TIMESTAMP NULL",
            'rating_avg'         => "DECIMAL(2,1) NULL",
            'rating_count'       => "INT NOT NULL DEFAULT 0",
            // v4: owner accounts
            'owner_account_id'   => "INT NULL",
        ];
        foreach ($add as $col => $def) {
            if (!in_array($col, $cols, true)) hc_db()->exec("ALTER TABLE hc_directory_listings ADD COLUMN `$col` $def");
        }
        if (!in_array('confirm_token', $cols, true)) {
            try { hc_db()->exec("ALTER TABLE hc_directory_listings ADD KEY idx_confirm_token (confirm_token)"); } catch (Exception $e) {}
        }
        // One-time carry-over: listings that were "featured" before plans existed keep it as complimentary.
        if (!in_array('plan', $cols, true)) {
            hc_q("UPDATE hc_directory_listings SET plan='featured', payment_status='comp' WHERE featured=1");
        }

        hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_directory_reviews (
            id INT PRIMARY KEY AUTO_INCREMENT,
            listing_id INT NOT NULL,
            name VARCHAR(120) NOT NULL,
            email VARCHAR(255) NOT NULL,
            relationship VARCHAR(80),
            rating TINYINT NOT NULL,
            title VARCHAR(150),
            body TEXT NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'pending',
            owner_response TEXT,
            response_at TIMESTAMP NULL,
            ip_address VARCHAR(64),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            approved_at TIMESTAMP NULL,
            KEY idx_listing_status (listing_id, status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_directory_owners (
            id INT PRIMARY KEY AUTO_INCREMENT,
            email VARCHAR(255) NOT NULL UNIQUE,
            name VARCHAR(150),
            password_hash VARCHAR(255),
            verified_at TIMESTAMP NULL,
            reset_token VARCHAR(64) NULL,
            reset_sent_at TIMESTAMP NULL,
            last_login_at TIMESTAMP NULL,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            KEY idx_reset (reset_token)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_directory_verifications (
            id INT PRIMARY KEY AUTO_INCREMENT,
            listing_id INT NOT NULL,
            request_note TEXT,
            status VARCHAR(20) NOT NULL DEFAULT 'requested',
            file_path VARCHAR(500),
            file_mime VARCHAR(100),
            file_name VARCHAR(255),
            owner_note TEXT,
            admin_note VARCHAR(500),
            requested_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            submitted_at TIMESTAMP NULL,
            reviewed_at TIMESTAMP NULL,
            KEY idx_listing (listing_id),
            KEY idx_status (status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_directory_edits (
            id INT PRIMARY KEY AUTO_INCREMENT,
            listing_id INT NOT NULL,
            owner_id INT NOT NULL,
            data MEDIUMTEXT NOT NULL,
            status VARCHAR(20) NOT NULL DEFAULT 'pending',
            admin_note VARCHAR(500),
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            reviewed_at TIMESTAMP NULL,
            KEY idx_listing_status (listing_id, status)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_directory_leads (
            id INT PRIMARY KEY AUTO_INCREMENT,
            listing_id INT NOT NULL,
            name VARCHAR(150) NOT NULL,
            phone VARCHAR(50),
            email VARCHAR(255),
            care_for VARCHAR(100),
            message TEXT,
            ip_address VARCHAR(64),
            emailed TINYINT(1) NOT NULL DEFAULT 0,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
            KEY idx_listing (listing_id)
        ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

        hc_q("INSERT INTO hc_settings (setting_key,setting_value) VALUES ('dir_schema_v',?) ON DUPLICATE KEY UPDATE setting_value=VALUES(setting_value)", [HC_DIR_SCHEMA_VERSION]);
    } catch (Exception $e) { /* table may be mid-creation elsewhere; retry next request */ }
}

/** The tier a listing actually gets right now — paid plans only apply once paid (or comped) and not expired. */
function hc_dir_tier(array $l): string {
    $plan = $l['plan'] ?? 'free';
    if ($plan === 'free' || !isset(hc_dir_plans()[$plan])) return 'free';
    if (!in_array($l['payment_status'] ?? '', ['paid', 'comp'], true)) return 'free';
    if (!empty($l['paid_until']) && strtotime($l['paid_until'] . ' 23:59:59') < time()) return 'free';
    return $plan;
}

/** Public "Claimed" state: owner confirmed, and (if it was a claim of an existing listing) admin has verified it. */
function hc_dir_is_claimed(array $l): bool {
    return !empty($l['owner_confirmed_at']) && !in_array($l['claim_status'] ?? '', ['pending', 'confirmed'], true);
}

/** Record a payment: activates the requested plan and extends paid_until by $months from today or the current end date. */
function hc_dir_mark_paid(int $id, int $months = 1): void {
    hc_q("UPDATE hc_directory_listings SET
            plan = CASE WHEN requested_plan IN ('premium','featured') THEN requested_plan ELSE plan END,
            requested_plan = NULL,
            payment_status = 'paid',
            paid_until = DATE_ADD(GREATEST(CURDATE(), IFNULL(paid_until, CURDATE())), INTERVAL ? MONTH)
          WHERE id=?", [$months, $id]);
    hc_q("UPDATE hc_directory_listings SET featured = (plan='featured') WHERE id=?", [$id]);
}

/** True when the description is the placeholder text from the bulk import (never show that publicly). */
function hc_dir_is_placeholder_desc(?string $d): bool {
    $d = (string)$d;
    return $d === '' || stripos($d, 'directory research') !== false || stripos($d, 'before approving') !== false;
}

/** Public-safe description: real text, or a neutral generated sentence for imported placeholders. */
function hc_dir_public_desc(array $l): string {
    if (!hc_dir_is_placeholder_desc($l['description'] ?? '')) return trim($l['description']);
    $svcs = hc_dir_lines($l['services'] ?? '');
    $s = $l['company_name'] . ' is a home care agency based in ' . $l['city'] . ', ' . $l['state'] . '.';
    if ($svcs) $s .= ' Services include ' . strtolower(implode(', ', array_slice($svcs, 0, 3))) . '.';
    return $s;
}

/** SQL expression ranking tiers (higher first) — mirrors hc_dir_tier(). */
function hc_dir_rank_sql(): string {
    $active = "payment_status IN ('paid','comp') AND (paid_until IS NULL OR paid_until >= CURDATE())";
    return "(CASE WHEN plan='featured' AND $active THEN 2 WHEN plan='premium' AND $active THEN 1 ELSE 0 END)";
}

function hc_dir_lines(?string $v): array {
    return array_values(array_filter(array_map('trim', preg_split('/\r?\n/', (string)$v))));
}

function hc_dir_areas(?string $v): array {
    return array_values(array_filter(array_map('trim', preg_split('/[\r\n,]+/', (string)$v))));
}

function hc_dir_domain(?string $urlOrEmail): string {
    $s = strtolower(trim((string)$urlOrEmail));
    if ($s === '') return '';
    if (str_contains($s, '@')) $s = substr($s, strpos($s, '@') + 1);
    else $s = parse_url(str_contains($s, '://') ? $s : 'http://' . $s, PHP_URL_HOST) ?: '';
    return preg_replace('/^www\./', '', $s);
}

/** True when the owner's email is on the agency's own website domain — a strong ownership signal. */
function hc_dir_domain_match(array $l): bool {
    $a = hc_dir_domain($l['owner_email'] ?? '');
    $b = hc_dir_domain($l['website'] ?? '');
    return $a !== '' && $a === $b;
}

function hc_dir_initials(string $name): string {
    $words = preg_split('/\s+/', preg_replace('/[^A-Za-z0-9 ]/', '', $name));
    $out = '';
    foreach ($words as $w) { if ($w !== '') $out .= strtoupper($w[0]); if (strlen($out) >= 2) break; }
    return $out ?: '?';
}

/** Shared branded HTML email shell. $rows = HTML paragraphs. */
function hc_dir_email_html(string $eyebrow, string $title, string $rowsHtml, string $btnText = '', string $btnUrl = '', string $note = ''): string {
    $btn = $btnText ? '<p style="margin:26px 0 6px"><a href="' . htmlspecialchars($btnUrl) . '" style="display:inline-block;background:#1d9e75;color:#fff;text-decoration:none;font-weight:700;font-size:15px;padding:14px 28px;border-radius:8px">' . htmlspecialchars($btnText) . '</a></p>' : '';
    return '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#f4f6f4;font-family:Arial,sans-serif">'
        . '<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f4;padding:32px 16px"><tr><td align="center">'
        . '<table width="540" cellpadding="0" cellspacing="0" style="max-width:540px;width:100%;background:#fff;border-radius:12px;overflow:hidden">'
        . '<tr><td style="background:#0a2e1e;padding:28px 36px">'
        . '<div style="font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#2ec68f;margin-bottom:8px">' . htmlspecialchars($eyebrow) . '</div>'
        . '<div style="font-size:21px;color:#ffffff;font-weight:700">' . htmlspecialchars($title) . '</div>'
        . '</td></tr>'
        . '<tr><td style="padding:28px 36px;font-size:15px;color:#1a1a14;line-height:1.7">' . $rowsHtml . $btn
        . ($note ? '<p style="font-size:12.5px;color:#6b7280;margin-top:18px">' . htmlspecialchars($note) . '</p>' : '') . '</td></tr>'
        . '<tr><td style="background:#f8faf8;padding:18px 36px;text-align:center;font-size:12px;color:#9ca3af">Homecare Creators Agency Directory &middot; homecarecreators.com/directory/</td></tr>'
        . '</table></td></tr></table></body></html>';
}

/** Generate a fresh token and send the owner-confirmation email. Returns true if mail handed off. */
function hc_dir_send_owner_confirmation(int $id): bool {
    $l = hc_one("SELECT * FROM hc_directory_listings WHERE id=?", [$id]);
    if (!$l || empty($l['owner_email'])) return false;
    $token = bin2hex(random_bytes(24));
    hc_q("UPDATE hc_directory_listings SET confirm_token=?, confirm_sent_at=NOW() WHERE id=?", [$token, $id]);

    $site  = defined('SITE_URL') ? rtrim(SITE_URL, '/') : 'https://homecarecreators.com';
    $url   = $site . '/directory-confirm.php?token=' . $token;
    $plans = hc_dir_plans();
    $plan  = $plans[$l['requested_plan'] ?: $l['plan']] ?? $plans['free'];
    $first = trim(explode(' ', (string)$l['owner_name'])[0]) ?: 'there';
    $isClaim = ($l['claim_status'] ?? '') === 'pending';

    $what = $isClaim ? 'claim the listing for' : 'list';
    $body  = "Hi {$first},\n\nYou asked to {$what} {$l['company_name']} in the Homecare Creators Agency Directory ({$plan['name']} plan).\n\n";
    $body .= "Please confirm you are the owner or an authorized representative of this agency:\n{$url}\n\n";
    $body .= "This link expires in 14 days. If you didn't request this, ignore this email.\n\n— Homecare Creators\n";

    $html = hc_dir_email_html(
        'Confirm ownership',
        $l['company_name'],
        '<p>Hi ' . htmlspecialchars($first) . ',</p>'
        . '<p>You asked to ' . $what . ' <strong>' . htmlspecialchars($l['company_name']) . '</strong> in the Homecare Creators Agency Directory on the <strong>' . htmlspecialchars($plan['name']) . '</strong> plan.</p>'
        . '<p>Please confirm you are the owner or an authorized representative of this agency. We can\'t publish or upgrade the listing until you do.</p>',
        'Confirm I represent this agency',
        $url,
        "Link expires in 14 days. Didn't request this? You can ignore this email."
    );

    if (!class_exists('HcMailer')) require_once __DIR__ . '/mailer.php';
    return (bool)HcMailer::send($l['owner_email'], "Confirm your agency listing — {$l['company_name']}", $body, 'info@homecarecreators.com', '', $html);
}

/** Email sent when admin approves a listing. */
function hc_dir_send_approved(int $id): bool {
    $l = hc_one("SELECT * FROM hc_directory_listings WHERE id=?", [$id]);
    if (!$l) return false;
    $to = $l['owner_email'] ?: $l['email'];
    if (!$to) return false;
    $site = defined('SITE_URL') ? rtrim(SITE_URL, '/') : 'https://homecarecreators.com';
    $url  = $site . '/directory/' . $l['slug'];
    $tier = hc_dir_tier($l);
    $upsell = $tier === 'free'
        ? '<p>Want more inquiries? Premium and Featured listings add photos, your website link, a Verified badge and top placement. Just reply to this email to upgrade.</p>'
        : '';
    $body = "Good news — {$l['company_name']} is now live in the Homecare Creators Agency Directory:\n{$url}\n\n— Homecare Creators\n";
    $html = hc_dir_email_html('Listing approved', $l['company_name'],
        '<p>Good news — your agency is now live in our directory.</p>' . $upsell,
        'View your listing', $url);
    if (!class_exists('HcMailer')) require_once __DIR__ . '/mailer.php';
    return (bool)HcMailer::send($to, "Your listing is live — {$l['company_name']}", $body, 'info@homecarecreators.com', '', $html);
}


/* ── Hours ─────────────────────────────────────────────────── */

/** Parsed hours: ['always' => true] or ['mon' => ['08:00','18:00'] | null, ...]. Null when not set. */
function hc_dir_hours(array $l): ?array {
    $h = json_decode((string)($l['hours_json'] ?? ''), true);
    if (!is_array($h) || !$h) return null;
    if (!empty($h['always'])) return ['always' => true];
    $out = []; $any = false;
    foreach (HC_DIR_DAYS as $k => $_) {
        $v = $h[$k] ?? null;
        if (is_array($v) && count($v) === 2 && preg_match('/^\d{2}:\d{2}$/', $v[0]) && preg_match('/^\d{2}:\d{2}$/', $v[1])) { $out[$k] = $v; $any = true; }
        else $out[$k] = null;
    }
    return $any ? $out : null;
}

/** Build hours JSON from form input: $always bool, $rows [day => ['open'=>..,'close'=>..,'closed'=>bool]]. */
function hc_dir_hours_from_input(bool $always, array $rows): ?string {
    if ($always) return json_encode(['always' => true]);
    $out = []; $any = false;
    foreach (HC_DIR_DAYS as $k => $_) {
        $r = $rows[$k] ?? [];
        $o = $r['open'] ?? ''; $c = $r['close'] ?? '';
        if (empty($r['closed']) && preg_match('/^\d{2}:\d{2}$/', $o) && preg_match('/^\d{2}:\d{2}$/', $c)) { $out[$k] = [$o, $c]; $any = true; }
        else $out[$k] = null;
    }
    return $any ? json_encode($out) : null;
}

function hc_dir_fmt_time(string $t): string {
    [$h, $m] = array_map('intval', explode(':', $t));
    if ($h >= 24) return '12:00 AM';
    $ap = $h >= 12 && $h < 24 ? 'PM' : 'AM';
    $h12 = $h % 12 ?: 12;
    return $h12 . ':' . str_pad((string)$m, 2, '0', STR_PAD_LEFT) . ' ' . $ap;
}

function hc_dir_tz(string $state): string {
    static $map = [
        'CA'=>'America/Los_Angeles','WA'=>'America/Los_Angeles','OR'=>'America/Los_Angeles','NV'=>'America/Los_Angeles',
        'AZ'=>'America/Phoenix','CO'=>'America/Denver','UT'=>'America/Denver','NM'=>'America/Denver','MT'=>'America/Denver','WY'=>'America/Denver','ID'=>'America/Denver',
        'TX'=>'America/Chicago','IL'=>'America/Chicago','MN'=>'America/Chicago','WI'=>'America/Chicago','IA'=>'America/Chicago','MO'=>'America/Chicago','AR'=>'America/Chicago',
        'LA'=>'America/Chicago','MS'=>'America/Chicago','AL'=>'America/Chicago','OK'=>'America/Chicago','KS'=>'America/Chicago','NE'=>'America/Chicago','SD'=>'America/Chicago','ND'=>'America/Chicago','TN'=>'America/Chicago',
        'AK'=>'America/Anchorage','HI'=>'Pacific/Honolulu',
    ];
    return $map[strtoupper($state)] ?? 'America/New_York';
}

/** ['open'=>bool, 'label'=>string, 'today'=>dayKey] or null when hours unknown. */
function hc_dir_open_status(array $l): ?array {
    $h = hc_dir_hours($l);
    if (!$h) return null;
    $now = new DateTime('now', new DateTimeZone(hc_dir_tz($l['state'] ?? 'FL')));
    $today = strtolower($now->format('D'));
    if (!empty($h['always'])) return ['open' => true, 'label' => 'Open 24 hours', 'today' => $today];
    $cur = $now->format('H:i');
    $t = $h[$today] ?? null;
    if ($t && $cur >= $t[0] && $cur < $t[1]) return ['open' => true, 'label' => 'Open until ' . hc_dir_fmt_time($t[1]), 'today' => $today];
    if ($t && $cur < $t[0]) return ['open' => false, 'label' => 'Opens at ' . hc_dir_fmt_time($t[0]), 'today' => $today];
    $keys = array_keys(HC_DIR_DAYS);
    $i = array_search($today, $keys, true);
    for ($n = 1; $n <= 7; $n++) {
        $k = $keys[($i + $n) % 7];
        if (!empty($h[$k])) return ['open' => false, 'label' => 'Opens ' . ($n === 1 ? 'tomorrow' : HC_DIR_DAYS[$k]) . ' ' . hc_dir_fmt_time($h[$k][0]), 'today' => $today];
    }
    return ['open' => false, 'label' => 'Closed', 'today' => $today];
}

/** Today's hours as text, e.g. "8:00 AM – 6:00 PM". */
function hc_dir_today_hours(array $l): string {
    $h = hc_dir_hours($l);
    if (!$h) return '';
    if (!empty($h['always'])) return 'Open 24 hours';
    $now = new DateTime('now', new DateTimeZone(hc_dir_tz($l['state'] ?? 'FL')));
    $t = $h[strtolower($now->format('D'))] ?? null;
    return $t ? hc_dir_fmt_time($t[0]) . ' – ' . hc_dir_fmt_time($t[1]) : 'Closed today';
}

/* ── Reviews ───────────────────────────────────────────────── */

function hc_dir_recalc_rating(int $listingId): void {
    $r = hc_one("SELECT COUNT(*) n, AVG(rating) a FROM hc_directory_reviews WHERE listing_id=? AND status='approved'", [$listingId]);
    $n = (int)($r['n'] ?? 0);
    hc_q("UPDATE hc_directory_listings SET rating_count=?, rating_avg=? WHERE id=?", [$n, $n ? round((float)$r['a'], 1) : null, $listingId]);
}

/* ── Geocoding (OpenStreetMap Nominatim; max 1 request/second) ── */

function hc_dir_geocode(int $id): bool {
    $l = hc_one("SELECT id,address,city,state FROM hc_directory_listings WHERE id=?", [$id]);
    if (!$l) return false;
    $queries = [];
    if (!empty($l['address'])) $queries[] = $l['address'] . ', ' . $l['city'] . ', ' . $l['state'] . ', USA';
    $queries[] = $l['city'] . ', ' . $l['state'] . ', USA';
    $ctx = stream_context_create(['http' => ['timeout' => 6, 'header' => "User-Agent: HomecareCreatorsDirectory/1.0 (+https://homecarecreators.com/directory/)\r\nAccept-Language: en\r\n"]]);
    foreach ($queries as $i => $q) {
        if ($i > 0) usleep(1100000);
        $raw = @file_get_contents('https://nominatim.openstreetmap.org/search?format=json&limit=1&countrycodes=us&q=' . urlencode($q), false, $ctx);
        $j = $raw ? json_decode($raw, true) : null;
        if (!empty($j[0]['lat'])) {
            hc_q("UPDATE hc_directory_listings SET lat=?, lng=?, geocoded_at=NOW() WHERE id=?", [(float)$j[0]['lat'], (float)$j[0]['lon'], $id]);
            return true;
        }
    }
    hc_q("UPDATE hc_directory_listings SET geocoded_at=NOW() WHERE id=?", [$id]);
    return false;
}


/* ── Logos ─────────────────────────────────────────────────── */

/** Fetch a URL with a browser-like UA. Returns [body, finalUrl, contentType] or null. */
function hc_dir_http_get(string $url, int $maxBytes = 3000000): ?array {
    if (!preg_match('#^https?://#i', $url)) return null;
    $host = parse_url($url, PHP_URL_HOST);
    if (!$host) return null;
    // Don't let a listing point the server at internal addresses.
    $ip = gethostbyname($host);
    if (!filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE)) return null;
    $ctx = stream_context_create(['http' => [
        'timeout' => 10, 'follow_location' => 1, 'max_redirects' => 5, 'ignore_errors' => true,
        'header' => "User-Agent: Mozilla/5.0 (compatible; HomecareCreatorsDirectory/1.0; +https://homecarecreators.com/directory/)\r\nAccept: text/html,image/*,*/*;q=0.8\r\n",
    ], 'ssl' => ['verify_peer' => true, 'verify_peer_name' => true]]);
    $body = @file_get_contents($url, false, $ctx, 0, $maxBytes);
    if ($body === false || $body === '') return null;
    $status = 0; $type = ''; $final = $url;
    foreach ($http_response_header ?? [] as $h) {
        if (preg_match('#^HTTP/\S+\s+(\d+)#', $h, $m)) $status = (int)$m[1];
        elseif (stripos($h, 'Content-Type:') === 0) $type = strtolower(trim(substr($h, 13)));
        elseif (stripos($h, 'Location:') === 0) $final = hc_dir_abs_url(trim(substr($h, 9)), $final);
    }
    return $status >= 200 && $status < 300 ? [$body, $final, $type] : null;
}

function hc_dir_abs_url(string $u, string $base): string {
    $u = html_entity_decode(trim($u), ENT_QUOTES);
    if ($u === '' || str_starts_with($u, 'data:')) return '';
    if (preg_match('#^https?://#i', $u)) return $u;
    $b = parse_url($base);
    $root = ($b['scheme'] ?? 'https') . '://' . ($b['host'] ?? '');
    if (str_starts_with($u, '//')) return ($b['scheme'] ?? 'https') . ':' . $u;
    if (str_starts_with($u, '/')) return $root . $u;
    $dir = preg_replace('#/[^/]*$#', '/', $b['path'] ?? '/');
    return $root . $dir . $u;
}

/** Candidate logo URLs from a homepage, best first. */
function hc_dir_logo_candidates(string $html, string $base): array {
    $c = [];
    // 1. JSON-LD "logo"
    if (preg_match_all('#<script[^>]+application/ld\+json[^>]*>(.*?)</script>#is', $html, $mm)) {
        foreach ($mm[1] as $js) {
            if (preg_match('#"logo"\s*:\s*(?:\{[^}]*?"url"\s*:\s*)?"([^"]+)"#i', $js, $m)) $c[] = stripslashes($m[1]);
        }
    }
    // 2. <img> that looks like the logo (class/id/alt/src mention "logo"), header first
    $head = preg_match('#<header\b.*?</header>#is', $html, $hm) ? $hm[0] : '';
    foreach ([$head, $html] as $chunk) {
        if (!$chunk) continue;
        if (preg_match_all('#<img\b[^>]*>#i', $chunk, $imgs)) {
            foreach ($imgs[0] as $tag) {
                if (!preg_match('#logo#i', $tag)) continue;
                if (preg_match('#\s(?:data-src|data-lazy-src|src)\s*=\s*["\']([^"\']+)#i', $tag, $m) && !str_starts_with($m[1], 'data:')) $c[] = $m[1];
                elseif (preg_match('#\ssrcset\s*=\s*["\']([^"\'\s,]+)#i', $tag, $m)) $c[] = $m[1];
            }
        }
    }
    // 3. Apple touch icon, then large favicons
    if (preg_match_all('#<link\b[^>]*>#i', $html, $links)) {
        $icons = [];
        foreach ($links[0] as $tag) {
            if (!preg_match('#rel\s*=\s*["\']([^"\']+)#i', $tag, $r) || !preg_match('#href\s*=\s*["\']([^"\']+)#i', $tag, $h)) continue;
            $rel = strtolower($r[1]);
            $size = preg_match('#sizes\s*=\s*["\'](\d+)#i', $tag, $sz) ? (int)$sz[1] : 0;
            if (str_contains($rel, 'apple-touch-icon')) $icons[] = [1000 + $size, $h[1]];
            elseif (str_contains($rel, 'icon') && $size >= 96) $icons[] = [$size, $h[1]];
        }
        usort($icons, fn($a, $b) => $b[0] <=> $a[0]);
        foreach ($icons as $i) $c[] = $i[1];
    }
    $out = [];
    foreach ($c as $u) { $a = hc_dir_abs_url($u, $base); if ($a && !in_array($a, $out, true)) $out[] = $a; }
    return $out;
}

/** Download an image and store it locally. Returns the public path or null. */
function hc_dir_store_logo(string $imgUrl, string $slug): ?string {
    $r = hc_dir_http_get($imgUrl, 2000000);
    if (!$r) return null;
    [$bin, , $type] = $r;
    $ext = null;
    if (str_contains($type, 'svg') || preg_match('#^\s*(<\?xml[^>]*>\s*)?<svg\b#i', substr($bin, 0, 500))) {
        if (!preg_match('#<svg\b#i', $bin)) return null;
        $bin = preg_replace('#<script\b.*?</script>#is', '', $bin);
        $bin = preg_replace('#\son\w+\s*=\s*("[^"]*"|\'[^\']*\')#i', '', $bin);
        $ext = 'svg';
    } else {
        $info = @getimagesizefromstring($bin);
        if (!$info || $info[0] < 48 || $info[1] < 24) return null;
        $ext = [IMAGETYPE_PNG => 'png', IMAGETYPE_JPEG => 'jpg', IMAGETYPE_GIF => 'gif', IMAGETYPE_WEBP => 'webp', IMAGETYPE_ICO => 'ico'][$info[2]] ?? null;
        if (!$ext || $ext === 'ico') return null;
    }
    $root = defined('SITE_ROOT') ? SITE_ROOT : dirname(__DIR__, 2);
    $dir = $root . '/images/blog/directory-logos';
    if (!is_dir($dir) && !@mkdir($dir, 0755, true) && !is_dir($dir)) return null;
    $file = preg_replace('/[^a-z0-9-]/', '', $slug) . '-' . substr(md5($bin), 0, 8) . '.' . $ext;
    if (@file_put_contents($dir . '/' . $file, $bin) === false) return null;
    return '/images/blog/directory-logos/' . $file;
}

/** Find the logo on a listing's website and save it as the listing's logo. Returns the path or null. */
function hc_dir_fetch_logo(int $id): ?string {
    $l = hc_one("SELECT id, slug, website FROM hc_directory_listings WHERE id=?", [$id]);
    if (!$l || empty($l['website'])) return null;
    $page = hc_dir_http_get($l['website']);
    if (!$page) return null;
    foreach (array_slice(hc_dir_logo_candidates($page[0], $page[1]), 0, 6) as $cand) {
        if ($path = hc_dir_store_logo($cand, $l['slug'])) {
            hc_q("UPDATE hc_directory_listings SET logo=? WHERE id=?", [$path, $id]);
            return $path;
        }
    }
    return null;
}


/* ── Owner accounts ────────────────────────────────────────── */

/** Fields an agency owner may change (all changes go to admin for approval). */
const HC_DIR_OWNER_FIELDS = [
    'tagline' => 'Tagline', 'description' => 'Description', 'services' => 'Services', 'payment_accepted' => 'Payment accepted',
    'features' => 'Highlights', 'hours_json' => 'Office hours', 'hours' => 'Hours note', 'phone' => 'Phone', 'email' => 'Email',
    'website' => 'Website', 'address' => 'Address', 'service_areas' => 'Service areas', 'languages' => 'Languages',
    'license_number' => 'License number', 'years_in_business' => 'Years in business', 'logo' => 'Logo URL',
    'cover_image' => 'Cover photo URL', 'photos' => 'Gallery photo URLs',
];

function hc_dir_session(): void {
    if (session_status() === PHP_SESSION_NONE) {
        session_set_cookie_params(['lifetime' => 0, 'path' => '/', 'secure' => !empty($_SERVER['HTTPS']), 'httponly' => true, 'samesite' => 'Lax']);
        session_start();
    }
}

function hc_dir_owner(): ?array {
    hc_dir_session();
    $id = (int)($_SESSION['hc_owner_id'] ?? 0);
    return $id ? hc_one("SELECT * FROM hc_directory_owners WHERE id=? AND verified_at IS NOT NULL", [$id]) : null;
}

function hc_dir_csrf(): string {
    hc_dir_session();
    if (empty($_SESSION['hc_owner_csrf'])) $_SESSION['hc_owner_csrf'] = bin2hex(random_bytes(16));
    return $_SESSION['hc_owner_csrf'];
}
function hc_dir_csrf_ok(): bool {
    hc_dir_session();
    return !empty($_POST['csrf']) && hash_equals($_SESSION['hc_owner_csrf'] ?? '', (string)$_POST['csrf']);
}

/** Link every confirmed listing whose owner email matches this (verified) account. */
function hc_dir_owner_link(int $ownerId, string $email): void {
    hc_q("UPDATE hc_directory_listings SET owner_account_id=? WHERE LOWER(owner_email)=LOWER(?) AND owner_confirmed_at IS NOT NULL AND (owner_account_id IS NULL OR owner_account_id=?)", [$ownerId, $email, $ownerId]);
}

function hc_dir_owner_login(array $o): void {
    hc_dir_session();
    session_regenerate_id(true);
    $_SESSION['hc_owner_id'] = (int)$o['id'];
    hc_q("UPDATE hc_directory_owners SET last_login_at=NOW() WHERE id=?", [$o['id']]);
    hc_dir_owner_link((int)$o['id'], $o['email']);
}

/** Email a link to set (or reset) a password. Creates the account record if needed. */
function hc_dir_send_password_link(string $email, string $name = ''): bool {
    $o = hc_one("SELECT * FROM hc_directory_owners WHERE LOWER(email)=LOWER(?)", [$email]);
    if (!$o) {
        hc_q("INSERT INTO hc_directory_owners (email, name) VALUES (?, ?)", [strtolower($email), $name ?: null]);
        $o = hc_one("SELECT * FROM hc_directory_owners WHERE id=?", [(int)hc_db()->lastInsertId()]);
    }
    $token = bin2hex(random_bytes(24));
    hc_q("UPDATE hc_directory_owners SET reset_token=?, reset_sent_at=NOW() WHERE id=?", [$token, $o['id']]);
    $url = (defined('SITE_URL') ? rtrim(SITE_URL, '/') : 'https://homecarecreators.com') . '/directory/account/?p=reset&token=' . $token;
    $body = "Use this link to set your password and manage your agency listing:\n{$url}\n\nThe link expires in 24 hours. If you didn't ask for this, you can ignore this email.\n\n— Homecare Creators\n";
    $html = hc_dir_email_html('Your agency account', 'Set your password', '<p>Use the button below to set your password and manage your agency listing on the Homecare Creators directory.</p>', 'Set my password', $url, 'This link expires in 24 hours. Didn\'t ask for this? You can ignore this email.');
    if (!class_exists('HcMailer')) require_once __DIR__ . '/mailer.php';
    return (bool)HcMailer::send($o['email'], 'Set your password — Homecare Creators Directory', $body, 'info@homecarecreators.com', '', $html);
}

/** Apply an approved edit request to its listing. */
function hc_dir_apply_edit(int $editId): bool {
    $e = hc_one("SELECT * FROM hc_directory_edits WHERE id=? AND status='pending'", [$editId]);
    if (!$e) return false;
    $data = array_intersect_key(json_decode($e['data'], true) ?: [], HC_DIR_OWNER_FIELDS);
    if ($data) {
        $set = implode(',', array_map(fn($k) => "`$k`=?", array_keys($data)));
        hc_q("UPDATE hc_directory_listings SET $set WHERE id=?", [...array_values($data), $e['listing_id']]);
        if (isset($data['address'])) { try { hc_dir_geocode((int)$e['listing_id']); } catch (Throwable $t) {} }
    }
    hc_q("UPDATE hc_directory_edits SET status='approved', reviewed_at=NOW() WHERE id=?", [$editId]);
    return true;
}

function hc_dir_notify_owner(int $ownerId, string $subject, string $title, string $htmlRows, string $text): void {
    $o = hc_one("SELECT email FROM hc_directory_owners WHERE id=?", [$ownerId]);
    if (!$o) return;
    $url = (defined('SITE_URL') ? rtrim(SITE_URL, '/') : 'https://homecarecreators.com') . '/directory/account/';
    if (!class_exists('HcMailer')) require_once __DIR__ . '/mailer.php';
    HcMailer::send($o['email'], $subject, $text . "\n\nManage your listing: {$url}\n", 'info@homecarecreators.com', '', hc_dir_email_html('Your agency account', $title, $htmlRows, 'Open my dashboard', $url));
}


/* ── Verification uploads (private: stored outside the web root when possible) ── */

const HC_DIR_VERIFY_TYPES = [
    'image/jpeg' => 'jpg', 'image/png' => 'png', 'image/webp' => 'webp', 'image/heic' => 'heic',
    'video/mp4' => 'mp4', 'video/quicktime' => 'mov', 'video/webm' => 'webm',
];

function hc_dir_private_dir(): ?string {
    $root = defined('SITE_ROOT') ? SITE_ROOT : dirname(__DIR__, 2);
    foreach ([dirname($root) . '/hc-private/directory-verifications', $root . '/admin/private-uploads/directory-verifications'] as $d) {
        if ((is_dir($d) || @mkdir($d, 0750, true)) && is_writable($d)) return $d;
    }
    return null;
}

/** Store an uploaded verification file. Returns [path, mime, name] or an error string. */
function hc_dir_store_verification(array $file) {
    if (($file['error'] ?? UPLOAD_ERR_NO_FILE) !== UPLOAD_ERR_OK) {
        return in_array($file['error'] ?? 0, [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true) ? 'That file is too large. Please keep it under ' . ini_get('upload_max_filesize') . '.' : 'Please choose a photo or video to upload.';
    }
    if ($file['size'] > 100 * 1024 * 1024) return 'Please keep the file under 100 MB.';
    $mime = function_exists('mime_content_type') ? (string)mime_content_type($file['tmp_name']) : (string)$file['type'];
    if (!isset(HC_DIR_VERIFY_TYPES[$mime])) return 'Please upload a JPG, PNG, WEBP or HEIC photo, or an MP4, MOV or WEBM video.';
    $dir = hc_dir_private_dir();
    if (!$dir) return 'Upload storage is not available right now. Please email the file to info@homecarecreators.com.';
    $name = bin2hex(random_bytes(24)) . '.' . HC_DIR_VERIFY_TYPES[$mime];
    if (!move_uploaded_file($file['tmp_name'], $dir . '/' . $name)) return 'The upload failed. Please try again.';
    return [$dir . '/' . $name, $mime, mb_substr(basename((string)$file['name']), 0, 200)];
}

