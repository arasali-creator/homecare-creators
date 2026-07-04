<?php
// ============================================================
//  Page Builder — Block Registry
//  Defines every block type: its editable fields (for the admin
//  editor form) and its render function (for the public page).
//  Add a new block type by adding one entry to hc_block_registry()
//  and one hc_render_block_xxx() function below.
// ============================================================

/**
 * Field types supported in the editor form builder:
 *   text     - single-line input
 *   textarea - multi-line input
 *   image    - image URL + "Choose Image" button (opens media picker)
 *   url      - link/href input
 *   select   - dropdown, needs 'options' => ['value'=>'Label', ...]
 *   repeater - list of sub-items, needs 'fields' => [ ...same shape... ]
 */
function hc_block_registry(): array {
    return [
        'hero' => [
            'label' => 'Hero Banner',
            'icon'  => 'fa-solid fa-flag',
            'fields' => [
                'eyebrow'     => ['type' => 'text', 'label' => 'Eyebrow Label'],
                'headline'    => ['type' => 'text', 'label' => 'Headline'],
                'subheadline' => ['type' => 'text', 'label' => 'Subheadline'],
                'description' => ['type' => 'textarea', 'label' => 'Description'],
                'btn1_text'   => ['type' => 'text', 'label' => 'Button 1 Text'],
                'btn1_link'   => ['type' => 'url', 'label' => 'Button 1 Link'],
                'btn2_text'   => ['type' => 'text', 'label' => 'Button 2 Text'],
                'btn2_link'   => ['type' => 'url', 'label' => 'Button 2 Link'],
            ],
            'defaults' => [
                'eyebrow' => 'Welcome', 'headline' => 'Your Headline Here',
                'subheadline' => '', 'description' => 'A short supporting description goes here.',
                'btn1_text' => 'Get Started', 'btn1_link' => '#contact',
                'btn2_text' => '', 'btn2_link' => '',
            ],
        ],
        'text_image' => [
            'label' => 'Text + Image',
            'icon'  => 'fa-solid fa-image',
            'fields' => [
                'eyebrow'        => ['type' => 'text', 'label' => 'Eyebrow Label'],
                'headline'       => ['type' => 'text', 'label' => 'Headline'],
                'body'           => ['type' => 'textarea', 'label' => 'Body Text'],
                'image'          => ['type' => 'image', 'label' => 'Image'],
                'image_alt'      => ['type' => 'text', 'label' => 'Image Alt Text'],
                'image_position' => ['type' => 'select', 'label' => 'Image Position', 'options' => ['right' => 'Right', 'left' => 'Left']],
            ],
            'defaults' => [
                'eyebrow' => '', 'headline' => 'Section Headline', 'body' => 'Body copy goes here.',
                'image' => '', 'image_alt' => '', 'image_position' => 'right',
            ],
        ],
        'feature_grid' => [
            'label' => 'Feature Grid',
            'icon'  => 'fa-solid fa-table-cells',
            'fields' => [
                'eyebrow'     => ['type' => 'text', 'label' => 'Eyebrow Label'],
                'headline'    => ['type' => 'text', 'label' => 'Headline'],
                'subheadline' => ['type' => 'textarea', 'label' => 'Subheadline'],
                'columns'     => ['type' => 'select', 'label' => 'Columns', 'options' => ['2' => '2', '3' => '3', '4' => '4']],
                'items'       => [
                    'type' => 'repeater', 'label' => 'Features',
                    'fields' => [
                        'icon'  => ['type' => 'text', 'label' => 'Icon (Font Awesome class, e.g. fa-solid fa-star)'],
                        'title' => ['type' => 'text', 'label' => 'Title'],
                        'desc'  => ['type' => 'textarea', 'label' => 'Description'],
                    ],
                ],
            ],
            'defaults' => [
                'eyebrow' => '', 'headline' => 'Our Features', 'subheadline' => '', 'columns' => '3',
                'items' => [['icon' => 'fa-solid fa-star', 'title' => 'Feature One', 'desc' => 'Description here.']],
            ],
        ],
        'stats' => [
            'label' => 'Stats / Numbers',
            'icon'  => 'fa-solid fa-chart-simple',
            'fields' => [
                'items' => [
                    'type' => 'repeater', 'label' => 'Stats',
                    'fields' => [
                        'number' => ['type' => 'text', 'label' => 'Number'],
                        'label'  => ['type' => 'text', 'label' => 'Label'],
                    ],
                ],
            ],
            'defaults' => [
                'items' => [['number' => '100+', 'label' => 'Happy Clients']],
            ],
        ],
        'testimonials' => [
            'label' => 'Testimonials',
            'icon'  => 'fa-solid fa-quote-left',
            'fields' => [
                'eyebrow'  => ['type' => 'text', 'label' => 'Eyebrow Label'],
                'headline' => ['type' => 'text', 'label' => 'Headline'],
                'items'    => [
                    'type' => 'repeater', 'label' => 'Testimonials',
                    'fields' => [
                        'quote' => ['type' => 'textarea', 'label' => 'Quote'],
                        'name'  => ['type' => 'text', 'label' => 'Name'],
                        'role'  => ['type' => 'text', 'label' => 'Role / Company'],
                    ],
                ],
            ],
            'defaults' => [
                'eyebrow' => 'Testimonials', 'headline' => 'What Clients Say',
                'items' => [['quote' => 'Great experience working with this team.', 'name' => 'Jane Doe', 'role' => 'Owner, Example Co.']],
            ],
        ],
        'faq' => [
            'label' => 'FAQ',
            'icon'  => 'fa-solid fa-circle-question',
            'fields' => [
                'eyebrow'  => ['type' => 'text', 'label' => 'Eyebrow Label'],
                'headline' => ['type' => 'text', 'label' => 'Headline'],
                'items'    => [
                    'type' => 'repeater', 'label' => 'Questions',
                    'fields' => [
                        'question' => ['type' => 'text', 'label' => 'Question'],
                        'answer'   => ['type' => 'textarea', 'label' => 'Answer'],
                    ],
                ],
            ],
            'defaults' => [
                'eyebrow' => 'FAQ', 'headline' => 'Frequently Asked Questions',
                'items' => [['question' => 'Question goes here?', 'answer' => 'Answer goes here.']],
            ],
        ],
        'cta' => [
            'label' => 'Call to Action',
            'icon'  => 'fa-solid fa-bullhorn',
            'fields' => [
                'eyebrow'     => ['type' => 'text', 'label' => 'Eyebrow Label'],
                'headline'    => ['type' => 'text', 'label' => 'Headline'],
                'description' => ['type' => 'textarea', 'label' => 'Description'],
                'btn_text'    => ['type' => 'text', 'label' => 'Button Text'],
                'btn_link'    => ['type' => 'url', 'label' => 'Button Link'],
            ],
            'defaults' => [
                'eyebrow' => '', 'headline' => 'Ready to Get Started?', 'description' => '',
                'btn_text' => 'Contact Us', 'btn_link' => '#contact',
            ],
        ],
        'custom_html' => [
            'label' => 'Custom HTML',
            'icon'  => 'fa-solid fa-code',
            'fields' => [
                'html' => ['type' => 'textarea', 'label' => 'Raw HTML'],
            ],
            'defaults' => [
                'html' => '<!-- Custom HTML goes here -->',
            ],
        ],
    ];
}

