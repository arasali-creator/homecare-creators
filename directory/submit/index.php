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
.sx-head{display:grid;grid-template-columns:1.2fr .8fr;gap:48px;align-items:end;margin-bottom:56px}
.sx-head .dx-h1{font-size:clamp(38px,5vw,68px)}
.sx-head .dx-lead{max-width:440px}
.sx-trust{display:flex;flex-wrap:wrap;gap:8px;margin-top:22px}
.sx-trust span{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--hair);border-radius:100px;padding:8px 14px;font-size:13px;color:var(--ink);background:rgba(255,255,255,.5)}
.sx-trust i{color:var(--teal);font-size:11px}
.sx-grid{display:grid;grid-template-columns:1fr 380px;gap:28px;align-items:start}
.sx-step{background:#fff;border-radius:32px;padding:40px;margin-bottom:12px}
.sx-step-h{display:grid;grid-template-columns:56px 1fr;gap:8px;margin-bottom:30px}
.sx-step-n{font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:#a3ada6;padding-top:8px}
.sx-step-h h2{font-size:28px;font-weight:800;letter-spacing:-.035em;line-height:1.15}
.sx-step-h h2 em{font-weight:700}
.sx-step-h p{font-size:14.5px;color:var(--mut);margin-top:6px;line-height:1.55}

.sx-plans{display:grid;grid-template-columns:repeat(3,1fr);gap:10px}
.sx-plan{position:relative;border:1.5px solid var(--hair);border-radius:24px;padding:20px;cursor:pointer;transition:border-color .15s,background .15s;display:block;background:var(--cream)}
.sx-plan:hover{border-color:rgba(10,46,30,.35)}
.sx-plan input{position:absolute;opacity:0;pointer-events:none}
.sx-plan.on{border-color:var(--ink);background:#fff;box-shadow:0 0 0 1px var(--ink)}
.sx-plan-top{display:flex;justify-content:space-between;align-items:center;margin-bottom:18px}
.sx-plan-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;color:var(--ink)}
.sx-radio{width:20px;height:20px;border-radius:50%;border:1.5px solid rgba(10,46,30,.3);position:relative;background:#fff}
.sx-plan.on .sx-radio{border-color:var(--ink);background:var(--ink)}
.sx-plan.on .sx-radio::after{content:"";position:absolute;inset:5px;border-radius:50%;background:#fff}
.sx-plan-price{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:34px;letter-spacing:-.04em;color:var(--ink);line-height:1;margin-bottom:10px}
.sx-plan-price small{font-size:13px;color:var(--mut);font-weight:600;letter-spacing:0}
.sx-plan-blurb{font-size:13px;color:var(--mut);line-height:1.45}
.sx-plan-pop{position:absolute;top:-10px;right:16px;background:var(--teal);color:#fff;font-size:10.5px;font-weight:700;padding:5px 10px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif}

.sx-row{display:grid;grid-template-columns:1fr 1fr;gap:14px}
.sx-row-3{display:grid;grid-template-columns:2fr 1fr 1fr;gap:14px}
.sx-f{margin-bottom:18px}
.sx-f label{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:13px;font-weight:600;color:var(--ink);margin:0 0 8px 4px}
.sx-f label em{font-style:normal;font-weight:400;color:var(--mut)}
.sx-f input,.sx-f select,.sx-f textarea{width:100%;font:inherit;font-size:15px;border:1px solid var(--hair);border-radius:16px;padding:14px 16px;background:var(--cream);color:var(--ink);outline:0;transition:border-color .15s,background .15s}
.sx-f input:focus,.sx-f select:focus,.sx-f textarea:focus{border-color:var(--ink);background:#fff}
.sx-f .err{border-color:#dc2626!important;background:#fff}
.sx-hint{font-size:12.5px;color:var(--mut);margin:7px 0 0 4px}
.sx-count{float:right;font-weight:500;color:var(--mut);font-size:12px}
.sx-checks{display:flex;flex-wrap:wrap;gap:8px}
.sx-chk{display:inline-flex;align-items:center;gap:8px;border:1px solid var(--hair);border-radius:100px;padding:10px 16px;font-size:14px;color:var(--ink);cursor:pointer;transition:.15s;background:#fff;user-select:none}
.sx-chk:hover{border-color:var(--ink)}
.sx-chk input{display:none}
.sx-chk::before{content:"+";font-weight:600;color:var(--mut);width:10px}
.sx-chk.on{background:var(--ink);border-color:var(--ink);color:#fff}
.sx-chk.on::before{content:"✓";color:var(--teal-lt)}
.sx-paid-only{background:var(--cream);border-radius:24px;padding:24px;margin-top:8px}
.sx-paid-only h3{font-size:16px;font-weight:700;margin-bottom:4px;display:flex;align-items:center;gap:10px}
.sx-paid-only h3 span{font-size:11px;font-weight:700;color:#fff;background:var(--teal);padding:4px 9px;border-radius:100px}
.sx-paid-only .sx-f input{background:#fff}
.sx-attest{display:flex;gap:14px;align-items:flex-start;background:var(--cream);border-radius:20px;padding:18px 20px;font-size:14px;color:var(--txt);line-height:1.6;cursor:pointer;margin-top:6px}
.sx-attest input{accent-color:var(--ink);width:18px;height:18px;margin-top:2px;flex-shrink:0}
.sx-attest a{color:var(--ink);text-decoration:underline!important;text-underline-offset:3px}
.sx-submit{width:100%;padding:18px!important;font-size:15.5px!important;margin-top:20px}
.sx-legal{font-size:12.5px;color:var(--mut);text-align:center;margin-top:14px}

.sx-claimbox{display:flex;gap:16px;align-items:center;background:#fff;border-radius:28px;padding:20px 24px;margin-bottom:12px}
.sx-claimbox h3{font-size:18px;font-weight:700}
.sx-claimbox p{font-size:14px;color:var(--mut)}
.sx-claimbox a{color:var(--ink);text-decoration:underline!important;text-underline-offset:3px}

.sx-side{position:sticky;top:96px;display:flex;flex-direction:column;gap:12px}
.sx-sum{background:var(--ink);border-radius:32px;padding:30px;color:#fff}
.sx-sum-h small{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;color:rgba(255,255,255,.5)}
.sx-sum-h div{display:flex;justify-content:space-between;align-items:baseline;margin:10px 0 20px;padding-bottom:20px;border-bottom:1px solid rgba(255,255,255,.12)}
.sx-sum-h b{font-family:'Plus Jakarta Sans',sans-serif;font-size:24px;letter-spacing:-.03em}
.sx-sum-h span{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:30px;letter-spacing:-.04em}
.sx-sum ul{list-style:none;margin:0;padding:0}
.sx-sum li{display:flex;gap:12px;font-size:14px;color:rgba(255,255,255,.78);padding:6px 0;line-height:1.45}
.sx-sum li i{color:var(--teal-lt);font-size:11px;margin-top:5px}
.sx-next{background:#fff;border-radius:32px;padding:28px 30px}
.sx-next h4{font-size:16px;font-weight:700;margin-bottom:14px}
.sx-next ol{margin:0;padding:0;list-style:none;counter-reset:s}
.sx-next li{counter-increment:s;display:grid;grid-template-columns:34px 1fr;gap:6px;padding:9px 0;font-size:14px;color:var(--txt);line-height:1.5;border-top:1px solid var(--hair-2)}
.sx-next li:first-child{border-top:0}
.sx-next li::before{content:"0" counter(s);font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;color:#a3ada6;padding-top:2px}

.sx-done{display:none;background:#fff;border-radius:32px;padding:56px 36px;text-align:center}
.sx-done .dx-arrow{width:64px;height:64px;font-size:22px;background:var(--teal);color:#fff;border:0;margin-bottom:22px}
.sx-done h2{font-size:32px;font-weight:800;letter-spacing:-.035em;margin-bottom:12px}
.sx-done p{font-size:16px;color:var(--mut);line-height:1.65;max-width:460px;margin:0 auto 8px}
.sx-mail{display:inline-flex;gap:10px;align-items:center;background:var(--cream);border-radius:100px;padding:12px 20px;margin:12px 0 16px;font-weight:600;font-size:15px;color:var(--ink)}

@media(max-width:1100px){
  .sx-head{grid-template-columns:1fr;gap:16px}
  .sx-grid{grid-template-columns:1fr}
  .sx-side{position:static;order:-1}
  .sx-next{display:none}
}
@media(max-width:700px){
  .sx-step{padding:26px 20px;border-radius:26px}
  .sx-step-h{grid-template-columns:1fr;gap:4px}
  .sx-step-h h2{font-size:24px}
  .sx-plans,.sx-row,.sx-row-3{grid-template-columns:1fr}
  .sx-sum{padding:24px;border-radius:26px}
}
CSS;
include '../../includes/header.php';
?>
<div id="scrollProgress"></div>
<div class="dx">
<div class="dx-frame is-first">
<section class="dx-panel">
<div class="dx-in">
  <div class="sx-head">
    <div>
      <div class="dx-crumbs"><a href="/directory/">Directory</a><i class="fa-solid fa-chevron-right"></i><?= $claim ? 'Claim listing' : 'List your agency' ?></div>
      <h1 class="dx-h1"><?= $claim ? 'Claim <em>' . htmlspecialchars($claim['company_name']) . '.</em>' : 'List your agency<br><em>in five minutes.</em>' ?></h1>
    </div>
    <div>
      <p class="dx-lead"><?= $claim
          ? 'Confirm you represent this agency to manage the listing, update its details and upgrade your profile.'
          : 'Every listing is confirmed with the agency owner and reviewed by our team before it goes live.' ?></p>
      <div class="sx-trust"><span><i class="fa-solid fa-check"></i>Free plan available</span><span><i class="fa-solid fa-check"></i>No card needed</span><span><i class="fa-solid fa-check"></i>Owner-verified</span></div>
    </div>
  </div>

<?php if ($claimTaken): ?>
  <div class="sx-grid" style="grid-template-columns:1fr">
    <div class="sx-step" style="text-align:center;padding:44px">
      <h2 style="font-size:20px;font-weight:800;margin-bottom:8px">This listing has already been claimed</h2>
      <p style="color:var(--mut)">If you're the owner and didn't claim it, email <a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a> and we'll verify and transfer it.</p>
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
          <div class="sx-step-h"><span class="sx-step-n">01</span><div><h2>Choose your <em>plan.</em></h2><p>Paid plans are invoiced by email, so you don't need a card today. You can change plans anytime.</p></div></div>
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
          <div class="sx-step-h"><span class="sx-step-n">02</span><div><h2>About your <em>agency.</em></h2><p>This is what families see on your public profile.</p></div></div>

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
          <div class="sx-step-h"><span class="sx-step-n">02</span><div><h2>Anything to <em>update?</em></h2><p>Tell us what's wrong or missing on the current listing and we'll update it after you confirm.</p></div></div>
          <div class="sx-f" style="margin-bottom:0"><textarea name="claim_notes" rows="4" placeholder="e.g. New phone number, add Skilled Nursing, we now serve Lake County…"></textarea></div>
        </div>
        <?php endif ?>

        <!-- STEP 3: OWNER -->
        <div class="sx-step">
          <div class="sx-step-h"><span class="sx-step-n">03</span><div><h2>Owner or <em>authorized rep.</em></h2><p>We send a confirmation link to this person, and nothing is published until they confirm. This is kept private and never shown on your listing.</p></div></div>
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
          <button type="submit" class="dx-btn is-dark sx-submit" id="sxBtn">Submit for review</button>
          <p class="sx-legal" id="sxLegal">You'll receive a confirmation email right away.</p>
        </div>
      </form>

      <div class="sx-done" id="sxDone">
        <span class="dx-arrow"><i class="fa-regular fa-envelope"></i></span>
        <h2>Check your <em>inbox.</em></h2>
        <p>We sent a confirmation link to</p>
        <div class="sx-mail" id="sxDoneMail"></div>
        <p id="sxDoneNext"></p>
        <p style="font-size:13.5px;color:var(--mut);margin-top:16px">Can't find it? Check your spam folder or email info@homecarecreators.com.</p>
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
</section>
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
      '<div class="sx-sum-h"><small>Your plan</small><div><b>' + esc(p.name) + '</b><span>' + (p.price ? '$' + p.price + '<small style="font-size:13px;color:rgba(255,255,255,.5);font-weight:600">/mo</small>' : 'Free') + '</span></div></div>' +
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
