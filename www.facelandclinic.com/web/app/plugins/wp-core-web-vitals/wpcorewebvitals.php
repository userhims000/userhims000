<?php
/**
 * Plugin Name: WP Core Web Vitals
 * Description: Core Web Vitals Plugin - www.corewebvitals.io
 * Version: 3.3.7
 * Author: Arjen
 */

namespace WPCWV;

$GLOBALS['wp_cwv_options'] = json_decode(get_option('wp_cwv_options'),true);
$GLOBALS['wp_cwv_default_options'] = ['wp_cwv_page_cache'=> 1,'cwv_page_minify'=>1,'cwv_combine_css'=>0,'wp_cwv_css'=>1,'cwv_lazy_load_images'=>1,'cwv_lazy_load_images_js'=>1,'cwv_lazy_load_bg_images'=>1,'cwv_async_render_images'=>1,'cwv_img_width_height'=>0,'cwv_defer_scripts'=>1,'cwv_footer_scripts1'=>1,'cwv_page_remove_dns_prefetch'=>1,'cwv_page_remove_preconnect'=>1,'cwv_footer_scripts'=>1,'cwv_text_rendering'=>1,'wp_cwv_critical_all_pages'=>0,'wp_cwv_page_cache_urlparam'=>0];


function critical_get_option($key){
	if(isset($GLOBALS['wp_cwv_options'][$key])){
		return $GLOBALS['wp_cwv_options'][$key];
	}

	if(isset($GLOBALS['wp_cwv_default_options'][$key])){
		return $GLOBALS['wp_cwv_default_options'][$key];
	}
	return false;
}


define( 'WP_CWV_PLUGIN_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_CWV_PLUGIN_DIR', plugin_dir_url( __FILE__ ) );
define( 'WP_CWV_LICENCE_KEY', critical_get_option('wp_cwv_key') );
define( 'WP_CWV_SITE_URL', get_site_url()); 
define( 'WP_CWV_VERSION', '3.3.7' );

// quick and dirty!
function dirtyByPassCache(){

	if(parse_url(WP_CWV_SITE_URL,PHP_URL_HOST) != $_SERVER['HTTP_HOST']){
		return true;
	}

	//logged in
	foreach ((array)$_COOKIE as $cookie_key => $cookie_value){
		if(preg_match("/wordpress_logged_in/i", $cookie_key)){
			return true;
		}
	}

	// no cache system
	if(critical_get_option('wp_cwv_page_cache') == false){
		return true;
	}

	// Only GET withour vars
	if($_SERVER['REQUEST_METHOD'] != 'GET'){
		return true;
	} else  if(is_array($_GET) && sizeof($_GET) > 0){
		if(critical_get_option('wp_cwv_page_cache_urlparam') == 0){
			return true;
		}
	}

	// WP-CLI
	if ( defined( 'WP_CLI' ) && WP_CLI ) {
		return true;
	}

	// Other CLI
	if(isset($_SERVER['argv']) && is_array($_SERVER['argv']) && sizeof($_SERVER['argv']) > 0){
		return true;
	}

	return false;
}

if(!dirtyByPassCache()){
	$filename = md5(trim($_SERVER['REQUEST_URI'],'/')).'.html';
	if(@include (WP_CONTENT_DIR.'/cache/wp_cwv/html/'.$filename)){
		echo '<!-- cached and optimized by www.corewebvitals.io -->';
		exit();
	}
}



add_action('template_redirect', 'WPCWV\initcwv',1); 
function initcwv(){


	// not loving this, need to rethink + rewrite
	if(get_the_ID() > 0 && $_SERVER['REQUEST_METHOD'] == 'GET' && (critical_get_option('wp_cwv_page_cache_urlparam') == 1 || sizeof((array)$_GET) == 0) && @sizeof((array)$_SERVER['argv']) == 0){

		require_once( WP_CWV_PLUGIN_PATH . 'optim/common/simplehtmldom.php' );
		require_once( WP_CWV_PLUGIN_PATH . 'optim/common/StrategyInterface.php' );
		require_once( WP_CWV_PLUGIN_PATH . 'optim/common/CssUtilities.php' );
		require_once( WP_CWV_PLUGIN_PATH . 'optim/cache/CWVCache.php' );
		require_once( WP_CWV_PLUGIN_PATH . 'optim/css/StyleRewriteStrategy.php' );
		require_once( WP_CWV_PLUGIN_PATH . 'optim/css/StyleAddDOMStrategy.php' );
		require_once( WP_CWV_PLUGIN_PATH . 'optim/js/ScriptDeferStrategy.php' );
		require_once( WP_CWV_PLUGIN_PATH . 'optim/img/ImgStrategy.php' );
		require_once( WP_CWV_PLUGIN_PATH . 'optim/html/HtmlStrategy.php' );
		require_once( WP_CWV_PLUGIN_PATH . 'optim/main.php' );

		if(cwvh::isOptimized()){
			$cwv = new CWV();
		}

	}
}

require_once( WP_CWV_PLUGIN_PATH . 'optim/common/h.php' );
require_once( WP_CWV_PLUGIN_PATH . 'admin/install.php' );
require_once( WP_CWV_PLUGIN_PATH . 'admin/settings.php' );
require_once( WP_CWV_PLUGIN_PATH . 'admin/admin-ajax-function.php' );
require_once( WP_CWV_PLUGIN_PATH . 'optim/common/DbQueries.php' );



/* from cron */
add_action('cwv_generate_critical', 'WPCWV\fn_cwv_generate_critical',10,0);

/* admin stuff */
add_action('wp_ajax_critical_clear_critical', 'WPCWV\fn_critical_clear_critical');
add_action('wp_ajax_critical_clear_cache', 'WPCWV\fn_critical_clear_cache');
add_action('wp_ajax_critical_save_options', 'WPCWV\fn_critical_save_options');

add_action('wp_ajax_wp_cwv_get_critical_css_rules', 'WPCWV\wp_cwv_get_critical_css_rules' );
add_action('wp_ajax_delete_critical_css_rule', 'WPCWV\delete_critical_css_rule' );

add_action('wp_ajax_wp_cwv_get_script_rules', 'WPCWV\wp_cwv_get_script_rules' );
add_action('wp_ajax_wp_cwv_delete_script_rule', 'WPCWV\wp_cwv_delete_script_rule' );

add_action('wp_ajax_wp_cwv_get_plugin_status', 'WPCWV\wp_cwv_get_plugin_status' );

add_action('admin_bar_menu', 'WPCWV\cwv_toolbar', 100);
add_action('admin_menu', 'WPCWV\wp_cwv_create_menu');
add_action('admin_enqueue_scripts', 'WPCWV\wp_cwv_admin_scripts_styles' );

if(is_writable(WP_CONTENT_DIR.'/cache/') === false){
	add_action( 'admin_notices', function(){echo '<div class="notice notice-warning  is-dismissible"><p><strong>WP Core Web Vitals Warning</strong></p><p>You cache folder is not writable. Please consult the WordPress <a href="https://wordpress.org/support/article/changing-file-permissions/">documentation</a></div>';});
}

// clear cache when post is saved
add_action('save_post','WPCWV\save_post_callback');
function save_post_callback($post_id){
	$aCacheInfo = cwvh::getCachePathInfo(get_permalink($post_id));
	@unlink($aCacheInfo['abspath'].$aCacheInfo['filename']);
}


