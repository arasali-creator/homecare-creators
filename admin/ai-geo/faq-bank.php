<?php
require_once dirname(__DIR__) . '/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/layout.php';
hc_require_auth();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if ($action === 'save') {
        $id  = (int)($_POST['id'] ?? 0);
        $q   = trim($_POST['question'] ?? '');
        $a   = trim($_POST['answer'] ?? '');
        $pgs = trim($_POST['pages'] ?? '');
        if ($q && $a) {
            if ($id) {
                hc_q("UPDATE hc_faqs SET question=?,answer=?,pages=?,updated_at=NOW() WHERE id=?", [$q,$a,$pgs,$id]);
                hc_flash('FAQ updated.');
            } else {
                hc_q("INSERT INTO hc_faqs (question,answer,pages) VALUES (?,?,?)", [$q,$a,$pgs]);
                hc_flash('FAQ added.');
            }
        }
    }
    if ($action === 'delete') {
        hc_q("DELETE FROM hc_faqs WHERE id=?", [(int)($_POST['id']??0)]);
        hc_flash('FAQ deleted.');
    }
    header('Location: /admin/ai-geo/faq-bank.php');
    exit;
}

$edit  = isset($_GET['edit']) ? hc_one("SELECT * FROM hc_faqs WHERE id=?", [(int)$_GET['edit']]) : null;
$faqs  = hc_all("SELECT * FROM hc_faqs ORDER BY created_at DESC");

hc_head('FAQ Bank');
hc_topbar('FAQ Bank', '<a href="/admin/">Admin</a> › AI / GEO Panel › FAQ Bank');
?>
<div class="page-content">

<?= hc_show_flash() ?>

<div class="page-header">
  <div><h1>FAQ Bank</h1><div class="sub">Master Q&A repository. FAQs here power FAQ schema (which feeds Google AI Overviews, ChatGPT, and Perplexity citations).</div></div>
</div>

<div class="alert alert-info">
  <strong>GEO Impact:</strong> FAQ schema with well-written Q&As is one of the most reliable ways to appear in AI-generated search answers. Each FAQ you add here can be deployed to specific pages via the Schema manager.
</div>

<!-- Add / Edit Form -->
<div class="card">
  <div class="card-title" style="margin-bottom:14px"><?= $edit ? 'Edit FAQ' : 'Add New FAQ' ?></div>
  <form method="POST">
    <input type="hidden" name="action" value="save">
    <input type="hidden" name="id" value="<?= $edit['id'] ?? 0 ?>">
    <div class="form-group">
      <label>Question</label>
      <input type="text" name="question" value="<?= h($edit['question'] ?? '') ?>" placeholder="e.g. How much does homecare SEO cost?" required>
      <div class="form-hint">Write exactly how a person would type this into Google or ChatGPT.</div>
    </div>
    <div class="form-group">
      <label>Answer</label>
      <textarea name="answer" rows="4" required><?= h($edit['answer'] ?? '') ?></textarea>
      <div class="form-hint">Aim for 40–80 words. Conversational but authoritative. Start with the direct answer, then add context.</div>
    </div>
    <div class="form-group">
      <label>Deploy to pages <span>(comma-separated paths)</span></label>
      <input type="text" name="pages" value="<?= h($edit['pages'] ?? '') ?>" placeholder="/seo/local-seo-for-home-care-agencies, /seo/homecare-website-design">
      <div class="form-hint">Which pages this FAQ is deployed on (for your reference — schema is managed per-page in the Schema manager).</div>
    </div>
    <div style="display:flex;gap:10px">
      <button class="btn btn-primary" type="submit"><?= $edit ? 'Update FAQ' : 'Add FAQ' ?></button>
      <?php if ($edit): ?><a href="/admin/ai-geo/faq-bank.php" class="btn btn-secondary">Cancel</a><?php endif ?>
    </div>
  </form>
</div>

<!-- FAQ List -->
<div class="card">
  <div class="card-header">
    <div class="card-title">All FAQs (<?= count($faqs) ?>)</div>
  </div>
  <?php if ($faqs): ?>
  <div class="table-wrap">
    <table>
      <thead><tr><th>Question</th><th>Pages</th><th>Added</th><th></th></tr></thead>
      <tbody>
      <?php foreach ($faqs as $f): ?>
      <tr>
        <td>
          <div style="font-weight:600;margin-bottom:3px"><?= h($f['question']) ?></div>
          <div style="font-size:12px;color:var(--muted)"><?= h(substr($f['answer'],0,100)) ?>…</div>
        </td>
        <td style="font-size:12px;color:var(--muted)"><?= h($f['pages'] ?: '—') ?></td>
        <td style="font-size:12px;color:var(--muted);white-space:nowrap"><?= date('M j, Y', strtotime($f['created_at'])) ?></td>
        <td class="td-actions">
          <a href="?edit=<?= $f['id'] ?>">Edit</a>
          <form method="POST" style="display:inline">
            <input type="hidden" name="action" value="delete"><input type="hidden" name="id" value="<?= $f['id'] ?>">
            <button class="btn btn-ghost btn-sm danger" type="submit" data-confirm="Delete this FAQ?">Delete</button>
          </form>
        </td>
      </tr>
      <?php endforeach ?>
      </tbody>
    </table>
  </div>
  <?php else: ?>
  <div class="empty-state"><p>No FAQs yet. Add your first question above.</p></div>
  <?php endif ?>
</div>

</div>
<?php hc_foot(); ?>
