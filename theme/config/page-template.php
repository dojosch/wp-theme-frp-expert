<?php
/**
 * Forces the Main Template on every post type it is registered for.
 *
 * The post types are read from the `Template Post Type` header in
 * page-templates/main-template.php, so adding a post type there is enough
 * to opt it in. Since the template is never optional, the Page Attributes
 * meta box (which holds the template selector) is removed as well.
 *
 * @package wp-starter-tw
 */

const DS_MAIN_TEMPLATE = 'page-templates/main-template.php';

/**
 * Returns the post types the Main Template is available for.
 *
 * @return string[] List of post type names.
 */
function ds_main_template_post_types() {
	static $post_types = null;

	if( null !== $post_types ) return $post_types;

	$post_types = array();

	foreach( get_post_types(array('show_ui' => true)) as $post_type ) {
		$templates = wp_get_theme()->get_page_templates(null, $post_type);

		if( isset($templates[DS_MAIN_TEMPLATE]) ) {
			$post_types[] = $post_type;
		}
	}

	return $post_types;
}

/**
 * Assigns the Main Template to posts that carry no template of their own.
 *
 * Runs after core has written `_wp_page_template`, so it also catches a
 * "Default template" selection made through Quick Edit.
 *
 * @param int     $post_id The post ID.
 * @param WP_Post $post    The post object.
 * @return void
 */
function ds_force_main_template($post_id, $post) {
	if( !in_array($post->post_type, ds_main_template_post_types(), true) ) return;

	$template = get_post_meta($post_id, '_wp_page_template', true);

	if( $template && 'default' !== $template ) return;

	update_post_meta($post_id, '_wp_page_template', DS_MAIN_TEMPLATE);
}
add_action('wp_insert_post', 'ds_force_main_template', 10, 2);

/**
 * Removes the Page Attributes meta box and its template selector.
 *
 * @return void
 */
function ds_remove_page_attributes_meta_box() {
	foreach( ds_main_template_post_types() as $post_type ) {
		remove_meta_box('pageparentdiv', $post_type, 'side');
	}
}
add_action('add_meta_boxes', 'ds_remove_page_attributes_meta_box', 20);
