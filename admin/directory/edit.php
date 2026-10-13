<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

$id      = (int)($_GET['id'] ?? 0);
$listing = $id ? hc_one("SELECT * FROM hc_directory_listings WHERE id=?", [$id]) : null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $company_name = trim($_POST['company_name'] ?? '');
    $slug         = hc_slug(trim($_POST['slug'] ?? '') ?: $company_name);
    $logo         = trim($_POST['logo'] ?? '');
    $description  = trim($_POST['description'] ?? '');
    $services     = trim($_POST['services'] ?? '');
    $city         = trim($_POST['city'] ?? '');
    $state        = strtoupper(trim($_POST['state'] ?? 'FL'));
    $service_areas = trim($_POST['service_areas'] ?? '');
    $address      = trim($_POST['address'] ?? '');
    $phone        = trim($_POST['phone'] ?? '');
    $email        = trim($_POST['email'] ?? '');
    $website      = trim($_POST['website'] ?? '');
    $license      = trim($_POST['license_number'] ?? '');
    $years        = trim($_POST['years_in_business'] ?? '');
    $featured     = isset($_POST['featured']) ? 1 : 0;
    $status       = in_array($_POST['status'] ?? '', ['pending','approved','rejected']) ? $_POST['status'] : 'pending';

    if (!$company_name || !$description || !$city) {
        hc_flash('Company name, description, and city are required.', 'error');
    } else {
        try {
            if ($id) {
                hc_q("UPDATE hc_directory_listings SET company_name=?,slug=?,logo=?,description=?,services=?,city=?,state=?,service_areas=?,address=?,phone=?,email=?,website=?,license_number=?,years_in_business=?,featured=?,status=?,approved_at=" . ($status==='approved' ? "IFNULL(approved_at,NOW())" : "NULL") . " WHERE id=?",
                    [$company_name,$slug,$logo,$description,$services,$city,$state,$service_areas,$address,$phone,$email,$website,$license,$years,$featured,$status,$id]);
            } else {
                $base = $slug; $n = 1;
                while (hc_val("SELECT id FROM hc_directory_listings WHERE slug=?", [$slug])) $slug = $base.'-'.$n++;
                hc_q("INSERT INTO hc_directory_listings (company_name,slug,logo,description,services,city,state,service_areas,address,phone,email,website,license_number,years_in_business,featured,status,approved_at) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?," . ($status==='approved' ? "NOW()" : "NULL") . ")",
                    [$company_name,$slug,$logo,$description,$services,$city,$state,$service_areas,$address,$phone,$email,$website,$license,$years,$featured,$status]);
                $id = (int)hc_db()->lastInsertId();
            }
            hc_flash('Listing saved.');
            header('Location: /admin/directory/edit.php?id='.$id); exit;
        } catch (Exception $e) {
            hc_flash('Error: '.$e->getMessage(), 'error');
        }
    }
    $listing = $id ? hc_one("SELECT * FROM hc_directory_listings WHERE id=?", [$id]) : $listing;
}

$title_val = $listing ? 'Edit: '.$listing['company_name'] : 'Add Listing';
hc_head($title_val);
hc_topbar($title_val, '<a href="/admin/">Admin</a> › <a href="/admin/directory/">Directory</a> › '.($listing ? 'Edit' : 'New'));
?>
<style>
.feat-dropzone{width:100%;min-height:120px;border:2px dashed var(--border);border-radius:10px;display:flex;flex-direction:column;align-items:center;justify-content:center;cursor:pointer;transition:.2s;position:relative;overflow:hidden;background:var(--cream)}
.feat-dropzone:hover,.feat-dropzone.drag{border-color:var(--teal);background:rgba(29,158,117,.04)}
.feat-dropzone img{max-width:100%;max-height:120px;display:block;border-radius:8px}
.feat-dropzone .dz-label{font-size:13px;color:var(--muted);text-align:center;padding:20px;pointer-events:none}
</style>
<div class="page-content">
<?= hc_show_flash() ?>

