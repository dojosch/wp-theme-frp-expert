<?php 

add_action('acf/include_fields', function() {
	if( !function_exists('acf_add_local_field_group') ) return;

	acf_add_local_field_group(array(
	'key' => 'group_67570e38a271e',
	'title' => '404',
	'fields' => array(
        ds_wysiwyg_field('field_4cdfc746639d43', 'Wysiwyg', 'full', 0, [
            'name' => 'text_404'
        ]),
	),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-404-seite',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'normal',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
));
});