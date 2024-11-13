<?php

class WP_Caveo_Cache_Model_Page_Cache
{
	public static function processCacheStatus (): void
	{
		if (isset($_POST['post_tab']) && $_POST['post_tab'] === 'options_page_cache') {
			$call = new WP_Caveo_Cache_Call_Builder('status');
			$call->setPayload([
					'active' => isset($_POST['enable_page_caching']) ? 'true' : 'false',
                    'domain' => get_site_url()
				])
			     ->run();
		}
	}

	public static function processPurgeCache (Array $urls = [], Bool $force = false): void
	{
		if (count($urls) > 0) {
			self::purgeUrls($urls);
			return;
		}

		if ($force || isset($_POST['purge_cache']) || isset($_GET['purge_wp_caveo_cache'])) {
			(new WP_Caveo_Cache_Call_Builder('recache'))
                ->setPayload([
                    'domain' => get_site_url()
                ])
                ->run();
		}
	}

	public static function getCacheStatus (): bool
	{
		$output = (new WP_Caveo_Cache_Call_Builder('status'))
	        ->setPayload([
                'domain' => get_site_url()
            ])
            ->run();

		return isset($output['msg']) && ($output['msg'] == 1 || $output['msg'] === 'Cache Enabled.')
			? 1
			: 0;
	}

	protected static function purgeUrls(Array $urls): void
	{
		// Refresh urls
		$url_string = implode(',', $urls);

		// Fix , ending
		if (substr($url_string, -1, 1) === ',') {
			$url_string = substr($url_string, 0, -1);
		}

		// send call
		$call = new WP_Caveo_Cache_Call_Builder('recache');
		$call->setMethod('POST')
			->setPayload([
				'urls' => $url_string
			])
		     ->run();
	}
}
