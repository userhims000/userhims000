<?php
/**
 * Rodesk admin core rewrites.
 *
 * Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 *
 * @package   rodesk-admin-core
 * @author    Rodesk BV <interactie@rodesk.nl>
 * @link      http://rodesk.nl
 * @copyright 2015 Rodesk BV
 */

class rodesk_admin_core_rewrites {

    private static $path; // Setup path, doubles as a singleton class
    protected $plugin_slug = 'rodesk-admin-core';

    // Construct the class
    public function __construct() {

        // if ( ! isset( self::$path ) ) { return; }
        // self::$path = $path;

        // Define some vars
        $get_theme_name = explode('/themes/', get_template_directory());
        $home_url = array(home_url('/', 'http'), home_url('/', 'https'));

        // Define constants
        define('RELATIVE_PLUGIN_PATH',  str_replace( WP_CONTENT_URL . '/', '', plugins_url()));
        define('RELATIVE_CONTENT_PATH', str_replace( WP_CONTENT_URL . '/', '', content_url()));
        define('THEME_NAME',            str_replace( '/templates', '', next( $get_theme_name ) ) );
        define('THEME_PATH',            RELATIVE_CONTENT_PATH . '/themes/' . THEME_NAME . '/assets');

        // Run the actions
        add_action( 'init', array( &$this, 'rodesk_login_rewrite' ) ); // Add nice login url for dashboard login screen;
        add_action('admin_init', array( &$this, 'rodesk_htaccess_writable' ) ); // Check for htaccess and give error when needed
        add_action('generate_rewrite_rules', array( &$this, 'rodesk_add_h5bp_htaccess' ) ); // Add HTML boilerplate htaccess file
        add_action('generate_rewrite_rules', array( &$this, 'rodesk_add_rewrites_htaccess' ) ); // Add custom redirects to htaccess file

        // Run the rewrite function for backend and frontend
        if ( is_admin() ) {
            add_action('admin_init', array($this, 'backend'));
        } else {
            add_action('after_setup_theme', array($this, 'frontend'));
        }

    }

    // Nice login URL
    public function rodesk_login_rewrite() {
        add_rewrite_rule( 'login/?$', 'wp-login.php', 'top' );
    }

    // Show an admin notice if .htaccess isn't writable
    public function rodesk_htaccess_writable() {
        if (!is_writable(get_home_path() . '.htaccess')) {
            if (current_user_can('administrator')) {
                // add_action('admin_notices', create_function('', "echo '<div class=\"error\"><p>" . sprintf(__('Please note (and check) if the <strong>.htaccess</strong> has the appropriate permissions and is writable.', $this->plugin_slug ), admin_url('options-permalink.php')) . "</p></div>';"));
            }
        }
    }

    // Add the contents of h5bp-htaccess into the .htaccess file
    public function rodesk_add_h5bp_htaccess($content) {
        global $wp_rewrite;
        $home_path = function_exists('get_home_path') ? get_home_path() : ABSPATH;
        $htaccess_file = $home_path . '.htaccess';
        $mod_rewrite_enabled = function_exists('got_mod_rewrite') ? got_mod_rewrite() : false;

        if ((!file_exists($htaccess_file) && is_writable($home_path) && $wp_rewrite->using_mod_rewrite_permalinks()) || is_writable($htaccess_file)) {
          if ($mod_rewrite_enabled) {
            $h5bp_rules = extract_from_markers($htaccess_file, 'HTML5 Boilerplate');
            if ($h5bp_rules === array()) {
              $filename = dirname(__DIR__) . '/plugins/h5bp/h5bp-htaccess';
              return insert_with_markers($htaccess_file, 'HTML5 Boilerplate', extract_from_markers($filename, 'HTML5 Boilerplate'));
            }
          }
        }

        return $content;
    }

    // Add the contents of the redirects.txt file into the .htaccess file
    // This folder is saved in the 'web' directory
    public function rodesk_add_rewrites_htaccess($content) {
        global $wp_rewrite;
        $home_path = function_exists('get_home_path') ? get_home_path() : ABSPATH;
        $htaccess_file = $home_path . '.htaccess';

        $mod_rewrite_enabled = function_exists('got_mod_rewrite') ? got_mod_rewrite() : false;

        if ((!file_exists($htaccess_file) && is_writable($home_path) && $wp_rewrite->using_mod_rewrite_permalinks()) || is_writable($htaccess_file)) {
            if ($mod_rewrite_enabled) {

                $custom_redirect_rules = extract_from_markers($htaccess_file, 'Rodesk custom redirects');

                if( $custom_redirect_rules === array() ) {
                    $filename = dirname( dirname( dirname( dirname(__DIR__) ) ) ) . '/redirects.txt';
                    return insert_with_markers($htaccess_file, 'Rodesk custom redirects', extract_from_markers($filename, 'Rodesk custom redirects'));
                }

            }
        }

        return $content;
    }

    public function frontend() {
        if ($this->disabled() || is_admin()) { return; }
        $tags = array(
          'plugins_url',
          'bloginfo',
          'stylesheet_directory_uri',
          'template_directory_uri',
          'script_loader_src',
          'style_loader_src',
          'rokit/assets/path'
        );

        $this->add_filters($tags, array($this, 'rodesk_clean_urls'));
    }

    public function backend() {
        if ($this->disabled()) { return; }
        global $wp_rewrite;

        $theme_path = str_replace( trailingslashit( get_home_url() ), '', THEME_PATH);

        $rodesk_new_non_wp_rules = [
            'assets/(.*)' => $theme_path . '/$1',
            'plugins/(.*)'     => RELATIVE_PLUGIN_PATH . '/$1'
        ];


        $wp_rewrite->non_wp_rules = array_merge($wp_rewrite->non_wp_rules, $rodesk_new_non_wp_rules );

        return;
    }

    private function add_filters($tags, $function) {
        foreach($tags as $tag) {
          add_filter($tag, $function);
        }
    }

    private function disabled() {
        if (is_multisite() || $this->deactivated()) { return true; }
        return false;
    }

    public function flush_rewrites() {
        flush_rewrite_rules();
    }

    public function rodesk_clean_urls($content) {

        if (strpos($content, RELATIVE_PLUGIN_PATH) > 0) {
            return str_replace('/' . RELATIVE_PLUGIN_PATH,  '/plugins', $content);

        } else {

            $base           = parse_url( WP_CONTENT_URL );
            $wp_content_url = str_replace( $base['path'] , '/', WP_CONTENT_URL);

            return str_replace( THEME_PATH , $wp_content_url . 'assets', $content);

        }

    }

    private function deactivated() {
        $path = plugin_basename(self::$path);
        return did_action('deactivate_' . $path);
    }

}
?>
