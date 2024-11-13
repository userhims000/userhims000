<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

// Include Timber objects
use Rokit\Controllers\Terms\VideoPlaylistTerm;
use Timber;
use TimberPost;

class VideoCollection extends PostCollection {

    protected static $postType = 'video';

    protected static $postClass = 'Rokit\Controllers\Types\Video';

    var $_image;

    var $_intro_button;

    var $_cta;

    public function image(){
        if( ! $this->_image ) {
            if (get_field(static::$postType . '_archive_show_image', 'option')){
                $this->_image = get_field(static::$postType . '_archive_image', 'option');
            }
        }
        return   $this->_image ;
    }

    public function intro_button(){
        if( ! $this->_intro_button ) {
            $this->_intro_button = get_field(static::$postType . '_archive_intro_button', 'option');
        }
        return   $this->_intro_button ;
    }

    public function cta(){
        if( ! $this->_cta ) {
            $cta = get_field( static::$postType . '_archive_cta', 'option');

            if(!empty($cta['button_label'])) {
                $cta['button'] = [
                    'label' => $cta['button_label'],
                    'url' => '#'
                ];

                unset($cta['button_label']);
            }

            $this->_cta = $cta;
        }

        return $this->_cta;
    }

    public static function playlists() {

        $playlists = [];
        $terms = get_terms('video_playlist');

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $playlists[] = new VideoPlaylistTerm($term->term_id);
            }
        }

        return $playlists;

    }

}
