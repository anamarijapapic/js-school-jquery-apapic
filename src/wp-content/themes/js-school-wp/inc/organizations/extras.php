<?php

define( 'JS_SCHOOL_WP_ORGANIZATIONS_PER_PAGE', 10 );

function js_school_wp_handle_ajax_load_autocomplete() : void {
    $page = (int) ( $_GET['js_school_wp_page'] ?? 1 );
    $blog_id = (int) ( $_GET['blog_id'] ?? 1 );

	$query = new WP_Query( [
		'post_type'      => 'organization',
		'posts_per_page' => JS_SCHOOL_WP_ORGANIZATIONS_PER_PAGE,
		'paged'          => $page,
		'post_status'    => 'publish',
        's'              => $_GET['keyword'] ?? null,
	] );

	$html = '';

	$organizations_json = [];
	if ( $query->have_posts() ) {
		foreach ( $query->posts as $post ) {
			array_push( $organizations_json, [
				'id'   => $post->ID,
				'name' => $post->post_title,
				'date_published' => $post->post_date,
				'date_modified'  => $post->post_modified,
			] );
		}
	}

	usort( $organizations_json, function( $a, $b ) { return strnatcasecmp( $a['name'], $b['name'] ); } );

	foreach ( $organizations_json as $post ) {
		$organization_name = get_the_title( $post['id'] );
		$escaped_organization_name = json_encode( $organization_name );
		$html .= "<button type='button' class='list-group-item list-group-item-action' onclick='selectOrganization($escaped_organization_name);'>{$organization_name}</button>";
	}

	if ( $blog_id === JS_SCHOOL_WP_2_SUBSITE_ID ) {
		// Enable CORS - any domain
		header( 'Access-Control-Allow-Origin: *' );
	}

	wp_send_json( [
		'success'     => true,
		'page'        => $page,
		'post_count'  => $query->post_count,
		'found_posts' => $query->found_posts,
		'max_page' 	  => $query->max_num_pages,
		'html'    	  => $html,
		'data'		  => $organizations_json,
		'blog_id'	  => $blog_id,
	], 200 );
}
add_action( 'wp_ajax_nopriv_js_school_wp_load_autocomplete', 'js_school_wp_handle_ajax_load_autocomplete' );
add_action( 'wp_ajax_js_school_wp_load_autocomplete', 'js_school_wp_handle_ajax_load_autocomplete' );
