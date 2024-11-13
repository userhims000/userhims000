<?php

// Set the namespace
namespace Rokit\Controllers\Terms;

use Rokit\Controllers\Collections\BlogArticleCollection;

class BlogArticleTaxonomyTerm extends Term {

    public $TermClass = 'Rokit\Controllers\Taxonomies\BlogArticleTaxonomyTerm';

    var $_labels;

    public function labels() {
        if( ! $this->_labels ) {
            $labels = $this->terms(static::$postType . '_taxonomy');
            if(!empty($labels) && is_array($labels)) {
                foreach($labels as $label) {
                    $this->_labels[] = new BlogArticleCollection($label->ID);
                }
            }
        }

        return $this->_labels;
    }

}
