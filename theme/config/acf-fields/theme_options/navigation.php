<?php 

acf_add_local_field_group( array(
	'key' => 'group_678e68e95a3ce',
	'title' => 'Navigation',
	'fields' => array(
        ds_image_field('field_81831956feee98', 'Logo', [
            'name' => 'navigation_logo',
        ]),
        array(
            'key' => 'field_f372ad05efff72',
            'label' => 'Links',
            'name' => 'navigation_links',
            'type' => 'repeater',
            'instructions' => '',
            'required' => 0,
            'conditional_logic' => 0,
            'wrapper' => array(
               'width' => '',
               'class' => '',
               'id' => '',
            ),
            'collapsed' => '',
            'min' => 0,
            'max' => 0,
            'layout' => 'block',
            'button_label' => 'Link hinzufügen',
            'sub_fields' => array(
                ds_link_field('field_d826b812f0b4a8', 'Link'),
            ),
        ),
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