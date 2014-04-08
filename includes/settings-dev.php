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
define('SITE_URL', 'http://dev.shaunpersad.com');
define('SITE_TITLE', 'shaun persad.');
define('TIMEZONE', 'America/New_York');
define('GOOGLE_ANALYTICS_CODE', 'UA-31591500-1');
define('FB_APP_ID', '751142364925926');
define('PUBLIC_FACING_NAMESPACE', 'PublicFacing');
define('ADMIN_NAMESPACE', 'Admin');

/*
 * Database credentials.
 */
define('DB_HOST', 'mysql.shaunpersad.com');
define('DB_USER', 'sp_tophat_user');
define('DB_PASSWORD', 'atlantic271');
define('DB_NAME', 'dev_tophat');
define('DB_DRIVER', 'pdo_mysql');

/*
 * Cache
 */

define('CACHE_DRIVER', CACHE_DRIVER_MEMCACHED);

define('MEMCACHE_HOST', 'localhost');
define('MEMCACHE_PORT', '11211');

/*
 * Searching (optional)
 */
define('SOLR_HOST', 'localhost');
define('SOLR_PORT', '8080');
define('SOLR_PATH', '/solr');