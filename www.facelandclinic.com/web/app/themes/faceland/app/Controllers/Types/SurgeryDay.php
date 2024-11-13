<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\LocationCollection;
use Rokit\Controllers\Collections\SpecialistCollection;
use Rokit\Controllers\Collections\TreatmentCollection;

class SurgeryDay extends Post {

    protected static $postType = 'surgery_day';

    protected static $termClass = 'Rokit\Controllers\Terms\SurgeryDayTypeTerm';

    var $_is_single;

    var $_title;

    var $_date_info;

    var $_data;

    var $_location;

    var $_treatment;

    var $_specialist;

    public function is_single() {
        if( ! $this->_is_single ) {
            if (!empty($term_id = $this->get_field(static::$postType . '_type'))){
                $term = new static::$termClass($term_id);
                $this->_is_single = $term->lang_id() == 181 ? true : false;
            }
        }

        return $this->_is_single;
    }

    public function title() {
        if( ! $this->_title ) {

            $title = $this->is_single() ? pll__('Consult') : $this->treatment()->title();
            $format = pll__('%s bij %s');
            $this->_title =   sprintf($format, $title, $this->specialist()->fullname());

        }

        return $this->_title;
    }

    public function date_info(){
        if( ! $this->_date_info ) {
            if($this->is_single()) {
                $this->_date_info = $this->get_field( static::$postType . '_date');
            } else {
                $this->_date_info = [
                    'start' => $this->get_field( static::$postType . '_date_start'),
                    'end' => $this->get_field( static::$postType . '_date_end')
                ];
            }
        }

        return $this->_date_info;
    }

    public function data(){
        if( ! $this->_data ) {

            $data = $this->get_field( static::$postType . '_data');

            if(!empty($data) && is_iterable($data)) {
                $this->_data = array_map(function($data){
                    $data['column_three'] = LocationCollection::post($data['column_three']);
                    return $data;
                }, $data);
            }
        }

        return $this->_data;

    }

    public function location() {

        if( ! $this->_location ) {
            $location = $this->get_field(static::$postType . '_location');
            if(!empty($location)) {
                $this->_location = LocationCollection::post($location);
            }

        }

        return $this->_location;
    }

    public function treatment() {

        if( ! $this->_treatment ) {
            $treatment = $this->get_field(static::$postType . '_treatment');
            if(!empty($treatment)) {
                $this->_treatment = TreatmentCollection::post($treatment);
            }

        }

        return $this->_treatment;
    }

    public function specialist() {
        if( ! $this->_specialist ) {
            $specialist = $this->get_field(static::$postType . '_specialist');
            if(!empty($specialist)) {
                $this->_specialist = SpecialistCollection::post($specialist);
            }
        }

        return $this->_specialist;
    }

    public function search_link() {

        if(!$this->_search_link) {
            $this->_search_link =  get_post_type_archive_link(static::$postType);
        }

        return $this->_search_link;
    }

}
