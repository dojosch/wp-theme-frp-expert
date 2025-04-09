<?php
/**
 * Custom Post Type (CPT) registration configuration.
 *
 * This file contains the configuration for registering custom post types (CPTs)
 * in the WordPress theme. It defines the initialization of CPTs such as FAQ and Career.
 *
 * @package wp-starter-tw
 * @subpackage Theme
 * @since 1.0.0
 */

add_action(
	'init',
	function () {
		ds_register_cpt(
			'faq',
			'FAQ',
			'FAQs',
			array(
				'slug'      => 'haeufige-fragen',
				'menu_icon' => 'dashicons-editor-help',
			)
		);

		ds_register_cpt(
			'career',
			'Offene Stelle',
			'Offene Stellen',
			array(
				'slug'      => 'offene-stellen',
				'menu_icon' => 'dashicons-editor-help',
			)
		);
	}
);
