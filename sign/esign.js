/* Homecare Creators e-sign — shared by the admin contract editor and the public /sign/ page.
 * Needs pdf.js (pdfjsLib) for viewing and pdf-lib (PDFLib) for stamping. */
(function () {
  'use strict';

  var WORKER = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/3.11.174/pdf.worker.min.js';
  var FONTS = ['Dancing Script', 'Great Vibes', 'Caveat'];
  var SIZE_PT = { signature: [170, 46], name: [170, 22], date: [110, 22] };
  var LABEL = { signature: 'Signature', name: 'Name', date: 'Date' };

  function el(tag, cls, text) {
    var e = document.createElement(tag);
    if (cls) e.className = cls;
    if (text != null) e.textContent = text;
    return e;
  }
  function uid() { return 'f' + Math.random().toString(36).slice(2, 10); }
  function today() {
    var d = new Date();
    return String(d.getMonth() + 1).padStart(2, '0') + '/' + String(d.getDate()).padStart(2, '0') + '/' + d.getFullYear();
  }
  function clamp(v, a, b) { return Math.max(a, Math.min(b, v)); }

  /* ── PDF loading & rendering ─────────────────────────────── */

  async function loadPdf(url) {
    var res = await fetch(url, { credentials: 'same-origin', cache: 'no-store' });
    if (!res.ok) throw new Error('Could not load the PDF (HTTP ' + res.status + ').');
    var bytes = new Uint8Array(await res.arrayBuffer());
    pdfjsLib.GlobalWorkerOptions.workerSrc = WORKER;
    var doc = await pdfjsLib.getDocument({ data: bytes.slice() }).promise; // pdf.js detaches its copy
    return { bytes: bytes, doc: doc };
  }

  async function renderPages(doc, container) {
    container.innerHTML = '';
    var pages = [];
    var dpr = Math.min(window.devicePixelRatio || 1, 2);
    var targetW = Math.min(container.clientWidth || 820, 900);
    for (var n = 1; n <= doc.numPages; n++) {
      var page = await doc.getPage(n);
      var vp1 = page.getViewport({ scale: 1 });
      var vp = page.getViewport({ scale: (targetW * dpr * 1.25) / vp1.width });
      var wrap = el('div', 'es-page');
      wrap.style.aspectRatio = vp1.width + ' / ' + vp1.height;
      var canvas = el('canvas');
      canvas.width = Math.floor(vp.width);
      canvas.height = Math.floor(vp.height);
      var layer = el('div', 'es-layer');
      layer.dataset.page = n;
      wrap.appendChild(canvas);
      wrap.appendChild(layer);
      container.appendChild(wrap);
      container.appendChild(el('div', 'es-pagenum', 'Page ' + n + ' of ' + doc.numPages));
      await page.render({ canvasContext: canvas.getContext('2d'), viewport: vp }).promise;
      pages.push({ n: n, wrap: wrap, layer: layer, w: vp1.width, h: vp1.height });
    }
    return pages;
  }

  /* ── Signature dialog (Draw / Type / Upload) ─────────────── */

  function trimCanvas(src) {
    var ctx = src.getContext('2d');
    var w = src.width, h = src.height;
    var data = ctx.getImageData(0, 0, w, h).data;
    var minX = w, minY = h, maxX = -1, maxY = -1;
    for (var y = 0; y < h; y++) for (var x = 0; x < w; x++) {
      if (data[(y * w + x) * 4 + 3] > 10) {
        if (x < minX) minX = x; if (x > maxX) maxX = x;
        if (y < minY) minY = y; if (y > maxY) maxY = y;
      }
    }
    if (maxX < 0) return null;
    var pad = 6;
    minX = Math.max(0, minX - pad); minY = Math.max(0, minY - pad);
    maxX = Math.min(w - 1, maxX + pad); maxY = Math.min(h - 1, maxY + pad);
    var out = el('canvas');
    out.width = maxX - minX + 1; out.height = maxY - minY + 1;
    out.getContext('2d').drawImage(src, minX, minY, out.width, out.height, 0, 0, out.width, out.height);
    return out.toDataURL('image/png');
  }

  var dlg = null;
  function buildDialog() {
    var root = el('div', 'es-modal');
    root.innerHTML =
      '<div class="es-dialog" role="dialog" aria-modal="true" aria-label="Add your signature">' +
      '<div class="es-dlg-head"><strong>Add your signature</strong><button type="button" class="es-x" aria-label="Close">&times;</button></div>' +
      '<div class="es-tabs"><button type="button" data-tab="draw" class="on">Draw</button><button type="button" data-tab="type">Type</button><button type="button" data-tab="upload">Upload</button></div>' +
      '<div class="es-panel" data-panel="draw"><canvas class="es-pad"></canvas><div class="es-pad-foot"><span>Sign above with your mouse or finger</span><button type="button" class="es-link es-clear">Clear</button></div></div>' +
      '<div class="es-panel" data-panel="type" hidden><input type="text" class="es-type-in" placeholder="Type your full name" maxlength="60"><div class="es-fonts"></div></div>' +
      '<div class="es-panel" data-panel="upload" hidden><label class="es-drop"><input type="file" accept="image/png,image/jpeg,image/webp" hidden><span>Choose an image of your signature<br><small>PNG or JPG. White backgrounds are removed automatically.</small></span></label><div class="es-up-prev"></div></div>' +
      '<div class="es-dlg-foot"><span class="es-legal">By clicking “Use this signature”, I agree this is my legal electronic signature.</span><div><button type="button" class="es-btn es-btn-ghost es-cancel">Cancel</button> <button type="button" class="es-btn es-ok">Use this signature</button></div></div>' +
      '</div>';
    document.body.appendChild(root);

    var state = { tab: 'draw', ink: false, font: FONTS[0], upload: null, resolve: null };
    var pad = root.querySelector('.es-pad');
    var pctx = null;

    function sizePad() {
      var r = pad.getBoundingClientRect();
      var dpr = window.devicePixelRatio || 1;
      pad.width = Math.round(r.width * dpr); pad.height = Math.round(r.height * dpr);
      pctx = pad.getContext('2d');
      pctx.lineWidth = 2.6 * dpr; pctx.lineCap = 'round'; pctx.lineJoin = 'round'; pctx.strokeStyle = '#0b1f4d';
      state.ink = false;
    }
    var last = null;
    function pt(e) { var r = pad.getBoundingClientRect(); return [(e.clientX - r.left) * pad.width / r.width, (e.clientY - r.top) * pad.height / r.height]; }
    pad.addEventListener('pointerdown', function (e) { e.preventDefault(); pad.setPointerCapture(e.pointerId); last = pt(e); pctx.beginPath(); pctx.arc(last[0], last[1], pctx.lineWidth / 2, 0, 7); pctx.fillStyle = pctx.strokeStyle; pctx.fill(); state.ink = true; });
    pad.addEventListener('pointermove', function (e) {
      if (!last) return;
      var p = pt(e);
      var mid = [(last[0] + p[0]) / 2, (last[1] + p[1]) / 2];
      pctx.beginPath(); pctx.moveTo(last[0], last[1]); pctx.quadraticCurveTo(last[0], last[1], mid[0], mid[1]); pctx.lineTo(p[0], p[1]); pctx.stroke();
      last = p;
    });
    ['pointerup', 'pointercancel', 'pointerleave'].forEach(function (t) { pad.addEventListener(t, function () { last = null; }); });
    root.querySelector('.es-clear').onclick = function () { pctx.clearRect(0, 0, pad.width, pad.height); state.ink = false; };

    // Type
    var typeIn = root.querySelector('.es-type-in');
    var fontsBox = root.querySelector('.es-fonts');
    FONTS.forEach(function (f, i) {
      var b = el('button', 'es-font' + (i === 0 ? ' on' : ''));
      b.type = 'button'; b.style.fontFamily = "'" + f + "', cursive"; b.dataset.font = f;
      b.onclick = function () { state.font = f; fontsBox.querySelectorAll('.es-font').forEach(function (x) { x.classList.toggle('on', x === b); }); };
      fontsBox.appendChild(b);
    });
    function syncFonts() { fontsBox.querySelectorAll('.es-font').forEach(function (b) { b.textContent = typeIn.value || 'Your Name'; }); }
    typeIn.addEventListener('input', syncFonts);

    // Upload
    var fileIn = root.querySelector('input[type=file]');
    var upPrev = root.querySelector('.es-up-prev');
    fileIn.onchange = function () {
      var file = fileIn.files[0]; if (!file) return;
      var img = new Image();
      img.onload = function () {
        var s = Math.min(1, 1000 / img.width);
        var c = el('canvas'); c.width = Math.round(img.width * s); c.height = Math.round(img.height * s);
        var cx = c.getContext('2d'); cx.drawImage(img, 0, 0, c.width, c.height);
        var d = cx.getImageData(0, 0, c.width, c.height), px = d.data;
        for (var i = 0; i < px.length; i += 4) { // knock out light background
          var lum = (px[i] + px[i + 1] + px[i + 2]) / 3;
          if (lum > 225) px[i + 3] = 0; else if (lum > 180) px[i + 3] = Math.round(px[i + 3] * (225 - lum) / 45);
        }
        cx.putImageData(d, 0, 0);
        state.upload = trimCanvas(c);
        upPrev.innerHTML = state.upload ? '<img alt="Signature preview" src="' + state.upload + '">' : '<p class="es-err">We could not find a signature in that image.</p>';
        URL.revokeObjectURL(img.src);
      };
      img.src = URL.createObjectURL(file);
    };

    function setTab(t) {
      state.tab = t;
      root.querySelectorAll('.es-tabs button').forEach(function (b) { b.classList.toggle('on', b.dataset.tab === t); });
      root.querySelectorAll('.es-panel').forEach(function (p) { p.hidden = p.dataset.panel !== t; });
      if (t === 'draw') sizePad();
      if (t === 'type') { syncFonts(); typeIn.focus(); }
    }
    root.querySelectorAll('.es-tabs button').forEach(function (b) { b.onclick = function () { setTab(b.dataset.tab); }; });

    function close(v) { root.classList.remove('open'); document.body.style.overflow = ''; if (state.resolve) state.resolve(v); state.resolve = null; }
    root.querySelector('.es-x').onclick = function () { close(null); };
    root.querySelector('.es-cancel').onclick = function () { close(null); };
    root.addEventListener('pointerdown', function (e) { if (e.target === root) close(null); });
    document.addEventListener('keydown', function (e) { if (e.key === 'Escape' && root.classList.contains('open')) close(null); });

    root.querySelector('.es-ok').onclick = async function () {
      var out = null;
      if (state.tab === 'draw') {
        if (!state.ink) return alert('Please draw your signature first.');
        out = trimCanvas(pad);
      } else if (state.tab === 'type') {
        var name = typeIn.value.trim();
        if (!name) return typeIn.focus();
        var font = "'" + state.font + "'";
        try { await document.fonts.load('96px ' + font); } catch (e) {}
        var c = el('canvas'), cx = c.getContext('2d');
        cx.font = '96px ' + font + ', cursive';
        c.width = Math.ceil(cx.measureText(name).width + 60); c.height = 170;
        cx.font = '96px ' + font + ', cursive'; cx.fillStyle = '#0b1f4d'; cx.textBaseline = 'middle';
        cx.fillText(name, 30, 88);
        out = trimCanvas(c);
      } else {
        if (!state.upload) return alert('Please choose an image first.');
        out = state.upload;
      }
      if (out) close(out);
    };

    return {
      open: function (defaultName) {
        root.classList.add('open'); document.body.style.overflow = 'hidden';
        if (defaultName && !typeIn.value) typeIn.value = defaultName;
        setTab(state.tab);
        return new Promise(function (res) { state.resolve = res; });
      }
    };
  }
  function askSignature(defaultName) { if (!dlg) dlg = buildDialog(); return dlg.open(defaultName); }

  /* ── Fields on the page ──────────────────────────────────── */

  /**
   * opts.mode: 'edit' (admin places fields, fills "sender" ones) or 'sign' (signer fills "signer" ones).
   */
  function Board(pages, fields, opts) {
    this.pages = pages; this.fields = fields; this.opts = opts || {};
    this.mode = this.opts.mode || 'sign';
    this.adopted = null; // signature reused across fields
    this.onchange = this.opts.onchange || function () {};
    this.nodes = {};
    var self = this;
    fields.forEach(function (f) { self.mount(f); });
  }
  Board.prototype.editable = function (f) { return this.mode === 'edit' ? f.party === 'sender' : f.party === 'signer'; };
  Board.prototype.page = function (n) { return this.pages[n - 1]; };

  Board.prototype.mount = function (f) {
    var p = this.page(f.page); if (!p) return;
    var node = el('div', 'es-field');
    node.dataset.id = f.id;
    p.layer.appendChild(node);
    this.nodes[f.id] = node;
    this.paint(f);
    this.bind(f, node);
  };

  Board.prototype.paint = function (f) {
    var node = this.nodes[f.id]; if (!node) return;
    var self = this, mine = this.editable(f);
    node.className = 'es-field es-' + f.type + ' es-' + f.party + (f.value ? ' filled' : '') + (mine ? ' mine' : ' theirs');
    node.style.left = f.x * 100 + '%'; node.style.top = f.y * 100 + '%';
    node.style.width = f.w * 100 + '%'; node.style.height = f.h * 100 + '%';
    node.innerHTML = '';
    if (this.mode === 'edit') {
      var tag = el('div', 'es-tag', (f.party === 'sender' ? 'You' : 'Signer') + ' · ' + LABEL[f.type]);
      node.appendChild(tag);
      var del = el('button', 'es-del', '×'); del.type = 'button'; del.title = 'Delete field';
      del.onclick = function (e) { e.stopPropagation(); self.remove(f.id); };
      node.appendChild(del);
      node.appendChild(el('div', 'es-rz'));
    } else if (mine && !f.value) {
      node.appendChild(el('div', 'es-tag', LABEL[f.type] + ' · required'));
    }
    if (f.type === 'signature') {
      if (f.value) { var img = el('img'); img.src = f.value; img.alt = 'Signature'; img.draggable = false; node.appendChild(img); }
      else node.appendChild(el('span', 'es-ph', mine ? (this.mode === 'sign' ? 'Click to sign' : 'Click to sign') : 'Signature'));
    } else if (mine) {
      var inp = el('input', 'es-in');
      inp.type = 'text'; inp.value = f.value || ''; inp.maxLength = 120;
      inp.placeholder = f.type === 'date' ? 'MM/DD/YYYY' : 'Full name';
      inp.setAttribute('aria-label', LABEL[f.type]);
      inp.addEventListener('input', function () { f.value = inp.value.trim(); node.classList.toggle('filled', !!f.value); self.onchange(); });
      node.appendChild(inp);
    } else {
      node.appendChild(el('span', f.value ? 'es-text' : 'es-ph', f.value || LABEL[f.type]));
    }
  };

  Board.prototype.fillSignature = async function (f, forceDialog) {
    var v = (!forceDialog && this.adopted) ? this.adopted : await askSignature(this.opts.defaultName ? this.opts.defaultName() : '');
    if (!v) return;
    this.adopted = v;
    f.value = v;
    this.paint(f);
    this.onchange();
  };

  Board.prototype.bind = function (f, node) {
    var self = this;
    if (this.mode !== 'edit') {
      if (this.editable(f) && f.type === 'signature') {
        node.tabIndex = 0; node.setAttribute('role', 'button');
        node.addEventListener('click', function () { self.fillSignature(f, !!f.value); });
        node.addEventListener('keydown', function (e) { if (e.key === 'Enter' || e.key === ' ') { e.preventDefault(); self.fillSignature(f, !!f.value); } });
      }
      return;
    }
    // Edit mode: drag to move, corner handle to resize, click to fill own signature
    node.addEventListener('pointerdown', function (e) {
      if (e.button > 0 || e.target.closest('.es-del') || e.target.classList.contains('es-in')) return;
      e.preventDefault();
      var layer = node.parentNode, r = layer.getBoundingClientRect();
      var resize = e.target.classList.contains('es-rz');
      var sx = e.clientX, sy = e.clientY, start = { x: f.x, y: f.y, w: f.w, h: f.h }, moved = false;
      self.select(f.id);
      node.setPointerCapture(e.pointerId);
      function move(ev) {
        var dx = (ev.clientX - sx) / r.width, dy = (ev.clientY - sy) / r.height;
        if (Math.abs(ev.clientX - sx) + Math.abs(ev.clientY - sy) > 3) moved = true;
        if (resize) {
          f.w = clamp(start.w + dx, 0.03, 1 - f.x);
          f.h = clamp(start.h + dy, 0.012, 1 - f.y);
        } else {
          f.x = clamp(start.x + dx, 0, 1 - f.w);
          f.y = clamp(start.y + dy, 0, 1 - f.h);
        }
        node.style.left = f.x * 100 + '%'; node.style.top = f.y * 100 + '%';
        node.style.width = f.w * 100 + '%'; node.style.height = f.h * 100 + '%';
      }
      function up() {
        node.removeEventListener('pointermove', move);
        node.removeEventListener('pointerup', up);
        node.removeEventListener('pointercancel', up);
        if (moved) self.onchange();
        else if (!resize && f.party === 'sender' && f.type === 'signature') self.fillSignature(f, true);
      }
      node.addEventListener('pointermove', move);
      node.addEventListener('pointerup', up);
      node.addEventListener('pointercancel', up);
    });
  };

  Board.prototype.select = function (id) {
    Object.keys(this.nodes).forEach(function (k) { this.nodes[k].classList.toggle('sel', k === id); }, this);
    this.selected = id;
  };

  Board.prototype.add = function (type, party, pageN, cx, cy) {
    var p = this.page(pageN); if (!p) return;
    var sz = SIZE_PT[type], w = sz[0] / p.w, h = sz[1] / p.h;
    var f = { id: uid(), type: type, party: party, page: pageN, x: clamp(cx - w / 2, 0, 1 - w), y: clamp(cy - h / 2, 0, 1 - h), w: w, h: h, value: '' };
    if (type === 'date' && party === 'sender') f.value = today();
    this.fields.push(f);
    this.mount(f);
    this.select(f.id);
    this.onchange();
    return f;
  };

  Board.prototype.remove = function (id) {
    var i = this.fields.findIndex(function (f) { return f.id === id; });
    if (i < 0) return;
    this.fields.splice(i, 1);
    if (this.nodes[id]) this.nodes[id].remove();
    delete this.nodes[id];
    this.onchange();
  };

  Board.prototype.setParty = function (id, party) {
    var f = this.fields.find(function (x) { return x.id === id; });
    if (!f) return;
    f.party = party;
    if (party === 'signer') f.value = '';
    this.paint(f); this.select(id); this.onchange();
  };

  Board.prototype.missing = function (party) {
    return this.fields.filter(function (f) { return f.party === party && !String(f.value || '').trim(); });
  };

  Board.prototype.focusField = function (f) {
    var n = this.nodes[f.id]; if (!n) return;
    n.scrollIntoView({ behavior: 'smooth', block: 'center' });
    n.classList.remove('es-flash'); void n.offsetWidth; n.classList.add('es-flash');
    var inp = n.querySelector('input'); if (inp) setTimeout(function () { inp.focus(); }, 350);
  };

  /* ── Stamping with pdf-lib ───────────────────────────────── */

  function dataUrlBytes(u) {
    var b = atob(u.split(',')[1]), out = new Uint8Array(b.length);
    for (var i = 0; i < b.length; i++) out[i] = b.charCodeAt(i);
    return out;
  }
  function winAnsi(s) {
    return String(s || '').replace(/[‘’]/g, "'").replace(/[“”]/g, '"').replace(/[–—]/g, '-').replace(/[^\x20-\x7E\xA0-\xFF]/g, '?');
  }
  function wrap(text, font, size, maxW) {
    var words = winAnsi(text).split(/\s+/), lines = [], line = '';
    words.forEach(function (w) {
      var t = line ? line + ' ' + w : w;
      if (font.widthOfTextAtSize(t, size) > maxW && line) { lines.push(line); line = w; } else line = t;
    });
    if (line) lines.push(line);
    return lines;
  }

  async function stamp(bytes, fields, cert) {
    var L = PDFLib;
    var pdf = await L.PDFDocument.load(bytes, { ignoreEncryption: true });
    var font = await pdf.embedFont(L.StandardFonts.Helvetica);
    var bold = await pdf.embedFont(L.StandardFonts.HelveticaBold);
    var pages = pdf.getPages(), imgCache = {};
    var ink = L.rgb(0.04, 0.08, 0.2);
    for (var i = 0; i < fields.length; i++) {
      var f = fields[i], page = pages[f.page - 1];
      if (!page || !f.value) continue;
      var box = page.getCropBox ? page.getCropBox() : { x: 0, y: 0, width: page.getWidth(), height: page.getHeight() };
      var x = box.x + f.x * box.width, w = f.w * box.width, h = f.h * box.height;
      var y = box.y + box.height * (1 - f.y - f.h);
      if (f.type === 'signature') {
        var img = imgCache[f.value] || (imgCache[f.value] = await pdf.embedPng(dataUrlBytes(f.value)));
        var s = Math.min(w / img.width, h / img.height), iw = img.width * s, ih = img.height * s;
        page.drawImage(img, { x: x + (w - iw) / 2, y: y + (h - ih) / 2, width: iw, height: ih });
      } else {
        var t = winAnsi(f.value), size = Math.min(h * 0.62, 18);
        while (size > 5 && font.widthOfTextAtSize(t, size) > w - 4) size -= 0.5;
        page.drawText(t, { x: x + 2, y: y + (h - size * 0.72) / 2, size: size, font: font, color: ink });
      }
    }
    if (cert) {
      var pg = pdf.addPage([612, 792]), yy = 730, M = 56, W = 500;
      var dark = L.rgb(0.04, 0.18, 0.12), grey = L.rgb(0.42, 0.45, 0.5);
      pg.drawRectangle({ x: 0, y: 762, width: 612, height: 30, color: L.rgb(0.04, 0.18, 0.12) });
      pg.drawText(winAnsi(cert.brand || 'Homecare Creators'), { x: M, y: 773, size: 11, font: bold, color: L.rgb(1, 1, 1) });
      pg.drawText('Signature Certificate', { x: M, y: yy, size: 20, font: bold, color: dark }); yy -= 22;
      pg.drawText('This page records how and when this document was electronically signed.', { x: M, y: yy, size: 10, font: font, color: grey }); yy -= 30;
      (cert.rows || []).forEach(function (r) {
        if (r === '-') { pg.drawLine({ start: { x: M, y: yy + 8 }, end: { x: M + W, y: yy + 8 }, thickness: 0.6, color: L.rgb(0.85, 0.86, 0.88) }); yy -= 12; return; }
        pg.drawText(winAnsi(r[0]).toUpperCase(), { x: M, y: yy, size: 8, font: bold, color: grey });
        var lines = wrap(r[1], font, 11, W - 150);
        lines.forEach(function (ln, k) { pg.drawText(ln, { x: M + 150, y: yy - k * 14, size: 11, font: font, color: L.rgb(0.07, 0.09, 0.15) }); });
        yy -= Math.max(1, lines.length) * 14 + 8;
      });
      if (cert.signature) {
        try {
          var simg = await pdf.embedPng(dataUrlBytes(cert.signature));
          var ss = Math.min(200 / simg.width, 60 / simg.height);
          yy -= 6;
          pg.drawText('SIGNATURE', { x: M, y: yy, size: 8, font: bold, color: grey });
          pg.drawImage(simg, { x: M + 150, y: yy - simg.height * ss + 10, width: simg.width * ss, height: simg.height * ss });
        } catch (e) {}
      }
    }
    return await pdf.save();
  }

  async function sha256Hex(bytes) {
    if (!(window.crypto && crypto.subtle)) return '';
    var h = await crypto.subtle.digest('SHA-256', bytes);
    return Array.from(new Uint8Array(h)).map(function (b) { return b.toString(16).padStart(2, '0'); }).join('');
  }

  function download(bytes, name) {
    var url = URL.createObjectURL(new Blob([bytes], { type: 'application/pdf' }));
    var a = el('a'); a.href = url; a.download = name; document.body.appendChild(a); a.click(); a.remove();
    setTimeout(function () { URL.revokeObjectURL(url); }, 4000);
  }

  window.ESign = { loadPdf: loadPdf, renderPages: renderPages, Board: Board, stamp: stamp, sha256Hex: sha256Hex, download: download, askSignature: askSignature, today: today, LABEL: LABEL };
})();
