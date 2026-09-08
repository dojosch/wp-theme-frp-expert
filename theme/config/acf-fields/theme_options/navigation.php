<?php 

acf_add_local_field_group(array(
	'key' => 'group_678e68e95a3ce',
	'title' => 'Navigation',
	'fields' => array(
        ds_group_field('field_bf28d816b0c121', 'Navigation', [
            
        ]),
    ),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-navigation',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
));