<?php
// ============================================================
//  Page Builder — Admin Edit-Form Renderer
//  Generates the editing UI for one block instance, driven by
//  that block type's field schema in hc_block_registry().
//  Companion to blocks.php (which renders the PUBLIC output).
// ============================================================

function hc_render_field(string $fieldKey, array $field, mixed $value): string {
    $label = h($field['label'] ?? $fieldKey);
    $type  = $field['type'] ?? 'text';

    if ($type === 'repeater') {
        return hc_render_repeater_field($fieldKey, $field, is_array($value) ? $value : []);
    }

    $val = h(is_scalar($value) ? (string)$value : '');
    $out = '<div class="pb-field"><label>' . $label . '</label>';

    switch ($type) {
        case 'textarea':
            $out .= '<textarea data-field="' . h($fieldKey) . '" rows="3">' . $val . '</textarea>';
            break;
        case 'select':
            $out .= '<select data-field="' . h($fieldKey) . '">';
            foreach (($field['options'] ?? []) as $optVal => $optLabel) {
                $sel = ((string)$value === (string)$optVal) ? ' selected' : '';
                $out .= '<option value="' . h($optVal) . '"' . $sel . '>' . h($optLabel) . '</option>';
            }
            $out .= '</select>';
            break;
        case 'image':
            $out .= '<div class="pb-image-field">'
                . '<img src="' . $val . '" class="pb-image-preview" style="' . ($val === '' ? 'display:none' : '') . '">'
                . '<input type="text" data-field="' . h($fieldKey) . '" value="' . $val . '" placeholder="No image selected" readonly>'
                . '<button type="button" class="btn btn-secondary btn-sm" onclick="pbOpenMedia(this)">Choose Image</button>'
                . '</div>';
            break;
        case 'url':
            $out .= '<input type="text" data-field="' . h($fieldKey) . '" value="' . $val . '" placeholder="https:// or #section-id">';
            break;
        default: // text
            $out .= '<input type="text" data-field="' . h($fieldKey) . '" value="' . $val . '">';
    }
    $out .= '</div>';
    return $out;
}

function hc_render_repeater_field(string $fieldKey, array $field, array $items): string {
    $subFields = $field['fields'] ?? [];
    $label = h($field['label'] ?? $fieldKey);

    $rows = '';
    foreach ($items as $item) {
        $rows .= hc_render_repeater_row($subFields, $item);
    }

    // Hidden template (blank row) the JS clones when "+ Add Item" is clicked.
    $template = htmlspecialchars(hc_render_repeater_row($subFields, []), ENT_QUOTES, 'UTF-8');

    return '<div class="pb-field pb-repeater" data-field="' . h($fieldKey) . '" data-template="' . $template . '">'
        . '<label>' . $label . '</label>'
        . '<div class="pb-repeater-items">' . $rows . '</div>'
        . '<button type="button" class="btn btn-secondary btn-sm" onclick="pbAddRepeaterItem(this)">+ Add Item</button>'
        . '</div>';
}

function hc_render_repeater_row(array $subFields, array $item): string {
    $inner = '';
    foreach ($subFields as $subKey => $subField) {
        $val = h((string)($item[$subKey] ?? ''));
        $subLabel = h($subField['label'] ?? $subKey);
        $subType = $subField['type'] ?? 'text';
        if ($subType === 'textarea') {
            $inner .= '<div class="pb-subfield"><label>' . $subLabel . '</label><textarea data-subfield="' . h($subKey) . '" rows="2">' . $val . '</textarea></div>';
        } else {
            $inner .= '<div class="pb-subfield"><label>' . $subLabel . '</label><input type="text" data-subfield="' . h($subKey) . '" value="' . $val . '"></div>';
        }
    }
    return '<div class="pb-repeater-item">' . $inner . '<button type="button" class="pb-repeater-remove" onclick="pbRemoveRepeaterItem(this)" title="Remove"><i class="fa-solid fa-xmark"></i></button></div>';
}

/** Renders the full edit form body for one block instance. */
function hc_render_block_form(int $blockId, string $type, array $data): string {
    $registry = hc_block_registry();
    $fields = $registry[$type]['fields'] ?? [];
    $out = '';
    foreach ($fields as $fieldKey => $field) {
        $out .= hc_render_field($fieldKey, $field, $data[$fieldKey] ?? null);
    }
    return $out;
}
