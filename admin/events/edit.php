<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$id    = (int)($_GET['id'] ?? 0);
$event = $id ? hc_one("SELECT * FROM hc_events WHERE id=?", [$id]) : null;

$timezones = [
    'America/New_York'  => 'Eastern (ET)',
    'America/Chicago'   => 'Central (CT)',
    'America/Denver'    => 'Mountain (MT)',
    'America/Los_Angeles' => 'Pacific (PT)',
];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title       = trim($_POST['title'] ?? '');
    $slug        = hc_slug(trim($_POST['slug'] ?? '') ?: $title);
    $badge_text  = trim($_POST['badge_text'] ?? '') ?: 'FREE LIVE MASTERCLASS';
    $subtitle    = trim($_POST['subtitle'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $highlights  = trim($_POST['highlights'] ?? '');
    $date_val    = trim($_POST['event_date'] ?? '');
    $time_val    = trim($_POST['event_time'] ?? '');
    $timezone    = trim($_POST['timezone'] ?? 'America/New_York');
    $zoom_link   = trim($_POST['zoom_link'] ?? '');
    $banner      = trim($_POST['banner_image'] ?? '');
    $giveaway    = trim($_POST['giveaway_text'] ?? '');
    $cta_text    = trim($_POST['cta_text'] ?? '') ?: 'Register Free';
    $max_att     = trim($_POST['max_attendees'] ?? '') !== '' ? (int)$_POST['max_attendees'] : null;
    $status      = $_POST['status'] ?? 'draft';

    $event_datetime = ($date_val && $time_val) ? "$date_val $time_val:00" : null;

    if (!$title) {
        hc_flash('Title is required.', 'error');
    } elseif (!$event_datetime) {
        hc_flash('Date and time are required.', 'error');
    } else {
        try {
            if ($id) {
                hc_q("UPDATE hc_events SET title=?,slug=?,badge_text=?,subtitle=?,description=?,highlights=?,event_datetime=?,timezone=?,zoom_link=?,banner_image=?,giveaway_text=?,cta_text=?,max_attendees=?,status=? WHERE id=?",
                    [$title,$slug,$badge_text,$subtitle,$description,$highlights,$event_datetime,$timezone,$zoom_link,$banner,$giveaway,$cta_text,$max_att,$status,$id]);
            } else {
                $base = $slug; $n = 1;
                while (hc_val("SELECT id FROM hc_events WHERE slug=?", [$slug])) $slug = $base.'-'.$n++;
                hc_q("INSERT INTO hc_events (title,slug,badge_text,subtitle,description,highlights,event_datetime,timezone,zoom_link,banner_image,giveaway_text,cta_text,max_attendees,status) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)",
                    [$title,$slug,$badge_text,$subtitle,$description,$highlights,$event_datetime,$timezone,$zoom_link,$banner,$giveaway,$cta_text,$max_att,$status]);
                $id = (int)hc_db()->lastInsertId();
            }
            hc_flash('Event '.($status==='published'?'published':'saved').'.');
            header('Location: /admin/events/edit.php?id='.$id); exit;
        } catch (Exception $e) {
            hc_flash('Error: '.$e->getMessage(), 'error');
        }
    }
    $event = $id ? hc_one("SELECT * FROM hc_events WHERE id=?", [$id]) : $event;
}

$dt_date = ''; $dt_time = '';
if ($event && $event['event_datetime']) {
    $parts = explode(' ', $event['event_datetime']);
    $dt_date = $parts[0] ?? '';
    $dt_time = isset($parts[1]) ? substr($parts[1], 0, 5) : '';
}

$title_val = $event ? 'Edit: '.$event['title'] : 'New Event';
hc_head($title_val);
hc_topbar($title_val, '<a href="/admin/">Admin</a> › <a href="/admin/events/">Events</a> › '.($event ? 'Edit' : 'New'));
?>
<style>
.feat-dropzone{width:100%;min-height:150px;border:2px dashed var(--border);border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;transition:.2s;position:relative;overflow:hidden;background:var(--cream)}
.feat-dropzone:hover,.feat-dropzone.drag{border-color:var(--teal);background:rgba(29,158,117,.04)}
.feat-dropzone img{width:100%;height:150px;object-fit:cover;display:block;border-radius:8px}
.feat-dropzone .dz-label{font-size:13px;color:var(--muted);text-align:center;padding:20px;pointer-events:none}
.feat-actions{display:flex;gap:8px;margin-top:8px}
</style>
<div class="page-content">
<?= hc_show_flash() ?>

<form method="POST">
<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start">

<!-- MAIN COLUMN -->
<div>
  <div class="card">
    <div class="form-group" style="margin-bottom:10px">
      <label>Event Title</label>
      <input type="text" id="ev-title" name="title" value="<?= h($event['title'] ?? '') ?>" placeholder="From Google to New Clients: SEO for Home Care Agencies" required
             style="font-size:18px;font-weight:700;padding:12px 14px" oninput="autoSlug(this.value)">
    </div>
    <div style="display:flex;align-items:center;gap:6px;padding:0 2px 4px">
      <span style="font-size:13px;color:var(--muted);white-space:nowrap">/events/event?slug=</span>
      <input type="text" id="ev-slug" name="slug" value="<?= h($event['slug'] ?? '') ?>" <?= $event ? 'data-locked=1' : '' ?>
             placeholder="auto-generated-slug" style="flex:1;font-size:13px;font-family:monospace;padding:6px 10px"
             oninput="this.dataset.locked=1">
    </div>
  </div>

  <div class="card">
    <div class="form-grid">
      <div class="form-group">
        <label>Badge Text</label>
        <input type="text" name="badge_text" value="<?= h($event['badge_text'] ?? 'FREE LIVE MASTERCLASS') ?>" placeholder="FREE LIVE MASTERCLASS">
      </div>
      <div class="form-group">
        <label>Subtitle</label>
        <input type="text" name="subtitle" value="<?= h($event['subtitle'] ?? '') ?>" placeholder="How SEO Can Help Your Home Care Agency Grow">
      </div>
    </div>
    <div class="form-group">
      <label>Description</label>
      <textarea name="description" rows="4" placeholder="A couple of paragraphs introducing the event..."><?= h($event['description'] ?? '') ?></textarea>
    </div>
    <div class="form-group">
      <label>What You'll Learn <span>(one bullet per line)</span></label>
      <textarea name="highlights" rows="5" placeholder="How families search for home care services on Google&#10;How to improve your local SEO and Google visibility&#10;How to turn website visitors into potential client inquiries&#10;Common SEO mistakes home care agencies should avoid"><?= h($event['highlights'] ?? '') ?></textarea>
      <div class="form-hint">Each line becomes a checklist item on the event page.</div>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Giveaway / Promo <span style="font-weight:400;color:var(--muted)">(optional)</span></div>
    <textarea name="giveaway_text" rows="3" placeholder="Win 1 of 3 Home Care Business Audits worth $500 each..."><?= h($event['giveaway_text'] ?? '') ?></textarea>
    <div class="form-hint">Shown as a highlighted callout on the event page. Include any eligibility/rules disclaimer here.</div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Zoom Link <span style="font-weight:400;color:var(--muted)">(private)</span></div>
    <input type="url" name="zoom_link" value="<?= h($event['zoom_link'] ?? '') ?>" placeholder="https://zoom.us/j/...">
    <div class="form-hint">Only shown to confirmed registrants (in their confirmation email and on the post-registration screen) — never shown publicly on the event page before registration.</div>
  </div>
</div><!-- /main col -->

<!-- SIDEBAR -->
<div style="position:sticky;top:70px;display:flex;flex-direction:column;gap:16px">

  <div class="card">
    <div class="card-title" style="margin-bottom:14px">Publish</div>
    <div class="form-group">
      <label>Status</label>
      <select name="status">
        <option value="draft"     <?= ($event['status']??'draft')==='draft'?'selected':'' ?>>Draft</option>
        <option value="published" <?= ($event['status']??'')==='published'?'selected':'' ?>>Published</option>
        <option value="completed" <?= ($event['status']??'')==='completed'?'selected':'' ?>>Completed</option>
        <option value="cancelled" <?= ($event['status']??'')==='cancelled'?'selected':'' ?>>Cancelled</option>
      </select>
    </div>
    <div style="display:flex;flex-direction:column;gap:8px">
      <button type="submit" class="btn btn-primary btn-lg"><?= $event ? 'Update Event' : 'Save Event' ?></button>
      <?php if ($event && $event['status']==='published'): ?>
      <a href="/events/event?slug=<?= h($event['slug']) ?>" target="_blank" class="btn btn-secondary btn-sm" style="text-align:center">↗ View Live Page</a>
      <?php endif ?>
      <?php if ($event): ?>
      <a href="/admin/events/registrations.php?event_id=<?= $event['id'] ?>" class="btn btn-secondary btn-sm" style="text-align:center">View Registrations</a>
      <?php endif ?>
      <a href="/admin/events/" class="btn btn-ghost btn-sm" style="text-align:center">← Back to Events</a>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Date &amp; Time</div>
    <div class="form-group">
      <label>Date</label>
      <input type="date" name="event_date" value="<?= h($dt_date) ?>" required>
    </div>
    <div class="form-group">
      <label>Time</label>
      <input type="time" name="event_time" value="<?= h($dt_time) ?>" required>
    </div>
    <div class="form-group">
      <label>Timezone</label>
      <select name="timezone">
        <?php foreach ($timezones as $tz=>$label): ?>
        <option value="<?= h($tz) ?>" <?= ($event['timezone'] ?? 'America/New_York')===$tz?'selected':'' ?>><?= h($label) ?></option>
        <?php endforeach ?>
      </select>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Banner Image</div>
    <div class="feat-dropzone" id="featDropZone" onclick="document.getElementById('bannerFileInput').click()"
         ondragover="event.preventDefault();this.classList.add('drag')" ondragleave="this.classList.remove('drag')" ondrop="bannerDrop(event)">
      <?php if (!empty($event['banner_image'])): ?>
        <img src="<?= h($event['banner_image']) ?>" alt="Banner preview">
      <?php else: ?>
        <div class="dz-label">Click to upload or drop image here</div>
      <?php endif ?>
    </div>
    <input type="file" id="bannerFileInput" accept="image/*" style="display:none" onchange="uploadBanner(this.files[0])">
    <div class="feat-actions">
      <input type="text" id="banner-url" name="banner_image" value="<?= h($event['banner_image'] ?? '') ?>" placeholder="Or paste an image URL" style="flex:1">
    </div>
    <div class="form-hint" id="bannerStatus"></div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Registration</div>
    <div class="form-group">
      <label>Button Text</label>
      <input type="text" name="cta_text" value="<?= h($event['cta_text'] ?? 'Register Free') ?>">
    </div>
    <div class="form-group">
      <label>Max Attendees <span>(optional)</span></label>
      <input type="number" name="max_attendees" value="<?= h($event['max_attendees'] ?? '') ?>" placeholder="Leave blank for unlimited" min="1">
    </div>
  </div>

</div><!-- /sidebar -->
</div><!-- /grid -->
</form>
</div>

<script>
function autoSlug(val) {
  var s = document.getElementById('ev-slug');
  if (s.dataset.locked) return;
  s.value = val.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/[\s-]+/g,'-').replace(/^-|-$/g,'');
}
function setBanner(url) {
  document.getElementById('banner-url').value = url;
  document.getElementById('featDropZone').innerHTML = '<img src="'+url+'" alt="Banner preview">';
}
function bannerDrop(e) {
  e.preventDefault();
  document.getElementById('featDropZone').classList.remove('drag');
  var f = e.dataTransfer.files[0];
  if (f && f.type.startsWith('image/')) uploadBanner(f);
}
function uploadBanner(file) {
  if (!file) return;
  document.getElementById('bannerStatus').textContent = 'Uploading…';
  var fd = new FormData(); fd.append('file', file);
  fetch('/admin/blog/upload.php', {method:'POST', body:fd})
    .then(function(r){return r.json();})
    .then(function(d){
      if (d.success) { setBanner(d.url); document.getElementById('bannerStatus').textContent = ''; }
      else document.getElementById('bannerStatus').textContent = '❌ ' + d.error;
    })
    .catch(function(){ document.getElementById('bannerStatus').textContent = '❌ Upload failed.'; });
}
</script>
<?php hc_foot(); ?>
