<?php

/**
 * Layouts whose section settings don't offer the background select.
 * Their sections get no ds-section--white / ds-section--dark modifier.
 *
 * @return string[] Flexible content layout names.
 */
function ds_get_layouts_without_background() {
    return [
        'header_main',
        'intro',
        'process',
        'content_slider',
        'two_col',
        'showcase',
    ];
}

function ds_open_section($additional_classes = '') {
    $section_name = get_row_layout();
    $section_classname = 'ds-section--' . str_replace('_', '-', $section_name);
    $section_config = get_sub_field('section_config');
    $id = $section_config['id'] ?? '';
    $css_class = $section_config['css_class'] ?? '';
    $background = '';

    if( !in_array($section_name, ds_get_layouts_without_background(), true) ) {
        $background = 'dark' === ($section_config['background'] ?? '') ? 'ds-section--dark' : 'ds-section--white';
    }

    $section_classes = $section_classname . ' ' . $css_class . ' ' . $background . ' ' . $additional_classes;

    return '<section id="' . esc_attr($id) . '" class="' . esc_attr($section_classes) . '">';
}

function ds_close_section() {
    return '</section>';
}
