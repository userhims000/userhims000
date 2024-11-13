<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\LocationCollection;
use Rokit\Controllers\Collections\SpecialistCollection;

class LastMinute extends Post {

    protected static $postType = 'last_minute';

    var $_title;

    var $_general;

    var $_day;

    var $_location;

    var $_data;

    public function title() {

        if( ! $this->_title ) {
            $this->_title = $this->get_field( static::$postType .'_title' );
        }

        return $this->_title;
    }

    public function general(){
        if( ! $this->_general ) {
            $this->_general = [
                'day' => $this->get_field( static::$postType . '_day'),
                'treatments' => $this->treatments(),
                'location' =>  $this->location()
            ];
        }

        return $this->_general;
    }

    public function location() {
        if( ! $this->_location ) {
            $location = $this->get_field( static::$postType . '_location');
            $this->_location = LocationCollection::post($location);
        }

        return $this->_location;
    }

    public function date_info(){
        if( ! $this->_date_info ) {
            $this->_date_info = $this->get_field( static::$postType . '_date');
        }

        return $this->_date_info;
    }

    public function data(){
        if( ! $this->_data ) {
            $show_data = $this->get_field( static::$postType . '_show_data');
            if(!empty($show_data)) {

                $data = $this->get_field( static::$postType . '_data');

                if(!empty($data) && is_iterable($data)) {
                    $this->_data = array_map(function($data){
                        $data['column_three'] = SpecialistCollection::post($data['column_three']);
                        return $data;
                    }, $data);
                }

            }
        }

        return $this->_data;
    }
}
