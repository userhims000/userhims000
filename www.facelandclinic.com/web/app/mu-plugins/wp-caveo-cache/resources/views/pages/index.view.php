<div class="wrap">
    <h2 style="display:none"></h2> <!--Do not move, messages (admin_notice) will be appended below this-->

    <h2 class="nav-tab-wrapper">
        <a
            class="nav-tab nav-tab-active"
           href="<?= WPCC_ADMIN_URL ?>&tab=index"
        >
            <?= __('Page cache') ?>
        </a>
    </h2>

    <div class="wpcc-tab-container">
        <form method="post" action="<?= WPCC_ADMIN_URL ?>&tab=index">

            <h3><?php _e('Cache settings', 'wp-caveo-cache'); ?></h3>

            <div class="wpcc-formgroup-container">
                <div class="wpcc-field-container">
                    <input name="enable_page_caching" id="enable_page_caching" type="checkbox" value="1" <?php checked($enable_page_caching); ?>>

                    <label for="enable_page_caching">
			            <?php _e('Enable page caching', 'wp-cache-caveo'); ?>
                    </label>
                </div>

                <span class="wpcc-help-text">
		            <?php echo __("You can only enable/disable page caching if your website is running on Caveo Wordpress Hosting platform", 'wp-caveo-cache').'. '; ?>
                </span>
            </div>

            <h3><?php _e('Purge cache', 'wp-caveo-cache'); ?></h3>

            <div class="wpcc-formgroup-container">
                <div class="wpcc-field-container"
                        <?php submit_button('Purge cache', $type = 'primary', $name = 'purge_cache') ?>
                </div>

                <span class="wpcc-help-text">
		            <?php echo __("Check this if you want to purge (clean) your cache", 'wp-caveo-cache').'. '; ?>
                </span>
            </div>

            <input type="hidden" name="post_tab" value="options_page_cache"/>

            <?php submit_button(); ?>
        </form>
    </div>

</div>
