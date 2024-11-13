<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\BlogArticleCollection;
use Rokit\Controllers\Terms\BlogArticleTagTerm;

class BlogArticle extends Article {

    protected static $postType = 'blog_article';

    protected static $collectionClass = 'Rokit\Controllers\Collections\BlogArticleCollection';

    protected static $termClass = 'Rokit\Controllers\Terms\BlogArticleTaxonomyTerm';

    public function author(){
        if( ! $this->_author ) {
            $this->_author = $this->get_field( static::$postType . '_overwrite_author') ? $this->get_field( static::$postType . '_author') : BlogArticleCollection::author();
        }

        return $this->_author;
    }

    public function tags() {
        if( ! $this->_tags ) {
            $tags = $this->terms(static::$postType . '_tag');
            if(!empty($tags) && is_array($tags)) {
                foreach($tags as $tag) {
                    $this->_tags[] = new BlogArticleTagTerm($tag->ID);
                }
            }
        }

        return $this->_tags;
    }


}
