<?php
/**
 * Utility functions for handling post excerpts in the WordPress theme.
 *
 * This file contains helper functions to process and retrieve excerpts
 * from post content or excerpt fields, ensuring proper formatting and
 * character limits.
 *
 * @package WordPress
 * @subpackage WP_Starter_TW
 * @since 1.0.0
 */

/**
 * Retrieves an excerpt from a post's content or excerpt field with a specified character limit.
 *
 * This function allows you to extract a portion of a post's content or excerpt,
 * clean it from shortcodes and HTML tags, and limit its length to a specified
 * number of characters. If the content exceeds the limit, it trims the excerpt
 * to the nearest word boundary and appends an ellipsis ("...").
 *
 * @param int         $limit   The maximum number of characters for the excerpt. Default is 100.
 * @param string|null $source  The source of the excerpt. Accepts 'content' for post content or null for the post excerpt. Default is null.
 * @param int|null    $post_id The ID of the post to retrieve the excerpt from. Default is null (current post).
 *
 * @return string The processed excerpt with the specified character limit.
 */
function ds_get_excerpt($limit = 100, $source = null, $post_id = null) {
	$excerpt = 'content' === $source
		? get_the_content(null, false, $post_id)
		: get_the_excerpt($post_id);

	$excerpt = preg_replace('/\[.*?\]/', '', $excerpt);
	$excerpt = strip_shortcodes($excerpt);
	$excerpt = wp_strip_all_tags($excerpt);

	if( $limit < strlen($excerpt) ) {
		$excerpt = substr($excerpt, 0, $limit);
		$excerpt = substr($excerpt, 0, strrpos($excerpt, ' '));
		$excerpt = trim(preg_replace('/\s+/', ' ', $excerpt));
		$excerpt = rtrim($excerpt, ',') . ' ...';
	}

	return $excerpt;
}
