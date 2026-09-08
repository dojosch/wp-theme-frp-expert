<?php 

acf_add_local_field_group( array(
	'key' => 'group_67879735a7e23',
	'title' => 'Testimonial Elements',
	'fields' => array(
        ds_wysiwyg_field('field_59694e29f66f47', 'Text', 'basic', 0),
        ds_text_field('field_2c13685444adcf', 'Author'),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'testimonial',
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