<?php
/**
 * This file defines hooks to filters and actions to make the plugin compatible with WPRocket.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/includes/hooks/compat/cache
 * @author     Antonio Villegas <antonio.villegas@neliosoftware.com>
 * @since      5.0.6
 */

namespace Nelio_AB_Testing\Compat\Cache\WPRocket;

defined( 'ABSPATH' ) || exit;

function flush_cache() {
	if ( function_exists( 'rocket_clean_domain' ) ) {
		rocket_clean_domain();
	}//end if
}//end flush_cache()
add_action( 'nab_flush_all_caches', __NAMESPACE__ . '\flush_cache' );

function exclude_files( $excluded_files = array() ) {
	$excluded_files[] = 'nelio-ab-testing';
	$excluded_files[] = 'nab';

	return $excluded_files;
}//end exclude_files()
add_filter( 'rocket_delay_js_exclusions', __NAMESPACE__ . '\exclude_files', 10, 1 );
add_filter( 'rocket_exclude_defer_js', __NAMESPACE__ . '\exclude_files', 10, 1 );
add_filter( 'rocket_exclude_async_css', __NAMESPACE__ . '\exclude_files', 10, 1 );
add_filter( 'rocket_exclude_cache_busting', __NAMESPACE__ . '\exclude_files', 10, 1 );
add_filter( 'rocket_exclude_static_dynamic_resources', __NAMESPACE__ . '\exclude_files', 10, 1 );
add_filter( 'rocket_excluded_inline_js_content', __NAMESPACE__ . '\exclude_files', 10, 1 );
add_filter( 'rocket_exclude_js', __NAMESPACE__ . '\exclude_files', 10, 1 );
