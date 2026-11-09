<?php
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
require_once __DIR__ . '/includes/functions.php';
require_once __DIR__ . '/includes/layout.php';
hc_require_auth();

// ── Safe query helpers (a missing table never breaks the dashboard) ──
function db_val(string $sql, array $p = [], $default = 0) {
    try { $v = hc_val($sql, $p); return $v === null || $v === false ? $default : $v; } catch (Throwable $e) { return $default; }
}
function db_all(string $sql, array $p = []): array {
    try { return hc_all($sql, $p) ?: []; } catch (Throwable $e) { return []; }
}
function db_ago(?string $ts): string {
    if (!$ts) return '—';
    $d = time() - strtotime($ts);
    if ($d < 60)     return 'just now';
    if ($d < 3600)   return floor($d / 60) . 'm ago';
    if ($d < 86400)  return floor($d / 3600) . 'h ago';
    if ($d < 604800) return floor($d / 86400) . 'd ago';
    return date('M j', strtotime($ts));
}
function db_delta(int $now, int $prev): array {
    if ($prev === 0) return $now > 0 ? ['up', 'New'] : ['flat', 'No change'];
    $pct = round(($now - $prev) / $prev * 100);
    if ($pct === 0.0 || $pct == 0) return ['flat', 'No change'];
    return [$pct > 0 ? 'up' : 'down', ($pct > 0 ? '+' : '') . $pct . '%'];
}
function db_page_label(?string $path): string {
    $path = trim((string)$path);
    if ($path === '' ) return 'Unknown';
    $path = preg_replace('#^https?://[^/]+#', '', $path);
    $path = strtok($path, '?');
    return $path === '/' || $path === '' ? 'Home page' : $path;
}

// ── Date windows ──
$d30  = date('Y-m-d 00:00:00', strtotime('-29 days'));
$d60  = date('Y-m-d 00:00:00', strtotime('-59 days'));
$d90  = date('Y-m-d 00:00:00', strtotime('-89 days'));

// ── KPIs: last 30 days vs the 30 days before ──
$form30   = (int)db_val("SELECT COUNT(*) FROM hc_form_submissions WHERE submitted_at >= ?", [$d30]);
$formPrev = (int)db_val("SELECT COUNT(*) FROM hc_form_submissions WHERE submitted_at >= ? AND submitted_at < ?", [$d60, $d30]);
$calc30   = (int)db_val("SELECT COUNT(*) FROM hc_calculator_submissions WHERE created_at >= ?", [$d30]);
$calcPrev = (int)db_val("SELECT COUNT(*) FROM hc_calculator_submissions WHERE created_at >= ? AND created_at < ?", [$d60, $d30]);
$reg30    = (int)db_val("SELECT COUNT(*) FROM hc_event_registrations WHERE created_at >= ?", [$d30]);
$regPrev  = (int)db_val("SELECT COUNT(*) FROM hc_event_registrations WHERE created_at >= ? AND created_at < ?", [$d60, $d30]);
$leads30  = $form30 + $calc30;
$leadsPrev= $formPrev + $calcPrev;

$newForm    = (int)db_val("SELECT COUNT(*) FROM hc_form_submissions WHERE status='new'");
$newCalc    = (int)db_val("SELECT COUNT(*) FROM hc_calculator_submissions WHERE status='new'");
$pendingDir = (int)db_val("SELECT COUNT(*) FROM hc_directory_listings WHERE status='pending'");
$totalForm  = (int)db_val("SELECT COUNT(*) FROM hc_form_submissions");

$postsPub   = (int)db_val("SELECT COUNT(*) FROM hc_blog_posts WHERE status='published'");
$postsDraft = (int)db_val("SELECT COUNT(*) FROM hc_blog_posts WHERE status<>'published'");
$lastPost   = db_val("SELECT MAX(created_at) FROM hc_blog_posts WHERE status='published'", [], null);
$daysSincePost = $lastPost ? (int)floor((time() - strtotime($lastPost)) / 86400) : null;

$redirects  = (int)db_val("SELECT COUNT(*) FROM hc_redirects WHERE active=1");
$tracking   = (int)db_val("SELECT COUNT(*) FROM hc_tracking_codes WHERE active=1");
$seoPages   = (int)db_val("SELECT COUNT(*) FROM hc_seo_pages");
$schemas    = (int)db_val("SELECT COUNT(*) FROM hc_page_schema WHERE active=1");
$faqs       = (int)db_val("SELECT COUNT(*) FROM hc_faqs");
$dirLive    = (int)db_val("SELECT COUNT(*) FROM hc_directory_listings WHERE status='approved'");

