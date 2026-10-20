<?php

$blog_header = array(
    'key' => 'layout_6f3a9d1c7e2b48',
    'label' => 'Blog Header',
    'name' => 'blog_header',
    'display' => 'block',
    'sub_fields' => array(
        ds_link_field('field_b2f8d5a3c1e967', 'Back Link', [
            'instructions' => 'Leer lassen für „Zurück" zur Startseite.',
        ]),
        ds_image_field('field_7d1e4b8a6c3f52', 'Image', [
            'instructions' => 'Titel und Sub Heading kommen aus den Blog-Card-Feldern dieses Beitrags.',
        ]),
    ),
    'min' => 0,
    'max' => 1,
);
