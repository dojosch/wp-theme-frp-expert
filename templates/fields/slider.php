<?php

$slider = array(
    'key' => 'layout_0bf9c692b4b217',
    'label' => 'Slider',
    'name' => 'slider',
    'display' => 'block',
    'sub_fields' => array(
        ds_heading_field('field_ec13c9e9775bd1', 'Heading', 'h2', 'Heading'),
        ds_repeater_field('field_2816ca7a8f2369', 'Slides', [
            ds_image_crop_field('field_6640db3d94bde8', 'Image', 3, 2),
        ], 'Add Slide'),
    ),
    'min' => 0,
    'max' => 0,
);