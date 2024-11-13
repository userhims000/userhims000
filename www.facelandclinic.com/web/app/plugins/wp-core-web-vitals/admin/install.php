<?php

namespace WPCWV;

if( ! defined( 'ABSPATH' ) ) { die('Let\'s not do this');}


register_activation_hook( __FILE__, 'WPCWV\wp_cwv_install' );
add_action( 'plugins_loaded', 'WPCWV\wp_cwv_update_db_check' );

function wp_cwv_install() {

	$wp_cwv_db_version = get_option( "wp_cwv_db_version" );

	if ( $wp_cwv_db_version != WP_CWV_VERSION ) {
		criticalrules::createTable();
		criticalfiles::createTable();
		scriptrules::createTable();
		update_option( "wp_cwv_db_version", WP_CWV_VERSION );
	}
}



function wp_cwv_update_db_check() {
	if ( get_site_option( 'wp_cwv_db_version' ) != WP_CWV_VERSION ) {
		wp_cwv_install();
	}
}


/* CUSTOM UPDATES */
add_filter('plugins_api', 'WPCWV\cwv_plugin_info', 20, 3);

function cwv_plugin_info( $res, $action, $args ){

	// do nothing if this is not about getting plugin information
	if( 'plugin_information' !== $action ) {
		return false;
	}
 
	$plugin_slug = 'wpcorewebvitals'; // we are going to use it in many places in this function
 
	// do nothing if it is not our plugin
	if( $plugin_slug !== $args->slug ) {
		return false;
	}
 
	// trying to get from cache first
 
	// wp-corewebvitals.json is the file with the actual plugin information on your server
	$remote = wp_remote_get(
		add_query_arg( ['license_key' => urlencode(  critical_get_option('cwv_api_key')),'cb'=>microtime(true)], 'https://www.corewebvitals.io/plugin/wp-corewebvitals.json'), 
		array(
		'timeout' => 10,
		'headers' => array(
			'Accept' => 'application/json'
		) )
	);
 

 
 
	if( ! is_wp_error( $remote ) && isset( $remote['response']['code'] ) && $remote['response']['code'] == 200 && ! empty( $remote['body'] ) ) {
 
		$remote = json_decode( $remote['body'] );
		$res = new \stdClass();
 
		$res->name = $remote->name;
		$res->slug = $plugin_slug;
		$res->version = $remote->version;
		$res->tested = $remote->tested;
		$res->requires = $remote->requires;
		$res->download_link = $remote->download_url;
		$res->trunk = $remote->download_url;
		$res->requires_php = '5.3';
		$res->last_updated = $remote->last_updated;
		$res->sections = array(
			'description' => $remote->sections->description,
			'installation' => $remote->sections->installation,
			'changelog' => $remote->sections->changelog
		);
 
		if( !empty( $remote->sections->screenshots ) ) {
			$res->sections['screenshots'] = $remote->sections->screenshots;
		}

		return $res;
 
	}
 
	return false;
 
}



add_filter('site_transient_update_plugins', 'WPCWV\cwv_push_update' );
 
function cwv_push_update( $transient ){
 
	if ( empty($transient->checked ) ) {
    	return $transient;
    }
 
	// wp-corewebvitals.json is the file with the actual plugin information on your server
	$remote = wp_remote_get(
		add_query_arg( ['license_key' => urlencode(  critical_get_option('cwv_api_key')),'cb'=>microtime(true)], 'https://www.corewebvitals.io/plugin/wp-corewebvitals.json'), 
		array(
		'timeout' => 10,
		'headers' => array(
			'Accept' => 'application/json'
		) )
	);


	if( is_array($remote )) {

		$remote = json_decode( $remote['body'] );

		// your installed plugin version should be on the line below! You can obtain it dynamically of course 
		if( $remote && version_compare( WP_CWV_VERSION, $remote->version, '<' ) ) {

			$res = new \stdClass();
			$res->slug = 'wpcorewebvitals';
			$res->plugin = 'wp-core-web-vitals/wpcorewebvitals.php'; // it could be just YOUR_PLUGIN_SLUG.php if your plugin doesn't have its own directory
			$res->new_version = $remote->version;
			$res->tested = $remote->tested;
			$res->package = $remote->download_url;
       		$transient->response[$res->plugin] = $res;
       	}
 
	}
    return $transient;
}