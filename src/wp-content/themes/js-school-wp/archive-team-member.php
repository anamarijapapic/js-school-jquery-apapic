<?php
/**
 * The template for displaying archive page for custom post type team-member
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package JS_School_WP
 */

use function JsSchoolWp\Inc\Shared\render;

get_header();

echo render( 'template-parts/team-members/archive/archive', [ 'query' => $wp_query ] );

get_footer();
