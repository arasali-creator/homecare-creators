<?php
require_once '../admin/config.php';
require_once '../admin/includes/db.php';

$slug  = trim($_GET['slug'] ?? '');
$event = $slug ? hc_one("SELECT * FROM hc_events WHERE slug=? AND status IN ('published','completed')", [$slug]) : null;
if (!$event) { http_response_code(404); header('Location: /events/'); exit; }

$reg_count = (int)hc_val("SELECT COUNT(*) FROM hc_event_registrations WHERE event_id=?", [$event['id']]);
$is_full   = $event['max_attendees'] && $reg_count >= (int)$event['max_attendees'];

$dt      = new DateTime($event['event_datetime'], new DateTimeZone($event['timezone'] ?: 'America/New_York'));
$dt_utc  = (clone $dt)->setTimezone(new DateTimeZone('UTC'));
$is_past = $dt->getTimestamp() < time() || $event['status'] === 'completed';

$highlights = array_filter(array_map('trim', explode("\n", $event['highlights'] ?? '')));

$page_title    = $event['title'] . " | Homecare Creators";
$page_desc     = $event['subtitle'] ?: $page_title;
$page_canonical = "https://homecarecreators.com/events/" . $event['slug'];
$og_title      = $page_title;
$og_desc       = $page_desc;
$og_image      = $event['banner_image'] ? ('https://homecarecreators.com' . $event['banner_image']) : null;

$page_css = <<<CSS
/* HERO */
.hero{background:var(--forest);position:relative;overflow:hidden;padding:140px 40px 70px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:760px;margin:0 auto;text-align:center}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:20px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(28px,4.2vw,46px);line-height:1.15;color:#fff;margin-bottom:14px}
.hero-subtitle{font-size:19px;line-height:1.6;color:rgba(255,255,255,.65);margin-bottom:28px}
.hero-meta{display:flex;gap:28px;justify-content:center;flex-wrap:wrap;margin-bottom:32px}
.hero-meta-item{display:flex;align-items:center;gap:8px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;color:#fff;font-weight:600}
.hero-meta-item i{color:var(--teal-lt)}
.hero-banner{max-width:700px;margin:0 auto;border-radius:var(--r-lg);overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.35)}
.hero-banner img{width:100%;display:block}

