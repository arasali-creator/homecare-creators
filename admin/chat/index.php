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

foreach ([
    "ALTER TABLE hc_chat_sessions ADD COLUMN admin_typing_until TIMESTAMP NULL DEFAULT NULL",
    "ALTER TABLE hc_chat_sessions ADD COLUMN visitor_typing_until TIMESTAMP NULL DEFAULT NULL",
] as $alter) {
    try { hc_db()->exec($alter); } catch (Exception $e) { /* column already exists */ }
}

$open_session = (int)($_GET['session'] ?? 0);

hc_head('Live Chat');
hc_topbar('Live Chat', '<a href="/admin/">Admin</a> › Live Chat');
?>
<style>
.chat-admin-wrap{display:grid;grid-template-columns:330px 1fr;gap:0;height:calc(100vh - 140px);background:#fff;border:1px solid var(--border,#e5e7eb);border-radius:var(--r,10px);overflow:hidden}
.chat-list{border-right:1px solid var(--border,#e5e7eb);overflow-y:auto}
.chat-list-item{display:flex;gap:11px;padding:14px 16px;border-bottom:1px solid #f1f1f1;cursor:pointer;transition:.15s;position:relative}
.chat-list-item:hover{background:#f9fafb}
.chat-list-item.active{background:#eefaf4}
.chat-avatar{width:36px;height:36px;border-radius:50%;background:linear-gradient(135deg,#1d9e75,#2ec68f);color:#fff;display:flex;align-items:center;justify-content:center;font-weight:700;font-size:13px;flex-shrink:0;font-family:'Plus Jakarta Sans',sans-serif}
.chat-list-body{flex:1;min-width:0}
.chat-list-name{font-weight:700;font-size:13.5px;color:#111827;display:flex;align-items:center;justify-content:space-between;gap:8px}
.chat-list-snippet{font-size:12px;color:#6b7280;margin-top:3px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}
.chat-list-meta{font-size:10.5px;color:#9ca3af;margin-top:4px}
.chat-unread-dot{width:9px;height:9px;border-radius:50%;background:#e53e3e;flex-shrink:0;box-shadow:0 0 0 3px rgba(229,62,62,.15)}
.chat-badge-type{font-size:9.5px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;padding:2px 7px;border-radius:20px;background:#eefaf4;color:#1d9e75}
.chat-badge-type.closed{background:#f3f4f6;color:#6b7280}
.chat-empty{padding:40px 20px;text-align:center;color:#9ca3af;font-size:13px}
.chat-thread-wrap{display:flex;flex-direction:column;height:100%}
.chat-thread-header{padding:16px 20px;border-bottom:1px solid var(--border,#e5e7eb);display:flex;align-items:center;justify-content:space-between;gap:12px}
.chat-thread-title{font-weight:700;font-size:14.5px;color:#111827;display:flex;align-items:center;gap:8px}
.chat-thread-sub{font-size:12px;color:#6b7280;margin-top:2px}
.chat-thread-messages{flex:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;gap:4px;background:#fafafa}
.chat-msg-row{display:flex;flex-direction:column;margin-bottom:8px;max-width:65%}
.chat-msg-row.from-admin{align-self:flex-end;align-items:flex-end}
.chat-msg-row.from-visitor{align-self:flex-start;align-items:flex-start}
.chat-msg{padding:10px 14px;border-radius:14px;font-size:13.5px;line-height:1.5;word-wrap:break-word}
.chat-msg-row.from-visitor .chat-msg{background:#fff;border:1px solid #e5e7eb;color:#111827;border-bottom-left-radius:4px}
.chat-msg-row.from-admin .chat-msg{background:linear-gradient(135deg,#1d9e75,#2ec68f);color:#fff;border-bottom-right-radius:4px}
.chat-msg-time{font-size:10px;color:#9ca3af;margin-top:3px;padding:0 4px}
.chat-typing-row{display:flex;align-items:center;gap:6px;padding:8px 14px;color:#9ca3af;font-size:12px;align-self:flex-start}
.chat-typing-dots{display:inline-flex;gap:3px}
.chat-typing-dots span{width:5px;height:5px;border-radius:50%;background:#9ca3af;animation:chatTypingBounce 1.2s infinite}
.chat-typing-dots span:nth-child(2){animation-delay:.2s}
.chat-typing-dots span:nth-child(3){animation-delay:.4s}
@keyframes chatTypingBounce{0%,60%,100%{transform:translateY(0);opacity:.5}30%{transform:translateY(-4px);opacity:1}}
.chat-canned-row{display:flex;gap:6px;flex-wrap:wrap;padding:10px 20px 0}
.chat-canned-chip{background:#f3f4f6;border:1px solid #e5e7eb;border-radius:20px;padding:5px 12px;font-size:11.5px;color:#374151;cursor:pointer;transition:.15s}
.chat-canned-chip:hover{background:#eefaf4;border-color:#1d9e75;color:#1d9e75}
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
var lastUnreadTotal = 0;
var typingPingAt = 0;
var pageTitle = document.title;
var titleFlashTimer = null;

var CANNED_REPLIES = [
  "Thanks for reaching out! Could you tell me a bit more about your agency?",
  "One moment, let me check on that for you.",
  "What city or area does your agency serve?",
  "You can book a time directly with us here: https://homecarecreators.com/contact/",
  "Happy to help! Is this regarding SEO, website design, or something else?"
];

function esc(s) { var d = document.createElement('div'); d.textContent = s == null ? '' : String(s); return d.innerHTML; }

function timeAgo(dateStr) {
  var d = new Date(dateStr.replace(' ', 'T') + 'Z');
  var diff = Math.floor((Date.now() - d.getTime()) / 1000);
  if (diff < 60) return 'just now';
  if (diff < 3600) return Math.floor(diff / 60) + 'm ago';
  if (diff < 86400) return Math.floor(diff / 3600) + 'h ago';
  return Math.floor(diff / 86400) + 'd ago';
}

function formatTime(dateStr) {
  var d = new Date(dateStr.replace(' ', 'T') + 'Z');
  var h = d.getHours(), m = d.getMinutes();
  var ampm = h >= 12 ? 'PM' : 'AM';
  h = h % 12 || 12;
  return h + ':' + (m < 10 ? '0' : '') + m + ' ' + ampm;
}

function initials(name) {
  name = (name || '').trim();
  if (!name) return '?';
  var parts = name.split(/\s+/);
  return (parts[0][0] + (parts[1] ? parts[1][0] : '')).toUpperCase();
}

// ── Sound + tab-title alert for new messages, even when a different session is open ──
function playChime() {
  try {
    var ctx = new (window.AudioContext || window.webkitAudioContext)();
    var osc = ctx.createOscillator();
    var gain = ctx.createGain();
    osc.type = 'sine';
    osc.frequency.setValueAtTime(880, ctx.currentTime);
    gain.gain.setValueAtTime(0.15, ctx.currentTime);
    gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.4);
    osc.connect(gain); gain.connect(ctx.destination);
    osc.start(); osc.stop(ctx.currentTime + 0.4);
  } catch (e) {}
}
function flashTitle(on) {
  if (titleFlashTimer) { clearInterval(titleFlashTimer); titleFlashTimer = null; }
  if (!on) { document.title = pageTitle; return; }
  var showAlert = true;
  titleFlashTimer = setInterval(function() {
    document.title = showAlert ? '🔴 New message!' : pageTitle;
    showAlert = !showAlert;
  }, 1000);
}
document.addEventListener('visibilitychange', function() { if (!document.hidden) flashTitle(false); });

function loadList() {
  fetch('/admin/chat/ajax.php?action=list')
    .then(function(r) { return r.json(); })
    .then(function(d) {
      if (!d.success) return;
      var unreadTotal = d.sessions.reduce(function(n, s) { return n + (s.admin_unread == 1 ? 1 : 0); }, 0);
      if (unreadTotal > lastUnreadTotal) { playChime(); if (document.hidden) flashTitle(true); }
      lastUnreadTotal = unreadTotal;

      var el = document.getElementById('chatList');
      if (!d.sessions.length) { el.innerHTML = '<div class="chat-empty">No chat sessions yet.</div>'; return; }
      el.innerHTML = d.sessions.map(function(s) {
        return '<div class="chat-list-item' + (s.id == currentId ? ' active' : '') + '" data-id="' + s.id + '">' +
          '<div class="chat-avatar">' + esc(initials(s.visitor_name)) + '</div>' +
          '<div class="chat-list-body">' +
          '<div class="chat-list-name"><span>' + esc(s.visitor_name || 'Anonymous') + '</span>' +
          (s.admin_unread == 1 ? '<span class="chat-unread-dot"></span>' : '<span class="chat-badge-type' + (s.status === 'closed' ? ' closed' : '') + '">' + esc(s.status) + '</span>') +
          '</div>' +
          '<div class="chat-list-snippet">' + (s.visitor_typing == 1 ? '<em>typing…</em>' : esc(s.last_message || '(no messages yet)')) + '</div>' +
          '<div class="chat-list-meta">' + esc(s.visitor_email) + ' &middot; ' + timeAgo(s.last_message_at) + '</div>' +
          '</div>' +
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
  lastMsgCount = -1;
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
      var sameCount = d.messages.length === lastMsgCount;

      if (!sameCount) {
        lastMsgCount = d.messages.length;
        var closedBadge = d.session.status === 'closed' ? ' (closed)' : '';
        wrap.innerHTML =
          '<div class="chat-thread-header">' +
            '<div><div class="chat-thread-title">' + esc(d.session.visitor_name || 'Anonymous') + closedBadge + '</div>' +
            '<div class="chat-thread-sub">' + esc(d.session.visitor_email) + ' &middot; from ' + esc(d.session.page_url || '—') + '</div></div>' +
            '<button class="btn btn-ghost btn-sm" id="chatCloseBtn">Close Chat</button>' +
          '</div>' +
          '<div class="chat-thread-messages" id="chatMessages"></div>' +
          '<div class="chat-canned-row" id="chatCannedRow"></div>' +
          '<div class="chat-reply-row"><textarea id="chatReplyInput" rows="1" placeholder="Type a reply…"></textarea><button class="btn btn-primary" id="chatReplyBtn">Send</button></div>';

        var msgsEl = document.getElementById('chatMessages');
        msgsEl.innerHTML = d.messages.map(function(m) {
          return '<div class="chat-msg-row from-' + m.sender + '"><div class="chat-msg">' + esc(m.message) + '</div><div class="chat-msg-time">' + formatTime(m.created_at) + '</div></div>';
        }).join('');
        if (scrollDown !== false) msgsEl.scrollTop = msgsEl.scrollHeight;

        document.getElementById('chatCannedRow').innerHTML = CANNED_REPLIES.map(function(c, i) {
          return '<div class="chat-canned-chip" data-i="' + i + '">' + esc(c.length > 38 ? c.slice(0, 38) + '…' : c) + '</div>';
        }).join('');
        document.querySelectorAll('.chat-canned-chip').forEach(function(chip) {
          chip.addEventListener('click', function() {
            var input = document.getElementById('chatReplyInput');
            input.value = CANNED_REPLIES[parseInt(chip.dataset.i, 10)];
            input.focus();
          });
        });

        document.getElementById('chatReplyBtn').onclick = sendReply;
        var replyInput = document.getElementById('chatReplyInput');
        replyInput.addEventListener('keydown', function(e) {
          if (e.key === 'Enter' && !e.shiftKey) { e.preventDefault(); sendReply(); }
        });
        replyInput.addEventListener('input', function() {
          var now = Date.now();
          if (now - typingPingAt > 3000) {
            typingPingAt = now;
            fetch('/admin/chat/ajax.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ action: 'typing', session_id: currentId }) }).catch(function() {});
          }
        });
        document.getElementById('chatCloseBtn').onclick = function() {
          fetch('/admin/chat/ajax.php', { method: 'POST', headers: { 'Content-Type': 'application/json' }, body: JSON.stringify({ action: 'close', session_id: currentId }) })
            .then(function() { loadThread(); loadList(); });
        };
      }

      // Typing indicator toggles independently of the full re-render above
      var msgsEl2 = document.getElementById('chatMessages');
      var existingTyping = document.getElementById('chatVisitorTyping');
      if (d.session.visitor_typing == 1 && !existingTyping) {
        var row = document.createElement('div');
        row.className = 'chat-typing-row';
        row.id = 'chatVisitorTyping';
        row.innerHTML = '<div class="chat-typing-dots"><span></span><span></span><span></span></div>';
        msgsEl2.appendChild(row);
        msgsEl2.scrollTop = msgsEl2.scrollHeight;
      } else if (d.session.visitor_typing != 1 && existingTyping) {
        existingTyping.remove();
      }

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
    .then(function() { lastMsgCount = -1; loadThread(); })
    .catch(function() {});
}

loadList();
setInterval(loadList, 5000);
setInterval(function() { if (currentId) loadThread(); }, 3000);
</script>

<?php hc_foot(); ?>
