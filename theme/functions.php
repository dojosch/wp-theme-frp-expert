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
	// Load utilities first (top-level)
	foreach ( glob( get_template_directory() . '/utils/*.php' ) as $file ) {
		require_once $file;
	}

	// Load utility subfolders (e.g., utils/acf-fields) before configs
	foreach ( glob( get_template_directory() . '/utils/*/*.php' ) as $file ) {
		require_once $file;
	}

	// Finally load configs
	foreach ( glob( get_template_directory() . '/config/*.php' ) as $file ) {
		require_once $file;
	}
}
ds_load_theme_files();