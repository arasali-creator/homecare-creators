<?php
require_once dirname(__DIR__) . '/admin/config.php';
require_once dirname(__DIR__) . '/admin/includes/auth.php';
require_once dirname(__DIR__) . '/admin/includes/db.php';
hc_require_auth();

if (($_GET['run'] ?? '') !== '1') {
    echo '<p>Add <strong>?run=1</strong> to the URL to switch the 3 newer blog posts from Unsplash to local images.</p>';
    exit;
}

// Maps the exact <img> tag as originally seeded (Unsplash src + alt) to a
// local-image version with the same alt text plus a matching title attribute.
$updates = [
    'google-reviews-home-care-agency' => [
        'featured' => '/images/blog/blog-google-reviews.jpg',
        'replace'  => [
            '<img src="https://images.unsplash.com/photo-1576091160399-112ba8d25d1d?w=1200&auto=format&fit=crop&q=80" alt="Caregiver sitting with an elderly woman at home, building trust and rapport" style="width:100%;border-radius:12px;margin-bottom:8px">'
                => '<img src="/images/blog/blog-google-reviews.jpg" alt="Caregiver sitting with an elderly woman at home, building trust and rapport" title="Caregiver building trust and rapport with a home care client" style="width:100%;border-radius:12px;margin-bottom:8px">',
            '<img src="https://images.unsplash.com/photo-1573497620053-ea5300f94f21?w=1200&auto=format&fit=crop&q=80" alt="Person on phone, leaving a Google review for a home care service" style="width:100%;border-radius:12px;margin:28px 0 8px">'
                => '<img src="/images/blog/inline-review-phone.jpg" alt="Person on phone, leaving a Google review for a home care service" title="Leaving a Google review for a home care agency" style="width:100%;border-radius:12px;margin:28px 0 8px">',
        ],
    ],
    'google-business-profile-checklist-home-care' => [
        'featured' => '/images/blog/blog-gbp-checklist.jpg',
        'replace'  => [
            '<img src="https://images.unsplash.com/photo-1611162616305-c69b3fa7fbe0?w=1200&auto=format&fit=crop&q=80" alt="Person using Google Maps on their smartphone to find a local home care agency" style="width:100%;border-radius:12px;margin-bottom:8px">'
                => '<img src="/images/blog/blog-gbp-checklist.jpg" alt="Person using Google Maps on their smartphone to find a local home care agency" title="Finding a local home care agency on Google Maps" style="width:100%;border-radius:12px;margin-bottom:8px">',
            '<img src="https://images.unsplash.com/photo-1454165804606-c3d57bc86b40?w=1200&auto=format&fit=crop&q=80" alt="Home care agency owner working through an optimization checklist on a laptop" style="width:100%;border-radius:12px;margin:28px 0 8px">'
                => '<img src="/images/blog/inline-optimization-checklist.jpg" alt="Home care agency owner working through an optimization checklist on a laptop" title="Home care agency Google Business Profile optimization checklist" style="width:100%;border-radius:12px;margin:28px 0 8px">',
        ],
    ],
    'home-care-agency-ai-search-chatgpt-optimization' => [
        'featured' => '/images/blog/blog-ai-search-optimization.jpg',
        'replace'  => [
            '<img src="https://images.unsplash.com/photo-1677442135703-1787eea5ce01?w=1200&auto=format&fit=crop&q=80" alt="Abstract representation of AI search and digital recommendations for home care" style="width:100%;border-radius:12px;margin-bottom:8px">'
                => '<img src="/images/blog/blog-ai-search-optimization.jpg" alt="Abstract representation of AI search and digital recommendations for home care" title="AI search optimization for home care agencies" style="width:100%;border-radius:12px;margin-bottom:8px">',
            '<img src="https://images.unsplash.com/photo-1499750310107-5fef28a66643?w=1200&auto=format&fit=crop&q=80" alt="Home care agency owner building their AI search presence through content strategy" style="width:100%;border-radius:12px;margin:28px 0 8px">'
                => '<img src="/images/blog/inline-ai-content-strategy.jpg" alt="Home care agency owner building their AI search presence through content strategy" title="Building AI search presence for a home care agency" style="width:100%;border-radius:12px;margin:28px 0 8px">',
        ],
    ],
];

$done = 0;
foreach ($updates as $slug => $u) {
    $post = hc_one("SELECT id, content FROM hc_blog_posts WHERE slug=?", [$slug]);
    if (!$post) continue;

    $content = strtr($post['content'], $u['replace']);

    hc_q(
        "UPDATE hc_blog_posts SET content=?, featured_image=?, og_image=? WHERE id=?",
        [$content, $u['featured'], $u['featured'], $post['id']]
    );
    $done++;
}
?>
<!DOCTYPE html>
<html><head><style>body{font-family:sans-serif;max-width:640px;margin:60px auto;padding:0 20px}</style></head><body>
<h2>Blog Images Switched to Local</h2>
<p>Updated <strong><?= $done ?></strong> posts (featured image, OG image, and inline content images).</p>
<ul>
  <li><a href="/blog/post.php?slug=google-reviews-home-care-agency" target="_blank">Blog — Google Reviews</a></li>
  <li><a href="/blog/post.php?slug=google-business-profile-checklist-home-care" target="_blank">Blog — GBP Checklist</a></li>
  <li><a href="/blog/post.php?slug=home-care-agency-ai-search-chatgpt-optimization" target="_blank">Blog — AI Search Optimization</a></li>
</ul>
<p style="color:#888;margin-top:24px">Delete this file after confirming images appear correctly in each post.</p>
</body></html>
