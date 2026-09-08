<?php

$cta = array(
    'key' => 'layout_fa120358f674fe',
    'label' => 'CTA',
    'name' => 'cta',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_textarea_field('field_4302b811f801f8', 'Heading', 'h2'),
        ds_heading_field('field_c49b7816172728', 'Sub Heading', 'h3'),
        ds_link_field('field_991ac6212992b7', 'Link'),
        ds_image_crop_field('field_a3c9fe40f76088', 'Image', 414, 343),
        ds_select_field('field_59f84b03272ff2', 'Image Position', [
            'left' => 'left',
            'right' => 'Right'
        ], 'left'),
    ),
    'min' => 0,
    'max' => 0,
);