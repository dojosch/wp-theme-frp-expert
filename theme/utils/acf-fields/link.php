<?php

/**
 * Creates an ACF link field configuration array.
 *
 * @param string $key   The unique key for the field.
 * @param string $label The label for the field.
 * @param array  $args  Additional arguments to customize the field.
 *
 * @return array The ACF link field configuration array.
 */
function ds_link_field($key, $label, $args = []) {
    if(empty($key)) {
        error_log('ds_link_field: key parameter is required');
        return null;
    }

    $link_field = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'link',
        'instructions' => '',
        'required' => 0,
        'return_format' => 'array',
    );

    return wp_parse_args($args, $link_field);
}