<?php

$intro = array(
    'key' => 'layout_7c2a5e91d4b836',
    'label' => 'Intro',
    'name' => 'intro',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_field('field_2f6b9d14e8a073', 'Sub Heading', 'h2'),
        ds_wysiwyg_field('field_a84d1c7e5f2b39', 'Text'),
        ds_repeater_field('field_6e3f0a92b7c15d', 'Tags', [
            ds_text_field('field_d95b2c8e4a7f16', 'Label', [
                'instructions' => 'Wird fett dargestellt, z. B. „EN 13121-3".',
                'wrapper'      => ['width' => '50'],
            ]),
            ds_text_field('field_1b7e4f3a9c6d28', 'Text', [
                'instructions' => 'z. B. „GFK-Tanks".',
                'wrapper'      => ['width' => '50'],
            ]),
        ], 'Tag hinzufügen', [
            'layout' => 'table',
        ]),
    ),
    'min' => 0,
    'max' => 0,
);
