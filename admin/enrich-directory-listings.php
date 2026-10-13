<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

// One-time enrichment pass for the listings added by seed-directory-listings.php.
// Only fills in fields I could verify from a real source (a directory page's
// visible, unmasked address, or the NY State DOH registry). Phone, email, and
// website are intentionally left untouched here — they were not available
// from any source without bypassing a lead-gen paywall, and this script will
// never fabricate contact details for a real business. Safe to re-run.
// Delete this file once you're done running it.

// [company_name, city, address, years_in_business]
$updates = [
    ['Home First Home Health Care LLC', 'Jacksonville', '101 Century 21 Dr Ste 210A, Jacksonville, FL', null],

    ['Mederi Caretenders', 'Tampa', '1413 Tech Blvd, Tampa, FL', null],
    ['Avian Home Health Corp', 'Tampa', '2502 W Diana St, Tampa, FL', null],
    ['Concierge Home Care', 'Tampa', '5810 W Cypress St, Tampa, FL', null],
    ['Accomplished Home Care', 'Tampa', '10508 N Dale Mabry Hwy, Tampa, FL', null],
    ['Griswold Care', 'Tampa', '4917 Ehrlich Road, #102, Tampa, FL', null],

    ['Always Best Care of Orlando', 'Orlando', '501 N. Magnolia Ave., Ste. A03, Orlando, FL', null],
    ['Right at Home North Orlando', 'Orlando', '711 W Colonial Drive, Orlando, FL', null],
    ['Mederi Caretenders (Orlando)', 'Orlando', '1117 S. Westmoreland Drive Suite B, Orlando, FL', null],
    ['Accomplished Home Care (Orlando)', 'Orlando', '922 Lake Baldwin Dr Ste B, Orlando, FL', null],
    ['Acute Home Healthcare', 'Orlando', '4303 Vineland Rd Ste F-12, Orlando, FL', null],

    ['FirstLight Home Care', 'Houston', '5433 Westheimer Road Suite 403, Houston, TX', null],
    ['Griswold Home Care', 'Houston', '10998 S Wilcrest Dr Ste 297, Houston, TX', null],
    ['Reliant At Home', 'Fort Worth', '3880 Hulen St Suite 670, Fort Worth, TX', '32'],

    ['BrightStar Care', 'Irving', '600 E John Carpenter Fwy Ste 345, Irving, TX', null],
    ['ComForcare Home Care', 'Irving', '940 N. Beltline Road, Suite 103, Irving, TX', null],
    ['Advanced Home Health Services', 'Irving', '1212 Corporate Drive, Suite 125, Irving, TX', null],
    ['Alpine Care Home Health', 'Irving', '4545 Fuller Drive Suite 330, Irving, TX', null],

    ['S N E Home Health Care Services', 'Whittier', '13583 Whittier Blvd, Suite 201, Whittier, CA', null],
    ['Safe Guard Home Health', 'Van Nuys', '14242 Oxnard St, Suite 205, Van Nuys, CA', null],
    ['Care4u Caregiving Inc.', 'La Mirada', '14403 Manecita Dr., La Mirada, CA', null],
    ['BrightStar Care of N. Central San Diego', 'San Diego', '3944 Murphy Canyon Rd. #C206, San Diego, CA', null],

    ['Life Care Services, Inc.', 'Brooklyn', '1723 Avenue M, Brooklyn, NY', null],
    ['Ultimate Care, Inc.', 'Brooklyn', '1000 Gates Avenue, 4th Floor, Brooklyn, NY', null],
    ['City Choice Home Care Services', 'Brooklyn', '2719 Coney Island Avenue, 2nd Floor, Brooklyn, NY', null],
    ['Centers Choice Home Care', 'Brooklyn', '5350 Kings Highway, Brooklyn, NY', null],
    ['Immediate Home Care, Inc.', 'Brooklyn', '204 Broadway, Brooklyn, NY', null],
    ['Parent Care Home Care, LLC', 'Brooklyn', '293 Penn Street, Brooklyn, NY', null],
    ['Adl Senior Choice, Inc.', 'Woodside', '63-04 Broadway, Woodside, NY', null],
    ['Best Choice Home Health Care, Inc.', 'Flushing', '136-65 37th Avenue, Flushing, NY', null],
    ['Rebekah Rehab Licensed Home Care Services Agency, Inc.', 'Bronx', '1040 Havemeyer Avenue, 3rd Floor, Bronx, NY', null],
];

$updated = [];
$missed  = [];

foreach ($updates as [$name, $city, $address, $years]) {
    $row = hc_one("SELECT id FROM hc_directory_listings WHERE company_name=? AND city=?", [$name, $city]);
    if (!$row) { $missed[] = "{$name} ({$city})"; continue; }
    if ($years !== null) {
        hc_q("UPDATE hc_directory_listings SET address=?, years_in_business=? WHERE id=?", [$address, $years, $row['id']]);
    } else {
        hc_q("UPDATE hc_directory_listings SET address=? WHERE id=?", [$address, $row['id']]);
    }
    $updated[] = "{$name} ({$city})";
}

hc_head('Enrich Directory Listings');
hc_topbar('Enrich Directory Listings', '<a href="/admin/">Admin</a> › Enrich Directory Listings');
?>
<div class="page-content">
  <div class="card">
    <div class="card-title" style="margin-bottom:10px">Enrichment Results</div>
    <p style="margin-bottom:16px"><strong><?= count($updated) ?></strong> listings updated with a verified address, <strong><?= count($missed) ?></strong> not found (already renamed/deleted?).</p>
    <p style="margin-bottom:16px;color:var(--muted)">Phone, email, and website were <strong>not</strong> filled in — they weren't available from any source without going around a lead-gen paywall, so they're left blank rather than invented. Fill those in manually (or wait for the agency to claim/complete its own listing) before approving.</p>
    <?php if ($updated): ?>
    <div class="card-title" style="margin-bottom:8px;font-size:13px">Updated</div>
    <ul style="margin:0 0 16px 18px;font-size:13px;color:var(--muted)">
      <?php foreach ($updated as $u): ?><li><?= h($u) ?></li><?php endforeach ?>
    </ul>
    <?php endif ?>
    <?php if ($missed): ?>
    <div class="card-title" style="margin-bottom:8px;font-size:13px">Not Found</div>
    <ul style="margin:0 0 16px 18px;font-size:13px;color:var(--muted)">
      <?php foreach ($missed as $m): ?><li><?= h($m) ?></li><?php endforeach ?>
    </ul>
    <?php endif ?>
    <p style="color:var(--red);font-weight:600">Delete this file (admin/enrich-directory-listings.php) now that it's run.</p>
  </div>
</div>
<?php hc_foot(); ?>
