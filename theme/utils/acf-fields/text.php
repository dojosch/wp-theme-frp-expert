<?php


/**
 * Returns an ACF field array for a text field.
 *
 * @param string $key   The unique key for the field.
 * @param string $label The label for the field.
 * @param array  $args  Optional. Additional arguments to customize the field.
 *                      These will override the default settings.
 *
 * @return array|null The ACF field array for the text field, or null on error.
 */
function ds_text_field($key, $label, $args = []) {
    if( empty($key) ) {
        error_log('ds_text_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'text',
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
        'maxlength' => '',
    );

    return wp_parse_args($args, $defaults);
}

/**
 * Returns an ACF field array for a textarea field.
 *
 * @param string  $key   The unique key for the field.
 * @param string  $label The label for the field.
 * @param integer $rows  Optional. The number of rows for the textarea. Default is 4.
 * @param array   $args  Optional. Additional arguments to customize the field.
 *                       These will override the default settings.
 *
 * @return array|null The ACF field array for the textarea field, or null on error.
 */
function ds_textarea_field($key, $label, $rows = 4, $args = []) {
    if( empty($key) ) {
        error_log('ds_textarea_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'textarea',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'new_lines' => 'br',
        'default_value' => '',
        'placeholder' => '',
        'maxlength' => '',
        'rows' => $rows,
    );

    return wp_parse_args($args, $defaults);
}

/**
 * Returns an ACF field array for a wysiwyg field.
 *
 * @param string  $key          The unique key for the field.
 * @param string  $label        The label for the field.
 * @param string  $toolbar      Optional. The toolbar configuration. Default is 'basic'.
 * @param boolean $media_upload Optional. Whether to allow media uploads. Default is false.
 * @param array   $args         Optional. Additional arguments to customize the field.
 *                              These will override the default settings.
 *
 * @return array|null The ACF field array for the wysiwyg field, or null on error.
 */
function ds_wysiwyg_field($key, $label, $toolbar = 'basic', $media_upload = 0, $args = []) {
    if( empty($key) ) {
        error_log('ds_wysiwyg_field: key parameter is required');
        return null;
    }

    $defaults = array(
        'key' => $key,
        'label' => $label,
        'name' => ds_parse_label_to_name($label),
        'type' => 'wysiwyg',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'default_value' => '',
        'tabs' => 'all',
        'toolbar' => $toolbar,
        'media_upload' => $media_upload,
        'delay' => 0,
    );

    return wp_parse_args($args, $defaults);
}
