<?php
header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://homecarecreators.com');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') { http_response_code(200); exit; }
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['success' => false, 'message' => 'Method not allowed']);
    exit;
}

$raw  = file_get_contents('php://input');
$data = json_decode($raw, true) ?: $_POST;

// Honeypot
if (!empty(trim($data['hp_website'] ?? ''))) {
    echo json_encode(['success' => true]);
    exit;
}

$name    = strip_tags(trim($data['name']  ?? ''));
$email   = filter_var(trim($data['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone   = strip_tags(trim($data['phone'] ?? ''));
$city    = strip_tags(trim($data['city']  ?? ''));
$website = filter_var(trim($data['website'] ?? ''), FILTER_SANITIZE_URL);
$problem_key = strip_tags(trim($data['problem'] ?? ''));

$monthly_inquiries = (int)($data['monthly_inquiries'] ?? 0);
$close_rate = (float)($data['close_rate'] ?? 0);
$additional_inquiries_target = (int)($data['additional_inquiries_target'] ?? 0);
$monthly_value = (float)($data['monthly_value_per_client'] ?? 0);
$avg_length    = (float)($data['avg_length_months'] ?? 0);

if (empty($name) || empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL) || empty($phone) || empty($city) || empty($website) || empty($problem_key)) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Name, email, phone, city, website, and your biggest challenge are all required.']);
    exit;
}
if ($monthly_inquiries <= 0 || $close_rate <= 0 || $additional_inquiries_target < 0 || $monthly_value <= 0 || $avg_length <= 0) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'Please fill in valid numbers for every calculator field.']);
    exit;
}

$problems = [
    'seo'      => ['label' => 'Not showing up on Google',               'url' => '/seo/home-care-seo/'],
    'website'  => ['label' => "Website doesn't turn visitors into leads", 'url' => '/web-design/homecare-website-design/'],
    'ai'       => ['label' => 'Not showing up in AI search (ChatGPT, etc.)', 'url' => '/ai-search-seo/'],
    'strategy' => ['label' => 'Not sure / need an overall strategy',     'url' => '/contact/'],
];
$problem = $problems[$problem_key] ?? $problems['strategy'];

// ── Server-side calculation (never trust client-computed numbers) ──
// Inquiry/close-rate model: the agency's own close rate (inquiry-to-client)
// is held constant -- that's their intake process, not something a
// marketing agency controls. The lever is purely more inquiries.
$current_clients   = (int)round($monthly_inquiries * $close_rate / 100);
$potential_clients = (int)round(($monthly_inquiries + $additional_inquiries_target) * $close_rate / 100);
$additional_clients = max(0, $potential_clients - $current_clients);
$client_ltv           = round($monthly_value * $avg_length, 2);
$additional_annual_value = round($additional_clients * 12 * $client_ltv, 2);

try {
    require_once __DIR__ . '/admin/config.php';
    require_once __DIR__ . '/admin/includes/db.php';
    require_once __DIR__ . '/admin/includes/functions.php';
    require_once __DIR__ . '/admin/includes/mailer.php';
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Server error. Please try again.']);
    exit;
}

