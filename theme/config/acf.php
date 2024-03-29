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
