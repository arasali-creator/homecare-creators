<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

// Ensure table exists
try {
    hc_db()->exec("CREATE TABLE IF NOT EXISTS hc_tracking_codes (
        id INT AUTO_INCREMENT PRIMARY KEY,
        name VARCHAR(100) NOT NULL,
        position ENUM('head','body') DEFAULT 'head',
        code TEXT NOT NULL,
        active TINYINT(1) DEFAULT 1,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4");
} catch(Exception $e){}


$action = $_POST['action'] ?? $_GET['action'] ?? '';
$id     = (int)($_POST['id'] ?? $_GET['id'] ?? 0);

// Toggle active/paused
if ($action === 'toggle' && $id) {
    hc_q("UPDATE hc_tracking_codes SET active = 1 - active WHERE id = ?", [$id]);
    hc_flash($id ? 'Tracking code status updated.' : 'Not found.', 'success');
    header('Location: /admin/technical/tracking.php'); exit;
}

// Delete
if ($action === 'delete' && $id) {
    hc_q("DELETE FROM hc_tracking_codes WHERE id = ?", [$id]);
    hc_flash('Tracking code deleted.', 'success');
    header('Location: /admin/technical/tracking.php'); exit;
}

// Save (add or edit)
if ($_SERVER['REQUEST_METHOD'] === 'POST' && in_array($action, ['add', 'edit'])) {
    $name     = trim($_POST['name'] ?? '');
    $position = in_array($_POST['position'] ?? '', ['head', 'body']) ? $_POST['position'] : 'head';
    $code     = trim($_POST['code'] ?? '');
    $active   = isset($_POST['active']) ? 1 : 0;

    if (!$name || !$code) {
        hc_flash('Name and Code are required.', 'error');
        header('Location: /admin/technical/tracking.php' . ($action === 'edit' && $id ? "?id=$id" : '')); exit;
    }

    if ($action === 'edit' && $id) {
        hc_q("UPDATE hc_tracking_codes SET name=?, position=?, code=?, active=? WHERE id=?",
            [$name, $position, $code, $active, $id]);
        hc_flash('Tracking code updated successfully.');
    } else {
        hc_q("INSERT INTO hc_tracking_codes (name, position, code, active) VALUES (?,?,?,1)",
            [$name, $position, $code]);
        hc_flash('Tracking code added and is now active.');
    }
    header('Location: /admin/technical/tracking.php'); exit;
}

$codes = hc_all("SELECT * FROM hc_tracking_codes ORDER BY position ASC, id ASC");
$edit  = ($id && !in_array($action, ['toggle', 'delete']))
       ? hc_one("SELECT * FROM hc_tracking_codes WHERE id=?", [$id])
       : null;

hc_head('Tracking Codes');
hc_topbar('Tracking Codes', '<a href="/admin/">Admin</a> › <a href="/admin/technical/sitemap.php">Technical SEO</a> › Tracking Codes');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<!-- Add / Edit form -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title"><?= $edit ? 'Edit Tracking Code' : 'Add Tracking Code' ?></div>
      <div class="card-sub"><?= $edit ? 'Update the snippet details below, then save.' : 'Add Google Tag Manager, GA4, Meta Pixel, or any custom script.' ?></div>
    </div>
    <?php if ($edit): ?>
    <a href="/admin/technical/tracking.php" class="btn btn-secondary btn-sm">Cancel</a>
    <?php endif ?>
  </div>

  <form method="POST">
    <input type="hidden" name="action" value="<?= $edit ? 'edit' : 'add' ?>">
    <?php if ($edit): ?><input type="hidden" name="id" value="<?= (int)$edit['id'] ?>"><?php endif ?>

    <div class="form-grid">
      <div class="form-group">
        <label for="tc_name">Label <span>(required)</span></label>
        <input type="text" id="tc_name" name="name" required
               placeholder="e.g. Google Tag Manager"
               value="<?= h($edit['name'] ?? '') ?>">
        <div class="form-hint">A name to identify this code in the list.</div>
      </div>
      <div class="form-group">
        <label for="tc_pos">Injection Position</label>
        <select id="tc_pos" name="position">
          <option value="head" <?= ($edit['position'] ?? 'head') === 'head' ? 'selected' : '' ?>>
            &lt;head&gt; — loads early (GTM script, GA4, etc.)
          </option>
          <option value="body" <?= ($edit['position'] ?? '') === 'body' ? 'selected' : '' ?>>
            After &lt;body&gt; — noscript fallbacks (GTM noscript iframe)
          </option>
        </select>
        <div class="form-hint">GTM needs two codes: one in &lt;head&gt;, one after &lt;body&gt;.</div>
      </div>
    </div>

    <div class="form-group">
      <label for="tc_code">Tracking Code <span>(required)</span></label>
      <textarea id="tc_code" name="code" required rows="9"
                style="font-family:'SF Mono',Consolas,monospace;font-size:12.5px;resize:vertical"
                placeholder="Paste the full snippet here including &lt;script&gt; or &lt;noscript&gt; tags..."><?= h($edit['code'] ?? '') ?></textarea>
      <div class="form-hint">Paste exactly as provided by Google, Meta, or your analytics platform.</div>
    </div>

    <?php if ($edit): ?>
    <div class="form-group" style="display:flex;align-items:center;gap:10px;margin-bottom:6px">
      <label class="toggle" style="margin-bottom:0">
        <input type="checkbox" name="active" <?= $edit['active'] ? 'checked' : '' ?>>
        <span class="toggle-slider"></span>
      </label>
      <span class="toggle-label">Active — inject this code on every page</span>
    </div>
    <?php endif ?>

    <div style="display:flex;gap:10px;margin-top:10px">
      <button type="submit" class="btn btn-primary">
        <?= $edit ? 'Save Changes' : 'Add Tracking Code' ?>
      </button>
    </div>
  </form>
</div>

<!-- Existing codes list -->
<div class="card">
  <div class="card-header">
    <div>
      <div class="card-title">Configured Tracking Codes</div>
      <div class="card-sub"><?= count($codes) ?> code<?= count($codes) !== 1 ? 's' : '' ?> installed</div>
    </div>
  </div>

  <?php if (empty($codes)): ?>
  <div class="empty-state">
    <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5"><polyline points="16 18 22 12 16 6"/><polyline points="8 6 2 12 8 18"/></svg>
    <p>No tracking codes yet. Use the form above to add one.</p>
  </div>
  <?php else: ?>
  <div class="table-wrap">
    <table>
      <thead>
        <tr>
          <th>Name</th>
          <th>Position</th>
          <th>Status</th>
          <th>Added</th>
          <th class="td-actions">Actions</th>
        </tr>
      </thead>
      <tbody>
      <?php foreach ($codes as $tc): ?>
      <tr>
        <td>
          <strong><?= h($tc['name']) ?></strong>
          <div style="font-family:'SF Mono',Consolas,monospace;font-size:11px;color:var(--muted);margin-top:3px;max-width:420px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis">
            <?= h(substr(preg_replace('/\s+/', ' ', $tc['code']), 0, 90)) ?>…
          </div>
        </td>
        <td>
          <span class="badge <?= $tc['position'] === 'head' ? 'badge-blue' : 'badge-gray' ?>">
            &lt;<?= h($tc['position']) ?>&gt;
          </span>
        </td>
        <td>
          <span class="badge <?= $tc['active'] ? 'badge-green' : 'badge-gray' ?>">
            <?= $tc['active'] ? 'Active' : 'Paused' ?>
          </span>
        </td>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap">
          <?= date('M j, Y', strtotime($tc['created_at'])) ?>
        </td>
        <td class="td-actions">
          <a href="?action=toggle&id=<?= $tc['id'] ?>"
             onclick="return confirm('<?= $tc['active'] ? 'Pause' : 'Re-activate' ?> this tracking code?')"
             style="color:<?= $tc['active'] ? 'var(--muted)' : 'var(--teal)' ?>">
            <?= $tc['active'] ? 'Pause' : 'Activate' ?>
          </a>
          <a href="?id=<?= $tc['id'] ?>">Edit</a>
          <a href="?action=delete&id=<?= $tc['id'] ?>" class="danger"
             onclick="return confirm('Permanently delete this tracking code? This cannot be undone.')">
            Delete
          </a>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php endif ?>
</div>

<!-- Help box -->
<div class="card" style="background:#f8fbff;border-color:rgba(59,130,246,.2)">
  <div class="card-title" style="margin-bottom:12px">
    <span style="color:#1d4ed8">Google Tag Manager — Quick Reference</span>
  </div>
  <div style="font-size:13px;line-height:2;color:var(--muted)">
    GTM requires <strong style="color:var(--text)">two separate snippets</strong>. Add each as its own entry:<br>
    <strong style="color:var(--text)">1. Head script</strong> → Position: <code style="background:#eef;padding:1px 5px;border-radius:3px">&lt;head&gt;</code>
    — paste the full <code>&lt;script&gt;…&lt;/script&gt;</code> block.<br>
    <strong style="color:var(--text)">2. Body noscript</strong> → Position: <code style="background:#eef;padding:1px 5px;border-radius:3px">After &lt;body&gt;</code>
    — paste the <code>&lt;noscript&gt;…&lt;/noscript&gt;</code> iframe block.<br><br>
    Both snippets are automatically injected on every page when set to <strong style="color:#0d7a57">Active</strong>.
    Set to <strong style="color:var(--muted)">Paused</strong> to temporarily disable without deleting.
  </div>
</div>

</div>
<?php hc_foot(); ?>