try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_calculator_submissions (
        id INT PRIMARY KEY AUTO_INCREMENT,
        name VARCHAR(255) NOT NULL,
        email VARCHAR(255) NOT NULL,
        phone VARCHAR(50) NOT NULL,
        city VARCHAR(100) NOT NULL,
        website VARCHAR(500) NOT NULL,
        problem VARCHAR(100) NOT NULL,
        monthly_inquiries INT NOT NULL,
        close_rate DECIMAL(5,2) NOT NULL,
        additional_inquiries_target INT NOT NULL,
        monthly_value_per_client DECIMAL(10,2) NOT NULL,
        avg_length_months DECIMAL(6,2) NOT NULL,
        current_inquiries INT NOT NULL,
        potential_inquiries INT NOT NULL,
        additional_inquiries INT NOT NULL,
        client_ltv DECIMAL(10,2) NOT NULL,
        additional_annual_value DECIMAL(12,2) NOT NULL,
        status VARCHAR(20) NOT NULL DEFAULT 'new',
        source_page VARCHAR(255),
        ip_address VARCHAR(64),
        user_agent TEXT,
        device_type VARCHAR(20),
        geo_city VARCHAR(100),
        geo_region VARCHAR(100),
        geo_country VARCHAR(100),
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        KEY idx_status (status)
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}
// Migrate older deployments through each prior schema generation (all best-effort/no-ops if not applicable)
try { hc_db()->exec("ALTER TABLE hc_calculator_submissions CHANGE COLUMN target_rate additional_inquiries_target INT NOT NULL"); } catch (Exception $e) {}
try { hc_db()->exec("ALTER TABLE hc_calculator_submissions CHANGE COLUMN traffic_increase_pct additional_inquiries_target INT NOT NULL"); } catch (Exception $e) {}
try { hc_db()->exec("ALTER TABLE hc_calculator_submissions CHANGE COLUMN monthly_visitors monthly_inquiries INT NOT NULL"); } catch (Exception $e) {}
try { hc_db()->exec("ALTER TABLE hc_calculator_submissions CHANGE COLUMN current_rate close_rate DECIMAL(5,2) NOT NULL"); } catch (Exception $e) {}
try { hc_db()->exec("ALTER TABLE hc_calculator_submissions ADD COLUMN website VARCHAR(500) NOT NULL DEFAULT ''"); } catch (Exception $e) {}

// ── Visitor context ──────────────────────────────────────────
$ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '')[0]) ?: ($_SERVER['REMOTE_ADDR'] ?? '');
$user_agent = strip_tags(trim($_SERVER['HTTP_USER_AGENT'] ?? ''));
$device_type = 'Desktop';
if (preg_match('/tablet|ipad/i', $user_agent)) { $device_type = 'Tablet'; }
elseif (preg_match('/mobile|android|iphone/i', $user_agent)) { $device_type = 'Mobile'; }

$geo_city = ''; $geo_region = ''; $geo_country = '';
$is_private_ip = !filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_NO_PRIV_RANGE | FILTER_FLAG_NO_RES_RANGE);
if ($ip && !$is_private_ip) {
    try {
        $ctx = stream_context_create(['http' => ['timeout' => 3]]);
        $geo_raw = @file_get_contents("http://ip-api.com/json/{$ip}?fields=status,country,regionName,city", false, $ctx);
        if ($geo_raw) {
            $geo = json_decode($geo_raw, true);
            if (($geo['status'] ?? '') === 'success') {
                $geo_city = $geo['city'] ?? ''; $geo_region = $geo['regionName'] ?? ''; $geo_country = $geo['country'] ?? '';
            }
        }
    } catch (Exception $e) {}
}

$source = strip_tags(trim($data['source'] ?? '/growth-calculator/'));

