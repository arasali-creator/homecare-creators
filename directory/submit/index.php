<?php
require_once '../../admin/config.php';
require_once '../../admin/includes/db.php';
require_once '../../admin/includes/functions.php';
require_once '../../admin/includes/directory.php';
require_once '../../includes/directory-ui.php';
hc_dir_ensure_schema();

$plans = hc_dir_plans();
$plan  = isset($plans[$_GET['plan'] ?? '']) ? $_GET['plan'] : 'premium';
$claim = null;
if (!empty($_GET['claim'])) {
    $claim = hc_one("SELECT * FROM hc_directory_listings WHERE slug=? AND status='approved'", [trim($_GET['claim'])]);
}
$claimTaken = $claim && !empty($claim['owner_confirmed_at']);

$page_title = $claim ? 'Claim ' . $claim['company_name'] . ' | Homecare Creators Directory' : 'List Your Home Care Agency | Homecare Creators Directory';
$page_desc  = 'Add your home care agency to the Homecare Creators directory. Free and premium listings, confirmed with the agency owner and reviewed by our team.';
$page_canonical = 'https://homecarecreators.com/directory/submit/';
$og_title = 'List Your Home Care Agency | Homecare Creators Directory';
$og_desc  = $page_desc;

$page_css = hc_dir_base_css() . <<<CSS
body{background:#f7f7f5}
.sx-band{background:var(--forest);padding:104px 0 36px}
.sx-band h1{color:#fff;font-size:clamp(26px,3.2vw,36px);font-weight:800;line-height:1.15;margin-bottom:8px}
.sx-band p{color:rgba(255,255,255,.62);font-size:15.5px;max-width:620px}
.sx-grid{display:grid;grid-template-columns:1fr 340px;gap:32px;padding:32px 0 80px;align-items:start}
.sx-step{background:#fff;border:1px solid var(--line);border-radius:14px;padding:28px;margin-bottom:18px}
.sx-step-h{display:flex;gap:14px;align-items:flex-start;margin-bottom:20px}
.sx-step-n{width:28px;height:28px;border-radius:50%;background:var(--forest);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:13px;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.sx-step-h h2{font-size:18px;font-weight:800;line-height:1.3}
.sx-step-h p{font-size:13.5px;color:var(--ink-3);margin-top:2px}

.sx-plans{display:grid;grid-template-columns:repeat(3,1fr);gap:12px}
.sx-plan{position:relative;border:1.5px solid var(--line);border-radius:12px;padding:16px;cursor:pointer;transition:border-color .15s,background .15s;display:block}
.sx-plan:hover{border-color:#b9c2bc}
.sx-plan input{position:absolute;opacity:0;pointer-events:none}
.sx-plan.on{border-color:var(--teal);background:#f6fbf9;box-shadow:0 0 0 3px rgba(29,158,117,.12)}
.sx-plan-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:6px}
.sx-plan-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:15px}
.sx-radio{width:18px;height:18px;border-radius:50%;border:2px solid #c6cdc8;position:relative}
.sx-plan.on .sx-radio{border-color:var(--teal)}
.sx-plan.on .sx-radio::after{content:"";position:absolute;inset:3px;border-radius:50%;background:var(--teal)}
.sx-plan-price{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:22px;margin-bottom:6px}
.sx-plan-price small{font-size:12.5px;color:var(--ink-3);font-weight:600}
.sx-plan-blurb{font-size:12.5px;color:var(--ink-3);line-height:1.45}
.sx-plan-pop{position:absolute;top:-9px;left:14px;background:var(--teal);color:#fff;font-size:10px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;padding:3px 7px;border-radius:4px;font-family:'Plus Jakarta Sans',sans-serif}

.sx-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.sx-row-3{display:grid;grid-template-columns:2fr 1fr 1fr;gap:14px}
.sx-f{margin-bottom:16px}
.sx-f label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:700;color:var(--ink);margin-bottom:6px}
.sx-f label em{font-style:normal;font-weight:500;color:var(--ink-3)}
.sx-f input,.sx-f select,.sx-f textarea{width:100%;font:inherit;font-size:14.5px;border:1px solid var(--line);border-radius:8px;padding:11px 13px;background:#fff;color:var(--ink);outline:0;transition:border-color .15s}
.sx-f input:focus,.sx-f select:focus,.sx-f textarea:focus{border-color:var(--teal);box-shadow:0 0 0 3px rgba(29,158,117,.1)}
.sx-f .err{border-color:#dc2626}
.sx-hint{font-size:12.5px;color:var(--ink-3);margin-top:5px}
.sx-count{float:right;font-weight:500;color:var(--ink-3);font-size:12px}
.sx-checks{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.sx-chk{display:flex;align-items:center;gap:9px;border:1px solid var(--line);border-radius:8px;padding:10px 12px;font-size:13.5px;color:var(--ink-2);cursor:pointer;transition:.15s;line-height:1.3}
.sx-chk:hover{border-color:#b9c2bc}
.sx-chk input{accent-color:var(--teal);width:15px;height:15px;flex-shrink:0}
.sx-chk.on{border-color:var(--teal);background:#f6fbf9;color:var(--ink)}
.sx-paid-only{border-top:1px dashed var(--line);margin-top:6px;padding-top:18px}
.sx-paid-only h3{font-size:14px;font-weight:800;margin-bottom:4px;display:flex;align-items:center;gap:8px}
.sx-paid-only h3 span{font-size:10.5px;font-weight:800;letter-spacing:.06em;text-transform:uppercase;color:var(--teal);background:#e7f5ef;padding:3px 6px;border-radius:4px}
.sx-attest{display:flex;gap:12px;align-items:flex-start;background:var(--bg);border:1px solid var(--line);border-radius:10px;padding:14px 16px;font-size:13.5px;color:var(--ink-2);line-height:1.55;cursor:pointer}
.sx-attest input{accent-color:var(--teal);width:17px;height:17px;margin-top:2px;flex-shrink:0}
.sx-submit{width:100%;padding:16px;font-size:15px;margin-top:6px}
.sx-legal{font-size:12px;color:var(--ink-3);text-align:center;margin-top:12px;line-height:1.5}

.sx-claimbox{display:flex;gap:16px;align-items:center;background:#fff;border:1px solid var(--line);border-radius:14px;padding:18px;margin-bottom:18px}
.sx-claimbox h3{font-size:16px;font-weight:800}
.sx-claimbox p{font-size:13.5px;color:var(--ink-3)}

.sx-side{position:sticky;top:90px;display:flex;flex-direction:column;gap:16px}
.sx-sum{background:#fff;border:1px solid var(--line);border-radius:14px;overflow:hidden}
.sx-sum-h{padding:18px 20px;border-bottom:1px solid var(--line-2)}
.sx-sum-h small{font-size:11.5px;font-weight:800;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-3);font-family:'Plus Jakarta Sans',sans-serif}
.sx-sum-h div{display:flex;justify-content:space-between;align-items:baseline;margin-top:4px}
.sx-sum-h b{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px}
.sx-sum-h span{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:19px}
.sx-sum ul{list-style:none;margin:0;padding:14px 20px 18px}
.sx-sum li{display:flex;gap:10px;font-size:13.5px;color:var(--ink-2);padding:5px 0;line-height:1.45}
.sx-sum li i{color:var(--teal);font-size:11px;margin-top:5px}
.sx-next{background:#fff;border:1px solid var(--line);border-radius:14px;padding:18px 20px}
.sx-next h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:800;margin-bottom:10px}
.sx-next ol{margin:0;padding-left:18px;font-size:13.5px;color:var(--ink-2);line-height:1.6}
.sx-next li{padding:3px 0}

.sx-done{display:none;background:#fff;border:1px solid var(--line);border-radius:14px;padding:44px 32px;text-align:center}
.sx-done i.big{width:64px;height:64px;border-radius:50%;background:#e7f5ef;color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:26px;margin:0 auto 18px}
.sx-done h2{font-size:24px;font-weight:800;margin-bottom:10px}
.sx-done p{font-size:15.5px;color:var(--ink-2);line-height:1.65;max-width:480px;margin:0 auto 8px}
.sx-mail{display:inline-flex;gap:10px;align-items:center;background:var(--bg);border:1px solid var(--line);border-radius:10px;padding:12px 16px;margin:14px 0;font-weight:700;font-size:14.5px}

@media(max-width:1024px){
  .sx-grid{grid-template-columns:1fr}
  .sx-side{position:static;order:-1}
  .sx-next{display:none}
}
@media(max-width:640px){
  .sx-step{padding:20px 16px}
  .sx-plans,.sx-row,.sx-row-3{grid-template-columns:1fr}
  .sx-checks{grid-template-columns:1fr 1fr}
}
CSS;
include '../../includes/header.php';
?>
<div id="scrollProgress"></div>
<div class="dx">

<section class="sx-band">
  <div class="dx-wrap">
    <div class="dx-crumbs"><a href="/directory/">Directory</a><span>/</span><?= $claim ? 'Claim listing' : 'List your agency' ?></div>
    <h1><?= $claim ? 'Claim ' . htmlspecialchars($claim['company_name']) : 'List your home care agency' ?></h1>
    <p><?= $claim
        ? 'Confirm you represent this agency to manage the listing, update details and upgrade your profile.'
        : 'Takes about 5 minutes. Every listing is confirmed with the agency owner and reviewed by our team before it goes live.' ?></p>
  </div>
</section>

<div class="dx-wrap">
<?php if ($claimTaken): ?>
  <div class="sx-grid" style="grid-template-columns:1fr">
    <div class="sx-step" style="text-align:center;padding:44px">
      <h2 style="font-size:20px;font-weight:800;margin-bottom:8px">This listing has already been claimed</h2>
      <p style="color:var(--ink-3)">If you're the owner and didn't claim it, email <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a> and we'll verify and transfer it.</p>
    </div>
  </div>
<?php else: ?>
  <div class="sx-grid">
    <div>
      <form id="sxForm" novalidate>
        <div class="hp-field" aria-hidden="true"><input type="text" name="hp_website" tabindex="-1" autocomplete="off"></div>
        <input type="hidden" name="mode" value="<?= $claim ? 'claim' : 'new' ?>">
        <?php if ($claim): ?><input type="hidden" name="claim_slug" value="<?= htmlspecialchars($claim['slug']) ?>"><?php endif ?>

        <?php if ($claim): ?>
        <div class="sx-claimbox">
          <?= hc_dir_logo($claim, 56, hc_dir_tier($claim) !== 'free') ?>
          <div><h3><?= htmlspecialchars($claim['company_name']) ?></h3><p><?= htmlspecialchars($claim['city'] . ', ' . $claim['state']) ?> · <a href="/directory/<?= urlencode($claim['slug']) ?>" target="_blank">View listing</a></p></div>
        </div>
        <?php endif ?>

        <!-- STEP 1: PLAN -->
        <div class="sx-step">
          <div class="sx-step-h"><span class="sx-step-n">1</span><div><h2>Choose your plan</h2><p>Paid plans are invoiced by email, so you don't need a card today. You can change plans anytime.</p></div></div>
          <div class="sx-plans">
            <?php foreach ($plans as $k => $p): ?>
            <label class="sx-plan<?= $plan === $k ? ' on' : '' ?>">
              <input type="radio" name="plan" value="<?= $k ?>" <?= $plan === $k ? 'checked' : '' ?>>
              <?php if ($k === 'premium'): ?><span class="sx-plan-pop">Popular</span><?php endif ?>
              <div class="sx-plan-top"><span class="sx-plan-name"><?= htmlspecialchars($p['name']) ?></span><span class="sx-radio"></span></div>
              <div class="sx-plan-price"><?= $p['price'] ? '$' . $p['price'] . '<small>/mo</small>' : 'Free' ?></div>
              <div class="sx-plan-blurb"><?= htmlspecialchars($p['blurb']) ?></div>
            </label>
            <?php endforeach ?>
          </div>
        </div>

        <?php if (!$claim): ?>
        <!-- STEP 2: AGENCY -->
        <div class="sx-step">
          <div class="sx-step-h"><span class="sx-step-n">2</span><div><h2>About your agency</h2><p>This is what families see on your public profile.</p></div></div>

          <div class="sx-f"><label for="fName">Agency name</label><input id="fName" name="company_name" required autocomplete="organization"></div>
          <div class="sx-row-3">
            <div class="sx-f"><label for="fCity">City</label><input id="fCity" name="city" required></div>
            <div class="sx-f"><label for="fState">State</label><input id="fState" name="state" maxlength="2" placeholder="FL" required style="text-transform:uppercase"></div>
            <div class="sx-f"><label for="fYears">Years in business <em>(optional)</em></label><input id="fYears" name="years_in_business" inputmode="numeric" placeholder="e.g. 8"></div>
          </div>
          <div class="sx-f"><label for="fAddress">Street address <em>(optional; leave blank if you only serve clients at home)</em></label><input id="fAddress" name="address" autocomplete="street-address"></div>
          <div class="sx-f">
            <label for="fDesc">Description <span class="sx-count" id="descCount">0 / 40 min</span></label>
            <textarea id="fDesc" name="description" rows="5" required placeholder="Who you care for, the areas you serve, how you screen and train caregivers, and what makes your agency different."></textarea>
          </div>

          <div class="sx-f">
            <label>Services offered</label>
            <div class="sx-checks">
              <?php foreach (HC_DIR_SERVICES as $s): ?>
              <label class="sx-chk"><input type="checkbox" name="services[]" value="<?= htmlspecialchars($s) ?>"><?= htmlspecialchars($s) ?></label>
              <?php endforeach ?>
            </div>
            <input name="services_other" placeholder="Other services, separated by commas" style="margin-top:10px">
          </div>

          <div class="sx-f">
            <label>Payment accepted</label>
            <div class="sx-checks">
              <?php foreach (HC_DIR_PAYMENTS as $p): ?>
              <label class="sx-chk"><input type="checkbox" name="payment_accepted[]" value="<?= htmlspecialchars($p) ?>"><?= htmlspecialchars($p) ?></label>
              <?php endforeach ?>
            </div>
          </div>

          <div class="sx-f"><label for="fAreas">Service area</label><input id="fAreas" name="service_areas" placeholder="Orlando, Winter Park, Kissimmee, Orange County"><div class="sx-hint">Cities or counties you serve, separated by commas.</div></div>

          <div class="sx-row">
            <div class="sx-f"><label for="fPhone">Agency phone</label><input id="fPhone" name="phone" type="tel" required autocomplete="tel"></div>
            <div class="sx-f"><label for="fEmail">Agency email</label><input id="fEmail" name="email" type="email" required></div>
          </div>
          <div class="sx-row">
            <div class="sx-f"><label for="fWebsite">Website</label><input id="fWebsite" name="website" type="url" placeholder="https://"></div>
            <div class="sx-f"><label for="fLicense">State license number</label><input id="fLicense" name="license_number" placeholder="e.g. AHCA #"></div>
          </div>
          <div class="sx-row">
            <div class="sx-f"><label for="fLang">Languages spoken <em>(optional)</em></label><input id="fLang" name="languages" placeholder="English, Spanish, Haitian Creole"></div>
            <div class="sx-f"><label for="fHours">Hours <em>(optional)</em></label><input id="fHours" name="hours" placeholder="24/7, or Mon–Fri 8am–6pm"></div>
          </div>

          <div class="sx-paid-only" id="paidFields">
            <h3>Profile extras <span>Premium &amp; Featured</span></h3>
            <p class="sx-hint" style="margin:0 0 14px">After you confirm, you can email us your cover photo and gallery photos.</p>
            <div class="sx-f"><label for="fTag">Tagline</label><input id="fTag" name="tagline" maxlength="160" placeholder="e.g. Compassionate in-home care across Central Florida since 2014"></div>
            <div class="sx-f" style="margin-bottom:0"><label for="fLogo">Logo URL <em>(optional)</em></label><input id="fLogo" name="logo" type="url" placeholder="https://yourwebsite.com/logo.png"></div>
          </div>
        </div>
        <?php else: ?>
        <div class="sx-step">
          <div class="sx-step-h"><span class="sx-step-n">2</span><div><h2>Anything to update?</h2><p>Tell us what's wrong or missing on the current listing and we'll update it after you confirm.</p></div></div>
          <div class="sx-f" style="margin-bottom:0"><textarea name="claim_notes" rows="4" placeholder="e.g. New phone number, add Skilled Nursing, we now serve Lake County…"></textarea></div>
        </div>
        <?php endif ?>

        <!-- STEP 3: OWNER -->
        <div class="sx-step">
          <div class="sx-step-h"><span class="sx-step-n">3</span><div><h2>Owner or authorized representative</h2><p>We send a confirmation link to this person, and nothing is published until they confirm. This is kept private and never shown on your listing.</p></div></div>
          <div class="sx-row">
            <div class="sx-f"><label for="oName">Full name</label><input id="oName" name="owner_name" required autocomplete="name"></div>
            <div class="sx-f"><label for="oTitle">Your role</label>
              <select id="oTitle" name="owner_title" required>
                <option value="">Select…</option>
                <option>Owner</option><option>Co-Owner / Partner</option><option>Administrator</option><option>Director of Operations</option>
                <option>Marketing Manager</option><option>Office Manager</option><option>Franchisee</option><option>Other authorized staff</option>
              </select>
            </div>
          </div>
          <div class="sx-row">
            <div class="sx-f"><label for="oEmail">Email</label><input id="oEmail" name="owner_email" type="email" required autocomplete="email"><div class="sx-hint">An email on your agency's domain gets verified faster.</div></div>
            <div class="sx-f"><label for="oPhone">Direct phone</label><input id="oPhone" name="owner_phone" type="tel" required autocomplete="tel"><div class="sx-hint">We may call to verify ownership.</div></div>
          </div>
          <label class="sx-attest"><input type="checkbox" name="owner_authorized" value="1" required><span>I confirm I am the owner or an authorized representative of this agency, and that the information I've provided is accurate. I agree to the <a href="/terms-of-service.php" target="_blank">Terms</a> and <a href="/privacy-policy.php" target="_blank">Privacy Policy</a>.</span></label>
          <button type="submit" class="dx-btn is-primary sx-submit" id="sxBtn">Submit for review</button>
          <p class="sx-legal" id="sxLegal">You'll receive a confirmation email right away.</p>
        </div>
      </form>

      <div class="sx-done" id="sxDone">
        <i class="fa-regular fa-envelope big"></i>
        <h2>Check your inbox to confirm</h2>
        <p>We sent a confirmation link to</p>
        <div class="sx-mail" id="sxDoneMail"></div>
        <p id="sxDoneNext"></p>
        <p style="font-size:13.5px;color:var(--ink-3);margin-top:16px">Can't find it? Check your spam folder or email info@homecarecreators.com.</p>
      </div>
    </div>

    <aside class="sx-side">
      <div class="sx-sum" id="sxSum"></div>
      <div class="sx-next">
        <h4>What happens next</h4>
        <ol id="sxNext"></ol>
      </div>
    </aside>
  </div>
<?php endif ?>
</div>
</div>
<?php
$plansJson = json_encode(array_map(fn($p) => ['name' => $p['name'], 'price' => $p['price'], 'features' => $p['features']], $plans), JSON_HEX_TAG | JSON_HEX_APOS);
$isClaim = $claim ? 'true' : 'false';
$page_js = <<<JS
(function(){
  var PLANS = {$plansJson}, IS_CLAIM = {$isClaim};
  var form = document.getElementById('sxForm');
  if (!form) return;
  function esc(s){ var d = document.createElement('div'); d.textContent = s; return d.innerHTML; }
  function currentPlan(){ var r = form.querySelector('input[name=plan]:checked'); return r ? r.value : 'free'; }

  function render(){
    var k = currentPlan(), p = PLANS[k];
    form.querySelectorAll('.sx-plan').forEach(function(el){ el.classList.toggle('on', el.querySelector('input').checked); });
    var pf = document.getElementById('paidFields'); if (pf) pf.style.display = k === 'free' ? 'none' : '';
    document.getElementById('sxSum').innerHTML =
      '<div class="sx-sum-h"><small>Your plan</small><div><b>' + esc(p.name) + '</b><span>' + (p.price ? '$' + p.price + '<small style="font-size:12px;color:var(--ink-3)">/mo</small>' : 'Free') + '</span></div></div>' +
      '<ul>' + p.features.map(function(f){ return '<li><i class="fa-solid fa-check"></i>' + esc(f) + '</li>'; }).join('') + '</ul>';
    var steps = ['Confirm ownership from the email we send you.'];
    if (k !== 'free') steps.push('We email your invoice within 1 business day.');
    steps.push(IS_CLAIM ? 'We verify and update the listing.' : 'Our team reviews your listing (1–2 business days).');
    steps.push(k !== 'free' ? 'Once paid, your ' + p.name + ' profile goes live.' : 'You get an email when it’s live.');
    document.getElementById('sxNext').innerHTML = steps.map(function(s){ return '<li>' + esc(s) + '</li>'; }).join('');
    document.getElementById('sxBtn').textContent = k === 'free' ? (IS_CLAIM ? 'Claim listing' : 'Submit free listing') : (IS_CLAIM ? 'Claim & request ' + p.name : 'Submit & request ' + p.name);
  }
  form.addEventListener('change', function(e){
    if (e.target.type === 'checkbox' && e.target.closest('.sx-chk')) e.target.closest('.sx-chk').classList.toggle('on', e.target.checked);
    render();
  });
  render();

  var desc = document.getElementById('fDesc');
  if (desc) desc.addEventListener('input', function(){
    var n = desc.value.trim().length, c = document.getElementById('descCount');
    c.textContent = n + (n < 40 ? ' / 40 min' : ' characters');
    c.style.color = n < 40 ? '' : 'var(--teal)';
  });

  function fail(el, msg){ el.classList.add('err'); el.focus(); alert(msg); setTimeout(function(){ el.classList.remove('err'); }, 2500); return false; }

  form.addEventListener('submit', function(e){
    e.preventDefault();
    var fd = new FormData(form), data = {services: [], payment_accepted: []};
    fd.forEach(function(v, k){
      if (k === 'services[]') data.services.push(v);
      else if (k === 'payment_accepted[]') data.payment_accepted.push(v);
      else data[k] = typeof v === 'string' ? v.trim() : v;
    });
    data.source = location.pathname;
    var q = function(n){ return form.querySelector('[name="' + n + '"]'); };

    if (!IS_CLAIM) {
      if (!data.company_name) return fail(q('company_name'), 'Please enter your agency name.');
      if (!data.city) return fail(q('city'), 'Please enter your city.');
      if (!/^[A-Za-z]{2}$/.test(data.state || '')) return fail(q('state'), 'Please enter your 2-letter state code.');
      if ((data.description || '').length < 40) return fail(q('description'), 'Please write a description of at least 40 characters.');
      if (!data.services.length && !data.services_other) { alert('Please select at least one service.'); return; }
      if (!data.phone) return fail(q('phone'), 'Please enter your agency phone.');
      if (!/^\S+@\S+\.\S+$/.test(data.email || '')) return fail(q('email'), 'Please enter a valid agency email.');
    }
    if (!data.owner_name) return fail(q('owner_name'), 'Please enter the owner or representative name.');
    if (!data.owner_title) return fail(q('owner_title'), 'Please select your role.');
    if (!/^\S+@\S+\.\S+$/.test(data.owner_email || '')) return fail(q('owner_email'), 'Please enter a valid email for the owner/representative.');
    if (!data.owner_phone) return fail(q('owner_phone'), 'Please enter a direct phone number.');
    if (!q('owner_authorized').checked) { alert('Please confirm you are the owner or an authorized representative.'); return; }
    data.owner_authorized = 1;

    var btn = document.getElementById('sxBtn'), label = btn.textContent;
    btn.disabled = true; btn.textContent = 'Submitting…';
    fetch('/directory-submit-handler.php', {method:'POST', headers:{'Content-Type':'application/json'}, body: JSON.stringify(data)})
      .then(function(r){ return r.json(); })
      .then(function(d){
        if (!d.success) { alert(d.message || 'Something went wrong. Please try again.'); btn.disabled = false; btn.textContent = label; return; }
        var k = currentPlan();
        form.style.display = 'none';
        document.getElementById('sxDoneMail').innerHTML = '<i class="fa-regular fa-envelope" style="color:var(--teal)"></i>' + esc(data.owner_email);
        document.getElementById('sxDoneNext').textContent = k === 'free'
          ? 'Click the link to confirm you represent the agency. We review the listing once it’s confirmed.'
          : 'Click the link to confirm you represent the agency. We’ll then email your ' + PLANS[k].name + ' invoice within 1 business day.';
        document.getElementById('sxDone').style.display = 'block';
        window.scrollTo({top: 0, behavior: 'smooth'});
      })
      .catch(function(){ alert('Connection error. Please try again or email info@homecarecreators.com.'); btn.disabled = false; btn.textContent = label; });
  });
})();
JS;
include '../../includes/footer.php';
