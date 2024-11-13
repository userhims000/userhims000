<?php
/**
 * This file contains the class for registering the plugin's roadmap page.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/admin/pages
 * @author     Antonio Villegas <antonio.villegas@neliosoftware.com>
 * @since      6.1.0
 */

defined( 'ABSPATH' ) || exit;

/**
 * Class that registers the plugin's roadmap page.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/admin/pages
 * @author     Antonio Villegas <antonio.villegas@neliosoftware.com>
 * @since      6.1.0
 */
class Nelio_AB_Testing_Roadmap_Page extends Nelio_AB_Testing_Abstract_Page {

	public function __construct() {

		parent::__construct(
			'nelio-ab-testing',
			_x( 'Roadmap', 'text', 'nelio-ab-testing' ),
			_x( 'Roadmap', 'text', 'nelio-ab-testing' ),
			'edit_nab_experiments',
			'nelio-ab-testing-roadmap'
		);

	}//end __construct()

	// @Implements
	// phpcs:ignore
	public function enqueue_assets() {

		$screen = get_current_screen();
		if ( 'nelio-a-b-testing_page_nelio-ab-testing-roadmap' !== $screen->id ) {
			return;
		}//end if

		wp_enqueue_style(
			'nab-roadmap-page',
			nelioab()->plugin_url . '/assets/dist/css/roadmap-page.css',
			array(),
			nelioab()->plugin_version
		);
		nab_enqueue_script_with_auto_deps( 'nab-roadmap-page', 'roadmap-page', true );

	}//end enqueue_assets()

	// @Implements
	// phpcs:ignore
	public function display() {
		// phpcs:ignore
		require_once nelioab()->plugin_path . '/admin/views/nelio-ab-testing-roadmap-page.php';
	}//end display()

}//end class
