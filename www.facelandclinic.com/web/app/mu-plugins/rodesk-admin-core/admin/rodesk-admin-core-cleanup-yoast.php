<?php
/**
 * Rodesk admin core cleanup Yoast WP SEO plugin.
 *
 * Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 *
 * @package   rodesk-admin-core
 * @author    Rodesk BV <interactie@rodesk.nl>
 * @link      http://rodesk.nl
 * @copyright 2015 Rodesk BV
 */

class rodesk_admin_core_cleanup_yoast {

    // Set some vars
    protected $plugin_slug  = 'rodesk-admin-core';

    // construct the class
    public function __construct() {

        add_action( 'wp_dashboard_setup', array( &$this, 'rodesk_cleanup_wpseo_dashboard_overview_widget' ) ); // Clean up overview dashboard widget
        add_action( 'admin_head', array( &$this, 'rodesk_cleanup_wpseo_hide_sidebar_ads' ) );
        add_action( 'admin_init', array( &$this, 'rodesk_cleanup_wpseo_ignore_tour'), 999 );
        add_action( 'admin_bar_menu', array( &$this, 'rodesk_cleanup_wpseo_remove_adminbar'), 999 );
        add_action( 'wp', array( &$this, 'rodesk_clean_wpseo_columns'), 999 );

    }

    // Cleanup dashboard columns from the Yoast SEO plugin
    public function rodesk_clean_wpseo_columns() {

        $post_types = get_post_types( array( 'public'   => true ) );
        if( $post_types ) {
            foreach( $post_types as $post_type ) {
                add_filter( 'manage_edit-' . $post_type . '_columns', array( $this, 'rodesk_clean_wpseo_remove_columns') , 10, 1 );
            }

        }
    }

    // Remove the WP SEO columns
    public function rodesk_clean_wpseo_remove_columns( $columns ) {

        // Unset WP SEO columns
        unset($columns['wpseo-title']);
        unset($columns['wpseo-metadesc']);
        unset($columns['wpseo-focuskw']);

        return $columns;
    }

    // Cleanup dashboard overview widget
    public function rodesk_cleanup_wpseo_dashboard_overview_widget() {
        remove_meta_box( 'wpseo-dashboard-overview', 'dashboard', 'side' );
    }

    public function rodesk_cleanup_wpseo_hide_sidebar_ads() {
        echo '<style type="text/css">
        #wpseo-dismiss-about, #sidebar-container.wpseo_content_cell, .wpseotab.active > p:nth-child(6), .wpseotab.active > p:nth-child(7), #wpseo-dismiss-gsc {display:none;}
        </style>';
    }

    public function rodesk_cleanup_wpseo_ignore_tour() {
        update_user_meta( get_current_user_id(), 'wpseo_ignore_tour', true );
    }

    public function rodesk_cleanup_wpseo_remove_adminbar() {
        global $wp_admin_bar;

        // remove the entire menu
        $wp_admin_bar->remove_node( 'wpseo-menu' );

        // remove WordPress SEO Settings
        // $wp_admin_bar->remove_node( 'wpseo-settings' );

        // remove keyword research information
        //$wp_admin_bar->remove_node( 'wpseo-kwresearch' );
    }
}
?>
