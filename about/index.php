<?php
$page_canonical = "https://homecarecreators.com/about/";
if (strpos($_SERVER['REQUEST_URI'] ?? '', '.php') !== false) {
    header('Location: ' . $page_canonical, true, 301);
    exit;
}
$page_title = "About Us | Homecare Creators";
$page_desc = "Meet Asifa Rani, Founder & CEO of Homecare Creators — a marketing agency built exclusively for home care agencies in Florida.";
$og_title = "About Us | Homecare Creators";
$og_desc = "Meet the founder behind Homecare Creators and why we built a marketing agency exclusively for home care agencies.";
$og_image = "https://homecarecreators.com/images/team/asifa-rani-founder-ceo.jpg";
$page_css = <<<CSS
/* HERO */
.hero{min-height:60vh;background:var(--forest);position:relative;overflow:hidden;display:flex;align-items:center;padding:140px 40px 80px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-inner{position:relative;z-index:2;max-width:760px;margin:0 auto;text-align:center}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:24px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(32px,4.6vw,54px);line-height:1.1;color:#fff;margin-bottom:18px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:18px;line-height:1.75;color:rgba(255,255,255,.65)}

/* FOUNDER */
.founder-section{background:#fff}
.founder-inner{display:grid;grid-template-columns:340px 1fr;gap:56px;align-items:start}
.founder-photo-wrap{position:relative}
.founder-photo{width:100%;aspect-ratio:1/1.05;border-radius:var(--r-lg);overflow:hidden;background:var(--cream);border:1px solid var(--border)}
.founder-photo img{width:100%;height:100%;object-fit:cover;display:block}
.founder-social{display:flex;gap:10px;margin-top:18px}
.founder-social a{width:38px;height:38px;border-radius:9px;background:var(--cream);border:1px solid var(--border);display:flex;align-items:center;justify-content:center;color:var(--forest);font-size:15px;text-decoration:none;transition:.2s}
.founder-social a:hover{background:var(--teal);color:#fff;border-color:var(--teal)}
.founder-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:700;color:var(--forest);margin-top:16px}
.founder-title{font-size:13px;color:var(--muted)}
.founder-bio p{font-size:17px;line-height:1.85;color:var(--muted);margin-bottom:20px}
.founder-bio p:first-child{font-size:20px;color:var(--forest);font-weight:500;line-height:1.7}

/* VALUES */
.values-section{background:var(--cream)}
.values-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:24px;margin-top:48px}
.value-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:28px}
.value-card-icon{width:42px;height:42px;background:rgba(29,158,117,.1);border-radius:10px;display:flex;align-items:center;justify-content:center;color:var(--teal);font-size:17px;margin-bottom:16px}
.value-card h4{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:10px}
.value-card p{font-size:15px;color:var(--muted);line-height:1.75}

