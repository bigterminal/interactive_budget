<?
// define directory separator
define('DS', DIRECTORY_SEPARATOR);

// define application/ directory, relative to THIS directory
define('APP_PATH', dirname(dirname(__FILE__)).DS);

// define public/ & private/ directories
define('PUBLIC_PATH', APP_PATH.'public'.DS);
define('PRIVATE_PATH', APP_PATH.'private'.DS);

// define includes/ directory
define('INCLUDE_PATH', PRIVATE_PATH.'includes'.DS);

// require includes.php
require_once(PRIVATE_PATH.'includes.php');

// resolve route & render response
global $routes; $routes->resolve();