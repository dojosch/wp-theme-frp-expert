<?php

/**
 * Adds the "Formats" dropdown to the second editor toolbar row (used by the Full toolbar).
 */
add_filter('mce_buttons_2', function($buttons) {
    return array_merge(['styleselect'], $buttons);
});

/**
 * Custom formats offered in the "Formats" dropdown. Styled in styles/tailwind/custom/wysiwyg.css.
 */
add_filter('tiny_mce_before_init', function($init) {
    $init['style_formats'] = wp_json_encode([
        [
            'title'   => 'Lead',
            'block'   => 'p',
            'classes' => 'ds-lead',
        ],
    ]);

    // Preview the formats inside the editor, mirroring their desktop styles.
    $init['content_style'] = trim(($init['content_style'] ?? '') . ' .ds-lead { color: #506bff; font-size: 24px; line-height: 36px; font-weight: 500; }');

    return $init;
});
