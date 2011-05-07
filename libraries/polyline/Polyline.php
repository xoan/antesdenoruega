<?php
// Miguel Perez
// This is my implementation of unichr() - chr() adapted for unicode
function unichr($c) {
    if ($c <= 0x7F) {
        return chr($c);
    } else if ($c <= 0x7FF) {
        return chr(0xC0 | $c >> 6) . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0xFFFF) {
        return chr(0xE0 | $c >> 12) . chr(0x80 | $c >> 6 & 0x3F)
                                    . chr(0x80 | $c & 0x3F);
    } else if ($c <= 0x10FFFF) {
        return chr(0xF0 | $c >> 18) . chr(0x80 | $c >> 12 & 0x3F)
                                    . chr(0x80 | $c >> 6 & 0x3F)
                                    . chr(0x80 | $c & 0x3F);
    } else {
        return false;
    }
}

// For debug purposes
define('debug', 0);
function debug() {
	if (!debug)
		return;
	
	$args = func_get_args();
	echo implode(' , ', $args);
	echo '<br/>';
}
// Polyline class (beta), by Andreas Kalsch
// license: GPL
class Polyline {
	
	function __construct(array $points = array()) {
		
		$this->points = $points;
	}
	
	protected $points;
	
	function getPoints() {
		
		return $this->points;
	}
	
	function encode() {
		
		debug('encode()');

		$plat = 0;
		$plng = 0;
		
		$encoded_points = '';
		$encoded_levels = '';
		
		for ($i = 0; $i < count($this->points); ++$i) {
			
			$point = $this->points[$i];
			$lat = $point[0];
			$lng = $point[1];
			// $level = ... 
			
			debug('	lat', $lat);
			debug('	lng', $lng);
			
			$late5 = floor($lat * 1e5);
			$lnge5 = floor($lng * 1e5);
		
			debug('	lat5', $late5);
			debug('	lng5', $lnge5);
			
			$dlat = $late5 - $plat;
			$dlng = $lnge5 - $plng;
			
			$plat = $late5;
			$plng = $lnge5;
			
			$encoded_points .= self::encodeSignedNumber($dlat).self::encodeSignedNumber($dlng);
			//$encoded_levels += $encodeNumber(level);
		}
		
		debug('	result', $encoded_points);
		
		return $encoded_points;
	}
	
		// Encode a signed number in the encode format.
	protected static function encodeSignedNumber($number) {
	
		debug('encodeSignedNumber()', $number);
		
		$signedNumber = $number << 1;
		
		if ($number < 0) {
		
			$signedNumber = ~($signedNumber);
		}
		
		debug('	result', $signedNumber);
	
		return self::encodeNumber($signedNumber);
	}

	// Encode an unsigned number in the encode format.
	protected static function encodeNumber($number) {
	
		debug('encodeNumber()', $number);
		
		$encodeString = '';
		
		while ($number >= 0x20) {
			
			$encodeString .= (unichr((0x20 | ($number & 0x1f)) + 63));
			$number >>= 5;
		}
		
		$encodeString .= (unichr($number + 63));
		
		debug('	result', $encodeString);
		
		return $encodeString;
	}
}
