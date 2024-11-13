<?php
namespace WPCWV;

if( ! defined( 'ABSPATH' ) ) { die('Let\'s not do this');}


class CWVCache{
	public function cache($html_critical_buffer){
		$aCacheInfo = cwvh::getCachePathInfo($_SERVER['REQUEST_URI']);
		@mkdir ( WP_CONTENT_DIR.'/cache/wp_cwv/html/', 0777 , true );
		file_put_contents(WP_CONTENT_DIR.'/cache/wp_cwv/html/'.$aCacheInfo['filename'], $html_critical_buffer);
		$html_critical_buffer.="<!-- created cache -->";
		return $html_critical_buffer;

	}
}