<?php

/**
 * ACF Image Field
 *
 * @param string $key   The unique key for the field.
 * @param string $label The label for the field.
 * @param array  $args  Additional arguments to customize the field.
 *
 * @return array|null The ACF image field configuration or null on error.
 */
function ds_image_field($key, $label, $args = []) {
    if( empty($key) ) {
        error_log('ds_image_field: key parameter is required');
        return null;
    }
    
    $image_field = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'image',
        'return_format' => 'id',
        'preview_size' => 'medium',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
    );

    return wp_parse_args($args, $image_field);
}

/**
 * ACF Image Field with Cropping Enabled
 *
 * @param string $key   The unique key for the field.
 * @param string $label The label for the field.
 * @param int    $width The aspect ratio width.
 * @param int    $height The aspect ratio height.
 * @param array  $args  Additional arguments to customize the field.
 *
 * @return array|null The ACF image field configuration with cropping or null on error.
 */
function ds_image_crop_field($key, $label, $width=1, $height=1, $args = []) {
    if( empty($key) ) {
        error_log('ds_image_crop_field: key parameter is required');
        return null;
    }

    $image_crop_field = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'image_aspect_ratio_crop',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'aspect_ratio_width' => $width,
        'aspect_ratio_height' => $height,
        'return_format' => 'id',
        'preview_size' => 'medium',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
    );

    return wp_parse_args($args, $image_crop_field);
}

function ds_header_image_field($key, $label, $args = []) {
    if( empty($key) ) {
        error_log('ds_header_image_field: key parameter is required');
        return null;
    }
    
    $header_image_field = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'image',
        'return_format' => 'array',
        'preview_size' => 'medium',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
    );

    return wp_parse_args($args, $header_image_field);
}