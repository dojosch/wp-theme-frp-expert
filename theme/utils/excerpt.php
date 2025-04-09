<?php
/**
 * Excerpt truncation helper (by character count).
 */

function ds_get_excerpt( $limit = 100, $source = null, $post_id = null ) {
	$excerpt = $source === 'content'
		? get_the_content( null, false, $post_id )
		: get_the_excerpt( $post_id );

	$excerpt = preg_replace( '/\[.*?\]/', '', $excerpt );
	$excerpt = strip_shortcodes( $excerpt );
	$excerpt = strip_tags( $excerpt );

	if ( strlen( $excerpt ) > $limit ) {
		$excerpt = substr( $excerpt, 0, $limit );
		$excerpt = substr( $excerpt, 0, strrpos( $excerpt, ' ' ) );
		$excerpt = trim( preg_replace( '/\s+/', ' ', $excerpt ) );
		$excerpt = rtrim( $excerpt, ',' ) . ' ...';
	}

	return $excerpt;
}
