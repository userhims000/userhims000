<?php
namespace WPCWV;

if( ! defined( 'ABSPATH' ) ) { die('Let\'s not do this');}


class CssUtilities{


	private static function rewritePaths($css,$url){

		$bgimgs = array();
		preg_match_all ('/url\s*\(\s*[\'\"]*([^;\'\"]*)[\'\"]*\)/Uui', $css, $bgimgs);

		if(isset($bgimgs[1]) && is_array($bgimgs[1])) {
			foreach(array_unique($bgimgs[1]) as $k=>$img) {
				# normalize
				$newimg = self::cwv_normalize_href($img,$url);
				if($newimg != $img) { $css = str_replace($bgimgs[0][$k], 'url(\''.$newimg.'\')', $css); $img = $newimg; }
			}
		}

		# remove empty url()
		$css = preg_replace('/url\s*\(\s*[\'"]?\s*[\'"]?\)/Uui', 'none', $css);

		# fixes
		$css = str_replace('/./', '/', $css);

		return $css;
	}





	// return full url
function cwv_normalize_href($href, $cur_url=null) {

	# preserve empty source handles
	$href = trim($href); 
	if(empty($href)) { return false; }      

	# external url
	$parse = parse_url($cur_url);
	

	# domain inf
	$scheme = ($parse['scheme'])?$parse['scheme']:'https';
	$host = $parse['host'];
	$path = $parse['path'];

	if (substr($href, 0, 7) === "http://") {
		## http url, do noting
	} else if (substr($href, 0, 8) === "https://") {
		#https url, do noting
	} else if (substr($href, 0, 8) === "data:") {
		# data uri, do noting
	} else 	if (substr($href, 0, 2) === "//") {
		$href = $scheme.':'.$href; # scheme missing
	} else if (substr($href, 0, 1) === "/") { 
		$href = $scheme.'://'.$host . $href; # scheme and domain missing
	}  else {
		$href = $scheme.'://'.$host.'/' . self::get_absolute_path(dirname($path) . '/' . $href); # url is completely relative
	}

	# prevent double forward slashes in the middle
	$href = str_replace('###', '://', str_replace('//', '/', str_replace('://', '###', $href)));

	return $href;	
}



	private static function get_absolute_path($path) {
	    $path = str_replace(array('/', '\\'), DIRECTORY_SEPARATOR, $path);
	    $parts = array_filter(explode(DIRECTORY_SEPARATOR, $path), 'strlen');
	    $absolutes = array();
	    foreach ($parts as $part) {
	        if ('.' == $part) continue;
	        if ('..' == $part) {
	            array_pop($absolutes);
	        } else {
	            $absolutes[] = $part;
	        }
	    }
	    return implode(DIRECTORY_SEPARATOR, $absolutes);
	}
}