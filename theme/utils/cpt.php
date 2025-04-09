<?php

/**
 * Register a custom post type with optional overrides.
 *
 * @param string $type       The post type key (e.g. 'faq')
 * @param string $singular   Singular label (e.g. 'FAQ')
 * @param string $plural     Plural label (e.g. 'FAQs')
 * @param array  $options    Optional overrides: 'slug', 'menu_icon', 'labels', 'args'
 */
function ds_register_cpt($type, $singular, $plural, $options = [])
{
    $slug      = $options['slug'] ?? $type;
    $menu_icon = $options['menu_icon'] ?? 'dashicons-admin-post';

    // Default labels
    $labels = array_merge([
        'name'                  => $plural,
        'singular_name'         => $singular,
        'menu_name'             => $plural,
        'name_admin_bar'        => $singular,
        'archives'              => "$singular Archives",
        'attributes'            => "$singular Attributes",
        'parent_item_colon'     => "Parent $singular:",
        'all_items'             => "All $plural",
        'add_new_item'          => "Add New $singular",
        'add_new'               => 'Add New',
        'new_item'              => "New $singular",
        'edit_item'             => "Edit $singular",
        'update_item'           => "Update $singular",
        'view_item'             => "View $singular",
        'view_items'            => "View $plural",
        'search_items'          => "Search $singular",
        'not_found'             => 'Not found',
        'not_found_in_trash'    => 'Not found in Trash',
        'featured_image'        => 'Featured Image',
        'set_featured_image'    => 'Set featured image',
        'remove_featured_image' => 'Remove featured image',
        'use_featured_image'    => 'Use as featured image',
        'insert_into_item'      => "Insert into $singular",
        'uploaded_to_this_item' => "Uploaded to this $singular",
        'items_list'            => "$plural list",
        'items_list_navigation' => "$plural list navigation",
        'filter_items_list'     => "Filter $plural list",
    ], $options['labels'] ?? []);

    // Default args
    $args = array_merge([
        'label'                 => $plural,
        'description'           => "$plural content type",
        'labels'                => $labels,
        'supports'              => ['title', 'custom-fields', 'page-attributes'],
        'hierarchical'          => false,
        'public'                => true,
        'show_ui'               => true,
        'show_in_menu'          => true,
        'menu_position'         => 5,
        'menu_icon'             => $menu_icon,
        'show_in_admin_bar'     => true,
        'show_in_nav_menus'     => true,
        'can_export'            => true,
        'has_archive'           => false,
        'exclude_from_search'   => false,
        'publicly_queryable'    => true,
        'rewrite'               => ['slug' => $slug],
        'capability_type'       => 'page',
    ], $options['args'] ?? []);

    register_post_type($type, $args);
}
