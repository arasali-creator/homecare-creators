<?php
// Reusable "case study proof" slider.
// Include from any page with: include '../includes/case-study-slider.php';
// (adjust the number of '../' to match the including file's depth)
$csm_studies = require __DIR__ . '/case-studies-data.php';
?>
<style>
.csm-section{background:var(--cream);padding:88px 40px;overflow:hidden}
.csm-header{text-align:center;margin-bottom:44px;max-width:640px;margin-left:auto;margin-right:auto}
.csm-header .section-label{justify-content:center}
.csm-header .section-h2{text-align:center}
.csm-slider-wrap{overflow:hidden;position:relative;max-width:1160px;margin:0 auto}
.csm-track{display:flex;gap:24px;transition:transform .5s cubic-bezier(.4,0,.2,1);will-change:transform}
.csm-card{background:#fff;border:1px solid var(--border);border-radius:18px;overflow:hidden;min-width:360px;max-width:360px;flex-shrink:0;transition:.25s}
.csm-card:hover{box-shadow:0 14px 40px rgba(10,46,30,.1);transform:translateY(-3px)}
.csm-card img{width:100%;display:block;border-bottom:1px solid var(--border)}
.csm-card-body{padding:20px 22px 24px}
.csm-card-badge{font-family:'Syne',sans-serif;font-size:10px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--teal);margin-bottom:8px}
.csm-card-title{font-family:'Syne',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:14px}
.csm-card-title span{color:var(--muted);font-weight:500}
.csm-stats-row{display:flex;gap:10px}
.csm-stat{flex:1;background:var(--warm);border:1px solid var(--border);border-radius:10px;padding:10px 6px;text-align:center}
.csm-stat-num{font-family:'Instrument Serif',serif;font-size:19px;color:var(--teal);line-height:1}
.csm-stat-label{font-size:9px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600;margin-top:3px}
.csm-controls{display:flex;justify-content:center;gap:12px;margin-top:32px;align-items:center}
.csm-btn{width:40px;height:40px;border-radius:50%;background:var(--forest);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:14px;transition:.25s}
.csm-btn:hover{background:var(--teal)}
.csm-dots{display:flex;gap:8px;align-items:center}
.csm-dot{width:8px;height:8px;border-radius:50%;background:var(--border);cursor:pointer;transition:.3s;border:none}
.csm-dot.active{background:var(--teal);width:22px;border-radius:4px}
.csm-cta{text-align:center;margin-top:36px}
@media(max-width:900px){.csm-card{min-width:300px;max-width:300px}}
@media(max-width:640px){.csm-section{padding:56px 20px}.csm-card{min-width:calc(100vw - 72px);max-width:calc(100vw - 72px)}}
</style>

<!-- CASE STUDY PROOF SLIDER -->
<section class="csm-section">
  <div class="container">
    <div class="csm-header" data-reveal>
      <p class="section-label">Real Results</p>
      <h2 class="section-h2">Real Campaigns.<br><em>Real Numbers.</em></h2>
      <p class="section-sub" style="margin:12px auto 0;text-align:center">A few of the home care agencies we've helped grow with SEO.</p>
    </div>
    <div class="csm-slider-wrap" data-reveal style="transition-delay:.1s">
      <div class="csm-track" id="csmSliderTrack">
        <?php foreach ($csm_studies as $c): ?>
        <div class="csm-card">
          <img src="/images/case-studies/<?= htmlspecialchars($c['img']) ?>" alt="<?= htmlspecialchars($c['name'].' lead generation dashboard showing '.$c['stats'][0][0].' '.$c['stats'][0][1]) ?>" title="<?= htmlspecialchars($c['name'].' campaign results') ?>" loading="lazy">
          <div class="csm-card-body">
            <div class="csm-card-badge">Case Study <?= htmlspecialchars($c['num']) ?></div>
            <h3 class="csm-card-title"><?= htmlspecialchars($c['name']) ?><?= $c['region'] ? ' <span>| '.htmlspecialchars($c['region']).'</span>' : '' ?></h3>
            <div class="csm-stats-row">
              <?php foreach (array_slice($c['stats'], 0, 2) as $s): ?>
              <div class="csm-stat"><div class="csm-stat-num"><?= htmlspecialchars($s[0]) ?></div><div class="csm-stat-label"><?= htmlspecialchars($s[1]) ?></div></div>
              <?php endforeach; ?>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
    <div class="csm-controls">
      <button class="csm-btn" onclick="csmSlide(-1)" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>
      <div class="csm-dots" id="csmSliderDots"></div>
      <button class="csm-btn" onclick="csmSlide(1)" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
    <div class="csm-cta">
      <a href="/case-studies/" class="btn-primary"><i class="fa-solid fa-chart-line"></i>View All Case Studies</a>
    </div>
  </div>
</section>
<script>
(function(){
  var track = document.getElementById('csmSliderTrack');
  var dotsWrap = document.getElementById('csmSliderDots');
  if (!track || !dotsWrap) return;
  var total = track.children.length;
  var current = 0, maxSlide = 0;
  function visibleCount(){ return window.innerWidth <= 640 ? 1 : (window.innerWidth <= 900 ? 2 : 3); }
  function cardStep(){ return track.children[0] ? (track.children[0].getBoundingClientRect().width + 24) : 384; }
  function build(){
    maxSlide = Math.max(0, total - visibleCount());
    current = Math.min(current, maxSlide);
    dotsWrap.innerHTML = '';
    for (var i = 0; i <= maxSlide; i++) {
      var d = document.createElement('button');
      d.className = 'csm-dot' + (i === current ? ' active' : '');
      d.setAttribute('aria-label', 'Slide ' + (i + 1));
      (function(idx){ d.addEventListener('click', function(){ go(idx); }); })(i);
      dotsWrap.appendChild(d);
    }
    go(current);
  }
  function go(n){
    current = Math.max(0, Math.min(n, maxSlide));
    track.style.transform = 'translateX(-' + (current * cardStep()) + 'px)';
    dotsWrap.querySelectorAll('.csm-dot').forEach(function(d, i){ d.classList.toggle('active', i === current); });
  }
  window.csmSlide = function(dir){ go(current + dir); };
  window.addEventListener('resize', build);
  build();
})();
</script>
