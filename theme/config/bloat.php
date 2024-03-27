<?php
add_filter( 'emoji_svg_url', '__return_false' );
add_filter( 'wp_headers', 'disable_x_pingback' );

// Really Simple Discovery link
remove_action( 'wp_head', 'rsd_link' );

// Windows Live Writer link
remove_action( 'wp_head', 'wlwmanifest_link' );

// Meta name generator
remove_action( 'wp_head', 'wp_generator' );

// Shortlink
remove_action( 'wp_head', 'wp_shortlink_wp_head' );

// Feed Links
remove_action( 'wp_head', 'feed_links', 2 );

//Comment Feed
remove_action( 'wp_head', 'feed_links_extra', 3 );

// xmlrpc
function disable_x_pingback( $headers ) {
  unset( $headers['XPingback'] );
  return $headers;
}
add_filter( 'xmlrpc_enabled', '__return_false' );

// Gutenberg
function remove_wp_block_library_css(){
  wp_dequeue_style( 'wp-block-library' );
  wp_dequeue_style( 'wp-block-library-theme' );
}
add_action( 'wp_enqueue_scripts', 'remove_wp_block_library_css', 100 );

// Emoji's
function disable_emojis_tinymce( $plugins ) {
	if ( is_array( $plugins ) ) {
		return array_diff( $plugins, array( 'wpemoji' ) );
	} else {
		return array();
	}
}

function disable_emojis() {
	remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
	remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
	remove_action( 'wp_print_styles', 'print_emoji_styles' );
	remove_action( 'admin_print_styles', 'print_emoji_styles' );
	remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
	remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );
	remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
	add_filter( 'tiny_mce_plugins', 'disable_emojis_tinymce' );
}
add_action( 'init', 'disable_emojis' );

// fa
//* Remove Font Awesome from WordPress theme
add_action( 'wp_print_styles', 'dequeue_font_awesome_style' );
function dequeue_font_awesome_style() {
  wp_dequeue_style( 'fontawesome5' );
  wp_deregister_style( 'fontawesome5' );
}