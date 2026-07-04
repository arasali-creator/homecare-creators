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
        'heading' => [
            'label' => 'Heading',
            'icon'  => 'fa-solid fa-heading',
            'fields' => [
                'text' => ['type' => 'text', 'label' => 'Heading Text'],
                'tag'  => ['type' => 'select', 'label' => 'Tag', 'options' => ['h1' => 'H1', 'h2' => 'H2', 'h3' => 'H3', 'h4' => 'H4']],
                'size' => ['type' => 'select', 'label' => 'Size', 'options' => ['small' => 'Small', 'medium' => 'Medium', 'large' => 'Large', 'xlarge' => 'X-Large']],
            ],
            'defaults' => ['text' => 'Your Heading Here', 'tag' => 'h2', 'size' => 'medium'],
        ],
        'text_editor' => [
            'label' => 'Text Editor',
            'icon'  => 'fa-solid fa-align-left',
            'fields' => [
                'content' => ['type' => 'textarea', 'label' => 'Text'],
            ],
            'defaults' => ['content' => 'Add your text here.'],
        ],
        'image' => [
            'label' => 'Image',
            'icon'  => 'fa-solid fa-image',
            'fields' => [
                'image'     => ['type' => 'image', 'label' => 'Image'],
                'image_alt' => ['type' => 'text', 'label' => 'Alt Text'],
                'caption'   => ['type' => 'text', 'label' => 'Caption'],
                'link'      => ['type' => 'url', 'label' => 'Link (optional)'],
                'align'     => ['type' => 'select', 'label' => 'Alignment', 'options' => ['left' => 'Left', 'center' => 'Center', 'right' => 'Right']],
                'size'      => ['type' => 'select', 'label' => 'Size', 'options' => ['small' => 'Small', 'medium' => 'Medium', 'large' => 'Large', 'full' => 'Full Width']],
            ],
            'defaults' => ['image' => '', 'image_alt' => '', 'caption' => '', 'link' => '', 'align' => 'center', 'size' => 'medium'],
        ],
        'video' => [
            'label' => 'Video',
            'icon'  => 'fa-solid fa-circle-play',
            'fields' => [
                'video_url' => ['type' => 'url', 'label' => 'YouTube, Vimeo, or direct video URL'],
                'caption'   => ['type' => 'text', 'label' => 'Caption'],
            ],
            'defaults' => ['video_url' => '', 'caption' => ''],
        ],
        'button' => [
            'label' => 'Button',
            'icon'  => 'fa-solid fa-square',
            'fields' => [
                'text'  => ['type' => 'text', 'label' => 'Button Text'],
                'link'  => ['type' => 'url', 'label' => 'Link'],
                'style' => ['type' => 'select', 'label' => 'Style', 'options' => ['primary' => 'Primary', 'secondary' => 'Secondary']],
                'align' => ['type' => 'select', 'label' => 'Alignment', 'options' => ['left' => 'Left', 'center' => 'Center', 'right' => 'Right']],
            ],
            'defaults' => ['text' => 'Click Here', 'link' => '#', 'style' => 'primary', 'align' => 'center'],
        ],
        'google_maps' => [
            'label' => 'Google Maps',
            'icon'  => 'fa-solid fa-map-location-dot',
            'fields' => [
                'address' => ['type' => 'text', 'label' => 'Address or Place Name'],
                'height'  => ['type' => 'select', 'label' => 'Height', 'options' => ['300' => '300px', '400' => '400px', '500' => '500px']],
            ],
            'defaults' => ['address' => '', 'height' => '400'],
        ],
        'icon' => [
            'label' => 'Icon',
            'icon'  => 'fa-solid fa-icons',
            'fields' => [
                'icon'  => ['type' => 'text', 'label' => 'Icon (Font Awesome class)'],
                'size'  => ['type' => 'text', 'label' => 'Size (px)'],
                'color' => ['type' => 'text', 'label' => 'Color (hex)'],
                'link'  => ['type' => 'url', 'label' => 'Link (optional)'],
                'align' => ['type' => 'select', 'label' => 'Alignment', 'options' => ['left' => 'Left', 'center' => 'Center', 'right' => 'Right']],
            ],
            'defaults' => ['icon' => 'fa-solid fa-star', 'size' => '32', 'color' => '', 'link' => '', 'align' => 'center'],
        ],
        'image_box' => [
            'label' => 'Image Box',
            'icon'  => 'fa-solid fa-image',
            'fields' => [
                'image'     => ['type' => 'image', 'label' => 'Image'],
                'image_alt' => ['type' => 'text', 'label' => 'Alt Text'],
                'heading'   => ['type' => 'text', 'label' => 'Heading'],
                'text'      => ['type' => 'textarea', 'label' => 'Text'],
            ],
            'defaults' => ['image' => '', 'image_alt' => '', 'heading' => 'Title Here', 'text' => 'Short description here.'],
        ],
        'icon_box' => [
            'label' => 'Icon Box',
            'icon'  => 'fa-solid fa-vector-square',
            'fields' => [
                'icon'    => ['type' => 'text', 'label' => 'Icon (Font Awesome class)'],
                'heading' => ['type' => 'text', 'label' => 'Heading'],
                'text'    => ['type' => 'textarea', 'label' => 'Text'],
                'align'   => ['type' => 'select', 'label' => 'Alignment', 'options' => ['left' => 'Left', 'center' => 'Center']],
            ],
            'defaults' => ['icon' => 'fa-solid fa-star', 'heading' => 'Title Here', 'text' => 'Short description here.', 'align' => 'center'],
        ],
        'columns' => [
            'label' => 'Columns',
            'icon'  => 'fa-solid fa-table-columns',
            'fields' => [
                'columns' => ['type' => 'select', 'label' => 'Number of Columns', 'options' => ['2' => '2', '3' => '3', '4' => '4']],
                'items'   => [
                    'type' => 'repeater', 'label' => 'Column Content',
                    'fields' => [
                        'image'         => ['type' => 'image', 'label' => 'Image (optional)'],
                        'heading'       => ['type' => 'text', 'label' => 'Heading'],
                        'text'          => ['type' => 'textarea', 'label' => 'Text'],
                        'button_text'   => ['type' => 'text', 'label' => 'Button Text (optional)'],
                        'button_link'   => ['type' => 'text', 'label' => 'Button Link'],
                    ],
                ],
            ],
            'defaults' => [
                'columns' => '2',
                'items' => [
                    ['image' => '', 'heading' => 'Column One', 'text' => 'Content goes here.', 'button_text' => '', 'button_link' => ''],
                    ['image' => '', 'heading' => 'Column Two', 'text' => 'Content goes here.', 'button_text' => '', 'button_link' => ''],
                ],
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
    return hc_apply_block_style($fn($data), $data);
}

/** Applies the universal Style panel (background/text color, padding, alignment) to a rendered block's outer <section>. */
function hc_apply_block_style(string $html, array $d): string {
    if ($html === '') return $html;
    $css = [];
    if (!empty($d['_style_bg']))    $css[] = 'background:' . $d['_style_bg'];
    if (!empty($d['_style_color'])) $css[] = 'color:' . $d['_style_color'];
    $paddingMap = ['compact' => '48px 40px', 'spacious' => '160px 40px'];
    if (!empty($d['_style_padding']) && isset($paddingMap[$d['_style_padding']])) {
        $css[] = 'padding:' . $paddingMap[$d['_style_padding']];
    }
    if (!empty($d['_style_align']) && $d['_style_align'] !== 'left') {
        $css[] = 'text-align:' . $d['_style_align'];
    }
    if (!$css) return $html;
    $styleAttr = h(implode(';', $css));
    return preg_replace('/^<section([ >])/', '<section style="' . $styleAttr . '"$1', $html, 1);
}

/** Converts a YouTube/Vimeo URL into its iframe embed URL. Returns '' if unrecognized. */
function hc_video_embed_src(string $url): string {
    $url = trim($url);
    if ($url === '') return '';
    if (preg_match('~youtu\.be/([A-Za-z0-9_-]+)~', $url, $m)) return 'https://www.youtube.com/embed/' . $m[1];
    if (preg_match('~youtube\.com/(?:watch\?v=|embed/)([A-Za-z0-9_-]+)~', $url, $m)) return 'https://www.youtube.com/embed/' . $m[1];
    if (preg_match('~vimeo\.com/(\d+)~', $url, $m)) return 'https://player.vimeo.com/video/' . $m[1];
    return '';
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

function hc_render_block_heading(array $d): string {
    $text = h($d['text'] ?? '');
    if ($text === '') return '';
    $tag  = in_array($d['tag'] ?? 'h2', ['h1', 'h2', 'h3', 'h4'], true) ? $d['tag'] : 'h2';
    $size = in_array($d['size'] ?? 'medium', ['small', 'medium', 'large', 'xlarge'], true) ? $d['size'] : 'medium';
    return '<section class="pb-heading-block"><div class="container"><' . $tag . ' class="pb-heading pb-heading-' . $size . '">' . $text . '</' . $tag . '></div></section>';
}

function hc_render_block_text_editor(array $d): string {
    if (trim($d['content'] ?? '') === '') return '';
    $content = nl2br(h($d['content']));
    return '<section class="pb-text-editor"><div class="container"><div class="pb-text-editor-inner">' . $content . '</div></div></section>';
}

function hc_render_block_image(array $d): string {
    $image = h($d['image'] ?? '');
    if ($image === '') return '';
    $alt      = h($d['image_alt'] ?? '');
    $caption  = h($d['caption'] ?? '');
    $link     = h($d['link'] ?? '');
    $align    = h($d['align'] ?? 'center');
    $sizeClass = 'pb-image-' . h($d['size'] ?? 'medium');

    $img = '<img src="' . $image . '" alt="' . $alt . '" loading="lazy">';
    if ($link !== '') $img = '<a href="' . $link . '">' . $img . '</a>';
    $captionHtml = $caption !== '' ? '<figcaption>' . $caption . '</figcaption>' : '';

    return '<section class="pb-image-block pb-align-' . $align . '"><div class="container"><figure class="' . $sizeClass . '">' . $img . $captionHtml . '</figure></div></section>';
}

function hc_render_block_video(array $d): string {
    $url = trim($d['video_url'] ?? '');
    if ($url === '') return '';
    $caption = h($d['caption'] ?? '');
    $embed   = hc_video_embed_src($url);
    if ($embed !== '') {
        $body = '<div class="pb-video-frame"><iframe src="' . h($embed) . '" allowfullscreen loading="lazy"></iframe></div>';
    } else {
        $body = '<div class="pb-video-frame"><video controls src="' . h($url) . '"></video></div>';
    }
    $captionHtml = $caption !== '' ? '<p class="pb-video-caption">' . h($caption) . '</p>' : '';
    return '<section class="pb-video"><div class="container">' . $body . $captionHtml . '</div></section>';
}

function hc_render_block_button(array $d): string {
    $text = h($d['text'] ?? '');
    if ($text === '') return '';
    $link  = h($d['link'] ?? '#');
    $style = ($d['style'] ?? 'primary') === 'secondary' ? 'btn-secondary' : 'btn-primary';
    $align = h($d['align'] ?? 'center');
    return '<section class="pb-button-block pb-align-' . $align . '"><div class="container"><a href="' . $link . '" class="' . $style . '">' . $text . '</a></div></section>';
}

function hc_render_block_google_maps(array $d): string {
    $address = trim($d['address'] ?? '');
    if ($address === '') return '';
    $height = (int)($d['height'] ?? 400);
    $src = 'https://maps.google.com/maps?q=' . urlencode($address) . '&output=embed';
    return '<section class="pb-map"><iframe src="' . h($src) . '" height="' . $height . '" style="border:0;width:100%;display:block" loading="lazy"></iframe></section>';
}

function hc_render_block_icon(array $d): string {
    $icon  = h($d['icon'] ?? 'fa-solid fa-star');
    $size  = (int)($d['size'] ?? 32);
    $color = h($d['color'] ?? '');
    $link  = h($d['link'] ?? '');
    $align = h($d['align'] ?? 'center');
    $style = 'font-size:' . $size . 'px' . ($color !== '' ? ';color:' . $color : '');
    $inner = '<i class="' . $icon . '" style="' . $style . '"></i>';
    if ($link !== '') $inner = '<a href="' . $link . '">' . $inner . '</a>';
    return '<section class="pb-icon-block pb-align-' . $align . '"><div class="container">' . $inner . '</div></section>';
}

function hc_render_block_image_box(array $d): string {
    $heading = h($d['heading'] ?? '');
    $image   = h($d['image'] ?? '');
    $alt     = h($d['image_alt'] ?? '');
    $text    = nl2br(h($d['text'] ?? ''));
    $imgHtml = $image !== '' ? '<img src="' . $image . '" alt="' . $alt . '" loading="lazy">' : '';
    return '<section class="pb-image-box-wrap"><div class="container"><div class="pb-image-box">' . $imgHtml . '<h3>' . $heading . '</h3><p>' . $text . '</p></div></div></section>';
}

function hc_render_block_icon_box(array $d): string {
    $icon    = h($d['icon'] ?? 'fa-solid fa-star');
    $heading = h($d['heading'] ?? '');
    $text    = nl2br(h($d['text'] ?? ''));
    $align   = h($d['align'] ?? 'center');
    return '<section class="pb-icon-box-wrap pb-align-' . $align . '"><div class="container"><div class="pb-icon-box"><div class="pb-icon-box-icon"><i class="' . $icon . '"></i></div><h3>' . $heading . '</h3><p>' . $text . '</p></div></div></section>';
}

function hc_render_block_columns(array $d): string {
    $cols  = (int)($d['columns'] ?? 2);
    $items = '';
    foreach (($d['items'] ?? []) as $item) {
        $img         = !empty($item['image']) ? '<img src="' . h($item['image']) . '" loading="lazy">' : '';
        $headingHtml = !empty($item['heading']) ? '<h3>' . h($item['heading']) . '</h3>' : '';
        $textHtml    = !empty($item['text']) ? '<p>' . nl2br(h($item['text'])) . '</p>' : '';
        $btnHtml     = !empty($item['button_text']) ? '<a href="' . h($item['button_link'] ?? '#') . '" class="btn-secondary">' . h($item['button_text']) . '</a>' : '';
        $items .= '<div class="pb-column">' . $img . $headingHtml . $textHtml . $btnHtml . '</div>';
    }
    return '<section class="pb-columns"><div class="container pb-columns-grid" style="grid-template-columns:repeat(' . $cols . ',1fr)">' . $items . '</div></section>';
}
