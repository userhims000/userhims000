<?php 

namespace WPCWV;


class ImgStrategy implements StrategyInterface{




	private function getPlaceholder($width = 0, $height = 0)
	{
		$width  = 0 === $width ? 0 : absint($width);
		$height = 0 === $height ? 0 : absint($height);

		$placeholder = str_replace(' ', '%20', "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 $width $height'%3E%3C/svg%3E");
		return $placeholder;
	}

	public function rewriteOutput($dom){


		// fix images
		$cwv_lazy_load_bg_images = critical_get_option( 'cwv_lazy_load_bg_images' );
		$cwv_lazy_load_images = critical_get_option( 'cwv_lazy_load_images' );
		$cwv_lazy_load_images_js = critical_get_option( 'cwv_lazy_load_images_js' );
		$cwv_async_render_images = critical_get_option( 'cwv_async_render_images' );
		$cwv_img_width_height = critical_get_option( 'cwv_img_width_height' );


		//lazy background
		if(isset($cwv_lazy_load_bg_images) && $cwv_lazy_load_bg_images == 1){
			$bInjectLazyCSSFix = false;
			if($dom){
				foreach( $dom->find('*[style]') as $node) {
					if(stristr($node->getAttribute('style'), 'url(')){
						$node->setAttribute('class', $node->getAttribute('class').' lazybg');
						$bInjectLazyCSSFix = true;
					}
				}
				if($bInjectLazyCSSFix){

					$inject = '<style>.lazybg{background-image:none!important;}</style>';
					$dom->find('title', 0)->outertext = $dom->find('title', 0)->outertext.$inject;

					$inject = '<script>let _cwv_bg_observer = new IntersectionObserver((entries, _cwv_bg_observer) => {entries.forEach(entry => {if(entry.isIntersecting){entry.target.classList.remove("lazybg");_cwv_bg_observer.unobserve(entry.target);}});});document.querySelectorAll(".lazybg").forEach(el => { _cwv_bg_observer.observe(el) });</script>';
					$dom->find('body', 0)->innertext = $dom->find('body', 0)->innertext.$inject;
		
				}
				$dom = str_get_html($dom->save());
			}

		}

		// loop and async / async decoding
		if($cwv_lazy_load_images || $cwv_async_render_images || $cwv_img_width_height || $cwv_lazy_load_images_js){
			if(!empty($dom)){
				foreach ($dom->find('img') as $img) {

					// lazy loading and async decoding
					if($cwv_lazy_load_images){
						$img->setAttribute('loading', 'lazy');
					}
					
					if($cwv_async_render_images){
						$img->setAttribute('decoding', 'async');
					} else {

						$img->setAttribute('asd', 'asd');
					}

					// add width and height
					if($cwv_img_width_height){
						if(! $img->getAttribute('width') || !$img->getAttribute('height')  ){
							try{
								$imginfo = wp_getimagesize($img->getAttribute('src'));

								// can we get img info?
								if($imginfo){

									// fix width and height
									if($cwv_img_width_height){
										$img->setAttribute('width', $imginfo[0]);
										$img->setAttribute('height', $imginfo[1]);
									}
								}
							}  catch (Exception $e) {

							}
						}
					}

					if($cwv_lazy_load_images_js){
						$img->setAttribute('data-src', $img->getAttribute('src'));
						$img->setAttribute('data-srcset', $img->getAttribute('srcset'));
						$img->removeAttribute('srcset');
						$img->setAttribute('src', $this->getPlaceholder($img->getAttribute('width'),$img->getAttribute('height')));
					}



				}
			}

			if($cwv_lazy_load_images_js){
				$inject = '<script>let _cwv_img_observer = new IntersectionObserver((entries, _cwv_img_observer) => {entries.forEach(entry => {if(entry.isIntersecting){entry.target.src = entry.target.dataset.src;if(entry.target.dataset.srcset){entry.target.srcset = entry.target.dataset.srcset;}_cwv_img_observer.unobserve(entry.target);}});});document.querySelectorAll("img").forEach(el => { _cwv_img_observer.observe(el) });</script>';
				$dom->find('body', 0)->innertext = $dom->find('body', 0)->innertext.$inject;
			}
			$dom = str_get_html($dom->save());
		}	






		return $dom;
		
	}
}
