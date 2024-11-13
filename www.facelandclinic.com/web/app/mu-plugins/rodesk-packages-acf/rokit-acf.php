<?php

/**
 * Plugin Name: Rokit ACF modifications
 * Description: Configure and modfify ACF for use in a theme.
 * Text Domain: rokit-acf
 * Domain Path: /languages
 *
 * Plugin URI: https://git.rodesk.nl/packages/acf
 *
 * Author: Joeri Abbo (Rodesk BV)
 * Author URI: https://rodesk.com
 *
 * Version: 1.1.5
 */

// File Security Check
defined('ABSPATH') or die("No script kiddies please!");

/**
 * Load plugin textdomain.
 *
 * @since 1.1.0
 */

function rfcm_load_textdomain() {
    load_muplugin_textdomain( 'rokit-acf', basename( dirname(__FILE__) ) . '/languages' );
}

add_action( 'init', 'rfcm_load_textdomain' );

/**
 * Init the additional flexible content modules functionality
 *
 * @since 1.1.0
 */

add_action('init', array('Rokit\Acf\FlexibleContentModals', 'init')); // Initialize
