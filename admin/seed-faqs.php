<?php
// ================================================================
//  FAQ Bank Seeder — imports existing on-page FAQ content (the
//  .faq-item / .faq-q-text / .faq-a-inner blocks already on service,
//  marketing, and case-study pages) into the hc_faqs table so the
//  chat widget's "Get Info from the Website" search has something
//  to search. Safe to re-run — skips exact question+answer matches
//  already in the table. Visit /admin/seed-faqs.php?run=1 to execute.
// ================================================================
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_faqs (
    id INT AUTO_INCREMENT PRIMARY KEY,
    question VARCHAR(500) NOT NULL,
    answer TEXT NOT NULL,
    pages VARCHAR(1000) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$run = isset($_GET['run']);
$root = dirname(__DIR__);

function hc_clean_faq_text(string $html): string {
    $text = html_entity_decode(strip_tags($html), ENT_QUOTES, 'UTF-8');
    return trim(preg_replace('/\s+/', ' ', $text));
}

function hc_url_for_path(string $root, string $file): string {
    $rel = str_replace('\\', '/', substr($file, strlen($root)));
    $rel = preg_replace('#/index\.php$#', '/', $rel);
    $rel = preg_replace('#\.php$#', '', $rel);
    return $rel ?: '/';
}

// A few pages (seo/home-care-seo, web-design/homecare-website-design,
// case-studies) render their FAQ section from a literal `$_faqs = [...]`
// PHP array instead of static text, so the regex scan below sees only the
// `<?= ... ?>` template code, not real content. Pull the literal array out
// of those files directly. eval() here only ever runs against our own
// trusted source files read off disk, never user input.
function hc_extract_faqs_array(string $content): array {
    if (!preg_match('/\$_?faqs\s*=\s*\[/', $content, $m, PREG_OFFSET_CAPTURE)) return [];
    $start = $m[0][1] + strlen($m[0][0]) - 1;
    $depth = 0;
    $inStr = null;
    $escaped = false;
    $len = strlen($content);
    $end = null;
    for ($i = $start; $i < $len; $i++) {
        $ch = $content[$i];
        if ($inStr !== null) {
            if ($escaped) { $escaped = false; continue; }
            if ($ch === '\\') { $escaped = true; continue; }
            if ($ch === $inStr) { $inStr = null; }
            continue;
        }
        if ($ch === "'" || $ch === '"') { $inStr = $ch; continue; }
        if ($ch === '[') $depth++;
        if ($ch === ']') { $depth--; if ($depth === 0) { $end = $i; break; } }
    }
    if ($end === null) return [];

    $arrText = substr($content, $start, $end - $start + 1);
    try {
        $arr = @eval('return ' . $arrText . ';');
    } catch (\Throwable $e) {
        return [];
    }
    if (!is_array($arr)) return [];

    $out = [];
    foreach ($arr as $pair) {
        if (is_array($pair) && count($pair) >= 2 && is_string($pair[0]) && is_string($pair[1])) {
            $out[] = [trim($pair[0]), trim($pair[1])];
        }
    }
    return $out;
}

// ── Scan every .php file outside /admin for .faq-item blocks ───────────────
function hc_scan_faq_files(string $root): array {
    $skipDirs = ['admin', '.git', 'node_modules'];
    $found = []; // [ [question, answer, url], ... ]

    $it = new RecursiveIteratorIterator(
        new RecursiveDirectoryIterator($root, FilesystemIterator::SKIP_DOTS),
        RecursiveIteratorIterator::LEAVES_ONLY,
        RecursiveIteratorIterator::CATCH_GET_CHILD
    );
    foreach ($it as $file) {
        if ($file->getExtension() !== 'php') continue;
        $rel = str_replace('\\', '/', substr($file->getPathname(), strlen($root) + 1));
        $topDir = explode('/', $rel)[0];
        if (in_array($topDir, $skipDirs, true)) continue;

        $content = file_get_contents($file->getPathname());
        if (strpos($content, 'faq-q-text') === false && strpos($content, '_faqs') === false && strpos($content, '$faqs') === false) continue;

        $url = hc_url_for_path($root, $file->getPathname());

        preg_match_all('/<span class="faq-q-text">(.*?)<\/span>/s', $content, $qm);
        preg_match_all('/<div class="faq-a-inner">(.*?)<\/div>/s', $content, $am);
        if ($qm[1] && count($qm[1]) === count($am[1])) {
            foreach ($qm[1] as $i => $q) {
                $question = hc_clean_faq_text($q);
                $answer   = hc_clean_faq_text($am[1][$i]);
                if ($question && $answer) $found[] = [$question, $answer, $url];
            }
        }

        foreach (hc_extract_faqs_array($content) as [$question, $answer]) {
            if ($question && $answer) $found[] = [$question, $answer, $url];
        }
    }
    return $found;
}

$log = [];
$inserted = 0;
$skipped = 0;

if ($run) {
    $pairs = hc_scan_faq_files($root);
    foreach ($pairs as [$question, $answer, $url]) {
        $exists = hc_val("SELECT id FROM hc_faqs WHERE question=? AND answer=?", [$question, $answer]);
        if ($exists) { $skipped++; continue; }
        hc_q("INSERT INTO hc_faqs (question, answer, pages) VALUES (?,?,?)", [$question, $answer, $url]);
        $inserted++;
        $log[] = ['q' => $question, 'url' => $url];
    }
}

hc_head('Seed FAQ Bank');
hc_topbar('Seed FAQ Bank', '<a href="/admin/">Admin</a> › <a href="/admin/ai-geo/faq-bank.php">FAQ Bank</a> › Seed');
?>
<div class="page-content">

<?php if (!$run): ?>
<div class="card">
  <div class="card-title" style="margin-bottom:14px">Import FAQs From Existing Pages</div>
  <p style="margin-bottom:14px">This scans every page on the site (outside <code>/admin</code>) for the FAQ accordion blocks already on your service, marketing, and case-study pages, and copies each question/answer into the FAQ Bank.</p>
  <p style="margin-bottom:14px">Safe to run more than once — it skips any question+answer pair that's already in the FAQ Bank, so nothing gets duplicated.</p>
  <a href="?run=1" class="btn btn-primary">Run Import</a>
</div>
<?php else: ?>
<div class="card">
  <div class="card-title" style="margin-bottom:14px">Import Complete</div>
  <p style="margin-bottom:14px"><strong><?= $inserted ?></strong> FAQ<?= $inserted === 1 ? '' : 's' ?> added, <strong><?= $skipped ?></strong> already existed and were skipped.</p>
  <a href="/admin/ai-geo/faq-bank.php" class="btn btn-primary">View FAQ Bank</a>
</div>
<?php if ($log): ?>
<div class="card">
  <div class="card-title" style="margin-bottom:14px">Added</div>
  <table>
    <thead><tr><th>Question</th><th>Page</th></tr></thead>
    <tbody>
      <?php foreach ($log as $l): ?>
      <tr><td><?= h($l['q']) ?></td><td style="color:var(--muted);font-size:12px"><?= h($l['url']) ?></td></tr>
      <?php endforeach ?>
    </tbody>
  </table>
</div>
<?php endif ?>
<?php endif ?>

</div>
<?php hc_foot(); ?>
