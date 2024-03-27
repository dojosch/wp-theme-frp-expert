<?php

// All Functions Require
// Field Type: "Image"
// Return Format "Image ID"
function get_image_data_from_field($field_name, $size = "large") {
  $field_value = get_field($field_name);
  // Return early if no image
  if(!$field_value) {return null; }
  // Return Image Array otherwise
  $src = wp_get_attachment_image_src($field_value, $size)[0];
  $alt = get_post_meta( $field_value, '_wp_attachment_image_alt', true);
  return ['src' => $src, 'alt' => $alt];
}

function get_image_data_from_sub_field($field_name, $size = "large") {
  $field_value = get_sub_field($field_name);
  // Return early if no image
  if(!$field_value) {return null; }
  // Return Image Array otherwise
  $src = wp_get_attachment_image_src($field_value, $size)[0];
  $alt = get_post_meta( $field_value, '_wp_attachment_image_alt', true);
  return ['src' => $src, 'alt' => $alt];
}

function get_image_data_from_option_field($field_name, $size = "large") {
  $field_value = get_field($field_name, "option");
  // Return early if no image
  if(!$field_value) {return null; }
  // Return Image Array otherwise
  $src = wp_get_attachment_image_src($field_value, $size)[0];
  $alt = get_post_meta( $field_value, '_wp_attachment_image_alt', true);
  return ['src' => $src, 'alt' => $alt];
}

function get_image_data($attachment_id, $size = "large") {
  $data = wp_get_attachment_image_src($attachment_id, $size);
	$src = $data[0];
  // Return early if no image
  if(!$src) {return null; }
  // Return Image Array otherwise
  $alt = get_post_meta( $attachment_id, '_wp_attachment_image_alt', true);
  return ['src' => $src, 'alt' => $alt, 'width' => $data[1], 'height' => $data[2]];
}