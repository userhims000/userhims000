<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

use Rokit\Controllers\Terms\TreatmentTypeTerm;
use Rokit\Controllers\Terms\TreatmentBodypartTerm;

class TreatmentCollection extends PostCollection {

    protected static $postType = 'treatment';

    protected static $postClass = 'Rokit\Controllers\Types\Treatment';

    var $_cta;

    var $_why;

    var $_bottom;

    var $_single_default;

    public function cta() {

        if( ! $this->_cta ) {

            if(!empty($cta_one = get_field(static::$postType . '_archive_cta_one','option'))){
                $this->_cta[] = $cta_one;
            }

            if(!empty($cta_two = get_field(static::$postType . '_archive_cta_two','option'))){
                $this->_cta[] = $cta_two;
            }

        }

        return $this->_cta;
    }

    public function why() {
        if( ! $this->_why ) {
            $this->_why = [
                'title' => get_field(static::$postType . '_archive_why_title', 'option'),
                'blocks' => get_field(static::$postType . '_archive_why_blocks', 'option')
            ];
        }

        return $this->_why;

    }

    public function bottom() {

        if( ! $this->_bottom ) {
            $this->_bottom = [
                'title' => get_field('treatment_archive_bottom_title', 'option'),
                'intro' => get_field('treatment_archive_bottom_intro', 'option')
            ];
        }

        return $this->_bottom;
    }

    public static function single_default() {

        return [
            'specialist'    => get_field( static::$postType . '_detail_specialist_intro', 'option'),
            'faq'           => get_field( static::$postType . '_detail_faq_intro', 'option'),
            'before-after'  => get_field( static::$postType . '_detail_ba_intro', 'option'),
            'cta'           => get_field( static::$postType . '_detail_cta', 'option')
        ];

    }

    public static function bodyparts() {

        $types = [];
        $terms = get_terms('treatment_bodypart');

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $types[] = new TreatmentBodypartTerm($term->term_id);
            }
        }

        return $types;

    }

    public static function types() {

        $types = [];
        $terms = get_terms('treatment_type');

        if(!empty($terms) and is_iterable($terms)) {
            foreach($terms as $term) {
                $types[] = new TreatmentTypeTerm($term->term_id);
            }
        }

        return $types;

    }

    public static function specialists_by_treatment($post_id) {
        return self::post($post_id)->specialists();
    }

    public static function locations_by_treatment($post_id) {
        return self::post($post_id)->locations();
    }

}
