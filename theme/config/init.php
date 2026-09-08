<?php
/**
 * Theme Initialization Configuration
 *
 * This file contains the initialization logic for the WordPress theme.
 * It sets up default options, configures timezone and language settings,
 * and modifies discussion and admin bar behavior.
 *
 * @package wp-starter-tw
 */

add_action(
	'after_switch_theme',
	function () {
		// Discourage search engines
		update_option('blog_public', '0');

		// Set timezone to Vienna
		update_option('timezone_string', 'Europe/Vienna');

		// Default post settings
		update_option('default_pingback_flag', 0); // Attempt to notify blogs
		update_option('default_ping_status', 'closed'); // Allow pingbacks
		update_option('default_comment_status', 'closed'); // Allow comments

		// Discussion settings
		update_option('comment_registration', 1); // Must be logged in
		update_option('comments_notify', 0); // Notify on comment
		update_option('comment_moderation', 0); // Hold for moderation
		update_option('show_avatars', 0); // Show avatars

		update_option('_ds_pending_language_setup', true);
	}
);

// Run this later, when WP is fully loaded and admin context is available
add_action(
	'admin_init',
	function () {
		if( !is_admin() ) return;

		if( get_option('_ds_pending_language_setup') ) {
			delete_option('_ds_pending_language_setup');

			$locale = 'de_DE';

			require_once ABSPATH . 'wp-admin/includes/translation-install.php';
			if( !in_array($locale, get_available_languages(), true) ) {
				wp_download_language_pack($locale);
			}

			update_option('WPLANG', $locale);

			// Redirect to apply language and avoid double action
			wp_safe_redirect(admin_url());
			exit;
		}
	}
);

add_filter('show_admin_bar', '__return_false');
