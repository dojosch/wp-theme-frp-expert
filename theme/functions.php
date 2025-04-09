<?php
/**
 * devsolution Starter functions and definitions
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package devsolution_Starter
 */

function ds_load_theme_files() {
	foreach ( [ 'utils', 'config' ] as $folder ) {
		foreach ( glob( get_template_directory() . "/$folder/*.php" ) as $file ) {
			require_once $file;
		}
	}
}
ds_load_theme_files();
