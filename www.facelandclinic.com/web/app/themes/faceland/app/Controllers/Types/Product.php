<?php

namespace Rokit\Controllers\Types;

class Product extends Post {

	/**
	 * @var WC_Product
	 */
	protected $_product;

	protected $_type;

	protected $_regular_price;

	protected $_sale_price;

	protected $_description;

	protected $_short_description;

	protected $_title;

	protected $_available_variations;

	protected $_variations_attr;

	protected $_cart_form_class;

	protected $_attributes;

	protected $_selected_attributes;

	protected $_image;

	protected $_gallery_images;

	protected $_public_attributes;

	public function __construct( $pid = null ) {

		parent::__construct( $pid );

		$this->_product = wc_get_product( $this->ID );

	}

	/**
	 * @return WC_Product
	 */
	public function product() {
		return $this->_product;
	}

	public function type() {

		if ( $this->_type ) {
			return $this->_type;
		}

		$this->_type = $this->_product->get_type();

		return $this->_type;

	}

	/**
	 * @return string HTML price markup
	 */
	public function price() {
		return $this->_product->get_price_html();
	}

	/**
	 * The regular, full price, without discount.
	 *
	 * @return string
	 */
	public function regular_price() {

		if ( $this->_regular_price ) {
			return $this->_regular_price;
		}

		switch ( $this->type() ) :

			case 'variable' :

				$this->_regular_price = $this->_product->get_variation_regular_price();

				break;

			case 'grouped' :

				$child_prices = array();
				$children = array_filter( array_map( 'wc_get_product', $this->_product->get_children() ), 'wc_products_array_filter_visible_grouped' );

				foreach ( $children as $child ) {
					if ( '' !== $child->get_regular_price() ) {
						$child_prices[] = wc_get_price_including_tax( $child );
					}
				}

				$this->_regular_price = max( $child_prices );

				break;

			default :

				$this->_regular_price = $this->_product->get_regular_price();

				break;

		endswitch;

		return $this->_regular_price;

	}

	/**
	 * @return string
	 */
	public function sale_price() {

		if ( $this->_sale_price ) {
			return $this->_sale_price;
		}

		switch ( $this->type() ) :

			case 'variable' :

				$this->_sale_price = $this->_product->get_variation_sale_price();

				break;

			case 'grouped' :

				$child_prices = array();
				$children = array_filter( array_map( 'wc_get_product', $this->_product->get_children() ), 'wc_products_array_filter_visible_grouped' );

				foreach ( $children as $child ) {
					if ( '' !== $child->get_sale_price() ) {
						$child_prices[] = wc_get_price_including_tax( $child );
					}
				}

				$this->_sale_price = max( $child_prices );

				break;

			default :

				$this->_sale_price = $this->_product->get_sale_price();

				break;

		endswitch;

		return $this->_sale_price;

	}

	public function is_on_sale() {
		return $this->_product->is_on_sale();
	}

	public function discount_percent() {

		$regular_price = $this->regular_price();
		$sale_price    = $this->sale_price();

		return ( ( $regular_price - $sale_price ) / $regular_price ) * 100;

	}

	public function title() {

		if ( $this->_title ) {
			return $this->_title;
		}

		$this->_title = $this->_product->get_title();

		return $this->_title;

		woocommerce_form_field();

	}

	public function description() {

		if ( $this->_description ) {
			return $this->_description;
		}

		$this->_description = $this->_product->get_description();

		return $this->_description;

	}

	public function short_description() {

		if ( $this->_short_description ) {
			return $this->_short_description;
		}

		$this->_short_description = $this->_product->get_short_description();

		return $this->_short_description;

	}

	public function available_variations() {

		if ( $this->_available_variations ) {
			return $this->_available_variations;
		}

		if ( 'variable' === $this->type() ) {

			$this->_available_variations = $this->_product->get_available_variations();

			return $this->_available_variations;

		}

	}

