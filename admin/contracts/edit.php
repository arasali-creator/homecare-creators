<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
require_once dirname(__DIR__) . '/includes/esign.php';
hc_require_auth();
hc_es_install();

$id = (int)($_GET['id'] ?? 0);
$c  = hc_one("SELECT * FROM hc_contracts WHERE id=?", [$id]);
if (!$c) { hc_flash('Contract not found.', 'error'); header('Location: /admin/contracts/'); exit; }

// ── Update payment link only (allowed even after signing) ───────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && ($_POST['do'] ?? '') === 'payment') {
    $raw = trim($_POST['payment_url'] ?? '');
    $url = hc_es_clean_url($raw);
    if ($raw !== '' && $url === '') {
        hc_flash('That payment link is not a valid web address.', 'error');
    } else {
        hc_q("UPDATE hc_contracts SET payment_url=? WHERE id=?", [$url ?: null, $id]);
        hc_flash($url ? 'Payment link saved.' : 'Payment link removed.');
    }
    header('Location: /admin/contracts/edit.php?id=' . $id);
    exit;
}

// ── Save / send ──────────────────────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $c['status'] !== 'signed') {
    $do     = $_POST['do'] ?? 'save';
    $fields = hc_es_clean_fields(json_decode((string)($_POST['fields_json'] ?? '[]'), true));
    foreach ($fields as &$f) { if ($f['party'] === 'signer') $f['value'] = ''; }
    unset($f);
    $data = [
        'title'        => mb_substr(trim($_POST['title'] ?? ''), 0, 250) ?: $c['title'],
        'signer_name'  => mb_substr(trim($_POST['signer_name'] ?? ''), 0, 250),
        'signer_email' => mb_substr(trim($_POST['signer_email'] ?? ''), 0, 250),
        'sender_name'  => mb_substr(trim($_POST['sender_name'] ?? ''), 0, 250),
        'sender_email' => mb_substr(trim($_POST['sender_email'] ?? ''), 0, 250),
        'message'      => mb_substr(trim($_POST['message'] ?? ''), 0, 2000),
        'payment_url'  => hc_es_clean_url((string)($_POST['payment_url'] ?? '')),
    ];
    $payBad = trim($_POST['payment_url'] ?? '') !== '' && $data['payment_url'] === '';
    hc_q("UPDATE hc_contracts SET title=?, signer_name=?, signer_email=?, sender_name=?, sender_email=?, message=?, payment_url=?, fields=? WHERE id=?",
        [$data['title'], $data['signer_name'], $data['signer_email'], $data['sender_name'], $data['sender_email'], $data['message'], $data['payment_url'] ?: null,
         json_encode($fields, JSON_UNESCAPED_SLASHES), $id]);

    if (in_array($do, ['link', 'email'], true)) {
        $errors = [];
        if ($payBad) $errors[] = 'a valid payment link (or leave it blank)';
        if ($data['signer_name'] === '') $errors[] = "the signer's name";
        if (!filter_var($data['signer_email'], FILTER_VALIDATE_EMAIL)) $errors[] = "a valid signer email";
        if ($data['sender_email'] !== '' && !filter_var($data['sender_email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'a valid email for you (or leave it blank)';
        if (!array_filter($fields, fn($f) => $f['party'] === 'signer')) $errors[] = 'at least one field for the signer';
        if (array_filter($fields, fn($f) => $f['party'] === 'sender' && $f['value'] === '')) $errors[] = 'your own fields filled in (green boxes)';
        if ($errors) {
            hc_flash('Saved, but not sent yet. Please add ' . implode(', ', $errors) . '.', 'error');
        } else {
            if ($c['status'] === 'void') hc_q("UPDATE hc_contracts SET token=?, code=? WHERE id=?", [bin2hex(random_bytes(24)), hc_es_new_code(), $id]);
            hc_q("UPDATE hc_contracts SET sent_at=COALESCE(IF(status='sent', sent_at, NULL), NOW()), status='sent' WHERE id=?", [$id]);
            $c = hc_one("SELECT * FROM hc_contracts WHERE id=?", [$id]);
            if ($do === 'email') {
                $err = hc_es_send_invite($c);
                hc_q("UPDATE hc_contracts SET mail_status=? WHERE id=?", [$err ?: ('Signing link emailed to ' . $c['signer_email'] . ' on ' . date('M j, g:i A')), $id]);
                hc_flash($err ? "The link is ready, but the email failed: $err" : 'Signing link emailed to ' . $c['signer_email'] . '.', $err ? 'error' : 'success');
            } else {
                hc_flash('Signing link is ready. Copy it below and send it to ' . $c['signer_name'] . '.');
            }
        }
    } else {
        hc_flash($payBad ? 'Saved, but the payment link is not a valid web address, so it was cleared.' : 'Saved.', $payBad ? 'error' : 'success');
    }
    header('Location: /admin/contracts/edit.php?id=' . $id);
    exit;
}

$fields  = hc_es_fields($c);
$signed  = $c['status'] === 'signed';
$signUrl = hc_es_sign_url($c);

hc_head($c['title']);
hc_topbar($c['title'], '<a href="/admin/">Admin</a> › <a href="/admin/contracts/">Contracts</a> › ' . h($c['title']));
?>
<link rel="stylesheet" href="/sign/esign.css?v=1">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&family=Dancing+Script:wght@500&family=Great+Vibes&display=swap">
<style>
.esa-wrap{display:grid;grid-template-columns:minmax(0,1fr) 330px;gap:22px;align-items:start}
.esa-tools{position:sticky;top:54px;z-index:20;background:var(--bg);padding:10px 0 12px;display:flex;flex-wrap:wrap;gap:8px;align-items:center}
.esa-tools .grp{display:flex;gap:6px;align-items:center;background:#fff;border:1px solid var(--border);border-radius:9px;padding:5px 6px}
.esa-tools .lbl{font-size:11px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.6px;padding:0 4px}
.esa-tool{border:1px solid transparent;background:#f3f4f6;border-radius:7px;padding:7px 11px;font-size:13px;font-weight:600;cursor:pointer;display:inline-flex;gap:6px;align-items:center;color:var(--text)}
.esa-tool:hover{background:#e5e7eb}
.esa-tool.on{background:var(--forest);color:#fff}
.esa-tool svg{width:15px;height:15px}
.esa-party button{border:0;background:none;padding:7px 11px;border-radius:7px;font-size:13px;font-weight:600;cursor:pointer;color:var(--muted)}
.esa-party button.on[data-party=signer]{background:#dbeafe;color:#1e40af}
.esa-party button.on[data-party=sender]{background:#d1fae5;color:#065f46}
.esa-hint{font-size:12px;color:var(--muted);flex-basis:100%}
.esa-sel{font-size:12.5px;display:none;gap:6px;align-items:center}
.esa-sel.show{display:flex}
.esa-side{position:sticky;top:70px}
.esa-side .card{padding:18px}
.esa-side .form-group{margin-bottom:12px}
.esa-side textarea{min-height:70px}
.esa-btns{display:grid;gap:8px}
.esa-btns .btn{justify-content:center}
.esa-link{display:flex;gap:6px;margin-top:6px}
.esa-link input{font-family:monospace;font-size:11.5px}
.esa-stat{font-size:12.5px;color:var(--muted);line-height:1.7}
.esa-stat strong{color:var(--text)}
.esa-legend{display:flex;gap:14px;font-size:12px;color:var(--muted);margin-top:8px}
.esa-legend i{display:inline-block;width:11px;height:11px;border-radius:3px;vertical-align:-1px;margin-right:4px}
.esa-audit{display:grid;grid-template-columns:140px 1fr;gap:6px 12px;font-size:13px}
.esa-audit dt{color:var(--muted);font-size:12px}
.esa-audit dd{word-break:break-all}
@media(max-width:1100px){.esa-wrap{grid-template-columns:1fr}.esa-side{position:static}.esa-tools{top:54px}}
</style>
<div class="page-content">
<?= hc_show_flash() ?>

<?php if ($signed): ?>
<div class="esa-wrap">
  <div><iframe src="/admin/contracts/file.php?id=<?= $id ?>&amp;kind=signed" style="width:100%;height:calc(100vh - 140px);border:1px solid var(--border);border-radius:var(--r);background:#fff" title="Signed contract"></iframe></div>
  <aside class="esa-side">
    <div class="card">
      <div class="card-header"><div class="card-title">Signed</div><?= hc_es_status_badge('signed') ?></div>
      <dl class="esa-audit">
        <dt>Signer</dt><dd><?= h($c['signer_name']) ?><br><span style="color:var(--muted)"><?= h($c['signer_email']) ?></span></dd>
        <dt>Signed at</dt><dd><?= h(date('M j, Y g:i:s A T', strtotime($c['signed_at']))) ?></dd>
        <dt>Sent at</dt><dd><?= $c['sent_at'] ? h(date('M j, Y g:i A', strtotime($c['sent_at']))) : '—' ?></dd>
        <dt>First opened</dt><dd><?= $c['viewed_at'] ? h(date('M j, Y g:i A', strtotime($c['viewed_at']))) : '—' ?></dd>
        <dt>IP address</dt><dd><?= h($c['signer_ip']) ?></dd>
        <dt>Device</dt><dd style="font-size:11.5px;color:var(--muted)"><?= h($c['signer_ua']) ?></dd>
        <dt>Original SHA-256</dt><dd style="font-family:monospace;font-size:11px"><?= h($c['original_sha256']) ?></dd>
        <dt>Signed SHA-256</dt><dd style="font-family:monospace;font-size:11px"><?= h($c['signed_sha256']) ?></dd>
        <dt>Email</dt><dd style="font-size:12px"><?= h($c['mail_status'] ?: '—') ?></dd>
      </dl>
      <div class="divider"></div>
      <form method="post">
        <input type="hidden" name="do" value="payment">
        <div class="form-group" style="margin-bottom:8px"><label for="pay">Payment link</label><input type="url" id="pay" name="payment_url" value="<?= h($c['payment_url'] ?? '') ?>" maxlength="1000" placeholder="https://buy.stripe.com/…"></div>
        <div class="form-hint" style="font-size:11.5px;color:var(--muted);margin-bottom:8px">Shown to the client on their “already signed” page.</div>
        <button class="btn btn-secondary btn-sm" type="submit">Save payment link</button>
      </form>
      <div class="divider"></div>
      <div class="esa-btns">
        <a class="btn btn-primary" href="/admin/contracts/file.php?id=<?= $id ?>&amp;kind=signed&amp;dl=1">Download signed PDF</a>
        <a class="btn btn-secondary" href="/admin/contracts/file.php?id=<?= $id ?>&amp;kind=original" target="_blank">View original</a>
        <a class="btn btn-secondary" href="/admin/contracts/">← All contracts</a>
      </div>
    </div>
  </aside>
</div>

<?php else: ?>
<form method="post" id="esForm" class="esa-wrap">
  <input type="hidden" name="fields_json" id="fieldsJson">
  <div>
    <div class="esa-tools">
      <div class="grp">
        <span class="lbl">Add</span>
        <button type="button" class="esa-tool" data-tool="signature" draggable="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 17c3-4 5-4 6 0s3 3 5-2 4-5 7-1"/><line x1="3" y1="21" x2="21" y2="21"/></svg>Signature</button>
        <button type="button" class="esa-tool" data-tool="name" draggable="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><circle cx="12" cy="8" r="4"/><path d="M4 21c0-4 4-6 8-6s8 2 8 6"/></svg>Name</button>
        <button type="button" class="esa-tool" data-tool="date" draggable="true"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>Date</button>
      </div>
      <div class="grp esa-party">
        <span class="lbl">For</span>
        <button type="button" data-party="signer" class="on">Signer</button>
        <button type="button" data-party="sender">Me</button>
      </div>
      <div class="grp esa-sel" id="selBar">
        <span class="lbl">Selected</span>
        <button type="button" class="esa-tool" id="selSwap">Switch to Me</button>
        <button type="button" class="esa-tool" id="selDel" style="color:var(--red)">Delete</button>
      </div>
      <div class="esa-hint" id="hint">Pick a field, then click on the page where it goes (or drag it onto the page). Drag a box to move it; use its corner to resize.</div>
    </div>
    <div id="esDoc" class="es-doc es-edit"><div class="es-loading">Loading PDF…</div></div>
  </div>

  <aside class="esa-side">
    <div class="card">
      <div class="card-header"><div class="card-title">Contract</div><?= hc_es_status_badge($c['status']) ?></div>
      <div class="form-group"><label for="t">Title</label><input type="text" id="t" name="title" value="<?= h($c['title']) ?>" maxlength="250"></div>
      <div class="form-group"><label for="sn">Signer name</label><input type="text" id="sn" name="signer_name" value="<?= h($c['signer_name']) ?>" maxlength="250" placeholder="Client's full name"></div>
      <div class="form-group"><label for="se">Signer email</label><input type="email" id="se" name="signer_email" value="<?= h($c['signer_email']) ?>" maxlength="250" placeholder="client@agency.com"></div>
      <div class="form-group"><label for="msg">Message <span>(optional, goes in the email)</span></label><textarea id="msg" name="message" maxlength="2000" placeholder="Hi, here's our agreement. Let me know if you have any questions."><?= h($c['message']) ?></textarea></div>
      <div class="form-group"><label for="pay">Payment link <span>(optional)</span></label><input type="url" id="pay" name="payment_url" value="<?= h($c['payment_url'] ?? '') ?>" maxlength="1000" placeholder="https://buy.stripe.com/…">
        <div class="form-hint" style="font-size:11.5px;color:var(--muted);margin-top:4px">After signing, the client goes straight to this link. It's also in their confirmation email.</div></div>
      <details style="margin-bottom:12px"><summary style="font-size:12.5px;font-weight:700;cursor:pointer">Your details (sender)</summary>
        <div class="form-group" style="margin-top:10px"><label for="yn">Your name</label><input type="text" id="yn" name="sender_name" value="<?= h($c['sender_name']) ?>" maxlength="250"></div>
        <div class="form-group"><label for="ye">Your email <span>(gets the signed copy)</span></label><input type="email" id="ye" name="sender_email" value="<?= h($c['sender_email']) ?>" maxlength="250"></div>
      </details>

      <?php if ($c['status'] === 'sent'): ?>
      <div class="alert alert-info" style="display:block;margin-bottom:12px">
        <strong>Signing link</strong> <?= $c['viewed_at'] ? '· opened ' . h(date('M j, g:i A', strtotime($c['viewed_at']))) : '· not opened yet' ?>
        <div class="esa-link"><input type="text" readonly value="<?= h($signUrl) ?>" id="signUrl" onclick="this.select()"><button type="button" class="btn btn-secondary btn-sm" id="copyBtn">Copy</button></div>
        <?php if ($c['mail_status']): ?><div style="font-size:11.5px;margin-top:6px;color:var(--muted)"><?= h($c['mail_status']) ?></div><?php endif ?>
      </div>
      <?php endif ?>

      <div class="esa-btns">
        <button type="submit" name="do" value="email" class="btn btn-primary"><?= $c['status'] === 'sent' ? 'Save & re-send email' : 'Save & email signing link' ?></button>
        <button type="submit" name="do" value="link" class="btn btn-secondary"><?= $c['status'] === 'sent' ? 'Save changes' : 'Save & get link only' ?></button>
        <button type="submit" name="do" value="save" class="btn btn-secondary" <?= $c['status'] === 'sent' ? 'hidden' : '' ?>>Save draft</button>
        <button type="button" class="btn btn-ghost" id="dlBtn">Download signed PDF now</button>
      </div>
      <div class="esa-legend"><span><i style="background:#2563eb"></i>Signer fills</span><span><i style="background:#1d9e75"></i>You fill</span></div>
      <p class="esa-stat" style="margin-top:10px" id="stat"></p>
    </div>
  </aside>
</form>

<script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
<script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
<script src="/sign/esign.js?v=1"></script>
<script>
(function () {
  var FIELDS = <?= json_encode($fields, JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;
  var PDF_URL = '/admin/contracts/file.php?id=<?= $id ?>&kind=original';
  var FILE_NAME = <?= json_encode(hc_es_download_name($c, true), JSON_HEX_TAG) ?>;
  var form = document.getElementById('esForm'), docEl = document.getElementById('esDoc');
  var stat = document.getElementById('stat'), selBar = document.getElementById('selBar'), selSwap = document.getElementById('selSwap');
  var armed = null, party = 'signer', board = null, dirty = false, pdfBytes = null;
  var val = function (id) { return document.getElementById(id).value.trim(); };

  function refresh() {
    var s = FIELDS.filter(function (f) { return f.party === 'signer'; }).length;
    var me = FIELDS.filter(function (f) { return f.party === 'sender'; });
    var empty = me.filter(function (f) { return !f.value; }).length;
    stat.innerHTML = '<strong>' + s + '</strong> field' + (s === 1 ? '' : 's') + ' for the signer · <strong>' + me.length + '</strong> for you' + (empty ? ' (<span style="color:var(--red)">' + empty + ' still empty</span>)' : '');
    var sel = board && board.selected && FIELDS.find(function (f) { return f.id === board.selected; });
    selBar.classList.toggle('show', !!sel);
    if (sel) selSwap.textContent = sel.party === 'signer' ? 'Switch to Me' : 'Switch to Signer';
  }
  function changed() { dirty = true; refresh(); }

  // Tools
  function arm(t) {
    armed = armed === t ? null : t;
    document.querySelectorAll('.esa-tool[data-tool]').forEach(function (b) { b.classList.toggle('on', b.dataset.tool === armed); });
    docEl.classList.toggle('es-arming', !!armed);
  }
  document.querySelectorAll('.esa-tool[data-tool]').forEach(function (b) {
    b.addEventListener('click', function () { arm(b.dataset.tool); });
    b.addEventListener('dragstart', function (e) { e.dataTransfer.setData('text/plain', 'es:' + b.dataset.tool); e.dataTransfer.effectAllowed = 'copy'; });
  });
  document.querySelectorAll('.esa-party button').forEach(function (b) {
    b.addEventListener('click', function () {
      party = b.dataset.party;
      document.querySelectorAll('.esa-party button').forEach(function (x) { x.classList.toggle('on', x === b); });
    });
  });
  selSwap.onclick = function () {
    var f = FIELDS.find(function (x) { return x.id === board.selected; }); if (!f) return;
    board.setParty(f.id, f.party === 'signer' ? 'sender' : 'signer');
    if (f.party === 'sender') prefill(f);
  };
  document.getElementById('selDel').onclick = function () { if (board.selected) { board.remove(board.selected); board.selected = null; refresh(); } };
  document.addEventListener('keydown', function (e) {
    if ((e.key === 'Delete' || e.key === 'Backspace') && board && board.selected && !/INPUT|TEXTAREA/.test(document.activeElement.tagName)) {
      e.preventDefault(); board.remove(board.selected); board.selected = null; refresh();
    }
    if (e.key === 'Escape' && armed) arm(null);
  });

  function prefill(f) {
    if (f.party !== 'sender' || f.value) return;
    if (f.type === 'name') f.value = val('yn');
    if (f.type === 'date') f.value = ESign.today();
    board.paint(f); refresh();
  }
  function placeAt(layer, type, clientX, clientY) {
    var r = layer.getBoundingClientRect();
    var f = board.add(type, party, +layer.dataset.page, (clientX - r.left) / r.width, (clientY - r.top) / r.height);
    if (f) prefill(f);
    if (f && f.party === 'sender' && f.type === 'signature') board.fillSignature(f);
  }

  ESign.loadPdf(PDF_URL).then(function (res) {
    pdfBytes = res.bytes;
    return ESign.renderPages(res.doc, docEl);
  }).then(function (pages) {
    board = new ESign.Board(pages, FIELDS, { mode: 'edit', onchange: changed, defaultName: function () { return val('yn'); } });
    pages.forEach(function (p) {
      p.layer.addEventListener('click', function (e) {
        if (e.target !== p.layer) return;
        if (armed) { placeAt(p.layer, armed, e.clientX, e.clientY); arm(null); }
        else { board.select(null); board.selected = null; refresh(); }
      });
      p.layer.addEventListener('dragover', function (e) { e.preventDefault(); e.dataTransfer.dropEffect = 'copy'; });
      p.layer.addEventListener('drop', function (e) {
        var d = e.dataTransfer.getData('text/plain');
        if (d.indexOf('es:') !== 0) return;
        e.preventDefault(); placeAt(p.layer, d.slice(3), e.clientX, e.clientY);
      });
    });
    var origSelect = board.select.bind(board);
    board.select = function (id) { origSelect(id); refresh(); };
    refresh();
  }).catch(function (err) {
    docEl.innerHTML = '<div class="alert alert-error">' + String(err.message || err).replace(/</g, '&lt;') + '</div>';
  });

  form.addEventListener('submit', function (e) {
    document.getElementById('fieldsJson').value = JSON.stringify(FIELDS);
    var btn = e.submitter;
    if (btn && btn.value !== 'save') {
      var missing = board ? board.missing('sender') : [];
      if (missing.length) { e.preventDefault(); alert('Please fill in your own fields (green) first.'); board.focusField(missing[0]); return; }
      if (!FIELDS.some(function (f) { return f.party === 'signer'; })) { e.preventDefault(); alert('Add at least one field for the signer (choose “For: Signer”, then place a field).'); return; }
    }
    dirty = false;
  });
  window.addEventListener('beforeunload', function (e) { if (dirty) { e.preventDefault(); e.returnValue = ''; } });

  // Self-sign: stamp whatever is filled and download right away
  document.getElementById('dlBtn').addEventListener('click', async function () {
    if (!pdfBytes || !board) return;
    var blankSigner = board.missing('signer').length, blankMe = board.missing('sender').length;
    if (blankMe && !confirm(blankMe + ' of your fields are still empty and will be left blank. Continue?')) return;
    if (blankSigner && !confirm('The ' + blankSigner + ' signer field(s) (blue) will be left blank. To fill them yourself, select each one and click “Switch to Me”. Download anyway?')) return;
    var b = this, t = b.textContent; b.textContent = 'Preparing…'; b.disabled = true;
    try { ESign.download(await ESign.stamp(pdfBytes, FIELDS, null), FILE_NAME); }
    catch (err) { alert('Could not create the PDF: ' + (err.message || err)); }
    b.textContent = t; b.disabled = false;
  });

  var copyBtn = document.getElementById('copyBtn');
  if (copyBtn) copyBtn.onclick = function () {
    navigator.clipboard.writeText(document.getElementById('signUrl').value).then(function () { copyBtn.textContent = 'Copied!'; setTimeout(function () { copyBtn.textContent = 'Copy'; }, 1500); });
  };
})();
</script>
<?php endif ?>
</div>
<?php hc_foot(); ?>
