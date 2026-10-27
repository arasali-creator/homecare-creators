<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_chat_sessions (
    id INT AUTO_INCREMENT PRIMARY KEY,
    token VARCHAR(40) NOT NULL UNIQUE,
    visitor_name VARCHAR(150) DEFAULT '',
    visitor_email VARCHAR(190) DEFAULT '',
    type ENUM('expert','info') NOT NULL DEFAULT 'expert',
    status ENUM('pending','active','closed') NOT NULL DEFAULT 'pending',
    page_url VARCHAR(500) DEFAULT '',
    admin_unread TINYINT(1) NOT NULL DEFAULT 1,
    visitor_unread TINYINT(1) NOT NULL DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_message_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_chat_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    session_id INT NOT NULL,
    sender ENUM('visitor','admin') NOT NULL,
    message TEXT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX (session_id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");

$open_session = (int)($_GET['session'] ?? 0);

hc_head('Live Chat');
hc_topbar('Live Chat', '<a href="/admin/">Admin</a> › Live Chat');
?>
<style>
.chat-admin-wrap{display:grid;grid-template-columns:320px 1fr;gap:0;height:calc(100vh - 140px);background:#fff;border:1px solid var(--border,#e5e7eb);border-radius:var(--r,10px);overflow:hidden}
.chat-list{border-right:1px solid var(--border,#e5e7eb);overflow-y:auto}
.chat-list-item{padding:14px 16px;border-bottom:1px solid #f1f1f1;cursor:pointer;transition:.15s;position:relative}
.chat-list-item:hover{background:#f9fafb}
.chat-list-item.active{background:#eefaf4}
.chat-list-name{font-weight:700;font-size:13.5px;color:#111827;display:flex;align-items:center;justify-content:space-between;gap:8px}
.chat-list-snippet{font-size:12px;color:#6b7280;margin-top:3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.chat-list-meta{font-size:10.5px;color:#9ca3af;margin-top:4px}
.chat-unread-dot{width:8px;height:8px;border-radius:50%;background:#e53e3e;flex-shrink:0}
.chat-badge-type{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:2px 7px;border-radius:20px;background:#eefaf4;color:#1d9e75}
.chat-empty{padding:40px 20px;text-align:center;color:#9ca3af;font-size:13px}
.chat-thread-wrap{display:flex;flex-direction:column;height:100%}
.chat-thread-header{padding:16px 20px;border-bottom:1px solid var(--border,#e5e7eb);display:flex;align-items:center;justify-content:space-between}
.chat-thread-title{font-weight:700;font-size:14.5px;color:#111827}
.chat-thread-sub{font-size:12px;color:#6b7280;margin-top:2px}
.chat-thread-messages{flex:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:10px;background:#fafafa}
.chat-msg{max-width:65%;padding:10px 14px;border-radius:12px;font-size:13.5px;line-height:1.5}
.chat-msg-visitor{align-self:flex-start;background:#fff;border:1px solid #e5e7eb;color:#111827}
.chat-msg-admin{align-self:flex-end;background:#1d9e75;color:#fff}
.chat-reply-row{display:flex;gap:10px;padding:14px 20px;border-top:1px solid var(--border,#e5e7eb)}
.chat-reply-row textarea{flex:1;border:1px solid #d1d5db;border-radius:9px;padding:10px 13px;font-size:13.5px;font-family:inherit;resize:none;outline:none}
.chat-reply-row textarea:focus{border-color:#1d9e75}
</style>

<div class="page-content">
<?= hc_show_flash() ?>

<div class="chat-admin-wrap">
  <div class="chat-list" id="chatList">
    <div class="chat-empty">Loading sessions…</div>
  </div>
  <div class="chat-thread-wrap" id="chatThreadWrap">
    <div class="chat-empty" style="margin:auto">Select a conversation to view it here.</div>
  </div>
</div>
</div>

<script>
var openSessionId = <?= (int)$open_session ?>;
var currentId = 0;
var lastMsgCount = 0;

function esc(s) { var d = document.createElement('div'); d.textContent = s == null ? '' : String(s); return d.innerHTML; }

function timeAgo(dateStr) {
  var d = new Date(dateStr.replace(' ', 'T') + 'Z');
  var diff = Math.floor((Date.now() - d.getTime()) / 1000);
  if (diff < 60) return 'just now';
  if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
  if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
  return Math.floor(diff / 86400) + 'd ago';
}

function loadList() {
  fetch('/admin/chat/ajax.php?action=list')
    .then(function(r) { return r.json(); })
    .then(function(d) {
      if (!d.success) return;
      var el = document.getElementById('chatList');
      if (!d.sessions.length) { el.innerHTML = '<div class="chat-empty">No chat sessions yet.</div>'; return; }
      el.innerHTML = d.sessions.map(function(s) {
        return '<div class="chat-list-item' + (s.id == currentId ? ' active' : '') + '" data-id="' + s.id + '">' +
          '<div class="chat-list-name"><span>' + esc(s.visitor_name || 'Anonymous') + '</span>' +
          (s.admin_unread == 1 ? '<span class="chat-unread-dot"></span>' : '<span class="chat-badge-type">' + esc(s.status) + '</span>') +
          '</div>' +
          '<div class="chat-list-snippet">' + esc(s.last_message || '(no messages yet)') + '</div>' +
          '<div class="chat-list-meta">' + esc(s.visitor_email) + ' &middot; ' + timeAgo(s.last_message_at) + '</div>' +
        '</div>';
      }).join('');
      el.querySelectorAll('.chat-list-item').forEach(function(item) {
        item.addEventListener('click', function() { openThread(parseInt(item.dataset.id, 10)); });
      });
      if (openSessionId && !currentId) { openThread(openSessionId); openSessionId = 0; }
    })
    .catch(function() {});
}

function openThread(id) {
  currentId = id;
  lastMsgCount = 0;
  document.querySelectorAll('.chat-list-item').forEach(function(it) { it.classList.toggle('active', parseInt(it.dataset.id, 10) === id); });
  loadThread(true);
}

function loadThread(scrollDown) {
  if (!currentId) return;
  fetch('/admin/chat/ajax.php?action=thread&id=' + currentId)
    .then(function(r) { return r.json(); })
    .then(function(d) {
      if (!d.success) return;
      var wrap = document.getElementById('chatThreadWrap');
      if (d.messages.length === lastMsgCount) return; // nothing new, skip re-render
      lastMsgCount = d.messages.length;

      var closedBadge = d.session.status === 'closed' ? ' (closed)' : '';
      wrap.innerHTML =
        '<div class="chat-thread-header">' +
          '<div><div class="chat-thread-title">' + esc(d.session.visitor_name || 'Anonymous') + closedBadge + '</div>' +
          '<div class="chat-thread-sub">' + esc(d.session.visitor_email) + ' &middot; from ' + esc(d.session.page_url || '—') + '</div></div>' +
          '<button class="btn btn-ghost btn-sm" id="chatCloseBtn">Close Chat</button>' +
        '</div>' +
        '<div class="chat-thread-messages" id="chatMessages"></div>' +
        '<div class="chat-reply-row"><textarea id="chatReplyInput" rows="1" placeholder="Type a reply…"></textarea><button class="btn btn-primary" id="chatReplyBtn">Send</button></div>';

      var msgsEl = document.getElementById('chatMessages');
      msgsEl.innerHTML = d.messages.map(function(m) {
        return '<div class="chat-msg chat-msg-' + m.sender + '">' + esc(m.message) + '</div>';
      }).join('');
      if (scrollDown !== false) msgsEl.scrollTop = msgsEl.scrollHeight;

      document.getElementById('chatReplyBtn').onclick = sendReply;
      document.getElementById('chatReplyInput').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendReply(); }
      });
      document.getElementById('chatCloseBtn').onclick = function() {
        fetch('/admin/chat/ajax.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ action: 'close', session_id: currentId }) })
          .then(function() { loadThread(); loadList(); });
      };
      loadList();
    })
    .catch(function() {});
}

function sendReply() {
  var input = document.getElementById('chatReplyInput');
  var msg = (input.value || '').trim();
  if (!msg || !currentId) return;
  input.value = '';
  fetch('/admin/chat/ajax.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({ action: 'reply', session_id: currentId, message: msg })
  })
    .then(function() { loadThread(); })
    .catch(function() {});
}

loadList();
setInterval(loadList, 5000);
setInterval(function() { if (currentId) loadThread(); }, 4000);
</script>

<?php hc_foot(); ?>
