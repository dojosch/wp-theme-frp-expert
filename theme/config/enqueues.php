<?php
/**
 * Theme Enqueue Configuration File
 *
 * This file is responsible for registering and enqueuing the theme's stylesheets
 * and JavaScript files. It ensures that the necessary assets are loaded for both
 * the frontend and the editor. Additionally, it handles the inclusion of the
 * WordPress comment-reply script when applicable.
 *
 * @package WordPress
 * @subpackage WP_Starter_TW
 * @since 1.0.0
 */

/**
 * Enqueues theme styles and scripts.
 *
 * This function registers and enqueues the main stylesheet, editor stylesheet,
 * and JavaScript files for the theme. Additionally, it enqueues the WordPress
 * comment-reply script if the current post is singular, comments are open, and
 * threaded comments are enabled.
 *
 * @return void
 */
function ds_scripts() {
	wp_enqueue_style('ds-starter-style', get_template_directory_uri() . '/dist/style.css', array(), 1);
	wp_enqueue_style('ds-starter-style', get_template_directory_uri() . '/dist/style-editor.css', array(), 1);
	wp_enqueue_script('ds-starter-script', get_template_directory_uri() . '/dist/script.min.js', array(), 1, true);

	if( is_singular() && comments_open() && get_option('thread_comments') ) {
		wp_enqueue_script('comment-reply');
	}
}
add_action('wp_enqueue_scripts', 'ds_scripts');

/**
 * Enqueues styles for the WordPress admin.
 *
 * Loads the compiled admin stylesheet on every admin screen so backend
 * tweaks (hidden meta box actions, editor adjustments) can be authored in
 * styles/admin.css instead of inline CSS.
 *
 * @return void
 */
function ds_admin_scripts() {
	wp_enqueue_style('ds-starter-admin-style', get_template_directory_uri() . '/dist/admin.css', array(), 1);
}
add_action('admin_enqueue_scripts', 'ds_admin_scripts');
