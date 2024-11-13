<?php 

namespace WPCWV;


class ScriptDeferStrategy implements StrategyInterface{

	private $inject = '';

	public function rewriteOutput($dom){

		$this->aScriptRules = scriptrules::findAll();


		$cwv_defer_scripts_lower_regex = critical_get_option('cwv_defer_scripts_lower_regex');
		$cwv_footer_scripts = critical_get_option('cwv_footer_scripts');
		$cwv_defer_scripts = critical_get_option('cwv_defer_scripts');

		if($cwv_defer_scripts || $cwv_footer_scripts){

			foreach ($dom->find('script') as $script) {
				if($script->type == 'text/javascript' || $script->type == ''){

					// defer it any way
					if($cwv_defer_scripts){
						if($script->src){
							$match = $script->src;
						} else {
							$match = $script->innertext;
							$script->src = 'data:text/javascript;base64,'.base64_encode($script->innertext);
							$script->innertext='';

						}

						$rule = $this->hasScriptRule($match);

						if($cwv_defer_scripts_lower_regex && (cwvh::isAllowedByRegex($cwv_defer_scripts_lower_regex,$match))){
							// script is allowed
						} else if($rule){
							$script = $this->handleScriptRule($script,$rule);
							

						} else {
							$script->defer = 'defer';
						}
					}


					if($cwv_footer_scripts){
						// copy tag and remove;
						$inject .= $script->outertext;
						$script->outertext = '';
					}
				}
			}
		}
		if($cwv_footer_scripts){
			$dom->find('body', 0)->innertext = $dom->find('body', 0)->innertext.$inject;
		}
		$dom = str_get_html($dom->save());

		$dom = $this->injectScriptRules($dom);

		$dom = str_get_html($dom->save());

		return $dom;
	}

	private function hasScriptRule($match){
		foreach($this->aScriptRules as $r){
			if(stristr($match, $r->scriptregex)){
				return $r;
			}
		}
			return false;
	}

	private function handleScriptRule($script,$rule){
		if($rule->scripttrigger == 'hover'){
			$this->inject .= 'document.querySelector("'.$rule->scriptselector.'").addEventListener("mouseover",function(){cwv_loadscript("'.$script->src.'")},{ once: true });';
		}
		
		if($rule->scripttrigger == 'interactionobserver'){
			$rnd = md5(microtime());
				$this->inject .= '
					const cwv_els'.$rnd.' = document.querySelectorAll("'.$rule->scriptselector.'");

					observer = new IntersectionObserver(entries => {
					  entries.forEach(entry => {
					    if (entry.intersectionRatio > 0) {
					    	cwv_loadscript("'.$script->src.'");
					      observer.unobserve(entry.target);
					    } 
					  });
					});

					cwv_els'.$rnd.'.forEach(image => {
  						observer.observe(image);
					});
			';
		}
		
		if($rule->scripttrigger == 'idle'){
			// update this to requestIdleCallback
			$this->inject .= 'document.addEventListener("load",function(){setTimeout(function(){cwv_loadscript("'.$script->src.'")},3000); });';
		}


		if($rule->scripttrigger == 'remove'){
			// do nothing
		}

		$script->outertext = '';
		return $script;
	}

	private function injectScriptRules($dom){

		$loadscript = '
			var cwv_loadscript = function(src){
   				var _cwv_script = document.createElement("script");
				_cwv_script.src = src
			    _cwv_script.async = true;
			    document.body.append(_cwv_script);
			};
   		';

		$inject = '<script>'.$loadscript .$this->inject.'</script>';
		$dom->find('body', 0)->innertext = $dom->find('body', 0)->innertext.$inject;

		return $dom;
	}

}