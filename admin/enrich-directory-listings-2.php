<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

// One-time enrichment pass #2. Adds verified phone/website (and, for a
// handful of rows whose official site disagrees with the directory
// aggregator used in the first seed, a corrected address) to the listings
// from seed-directory-listings.php. Only rows where a real source (company's
// own site, franchise locator, NPI registry, NY State DOH HFIS, or an
// unconflicted directory listing) confirmed the data are included here —
// every "not found" or conflicting-branch case from the research pass was
// deliberately left out rather than guessed. Safe to re-run. Delete after use.

// [company_name, city, phone, website, address_override_or_null]
$updates = [
    ['United Home Care Services', 'Miami', '(305) 716-0710', null, null],

    ['Brooks Rehabilitation Home Health', 'Jacksonville', '(844) 238-0064', 'https://brooksrehab.org', null],
    ['Southeast Homecare', 'Jacksonville', '(904) 717-9960', null, null],

    ['Parx Home Care (West Florida)', 'Tampa', null, 'https://parxhhc.com', null],
    ['Granny Nannies Senior Home Care of Tampa', 'Tampa', '(800) 316-2669', 'https://grannynannies.com', null],
    ['Concierge Home Care', 'Tampa', null, 'https://conciergehomecare.com', null],
    ['Griswold Care', 'Tampa', '(813) 343-2228', 'https://griswoldcare.com/tampa', null],

    ['Mederi Caretenders (Orlando)', 'Orlando', '(407) 852-2782', null, null],
    ['Acute Home Healthcare', 'Orlando', '(321) 594-5656', null, null],

    ['Always Best Care of West Houston', 'Houston', '(832) 460-2000', null, null],
    ['FirstLight Home Care', 'Houston', '(713) 714-5625', 'https://firstlighthomecare.com', null],
    ['Griswold Home Care', 'Houston', '(832) 598-4131', 'https://griswoldcare.com/west-houston', '1011 South Highway 6, Suite 305, Houston, TX'],
    ['Newport Home Health Agency', 'Grand Prairie', '(972) 602-3500', null, null],
    ['Reliant At Home', 'Fort Worth', '(817) 332-0400', 'https://reliantathome.com', '6000 Western Place, Ste 410, Fort Worth, TX'],

    ['ComForcare Home Care', 'Irving', '(469) 981-3033', 'https://comforcare.com/irving', null],
    ['BrightStar Care', 'Irving', '(469) 379-2652', 'https://brightstarcare.com/locations/irving-dallas-metro', null],
    ['Home Instead', 'Irving', '(972) 243-6100', 'https://homeinstead.com/location/407', null],
    ['Advanced Home Health Services', 'Irving', '(972) 445-9117', null, null],
    ['Alpine Care Home Health', 'Irving', '(972) 871-7500', null, null],

    ['Interim Healthcare San Diego Home Health', 'San Diego', '(760) 432-9811', null, '425 W 5th Ave Ste 101, Escondido, CA'],
    ['Kevory Enterprises dba Senior Helpers', 'San Diego', '(858) 217-4837', null, null],
    ['BrightStar Care of N. Central San Diego', 'San Diego', '(619) 817-8884', 'https://brightstarcare.com/n-central-san-diego', '9939 Hibert Street, Suite 203, San Diego, CA'],
    ['Heritage Senior Care, Inc.', 'Carlsbad', '(760) 720-7740', 'https://heritageseniorcare.com', '2111 Palomar Airport Rd Ste 120, Carlsbad, CA'],
    ['Advantage Health Systems', 'San Diego', '(858) 433-0469', null, null],

    ['Life Care Services, Inc.', 'Brooklyn', '(718) 252-1515', null, null],
    ['Ultimate Care, Inc.', 'Brooklyn', '(718) 257-0702', 'https://ultimate-care.com', null],
    ['City Choice Home Care Services', 'Brooklyn', '(718) 645-1116', null, null],
    ['Centers Choice Home Care', 'Brooklyn', '(646) 558-2555', null, null],
    ['Parent Care Home Care, LLC', 'Brooklyn', '(718) 486-7100', null, null],
    ['Rebekah Rehab Licensed Home Care Services Agency, Inc.', 'Bronx', '(718) 863-6200', null, null],
    ['Atara Home Care', 'Bronx', '(212) 235-5100', null, '3525 Baychester Ave, Bronx, NY'],
];

$updated = [];
$missed  = [];

