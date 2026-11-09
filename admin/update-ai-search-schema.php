<?php
// ================================================================
//  One-time update: AI Search SEO page schema (prices + FAQ)
//  Visit /admin/update-ai-search-schema.php?run=1 while logged in.
//  Replaces ONLY the Service and FAQPage rows for /ai-search-seo/ in
//  hc_page_schema with data from includes/ai-search-seo-data.php
//  (the same file the page uses). Nothing else is touched.
//  Delete this file after running.
// ================================================================
require_once __DIR__ . '/config.php';
require_once __DIR__ . '/includes/auth.php';
require_once __DIR__ . '/includes/db.php';
hc_require_auth();

const AI_SITE = 'https://homecarecreators.com';
const AI_PATH = '/ai-search-seo/';

$ai  = require dirname(__DIR__) . '/includes/ai-search-seo-data.php';
$run = isset($_GET['run']);
$log = [];

if ($run) {
    $area = array_map(fn($s) => ['@type'=>'State','name'=>$s],
        ['Florida','Texas','California','New York','Georgia','North Carolina','Arizona','Pennsylvania','Ohio','Virginia']);
    $area[] = ['@type'=>'Country','name'=>'United States'];

    $offers = [];
    foreach ($ai['plans'] as $pl) {
        $offers[] = ['@type'=>'Offer','name'=>$pl['name'],'price'=>$pl['price'],'priceCurrency'=>'USD','availability'=>'https://schema.org/InStock',
            'priceSpecification'=>['@type'=>'UnitPriceSpecification','price'=>$pl['price'],'priceCurrency'=>'USD','unitText'=>'MONTH']];
    }
    $offers[] = ['@type'=>'Offer','name'=>$ai['setup']['name'].' (one-time)','price'=>$ai['setup']['price'],'priceCurrency'=>'USD','availability'=>'https://schema.org/InStock'];
    $offers[] = ['@type'=>'Offer','name'=>$ai['addon']['name'],'price'=>$ai['addon']['price'],'priceCurrency'=>'USD','availability'=>'https://schema.org/InStock',
        'priceSpecification'=>['@type'=>'UnitPriceSpecification','price'=>$ai['addon']['price'],'priceCurrency'=>'USD','unitText'=>'MONTH']];

    $service = [
        'name'        => 'AI Search SEO for Home Care Agencies',
        'description' => 'AI Search SEO (GEO/AEO) for home care agencies nationwide: tracked family questions across ChatGPT, Google AI Overviews and Perplexity, structured data, entity building and answer-formatted content. Plans from $797/month.',
        'provider'    => ['@type'=>'Organization','name'=>'Homecare Creators','url'=>AI_SITE],
        'serviceType' => 'Generative Engine Optimization (GEO) / Answer Engine Optimization (AEO)',
        'areaServed'  => $area,
        'url'         => AI_SITE . AI_PATH,
        'audience'    => ['@type'=>'Audience','audienceType'=>'Home Care Agency Owners'],
        'offers'      => $offers,
    ];
    $faq = ['mainEntity' => array_map(fn($q) => [
        '@type'=>'Question','name'=>$q[0],'acceptedAnswer'=>['@type'=>'Answer','text'=>$q[1]]
    ], $ai['faqs'])];

    foreach (['Service' => $service, 'FAQPage' => $faq] as $type => $data) {
        $n = (int) hc_val("SELECT COUNT(*) FROM hc_page_schema WHERE page_path = ? AND schema_type = ?", [AI_PATH, $type]);
        hc_q("DELETE FROM hc_page_schema WHERE page_path = ? AND schema_type = ?", [AI_PATH, $type]);
        hc_q("INSERT INTO hc_page_schema (page_path,schema_type,schema_data,active) VALUES (?,?,?,1)",
            [AI_PATH, $type, json_encode($data, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES)]);
        $log[] = "✓ {$type}: replaced {$n} old row(s) with 1 new row";
    }
}
?><!doctype html><html lang="en"><head><meta charset="UTF-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title>Update AI Search SEO Schema</title>
<style>
body{font-family:system-ui,sans-serif;background:#f5f2ec;padding:40px 20px;color:#1a1a14}
.card{max-width:640px;margin:0 auto;background:#fff;border-radius:14px;padding:32px;border:1px solid #ddd}
h1{font-size:22px;margin-bottom:12px;color:#0a2e1e}
.btn{display:inline-block;background:#1d9e75;color:#fff;padding:12px 22px;border-radius:9px;text-decoration:none;font-weight:600;margin-top:14px}
.log{background:#f5f2ec;border-radius:9px;padding:14px 16px;margin:16px 0;font-family:monospace;font-size:13px;line-height:1.7}
.warn{background:#fff6e0;border:1px solid #e8c96a;border-radius:9px;padding:12px 16px;font-size:14px}
</style></head><body><div class="card">
<h1>Update AI Search SEO Schema</h1>
<?php if (!$run): ?>
<p>This replaces the <strong>Service</strong> and <strong>FAQPage</strong> schema for <code>/ai-search-seo/</code> with the new prices ($797 / $1,297 / $1,997 per month, $997 setup, $497 add-on) and the current FAQ text. No other page is touched.</p>
<a href="?run=1" class="btn">&#9654; Run Update</a>
<?php else: ?>
<div class="log"><?php foreach ($log as $l): ?><div><?= htmlspecialchars($l) ?></div><?php endforeach ?></div>
<div class="warn">Done. Delete <code>admin/update-ai-search-schema.php</code> from the server now.</div>
<a href="/admin/schema/" class="btn">View Schema Manager &#8594;</a>
<?php endif ?>
</div></body></html>
