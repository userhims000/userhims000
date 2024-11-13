<?php

namespace Nelio_AB_Testing\WooCommerce\Experiment_Library\Bulk_Sale_Experiment;

defined( 'ABSPATH' ) || exit;

use function add_action;
use function add_filter;

function add_tracking_hooks() {

	$exps_with_loaded_alts = array();

	add_filter( 'nab_nab/wc-bulk-sale_track_page_views_in_footer', '__return_true' );

	$save_loaded_alternative_for_triggering_page_view_events_later = function( $alternative, $control, $experiment_id ) use ( &$exps_with_loaded_alts ) {
		add_filter(
			'the_title',
			function( $title, $post_id ) use ( $control, $experiment_id, &$exps_with_loaded_alts ) {
				$product = wc_get_product( $post_id );
				if ( empty( $product ) ) {
					return $title;
				}//end if
				if ( is_product_under_test( $control, $post_id ) && ! in_array( $experiment_id, $exps_with_loaded_alts, true ) ) {
					array_push( $exps_with_loaded_alts, $experiment_id );
				}//end if
				return $title;
			},
			10,
			2
		);
	};
	add_action( 'nab_nab/wc-bulk-sale_load_alternative', $save_loaded_alternative_for_triggering_page_view_events_later, 10, 3 );

	add_filter(
		'nab_nab/wc-bulk-sale_should_trigger_page_view',
		function( $result, $alternative, $control, $experiment_id ) use ( &$exps_with_loaded_alts ) {
			return in_array( $experiment_id, $exps_with_loaded_alts, true );
		},
		10,
		4
	);

}//end add_tracking_hooks()
add_tracking_hooks();
