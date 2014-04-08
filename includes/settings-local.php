<?php
/*
* turn on all errors for development
*/
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);

/*
 * Site-specific.
 */
define('SITE_URL', 'http://tophat.localhost');
define('SITE_TITLE', 'shaun persad.');
define('TIMEZONE', 'America/New_York');
define('GOOGLE_ANALYTICS_CODE', 'UA-31591500-1');
define('FB_APP_ID', '751142364925926');
define('PUBLIC_FACING_NAMESPACE', 'PublicFacing');
define('ADMIN_NAMESPACE', 'Admin');

/*
 * Database credentials.
 */
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_NAME', 'tophat');
define('DB_DRIVER', 'pdo_mysql');

/*
 * Cache (optional)
 */

define('CACHE_DRIVER', CACHE_DRIVER_APC);

//define('MEMCACHE_HOST', 'localhost');
//define('MEMCACHE_PORT', '11211');

/*
 * Searching (optional)
 */
define('SOLR_HOST', 'localhost');
define('SOLR_PORT', '8080');
define('SOLR_PATH', '/solr');