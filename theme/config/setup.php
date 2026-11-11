<?php
/**
 * Theme setup function.
 *
 * Sets up theme defaults and registers support for various WordPress features.
 * This function is hooked into the 'after_setup_theme' hook, which runs before
 * the init hook. The init hook is too late for some features, such as indicating
 * support for post thumbnails.
 *
 * @return void
 * @package wp-starter-tw
 */

/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * This function is hooked into the 'after_setup_theme' action, which runs
 * before the init hook. The init hook is too late for some features, such as
 * indicating support for post thumbnails.
 *
 * @return void
 */
function ds_setup() {

	load_theme_textdomain('ds-starter', get_template_directory() . '/languages');

	/*
		* Let WordPress manage the document title.
		* By adding theme support, we declare that this theme does not use a
		* hard-coded <title> tag in the document head, and expect WordPress to
		* provide it for us.
		*/
	add_theme_support('title-tag');

	/*
		* Enable support for Post Thumbnails on posts and pages.
		*
		* @link https://developer.wordpress.org/themes/functionality/featured-images-post-thumbnails/
		*/
	add_theme_support('post-thumbnails');

	/*
		* Switch default core markup for search form, comment form, and comments
		* to output valid HTML5.
		*/
	add_theme_support(
		'html5',
		array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
			'style',
			'script',
		)
	);

	// Add theme support for selective refresh for widgets.
	add_theme_support('customize-selective-refresh-widgets');

	// Add support for editor styles.
	add_theme_support('editor-styles');

	// Enqueue editor styles.
	add_editor_style('style-editor.css');

	// Add support for responsive embedded content.
	add_theme_support('responsive-embeds');

	// Remove support for block templates.
	remove_theme_support('block-templates');
}
add_action('after_setup_theme', 'ds_setup');

add_filter('wpcf7_autop_or_not', '__return_false');
add_filter('wpcf7_load_css', '__return_false'); // styles/tailwind/custom/contact.css covers the form