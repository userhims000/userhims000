<?php
/**
 * Rodesk admin core.
 *
 * Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 *
 * @package   rodesk-admin-core
 * @author    Rodesk BV <interactie@rodesk.nl>
 * @link      http://rodesk.nl
 * @copyright 2015 Rodesk BV
 */

class rodesk_admin_core {

    // Define some vars
    const VERSION = '1';
    protected $plugin_slug = 'rodesk-admin-core';

    // construct the class
    public function __construct() {

        add_action( 'plugins_loaded', array( &$this, 'load_plugin_textdomain' ) );

        $this->rodesk_cleanup_class(); // Init the cleaup class
        $this->rodesk_init_class(); // Init the init class
        $this->rodesk_dashboard_class(); // Init the dashboard class
        $this->rodesk_login_class(); // Init the login class
        $this->rodesk_rewrites_class(); // Init the rewrite class
        $this->rodesk_images_class(); // Init the images class
        $this->rodesk_cleanup_yoast_class(); // Init the Yoast clean up class
    }

    // return plugin slug
    public function get_plugin_slug() {
        return $this->plugin_slug;
    }

    // Load the custom languages path as the defaul path in load_muplugin_textodomain function doesn't work.
    public function load_plugin_textdomain() {

        $domain             = 'rodesk-admin-core';
        $mu_plugin_rel_path = basename( dirname( __FILE__ ) ) . '/languages';
        $locale             = apply_filters( 'plugin_locale', get_locale(), $domain );
        $mofile             = $domain . '-' . $locale . '.mo';
        $path               = str_replace('public/', '', plugin_dir_path( __FILE__ ) ) . 'languages/';

        return load_textdomain( $domain, $path . $mofile );

    }

    // Load the cleanup class
    public function rodesk_cleanup_class() {
        $rodesk_admin_core_cleanup = new rodesk_admin_core_cleanup();
    }

    // Load the init class
    public function rodesk_init_class() {
        $rodesk_admin_core_init = new rodesk_admin_core_init();
    }

    // Load the dashboard class
    public function rodesk_dashboard_class() {
        $rodesk_admin_core_dashboard = new rodesk_admin_core_dashboard();
    }

    // Load the login class
    public function rodesk_login_class() {
        $rodesk_admin_core_login = new rodesk_admin_core_login();
    }

    // Load the rewrite class
    public function rodesk_rewrites_class() {
        $rodesk_admin_core_rewrites = new rodesk_admin_core_rewrites();
    }

    // Load the images class
    public function rodesk_images_class() {
        $rodesk_admin_core_images = new rodesk_admin_core_images();
    }

    // Load the Yoast clean up class
    public function rodesk_cleanup_yoast_class() {

        $plugins = get_option( 'active_plugins' );
        $required_plugin = 'wordpress-seo/wp-seo.php';

        // Check if Yoast WP SEO is installed and active
        if ( in_array( $required_plugin , $plugins ) ) {
            $rodesk_cleanup_yoast_class = new rodesk_admin_core_cleanup_yoast();
        }
    }


}

$rodesk_admin_core = new rodesk_admin_core();
?>
