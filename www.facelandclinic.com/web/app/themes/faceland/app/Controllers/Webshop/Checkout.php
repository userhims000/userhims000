<?php

namespace Rokit\Controllers\Webshop;

class Checkout {

	protected $_available_gateways;

	protected $_billing_countries;

	protected $_shipping_countries;

	protected $_checkout;

	protected $_fields;

	protected $_needs_payment;

	public function __construct() {

		$this->_checkout = WC()->checkout();

		add_filter( 'woocommerce_checkout_fields', array( $this, 'modify_checkout_fields' ) );

	}

	/**
	 * Modify checkout fields
	 *
	 * Unset or override checkout fields.
	 * See https://docs.woocommerce.com/document/tutorial-customising-checkout-fields-using-actions-and-filters/
	 *
	 * @param array $fields
	 *
	 * @return array
	 */
	public function modify_checkout_fields( $fields ) {

		// Clean/process all fields
		$fields['billing'] = array_map( 'rodesk_filter_field', $fields['billing'] );
		$fields['shipping'] = array_map( 'rodesk_filter_field', $fields['shipping'] );

		return $fields;

	}

	public function checkout() {
		return $this->_checkout;
	}

	public function fields() {

		if ( $this->_fields ) {
			return $this->_fields;
		}

		$this->_fields = WC()->checkout()->get_checkout_fields();

		return $this->_fields;

	}

	public function billing_countries() {

		if ( $this->_billing_countries ) {
			return $this->_billing_countries;
		}

		$this->_billing_countries = WC()->countries->get_allowed_countries();

		return $this->_billing_countries;

	}

	public function shipping_countries() {

		if ( $this->_shipping_countries ) {
			return $this->_shipping_countries;
		}

		$this->_shipping_countries = WC()->countries->get_shipping_countries();

		return $this->_shipping_countries;

	}

	public function available_gateways() {

		if ( $this->_available_gateways ) {
			return $this->_available_gateways;
		}

		$this->_available_gateways = array();

		if ( $this->needs_payment() ) {

			$available_gateways = WC()->payment_gateways()->get_available_payment_gateways();
			WC()->payment_gateways()->set_current_gateway( $available_gateways );

			$this->_available_gateways = $available_gateways;

			return $this->_available_gateways;

		}

		return $this->_available_gateways;

	}

	public function needs_payment() {

		if ( $this->_needs_payment ) {
			return $this->_needs_payment;
		}

		$this->_needs_payment = WC()->cart->needs_payment();

		return $this->_needs_payment;

	}

	public function requires_login() {
		return ! $this->checkout()->is_registration_enabled()
		       && $this->checkout()->is_registration_required()
		       && ! is_user_logged_in();
	}

}