<?php

trait WP_Caveo_Cache_Messages
{
	public function successMessage (): void
	{
		echo '<div id="message" class="updated fade"><p><strong>' . __('WP Caveo Cache', 'wp-caveo-cache') . '</strong><br />' . __('Purging selected items, this can take a few moments...') . '</p></div>';
	}

	public function errorMessage (): void
	{
		echo '<div id="message" class="error">
                <p>
                    <strong>' . __('WP Caveo Cache', 'wp-caveo-cache') . '</strong><br />' . __('Whoops! Something went wrong... please contact support@caveo.nl') . '<br /><br /> . '. urldecode($_GET['caveo_error_message']) . '
                </p>
              </div>';
	}
}
