<?php

/**
 * Plugin Name: Rokit Languages
 * Description: The Rokit languages plugin. A plugin to manage translations in WordPress projects. Work with polylang.
 *
 * Plugin URI: https://git.rodesk.nl/packages/language
 *
 * Author: Rodesk BV
 * Author URI: https://rodesk.com
 *
 * Version: 1.5.0
 */

// File Security Check
defined('ABSPATH') or die("No script kiddies please!");

add_filter( 'wpseo_breadcrumb_indexables', function($indexables) {
    foreach ( $indexables as &$indexable ) {
        if($indexable->object_type == 'post-type-archive' && empty($indexable->breadcrumb_title) && !empty($indexable->object_sub_type)) {
            $post_type_object = get_post_type_object( $indexable->object_sub_type );
            if(!empty($post_type_object) && isset($post_type_object->labels) && isset($post_type_object->labels->name)) {
                $indexable->breadcrumb_title = $post_type_object->labels->name;
            }
        }
    }
    return $indexables;
}, 15 );

// Init the languages class
new Rokit\Languages\Languages();
