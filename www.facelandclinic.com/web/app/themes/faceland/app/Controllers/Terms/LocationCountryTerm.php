<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

class LocationCountryTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Taxonomies\LocationCountryTerm';

    var $_items;

    public function items() {

        if( ! $this->_items ) {
            $args = [
                'posts_per_page' => -1,
                'orderby'=> 'title',
                'order' => 'ASC'
            ];

            $this->_items = self::posts($args);
        }

        return $this->_items;
    }
}
