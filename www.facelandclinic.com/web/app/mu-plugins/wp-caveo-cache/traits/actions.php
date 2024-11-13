<?php

trait WP_Caveo_Cache_Actions
{
	public function addRowActions ($actions, $post): array
	{
		$actions['wp_caveo_cache_purge_post'] = sprintf(
			'<a href="%s">' . __('Purge caveo cache', 'wp-cave-cache') . '</a>',
			wp_nonce_url(sprintf(WPCC_ADMIN_URL . '&tab=index&action=purge_post&post_id=%d', $post->ID), 'wp-cave-cache')
		);

		return $actions;
	}
}
