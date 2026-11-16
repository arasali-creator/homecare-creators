<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/esign.php';
hc_require_auth();
hc_es_install();

// ── Upload a new contract ────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['action'] ?? '') === 'upload') {
    $file  = $_FILES['pdf'] ?? null;
    $title = trim($_POST['title'] ?? '');
    $err   = '';
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) {
        $err = ($file && in_array($file['error'], [UPLOAD_ERR_INI_SIZE, UPLOAD_ERR_FORM_SIZE], true))
            ? 'That PDF is larger than the server allows (' . ini_get('upload_max_filesize') . ').'
            : 'Please choose a PDF to upload.';
    } else {
        $stored = hc_es_save_pdf((string)file_get_contents($file['tmp_name']));
        if ($stored[0] === '!') {
            $err = substr($stored, 1);
        } else {
            $orig  = mb_substr(basename((string)$file['name']), 0, 200);
            $title = mb_substr($title ?: preg_replace('/\.pdf$/i', '', $orig), 0, 250) ?: 'Contract';
            $path  = hc_es_path($stored);
            hc_q("INSERT INTO hc_contracts (title, token, status, original_file, original_name, original_sha256, fields, sender_name, sender_email)
                  VALUES (?,?,?,?,?,?,?,?,?)",
                [$title, bin2hex(random_bytes(24)), 'draft', $stored, $orig, hash_file('sha256', $path), '[]',
                 hc_setting('site_name', 'Homecare Creators'), hc_es_default_sender_email()]);
            header('Location: /admin/contracts/edit.php?id=' . (int)hc_db()->lastInsertId());
            exit;
        }
    }
    hc_flash($err, 'error');
    header('Location: /admin/contracts/');
    exit;
}

// ── Void / delete ────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($_POST['action'] ?? '', ['void', 'delete'], true)) {
    $c = hc_one("SELECT * FROM hc_contracts WHERE id=?", [(int)($_POST['id'] ?? 0)]);
    if ($c && $_POST['action'] === 'void' && $c['status'] === 'sent') {
        hc_q("UPDATE hc_contracts SET status='void' WHERE id=?", [$c['id']]);
        hc_flash('Contract voided. The signing link no longer works.');
    } elseif ($c && $_POST['action'] === 'delete') {
        foreach ([$c['original_file'], $c['signed_file']] as $f) { if ($p = hc_es_path($f)) @unlink($p); }
        hc_q("DELETE FROM hc_contracts WHERE id=?", [$c['id']]);
        hc_flash('Contract deleted.');
    }
    header('Location: /admin/contracts/' . (isset($_GET['status']) ? '?status=' . urlencode($_GET['status']) : ''));
    exit;
}

$filter = $_GET['status'] ?? 'all';
$labels = ['all' => 'All', 'draft' => 'Draft', 'sent' => 'Awaiting signature', 'signed' => 'Signed', 'void' => 'Voided'];
if (!isset($labels[$filter])) $filter = 'all';
$rows = $filter === 'all'
    ? hc_all("SELECT * FROM hc_contracts ORDER BY created_at DESC")
    : hc_all("SELECT * FROM hc_contracts WHERE status=? ORDER BY created_at DESC", [$filter]);
$counts = array_fill_keys(array_keys($labels), 0);
foreach (hc_all("SELECT status, COUNT(*) c FROM hc_contracts GROUP BY status") as $r) {
    $counts[$r['status']] = (int)$r['c'];
    $counts['all'] += (int)$r['c'];
}
$storage_ok = (bool)hc_es_dir();

hc_head('Contracts');
hc_topbar('Contracts', '<a href="/admin/">Admin</a> › Contracts');
?>
<div class="page-content">
<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Contracts &amp; E-Signatures</h1><div class="sub">Upload a PDF, place signature fields, then sign it yourself or send a private signing link.</div></div>
</div>

<?php if (!$storage_ok): ?>
<div class="alert alert-error">Contract storage isn't writable. On the server, run:
  <code>mkdir -p <?= h(dirname(SITE_ROOT)) ?>/hc-private/contracts &amp;&amp; chown -R homecarecreators:homecarecreators <?= h(dirname(SITE_ROOT)) ?>/hc-private</code></div>
<?php endif ?>

