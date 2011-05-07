<?php
define('ENV', 'development');
define('PUB_PATH', dirname(__FILE__));

switch (ENV) {
	case 'development':
	case 'testing':
	case 'production':
	default:
		include '../init.php';
}
