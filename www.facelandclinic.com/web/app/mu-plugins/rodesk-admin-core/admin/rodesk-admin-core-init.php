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

class rodesk_admin_core_init {

    protected $plugin_slug = 'rodesk-admin-core';

    // construct the class
    public function __construct() {

        // Run the actions
        add_action('after_setup_theme', array( &$this, 'rodesk_setup' ) ); // Setup
        add_action( 'admin_head', array( &$this, 'rodesk_custom_icons' ) );

        // Run the filters
        add_filter('image_size_names_choose', array( &$this, 'rodesk_select_image_sizes' ) ); // Add all custom image sizes to the "Size" select box in the media pop up
    }


    public function rodesk_setup() {

        // Make theme available for translation
        // load_theme_textdomain('langtag-here', get_template_directory() . '/lang');

        // Register wp_nav_menu() menus (http://codex.wordpress.org/Function_Reference/register_nav_menus)
        register_nav_menus(array(
            'primary_navigation' => __('Primary Navigation', $this->plugin_slug),
            'footer_navigation' => __('Footer Navigation', $this->plugin_slug)
        ));

        // Add post thumbnails (http://codex.wordpress.org/Post_Thumbnails)
        // add_theme_support('post-thumbnails');
        // set_post_thumbnail_size(150, 150, false);

        // Add post formats (http://codex.wordpress.org/Post_Formats)
        // add_theme_support('post-formats', array('aside', 'gallery', 'link', 'image', 'quote', 'status', 'video', 'audio', 'chat'));

        // Tell the TinyMCE editor to use a custom stylesheet
        // add_editor_style('/assets/css/editor-style.css');
    }

    // Add all custom image sizes to the "Size" select box in the media pop up
    public function rodesk_select_image_sizes($sizes) {

        $image_sizes = get_intermediate_image_sizes();
        $image_sizes_all = array();

        // Loop through all images sizes
        if( $image_sizes ) {
            $counter = '0';
            foreach ($image_sizes as $image_size) {
                $counter++;
                $nice_image_size = ucfirst( str_replace( '-', ' ', $image_size ) );
                $image_sizes_all[$image_size] = $nice_image_size;
            }
        }

        return $image_sizes_all;
    }


    // Custom icons for CPT
    public function rodesk_custom_icons() {
        echo '
            <style type="text/css" media="screen">
                #adminmenu .menu-icon-post div.wp-menu-image:before {
                    content: "\f105";
                }
            </style>
        ';
    }
}
?>
