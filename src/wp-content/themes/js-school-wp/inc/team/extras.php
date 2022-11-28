<?php

use function JsSchoolWp\Inc\Shared\render;

define( 'JS_SCHOOL_WP_TEAM_MEMBERS_PER_PAGE', 10 );

function js_school_wp_handle_ajax_load_more_team_members() : void {
	$page = (int) ( $_GET['js_school_wp_page'] ?? 1 );

	$query = new WP_Query( [
		'post_type'      => 'team-member',
		'posts_per_page' => JS_SCHOOL_WP_TEAM_MEMBERS_PER_PAGE,
		'paged'          => $page,
		'post_status'    => 'publish',
	] );

	$html = '';

	if ( $query->have_posts() ) {
		foreach ( $query->posts as $post ) {
			$html .= render( 'template-parts/team-members/archive/loop-item', [ 'post' => $post ] );
		}
	}

	wp_send_json( [
		'success'     => true,
		'page'        => $page,
		'post_count'  => $query->post_count,
		'found_posts' => $query->found_posts,
		'max_page' 	  => $query->max_num_pages,
		'data'    	  => $html,
	], 200 );
}
add_action( 'wp_ajax_nopriv_js_school_wp_load_more_team_members', 'js_school_wp_handle_ajax_load_more_team_members' );
add_action( 'wp_ajax_js_school_wp_load_more_team_members', 'js_school_wp_handle_ajax_load_more_team_members' );
