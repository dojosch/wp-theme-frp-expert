<?php
/**
 * ACF Fields Configuration Loader
 *
 * This file ensures that Advanced Custom Fields (ACF) local field groups and configurations
 * are properly loaded into the theme. It checks for the existence of the `acf_add_local_field_group`
 * function before including the necessary ACF configuration files.
 *
 * Included Files:
 * - Custom Post Types (CPT) fields: Handles ACF fields for custom post types.
 * - Elements fields: Manages ACF fields for reusable elements.
 * - Theme Options: Defines ACF fields for theme-wide options.
 * - Blog Template: Configures ACF fields for the blog template.
 * - Blog Single Template: Configures ACF fields for the single blog post template.
 *
 * @package wp-starter-tw
 */

if( !function_exists('acf_add_local_field_group') ) return;

// Include specific files
require_once get_template_directory() . '/config/acf-fields/elements/elements.php';
require_once get_template_directory() . '/config/acf-fields/blog.php';
require_once get_template_directory() . '/config/acf-fields/blog-single.php';

// Auto-load all PHP files in specific subfolders
foreach( ['cpt', 'theme_options'] as $subfolder ) {
	foreach( glob(get_template_directory() . "/config/acf-fields/$subfolder/*.php") as $file ) {
		require_once $file;
	}
}