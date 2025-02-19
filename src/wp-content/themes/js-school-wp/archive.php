<?php
/**
 * The template for displaying archive pages
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JS_School_WP
 */

use function JsSchoolWp\Inc\Shared\render;

get_header();

echo render( 'template-parts/stackoverflow-posts/archive/archive', [ 'query' => $wp_query ] );

get_footer();
