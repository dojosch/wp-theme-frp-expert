<?php

// Create Options Page
add_action('acf/init', 'my_acf_op_init');
function my_acf_op_init() {

    // Check function exists.
    if( function_exists('acf_add_options_page') ) {

        // Add parent.
        $parent = acf_add_options_page(array(
            'page_title' 	=> 'Theme Einstellungen',
			'menu_title'	=> 'Theme Einstellungen',
			'menu_slug' 	=> 'theme-overview-settings',
			'capability'	=> 'edit_posts',
			'redirect'		=> false
        ));

        // Add sub page.
        $child = acf_add_options_sub_page(array(
            'page_title'  => __('Footer'),
            'menu_title'  => __('Footer'),
            'parent_slug' => 'theme-overview-settings',
        ));
    }
}

// Create ACF JSON Connection
// Needed to automatically track field changes
add_filter('acf/settings/save_json', 'my_acf_json_save_point');
function my_acf_json_save_point( $path ) {
    $path = get_stylesheet_directory() . '/acf-json';
    return $path;
}

add_filter('acf/settings/load_json', 'my_acf_json_load_point');
function my_acf_json_load_point( $paths ) {
    unset($paths[0]);
    $paths[] = get_stylesheet_directory() . '/acf-json';
    return $paths;  
}