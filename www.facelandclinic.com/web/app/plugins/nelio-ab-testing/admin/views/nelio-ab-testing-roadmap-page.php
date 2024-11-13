<?php
/**
 * Displays the UI for the roadmap.
 *
 * @package    Nelio_AB_Testing
 * @subpackage Nelio_AB_Testing/admin/views
 * @author     Antonio Villegas <antonio.villegas@neliosoftware.com>
 * @since      6.1.0
 */

defined( 'ABSPATH' ) || exit;

?>

<div class="wrap">

	<h2 class="screen-reader-text">
		<?php echo esc_html_x( 'Nelio A/B Testing - Roadmap', 'text', 'nelio-ab-testing' ); ?>
	</h2>

	<iframe id="nab-trello-iframe" src="https://trello.com/b/4zBeOjTM.html"></iframe>

</div><!-- .wrap -->
