<?php

$content_part = array(
	'key' => 'field_96388818d1c718',
	'label' => 'Content Part / Preset',
	'name' => 'content_part',
	'display' => 'block',
	'sub_fields' => array(
		array(
			'key' => 'field_7580ac4059e2ec',
			'label' => 'Content Part Preset',
			'name' => 'content_part_id',
			'type' => 'post_object',
			'instructions' => 'Wähle einen Content Part aus, der als Preset eingefügt werden soll.',
			'required' => 0,
			'post_type' => array( 'content_part' ),
			'taxonomy' => array(),
			'allow_null' => 0,
			'multiple' => 0,
			'return_format' => 'id',
			'ui' => 1,
		),
	),
	'min' => 0,
	'max' => 0,
);