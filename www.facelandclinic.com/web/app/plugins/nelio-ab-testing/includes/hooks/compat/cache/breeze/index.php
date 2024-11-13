<?php
/**
 * This file defines hooks to filters and actions to make the plugin compatible with Breeze.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/includes/hooks/compat/cache
 * @author     David Aguilera <david.aguilera@neliosoftware.com>
 * @since      6.0.7
 */

namespace Nelio_AB_Testing\Compat\Cache\Breeze;

defined( 'ABSPATH' ) || exit;

function flush_cache() {
	global $admin;
	if ( class_exists( 'Breeze_Admin' ) && ! empty( $admin ) && ( $admin instanceof \Breeze_Admin ) ) {
		$admin->breeze_clear_all_cache();
	}//end if
}//end flush_cache()
add_action( 'nab_flush_all_caches', __NAMESPACE__ . '\flush_cache' );
