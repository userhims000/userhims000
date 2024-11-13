<?php

namespace Rokit\Controllers\Collections;

use Rokit\Controllers\Collections\LocationCollection;
use Timber\Pagination;

class SearchCollection extends PostCollection {

    protected static $postType = 'page';

    protected static $postClass = 'Rokit\Controllers\Types\Page';

    var $_swp_query;

    var $_search_total;

    var $_search_title;

    var $_search_results_title;

    var $_search_query;

    var $_search_results;

    var $_search_posttype;

    function __construct() {

        global $wp_query;

        $this->_swp_query = $wp_query;

    }

    public function title() {
        if( !$this->_search_title ) {
            $this->_search_title = $this->search_query() ? pll__('Zoekresultaten') : pll__('Zoeken');
        }

        return $this->_search_title;
    }

    public function results_title() {
        if( !$this->_search_results_title ) {
            $plural = sprintf(pll__('%s resultaten voor:'), $this->total());
            $single = sprintf(pll__('%s resultaat voor:'), $this->total());
            $this->_search_results_title = $this->total() > 1 ? $plural : $single;
        }

        return $this->_search_results_title;
    }

    public function total() {
        if( !$this->_search_total ) {
            if(!empty($this->_swp_query->found_posts)) {
                $this->_search_total =  $this->_swp_query->found_posts;
            }
        }

        return $this->_search_total;
    }

    public function search_query() {

        if( !$this->_search_query ) {
            $search_query = get_search_query();
            $this->_search_query = (strlen(trim($search_query)) == 0) ? false : $search_query;
        }

        return $this->_search_query;
    }

    public function search_posttype() {

        if( !$this->_search_posttype ) {

            $query_var = !empty( $_GET['post_type'] ) ? $_GET['post_type'] : '';

            if( !empty( $query_var ) && post_type_exists( $query_var ) ) {
                $this->_search_posttype = $query_var;
            }

        }

        return $this->_search_posttype;
    }

    public function results() {

        if( !$this->_search_results ) {

            $results = [];
            $posts = $this->_swp_query->posts;

            if(!empty($posts) && is_array($posts)) {
                foreach( $posts as $post ) {

                    $controller = rokit_timber_type_class( $post->post_type, $post->ID );
                    $results[] = new $controller($post->ID);

                }
            }

            if(!empty($results)) {
                $this->_search_results = $results;
            }

        }

        return $this->_search_results;

    }

    public function pagination() {
        return new Pagination([], $this->_swp_query);
    }

}
?>