// ── Daily leads, last 30 days (form + calculator) ──
$days = [];
for ($i = 29; $i >= 0; $i--) { $days[date('Y-m-d', strtotime("-$i days"))] = ['form' => 0, 'calc' => 0]; }
foreach (db_all("SELECT DATE(submitted_at) d, COUNT(*) c FROM hc_form_submissions WHERE submitted_at >= ? GROUP BY DATE(submitted_at)", [$d30]) as $r) {
    if (isset($days[$r['d']])) $days[$r['d']]['form'] = (int)$r['c'];
}
foreach (db_all("SELECT DATE(created_at) d, COUNT(*) c FROM hc_calculator_submissions WHERE created_at >= ? GROUP BY DATE(created_at)", [$d30]) as $r) {
    if (isset($days[$r['d']])) $days[$r['d']]['calc'] = (int)$r['c'];
}
$maxDay = 1;
foreach ($days as $v) $maxDay = max($maxDay, $v['form'] + $v['calc']);
$bestDay = 0; foreach ($days as $v) $bestDay = max($bestDay, $v['form'] + $v['calc']);

// ── Breakdowns, last 90 days ──
$byService = db_all("SELECT COALESCE(NULLIF(service,''),'Not selected') label, COUNT(*) c FROM hc_form_submissions WHERE submitted_at >= ? GROUP BY label ORDER BY c DESC LIMIT 7", [$d90]);
$bySource  = [];
foreach (db_all("SELECT source_page p, COUNT(*) c FROM hc_form_submissions WHERE submitted_at >= ? GROUP BY source_page", [$d90]) as $r) {
    $k = db_page_label($r['p']); $bySource[$k] = ($bySource[$k] ?? 0) + (int)$r['c'];
}
foreach (db_all("SELECT source_page p, COUNT(*) c FROM hc_calculator_submissions WHERE created_at >= ? GROUP BY source_page", [$d90]) as $r) {
    $k = db_page_label($r['p']); $bySource[$k] = ($bySource[$k] ?? 0) + (int)$r['c'];
}
arsort($bySource); $bySource = array_slice($bySource, 0, 7, true);
$byPlace = db_all("SELECT CONCAT_WS(', ', NULLIF(geo_city,''), NULLIF(geo_region,'')) label, COUNT(*) c FROM hc_form_submissions WHERE submitted_at >= ? AND (geo_city <> '' OR geo_region <> '') GROUP BY label ORDER BY c DESC LIMIT 7", [$d90]);
$byDevice = db_all("SELECT COALESCE(NULLIF(device_type,''),'unknown') label, COUNT(*) c FROM hc_form_submissions WHERE submitted_at >= ? GROUP BY label ORDER BY c DESC", [$d90]);
$deviceTotal = array_sum(array_map(fn($r) => (int)$r['c'], $byDevice));

