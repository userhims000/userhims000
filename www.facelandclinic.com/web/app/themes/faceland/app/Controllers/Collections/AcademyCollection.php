<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

class AcademyCollection extends PostCollection {

    protected static $postType = 'academy';

    protected static $postClass = 'Rokit\Controllers\Types\Academy';

    var $_panorama;

    var $_video;

    var $_intro;

    var $_list;

    var $_appointment;

    var $_cta;

    public function panorama() {
        if( ! $this->_panorama ) {
            if(!empty($panorama =  get_field( static::$postType .'_archive_panorama', 'option' ))){
                $this->_panorama = [
                    'title'     => $panorama['title'],
                    'subtitle'  => $panorama['subtitle'],
                    'type'      => $panorama['panorama_show'],
                    'image'     => $panorama['panorama_image'],
                    'video' => [
                        'url' => $panorama['panorama_video_url'],
                        'thumbnail' => $panorama['panorama_video_thumbnail'],
                    ]
                ];
            }
        }

        return $this->_panorama;
    }

    public function video() {
        if( ! $this->_video ) {
            if (get_field( static::$postType .'_archive_show_video', 'option' )){
                $this->_video = get_field( static::$postType .'_archive_video', 'option' );
            }
        }

        return $this->_video;
    }

    public function intro() {
        if( ! $this->_intro ) {
            $titleTag = ['tag' => get_field( static::$postType .'_tag', 'option' )];
            $this->_intro = array_merge(get_field( static::$postType .'_archive_intro', 'option' ),$titleTag);
        }

        return $this->_intro;
    }

    public function list() {
        if( ! $this->_list ) {
            $this->_list = [
                'title_tag' => get_field( static::$postType .'_list_tag', 'option' ),
                'title' => get_field( static::$postType .'_archive_list_title', 'option' ),
                'subtitle' => get_field( static::$postType .'_archive_list_subtitle', 'option' ),
                'items' => $this->items(),
            ];
        }

        return $this->_list;
    }

    public function appointment() {

        if( ! $this->_appointment ) {
            $titleTag = ['tag' => get_field( static::$postType .'_appointment_tag', 'option' )];
            $this->_appointment = array_merge(get_field( static::$postType .'_archive_appointment', 'option' ),$titleTag);
        }

        return $this->_appointment;
    }

    public function cta() {
        if( ! $this->_cta ) {
            $ctaSectionTitleTag = ['title_tag' => get_field(static::$postType . '_cta_tag', 'option')];
            $cta = array_merge(get_field(static::$postType . '_archive_cta', 'option'), $ctaSectionTitleTag);

            if (!empty($cta)){
                $cta['image'] = get_field(static::$postType . '_archive_cta_image', 'option');
            }
            $this->_cta = $cta;
        }

        return $this->_cta;
    }

    public static function items(array $args = []) {

        $args = array_merge([
            'meta_query' =>  [
                [
                    'key' => static::$postType . '_date',
                    'value' => date('Ymd'),
                    'type' => 'DATE',
                    'compare' => '>='
                ]
            ],
            'meta_key' => static::$postType . '_date',
            'orderby' => 'meta_value_num',
            'order' => 'ASC'
        ], $args);

        return self::query($args);

    }
}
