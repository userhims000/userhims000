<?php
$root_dir = dirname(__DIR__);
$webroot_dir = $root_dir . '/web';

/**
 * Expose global env() function from oscarotero/env
 */
Env::init();

/**
 * Use Dotenv to set required environment variables and load .env file in root
 */
$dotenv = new Dotenv\Dotenv($root_dir);
if (file_exists($root_dir . '/.env')) {
  $dotenv->load();
  $dotenv->required(['DB_NAME', 'DB_USER', 'DB_PASSWORD', 'WP_HOME', 'WP_SITEURL']);
}

/**
 * Set up our global environment constant and load its config first
 * Default: development
 */
define('WP_ENV', env('WP_ENV') ?: 'development');

$env_config = __DIR__ . '/environments/' . WP_ENV . '.php';

if (file_exists($env_config)) {
  require_once $env_config;
}

/**
 * URLs
 */
define('WP_HOME', env('WP_HOME'));
define('WP_SITEURL', env('WP_SITEURL'));

/**
 * Custom Content Directory
 */
define('CONTENT_DIR', '/app');
define('WP_CONTENT_DIR', $webroot_dir . CONTENT_DIR);

/**
 * Custom Content URL
 */

$wp_content_url = env('WP_CONTENT_URL') ? env('WP_CONTENT_URL') : WP_HOME . CONTENT_DIR;
define('WP_CONTENT_URL', $wp_content_url );

//define('CONCATENATE_SCRIPTS', true); 

/**
 * Force https for admin
 */

//if(!empty(env('FORCE_SSL_ADMIN'))) {

  /* SSL Settings */
  //define('FORCE_SSL_ADMIN', true);

  //if(isset($_SERVER['HTTP_X_FORWARDED_PROTO'])){
      /* Turn HTTPS 'on' if HTTP_X_FORWARDED_PROTO matches 'https' */
      //if (strpos($_SERVER['HTTP_X_FORWARDED_PROTO'], 'https') !== false) {
          //$_SERVER['HTTPS'] = 'on';
      //}
  //}

//}

/**
 * Custom Upload Directory
 */
// Do not use this constant.
// Setting this will overwrite the custom upload path and URL setting in DB
// This constant work relative to ABSPATH and will make a mess
// Therefor we customly set a upload path and URL in the DB
// See assets-function.php (function rodesk_upload_path) for more info
// define('UPLOADS', '../app/assets');

/**
 * DB settings
 */
define('DB_NAME', env('DB_NAME'));
define('DB_USER', env('DB_USER'));
define('DB_PASSWORD', env('DB_PASSWORD'));
define('DB_HOST', env('DB_HOST') ?: 'localhost');
define('DB_CHARSET', 'utf8');
define('DB_COLLATE', '');
$table_prefix = env('DB_PREFIX') ?: 'rodesk_';

/**
 * Authentication Unique Keys and Salts
 */
define('AUTH_KEY', env('AUTH_KEY'));
define('SECURE_AUTH_KEY', env('SECURE_AUTH_KEY'));
define('LOGGED_IN_KEY', env('LOGGED_IN_KEY'));
define('NONCE_KEY', env('NONCE_KEY'));
define('AUTH_SALT', env('AUTH_SALT'));
define('SECURE_AUTH_SALT', env('SECURE_AUTH_SALT'));
define('LOGGED_IN_SALT', env('LOGGED_IN_SALT'));
define('NONCE_SALT', env('NONCE_SALT'));

/**
 * Custom Settings
 */
define('DISALLOW_FILE_EDIT', true);
define('AUTOMATIC_UPDATER_DISABLED', true);
define('DISABLE_WP_CRON', env('DISABLE_WP_CRON') ? true : false);
define('WP_POST_REVISIONS', env('WP_POST_REVISIONS') ? true : false);
define('WP_MEMORY_LIMIT', '512M');
define('ALLOW_UNFILTERED_UPLOADS', true);

//define( 'WP_SENTRY_PHP_DSN', 'https://2e10aa6636ec1c605ed5b4b4179c19fa@o45680.ingest.sentry.io/4506619421261824' );
//define( 'WP_SENTRY_BROWSER_TRACES_SAMPLE_RATE', 1.0 );
//define( 'WP_SENTRY_BROWSER_REPLAYS_ON_ERROR_SAMPLE_RATE', 1.0 );
// You can _optionally_ enable or disable the JavaScript tracker in certain parts of your site with these constants:
//define('WP_SENTRY_BROWSER_ADMIN_ENABLED', true);    // Add the JavaScript tracker to the admin area. Default: true
//define('WP_SENTRY_BROWSER_LOGIN_ENABLED', true);    // Add the JavaScript tracker to the login page. Default: true
//define('WP_SENTRY_BROWSER_FRONTEND_ENABLED', true); // Add the JavaScript tracker to the front end. Default: true

/**
 * Bootstrap WordPress
 */
if (!defined('ABSPATH')) {
  define('ABSPATH', $webroot_dir . '/cms/');
}

