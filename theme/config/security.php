<?php 

// Hide login errors
add_filter('login_errors', 'ds_hide_login_errors');
function ds_hide_login_errors() {
	// We’ll handle our own messages if needed
	return 'Login-Daten stimmen nicht überein';
}

// Disable XML-RPC
add_filter('xmlrpc_enabled', '__return_false');

// Hide WP version
remove_action('wp_head', 'wp_generator');
add_filter('the_generator', '__return_empty_string');
add_filter('style_loader_src', 'ds_remove_wp_version_param', 9999);
add_filter('script_loader_src', 'ds_remove_wp_version_param', 9999);
function ds_remove_wp_version_param($src) {
	return remove_query_arg('ver', $src);
}
