<?php

namespace Nelio_AB_Testing\WooCommerce\Compat;

function create_custom_woocommerce_hooks() {
	create_hooks_for_regular_products();
	create_hooks_for_variable_products();
	create_hooks_for_product_variations();
}//end create_custom_woocommerce_hooks()
add_action( 'init', __NAMESPACE__ . '\create_custom_woocommerce_hooks' );


function create_hooks_for_regular_products() {
	create_product_name_hook();
	create_product_description_hook();
	create_product_short_description_hook();
	create_product_image_id_hook();
	create_product_gallery_hook();
	create_product_regular_price_hook();
	create_product_sale_price_hook();
	fix_product_on_sale();
}//end create_hooks_for_regular_products()


function create_hooks_for_variable_products() {
	fix_variable_product_price();
	fix_variable_product_on_sale();
}//end create_hooks_for_variable_products()


function create_hooks_for_product_variations() {
	create_variation_description_hook();
	create_variation_image_id_hook();
	create_variation_regular_price_hook();
	create_variation_sale_price_hook();
	fix_variation_price_hook();
}//end create_hooks_for_product_variations()


function create_product_name_hook() {
	$replace_name = function( $name, $object ) {
		$product_id = get_product_id( $object );
		if ( 'product' !== get_post_type( $product_id ) ) {
			return $name;
		}//end if

		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $name;
		}//end if

		if ( exclude_from_testing( $product_id ) ) {
			return $name;
		}//end if

		/**
		 * Filters the name of a WooCommerce product.
		 *
		 * @param string $name       Product name.
		 * @param number $product_id Product ID.
		 *
		 * @since 5.4.3
		 */
		return apply_filters( 'nab_woocommerce_product_name', $name, $product_id );
	};
	add_filter( 'the_title', $replace_name, 99, 2 );
	// Source: includes/abstracts/abstract-wc-product.php.
	// Source: includes/class-wc-product-variation.php.
	add_filter( 'woocommerce_product_title', $replace_name, 99, 2 );
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_product_get_name', $replace_name, 99, 2 );
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_order_item_get_name', $replace_name, 99, 2 );
}//end create_product_name_hook()


function create_product_description_hook() {
	$replace_description = function( $description ) {
		$post_id = get_the_ID();
		if ( get_post_type( $post_id ) !== 'product' ) {
			return $description;
		}//end if

		if ( doing_filter( 'nab_woocommerce_product_description' ) ) {
			return $description;
		}//end if

		$product_id = $post_id;
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $description;
		}//end if

		if ( exclude_from_testing( $product_id ) ) {
			return $description;
		}//end if

		/**
		 * Filters the description of a WooCommerce product.
		 *
		 * @param string $description Product’s short description.
		 * @param number $product_id  Product ID.
		 *
		 * @since 5.5.0
		 */
		return apply_filters( 'nab_woocommerce_product_description', $description, $product_id );
	};
	add_filter( 'the_content', $replace_description, 99, 2 );
}//end create_product_description_hook()


function create_product_short_description_hook() {
	$replace_short_description = function( $short_description ) {
		if ( doing_filter( 'woocommerce_archive_description' ) ) {
			return $short_description;
		}//end if

		$post_id = get_the_ID();
		if ( get_post_type( $post_id ) !== 'product' ) {
			return $short_description;
		}//end if

		if ( doing_filter( 'nab_woocommerce_product_short_description' ) ) {
			return $short_description;
		}//end if

		$product_id = $post_id;
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $short_description;
		}//end if

		if ( exclude_from_testing( $product_id ) ) {
			return $short_description;
		}//end if

		/**
		 * Filters the short description of a WooCommerce product.
		 *
		 * @param string $short_description Product’s short description.
		 * @param number $product_id        Product ID.
		 *
		 * @since 5.4.3
		 */
		return apply_filters( 'nab_woocommerce_product_short_description', $short_description, $product_id );
	};
	add_filter( 'get_the_excerpt', $replace_short_description, 99 );
	add_filter( 'woocommerce_short_description', $replace_short_description, 99 );

	$undo_replace_short_description = function( $props, $object, $variation ) use ( &$replace_short_description ) {
		$product_id = get_product_id( $object );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $props;
		}//end if

		remove_filter( 'woocommerce_short_description', $replace_short_description, 99 );
		$props['variation_description'] = wc_format_content( $variation->get_description() );
		add_filter( 'woocommerce_short_description', $replace_short_description, 99 );
		return $props;
	};
	add_filter( 'woocommerce_available_variation', $undo_replace_short_description, 99, 3 );
}//end create_product_short_description_hook()


