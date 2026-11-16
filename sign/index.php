<?php
// Public signing page — reached only through the private link (?t=TOKEN) created in /admin/contracts/.
require_once dirname(__DIR__) . '/admin/config.php';
require_once dirname(__DIR__) . '/admin/includes/db.php';
require_once dirname(__DIR__) . '/admin/includes/functions.php';
require_once dirname(__DIR__) . '/admin/includes/esign.php';

header('Cache-Control: private, no-store, max-age=0');
header('X-Robots-Tag: noindex, nofollow');
header('Referrer-Policy: no-referrer');

$token = (string)($_GET['t'] ?? $_POST['t'] ?? '');
$code  = explode('&', (string)($_SERVER['QUERY_STRING'] ?? ''))[0]; // ignore ?CODE&fbclid=… style extras
if (preg_match('/^[a-f0-9]{48}$/', $token))         $c = hc_one("SELECT * FROM hc_contracts WHERE token=?", [$token]);
elseif (preg_match('/^[A-Za-z0-9]{10}$/', $code))   $c = hc_one("SELECT * FROM hc_contracts WHERE BINARY code=?", [$code]);
else                                                $c = null;
if ($c && $c['status'] === 'draft') $c = null;
$ip = trim(explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'] ?? '')[0]) ?: ($_SERVER['REMOTE_ADDR'] ?? '');

// ── Submit the signed document ──────────────────────────────────────────────
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    $fail = function (string $msg, int $code = 400) { http_response_code($code); echo json_encode(['ok' => false, 'error' => $msg]); exit; };
    if (!$c) $fail('This signing link is not valid.', 404);
    if ($c['status'] === 'signed') $fail('This document has already been signed.', 409);
    if ($c['status'] !== 'sent') $fail('This document is no longer available for signing.', 410);
    if (empty($_POST['consent'])) $fail('Please agree to sign electronically.');

    // Merge the signer's values into the saved field layout (the layout itself can't be changed here)
    $posted = json_decode((string)($_POST['values'] ?? '{}'), true);
    $fields = hc_es_fields($c);
    foreach ($fields as &$f) {
        if ($f['party'] !== 'signer') continue;
        $f['value'] = hc_es_clean_value($f['type'], is_array($posted) ? ($posted[$f['id']] ?? '') : '');
        if ($f['value'] === '') $fail('Please complete every required field before finishing.');
    }
    unset($f);

    $file = $_FILES['pdf'] ?? null;
    if (!$file || $file['error'] !== UPLOAD_ERR_OK) $fail('The signed document did not upload. Please try again.');
    $bytes  = (string)file_get_contents($file['tmp_name']);
    $stored = hc_es_save_pdf($bytes, '-signed');
    if ($stored[0] === '!') $fail(substr($stored, 1), 500);

    $ua  = mb_substr($_SERVER['HTTP_USER_AGENT'] ?? '', 0, 500);
    $upd = hc_q("UPDATE hc_contracts SET status='signed', signed_file=?, signed_sha256=?, fields=?, signed_at=NOW(), signer_ip=?, signer_ua=? WHERE id=? AND status='sent'",
        [$stored, hash('sha256', $bytes), json_encode($fields, JSON_UNESCAPED_SLASHES), $ip, $ua, $c['id']]);
    if ($upd->rowCount() !== 1) { @unlink(hc_es_path($stored) ?? ''); $fail('This document has already been signed.', 409); }

    $c = hc_one("SELECT * FROM hc_contracts WHERE id=?", [$c['id']]);
    $status = hc_es_send_completed($c, $bytes);
    hc_q("UPDATE hc_contracts SET mail_status=? WHERE id=?", [mb_substr($status, 0, 500), $c['id']]);
    echo json_encode(['ok' => true, 'emailed' => !str_contains($status, 'signer FAILED'), 'pay' => (string)($c['payment_url'] ?? '')]);
    exit;
}

if ($c && $c['status'] === 'sent' && !$c['viewed_at']) hc_q("UPDATE hc_contracts SET viewed_at=NOW() WHERE id=? AND viewed_at IS NULL", [$c['id']]);

