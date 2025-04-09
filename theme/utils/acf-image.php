<?php
/**
 * Helpers to get ACF image data (requires return format = Image ID).
 *
 * @package wp-starter-tw
 */

/**
 * Get image data from an ACF field.
 *
 * @param string $field_name The name of the ACF field.
 * @param string $size       The size of the image to retrieve. Default is 'large'.
 * @return array|null        An associative array containing 'src', 'alt', 'width', and 'height', or null if not found.
 */
function ds_get_image_data_from_field( $field_name, $size = 'large' ) {
	$attachment_id = get_field( $field_name );
	return ds_get_image_data_from_id( $attachment_id, $size );
}

/**
 * Get image data from an ACF sub field.
 *
 * @param string $field_name The name of the ACF sub field.
 * @param string $size       The size of the image to retrieve. Default is 'large'.
 * @return array|null        An associative array containing 'src', 'alt', 'width', and 'height', or null if not found.
 */
function ds_get_image_data_from_sub_field( $field_name, $size = 'large' ) {
	$attachment_id = get_sub_field( $field_name );
	return ds_get_image_data_from_id( $attachment_id, $size );
}

/**
 * Get image data from an ACF option field.
 *
 * @param string $field_name The name of the ACF option field.
 * @param string $size       The size of the image to retrieve. Default is 'large'.
 * @return array|null        An associative array containing 'src', 'alt', 'width', and 'height', or null if not found.
 */
function ds_get_image_data_from_option_field( $field_name, $size = 'large' ) {
	$attachment_id = get_field( $field_name, 'option' );
	return ds_get_image_data_from_id( $attachment_id, $size );
}

/**
 * Get image data from an attachment ID.
 *
 * @param int    $attachment_id The attachment ID of the image.
 * @param string $size          The size of the image to retrieve. Default is 'large'.
 * @return array|null           An associative array containing 'src', 'alt', 'width', and 'height', or null if not found.
 */
function ds_get_image_data_from_id( $attachment_id, $size = 'large' ) {
	$data   = wp_get_attachment_image_src( $attachment_id, $size );
	$src    = $data[0] ?? '';
	$alt    = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
	$width  = $data[1] ?? null;
	$height = $data[2] ?? null;

	if ( ! $src ) {
		return null;
	}

	return compact( 'src', 'alt', 'width', 'height' );
}
