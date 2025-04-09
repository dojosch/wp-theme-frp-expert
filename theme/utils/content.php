<?php
/**
 * Helpers for links, headings, and media output.
 */

function ds_get_heading( $text, $tag = 'h2', $class = '' ) {
	return "<$tag class='" . esc_attr( $class ) . "'>" . esc_html( $text ) . "</$tag>";
}

function ds_get_link( $link, $class = '' ) {
	if ( ! is_array( $link ) ) return '';

	$rel = $link['target'] === '_blank' ? 'rel="noopener noreferrer"' : '';
	return "<a $rel class='" . esc_attr( $class ) . "' href='" . esc_url( $link['url'] ) . "' target='" . esc_attr( $link['target'] ) . "'>" . esc_html( $link['title'] ) . "</a>";
}

function ds_get_icon_link( $link, $icon_id, $class = '', $icon_class = '' ) {
	$icon = ds_get_image_data_from_id( $icon_id );
	if ( ! $icon ) return '';

	$rel = $link['target'] === '_blank' ? 'rel="noopener noreferrer"' : '';
	$icon_elem = '<img src="' . esc_url( $icon['src'] ) . '" alt="' . esc_attr( $icon['alt'] ) . '" class="' . esc_attr( $icon_class ) . '" />';

	return "<a $rel class='" . esc_attr( $class ) . "' href='" . esc_url( $link['url'] ) . "' target='" . esc_attr( $link['target'] ) . "'>$icon_elem</a>";
}

function ds_open_link( $link, $class = '' ) {
	if ( ! is_array( $link ) ) return '';
	$rel = $link['target'] === '_blank' ? 'rel="noopener noreferrer"' : '';
	return "<a $rel class='bj-type-link " . esc_attr( $class ) . "' href='" . esc_url( $link['url'] ) . "' target='" . esc_attr( $link['target'] ) . "'>";
}

function ds_close_link() {
	return '</a>';
}

function ds_parse_phone_into_tel( $phone ) {
	$phone = str_replace( [ '-', ' ' ], '', $phone );
	$phone = preg_replace( '/\(\d+\)/', '', $phone );
	return 'tel:' . $phone;
}

function ds_parse_mail_into_mailto( $mail ) {
	return 'mailto:' . sanitize_email( $mail );
}