/* CONTACT STRIP */
.contact-strip{background:var(--forest)}
.contact-strip-inner{display:flex;justify-content:center;gap:56px;flex-wrap:wrap;text-align:center}
.contact-strip-item{display:flex;flex-direction:column;gap:6px}
.contact-strip-item i{color:var(--teal-lt);font-size:20px;margin-bottom:6px}
.contact-strip-item a{color:#fff;text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:16px}
.contact-strip-item span{font-size:12px;color:rgba(255,255,255,.45);text-transform:uppercase;letter-spacing:1px;font-family:'Plus Jakarta Sans',sans-serif}

/* RESPONSIVE */
@media(max-width:900px){
  .founder-inner{grid-template-columns:1fr;gap:32px}
  .founder-photo{max-width:280px;margin:0 auto}
  .values-grid{grid-template-columns:1fr 1fr}
}
@media(max-width:640px){
  .hero{padding:120px 24px 60px}
  .values-grid{grid-template-columns:1fr}
  .contact-strip-inner{gap:28px}
}
CSS;
include '../includes/header.php';
?>

<div id="scrollProgress"></div>

<!-- HERO -->
<section class="hero">
  <div class="hero-bg-grid"></div>
  <div class="hero-inner">
    <div class="hero-badge"><i class="fa-solid fa-user" style="margin-right:6px"></i>About Us</div>
    <h1 class="hero-h1">The Marketing Agency Built<br><em>By Someone Who Gets It</em></h1>
    <p class="hero-desc">Homecare Creators exists because home care agencies deserve a marketing partner who actually understands the industry — not a generalist shop treating you like every other local business.</p>
  </div>
</section>

<!-- FOUNDER -->
<section class="founder-section">
  <div class="container founder-inner">
    <div data-reveal>
      <div class="founder-photo">
        <img src="/images/team/asifa-rani-founder-ceo.jpg" alt="Asifa Rani, Founder and CEO of Homecare Creators" title="Asifa Rani — Founder & CEO, Homecare Creators">
      </div>
      <div class="founder-name">Asifa Rani</div>
      <div class="founder-title">Founder &amp; CEO, Homecare Creators</div>
      <div class="founder-social">
        <a href="https://www.linkedin.com/in/asifa-rani/" target="_blank" rel="noopener" aria-label="Asifa Rani on LinkedIn"><i class="fa-brands fa-linkedin-in"></i></a>
        <a href="mailto:info@homecarecreators.com" aria-label="Email Homecare Creators"><i class="fa-solid fa-envelope"></i></a>
      </div>
    </div>
    <div class="founder-bio" data-reveal style="transition-delay:.1s">
      <p class="section-label" style="margin-bottom:8px">Our Story</p>
      <p>Hi, I'm Asifa — founder and CEO of Homecare Creators.</p>
      <p>Before starting Homecare Creators, I co-founded a web solutions company helping businesses across industries build their digital presence. Along the way, I kept running into the same problem: home care agencies — the people trusted with caring for someone's parent or grandparent — were being marketed by agencies that treated them like any other local business. Same templates, same generic SEO playbook, no real understanding of how families actually search for care, what builds trust with them, or what a homecare business owner is actually up against day to day.</p>
      <p>That gap is why Homecare Creators exists. We don't split our attention across restaurants, law firms, and dentists. We work exclusively with home care agencies — which means every strategy, every page, and every piece of advice we give is built around one industry, not retrofitted from a generic template.</p>
      <p>Homecare Creators is based in Lady Lake, Florida, and works with home care agencies across the state. If you want to talk through your agency's marketing directly, you can reach me at the contact details below.</p>
      <div style="display:flex;gap:14px;flex-wrap:wrap;margin-top:8px">
        <a href="/contact/" class="btn-primary" style="background:linear-gradient(135deg,var(--teal),var(--teal-lt))"><i class="fa-solid fa-comment"></i>Get in Touch</a>
        <a href="tel:+14094193533" class="btn-secondary" style="background:var(--cream);border-color:var(--border);color:var(--forest)"><i class="fa-solid fa-phone"></i>+1 (409) 419-3533</a>
      </div>
    </div>
  </div>
</section>

<!-- VALUES -->
<section class="values-section">
  <div class="container">
    <div data-reveal style="text-align:center">
      <p class="section-label" style="justify-content:center">What We Believe</p>
      <h2 class="section-h2">Why Homecare Agencies<br>Choose to <em>Work With Us</em></h2>
    </div>
    <div class="values-grid" data-reveal style="transition-delay:.1s">
      <div class="value-card">
        <div class="value-card-icon"><i class="fa-solid fa-bullseye"></i></div>
        <h4>Homecare-Only Focus</h4>
        <p>We don't take on restaurants, dentists, or law firms. Every hour we spend goes toward understanding home care marketing better — the keywords, the compliance considerations, the trust signals families look for.</p>
      </div>
      <div class="value-card">
        <div class="value-card-icon"><i class="fa-solid fa-comments"></i></div>
        <h4>Straight Talk, No Guaranteed-Rank Gimmicks</h4>
        <p>We won't promise you a #1 Google ranking by a specific date — no one honestly can. What we will do is show you exactly what we're doing, why, and how it's tracking, every month.</p>
      </div>
      <div class="value-card">
        <div class="value-card-icon"><i class="fa-solid fa-handshake"></i></div>
        <h4>No Long-Term Lock-In</h4>
        <p>After an initial ramp-up period, every plan moves to month-to-month. We'd rather keep earning your business than hold you to a contract.</p>
      </div>
    </div>
  </div>
</section>

<!-- CONTACT STRIP -->
<section class="contact-strip">
  <div class="container contact-strip-inner">
    <div class="contact-strip-item"><i class="fa-solid fa-phone"></i><a href="tel:+14094193533">+1 (409) 419-3533</a><span>Call or Text</span></div>
    <div class="contact-strip-item"><i class="fa-solid fa-envelope"></i><a href="mailto:info@homecarecreators.com">info@homecarecreators.com</a><span>Email</span></div>
    <div class="contact-strip-item"><i class="fa-solid fa-location-dot"></i><span style="color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:600;font-size:16px">Lady Lake, FL 32159</span><span>Based In</span></div>
  </div>
</section>

<?php include '../includes/footer.php'; ?>