/* MAIN LAYOUT */
.event-body{background:#fff}
.event-grid{display:grid;grid-template-columns:1fr 400px;gap:56px;align-items:start}
.event-desc p{font-size:17px;line-height:1.85;color:var(--muted);margin-bottom:20px;white-space:pre-line}
.highlight-list{list-style:none;display:flex;flex-direction:column;gap:14px;margin:28px 0}
.highlight-list li{display:flex;align-items:flex-start;gap:14px;font-size:16px;line-height:1.6;color:var(--text)}
.highlight-list li i{color:var(--teal);font-size:16px;margin-top:3px;flex-shrink:0}
.giveaway-box{background:rgba(201,168,76,.08);border:1px dashed rgba(201,168,76,.4);border-radius:var(--r-lg);padding:24px 28px;margin-top:28px}
.giveaway-box-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;color:#7a5f18;margin-bottom:8px;display:flex;align-items:center;gap:8px}
.giveaway-box p{font-size:14.5px;color:#7a5f18;line-height:1.7;white-space:pre-line;margin:0}

/* REGISTRATION CARD */
.reg-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r-lg);padding:32px;position:sticky;top:90px;box-shadow:0 16px 48px rgba(10,46,30,.08)}
.reg-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:20px;color:var(--forest);margin-bottom:6px}
.reg-card-sub{font-size:14px;color:var(--muted);margin-bottom:22px}
.reg-form-group{margin-bottom:14px}
.reg-form-group label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;color:var(--muted);display:block;margin-bottom:6px}
.reg-form-group input{width:100%;padding:12px 14px;border:1px solid var(--border);border-radius:9px;font-family:'DM Sans',sans-serif;font-size:14px;background:#fff;outline:none;transition:border-color .2s}
.reg-form-group input:focus{border-color:var(--teal)}
.reg-submit{width:100%;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;border:none;border-radius:11px;padding:15px 24px;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;cursor:pointer;margin-top:6px;transition:.2s}
.reg-submit:hover{box-shadow:0 8px 28px rgba(29,158,117,.4)}
.reg-submit:disabled{opacity:.6;cursor:not-allowed}
.reg-privacy{font-size:11.5px;color:var(--muted);text-align:center;margin-top:12px}
.reg-success{display:none;text-align:center;padding:10px 0}
.reg-success i{font-size:46px;color:var(--teal);margin-bottom:14px;display:block}
.reg-success-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:700;color:var(--forest);margin-bottom:10px}
.reg-success p{font-size:14.5px;color:var(--muted);line-height:1.7;margin-bottom:16px}
.reg-zoom-box{background:#fff;border:1px solid var(--border);border-radius:10px;padding:16px;margin-bottom:16px;text-align:left}
.reg-zoom-box a{color:var(--teal);font-weight:700;word-break:break-all}
.reg-cal-links{display:flex;gap:8px;justify-content:center;flex-wrap:wrap}
.reg-cal-links a{font-size:12.5px;color:var(--teal);font-weight:700;text-decoration:none;border:1px solid var(--border);border-radius:8px;padding:8px 14px}
.reg-closed{text-align:center;padding:20px 0}
.reg-closed i{font-size:36px;color:var(--muted);margin-bottom:12px;display:block}
.reg-closed p{color:var(--muted);font-size:14.5px;line-height:1.7}

@media(max-width:1024px){
  .event-grid{grid-template-columns:1fr}
  .reg-card{position:static}
}
@media(max-width:640px){
  .hero{padding:120px 24px 50px}
  .hero-meta{gap:16px}
}
CSS;
include '../includes/header.php';
?>

<script type="application/ld+json">
<?= json_encode([
    '@context'  => 'https://schema.org',
    '@type'     => 'Event',
    'name'      => $event['title'],
    'description' => $event['subtitle'] ?: $event['title'],
    'startDate' => $dt->format('c'),
    'eventAttendanceMode' => 'https://schema.org/OnlineEventAttendanceMode',
    'eventStatus' => $event['status'] === 'cancelled' ? 'https://schema.org/EventCancelled' : 'https://schema.org/EventScheduled',
    'location'  => ['@type' => 'VirtualLocation', 'url' => $page_canonical],
    'image'     => $og_image ?: 'https://homecarecreators.com/images/home/homecarecreators-logo.png',
    'organizer' => ['@type' => 'Organization', 'name' => 'Homecare Creators', 'url' => 'https://homecarecreators.com'],
    'offers'    => ['@type' => 'Offer', 'price' => '0', 'priceCurrency' => 'USD', 'url' => $page_canonical, 'availability' => $is_full ? 'https://schema.org/SoldOut' : 'https://schema.org/InStock'],
], JSON_UNESCAPED_SLASHES) ?>
</script>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-breadcrumb"><a href="/">Home</a> / <a href="/events/">Events</a> / <span style="color:var(--teal-lt)"><?= htmlspecialchars($event['title']) ?></span></div>
    <div class="hero-badge"><i class="fa-solid fa-signal" style="margin-right:6px"></i><?= htmlspecialchars($event['badge_text'] ?: 'Free Event') ?></div>
    <h1 class="hero-h1"><?= htmlspecialchars($event['title']) ?></h1>
    <?php if ($event['subtitle']): ?><p class="hero-subtitle"><?= htmlspecialchars($event['subtitle']) ?></p><?php endif ?>
    <div class="hero-meta">
      <div class="hero-meta-item"><i class="fa-solid fa-calendar"></i><?= $dt->format('l, F j, Y') ?></div>
      <div class="hero-meta-item"><i class="fa-solid fa-clock"></i><?= $dt->format('g:i A') ?> <?= htmlspecialchars($dt->format('T')) ?></div>
      <div class="hero-meta-item"><i class="fa-solid fa-video"></i>Online — Join via Zoom</div>
    </div>
  </div>
  <?php if ($event['banner_image']): ?>
  <div class="hero-banner" data-reveal>
    <img src="<?= htmlspecialchars($event['banner_image']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
  </div>
  <?php endif ?>
</section>

<!-- BODY -->
<section class="event-body">
  <div class="container event-grid">
    <div class="event-desc" data-reveal>
      <?php if ($event['description']): ?><p><?= htmlspecialchars($event['description']) ?></p><?php endif ?>

      <?php if ($highlights): ?>
      <p class="section-label" style="margin-top:28px">What You'll Learn</p>
      <ul class="highlight-list">
        <?php foreach ($highlights as $h): ?>
        <li><i class="fa-solid fa-circle-check"></i><?= htmlspecialchars($h) ?></li>
        <?php endforeach ?>
      </ul>
      <?php endif ?>

      <?php if ($event['giveaway_text']): ?>
      <div class="giveaway-box">
        <div class="giveaway-box-title"><i class="fa-solid fa-gift"></i>Giveaway</div>
        <p><?= htmlspecialchars($event['giveaway_text']) ?></p>
      </div>
      <?php endif ?>
    </div>

    <div class="reg-card" data-reveal style="transition-delay:.1s">
      <?php if ($event['status'] === 'cancelled'): ?>
        <div class="reg-closed"><i class="fa-solid fa-circle-xmark"></i><p>This event has been cancelled.</p></div>
      <?php elseif ($is_past): ?>
        <div class="reg-closed"><i class="fa-solid fa-clock-rotate-left"></i><p>This event has already taken place.<br>Check out our <a href="/events/" style="color:var(--teal);font-weight:700">upcoming events</a>.</p></div>
      <?php elseif ($is_full): ?>
        <div class="reg-closed"><i class="fa-solid fa-users"></i><p>This event is full. <a href="/contact/" style="color:var(--teal);font-weight:700">Contact us</a> to join the waitlist.</p></div>
      <?php else: ?>
        <div id="regFormWrap">
          <div class="reg-card-title"><?= htmlspecialchars($event['cta_text'] ?: 'Register Free') ?></div>
          <div class="reg-card-sub">Takes 30 seconds. We'll email you the Zoom link.</div>
          <div class="hp-field" aria-hidden="true"><label for="rWebsite">Website</label><input type="text" id="rWebsite" tabindex="-1" autocomplete="off"></div>
          <div class="reg-form-group"><label for="rName">Full Name *</label><input type="text" id="rName" autocomplete="name" required></div>
          <div class="reg-form-group"><label for="rEmail">Email *</label><input type="email" id="rEmail" autocomplete="email" required></div>
          <div class="reg-form-group"><label for="rPhone">Phone *</label><input type="tel" id="rPhone" autocomplete="tel" required></div>
          <div class="reg-form-group"><label for="rAgency">Agency Name *</label><input type="text" id="rAgency" autocomplete="organization" required></div>
          <div class="reg-form-group"><label for="rRole">Your Role *</label><input type="text" id="rRole" placeholder="Owner, Administrator, etc." required></div>
          <button class="reg-submit" id="regSubmitBtn" onclick="submitRegistration()">Reserve My Spot</button>
          <div class="reg-privacy"><i class="fa-solid fa-lock" style="margin-right:4px"></i>100% private. No spam, ever.</div>
        </div>
        <div class="reg-success" id="regSuccess">
          <i class="fa-solid fa-circle-check"></i>
          <div class="reg-success-title">You're registered!</div>
          <p>A confirmation with the Zoom link has been sent to your email.</p>
          <div class="reg-zoom-box">
            <div style="font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:.5px;color:var(--muted);margin-bottom:6px">Zoom Link</div>
            <a href="<?= htmlspecialchars($event['zoom_link'] ?: '#') ?>" target="_blank"><?= htmlspecialchars($event['zoom_link'] ?: 'Will be emailed to you') ?></a>
          </div>
          <div class="reg-cal-links">
            <a href="https://calendar.google.com/calendar/render?action=TEMPLATE&text=<?= urlencode($event['title']) ?>&dates=<?= $dt_utc->format('Ymd\THis\Z') ?>/<?= (clone $dt_utc)->modify('+1 hour')->format('Ymd\THis\Z') ?>&details=<?= urlencode($event['subtitle'] ?: $event['title']) ?>&location=<?= urlencode($event['zoom_link'] ?: 'Online') ?>" target="_blank"><i class="fa-brands fa-google"></i> Add to Google Calendar</a>
          </div>
        </div>
      <?php endif ?>
    </div>
  </div>
</section>

<?php
$page_js = <<<JS
function submitRegistration() {
  var name   = (document.getElementById('rName').value || '').trim();
  var email  = (document.getElementById('rEmail').value || '').trim();
  var phone  = (document.getElementById('rPhone').value || '').trim();
  var agency = (document.getElementById('rAgency').value || '').trim();
  var role   = (document.getElementById('rRole').value || '').trim();
  var honeypot = (document.getElementById('rWebsite').value || '').trim();

  if (!name) { alert('Please enter your name.'); document.getElementById('rName').focus(); return; }
  if (!email || !email.includes('@') || !email.includes('.')) { alert('Please enter a valid email address.'); document.getElementById('rEmail').focus(); return; }
  if (!phone) { alert('Please enter your phone number.'); document.getElementById('rPhone').focus(); return; }
  if (!agency) { alert('Please enter your agency name.'); document.getElementById('rAgency').focus(); return; }
  if (!role) { alert('Please enter your role.'); document.getElementById('rRole').focus(); return; }

  var btn = document.getElementById('regSubmitBtn');
  btn.disabled = true;
  btn.textContent = 'Reserving...';

  fetch('/event-register-handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      event_slug: '{$event['slug']}',
      name: name, email: email, phone: phone, agency: agency, role: role,
      source: window.location.pathname + window.location.search,
      website: honeypot
    })
  })
  .then(function(r) { return r.json(); })
  .then(function(d) {
    if (d.success) {
      document.getElementById('regFormWrap').style.display = 'none';
      document.getElementById('regSuccess').style.display = 'block';
    } else {
      alert(d.message || 'Something went wrong. Please try again.');
      btn.disabled = false;
      btn.textContent = 'Reserve My Spot';
    }
  })
  .catch(function() {
    alert('Connection error. Please try again or email info@homecarecreators.com.');
    btn.disabled = false;
    btn.textContent = 'Reserve My Spot';
  });
}
JS;
include '../includes/footer.php';
?>
