<?php
/**
 * Theme Functions File
 *
 * This file is responsible for loading utility and configuration files
 * required by the theme. It ensures that all necessary PHP files in the
 * `utils` and `config` directories are included automatically.
 *
 * @package wp-starter-tw
 */

/**
 * Loads all PHP files from the `utils` and `config` directories.
 *
 * This function iterates through the specified directories and includes
 * all `.php` files found within them. It is used to modularize the theme
 * by separating functionality into smaller, reusable files.
 *
 * @return void
 */
function ds_load_theme_files() {
	foreach ( array( 'utils', 'config' ) as $folder ) {
		foreach ( glob( get_template_directory() . "/$folder/*.php" ) as $file ) {
			require_once $file;
		}
	}
}
ds_load_theme_files();
