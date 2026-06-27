// ── Character counters ──────────────────────────────────────
document.querySelectorAll('[data-counter]').forEach(el => {
  const targetId = el.dataset.counter;
  const [min, max] = (el.dataset.range || '0,999').split(',').map(Number);
  const counter = document.getElementById(targetId);
  if (!counter) return;
  const update = () => {
    const len = el.value.length;
    counter.textContent = len + ' / ' + max;
    counter.className = 'char-count';
    if (len >= min && len <= max) counter.classList.add('good');
    else if (len > max) counter.classList.add('over');
    else if (len > 0) counter.classList.add('warn');
  };
  el.addEventListener('input', update);
  update();
});

// ── Live SEO Preview ─────────────────────────────────────────
function updateSeoPreview() {
  const title = document.getElementById('meta_title');
  const desc  = document.getElementById('meta_desc');
  const canon = document.getElementById('canonical_url');
  const pTitle = document.getElementById('prev-title');
  const pDesc  = document.getElementById('prev-desc');
  const pUrl   = document.getElementById('prev-url');
  if (title && pTitle) pTitle.textContent = title.value || 'Page Title';
  if (desc  && pDesc)  pDesc.textContent  = desc.value  || 'Meta description will appear here.';
  if (canon && pUrl)   pUrl.textContent   = (canon.value || 'https://homecarecreators.com/page').replace(/^https?:\/\//, '');
}
['meta_title','meta_desc','canonical_url'].forEach(id => {
  const el = document.getElementById(id);
  if (el) el.addEventListener('input', updateSeoPreview);
});
updateSeoPreview();

// ── Tabs ─────────────────────────────────────────────────────
document.querySelectorAll('.tabs').forEach(tabs => {
  const btns   = tabs.querySelectorAll('.tab-btn');
  const panels = document.querySelectorAll('.tab-panel');
  btns.forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.dataset.tab;
      btns.forEach(b => b.classList.remove('active'));
      panels.forEach(p => p.classList.remove('active'));
      btn.classList.add('active');
      const panel = document.getElementById('tab-' + target);
      if (panel) panel.classList.add('active');
    });
  });
});

// ── Schema block toggle ──────────────────────────────────────
document.querySelectorAll('.schema-block-header').forEach(h => {
  h.addEventListener('click', () => {
    const body = h.nextElementSibling;
    if (body) body.classList.toggle('open');
    const icon = h.querySelector('.toggle-icon');
    if (icon) icon.textContent = body.classList.contains('open') ? '▲' : '▼';
  });
});

// ── Tag input ────────────────────────────────────────────────
document.querySelectorAll('.tags-wrap').forEach(wrap => {
  const input   = wrap.querySelector('input[type=text]');
  const hidden  = wrap.querySelector('input[type=hidden]');
  const display = wrap.querySelector('.tags-display');
  if (!input || !hidden) return;

  let tags = hidden.value ? hidden.value.split(',').map(t => t.trim()).filter(Boolean) : [];

  function render() {
    display.innerHTML = tags.map((t,i) =>
      `<span class="tag">${t} <span class="tag-remove" data-i="${i}">×</span></span>`
    ).join('');
    hidden.value = tags.join(',');
    display.querySelectorAll('.tag-remove').forEach(btn => {
      btn.addEventListener('click', () => { tags.splice(+btn.dataset.i,1); render(); });
    });
  }

  input.addEventListener('keydown', e => {
    if ((e.key === 'Enter' || e.key === ',') && input.value.trim()) {
      e.preventDefault();
      const val = input.value.trim().replace(/,$/, '');
      if (val && !tags.includes(val)) { tags.push(val); render(); }
      input.value = '';
    }
    if (e.key === 'Backspace' && !input.value && tags.length) {
      tags.pop(); render();
    }
  });

  render();
});

// ── Blog editor toolbar ──────────────────────────────────────
document.querySelectorAll('.editor-btn').forEach(btn => {
  btn.addEventListener('click', e => {
    e.preventDefault();
    const cmd  = btn.dataset.cmd;
    const val  = btn.dataset.val || null;
    document.execCommand(cmd, false, val);
    document.getElementById('blog-content')?.focus();
  });
});

// Sync contenteditable → hidden textarea for blog
const blogContent = document.getElementById('blog-content');
const blogHidden  = document.getElementById('blog-html');
if (blogContent && blogHidden) {
  blogContent.innerHTML = blogHidden.value;
  blogContent.addEventListener('input', () => {
    blogHidden.value = blogContent.innerHTML;
  });
}

// ── Confirm delete ───────────────────────────────────────────
document.querySelectorAll('[data-confirm]').forEach(el => {
  el.addEventListener('click', e => {
    if (!confirm(el.dataset.confirm || 'Are you sure?')) e.preventDefault();
  });
});

// ── Auto-slug from title ─────────────────────────────────────
const blogTitle = document.getElementById('post-title');
const blogSlug  = document.getElementById('post-slug');
if (blogTitle && blogSlug && !blogSlug.dataset.locked) {
  blogTitle.addEventListener('input', () => {
    blogSlug.value = blogTitle.value.toLowerCase()
      .replace(/[^a-z0-9\s-]/g, '').replace(/[\s]+/g, '-').replace(/-+/g, '-').replace(/^-|-$/g,'');
  });
  blogSlug.addEventListener('input', () => { blogSlug.dataset.locked = '1'; });
}

// ── Keyword density ──────────────────────────────────────────
function calcDensity() {
  const kw   = (document.getElementById('focus_keyword')?.value || '').toLowerCase().trim();
  const body = (document.getElementById('blog-html')?.value || document.getElementById('blog-content')?.innerText || '').toLowerCase();
  const total = body.split(/\s+/).filter(Boolean).length;
  if (!kw || !total) return;
  const count = (body.match(new RegExp('\\b' + kw.replace(/[.*+?^${}()|[\]\\]/g,'\\$&') + '\\b','g')) || []).length;
  const pct   = ((count / total) * 100).toFixed(1);
  const bar   = document.querySelector('.density-fill');
  const label = document.querySelector('.density-label');
  if (bar)   bar.style.width = Math.min(pct * 20, 100) + '%';
  if (label) label.textContent = pct + '% (' + count + ' uses)';
}
['focus_keyword','blog-content'].forEach(id => {
  const el = document.getElementById(id);
  if (el) el.addEventListener('input', calcDensity);
});
calcDensity();
