<?php
/*
 * All global definitions
 */

define('MODE_LOCAL', 1);
define('MODE_DEV', 2);
define('MODE_PRODUCTION', 3);

define('CACHE_DRIVER_APC', 'APC');
define('CACHE_DRIVER_MEMCACHE', 'memcache');
define('CACHE_DRIVER_MEMCACHED', 'memcached');
define('CACHE_DRIVER_XCACHE', 'xcache');

define('MODE', MODE_LOCAL);

define('INCLUDES_DIR', dirname(__FILE__));

if (MODE == MODE_PRODUCTION) {

    require INCLUDES_DIR.'/settings-production.php';

} elseif (MODE == MODE_DEV) {

    require INCLUDES_DIR.'/settings-dev.php';

} else {

    require INCLUDES_DIR.'/settings-local.php';
}


define('MYSQL_DATETIME_FORMAT', 'Y-m-d H:i:s');

$script_base = '';

$url_pieces = explode('://', SITE_URL);

if (!empty($url_pieces[1])) {

    $script_base = '//'.$url_pieces[1];
}

/*
 * The base URL to include javascript/css scripts.
 */
define('SCRIPT_BASE', $script_base);

/*
 * The root (/) directory location
 */
define('ROOT_DIR', str_replace('includes', '', INCLUDES_DIR));

/*
 * The web root directory location where all files are served from.
 */
define('WEB_DIR', ROOT_DIR.'web'.DIRECTORY_SEPARATOR);


/*
 * base location of the views directory
 */
define('VIEWS_DIR', ROOT_DIR.'views'.DIRECTORY_SEPARATOR.'top-hat'.DIRECTORY_SEPARATOR);

/*
 * base location of the temporary files directory
 */
define('TEMP_DIR', WEB_DIR .'temp'.DIRECTORY_SEPARATOR);

/*
 * base location of the uploaded files directory
 */
define('UPLOADS_DIR', WEB_DIR .'uploads'.DIRECTORY_SEPARATOR);


/*
 * URL of temp directory
 */
define('TEMP_URL', '/temp/');

/*
 * URL of uploads directory
 */
define('UPLOADS_URL', '/uploads/');

date_default_timezone_set(TIMEZONE);

/*
 * Composer autoloader
 * This includes (as necessary) all files installed via composer (/vendor directory),
 * as well as all files in the /controller and /classes directories.
 * Classes should be namespaced, according to the location in the directory.
 */
$loader = require_once ROOT_DIR.'vendor'.DIRECTORY_SEPARATOR.'autoload.php';