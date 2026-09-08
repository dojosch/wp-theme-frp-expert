<?php 

acf_add_local_field_group(array(
	'key' => 'group_321bf8107f6a58',
	'title' => 'Defaults',
	'fields' => array(
        ds_group_field('field_d671b423c81c7c', 'Defaults', [
            ds_text_field('field_aa404830578648', 'Video Play Text', [
                'default_value' => 'Video abspielen',
            ]),
            ds_text_field('field_aa404830578648', 'Video Pause Text', [
                'default_value' => 'Video pausieren',
            ]),
        ]),
    ),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-defaults',
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