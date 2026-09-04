<?php


/**
 * Returns an ACF field array for a group field.
 *
 * @param string $key        The unique key for the field.
 * @param string $label      The label for the field.
 * @param array  $sub_fields The sub fields belonging to the group.
 * @param array  $args       Optional. Additional arguments to customize the field.
 *                           These will override the default settings.
 *
 * @return array|null The ACF field array for the group field, or null on error.
 */
function ds_group_field($key, $label, $sub_fields = [], $args = []) {
    if (empty($key)) {
        error_log('ds_group_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'group',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'layout' => 'block',
    );

    $group_field = wp_parse_args($args, $defaults);
    $group_field['sub_fields'] = $sub_fields;

    return $group_field;
}
