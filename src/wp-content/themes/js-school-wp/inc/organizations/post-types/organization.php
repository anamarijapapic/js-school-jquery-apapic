<?php

function js_school_wp_register_organization_cpt() : void {

    register_post_type( 'organization', [
            'label'       => __( 'Organizations', 'js-school-wp.administration' ),
            'description' => __( 'Organizations Post Type', 'js-school-wp.administration' ),
            'labels'      => [
                'name'                  => _x( 'Organizations', 'Post Type General Name', 'js-school-wp.administration' ),
                'singular_name'         => _x( 'Organization', 'Post Type Singular Name', 'js-school-wp.administration' ),
                'menu_name'             => __( 'Organizations', 'js-school-wp.administration' ),
                'name_admin_bar'        => __( 'Organizations', 'js-school-wp.administration' ),
                'archives'              => __( 'Organization Archives', 'js-school-wp.administration' ),
                'attributes'            => __( 'Organization Attributes', 'js-school-wp.administration' ),
                'parent_item_colon'     => __( 'Parent Organization:', 'js-school-wp.administration' ),
                'all_items'             => __( 'All Organizations', 'js-school-wp.administration' ),
                'add_new_item'          => __( 'Add New Organization', 'js-school-wp.administration' ),
                'add_new'               => __( 'Add New', 'js-school-wp.administration' ),
                'new_item'              => __( 'New Organization', 'js-school-wp.administration' ),
                'edit_item'             => __( 'Edit Organization', 'js-school-wp.administration' ),
                'update_item'           => __( 'Update Organization', 'js-school-wp.administration' ),
                'view_item'             => __( 'View Organization', 'js-school-wp.administration' ),
                'view_items'            => __( 'View Organizations', 'js-school-wp.administration' ),
                'search_items'          => __( 'Search Organizations', 'js-school-wp.administration' ),
                'not_found'             => __( 'Not found', 'js-school-wp.administration' ),
                'not_found_in_trash'    => __( 'Not found in Trash', 'js-school-wp.administration' ),
                'featured_image'        => __( 'Featured Image', 'js-school-wp.administration' ),
                'set_featured_image'    => __( 'Set featured image', 'js-school-wp.administration' ),
                'remove_featured_image' => __( 'Remove featured image', 'js-school-wp.administration' ),
                'use_featured_image'    => __( 'Use as featured image', 'js-school-wp.administration' ),
                'insert_into_item'      => __( 'Insert into organization', 'js-school-wp.administration' ),
                'uploaded_to_this_item' => __( 'Uploaded to this organization', 'js-school-wp.administration' ),
                'items_list'            => __( 'Organization list', 'js-school-wp.administration' ),
                'items_list_navigation' => __( 'Organization list navigation', 'js-school-wp.administration' ),
                'filter_items_list'     => __( 'Filter organization list', 'js-school-wp.administration' ),
            ],
            'supports'            => [ 'title', 'page-attributes', 'editor' ],
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-building',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'rewrite'             => [
                'slug'       => 'organizations',
                'with_front' => false,
            ],
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        ] );

}
add_action( 'init', 'js_school_wp_register_organization_cpt', 0 );
