<?php

$showcase = array(
    'key' => 'layout_3f8c1e6a9d2b74',
    'label' => 'Showcase',
    'name' => 'showcase',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_field('field_a6d2f8b1e4c937', 'Sub Heading', 'h3'),
        ds_heading_field('field_5c9e3a7d1f6b28', 'Heading', 'h2'),
        ds_repeater_field('field_e2b7d4f9a1c683', 'Items', [
            ds_text_field('field_9a4c1f7e3b6d52', 'Label', [
                'instructions' => 'Titel des Tabs, z. B. „Videobeispiel 01".',
            ]),
            ds_media_crop_field('field_c7f3b9e2d5a148', 'Media', 884, 497, [
                'instructions' => 'Bild oder Video (mp4/webm). Videos zeigen das Vorschaubild unscharf mit Play-Button.',
            ]),
        ], 'Eintrag hinzufügen', [
            'min'          => 1,
            'collapsed'    => 'field_9a4c1f7e3b6d52',
        ]),
    ),
    'min' => 0,
    'max' => 0,
);
