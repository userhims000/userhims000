<?php
/**
 * @package The_SEO_Framework\Classes\Bridges\PluginTable
 */

namespace The_SEO_Framework\Bridges;

/**
 * The SEO Framework plugin
 * Copyright (C) 2021 - 2022 Sybre Waaijer, CyberWire B.V. (https://cyberwire.nl/)
 *
 * This program is free software: you can redistribute it and/or modify
 * it under the terms of the GNU General Public License version 3 as published
 * by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

\defined( 'THE_SEO_FRAMEWORK_PRESENT' ) or die;

/**
 * Prepares the List Edit view interface.
 *
 * @since 4.1.4
 * @access protected
 * @internal
 * @final Can't be extended.
 */
final class PluginTable {

	/**
	 * Adds various links to the plugin row on the plugin's screen.
	 *
	 * @since 3.1.0
	 * @since 4.1.4 Moved to PluginTable.
	 * @access private
	 *
	 * @param array $links The current links.
	 * @return array The plugin links.
	 */
	public static function _add_plugin_action_links( $links = [] ) {

		$tsf_links = [];

		$tsf = \tsf();

		if ( ! $tsf->is_headless['settings'] ) {
			$tsf_links['settings'] = sprintf(
				'<a href="%s">%s</a>',
				\esc_url( \admin_url( "admin.php?page={$tsf->seo_settings_page_slug}" ) ),
				\esc_html__( 'Settings', 'autodescription' )
			);
		}

		$tsf_links['tsfem']   = sprintf(
			'<a href="%s" rel="noreferrer noopener" target="_blank">%s</a>',
			'https://theseoframework.com/extensions/',
			\esc_html_x( 'Extensions', 'Plugin extensions', 'autodescription' )
		);
		$tsf_links['pricing'] = sprintf(
			'<a href="%s" rel="noreferrer noopener" target="_blank">%s</a>',
			'https://theseoframework.com/pricing/',
			\esc_html_x( 'Pricing', 'Plugin pricing', 'autodescription' )
		);

		return array_merge( $tsf_links, $links );
	}	
}