function create_product_image_id_hook() {
	$replace_product_image_id = function( $image_id, $product ) {
		$product_id = is_int( $product ) ? $product : absint( $product->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $image_id;
		}//end if

		if ( exclude_from_testing( $product ) ) {
			return $image_id;
		}//end if

		/**
		 * Filters the featured image of a WooCommerce product.
		 *
		 * @param number $image_id   Featured image ID.
		 * @param number $product_id Product ID.
		 *
		 * @since 5.4.3
		 */
		return apply_filters( 'nab_woocommerce_product_image_id', $image_id, $product_id );
	};
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_product_get_image_id', $replace_product_image_id, 99, 2 );

	$replace_image_id_meta = function( $value, $object_id, $meta_key ) use ( &$replace_product_image_id, &$replace_image_id_meta ) {
		return '_thumbnail_id' !== $meta_key ? $value : $replace_product_image_id( $value, $object_id );
	};
	add_filter( 'get_post_metadata', $replace_image_id_meta, 99, 3 );
}//end create_product_image_id_hook()


function create_product_gallery_hook() {
	$replace_gallery_image_ids = function( $image_ids, $product ) {
		$product_id = is_int( $product ) ? $product : absint( $product->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $image_ids;
		}//end if

		if ( exclude_from_testing( $product ) ) {
			return $image_ids;
		}//end if

		/**
		 * Filters the array of image IDs that make up the product’s gallery.
		 *
		 * @param number $image_ids  Array of image IDs.
		 * @param number $product_id Product ID.
		 *
		 * @since 5.5.0
		 */
		return apply_filters( 'nab_woocommerce_product_gallery_ids', $image_ids, $product_id );
	};
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_product_get_gallery_image_ids', $replace_gallery_image_ids, 99, 2 );
}//end create_product_gallery_hook()


function create_product_regular_price_hook() {
	$replace_regular_price = function( $regular_price, $product ) {
		if ( $product->get_type() === 'variable' ) {
			return $regular_price;
		}//end if

		$product_id = absint( $product->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $regular_price;
		}//end if

		if ( exclude_from_testing( $product ) ) {
			return $regular_price;
		}//end if

		/**
		 * Filters the regular price of a (non-variable) WooCommerce product.
		 *
		 * @param numeric $regular_price Product’s regular price.
		 * @param number  $product_id    Product ID.
		 *
		 * @since 5.4.3
		 */
		return apply_filters( 'nab_woocommerce_product_regular_price', $regular_price, $product_id );
	};
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_product_get_regular_price', $replace_regular_price, 99, 2 );
}//end create_product_regular_price_hook()


function create_product_sale_price_hook() {
	$replace_sale_price = function( $sale_price, $product ) {
		if ( $product->get_type() === 'variable' ) {
			return $sale_price;
		}//end if

		$product_id = absint( $product->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $sale_price;
		}//end if

		if ( exclude_from_testing( $product ) ) {
			return $sale_price;
		}//end if

		$regular_price = $product->get_regular_price();

		/**
		 * Filters the sale price of a (non-variable) WooCommerce product.
		 *
		 * @param numeric $sale_price    Product’s sale price.
		 * @param number  $product_id    Product ID.
		 * @param numeric $regular_price Product’s regular price.
		 *
		 * @since 5.4.3
		 */
		return apply_filters( 'nab_woocommerce_product_sale_price', $sale_price, $product_id, $regular_price );
	};
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_product_get_price', $replace_sale_price, 99, 2 );
}//end create_product_sale_price_hook()


