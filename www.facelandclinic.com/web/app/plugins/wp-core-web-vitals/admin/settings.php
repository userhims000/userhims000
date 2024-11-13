<?php
namespace WPCWV;

if( ! defined( 'ABSPATH' ) ) { die('Let\'s not do this');}

function wp_cwv_admin_scripts_styles($hook) {
    if($hook != 'settings_page_criticalcss'){return;}
    wp_register_script('wp_cwv_plugin_admin_script',WP_CWV_PLUGIN_DIR . 'admin/js/settings.js',array( 'jquery' ),WP_CWV_VERSION,true);
    wp_register_style('wp_cwv_plugin_admin_style',WP_CWV_PLUGIN_DIR . 'admin/css/settings.css',[],WP_CWV_VERSION);
    wp_enqueue_script( 'wp_cwv_plugin_admin_script' );
    wp_enqueue_style( 'wp_cwv_plugin_admin_style' );
}

function wp_cwv_create_menu() {
  add_options_page('WP Core Web Vitals', 'WP Core Web Vitals', 'manage_options', 'criticalcss', 'WPCWV\criticalcss_options_content', 0 );
}

function criticalcss_options_content() {
    $oCriticalFiles = criticalfiles::findAll();
    include (WP_CWV_PLUGIN_PATH.'admin/html/settings.php');
  
}  