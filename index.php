<?php
$page_title    = "Homecare Creators: Marketing for Home Care Agencies";
$page_desc     = "The only marketing agency built exclusively for home care agencies in Florida - SEO, websites, and AI search optimization.";
$page_canonical = "https://homecarecreators.com/";
$og_title      = "Homecare Creators: Marketing for Home Care Agencies";
$og_desc       = "The only agency built 100% for homecare - website design, local SEO, AI search SEO, and the CareOS platform.";

$page_css = <<<CSS
/* ── HERO ── */
.hero{min-height:100vh;background:var(--forest);position:relative;overflow:hidden;padding:0;display:grid;grid-template-columns:1fr 1fr;align-items:center}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-blob1{position:absolute;width:700px;height:700px;top:-200px;right:-150px;background:radial-gradient(circle,rgba(29,158,117,.16) 0%,transparent 65%);animation:float 10s ease-in-out infinite}
.hero-blob2{position:absolute;width:500px;height:500px;bottom:-150px;left:-100px;background:radial-gradient(circle,rgba(201,168,76,.1) 0%,transparent 65%);animation:float 13s ease-in-out infinite reverse}
.hero-left{position:relative;z-index:2;padding:140px 52px 80px 80px}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Syne',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:32px;width:fit-content;animation:fadeIn .6s ease both}
.hero-badge-pulse{width:7px;height:7px;border-radius:50%;background:var(--teal-lt);animation:pulse-ring 2s infinite}
.hero-h1{font-family:'Instrument Serif',serif;font-size:clamp(42px,5.2vw,70px);line-height:1.04;color:#fff;margin-bottom:6px;animation:fadeUp .8s .1s ease both}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-tagline{font-family:'Instrument Serif',serif;font-size:clamp(20px,2.4vw,30px);line-height:1.3;color:rgba(255,255,255,.5);margin-bottom:10px;animation:fadeUp .8s .18s ease both}
.hero-tagline em{color:var(--mint);font-style:normal}
.hero-desc{font-size:16.5px;line-height:1.75;color:rgba(255,255,255,.62);max-width:500px;margin-bottom:42px;animation:fadeUp .8s .3s ease both}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;animation:fadeUp .8s .4s ease both;margin-bottom:52px}
.hero-proof{display:flex;gap:32px;flex-wrap:wrap;animation:fadeUp .8s .55s ease both}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Instrument Serif',serif;font-size:34px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.42)}
.hero-proof-divider{width:1px;background:rgba(255,255,255,.1);align-self:stretch}
.hero-right{position:relative;z-index:2;height:100vh;min-height:700px;padding:120px 48px 60px 24px;display:grid;grid-template-columns:1fr 1fr;grid-template-rows:1fr 1fr;gap:14px}
.hero-img-card{border-radius:20px;overflow:hidden;position:relative;box-shadow:0 20px 60px rgba(0,0,0,.35)}
.hero-img-card img{width:100%;height:100%;object-fit:cover;display:block;transition:transform .6s ease}
.hero-img-card:hover img{transform:scale(1.04)}
.hero-img-card::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 40%,rgba(5,25,14,.65) 100%);pointer-events:none}
.hero-img-card.tall{grid-row:span 2}
.hero-img-overlay{position:absolute;bottom:14px;left:14px;right:14px;z-index:2;background:rgba(10,46,30,.85);backdrop-filter:blur(10px);border:1px solid rgba(29,158,117,.25);border-radius:10px;padding:10px 14px;display:flex;align-items:center;gap:10px}
.hero-img-overlay-icon{width:30px;height:30px;border-radius:8px;background:var(--teal);display:flex;align-items:center;justify-content:center;font-size:13px;color:#fff;flex-shrink:0}
.hero-img-overlay-text{font-family:'Syne',sans-serif;font-size:11px;font-weight:600;color:#fff;line-height:1.3}
.hero-img-overlay-sub{font-size:10px;color:rgba(255,255,255,.5)}
.hero-float-badge{position:absolute;z-index:3;background:rgba(201,168,76,.15);backdrop-filter:blur(16px);border:1px solid rgba(201,168,76,.4);border-radius:12px;padding:10px 16px;font-family:'Syne',sans-serif}
.hero-float-badge-num{font-size:22px;font-weight:800;color:var(--gold-lt);line-height:1}
.hero-float-badge-label{font-size:10px;color:rgba(255,255,255,.6)}

/* ── WHY US ── */
.why{background:#fff}
.why-inner{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.why-image-wrap{position:relative;align-self:start}
.why-image-main{border-radius:24px;overflow:hidden;box-shadow:0 24px 80px rgba(10,46,30,.18);position:relative;aspect-ratio:4/5}
.why-image-main img{width:100%;height:100%;object-fit:cover;display:block}
.why-image-main::after{content:'';position:absolute;inset:0;background:linear-gradient(180deg,transparent 50%,rgba(10,46,30,.55) 100%);border-radius:24px}
.why-img-stat{position:absolute;bottom:-20px;right:-20px;background:#fff;border-radius:16px;padding:18px 22px;box-shadow:0 12px 48px rgba(10,46,30,.18);text-align:center;min-width:130px;border:1px solid var(--border);animation:floatR 5s ease-in-out infinite}
.why-img-stat-num{font-family:'Instrument Serif',serif;font-size:38px;color:var(--teal);line-height:1}
.why-img-stat-label{font-size:11px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600;margin-top:3px}
.why-img-badge{position:absolute;top:24px;left:-18px;background:var(--forest);border-radius:14px;padding:12px 18px;min-width:160px;box-shadow:0 8px 32px rgba(0,0,0,.25);border:1px solid rgba(29,158,117,.3);animation:floatR 7s ease-in-out infinite 1s}
.why-img-badge-row{display:flex;align-items:center;gap:10px}
.why-img-badge-icon{font-size:18px;color:var(--teal-lt)}
.why-img-badge-text{font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:#fff}
.why-img-badge-sub{font-size:10px;color:rgba(255,255,255,.5)}
.why-points{display:flex;flex-direction:column;gap:16px;margin-top:24px}
.why-point{display:flex;gap:16px;align-items:flex-start;padding:18px;border-radius:16px;border:1px solid var(--border);background:var(--warm);transition:.3s}
.why-point:hover{border-color:rgba(29,158,117,.3);box-shadow:0 8px 32px rgba(10,46,30,.08);transform:translateX(4px)}
.why-point-icon{width:44px;height:44px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.why-point-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15px;color:var(--forest);margin-bottom:4px}
.why-point-desc{font-size:13.5px;line-height:1.6;color:var(--muted)}

/* ── SERVICES ── */
.services-header{text-align:center;max-width:720px;margin:0 auto 24px}
.svc-detail{padding:80px 40px}
.svc-detail-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:64px;align-items:start}
.svc-detail-icon{width:52px;height:52px;border-radius:14px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:22px;margin-bottom:22px}
.svc-detail-grid p{font-size:16px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.svc-detail-closer{font-family:'Instrument Serif',serif;font-style:italic;font-size:19px;line-height:1.5;color:var(--forest);border-left:3px solid var(--teal);padding-left:18px;margin-top:24px}
.svc-detail-card{background:#fff;border:1px solid var(--border);border-radius:var(--r-lg);padding:32px;box-shadow:0 16px 48px rgba(10,46,30,.06)}
.svc-detail-card-title{font-family:'Syne',sans-serif;font-weight:700;font-size:12.5px;text-transform:uppercase;letter-spacing:.8px;color:var(--muted);margin-bottom:18px}
.svc-detail-list{list-style:none;display:flex;flex-direction:column;gap:14px;margin-bottom:24px}
.svc-detail-list li{display:flex;align-items:center;gap:12px;font-size:14.5px;color:var(--forest);font-weight:600}
.svc-detail-list li i{width:26px;height:26px;border-radius:8px;background:rgba(29,158,117,.12);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:11px;flex-shrink:0}
.svc-detail-link{display:inline-flex;align-items:center;gap:7px;font-family:'Syne',sans-serif;font-size:12.5px;font-weight:700;color:var(--teal);text-decoration:none;transition:.2s;border-top:1px solid var(--border);padding-top:20px}
.svc-detail-link:hover{color:var(--forest);gap:10px}
@media(max-width:1024px){.svc-detail-grid{grid-template-columns:1fr;gap:32px}}

/* ── HOW IT WORKS ── */
.how{background:#fff}
.how-grid{display:grid;grid-template-columns:repeat(4,1fr);gap:0;margin-top:72px;position:relative}
.how-grid::before{content:'';position:absolute;top:44px;left:12%;right:12%;height:1px;background:linear-gradient(90deg,transparent,var(--teal) 20%,var(--teal) 80%,transparent);opacity:.25}
.how-step{text-align:center;padding:0 20px 48px;position:relative}
.how-step-num{width:88px;height:88px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;margin:0 auto 24px;font-family:'Syne',sans-serif;font-weight:800;font-size:26px;position:relative;z-index:1;box-shadow:0 0 0 10px rgba(29,158,117,.08),0 8px 32px rgba(10,46,30,.2);transition:.3s}
.how-step:hover .how-step-num{background:var(--teal);box-shadow:0 0 0 10px rgba(29,158,117,.15),0 12px 40px rgba(29,158,117,.35)}
.how-step-icon{position:absolute;bottom:-4px;right:-4px;width:28px;height:28px;border-radius:50%;background:var(--teal-lt);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;box-shadow:0 2px 8px rgba(0,0,0,.2)}
.how-step-title{font-family:'Syne',sans-serif;font-weight:700;font-size:15.5px;color:var(--forest);margin-bottom:10px}
.how-step-desc{font-size:13.5px;line-height:1.65;color:var(--muted)}

/* ── CAREOS ── */
.careos{background:#020d06;position:relative;overflow:hidden;padding:120px 40px}
.careos-stars{position:absolute;inset:0;background-image:radial-gradient(1px 1px at 10% 20%,rgba(255,255,255,.4) 0%,transparent 100%),radial-gradient(1px 1px at 30% 60%,rgba(255,255,255,.3) 0%,transparent 100%),radial-gradient(1px 1px at 60% 15%,rgba(255,255,255,.5) 0%,transparent 100%),radial-gradient(1px 1px at 80% 70%,rgba(255,255,255,.3) 0%,transparent 100%),radial-gradient(2px 2px at 20% 45%,rgba(46,198,143,.6) 0%,transparent 100%),radial-gradient(2px 2px at 70% 30%,rgba(46,198,143,.5) 0%,transparent 100%)}
.careos-glow{position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);width:900px;height:500px;background:radial-gradient(ellipse,rgba(29,158,117,.12) 0%,transparent 70%)}
.careos-grid-lines{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.06) 1px,transparent 1px);background-size:48px 48px}
.careos-inner{position:relative;z-index:2}
.careos-top-badge{display:inline-flex;align-items:center;gap:10px;background:rgba(201,168,76,.1);border:1px solid rgba(201,168,76,.35);padding:10px 22px;border-radius:100px;font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:var(--gold-lt);letter-spacing:1.5px;text-transform:uppercase;margin-bottom:32px;animation:shimmer 3s ease-in-out infinite}
.careos-top-badge-dot{width:8px;height:8px;border-radius:50%;background:var(--gold-lt);animation:pulse-ring 2s infinite}
.careos-headline{font-family:'Instrument Serif',serif;font-size:clamp(40px,5vw,72px);line-height:1.05;color:#fff;margin-bottom:16px;text-align:center}
.careos-headline em{font-style:italic;color:var(--teal-lt)}
.careos-subhead{font-size:18px;line-height:1.75;color:rgba(255,255,255,.65);max-width:640px;margin:0 auto 16px;text-align:center}
.careos-tagline{font-family:'Syne',sans-serif;font-size:13px;font-weight:700;color:var(--teal-lt);letter-spacing:1px;text-transform:uppercase;text-align:center;margin-bottom:56px;opacity:.8}
.careos-launch{display:flex;justify-content:center;gap:0;margin-bottom:64px}
.careos-launch-item{text-align:center;padding:28px 36px;position:relative}
.careos-launch-item::after{content:'';position:absolute;right:0;top:20%;height:60%;width:1px;background:rgba(29,158,117,.2)}
.careos-launch-item:last-child::after{display:none}
.careos-launch-num{font-family:'Instrument Serif',serif;font-size:56px;color:#fff;line-height:1;display:block}
.careos-launch-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;color:rgba(255,255,255,.4);letter-spacing:2px;text-transform:uppercase;margin-top:4px;display:block}
.careos-modules-grid{display:grid;grid-template-columns:repeat(auto-fill,minmax(240px,1fr));gap:16px;margin-bottom:64px}
.careos-module{background:rgba(255,255,255,.03);border:1px solid rgba(29,158,117,.15);border-radius:var(--r);padding:24px;position:relative;overflow:hidden;transition:.3s}
.careos-module::before{content:'';position:absolute;top:0;left:0;right:0;height:2px;background:linear-gradient(90deg,var(--teal),var(--teal-lt));opacity:0;transition:.3s}
.careos-module:hover{border-color:rgba(29,158,117,.35);background:rgba(255,255,255,.06);transform:translateY(-4px)}
.careos-module:hover::before{opacity:1}
.careos-module-icon{width:46px;height:46px;border-radius:13px;background:rgba(29,158,117,.12);display:flex;align-items:center;justify-content:center;color:var(--teal-lt);font-size:20px;margin-bottom:16px}
.careos-module-name{font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:#fff;margin-bottom:8px}
.careos-module-desc{font-size:13px;line-height:1.65;color:rgba(255,255,255,.6)}
.module-badge{display:inline-block;margin-top:12px;font-family:'Syne',sans-serif;font-size:9px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;padding:3px 9px;border-radius:5px}
.badge-ai{background:rgba(29,158,117,.2);color:var(--mint)}
.badge-new{background:rgba(201,168,76,.2);color:var(--gold-lt)}
.badge-core{background:rgba(255,255,255,.08);color:rgba(255,255,255,.5)}
.careos-cta-box{background:rgba(29,158,117,.08);border:1px solid rgba(29,158,117,.25);border-radius:24px;padding:48px;text-align:center;position:relative;overflow:hidden}
.careos-cta-box::before{content:'';position:absolute;top:-50%;left:-50%;width:200%;height:200%;background:conic-gradient(from 0deg,transparent 0%,rgba(29,158,117,.05) 25%,transparent 50%);animation:spin-slow 20s linear infinite}
.careos-cta-title{font-family:'Instrument Serif',serif;font-size:36px;color:#fff;margin-bottom:12px;position:relative;z-index:1}
.careos-cta-desc{font-size:16px;color:rgba(255,255,255,.6);margin-bottom:28px;position:relative;z-index:1}
.careos-cta-perks{display:flex;justify-content:center;gap:32px;flex-wrap:wrap;margin-bottom:32px;position:relative;z-index:1}
.careos-cta-perk{display:flex;align-items:center;gap:8px;font-family:'Syne',sans-serif;font-size:12px;font-weight:600;color:var(--mint)}
.careos-cta-perk i{color:var(--teal-lt)}

/* ── AI SEO ── */
.ai-seo{background:var(--cream)}
.ai-seo-inner{background:var(--forest);border-radius:32px;overflow:hidden;display:grid;grid-template-columns:1fr 1fr;gap:0;box-shadow:0 32px 100px rgba(10,46,30,.25)}
.ai-seo-left{padding:64px 56px;position:relative}
.ai-seo-left .section-h2{color:#fff}
.ai-seo-left .section-label{color:var(--mint)}
.ai-seo-desc{font-size:16px;line-height:1.75;color:rgba(255,255,255,.58);margin-bottom:32px}
.ai-pillars{display:flex;flex-direction:column;gap:12px}
.ai-pillar{display:flex;align-items:flex-start;gap:14px;padding:15px 18px;border-radius:14px;background:rgba(255,255,255,.05);border:1px solid rgba(29,158,117,.15);transition:.25s}
.ai-pillar:hover{background:rgba(255,255,255,.09);border-color:rgba(29,158,117,.35);transform:translateX(5px)}
.ai-pillar-icon{width:34px;height:34px;border-radius:10px;background:var(--teal);color:#fff;display:flex;align-items:center;justify-content:center;font-size:14px;flex-shrink:0}
.ai-pillar-title{font-family:'Syne',sans-serif;font-weight:700;font-size:13.5px;color:#fff;margin-bottom:3px}
.ai-pillar-sub{font-size:12px;color:rgba(255,255,255,.45);line-height:1.5}
.ai-seo-right{position:relative;overflow:hidden;min-height:500px}
.ai-seo-right img{width:100%;height:100%;object-fit:cover;display:block}
.ai-seo-right::before{content:'';position:absolute;inset:0;z-index:1;background:linear-gradient(90deg,rgba(10,46,30,.8) 0%,transparent 50%)}
.ai-seo-platforms{position:absolute;bottom:32px;right:32px;z-index:2;display:flex;flex-direction:column;gap:10px}
.ai-platform-pill{display:flex;align-items:center;gap:10px;background:rgba(10,46,30,.88);backdrop-filter:blur(12px);border:1px solid rgba(29,158,117,.25);border-radius:100px;padding:8px 16px;font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:#fff}
.ai-platform-pill i{color:var(--teal-lt);font-size:14px}

/* ── BUNDLES ── */
.bundles{background:var(--forest);position:relative;overflow:hidden}
.bundles-bg{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.05) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.05) 1px,transparent 1px);background-size:48px 48px}
.bundles .section-h2{color:#fff}
.bundles .section-h2 em{color:var(--mint)}
.bundles .section-sub{color:rgba(255,255,255,.5)}
.bundles .section-label{color:var(--mint)}
.bundles .section-label::before{background:var(--mint)}
.bundles-header{text-align:center;position:relative;z-index:1;margin-bottom:64px}
.bundles-header .section-label{justify-content:center}
.bundles-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:22px;position:relative;z-index:1;align-items:start}
.bundle-card{background:rgba(255,255,255,.05);border:1px solid rgba(255,255,255,.09);border-radius:24px;padding:36px 30px;position:relative;overflow:hidden;transition:.4s cubic-bezier(.34,1.56,.64,1)}
.bundle-card:hover{transform:translateY(-6px);border-color:rgba(29,158,117,.35)}
.bundle-card.featured{background:var(--teal);border:none;box-shadow:0 0 0 1px var(--teal-lt),0 20px 60px rgba(29,158,117,.4);transform:translateY(-12px)}
.bundle-card.featured:hover{transform:translateY(-18px)}
.bundle-top-bar{position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--teal),var(--teal-lt))}
.bundle-card.featured .bundle-top-bar{background:linear-gradient(90deg,#fff,rgba(255,255,255,.6))}
.bundle-badge{display:inline-flex;align-items:center;gap:6px;font-family:'Syne',sans-serif;font-size:10px;font-weight:700;letter-spacing:1.2px;text-transform:uppercase;background:rgba(255,255,255,.1);color:rgba(255,255,255,.7);padding:5px 12px;border-radius:6px;margin-bottom:20px}
.bundle-badge.hot{background:var(--gold);color:var(--forest)}
.bundle-name{font-family:'Instrument Serif',serif;font-size:32px;color:#fff;line-height:1;margin-bottom:6px}
.bundle-price{font-family:'Syne',sans-serif;font-weight:800;font-size:42px;color:#fff;line-height:1;margin-bottom:4px}
.bundle-price sub{font-size:16px;font-weight:400;opacity:.6;vertical-align:baseline;margin-right:2px}
.bundle-price span{font-size:15px;font-weight:400;opacity:.6}
.bundle-orig-price{font-family:'Syne',sans-serif;font-size:13px;color:rgba(255,255,255,.4);text-decoration:line-through;margin-bottom:4px}
.bundle-setup{font-size:12px;color:rgba(255,255,255,.45);margin-bottom:24px}
.bundle-divider{height:1px;background:rgba(255,255,255,.1);margin:22px 0}
.bundle-features{list-style:none;display:flex;flex-direction:column;gap:11px}
.bundle-features li{display:flex;align-items:flex-start;gap:10px;font-size:13.5px;color:rgba(255,255,255,.8);line-height:1.45}
.bundle-features li i{color:var(--teal-lt);font-size:12px;margin-top:2px;flex-shrink:0}
.bundle-card.featured .bundle-features li i{color:#fff}
.bundle-cta{display:block;text-align:center;margin-top:26px;padding:14px;border-radius:12px;font-family:'Syne',sans-serif;font-weight:700;font-size:14px;text-decoration:none;transition:.25s;cursor:pointer;border:none;width:100%}
.bundle-cta-default{background:rgba(255,255,255,.08);border:1px solid rgba(255,255,255,.15);color:#fff}
.bundle-cta-default:hover{background:rgba(255,255,255,.15)}
.bundle-cta-featured{background:var(--forest);color:var(--mint)}
.bundle-cta-featured:hover{background:var(--forest-md)}
.bundles-note{text-align:center;margin-top:32px;font-size:12.5px;color:rgba(255,255,255,.3);font-family:'Syne',sans-serif;position:relative;z-index:1}
.savings-badge{display:inline-block;background:rgba(201,168,76,.2);border:1px solid rgba(201,168,76,.3);color:var(--gold-lt);font-family:'Syne',sans-serif;font-size:10px;font-weight:700;padding:3px 10px;border-radius:6px;margin-left:8px;letter-spacing:.5px}

/* ── RESULTS ── */
.results{background:var(--cream)}
.results-inner{display:grid;grid-template-columns:1fr 1fr;gap:72px;align-items:center}
.results-image-wrap{position:relative;align-self:start}
.results-image{border-radius:24px;overflow:hidden;box-shadow:0 24px 80px rgba(10,46,30,.18);aspect-ratio:4/5}
.results-image img{width:100%;height:100%;object-fit:cover;display:block}
.results-stat-card{position:absolute;bottom:-16px;right:-16px;background:#fff;border-radius:18px;padding:20px 24px;box-shadow:0 12px 48px rgba(10,46,30,.16);border:1px solid var(--border);min-width:150px;text-align:center}
.results-stat-num{font-family:'Instrument Serif',serif;font-size:42px;color:var(--teal);line-height:1}
.results-stat-label{font-size:11px;color:var(--muted);font-family:'Syne',sans-serif;font-weight:600;margin-top:4px}
.results-grid-right{display:grid;grid-template-columns:1fr 1fr;gap:18px}
.result-card{background:#fff;border:1px solid var(--border);border-radius:20px;padding:28px 22px;text-align:center;transition:.3s;position:relative;overflow:hidden}
.result-card::before{content:'';position:absolute;top:0;left:0;right:0;height:3px;background:linear-gradient(90deg,var(--teal),var(--teal-lt));opacity:0;transition:.3s}
.result-card:hover{transform:translateY(-5px);box-shadow:0 16px 48px rgba(10,46,30,.1)}
.result-card:hover::before{opacity:1}
.result-card-icon{font-size:28px;color:var(--teal);margin-bottom:12px}
.result-num{font-family:'Instrument Serif',serif;font-size:36px;color:var(--forest);line-height:1;margin-bottom:6px}
.result-label{font-family:'Syne',sans-serif;font-size:12px;font-weight:700;color:var(--forest);margin-bottom:6px}
.result-desc{font-size:12px;line-height:1.6;color:var(--muted)}

/* ── REVIEWS SLIDER ── */
.reviews{background:#fff;overflow:hidden}
.reviews-header{text-align:center;margin-bottom:56px}
.reviews-header .section-label{justify-content:center}
.slider-wrap{overflow:hidden;position:relative}
.slider-track{display:flex;gap:24px;transition:transform .5s cubic-bezier(.4,0,.2,1);will-change:transform}
.review-card{background:var(--cream);border:1px solid var(--border);border-radius:22px;padding:32px;min-width:360px;max-width:360px;position:relative;overflow:hidden;flex-shrink:0}
.review-card::before{content:'\201C';position:absolute;top:-12px;right:20px;font-family:'Instrument Serif',serif;font-size:120px;color:rgba(29,158,117,.08);line-height:1;pointer-events:none}
.review-stars{color:var(--gold);font-size:15px;margin-bottom:16px;letter-spacing:2px}
.review-quote{font-family:'Instrument Serif',serif;font-size:17px;line-height:1.65;color:var(--forest);font-style:italic;margin-bottom:24px}
.review-author{display:flex;align-items:center;gap:13px}
.review-avatar{width:48px;height:48px;border-radius:50%;background:var(--teal);color:#fff;display:flex;align-items:center;justify-content:center;font-family:'Syne',sans-serif;font-weight:700;font-size:16px;flex-shrink:0}
.review-name{font-family:'Syne',sans-serif;font-weight:700;font-size:14px;color:var(--forest)}
.review-role{font-size:12px;color:var(--muted);margin-top:2px}
.slider-controls{display:flex;justify-content:center;gap:12px;margin-top:40px;align-items:center}
.slider-btn{width:44px;height:44px;border-radius:50%;background:var(--forest);color:#fff;border:none;cursor:pointer;display:flex;align-items:center;justify-content:center;font-size:16px;transition:.25s}
.slider-btn:hover{background:var(--teal);transform:scale(1.05)}
.slider-dots{display:flex;gap:8px;align-items:center}
.slider-dot{width:8px;height:8px;border-radius:50%;background:var(--border);cursor:pointer;transition:.3s;border:none}
.slider-dot.active{background:var(--teal);width:24px;border-radius:4px}

/* ── FAQ ── */
.faq{background:#fff}
.faq-header{text-align:center;margin-bottom:64px}
.faq-header .section-label{justify-content:center}
.faq-list{max-width:860px;margin:0 auto;display:flex;flex-direction:column;gap:12px}
.faq-item{background:var(--warm);border:1px solid var(--border);border-radius:16px;overflow:hidden;transition:border-color .3s}
.faq-item:hover{border-color:rgba(29,158,117,.3)}
.faq-q{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:20px 24px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Syne',sans-serif;font-weight:700;font-size:14.5px;color:var(--forest)}
.faq-q-icon{width:28px;height:28px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;transition:transform .3s,background .3s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal)}
.faq-a{max-height:0;overflow:hidden;transition:max-height .4s ease}
.faq-item.open .faq-a{max-height:400px}
.faq-a-inner{padding:0 24px 20px;font-size:14px;line-height:1.75;color:var(--muted);border-top:1px solid var(--border)}
.faq-a-inner p{padding-top:16px}

/* ── CONTACT ── */
.contact-section{background:var(--cream)}
.contact-inner{display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:start}
.contact-info{padding-top:8px}
.contact-desc{font-size:16px;line-height:1.75;color:var(--muted);margin-bottom:40px}
.contact-details{display:flex;flex-direction:column;gap:20px}
.contact-detail{display:flex;align-items:center;gap:16px}
.contact-detail-icon{width:46px;height:46px;border-radius:13px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:18px;flex-shrink:0}
.contact-detail-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;text-transform:uppercase;letter-spacing:1px;color:var(--muted);margin-bottom:2px}
.contact-detail-value{font-size:15px;font-weight:500;color:var(--forest)}
.contact-detail-value a{color:var(--teal);text-decoration:none}
.contact-detail-value a:hover{text-decoration:underline}
.contact-form-card{background:#fff;border:1px solid var(--border);border-radius:24px;padding:40px;box-shadow:0 16px 64px rgba(10,46,30,.1)}
.form-title{font-family:'Syne',sans-serif;font-weight:700;font-size:18px;color:var(--forest);margin-bottom:8px}
.form-subtitle{font-size:14px;color:var(--muted);margin-bottom:28px}
.form-row{display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:16px}
.form-group{display:flex;flex-direction:column;gap:6px;margin-bottom:16px}
.form-group:last-of-type{margin-bottom:0}
.form-label{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--forest)}
.form-input,.form-select,.form-textarea{width:100%;padding:12px 16px;border:1.5px solid var(--border);border-radius:10px;font-family:'DM Sans',sans-serif;font-size:14px;color:var(--text);background:#fff;transition:.2s;outline:none;-webkit-appearance:none}
.form-input:focus,.form-select:focus,.form-textarea:focus{border-color:var(--teal);box-shadow:0 0 0 3px rgba(29,158,117,.1)}
.form-textarea{min-height:110px;resize:vertical}
.form-submit{width:100%;padding:15px;border-radius:11px;font-family:'Syne',sans-serif;font-weight:700;font-size:15px;background:linear-gradient(135deg,var(--teal),var(--teal-lt));color:#fff;border:none;cursor:pointer;transition:.3s;display:flex;align-items:center;justify-content:center;gap:9px;margin-top:8px}
.form-submit:hover{transform:translateY(-2px);box-shadow:0 8px 32px rgba(29,158,117,.4)}
.form-success{display:none;text-align:center;padding:32px 16px;background:rgba(29,158,117,.06);border-radius:14px;border:1px solid rgba(29,158,117,.2)}
.form-success i{font-size:40px;color:var(--teal);margin-bottom:14px;display:block}
.form-success-title{font-family:'Syne',sans-serif;font-weight:700;font-size:18px;color:var(--forest);margin-bottom:6px}
.form-success p{font-size:14px;color:var(--muted)}

/* ── CTA SECTION ── */
.cta-section{background:var(--forest);position:relative;overflow:hidden}
.cta-section::before{content:'';position:absolute;inset:0;background:radial-gradient(ellipse 80% 80% at 50% 50%,rgba(29,158,117,.14),transparent)}
.cta-inner{position:relative;z-index:1;display:grid;grid-template-columns:1fr 1fr;gap:80px;align-items:center}
.cta-content .section-h2{color:#fff}
.cta-content .section-h2 em{color:var(--mint)}
.cta-content .section-label{color:var(--mint)}
.cta-content .section-label::before{background:var(--mint)}
.cta-desc{font-size:16px;line-height:1.75;color:rgba(255,255,255,.6);margin-bottom:36px;max-width:460px}
.cta-actions{display:flex;gap:14px;flex-wrap:wrap}
.cta-guarantee{margin-top:24px;display:flex;align-items:center;gap:8px;font-family:'Syne',sans-serif;font-size:12px;color:rgba(255,255,255,.35)}
.cta-guarantee i{color:var(--teal)}
.cta-image{border-radius:24px;overflow:hidden;box-shadow:0 24px 80px rgba(0,0,0,.3);position:relative;aspect-ratio:4/5}
.cta-image img{width:100%;height:100%;object-fit:cover;display:block}
.cta-image::after{content:'';position:absolute;inset:0;background:linear-gradient(135deg,rgba(10,46,30,.6),transparent 60%)}
.cta-image-badge{position:absolute;top:24px;left:24px;z-index:2;background:rgba(10,46,30,.9);backdrop-filter:blur(16px);border:1px solid rgba(29,158,117,.3);border-radius:14px;padding:14px 18px}
.cta-image-badge-title{font-family:'Syne',sans-serif;font-size:11px;font-weight:700;color:var(--mint);letter-spacing:.8px;text-transform:uppercase;margin-bottom:6px}
.cta-badge-row{display:flex;align-items:center;gap:8px;margin-top:6px}
.cta-badge-dot{width:6px;height:6px;border-radius:50%;background:var(--teal-lt)}
.cta-badge-text{font-size:12px;color:rgba(255,255,255,.65)}

/* ── RESPONSIVE ── */
@media(max-width:1024px){
  .hero{grid-template-columns:1fr}
  .hero-right{display:none}
  .hero-left{padding:130px 40px 80px}
  .why-inner,.results-inner,.cta-inner,.ai-seo-inner,.contact-inner{grid-template-columns:1fr}
  .bundles-grid{grid-template-columns:1fr}
  .bundle-card.featured{transform:none}
  .how-grid{grid-template-columns:1fr 1fr}
  .ai-seo-right{min-height:300px}
}
@media(max-width:640px){
  .hero-left{padding:110px 24px 60px}
  section{padding:72px 24px}
  .svc-detail{padding:64px 24px}
  .results-grid-right{grid-template-columns:1fr}
  .bundles-grid{grid-template-columns:1fr}
  .how-grid{grid-template-columns:1fr}
  .form-row{grid-template-columns:1fr}
  .review-card{min-width:calc(100vw - 80px);max-width:calc(100vw - 80px)}
  .faq-list{padding:0}
}
CSS;

$page_js = <<<JS
// ── REVIEW SLIDER ──
var currentSlide = 0;
var TOTAL_CARDS = 6;
var VISIBLE = 3;
var MAX_SLIDE = TOTAL_CARDS - VISIBLE;
var CARD_W = 360 + 24;

function buildDots() {
  var dots = document.getElementById('sliderDots');
  if (!dots) return;
  dots.innerHTML = '';
  for (var i = 0; i <= MAX_SLIDE; i++) {
    var d = document.createElement('button');
    d.className = 'slider-dot' + (i === 0 ? ' active' : '');
    d.setAttribute('aria-label', 'Slide ' + (i + 1));
    (function(idx) { d.addEventListener('click', function() { goSlide(idx); }); })(i);
    dots.appendChild(d);
  }
}
function goSlide(n) {
  currentSlide = Math.max(0, Math.min(n, MAX_SLIDE));
  document.getElementById('sliderTrack').style.transform = 'translateX(-' + (currentSlide * CARD_W) + 'px)';
  document.querySelectorAll('.slider-dot').forEach(function(d, i) {
    d.classList.toggle('active', i === currentSlide);
  });
}
function slideReviews(dir) { goSlide(currentSlide + dir); }
buildDots();

// ── COUNTDOWN TIMER ──
function updateCountdown() {
  var launch = new Date('2026-09-01T00:00:00');
  var now = new Date();
  var diff = launch - now;
  if (diff <= 0) return;
  var d = Math.floor(diff / 86400000);
  var h = Math.floor((diff % 86400000) / 3600000);
  var m = Math.floor((diff % 3600000) / 60000);
  var s = Math.floor((diff % 60000) / 1000);
  document.getElementById('cntD').textContent = String(d).padStart(2, '0');
  document.getElementById('cntH').textContent = String(h).padStart(2, '0');
  document.getElementById('cntM').textContent = String(m).padStart(2, '0');
  document.getElementById('cntS').textContent = String(s).padStart(2, '0');
}
updateCountdown();
setInterval(updateCountdown, 1000);

// ── CONTACT FORM SUBMIT ──
function submitContact() {
  var first   = (document.getElementById('cfFirst').value || '').trim();
  var last    = (document.getElementById('cfLast').value || '').trim();
  var email   = (document.getElementById('cfEmail').value || '').trim();
  var phone   = (document.getElementById('cfPhone').value || '').trim();
  var agency  = (document.getElementById('cfAgency').value || '').trim();
  var service = document.getElementById('cfService').value;
  var msg     = (document.getElementById('cfMessage').value || '').trim();

  if (!first) { alert('Please enter your first name.'); document.getElementById('cfFirst').focus(); return; }
  if (!email || !email.includes('@')) { alert('Please enter a valid email.'); document.getElementById('cfEmail').focus(); return; }

  var submitBtn = document.querySelector('#contactFormWrap .form-submit');
  var originalHTML = submitBtn.innerHTML;
  submitBtn.disabled = true;
  submitBtn.innerHTML = '<i class="fa-solid fa-paper-plane"></i>Sending...';

  fetch('/form-handler.php', {
    method: 'POST',
    headers: { 'Content-Type': 'application/json' },
    body: JSON.stringify({
      name:    first + ' ' + last,
      email:   email,
      phone:   phone || 'Not provided',
      agency:  agency || 'Not provided',
      service: service || 'Not specified',
      message: msg || '(none)',
      source:  'contact_form'
    })
  })
  .then(function(res) { return res.json(); })
  .then(function(d) {
    if (d.success) {
      document.getElementById('contactFormWrap').style.display = 'none';
      document.getElementById('contactSuccess').style.display = 'block';
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalHTML;
      ['cfFirst','cfLast','cfEmail','cfPhone','cfAgency','cfService','cfMessage'].forEach(function(id) {
        document.getElementById(id).value = '';
      });
    } else {
      alert('There was an error sending your message. Please try again.');
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalHTML;
    }
  })
  .catch(function(err) {
    console.error('Error:', err);
    alert('There was an error sending your message. Please try again.');
    submitBtn.disabled = false;
    submitBtn.innerHTML = originalHTML;
  });
}

// ── OPEN POPUP OVERRIDE (homepage type-based variant) ──
function openPopup(type) {
  var overlay  = document.getElementById('mainPopup');
  var formDiv  = document.getElementById('popupFormEl');
  var succDiv  = document.getElementById('popupSuccessEl');
  var titleEl  = document.getElementById('popupTitleEl');
  var btnLabel = document.getElementById('popupBtnLabel');
  var svcSel   = document.getElementById('pService');

  formDiv.style.display = 'block';
  succDiv.style.display = 'none';

  if (type === 'waitlist') {
    titleEl.textContent  = 'Join the CareOS Waitlist';
    btnLabel.textContent = 'Join the Waitlist';
    svcSel.value         = 'CareOS Waitlist';
  } else if (type === 'audit') {
    titleEl.textContent  = 'Book Your Free Growth Audit';
    btnLabel.textContent = 'Book My Free Audit';
    svcSel.value         = 'Free Growth Audit';
  } else {
    var names = { starter: 'Starter Bundle', scale: 'Scale Bundle', dominate: 'Dominate Bundle' };
    titleEl.textContent  = 'Get Started — ' + (names[type] || 'Bundle');
    btnLabel.textContent = 'Send My Request';
    svcSel.value         = 'Full Bundle Package';
  }

  generateCaptcha();
  overlay.classList.add('open');
  document.body.style.overflow = 'hidden';
}
JS;

include 'includes/header.php';
?>

<!-- ══════════════════════════
   HERO
══════════════════════════ -->
<section class="hero" id="home">
  <div class="hero-bg-grid"></div>
  <div class="hero-blob1"></div>
  <div class="hero-blob2"></div>
  <div class="hero-left">
    <div class="hero-badge">
      <div class="hero-badge-pulse"></div>The #1 Agency Exclusively for Homecare
    </div>
    <h1 class="hero-h1">Market It. Manage It.<br><em>Grow It.</em></h1>
    <div class="hero-tagline"><em>The Only Agency Built 100% for</em><br><em>Homecare.</em></div>
    <p class="hero-desc">We build your website, take over your local search rankings, and run the marketing.
      Then our AI tools handle a chunk of the day-to-day operations too. You focus on delivering care. We chase
      the clients.</p>
    <div class="hero-actions">
      <button class="btn-primary" onclick="openPopup('audit')"><i class="fa-solid fa-rocket"></i>Book Free Growth
        Audit</button>
      <a href="#careos" class="btn-secondary"><i class="fa-solid fa-play"></i>See CareOS Platform</a>
    </div>
    <div class="hero-proof">
      <div class="hero-proof-item">
        <div class="hero-proof-num">312%</div>
        <div class="hero-proof-label">Avg Lead Increase</div>
      </div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item">
        <div class="hero-proof-num">67+</div>
        <div class="hero-proof-label">Reviews in 90 Days</div>
      </div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item">
        <div class="hero-proof-num">#1</div>
        <div class="hero-proof-label">Google Rank in 5mo</div>
      </div>
      <div class="hero-proof-divider"></div>
      <div class="hero-proof-item">
        <div class="hero-proof-num">12h</div>
        <div class="hero-proof-label">Saved/Week via AI</div>
      </div>
    </div>
  </div>

  <div class="hero-right">
    <div class="hero-img-card tall" style="animation:scaleIn .9s .4s ease both">
      <img src="/images/home/hero-caregiver-elderly.jpg"
        alt="Professional caregiver assisting an elderly client at home for a Florida home care agency"
        title="Home care agency caregiver assisting an elderly client">
      <div class="hero-img-overlay">
        <div class="hero-img-overlay-icon"><i class="fa-solid fa-heart-pulse"></i></div>
        <div>
          <div class="hero-img-overlay-text">Live Shift Active</div>
          <div class="hero-img-overlay-sub">AI monitoring in real-time</div>
        </div>
      </div>
    </div>
    <div class="hero-img-card" style="animation:scaleIn .9s .55s ease both">
      <img src="/images/home/hero-nurse-senior.jpg"
        alt="Home care nurse providing compassionate in-home senior care services"
        title="Home care nurse caring for a senior client">
      <div class="hero-float-badge" style="top:14px;left:12px">
        <div class="hero-float-badge-num">+67</div>
        <div class="hero-float-badge-label">New Reviews</div>
      </div>
    </div>
    <div class="hero-img-card" style="animation:scaleIn .9s .7s ease both">
      <img src="/images/home/hero-caregiver-woman.jpg"
        alt="Happy caregiver bonding with an elderly woman client, ranked #1 on Google"
        title="Caregiver with elderly woman client — home care agency ranked #1 on Google">
      <div class="hero-img-overlay">
        <div class="hero-img-overlay-icon"><i class="fa-brands fa-google"></i></div>
        <div>
          <div class="hero-img-overlay-text">Ranked #1 Google</div>
          <div class="hero-img-overlay-sub">5 months in</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- TICKER -->
<div class="ticker-wrap">
  <div class="ticker-inner">
    <div class="ticker-item"><i class="fa-solid fa-star"></i>Website Design & Development</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass-chart"></i>Local SEO Domination</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>AI Search SEO / GEO</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-palette"></i>Brand Identity Design</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-share-nodes"></i>Social Media Marketing</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>CareOS AI Platform</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-envelope-open-text"></i>Email Marketing</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-chart-line"></i>Growth Analytics</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-star"></i>Website Design & Development</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-magnifying-glass-chart"></i>Local SEO Domination</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-brands fa-google"></i>AI Search SEO / GEO</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-palette"></i>Brand Identity Design</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-share-nodes"></i>Social Media Marketing</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-robot"></i>CareOS AI Platform</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-envelope-open-text"></i>Email Marketing</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
    <div class="ticker-item"><i class="fa-solid fa-chart-line"></i>Growth Analytics</div>
    <div class="ticker-item"><span class="ticker-dot"></span></div>
  </div>
</div>

<!-- ══════════════════════════
   CERTIFICATIONS / TRUST BADGES
══════════════════════════ -->
<section class="certs">
  <div class="container">
    <p class="certs-label">Certified &amp; Trusted By</p>
    <div class="certs-row">
      <div class="cert-item"><img src="/images/blog/Homecarecreators-BBB-Certified.png" alt="Homecare Creators BBB accredited business certification badge" title="BBB Accredited Business" loading="lazy"><span>BBB Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-Google-my-business-profile.png" alt="Homecare Creators verified Google Business Profile badge" title="Verified Google Business Profile" loading="lazy"><span>Google Business Profile</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-google-partner.jpg" alt="Homecare Creators Google Partner certification badge" title="Google Partner Certified Agency" loading="lazy"><span>Google Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-hubspot-partner.webp" alt="Homecare Creators HubSpot certified partner badge" title="HubSpot Certified Partner" loading="lazy"><span>HubSpot Partner</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-meta-certificate.jpg" alt="Homecare Creators Meta certified marketing partner badge" title="Meta Certified Marketing Partner" loading="lazy"><span>Meta Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-semrush-ceticificate.png" alt="Homecare Creators SEMrush certified SEO partner badge" title="SEMrush Certified Agency Partner" loading="lazy"><span>SEMrush Certified</span></div>
      <div class="cert-item"><img src="/images/blog/Homecarecreators-NACH.webp" alt="Homecare Creators National Association for Home Care and Hospice member badge" title="NAHC Member Agency" loading="lazy"><span>NAHC Member</span></div>
    </div>
  </div>
</section>

<!-- ══════════════════════════
   WHY US
══════════════════════════ -->
<section class="why" id="why">
  <div class="container">
    <div class="why-inner">
      <div class="why-image-wrap" data-reveal>
        <div class="why-image-main">
          <img src="/images/home/why-team-training.jpg" alt="Homecare Creators marketing team meeting to plan home care agency growth strategy" title="Homecare Creators team training and strategy meeting">
        </div>
        <div class="why-img-stat">
          <div class="why-img-stat-num">98%</div>
          <div class="why-img-stat-label">Client Retention</div>
        </div>
        <div class="why-img-badge">
          <div class="why-img-badge-row"><i class="fa-solid fa-trophy why-img-badge-icon"></i>
            <div>
              <div class="why-img-badge-text">Homecare Only</div>
              <div class="why-img-badge-sub">100% niche focus</div>
            </div>
          </div>
        </div>
      </div>
      <div data-reveal style="transition-delay:.15s">
        <p class="section-label">Why Homecare Creators</p>
        <h2 class="section-h2">The Only Agency Built <em>100% for </em>Homecare</h2>
        <p class="section-sub">Generalist agencies don't get homecare. We do. That gap alone is worth hundreds
          of thousands in growth most years.</p>
        <div class="why-points">
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-crosshairs"></i></div>
            <div>
              <div class="why-point-title">We Only Do One Thing</div>
              <div class="why-point-desc">Every strategy, keyword, and page we build is for a homecare agency,
                nothing else. That focus means faster results and none of your budget wasted on trial and error.</div>
            </div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-brands fa-google"></i></div>
            <div>
              <div class="why-point-title">AI Search SEO, Before Your Competitors Even Know It Exists</div>
              <div class="why-point-desc">We get your agency cited by ChatGPT, Google AI Overviews, and Perplexity.
                Most agencies in your city haven't heard of this yet.</div>
            </div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-layer-group"></i></div>
            <div>
              <div class="why-point-title">One Partner for Marketing and Software</div>
              <div class="why-point-desc">Pair CareOS with our agency services and you get a growth loop your
                competitors can't copy.</div>
            </div>
          </div>
          <div class="why-point">
            <div class="why-point-icon"><i class="fa-solid fa-dollar-sign"></i></div>
            <div>
              <div class="why-point-title">Every New Client = $3,000–$8,000/Year</div>
              <div class="why-point-desc">Land one new client through our SEO and it often covers the entire
                retainer within 30 days.</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════
   SERVICES — detailed 2-column breakdown
══════════════════════════ -->
<section class="services" id="services" style="background:#fff;padding-bottom:0">
  <div class="container">
    <div class="services-header">
      <div data-reveal>
        <p class="section-label" style="justify-content:center">What We Do</p>
        <h2 class="section-h2">Everything Your Agency<br>Needs to <em>Dominate</em></h2>
      </div>
      <p class="section-sub" data-reveal style="transition-delay:.1s;margin:0 auto">Five done-for-you service lines, built around
        what actually moves the needle for a homecare agency.</p>
    </div>
  </div>
</section>

<!-- SERVICE: Home Care SEO -->
<section class="svc-detail" style="background:var(--cream)">
  <div class="container">
    <div class="svc-detail-grid">
      <div data-reveal>
        <div class="svc-detail-icon"><i class="fa-solid fa-magnifying-glass-chart"></i></div>
        <p class="section-label">Home Care SEO</p>
        <h2 class="section-h2">Get Found by Families<br>When They Need <em>Care Most</em></h2>
        <p>When someone starts looking for home care, they usually don't ask around first. They search online.</p>
        <p>They compare agencies, read reviews, visit websites, and often make a shortlist before they ever pick up the phone.</p>
        <p>If your agency isn't showing up in those searches, you're missing opportunities every single day.</p>
        <p>At Homecare Creators, we specialize in SEO built specifically for home care agencies. We don't chase vanity rankings or traffic that never converts. Our focus is helping your agency appear where it matters most, when families are actively searching for care in your community.</p>
        <p>From improving your local visibility to creating helpful content that answers real questions, every strategy is designed to help more families discover your agency and feel confident choosing you.</p>
        <p class="svc-detail-closer">The goal isn't just better rankings. It's more inquiries from families who are ready to find care.</p>
      </div>
      <div class="svc-detail-card" data-reveal style="transition-delay:.15s">
        <div class="svc-detail-card-title">What We Help With</div>
        <ul class="svc-detail-list">
          <li><i class="fa-solid fa-check"></i>Local SEO for your service areas</li>
          <li><i class="fa-solid fa-check"></i>Google Business Profile optimization</li>
          <li><i class="fa-solid fa-check"></i>Technical SEO improvements</li>
          <li><i class="fa-solid fa-check"></i>Content that answers families' questions</li>
          <li><i class="fa-solid fa-check"></i>Service & location pages</li>
          <li><i class="fa-solid fa-check"></i>Monthly performance reporting</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- SERVICE: Home Care Website Design -->
<section class="svc-detail" style="background:#fff">
  <div class="container">
    <div class="svc-detail-grid">
      <div data-reveal>
        <div class="svc-detail-icon"><i class="fa-solid fa-laptop-code"></i></div>
        <p class="section-label">Home Care Website Design</p>
        <h2 class="section-h2">A Website That Builds Trust<br><em>Before the First Call</em></h2>
        <p>Families don't choose a home care provider because of fancy animations or trendy designs.</p>
        <p>They choose the agency that feels trustworthy, professional, and easy to contact. Your website should reassure families that they've found the right place.</p>
        <p>We create websites designed specifically for home care agencies: sites that clearly explain your services, answer common questions, showcase your experience, and guide visitors toward taking the next step.</p>
        <p>Every page is built to make it easy for someone to say, "This is the agency I want to call."</p>
        <p class="svc-detail-closer">A great website doesn't just look professional. It helps families feel confident reaching out.</p>
      </div>
      <div class="svc-detail-card" data-reveal style="transition-delay:.15s">
        <div class="svc-detail-card-title">Every Website Includes</div>
        <ul class="svc-detail-list">
          <li><i class="fa-solid fa-check"></i>Custom design tailored to your agency</li>
          <li><i class="fa-solid fa-check"></i>Mobile-friendly experience</li>
          <li><i class="fa-solid fa-check"></i>Fast loading speeds</li>
          <li><i class="fa-solid fa-check"></i>Clear calls-to-action</li>
          <li><i class="fa-solid fa-check"></i>SEO-ready structure</li>
          <li><i class="fa-solid fa-check"></i>Easy-to-manage content</li>
        </ul>
        <a href="/seo/homecare-website-design" class="svc-detail-link">See Website Packages <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- SERVICE: Local SEO -->
<section class="svc-detail" style="background:var(--cream)">
  <div class="container">
    <div class="svc-detail-grid">
      <div data-reveal>
        <div class="svc-detail-icon"><i class="fa-solid fa-map-location-dot"></i></div>
        <p class="section-label">Local SEO</p>
        <h2 class="section-h2">Help Families Find Your<br>Agency <em>In Their Community</em></h2>
        <p>Most families aren't searching for home care across the country. They're looking for trusted providers close to home. That's why local visibility matters.</p>
        <p>We help your agency appear in Google Maps and local search results when families search for services in your city or surrounding areas.</p>
        <p>Whether you serve one community or multiple counties across Florida, we build a local SEO strategy that helps your agency become more visible where it matters most.</p>
        <p class="svc-detail-closer">When someone searches for home care nearby, your agency should be one of the first names they see.</p>
      </div>
      <div class="svc-detail-card" data-reveal style="transition-delay:.15s">
        <div class="svc-detail-card-title">Local SEO Services</div>
        <ul class="svc-detail-list">
          <li><i class="fa-solid fa-check"></i>Google Business Profile optimization</li>
          <li><i class="fa-solid fa-check"></i>Service area optimization</li>
          <li><i class="fa-solid fa-check"></i>Citation management</li>
          <li><i class="fa-solid fa-check"></i>Review strategy</li>
          <li><i class="fa-solid fa-check"></i>Local landing pages</li>
          <li><i class="fa-solid fa-check"></i>Google Maps optimization</li>
        </ul>
        <a href="/seo/local-seo-for-home-care-agencies" class="svc-detail-link">See Local SEO Packages <i class="fa-solid fa-arrow-right"></i></a>
      </div>
    </div>
  </div>
</section>

<!-- SERVICE: AI Search Optimization (GEO) -->
<section class="svc-detail" style="background:#fff">
  <div class="container">
    <div class="svc-detail-grid">
      <div data-reveal>
        <div class="svc-detail-icon"><i class="fa-solid fa-brain"></i></div>
        <p class="section-label">AI Search Optimization (GEO)</p>
        <h2 class="section-h2">Be Visible in the<br><em>Future of Search</em></h2>
        <p>The way people search is changing. Families are starting to ask ChatGPT, Google AI, Gemini, and other AI-powered tools for recommendations instead of only using traditional Google searches.</p>
        <p>That means your website needs to be prepared for more than just search engines.</p>
        <p>We help home care agencies create content and structure their websites in ways that make them easier for AI-powered search platforms to understand, trust, and recommend.</p>
        <p>While no one can guarantee AI recommendations, preparing your website today puts your agency in a much stronger position as search continues to evolve.</p>
        <p class="svc-detail-closer">It's about preparing your agency for where search is going, not just where it is today.</p>
      </div>
      <div class="svc-detail-card" data-reveal style="transition-delay:.15s">
        <div class="svc-detail-card-title">Our GEO Strategy Includes</div>
        <ul class="svc-detail-list">
          <li><i class="fa-solid fa-check"></i>AI-friendly website structure</li>
          <li><i class="fa-solid fa-check"></i>Schema markup</li>
          <li><i class="fa-solid fa-check"></i>Entity optimization</li>
          <li><i class="fa-solid fa-check"></i>Topical authority development</li>
          <li><i class="fa-solid fa-check"></i>Helpful, people-first content</li>
          <li><i class="fa-solid fa-check"></i>Future-ready SEO strategy</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- SERVICE: AI & Automation -->
<section class="svc-detail" style="background:var(--cream)">
  <div class="container">
    <div class="svc-detail-grid">
      <div data-reveal>
        <div class="svc-detail-icon"><i class="fa-solid fa-gears"></i></div>
        <p class="section-label">AI & Automation</p>
        <h2 class="section-h2">Spend Less Time Chasing Leads,<br><em>More Time Giving Care</em></h2>
        <p>Running a home care agency comes with enough moving parts already. Answering inquiries, following up with families, scheduling consultations, and keeping everything organized can quickly become overwhelming.</p>
        <p>We help automate the repetitive work so your team can focus on delivering exceptional care.</p>
        <p>From AI chat assistants that answer questions after hours to automated follow-ups that ensure no inquiry is forgotten, we build systems that help your agency respond faster and stay connected with every potential client.</p>
        <p class="svc-detail-closer">Technology should support your team, not replace the personal care that makes your agency unique.</p>
      </div>
      <div class="svc-detail-card" data-reveal style="transition-delay:.15s">
        <div class="svc-detail-card-title">What We Can Automate</div>
        <ul class="svc-detail-list">
          <li><i class="fa-solid fa-check"></i>AI website chat assistants</li>
          <li><i class="fa-solid fa-check"></i>Lead follow-up workflows</li>
          <li><i class="fa-solid fa-check"></i>Appointment scheduling</li>
          <li><i class="fa-solid fa-check"></i>CRM integrations</li>
          <li><i class="fa-solid fa-check"></i>Email & SMS automation</li>
          <li><i class="fa-solid fa-check"></i>Internal business workflows</li>
        </ul>
      </div>
    </div>
  </div>
</section>

<!-- HOW IT WORKS -->
<section class="how" id="how">
  <div class="container">
    <div data-reveal style="text-align:center;margin-bottom:16px;">
      <p class="section-label" style="justify-content:center">How It Works</p>
      <h2 class="section-h2" style="text-align:center">From Zero to <em>#1</em><br>in 4 Simple Steps</h2>
    </div>
    <div class="how-grid" data-reveal style="transition-delay:.1s">
      <div class="how-step">
        <div class="how-step-num">1<div class="how-step-icon"><i class="fa-solid fa-calendar"></i></div>
        </div>
        <div class="how-step-title">Book Free Audit</div>
        <div class="how-step-desc">We dig through your website, SEO, Google profile, and a couple of local
          competitors. No cost, no catch.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">2<div class="how-step-icon"><i class="fa-solid fa-map"></i></div>
        </div>
        <div class="how-step-title">Custom Growth Plan</div>
        <div class="how-step-desc">You get a 90-day roadmap built around your market, with real ROI numbers attached
          to it, not vague promises.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">3<div class="how-step-icon"><i class="fa-solid fa-gears"></i></div>
        </div>
        <div class="how-step-title">We Execute for You</div>
        <div class="how-step-desc">A dedicated team runs the whole plan day to day. You keep running care, we
          run the growth side.</div>
      </div>
      <div class="how-step">
        <div class="how-step-num">4<div class="how-step-icon"><i class="fa-solid fa-chart-line"></i></div>
        </div>
        <div class="how-step-title">Watch Your Agency Grow</div>
        <div class="how-step-desc">Rankings climb. Leads pick up. Reviews stack. And you'll hear about all of it on
          a monthly strategy call, not just a report you never open.</div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════
   CAREOS — COMING SOON SAAS
══════════════════════════ -->
<section class="careos" id="careos">
  <div class="careos-stars"></div>
  <div class="careos-glow"></div>
  <div class="careos-grid-lines"></div>
  <div class="container careos-inner">
    <div style="text-align:center" data-reveal>
      <div class="careos-top-badge">
        <div class="careos-top-badge-dot"></div>Coming Q3 2026 — Join the Waitlist Now
      </div>
      <h2 class="careos-headline">Meet <em>CareOS</em>:<br>The AI Brain for Your Agency</h2>
      <p class="careos-subhead">It's the first AI-powered management platform built just for homecare agencies.
        Scheduling, billing, voice AI, family portals, growth tools. One login, not six.</p>
      <p class="careos-tagline"><i class="fa-solid fa-circle-dot"
          style="margin-right:8px;color:var(--teal-lt)"></i>Early access members save 40% for life</p>
    </div>
    <div class="careos-launch" data-reveal style="transition-delay:.1s">
      <div class="careos-launch-item"><span class="careos-launch-num" id="cntD">00</span><span
          class="careos-launch-label">Days</span></div>
      <div class="careos-launch-item"><span class="careos-launch-num" id="cntH">00</span><span
          class="careos-launch-label">Hours</span></div>
      <div class="careos-launch-item"><span class="careos-launch-num" id="cntM">00</span><span
          class="careos-launch-label">Minutes</span></div>
      <div class="careos-launch-item"><span class="careos-launch-num" id="cntS">00</span><span
          class="careos-launch-label">Seconds</span></div>
    </div>
    <div class="careos-modules-grid" data-reveal style="transition-delay:.15s">
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-calendar-days"></i></div>
        <div class="careos-module-name">Smart Scheduling</div>
        <div class="careos-module-desc">AI matches shifts to the right caregiver, flags conflicts before they
          happen, and remembers everyone's preferences so double bookings stop being a thing.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-microphone"></i></div>
        <div class="careos-module-name">Voice Shift Journal</div>
        <div class="careos-module-desc">A caregiver talks for 60 seconds and the AI turns it into compliance logs,
          a family update, and incident flags in under 8 seconds flat.</div><span class="module-badge badge-ai">AI Feature</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-heart"></i></div>
        <div class="careos-module-name">Family Trust Portal</div>
        <div class="careos-module-desc">Families see shift updates as they happen, plus AI care summaries and mood
          timelines. It's the kind of transparency that keeps them from shopping around.</div><span class="module-badge badge-new">Unique</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-file-invoice-dollar"></i></div>
        <div class="careos-module-name">Billing & Payroll</div>
        <div class="careos-module-desc">Handles private pay, Medicaid, and long-term care billing in one system.
          Invoices go out automatically, ERA reconciliation runs itself, and it connects straight to Stripe.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-star"></i></div>
        <div class="careos-module-name">Auto Review Engine</div>
        <div class="careos-module-desc">Sends review requests the moment satisfaction is running high, and catches
          negative feedback before it ever hits Google.</div><span class="module-badge badge-ai">AI Feature</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-brain"></i></div>
        <div class="careos-module-name">Predictive Intelligence</div>
        <div class="careos-module-desc">Flags which clients are at risk of leaving, warns you before a caregiver
          quits, and forecasts revenue 90 days out.</div><span class="module-badge badge-ai">AI Feature</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-map-pin"></i></div>
        <div class="careos-module-name">EVV & Compliance</div>
        <div class="careos-module-desc">GPS check-in and check-out, HHAeXchange sync, and a mandate tracker that
          covers all 50 states so you're never caught off guard by a missed visit.</div><span class="module-badge badge-core">Core</span>
      </div>
      <div class="careos-module">
        <div class="careos-module-icon"><i class="fa-solid fa-people-group"></i></div>
        <div class="careos-module-name">Caregiver Wellness</div>
        <div class="careos-module-desc">Picks up on burnout from voice tone and shift patterns before a caregiver
          walks out, saving you the $4,500–$8,000 it typically costs to replace one.</div><span class="module-badge badge-new">Industry First</span>
      </div>
    </div>
    <div class="careos-cta-box" data-reveal style="transition-delay:.2s">
      <h3 class="careos-cta-title">Be First. Save 40% for Life.</h3>
      <p class="careos-cta-desc">Get on the CareOS waitlist now and you'll never pay full price. The 40% lifetime
        discount locks in the day you sign up.</p>
      <div class="careos-cta-perks">
        <div class="careos-cta-perk"><i class="fa-solid fa-check-circle"></i>40% lifetime discount</div>
        <div class="careos-cta-perk"><i class="fa-solid fa-check-circle"></i>Free onboarding & migration</div>
        <div class="careos-cta-perk"><i class="fa-solid fa-check-circle"></i>Priority feature access</div>
        <div class="careos-cta-perk"><i class="fa-solid fa-check-circle"></i>Founding member badge</div>
      </div>
      <button class="btn-primary"
        style="font-size:15px;padding:16px 40px;display:inline-flex;position:relative;z-index:2;"
        onclick="openPopup('waitlist')">
        <i class="fa-solid fa-rocket"></i>Join the CareOS Waitlist
      </button>
      <p
        style="margin-top:16px;font-size:12px;color:rgba(255,255,255,.35);font-family:'Syne',sans-serif;position:relative;z-index:2;">
        <i class="fa-solid fa-users" style="margin-right:5px;color:var(--teal)"></i>247 homecare agencies already on
        the waitlist</p>
    </div>
  </div>
</section>

<!-- AI SEO HIGHLIGHT -->
<section class="ai-seo" id="ai-seo">
  <div class="container">
    <div class="ai-seo-inner" data-reveal>
      <div class="ai-seo-left">
        <p class="section-label">The Unfair Advantage</p>
        <h2 class="section-h2" style="color:#fff;font-size:clamp(28px,3.2vw,44px)">Your Agency, Cited
          by<br><em>ChatGPT & Google AI</em></h2>
        <p class="ai-seo-desc">Families are typing "what's the best homecare agency near me" into ChatGPT now, not
          just Google. We make sure your name is the one it gives them.</p>
        <div class="ai-pillars">
          <div class="ai-pillar">
            <div class="ai-pillar-icon"><i class="fa-solid fa-robot"></i></div>
            <div>
              <div class="ai-pillar-title">ChatGPT & Perplexity Optimisation</div>
              <div class="ai-pillar-sub">We structure your content and entity signals so AI models actually
                recommend your agency by name.</div>
            </div>
          </div>
          <div class="ai-pillar">
            <div class="ai-pillar-icon"><i class="fa-brands fa-google"></i></div>
            <div>
              <div class="ai-pillar-title">Google AI Overviews Placement</div>
              <div class="ai-pillar-sub">Over 50 FAQ schemas, E-E-A-T signals, and author pages built to earn a spot
                in the featured AI answers.</div>
            </div>
          </div>
          <div class="ai-pillar">
            <div class="ai-pillar-icon"><i class="fa-solid fa-network-wired"></i></div>
            <div>
              <div class="ai-pillar-title">Knowledge Graph Entity Creation</div>
              <div class="ai-pillar-sub">Your agency gets verified as a real entity across Google's Knowledge Graph
                and the AI systems that pull from it.</div>
            </div>
          </div>
          <div class="ai-pillar">
            <div class="ai-pillar-icon"><i class="fa-solid fa-chart-bar"></i></div>
            <div>
              <div class="ai-pillar-title">Monthly AI Citation Audit</div>
              <div class="ai-pillar-sub">Every month we check where you're showing up in AI answers and tighten
                whatever's slipping.</div>
            </div>
          </div>
        </div>
      </div>
      <div class="ai-seo-right">
        <img src="/images/home/ai-seo-tech.jpg"
          alt="AI search technology helping home care agencies get cited by ChatGPT and Google AI Overviews"
          title="AI search technology for home care agency visibility">
        <div class="ai-seo-platforms">
          <div class="ai-platform-pill"><i class="fa-brands fa-google"></i>Google AI Overviews</div>
          <div class="ai-platform-pill"><i class="fa-solid fa-robot"></i>ChatGPT Citations</div>
          <div class="ai-platform-pill"><i class="fa-solid fa-magnifying-glass"></i>Perplexity AI</div>
          <div class="ai-platform-pill"><i class="fa-solid fa-layer-group"></i>Bing Copilot</div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════
   PRICING BUNDLES
══════════════════════════ -->
<section class="bundles" id="bundles">
  <div class="bundles-bg"></div>
  <div class="container">
    <div class="bundles-header" data-reveal>
      <p class="section-label">Transparent Pricing</p>
      <h2 class="section-h2">Simple Bundle Pricing.<br>Everything <em>Included.</em></h2>
      <p class="section-sub" style="margin:0 auto;text-align:center;">Every plan comes with CareOS software access
        built in. No hidden fees, cancel whenever you want. <span class="savings-badge">20% OFF — Limited Time</span></p>
    </div>
    <div class="bundles-grid">
      <div class="bundle-card" data-reveal style="transition-delay:.05s">
        <div class="bundle-top-bar"></div>
        <div class="bundle-badge"><i class="fa-solid fa-seedling" style="margin-right:4px"></i>Launch Bundle</div>
        <div class="bundle-name">Starter</div>
        <div class="bundle-orig-price">Was $1,039/mo</div>
        <div class="bundle-price"><sub>$</sub>831<span>/mo</span></div>
        <div class="bundle-setup">+ $960 one-time setup (was $1,200)</div>
        <div class="bundle-divider"></div>
        <ul class="bundle-features">
          <li><i class="fa-solid fa-circle-check"></i>CareOS Starter plan included</li>
          <li><i class="fa-solid fa-circle-check"></i>5-page website built & hosted</li>
          <li><i class="fa-solid fa-circle-check"></i>Google My Business management</li>
          <li><i class="fa-solid fa-circle-check"></i>Local SEO (citations + on-page)</li>
          <li><i class="fa-solid fa-circle-check"></i>Brand Starter kit</li>
          <li><i class="fa-solid fa-circle-check"></i>Monthly review management</li>
          <li><i class="fa-solid fa-circle-check"></i>30-min monthly strategy call</li>
        </ul>
        <button class="bundle-cta bundle-cta-default" onclick="openPopup('starter')">Get Started</button>
      </div>
      <div class="bundle-card featured" data-reveal style="transition-delay:.1s">
        <div class="bundle-top-bar"></div>
        <div class="bundle-badge hot"><i class="fa-solid fa-fire" style="margin-right:4px"></i>Most Popular</div>
        <div class="bundle-name">Scale</div>
        <div class="bundle-orig-price">Was $1,599/mo</div>
        <div class="bundle-price"><sub>$</sub>1,279<span>/mo</span></div>
        <div class="bundle-setup">Everything to grow fast</div>
        <div class="bundle-divider"></div>
        <ul class="bundle-features">
          <li><i class="fa-solid fa-circle-check"></i>CareOS Growth plan included</li>
          <li><i class="fa-solid fa-circle-check"></i>Full SEO + AI Search SEO</li>
          <li><i class="fa-solid fa-circle-check"></i>Social media (3 posts/week)</li>
          <li><i class="fa-solid fa-circle-check"></i>Monthly email newsletter</li>
          <li><i class="fa-solid fa-circle-check"></i>Review engine + referral activator</li>
          <li><i class="fa-solid fa-circle-check"></i>Dedicated account manager</li>
          <li><i class="fa-solid fa-circle-check"></i>60-min monthly strategy call</li>
        </ul>
        <button class="bundle-cta bundle-cta-featured" onclick="openPopup('scale')">Start Growing &rarr;</button>
      </div>
      <div class="bundle-card" data-reveal style="transition-delay:.15s">
        <div class="bundle-top-bar"></div>
        <div class="bundle-badge"><i class="fa-solid fa-crown" style="margin-right:4px"></i>Dominate Bundle</div>
        <div class="bundle-name">Dominate</div>
        <div class="bundle-orig-price">Was $2,799/mo</div>
        <div class="bundle-price"><sub>$</sub>2,239<span>/mo</span></div>
        <div class="bundle-setup">Full-service growth partner</div>
        <div class="bundle-divider"></div>
        <ul class="bundle-features">
          <li><i class="fa-solid fa-circle-check"></i>CareOS Agency Pro included</li>
          <li><i class="fa-solid fa-circle-check"></i>All marketing services</li>
          <li><i class="fa-solid fa-circle-check"></i>AI Dominance SEO package</li>
          <li><i class="fa-solid fa-circle-check"></i>Social media (5 posts/week)</li>
          <li><i class="fa-solid fa-circle-check"></i>Full email automation suite</li>
          <li><i class="fa-solid fa-circle-check"></i>Weekly strategy call (30 min)</li>
          <li><i class="fa-solid fa-circle-check"></i>Fractional CMO access</li>
        </ul>
        <button class="bundle-cta bundle-cta-default" onclick="openPopup('dominate')">Contact Us</button>
      </div>
    </div>
    <p class="bundles-note"><i class="fa-solid fa-shield-halved" style="color:var(--teal);margin-right:6px"></i>Every
      plan comes with a 30-day satisfaction guarantee, no long-term contract attached.</p>
  </div>
</section>

<!-- RESULTS -->
<section class="results" id="results">
  <div class="container">
    <div class="results-inner">
      <div class="results-image-wrap" data-reveal>
        <div class="results-image">
          <img src="/images/home/results-growth.jpg"
            alt="Home care agency growth results achieved with Homecare Creators marketing"
            title="Home care agency growth results">
        </div>
        <div class="results-stat-card">
          <div class="results-stat-num">312%</div>
          <div class="results-stat-label">Lead Increase<br>in 6 Months</div>
        </div>
      </div>
      <div data-reveal style="transition-delay:.15s">
        <p class="section-label">Proven Results</p>
        <h2 class="section-h2">What Homecare Agencies<br><em>Achieve With Us</em></h2>
        <p class="section-sub" style="margin-bottom:36px">These numbers come from actual agency owners we work with.
          Not projections we made up in a pitch deck.</p>
        <div class="results-grid-right">
          <div class="result-card">
            <div class="result-card-icon"><i class="fa-brands fa-google"></i></div>
            <div class="result-num">8&rarr;67</div>
            <div class="result-label">Google Reviews in 90 Days</div>
            <div class="result-desc">Using our AI review automation</div>
          </div>
          <div class="result-card">
            <div class="result-card-icon"><i class="fa-solid fa-arrow-trend-up"></i></div>
            <div class="result-num">312%</div>
            <div class="result-label">Website Lead Increase</div>
            <div class="result-desc">Avg uplift after website + SEO in 6 months</div>
          </div>
          <div class="result-card">
            <div class="result-card-icon"><i class="fa-solid fa-clock"></i></div>
            <div class="result-num">12h</div>
            <div class="result-label">Saved Per Week</div>
            <div class="result-desc">Via CareOS AI voice journaling</div>
          </div>
          <div class="result-card">
            <div class="result-card-icon"><i class="fa-solid fa-medal"></i></div>
            <div class="result-num">#1</div>
            <div class="result-label">Google Maps Rankings</div>
            <div class="result-desc">Avg position reached within 5 months</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ══════════════════════════
   REVIEWS SLIDER
══════════════════════════ -->
<section class="reviews" id="reviews">
  <div class="container">
    <div class="reviews-header" data-reveal>
      <p class="section-label">What Owners Say</p>
      <h2 class="section-h2">Homecare Owners<br><em>Love the Results</em></h2>
    </div>
    <div class="slider-wrap" data-reveal style="transition-delay:.1s">
      <div class="slider-track" id="sliderTrack">
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"We had 6 Google reviews before Homecare Creators and almost no website traffic
            to speak of. Four months later we're at 52 reviews, ranked #1 in our city, and our inquiry calls have
            tripled. Worth every penny."</p>
          <div class="review-author">
            <div class="review-avatar">SR</div>
            <div>
              <div class="review-name">Sarah R.</div>
              <div class="review-role">Owner, Comfort Home Care &middot; Chicago, IL</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"I'd tried two other marketing agencies before this one, and neither understood
            homecare at all. Homecare Creators knew exactly what we needed. Their SEO strategy was nothing like
            what we'd seen, and it worked."</p>
          <div class="review-author">
            <div class="review-avatar">MJ</div>
            <div>
              <div class="review-name">Marcus J.</div>
              <div class="review-role">Founder, Golden Years Care &middot; Atlanta, GA</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"Their AI Search SEO is unlike anything I've seen from a marketing agency. We
            show up now when families search on ChatGPT and Google AI, and honestly, I don't think our competitors
            even know this is possible yet."</p>
          <div class="review-author">
            <div class="review-avatar">LD</div>
            <div>
              <div class="review-name">Linda D.</div>
              <div class="review-role">CEO, Caring Hands Agency &middot; Houston, TX</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"Zero to 28 private-pay clients in 7 months. The website redesign paired with
            local SEO is genuinely a powerful combination, and the monthly strategy calls keep us honest."</p>
          <div class="review-author">
            <div class="review-avatar">TW</div>
            <div>
              <div class="review-name">Tamara W.</div>
              <div class="review-role">Owner, Sunrise Senior Care &middot; Phoenix, AZ</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"Just the fact that CareOS exists tells you this team thinks differently. They're
            building what homecare operations will actually look like in a few years."</p>
          <div class="review-author">
            <div class="review-avatar">RB</div>
            <div>
              <div class="review-name">Robert B.</div>
              <div class="review-role">CEO, Premier Home Health &middot; Dallas, TX</div>
            </div>
          </div>
        </div>
        <div class="review-card">
          <div class="review-stars">&#9733;&#9733;&#9733;&#9733;&#9733;</div>
          <p class="review-quote">"Three months in, a family told us they found us through ChatGPT. I was floored,
            honestly. This team is ahead of the curve, and homecare is the only thing they do."</p>
          <div class="review-author">
            <div class="review-avatar">AC</div>
            <div>
              <div class="review-name">Angela C.</div>
              <div class="review-role">Director, CareFirst Agency &middot; Miami, FL</div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="slider-controls">
      <button class="slider-btn" onclick="slideReviews(-1)" aria-label="Previous"><i
          class="fa-solid fa-chevron-left"></i></button>
      <div class="slider-dots" id="sliderDots"></div>
      <button class="slider-btn" onclick="slideReviews(1)" aria-label="Next"><i
          class="fa-solid fa-chevron-right"></i></button>
    </div>
  </div>
</section>

<!-- ══════════════════════════
   FAQ
══════════════════════════ -->
<section class="faq" id="faq">
  <div class="container">
    <div class="faq-header" data-reveal>
      <p class="section-label">FAQ</p>
      <h2 class="section-h2">Frequently Asked<br><em>Questions</em></h2>
    </div>
    <div class="faq-list" data-reveal style="transition-delay:.1s">

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">How long before I see results?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>Google My Business results usually show up first, often within 30 days. Broader ranking improvements
              tend to follow in the 60–90 day range, and most clients see website leads pick up within that first
              90-day window after launch.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">Do you work with any type of homecare agency?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>Yes. Companion care, personal care, skilled nursing, Medicaid waiver, private-pay, it doesn't matter.
              We build the strategy around your specific payer mix and service area, not a one-size-fits-all
              template.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">What is AI Search SEO and why does it matter?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>People also call it GEO. It's the process of shaping your content so it gets pulled into AI-generated
              answers on ChatGPT, Google AI Overviews, and Perplexity. Millions of families are already using AI to
              search for homecare, and this is how we make sure they land on your agency.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">Is there a long-term contract?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>No. Every plan goes month-to-month after the first 90 days, because we'd rather keep you as a client
              through results than a contract. If you want to commit annually, there are extra discounts for that
              too.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">What is CareOS and when does it launch?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>It's our AI-powered management platform for homecare agencies. Scheduling, billing, EVV compliance,
              voice AI journaling, family portals, growth tools, all of it. CareOS launches in Q3 2026, and joining
              the waitlist now locks in 40% off for life.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">How is Homecare Creators different from other agencies?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>We don't touch restaurants, dentists, or e-commerce. Homecare is the only thing we do, so every
              strategy, keyword, and piece of content is built specifically for it. On top of that, we're the ones
              building the software platform that runs the agencies we market for.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">What does the free audit include?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>We look at your website speed and SEO health, audit your Google Maps and GMB profile, compare you
              against local competitors, and go through your review profile. You walk away with a 90-day growth
              roadmap. No strings attached, no cost.</p>
          </div>
        </div>
      </div>

      <div class="faq-item">
        <div class="faq-q" onclick="toggleFaq(this)">
          <span class="faq-q-text">Do you guarantee results?</span>
          <div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div>
        </div>
        <div class="faq-a">
          <div class="faq-a-inner">
            <p>Every plan comes with a 30-day satisfaction guarantee. Not happy after the first month? We'll refund
              it, no questions asked. We can offer that because we know the work holds up.</p>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ══════════════════════════
   CONTACT FORM
══════════════════════════ -->
<section class="contact-section" id="contact">
  <div class="container">
    <div class="contact-inner">
      <div class="contact-info" data-reveal>
        <p class="section-label">Get in Touch</p>
        <h2 class="section-h2">Let's Grow Your<br><em>Agency Together</em></h2>
        <p class="contact-desc">Got a question about our services, pricing, or CareOS? Fill out the form below and
          someone from our team will get back to you within 24 hours.</p>
        <div class="contact-details">
          <div class="contact-detail">
            <div class="contact-detail-icon"><i class="fa-solid fa-envelope"></i></div>
            <div>
              <div class="contact-detail-label">Email Us</div>
              <div class="contact-detail-value"><a
                  href="mailto:hello@homecarecreators.com">hello@homecarecreators.com</a></div>
            </div>
          </div>
          <div class="contact-detail">
            <div class="contact-detail-icon"><i class="fa-brands fa-linkedin-in"></i></div>
            <div>
              <div class="contact-detail-label">LinkedIn</div>
              <div class="contact-detail-value"><a href="https://www.linkedin.com/company/homecare-creators/"
                  target="_blank" rel="noopener">linkedin.com/company/homecare-creators</a></div>
            </div>
          </div>
          <div class="contact-detail">
            <div class="contact-detail-icon"><i class="fa-solid fa-clock"></i></div>
            <div>
              <div class="contact-detail-label">Response Time</div>
              <div class="contact-detail-value">Within 24 hours, Monday&ndash;Friday</div>
            </div>
          </div>
          <div class="contact-detail">
            <div class="contact-detail-icon"><i class="fa-solid fa-shield-halved"></i></div>
            <div>
              <div class="contact-detail-label">Free Audit</div>
              <div class="contact-detail-value">30-min growth audit, no obligation</div>
            </div>
          </div>
        </div>
      </div>
      <div class="contact-form-card" data-reveal style="transition-delay:.15s">
        <div class="form-title">Send Us a Message</div>
        <div class="form-subtitle">We'll get back to you within 24 hours.</div>
        <div id="contactFormWrap">
          <div class="form-row">
            <div class="form-group" style="margin-bottom:0"><label class="form-label" for="cfFirst">First Name
                *</label><input type="text" class="form-input" id="cfFirst" placeholder="Sarah"
                autocomplete="given-name"></div>
            <div class="form-group" style="margin-bottom:0"><label class="form-label" for="cfLast">Last Name
                *</label><input type="text" class="form-input" id="cfLast" placeholder="Johnson"
                autocomplete="family-name"></div>
          </div>
          <div class="form-group"><label class="form-label" for="cfEmail">Email Address *</label><input type="email"
              class="form-input" id="cfEmail" placeholder="sarah@agency.com" autocomplete="email"></div>
          <div class="form-group"><label class="form-label" for="cfPhone">Phone Number</label><input type="tel"
              class="form-input" id="cfPhone" placeholder="+1 (555) 000-0000" autocomplete="tel"></div>
          <div class="form-group"><label class="form-label" for="cfAgency">Agency Name</label><input type="text"
              class="form-input" id="cfAgency" placeholder="Comfort Home Care LLC"></div>
          <div class="form-group"><label class="form-label" for="cfService">How Can We Help?</label>
            <select class="form-select" id="cfService">
              <option value="">Select a topic...</option>
              <option>Free Growth Audit</option>
              <option>Website Development</option>
              <option>Local SEO</option>
              <option>AI Search SEO</option>
              <option>Full Bundle Package</option>
              <option>CareOS Waitlist</option>
              <option>General Enquiry</option>
            </select>
          </div>
          <div class="form-group"><label class="form-label" for="cfMessage">Message</label><textarea
              class="form-textarea" id="cfMessage"
              placeholder="Tell us about your agency and what you'd like to achieve..."></textarea></div>
          <button class="form-submit" onclick="submitContact()"><i class="fa-solid fa-paper-plane"></i>Send
            Message</button>
        </div>
        <div class="form-success" id="contactSuccess">
          <i class="fa-solid fa-circle-check"></i>
          <div class="form-success-title">Message Received!</div>
          <p>Thank you! We'll reply within 24 hours.</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- CTA -->
<section class="cta-section">
  <div class="container">
    <div class="cta-inner">
      <div class="cta-content" data-reveal>
        <p class="section-label">Get Started Today</p>
        <h2 class="section-h2">Ready to Grow Your<br><em>Homecare Agency?</em></h2>
        <p class="cta-desc">Book a free 30-minute growth audit and we'll walk through your digital presence with
          you, then show you exactly what needs fixing. No obligation, no sales pitch.</p>
        <div class="cta-actions">
          <button class="btn-primary" style="font-size:15px;padding:16px 32px;" onclick="openPopup('audit')"><i
              class="fa-solid fa-calendar-check"></i>Book Your Free Audit</button>
        </div>
        <div class="cta-guarantee"><i class="fa-solid fa-shield-halved"></i>Free audit &nbsp;&middot;&nbsp; No
          obligation &nbsp;&middot;&nbsp; Results in 30 days guaranteed</div>
      </div>
      <div class="cta-image" data-reveal style="transition-delay:.15s">
        <img src="/images/home/cta-business-owner.jpg"
          alt="Home care agency owner reviewing a free growth audit with Homecare Creators"
          title="Home care agency owner growing their business">
        <div class="cta-image-badge">
          <div class="cta-image-badge-title"><i class="fa-solid fa-circle-dot"
              style="color:var(--teal-lt);margin-right:4px"></i>Audit Includes</div>
          <div class="cta-badge-row">
            <div class="cta-badge-dot"></div>
            <div class="cta-badge-text">Website & speed analysis</div>
          </div>
          <div class="cta-badge-row">
            <div class="cta-badge-dot"></div>
            <div class="cta-badge-text">Google ranking audit</div>
          </div>
          <div class="cta-badge-row">
            <div class="cta-badge-dot"></div>
            <div class="cta-badge-text">Competitor comparison</div>
          </div>
          <div class="cta-badge-row">
            <div class="cta-badge-dot"></div>
            <div class="cta-badge-text">90-day growth roadmap</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<?php include 'includes/footer.php'; ?>
