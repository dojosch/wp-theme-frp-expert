<?php
/**
 * Helpers.php
 *
 * This file contains general helper functions for WordPress theme development.
 *
 * @package WordPress
 * @subpackage WP_Starter_TW
 * @since 1.0.0
 */

/**
 * Retrieves the URL of a theme asset.
 *
 * This function generates the full URL for a given asset path within the theme.
 *
 * @param string $path The relative path to the asset within the theme directory.
 * @return string The full URL to the specified asset.
 */
function ds_get_theme_asset_url( $path ) {
	return get_stylesheet_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

/**
 * Retrieves the URL of a theme image based on the provided path.
 *
 * @param string $path The relative path to the image within the theme directory.
 * @return string The full URL to the image.
 */
function ds_get_theme_image_url( $path ) {
	return get_stylesheet_directory_uri() . '/assets/images/' . ltrim( $path, '/' );
}

/**
 * Retrieves the URL for a theme icon based on the provided path.
 *
 * @param string $path The relative path to the icon within the theme directory.
 * @return string The full URL to the theme icon.
 */
function ds_get_theme_icon_url( $path ) {
	return get_stylesheet_directory_uri() . '/assets/images/icons/' . ltrim( $path, '/' );
}

/**
 * Retrieves the URL for a theme icon based on the provided path.
 *
 * @param string $path The relative path to the icon within the theme directory.
 * @return string The full URL to the theme icon.
 */
function ds_get_theme_logo_url( $path ) {
	return get_stylesheet_directory_uri() . '/assets/images/logos/' . ltrim( $path, '/' );
}

/**
 * Retrieves the URL of a template file within the theme.
 *
 * @param string $path The relative path to the template file within the theme directory.
 * @return string The full URL to the specified template file.
 */
function ds_get_template_url( $path ) {
	return get_stylesheet_directory_uri() . '/page-templates/' . ltrim( $path, '/' );
}

/**
 * Checks if the current page is a blog archive.
 *
 * @return bool True if the current page is a blog archive, false otherwise.
 */
function ds_is_blog_archive() {
	return ( is_archive() || is_category() || is_home() || is_tag() ) && get_post_type() === 'post';
}

/**
 * Generates a unique CSS ID.
 *
 * This function creates a unique identifier that can be used as a CSS ID
 * to ensure there are no conflicts with other elements on the page.
 *
 * @return string A unique CSS ID.
 */
function ds_create_unique_css_id() {
	return 'ds_' . uniqid();
}

/**
 * Logs PHP data to the browser's developer console.
 *
 * @param mixed  $data     The data to log (string, array, object, etc).
 * @param string $context  Optional. A context label to prefix the log. Default is 'Debug'.
 */
function ds_console_log( $data, $context = 'Debug' ) {
	if ( is_array( $data) || is_object( $data ) ) {
		$data = json_encode( $data, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE );
	} else {
		$data = json_encode( (string) $data );
	}

	echo "<script>console.log('[{$context}]', {$data});</script>";
}

