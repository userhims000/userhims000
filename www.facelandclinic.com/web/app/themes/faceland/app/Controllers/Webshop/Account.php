<?php
/**
 * Created by PhpStorm.
 * User: miljan
 * Date: 21/10/2019
 * Time: 09:55
 */

namespace Rokit\Controllers\Webshop;


class Account {

	protected $_customer;

	protected $_menu_items;

	protected $_edit_address_type;

	protected $_edit_address_fields;

	protected $_orders_query;

	protected $_order;

	protected $_panorama;

	protected $_current_page;

	protected $_options;

	public function customer() {

		if ( $this->_customer ) {
			return $this->_customer;
		}

		$this->_customer = new \WC_Customer( get_current_user_id() );

		return $this->_customer;

	}

	public function menu_items() {

		global $wp;

		if ( $this->_menu_items ) {
			return $this->_menu_items;
		}

		$menu_items     = array();
		$wc_menu_items  = wc_get_account_menu_items();

		// Unset unused menu items
		unset( $wc_menu_items['downloads'] );

		// Loop through WC menu items and add more data (like icons)
		foreach ( $wc_menu_items as $endpoint => $label ) {

			$current = isset( $wp->query_vars[ $endpoint ] );

			$item_data = array(
				'active'    => $current,
				'endpoint'  => $endpoint,
				'label'     => $label,
				'url'       => wc_get_account_endpoint_url( $endpoint )
			);

			switch ( $endpoint ) :

				case 'dashboard' :
					$item_data['icon'] = 'dashboard.svg';
					$item_data['active'] = $current || ( isset( $wp->query_vars['page'] ) || empty( $wp->query_vars ) );
					break;

				case 'orders' :
					$item_data['icon'] = 'orders.svg';
					$item_data['active'] = $current || isset( $wp->query_vars['view-order'] );
					break;

				case 'edit-address' :
					$item_data['icon'] = 'address.svg';
					break;

				case 'edit-account' :
					$item_data['icon'] = 'account.svg';
					break;

				case 'customer-logout' :
					$item_data['icon'] = 'logout.svg';
					break;

				default :
					$item_data['icon'] = '';
					break;

			endswitch;

			$menu_items[ $endpoint ] = $item_data;

			wc_get_account_formatted_address();

		}

		$this->_menu_items = $menu_items;

		return $this->_menu_items;

	}

	public function edit_address_type() {

		global $wp;

		if ( $this->_edit_address_type ) {
			return $this->_edit_address_type;
		}

		$this->_edit_address_type = isset( $wp->query_vars['edit-address'] ) ? $wp->query_vars['edit-address'] : '';

		return $this->_edit_address_type;

	}

	public function edit_address_fields( $address_type ) {

		if ( isset( $this->_edit_address_fields[ $address_type ] ) ) {
			return $this->_edit_address_fields[ $address_type ];
		}

		if ( empty( $this->_edit_address_fields ) && ! is_array( $this->_edit_address_fields ) ) {
			$this->_edit_address_fields = array();
		}

		$country = get_user_meta( $this->customer()->get_id(), $address_type . '_country', true );

		if ( ! $country ) {
			$country = WC()->countries->get_base_country();
		}

		if ( 'billing' === $address_type ) {
			$allowed_countries = WC()->countries->get_allowed_countries();

			if ( ! array_key_exists( $country, $allowed_countries ) ) {
				$country = current( array_keys( $allowed_countries ) );
			}
		}

		if ( 'shipping' === $address_type ) {
			$allowed_countries = WC()->countries->get_shipping_countries();

			if ( ! array_key_exists( $country, $allowed_countries ) ) {
				$country = current( array_keys( $allowed_countries ) );
			}
		}

		$address = WC()->countries->get_address_fields( $country, $address_type . '_' );

		// Prepare values.
		foreach ( $address as $key => $field ) {

			$value = get_user_meta( get_current_user_id(), $key, true );

			if ( ! $value ) {
				switch ( $key ) {
					case 'billing_email':
					case 'shipping_email':
						$value = $this->customer()->get_email();
						break;
				}
			}

			$address[ $key ]['value'] = apply_filters( 'woocommerce_my_account_edit_address_field_value', $value, $key, $address_type );

		}

		$this->_edit_address_fields[ $address_type ] = $address;

		return $this->_edit_address_fields[ $address_type ];

	}

