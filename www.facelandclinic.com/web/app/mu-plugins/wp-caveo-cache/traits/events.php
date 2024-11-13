<?php

trait WP_Caveo_Cache_Events
{
	protected $option_exclude_list = [
        	'_transient_',
		'bwp_',
		'layerslider',
		'recently_edited',
		'cron',
		'action_scheduler_',
		'mw_',
		'mlfp-folder-check',
		'_transient_',
		'wpmdb_',
		'ub-',
		'_site_transient_update_themes',
    	];
	
	public function handleEvents (): void
	{
		if (isset($_GET['purge_wp_caveo_cache']) && check_admin_referer('wp-caveo-cache')) {
			WP_Caveo_Cache_Model_Page_Cache::processPurgeCache();

			$referer = wp_get_referer();
			$referer .= (strpos($referer, '?') ? '&' : '?') . 'caveo_note=1';

			wp_redirect($referer);
			echo '<meta http-equiv="refresh" content="0; url='.$referer.'">'; // fallback... header sent message
			exit;
		}

		if (isset($_GET['action'], $_GET['post_id']) && in_array($_GET['action'], ['purge_post', 'purge_page'], true)) {
			$this->eventPurgeCache($_GET['post_id']);

			$referer = wp_get_referer();
			$referer .= (strpos($referer, '?') ? '&' : '?') . 'caveo_note=1';

			wp_redirect($referer);
			echo '<meta http-equiv="refresh" content="0; url='.$referer.'">'; // fallback... header sent message
			exit;
		}
	}

	public function eventPurgeCache ($postId, $post = null): void
	{
		if (get_post_type($post) === 'nav_menu_item' && $this->_purgeOnMenuSave === false) {
			return;
		}

		if ($this->pageIsRevision($postId, $post)) {
			return;
		}

		$urls = $this->getPurgeUrls($postId, $post);

		WP_Caveo_Cache_Model_Page_Cache::processPurgeCache($urls);
	}

	public function eventPurgeFullCache ($option_name): void
	{
		if ($this->validateOptionExcludeList($option_name)) {
		    return;
		}

		WP_Caveo_Cache_Model_Page_Cache::processPurgeCache([], true);
	}

	protected function validateOptionExcludeList ($event_option_name): bool
	{
		foreach ($this->option_exclude_list as $option) {
		    if (strpos($event_option_name, $option) !== false) {
			return true;
		    }
		}

		return false;
	}

	protected function pageIsRevision ($postId, $post): bool
	{
		$validPostStatus = array('publish', 'trash');
		$thisPostStatus  = get_post_status($postId);

		return get_permalink($postId) !== true && ! in_array( $thisPostStatus, $validPostStatus, true);
	}

	protected function getPurgeUrls ($postId, $post): array
	{
		$urls = [];

		// Category purge based on Donnacha's work in WP Super Cache
		$categories = get_the_category($postId);
		if ($categories) {
			foreach ($categories as $cat) {
				$urls[] = get_category_link( $cat->term_id );
			}
		}

		// Tag purge based on Donnacha's work in WP Super Cache
		$tags = get_the_tags($postId);
		if ($tags) {
			foreach ($tags as $tag) {
				$urls[] = get_tag_link( $tag->term_id );
			}
		}

		// Author URL's
		$urls[] = get_author_posts_url(get_post_field('post_author', $postId));
		$urls[] = get_author_feed_link(get_post_field('post_author', $postId));

		// Archived URL's
		if (get_post_type_archive_link(get_post_type($postId))) {
			$urls[] = get_post_type_archive_link(get_post_type($postId));
			$urls[] = get_post_type_archive_feed_link(get_post_type($postId));
		}

		// Post URL
		$urls[] = get_permalink($postId);

		// (RSS) Feeds
		$urls[] = get_bloginfo_rss('rdf_url');
		$urls[] = get_bloginfo_rss('rss_url');
		$urls[] = get_bloginfo_rss('rss2_url');
		$urls[] = get_bloginfo_rss('atom_url');
		$urls[] = get_bloginfo_rss('atom_url');
		$urls[] = get_bloginfo_rss('comments_rss2_url');
		$urls[] = get_post_comments_feed_link($postId);

		// Home Page and (if used) posts page
		$urls[] = home_url('/');

		if (get_option('show_on_front') === 'page') {
			$urls[] = get_permalink(get_option('page_for_posts'));
		}

		// If Automattic's AMP is installed, add AMP permalink
		if (function_exists('amp_get_permalink')) {
			$urls[] = amp_get_permalink($postId);
		}

		return $urls;
	}
}
