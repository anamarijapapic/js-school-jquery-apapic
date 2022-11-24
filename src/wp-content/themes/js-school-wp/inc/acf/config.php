<?php

add_filter( 'acf/settings/save_json', 'js_school_wp_acf_json_save_point' );

function js_school_wp_acf_json_save_point( $path ) {
	
	// update path
	$path = get_stylesheet_directory() . '/inc/acf/acf-json';

	// return
	return $path;
	
}

add_filter( 'acf/settings/load_json', 'js_school_wp_acf_json_load_point' );

function js_school_wp_acf_json_load_point( $paths ) {
	
	// remove original path (optional)
	unset( $paths[0] );

	// append path
	$paths[] = get_stylesheet_directory() . '/inc/acf/acf-json';

	// return
	return $paths;
	
}
