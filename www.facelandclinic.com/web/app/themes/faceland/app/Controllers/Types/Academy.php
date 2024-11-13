<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\LocationCollection;
use Rokit\Controllers\Collections\TreatmentCollection;

class Academy extends PostDetail {

    protected static $postType = 'academy';

    var $_date_of_academy;

    var $_treatments;

    public function title(){
        if( ! $this->_title ) {
            $this->_title = $this->get_field( static::$postType . '_title');
        }

        return $this->_title;
    }

    public function date_of_academy(){
        if( ! $this->_date_of_academy ) {
            $this->_date_of_academy = $this->get_field( static::$postType . '_date');
        }

        return $this->_date_of_academy;
    }

    public function data(){
        if( ! $this->_data ) {

            $data = $this->get_field( static::$postType . '_treatments');

            if(!empty($data) && is_iterable($data)) {
                $this->_data = array_map(function($data){
                    $data['column_two'] = TreatmentCollection::post($data['column_two']);
                    $data['column_three'] = LocationCollection::post($data['column_three']);
                    return $data;
                }, $data);
            }

        }

        return $this->_data;
    }

    public function search_link() {

        if(!$this->_search_link) {
            $this->_search_link =  get_post_type_archive_link(static::$postType);
        }

        return $this->_search_link;
    }

}
