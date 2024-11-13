<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\OfferCollection;

class Offer extends Post {

    protected static $postType = 'offer';

    var $_panorama;

    var $_thumbnail;

    var $_label;

    var $_share_title;

    var $_related;

    public function panorama(){
        if( ! $this->_panorama ) {

            $panorama = parent::panorama();
            $panorama['label'] = $this->label();

            $this->_panorama = $panorama;
        }

        return $this->_panorama;
    }

    public function thumbnail(){
        if( ! $this->_thumbnail ) {
            $this->_thumbnail = $this->get_field(static::$postType . '_panorama_thumbnail');
        }
        return $this->_thumbnail;
    }

    public function label(){
        if( ! $this->_label ) {
            $this->_label = $this->get_field(static::$postType . '_label');
        }
        return $this->_label;
    }

    public function share_title() {
        if( ! $this->_share_title ) {
            $this->_share_title = pll__('Deel op social media:');
        }

        return $this->_share_title;
    }

    public function related(){
        if( ! $this->_related ) {
            $args = [
                'posts_per_page' => 3,
                'post__not_in' => [$this->ID]
            ];
            $this->_related = OfferCollection::query($args);
        }
        return $this->_related;
    }

}
