<?php

// Set the namespace
namespace Rokit\Controllers\Types;

class Brand extends PostDetail {

    protected static $postType = 'brand';

    var $_logo;

    var $_thumbnail;

    public function logo(){
        if( ! $this->_logo ) {
            $this->_logo = $this->get_field( static::$postType . '_logo');
        }

        return $this->_logo;
    }

    public function thumbnail(){
        if( ! $this->_thumbnail ) {
            $this->_thumbnail = $this->get_field( static::$postType . '_panorama_thumbnail');
        }

        return $this->_thumbnail;
    }

}
