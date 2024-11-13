<?php


namespace WPCWV;

if( ! defined( 'ABSPATH' ) ) { die('Let\'s not do this');}

class CWV{

	private $aInterceptedCssSrc = [];

	public function __construct(){

		add_action( 'template_redirect', [ $this, 'ob_start' ]); 

		$this->oCache = new CWVCache();
		$this->oStyle = new StyleRewriteStrategy();
		$this->oScript = new ScriptDeferStrategy();
		$this->oExtraStyle = new StyleAddDOMStrategy();
		$this->oImg = new ImgStrategy();
		$this->oHtml = new HtmlStrategy();
	
	}

	public function ob_start(){
		header('X-Accel-Buffering: no');
		ob_start([$this,"ob_lazy_load_callback"]); 
	}


	public function ob_lazy_load_callback($html_critical_buffer) {

		// bypass page?
		if(cwvh::ignored()){
			return $html_critical_buffer;
		}


		if(!current_user_can('administrator')){

			## DOM Objecgt
			$dom = str_get_html($html_critical_buffer);

			## Rewrite
			$dom = $this->oImg->rewriteOutput($dom);
			$dom = $this->oScript->rewriteOutput($dom);
			$dom = $this->oStyle->rewriteOutput($dom);
			$dom = $this->oExtraStyle->rewriteOutput($dom);
			$dom = $this->oHtml->rewriteOutput($dom);

			## Save
			$html_critical_buffer = $dom->save();

			if(critical_get_option('wp_cwv_page_cache') == 1){
				// write the cache file
				$cwv_buffer = $this->oCache->cache($html_critical_buffer);
			}
		


			## Fix
			if(is_super_admin()){
				header('X-Accel-Buffering: no');
			}
		}

		## Return html
		return $html_critical_buffer;
	}
}