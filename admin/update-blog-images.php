<?php
require_once dirname(__DIR__) . '/admin/config.php';
require_once dirname(__DIR__) . '/admin/includes/auth.php';
require_once dirname(__DIR__) . '/admin/includes/db.php';
hc_require_auth();

if (($_GET['run'] ?? '') !== '1') {
    echo '<p>Add <strong>?run=1</strong> to the URL to update blog featured images.</p>';
    exit;
}

$updates = [
    'why-home-care-agency-not-showing-up-google' => '/images/blog/blog-seo-google.jpg',
    'private-pay-home-care-clients-florida'       => '/images/blog/blog-private-pay.jpg',
    'home-care-website-design-must-haves'         => '/images/blog/blog-website-design.jpg',
    'local-seo-home-care-agency-google-maps'      => '/images/blog/blog-local-seo.jpg',
    'home-care-agency-marketing-mistakes'         => '/images/blog/blog-marketing.jpg',
];

$done = 0;
foreach ($updates as $slug => $img) {
    hc_q("UPDATE hc_blog_posts SET featured_image=? WHERE slug=?", [$img, $slug]);
    $done++;
}
?>
<!DOCTYPE html>
<html><head><style>body{font-family:sans-serif;max-width:640px;margin:60px auto;padding:0 20px}</style></head><body>
<h2>Blog Images Updated</h2>
<p>Updated featured image for <strong><?= $done ?></strong> posts.</p>
<p><a href="/blog">View Blog →</a></p>
<p style="color:#888;margin-top:24px">Delete this file after confirming images show correctly.</p>
</body></html>
