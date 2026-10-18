<?php
// Reusable "reviews proof" slider (same reviews shown on the homepage).
// Include from any page with: include '../includes/reviews-slider.php';
// (adjust the number of '../' to match the including file's depth)
?>
<style>
.rvs-section{background:var(--forest);overflow:hidden;position:relative}
.rvs-section::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;pointer-events:none}
.rvs-section .container{position:relative;z-index:1}
.rvs-header{text-align:center;margin-bottom:56px}
.rvs-header .section-label{justify-content:center;color:var(--mint)}
.rvs-header .section-label::before{background:var(--mint)}
.rvs-header .section-h2{color:#fff}
.rvs-header .section-h2 em{color:var(--mint)}
.rvs-slider-wrap{overflow:hidden;position:relative}
.rvs-track{display:flex;gap:24px;transition:transform .5s cubic-bezier(.4,0,.2,1);will-change:transform}
.rvs-card{background:var(--cream);border:1px solid var(--border);border-radius:22px;padding:32px;min-width:360px;max-width:360px;position:relative;overflow:hidden;flex-shrink:0}
.rvs-card::before{content:'\201C';position:absolute;top:-12px;right:20px;font-family:'Plus Jakarta Sans',sans-serif;font-size:120px;color:rgba(29,158,117,.08);line-height:1;pointer-events:none}
.rvs-stars{color:var(--gold);font-size:15px;margin-bottom:16px;letter-spacing:2px}
.rvs-quote{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;line-height:1.65;color:var(--forest);font-style:italic;margin-bottom:24px}
.rvs-author{display:flex;align-items:center;gap:13px}
.rvs-avatar{width:48px;height:48px;border-radius:50%;background:var(--teal);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:16px;flex-shrink:0}
.rvs-name{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;color:var(--forest)}
.rvs-role{font-size:12px;color:var(--muted);margin-top:2px}
.rvs-controls{display:flex;justify-content:center;gap:12px;margin-top:40px;align-items:center}
.rvs-btn{width:44px;height:44px;border-radius:50%;background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.16);color:#fff;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;transition:.25s}
.rvs-btn:hover{background:var(--teal);border-color:var(--teal)}
.rvs-dots{display:flex;gap:8px;align-items:center}
.rvs-dot{width:8px;height:8px;border-radius:50%;background:rgba(255,255,255,.2);cursor:pointer;transition:.3s;border:none}
.rvs-dot.active{background:var(--mint);width:24px;border-radius:4px}
@media(max-width:640px){.rvs-card{min-width:calc(100vw - 72px);max-width:calc(100vw - 72px)}}
</style>

<!-- REVIEWS SLIDER -->
<section class="rvs-section" id="reviews">
  <div class="container">
    <div class="rvs-header" data-reveal>
      <p class="section-label">What Owners Say</p>
      <h2 class="section-h2">Homecare Owners<br><em>Love the Results</em></h2>
    </div>
    <div class="rvs-slider-wrap" data-reveal style="transition-delay:.1s">
      <div class="rvs-track" id="rvsTrack">
        <div class="rvs-card">
          <div class="rvs-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="rvs-quote">"We had 6 Google reviews before Homecare Creators and almost no website traffic to speak of. Four months later we're at 52 reviews, ranked #1 in our city, and our inquiry calls have tripled. Worth every penny."</p>
          <div class="rvs-author">
            <div class="rvs-avatar">SR</div>
            <div>
              <div class="rvs-name">Sarah R.</div>
              <div class="rvs-role">Owner, Comfort Home Care &middot; Chicago, IL</div>
            </div>
          </div>
        </div>
        <div class="rvs-card">
          <div class="rvs-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="rvs-quote">"I'd tried two other marketing agencies before this one, and neither understood homecare at all. Homecare Creators knew exactly what we needed. Their SEO strategy was nothing like what we'd seen, and it worked."</p>
          <div class="rvs-author">
            <div class="rvs-avatar">MJ</div>
            <div>
              <div class="rvs-name">Marcus J.</div>
              <div class="rvs-role">Founder, Golden Years Care &middot; Atlanta, GA</div>
            </div>
          </div>
        </div>
        <div class="rvs-card">
          <div class="rvs-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="rvs-quote">"Their AI Search SEO is unlike anything I've seen from a marketing agency. We show up now when families search on ChatGPT and Google AI, and honestly, I don't think our competitors even know this is possible yet."</p>
          <div class="rvs-author">
            <div class="rvs-avatar">LD</div>
            <div>
              <div class="rvs-name">Linda D.</div>
              <div class="rvs-role">CEO, Caring Hands Agency &middot; Houston, TX</div>
            </div>
          </div>
        </div>
        <div class="rvs-card">
          <div class="rvs-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="rvs-quote">"Zero to 28 private-pay clients in 7 months. The website redesign paired with local SEO is genuinely a powerful combination, and the monthly strategy calls keep us honest."</p>
          <div class="rvs-author">
            <div class="rvs-avatar">TW</div>
            <div>
              <div class="rvs-name">Tamara W.</div>
              <div class="rvs-role">Owner, Sunrise Senior Care &middot; Phoenix, AZ</div>
            </div>
          </div>
        </div>
        <div class="rvs-card">
          <div class="rvs-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="rvs-quote">"The follow-up automation alone paid for the retainer. Leads used to sit for days, now they get a response in minutes, day or night."</p>
          <div class="rvs-author">
            <div class="rvs-avatar">RB</div>
            <div>
              <div class="rvs-name">Robert B.</div>
              <div class="rvs-role">CEO, Premier Home Health &middot; Dallas, TX</div>
            </div>
          </div>
        </div>
        <div class="rvs-card">
          <div class="rvs-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="rvs-quote">"Three months in, a family told us they found us through ChatGPT. I was floored, honestly. This team is ahead of the curve, and homecare is the only thing they do."</p>
          <div class="rvs-author">
            <div class="rvs-avatar">AC</div>
            <div>
              <div class="rvs-name">Angela C.</div>
              <div class="rvs-role">Director, CareFirst Agency &middot; Miami, FL</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="rvs-controls">
      <button class="rvs-btn" onclick="rvsSlide(-1)" aria-label="Previous"><i class="fa-solid fa-chevron-left"></i></button>
      <div class="rvs-dots" id="rvsDots"></div>
      <button class="rvs-btn" onclick="rvsSlide(1)" aria-label="Next"><i class="fa-solid fa-chevron-right"></i></button>
    </div>
  </div>
</section>
<script>
(function(){
  var track = document.getElementById('rvsTrack');
  var dotsWrap = document.getElementById('rvsDots');
  if (!track || !dotsWrap) return;
  var total = track.children.length;
  var current = 0, maxSlide = 0;
  function visibleCount(){ return window.innerWidth <= 640 ? 1 : (window.innerWidth <= 1024 ? 2 : 3); }
  function cardStep(){ return track.children[0] ? (track.children[0].getBoundingClientRect().width + 24) : 384; }
  function build(){
    maxSlide = Math.max(0, total - visibleCount());
    current = Math.min(current, maxSlide);
    dotsWrap.innerHTML = '';
    for (var i = 0; i <= maxSlide; i++) {
      var d = document.createElement('button');
      d.className = 'rvs-dot' + (i === current ? ' active' : '');
      d.setAttribute('aria-label', 'Slide ' + (i + 1));
      (function(idx){ d.addEventListener('click', function(){ go(idx); }); })(i);
      dotsWrap.appendChild(d);
    }
    go(current);
  }
  function go(n){
    current = Math.max(0, Math.min(n, maxSlide));
    track.style.transform = 'translateX(-' + (current * cardStep()) + 'px)';
    dotsWrap.querySelectorAll('.rvs-dot').forEach(function(d, i){ d.classList.toggle('active', i === current); });
  }
  window.rvsSlide = function(dir){ go(current + dir); };
  window.addEventListener('resize', build);
  build();
})();
</script>
