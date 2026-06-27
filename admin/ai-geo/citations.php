<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';
    if ($action === 'add') {
        hc_q("INSERT INTO hc_citations (source_name,url,anchor_text,found_date,notes) VALUES (?,?,?,?,?)",
            [trim($_POST['source_name']??''), trim($_POST['url']??''), trim($_POST['anchor_text']??''),
             $_POST['found_date'] ?: null, trim($_POST['notes']??'')]);
        hc_flash('Citation logged.');
    }
    if ($action === 'delete') {
        hc_q("DELETE FROM hc_citations WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('Citation deleted.');
    }
    header('Location: /admin/ai-geo/citations.php');
    exit;
}

$citations = hc_all("SELECT * FROM hc_citations ORDER BY found_date DESC, created_at DESC");

hc_head('Citation Tracker');
hc_topbar('Citation Tracker', '<a href="/admin/">Admin</a> › AI / GEO Panel › Citations');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Citation Tracker</h1><div class="sub">Log every place Homecare Creators is mentioned online — builds your authority signal for AI engines and local SEO.</div></div>
</div>

<div class="card">
  <div class="card-title" style="margin-bottom:16px">Log a Citation</div>
  <form method="POST">
    <input type="hidden" name="action" value="add">
    <div class="form-grid">
      <div class="form-group">
        <label>Source Name</label>
        <input type="text" name="source_name" placeholder="e.g. Google Business Profile, Yelp, HCAOA.org" required>
      </div>
      <div class="form-group">
        <label>URL to Citation</label>
        <input type="url" name="url" placeholder="https://...">
      </div>
      <div class="form-group">
        <label>Anchor Text or Context</label>
        <input type="text" name="anchor_text" placeholder="Text that links to you or mentions your business">
      </div>
      <div class="form-group">
        <label>Date Found</label>
        <input type="date" name="found_date" value="<?= date('Y-m-d') ?>">
      </div>
    </div>
    <div class="form-group">
      <label>Notes</label>
      <textarea name="notes" rows="2" placeholder="Additional context about this citation"></textarea>
    </div>
    <button class="btn btn-primary" type="submit">Log Citation</button>
  </form>
</div>

<div class="card">
  <div class="card-header">
    <div class="card-title">Citations Log (<?= count($citations) ?>)</div>
  </div>
  <?php if ($citations): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Source</th><th>Anchor / Context</th><th>URL</th><th>Date</th><th>Notes</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($citations as $c): ?>
      <tr>
        <td><strong><?= h($c['source_name']) ?></strong></td>
        <td style="font-size:12.5px"><?= h($c['anchor_text'] ?: '—') ?></td>
        <td style="font-size:12px"><?php if($c['url']): ?><a href="<?= h($c['url']) ?>" target="_blank" style="color:var(--teal)">View ↗</a><?php else: ?>—<?php endif ?></td>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= $c['found_date'] ? date('M j, Y',strtotime($c['found_date'])) : '—' ?></td>
        <td style="font-size:12px;color:var(--muted)"><?= h(substr($c['notes']??'',0,60)) ?></td>
        <td class="td-actions">
          <form method="POST" style="display:inline">
            <input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $c['id'] ?>">
            <button class="btn btn-ghost btn-sm danger" type="submit" data-confirm="Delete this citation?">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state"><p>No citations logged yet. Start tracking your mentions above.</p></div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
