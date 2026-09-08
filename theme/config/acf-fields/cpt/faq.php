<?php

acf_add_local_field_group( array(
	'key' => 'group_67877dc96bf94',
	'title' => 'FAQ Elements',
	'fields' => array(
		ds_wysiwyg_field('field_35f88d10b4f3ff', 'Text', 'basic', 0),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'faq',
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
) );