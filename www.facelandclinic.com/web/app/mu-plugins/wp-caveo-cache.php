<?php
/**
 * Plugin Name: WP Caveo Cache
 * Plugin URI: https://www.caveo.nl/
 * Description: WP Caveo Cache, manages your server caching system. This plugin only works in combination with caveo wordpress hosting
 * Version: 1.2
 * Author: Caveo Internet B.V., Quirinus de Munnik, Clifford James van den Bos, Martin de Bruijn
 * Author URI: https://www.caveo.nl/
 * Text Domain: wp-caveo-cache
 **/

// force enabling SSL for mixed content issues due to proxy
$_SERVER['HTTPS']='off';

if (! defined('ABSPATH')) {
	die('No direct access allowed');
}

// Checks if we're recaching...
if (isset($_SERVER['HTTP_X_CCM']) && $_SERVER['HTTP_X_CCM'] == 'true') {
    return;
}

// checks wether we're already loaded!
if (! class_exists('WP_Caveo_Cache')) {
	define('WPCC_VERSION', '1.2');
	define('WPCC_ADMIN_URL', admin_url('admin.php?page=wp-caveo-cache-plugin'));
	define('WPCC_PLUGIN_URL', plugins_url('/wp-caveo-cache/', __FILE__));
	define('WPCC_PLUGIN_MAIN_PATH', plugin_dir_path(__FILE__) . 'wp-caveo-cache/');

	// includes ouder wordpress (builder) class
	require_once('wp-caveo-cache/class.wp-caveo-cache.php');
}

// initialise our wordpress (builder) class.
require_once('wp-caveo-cache/init.wp-caveo-cache.php');
