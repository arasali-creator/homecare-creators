<?php
require_once dirname(__DIR__) . '/admin/config.php';
require_once dirname(__DIR__) . '/admin/includes/auth.php';
require_once dirname(__DIR__) . '/admin/includes/db.php';
hc_require_auth();

if (($_GET['run'] ?? '') !== '1') {
    echo '<p>Add <strong>?run=1</strong> to the URL to inject inline images into blog posts.</p>';
    exit;
}

// Inline image HTML block
function img_block(string $src, string $alt, string $caption = ''): string {
    return '<figure style="margin:36px 0;text-align:center">'
        . '<img src="' . htmlspecialchars($src) . '" alt="' . htmlspecialchars($alt) . '" title="' . htmlspecialchars($alt) . '" '
        . 'style="width:100%;max-width:820px;border-radius:12px;border:1px solid #e5e7eb;display:inline-block" loading="lazy">'
        . ($caption ? '<figcaption style="margin-top:10px;font-size:13px;color:#9ca3af;font-style:italic">' . htmlspecialchars($caption) . '</figcaption>' : '')
        . '</figure>';
}

// Inject an image block after the Nth occurrence of </h2> in HTML
function inject_after_h2(string $html, int $n, string $img_html): string {
    $pos = 0;
    for ($i = 0; $i < $n; $i++) {
        $found = strpos($html, '</h2>', $pos);
        if ($found === false) return $html;
        $pos = $found + 5;
    }
    return substr($html, 0, $pos) . "\n" . $img_html . "\n" . substr($html, $pos);
}

$updates = [
    'why-home-care-agency-not-showing-up-google' => [
        [1, '/images/blog/blog-seo-google.jpg',     'A home care agency caregiver connecting with a client — trust starts with visibility.',          'after 1st h2'],
        [3, '/images/blog/inline-seo-laptop.jpg',   'Tracking your Google Business Profile performance is the first step to local dominance.',        'after 3rd h2'],
    ],
    'private-pay-home-care-clients-florida' => [
        [1, '/images/blog/blog-private-pay.jpg',    'Private-pay families begin their search online — often in moments of crisis and high emotion.',   'after 1st h2'],
        [3, '/images/blog/inline-family-care.jpg',  'A website that communicates trust converts the family before they ever pick up the phone.',       'after 3rd h2'],
    ],
    'home-care-website-design-must-haves' => [
        [2, '/images/blog/blog-website-design.jpg', 'Modern, fast websites built for home care agencies convert families at 3–4× the industry average.', 'after 2nd h2'],
        [5, '/images/blog/inline-laptop-website.jpg','Mobile-first design is no longer optional — it is the standard families judge you by.',           'after 5th h2'],
    ],
    'local-seo-home-care-agency-google-maps' => [
        [1, '/images/blog/blog-local-seo.jpg',      'Ranking in the Google Maps Pack puts your agency in front of families at the exact moment of need.', 'after 1st h2'],
        [3, '/images/blog/inline-google-maps.jpg',  'Local citations on healthcare directories build the trust signals Google uses to rank your listing.', 'after 3rd h2'],
    ],
    'home-care-agency-marketing-mistakes' => [
        [2, '/images/blog/blog-marketing.jpg',      'The agencies winning private-pay clients in Florida share one thing: a digital foundation built before they needed it.', 'after 2nd h2'],
        [4, '/images/blog/inline-analytics.jpg',    'Measuring cost-per-lead and conversion rates is what separates scaling agencies from stagnant ones.', 'after 4th h2'],
    ],
];

$done = 0;
foreach ($updates as $slug => $images) {
    $post = hc_one("SELECT id, content FROM hc_blog_posts WHERE slug=?", [$slug]);
    if (!$post) continue;

    $content = $post['content'];
    // Sort images by h2 position descending so earlier injections don't shift later offsets
    // We inject from last to first so positions stay valid
    $sorted = $images;
    usort($sorted, fn($a, $b) => $b[0] - $a[0]);

    foreach ($sorted as [$h2_num, $src, $alt]) {
        $img = img_block($src, $alt);
        $content = inject_after_h2($content, $h2_num, $img);
    }

    hc_q("UPDATE hc_blog_posts SET content=? WHERE id=?", [$content, $post['id']]);
    $done++;
}
?>
<!DOCTYPE html>
<html><head><style>body{font-family:sans-serif;max-width:640px;margin:60px auto;padding:0 20px}</style></head><body>
<h2>Inline Images Injected</h2>
<p>Updated <strong><?= $done ?></strong> blog posts with inline images.</p>
<ul>
  <li><a href="/blog/post.php?slug=why-home-care-agency-not-showing-up-google" target="_blank">Blog 1 — SEO Visibility</a></li>
  <li><a href="/blog/post.php?slug=private-pay-home-care-clients-florida" target="_blank">Blog 2 — Private Pay</a></li>
  <li><a href="/blog/post.php?slug=home-care-website-design-must-haves" target="_blank">Blog 3 — Website Design</a></li>
  <li><a href="/blog/post.php?slug=local-seo-home-care-agency-google-maps" target="_blank">Blog 4 — Local SEO</a></li>
  <li><a href="/blog/post.php?slug=home-care-agency-marketing-mistakes" target="_blank">Blog 5 — Marketing</a></li>
</ul>
<p style="color:#888;margin-top:24px">Delete this file after confirming images appear correctly in each post.</p>
</body></html>
