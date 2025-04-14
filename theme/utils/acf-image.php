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
 * Always returns either a full associative array with 'src', 'alt', 'width', and 'height', or null.
 *
 * @param int    $attachment_id The attachment ID of the image.
 * @param string $size          The size of the image to retrieve. Default is 'large'.
 * @return array|null           Image data or null if not found or invalid.
 */
function ds_get_image_data_from_id( $attachment_id, $size = 'large' ) {
	if ( ! is_numeric( $attachment_id ) || intval( $attachment_id ) <= 0 ) {
		return null;
	}

	$data = wp_get_attachment_image_src( intval( $attachment_id ), $size );

	if ( ! is_array( $data ) || empty( $data[0] ) ) {
		return null;
	}

	return array(
		'src'    => esc_url( $data[0] ),
		'alt'    => esc_attr( get_post_meta( $attachment_id, '_wp_attachment_image_alt', true ) ),
		'width'  => isset( $data[1] ) ? (int) $data[1] : null,
		'height' => isset( $data[2] ) ? (int) $data[2] : null,
	);
}
