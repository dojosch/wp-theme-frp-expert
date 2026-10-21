<?php 

acf_add_local_field_group(array(
	'key' => 'group_67570e38a271d',
	'title' => 'Footer',
	'fields' => array(
        ds_group_field('field_c95a8835cfeb9c', 'Footer', [
            ds_wysiwyg_field('field_footer_text', 'Text', 'basic', 0, [
                'instructions' => 'Einleitung unter dem Logo.',
            ]),
            ds_wysiwyg_field('field_footer_address', 'Adresse', 'basic', 0, [
                'name'    => 'address',
                'wrapper' => ['width' => '50'],
            ]),
            ds_text_field('field_footer_phone', 'Telefon', [
                'name'         => 'phone',
                'instructions' => 'z. B. „+43 660 123 456". Wird mit „T." davor als Anruf-Link angezeigt.',
                'wrapper'      => ['width' => '25'],
            ]),
            ds_email_field('field_footer_email', 'E-Mail', [
                'name'    => 'email',
                'wrapper' => ['width' => '25'],
            ]),
            ds_text_field('field_footer_form', 'Formular', [
                'name'         => 'form',
                'instructions' => 'Contact Form 7 Shortcode, z. B. [contact-form-7 id="…"].',
            ]),
            ds_image_field('field_footer_watermark', 'Schriftzug', [
                'name'         => 'watermark',
                'instructions' => 'Großer Schriftzug am unteren Rand (nur Desktop), am besten als SVG.',
            ]),
        ]),
    ),
	'location' => array(
		array(
			array(
				'param' => 'options_page',
				'operator' => '==',
				'value' => 'acf-options-footer',
			),
		),
	),
	'menu_order' => 0,
	'position' => 'acf_after_title',
	'style' => 'default',
	'label_placement' => 'top',
	'instruction_placement' => 'label',
	'hide_on_screen' => '',
	'active' => true,
	'description' => '',
	'show_in_rest' => 0,
));