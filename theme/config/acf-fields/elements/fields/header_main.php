<?php

$header_main = array(
    'key' => 'layout_4b1e9c2d7f3a61',
    'label' => 'Header Main',
    'name' => 'header_main',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_textarea_field('field_9d2c4e71a8b3f0', 'Heading', 'h1'),
        ds_wysiwyg_field('field_c3f81a5e27d940', 'Text'),
        ds_link_field('field_5a7e3d92c1f468', 'Link'),
        ds_image_field('field_e18b6f4d03a7c2', 'Image', [
            'instructions' => 'Wird rechts neben dem Text angezeigt (Desktop) bzw. darunter (Mobile).',
        ]),
    ),
    'min' => 0,
    'max' => 0,
);