	public function orders_query() {

		if ( $this->_orders_query ) {
			return $this->_orders_query;
		}

		$current_page = get_query_var( 'orders' ) ?: 1;

		$this->_orders_query = wc_get_orders(array(
			'customer' => $this->customer()->get_id(),
			'page'     => $current_page,
			'paginate' => true,
		));

		return $this->_orders_query;

	}

	public function order() {

		if ( $this->_order ) {
			return $this->_order;
		}

		$order_id = get_query_var( 'view-order' );

		if ( empty( $order_id ) ) {
			return false;
		}

		$this->_order = wc_get_order( $order_id );

		return $this->_order;

	}

	public function panorama() {

		if ( $this->_panorama ) {
			return $this->_panorama;
		}

		$current_page = $this->current_page();
		$panorama = array();

		if ( empty( $current_page ) ) {
			return $panorama;
		}

		$display_name = $this->customer()->get_first_name() ?: $this->customer()->get_username();
		$default_text = sprintf(
			__( 'Welkom in je persoonlijke dashboard. Hier vind je al je <strong>recentelijke bestellingen</strong>, adressen en accountgegevens. Ben je %s niet, <a href="%s" title="log out">log dan uit</a>.' ),
			$display_name,
			wc_logout_url()
		);

		switch ( $current_page ) :

			case 'orders' :
				$panorama['title'] = __( 'Jouw bestellingen' );
				$panorama['text'] = $default_text;
				break;

			case 'view-order' :
				$panorama['title'] = sprintf( 'Order #%s', $this->order()->get_id() );
				$panorama['text'] = sprintf(
					'Bestelling #%s is geplaats op %s en is momenteel %s.',
					$this->order()->get_id() ,
					$this->order()->get_date_created()->format('j F Y'),
					strtolower( wc_get_order_status_name( $this->order()->get_status() ) )
				);
				break;

			case 'edit-account' :
				$panorama['title'] = __( 'Gegevens bewerken' );
				$panorama['text'] = $default_text;
				break;

			case 'edit-address' :
				$address_type = get_query_var( 'edit-address' );
				if ( ! empty( $address_type ) ) {
					$panorama['title'] = $address_type === 'shipping' ? __( 'Verzendadres bijwerken' ) : __( 'Factuuradres bijwerken' );
				} else {
					$panorama['title'] = __( 'Adresgegevens' );
				}
				$panorama['text'] = $default_text;
				break;

			case 'dashboard' :
			default :
				$panorama['title'] = sprintf( __( 'Hallo %s!' ), $display_name );
				$panorama['text'] = $default_text;
				break;

		endswitch;

		$this->_panorama = $panorama;

		return $this->_panorama;

	}

	public function current_page() {

		global $wp;

		if ( $this->_current_page ) {
			return $this->_current_page;
		}

		foreach ( $wp->query_vars as $key => $value ) {

			// Ignore pagename param.
			if ( 'pagename' === $key ) {
				continue;
			}

			if ( has_action( 'woocommerce_account_' . $key . '_endpoint' ) ) {

				$this->_current_page = $key;
				break;

			}

		}

		// Dashboard doesn't have a query var and is default when nothing else is found
		if ( empty( $this->_current_page ) ) {
			$this->_current_page = 'dashboard';
		}

		return $this->_current_page;

	}

	public function options() {

		if ( $this->_options ) {
			return $this->_options;
		}

		$this->_options = array(
			'registration_enabled'  => 'yes' === get_option( 'woocommerce_enable_myaccount_registration' ),
			'generate_username'     => 'yes' === get_option( 'woocommerce_registration_generate_username' ),
			'generate_password'     => 'yes' === get_option( 'woocommerce_registration_generate_password' ),
		);

		return $this->_options;

	}

}