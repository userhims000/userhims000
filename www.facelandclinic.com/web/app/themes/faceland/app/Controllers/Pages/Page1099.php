<?php

// Set the namespace
namespace Rokit\Controllers\Pages;

class Page1099 extends Page {

    protected static $postType = 'page';

    var $_more_information;

    public function more_information() {
        if( !$this->_more_information ) {
            $this->_more_information = [
                'titles' => [
                    'title_tag' => $this->get_field(static::$postType.'_more_information_titles_title_tag'),
                    'title' => $this->get_field(static::$postType.'_more_information_titles_title'),
                    'intro' =>$this->get_field(static::$postType.'_more_information_titles_subtitle')
                ],
                'subjects' => $this->get_field(static::$postType.'_more_information_subjects')
            ];
        }

        return $this->_more_information;
    }

}
