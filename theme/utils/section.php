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
        'cta',
        'calculator',
        'faq',
        'blog_header',
        'text',
        'blog_slider',
        'about',
        'blog_grid',
    ];
}

/**
 * Layouts with a dark background. When one of them is the first section on a page,
 * the transparent header keeps its white logo and links.
 *
 * @return string[] Flexible content layout names.
 */
function ds_get_dark_layouts() {
    return [
        'header_main',
        'process',
        'content_slider',
        'cta',
        'about',
    ];
}

/**
 * Whether the current page starts with a light section, so the transparent header
 * needs the dark logo and dark links.
 *
 * @return bool
 */
function ds_has_light_header() {
    if( !is_singular() ) return false;

    $post_id = get_queried_object_id();
    $layouts = get_post_meta($post_id, 'elements', true);
    if( empty($layouts) || !is_array($layouts) ) return false;
    if( in_array($layouts[0], ds_get_dark_layouts(), true) ) return false;

    return 'dark' !== get_post_meta($post_id, 'elements_0_section_config_background', true);
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
