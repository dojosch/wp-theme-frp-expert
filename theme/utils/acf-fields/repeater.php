<?php


/**
 * Returns an ACF field array for a repeater field.
 *
 * @param string $key        The unique key for the field.
 * @param string $label      The label for the field.
 * @param array  $sub_fields The sub fields belonging to the repeater rows.
 * @param string $button_label Optional. The label of the "add row" button. Default is 'Add Row'.
 * @param array  $args       Optional. Additional arguments to customize the field.
 *                           These will override the default settings.
 *
 * @return array|null The ACF field array for the repeater field, or null on error.
 */
function ds_repeater_field($key, $label, $sub_fields = [], $button_label = 'Add Row', $args = []) {
    if( empty($key) ) {
        error_log('ds_repeater_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'repeater',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'layout' => 'block',
        'button_label' => $button_label,
        'min' => 0,
        'max' => 0,
        'collapsed' => '',
    );

    $repeater_field = wp_parse_args($args, $defaults);
    $repeater_field['sub_fields'] = $sub_fields;

    return $repeater_field;
}
