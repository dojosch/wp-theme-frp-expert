<?php


/**
 * Returns an ACF field array for an accordion field.
 *
 * @param string $key   The unique key for the field.
 * @param string $label The label for the field.
 * @param array  $args  Optional. Additional arguments to customize the field.
 *                      These will override the default settings.
 *
 * @return array|null The ACF field array for the accordion field, or null on error.
 */
function ds_accordion_field($key, $label, $args = []) {
    if( empty($key) ) {
        error_log('ds_accordion_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => '',
        'type' => 'accordion',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'open' => 0,
        'multi_expand' => 0,
        'endpoint' => 0,
    );

    return wp_parse_args($args, $defaults);
}
