<?php

$two_col = array(
    'key' => 'layout_9e4b7c2a6d1f83',
    'label' => 'Two Col',
    'name' => 'two_col',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_field('field_c5a1e8d3f7b246', 'Sub Heading', 'h3'),
        ds_heading_textarea_field('field_6d2f9b4e1a8c57', 'Heading', 'h2'),
        ds_wysiwyg_field('field_f3b8a6d1c9e472', 'Text'),
        ds_repeater_field('field_2a7d5c9f3e1b84', 'Rows', [
            ds_image_crop_field('field_8f1c4a7e2d6b93', 'Image', 764, 430, [
                'instructions' => 'Wird auf Mobile immer über dem Text angezeigt.',
            ]),
            ds_select_field('field_4c8e2a6f9d1b37', 'Image Position', [
                'left'  => 'Links',
                'right' => 'Rechts',
            ], 'left', [
                'instructions' => 'Position des Bildes neben dem Text (Desktop).',
            ]),
            ds_textarea_field('field_b4e9d2a6f8c135', 'Heading', 2, [
                'new_lines' => 'br',
            ]),
            ds_wysiwyg_field('field_1e6c3b8f5a9d27', 'Text'),
            ds_repeater_field('field_7a3f1d9c4b6e58', 'List', [
                ds_text_field('field_d8b2e5a1c7f394', 'Item'),
            ], 'Punkt hinzufügen', [
                'layout' => 'table',
            ]),
        ], 'Zeile hinzufügen'),
    ),
    'min' => 0,
    'max' => 0,
);
