<?php
/**
 * Security Configuration for WordPress Theme
 *
 * This file contains security-related configurations for the WordPress theme.
 * It includes functions to enhance security by hiding sensitive information,
 * disabling unnecessary features, and removing version parameters from assets.
 *
 * Features:
 * - Hides login error messages to prevent information disclosure.
 * - Disables XML-RPC to reduce attack surface.
 * - Removes WordPress version information from headers and asset URLs.
 *
 * @package wp-starter-tw
 */

// Hide login errors
add_filter( 'login_errors', 'ds_hide_login_errors' );

/**
 * Hides login error messages for security purposes.
 *
 * This function prevents WordPress from displaying detailed error messages
 * on the login screen, which could potentially reveal information to attackers.
 *
 * @return string
 */
function ds_hide_login_errors() {
	// We’ll handle our own messages if needed
	return 'Login-Daten stimmen nicht überein';
}

// Disable XML-RPC
add_filter( 'xmlrpc_enabled', '__return_false' );

// Hide WP version
remove_action( 'wp_head', 'wp_generator' );
add_filter( 'the_generator', '__return_empty_string' );
add_filter( 'style_loader_src', 'ds_remove_wp_version_param', 9999 );
add_filter( 'script_loader_src', 'ds_remove_wp_version_param', 9999 );

/**
 * Removes the WordPress version parameter from enqueued scripts and styles.
 *
 * This function is typically used to enhance security by preventing the WordPress
 * version from being exposed in the query strings of enqueued assets.
 *
 * @param string $src The source URL of the enqueued script or style.
 * @return string The modified source URL without the WordPress version parameter.
 */
function ds_remove_wp_version_param( $src ) {
	return remove_query_arg( 'ver', $src );
}
