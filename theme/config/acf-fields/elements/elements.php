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

$section_layouts = array();
$content_part_raw = null;

require_once get_template_directory() . '/config/acf-fields/elements/section_config.php';
if( !isset($section_config) ) return;

foreach( glob(get_template_directory() . '/config/acf-fields/elements/fields/*.php') as $file ) {
	$layout_name = basename($file, '.php');

	if( 'content_part' === $layout_name ) {
		require_once $file;
		if( isset($content_part) ) {
			$content_part_raw = $content_part;
		}
		continue;
	}

	$new_config = unserialize(serialize($section_config));
	$new_config['key'] = 'field_' . $layout_name;

	if( in_array($layout_name, ds_get_layouts_without_background(), true) ) {
		$new_config['sub_fields'] = array_filter(
			$new_config['sub_fields'],
			function ($field) {
				return !in_array(
					$field['key'],
					array(
						'field_section_background',
					),
					true
				);
			}
		);

		$new_config['sub_fields'] = array_values($new_config['sub_fields']);
	}

	$layout_entry = ds_load_acf_layout($file, $new_config);

	// Merge single-element array into section_layouts
	$section_layouts = array_merge($section_layouts, $layout_entry);
}

if( !empty($content_part_raw) ) {
	$all_layouts = array_merge($section_layouts, array('content_part' => $content_part_raw));
} else {
	$all_layouts = $section_layouts;
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
                'layouts'      => $all_layouts,
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
            array(
				array(
					'param'    => 'post_type',
					'operator' => '==',
					'value'    => 'content_part',
				),
			),
        ),
    )
);

add_filter(
	'acf/prepare_field/name=elements',
	function($field) {
		if( get_post_type() === 'content_part' ) {
			if( isset($field['layouts']['content_part']) ) {
				unset($field['layouts']['content_part']);
			}
		}
		return $field;
	}
);