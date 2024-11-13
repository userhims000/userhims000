<?php
/*
Plugin Name: SearchWP Polylang Integration
Plugin URI: https://searchwp.com/
Description: Integrate SearchWP with Polylang
Version: 1.3.3
Author: SearchWP
Author URI: https://searchwp.com/

Copyright 2013-2021 SearchWP

This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, see <http://www.gnu.org/licenses/>.
*/

// exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( ! defined( 'SEARCHWP_POLYLANG_VERSION' ) ) {
	define( 'SEARCHWP_POLYLANG_VERSION', '1.3.3' );
}

/**
 * instantiate the updater
 */
if ( ! class_exists( 'SWP_Polylang_Updater' ) ) {
	// load our custom updater
	include_once( dirname( __FILE__ ) . '/vendor/updater.php' );
}

// set up the updater
function searchwp_polylang_update_check() {

	if ( defined( 'DOING_AJAX' ) && DOING_AJAX ) {
		return false;
	}

	// environment check
	if ( ! defined( 'SEARCHWP_PREFIX' ) ) {
		return false;
	}

	if ( ! defined( 'SEARCHWP_EDD_STORE_URL' ) ) {
		return false;
	}

	// SearchWP 4 compat.
	if ( class_exists( '\\SearchWP\\License' ) ) {
		$license_key = \SearchWP\License::get_key();
	} else {
		$license_key = trim( get_option( SEARCHWP_PREFIX . 'license_key' ) );
		$license_key = sanitize_text_field( $license_key );
	}

	// instantiate the updater to prep the environment
	$searchwp_polylang_updater = new SWP_Polylang_Updater( SEARCHWP_EDD_STORE_URL, __FILE__, array(
			'item_id' 	=> 33648,
			'version'   => SEARCHWP_POLYLANG_VERSION,
			'license'   => $license_key,
			'item_name' => 'Polylang Integration',
			'author'    => 'SearchWP',
			'url'       => site_url(),
		)
	);

	return $searchwp_polylang_updater;
}

add_action( 'admin_init', 'searchwp_polylang_update_check' );

class SearchWP_Polylang {

	function __construct() {
		add_action( 'after_plugin_row_' . plugin_basename( __FILE__ ), array( $this, 'plugin_row' ), 11 );

		add_filter( 'searchwp_include', array( $this, 'include_only_current_language_posts' ), 10, 3 );

		// prevent interference with the indexer
		add_action( 'searchwp_indexer_pre', array( $this, 'remove_all_unwanted_filters' ) );

		// SearchWP 4.0 compat.
		add_filter( 'searchwp\query\mods', array( $this, 'add_mods' ), 10, 2 );
		add_filter( 'searchwp\native\args', array( $this, 'remove_native_polylang_args' ) );
	}

	/**
	 * Removes Polylang's tax_query from \SearchWP\Native because we're adding our own.
	 *
	 * @param mixed $args
	 * @return mixed
	 */
	function remove_native_polylang_args( $args ) {
		if ( ! empty( $args['tax_query'] ) ) {
			foreach ( $args['tax_query'] as $key => $val ) {
				if ( isset( $val['taxonomy'] ) && 'language' === $val['taxonomy'] ) {
					unset( $args['tax_query'][ $key ] );
				}
			}

			$args['tax_query'] = array_values( $args['tax_query'] );
		}

		return $args;
	}

