<?php
/**
 * This file loads all compatibility hooks for cache plugins and defines a custom action.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/includes/hooks/compat/cache
 * @author     David Aguilera <david.aguilera@neliosoftware.com>
 * @since      6.0.7
 */

namespace Nelio_AB_Testing\Compat\Cache;

defined( 'ABSPATH' ) || exit;

require_once dirname( __FILE__ ) . '/autoptimize/index.php';
require_once dirname( __FILE__ ) . '/breeze/index.php';
require_once dirname( __FILE__ ) . '/cloudflare/index.php';
require_once dirname( __FILE__ ) . '/godaddy/index.php';
require_once dirname( __FILE__ ) . '/kinsta/index.php';
require_once dirname( __FILE__ ) . '/litespeed/index.php';
require_once dirname( __FILE__ ) . '/nitropack/index.php';
require_once dirname( __FILE__ ) . '/rapidload/index.php';
require_once dirname( __FILE__ ) . '/sg-optimizer/index.php';
require_once dirname( __FILE__ ) . '/w3-total/index.php';
require_once dirname( __FILE__ ) . '/wordpress/index.php';
require_once dirname( __FILE__ ) . '/wpengine/index.php';
require_once dirname( __FILE__ ) . '/wp-fastest/index.php';
require_once dirname( __FILE__ ) . '/wp-optimize/index.php';
require_once dirname( __FILE__ ) . '/wp-rocket/index.php';
require_once dirname( __FILE__ ) . '/wp-super/index.php';

function trigger_flush_all_caches() {
	/**
	 * Triggers a request to flush all compatible caches.
	 *
	 * By default, this action fires when an experiment is started, stopped,
	 * paused, or resumed. Hook into this action to add compatibility with
	 * your own cache plugin.
	 *
	 * @since 5.0.0
	 */
	do_action( 'nab_flush_all_caches' );
}//end trigger_flush_all_caches()
add_action( 'nab_start_experiment', __NAMESPACE__ . '\trigger_flush_all_caches' );
add_action( 'nab_pause_experiment', __NAMESPACE__ . '\trigger_flush_all_caches' );
add_action( 'nab_resume_experiment', __NAMESPACE__ . '\trigger_flush_all_caches' );
add_action( 'nab_stop_experiment', __NAMESPACE__ . '\trigger_flush_all_caches' );
