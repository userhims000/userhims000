<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

class ArticleTaxonomyTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Taxonomies\ArticleTaxonomyTerm';

    var $_description;

    var $_items;

    var $_color;

    public function description() {

        if( ! $this->_description ) {
            $this->_description =  term_description( $this->term_id, self::post_type().'_taxonomy' );
        }

        return $this->_description;
    }

    public function items() {

        if( ! $this->_items ) {
            $args = [
                'orderby'           => 'menu_order',
                'order'             => 'ASC'
            ];

            $this->_items = $this->get_posts($args);
        }

        return $this->_items;
    }

    public function color(){
        if( ! $this->_color ) {
            $this->_color = $this->get_field( self::post_type(). '_taxonomy_color');
        }

        return $this->_color;
    }

}
