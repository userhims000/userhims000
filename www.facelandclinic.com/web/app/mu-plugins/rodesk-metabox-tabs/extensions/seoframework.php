<?php
/*--------------------------------------------------------------------------
*
*	umt_seoframework_support
*	Adds The SEO Framework support to metabox tabs
*
*	@author Jasper Rooduijn | Rodesk
*
*-------------------------------------------------------------------------*/

class umt_seoframework_support {
	var $umt, $input;

	function __construct( $parent ) {

		$this->umt = $parent;

		// setup initiation procedure
		add_action( 'init', array( $this, 'init' ), 99 );
	}

	function init() {

        // Check if WPSEO is installed
		if ( defined( 'WPSEO_VERSION' ) ) {

            // trigger_error( "YOAST WordPress SEO plugin is activated. WordPress SEO Framework does not play nice wit Yoast Seo enabled. Please Deactivate the Yoast WordPress SEO plugin." );

		} elseif ( defined( 'THE_SEO_FRAMEWORK_VERSION' ) ) {

			// hooks to the admin_men_print_styles if its used by Ultimate Metabox tabs
			add_action( 'umt_admin_menu_print_styles', array( $this, 'admin_menu_print_styles' ) );

		} else {

			trigger_error("Support for The SEO Framework has become broken. Please contact the developer. For now, disable the extension.");

		}
	}

	function admin_menu_print_styles() {

		$posts = array();

		$new_post = array();
		$new_post['name'] = 'SEO Framework meta box';
		$new_post['value'] = "theseoframework-inpost-box";
		array_push($posts,$new_post);

		// Places the posts into a div group list
		umt_register_div_types(__( 'The SEO Framework', 'umt' ),$posts);

	}
}
?>
