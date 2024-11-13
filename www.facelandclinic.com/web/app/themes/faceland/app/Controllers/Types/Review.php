<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Types\Specialist;
use Rokit\Controllers\Types\Treatment;
use Rokit\Controllers\Types\Location;

class Review extends Post {

    protected static $postType = 'review';

    var $_review;

    var $_date;

    var $_name;

    var $_title;

    var $_text;

    var $_grade;

    var $_url;

    var $_review_id;

    var $_location;

    var $_specialist;

    var $_treatment;

    public function review(){
        if( ! $this->_review ) {
            $this->_review = [
                'date'          => $this->review_date(),
                'name'          => $this->name(),
                'title'         => $this->title(),
                'text'         => $this->text(),
                'grade'         => $this->grade(),
                'url'           => $this->url(),
                'id'            => $this->review_id(),
                'location'      => $this->location(),
                'specialist'    => $this->specialist(),
                'treatment'     => $this->treatment(),
            ];
        }

        return $this->_review;
    }

    public function review_date(){
        if( ! $this->_date ) {
            $this->_date = strtotime(strtr( $this->get_field( static::$postType . '_date'), '/', '-'));
        }

        return $this->_date;
    }

    public function name(){
        if( ! $this->_name ) {
            $this->_name = $this->get_field( static::$postType . '_name');
        }

        return $this->_name;
    }

    public function title(){
        if( ! $this->_title ) {
            $this->_title = $this->get_field( static::$postType . '_title');
        }

        return $this->_title;
    }

    public function text(){
        if( ! $this->_text ) {
            $this->_text = $this->get_field( static::$postType . '_text');
        }

        return $this->_text;
    }

    public function grade(){
        if( ! $this->_grade ) {
            $this->_grade =  $this->get_field( static::$postType . '_grade') / 10;
        }

        return $this->_grade;
    }

    public function url(){
        if( ! $this->_url ) {
            $this->_url = $this->get_field( static::$postType . '_url');
        }

        return $this->_url;
    }

    public function review_id(){
        if( ! $this->_review_id ) {
            $this->_review_id = $this->get_field( static::$postType . '_id');
        }

        return $this->_review_id;
    }

    public function location(){
        if( ! $this->_location ) {

            $location_id = $this->get_field( static::$postType . '_location');

            if(!empty($location_id)) {
                $this->_location = new Location($location_id);
            }

        }

        return $this->_location;
    }

    public function specialist(){
        if( ! $this->_specialist ) {

            $specialist_id = $this->get_field( static::$postType . '_specialist');

            if(!empty($specialist_id)) {
                $this->_specialist = new Specialist($specialist_id);
            }
        }

        return $this->_specialist;
    }

    public function treatment(){
        if( ! $this->_treatment ) {

            $treatment_id = $this->get_field( static::$postType . '_treatment');

            if(!empty($treatment_id)) {
                $this->_treatment = new Treatment($treatment_id);
            }
        }

        return $this->_treatment;
    }


}
