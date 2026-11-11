<?php


/**
 * Returns an ACF field array for a relationship field.
 *
 * @param string   $key        The unique key for the field.
 * @param string   $label      The label for the field.
 * @param string[] $post_types Optional. Post types to choose from. Default is all.
 * @param array    $args       Optional. Additional arguments to customize the field.
 *                             These will override the default settings.
 *
 * @return array|null The ACF field array for the relationship field, or null on error.
 */
function ds_relationship_field($key, $label, $post_types = [], $args = []) {
    if( empty($key) ) {
        error_log('ds_relationship_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'relationship',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'post_type' => $post_types,
        'post_status' => array('publish'),
        'taxonomy' => '',
        'filters' => array('search'),
        'return_format' => 'id',
        'min' => '',
        'max' => '',
        'elements' => '',
    );

    return wp_parse_args($args, $defaults);
}
