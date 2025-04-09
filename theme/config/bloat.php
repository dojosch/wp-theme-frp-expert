<?php
/**
 * Cleanup WordPress frontend and backend bloat.
 * Recommended for lean, modern themes without legacy WP features.
 */

// -----------------------------
// Disable Emojis (scripts + styles + TinyMCE plugin)
// -----------------------------
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

function ds_disable_emojis_tinymce( $plugins ) {
    return is_array( $plugins ) ? array_diff( $plugins, array( 'wpemoji' ) ) : array();
}

// -----------------------------
// Disable Pingbacks, XML-RPC, and Related Headers
// -----------------------------
function ds_disable_pingback_headers( $headers ) {
    unset( $headers['X-Pingback'] );
    return $headers;
}
add_filter( 'wp_headers', 'ds_disable_pingback_headers' );
add_filter( 'xmlrpc_enabled', '__return_false' );

// -----------------------------
// Remove wp_head Output: Meta junk, feed links, etc.
// -----------------------------
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

// -----------------------------
// Remove Gutenberg block styles (if not using Block Editor)
// -----------------------------
function ds_remove_block_library_css() {
    wp_dequeue_style( 'wp-block-library' );
    wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'ds_remove_block_library_css', 100 );

// -----------------------------
// Remove Dashicons for non-logged-in users
// -----------------------------
function ds_dequeue_dashicons_for_guests() {
    if ( ! is_user_logged_in() ) {
        wp_dequeue_style( 'dashicons' );
    }
}
add_action( 'wp_enqueue_scripts', 'ds_dequeue_dashicons_for_guests' );

// -----------------------------
// Remove Font Awesome (if enqueued by a plugin/theme)
// -----------------------------
function ds_dequeue_font_awesome() {
    wp_dequeue_style( 'fontawesome5' );
    wp_deregister_style( 'fontawesome5' );
}
add_action( 'wp_print_styles', 'ds_dequeue_font_awesome' );

// -----------------------------
// Remove Block Editor Stuff
// -----------------------------
add_filter('use_block_editor_for_post_type', '__return_false', 10);

function remove_block_library_css() {
    wp_dequeue_style('wp-block-library');
    wp_dequeue_style('wp-block-library-theme');
    wp_dequeue_style('wc-block-style'); // if you're using WooCommerce
}
add_action('wp_enqueue_scripts', 'remove_block_library_css', 100);