// ── Recent activity ──
$recentLeads = db_all("SELECT id,name,email,agency_name,city,service,source_page,status,submitted_at FROM hc_form_submissions ORDER BY submitted_at DESC LIMIT 8");
$recentCalc  = db_all("SELECT id,name,city,additional_annual_value,status,created_at FROM hc_calculator_submissions ORDER BY created_at DESC LIMIT 4");
$recentPosts = db_all("SELECT id,title,slug,status,created_at FROM hc_blog_posts ORDER BY created_at DESC LIMIT 5");
$nextEvents  = db_all("SELECT e.id,e.title,e.event_datetime,e.max_attendees,(SELECT COUNT(*) FROM hc_event_registrations r WHERE r.event_id=e.id) regs
                       FROM hc_events e WHERE e.event_datetime >= NOW() AND e.status='published' ORDER BY e.event_datetime ASC LIMIT 3");

// ── Needs attention ──
$attention = [];
if ($newForm)    $attention[] = ['red',  'New form leads waiting',        "$newForm unread " . ($newForm === 1 ? 'lead' : 'leads') . ' in the form log', '/admin/form-log.php?status=new', 'Open'];
if ($newCalc)    $attention[] = ['red',  'New growth calculator leads',   "$newCalc new " . ($newCalc === 1 ? 'submission' : 'submissions'), '/admin/calculator-leads.php', 'Open'];
if ($pendingDir) $attention[] = ['gold', 'Directory listings to review',  "$pendingDir pending approval", '/admin/directory/', 'Review'];
if ($daysSincePost !== null && $daysSincePost > 14)
                 $attention[] = ['gold', 'No new blog post in ' . $daysSincePost . ' days', 'Regular posts help rankings and AI search visibility', '/admin/blog/edit.php', 'Write'];
if ($postsDraft) $attention[] = ['gray', 'Draft posts', "$postsDraft " . ($postsDraft === 1 ? 'post is' : 'posts are') . ' not published yet', '/admin/blog/', 'View'];
if ($tracking === 0)
                 $attention[] = ['red',  'No active tracking codes', 'Google Analytics / Tag Manager are not running', '/admin/technical/tracking.php', 'Fix'];
$leftover = [];
foreach (['seed-*.php', 'update-*.php', 'enrich-*.php', 'fix-*.php', 'blog-seeder.php'] as $pat) {
    foreach (glob(__DIR__ . '/' . $pat) ?: [] as $f) $leftover[] = basename($f);
}
if ($leftover)   $attention[] = ['red', 'One-time scripts still on the server', count($leftover) . ' setup scripts should be deleted after use: ' . implode(', ', array_slice($leftover, 0, 4)) . (count($leftover) > 4 ? '…' : ''), '', ''];

$user  = $_SESSION['hc_user'] ?? 'there';
$hour  = (int)date('G');
$greet = $hour < 12 ? 'Good morning' : ($hour < 18 ? 'Good afternoon' : 'Good evening');

hc_head('Dashboard');
hc_topbar('Dashboard', '<a href="/admin/">Admin</a>');
?>
<style>
.db-hello{display:flex;justify-content:space-between;align-items:flex-end;gap:20px;margin-bottom:22px;flex-wrap:wrap}
.db-hello h1{font-size:22px;font-weight:700;color:var(--forest);line-height:1.2}
.db-hello p{font-size:13px;color:var(--muted);margin-top:4px}
.db-hello-actions{display:flex;gap:8px;flex-wrap:wrap}

.db-kpis{display:grid;grid-template-columns:repeat(4,1fr);gap:14px;margin-bottom:20px}
.db-kpi{background:#fff;border:1px solid var(--border);border-radius:var(--r);padding:18px 20px;display:flex;flex-direction:column;gap:6px;text-decoration:none!important;color:inherit;transition:border-color .15s}
.db-kpi:hover{border-color:var(--teal)}
.db-kpi-label{font-size:12px;font-weight:600;color:var(--muted)}
.db-kpi-row{display:flex;align-items:baseline;gap:10px}
.db-kpi-num{font-size:30px;font-weight:800;color:var(--forest);line-height:1;font-variant-numeric:tabular-nums}
.db-delta{font-size:11.5px;font-weight:700;padding:2px 7px;border-radius:20px}
.db-delta.up{background:rgba(29,158,117,.12);color:#0d7a57}
.db-delta.down{background:rgba(220,38,38,.09);color:var(--red)}
.db-delta.flat{background:rgba(107,114,128,.1);color:var(--muted)}
.db-kpi-foot{font-size:12px;color:var(--muted)}
.db-kpi-foot strong{color:var(--text)}

.db-grid{display:grid;grid-template-columns:minmax(0,1.65fr) minmax(0,1fr);gap:20px;margin-bottom:20px}
.db-grid > .card{margin-bottom:0}
.db-grid-3{display:grid;grid-template-columns:repeat(3,minmax(0,1fr));gap:20px;margin-bottom:20px}
.db-grid-3 > .card{margin-bottom:0}

.db-chart{position:relative;height:190px;display:flex;align-items:flex-end;gap:3px;padding-top:8px;border-bottom:1px solid var(--border)}
.db-chart-grid{position:absolute;left:0;right:0;border-top:1px dashed rgba(0,0,0,.07);pointer-events:none}
.db-chart-grid span{position:absolute;right:0;top:-16px;font-size:10.5px;color:var(--muted)}
.db-bar{flex:1;display:flex;flex-direction:column;justify-content:flex-end;height:100%;cursor:default;position:relative}
.db-bar-seg{width:100%;border-radius:3px 3px 0 0;background:var(--teal);min-height:0}
.db-bar-seg.calc{background:#8fd3bb;border-radius:0}
.db-bar-seg.calc + .db-bar-seg{border-radius:0}
.db-bar:hover .db-bar-seg{filter:brightness(.88)}
.db-bar-empty{width:100%;height:2px;background:rgba(0,0,0,.06);border-radius:2px}
.db-chart-x{display:flex;justify-content:space-between;font-size:10.5px;color:var(--muted);margin-top:6px}
.db-legend{display:flex;gap:16px;font-size:12px;color:var(--muted)}
.db-legend i{display:inline-block;width:10px;height:10px;border-radius:3px;margin-right:6px;vertical-align:-1px}
.db-tip{position:fixed;pointer-events:none;background:var(--forest);color:#fff;font-size:12px;padding:8px 10px;border-radius:7px;line-height:1.5;z-index:50;display:none;white-space:nowrap}
.db-chart-sum{display:flex;gap:28px;margin-top:16px;padding-top:14px;border-top:1px solid var(--border);flex-wrap:wrap}
.db-chart-sum div{font-size:12px;color:var(--muted)}
.db-chart-sum strong{display:block;font-size:18px;color:var(--forest);font-variant-numeric:tabular-nums}

.db-att{display:flex;flex-direction:column}
.db-att-item{display:grid;grid-template-columns:8px 1fr auto;gap:12px;align-items:center;padding:12px 0;border-bottom:1px solid var(--border)}
.db-att-item:last-child{border-bottom:none}
.db-dot{width:8px;height:8px;border-radius:50%}
.db-dot.red{background:var(--red)}.db-dot.gold{background:var(--gold)}.db-dot.gray{background:#9ca3af}
.db-att-title{font-size:13.5px;font-weight:600;color:var(--text)}
.db-att-sub{font-size:12px;color:var(--muted);margin-top:1px;word-break:break-word}
.db-allclear{display:flex;align-items:center;gap:12px;padding:18px;background:rgba(29,158,117,.07);border-radius:8px;color:#0d5c40;font-size:13.5px}

.db-bars{display:flex;flex-direction:column;gap:11px}
.db-bars-row{display:grid;grid-template-columns:minmax(0,1fr) 34px;gap:10px;align-items:center}
.db-bars-label{font-size:12.5px;color:var(--text);white-space:nowrap;overflow:hidden;text-overflow:ellipsis;margin-bottom:4px}
.db-bars-track{height:6px;background:rgba(0,0,0,.05);border-radius:4px;overflow:hidden}
.db-bars-fill{height:100%;background:var(--teal);border-radius:4px}
.db-bars-val{font-size:13px;font-weight:700;color:var(--forest);text-align:right;font-variant-numeric:tabular-nums}
.db-empty{font-size:13px;color:var(--muted);padding:18px 0}

.db-device{display:flex;height:10px;border-radius:6px;overflow:hidden;gap:2px;margin:6px 0 14px}
.db-device div{background:var(--teal)}
.db-device div:nth-child(2){background:#8fd3bb}
.db-device div:nth-child(3){background:#c9a84c}
.db-device div:nth-child(n+4){background:#cbd5d1}
.db-device-legend{display:flex;flex-wrap:wrap;gap:6px 16px;font-size:12px;color:var(--muted)}
.db-device-legend i{display:inline-block;width:9px;height:9px;border-radius:2px;margin-right:6px}

.db-lead-name{font-weight:600;color:var(--text)}
.db-lead-sub{font-size:12px;color:var(--muted)}
.db-src{font-size:12px;color:var(--muted);font-family:'SF Mono',Consolas,monospace}

.db-health{display:grid;grid-template-columns:repeat(2,1fr);gap:0}
.db-health a{display:flex;justify-content:space-between;align-items:center;padding:11px 0;border-bottom:1px solid var(--border);font-size:13px;color:var(--text);text-decoration:none!important}
.db-health a:nth-child(odd){padding-right:16px}
.db-health a:nth-child(even){padding-left:16px;border-left:1px solid var(--border)}
.db-health a:hover{color:var(--teal)}
.db-health strong{font-variant-numeric:tabular-nums}

.db-list-item{display:flex;justify-content:space-between;gap:12px;padding:10px 0;border-bottom:1px solid var(--border);align-items:center}
.db-list-item:last-child{border-bottom:none}
.db-list-title{font-size:13px;font-weight:600;color:var(--text)}
.db-list-sub{font-size:12px;color:var(--muted)}

.db-actions{display:grid;grid-template-columns:repeat(4,1fr);gap:10px}
.db-action{display:flex;align-items:center;gap:10px;padding:12px 14px;border:1px solid var(--border);border-radius:8px;color:var(--text);font-size:13px;font-weight:600;text-decoration:none!important;transition:border-color .15s,color .15s}
.db-action:hover{border-color:var(--teal);color:var(--teal)}
.db-action svg{width:16px;height:16px;color:var(--teal);flex-shrink:0}

@media(max-width:1200px){.db-kpis{grid-template-columns:repeat(2,1fr)}.db-grid-3{grid-template-columns:1fr 1fr}.db-actions{grid-template-columns:repeat(2,1fr)}}
@media(max-width:900px){.db-grid,.db-grid-3{grid-template-columns:1fr}}
@media(max-width:560px){.db-kpis,.db-actions,.db-health{grid-template-columns:1fr}.db-health a:nth-child(even){padding-left:0;border-left:none}}
</style>

<div class="page-content">
<?= hc_show_flash() ?>

<div class="db-hello">
  <div>
    <h1><?= $greet ?>, <?= h(ucfirst($user)) ?></h1>
    <p><?= date('l, F j, Y') ?> · Here's how the website is doing over the last 30 days.</p>
  </div>
  <div class="db-hello-actions">
    <a href="/" target="_blank" rel="noopener" class="btn btn-secondary">View website</a>
    <a href="/admin/blog/edit.php" class="btn btn-primary">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
      New blog post
    </a>
  </div>
</div>

<!-- KPIs -->
<div class="db-kpis">
  <?php [$dc, $dt] = db_delta($leads30, $leadsPrev); ?>
  <a class="db-kpi" href="/admin/form-log.php">
    <div class="db-kpi-label">Total leads · 30 days</div>
    <div class="db-kpi-row"><div class="db-kpi-num"><?= $leads30 ?></div><span class="db-delta <?= $dc ?>"><?= $dt ?></span></div>
    <div class="db-kpi-foot">vs <strong><?= $leadsPrev ?></strong> in the previous 30 days</div>
  </a>
  <?php [$dc, $dt] = db_delta($form30, $formPrev); ?>
  <a class="db-kpi" href="/admin/form-log.php">
    <div class="db-kpi-label">Form leads · 30 days</div>
    <div class="db-kpi-row"><div class="db-kpi-num"><?= $form30 ?></div><span class="db-delta <?= $dc ?>"><?= $dt ?></span></div>
    <div class="db-kpi-foot"><strong><?= $newForm ?></strong> unread · <?= $totalForm ?> all time</div>
  </a>
  <?php [$dc, $dt] = db_delta($calc30, $calcPrev); ?>
  <a class="db-kpi" href="/admin/calculator-leads.php">
    <div class="db-kpi-label">Growth calculator · 30 days</div>
    <div class="db-kpi-row"><div class="db-kpi-num"><?= $calc30 ?></div><span class="db-delta <?= $dc ?>"><?= $dt ?></span></div>
    <div class="db-kpi-foot"><strong><?= $newCalc ?></strong> new to follow up</div>
  </a>
  <?php [$dc, $dt] = db_delta($reg30, $regPrev); ?>
  <a class="db-kpi" href="/admin/events/">
    <div class="db-kpi-label">Event sign-ups · 30 days</div>
    <div class="db-kpi-row"><div class="db-kpi-num"><?= $reg30 ?></div><span class="db-delta <?= $dc ?>"><?= $dt ?></span></div>
    <div class="db-kpi-foot"><strong><?= count($nextEvents) ?></strong> upcoming <?= count($nextEvents) === 1 ? 'event' : 'events' ?></div>
  </a>
</div>

<!-- CHART + ATTENTION -->
<div class="db-grid">
  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Leads per day</div>
        <div class="card-sub">Last 30 days · contact form and growth calculator</div>
      </div>
      <div class="db-legend"><span><i style="background:var(--teal)"></i>Form</span><span><i style="background:#8fd3bb"></i>Calculator</span></div>
    </div>
    <div class="db-chart" id="dbChart">
      <?php $mid = (int)ceil($maxDay / 2); ?>
      <div class="db-chart-grid" style="top:8px"><span><?= $maxDay ?></span></div>
      <?php if ($mid < $maxDay && $mid > 0): ?><div class="db-chart-grid" style="top:calc(8px + (100% - 8px) * <?= round(1 - $mid / $maxDay, 3) ?>)"><span><?= $mid ?></span></div><?php endif ?>
      <?php foreach ($days as $d => $v): $t = $v['form'] + $v['calc']; ?>
      <div class="db-bar" data-tip="<?= h(date('D, M j', strtotime($d))) ?>|<?= $v['form'] ?>|<?= $v['calc'] ?>">
        <?php if ($t === 0): ?><div class="db-bar-empty"></div><?php else: ?>
          <?php if ($v['calc']): ?><div class="db-bar-seg calc" style="height:<?= round($v['calc'] / $maxDay * 100, 2) ?>%;<?= $v['form'] ? '' : 'border-radius:3px 3px 0 0' ?>"></div><?php endif ?>
          <?php if ($v['form']): ?><div class="db-bar-seg" style="height:<?= round($v['form'] / $maxDay * 100, 2) ?>%;<?= $v['calc'] ? 'border-radius:0;margin-top:2px' : '' ?>"></div><?php endif ?>
        <?php endif ?>
      </div>
      <?php endforeach ?>
    </div>
    <div class="db-chart-x"><span><?= date('M j', strtotime('-29 days')) ?></span><span><?= date('M j', strtotime('-15 days')) ?></span><span>Today</span></div>
    <div class="db-chart-sum">
      <div><strong><?= $leads30 ?></strong>leads in 30 days</div>
      <div><strong><?= number_format($leads30 / 30, 1) ?></strong>per day on average</div>
      <div><strong><?= $bestDay ?></strong>on the best day</div>
    </div>
  </div>

  <div class="card">
    <div class="card-header">
      <div>
        <div class="card-title">Needs your attention</div>
        <div class="card-sub">Things to act on today</div>
      </div>
    </div>
    <?php if ($attention): ?>
    <div class="db-att">
      <?php foreach ($attention as [$c, $title, $sub, $href, $btn]): ?>
      <div class="db-att-item">
        <span class="db-dot <?= $c ?>"></span>
        <div><div class="db-att-title"><?= h($title) ?></div><div class="db-att-sub"><?= h($sub) ?></div></div>
        <?php if ($href): ?><a href="<?= h($href) ?>" class="btn btn-sm btn-secondary"><?= h($btn) ?></a><?php else: ?><span></span><?php endif ?>
      </div>
      <?php endforeach ?>
    </div>
    <?php else: ?>
    <div class="db-allclear">
      <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><polyline points="20 6 9 17 4 12"/></svg>
      All caught up. No unread leads or pending reviews.
    </div>
    <?php endif ?>
  </div>
</div>

<!-- BREAKDOWNS -->
<?php
function db_bars(array $rows): void {
    if (!$rows) { echo '<div class="db-empty">No data in the last 90 days yet.</div>'; return; }
    $max = max(array_map(fn($r) => (int)$r[1], $rows)) ?: 1;
    echo '<div class="db-bars">';
    foreach ($rows as [$label, $c]) {
        echo '<div class="db-bars-row"><div><div class="db-bars-label" title="' . h($label) . '">' . h($label) . '</div>'
           . '<div class="db-bars-track"><div class="db-bars-fill" style="width:' . round($c / $max * 100, 1) . '%"></div></div></div>'
           . '<div class="db-bars-val">' . (int)$c . '</div></div>';
    }
    echo '</div>';
}
?>
<div class="db-grid-3">
  <div class="card">
    <div class="card-header"><div><div class="card-title">What leads ask for</div><div class="card-sub">Service picked in the form · 90 days</div></div></div>
    <?php db_bars(array_map(fn($r) => [$r['label'], $r['c']], $byService)); ?>
  </div>
  <div class="card">
    <div class="card-header"><div><div class="card-title">Top lead pages</div><div class="card-sub">Page the lead came from · 90 days</div></div></div>
    <?php $rows = []; foreach ($bySource as $k => $c) $rows[] = [$k, $c]; db_bars($rows); ?>
  </div>
  <div class="card">
    <div class="card-header"><div><div class="card-title">Where leads are</div><div class="card-sub">Location and device · 90 days</div></div></div>
    <?php if ($deviceTotal): ?>
    <div class="db-device"><?php foreach ($byDevice as $r): ?><div style="width:<?= round($r['c'] / $deviceTotal * 100, 1) ?>%" title="<?= h(ucfirst($r['label'])) ?>: <?= (int)$r['c'] ?>"></div><?php endforeach ?></div>
    <div class="db-device-legend" style="margin-bottom:18px">
      <?php $cols = ['var(--teal)', '#8fd3bb', '#c9a84c', '#cbd5d1']; foreach ($byDevice as $i => $r): ?>
      <span><i style="background:<?= $cols[min($i, 3)] ?>"></i><?= h(ucfirst($r['label'])) ?> <?= round($r['c'] / $deviceTotal * 100) ?>%</span>
      <?php endforeach ?>
    </div>
    <?php endif ?>
    <?php db_bars(array_map(fn($r) => [$r['label'], $r['c']], $byPlace)); ?>
  </div>
</div>

<!-- RECENT LEADS + SIDE -->
<div class="db-grid">
  <div class="card">
    <div class="card-header">
      <div><div class="card-title">Latest leads</div><div class="card-sub">Most recent contact form submissions</div></div>
      <a href="/admin/form-log.php" class="btn btn-sm btn-secondary">View all</a>
    </div>
    <?php if ($recentLeads): ?>
    <div class="table-wrap">
      <table>
        <thead><tr><th>Lead</th><th>Service</th><th>From page</th><th>When</th><th>Status</th></tr></thead>
        <tbody>
        <?php foreach ($recentLeads as $r): ?>
        <tr>
          <td><a class="db-lead-name" href="/admin/form-log.php?view=<?= (int)$r['id'] ?>"><?= h($r['name']) ?></a>
            <div class="db-lead-sub"><?= h(trim(($r['agency_name'] ?? '') . (($r['agency_name'] ?? '') && ($r['city'] ?? '') ? ' · ' : '') . ($r['city'] ?? ''))) ?: h($r['email']) ?></div></td>
          <td style="font-size:12.5px"><?= h($r['service'] ?: '—') ?></td>
          <td><span class="db-src"><?= h(db_page_label($r['source_page'] ?? '')) ?></span></td>
          <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= db_ago($r['submitted_at']) ?></td>
          <td><span class="badge <?= $r['status']==='new' ? 'badge-red' : ($r['status']==='read' ? 'badge-green' : 'badge-gray') ?>"><?= h($r['status']) ?></span></td>
        </tr>
        <?php endforeach ?>
        </tbody>
      </table>
    </div>
    <?php else: ?><div class="empty-state"><p>No submissions yet.</p></div><?php endif ?>
  </div>

  <div class="card">
    <div class="card-header">
      <div><div class="card-title">Growth calculator leads</div><div class="card-sub">Estimated yearly opportunity per lead</div></div>
      <a href="/admin/calculator-leads.php" class="btn btn-sm btn-secondary">View all</a>
    </div>
    <?php if ($recentCalc): foreach ($recentCalc as $r): ?>
    <div class="db-list-item">
      <div><div class="db-list-title"><?= h($r['name']) ?></div><div class="db-list-sub"><?= h($r['city']) ?> · <?= db_ago($r['created_at']) ?></div></div>
      <div style="text-align:right"><div class="db-list-title">$<?= number_format((float)$r['additional_annual_value']) ?></div>
        <?php if ($r['status'] === 'new'): ?><span class="badge badge-red">new</span><?php endif ?></div>
    </div>
    <?php endforeach; else: ?><div class="db-empty">No calculator leads yet.</div><?php endif ?>
  </div>
</div>

<!-- CONTENT / EVENTS / HEALTH -->
<div class="db-grid-3">
  <div class="card">
    <div class="card-header">
      <div><div class="card-title">Blog</div><div class="card-sub"><?= $postsPub ?> published<?= $daysSincePost !== null ? ' · last one ' . ($daysSincePost === 0 ? 'today' : $daysSincePost . ' days ago') : '' ?></div></div>
      <a href="/admin/blog/" class="btn btn-sm btn-secondary">All posts</a>
    </div>
    <?php if ($recentPosts): foreach ($recentPosts as $p): ?>
    <div class="db-list-item">
      <div style="min-width:0"><a class="db-list-title" href="/admin/blog/edit.php?id=<?= (int)$p['id'] ?>" style="display:block;white-space:nowrap;overflow:hidden;text-overflow:ellipsis"><?= h($p['title']) ?></a><div class="db-list-sub"><?= date('M j, Y', strtotime($p['created_at'])) ?></div></div>
      <span class="badge <?= $p['status']==='published' ? 'badge-green' : 'badge-gray' ?>"><?= h($p['status']) ?></span>
    </div>
    <?php endforeach; else: ?><div class="db-empty">No blog posts yet.</div><?php endif ?>
  </div>

  <div class="card">
    <div class="card-header">
      <div><div class="card-title">Upcoming events</div><div class="card-sub">Published events and sign-ups</div></div>
      <a href="/admin/events/" class="btn btn-sm btn-secondary">Manage</a>
    </div>
    <?php if ($nextEvents): foreach ($nextEvents as $e): ?>
    <div class="db-list-item">
      <div style="min-width:0"><a class="db-list-title" href="/admin/events/registrations.php?event_id=<?= (int)$e['id'] ?>"><?= h($e['title']) ?></a><div class="db-list-sub"><?= date('D, M j · g:ia', strtotime($e['event_datetime'])) ?></div></div>
      <div style="text-align:right;white-space:nowrap"><div class="db-list-title"><?= (int)$e['regs'] ?><?= $e['max_attendees'] ? ' / ' . (int)$e['max_attendees'] : '' ?></div><div class="db-list-sub">registered</div></div>
    </div>
    <?php endforeach; else: ?>
    <div class="db-empty">No upcoming events. <a href="/admin/events/edit.php">Create one</a> to collect sign-ups.</div>
    <?php endif ?>
  </div>

  <div class="card">
    <div class="card-header"><div><div class="card-title">Site health</div><div class="card-sub">SEO setup at a glance</div></div></div>
    <div class="db-health">
      <a href="/admin/technical/tracking.php"><span>Tracking codes</span><strong style="color:<?= $tracking ? 'var(--teal)' : 'var(--red)' ?>"><?= $tracking ?> active</strong></a>
      <a href="/admin/schema/"><span>Schema blocks</span><strong><?= $schemas ?></strong></a>
      <a href="/admin/seo-pages.php"><span>SEO overrides</span><strong><?= $seoPages ?></strong></a>
      <a href="/admin/technical/redirects.php"><span>Redirects</span><strong><?= $redirects ?></strong></a>
      <a href="/admin/ai-geo/faq-bank.php"><span>FAQ bank</span><strong><?= $faqs ?></strong></a>
      <a href="/admin/directory/"><span>Directory live</span><strong><?= $dirLive ?></strong></a>
    </div>
  </div>
</div>

<!-- QUICK ACTIONS -->
<div class="card">
  <div class="card-header"><div class="card-title">Quick actions</div></div>
  <div class="db-actions">
    <a class="db-action" href="/admin/blog/edit.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 20h9"/><path d="M16.5 3.5a2.1 2.1 0 0 1 3 3L7 19l-4 1 1-4Z"/></svg>Write a blog post</a>
    <a class="db-action" href="/admin/seo-pages.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="11" cy="11" r="7"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>Edit page SEO</a>
    <a class="db-action" href="/admin/technical/redirects.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><polyline points="15 10 20 15 15 20"/><path d="M4 4v7a4 4 0 0 0 4 4h12"/></svg>Add a redirect</a>
    <a class="db-action" href="/admin/content/broken-links.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M10 13a5 5 0 0 0 7.5.5l3-3a5 5 0 0 0-7-7l-1.7 1.7"/><path d="M14 11a5 5 0 0 0-7.5-.5l-3 3a5 5 0 0 0 7 7l1.7-1.7"/></svg>Check broken links</a>
    <a class="db-action" href="/admin/ai-geo/faq-bank.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="10"/><path d="M9.1 9a3 3 0 0 1 5.8 1c0 2-3 3-3 3"/><line x1="12" y1="17" x2="12.01" y2="17"/></svg>FAQ bank</a>
    <a class="db-action" href="/admin/technical/sitemap.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="3" width="7" height="7"/><rect x="14" y="14" width="7" height="7"/><path d="M6.5 10v4a3 3 0 0 0 3 3H14"/></svg>Sitemap</a>
    <a class="db-action" href="/admin/events/edit.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Create an event</a>
    <a class="db-action" href="/admin/settings.php"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.7 1.7 0 0 0 .3 1.8l.1.1a2 2 0 1 1-2.8 2.8l-.1-.1a1.7 1.7 0 0 0-1.8-.3 1.7 1.7 0 0 0-1 1.5V21a2 2 0 0 1-4 0v-.1a1.7 1.7 0 0 0-1.1-1.5 1.7 1.7 0 0 0-1.8.3l-.1.1a2 2 0 1 1-2.8-2.8l.1-.1a1.7 1.7 0 0 0 .3-1.8 1.7 1.7 0 0 0-1.5-1H3a2 2 0 0 1 0-4h.1a1.7 1.7 0 0 0 1.5-1.1 1.7 1.7 0 0 0-.3-1.8l-.1-.1a2 2 0 1 1 2.8-2.8l.1.1a1.7 1.7 0 0 0 1.8.3H9a1.7 1.7 0 0 0 1-1.5V3a2 2 0 0 1 4 0v.1a1.7 1.7 0 0 0 1 1.5 1.7 1.7 0 0 0 1.8-.3l.1-.1a2 2 0 1 1 2.8 2.8l-.1.1a1.7 1.7 0 0 0-.3 1.8V9a1.7 1.7 0 0 0 1.5 1H21a2 2 0 0 1 0 4h-.1a1.7 1.7 0 0 0-1.5 1Z"/></svg>Site settings</a>
  </div>
</div>

</div>

<div class="db-tip" id="dbTip"></div>
<script>
(function () {
  var tip = document.getElementById('dbTip');
  document.querySelectorAll('#dbChart .db-bar').forEach(function (b) {
    b.addEventListener('mousemove', function (e) {
      var p = b.dataset.tip.split('|'), f = +p[1], c = +p[2];
      tip.innerHTML = '<strong>' + p[0] + '</strong><br>' + (f + c) + ' leads · ' + f + ' form, ' + c + ' calculator';
      tip.style.display = 'block';
      tip.style.left = Math.min(e.clientX + 12, window.innerWidth - tip.offsetWidth - 8) + 'px';
      tip.style.top = (e.clientY - tip.offsetHeight - 12) + 'px';
    });
    b.addEventListener('mouseleave', function () { tip.style.display = 'none'; });
  });
})();
</script>
<?php hc_foot(); ?>
