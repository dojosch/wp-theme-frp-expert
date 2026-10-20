<?php

$content_slider = array(
    'key' => 'layout_9e4b7c2a5d1f83',
    'label' => 'Content Slider',
    'name' => 'content_slider',
    'display' => 'block',
    'sub_fields' => array(
        ds_accordion_field('field_2d7f4a9c1e6b35', 'Slider'),
        ds_heading_field('field_6a1e9c4f7b2d58', 'Slider Sub Heading', 'h3'),
        ds_heading_textarea_field('field_c8f3b1e6a9d247', 'Slider Heading', 'h2'),
        ds_repeater_field('field_4b9d2e7f1c6a83', 'Slides', [
            ds_image_field('field_e1c7a4f9b3d562', 'Image'),
            ds_text_field('field_9f2b6d1a8e4c37', 'Title'),
            ds_wysiwyg_field('field_3a8e5c2f9b1d64', 'Text'),
        ], 'Slide hinzufügen'),
        ds_accordion_field('field_7c3f1b8e4a2d96', 'Content'),
        ds_heading_field('field_b5d9a3e7c1f248', 'Sub Heading', 'h3'),
        ds_heading_textarea_field('field_1f6c4b9e2a7d53', 'Heading', 'h2'),
        ds_wysiwyg_field('field_d2a7e5c9f3b186', 'Text'),
        ds_repeater_field('field_8e3a6d1c4f9b27', 'Facts', [
            ds_text_field('field_5c1f8b3e7a2d94', 'Value', [
                'instructions' => 'z. B. „14+" oder „η ≤ 1,0".',
            ]),
            ds_text_field('field_a6d4c9f2e8b137', 'Title'),
            ds_textarea_field('field_f9b2e7a4d1c368', 'Text', 2),
        ], 'Fakt hinzufügen', [
            'layout' => 'table',
        ]),
    ),
    'min' => 0,
    'max' => 0,
);
