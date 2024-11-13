<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

use Rokit\Controllers\Collections\FaqCollection;

class FaqTaxonomyTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Taxonomies\FaqTaxonomyTerm';

    var $_long_title;
    
    var $_long_title_heading;

    var $_highlighted;

    var $_intro;

    var $_media;

    var $_types;

    var $_button;

    public function long_title() {

        if( ! $this->_long_title ) {
            $this->_long_title = $this->get_field('faq_taxonomy_long_title', $this->acf_id());
        }

        return $this->_long_title;
    }

    public function long_title_heading() {

        if( ! $this->_long_title_heading ) {
            $this->_long_title_heading = $this->get_field('faq_taxonomy_heading_tag', $this->acf_id());
        }

        return $this->_long_title_heading;
    }


    public function highlighted() {

        if( ! $this->_highlighted ) {
            $highlighted =  $this->get_field('faq_taxonomy_highlighted', $this->acf_id());
            if (!empty($highlighted)){
                $this->_highlighted = FaqCollection::posts_by_id($highlighted);
            }
        }

        return $this->_highlighted;
    }

    public function intro() {

        if( ! $this->_intro ) {
            $this->_intro = [
                'short' => $this->get_field('faq_taxonomy_short_description', $this->acf_id()),
                'long' => $this->get_field('faq_taxonomy_long_description', $this->acf_id())
            ];
        }

        return $this->_intro;
    }

    public function media(){
        if( ! $this->_media ) {
            $type =  $this->get_field('faq_taxonomy_media_type', $this->acf_id());
            $media['type'] =$type;
            $media[$type] = $this->get_field('faq_taxonomy_media_'.$type, $this->acf_id());
            $this->_media = $media;
        }

        return $this->_media;
    }

    public function types(){
        if( ! $this->_types ) {

            $webshop_id = FaqCollection::get_webshop_taxonomy_id();
            if ($webshop_id == $this->ID || $this->parent == $webshop_id){

                $terms = get_term_children($webshop_id, 'faq_taxonomy' );
                $types = [];

                foreach($terms as $term) {
                    $types[] = new FaqTaxonomyTerm($term);
                }

                $this->_types = $types;
            } else {
                $this->_types = FaqCollection::types();
            }
        }

        return $this->_types;
    }

    public function button(){
        if( ! $this->_button ) {
            $this->_button = [
                'url' => $this->link(),
                'label' => pll__('Bekijk alle vragen'),
                'external' => false
            ];
        }

        return $this->_button;
    }

    public function collection_button() {
        $collection_button = [
            'url' => get_post_type_archive_link($this->post_type()),
            'label' =>  pll__('Terug naar overzicht')
        ];
        return $collection_button;
    }

    function items() {
        $args = [
            'post_type' => 'faq',
            'tax_query' => [
                [
                    'taxonomy' => 'faq_taxonomy',
                    'field' => 'term_id',
                    'terms' => $this->term_id(),
                ]
            ],
            'posts_per_page' => '-1',
            'order' => 'ASC',
            'orderby' => 'menu_order'
        ];

        return FaqCollection::query( $args);
    }
}