<form method="POST">
<div style="display:grid;grid-template-columns:1fr 320px;gap:20px;align-items:start">

<!-- MAIN COLUMN -->
<div>
  <div class="card">
    <div class="form-group" style="margin-bottom:10px">
      <label>Company Name</label>
      <input type="text" id="co-name" name="company_name" value="<?= h($listing['company_name'] ?? '') ?>" placeholder="e.g. Sunshine Home Care Services" required
             style="font-size:18px;font-weight:700;padding:12px 14px" oninput="autoSlug(this.value)">
    </div>
    <div style="display:flex;align-items:center;gap:6px;padding:0 2px 4px">
      <span style="font-size:13px;color:var(--muted);white-space:nowrap">/directory/</span>
      <input type="text" id="co-slug" name="slug" value="<?= h($listing['slug'] ?? '') ?>" <?= $listing ? 'data-locked=1' : '' ?>
             placeholder="auto-generated-slug" style="flex:1;font-size:13px;font-family:monospace;padding:6px 10px"
             oninput="this.dataset.locked=1">
    </div>
  </div>

  <div class="card">
    <div class="form-group">
      <label>Description <span>(required — shown on the listing page)</span></label>
      <textarea name="description" rows="5" placeholder="A few paragraphs about the agency, who they serve, and what makes them different..." required><?= h($listing['description'] ?? '') ?></textarea>
    </div>
    <div class="form-group" style="margin-bottom:0">
      <label>Services Offered <span>(one per line)</span></label>
      <textarea name="services" rows="5" placeholder="Personal Care&#10;Companion Care&#10;Skilled Nursing&#10;Respite Care"><?= h($listing['services'] ?? '') ?></textarea>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Service Areas <span style="font-weight:400;color:var(--muted)">(optional)</span></div>
    <textarea name="service_areas" rows="3" placeholder="Orlando, Winter Park, Kissimmee, Lake County"><?= h($listing['service_areas'] ?? '') ?></textarea>
    <div class="form-hint">Cities/counties this agency serves — shown as a list on the listing page.</div>
  </div>
</div><!-- /main col -->

