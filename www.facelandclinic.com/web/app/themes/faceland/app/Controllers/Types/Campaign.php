<?php

// Set the namespace
namespace Rokit\Controllers\Types;

class Campaign extends PostDetail {

    protected static $postType = 'campaign';

    var $_panorama_type;

    var $_video;

    var $_color;

    var $_color_background;

    var $_color_button;

    var $_color_title;

    var $_color_text;

    var $_thumbnail;

    var $_share_title;

    public function panorama() {

        if( ! $this->_panorama ) {
            $panorama = [
                'title'     => $this->get_field( $this->post_type .'_panorama_titles_title' ),
                'subtitle'  => $this->get_field( $this->post_type .'_panorama_titles_subtitle' ),
                'type'      => $this->panorama_type(),
                'image'     => $this->image(),
                'video'     => $this->video()
            ];

            $this->_panorama = $panorama;

        }

        return $this->_panorama;
    }

    public function panorama_type() {

        if( ! $this->_panorama_type ) {
            $this->_panorama_type =  $this->get_field( $this->post_type .'_panorama_type' );
        }

        return $this->_panorama_type;
    }

    public function video() {

        if( ! $this->_video ) {
            $this->_video =[
                'url' => $this->get_field( $this->post_type .'_panorama_video_url' ),
                'thumbnail' => $this->get_field( $this->post_type .'_panorama_video_thumbnail' )
            ];
        }

        return $this->_video;
    }

    public function color(){
        if( ! $this->_color ) {
            $this->_color = [
                'background'    => $this->color_background(),
                'button'        => $this->color_button(),
                'title'         => $this->color_title(),
                'text'          => $this->color_text()
            ];
        }
        return $this->_color;
    }

    public function color_background(){
        if( ! $this->_color_background ) {
            $this->_color_background =  $this->get_field( static::$postType . '_color_background');
        }

        return $this->_color_background;
    }

    public function color_button(){
        if( ! $this->_color_button ) {
            $this->_color_button =  $this->get_field( static::$postType . '_color_button');
        }

        return $this->_color_button;
    }

    public function color_title(){
        if( ! $this->_color_title ) {
            $this->_color_title =  $this->get_field( static::$postType . '_color_title');
        }

        return $this->_color_title;
    }

    public function color_text(){
        if( ! $this->_color_text ) {
            $this->_color_text =  $this->get_field( static::$postType . '_color_text');
        }

        return $this->_color_text;
    }

    public function thumbnail(){
        if( ! $this->_thumbnail ) {
            $this->_thumbnail =  $this->get_field( static::$postType . '_thumbnail');
        }

        return $this->_thumbnail;
    }

    public function share_title() {
        if( ! $this->_share_title ) {
            $this->_share_title = pll__('Deel op social media:');
        }

        return $this->_share_title;
    }
}
