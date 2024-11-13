<?php

// Set the namespace
namespace Rokit\Controllers\Pages;

class Page1158 extends Page {

    protected static $postType = 'page';

    var $_intro;

    var $_questions;

    var $_contacts;

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
                    //'title' => $this->get_field( $this->post_type .'_questions_title' ),
                    //'items' => $questions
                ];
            }
        }

        return $this->_questions;
    }

    public function contacts() {
        if( !$this->_contacts ) {
            if ( $this->get_field( $this->post_type .'_contacts_show' ) ){
                $contacts = !empty($this->get_field( $this->post_type .'_contacts' )) ? $this->get_field( $this->post_type .'_contacts' ) : [];

                foreach ($contacts as &$contact){
                    $contact['featherlight'] = rand() . 'contacts';
                }
                //var_dump($this->post_type);
                $this->_contacts = [
                    //'title' => $this->get_field( $this->post_type .'_contacts_title' ),
                    //'items' => ''
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
                    //'title' => $this->get_field( $this->post_type .'_days_titles_title' ),
                    //'intro' => $this->get_field( $this->post_type .'_days_titles_subtitle' )
                ],
                'items' => ''
            ];
        }

        return $this->_fixed_days;
    }
}
