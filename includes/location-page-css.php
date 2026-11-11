<?php
// Shared styles for state and Florida city location pages.
return <<<'CSS'
.container{max-width:1280px}
.section-h2{font-size:clamp(24px,3.2vw,42px)}
.hero{background:var(--forest);position:relative;overflow:hidden;padding:150px 0 72px}
.hero-bg-grid{position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.055) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.055) 1px,transparent 1px);background-size:60px 60px;mask-image:radial-gradient(ellipse 90% 90% at 30% 50%,black 20%,transparent 80%)}
.hero-grid{position:relative;z-index:2;max-width:1280px;margin:0 auto;display:grid;grid-template-columns:1.05fr .95fr;gap:64px;align-items:center;padding:0 48px}
.hero-breadcrumb{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:600;letter-spacing:1px;color:rgba(255,255,255,.4);margin-bottom:18px}
.hero-breadcrumb a{color:rgba(255,255,255,.4);text-decoration:none}
.hero-breadcrumb span{color:var(--teal-lt)}
.hero-badge{display:inline-flex;align-items:center;gap:9px;background:rgba(29,158,117,.12);border:1px solid rgba(29,158,117,.28);padding:7px 16px;border-radius:100px;font-family:'Plus Jakarta Sans',sans-serif;font-size:11.5px;font-weight:700;color:var(--mint);letter-spacing:.9px;text-transform:uppercase;margin-bottom:24px}
.hero-h1{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(26px,3.4vw,42px);line-height:1.15;color:#fff;margin-bottom:20px}
.hero-h1 em{font-style:italic;color:var(--teal-lt)}
.hero-desc{font-size:17.5px;line-height:1.75;color:rgba(255,255,255,.66);max-width:500px;margin-bottom:32px}
.hero-actions{display:flex;gap:14px;flex-wrap:wrap;margin-bottom:36px}
.hero-proof{display:flex;gap:28px;flex-wrap:wrap}
.hero-proof-item{display:flex;flex-direction:column;gap:2px}
.hero-proof-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;color:var(--teal-lt);line-height:1}
.hero-proof-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:500;color:rgba(255,255,255,.5)}
.hero-photo-wrap{position:relative}
.hero-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/4.4;position:relative;box-shadow:0 30px 80px rgba(0,0,0,.4)}
.hero-photo img{width:100%;height:100%;object-fit:cover;display:block}
.hero-photo-badge{position:absolute;bottom:-20px;left:-20px;z-index:3;background:#fff;border-radius:16px;padding:16px 20px;box-shadow:0 20px 50px rgba(10,46,30,.25);display:flex;align-items:center;gap:12px}
.hero-photo-badge-icon{width:40px;height:40px;border-radius:11px;background:rgba(29,158,117,.1);color:var(--teal);display:flex;align-items:center;justify-content:center;font-size:17px;flex-shrink:0}
.hero-photo-badge-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:800;color:var(--forest);line-height:1.15}
.hero-photo-badge-label{font-size:11px;color:var(--muted);font-weight:600;font-family:'Plus Jakarta Sans',sans-serif}
.lede{font-size:17px;line-height:1.8;color:var(--muted);margin-bottom:16px}
.lede strong{color:var(--forest)}
.section-cta-btn{display:inline-flex;align-items:center;gap:8px;background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;padding:14px 26px;border-radius:10px;border:none;cursor:pointer;transition:.2s;margin-top:8px;text-decoration:none}
.section-cta-btn:hover{background:var(--forest);transform:translateY(-2px)}
.intro-section{background:#fff}
.intro-grid{display:grid;grid-template-columns:1.1fr .9fr;gap:64px;align-items:center}
.intro-photo{border-radius:24px;overflow:hidden;aspect-ratio:4/4.6;box-shadow:0 24px 70px rgba(10,46,30,.15)}
.intro-photo img{width:100%;height:100%;object-fit:cover;display:block}
/* STATE FACTS */
.facts-section{background:var(--cream)}
.facts-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:36px}
.fact-card{background:#fff;border:1px solid var(--border);border-radius:18px;padding:26px;display:flex;flex-direction:column}
.fact-icon{width:42px;height:42px;border-radius:12px;background:var(--forest);color:var(--teal-lt);display:flex;align-items:center;justify-content:center;font-size:17px;margin-bottom:14px}
.fact-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--forest);margin-bottom:10px}
.fact-card p{font-size:14.5px;line-height:1.7;color:var(--muted)}
.fact-tip{margin-top:14px;padding:12px 14px;background:var(--warm);border-left:3px solid var(--teal);border-radius:8px;font-size:13.5px;line-height:1.6;color:var(--forest)}
.fact-tip strong{color:var(--teal)}
.facts-note{font-size:13px;color:var(--muted);margin-top:18px;font-style:italic}
/* METROS */
.market-section{background:#fff}
.metro-grid{display:grid;grid-template-columns:repeat(2,1fr);gap:20px;margin-top:36px}
.metro-card{background:var(--warm);border:1px solid var(--border);border-left:4px solid var(--teal);border-radius:14px;padding:24px}
.metro-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:16px;font-weight:700;color:var(--forest);margin-bottom:8px}
.metro-card p{font-size:14.5px;line-height:1.7;color:var(--muted)}
/* IDEAS */
.ideas-section{background:var(--cream)}
.ideas-grid{display:grid;grid-template-columns:repeat(3,1fr);gap:20px;margin-top:36px}
.idea-card{background:#fff;border:1px solid var(--border);border-radius:16px;padding:24px}
.idea-num{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:28px;color:var(--teal);line-height:1;margin-bottom:10px}
.idea-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:15.5px;font-weight:700;color:var(--forest);margin-bottom:8px}
.idea-card p{font-size:14px;line-height:1.65;color:var(--muted)}
/* SERVICES */
.services-section{background:#fff}
.svc-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:16px;margin-top:32px}
.svc-card{display:block;text-decoration:none;background:var(--warm);border:1px solid var(--border);border-radius:16px;padding:22px;transition:.25s}
.svc-card:hover{border-color:var(--teal);transform:translateY(-3px)}
.svc-card i{font-size:20px;color:var(--teal);margin-bottom:12px;display:block}
.svc-card h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:15px;font-weight:700;color:var(--forest);margin-bottom:6px}
.svc-card p{font-size:13.5px;line-height:1.6;color:var(--muted)}
/* CASE STUDIES */
.cases-section{background:var(--cream)}
.case-grid{display:grid;grid-template-columns:1fr 1fr;gap:24px;margin-top:36px}
.case-card{background:#fff;border:1px solid var(--border);border-radius:20px;overflow:hidden}
.case-card img{width:100%;display:block;border-bottom:1px solid var(--border)}
.case-body{padding:24px}
.case-badge{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--teal);margin-bottom:6px}
.case-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--forest);margin-bottom:10px}
.case-title span{color:var(--muted);font-weight:500}
.case-text{font-size:14.5px;line-height:1.65;color:var(--muted);margin-bottom:14px}
.case-stats{display:grid;grid-template-columns:repeat(3,1fr);gap:8px}
.case-stat{background:var(--warm);border:1px solid var(--border);border-radius:10px;padding:10px 6px;text-align:center}
.case-stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:19px;font-weight:800;color:var(--teal);line-height:1}
.case-stat-label{font-size:10.5px;color:var(--muted);font-weight:600;margin-top:4px}
.cases-cta{text-align:center;margin-top:28px}
/* PRICING STRIP */
.price-strip{background:#fff}
.price-strip-inner{display:flex;align-items:center;justify-content:space-between;gap:32px;flex-wrap:wrap;background:var(--forest);border-radius:24px;padding:36px 40px}
.price-strip h2{font-family:'Plus Jakarta Sans',sans-serif;color:#fff;font-size:clamp(20px,2.4vw,28px);margin-bottom:8px}
.price-strip p{color:rgba(255,255,255,.7);font-size:15.5px;line-height:1.7;max-width:640px}
.price-strip strong{color:var(--mint)}
.price-strip a{background:#fff;color:var(--forest);text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14px;padding:15px 26px;border-radius:100px;white-space:nowrap}
/* FAQ */
.faq{background:var(--cream)}
.faq-header{text-align:center;margin-bottom:48px}
.faq-header .section-label{justify-content:center}
.faq-list{max-width:820px;margin:0 auto;display:flex;flex-direction:column;gap:12px}
.faq-item{background:#fff;border:1px solid var(--border);border-radius:16px;overflow:hidden}
.faq-q{display:flex;justify-content:space-between;align-items:center;gap:16px;padding:20px 24px;cursor:pointer;user-select:none}
.faq-q-text{font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;color:var(--forest)}
.faq-q-icon{width:28px;height:28px;border-radius:50%;background:var(--forest);color:#fff;display:flex;align-items:center;justify-content:center;font-size:12px;flex-shrink:0;transition:transform .3s,background .3s}
.faq-item.open .faq-q-icon{transform:rotate(45deg);background:var(--teal)}
.faq-a{max-height:0;overflow:hidden;transition:max-height .4s ease}
.faq-item.open .faq-a{max-height:500px}
.faq-a-inner{padding:16px 24px 20px;font-size:15px;line-height:1.75;color:var(--muted);border-top:1px solid var(--border)}
/* OTHER STATES */
.states-section{background:#fff;padding-bottom:40px}
.states-row{display:flex;flex-wrap:wrap;gap:10px;margin-top:20px}
.states-row a{text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:600;color:var(--forest);background:var(--warm);border:1px solid var(--border);border-radius:100px;padding:10px 18px;transition:.2s}
.states-row a:hover{border-color:var(--teal);color:var(--teal)}
/* CTA */
.cta-section{background:#fff;padding:24px 24px 72px}
.cta-card{position:relative;max-width:1100px;margin:0 auto;background:var(--forest);border-radius:36px;padding:64px 48px;text-align:center;overflow:hidden}
.cta-card-inner{position:relative;z-index:2;max-width:640px;margin:0 auto}
.cta-headline{font-family:'Plus Jakarta Sans',sans-serif;font-weight:800;font-size:clamp(21px,2.9vw,30px);line-height:1.25;color:#fff;margin-bottom:18px}
.cta-headline em{font-style:italic;color:var(--mint)}
.cta-sub{font-size:16px;line-height:1.7;color:rgba(255,255,255,.66);margin:0 auto 28px}
.cta-pill-btn{display:inline-flex;align-items:center;gap:10px;background:#fff;color:var(--forest);font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:15px;padding:17px 32px;border-radius:100px;border:none;cursor:pointer;transition:.2s}
.cta-pill-btn:hover{transform:translateY(-2px)}
@media(max-width:1100px){.svc-grid{grid-template-columns:repeat(3,1fr)}}
@media(max-width:1024px){
  .hero-grid{grid-template-columns:1fr;gap:40px;padding:0 32px}
  .intro-grid{grid-template-columns:1fr;gap:32px}
  .intro-photo{max-width:420px;margin:0 auto}
  .facts-grid,.ideas-grid{grid-template-columns:1fr 1fr}
  .metro-grid,.case-grid{grid-template-columns:1fr}
}
@media(max-width:640px){
  .hero{padding:120px 0 56px}
  .hero-grid{padding:0 20px}
  section{padding:64px 20px}
  .facts-grid,.ideas-grid,.svc-grid{grid-template-columns:1fr}
  .price-strip-inner{padding:28px 22px}
  .cta-card{padding:48px 22px;border-radius:26px}
}
/* ── SHARED LOCATION SECTIONS (includes/location-sections.php) ── */
.loc-toc{background:#fff;border-bottom:1px solid var(--border);padding:14px 40px;position:relative;z-index:2}
.loc-toc .container{display:flex;flex-wrap:wrap;gap:8px 18px;align-items:center}
.loc-toc-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--muted);text-transform:uppercase;letter-spacing:.8px}
.loc-toc a{font-family:'Plus Jakarta Sans',sans-serif;font-size:13.5px;font-weight:600;color:var(--teal);text-decoration:none}
.loc-toc a:hover{text-decoration:underline}
.loc-qa{background:#fff;padding-top:48px;padding-bottom:16px}
.loc-qa-box{background:var(--warm);border:1px solid var(--border);border-left:5px solid var(--teal);border-radius:20px;padding:30px 32px}
.loc-qa-label{font-family:'Plus Jakarta Sans',sans-serif;font-size:12px;font-weight:700;color:var(--teal);text-transform:uppercase;letter-spacing:1px;margin-bottom:8px}
.loc-qa-q{font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(19px,2.2vw,24px);font-weight:800;color:var(--forest);margin-bottom:10px;line-height:1.3}
.loc-qa-a{font-size:16.5px;line-height:1.8;color:var(--text);margin-bottom:0}
.loc-stats{display:grid;grid-template-columns:repeat(auto-fit,minmax(180px,1fr));gap:14px;margin-top:22px}
.loc-stat{background:#fff;border:1px solid var(--border);border-radius:14px;padding:16px}
.loc-stat-num{font-family:'Plus Jakarta Sans',sans-serif;font-size:26px;font-weight:800;color:var(--teal);line-height:1.1}
.loc-stat-label{font-size:13.5px;color:var(--forest);font-weight:600;margin-top:4px;line-height:1.45}
.loc-stat-src{font-size:11.5px;color:var(--muted);margin-top:6px;font-style:italic}

/* PLAYBOOK (dark, two-column) */
.loc-playbook{background:var(--forest);position:relative;overflow:hidden}
.loc-playbook::before{content:'';position:absolute;inset:0;background-image:linear-gradient(rgba(29,158,117,.06) 1px,transparent 1px),linear-gradient(90deg,rgba(29,158,117,.06) 1px,transparent 1px);background-size:60px 60px;pointer-events:none}
.pb-grid{position:relative;display:grid;grid-template-columns:5fr 7fr;gap:64px;align-items:start}
.pb-intro{position:sticky;top:110px}
.pb-intro .section-label{color:var(--teal-lt)}
.pb-intro .section-label::before{background:var(--teal-lt)}
.pb-intro .section-h2{color:#fff}
.pb-intro .section-h2 em{color:var(--mint);font-style:italic}
.pb-lede{font-size:16.5px;line-height:1.75;color:rgba(255,255,255,.66);margin:14px 0 26px}
.pb-summary{list-style:none;display:flex;flex-direction:column;gap:10px;margin-bottom:28px}
.pb-summary li{display:flex;align-items:center;gap:12px;font-family:'Plus Jakarta Sans',sans-serif;font-size:14.5px;font-weight:600;color:rgba(255,255,255,.85)}
.pb-summary li span{width:28px;height:28px;border-radius:50%;border:1px solid rgba(46,198,143,.5);color:var(--mint);display:flex;align-items:center;justify-content:center;font-size:12px;font-weight:800;flex-shrink:0}
.pb-cta{display:inline-flex;align-items:center;gap:10px;background:var(--teal);color:#fff;border:none;cursor:pointer;font-family:'Plus Jakarta Sans',sans-serif;font-weight:700;font-size:14.5px;padding:15px 26px;border-radius:100px;transition:.2s}
.pb-cta:hover{background:var(--teal-lt);transform:translateY(-2px)}
.pb-steps{list-style:none;display:flex;flex-direction:column;gap:18px;position:relative}
.pb-steps::before{content:'';position:absolute;left:31px;top:36px;bottom:36px;width:2px;background:linear-gradient(var(--teal),rgba(29,158,117,.15))}
.pb-step{display:flex;gap:22px;align-items:flex-start;position:relative}
.pb-num{width:64px;height:64px;border-radius:18px;background:var(--teal);color:#fff;font-family:'Plus Jakarta Sans',sans-serif;font-size:20px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0;box-shadow:0 0 0 6px var(--forest);position:relative;z-index:1}
.pb-body{flex:1;background:#fff;border-radius:20px;padding:24px 26px;box-shadow:0 18px 50px rgba(0,0,0,.18)}
.pb-body h3{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--forest);margin-bottom:8px}
.pb-body p{font-size:15px;line-height:1.7;color:var(--muted)}
.pb-example{margin-top:14px;background:var(--warm);border-left:3px solid var(--teal);border-radius:10px;padding:12px 16px;font-size:14px;line-height:1.6;color:var(--forest)}
.pb-example span{display:block;font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:.8px;text-transform:uppercase;color:var(--teal);margin-bottom:4px}
.pb-list{list-style:none;display:grid;grid-template-columns:1fr 1fr;gap:8px 18px;margin-top:14px}
.pb-list li{display:flex;gap:8px;font-size:14px;color:var(--text);line-height:1.45}
.pb-list li i{color:var(--teal);font-size:13px;margin-top:2px}

/* GUIDES + AUTHOR */
.loc-trust{background:var(--cream)}
.loc-trust-grid{display:grid;grid-template-columns:7fr 4fr;gap:48px;align-items:start}
.loc-trust-h2{margin-bottom:24px}
.loc-guides{display:flex;flex-direction:column;gap:14px}
.loc-guide{display:flex;gap:18px;align-items:stretch;background:#fff;border:1px solid var(--border);border-radius:18px;overflow:hidden;text-decoration:none;transition:.25s}
.loc-guide:hover{border-color:var(--teal);box-shadow:0 14px 36px rgba(10,46,30,.1);transform:translateY(-2px)}
.loc-guide img{width:180px;min-height:120px;object-fit:cover;flex-shrink:0;display:block}
.loc-guide-body{display:flex;flex-direction:column;justify-content:center;gap:6px;padding:16px 20px 16px 0}
.loc-guide-tag{font-family:'Plus Jakarta Sans',sans-serif;font-size:11px;font-weight:700;letter-spacing:1px;text-transform:uppercase;color:var(--teal)}
.loc-guide-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:16.5px;font-weight:700;color:var(--forest);line-height:1.35}
.loc-guide-more{font-size:13.5px;font-weight:600;color:var(--muted)}
.loc-guide:hover .loc-guide-more{color:var(--teal)}
.loc-author-card{background:#fff;border:1px solid var(--border);border-radius:24px;padding:28px;box-shadow:0 20px 50px rgba(10,46,30,.08);position:sticky;top:110px}
.loc-author-top{display:flex;gap:16px;align-items:center;margin-bottom:16px}
.loc-author-top img{width:96px;height:96px;border-radius:50%;object-fit:cover;border:4px solid var(--warm);box-shadow:0 0 0 2px var(--teal);flex-shrink:0}
.loc-author-meta{font-size:11px;font-weight:700;color:var(--teal);text-transform:uppercase;letter-spacing:1px}
.loc-author-name{font-family:'Plus Jakarta Sans',sans-serif;font-size:21px;font-weight:800;margin:2px 0}
.loc-author-name a{color:var(--forest);text-decoration:none}
.loc-author-role{font-size:13.5px;color:var(--muted);font-weight:600}
.loc-author-bio{font-size:15px;line-height:1.7;color:var(--muted);margin-bottom:16px}
.loc-author-pills{display:flex;flex-wrap:wrap;gap:8px;margin-bottom:14px}
.loc-pill{display:inline-flex;align-items:center;gap:7px;background:var(--warm);border:1px solid var(--border);border-radius:100px;padding:7px 13px;font-size:12.5px;font-weight:600;color:var(--forest);text-decoration:none}
.loc-pill i{color:var(--teal)}
.loc-pill-link:hover{border-color:var(--teal)}
.loc-sources{border-top:1px solid var(--border);padding-top:12px;font-size:13px;color:var(--muted)}
.loc-sources summary{cursor:pointer;font-weight:700;color:var(--forest);display:flex;align-items:center;gap:8px;list-style:none}
.loc-sources summary::-webkit-details-marker{display:none}
.loc-sources summary::after{content:'+';margin-left:auto;font-size:16px;color:var(--teal)}
.loc-sources[open] summary::after{content:'−'}
.loc-sources summary i{color:var(--teal)}
.loc-sources ul{margin:10px 0 0 16px;display:flex;flex-direction:column;gap:6px;line-height:1.5}
.loc-sources a{color:var(--teal)}

/* WHERE WE WORK (tile map) */
.loc-coverage{background:#fff}
.cov-grid{display:grid;grid-template-columns:5fr 7fr;gap:56px;align-items:center}
.cov-text .section-h2 em{color:var(--teal);font-style:italic}
.cov-links{display:grid;grid-template-columns:1fr 1fr;gap:10px;margin-top:22px}
.cov-link{display:flex;align-items:center;gap:10px;background:var(--warm);border:1px solid var(--border);border-radius:12px;padding:10px 14px;text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:600;color:var(--forest);transition:.2s}
.cov-link i{margin-left:auto;font-size:11px;color:var(--muted);transition:.2s}
.cov-link:hover{border-color:var(--teal)}
.cov-link:hover i{color:var(--teal);transform:translateX(3px)}
.cov-abbr{width:30px;height:24px;border-radius:6px;background:rgba(29,158,117,.12);color:var(--teal);font-size:11px;font-weight:800;display:flex;align-items:center;justify-content:center;flex-shrink:0}
.cov-link.is-current{background:var(--forest);border-color:var(--forest);color:#fff}
.cov-link.is-current .cov-abbr{background:var(--teal);color:#fff}
.cov-link.is-current i{color:var(--mint)}
.cov-map-wrap{background:var(--warm);border:1px solid var(--border);border-radius:24px;padding:28px}
.cov-map{display:grid;grid-template-columns:repeat(12,1fr);grid-template-rows:repeat(8,auto);gap:5px}
.cov-tile{aspect-ratio:1;border-radius:8px;background:#e6ebe7;color:#a3b1a7;font-family:'Plus Jakarta Sans',sans-serif;font-size:clamp(8px,.85vw,12px);font-weight:700;display:flex;align-items:center;justify-content:center;text-decoration:none}
a.cov-tile.is-served{background:var(--teal);color:#fff;transition:.2s}
a.cov-tile.is-served:hover{background:var(--teal-lt);transform:scale(1.08)}
a.cov-tile.is-current{background:var(--forest);color:#fff;box-shadow:0 0 0 3px var(--gold)}
.cov-legend{display:flex;flex-wrap:wrap;gap:18px;margin-top:18px;font-size:13px;color:var(--muted);font-weight:600}
.cov-legend span{display:flex;align-items:center;gap:7px}
.cov-key{width:14px;height:14px;border-radius:4px;background:#e6ebe7;display:inline-block}
.cov-key.is-served{background:var(--teal)}
.cov-key.is-current{background:var(--forest);box-shadow:0 0 0 2px var(--gold)}
.cov-cities{margin-top:44px}
.cov-cities-title{font-family:'Plus Jakarta Sans',sans-serif;font-size:18px;font-weight:800;color:var(--forest);margin-bottom:14px}
.cov-city-grid{display:grid;grid-template-columns:repeat(5,1fr);gap:10px}
.cov-city{display:flex;align-items:center;gap:9px;background:var(--warm);border:1px solid var(--border);border-radius:12px;padding:12px 14px;text-decoration:none;font-family:'Plus Jakarta Sans',sans-serif;font-size:14px;font-weight:600;color:var(--forest)}
.cov-city i{color:var(--teal)}
.cov-city:hover{border-color:var(--teal)}
.cov-city.is-current{background:var(--forest);color:#fff;border-color:var(--forest)}
.cov-city.is-current i{color:var(--mint)}

@media(max-width:1024px){
  .pb-grid,.loc-trust-grid,.cov-grid{grid-template-columns:1fr;gap:36px}
  .pb-intro,.loc-author-card{position:static}
  .cov-city-grid{grid-template-columns:repeat(3,1fr)}
}
@media(max-width:640px){
  .loc-toc{padding:12px 20px}
  .loc-toc .container{flex-wrap:nowrap;overflow-x:auto;white-space:nowrap;scrollbar-width:none}
  .loc-toc .container::-webkit-scrollbar{display:none}
  .loc-qa-box{padding:22px 20px}
  .pb-steps::before{left:21px}
  .pb-step{gap:14px}
  .pb-num{width:44px;height:44px;border-radius:12px;font-size:15px;box-shadow:0 0 0 4px var(--forest)}
  .pb-body{padding:20px}
  .pb-list,.cov-links{grid-template-columns:1fr}
  .loc-guide{flex-direction:column}
  .loc-guide img{width:100%;height:150px}
  .loc-guide-body{padding:0 18px 18px}
  .cov-map-wrap{padding:16px}
  .cov-map{gap:3px}
  .cov-tile{border-radius:5px}
  .cov-city-grid{grid-template-columns:1fr 1fr}
}

CSS;
