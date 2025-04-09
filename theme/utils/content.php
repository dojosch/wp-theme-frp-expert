<?php
/**
 * Content Utility Functions
 *
 * This file contains helper functions for generating links, headings, and media output
 * within the WordPress theme.
 *
 * @package wp-starter-tw
 * @subpackage Utils
 * @since 1.0.0
 */

/**
 * Generates an HTML heading element with the specified text, tag, and CSS class.
 *
 * @param string $text      The text content for the heading.
 * @param string $tag       The HTML tag to use for the heading (default is 'h2').
 * @param string $css_class Optional. Additional CSS class(es) to apply to the heading element.
 *
 * @return string The generated HTML heading element as a string.
 */
function ds_get_heading( $text, $tag = 'h2', $css_class = '' ) {
	return "<$tag class='" . esc_attr( $css_class ) . "'>" . esc_html( $text ) . "</$tag>";
}

/**
 * Generates an HTML link with optional CSS class.
 *
 * @param string $link The URL for the link.
 * @param string $css_class Optional. The CSS class to apply to the link. Default is an empty string.
 * @return string The generated HTML link.
 */
function ds_get_link( $link, $css_class = '' ) {
	if ( is_array( $link ) === false ) {
		return '';
	}

	$rel = '_blank' === $link['target'] ? 'rel="noopener noreferrer"' : '';
	return "<a $rel class='" . esc_attr( $css_class ) . "' href='" . esc_url( $link['url'] ) . "' target='" . esc_attr( $link['target'] ) . "'>" . esc_html( $link['title'] ) . '</a>';
}

/**
 * Generates an HTML link with an icon.
 *
 * @param string $link       The URL for the link.
 * @param string $icon_id    The ID or identifier for the icon.
 * @param string $css_class  Optional. Additional CSS classes for the link element. Default is an empty string.
 * @param string $icon_class Optional. Additional CSS classes for the icon element. Default is an empty string.
 *
 * @return string The HTML string for the link with the icon.
 */
function ds_get_icon_link( $link, $icon_id, $css_class = '', $icon_class = '' ) {
	$icon = ds_get_image_data_from_id( $icon_id );
	if ( ! $icon ) {
		return '';
	}

	$rel       = '_blank' === $link['target'] ? 'rel="noopener noreferrer"' : '';
	$icon_elem = '<img src="' . esc_url( $icon['src'] ) . '" alt="' . esc_attr( $icon['alt'] ) . '" class="' . esc_attr( $icon_class ) . '" />';

	return "<a $rel class='" . esc_attr( $class ) . "' href='" . esc_url( $link['url'] ) . "' target='" . esc_attr( $link['target'] ) . "'>$icon_elem</a>";
}

/**
 * Opens a link with optional CSS class.
 *
 * @param string $link The URL of the link to open.
 * @param string $css_class Optional. Additional CSS class to apply to the link. Default is an empty string.
 */
function ds_open_link( $link, $css_class = '' ) {
	if ( is_array( $link ) === false ) {
		return '';
	}
	$rel = '_blank' === $link['target'] ? 'rel="noopener noreferrer"' : '';
	return "<a $rel class='bj-type-link " . esc_attr( $css_class ) . "' href='" . esc_url( $link['url'] ) . "' target='" . esc_attr( $link['target'] ) . "'>";
}

/**
 * Closes an open HTML link tag.
 *
 * This function is used to properly close an open anchor (`<a>`) tag
 * in the HTML output. It ensures that the markup remains valid and
 * prevents potential rendering issues.
 *
 * @return string
 */
function ds_close_link() {
	return '</a>';
}

/**
 * Parses a phone number into a tel: link format.
 *
 * @param string $phone The phone number to be parsed.
 * @return string The formatted phone number as a tel: link.
 */
function ds_parse_phone_into_tel( $phone ) {
	$phone = str_replace( array( '-', ' ' ), '', $phone );
	$phone = preg_replace( '/\(\d+\)/', '', $phone );
	return 'tel:' . $phone;
}

/**
 * Parses an email address and converts it into a mailto link.
 *
 * @param string $mail The email address to be converted.
 * @return string The mailto link generated from the email address.
 */
function ds_parse_mail_into_mailto( $mail ) {
	return 'mailto:' . sanitize_email( $mail );
}
