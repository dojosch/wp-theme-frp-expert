<?php
/**
 * Register ACF Options Pages for the Theme
 *
 * @package wp-starter-tw
 */

/**
 * Registers ACF options pages and subpages for the theme.
 *
 * @return void
 */

add_action('acf/init', 'ds_register_acf_options_pages');
function ds_register_acf_options_pages() {
	if ( ! function_exists( 'acf_add_options_page' ) ) {
		return;
	}

	// Add the main options page.
	acf_add_options_page(
		array(
			'page_title' => 'Theme Einstellungen',
			'menu_title' => 'Theme Einstellungen',
			'menu_slug'  => 'theme-overview-settings',
			'capability' => 'edit_posts',
			'redirect'   => true, // Redirects to the first sub page.
		)
	);

	// Subpages to register under the parent.
	$subpages = array(
		'Footer',
		'Navigation',
		'404-Seite',
	);

	foreach ( $subpages as $title ) {
		acf_add_options_sub_page(
			array(
				// translators: %s: Subpage title.
				'page_title'  => sprintf( __( '%s', 'ds' ), $title ),
				// translators: %s: Subpage title.
				'menu_title'  => sprintf( __( '%s', 'ds' ), $title ),
				'parent_slug' => 'theme-overview-settings',
			)
		);
	}
}
