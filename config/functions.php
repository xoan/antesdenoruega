<?php
function __autoload($class)
{
	$dirs = array(
		LIB_PATH.'/flourish/classes',
		LIB_PATH.'/moor',
		LIB_PATH.'/polyline',
		LIB_PATH.'/phpquery',
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

function link_to()
{
	$args = func_get_args();
	return call_user_func_array(
		'Moor::linkTo', $args
	);
}

function round_and_reverse_coords($point, $array = false)
{
	$point = array_reverse(array_map('round', explode(',', $point), array(4, 4)));
	return ($array) ? $point : join(',', $point);
}

function encode_polyline($points)
{
	if (count($points) > 500) {
		$encoder = new PolylineEncoder();
		$polyline = $encoder->encode($points);
		$path = $polyline->points;
	} else {
		$polyline = new Polyline($points);
		$path = $polyline->encode();
	}
	return 'enc:'.$path;
}

function get_data($url)
{
	$ch = curl_init();
	$timeout = 5;
	curl_setopt($ch, CURLOPT_URL, $url);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
	curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
	$data = curl_exec($ch);
	curl_close($ch);
	return $data;
}
