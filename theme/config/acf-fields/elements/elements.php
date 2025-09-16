<?php

/**
 * Registers a Flexible Content field group for ACF (Advanced Custom Fields) with dynamic layouts.
 *
 * This script auto-loads all layout configuration files from `/config/acf_fields/elements/fields/`.
 * Each layout file must define a variable with the same name as the file (e.g. `cta.php` defines `$cta`).
 *
 * If a file does not declare a matching variable, a warning is triggered.
 *
 * @package wp-starter-tw-main
 */

$layouts = [];
$layouts_without_background_option = [
    // Add section names here that should NOT have the background option
];

require_once get_template_directory() . '/config/acf-fields/elements/section_config.php';

foreach (glob(get_template_directory() . '/config/acf-fields/elements/fields/*.php') as $file) {
    $new_config = unserialize(serialize($section_config));
    $layout_name = basename($file, '.php');
    $new_config['key'] = 'field_' . $layout_name;

    if (in_array($layout_name, $layouts_without_background_option)) {
        $new_config['sub_fields'] = array_filter($new_config['sub_fields'], function ($field) {
            return !in_array($field['key'], [
                'field_section_background',
            ]);
        });

        $new_config['sub_fields'] = array_values($new_config['sub_fields']);
    }

    $layout_entry = ds_load_acf_layout($file, $new_config);

    // Merge single-element array into layouts
    $layouts = array_merge($layouts, $layout_entry);
}


acf_add_local_field_group(
    array(
        'key'      => 'group_elements',
        'title'    => 'Page Fields',
        'menu_order' => 0,
        'position' => 'acf_after_title',
        'style' => 'default',
        'label_placement' => 'top',
        'instruction_placement' => 'label',
        'hide_on_screen' => array(
            0 => 'the_content',
            1 => 'excerpt',
            2 => 'discussion',
            3 => 'comments',
            4 => 'author',
            5 => 'format',
            7 => 'featured_image',
            8 => 'categories',
            9 => 'tags',
        ),
        'active' => true,
        'description' => '',
        'fields'   => array(
            array(
                'key'          => 'field_elements',
                'label'        => 'Elements',
                'name'         => 'elements',
                'type'         => 'flexible_content',
                'layouts'      => $layouts,
                'button_label' => 'Layout hinzufügen',
            ),
        ),
        'location' => array(
            array(
                array(
                    'param'    => 'page_template',
                    'operator' => '==',
                    'value'    => 'page-templates/main-template.php',
                ),
            ),
        ),
    )
);
