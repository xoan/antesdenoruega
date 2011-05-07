<?php
define('ROOT_PATH', dirname(__FILE__));
define('CONF_PATH', ROOT_PATH.'/config');
define('APP_PATH', ROOT_PATH.'/application');
define('LIB_PATH', ROOT_PATH.'/libraries');

include CONF_PATH.'/config.php';
include CONF_PATH.'/functions.php';

$db = $config['db'][ENV];
$database = new fDatabase($db['type'], $db['name'], $db['user'], $db['pass'], $db['host']);
fORMDatabase::attach($database);

fSession::open();

include CONF_PATH.'/route.php';
