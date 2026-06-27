<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$pages = hc_scan_pages();
$report = [];
foreach ($pages as $page) {
    if (!file_exists($page['file'])) continue;
    $html  = file_get_contents($page['file']);
    $links = [];
    preg_match_all('/href=["\']([^"\'#?]+)["\']/', $html, $m);
    foreach ($m[1] as $href) {
        if (str_starts_with($href,'/') && !str_starts_with($href,'//') && !str_starts_with($href,'/admin')) {
            $links[] = $href;
        }
    }
    $links = array_unique($links);
    $report[] = [
        'name'   => $page['name'],
        'path'   => $page['path'],
        'count'  => count($links),
        'links'  => $links,
    ];
}
usort($report, fn($a,$b) => $a['count'] - $b['count']);

hc_head('Internal Link Suggestions');
hc_topbar('Internal Link Suggestions', '<a href="/admin/">Admin</a> › Content Tools › Internal Links');
?>
<div class="page-content">

<div class="page-header">
  <div><h1>Internal Link Suggestions</h1><div class="sub">Pages with fewer internal links are less well-connected. Aim for 3+ internal links per page.</div></div>
</div>

<div class="stats-grid">
  <?php
  $low    = count(array_filter($report, fn($r) => $r['count'] < 3));
  $ok     = count(array_filter($report, fn($r) => $r['count'] >= 3 && $r['count'] < 7));
  $strong = count(array_filter($report, fn($r) => $r['count'] >= 7));
  ?>
  <div class="stat-card red"><div class="stat-num"><?= $low ?></div><div class="stat-label">Pages with &lt;3 links</div></div>
  <div class="stat-card gold"><div class="stat-num"><?= $ok ?></div><div class="stat-label">OK (3–6 links)</div></div>
  <div class="stat-card teal"><div class="stat-num"><?= $strong ?></div><div class="stat-label">Well-linked (7+)</div></div>
  <div class="stat-card"><div class="stat-num"><?= count($report) ?></div><div class="stat-label">Total Pages</div></div>
</div>

<div class="card">
  <div class="table-wrap">
    <table>
      <thead><tr><th>Page</th><th>Path</th><th>Internal Links</th><th>Status</th><th>Links Found</th></tr></thead>
      <tbody>
      <?php foreach ($report as $r): ?>
      <tr>
        <td><?= h($r['name']) ?></td>
        <td class="td-path"><?= h($r['path']) ?></td>
        <td>
          <div style="display:flex;align-items:center;gap:10px">
            <span style="font-weight:700;font-size:15px;color:<?= $r['count']<3?'var(--red)':($r['count']<7?'var(--gold)':'var(--teal)') ?>"><?= $r['count'] ?></span>
            <div style="flex:1;height:6px;background:var(--border);border-radius:3px;max-width:80px;overflow:hidden">
              <div style="height:100%;width:<?= min($r['count']*10,100) ?>%;background:<?= $r['count']<3?'var(--red)':($r['count']<7?'var(--gold)':'var(--teal)') ?>;border-radius:3px"></div>
            </div>
          </div>
        </td>
        <td>
          <?php if ($r['count'] < 3): ?>
            <span class="badge badge-red">Needs links</span>
          <?php elseif ($r['count'] < 7): ?>
            <span class="badge badge-gold">OK</span>
          <?php else: ?>
            <span class="badge badge-green">Strong</span>
          <?php endif ?>
        </td>
        <td>
          <details style="cursor:pointer">
            <summary style="font-size:12px;color:var(--teal);cursor:pointer">Show links</summary>
            <ul style="margin-top:6px;padding-left:16px">
              <?php foreach ($r['links'] as $lnk): ?>
              <li style="font-size:11.5px;color:var(--muted);font-family:monospace"><?= h($lnk) ?></li>
              <?php endforeach ?>
            </ul>
          </details>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
</div>

</div>
<?php hc_foot(); ?>
