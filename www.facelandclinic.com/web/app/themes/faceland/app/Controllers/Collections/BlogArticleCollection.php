<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

class BlogArticleCollection extends ArticleCollection {

    protected static $postType = 'blog_article';

    protected static $postClass = 'Rokit\Controllers\Types\BlogArticle';

    protected static $termClass = 'Rokit\Controllers\Terms\BlogArticleTaxonomyTerm';

}
