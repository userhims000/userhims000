<?php
/*--------------------------------------------------------------------------
*
*	umt_seo_support
*	Adds Yoast SEO Meta support to metabox tabs
*
*	@author Jasper Rooduijn | Rodesk
*
*-------------------------------------------------------------------------*/

class umt_wpseo_support {
	var $umt, $input;

	function __construct($parent) {
		$this->umt = $parent;

		// setup initiation procedure
		add_action('init',array($this,'init'),99);
	}

	function init() {

		// Check if WPSEO is installed
		if ( defined('WPSEO_VERSION') ) {

			// hooks to the admin_men_print_styles if its used by Ultimate Metabox tabs
			add_action('umt_admin_menu_print_styles',array($this,'admin_menu_print_styles'));

		} else {
			trigger_error("Support for WP SEO has become broken. Please contact the developer. For now, disable the extension.");
		}
	}

	function admin_menu_print_styles() {

		$posts = array();

		$new_post = array();
		$new_post['name'] = 'SEO meta box';
		$new_post['value'] = "wpseo_meta";
		array_push($posts,$new_post);

		// Places the posts into a div group list
		umt_register_div_types(__( 'WP SEO (Yoast)', 'umt' ),$posts);

	}
}
?>
