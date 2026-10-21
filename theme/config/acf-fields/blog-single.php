<?php

acf_add_local_field_group(array(
    'key' => 'group_post_card',
    'title' => 'Blog Card',
    'fields' => array(
        ds_image_crop_field('field_9b3e6a1d4c8f27', 'Card Image', 453, 200),
        ds_select_field('field_5f2c8d7a1e4b96', 'Title Tag', [
            'h2'   => 'h2',
            'h3'   => 'h3',
            'h4'   => 'h4',
            'h5'   => 'h5',
            'h6'   => 'h6',
            'span' => 'Text',
        ], 'h3', [
            'instructions' => 'Tag des Titels auf der Karte (Slider, Übersicht).',
        ]),
        ds_text_field('field_d1a7f4b9e2c638', 'Sub Heading', [
            'instructions' => 'z. B. die Kategorie. Wird auch im Blog Header angezeigt.',
        ]),
        ds_textarea_field('field_3c8e5b2f7a1d94', 'Text', 3, [
            'instructions' => 'Kurzer Teaser für die Karte.',
        ]),
    ),
    'location' => array(
        array(
            array(
                'param' => 'post_type',
                'operator' => '==',
                'value' => 'post',
            ),
        ),
    ),
    'menu_order' => -1,
    'position' => 'acf_after_title',
    'style' => 'default',
    'label_placement' => 'top',
    'instruction_placement' => 'label',
    'hide_on_screen' => '',
    'active' => true,
    'description' => '',
    'show_in_rest' => 0,
));
