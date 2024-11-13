<?php

trait WP_Caveo_Cache_Admin_Interface
{
	public function addMenuItemAdminInterface (): void
	{
		add_menu_page(
			__('WP Caveo Cache'),
			__('WP Caveo Cache'),
			'manage_options',
			'wp-caveo-cache-plugin',
			[$this, 'adminIndexPage'],
			'',
			99
		);
	}

	public function addMenuItemAdminBar ($admin_bar): void
	{
		$admin_bar
			->add_menu([
			'id'    => 'purge-wp-caveo-cache',
			'title' => __('Purge Cache', 'wp-caveo-cache'),
			'href'  => wp_nonce_url(add_query_arg('purge_wp_caveo_cache', 1), 'wp-caveo-cache'),
			'meta'  => [
				'title' => __('Purge Cache', 'wp-caveo-cache'),
			]
		]);
	}

	protected function handleAdminBarPurge (): void
	{
		if (isset($_GET['purge_wp_caveo_cache']) && check_admin_referer('wp-caveo-cache')) {
			WP_Caveo_Cache_Model_Page_Cache::processPurgeCache();

			$referer = wp_get_referer();
			$referer .= (strpos($referer, '?') ? '&' : '?') . 'caveo_note=1';

			wp_redirect($referer);
			echo '<meta http-equiv="refresh" content="0; url='.$referer.'">'; // fallback... header sent message
			exit;
		}
	}
}
