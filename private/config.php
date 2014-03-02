<?
// define the site's URL
define('SITE_URL', 'http://interactivebudget.local');

// define enviroment specific info
define('MODE', 'DEVELOPMENT'); // ['DEVELOPMENT', 'STAGING', 'PRODUCTION']
define('DEBUG', false);
define('CACHE', true);

// define MySQL database info
define('DB_NAME', 'interactivebudget');
define('DB_HOST', 'localhost');
define('DB_USER', 'dev');
define('DB_PASS', 'younotry');

// define common paths
define('MODEL_PATH', PRIVATE_PATH.'models'.DS);
define('CONTROLLER_PATH', PRIVATE_PATH.'controllers'.DS);
define('LIBRARY_PATH', PRIVATE_PATH.'libraries'.DS);
define('TEMPLATE_PATH', PRIVATE_PATH.'templates'.DS);
define('DATA_PATH', PRIVATE_PATH.'data'.DS);

// set default timezone
date_default_timezone_set('America/Toronto');