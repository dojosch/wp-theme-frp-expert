<?php


/**
 * Returns an ACF field array for a true/false toggle field.
 *
 * @param string $key   The unique key for the field.
 * @param string $label The label for the field.
 * @param array  $args  Optional. Additional arguments to customize the field.
 *                      These will override the default settings.
 *
 * @return array|null The ACF field array for the toggle field, or null on error.
 */
function ds_toggle_field($key, $label, $args = []) {
    if( empty($key) ) {
        error_log('ds_toggle_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'true_false',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'message' => '',
        'default_value' => 0,
        'ui' => 1,
        'ui_on_text' => '',
        'ui_off_text' => '',
    );

    return wp_parse_args($args, $defaults);
}
