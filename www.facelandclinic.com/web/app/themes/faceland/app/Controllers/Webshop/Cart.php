<?php
/**
 * Created by PhpStorm.
 * User: miljan
 * Date: 10/10/2019
 * Time: 09:41
 */

namespace Rokit\Controllers\Webshop;


class Cart {

	protected $_cart;

	protected $_totals;

	protected $_contents;

	protected $_coupons;

	protected $_coupons_enabled;

	protected $_fees;

	protected $_is_empty;

	protected $_item_count;

	public function __construct() {

		// Store a reference of the WC cart when instantiating
		$this->_cart = WC()->cart;

	}

	public function cart() {
		return $this->_cart;
	}

	public function contents() {

		if ( $this->_contents ) {
			return $this->_contents;
		}

		$this->_contents = $this->cart()->get_cart();

		return $this->_contents;

	}

	public function coupons() {

		if ( $this->_coupons ) {
			return $this->_coupons;
		}

		$this->_coupons = array();

		$coupons = $this->cart()->get_coupons();

		if ( empty( $coupons ) ) {
			return $this->_coupons;
		}

		$remove_base_url = defined( 'WOOCOMMERCE_CHECKOUT' ) ? wc_get_checkout_url() : wc_get_cart_url();

		foreach ( $coupons as $coupon ) {
			$this->_coupons[] = array(
				'code' => $coupon->get_code(),
				'discount' => WC()->cart->get_coupon_discount_amount( $coupon->get_code(), WC()->cart->display_cart_ex_tax ),
				'remove_url' => esc_url( add_query_arg( 'remove_coupon', rawurlencode( $coupon->get_code() ), $remove_base_url ) )
			);
		}

		return $this->_coupons;

	}

	public function coupons_enabled() {

		if ( $this->_coupons_enabled ) {
			return $this->_coupons_enabled;
		}

		$this->_coupons_enabled = apply_filters( 'woocommerce_coupons_enabled', 'yes' === get_option( 'woocommerce_enable_coupons' ) );

		return $this->_coupons_enabled;

	}

	public function totals() {

		if ( $this->_totals ) {
			return $this->_totals;
		}

		$this->_totals = $this->cart()->get_totals();

		return $this->_totals;

	}

	public function fees() {

		if ( $this->_fees ) {
			return $this->_fees;
		}

		$this->_fees = $this->cart()->get_fees();

		return $this->_fees;

	}

	public function is_empty() {

		if ( $this->_is_empty ) {
			return $this->_is_empty;
		}

		$this->_is_empty = $this->cart()->is_empty();

		return $this->_is_empty;

	}

	public function item_count() {

		if ( $this->_item_count ) {
			return $this->_item_count;
		}

		$this->_item_count = $this->cart()->get_cart_contents_count();

		return $this->_item_count;

	}

}