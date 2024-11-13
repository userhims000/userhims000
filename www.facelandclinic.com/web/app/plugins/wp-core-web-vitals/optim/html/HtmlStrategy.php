<?php 

namespace WPCWV;


class HtmlStrategy implements StrategyInterface{


	public function rewriteOutput($dom){

		$cwv_page_remove_dns_prefetch = critical_get_option('cwv_page_remove_dns_prefetch');
		$cwv_page_remove_preconnect = critical_get_option('cwv_page_remove_preconnect');
		$cvw_custom_preload = critical_get_option('cvw_custom_preload');

		if($cwv_page_remove_preconnect){
			foreach ($dom->find('link[rel=preconnect]') as $link) {
				$link->outertext = '';
			}
		}

		if($cwv_page_remove_dns_prefetch){
			foreach ($dom->find('link[rel=dns-prefetch]') as $link) {
				$link->outertext = '';
			}
		}
		
		if(!empty($cvw_custom_preload)){
			foreach(explode("\n", $cvw_custom_preload) as $href){
				$inject .= '<link rel="preload" href="'.trim($href).'" as="font" type="font/woff2" crossorigin>';
			}

			$dom->find('title', 0)->outertext = $dom->find('title', 0)->outertext.$inject;
		};

		return $dom;
	}

}