<?php

spl_autoload_register(function ($class) {
    // project-specific namespace prefix
	$prefix = 'JsSchoolWp\\';

	// base directory for the namespace prefix
	$base_dir = __DIR__ . '/src/JsSchoolWp/';

	// does the class use the namespace prefix?
	$len = strlen( $prefix );
	if ( strncmp( $prefix, $class, $len ) !== 0 ) {
		// no, exit
		return;
	}

	// get the relative class name
	$relative_class = substr( $class, $len );

	// replace the namespace prefix with the base directory, replace namespace
	// separators with directory separators in the relative class name, append .php
	$file = $base_dir . str_replace( '\\', '/', $relative_class ) . '.php';

	require $file;
});
