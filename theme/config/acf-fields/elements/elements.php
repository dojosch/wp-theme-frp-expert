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

foreach ( glob( get_template_directory() . '/config/acf-fields/elements/fields/*.php' ) as $file ) {
	require_once $file;

	$layout_name = basename( $file, '.php' );

	if ( isset( ${$layout_name} ) ) {
		$layouts[ $layout_name ] = ${$layout_name};
	} else {
		trigger_error( "ACF layout variable \${$layout_name} not found in {$file}", E_USER_WARNING );
	}
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
