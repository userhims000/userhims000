<?php

namespace Nelio_AB_Testing\WooCommerce\Experiment_Library\Bulk_Sale_Experiment;

use function Nelio_AB_Testing\WooCommerce\Helpers\Product_Selection\do_products_match;

defined( 'ABSPATH' ) || exit;

function is_product_under_test( $control, $product_id ) {
	static $cache = array();

	if ( isset( $cache[ $product_id ] ) ) {
		return $cache[ $product_id ];
	}//end if

	$cache[ $product_id ] = nab_some(
		function( $selection ) use ( $product_id ) {
			return do_products_match( $selection, $product_id );
		},
		$control['productSelections']
	);

	return $cache[ $product_id ];
}//end is_product_under_test()