	function add_mods( $mods, $query ) {
		global $polylang, $wpdb;

		if ( ! class_exists( 'PLL_Model' ) ) {
			return;
		}

		$model = new \PLL_Model( $polylang->options );

		if ( ! function_exists( 'pll_current_language' ) || ! function_exists( 'pll_default_language' ) ) {
			return $mods;
		}

		$currentLanguage = pll_current_language();

		if ( false == $currentLanguage ) {
			$currentLanguage = pll_default_language();
		}

		// We need to loop through all post types and add a Mod for each.
		foreach ( $query->get_engine()->get_sources() as $source ) {
			$flag = 'post' . SEARCHWP_SEPARATOR;

			if ( 0 !== strpos( $source->get_name(), $flag ) ) {
				continue;
			}

			$post_type = substr( $source->get_name(), strlen( $flag ) );

			if ( ! $model->is_translated_post_type( $post_type ) ) {
				continue;
			}

			// We need to do a bit of detective work depending on the tax_query.
			$alias     = 'swppolylang';
			$tax_query = new WP_Tax_Query( array(
				array(
					'taxonomy'  => 'language',
					'field'     => 'slug',
					'terms'     => sanitize_text_field( $currentLanguage ),
				),
			) );
			$tq_sql    = $tax_query->get_sql( $alias, 'ID' );
			$mod       = new \SearchWP\Mod();

			// If the JOIN is empty, WP_Tax_Query assumes we have a JOIN with wp_posts, so let's make that.
			if ( ! empty( $tq_sql['join'] ) ) {
				// Queue the assumed wp_posts JOIN using our alias.
				$mod->raw_join_sql( function( $runtime ) use ( $wpdb, $alias ) {
					return "LEFT JOIN {$wpdb->posts} {$alias} ON {$alias}.ID = {$runtime->get_foreign_alias()}.id";
				} );

				// Queue the WP_Tax_Query JOIN which already has our alias.
				$mod->raw_join_sql( $tq_sql['join'] );

				// Queue the WP_Tax_Query WHERE which already has our alias.
				$mod->raw_where_sql( '1=1 ' . $tq_sql['where'] );
			} else {
				// There's no JOIN here because WP_Tax_Query assumes a JOIN with wp_posts already
				// exists. We need to rebuild the tax_query SQL to use a functioning alias. The Mod
				// will ensure the JOIN, and we can use that Mod's alias to rebuild our tax_query.
				$mod->set_local_table( $wpdb->posts );
				$mod->on( 'ID', [ 'column' => 'id' ] );

				$mod->raw_where_sql( function( $runtime ) use ( $tax_query ) {
					$tq_sql = $tax_query->get_sql( $runtime->get_local_table_alias(), 'ID' );

					return '1=1 ' . $tq_sql['where'];
				} );
			}

			$mods[] = $mod;

			// This is an Index Mod. Bail out.
			break;
		}

		return $mods;
	}

	function remove_all_unwanted_filters() {
		remove_all_filters( 'parse_query' );
	}

	function include_only_current_language_posts( $relevantPostIds, $engine, $terms ) {

		if ( isset( $engine ) ) {
			$engine = null;
		}

		if ( isset( $terms ) ) {
			$terms = null;
		}

		$post_ids = $relevantPostIds;

		if ( function_exists( 'pll_current_language' ) && function_exists( 'pll_default_language' ) ) {

			$currentLanguage = pll_current_language();

			if ( false == $currentLanguage ) {
				$currentLanguage = pll_default_language();
			}

			// get all posts in the current language
			$args = array(
				'nopaging'      => true,
				'post_type'     => 'any',
				'post_status'   => 'any',
				'fields'        => 'ids',
				'tax_query'     => array(
					array(
						'taxonomy'  => 'language',
						'field'     => 'slug',
						'terms'     => sanitize_text_field( $currentLanguage ),
					),
				)
			);

			// we may need to limit to relevant post IDs
			if ( ! empty( $relevantPostIds ) ) {
				$args['post__in'] = array_map( 'absint', $relevantPostIds );
			}

			$query = new WP_Query( $args );
			$post_ids = $query->posts;
		}

		return $post_ids;
	}

	function plugin_row() {
		if ( ! function_exists( 'SWP' ) ) {
			return;
		}

		if ( ! class_exists( 'SearchWP' ) ) { ?>
			<tr class="plugin-update-tr searchwp">
				<td colspan="3" class="plugin-update">
					<div class="update-message">
						<?php _e( 'SearchWP must be active to use this Extension' ); ?>
					</div>
				</td>
			</tr>
		<?php } else { ?>
		<?php $searchwp = SWP(); ?>
		<?php if ( version_compare( $searchwp->version, '1.1', '<' ) ) : ?>
			<tr class="plugin-update-tr searchwp">
				<td colspan="3" class="plugin-update">
					<div class="update-message">
						<?php _e( 'SearchWP Polylang Integration requires SearchWP 1.1 or greater', $searchwp->textDomain ); ?>
					</div>
				</td>
			</tr>
		<?php endif; ?>
	<?php }
	}

}

new SearchWP_Polylang();
