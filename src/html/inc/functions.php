<?php
/**
 * Frontend functions.
 *
 * @package WebStarter
 */

/**
 * Sprite function.
 *
 * Example of usage:
 * ```php
 * <?php sprite('checkmark', 'u-fill-current'); ?>
 * ```
 *
 * @param string  $name    SVG icon name.
 * @param string  $classes Additional classes.
 * @param boolean $echo    Echo or return.
 * @return void|string
 */
function sprite( $name, $classes = '', $echo = true ) {
	$path   = "/html/sprite/icons.svg#icon-$name";
	$output = "<svg class=\"o-icon {$classes}\"><use xmlns:xlink=\"http://www.w3.org/1999/xlink\" xlink:href=\"{$path}\"></use></svg>";

	if ( ! $echo ) {
		return $output;
	}

	echo $output; // WPCS: xss ok.
}
