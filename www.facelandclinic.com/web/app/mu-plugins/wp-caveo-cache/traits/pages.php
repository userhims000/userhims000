<?php

trait WP_Caveo_Cache_Pages
{
	protected function canUserAccess (): bool
	{
		$access = current_user_can('manage_options');

		if (! $access) {
			exit('Permission denied.');
		}

		return current_user_can('manage_options');
	}

	public function adminIndexPage (): void
	{
		$this->canUserAccess();

		// Handle Post
		WP_Caveo_Cache_Model_Page_Cache::processCacheStatus();
		WP_Caveo_Cache_Model_Page_Cache::processPurgeCache();

		// get Values we need
		$viewData = [
			'enable_page_caching' => WP_Caveo_Cache_Model_Page_Cache::getCacheStatus(),
		];

		$builder = new WP_Caveo_Cache_Template_Builder();

		echo $builder->addPage('pages/index')
					 ->addViewData($viewData)
		             ->getHTML();
	}
}
