<?php 

function ds_open_section($additional_classes = '') {
    $section_name = get_row_layout();
    $section_classname = 'ds-section--' . str_replace('_', '-', $section_name);
    $section_config = get_sub_field('section_config');
    $id = $section_config['id'] ?? '';
    $css_class = $section_config['css_class'] ?? '';
    $background = $section_config['background'] ?? '';

    $section_classes = $section_classname . ' ' . $css_class . ' ' . $background . ' ' . $additional_classes;

    return '<section id="' . $id . '" class="' . $section_classes . '">';
}

function ds_close_section() {
    return '</section>';
}