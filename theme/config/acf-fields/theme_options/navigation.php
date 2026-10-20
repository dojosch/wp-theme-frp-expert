<?php 

acf_add_local_field_group(array(
	'key' => 'group_678e68e95a3ce',
	'title' => 'Navigation',
	'fields' => array(
        ds_group_field('field_bf28d816b0c121', 'Navigation', [
            ds_image_field('field_nav_logo_dark', 'Logo Dark', [
                'instructions' => 'Dunkles Logo für Seiten, deren erster Abschnitt hell ist (z. B. Blog-Beiträge). Das helle Logo kommt aus Defaults.',
            ]),
            ds_repeater_field('field_nav_links', 'Links', [
                ds_link_field('field_nav_links_link', 'Link'),
            ], 'Link hinzufügen'),
            ds_link_field('field_nav_button', 'Button'),
            ds_repeater_field('field_nav_meta_links', 'Meta Links', [
                ds_link_field('field_nav_meta_links_link', 'Link'),
            ], 'Link hinzufügen', [
                'instructions' => 'Rechtliche Links unten im mobilen Menü.',
            ]),
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