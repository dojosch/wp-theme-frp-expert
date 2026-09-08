<?php

$two_col = array(
    'key' => 'layout_2aab98031c724a',
    'label' => 'Two Col',
    'name' => 'two_col',
    'display' => 'block',
    'sub_fields' => array(
        ds_image_crop_field('field_25c48244a7c648', 'Image', 630, 391),
        ds_select_field('field_039188376f6cd6', 'Image Position', [
            'left' => 'Left',
            'right' => 'Right'
        ], 'left'),
        ds_heading_field('field_0d9895065c91e8', 'Heading', 'h4'),
        ds_wysiwyg_field('field_161afe13407ca8', 'Text', 'basic', 0),
        ds_link_field('field_6da76817f4a795', 'Link'),
    ),
    'min' => 0,
    'max' => 0,
);