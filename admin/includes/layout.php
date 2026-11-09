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
  <div class="topbar-left-wrap">
    <button class="topbar-menu" onclick="hcSidebar(true)" aria-label="Open menu"><svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.2"><line x1="3" y1="6" x2="21" y2="6"/><line x1="3" y1="12" x2="21" y2="12"/><line x1="3" y1="18" x2="21" y2="18"/></svg></button>
    <div class="topbar-left">
      <h2><?= htmlspecialchars($title) ?></h2>
      <?php if ($breadcrumb): ?><div class="breadcrumb"><?= $breadcrumb ?></div><?php endif ?>
    </div>
  </div>
  <div class="topbar-user">
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
