<?php

$blog_slider = array(
    'key' => 'layout_4d9b2e7f1a6c35',
    'label' => 'Blog Slider',
    'name' => 'blog_slider',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_field('field_e3a8c6f2d9b147', 'Sub Heading', 'h3'),
        ds_heading_field('field_7c2f9a4e1d8b56', 'Heading', 'h2'),
        ds_link_field('field_a5d1e8b3f7c924', 'Link', [
            'instructions' => 'z. B. „Alle Artikel" zur Blog-Übersicht.',
        ]),
        ds_select_field('field_2b6e9d4a8c1f73', 'Source', [
            'all'      => 'Alle Beiträge',
            'selected' => 'Beiträge auswählen',
        ], 'all', [
            'instructions' => 'Auf einem Blog-Beitrag wird der aktuelle Beitrag automatisch ausgeblendet.',
            'ui'           => 1,
        ]),
        ds_relationship_field('field_9f4c7a2e5b8d16', 'Posts', ['post'], [
            'instructions'      => 'Reihenfolge per Drag & Drop.',
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_2b6e9d4a8c1f73',
                        'operator' => '==',
                        'value'    => 'selected',
                    ),
                ),
            ),
        ]),
    ),
    'min' => 0,
    'max' => 0,
);
