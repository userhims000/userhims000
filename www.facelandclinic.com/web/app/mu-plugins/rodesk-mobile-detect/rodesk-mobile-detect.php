<?php
/**
 * Rodesk Mobile Detect.
 *
 * Server side device detection plugin. Based on Mobile Detect.
 *
 * @package   rodesk-mobile-detect
 * @author    Rodesk BV
 * @link      http://rodesk.com
 * @copyright 2014 Rodesk B.V.
 *
 * @wordpress-plugin
 * Plugin Name:       	Rodesk Mobile Detect
 * Plugin URI:        	http://www.Rodesk.com
 * Description:       	Server side device detection plugin. Based on Mobile Detect.
 * Version:           	2.0.7
 * Author URI: 			http://www.rodesk.com
 * Author: 				Rodesk BV
 * Text Domain:       	rodesk-mobile-detect
 * Domain Path:       	/languages
**/

use Rokit\Session\Session;

/*----------------------------------------------------------------------------*
 * Protection for the plugin
 *----------------------------------------------------------------------------*/

if(!defined('WPINC')) // MUST have WordPress.
	exit('Do NOT access this file directly: '.basename(__FILE__));

/*----------------------------------------------------------------------------*
 * Load the Mobile Detect class
 *----------------------------------------------------------------------------*/

if ( file_exists( plugin_dir_path( __FILE__ ) . 'detect-functions.php' ) ) {
    require_once( plugin_dir_path( __FILE__ ) . 'detect-functions.php' );
}

/*----------------------------------------------------------------------------*
 * Load the rokit session package and start a session
 *----------------------------------------------------------------------------*/

// Dot not run when crontask is done
if(!defined( 'DOING_CRON' )) {

	$session = new Session();

	/*----------------------------------------------------------------------------*
	* Define a session var to store device data
	*----------------------------------------------------------------------------*/

	$detect = new Mobile_Detect();

	// Set session variable for the device to false
	$session->set('isTablet', false);
	$session->set('isMobile', false);
	$session->set('isDesktop', false);

	// Set session variable per device
	if( $detect->isTablet() ){
		$session->set('isTablet', true);
	} else if($detect->isMobile()){
		$session->set('isMobile', true);
	} else{
		// if device can't be detected, assume it's desktop.
		$session->set('isDesktop', true);
	}

}

/*----------------------------------------------------------------------------*
 * Function to load (device specific) template snippets
 *----------------------------------------------------------------------------*/

function rodesk_snippet_detector($snippet, $data=array(), $overflow=false, $return=false) {

	// Load the rokit session package
	$session = new Session();

	// Check if website is responsive else just load desktop files
	if(rodesk_is_responsive()) {

		// Set variables used for snippet filename
		if( !empty( $session->get("isTablet") ) ){
			$deviceClass = 'tablet';
		}
		if( !empty( $session->get("isMobile") ) ){
			$deviceClass = 'mobile';
		}
		if( !empty( $session->get("isDesktop") ) ){
			$deviceClass = 'desktop';
		}

		// Load snippet file
		if ($deviceClass == 'tablet' && $overflow == 'tablet=>desktop') {
			return get_template_part('snippets/'. $snippet, 'desktop');
		} elseif($deviceClass == 'mobile') {
			return get_template_part('snippets/'. $snippet);
		} else {
			return get_template_part('snippets/'. $snippet, $deviceClass );
		}

	} else {

		return get_template_part('snippets/'. $snippet, 'desktop');

	}
}
