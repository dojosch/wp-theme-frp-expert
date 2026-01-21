<?php
/**
 * Cleanup WordPress frontend and backend bloat.
 * Recommended for lean, modern themes without legacy WP features.
 *
 * @package wp-starter-tw
 */

/**
 * Disables the use of emojis in WordPress.
 *
 * This function removes actions and filters related to emoji support,
 * which can help improve performance and reduce unnecessary scripts
 * and styles being loaded on the site.
 *
 * @return void
 */
function ds_disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'ds_disable_emojis_tinymce' );
	add_filter( 'emoji_svg_url', '__return_false' );
}
add_action( 'init', 'ds_disable_emojis' );

/**
 * Disables the TinyMCE plugin for emojis in WordPress.
 *
 * This function removes the emoji plugin from the list of TinyMCE plugins,
 * effectively disabling emoji support in the WordPress editor.
 *
 * @param array $plugins An array of TinyMCE plugins.
 * @return array The modified array of TinyMCE plugins without the emoji plugin.
 */
function ds_disable_emojis_tinymce( $plugins ) {
	return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}

/**
 * Disables pingback headers in HTTP responses.
 *
 * This function modifies the headers to remove any references to pingbacks,
 * XML-RPC, and related functionalities, enhancing security and reducing
 * unnecessary overhead.
 *
 * @param array $headers The current array of HTTP headers.
 * @return array The modified array of HTTP headers.
 */
function ds_disable_pingback_headers( $headers ) {
	unset( $headers['X-Pingback'] );
	return $headers;
}
add_filter( 'wp_headers', 'ds_disable_pingback_headers' );
add_filter( 'xmlrpc_enabled', '__return_false' );

/**
 * Cleans up unnecessary elements from the WordPress head section.
 *
 * This function is intended to remove default WordPress metadata and links
 * that are added to the <head> section of the site, which may not be needed
 * for most themes or custom implementations.
 *
 * @return void
 */
function ds_cleanup_wp_head() {
	remove_action( 'wp_head', 'rsd_link' ); // Really Simple Discovery
	remove_action( 'wp_head', 'wlwmanifest_link' ); // Windows Live Writer support
	remove_action( 'wp_head', 'wp_generator' ); // WordPress version
	remove_action( 'wp_head', 'wp_shortlink_wp_head' ); // Shortlink
	remove_action( 'wp_head', 'feed_links', 2 ); // Feed links
	remove_action( 'wp_head', 'feed_links_extra', 3 ); // Comment feed
	remove_action( 'wp_head', 'rest_output_link_wp_head' ); // REST API link
	remove_action( 'wp_head', 'wp_oembed_add_discovery_links' ); // oEmbed
	remove_action( 'wp_head', 'wp_oembed_add_host_js' );
}
add_action( 'init', 'ds_cleanup_wp_head' );

/**
 * Removes the default block library CSS from being enqueued.
 *
 * This function is typically used to prevent WordPress from loading
 * the block library CSS file on the front end, which can help reduce
 * unnecessary styles and improve performance.
 *
 * @return void
 */
function ds_remove_block_library_css() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'ds_remove_block_library_css', 100 );

/**
 * Dequeues the Dashicons stylesheet for non-logged-in users (guests).
 *
 * This function is used to optimize the frontend performance by preventing
 * the unnecessary loading of the Dashicons stylesheet for users who are not
 * logged into the WordPress admin area.
 *
 * @return void
 */
function ds_dequeue_dashicons_for_guests() {
	if ( ! is_user_logged_in() ) {
		wp_dequeue_style( 'dashicons' );
	}
}
add_action( 'wp_enqueue_scripts', 'ds_dequeue_dashicons_for_guests' );

/**
 * Dequeues the Font Awesome stylesheet from being loaded in WordPress.
 *
 * This function is used to remove the Font Awesome CSS file from the
 * WordPress front-end to optimize performance or avoid conflicts with
 * other stylesheets.
 *
 * @return void
 */
function ds_dequeue_font_awesome() {
	wp_dequeue_style( 'fontawesome5' );
	wp_deregister_style( 'fontawesome5' );
}
add_action( 'wp_print_styles', 'ds_dequeue_font_awesome' );

add_filter( 'use_block_editor_for_post_type', '__return_false', 10 );

/**
 * Removes the block library CSS from being enqueued in WordPress.
 *
 * This function is typically used to prevent the default block editor styles
 * from being loaded on the front end, which can help reduce unnecessary CSS
 * and improve page performance.
 *
 * @return void
 */
function remove_block_library_css() {
	wp_dequeue_style( 'wp-block-library' );
	wp_dequeue_style( 'wp-block-library-theme' );
	wp_dequeue_style( 'wc-block-style' ); // if you're using WooCommerce
}
add_action( 'wp_enqueue_scripts', 'remove_block_library_css', 100 );

/**
 * Removes Contact Form 7 and related plugin assets if not used on the page.
 *
 * This function scans the current post's content and ACF meta fields to detect
 * if Contact Form 7 shortcodes are present. If not found, it dequeues and deregisters
 * CSS and JavaScript files from Contact Form 7 and related plugins to improve
 * performance by preventing unnecessary asset loading.
 *
 * Scans the following plugin folders:
 * - contact-form-7
 * - honeypot
 * - wpcf7-redirect
 * - cf7-conditional-fields
 *
 * @return void
 */
function remove_unused_cf7_assets() {
    global $post;

    // --- CONFIGURATION ---
    $plugins_to_unload = [
        '/contact-form-7/',
        '/honeypot/',
        '/wpcf7-redirect/',
        '/cf7-conditional-fields/'
    ];

    // Safety check
    if ( ! isset( $post ) || ! is_a( $post, 'WP_Post' ) ) {
        return;
    }

    // CHECK 1: Standard Content (Classic Editor / Gutenberg)
    if ( strpos( $post->post_content, 'contact-form-7' ) !== false ) {
        return; // Found in main content
    }

    // CHECK 2: ACF / Flexible Content (Scans Database Fields)
    // We get all meta data for this page and check if the shortcode string exists anywhere.
    $all_meta = get_post_meta( $post->ID );
    // Convert all fields to a single string for easy searching
    $meta_string = json_encode( $all_meta );

    if ( strpos( $meta_string, 'contact-form-7' ) !== false ) {
        return; // Found in ACF fields!
    }

    // --- UNLOADER ---
    // If we reach here, the form is NOT on the page. Unload the files.
    $dequeue_assets_by_folder = function( $type ) use ( $plugins_to_unload ) {
        global $wp_styles, $wp_scripts;
        $registry = ( $type === 'style' ) ? $wp_styles : $wp_scripts;
        
        if ( empty( $registry->queue ) ) return;

        foreach ( $registry->queue as $handle ) {
            if ( ! isset( $registry->registered[ $handle ] ) ) continue;
            
            $src = $registry->registered[ $handle ]->src;

            foreach ( $plugins_to_unload as $plugin_folder ) {
                if ( strpos( $src, $plugin_folder ) !== false ) {
                    if ( $type === 'style' ) {
                        wp_dequeue_style( $handle );
                        wp_deregister_style( $handle );
                    } else {
                        wp_dequeue_script( $handle );
                        wp_deregister_script( $handle );
                    }
                    break; 
                }
            }
        }
    };

    $dequeue_assets_by_folder( 'style' );
    $dequeue_assets_by_folder( 'script' );
}
add_action( 'wp_enqueue_scripts', 'remove_unused_cf7_assets', 100 );