function hc_block_defaults(string $type): array {
    $reg = hc_block_registry();
    return $reg[$type]['defaults'] ?? [];
}

/** Renders one block's HTML for the public-facing page. */
function hc_render_block(string $type, array $data): string {
    $fn = 'hc_render_block_' . $type;
    if (!function_exists($fn)) return '';
    return $fn($data);
}

function hc_render_block_hero(array $d): string {
    $eyebrow  = h($d['eyebrow'] ?? '');
    $headline = h($d['headline'] ?? '');
    $sub      = h($d['subheadline'] ?? '');
    $desc     = h($d['description'] ?? '');

    $eyebrowHtml = $eyebrow !== '' ? '<p class="section-label">' . $eyebrow . '</p>' : '';
    $subHtml     = $sub !== '' ? '<p class="pb-hero-sub">' . $sub . '</p>' : '';
    $descHtml    = $desc !== '' ? '<p class="pb-hero-desc">' . $desc . '</p>' : '';

    $btn1 = '';
    if (!empty($d['btn1_text'])) {
        $btn1 = '<a href="' . h($d['btn1_link'] ?? '#') . '" class="btn-primary">' . h($d['btn1_text']) . '</a>';
    }
    $btn2 = '';
    if (!empty($d['btn2_text'])) {
        $btn2 = '<a href="' . h($d['btn2_link'] ?? '#') . '" class="btn-secondary">' . h($d['btn2_text']) . '</a>';
    }

    return '<section class="pb-hero"><div class="container"><div class="pb-hero-inner">'
        . $eyebrowHtml
        . '<h1 class="pb-hero-h1">' . $headline . '</h1>'
        . $subHtml
        . $descHtml
        . '<div class="pb-hero-actions">' . $btn1 . $btn2 . '</div>'
        . '</div></div></section>';
}

function hc_render_block_text_image(array $d): string {
    $eyebrow  = h($d['eyebrow'] ?? '');
    $headline = h($d['headline'] ?? '');
    $body     = nl2br(h($d['body'] ?? ''));
    $image    = h($d['image'] ?? '');
    $alt      = h($d['image_alt'] ?? '');
    $posClass = ($d['image_position'] ?? 'right') === 'left' ? ' pb-reverse' : '';

    $eyebrowHtml = $eyebrow !== '' ? '<p class="section-label">' . $eyebrow . '</p>' : '';
    $imgHtml     = $image !== '' ? '<img src="' . $image . '" alt="' . $alt . '" loading="lazy">' : '';

    return '<section class="pb-text-image' . $posClass . '"><div class="container pb-text-image-grid"><div>'
        . $eyebrowHtml
        . '<h2 class="section-h2">' . $headline . '</h2>'
        . '<p class="section-sub">' . $body . '</p>'
        . '</div><div class="pb-text-image-visual">' . $imgHtml . '</div></div></section>';
}

