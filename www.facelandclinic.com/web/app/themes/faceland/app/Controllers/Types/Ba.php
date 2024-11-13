<?php

// Set the namespace
namespace Rokit\Controllers\Types;

class Ba extends Post {

    protected static $postType = 'ba';

    var $_treatment;

    var $_ba;

    var $_show;

    var $_single_image;

    public function treatment(){
        if( ! $this->_treatment ) {
            $this->_treatment = $this->get_field( static::$postType . '_treatment');
        }

        return $this->_treatment;
    }

    public function ba(){
        if( ! $this->_ba ) {
            $this->_ba = $this->get_field( static::$postType . '_ba');
        }

        return $this->_ba;
    }

    public function show(){
        if( ! $this->_show ) {
            $this->_show = $this->get_field( static::$postType . '_show');
        }

        return $this->_show;
    }

    public function single_image(){
        if( ! $this->_single_image ) {
            $this->_single_image = [
                'image' => $this->get_field( static::$postType . '_image'),
                'caption' => $this->get_field( static::$postType . '_caption')];
        }

        return $this->_single_image;
    }

    public function search_link() {

        if(!$this->_search_link) {
            $this->_search_link = false;
        }

        return $this->_search_link;
    }

}
