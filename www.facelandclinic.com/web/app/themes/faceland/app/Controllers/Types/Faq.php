<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\FaqCollection;

class Faq extends Post {

    protected static $postType = 'faq';

    var $_question;

    var $_answer;

    var $_modal;

    public function question() {
        if (!$this->_question) {
            $this->_question = $this->get_field(static::$postType . '_title');
        }

        return $this->_question;
    }

    public function answer() {

        if (!$this->_answer) {
            $this->_answer = $this->get_field(static::$postType . '_text');
        }

        return $this->_answer;
    }

    public function modal($classname = null) {

        if (!$this->_modal) {
            $class = !empty($classname) ? 'class="' . $classname . '"' : '';
            $this->_modal = sprintf('<div %s><h3>%s</h3>%s</div>', $class, $this->question(), $this->answer());
        }

        return $this->_modal;
    }

    public function search_link() {

        if(!$this->_search_link) {

            $terms = $this->terms(['faq_taxonomy']);

            if(!empty($terms[0])) {
                $this->_search_link = $terms[0]->link();
            } else {
                $this->_search_link = FaqCollection::url();
            }

        }

        return $this->_search_link;
    }

    public function search_excerpt(string $passed_excerpt=null) {
        if(!$this->_search_excerpt) {
            $this->_search_excerpt = parent::search_excerpt($this->answer());
        }

        return $this->_search_excerpt;
    }

}
