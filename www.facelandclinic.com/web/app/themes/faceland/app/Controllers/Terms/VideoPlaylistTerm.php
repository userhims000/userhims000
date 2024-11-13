<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

use Rokit\Controllers\Collections\VideoCollection;
use Rokit\Controllers\Types\Video;
use TimberTerm;
use Timber;

class VideoPlaylistTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Taxonomies\VideoPlaylistTerm';

    var $_description;

    var $_playlist_link;

    var $_image;

    var $_button;

    public function description() {

        if( ! $this->_description ) {
            $this->_description = $this->get_field('video_taxonomy_description', $this->acf_id());
        }

        return $this->_description;
    }

    public function playlist_link() {

        if( ! $this->_playlist_link ) {
            $this->_playlist_link = $this->get_field('video_taxonomy_link', $this->acf_id());
        }

        return $this->_playlist_link;
    }

    public function image() {

        if( ! $this->_image ) {


            if($this->get_field('video_taxonomy_show_image', $this->acf_id())) {
                $this->_image = $this->get_field('video_taxonomy_image', $this->acf_id());
            }

        }

        return $this->_image;
    }

    public function button() {

        if( ! $this->_button ) {

            $this->_button = [
                'url' => $this->playlist_link(),
                'label' => pll__("Bekijk alle video's"),
                'external' => true
            ];

        }

        return $this->_button;
    }

    function videos() {
         $args = [
            'post_type' => 'video',
            'tax_query' => [
                [
                    'taxonomy' => 'video_playlist',
                    'field' => 'term_id',
                    'terms' => $this->term_id(),
                ]
            ],
            'posts_per_page' => '-1',
            'order' => 'ASC',
            'orderby' => 'menu_order'
        ];

        return VideoCollection::query( $args);
    }
}
