<?php
// Compact inline case-study block, expanded from the [case_studies] shortcode
// in blog post content (see blog/post.php). Shows a couple of real case
// studies side by side inside the article — not the full homepage/SEO-page
// slider, which is too heavy to drop mid-article.
$csi_all  = require __DIR__ . '/case-studies-data.php';
$csi_n    = max(1, min(count($csi_all), isset($csi_count) ? (int)$csi_count : 2));
$csi_show = array_slice($csi_all, 0, $csi_n);
?>
<div class="csi-block">
  <div class="csi-label">Real Results</div>
  <div class="csi-grid" style="--csi-cols:<?= $csi_n ?>">
    <?php foreach ($csi_show as $c): ?>
    <div class="csi-card">
      <img src="/images/case-studies/<?= htmlspecialchars($c['img']) ?>" alt="<?= htmlspecialchars($c['name'] . ' lead generation dashboard showing ' . $c['stats'][0][0] . ' ' . $c['stats'][0][1]) ?>" loading="lazy">
      <div class="csi-card-body">
        <div class="csi-card-badge">Case Study <?= htmlspecialchars($c['num']) ?></div>
        <h4 class="csi-card-title"><?= htmlspecialchars($c['name']) ?><?= $c['region'] ? ' <span>| ' . htmlspecialchars($c['region']) . '</span>' : '' ?></h4>
        <div class="csi-stats-row">
          <?php foreach (array_slice($c['stats'], 0, 2) as $s): ?>
          <div class="csi-stat"><div class="csi-stat-num"><?= htmlspecialchars($s[0]) ?></div><div class="csi-stat-label"><?= htmlspecialchars($s[1]) ?></div></div>
          <?php endforeach; ?>
        </div>
      </div>
    </div>
    <?php endforeach; ?>
  </div>
  <div class="csi-cta"><a href="/case-studies/">View All Case Studies <i class="fa-solid fa-arrow-right"></i></a></div>
</div>
