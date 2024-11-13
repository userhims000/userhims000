<?php

// Set the namespace
namespace Rokit\Controllers\Pages;

// Include Timber objects
use Timber;
use TimberPost;

class page404 extends Page {

    protected static $postType = 'page';

    var $_title;

    var $_image;

    var $_subtitle;

    var $_text;
    
    var $_show_search_button;
    
    var $_search_button_placehoder;

    public function title() {

        if( !$this->_title ) {
            $this->_title = get_field('options_404_title','option');
        }

        return $this->_title;

    }

    public function image() {

        if( !$this->_image ) {
            $this->_image = get_field('options_404_image','option');
        }

        return $this->_image;

    }

    public function subtitle() {

        if( !$this->_subtitle ) {
            $this->_subtitle = get_field('options_404_subtitle','option');
        }

        return $this->_subtitle;

    }

    public function text() {

        if( !$this->_text ) {
            $this->_text = get_field('options_404_text','option');;
        }

        return $this->_text;

    }

    public function show_search_btn() {

        if( !$this->_show_search_button ) {
            $this->_show_search_button = get_field('options_404_search_show','option');;
        }

        return $this->_show_search_button;
    }

    public function search_btn_placeholder() {

        if( !$this->_search_button_placehoder ) {
            $this->_search_button_placehoder = get_field('options_404_search_placeholder','option');;
        }

        return $this->_search_button_placehoder;
    }



}
