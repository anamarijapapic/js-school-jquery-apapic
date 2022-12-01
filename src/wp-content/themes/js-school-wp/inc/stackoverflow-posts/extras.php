<?php

function js_school_wp_handle_ajax_load_stackoverflow_tag_data() : void {
    $tag_name = $_REQUEST['tag_name'] ?? '';
    
	$my_term = get_term_by( 'name', $tag_name, 'post_tag' );

    $followers = get_field( 'followers', $my_term ) ?? 0;
    $questions = $my_term->count;
    $description = term_description( $my_term->term_id );

	$header = "<small>$followers followers, $questions questions</small>";
    $body = "<small>$description</small>";

	wp_send_json( [
		'success' => true,
		'popover_header'  => $header,
        'popover_body'    => $body,
	], 200 );
}
add_action( 'wp_ajax_nopriv_js_school_wp_load_stackoverflow_tag_data', 'js_school_wp_handle_ajax_load_stackoverflow_tag_data' );
add_action( 'wp_ajax_js_school_wp_load_stackoverflow_tag_data', 'js_school_wp_handle_ajax_load_stackoverflow_tag_data' );
