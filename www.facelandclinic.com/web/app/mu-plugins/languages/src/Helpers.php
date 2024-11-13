<?php

/**
 * Return the post (or page) translation
 *
 * @author  Jasper Rooduijn
 * @since   1.0
 *
 * @param  [int]  	$id  	The post ID
 * @return [type]      		The id of the translated post or page as integer.
 */
if( !function_exists( 'rokit_get_lang_id' ) ) {

	function rokit_get_lang_id( $id, $type = 'post', $lang = '' ) {

	    if( empty( $id ) ) {
	        return;
	    }

	    if( $type == 'term' ) {

	        if ( function_exists( 'pll_get_term' ) ) {
	            if( pll_get_term( $id ) ) {
	                $id = pll_get_term( $id, $lang );
	                return $id;
	            }
	        }

	    } else {

	        if ( function_exists( 'pll_get_post' ) ) {
	            if( pll_get_post( $id ) ) {
	                $id = pll_get_post( $id, $lang );
	                return $id;
	            }
	        }

	    }

	    return $id;
	}

}