<!-- SIDEBAR -->
<div style="position:sticky;top:70px;display:flex;flex-direction:column;gap:16px">

  <div class="card">
    <div class="card-title" style="margin-bottom:14px">Publish</div>
    <div class="form-group">
      <label>Status</label>
      <select name="status">
        <option value="pending"  <?= ($listing['status']??'pending')==='pending'?'selected':'' ?>>Pending Review</option>
        <option value="approved" <?= ($listing['status']??'')==='approved'?'selected':'' ?>>Approved (live)</option>
        <option value="rejected" <?= ($listing['status']??'')==='rejected'?'selected':'' ?>>Rejected</option>
      </select>
    </div>
    <div class="form-group" style="margin-bottom:0">
      <label style="display:flex;align-items:center;gap:8px;cursor:pointer">
        <input type="checkbox" name="featured" value="1" <?= !empty($listing['featured'])?'checked':'' ?> style="width:auto">
        Featured listing
      </label>
    </div>
    <div style="display:flex;flex-direction:column;gap:8px;margin-top:14px">
      <button type="submit" class="btn btn-primary btn-lg"><?= $listing ? 'Save Changes' : 'Add Listing' ?></button>
      <?php if ($listing && $listing['status']==='approved'): ?>
      <a href="/directory/<?= h($listing['slug']) ?>" target="_blank" class="btn btn-secondary btn-sm" style="text-align:center">↗ View Live Listing</a>
      <?php endif ?>
      <a href="/admin/directory/" class="btn btn-ghost btn-sm" style="text-align:center">← Back to Directory</a>
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Logo <span style="font-weight:400;color:var(--muted)">(optional)</span></div>
    <div class="feat-dropzone" id="logoDropZone" onclick="document.getElementById('logoFileInput').click()"
         ondragover="event.preventDefault();this.classList.add('drag')" ondragleave="this.classList.remove('drag')" ondrop="logoDrop(event)">
      <?php if (!empty($listing['logo'])): ?>
        <img src="<?= h($listing['logo']) ?>" alt="Logo preview">
      <?php else: ?>
        <div class="dz-label">Click to upload or drop image here</div>
      <?php endif ?>
    </div>
    <input type="file" id="logoFileInput" accept="image/*" style="display:none" onchange="uploadLogo(this.files[0])">
    <input type="text" id="logo-url" name="logo" value="<?= h($listing['logo'] ?? '') ?>" placeholder="Or paste an image URL" style="margin-top:8px">
    <div class="form-hint" id="logoStatus"></div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Location</div>
    <div class="form-group">
      <label>City</label>
      <input type="text" name="city" value="<?= h($listing['city'] ?? '') ?>" placeholder="Orlando" required>
    </div>
    <div class="form-group" style="margin-bottom:0">
      <label>State</label>
      <input type="text" name="state" value="<?= h($listing['state'] ?? 'FL') ?>" maxlength="2" style="max-width:80px;text-transform:uppercase">
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Contact Info</div>
    <div class="form-group">
      <label>Phone</label>
      <input type="text" name="phone" value="<?= h($listing['phone'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label>Email</label>
      <input type="email" name="email" value="<?= h($listing['email'] ?? '') ?>">
    </div>
    <div class="form-group">
      <label>Website</label>
      <input type="url" name="website" value="<?= h($listing['website'] ?? '') ?>" placeholder="https://">
    </div>
    <div class="form-group" style="margin-bottom:0">
      <label>Address <span>(optional)</span></label>
      <input type="text" name="address" value="<?= h($listing['address'] ?? '') ?>">
    </div>
  </div>

  <div class="card">
    <div class="card-title" style="margin-bottom:12px">Credentials <span style="font-weight:400;color:var(--muted)">(optional)</span></div>
    <div class="form-group">
      <label>License Number</label>
      <input type="text" name="license_number" value="<?= h($listing['license_number'] ?? '') ?>" placeholder="AHCA license #">
    </div>
    <div class="form-group" style="margin-bottom:0">
      <label>Years in Business</label>
      <input type="text" name="years_in_business" value="<?= h($listing['years_in_business'] ?? '') ?>" placeholder="e.g. 8">
    </div>
  </div>

</div><!-- /sidebar -->
</div><!-- /grid -->
</form>
</div>

<script>
function autoSlug(val) {
  var s = document.getElementById('co-slug');
  if (s.dataset.locked) return;
  s.value = val.toLowerCase().replace(/[^a-z0-9\s-]/g,'').replace(/[\s-]+/g,'-').replace(/^-|-$/g,'');
}
function setLogo(url) {
  document.getElementById('logo-url').value = url;
  document.getElementById('logoDropZone').innerHTML = '<img src="'+url+'" alt="Logo preview">';
}
function logoDrop(e) {
  e.preventDefault();
  document.getElementById('logoDropZone').classList.remove('drag');
  var f = e.dataTransfer.files[0];
  if (f && f.type.startsWith('image/')) uploadLogo(f);
}
function uploadLogo(file) {
  if (!file) return;
  document.getElementById('logoStatus').textContent = 'Uploading…';
  var fd = new FormData(); fd.append('file', file);
  fetch('/admin/blog/upload.php', {method:'POST', body:fd})
    .then(function(r){return r.json();})
    .then(function(d){
      if (d.success) { setLogo(d.url); document.getElementById('logoStatus').textContent = ''; }
      else document.getElementById('logoStatus').textContent = '❌ ' + d.error;
    })
    .catch(function(){ document.getElementById('logoStatus').textContent = '❌ Upload failed.'; });
}
</script>
<?php hc_foot(); ?>
