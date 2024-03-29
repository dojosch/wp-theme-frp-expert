<?php

function ds_get_heading($text, $tag = "h2", $class = "") {
    return "<" . $tag . " class='".$class."' >" . $text . "</" . $tag . ">";
}

function ds_get_link($link, $class = "") {
    $rel = $link['target'] == "_blank" ? "rel='noopener noreferrer'" : "";
    return "<a " . $rel . " class='".$class."'  href='" . $link['url'] . "' target='" . $link['target'] . "'>" . $link['title'] . "</a>";
}

function ds_get_icon_link($link, $icon, $class = "", $icon_class = "") {
	$rel = $link['target'] == "_blank" ? "rel='noopener noreferrer'" : "";
	$icon_data = get_image_data($icon);
	$icon_elem = '<img src="' . $icon_data['src'] . '" alt="' . $icon_data['alt'] . '" class="' . $icon_class . '" />';
	return "<a " . $rel . " class='".$class."'  href='" . $link['url'] . "' target='" . $link['target'] . "'>" . $icon_elem . "</a>";
}

function ds_open_link($link, $class = "") {
	$rel = $link['target'] == "_blank" ? "rel='noopener noreferrer'" : "";
	return "<a " . $rel . " class='bj-type-link ".$class."'  href='" . $link['url'] . "' target='" . $link['target'] . "'>" . $link['title'];
}

function ds_close_link() {
	return "</a>";
}

function ds_parse_phone_into_tel($phone) {
	// Remove '-' and whitespaces - Example: +43 (0) 1234 5678 -> +43(0)12345678
	$search = array('-', ' ');
	$replace = array('', '');
	$phone = str_replace($search, $replace, $phone);

	// Remove '(*)' - Example: +43(0)12345678 -> +4312345678
	$searchPattern = "/\(\d+\)/";
	$replace = '';
	$phone = preg_replace($searchPattern, $replace, $phone);

	return "tel:" . $phone;
}

function ds_parse_mail_into_mailto($mail) {
	return "mailto:" . $mail;
}
