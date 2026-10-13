<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

// One-time seeder: adds researched agency names as PENDING directory
// listings for you to review, flesh out, and approve/reject one by one
// in /admin/directory/. Nothing here is auto-published. Safe to re-run —
// it skips any company_name+city pair already in the table. Delete this
// file once you're done running it.

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
} catch(Exception $e){}

// [name, city, state]
$agencies = [
    // Florida (general)
    ['Santa Fe Home Health Care', 'Miami', 'FL'],
    ['Serenity Home Health Care', 'Miami', 'FL'],
    ['United Home Care Services', 'Miami', 'FL'],
    ['Premier Homecare Services', 'Miami', 'FL'],
    ['Living Waters Healthcare Services', 'Miami', 'FL'],
    ['Cornerstone Caregiving', 'Miami', 'FL'],
    ['Haven Home Health Services', 'Miami', 'FL'],
    ['Brooks Rehabilitation Home Health', 'Jacksonville', 'FL'],
    ['Home First Home Health Care LLC', 'Jacksonville', 'FL'],
    ['Southeast Homecare', 'Jacksonville', 'FL'],

    // Tampa, FL
    ['Parx Home Care (West Florida)', 'Tampa', 'FL'],
    ['Granny Nannies Senior Home Care of Tampa', 'Tampa', 'FL'],
    ['A Piece of My Heart L.L.C.', 'Tampa', 'FL'],
    ['Mederi Caretenders', 'Tampa', 'FL'],
    ['Avian Home Health Corp', 'Tampa', 'FL'],
    ['Concierge Home Care', 'Tampa', 'FL'],
    ['Accomplished Home Care', 'Tampa', 'FL'],
    ['Bon Secours Home Care by Compassus', 'Tampa', 'FL'],
    ['Advanced Home Health of Tampa', 'Tampa', 'FL'],
    ['Griswold Care', 'Tampa', 'FL'],

    // Orlando, FL
    ['Family Home Care of Central Florida', 'Orlando', 'FL'],
    ['Always Best Care of Orlando', 'Orlando', 'FL'],
    ['Right at Home North Orlando', 'Orlando', 'FL'],
    ['Serenity Home Care & Services', 'Orlando', 'FL'],
    ['Ability Homecare', 'Orlando', 'FL'],
    ['Elite Caregivers United', 'Orlando', 'FL'],
    ['Family Home Care Group LLC', 'Orlando', 'FL'],
    ['Mederi Caretenders (Orlando)', 'Orlando', 'FL'],
    ['Acute Home Healthcare', 'Orlando', 'FL'],
    ['Accomplished Home Care (Orlando)', 'Orlando', 'FL'],

    // Texas (general)
    ['Always Best Care of West Houston', 'Houston', 'TX'],
    ['FirstLight Home Care', 'Houston', 'TX'],
    ['Griswold Home Care', 'Houston', 'TX'],
    ['Hands with Heart Home Healthcare', 'Houston', 'TX'],
    ['Home Helpers Home Care of Memorial', 'Houston', 'TX'],
    ['Lewis Legacy Homecare', 'Houston', 'TX'],
    ['T&T HomeCare Partners LLC', 'Dallas', 'TX'],
    ['Newport Home Health Agency', 'Grand Prairie', 'TX'],
    ['Reliant At Home', 'Fort Worth', 'TX'],
    ['Keystone Healthcare', 'Richardson', 'TX'],

    // Irving, TX
    ['ComForcare Home Care', 'Irving', 'TX'],
    ['BrightStar Care', 'Irving', 'TX'],
    ['Home Instead', 'Irving', 'TX'],
    ['Right At Home', 'Irving', 'TX'],
    ['Maxim Healthcare Services', 'Irving', 'TX'],
    ['Advanced Home Health Services', 'Irving', 'TX'],
    ['Alpine Care Home Health', 'Irving', 'TX'],

    // California
    ['S N E Home Health Care Services', 'Whittier', 'CA'],
    ['Safe Guard Home Health', 'Van Nuys', 'CA'],
    ['Care4u Caregiving Inc.', 'La Mirada', 'CA'],
    ['Interim Healthcare San Diego Home Health', 'San Diego', 'CA'],
    ['Kevory Enterprises dba Senior Helpers', 'San Diego', 'CA'],
    ['BrightStar Care of N. Central San Diego', 'San Diego', 'CA'],
    ['1Heart Caregiver Services', 'San Diego', 'CA'],
    ['Heritage Senior Care, Inc.', 'Carlsbad', 'CA'],
    ['Associate Home Care (AHC)', 'San Diego', 'CA'],
    ['Advantage Health Systems', 'San Diego', 'CA'],

    // New York
    ['Life Care Services, Inc.', 'Brooklyn', 'NY'],
    ['Ultimate Care, Inc.', 'Brooklyn', 'NY'],
    ['City Choice Home Care Services', 'Brooklyn', 'NY'],
    ['Centers Choice Home Care', 'Brooklyn', 'NY'],
    ['Immediate Home Care, Inc.', 'Brooklyn', 'NY'],
    ['Parent Care Home Care, LLC', 'Brooklyn', 'NY'],
    ['Adl Senior Choice, Inc.', 'Woodside', 'NY'],
    ['Best Choice Home Health Care, Inc.', 'Flushing', 'NY'],
    ['Rebekah Rehab Licensed Home Care Services Agency, Inc.', 'Bronx', 'NY'],
    ['Atara Home Care', 'Bronx', 'NY'],
];

