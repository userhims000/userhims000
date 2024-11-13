<?php

namespace Nelio_AB_Testing\WooCommerce\Experiment_Library\Bulk_Sale_Experiment;

defined( 'ABSPATH' ) || exit;

function load_alternative_discount( $alternative, $control ) {

	if ( empty( $alternative['discount'] ) ) {
		return;
	}//end if


	add_filter(
		'nab_enable_custom_woocommerce_hooks',
		function( $enabled, $product_id ) use ( $control ) {
			return $enabled || is_product_under_test( $control, $product_id );
		},
		10,
		2
	);


	$get_sale_price = function( $sale_price, $product_id, $regular_price ) use ( $control, $alternative ) {
		if ( ! is_product_under_test( $control, $product_id ) ) {
			return $sale_price;
		}//end if

		$was_already_on_sale = $sale_price < $regular_price;
		if ( $was_already_on_sale && empty( $alternative['overwritesExistingSalePrice'] ) ) {
			return $sale_price;
		}//end if

		return $regular_price * ( 100 - $alternative['discount'] ) / 100;
	};
	add_filter( 'nab_woocommerce_product_sale_price', $get_sale_price, 10, 3 );
	add_filter( 'nab_woocommerce_variation_sale_price', $get_sale_price, 10, 3 );

}//end load_alternative_discount()
add_action( 'nab_nab/wc-bulk-sale_load_alternative', __NAMESPACE__ . '\load_alternative_discount', 10, 2 );
