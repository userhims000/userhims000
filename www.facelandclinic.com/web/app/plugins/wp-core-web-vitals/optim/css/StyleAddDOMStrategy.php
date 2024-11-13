<?php 

namespace WPCWV;

class StyleAddDOMStrategy implements StrategyInterface{


	public function rewriteOutput($dom){

		$cwv_extra_css = critical_get_option( 'cwv_extra_css' );
		$cwv_text_rendering = critical_get_option( 'cwv_text_rendering' );

		if($cwv_text_rendering){
			$cwv_extra_css .= 'body {text-rendering: optimizeSpeed;}';
		}
		
		if(!empty($cwv_extra_css)){
			$inject = '<style>'.$cwv_extra_css.'</style>';
			$dom->find('title', 0)->outertext = $dom->find('title', 0)->outertext.$inject;
		};	

		return $dom;
	}
}