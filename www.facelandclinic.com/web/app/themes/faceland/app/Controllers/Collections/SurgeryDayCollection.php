<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

use Rokit\Controllers\Terms\SurgeryDayTypeTerm;

class SurgeryDayCollection extends AcademyCollection {

    protected static $postType = 'surgery_day';

    protected static $postClass = 'Rokit\Controllers\Types\SurgeryDay';


    public function panorama() {
        if( ! $this->_panorama ) {
            $this->_panorama = [
                'title'         => get_field( static::$postType .'_archive_panorama_titles_title', 'option' ),
                'subtitle'      => get_field( static::$postType .'_archive_panorama_titles_subtitle', 'option'  ),
                'image'         => get_field( static::$postType .'_archive_panorama_image', 'option'  ),
                'show'          => get_field( static::$postType .'_archive_panorama_show_image', 'option'  ),
            ];
        }

        return $this->_panorama;
    }

    public static function types() {

        $types = [];
        $terms = get_terms('surgery_day_type');

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $types[] = new SurgeryDayTypeTerm($term->term_id);
            }
        }

        return $types;
    }

    public static function filter() {
        return ['options' => static::types()];
    }

}
