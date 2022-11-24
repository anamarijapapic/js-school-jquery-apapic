<?php

function js_school_wp_register_team_member_cpt() : void {

    register_post_type( 'team-member', [
            'label'       => __( 'Team Members', 'js-school-wp.administration' ),
            'description' => __( 'Team Members Post Type', 'js-school-wp.administration' ),
            'labels'      => [
                'name'                  => _x( 'Team Members', 'Post Type General Name', 'js-school-wp.administration' ),
                'singular_name'         => _x( 'Team Member', 'Post Type Singular Name', 'js-school-wp.administration' ),
                'menu_name'             => __( 'Team Members', 'js-school-wp.administration' ),
                'name_admin_bar'        => __( 'Team Members', 'js-school-wp.administration' ),
                'archives'              => __( 'Team Member Archives', 'js-school-wp.administration' ),
                'attributes'            => __( 'Team Member Attributes', 'js-school-wp.administration' ),
                'parent_item_colon'     => __( 'Parent Team Member:', 'js-school-wp.administration' ),
                'all_items'             => __( 'All Team Members', 'js-school-wp.administration' ),
                'add_new_item'          => __( 'Add New Team Member', 'js-school-wp.administration' ),
                'add_new'               => __( 'Add New', 'js-school-wp.administration' ),
                'new_item'              => __( 'New Team Member', 'js-school-wp.administration' ),
                'edit_item'             => __( 'Edit Team Member', 'js-school-wp.administration' ),
                'update_item'           => __( 'Update Team Member', 'js-school-wp.administration' ),
                'view_item'             => __( 'View Team Member', 'js-school-wp.administration' ),
                'view_items'            => __( 'View Team Members', 'js-school-wp.administration' ),
                'search_items'          => __( 'Search Team Members', 'js-school-wp.administration' ),
                'not_found'             => __( 'Not found', 'js-school-wp.administration' ),
                'not_found_in_trash'    => __( 'Not found in Trash', 'js-school-wp.administration' ),
                'featured_image'        => __( 'Featured Image', 'js-school-wp.administration' ),
                'set_featured_image'    => __( 'Set featured image', 'js-school-wp.administration' ),
                'remove_featured_image' => __( 'Remove featured image', 'js-school-wp.administration' ),
                'use_featured_image'    => __( 'Use as featured image', 'js-school-wp.administration' ),
                'insert_into_item'      => __( 'Insert into team member', 'js-school-wp.administration' ),
                'uploaded_to_this_item' => __( 'Uploaded to this team member', 'js-school-wp.administration' ),
                'items_list'            => __( 'Team Member list', 'js-school-wp.administration' ),
                'items_list_navigation' => __( 'Team Member list navigation', 'js-school-wp.administration' ),
                'filter_items_list'     => __( 'Filter team member list', 'js-school-wp.administration' ),
            ],
            'supports'            => [ 'title', 'page-attributes', 'editor' ],
            'hierarchical'        => false,
            'public'              => true,
            'show_ui'             => true,
            'show_in_menu'        => true,
            'menu_icon'           => 'dashicons-groups',
            'show_in_admin_bar'   => true,
            'show_in_nav_menus'   => true,
            'can_export'          => true,
            'has_archive'         => true,
            'rewrite'             => [
                'slug'       => 'team-members',
                'with_front' => false,
            ],
            'exclude_from_search' => false,
            'publicly_queryable'  => true,
            'capability_type'     => 'page',
        ] );

}
add_action( 'init', 'js_school_wp_register_team_member_cpt', 0 );
