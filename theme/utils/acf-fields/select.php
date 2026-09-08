<?php


/**
 * Returns an ACF field array for a select field.
 *
 * @param string $key           The unique key for the field.
 * @param string $label         The label for the field.
 * @param array  $choices       The selectable choices as 'value' => 'Label' pairs.
 * @param string $default_value Optional. The preselected choice value. Default is empty.
 * @param array  $args          Optional. Additional arguments to customize the field.
 *                              These will override the default settings.
 *
 * @return array|null The ACF field array for the select field, or null on error.
 */
function ds_select_field($key, $label, $choices = [], $default_value = '', $args = []) {
    if( empty($key) ) {
        error_log('ds_select_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => $choices,
        'default_value' => $default_value,
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'value',
        'ajax' => 0,
        'placeholder' => '',
    );

    return wp_parse_args($args, $defaults);
}
