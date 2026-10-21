<?php

/**
 * Registers the "Lead" button plugin (theme/assets/js/tinymce-lead.js).
 */
add_filter('mce_external_plugins', function($plugins) {
    $plugins['ds_lead'] = ds_get_theme_asset_url('js/tinymce-lead.js') . '?ver=' . filemtime(get_template_directory() . '/assets/js/tinymce-lead.js');
    return $plugins;
});

/**
 * Places the "Lead" button in the first editor toolbar row (used by the Full toolbar), after the paragraph dropdown.
 */
add_filter('mce_buttons', function($buttons) {
    $position = array_search('formatselect', $buttons, true);
    array_splice($buttons, false === $position ? 0 : $position + 1, 0, ['ds_lead']);
    return $buttons;
});

/**
 * Previews the Lead style inside the editor, mirroring its desktop style in styles/tailwind/custom/wysiwyg.css.
 */
add_filter('tiny_mce_before_init', function($init) {
    $init['content_style'] = trim(($init['content_style'] ?? '') . ' .ds-lead { color: #506bff; font-size: 24px; line-height: 36px; font-weight: 500; }');
    return $init;
});