<div class="card">
  <div class="card-header"><div class="card-title">New contract</div></div>
  <form method="post" enctype="multipart/form-data" style="display:flex;gap:12px;align-items:flex-end;flex-wrap:wrap">
    <input type="hidden" name="action" value="upload">
    <div class="form-group" style="flex:1;min-width:220px;margin:0">
      <label for="title">Title <span>(optional)</span></label>
      <input type="text" id="title" name="title" maxlength="250" placeholder="e.g. Website Design Agreement — Sunshine Home Care">
    </div>
    <div class="form-group" style="flex:1;min-width:220px;margin:0">
      <label for="pdf">PDF file <span>(max 25 MB)</span></label>
      <input type="file" id="pdf" name="pdf" accept="application/pdf,.pdf" required style="font-size:13px">
    </div>
    <button class="btn btn-primary" type="submit">Upload &amp; place fields</button>
  </form>
</div>

<div style="display:flex;gap:8px;flex-wrap:wrap;margin-bottom:16px">
  <?php foreach ($labels as $s => $label): ?>
  <a href="?status=<?= $s ?>" class="btn btn-sm <?= $filter === $s ? 'btn-primary' : 'btn-secondary' ?>"><?= $label ?> <span style="opacity:.7">(<?= $counts[$s] ?? 0 ?>)</span></a>
  <?php endforeach ?>
</div>

<div class="card">
<?php if ($rows): ?>
  <div class="table-wrap">
  <table>
    <thead><tr><th>Contract</th><th>Signer</th><th>Status</th><th>Updated</th><th></th></tr></thead>
    <tbody>
    <?php foreach ($rows as $c): ?>
    <tr>
      <td><a href="/admin/contracts/edit.php?id=<?= $c['id'] ?>"><strong><?= h($c['title']) ?></strong></a>
        <div style="font-size:11.5px;color:var(--muted)"><?= h($c['original_name']) ?></div></td>
      <td><?= $c['signer_name'] ? h($c['signer_name']) . '<div style="font-size:11.5px;color:var(--muted)">' . h($c['signer_email']) . '</div>' : '<span style="color:var(--muted)">—</span>' ?></td>
      <td><?= hc_es_status_badge($c['status']) ?>
        <?php if ($c['status'] === 'sent'): ?><div style="font-size:11px;color:var(--muted);margin-top:3px"><?= $c['viewed_at'] ? 'Opened ' . date('M j, g:i A', strtotime($c['viewed_at'])) : 'Not opened yet' ?></div><?php endif ?>
      </td>
      <td style="font-size:12.5px;white-space:nowrap"><?= date('M j, Y', strtotime($c['signed_at'] ?: ($c['sent_at'] ?: $c['created_at']))) ?></td>
      <td class="td-actions" style="white-space:nowrap">
        <a href="/admin/contracts/edit.php?id=<?= $c['id'] ?>"><?= $c['status'] === 'signed' ? 'View' : 'Edit' ?></a>
        <?php if ($c['status'] === 'sent'): ?><a href="#" data-copy="<?= h(hc_es_sign_url($c)) ?>">Copy link</a><?php endif ?>
        <?php if ($c['status'] === 'signed'): ?><a href="/admin/contracts/file.php?id=<?= $c['id'] ?>&amp;kind=signed&amp;dl=1">Download</a><?php endif ?>
        <?php if ($c['status'] === 'sent'): ?>
        <form method="post" style="display:inline" onsubmit="return confirm('Void this contract? The signing link will stop working.')"><input type="hidden" name="action" value="void"><input type="hidden" name="id" value="<?= $c['id'] ?>"><button class="btn-ghost" style="background:none;border:0;color:var(--muted);cursor:pointer;font-size:13px;padding:0">Void</button></form>
        <?php endif ?>
        <form method="post" style="display:inline" onsubmit="return confirm('Delete “<?= h(addslashes($c['title'])) ?>” and its PDF files permanently?')"><input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $c['id'] ?>"><button class="danger" style="background:none;border:0;color:var(--red);cursor:pointer;font-size:13px;padding:0">Delete</button></form>
      </td>
    </tr>
    <?php endforeach ?>
    </tbody>
  </table>
  </div>
<?php else: ?>
  <div class="empty-state">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/><path d="M8 17c1.5-2 2.5-2 3.5 0s2 2 3.5-1"/></svg>
    <p><?= $filter === 'all' ? 'No contracts yet. Upload a PDF above to get started.' : 'No contracts with this status.' ?></p>
  </div>
<?php endif ?>
</div>

</div>
<script>
document.querySelectorAll('[data-copy]').forEach(function (a) {
  a.addEventListener('click', function (e) {
    e.preventDefault();
    navigator.clipboard.writeText(a.dataset.copy).then(function () { var t = a.textContent; a.textContent = 'Copied!'; setTimeout(function () { a.textContent = t; }, 1500); });
  });
});
</script>
<?php hc_foot(); ?>
