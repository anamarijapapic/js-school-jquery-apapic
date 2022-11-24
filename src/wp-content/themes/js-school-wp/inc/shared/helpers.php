<?php

namespace JsSchoolWp\Inc\Shared;

use JsSchoolWp\Utilities\Utilities;

/**
 * Sprite function.
 *
 * Example of usage:
 * ```php
 * <?php echo sprite( 'checkmark', 'u-fill-current' ); ?>
 * ```
 *
 * @param string $name    SVG icon name.
 * @param string $classes Additional classes.
 * @return string
 */
function sprite( $name, $classes = '' ) : string {
	return Utilities::sprite( $name, $classes );
}

function render( string $slug, array $args = [] ) : string {
	return Utilities::render( $slug, $args );
}
