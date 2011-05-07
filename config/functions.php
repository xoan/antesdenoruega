<?php
function __autoload($class)
{
	$dirs = array(
		LIB_PATH.'/flourish/classes',
		LIB_PATH.'/moor',
		APP_PATH.'/models',
		APP_PATH.'/controllers'
	);
	foreach ($dirs as $dir) {
		if (file_exists($file = $dir.'/'.$class.'.php')) {
			return require $file;
		}
	}
	throw new Exception('The class '.$class.' could not be loaded');
}

function not_found() {
	header('HTTP/1.0 404 Not Found');
	exit('<h1>404 Not Found</h1>'."\n".
	'<p>The page that you have requested could not be found.</p>'."\n");
}
