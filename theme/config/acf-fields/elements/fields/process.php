<?php

$process = array(
    'key' => 'layout_5d8f2b6a1c9e47',
    'label' => 'Process',
    'name' => 'process',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_field('field_8a3c6e1f5b2d94', 'Sub Heading', 'h3'),
        ds_heading_textarea_field('field_b27e9d4a6c1f53', 'Heading', 'h2'),
        ds_wysiwyg_field('field_4f1a8c3e7d6b25', 'Text'),
        ds_image_crop_field('field_e6b3d92f1a8c74', 'Image', 500, 527),
        ds_repeater_field('field_3c9a7e2d5f1b68', 'Steps', [
            ds_image_field('field_7b4e1d8a2c6f39', 'Icon', [
                'instructions' => 'SVG-Icon, quadratisch.',
            ]),
            ds_text_field('field_a1f5c8e3b7d240', 'Label', [
                'instructions' => 'z. B. „Eingabe". Die Nummer wird automatisch vorangestellt.',
            ]),
            ds_text_field('field_d6e2b9f4a3c157', 'Heading'),
            ds_wysiwyg_field('field_5e8d3a1c7b9f62', 'Text'),
        ], 'Schritt hinzufügen'),
    ),
    'min' => 0,
    'max' => 0,
);
