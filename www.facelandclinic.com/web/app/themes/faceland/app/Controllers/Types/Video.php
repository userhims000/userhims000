<?php

// Set the namespace
namespace Rokit\Controllers\Types;

class Video extends Post {

    protected static $postType = 'video';

    var $_image;

    var $_video_url;

    public function image(){
        if( ! $this->_image ) {
            $this->_image = $this->get_field( static::$postType.'_image');
        }

        return $this->_image;
    }

    public function video_url(){
        if( ! $this->_video_url ) {

            $id = $this->get_field( static::$postType.'_id');
            $url = $this->get_field( static::$postType.'_type') == 'youtube' ? 'https://www.youtube.com/embed/'.$id : 'https://player.vimeo.com/video/'.$id ;
            $this->_video_url = $url;
        }

        return $this->_video_url;
    }

    public function search_link() {

        if(!$this->_search_link) {
            $this->_search_link =  get_post_type_archive_link(static::$postType);
        }

        return $this->_search_link;
    }

}
