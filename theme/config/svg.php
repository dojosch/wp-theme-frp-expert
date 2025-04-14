<?php
/**
 * Enables support for uploading SVG files in WordPress.
 *
 * This file contains a function to add the MIME type for SVG files
 * to the list of allowed upload types in WordPress.
 *
 * @package wp-starter-tw
 */

/**
 * Adds SVG MIME type to the list of allowed upload types.
 *
 * This function modifies the MIME types array to include support for
 * SVG files, enabling users to upload SVG images through the WordPress
 * media uploader.
 *
 * @param array $mimes Existing MIME types.
 * @return array Modified MIME types with SVG support added.
 */
function cc_mime_types( $mimes ) {
	$mimes['svg'] = 'image/svg+xml';
	return $mimes;
}
add_filter( 'upload_mimes', 'cc_mime_types' );
