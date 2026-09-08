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
 * Checks if a given link array is valid.
 *
 * A valid link must be an array with a non-empty URL and a title.
 *
 * @param mixed $link The input to validate as a link array.
 * @return bool True if the link is valid, false otherwise.
 */
function ds_is_valid_link($link) {
	return is_array($link)
		&& !empty($link['url'])
		&& !empty($link['title']);
}

/**
 * Generates an HTML heading element with the specified text, tag, and CSS class.
 *
 * @param string $text      The text content for the heading.
 * @param string $tag       The HTML tag to use for the heading (default is 'h2').
 * @param string $css_class Optional. Additional CSS class(es) to apply to the heading element.
 *
 * @return string The generated HTML heading element as a string.
 */
function ds_get_heading($text = '', $tag = 'h2', $css_class = '') {
	if( empty($text) || !is_string($text) ) return '';

    $allowed_tags = array('h1', 'h2', 'h3', 'h4', 'h5', 'h6', 'span', 'p', 'div', 'strong', 'em', 'u', 'a', 'ul', 'ol', 'li', 'br');
	$tag = in_array(strtolower($tag), $allowed_tags, true) ? strtolower($tag) : 'h2';

	return sprintf(
		'<%1$s class="%2$s">%3$s</%1$s>',
		$tag,
		esc_attr($css_class),
		wp_kses($text, array_fill_keys($allowed_tags, array()))
	);
}

/**
 * Generates an HTML link with optional CSS class.
 *
 * @param array  $link      The ACF-style link array with keys 'url', 'title', and optionally 'target'.
 * @param string $css_class Optional. The CSS class to apply to the link. Default is an empty string.
 *
 * @return string The generated HTML link.
 */
function ds_get_link($link = null, $css_class = '') {
	if( !ds_is_valid_link($link) ) return '';

	$rel = ($link['target'] ?? '') === '_blank' ? 'rel="noopener noreferrer"' : '';
	$target = esc_attr($link['target'] ?? '_self');

	return sprintf(
		'<a href="%1$s" target="%2$s" %3$s class="%4$s">%5$s</a>',
		esc_url($link['url']),
		$target,
		$rel,
		esc_attr($css_class),
		esc_html($link['title'])
	);
}

/**
 * Generates an HTML link with an embedded icon.
 *
 * @param array  $link       The ACF-style link array.
 * @param int    $icon_id    The attachment ID of the icon.
 * @param string $css_class  Optional. CSS classes for the anchor tag.
 * @param string $icon_class Optional. CSS classes for the image element.
 *
 * @return string The generated HTML string for the icon link.
 */
function ds_get_icon_link($link = null, $icon_id = null, $css_class = '', $icon_class = '') {
	if( !ds_is_valid_link($link) || empty($icon_id) ) return '';

	$icon = ds_get_image_data_from_id($icon_id);

	if( !$icon || empty($icon['src']) ) return '';

	$rel = ($link['target'] ?? '') === '_blank' ? 'rel="noopener noreferrer"' : '';
	$target = esc_attr($link['target'] ?? '_self');
	$icon_elem = sprintf(
		'<img src="%1$s" alt="%2$s" class="%3$s" />',
		esc_url($icon['src']),
		esc_attr($icon['alt'] ?? ''),
		esc_attr($icon_class)
	);

	return sprintf(
		'<a href="%1$s" target="%2$s" %3$s class="%4$s">%5$s</a>',
		esc_url($link['url']),
		$target,
		$rel,
		esc_attr($css_class),
		$icon_elem
	);
}

/**
 * Opens a link as a wrapper (for wrapping custom content).
 *
 * @param array  $link      The ACF-style link array.
 * @param string $css_class Optional. Additional CSS class to apply to the anchor.
 *
 * @return string The opening <a> tag or an empty string.
 */
function ds_open_link($link = null, $css_class = '') {
	if( !ds_is_valid_link($link) ) return '';

	$rel = ($link['target'] ?? '') === '_blank' ? 'rel="noopener noreferrer"' : '';
	$target = esc_attr($link['target'] ?? '_self');

	return sprintf(
		'<a href="%1$s" target="%2$s" %3$s class="bj-type-link %4$s">',
		esc_url($link['url']),
		$target,
		$rel,
		esc_attr($css_class)
	);
}

/**
 * Closes an open HTML link tag.
 *
 * @return string The closing anchor tag.
 */
function ds_close_link() {
	return '</a>';
}

/**
 * Parses a phone number into a tel: link format.
 *
 * @param string $phone The phone number to be parsed.
 *
 * @return string The formatted phone number as a tel: link.
 */
function ds_parse_phone_into_tel($phone = '') {
	if( !is_string($phone) || empty($phone) ) return '';

	$clean = preg_replace(array('/[^\d\+]/', '/\(\d+\)/'), '', $phone);
	return 'tel:' . esc_attr($clean);
}

/**
 * Parses an email address and converts it into a mailto link.
 *
 * @param string $mail The email address to be converted.
 *
 * @return string The mailto link generated from the email address.
 */
function ds_parse_mail_into_mailto($mail = '') {
	if( !is_email($mail) ) return '';

	return 'mailto:' . sanitize_email($mail);
}