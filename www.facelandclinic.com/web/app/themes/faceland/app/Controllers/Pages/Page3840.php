<?php

// Set the namespace
namespace Rokit\Controllers\Pages;

class Page3840 extends Page {

    protected static $postType = 'page';

    var $_intro;

    var $_items;

    var $_appointment;

    public function intro() {
        if( !$this->_intro ) {
            $this->_intro = [
                'title' =>  $this->get_field( $this->post_type .'_intro_title' ),
                'text' =>  $this->get_field( $this->post_type .'_intro_text' )
            ];
        }

        return $this->_intro;
    }

    public function items() {
        if( !$this->_items ) {
            $this->_items =  $this->get_field( $this->post_type .'_items' );
        }

        return $this->_items;
    }

    public function appointment() {
        if( !$this->_appointment ) {
            $this->_appointment = [
                'title' =>  $this->get_field( $this->post_type .'_appointment_title' ),
                'text'  =>  $this->get_field( $this->post_type .'_appointment_text' )
            ];
        }

        return $this->_appointment;
    }
}