$brand  = hc_setting('site_name', 'Homecare Creators');
$fields = $c ? hc_es_fields($c) : [];
$ready  = $c && $c['status'] === 'sent';
if ($ready) {
    foreach ($fields as &$f) { if ($f['party'] === 'signer') $f['value'] = ''; }
    unset($f);
}
?><!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<meta name="robots" content="noindex,nofollow">
<title><?= $c ? h($c['title']) . ' — Sign' : 'Signing link' ?> | <?= h($brand) ?></title>
<link rel="icon" href="/favicon.ico">
<link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Caveat:wght@500&family=Dancing+Script:wght@500&family=Great+Vibes&family=Plus+Jakarta+Sans:wght@500;700;800&display=swap">
<link rel="stylesheet" href="/sign/esign.css?v=1">
<style>
*{box-sizing:border-box;margin:0;padding:0}
body{font-family:'Plus Jakarta Sans',-apple-system,BlinkMacSystemFont,'Segoe UI',Roboto,sans-serif;background:#eef0f2;color:#111827;font-size:15px;line-height:1.5}
.bar{background:#0a2e1e;color:#fff;position:sticky;top:0;z-index:50;box-shadow:0 2px 10px rgba(0,0,0,.15)}
.bar-in{max-width:960px;margin:0 auto;padding:12px 16px;display:flex;align-items:center;gap:14px;flex-wrap:wrap}
.brand{font-weight:800;letter-spacing:.2px;white-space:nowrap}
.doc-title{flex:1;min-width:0;font-size:13.5px;color:rgba(255,255,255,.75);white-space:nowrap;overflow:hidden;text-overflow:ellipsis}
.progress{font-size:13px;color:rgba(255,255,255,.85);white-space:nowrap}
.btn{border:0;border-radius:8px;padding:10px 18px;font:700 14px 'Plus Jakarta Sans',sans-serif;cursor:pointer;background:#1d9e75;color:#fff;text-decoration:none;display:inline-block}
.btn:hover{background:#178a64}
.btn:disabled{opacity:.6;cursor:default}
.btn-light{background:#fff;color:#0a2e1e}
.btn-light:hover{background:#f3f4f6}
main{max-width:960px;margin:0 auto;padding:20px 16px 60px}
.intro{background:#fff;border-radius:10px;padding:16px 18px;margin-bottom:18px;border:1px solid rgba(0,0,0,.07);font-size:14px}
.intro .msg{margin-top:8px;padding:10px 12px;background:#f8f5ef;border-radius:8px;white-space:pre-line}
.finish{background:#fff;border-radius:10px;padding:18px;margin-top:8px;border:1px solid rgba(0,0,0,.07)}
.finish label{display:flex;gap:10px;align-items:flex-start;font-size:13.5px;margin-bottom:14px;cursor:pointer}
.finish input{margin-top:3px;width:17px;height:17px;flex-shrink:0;accent-color:#1d9e75}
.err{color:#b91c1c;font-size:13.5px;margin-top:10px}
.state{max-width:520px;margin:12vh auto;background:#fff;border-radius:12px;padding:34px 28px;text-align:center;border:1px solid rgba(0,0,0,.07)}
.state h1{font-size:22px;color:#0a2e1e;margin-bottom:10px}
.state p{color:#4b5563;margin-bottom:18px}
.state .ic{width:54px;height:54px;border-radius:50%;margin:0 auto 16px;display:flex;align-items:center;justify-content:center;background:#d1fae5;color:#065f46;font-size:28px}
.foot{text-align:center;font-size:12px;color:#6b7280;margin-top:26px}
@media(max-width:600px){.doc-title{display:none}}
</style>
</head>
<body>
<?php if (!$ready): ?>
  <div class="bar"><div class="bar-in"><span class="brand"><?= h($brand) ?></span></div></div>
  <div class="state">
  <?php if (!$c): ?>
    <div class="ic" style="background:#fee2e2;color:#991b1b">!</div><h1>This link isn't valid</h1>
    <p>The signing link may be incomplete or out of date. Please check the link or ask the sender for a new one.</p>
  <?php elseif ($c['status'] === 'void'): ?>
    <div class="ic" style="background:#fee2e2;color:#991b1b">!</div><h1>This document was cancelled</h1>
    <p>The sender has cancelled “<?= h($c['title']) ?>”, so it can no longer be signed.</p>
  <?php else: ?>
    <div class="ic">✓</div><h1>Already signed</h1>
    <p>“<?= h($c['title']) ?>” was signed on <?= h(date('F j, Y', strtotime($c['signed_at']))) ?>. A copy was emailed to both parties.</p>
    <?php if (!empty($c['payment_url'])): ?>
    <a class="btn" href="<?= h($c['payment_url']) ?>" rel="noopener">Continue to payment</a>
    <div style="margin-top:12px"><a href="/sign/file.php?t=<?= h($c['token']) ?>&amp;dl=1" style="color:#1d9e75;font-weight:700;font-size:14px">Download signed copy</a></div>
    <?php else: ?>
    <a class="btn" href="/sign/file.php?t=<?= h($c['token']) ?>&amp;dl=1">Download signed copy</a>
    <?php endif ?>
  <?php endif ?>
  </div>
<?php else: ?>
  <div class="bar"><div class="bar-in">
    <span class="brand"><?= h($brand) ?></span>
    <span class="doc-title"><?= h($c['title']) ?></span>
    <span class="progress" id="progress"></span>
    <button class="btn btn-light" type="button" id="nextBtn">Start</button>
  </div></div>
  <main>
    <div class="intro">
      <strong><?= h($c['sender_name'] ?: $brand) ?></strong> sent you <strong><?= h($c['title']) ?></strong> to sign, <?= h($c['signer_name']) ?>.
      Click each <span style="color:#2563eb;font-weight:700">blue box</span> to fill it in, then click <strong>Finish</strong> at the bottom.
      <?php if (trim((string)$c['message']) !== ''): ?><div class="msg"><?= h($c['message']) ?></div><?php endif ?>
    </div>
    <div id="esDoc" class="es-doc"><div class="es-loading">Loading document…</div></div>
    <div class="finish">
      <label><input type="checkbox" id="consent"> <span>I agree to sign this document electronically, and I understand my electronic signature is as legally binding as a handwritten one.</span></label>
      <button class="btn" type="button" id="finishBtn">Finish &amp; sign</button>
      <div class="err" id="err" hidden></div>
    </div>
    <p class="foot">Secure signing by <?= h($brand) ?> · Your IP address (<?= h($ip) ?>) and the time of signing are recorded.</p>
  </main>

  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.min.js"></script>
  <script src="https://unpkg.com/pdf-lib@1.17.1/dist/pdf-lib.min.js"></script>
  <script src="/sign/esign.js?v=1"></script>
  <script>
  (function () {
    var C = <?= json_encode([
        'token'  => $c['token'],
        'fields' => $fields,
        'signer' => $c['signer_name'],
        'cert'   => [
            'brand' => $brand,
            'rows'  => [
                ['Document', $c['title']],
                ['Document ID', 'HC-' . str_pad((string)$c['id'], 5, '0', STR_PAD_LEFT)],
                ['Original file SHA-256', (string)$c['original_sha256']],
                '-',
                ['Sent by', trim($c['sender_name'] . ($c['sender_email'] ? ' <' . $c['sender_email'] . '>' : ''))],
                ['Sent on', $c['sent_at'] ? date('M j, Y g:i A T', strtotime($c['sent_at'])) : ''],
                '-',
                ['Signed by', $c['signer_name'] . ' <' . $c['signer_email'] . '>'],
                ['Signer IP address', $ip],
            ],
        ],
        'file' => hc_es_download_name($c, true),
    ], JSON_UNESCAPED_SLASHES | JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT) ?>;

    var FIELDS = C.fields, board = null, pdfBytes = null;
    var progress = document.getElementById('progress'), nextBtn = document.getElementById('nextBtn');
    var errEl = document.getElementById('err'), finishBtn = document.getElementById('finishBtn');
    var mine = FIELDS.filter(function (f) { return f.party === 'signer'; });
    mine.forEach(function (f) {
      if (f.type === 'date') f.value = ESign.today();
      if (f.type === 'name') f.value = C.signer || '';
    });

    function update() {
      var done = mine.filter(function (f) { return String(f.value || '').trim(); }).length;
      progress.textContent = done + ' of ' + mine.length + ' fields done';
      nextBtn.textContent = done === mine.length ? 'Finish' : (done ? 'Next field' : 'Start');
    }
    function showErr(m) { errEl.textContent = m; errEl.hidden = !m; }

    nextBtn.onclick = function () {
      if (!board) return;
      var left = board.missing('signer');
      if (!left.length) { document.querySelector('.finish').scrollIntoView({ behavior: 'smooth', block: 'center' }); return; }
      board.focusField(left[0]);
      if (left[0].type === 'signature') setTimeout(function () { board.fillSignature(left[0]); }, 450);
    };

    ESign.loadPdf('/sign/file.php?t=' + C.token).then(function (r) {
      pdfBytes = r.bytes;
      return ESign.renderPages(r.doc, document.getElementById('esDoc'));
    }).then(function (pages) {
      board = new ESign.Board(pages, FIELDS, { mode: 'sign', onchange: function () { showErr(''); update(); }, defaultName: function () { return C.signer; } });
      update();
    }).catch(function (e) {
      document.getElementById('esDoc').innerHTML = '<div class="intro" style="color:#b91c1c">Sorry, the document could not be loaded. Please refresh the page. (' + String(e.message || e).replace(/</g, '&lt;') + ')</div>';
    });

    finishBtn.onclick = async function () {
      if (!board) return;
      var left = board.missing('signer');
      if (left.length) { showErr('Please complete all ' + left.length + ' remaining field' + (left.length > 1 ? 's' : '') + '.'); board.focusField(left[0]); return; }
      if (!document.getElementById('consent').checked) { showErr('Please tick the box to agree to sign electronically.'); return; }
      showErr(''); finishBtn.disabled = true; finishBtn.textContent = 'Signing…';
      try {
        // No certificate page is appended; the audit trail (IP, time, device, hashes) is kept in the admin.
        var out = await ESign.stamp(pdfBytes, FIELDS, null);
        var values = {};
        mine.forEach(function (f) { values[f.id] = f.value; });
        var fd = new FormData();
        fd.append('t', C.token);
        fd.append('consent', '1');
        fd.append('values', JSON.stringify(values));
        fd.append('pdf', new Blob([out], { type: 'application/pdf' }), 'signed.pdf');
        var res = await fetch('/sign/', { method: 'POST', body: fd, credentials: 'same-origin' });
        var j = await res.json().catch(function () { return { ok: false, error: 'Server error (' + res.status + ').' }; });
        if (!j.ok) throw new Error(j.error || 'Something went wrong.');
        var url = URL.createObjectURL(new Blob([out], { type: 'application/pdf' }));
        document.body.innerHTML = '<div class="bar"><div class="bar-in"><span class="brand"></span></div></div><div class="state"><div class="ic">✓</div><h1>You’re all set!</h1><p></p><a class="btn" download></a></div>';
        document.querySelector('.brand').textContent = C.cert.brand;
        document.querySelector('.state p').textContent = j.emailed ? 'Your document is signed. We’ve emailed a copy to you and to the sender.' : 'Your document is signed. Please download your copy below.';
        var a = document.querySelector('.state a'); a.href = url; a.download = C.file; a.textContent = 'Download signed copy';
        window.scrollTo(0, 0);
        if (j.pay) {
          // Payment step: show a button and send them there automatically
          var p = document.querySelector('.state p');
          p.textContent = 'Your document is signed' + (j.emailed ? ' and a copy has been emailed to you' : '') + '. Taking you to payment in 4 seconds…';
          var go = document.createElement('a');
          go.className = 'btn'; go.href = j.pay; go.rel = 'noopener'; go.textContent = 'Continue to payment';
          a.parentNode.insertBefore(go, a);
          a.className = ''; a.style.cssText = 'display:block;margin-top:12px;color:#1d9e75;font-weight:700;font-size:14px';
          var n = 4, timer = setInterval(function () {
            n--;
            if (n > 0) p.textContent = p.textContent.replace(/in \d+ seconds?/, 'in ' + n + ' second' + (n === 1 ? '' : 's'));
            else { clearInterval(timer); window.location.href = j.pay; }
          }, 1000);
        }
      } catch (e) {
        showErr(e.message || String(e));
        finishBtn.disabled = false; finishBtn.textContent = 'Finish & sign';
      }
    };
  })();
  </script>
<?php endif ?>
</body>
</html>
