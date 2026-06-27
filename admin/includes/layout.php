<?php
function hc_head(string $title): void { ?>
<!doctype html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width,initial-scale=1">
<title><?= htmlspecialchars($title) ?> — HC Admin</title>
<meta name="robots" content="noindex,nofollow">
<link rel="stylesheet" href="/admin/assets/admin.css">
</head>
<body>
<div class="admin-wrap">
<?php require __DIR__ . '/nav.php'; ?>
<div class="main">
<?php } ?>

<?php
function hc_topbar(string $title, string $breadcrumb = ''): void { ?>
<div class="topbar">
  <div class="topbar-left">
    <h2><?= htmlspecialchars($title) ?></h2>
    <?php if ($breadcrumb): ?><div class="breadcrumb"><?= $breadcrumb ?></div><?php endif ?>
  </div>
  <div style="font-size:12px;color:#9ca3af">
    <?= htmlspecialchars($_SESSION['hc_user'] ?? 'admin') ?> &middot; <a href="/admin/logout.php">Logout</a>
  </div>
</div>
<?php } ?>

<?php
function hc_foot(): void { ?>
<script src="/admin/assets/admin.js"></script>
</div></div>
</body>
</html>
<?php } ?>
