<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

class ProductCollection extends PostCollection {

	protected static $postType = 'product';

	protected static $postClass = 'Rokit\Controllers\Types\Product';

	protected $_loop = array();

	protected $_orderby;

	protected $_orderby_options = array();

	protected $_show_default_orderby;

	var $_title;

	var $_subtitle;

	var $_bottom;

    public function title() {
        if( !$this->_title ) {
            $this->_title =  get_field('page_title', '5516');
        }

        return $this->_title;
    }

    public function subtitle() {
        if( !$this->_subtitle ) {
            $this->_subtitle =  get_field('page_subtitle', '5516');
        }

        return $this->_subtitle;
    }

    public function bottom() {
        if( !$this->_bottom ) {
            $this->_bottom =  get_field('page_bottom', '5516');
        }

        return $this->_bottom;
    }


    /**
	 * Loop properties.
	 *
	 * @return array
	 */
	public function loop() {

		if ( $this->_loop ) {
			return $this->_loop;
		}

		$this->_loop = array(
			'total'     => absint( wc_get_loop_prop( 'total' ) ),
			'per_page'  => absint( wc_get_loop_prop( 'per_page' ) ),
			'current'   => absint( wc_get_loop_prop( 'current_page' ) ),
		);

		return $this->_loop;

	}

	/**
	 * What the archive is currently ordered by.
	 *
	 * @return array
	 */
	public function orderby() {

		if ( $this->_orderby ) {
			return $this->_orderby;
		}

		$default_orderby = wc_get_loop_prop( 'is_search' ) ? 'relevance' : apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', '' ) );
		$this->_orderby  = isset( $_GET['orderby'] ) ? wc_clean( wp_unslash( $_GET['orderby'] ) ) : $default_orderby;

		return $this->_orderby;

	}

	/**
	 * Options for archive sorting.
	 *
	 * @return array
	 */
	public function orderby_options() {

		if ( $this->_orderby_options ) {
			return $this->_orderby_options;
		}

		$this->_orderby_options = apply_filters(
			'woocommerce_catalog_orderby',
			array(
				'menu_order' => __( 'Default sorting', 'woocommerce' ),
				'popularity' => __( 'Sort by popularity', 'woocommerce' ),
				'rating'     => __( 'Sort by average rating', 'woocommerce' ),
				'date'       => __( 'Sort by latest', 'woocommerce' ),
				'price'      => __( 'Sort by price: low to high', 'woocommerce' ),
				'price-desc' => __( 'Sort by price: high to low', 'woocommerce' ),
			)
		);

		return $this->_orderby_options;

	}

	/**
	 * Whether to show the default orderby option.
	 *
	 * @return bool
	 */
	public function show_default_orderby() {

		if ( $this->_show_default_orderby ) {
			return $this->_show_default_orderby;
		}

		$this->_show_default_orderby = 'menu_order' === apply_filters( 'woocommerce_default_catalog_orderby', get_option( 'woocommerce_default_catalog_orderby', 'menu_order' ) );

		return $this->_show_default_orderby;

	}

}
