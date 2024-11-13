<?php
/**
 * This file defines hooks to filters and actions to make the plugin compatible with WPSuper.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/includes/hooks/compat/cache
 * @author     David Aguilera <david.aguilera@neliosoftware.com>
 * @since      6.0.7
 */

namespace Nelio_AB_Testing\Compat\Cache\WPSuper;

defined( 'ABSPATH' ) || exit;

function flush_cache() {

	if ( ! function_exists( 'wp_cache_clean_cache' ) ) {
		return;
	}//end if

	global $file_prefix, $supercachedir;
	if ( empty( $supercachedir ) && function_exists( 'get_supercache_dir' ) ) {
		$supercachedir = get_supercache_dir();
	}//end if

	wp_cache_clean_cache( $file_prefix );

}//end flush_cache()
add_action( 'nab_flush_all_caches', __NAMESPACE__ . '\flush_cache' );
