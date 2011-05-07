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

function render($data = null, $callback = null, $format = 'html')
{
	static $called = false;
	// don't return if render is called before after_action
	if ($called) {
		return;
	} else {
		$called = true;
	}
	
	// make variables available inside view
	extract($data);
	if (is_null($callback)) {
		$callback = Moor::getActiveCallback();
	}
	$format = fRequest::getValid('format', array($format, 'rss', 'json'));
	$tmpl = new fTemplating(APP_PATH.'/views');
	$tmpl->set(array(
		'header' => 'header.'.$format.'.php',
		'footer' => 'footer.'.$format.'.php'
	));
	$view = APP_PATH.'/views'.Moor::pathTo($callback).'.'.$format.'.php';
	if (file_exists($view)) {
		include $view;
	} else { // raise not_found()
		throw new MoorNotFoundException();
	}
}

function not_found() {
	header('HTTP/1.0 404 Not Found');
	exit('<h1>404 Not Found</h1>'."\n".
	'<p>The page that you have requested could not be found.</p>'."\n");
}

function round_and_reverse_coords($point, $array = false)
{
	$point = array_reverse(array_map('round', explode(',', $point), array(4, 4)));
	return ($array) ? $point : join(',', $point);
}

function get_longitude($coord)
{
        return $coord[0];
}

function get_latitude($coord)
{
        return $coord[1];
}
