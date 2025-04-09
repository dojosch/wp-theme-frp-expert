<?php
/**
 * Helpers to get ACF image data (requires return format = Image ID).
 */

function ds_get_image_data_from_field( $field_name, $size = 'large' ) {
	return ds_get_image_data_from_id( get_field( $field_name ), $size );
}

function ds_get_image_data_from_sub_field( $field_name, $size = 'large' ) {
	return ds_get_image_data_from_id( get_sub_field( $field_name ), $size );
}

function ds_get_image_data_from_option_field( $field_name, $size = 'large' ) {
	return ds_get_image_data_from_id( get_field( $field_name, 'option' ), $size );
}

function ds_get_image_data_from_id( $attachment_id, $size = 'large' ) {
	if ( ! $attachment_id ) {
		return null;
	}

	$data  = wp_get_attachment_image_src( $attachment_id, $size );
	$src   = $data[0] ?? '';
	$alt   = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true );
	$width = $data[1] ?? null;
	$height = $data[2] ?? null;

	if ( ! $src ) {
		return null;
	}

	return compact( 'src', 'alt', 'width', 'height' );
}
