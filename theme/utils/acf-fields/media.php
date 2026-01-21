<?php

/**
 * Defines a media field group with options for image or video.
 *
 * @param string $key   The unique key for the field.
 * @param string $label The label for the field.
 * @param array  $args  Optional. Additional arguments to customize the group field.
 *                      These will override the default group settings.
 *
 * @return array The ACF field group array for media selection.
 */
function ds_media_field($key, $label, $args=[]) {
    if( empty($key)) {
        error_log('ds_media_field: key parameter is required');
        return null;
    }

    $select_field = array(
        'key' => $key . '_type',
        'label' => 'Type',
        'name' => 'type',
        'type' => 'select',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => 0,
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'choices' => array(
            'image' => 'Image',
            'video' => 'Video'
        ),
        'default_value' => 'image',
        'allow_null' => 0,
        'multiple' => 0,
        'ui' => 0,
        'return_format' => 'value',
        'ajax' => 0,
        'placeholder' => '',
    );

    $image_field = array(
        'key' => $key . '_image',
        'label' => 'Image',
        'name' => 'image',
        'type' => 'image',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array(
            array(
                array(
                    'field' => $key . '_type',
                    'operator' => '==',
                    'value' => 'image',
                ),
            ),
        ),
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'return_format' => 'id',
        'preview_size' => 'medium',
        'library' => 'all',
        'min_width' => '',
        'min_height' => '',
        'min_size' => '',
        'max_width' => '',
        'max_height' => '',
        'max_size' => '',
        'mime_types' => '',
    );

    $video_field = array(
        'key' => $key . '_video',
        'label' => 'Video',
        'name' => 'video',
        'type' => 'file',
        'instructions' => '',
        'required' => 0,
        'conditional_logic' => array(
            array(
                array(
                    'field' => $key . '_type',
                    'operator' => '==',
                    'value' => 'video',
                ),
            ),
        ),
        'wrapper' => array(
            'width' => '',
            'class' => '',
            'id' => '',
        ),
        'return_format' => 'array',
        'library' => 'all',
        'min_size' => '',
        'max_size' => '',
        'mime_types' => 'mp4,webm',
    );

    $defaults_group = array(
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

    $group_field = wp_parse_args($args, $defaults_group);
    $group_field['sub_fields'] = array(
        $select_field,
        $image_field,
        $video_field,
    );
    return $group_field;
}