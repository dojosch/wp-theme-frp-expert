<?php 

$section_config = [
	'key' => 'field_section_config',
	'label' => 'Section Settings',
	'name' => 'section_config',
	'type' => 'group',
	'required' => 0,
	'layout' => 'row',
	'sub_fields' => [
        [
            'key' => 'field_section_settings_toggle',
            'label' => 'Open Additional Settings like Class, ID and Background',
            'type' => 'accordion',
            'multi_expand' => 0,
            'open' => 0,
            'endpoint' => 0,
        ],
		[
			'key' => 'field_section_id',
			'label' => 'Section ID',
			'name' => 'id',
			'type' => 'text',
			'instructions' => 'Optional: Use a unique ID for anchor links.',
			'required' => 0,
		],
		[
			'key' => 'field_section_class',
			'label' => 'Additional CSS Classes',
			'name' => 'css_class',
			'type' => 'text',
			'instructions' => 'Optional: Additional utility classes for this section.',
			'required' => 0,
		],
		[
			'key' => 'field_section_background',
			'label' => 'Background',
			'name' => 'background',
			'type' => 'select',
			'instructions' => 'Choose a background color for the section.',
			'required' => 0,
			'choices' => [
				'bg-transparent' => 'None',
				'bg-background' => 'Background',
				'bg-primary/5' => 'Primary (light)',
				'bg-secondary/5' => 'Secondary (light)',
			],
			'default_value' => 'bg-transparent',
			'allow_null' => 0,
			'multiple' => 0,
			'ui' => 1,
		],
	],
];