$inserted = [];
$skipped  = [];

foreach ($agencies as [$name, $city, $state]) {
    $existing = hc_val("SELECT id FROM hc_directory_listings WHERE company_name=? AND city=?", [$name, $city]);
    if ($existing) { $skipped[] = "{$name} ({$city}, {$state})"; continue; }

    $slug = hc_slug($name . '-' . $city);
    $base = $slug; $n = 1;
    while (hc_val("SELECT id FROM hc_directory_listings WHERE slug=?", [$slug])) $slug = $base . '-' . $n++;

    $description = "{$name} is a home care agency serving {$city}, {$state}. This listing was added from directory research and has not been independently verified yet — confirm licensing and add full details (services, service areas, contact info) before approving it.";

    hc_q("INSERT INTO hc_directory_listings (company_name,slug,description,city,state,status) VALUES (?,?,?,?,?,'pending')",
        [$name, $slug, $description, $city, $state]);
    $inserted[] = "{$name} ({$city}, {$state})";
}

hc_head('Seed Directory Listings');
hc_topbar('Seed Directory Listings', '<a href="/admin/">Admin</a> › Seed Directory Listings');
?>
<div class="page-content">
  <div class="card">
    <div class="card-title" style="margin-bottom:10px">Seed Results</div>
    <p style="margin-bottom:16px"><strong><?= count($inserted) ?></strong> inserted as <strong>pending</strong>, <strong><?= count($skipped) ?></strong> skipped (already existed).</p>
    <p style="margin-bottom:16px">Every row landed in <a href="/admin/directory/?status=pending">/admin/directory/ → Pending Review</a> with a placeholder description flagged as unverified. Nothing is public until you individually edit and approve each one.</p>
    <?php if ($inserted): ?>
    <div class="card-title" style="margin-bottom:8px;font-size:13px">Inserted</div>
    <ul style="margin:0 0 16px 18px;font-size:13px;color:var(--muted)">
      <?php foreach ($inserted as $i): ?><li><?= h($i) ?></li><?php endforeach ?>
    </ul>
    <?php endif ?>
    <?php if ($skipped): ?>
    <div class="card-title" style="margin-bottom:8px;font-size:13px">Skipped (duplicates)</div>
    <ul style="margin:0 0 16px 18px;font-size:13px;color:var(--muted)">
      <?php foreach ($skipped as $s): ?><li><?= h($s) ?></li><?php endforeach ?>
    </ul>
    <?php endif ?>
    <p style="color:var(--red);font-weight:600">Delete this file (admin/seed-directory-listings.php) now that it's run.</p>
  </div>
</div>
<?php hc_foot(); ?>