function fix_product_on_sale() {
	$replace_on_sale = function( $is_on_sale, $product ) {
		if ( $product->get_type() === 'variable' ) {
			return $is_on_sale;
		}//end if

		if ( exclude_from_testing( $product ) ) {
			return $is_on_sale;
		}//end if

		$product_id = absint( $product->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $is_on_sale;
		}//end if

		$current_price = $product->get_price();
		$regular_price = $product->get_regular_price();

		return $current_price < $regular_price;
	};
	add_filter( 'woocommerce_product_is_on_sale', $replace_on_sale, 99, 2 );
}//end fix_product_on_sale()


function fix_variable_product_price() {
	$fix_html_price = function( $html, $product ) {
		$product_id = absint( $product->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $html;
		}//end if

		if ( exclude_from_testing( $product ) ) {
			return $html;
		}//end if

		$variation_prices = get_variation_prices( $product );

		$min_price = min( wp_list_pluck( $variation_prices, 'current' ) );
		$max_price = max( wp_list_pluck( $variation_prices, 'current' ) );

		$min_regular_price = min( wp_list_pluck( $variation_prices, 'regular' ) );
		$max_regular_price = max( wp_list_pluck( $variation_prices, 'regular' ) );

		$min_sale_price = min( wp_list_pluck( $variation_prices, 'sale' ) );

		$is_price_range = $min_price < $max_price;
		$is_on_sale     = (
			! $is_price_range &&
			$min_regular_price === $max_regular_price &&
			$min_sale_price < $min_regular_price
		);

		if ( $is_price_range ) {
			return wc_format_price_range( $min_price, $max_price );
		}//end if

		if ( $is_on_sale ) {
			return wc_format_sale_price( wc_price( $min_regular_price ), wc_price( $min_sale_price ) );
		}//end if

		return wc_price( $min_price );
	};
	add_filter( 'woocommerce_variable_price_html', $fix_html_price, 99, 2 );
}//end fix_variable_product_price()


function fix_variable_product_on_sale() {
	$replace_on_sale = function( $is_on_sale, $product ) {
		if ( $product->get_type() !== 'variable' ) {
			return $is_on_sale;
		}//end if

		if ( exclude_from_testing( $product ) ) {
			return $is_on_sale;
		}//end if

		$product_id = absint( $product->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $is_on_sale;
		}//end if

		$variation_prices = get_variation_prices( $product );
		return nab_some(
			function( $prices ) {
				return $prices['sale'] < $prices['regular'];
			},
			$variation_prices
		);
	};
	add_filter( 'woocommerce_product_is_on_sale', $replace_on_sale, 99, 2 );
}//end fix_variable_product_on_sale()


function create_variation_description_hook() {
	$replace_description = function( $description, $variation ) {
		$product_id   = $variation->get_parent_id();
		$variation_id = absint( $variation->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $description;
		}//end if

		if ( exclude_from_testing( $product_id ) ) {
			return $description;
		}//end if

		/**
		 * Filters the short description of a variation in a WooCommerce variable product.
		 *
		 * @param string $description  Variation’s short description.
		 * @param number $product_id   Variable product ID.
		 * @param number $variation_id Variation ID.
		 *
		 * @since 5.5.0
		 */
		return apply_filters( 'nab_woocommerce_variation_description', $description, $product_id, $variation_id );
	};
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_product_variation_get_description', $replace_description, 99, 2 );
}//end create_variation_description_hook()

