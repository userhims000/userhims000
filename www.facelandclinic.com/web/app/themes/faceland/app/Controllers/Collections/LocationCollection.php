<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

use Rokit\Controllers\Terms\Term;

class LocationCollection extends PostCollection {

    protected static $postType = 'location';

    protected static $postClass = 'Rokit\Controllers\Types\Location';

    var $_bottom;

    public function bottom() {

        if( ! $this->_bottom ) {
            $this->_bottom =  get_field( static::$postType . '_archive_bottom', 'option');
        }

        return $this->_bottom;

    }

    public static function countries() {

        $countries = [];
        $terms = get_terms('location_country');

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $countries[] = new Term($term->term_id);
            }
        }

        return $countries;

    }

    public static function by_country($country_ids) {

        $country_ids = is_iterable($country_ids) ? $country_ids : [$country_ids];

        return self::query_by_terms(['location_country' => $country_ids]);

    }

    public static function single_default() {

        return [
            'related'   => get_field( static::$postType . '_detail_related_intro', 'option'),
            'cta'       => get_field( static::$postType . '_detail_cta', 'option')
        ];

    }

    public static function filter() {
        return ['options' => static::countries()];
    }

}
