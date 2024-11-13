<?php
/**
 * This file defines hooks to filters and actions to make the plugin compatible with LiteSpeed.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/includes/hooks/compat/cache
 * @author     David Aguilera <david.aguilera@neliosoftware.com>
 * @since      6.0.7
 */

namespace Nelio_AB_Testing\Compat\Cache\LiteSpeed;

defined( 'ABSPATH' ) || exit;

function flush_cache() {
	if ( class_exists( 'LiteSpeed_Cache_Purge' ) ) {
		\LiteSpeed_Cache_Purge::purge_all();
	}//end if

	if ( class_exists( 'Purge' ) ) {
		\Purge::purge_all();
	}//end if
}//end flush_cache()
add_action( 'nab_flush_all_caches', __NAMESPACE__ . '\flush_cache' );

function exclude_files( $excluded_files = array() ) {
	$excluded_files[] = 'nelio-ab-testing';
	$excluded_files[] = 'nabSettings';
	$excluded_files[] = 'nabQuickActionSettings';
	return $excluded_files;
}//end exclude_files()
add_filter( 'litespeed_optimize_js_excludes', __NAMESPACE__ . '\exclude_files' );
add_filter( 'litespeed_optm_js_defer_exc', __NAMESPACE__ . '\exclude_files' );
add_filter( 'litespeed_optm_gm_js_exc', __NAMESPACE__ . '\exclude_files' );

function exclude_overlay( $excluded_files = array() ) {
	$excluded_files[] = 'nelio-ab-testing-overlay';
	return $excluded_files;
}//end exclude_overlay()
add_filter( 'litespeed_optimize_css_excludes', __NAMESPACE__ . '\exclude_overlay' );
