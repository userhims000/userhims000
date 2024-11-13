<?php

// Set the namespace
namespace Rokit\Controllers\Pages;

class Page11834 extends Page {

    protected static $postType = 'page';

    var $_intro;

    var $_questions;

    var $_contacts;

    var $_appointment_book;

    var $_fixed_days;

    public function intro() {
        if( !$this->_intro ) {
            $this->_intro = $this->get_field( $this->post_type .'_intro' );
        }

        return $this->_intro;
    }

    public function questions() {
        if( !$this->_questions ) {
            if ( $this->get_field( $this->post_type .'_questions_show' ) ){
                $questions = !empty($this->get_field( $this->post_type .'_questions' )) ? $this->get_field( $this->post_type .'_questions' ) : [];

                foreach ($questions as &$question){
                    $question['featherlight'] = rand() . '-questions';
                    $question['popup_title'] = $question['title'];
                    $question['popup_text'] = $question['text'];
                }
                $this->_questions = [
                    'title' => $this->get_field( $this->post_type .'_questions_title' ),
                    'items' => $questions
                ];
            }
        }

        return $this->_questions;
    }

    public function appointment_book() {
        if( !$this->_appointment_book ) {
            if ( $this->get_field( $this->post_type .'_appointment_book' ) ){
                $this->_appointment_book = [
                    'items' => $this->get_field( $this->post_type .'_appointment_book' )
                ];
            }
        }

        return $this->_appointment_book;
    }

    public function contacts() {
        if( !$this->_contacts ) {
            if ( $this->get_field( $this->post_type .'_contacts_show' ) ){
                $contacts = !empty($this->get_field( $this->post_type .'_contacts' )) ? $this->get_field( $this->post_type .'_contacts' ) : [];
                foreach ($contacts as &$contact){
                    $contact['featherlight'] = rand() . 'contacts';
                }
                
                $this->_contacts = [
                    'title' => $this->get_field( $this->post_type .'_contact_title' ),
                    'sub_title' => $this->get_field( $this->post_type .'_contact_sub_texts' ),
                    'items' => $contacts
                ];
            }
        }

        return $this->_contacts;
    }

    public function fixed_days() {
        if( !$this->_fixed_days ) {
            $this->_fixed_days = [
                'titles' =>
                [
                    'title' => $this->get_field( $this->post_type .'_days_titles_title' ),
                    'intro' => $this->get_field( $this->post_type .'_days_titles_subtitle' )
                ],
                'items' =>$this->get_field( $this->post_type .'_days_info' )
            ];
        }

        return $this->_fixed_days;
    }
}
