<?php
/**
 * Rodesk admin core.
 *
 * Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 *
 * @package             rodesk-admin-core
 * @author              Jasper Rooduijn <jasper@rodesk.com>
 * @link                http://Rodesk.com
 * @copyright           2014 Rodesk B.V.
 *
 * @wordpress-plugin
 * Plugin Name:       	Rodesk Admin Core
 * Plugin URI:        	http://www.Rodesk.com
 * Description:       	Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 * Version:           	2.1.5
 * Author URI: 			http://www.rodesk.com
 * Author: 				Rodesk BV
 * Text Domain:       	rodesk-admin-core
 * Domain Path:       	/languages
**/

/**
* TODO LIST
* Remove content from DB on uninstall (if requested)
* Rename all functions from twhoog to rodesk
**/

/*----------------------------------------------------------------------------*
 * Protection for the plugin
 *----------------------------------------------------------------------------*/

if(!defined('WPINC')) // MUST have WordPress.
	exit('Do NOT access this file directly: '.basename(__FILE__));

/*----------------------------------------------------------------------------*
 * Load several core plugins/classes
 *----------------------------------------------------------------------------*/

// Load the cleaup class
if ( file_exists( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-cleanup.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-cleanup.php' );
}

// Load the init class
if ( file_exists( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-init.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-init.php' );
}

// Load the dashboard class
if ( !class_exists( 'twhoog_admin_core_dashboard' ) && file_exists( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-dashboard.php' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-dashboard.php' );
}

// Load the login class
if ( !class_exists( 'twhoog_admin_core_login' ) && file_exists( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-login.php' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-login.php' );
}

// Load the rewrites options
if ( !class_exists( 'twhoog_admin_core_rewrites' ) && file_exists( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-rewrites.php' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-rewrites.php' );
}

// Load the WPThumb plugin
if ( !class_exists( 'WP_Thumb' ) && file_exists( plugin_dir_path( __FILE__ ) . 'plugins/WPThumb/wpthumb.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'plugins/WPThumb/wpthumb.php' );
}

// Load the image functions
if ( !class_exists( 'twhoog_admin_core_images' ) && file_exists( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-images.php' ) ) {
	require_once( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-images.php' );
}

// If Yoast WP SEO plugin is active load this class to clean it up
// Load the default theme functions
if ( !class_exists( 'twhoog_admin_core_cleanup_yoast' ) && file_exists( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-cleanup-yoast.php' ) ) {

    $plugins = get_option( 'active_plugins' );
	$required_plugin = 'wordpress-seo/wp-seo.php';

	// Check if Yoast WP SEO is installed and active
	if ( in_array( $required_plugin , $plugins ) ) {
		require_once( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-cleanup-yoast.php' );
	}
}

// Load the default theme functions
if ( file_exists( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-functions.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'admin/rodesk-admin-core-functions.php' );
}

/*----------------------------------------------------------------------------*
 * Main core class
 *----------------------------------------------------------------------------*/

require_once( plugin_dir_path( __FILE__ ) . 'public/rodesk-admin-core.php' );
