<?php
/**
 * Rodesk admin core dashboard.
 *
 * Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 *
 * @package   rodesk-admin-core
 * @author    Rodesk BV <interactie@rodesk.nl>
 * @link      http://rodesk.nl
 * @copyright 2015 Rodesk BV
 */

class rodesk_admin_core_login {

    protected $plugin_slug = 'rodesk-admin-core';

    // construct the class
    public function __construct() {
        add_action( 'login_head', array( &$this , 'rodesk_custom_login_logo' ) ); // load custom login logo
        add_filter( 'login_headerurl', array( &$this , 'rodesk_custom_loginlogo_url' ) );
        add_filter( 'login_headertext', array( &$this , 'rodesk_custom_login_title' ) );
    }

    // load custom login logo
    public function rodesk_custom_login_logo() {
    echo '
        <style type="text/css">
            h1 a {
                background-image:url(' . plugin_dir_url( __FILE__ ) . '/assets/logo-en-masse.png) !important;
                height: 87px !important;
                width: 200px !important;
                background-size: 200px 35px !important;
                background-position: bottom center !important;
            }
        </style>';
    }

    // load custom login logo URL
    public function rodesk_custom_loginlogo_url($url) {
        return get_bloginfo('url');
    }

    // load custom login logo TITLE
    public function rodesk_custom_login_title () {
        return get_bloginfo ('name');
    }
}
?>
