<?php

namespace JsSchoolWp\Utilities;

use WP_Query;

/**
 * Keeping this function outside the class so self:: is not available in the included template.
 * 
 * @param mixed[] $args
 */
function load_template( string $__template_file__, array $args = [] ) : void {
	require $__template_file__;
}

final class Utilities {

	private function __construct() {}

	// /**
	// * Similar to get_template_part but doesn't load global variables inside the
	// * template so you don't have to worry about overwriting them.
	// * 
	// * @param mixed[] $args
	// */
	// public static function get_template_part( string $slug, array $args = [] ) : void {

	// $template = "{$slug}.php";

	// $template_filepath = '';

	// if ( \file_exists( \STYLESHEETPATH . '/' . $template ) ) {
	// $template_filepath = \STYLESHEETPATH . '/' . $template;
	// } elseif ( \file_exists( \TEMPLATEPATH . '/' . $template ) ) {
	// $template_filepath = \TEMPLATEPATH . '/' . $template;
	// } elseif ( \file_exists( \ABSPATH . \WPINC . '/theme-compat/' . $template ) ) {
	// $template_filepath = \ABSPATH . \WPINC . '/theme-compat/' . $template;
	// }

	// if ( $template_filepath ) {
	// \JsSchoolWp\Utilities\load_template( $template_filepath, $args );
	// }
	// }

	/**
	 * Similar to get_template_part but doesn't load global variables inside the
	 * template so you don't have to worry about overwriting them.
	 * Returns an HTML string instead of outputting it.
	 * 
	 * @param mixed[] $args
	 */
	public static function render( string $slug, array $args = [] ) : string {
		\ob_start();
		\JsSchoolWp\Utilities\load_template( \get_stylesheet_directory() . '/' . $slug . '.php', $args );
		return (string) \ob_get_clean();
	}

	/**
	 * Returns the primary term for a given post and a given taxonomy.
	 *
	 * @param  string                  $tax
	 * @param  null|int|\WP_Post       $post
	 * @return null|\WP_Term
	 */
	public static function get_post_primary_term( $tax, $post = null ) {
		$post = \get_post( $post );
		if ( $post instanceof \WP_Post ) {
			if ( \class_exists( '\\WPSEO_Primary_Term' ) ) {
				$terms = new \WPSEO_Primary_Term( $tax, $post->ID );
				$term_id = $terms->get_primary_term();
				if ( \is_int( $term_id ) && $term_id ) {
					$term = \get_term( $term_id, $tax );
					return $term instanceof \WP_Term ? $term : null;
				}
			}
			$terms = \wp_get_post_terms( $post->ID, $tax );
			if ( \is_array( $terms ) && $terms ) {
				return $terms[0];
			}
		}
		return null;
	}

	/**
	 * Wrapper around wp_enqueue_script() that generates the version automatically.
	 *
	 * @param string   $handle
	 * @param string   $src       Filepath relative to the current theme folder, eg. "assets/js/main.js".
	 * @param string[] $deps
	 * @param bool     $in_footer
	 */
	public static function wp_enqueue_script( $handle, $src, $deps = [], $in_footer = false ) : void {

		$src = \get_stylesheet_directory_uri() . '/' . $src;
		$filepath = \str_replace( \get_stylesheet_directory_uri(), \get_stylesheet_directory(), $src );

		if ( \file_exists( $filepath ) ) {
			\wp_enqueue_script( $handle, $src, $deps, (string) \filemtime( $filepath ), $in_footer );
		}
	}

	/**
	 * Wrapper around wp_enqueue_style() that generates the version automatically.
	 *
	 * @param string   $handle
	 * @param string   $src    Filepath relative to the current theme folder, eg. "assets/css/main.css".
	 * @param string[] $deps
	 * @param string   $media
	 */
	public static function wp_enqueue_style( $handle, $src, $deps = [], $media = 'all' ) : void {

		$src = \get_stylesheet_directory_uri() . '/' . $src;
		$filepath = \str_replace( \get_stylesheet_directory_uri(), \get_stylesheet_directory(), $src );

		if ( \file_exists( $filepath ) ) {
			\wp_enqueue_style( $handle, $src, $deps, (string) \filemtime( $filepath ), $media );
		}
	}

	/**
	 * Sprite function.
	 *
	 * Example of usage:
	 * ```php
	 * <?php echo sprite( 'checkmark', 'u-fill-current' ); ?>
	 * ```
	 *
	 * @param string  $name    SVG icon name.
	 * @param string  $classes Additional classes.
	 * @return string
	 */
	public static function sprite( $name, $classes = '' ) : string {
		$filepath = \get_stylesheet_directory() . '/assets/sprite/icons.svg';
		$version = \file_exists( $filepath ) ? ( (string) \filemtime( $filepath ) ) : '';
		$uri = \get_stylesheet_directory_uri() . '/assets/sprite/icons.svg?ver=' . $version . '#icon-' . $name;

		return '<svg class="o-icon ' . $classes . '"><use xmlns:xlink="http://www.w3.org/1999/xlink" xlink:href="' . esc_url( $uri ) . '"></use></svg>';
	}

	public static function get_image_src( int $image_id, string $size = 'thumbnail' ) : ?string {
		$src = \wp_get_attachment_image_src( $image_id, $size );
		return $src ? $src[0] : null;
	}

	/**
	 * Convert an HTML string to plain text.
	 */
	public static function html2text( string $html ) : string {
		$html = \wp_strip_all_tags( $html, true );
		$html = \html_entity_decode( $html, \ENT_COMPAT, 'UTF-8' );
		return $html;
	}

	/**
	 * Get post excerpt (or content if excerpt is not defined),
	 * and then return the first $length characters.
	 * 
	 * @param int|\WP_Post $post
	 */
	public static function get_excerpt( $post, int $length = 125 ) : string {

		if ( ! $post ) {
			return '';
		}

		$post = \get_post( $post );

		$excerpt = '';

		if ( $post instanceof \WP_Post ) {

			$excerpt = $post->post_excerpt ? $post->post_excerpt : $post->post_content;
			$excerpt = self::html2text( $excerpt );
	
			if ( \mb_strlen( $excerpt, 'UTF-8' ) > $length ) {
				$excerpt = \mb_substr( $excerpt, 0, $length - 3, 'UTF-8' ) . '...';
			}
		}

		return $excerpt;
	}
}
