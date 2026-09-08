<?php

$content_part_id = get_sub_field('content_part_id');

if( $content_part_id && have_rows('elements', $content_part_id) ) {
	while( have_rows('elements', $content_part_id) ) {
		the_row();
		$layout = get_row_layout();
		$section_path = 'sections/' . $layout . '.php';
		$file = get_stylesheet_directory() . '/page-templates/' . $section_path;

		if( file_exists($file) ) {
			include $file;
		} else {
			ds_missing_layout_notice($layout);
		}
	}
}