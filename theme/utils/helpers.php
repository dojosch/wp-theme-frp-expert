<?php
/**
 * General helpers for WordPress theme development.
 */

function ds_get_theme_asset_url( $path ) {
	return get_stylesheet_directory_uri() . '/assets/' . ltrim( $path, '/' );
}

function ds_get_theme_image_url( $path ) {
	return get_stylesheet_directory_uri() . '/assets/images/' . ltrim( $path, '/' );
}

function ds_get_theme_icon_url( $path ) {
	return get_stylesheet_directory_uri() . '/assets/images/icons/' . ltrim( $path, '/' );
}

function ds_get_template_url( $path ) {
	return get_stylesheet_directory_uri() . '/page-templates/' . ltrim( $path, '/' );
}

function ds_is_blog_archive() {
	return ( is_archive() || is_category() || is_home() || is_tag() ) && get_post_type() === 'post';
}

function ds_create_unique_css_id() {
	return 'ds_' . uniqid();
}
