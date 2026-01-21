<?php


/**
 * Returns an ACF field array for a heading with selectable tag.
 *
 * @param string $key   The unique key for the field.
 * @param string $label The label for the field.
 * @param array  $args  Optional. Additional arguments to customize the group field.
 *                      These will override the default group settings.
 *
 * @return array|null The ACF field array for the heading group, or null on error.
 */
function ds_heading_field($key, $label, $args = []) {
    if (empty($key)) {
        error_log('ds_heading_field: key parameter is required');
        return null;
    }

    $heading_field = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'text',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '80',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
        'placeholder' => '',
        'prepend' => '',
        'append' => '',
        'maxlength' => '',
    );
    
    $heading_tag_field = array(
        'key' => $key . '_tag',
        'label' => $label . ' Tag',
        'name' => ds_parse_label_to_name($label) . '_tag',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '20',
            'class' => '',
            'id' => '',
        ),
        'choices' => array(
            'h1' => 'h1',
            'h2' => 'h2',
            'h3' => 'h3',
            'h4' => 'h4',
            'h5' => 'h5',
            'h6' => 'h6',
            'span' => 'Text',
        ),
        'default_value' => 'h2',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'ajax' => 0,
        'return_format' => 'value',
        'placeholder' => '',
    );

    // Group defaults can be overridden via $args
    $defaults_group = array(
        'key' => $key . '_group',
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

    $group_field = wp_parse_args($args, $defaults_group);
    $group_field['sub_fields'] = array(
        $heading_field,
        $heading_tag_field,
    );

    return $group_field;
}