try {
    hc_q("INSERT INTO hc_calculator_submissions (name,email,phone,city,website,problem,monthly_inquiries,close_rate,additional_inquiries_target,monthly_value_per_client,avg_length_months,current_inquiries,potential_inquiries,additional_inquiries,client_ltv,additional_annual_value,source_page,ip_address,user_agent,device_type,geo_city,geo_region,geo_country) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
        [$name,$email,$phone,$city,$website,$problem['label'],$monthly_inquiries,$close_rate,$additional_inquiries_target,$monthly_value,$avg_length,$current_clients,$potential_clients,$additional_clients,$client_ltv,$additional_annual_value,$source,$ip,$user_agent,$device_type,$geo_city,$geo_region,$geo_country]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Could not save your results. Please try again.']);
    exit;
}

// ── Email the lead their results ──────────────────────────────
$subject_lead = "Your Website Growth Report — Homecare Creators";
$cta_url = 'https://homecarecreators.com' . $problem['url'];
$html_lead = '<!DOCTYPE html><html><head><meta charset="UTF-8"></head><body style="margin:0;padding:0;background:#f4f6f4;font-family:Arial,sans-serif">'
    . '<table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f6f4;padding:32px 16px"><tr><td align="center">'
    . '<table width="520" cellpadding="0" cellspacing="0" style="max-width:520px;width:100%;background:#fff;border-radius:16px;overflow:hidden">'
    . '<tr><td style="background:#0a2e1e;padding:32px 36px;text-align:center">'
    . '<div style="font-family:Arial,sans-serif;font-size:11px;font-weight:700;letter-spacing:2px;text-transform:uppercase;color:#2ec68f;margin-bottom:10px">Your Growth Report</div>'
    . '<div style="font-family:Georgia,serif;font-size:22px;color:#ffffff">Hi ' . htmlspecialchars($name) . '</div>'
    . '</td></tr>'
    . '<tr><td style="padding:28px 36px">'
    . '<p style="font-size:15px;color:#1a1a14;line-height:1.7">Based on what you entered, here\'s your estimated opportunity:</p>'
    . '<div style="background:#f8faf8;border-left:3px solid #1d9e75;border-radius:0 8px 8px 0;padding:16px 20px;margin:16px 0">'
    . '<div style="font-size:13px;color:#6b7b6e;margin-bottom:4px">Additional clients per month</div>'
    . '<div style="font-size:20px;font-weight:700;color:#0a2e1e;margin-bottom:12px">+' . $additional_clients . '</div>'
    . '<div style="font-size:13px;color:#6b7b6e;margin-bottom:4px">Additional annual opportunity</div>'
    . '<div style="font-size:24px;font-weight:700;color:#1d9e75">$' . number_format($additional_annual_value) . '</div>'
    . '</div>'
    . '<p style="font-size:14px;color:#6b7b6e;line-height:1.7">These are estimates based on the numbers you provided, not a guarantee. The biggest lever for agencies like yours is usually: <strong>' . htmlspecialchars($problem['label']) . '</strong>.</p>'
    . '<div style="text-align:center;margin-top:24px"><a href="' . htmlspecialchars($cta_url) . '" style="display:inline-block;background:#1d9e75;color:#fff;text-decoration:none;padding:14px 28px;border-radius:50px;font-weight:700;font-size:14px">Claim My Discounted Audit &rarr;</a></div>'
    . '</td></tr>'
    . '<tr><td style="background:#f8faf8;padding:18px 36px;text-align:center;font-size:12px;color:#9ca3af">Homecare Creators &middot; homecarecreators.com</td></tr>'
    . '</table></td></tr></table></body></html>';

$notification_email = hc_setting('notification_email', 'info@homecarecreators.com');
HcMailer::send($email, $subject_lead, "Hi {$name},\n\nYour estimated additional clients per month: +{$additional_clients}\nYour estimated additional annual opportunity: $" . number_format($additional_annual_value) . "\n\nSee how we help: {$cta_url}\n\n— Homecare Creators", $notification_email, '', $html_lead);

// ── Notify admin ──────────────────────────────────────────────
$subject_admin = "🧮 New growth calculator lead: {$name} — {$city}";
$body_admin  = "New growth calculator submission:\n\n";
$body_admin .= "Name: {$name}\nEmail: {$email}\nPhone: {$phone}\nCity: {$city}\nWebsite: {$website}\n";
$body_admin .= "Biggest challenge: {$problem['label']}\n\n";
$body_admin .= "Monthly inquiries: {$monthly_inquiries}\nClose rate: {$close_rate}%\nAdditional inquiries target: +{$additional_inquiries_target}\n";
$body_admin .= "Client value/mo: \${$monthly_value}, avg length: {$avg_length} months (LTV: \${$client_ltv})\n\n";
$body_admin .= "Additional clients per month: +{$additional_clients}\nAdditional annual opportunity: \$" . number_format($additional_annual_value) . "\n\n";
$geo_str = trim(implode(', ', array_filter([$geo_city, $geo_region, $geo_country])));
if ($geo_str) $body_admin .= "Location: {$geo_str}\n";
$body_admin .= "Device: {$device_type}\n\nView all leads: https://homecarecreators.com/admin/calculator-leads.php\n";

HcMailer::send($notification_email, $subject_admin, $body_admin, $email);

echo json_encode([
    'success' => true,
    'results' => [
        'current_clients'   => $current_clients,
        'potential_clients' => $potential_clients,
        'additional_clients'=> $additional_clients,
        'client_ltv'          => $client_ltv,
        'additional_annual_value' => $additional_annual_value,
        'cta_url'             => $problem['url'],
        'cta_label'           => $problem['label'],
    ],
]);
