<?php

// Set the namespace
namespace Rokit\Controllers\Types;

class PostDetail extends Post {

    protected static $postType = 'post';

    var $_title;

    var $_subtitle;

    var $_image;

    var $_panorama;

    public function title() {

        if( ! $this->_title ) {
            $this->_title = $this->get_field( $this->post_type .'_panorama_titles_title' );
        }

        return $this->_title;
    }

    public function subtitle() {

        if( ! $this->_subtitle ) {
            $this->_subtitle = $this->get_field( $this->post_type .'_panorama_titles_subtitle' );
        }

        return $this->_subtitle;
    }

    public function image() {

        if( ! $this->_image ) {
            $this->_image = $this->get_field( $this->post_type .'_panorama_image' );
        }

        return $this->_image;
    }

    public function panorama() {

        if( ! $this->_panorama ) {
            $panorama = [
                'title' => $this->title(),
                'subtitle' => $this->subtitle(),
            ];

            if(!empty($show_image = $this->get_field( $this->post_type .'_panorama_show_image' ))) {
                $panorama['show'] = $show_image;
                $panorama['image'] = $this->image();
            }

            if(is_singular('location')){
                $panorama['clinic_location_address'] = $this->get_field( 'location_street', get_the_ID() ) .', '. $this->get_field( 'location_zipcode', get_the_ID() ) .', '. $this->get_field( 'location_city', get_the_ID() ) ;
            }


            $this->_panorama = $panorama;

        }

        return $this->_panorama;
    }

}
