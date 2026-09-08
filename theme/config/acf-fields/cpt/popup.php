<?php

acf_add_local_field_group( array(
	'key' => 'group_d798a358f40c51',
	'title' => 'Popup Einstellungen',
	'fields' => array(
        ds_group_field('field_b57bd826111e78', 'Popup', [
            ds_toggle_field('field_118928268e1049', 'Activ', [
                'instructions' => 'Popup aktivieren oder deaktivieren.',
                'ui_on_text' => 'Aktiv',
                'ui_off_text' => 'Inaktiv',
                'name' => 'active',
            ]),
            ds_heading_field('field_6d9308005a4098', 'Heading', 'h2', ''),
            ds_wysiwyg_field('field_e7e2411789a732', 'Text', 'basic', 0),
            ds_link_field('field_55a08824b13038', 'Button 1 (Primary)', array( 'name' => 'button_1' ) ),
            ds_link_field('field_6862f838e93568', 'Button 2 (Secondary)', array( 'name' => 'button_2' ) ),
            ds_select_field('field_88e17854163cfe', 'Anzeigeoption', [
                'all' => 'Auf allen Seiten',
                'pages' => 'Bestimmte Seiten',
                'categories' => 'Bestimmte Kategorien',
            ], 'all', [
                'name' => 'display_option',
                'instructions' => 'Wo soll das Popup angezeigt werden?',
            ]),
            array(
                'key' => 'field_ce4086189c2a41',
                'label' => 'Seiten auswählen',
                'name' => 'pages',
                'type' => 'relationship',
                'instructions' => 'Wähle die Seiten aus, auf denen das Popup angezeigt werden soll.',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_88e17854163cfe',
                            'operator' => '==',
                            'value' => 'pages',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'post_type' => array(
                    0 => 'page',
                    1 => 'room',
                    2 => 'offer',
                    3 => 'post',
                ),
                'filters' => array(
                    0 => 'search',
                    1 => 'post_type',
                ),
                'return_format' => 'id',
                'min' => '',
                'max' => '',
                'elements' => '',
            ),
            array(
                'key' => 'field_d5581822beb2ab',
                'label' => 'Kategorien auswählen',
                'name' => 'categories',
                'type' => 'taxonomy',
                'instructions' => 'Wähle die Kategorien aus, auf denen das Popup angezeigt werden soll.',
                'required' => 0,
                'conditional_logic' => array(
                    array(
                        array(
                            'field' => 'field_field_88e17854163cfe',
                            'operator' => '==',
                            'value' => 'categories',
                        ),
                    ),
                ),
                'wrapper' => array(
                    'width' => '',
                    'class' => '',
                    'id' => '',
                ),
                'taxonomy' => 'category',
                'field_type' => 'multi_select',
                'allow_null' => 0,
                'add_term' => 0,
                'save_terms' => 0,
                'load_terms' => 0,
                'return_format' => 'id',
                'multiple' => 1,
            ),
            ds_group_field('field_200ab852f9ff58', 'Popup Einstellungen', [
                array(
                    'key' => 'field_9299785292a408',
                    'label' => 'Verzögerung (Sekunden)',
                    'name' => 'delay',
                    'type' => 'number',
                    'instructions' => 'Verzögerung in Sekunden bis das Popup erscheint (Standard: 3).',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 3,
                    'min' => 0,
                    'max' => 60,
                    'step' => 1,
                ),
                array(
                    'key' => 'field_cpt_popup_cookie_duration',
                    'label' => 'Cookie-Laufzeit (Tage)',
                    'name' => 'cookie_duration',
                    'type' => 'number',
                    'instructions' => 'Nach dem Schließen für wie viele Tage nicht mehr anzeigen? (Standard: 7).',
                    'required' => 0,
                    'conditional_logic' => 0,
                    'wrapper' => array(
                        'width' => '50',
                        'class' => '',
                        'id' => '',
                    ),
                    'default_value' => 7,
                    'min' => 1,
                    'max' => 365,
                    'step' => 1,
                ),
            ], [
                'name' => 'popup_settings',
            ]),
        ]),
	),
	'location' => array(
		array(
			array(
				'param' => 'post_type',
				'operator' => '==',
				'value' => 'ds_popups',
			),
		),
	),
	'position' => 'acf_after_title',
	'menu_order' => 0,
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
) );