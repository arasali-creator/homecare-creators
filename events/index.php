<?php
$page_title = "Free Events & Webinars for Home Care Agencies | Homecare Creators";
$page_desc = "Join free live events and masterclasses for home care agency owners — learn SEO, marketing, and growth strategies from Homecare Creators.";
$page_canonical = "https://homecarecreators.com/events/";
$og_title = "Free Events & Webinars for Home Care Agencies | Homecare Creators";
$og_desc = "Live online events built for home care agency owners who want to grow their business.";
$page_css = <<<CSS
/* HERO */
.hero{min-height:40vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 60px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:760px;margin:0 auto;text-align:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:22px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(30px,4.4vw,50px);line-height:1.1;color:#fff;margin-bottom:16px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:18px;line-height:1.75;color:rgba(255,255,255,.65)}

/* EVENTS GRID */
.events-section{background:#fff}
.events-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(320px,1fr));gap:28px;margin-top:40px}
.event-card{background:var(--warm);border:1px solid var(--border);border-radius:var(--r-lg);overflow:hidden;transition:.25s;text-decoration:none;display:flex;flex-direction:column}
.event-card:hover{transform:translateY(-4px);box-shadow:0 16px 48px rgba(10,46,30,.1);border-color:rgba(29,158,117,.25)}
.event-card-img{aspect-ratio:16/9;background:var(--forest);position:relative;overflow:hidden}
.event-card-img img{width:100%;height:100%;object-fit:contain;display:block}
.event-card-badge{position:absolute;top:14px;left:14px;background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:10px;font-weight:700;letter-spacing:.5px;text-transform:uppercase;padding:5px 12px;border-radius:20px}
.event-card-body{padding:24px;display:flex;flex-direction:column;gap:10px;flex:1}
.event-card-date{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--teal);text-transform:uppercase;letter-spacing:.5px;display:flex;align-items:center;gap:6px}
.event-card-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:700;color:var(--forest);line-height:1.3}
.event-card-desc{font-size:14.5px;color:var(--muted);line-height:1.6;flex:1}
.event-card-cta{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--teal);margin-top:4px}

.empty-events{text-align:center;padding:60px 20px;color:var(--muted)}
.empty-events svg{width:48px;height:48px;opacity:.3;margin:0 auto 16px;display:block}

/* RESPONSIVE */
@media(max-width:640px){
  .hero{padding:120px 24px 50px}
  .events-grid{grid-template-columns:1fr}
}
CSS;
include '../includes/header.php';

require_once '../admin/config.php';
require_once '../admin/includes/db.php';

$now = date('Y-m-d H:i:s');
$upcoming = hc_all("SELECT * FROM hc_events WHERE status='published' AND event_datetime >= ? ORDER BY event_datetime ASC", [$now]);
$past = hc_all("SELECT * FROM hc_events WHERE status IN ('published','completed') AND event_datetime < ? ORDER BY event_datetime DESC LIMIT 6", [$now]);
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-badge"><i class="fa-solid fa-calendar-days" style="margin-right:6px"></i>Events</div>
    <h1 class="hero-h1">Free Live Events for<br><em>Home Care Agency Owners</em></h1>
    <p class="hero-desc">Practical, no-fluff sessions on SEO, marketing, and growth — built specifically for people running home care agencies.</p>
  </div>
</section>

<!-- UPCOMING EVENTS -->
<section class="events-section">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Upcoming</p>
      <h2 class="section-h2">Register for an <em>Upcoming Event</em></h2>
    </div>
    <?php if ($upcoming): ?>
    <div class="events-grid" data-reveal style="transition-delay:.1s">
      <?php foreach ($upcoming as $e):
        $dt = new DateTime($e['event_datetime'], new DateTimeZone($e['timezone'] ?: 'America/New_York'));
      ?>
      <a href="/events/<?= urlencode($e['slug']) ?>" class="event-card">
        <div class="event-card-img">
          <?php if ($e['banner_image']): ?>
          <img src="<?= htmlspecialchars($e['banner_image']) ?>" alt="<?= htmlspecialchars($e['title']) ?>" loading="lazy">
          <?php endif ?>
          <div class="event-card-badge"><?= htmlspecialchars($e['badge_text'] ?: 'Free Event') ?></div>
        </div>
        <div class="event-card-body">
          <?php
          $_tz_short = ['America/New_York'=>'ET','America/Chicago'=>'CT','America/Denver'=>'MT','America/Los_Angeles'=>'PT'][$e['timezone']] ?? $dt->format('T');
          ?>
          <div class="event-card-date"><i class="fa-solid fa-calendar"></i><?= $dt->format('l, F j, Y \a\t g:i A') ?> <?= htmlspecialchars($_tz_short) ?></div>
          <div class="event-card-title"><?= htmlspecialchars($e['title']) ?></div>
          <?php if ($e['subtitle']): ?><div class="event-card-desc"><?= htmlspecialchars($e['subtitle']) ?></div><?php endif ?>
          <div class="event-card-cta"><?= htmlspecialchars($e['cta_text'] ?: 'Register Free') ?> &rarr;</div>
        </div>
      </a>
      <?php endforeach ?>
    </div>
    <?php else: ?>
    <div class="empty-events">
      <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><rect x="3" y="4" width="18" height="18" rx="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
      <p>No upcoming events right now — check back soon.</p>
    </div>
    <?php endif ?>
  </div>
</section>

<?php if ($past): ?>
<!-- PAST EVENTS -->
<section class="events-section" style="background:var(--cream)">
  <div class="container">
    <div data-reveal>
      <p class="section-label">Past Events</p>
      <h2 class="section-h2">Previous <em>Sessions</em></h2>
    </div>
    <div class="events-grid" data-reveal style="transition-delay:.1s">
      <?php foreach ($past as $e):
        $dt = new DateTime($e['event_datetime'], new DateTimeZone($e['timezone'] ?: 'America/New_York'));
      ?>
      <div class="event-card" style="opacity:.75">
        <div class="event-card-img">
          <?php if ($e['banner_image']): ?>
          <img src="<?= htmlspecialchars($e['banner_image']) ?>" alt="<?= htmlspecialchars($e['title']) ?>" loading="lazy">
          <?php endif ?>
          <div class="event-card-badge" style="background:var(--muted)">Past Event</div>
        </div>
        <div class="event-card-body">
          <div class="event-card-date"><i class="fa-solid fa-calendar"></i><?= $dt->format('F j, Y') ?></div>
          <div class="event-card-title"><?= htmlspecialchars($e['title']) ?></div>
        </div>
      </div>
      <?php endforeach ?>
    </div>
  </div>
</section>
<?php endif ?>

<?php include '../includes/footer.php'; ?>
