<?php
/**
 * Plugin Name: SEO Sitemap 
 * Plugin URI: https://en-masse.nl/
 * Description: An automated, advanced, accessible, unbranded and extremely fast SEO sitemap for your WordPress website.
 * Version: 1.0
 * Author: En Masse
 * Author URI: https://en-masse.nl/
 * License: GPLv3
 * Text Domain: autodescription
 * Domain Path: /language
 * Requires at least: 5.5
 * Requires PHP: 7.2.0
 *
 * @package The_SEO_Framework\Bootstrap
 */

defined( 'ABSPATH' ) or die;

/**
 * The SEO Framework plugin
 * Copyright (C) 2015 - 2022 Sybre Waaijer, CyberWire B.V. (https://cyberwire.nl/)
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

/**
 * The plugin version.
 *
 * 3 point: x.x.y; x.x is major; y is minor.
 *
 * @since 2.3.5
 */
define( 'THE_SEO_FRAMEWORK_VERSION', '4.2.3' );

/**
 * The plugin Database version.
 *
 * Used for lightweight version upgrade comparing.
 *
 * @since 2.7.0
 */
define( 'THE_SEO_FRAMEWORK_DB_VERSION', '4200' );

/**
 * The plugin file, absolute unix path.
 *
 * @since 2.2.9
 */
define( 'THE_SEO_FRAMEWORK_PLUGIN_BASE_FILE', __FILE__ );

/**
 * The plugin's bootstrap folder location.
 *
 * @since 3.1.0
 */
define( 'THE_SEO_FRAMEWORK_BOOTSTRAP_PATH', dirname( THE_SEO_FRAMEWORK_PLUGIN_BASE_FILE ) . DIRECTORY_SEPARATOR . 'bootstrap' . DIRECTORY_SEPARATOR );

// Defines environental constants.
require THE_SEO_FRAMEWORK_BOOTSTRAP_PATH . 'define.php';

// Load plugin API functions.
require THE_SEO_FRAMEWORK_DIR_PATH_FUNCT . 'api.php';

// Prepare plugin upgrader before the plugin loads. This may also downgrade (3103 or higher).
the_seo_framework_db_version() !== THE_SEO_FRAMEWORK_DB_VERSION
	and require THE_SEO_FRAMEWORK_BOOTSTRAP_PATH . 'upgrade.php';

// Load deprecated functions.
// require THE_SEO_FRAMEWORK_DIR_PATH_FUNCT . 'deprecated.php';

// Load plugin.
require THE_SEO_FRAMEWORK_BOOTSTRAP_PATH . 'load.php';

