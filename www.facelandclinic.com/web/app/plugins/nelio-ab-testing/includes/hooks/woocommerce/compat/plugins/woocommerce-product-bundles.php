<?php

namespace Nelio_AB_Testing\WooCommerce\Compat;

add_action(
	'plugins_loaded',
	function () {
		if ( ! defined( 'WC_PB_VERSION' ) ) {
			return;
		}//end if
		add_filter(
			'nab_exclude_woocommerce_product_from_testing',
			function ( $skip, $product ) {
				if ( ( is_object( $product ) && ! empty( $product->bundled_cart_item ) ) ) {
					return true;
				}//end if

				if ( is_singular( 'product' ) && is_main_query() ) {
					$product = wc_get_product( get_the_ID() );
					return $skip || 'WC_Product_Bundle' === get_class( $product );
				}//end if

				return $skip;
			},
			10,
			2
		);
	}
);
