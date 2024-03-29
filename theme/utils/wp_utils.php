<?php

function get_theme_image_url($path) {
  return get_stylesheet_directory_uri() . "/images" . "/" . $path;
}

function get_theme_icon_url($path) {
  return get_stylesheet_directory_uri() . "/images/icons" . "/" . $path;
}

function get_template_url($path) {
  return get_stylesheet_directory_uri() . "/page-temmplates" . "/" . $path;
}

function is_blog_archive () {
  return ( is_archive() || is_category() || is_home() || is_tag()) && 'post' == get_post_type();
}

function create_unique_css_id () {
	// Prefix is required - ids must not start with digits, uniqid does not guarantee this
	return 'ds_' . uniqid();
}
