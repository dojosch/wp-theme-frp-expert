<?php

$faq = array(
    'key' => 'layout_2e7b4d9a6f1c38',
    'label' => 'FAQ',
    'name' => 'faq',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_field('field_6c1f8a3e9d5b47', 'Sub Heading', 'h3'),
        ds_heading_field('field_b9d4e2a7c6f153', 'Heading', 'h2'),
        ds_wysiwyg_field('field_3e8a5c1d7b9f26', 'Text'),
        ds_link_field('field_f1a7d3c9e5b284', 'Link'),
        ds_select_field('field_8d2c6f4a1e7b93', 'Source', [
            'all'      => 'Alle FAQs',
            'selected' => 'FAQs auswählen',
        ], 'all', [
            'ui' => 1,
        ]),
        ds_relationship_field('field_4a9e1b7d3c6f58', 'FAQs', ['faq'], [
            'instructions'      => 'Reihenfolge per Drag & Drop.',
            'conditional_logic' => array(
                array(
                    array(
                        'field'    => 'field_8d2c6f4a1e7b93',
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
