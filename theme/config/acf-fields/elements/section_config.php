<?php

$section_config = ds_group_field(
    'field_section_config',
    'Section Settings',
    [
        ds_accordion_field('field_section_settings_toggle', 'Open Additional Settings like Class, ID and Background'),
        ds_text_field('field_section_id', 'Section ID', [
            'name'         => 'id',
            'instructions' => 'Optional: Use a unique ID for anchor links.',
        ]),
        ds_text_field('field_section_class', 'Additional CSS Classes', [
            'name'         => 'css_class',
            'instructions' => 'Optional: Additional utility classes for this section.',
        ]),
        ds_select_field('field_section_background', 'Background', [
            'white' => 'White',
            'dark'  => 'Main New',
        ], 'white', [
            'instructions' => 'Choose a background color for the section.',
            'ui'           => 1,
        ]),
    ],
    [
        'name'   => 'section_config',
        'layout' => 'row',
    ]
);