function create_variation_image_id_hook() {
	$replace_image_id = function( $image_id, $variation ) {
		$product_id   = $variation->get_parent_id();
		$variation_id = absint( $variation->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $image_id;
		}//end if

		if ( exclude_from_testing( $product_id ) ) {
			return $image_id;
		}//end if

		/**
		 * Filters the featured image ID of a variation in a WooCommerce variable product.
		 *
		 * @param string $image_id     Featured image ID of a product variation.
		 * @param number $product_id   Variable product ID.
		 * @param number $variation_id Variation ID.
		 *
		 * @since 5.4.3
		 */
		return apply_filters( 'nab_woocommerce_variation_image_id', $image_id, $product_id, $variation_id );
	};
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_product_variation_get_image_id', $replace_image_id, 99, 2 );
}//end create_variation_image_id_hook()


function create_variation_regular_price_hook() {
	$replace_regular_price = function( $regular_price, $variation ) {
		$product_id   = $variation->get_parent_id();
		$variation_id = absint( $variation->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $regular_price;
		}//end if

		if ( exclude_from_testing( $variation ) ) {
			return $regular_price;
		}//end if

		return apply_variation_regular_price_filter( $regular_price, $product_id, $variation_id );
	};
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_product_variation_get_regular_price', $replace_regular_price, 99, 2 );
}//end create_variation_regular_price_hook()


function create_variation_sale_price_hook() {
	$replace_sale_price = function( $sale_price, $variation ) {
		$product_id   = $variation->get_parent_id();
		$variation_id = absint( $variation->get_id() );
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $sale_price;
		}//end if

		if ( exclude_from_testing( $variation ) ) {
			return $sale_price;
		}//end if

		$regular_price = $variation->get_regular_price();
		$regular_price = apply_variation_regular_price_filter( $regular_price, $product_id, $variation_id );
		return apply_variation_sale_price_filter( $sale_price, $product_id, $regular_price, $variation_id );
	};
	// Source: WC_Data » get_hook_prefix() . $prop.
	add_filter( 'woocommerce_product_variation_get_price', $replace_sale_price, 99, 2 );
	// Source: includes/class-wc-product-variable.php.
	add_filter( 'woocommerce_get_variation_sale_price', $replace_sale_price, 99, 2 );
}//end create_variation_sale_price_hook()


function fix_variation_price_hook() {
	$replace_variation_price = function( $props, $object ) {
		$product_id   = get_product_id( $object );
		$variation_id = $props['variation_id'];
		if ( ! are_custom_hooks_enabled( $product_id ) ) {
			return $props;
		}//end if

		if ( exclude_from_testing( $object ) ) {
			return $props;
		}//end if

		$variation_prices = get_variation_prices( $object );

		$regular_prices    = array_map( 'wc_price', wp_list_pluck( $variation_prices, 'regular' ) );
		$min_regular_price = min( $regular_prices );
		$max_regular_price = max( $regular_prices );
		$is_unique_regular = $min_regular_price === $max_regular_price;

		$sale_prices    = array_map( 'wc_price', wp_list_pluck( $variation_prices, 'sale' ) );
		$min_sale_price = min( $sale_prices );
		$max_sale_price = max( $sale_prices );
		$is_unique_sale = $min_sale_price === $max_sale_price;

		$variation_prices = array_combine( wp_list_pluck( $variation_prices, 'id' ), $variation_prices );
		$regular_price    = wc_price( $variation_prices[ $variation_id ]['regular'] );
		$sale_price       = wc_price( $variation_prices[ $variation_id ]['sale'] );

		if ( $is_unique_regular && $is_unique_sale ) {
			$props['price_html'] = '';
		} elseif ( $regular_price === $sale_price ) {
			$props['price_html'] = $regular_price;
		} else {
			$props['price_html'] = wc_format_sale_price( $regular_price, $sale_price );
		}//end if

		return $props;
	};
	// Source: includes/class-wc-product-variable.php.
	add_filter( 'woocommerce_available_variation', $replace_variation_price, 99, 2 );
}//end fix_variation_price_hook()


