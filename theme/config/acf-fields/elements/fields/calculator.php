<?php

$calculator = array(
    'key' => 'layout_8b5d2f7a3c9e16',
    'label' => 'Calculator',
    'name' => 'calculator',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_field('field_1d7a4e9c2f6b83', 'Sub Heading', 'h3'),
        ds_heading_textarea_field('field_e5c8b3a6d1f927', 'Heading', 'h2'),
        ds_wysiwyg_field('field_7f2b9d5e8a3c41', 'Text'),
        ds_repeater_field('field_a3e6c1f8b4d592', 'Modes', [
            ds_text_field('field_4b9f2d7c6e1a38', 'Label', [
                'instructions' => 'Titel des Tabs, z. B. „Extern". Der erste Modus ist beim Laden ausgewählt.',
            ]),
            ds_text_field('field_9e1c6b4a2d8f75', 'Heading', [
                'instructions' => 'Überschrift des Rechners, z. B. „Berechnung durch Ingenieurbüro".',
            ]),
            ds_repeater_field('field_6a4d9f3b1c7e28', 'Sliders', [
                ds_text_field('field_f8b3e1d6a9c452', 'Label'),
                ds_text_field('field_2c7f5a8e3b1d96', 'Key', [
                    'instructions' => 'Technischer Name für die Berechnung, z. B. „tanks_per_year".',
                ]),
                ds_text_field('field_b1e4d7a2f9c635', 'Unit', [
                    'instructions' => 'Wird hinter dem Wert angezeigt, z. B. „Stunden".',
                ]),
                ds_number_field('field_5d9a2c6f8e3b17', 'Min', [
                    'default_value' => 0,
                    'wrapper'       => ['width' => '25'],
                ]),
                ds_number_field('field_e7c3f9b5a1d248', 'Max', [
                    'default_value' => 100,
                    'wrapper'       => ['width' => '25'],
                ]),
                ds_number_field('field_3a8e6d2b9f4c51', 'Step', [
                    'default_value' => 1,
                    'wrapper'       => ['width' => '25'],
                ]),
                ds_number_field('field_d4f1b8e6c3a792', 'Value', [
                    'instructions'  => 'Startwert.',
                    'default_value' => 0,
                    'wrapper'       => ['width' => '25'],
                ]),
            ], 'Regler hinzufügen', [
                'min'    => 2,
                'max'    => 2,
                'layout' => 'block',
            ]),
            ds_text_field('field_8c5a3f7d1e9b24', 'Cost Label', [
                'instructions' => 'z. B. „Kosten mit FibreTank".',
                'wrapper'      => ['width' => '33'],
            ]),
            ds_text_field('field_1f9d6b2e8a4c73', 'Comparison Label', [
                'instructions' => 'z. B. „Kosten Ingenieurbüro (extern)".',
                'wrapper'      => ['width' => '33'],
            ]),
            ds_text_field('field_7e2a8c4f6d1b59', 'Savings Label', [
                'instructions' => 'z. B. „Ersparnis pro Jahr".',
                'wrapper'      => ['width' => '34'],
            ]),
        ], 'Modus hinzufügen', [
            'collapsed' => 'field_4b9f2d7c6e1a38',
        ]),
    ),
    'min' => 0,
    'max' => 0,
);