	public function variations_attr() {

		if ( $this->_variations_attr ) {
			return $this->_variations_attr;
		}

		$available_variations = $this->available_variations();

		if ( $available_variations ) {

			$variations_json = wp_json_encode( $available_variations );

			$this->_variations_attr = wc_esc_json( $variations_json );

			return $this->_variations_attr;

		}

	}

	public function attributes() {

		if ( $this->_attributes ) {
			return $this->_attributes;
		}

		if ( 'variable' === $this->type() ) {

			$this->_attributes = $this->_product->get_attributes();

			return $this->_attributes;

		}

	}

	public function selected_attributes() {

		if ( $this->_selected_attributes ) {
			return $this->_selected_attributes;
		}

		if ( 'variable' === $this->type() ) {

			$this->_selected_attributes = $this->_product->get_default_attributes();

			return $this->_selected_attributes;

		}

	}

	public function cart_form_class() {

		if ( $this->_cart_form_class ) {
			return $this->_cart_form_class;
		}

		switch ( $this->type() ) :

			case 'variable' :
				$form_class = 'cart variations_form';
				break;

			default :
				$form_class = 'cart';
				break;

		endswitch;

		$this->_cart_form_class = $form_class;

		return $this->_cart_form_class;

	}

	public function image() {

		if ( $this->_image ) {
			return $this->_image;
		}

		$this->_image = $this->product()->get_image_id();

		return $this->_image;

	}

	public function gallery_images() {

		if ( $this->_gallery_images ) {
			return $this->_gallery_images;
		}

		$this->_gallery_images = $this->product()->get_gallery_image_ids();

		return $this->_gallery_images;

	}

	public function public_attributes() {

		if ( $this->_public_attributes ) {
			return $this->_public_attributes;
		}

		$product = $this->product();
		$product_attributes = array();

		// Display weight and dimensions before attribute list.
		$display_dimensions = apply_filters( 'wc_product_enable_dimensions_display', $product->has_weight() || $product->has_dimensions() );

		if ( $display_dimensions && $product->has_weight() ) {
			$product_attributes['weight'] = array(
				'label' => __( 'Weight', 'woocommerce' ),
				'value' => wc_format_weight( $product->get_weight() ),
			);
		}

		if ( $display_dimensions && $product->has_dimensions() ) {
			$product_attributes['dimensions'] = array(
				'label' => __( 'Dimensions', 'woocommerce' ),
				'value' => wc_format_dimensions( $product->get_dimensions( false ) ),
			);
		}

		// Add product attributes to list.
		$attributes = array_filter( $product->get_attributes(), 'wc_attributes_array_filter_visible' );

		foreach ( $attributes as $attribute ) {
			$values = array();

			if ( $attribute->is_taxonomy() ) {
				$attribute_taxonomy = $attribute->get_taxonomy_object();
				$attribute_values   = wc_get_product_terms( $product->get_id(), $attribute->get_name(), array( 'fields' => 'all' ) );

				foreach ( $attribute_values as $attribute_value ) {
					$value_name = esc_html( $attribute_value->name );

					if ( $attribute_taxonomy->attribute_public ) {
						$values[] = '<a href="' . esc_url( get_term_link( $attribute_value->term_id, $attribute->get_name() ) ) . '" rel="tag">' . $value_name . '</a>';
					} else {
						$values[] = $value_name;
					}
				}
			} else {
				$values = $attribute->get_options();

				foreach ( $values as &$value ) {
					$value = make_clickable( esc_html( $value ) );
				}
			}

			$product_attributes[ 'attribute_' . sanitize_title_with_dashes( $attribute->get_name() ) ] = array(
				'label' => wc_attribute_label( $attribute->get_name() ),
				'value' => wptexturize( implode( ', ', $values ) ),
			);
		}

		$this->_public_attributes = $product_attributes;

		return $this->_public_attributes;

	}

}
