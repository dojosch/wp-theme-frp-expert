<?php 

add_action('init', function () {
	ds_register_cpt('faq', 'FAQ', 'FAQs', [
		'slug' => 'haeufige-fragen',
		'menu_icon' => 'dashicons-editor-help',
	]);

	ds_register_cpt('career', 'Offene Stelle', 'Offene Stellen', [
		'slug' => 'offene-stellen',
		'menu_icon' => 'dashicons-editor-help',
	]);
});
