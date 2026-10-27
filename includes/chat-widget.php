<?php
// Site-wide chat widget bubble. Included from includes/footer.php so it
// appears on every page. Talks to /chat-handler.php.
?>
<style>
#hcChatRoot{position:fixed;right:24px;bottom:24px;z-index:900;font-family:'DM Sans',sans-serif}
#hcChatBubble{width:60px;height:60px;border-radius:50%;background:linear-gradient(135deg,var(--teal),var(--teal-lt));border:none;color:#fff;font-size:24px;cursor:pointer;box-shadow:0 10px 30px rgba(29,158,117,.45);display:flex;align-items:center;justify-content:center;position:relative;transition:transform .2s}
#hcChatBubble:hover{transform:scale(1.06)}
.hc-chat-badge{position:absolute;top:-2px;right:-2px;width:18px;height:18px;border-radius:50%;background:#e53e3e;border:2px solid #fff;display:none;align-items:center;justify-content:center}
.hc-chat-panel{position:fixed;right:24px;bottom:96px;width:360px;max-width:calc(100vw - 32px);max-height:min(560px,calc(100vh - 130px));background:#fff;border-radius:var(--r-lg);box-shadow:0 24px 70px rgba(10,46,30,.3);display:none;flex-direction:column;overflow:hidden;border:1px solid var(--border)}
.hc-chat-panel.open{display:flex}
.hc-chat-header{background:var(--forest);padding:18px 20px;display:flex;align-items:center;justify-content:space-between;flex-shrink:0}
.hc-chat-header-title{color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;display:flex;align-items:center;gap:9px}
.hc-chat-header-title i{color:var(--teal-lt)}
#hcChatClose{background:none;border:none;color:rgba(255,255,255,.6);font-size:16px;cursor:pointer;padding:4px}
#hcChatClose:hover{color:#fff}
.hc-chat-body{flex:1;overflow-y:auto;padding:20px;display:flex;flex-direction:column;min-height:0}
.hc-chat-greeting{font-size:14.5px;color:var(--text);margin-bottom:16px;line-height:1.5}
.hc-chat-option{display:flex;align-items:center;gap:14px;text-align:left;background:var(--cream);border:1px solid var(--border);border-radius:var(--r);padding:14px 16px;cursor:pointer;margin-bottom:10px;transition:.15s;font-family:inherit}
.hc-chat-option:hover{border-color:var(--teal);background:#fff;box-shadow:0 6px 20px rgba(10,46,30,.08)}
.hc-chat-option i{font-size:19px;color:var(--teal);flex-shrink:0;width:22px;text-align:center}
.hc-chat-option-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:13.5px;color:var(--forest)}
.hc-chat-option-desc{font-size:11.5px;color:var(--muted);margin-top:2px}
.hc-chat-back{display:flex;align-items:center;gap:8px;background:none;border:none;color:var(--teal);font-weight:700;font-size:12.5px;cursor:pointer;padding:0 0 16px;font-family:'Plus Jakarta Sans',sans-serif}
.hc-chat-faq-intro{font-size:13.5px;color:var(--muted);margin-bottom:12px}
.hc-chat-faq-row{display:flex;gap:8px;margin-bottom:14px}
.hc-chat-faq-row input,.hc-chat-input-field{width:100%;padding:10px 13px;border:1px solid var(--border);border-radius:9px;font-size:13.5px;font-family:inherit;outline:none}
.hc-chat-faq-row input:focus,.hc-chat-input-field:focus{border-color:var(--teal)}
.hc-chat-faq-row button{flex-shrink:0;width:38px;background:var(--teal);color:#fff;border:none;border-radius:9px;cursor:pointer}
.hc-chat-input-field{margin-bottom:10px;resize:vertical}
.hc-chat-loading,.hc-chat-noresult{font-size:12.5px;color:var(--muted);padding:8px 0}
.hc-chat-faq-card{background:var(--cream);border:1px solid var(--border);border-radius:9px;padding:12px 14px;margin-bottom:10px}
.hc-chat-faq-q{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:12.5px;color:var(--forest);margin-bottom:6px}
.hc-chat-faq-a{font-size:12.5px;color:var(--text);line-height:1.6}
.hc-chat-link{background:none;border:none;color:var(--teal);font-weight:700;font-size:12.5px;cursor:pointer;padding:6px 0;font-family:'Plus Jakarta Sans',sans-serif;text-align:left}
.hc-chat-submit{background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;border:none;border-radius:9px;padding:12px;font-weight:700;font-size:13.5px;cursor:pointer;width:100%;font-family:'Plus Jakarta Sans',sans-serif}
.hc-chat-field-error{border-color:#e53e3e!important}
.hc-chat-status{font-size:11.5px;color:var(--muted);text-align:center;margin-bottom:10px}
.hc-chat-thread{flex:1;overflow-y:auto;display:flex;flex-direction:column;gap:8px;margin-bottom:12px;min-height:120px}
.hc-chat-msg{max-width:80%;padding:9px 13px;border-radius:12px;font-size:13px;line-height:1.5;word-wrap:break-word}
.hc-chat-msg-visitor{align-self:flex-end;background:var(--teal);color:#fff;border-bottom-right-radius:3px}
.hc-chat-msg-admin{align-self:flex-start;background:var(--cream);color:var(--text);border-bottom-left-radius:3px}
.hc-chat-footer{display:flex;gap:8px;flex-shrink:0}
.hc-chat-footer input{flex:1;padding:11px 13px;border:1px solid var(--border);border-radius:9px;font-size:13.5px;font-family:inherit;outline:none}
.hc-chat-footer input:focus{border-color:var(--teal)}
.hc-chat-footer button{flex-shrink:0;width:40px;background:var(--teal);color:#fff;border:none;border-radius:9px;cursor:pointer}
@media(max-width:480px){.hc-chat-panel{right:16px;bottom:88px;width:calc(100vw - 32px)}#hcChatRoot{right:16px;bottom:16px}}
</style>

<div id="hcChatRoot">
  <button id="hcChatBubble" aria-label="Open chat"><i class="fa-solid fa-comment-dots"></i><span class="hc-chat-badge" id="hcChatBubbleBadge"></span></button>
  <div class="hc-chat-panel" id="hcChatPanel">
    <div class="hc-chat-header">
      <div class="hc-chat-header-title"><i class="fa-solid fa-comment-dots"></i>Homecare Creators</div>
      <button id="hcChatClose" aria-label="Close chat"><i class="fa-solid fa-xmark"></i></button>
    </div>
    <div class="hc-chat-body" id="hcChatBody"></div>
  </div>
</div>

<script>
(function(){
  var API = '/chat-handler.php';
  var bubble, panel, body, badge;
  var pollTimer = null;
  var lastMsgId = 0;
  var state = {
    sessionId: parseInt(localStorage.getItem('hcChatSessionId') || '0', 10),
    token: localStorage.getItem('hcChatToken') || ''
  };

  function esc(s) { var d = document.createElement('div'); d.textContent = s == null ? '' : String(s); return d.innerHTML; }

  function init() {
    bubble = document.getElementById('hcChatBubble');
    panel  = document.getElementById('hcChatPanel');
    body   = document.getElementById('hcChatBody');
    badge  = document.getElementById('hcChatBubbleBadge');

    bubble.addEventListener('click', togglePanel);
    document.getElementById('hcChatClose').addEventListener('click', togglePanel);

    if (state.sessionId && state.token) renderExpertChat();
    else renderMenu();
  }

  function togglePanel() {
    panel.classList.toggle('open');
    if (panel.classList.contains('open')) badge.style.display = 'none';
  }

  function renderMenu() {
    body.innerHTML =
      '<div class="hc-chat-greeting">👋 Hi! How can we help?</div>' +
      '<button class="hc-chat-option" id="hcOptExpert"><i class="fa-solid fa-user-headset"></i><div><div class="hc-chat-option-title">Talk with an Expert</div><div class="hc-chat-option-desc">Get a reply from our team, usually within minutes</div></div></button>' +
      '<button class="hc-chat-option" id="hcOptInfo"><i class="fa-solid fa-book-open"></i><div><div class="hc-chat-option-title">Get Info from the Website</div><div class="hc-chat-option-desc">Ask a question, get an instant answer</div></div></button>';
    document.getElementById('hcOptExpert').onclick = renderExpertForm;
    document.getElementById('hcOptInfo').onclick = renderFaq;
  }

  function backHeader(label) {
    return '<button class="hc-chat-back" id="hcChatBack"><i class="fa-solid fa-arrow-left"></i>' + esc(label) + '</button>';
  }

  function renderFaq() {
    body.innerHTML = backHeader('Back') +
      '<div class="hc-chat-faq-intro">What do you want to know?</div>' +
      '<div class="hc-chat-faq-row"><input type="text" id="hcFaqInput" placeholder="Type your question…" autocomplete="off"><button id="hcFaqBtn"><i class="fa-solid fa-paper-plane"></i></button></div>' +
      '<div id="hcFaqResults"></div>' +
      '<button class="hc-chat-link" id="hcFaqTalkHuman">Still need help? Talk to a human →</button>';
    document.getElementById('hcChatBack').onclick = renderMenu;
    document.getElementById('hcFaqTalkHuman').onclick = renderExpertForm;

    var input = document.getElementById('hcFaqInput');
    function doSearch() {
      var q = input.value.trim();
      if (!q) return;
      var resultsEl = document.getElementById('hcFaqResults');
      resultsEl.innerHTML = '<div class="hc-chat-loading">Searching…</div>';
      fetch(API + '?action=faq_search&q=' + encodeURIComponent(q))
        .then(function(r) { return r.json(); })
        .then(function(d) {
          if (!d.success || !d.results.length) {
            resultsEl.innerHTML = '<div class="hc-chat-noresult">No match found in our FAQs for that yet — try "Talk with an Expert" below.</div>';
            return;
          }
          resultsEl.innerHTML = d.results.map(function(r) {
            return '<div class="hc-chat-faq-card"><div class="hc-chat-faq-q">' + esc(r.question) + '</div><div class="hc-chat-faq-a">' + esc(r.answer) + '</div></div>';
          }).join('');
        })
        .catch(function() { resultsEl.innerHTML = '<div class="hc-chat-noresult">Something went wrong. Please try again.</div>'; });
    }
    document.getElementById('hcFaqBtn').onclick = doSearch;
    input.addEventListener('keydown', function(e) { if (e.key === 'Enter') doSearch(); });
  }

  function markFieldError(id) {
    var el = document.getElementById(id);
    el.classList.add('hc-chat-field-error');
    el.focus();
    el.addEventListener('input', function() { el.classList.remove('hc-chat-field-error'); }, { once: true });
  }

  function renderExpertForm() {
    body.innerHTML = backHeader('Back') +
      '<div class="hc-chat-faq-intro">Tell us a bit about you and we’ll connect you with our team.</div>' +
      '<input type="text" id="hcExpName" class="hc-chat-input-field" placeholder="Full Name *">' +
      '<input type="email" id="hcExpEmail" class="hc-chat-input-field" placeholder="Email *">' +
      '<textarea id="hcExpMsg" class="hc-chat-input-field" rows="3" placeholder="What can we help with? (optional)"></textarea>' +
      '<div class="hp-field" aria-hidden="true"><label for="hcExpWebsite">Website</label><input type="text" id="hcExpWebsite" tabindex="-1" autocomplete="off"></div>' +
      '<button class="hc-chat-submit" id="hcExpSubmit">Start Chat</button>';
    document.getElementById('hcChatBack').onclick = renderMenu;

    document.getElementById('hcExpSubmit').onclick = function() {
      var btn = this;
      var name = document.getElementById('hcExpName').value.trim();
      var email = document.getElementById('hcExpEmail').value.trim();
      var message = document.getElementById('hcExpMsg').value.trim();
      var honeypot = document.getElementById('hcExpWebsite').value.trim();
      if (!name) return markFieldError('hcExpName');
      if (!email || email.indexOf('@') === -1 || email.indexOf('.') === -1) return markFieldError('hcExpEmail');

      btn.disabled = true;
      btn.textContent = 'Connecting…';
      fetch(API, {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ action: 'start_expert', name: name, email: email, message: message, page_url: window.location.pathname, website: honeypot })
      })
        .then(function(r) { return r.json(); })
        .then(function(d) {
          if (d.success && d.session_id) {
            state.sessionId = d.session_id;
            state.token = d.token;
            localStorage.setItem('hcChatSessionId', d.session_id);
            localStorage.setItem('hcChatToken', d.token);
            lastMsgId = 0;
            renderExpertChat();
          } else {
            btn.disabled = false;
            btn.textContent = 'Start Chat';
            alert(d.message || 'Something went wrong. Please try again.');
          }
        })
        .catch(function() {
          btn.disabled = false;
          btn.textContent = 'Start Chat';
          alert('Connection error. Please try again.');
        });
    };
  }

  function renderExpertChat() {
    body.innerHTML = backHeader('New Chat') +
      '<div class="hc-chat-status" id="hcChatStatus">Connecting you with our team…</div>' +
      '<div class="hc-chat-thread" id="hcChatThread"></div>' +
      '<div class="hc-chat-footer"><input type="text" id="hcChatMsgInput" placeholder="Type a message…" autocomplete="off"><button id="hcChatSendBtn"><i class="fa-solid fa-paper-plane"></i></button></div>';

    document.getElementById('hcChatBack').onclick = function() {
      stopPolling();
      localStorage.removeItem('hcChatSessionId');
      localStorage.removeItem('hcChatToken');
      state.sessionId = 0;
      state.token = '';
      renderMenu();
    };
    document.getElementById('hcChatSendBtn').onclick = sendChatMessage;
    document.getElementById('hcChatMsgInput').addEventListener('keydown', function(e) { if (e.key === 'Enter') sendChatMessage(); });

    lastMsgId = 0;
    pollNow();
    startPolling();
  }

  function sendChatMessage() {
    var input = document.getElementById('hcChatMsgInput');
    var msg = (input.value || '').trim();
    if (!msg) return;
    appendMessage('visitor', msg);
    input.value = '';
    fetch(API, {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ action: 'send_message', session_id: state.sessionId, token: state.token, message: msg })
    }).catch(function() {});
  }

  function appendMessage(sender, text) {
    var thread = document.getElementById('hcChatThread');
    if (!thread) return;
    var div = document.createElement('div');
    div.className = 'hc-chat-msg hc-chat-msg-' + sender;
    div.textContent = text;
    thread.appendChild(div);
    thread.scrollTop = thread.scrollHeight;
  }

  function pollNow() {
    if (!state.sessionId || !state.token) return;
    fetch(API + '?action=poll&session_id=' + state.sessionId + '&token=' + state.token + '&since=' + lastMsgId)
      .then(function(r) { return r.json(); })
      .then(function(d) {
        if (!d.success) return;
        var statusEl = document.getElementById('hcChatStatus');
        if (statusEl) {
          if (d.status === 'closed') statusEl.textContent = 'This conversation has ended.';
          else if (lastMsgId === 0 && !d.messages.length) statusEl.textContent = 'Connecting you with our team…';
          else statusEl.style.display = 'none';
        }
        var hadAdminReply = false;
        d.messages.forEach(function(m) {
          appendMessage(m.sender, m.message);
          lastMsgId = Math.max(lastMsgId, parseInt(m.id, 10));
          if (m.sender === 'admin') hadAdminReply = true;
        });
        if (hadAdminReply && !panel.classList.contains('open')) {
          badge.style.display = 'flex';
        }
      })
      .catch(function() {});
  }

  function startPolling() {
    stopPolling();
    pollTimer = setInterval(pollNow, 3000);
  }
  function stopPolling() {
    if (pollTimer) { clearInterval(pollTimer); pollTimer = null; }
  }

  if (document.readyState === 'loading') document.addEventListener('DOMContentLoaded', init);
  else init();
})();
</script>
