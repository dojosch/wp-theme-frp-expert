<?php 

acf_add_local_field_group(array(
	'key' => 'group_67570e38a271d',
	'title' => 'Footer',
	'fields' => array(
        ds_group_field('field_c95a8835cfeb9c', 'Footer', [
            
        ]),
    ),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-footer',
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