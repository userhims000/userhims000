<?php 

namespace WPCWV;


class StyleRewriteStrategy implements StrategyInterface{

	public function rewriteOutput($dom){

		// got a visit from critical css generator
		if($_SERVER['HTTP_USER_AGENT'] == 'critcalcssgen'){
			return $dom;
		}


		## Should we combine CSS?
		if(critical_get_option('cwv_combine_css') && is_writable(WP_CONTENT_DIR.'/cache/')){
			$sCss = '';
			$sInlineCss = '';
			$aCssFiles = [];

			##  External files
			foreach ($dom->find('link') as $style) {
				if($style->rel == 'stylesheet' && $style->media != 'print'){
					$aCssFiles[] = $style->href;
					$style->outertext = '';
				}
			}


			## Inline CSS
			foreach ($dom->find('style') as $style) {
				$sInlineCss .= $style->innertext."\n";
				$style->innertext = '';
			}

			$sCombinesCssHash = md5(implode('-', $aCssFiles).$sInlineCss);

			if(file_exists(WP_CONTENT_DIR.'/cache/wp_cwv/css/'.$sCombinesCssHash.'.css')){

			} else {
				foreach ($aCssFiles as $url) {
					$sCss .= "/* --------------- ". $url." --------------- */ \n";
					$sCss .= $this->fetchStyleSheet($url);
				}

				@mkdir ( WP_CONTENT_DIR.'/cache/wp_cwv/css/', 0777 , true );
				file_put_contents(WP_CONTENT_DIR.'/cache/wp_cwv/css/'.$sCombinesCssHash.'.css', $sCss);
			}

			$inject = '<link rel="stylesheet" href="/wp-content/cache/wp_cwv/css/'.$sCombinesCssHash.'.css">';
			$dom->find('title', 0)->outertext = $dom->find('title', 0)->outertext.$inject;
			
			## kinda a dumb idea?
			$dom = str_get_html($dom->save());

		}




		//dont waste resources on Critical CSS
		if(is_404() || is_attachment() || (critical_get_option('wp_cwv_page_cache_urlparam') == 0 && stristr($_SERVER['REQUEST_URI'], '?'))){
			return $dom;
		}		

			// generate critical
		if(critical_get_option('wp_cwv_css')){

			$oCriticalRules = criticalrules::findAll();

			$pagetype= false;

			foreach($oCriticalRules as $oCriticalRule){
				if(cwvh::isAllowedByRegex($oCriticalRule->rule)){
					$pagetype = $oCriticalRule->rule;
				}
			}


			if($pagetype){

			} else if(is_tax() ){
				$pagetype = 'tax';
			} else if(is_author()  ){
				$pagetype = 'author';
			} else if(is_category(  )  ){
				$pagetype = 'category';
			} else if(is_tag() ){
				$pagetype = 'tag';
			} else if(is_search() ){
				$pagetype = 'search';
			} else if(is_front_page()){
				$pagetype = 'home';
			} else if(is_feed() ){
				$pagetype = false;
			} else if(is_attachment() ){
				$pagetype = false;
			} else if(is_home() ){
				$pagetype = 'blog';
			} else {
				$pagetype = 'page';
			}

			// is this page worth critical css?
			if($pagetype){

				$posttype = (string)get_post_type();
				$templateslug = (string)get_page_template_slug();
				$criticalhashname = $pagetype.'-'.$posttype.'-'.$templateslug;
				$criticalhash = md5($criticalhashname);

				if(critical_get_option('wp_cwv_critical_all_pages') && criticalfiles::getCount() < 90){
					$criticalhash = md5($criticalhashname.$_SERVER['REQUEST_URI']);
				}


				## critical is allready generated, insert and return
				if(file_exists(WP_CONTENT_DIR.'/cache/wp_cwv/critical/'.$criticalhash.'.css')){

					foreach ($dom->find('link') as $style) {
						if($style->rel == 'stylesheet' && $style->media != 'print'){
							$style->rel = 'preload';
							$style->as = 'style';
							$style->onload = 'this.onload=null;this.rel=\'stylesheet\'';
						}
					}


					$inject = '<style data-critical="true" data-file="'.$criticalhashname.'">'.file_get_contents(WP_CONTENT_DIR.'/cache/wp_cwv/critical/'.$criticalhash.'.css').'</style>';
					$dom->find('title', 0)->outertext = $dom->find('title', 0)->outertext.$inject;

				## need to generate critical css
				} else {

				// create critical CSS in bg
					global $wp;  
					$url = home_url(add_query_arg(array($_GET), $wp->request));



					## insert into critical giles table
					$data = [
						'url' =>  $url, 
						'hash' =>  $criticalhash,
						'pagetype'=> $pagetype,
						'templateslug'=> $templateslug,
						'posttype'=> $posttype,
						'status'=> 'open'
					];

					$test = criticalfiles::findOne($data,'hash');
					if (!is_object($test)) {
						criticalfiles::insert($data);
					}


					if(!wp_next_scheduled('cwv_generate_critical')){
						wp_schedule_single_event( time() + 10, 'cwv_generate_critical' );
					}

				}
			}


		}




		return $dom;
	}


	private function fetchStyleSheet($url){

		$url = CssUtilities::cwv_normalize_href($url,WP_CWV_SITE_URL.$_SERVER['REQUEST_URI']);


		$response = wp_remote_get($url, array('timeout' => 15, 'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_10_2) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/49.0.2623.110 Safari/537.36'));
		if(is_wp_error( $response ) ){
			return "\n".$url . "\n\n".$response->get_error_message();
		}

		if ( !$response || is_wp_error( $response ) ) {
			return false;
		}else{
			if(wp_remote_retrieve_response_code($response) == 200){
				$data = wp_remote_retrieve_body( $response );

				if(preg_match("/\<\!DOCTYPE/i", $data) || preg_match("/<\/\s*html\s*>/i", $data)){
					return false;
				}else if(!$data){
					return "/* empty */";
				}else{
					return $data;
					return CssUtilities::rewritePaths($data,$url);	
				}
			}else if(wp_remote_retrieve_response_code($response) == 404){
				if(preg_match("/\.css/", $url)){
					return "/*404*/";
				}else{
					return "<!-- 404 -->";
				}
			}
		}
	}
}
