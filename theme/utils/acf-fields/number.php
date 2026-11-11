<?php


/**
 * Returns an ACF field array for a number field.
 *
 * @param string $key   The unique key for the field.
 * @param string $label The label for the field.
 * @param array  $args  Optional. Additional arguments to customize the field.
 *                      These will override the default settings.
 *
 * @return array|null The ACF field array for the number field, or null on error.
 */
function ds_number_field($key, $label, $args = []) {
    if( empty($key) ) {
        error_log('ds_number_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'number',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'min' => '',
        'max' => '',
        'step' => '',
    );

    return wp_parse_args($args, $defaults);
}