function hc_render_block_feature_grid(array $d): string {
    $eyebrow  = h($d['eyebrow'] ?? '');
    $headline = h($d['headline'] ?? '');
    $sub      = h($d['subheadline'] ?? '');
    $cols     = (int)($d['columns'] ?? 3);

    $eyebrowHtml = $eyebrow !== '' ? '<p class="section-label" style="justify-content:center">' . $eyebrow . '</p>' : '';
    $subHtml     = $sub !== '' ? '<p class="section-sub" style="margin:0 auto">' . $sub . '</p>' : '';

    $items = '';
    foreach (($d['items'] ?? []) as $item) {
        $icon  = h($item['icon'] ?? 'fa-solid fa-star');
        $title = h($item['title'] ?? '');
        $desc  = h($item['desc'] ?? '');
        $items .= '<div class="pb-feature-card"><div class="pb-feature-icon"><i class="' . $icon . '"></i></div><h3>' . $title . '</h3><p>' . $desc . '</p></div>';
    }

    return '<section class="pb-feature-grid"><div class="container"><div class="pb-section-header">'
        . $eyebrowHtml
        . '<h2 class="section-h2">' . $headline . '</h2>'
        . $subHtml
        . '</div><div class="pb-feature-cards" style="grid-template-columns:repeat(' . $cols . ',1fr)">' . $items . '</div></div></section>';
}

function hc_render_block_stats(array $d): string {
    $items = '';
    foreach (($d['items'] ?? []) as $item) {
        $items .= '<div class="pb-stat"><div class="pb-stat-num">' . h($item['number'] ?? '') . '</div><div class="pb-stat-label">' . h($item['label'] ?? '') . '</div></div>';
    }
    return '<section class="pb-stats"><div class="container pb-stats-row">' . $items . '</div></section>';
}

function hc_render_block_testimonials(array $d): string {
    $eyebrow  = h($d['eyebrow'] ?? '');
    $headline = h($d['headline'] ?? '');
    $eyebrowHtml = $eyebrow !== '' ? '<p class="section-label" style="justify-content:center">' . $eyebrow . '</p>' : '';

    $items = '';
    foreach (($d['items'] ?? []) as $item) {
        $items .= '<div class="pb-testimonial"><p class="pb-testimonial-quote">&ldquo;' . h($item['quote'] ?? '') . '&rdquo;</p><div class="pb-testimonial-name">' . h($item['name'] ?? '') . '</div><div class="pb-testimonial-role">' . h($item['role'] ?? '') . '</div></div>';
    }

    return '<section class="pb-testimonials"><div class="container"><div class="pb-section-header">'
        . $eyebrowHtml
        . '<h2 class="section-h2">' . $headline . '</h2>'
        . '</div><div class="pb-testimonial-grid">' . $items . '</div></div></section>';
}

function hc_render_block_faq(array $d): string {
    $eyebrow  = h($d['eyebrow'] ?? '');
    $headline = h($d['headline'] ?? '');
    $eyebrowHtml = $eyebrow !== '' ? '<p class="section-label" style="justify-content:center">' . $eyebrow . '</p>' : '';

    $items = '';
    foreach (($d['items'] ?? []) as $item) {
        $items .= '<div class="faq-item"><div class="faq-q" onclick="toggleFaq(this)"><span class="faq-q-text">' . h($item['question'] ?? '') . '</span><div class="faq-q-icon"><i class="fa-solid fa-plus"></i></div></div><div class="faq-a"><div class="faq-a-inner">' . nl2br(h($item['answer'] ?? '')) . '</div></div></div>';
    }

    return '<section class="pb-faq"><div class="container"><div class="pb-section-header">'
        . $eyebrowHtml
        . '<h2 class="section-h2">' . $headline . '</h2>'
        . '</div><div class="faq-list" style="max-width:860px;margin:0 auto">' . $items . '</div></div></section>';
}

function hc_render_block_cta(array $d): string {
    $eyebrow  = h($d['eyebrow'] ?? '');
    $headline = h($d['headline'] ?? '');
    $desc     = h($d['description'] ?? '');

    $eyebrowHtml = $eyebrow !== '' ? '<p class="section-label" style="justify-content:center">' . $eyebrow . '</p>' : '';
    $descHtml    = $desc !== '' ? '<p class="section-sub" style="margin:0 auto 24px">' . $desc . '</p>' : '';

    $btn = '';
    if (!empty($d['btn_text'])) {
        $btn = '<a href="' . h($d['btn_link'] ?? '#') . '" class="btn-primary">' . h($d['btn_text']) . '</a>';
    }

    return '<section class="pb-cta"><div class="container pb-cta-inner">'
        . $eyebrowHtml
        . '<h2 class="section-h2">' . $headline . '</h2>'
        . $descHtml
        . $btn
        . '</div></section>';
}

function hc_render_block_custom_html(array $d): string {
    // Intentionally unescaped — this block exists specifically to let an
    // admin (already auth-gated) drop in raw markup/embeds.
    return $d['html'] ?? '';
}
