<?php

// Set the namespace
namespace Rokit\Controllers\Pages;

// Include Timber objects
use Rokit\Controllers\Collections\ProductCollection;

class page5536 extends Page {

    protected static $postType = 'page';

    var $_items;

    var $_cta;

    public function panorama() {

        if( ! $this->_panorama ) {
            $panorama = [
                'title'     => $this->get_field( static::$postType . '_panorama_titles_title'),
                'subtitle'  => $this->get_field( static::$postType . '_panorama_titles_subtitle'),
                'image'     => $this->get_field( static::$postType . '_panorama_image'),
                'type'      => 'image'
            ];


            $this->_panorama = $panorama;
        }

        return $this->_panorama;
    }

    public function items() {

        if( !$this->_items ) {

            if ( !empty($items = $this->get_field( static::$postType . '_items'))){
               foreach ($items as &$item) {
                   if (is_array($item['products'])){
                       $item['products'] = ProductCollection::posts_by_id($item['products']);
                   }
               }
            }

            if (!empty($items)){
                $this->_items = $items;
            }
        }

        return $this->_items;

    }

    public function cta() {

        if( !$this->_cta ) {
            $this->_cta = $this->get_field( static::$postType . '_cta');
        }

        return $this->_cta;

    }

    public function seo_image(){

        if (!$this->_seo_image) {
            if (!empty($image_id = $this->get_field(static::$postType . '_social_image'))) {
                $image = rokit_get_attachment($image_id, 'social');
                if (!empty($image)) {
                    $this->_seo_image = $image;
                }
            }
        }
        
        return $this->_seo_image;
    }

}
