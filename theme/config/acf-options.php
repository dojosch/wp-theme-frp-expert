<?php
/**
 * Register ACF Options Pages for the Theme
 */

add_action('acf/init', 'ds_register_acf_options_pages');

function ds_register_acf_options_pages() {
    if ( ! function_exists('acf_add_options_page') ) {
        return;
    }

    // Add main options page
    acf_add_options_page([
        'page_title'  => 'Theme Einstellungen',
        'menu_title'  => 'Theme Einstellungen',
        'menu_slug'   => 'theme-overview-settings',
        'capability'  => 'edit_posts',
        'redirect'    => true, // Redirects to first sub page
    ]);

    // Subpages to register under the parent
    $subpages = [
        'Footer',
        'Navigation',
        '404-Page',
    ];

    foreach ( $subpages as $title ) {
        acf_add_options_sub_page([
            'page_title'  => __( $title, 'ds-starter' ),
            'menu_title'  => __( $title, 'ds-starter' ),
            'parent_slug' => 'theme-overview-settings',
        ]);
    }
}