foreach ($updates as [$name, $city, $phone, $website, $address]) {
    $row = hc_one("SELECT id FROM hc_directory_listings WHERE company_name=? AND city=?", [$name, $city]);
    if (!$row) { $missed[] = "{$name} ({$city})"; continue; }

    $sets = []; $params = [];
    if ($phone !== null)   { $sets[] = 'phone=?';   $params[] = $phone; }
    if ($website !== null) { $sets[] = 'website=?'; $params[] = $website; }
    if ($address !== null) { $sets[] = 'address=?'; $params[] = $address; }
    if (!$sets) continue;

    $params[] = $row['id'];
    hc_q("UPDATE hc_directory_listings SET " . implode(',', $sets) . " WHERE id=?", $params);
    $updated[] = "{$name} ({$city})";
}

// Listings the research flagged as likely mistagged, defunct, or unverifiable —
// deliberately NOT auto-rejected. Surfaced here so an admin makes the call.
$flagged = [
    ['Living Waters Healthcare Services', 'Miami, FL', 'No matching business could be found at all under this name.'],
    ['Bon Secours Home Care by Compassus', 'Tampa, FL', "No Tampa office exists on the company's own site — nearest confirmed offices are St. Petersburg and Sun City Center. City tag is likely wrong."],
    ['Family Home Care of Central Florida', 'Orlando, FL', "The company's own domain now redirects to an unrelated competitor's page — may have closed or rebranded."],
    ['Accomplished Home Care (Orlando)', 'Orlando, FL', "The seeded address appears to belong to a different company (Leeder Home Health Care). This company's real FL offices are in Ocala/Port Charlotte, not Orlando."],
    ['Right At Home', 'Irving, TX', 'Prior Irving office is marked closed; no current Right At Home office found in Irving.'],
    ['Maxim Healthcare Services', 'Irving, TX', 'No Maxim office found in Irving; nearest is the Dallas regional office.'],
    ['Care4u Caregiving Inc.', 'La Mirada, CA', 'No phone, website, license record, or online presence found anywhere for this business.'],
    ['Associate Home Care (AHC)', 'San Diego, CA', 'Could not confirm this business exists under this name in San Diego.'],
    ['Adl Senior Choice, Inc.', 'Woodside, NY', 'Could not confirm this entity exists at all in NY DOH records or elsewhere.'],
    ['Safe Guard Home Health', 'Van Nuys, CA', 'A phone number surfaced but its registered address (Northridge, CA) conflicts with the seeded Van Nuys address — do not trust without manual verification.'],
];

hc_head('Enrich Directory Listings (Pass 2)');
hc_topbar('Enrich Directory Listings (Pass 2)', '<a href="/admin/">Admin</a> › Enrich Directory Listings 2');
?>
<div class="page-content">
  <div class="card">
    <div class="card-title" style="margin-bottom:10px">Enrichment Results</div>
    <p style="margin-bottom:16px"><strong><?= count($updated) ?></strong> listings updated with verified phone/website/address, <strong><?= count($missed) ?></strong> not found in the table.</p>
    <?php if ($updated): ?>
    <div class="card-title" style="margin-bottom:8px;font-size:13px">Updated</div>
    <ul style="margin:0 0 16px 18px;font-size:13px;color:var(--muted)">
      <?php foreach ($updated as $u): ?><li><?= h($u) ?></li><?php endforeach ?>
    </ul>
    <?php endif ?>
  </div>

  <div class="card" style="border-color:rgba(220,38,38,.3);background:rgba(220,38,38,.03)">
    <div class="card-title" style="margin-bottom:10px;color:var(--red)">⚠ Needs Manual Review Before Approving</div>
    <p style="margin-bottom:16px">These 10 listings came back from research with real problems — wrong city, a possibly-defunct business, or no verifiable record at all. They were intentionally left untouched (still pending, no fabricated data added). Open each one in <a href="/admin/directory/">the directory admin</a> and decide: fix it with correct info, or reject/delete it.</p>
    <table>
      <thead><tr><th>Company</th><th>City</th><th>Issue</th></tr></thead>
      <tbody>
      <?php foreach ($flagged as $f): ?>
      <tr><td><strong><?= h($f[0]) ?></strong></td><td><?= h($f[1]) ?></td><td style="font-size:13px;color:var(--muted)"><?= h($f[2]) ?></td></tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>

  <p style="color:var(--red);font-weight:600">Delete this file (admin/enrich-directory-listings-2.php) now that it's run.</p>
</div>
<?php hc_foot(); ?>
