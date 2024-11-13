<?php

require_once(WPCC_PLUGIN_MAIN_PATH . 'includes/template-builder.php');
require_once(WPCC_PLUGIN_MAIN_PATH . 'includes/call-builder.php');
require_once(WPCC_PLUGIN_MAIN_PATH . 'models/page-cache.php');
require_once(WPCC_PLUGIN_MAIN_PATH . 'traits/actions.php');
require_once(WPCC_PLUGIN_MAIN_PATH . 'traits/admin-interface.php');
require_once(WPCC_PLUGIN_MAIN_PATH . 'traits/events.php');
require_once(WPCC_PLUGIN_MAIN_PATH . 'traits/hooks.php');
require_once(WPCC_PLUGIN_MAIN_PATH . 'traits/messages.php');
require_once(WPCC_PLUGIN_MAIN_PATH . 'traits/pages.php');

class WP_Caveo_Cache
{
	use WP_Caveo_Cache_Actions,
		WP_Caveo_Cache_Admin_Interface,
		WP_Caveo_Cache_Events,
		WP_Caveo_Cache_Hooks,
		WP_Caveo_Cache_Messages,
		WP_Caveo_Cache_Pages;

	protected static $_instance;

	protected $_currentUrl;

	public $_purgeOnMenuSave = false;

	public function __construct ()
	{
		$this->registerWordpressHooks();
		$this->registerWordpressEvents();
		$this->registerWordpressAdmin();
		$this->setCurrentUrl();
		$this->registerCaveoMessages();
		$this->registerAfterLoad();
	}

	/**
	 * Register wordpress hooks (activation, deactivation, uninstall)
	 */
	protected function registerWordpressHooks (): void
	{
		register_activation_hook(__FILE__, 'activationHook');
		register_deactivation_hook(__FILE__, 'deactivationHook');
		register_uninstall_hook(__FILE__, 'uninstallHook');
	}

	/**
	 * Register wordpress events for purge cache
	 */
	protected function registerWordpressEvents (): void
	{
		foreach ($this->getEventsToRegister() as $event) {
			add_action($event, [$this, 'eventPurgeCache'], 10, 2);
		}

		// Check if is on Admin Pages.
		if (is_admin()) {
		    add_filter('post_row_actions', [&$this, 'addRowActions'], 0, 2);
		    add_filter('page_row_actions', [&$this, 'addRowActions'], 0, 2 );

//		    add_action('added_option', [$this, 'eventPurgeFullCache'], 10, 2);
		    add_action('updated_option', [$this, 'eventPurgeFullCache'], 10, 2);
		}
	}

	/**
	 * Register / init wordpress functions for admin menu.
	 */
	protected function registerWordpressAdmin (): void
	{
		add_action('admin_menu', [$this, 'addMenuItemAdminInterface']);
		add_action('admin_bar_menu', [$this, 'addMenuItemAdminBar'], 100);
	}

	/**
	 * Sets the current URL
	 */
	protected function setCurrentUrl (): void
	{
		$protocol = isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on'
			? "https"
			: "http";

		$this->_currentUrl =  "{$protocol}://{$_SERVER['HTTP_HOST']}{$_SERVER['REQUEST_URI']}";
	}

	/**
	 * register / output Caveo messages
	 */
	protected function registerCaveoMessages (): void
	{
		if (isset($_GET['caveo_note'])) {
			add_action('admin_notices', [$this, 'successMessage']);
		}

		if (isset($_GET['caveo_error'])) {
			add_action('admin_notices', [$this, 'errorMessage']);
		}
	}

	/**
	 * Things loaded after WP loaded (things that need WP Functions)
	 */
	protected function registerAfterLoad (): void
	{
		add_action('wp_loaded', [$this, 'handleEvents']);
	}

	/**
	 * Sets events to purge
	 * @return mixed|void
	 */
	protected function getEventsToRegister ()
	{
		return apply_filters('wp_caveo_cache_events', [
			'save_post',
			'deleted_post',
			'trashed_post',
			'edit_post',
			'delete_attachment',
			'switch_theme',
		]);
	}

	/**
	 * Initialises this class
	 *
	 * @return static
	 */
	public static function init (): self
	{
		if (self::$_instance === null) {
			self::$_instance = new self();
		}

		return self::$_instance;
	}
}
