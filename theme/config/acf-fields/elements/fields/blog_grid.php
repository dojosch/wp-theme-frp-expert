<?php

$blog_grid = array(
    'key' => 'layout_2e8b5d1c7a4f93',
    'label' => 'Blog Grid',
    'name' => 'blog_grid',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_field('field_8d4f1a6c3e9b27', 'Sub Heading', 'span'),
        ds_heading_field('field_b5c2e9a7d1f348', 'Heading', 'h2'),
        ds_select_field('field_4a9e2c7b5d1f86', 'Source', [
            'all'      => 'Alle Beiträge',
            'selected' => 'Ausgewählte Beiträge',
        ], 'all', [
            'label'        => 'Anzeige',
            'instructions' => 'Alle veröffentlichten Beiträge (neueste zuerst) oder eine eigene Auswahl in eigener Reihenfolge.',
        ]),
        ds_relationship_field('field_f1d7b3a9c6e254', 'Posts', ['post'], [
            'label'             => 'Beiträge',
            'conditional_logic' => [
                [
                    [
                        'field'    => 'field_4a9e2c7b5d1f86',
                        'operator' => '==',
                        'value'    => 'selected',
                    ],
                ],
            ],
        ]),
    ),
    'min' => 0,
    'max' => 0,
);