function apply_variation_regular_price_filter( $regular_price, $product_id, $variation_id ) {
	if ( exclude_from_testing( $product_id ) ) {
		return $regular_price;
	}//end if

	/**
	 * Filters the regular price of a variation in a WooCommerce variable product.
	 *
	 * @param numeric $regular_price Variation’s regular price.
	 * @param number  $product_id    Variable product ID.
	 * @param number  $variation_id  Variation ID.
	 *
	 * @since 5.4.3
	 */
	return apply_filters( 'nab_woocommerce_variation_regular_price', $regular_price, $product_id, $variation_id );
}//end apply_variation_regular_price_filter()

function apply_variation_sale_price_filter( $sale_price, $product_id, $regular_price, $variation_id ) {
	if ( exclude_from_testing( $product_id ) ) {
		return $sale_price;
	}//end if

	/**
	 * Filters the sale price of a variation in a WooCommerce variable product.
	 *
	 * @param numeric $sale_price    Variation’s sale price.
	 * @param number  $product_id    Variable product ID.
	 * @param numeric $regular_price Variation’s regular price.
	 * @param number  $variation_id  Variation ID.
	 *
	 * @since 5.4.3
	 */
	return apply_filters( 'nab_woocommerce_variation_sale_price', $sale_price, $product_id, $regular_price, $variation_id );
}//end apply_variation_sale_price_filter()


function get_product_id( $object ) {
	if ( is_int( $object ) ) {
		return absint( $object );
	}//end if

	if ( is_object( $object ) && method_exists( $object, 'get_id' ) ) {
		return absint( $object->get_id() );
	}//end if

	if ( is_object( $object ) && method_exists( $object, 'get_product_id' ) ) {
		return absint( $object->get_product_id() );
	}//end if

	return 0;
}//end get_product_id()


function get_variation_prices( $product ) {
	if ( $product->get_type() !== 'variable' ) {
		return array();
	}//end if

	$product_id       = absint( $product->get_id() );
	$variation_prices = $product->get_variation_prices();
	ksort( $variation_prices['regular_price'] );
	ksort( $variation_prices['sale_price'] );

	$variation_prices = array_map(
		function( $variation_id, $regular_price, $sale_price ) use ( $product_id ) {
			$regular = apply_variation_regular_price_filter( $regular_price, $product_id, $variation_id );
			$sale    = apply_variation_sale_price_filter( $sale_price, $product_id, $regular, $variation_id );
			return array(
				'id'      => $variation_id,
				'current' => min( $regular, $sale ),
				'regular' => $regular,
				'sale'    => $sale,
			);
		},
		array_keys( $variation_prices['regular_price'] ),
		$variation_prices['regular_price'],
		$variation_prices['sale_price']
	);

	return array_values( $variation_prices );
}//end get_variation_prices()


function are_custom_hooks_enabled( $product_id ) {
	/**
	 * Enables (or disables) custom WooCommerce filters for a given WooCommerce product.
	 *
	 * Notice: if you want to enable custom hooks for product
	 * variations, you’ll need to enable them for their parent
	 * variable product.
	 *
	 * @param boolean $is_enabled Whether custom WooCommerce filters are enabled or not. Default: `false`.
	 * @param number  $product_id WooCommerce product ID.
	 *
	 * @sine 5.4.3
	 */
	return apply_filters( 'nab_enable_custom_woocommerce_hooks', false, $product_id );
}//end are_custom_hooks_enabled()

function exclude_from_testing( $product ) {
	/**
	 * Filters whether a certain tested product should indeed be tested or not.
	 *
	 * @param boolean           $skip      Whether a certain tested product should indeed be tested or not. Default: `false` (meaning, it will indeed be tested)
	 * @param WC_Product|number $product   WooCommerce product/variation or WooCommerce product ID.
	 *
	 * @since 5.5.7
	 */
	return apply_filters( 'nab_exclude_woocommerce_product_from_testing', false, $product );
}//end exclude_from_testing()
