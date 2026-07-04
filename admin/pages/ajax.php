<?php
require_once dirname(dirname(__DIR__)) . '/admin/config.php';
require_once dirname(__DIR__) . '/includes/auth.php';
require_once dirname(__DIR__) . '/includes/db.php';
require_once dirname(__DIR__) . '/includes/functions.php';
require_once dirname(__DIR__) . '/includes/blocks.php';
require_once dirname(__DIR__) . '/includes/block-forms.php';
hc_require_auth();

header('Content-Type: application/json');

$action = $_POST['action'] ?? '';

try {
    switch ($action) {

        case 'add_block': {
            $pageId = (int)($_POST['page_id'] ?? 0);
            $type   = (string)($_POST['type'] ?? '');
            $registry = hc_block_registry();
            if (!$pageId || !isset($registry[$type])) {
                echo json_encode(['success' => false, 'error' => 'Invalid page or block type']);
                exit;
            }
            $maxOrder = (int)hc_val("SELECT COALESCE(MAX(sort_order),-1) FROM hc_page_blocks WHERE page_id=?", [$pageId]);
            $defaults = hc_block_defaults($type);
            hc_q("INSERT INTO hc_page_blocks (page_id,block_type,block_data,sort_order) VALUES (?,?,?,?)",
                [$pageId, $type, json_encode($defaults), $maxOrder + 1]);
            $blockId = (int)hc_db()->lastInsertId();
            echo json_encode([
                'success'  => true,
                'block_id' => $blockId,
                'label'    => $registry[$type]['label'],
                'icon'     => $registry[$type]['icon'],
                'form'     => hc_render_block_form($blockId, $type, $defaults),
            ]);
            break;
        }

        case 'delete_block': {
            $blockId = (int)($_POST['block_id'] ?? 0);
            hc_q("DELETE FROM hc_page_blocks WHERE id=?", [$blockId]);
            echo json_encode(['success' => true]);
            break;
        }

        case 'save_block': {
            $blockId = (int)($_POST['block_id'] ?? 0);
            $data    = $_POST['data'] ?? '{}';
            $decoded = json_decode($data, true);
            if (!is_array($decoded)) {
                echo json_encode(['success' => false, 'error' => 'Invalid data']);
                exit;
            }
            hc_q("UPDATE hc_page_blocks SET block_data=? WHERE id=?", [json_encode($decoded), $blockId]);
            $pageId = hc_val("SELECT page_id FROM hc_page_blocks WHERE id=?", [$blockId]);
            if ($pageId) hc_q("UPDATE hc_pages SET updated_at=NOW() WHERE id=?", [$pageId]);
            echo json_encode(['success' => true]);
            break;
        }

        case 'reorder': {
            $order = json_decode($_POST['order'] ?? '[]', true);
            if (!is_array($order)) {
                echo json_encode(['success' => false, 'error' => 'Invalid order']);
                exit;
            }
            foreach ($order as $i => $blockId) {
                hc_q("UPDATE hc_page_blocks SET sort_order=? WHERE id=?", [$i, (int)$blockId]);
            }
            echo json_encode(['success' => true]);
            break;
        }

        default:
            echo json_encode(['success' => false, 'error' => 'Unknown action']);
    }
} catch (Exception $e) {
    echo json_encode(['success' => false, 'error' => 'Server error']);
}
