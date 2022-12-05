<?php

define( 'JS_SCHOOL_WP_ORGANIZATIONS_PER_PAGE', 10 );

function js_school_wp_handle_ajax_load_autocomplete() : void {
    $page = (int) ( $_GET['js_school_wp_page'] ?? 1 );

	$query = new WP_Query( [
		'post_type'      => 'organization',
		'posts_per_page' => JS_SCHOOL_WP_ORGANIZATIONS_PER_PAGE,
		'paged'          => $page,
		'post_status'    => 'publish',
        's'              => $_GET['keyword'] ?? null,
	] );

	$html = '';

	if ( $query->have_posts() ) {
		foreach ( $query->posts as $post ) {
            $escaped_organization_name = json_encode( $post->post_title );
			$html .= "<button type='button' class='list-group-item list-group-item-action' onclick='selectOrganization($escaped_organization_name);'>{$post->post_title}</button>";
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
add_action( 'wp_ajax_nopriv_js_school_wp_load_autocomplete', 'js_school_wp_handle_ajax_load_autocomplete' );
add_action( 'wp_ajax_js_school_wp_load_autocomplete', 'js_school_wp_handle_ajax_load_autocomplete' );
