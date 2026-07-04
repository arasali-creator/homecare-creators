<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

hc_q("CREATE TABLE IF NOT EXISTS hc_pages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    slug VARCHAR(255) NOT NULL UNIQUE,
    title VARCHAR(255) NOT NULL,
    status VARCHAR(20) NOT NULL DEFAULT 'draft',
    meta_title VARCHAR(255) DEFAULT '',
    meta_desc VARCHAR(500) DEFAULT '',
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
)");
hc_q("CREATE TABLE IF NOT EXISTS hc_page_blocks (
    id INT AUTO_INCREMENT PRIMARY KEY,
    page_id INT NOT NULL,
    block_type VARCHAR(50) NOT NULL,
    block_data LONGTEXT,
    sort_order INT NOT NULL DEFAULT 0,
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_page_order (page_id, sort_order)
)");

if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    try {
        hc_q("DELETE FROM hc_page_blocks WHERE page_id=?", [$id]);
        hc_q("DELETE FROM hc_pages WHERE id=?", [$id]);
        hc_flash('Page deleted.');
    } catch (Exception $e) {
        hc_flash('Could not delete page.', 'error');
    }
    header('Location: /admin/pages/'); exit;
}

if (isset($_GET['duplicate'])) {
    $id = (int)$_GET['duplicate'];
    $src = hc_one("SELECT * FROM hc_pages WHERE id=?", [$id]);
    if ($src) {
        try {
            $newSlug = $src['slug'] . '-copy-' . substr(uniqid(), -4);
            hc_q("INSERT INTO hc_pages (slug,title,status,meta_title,meta_desc) VALUES (?,?,?,?,?)",
                [$newSlug, $src['title'] . ' (Copy)', 'draft', $src['meta_title'], $src['meta_desc']]);
            $newId = (int)hc_db()->lastInsertId();
            $blocks = hc_all("SELECT * FROM hc_page_blocks WHERE page_id=? ORDER BY sort_order ASC", [$id]);
            foreach ($blocks as $b) {
                hc_q("INSERT INTO hc_page_blocks (page_id,block_type,block_data,sort_order) VALUES (?,?,?,?)",
                    [$newId, $b['block_type'], $b['block_data'], $b['sort_order']]);
            }
            hc_flash('Page duplicated.');
        } catch (Exception $e) {
            hc_flash('Could not duplicate page.', 'error');
        }
    }
    header('Location: /admin/pages/'); exit;
}

if (isset($_GET['toggle'])) {
    $id = (int)$_GET['toggle'];
    $p = hc_one("SELECT status FROM hc_pages WHERE id=?", [$id]);
    if ($p) {
        $new = $p['status'] === 'published' ? 'draft' : 'published';
        hc_q("UPDATE hc_pages SET status=? WHERE id=?", [$new, $id]);
        hc_flash($new === 'published' ? 'Page published.' : 'Page unpublished.');
    }
    header('Location: /admin/pages/'); exit;
}

$pages = hc_all("SELECT p.*, (SELECT COUNT(*) FROM hc_page_blocks b WHERE b.page_id=p.id) AS block_count
                  FROM hc_pages p ORDER BY p.updated_at DESC");

hc_head('Pages');
hc_topbar('Pages', '<a href="/admin/">Admin</a> › Pages');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>Pages</h1><div class="sub"><?= count($pages) ?> page<?= count($pages) !== 1 ? 's' : '' ?></div></div>
  <a href="/admin/pages/edit.php" class="btn btn-primary">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5"><line x1="12" y1="5" x2="12" y2="19"/><line x1="5" y1="12" x2="19" y2="12"/></svg>
    New Page
  </a>
</div>

<div class="card">
  <?php if ($pages): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Title</th><th>Blocks</th><th>Status</th><th>Updated</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($pages as $p): ?>
      <tr>
        <td>
          <strong><?= h($p['title']) ?></strong>
          <div style="font-size:11px;color:var(--muted);font-family:monospace;margin-top:2px">/<?= h($p['slug']) ?>/</div>
        </td>
        <td><?= (int)$p['block_count'] ?></td>
        <td>
          <a href="?toggle=<?= $p['id'] ?>" class="badge <?= $p['status'] === 'published' ? 'badge-green' : 'badge-gray' ?>" style="text-decoration:none" title="Click to toggle">
            <?= h($p['status']) ?>
          </a>
        </td>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= date('M j, Y', strtotime($p['updated_at'])) ?></td>
        <td class="td-actions">
          <a href="/admin/pages/edit.php?id=<?= $p['id'] ?>">Edit</a>
          <a href="/page.php?slug=<?= urlencode($p['slug']) ?>&preview=1" target="_blank">Preview</a>
          <a href="?duplicate=<?= $p['id'] ?>">Duplicate</a>
          <a href="?delete=<?= $p['id'] ?>" class="danger" data-confirm="Delete '<?= h($p['title']) ?>'? This cannot be undone.">Delete</a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><path d="M11 4H4a2 2 0 0 0-2 2v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2v-7"/><path d="M18.5 2.5a2.121 2.121 0 0 1 3 3L12 15l-4 1 1-4 9.5-9.5z"/></svg>
    <p>No pages yet.</p>
    <a href="/admin/pages/edit.php" class="btn btn-primary" style="margin-top:12px">Create your first page</a>
  </div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
