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

/**
 * Convert a human-readable label to a machine-readable field name
 * 
 * @param string $label The label to convert (e.g., "Hero Heading")
 * @return string The converted field name (e.g., "hero_heading")
 */
function ds_parse_label_to_name($label) {
    // Convert to lowercase
    $name = strtolower($label);
    
    // Replace spaces and dashes with underscores
    $name = str_replace([' ', '-'], '_', $name);
    
    // Remove special characters (keep only alphanumeric and underscores)
    $name = preg_replace('/[^a-z0-9_]/', '', $name);
    
    // Remove multiple consecutive underscores
    $name = preg_replace('/_+/', '_', $name);
    
    // Trim underscores from start and end
    $name = trim($name, '_');
    
    return $name;
}
/**
 * Returns the post types the main page template can be assigned to.
 *
 * Reads the "Template Post Type" header of page-templates/main-template.php and
 * always includes the 'page' post type, so field groups can stay in sync with
 * the template without maintaining a second, hard-coded list.
 *
 * @return array List of post type keys.
 */
function ds_get_main_template_post_types() {
    static $post_types = null;

    if ( null !== $post_types ) {
        return $post_types;
    }

    $post_types = array( 'page' );
    $file       = get_template_directory() . '/page-templates/main-template.php';

    if ( file_exists( $file ) ) {
        $data = get_file_data( $file, array( 'post_type' => 'Template Post Type' ) );

        foreach ( explode( ',', (string) $data['post_type'] ) as $post_type ) {
            $post_type = trim( $post_type );

            if ( '' !== $post_type ) {
                $post_types[] = $post_type;
            }
        }
    }

    $post_types = array_values( array_unique( $post_types ) );

    return $post_types;
}
