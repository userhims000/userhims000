<?php 

namespace WPCWV;

if( ! defined( 'ABSPATH' ) ) { die('Let\'s not do this');}


class cwvh{
	public static function isAllowedByRegex($regex,$what=false){
		if($what == false){
			$what = $_SERVER['REQUEST_URI'];
		}
		$regex = trim(stripslashes($regex));
		if($regex){
			if (@preg_match('/'.$regex.'/i', "") === false) {
				return false;
			} else 
			return (@preg_match('/'.$regex.'/i', $what) > 0)?true:false;
		}
		return false;
	}


	public static function getCachePathInfo($mUrl){

		$sRelPath = trim(str_replace(home_url(), '', $mUrl),'/'); 
		$sHash = md5($sRelPath).'.html';
		$sCacheFile = WP_CONTENT_DIR.'/cache/cwv/html/'.$filename;
		
		return ['filename'=>$sHash,'abspath'=>$sCacheFile];

	} 


	public static function isOptimized(){
		return (get_option('wp_cwv_licence_state') == 'valid');
	}



	

	static function fetch($url){
		{
    		//user agent is very necessary, otherwise some websites like google.com wont give zipped content
			$opts = array(
				'http'=>array(
					'method'=>"GET",
					'header'=>"Accept-Language: en-US,en;q=0.8rn" .
					"Accept-Encoding: gzip,deflate,sdchrn" .
					"Accept-Charset:UTF-8,*;q=0.5rn" .
					"User-Agent: Mozilla/5.0 (X11; Linux x86_64; rv:19.0) Gecko/20100101 Firefox/19.0 FirePHP/0.4rn"
				)
			);

			$context = stream_context_create($opts);
			$content = wp_remote_get($url ,false,$context); 

    		//If http response header mentions that content is gzipped, then uncompress it
			foreach($http_response_header as $c => $h)
			{
				if(stristr($h, 'content-encoding') and stristr($h, 'gzip'))
				{
            //Now lets uncompress the compressed data
					$content = gzinflate( substr($content,10,-8) );
				}
			}

			return $content;
		}

	}


static function isPluginActive( $plugin ) {
		return in_array( $plugin, (array) get_option( 'active_plugins', array() ) ) || self::isPluginActiveForNetwork( $plugin );
	}




	static function isPluginActiveForNetwork( $plugin ) {
		if ( !is_multisite() )
			return false;

		$plugins = get_site_option( 'active_sitewide_plugins');
		if ( isset($plugins[$plugin]) )
			return true;

		return false;
	}


	static function ignored(){

		if (is_user_logged_in() && !current_user_can('administrator')){
			return true;
		}


		if(defined('DONOTCACHEPAGE')){
			return true;
		}


		

		if(isset($_COOKIE['woocommerce_cart_hash'])){
			return true;
		}

		$list = array(
			"\/wp\-comments\-post\.php",
			"\/wp\-login\.php",
			"\/robots\.txt",
			"\/wp\-cron\.php",
			"\/wp\-content",
			"\/wp\-admin",
			"\/wp\-includes",
			"\/index\.php",
			"\/xmlrpc\.php",
			"\/wp\-api\/",
			"leaflet\-geojson\.php",
			"\/clientarea\.php"
		);
		if(self::isPluginActive('woocommerce/woocommerce.php')){
			global $post;

			if(isset($post->ID) && $post->ID){
				if(function_exists("wc_get_page_id")){
					$woocommerce_ids = array();

							//wc_get_page_id('product')
							//wc_get_page_id('product-category')

					array_push($woocommerce_ids, wc_get_page_id('cart'), wc_get_page_id('checkout'), wc_get_page_id('receipt'), wc_get_page_id('confirmation'), wc_get_page_id('myaccount'));

					if (in_array($post->ID, $woocommerce_ids)) {
						return true;
					}
				}
			}



			array_push($list, "\/cart\/?$", "\/checkout", "\/receipt", "\/confirmation", "\/wc-api\/");
		}

		if(self::isPluginActive('wp-easycart/wpeasycart.php')){
			array_push($list, "\/cart");
		}

		if(self::isPluginActive('easy-digital-downloads/easy-digital-downloads.php')){
			array_push($list, "\/cart", "\/checkout");
		}

		if(preg_match("/".implode("|", $list)."/i", $_SERVER["REQUEST_URI"])){
			return true;
		}

		return false;
	}



}