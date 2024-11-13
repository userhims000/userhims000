<?php

// Set the namespace
namespace Rokit\Controllers\Types;

use Rokit\Controllers\Collections\ArticleCollection;
use Rokit\Controllers\Terms\ArticleTagTerm;
use Rokit\Controllers\Terms\ArticleTaxonomyTerm;

class Article extends Post {

    protected static $postType = 'article';

    protected static $collectionClass = 'Rokit\Controllers\Collections\ArticleCollection';

    protected static $termClass = 'Rokit\Controllers\Terms\ArticleTaxonomyTerm';

    var $_primary_term;

    var $_related;

    var $_author;

    var $_image;

    var $_label;

    var $_color;

    var $_share_title;

    var $_labels;

    var $_tags;

    var $_blog_sidebar_feeds;

    var $_recent_blogs;
    
    var $_most_reads_blogs;
    
    var $_blog_feeds_titles;

    var $_custom_blogs_feeds;

    /**
     * Check if primary term is defined (Yoast functionality)
     * If no primary term is defined use first assinged term in array
     *
     * @return string
     */

    public function primary_term(){
        if( ! $this->_primary_term ) {

            $primary_term = get_post_meta($this->ID, '_yoast_wpseo_primary_' . static::$postType .'_taxonomy');

            if(!empty($primary_term[0])) {
                $this->_primary_term = new static::$termClass($primary_term[0]);
            } else {
                $terms = $this->terms(static::$postType . '_taxonomy');
                if(!empty($terms[0])) {
                    $this->_primary_term = $terms[0];
                }
            }
        }

        return $this->_primary_term;
    }

    public function related(){
        if( ! $this->_related ) {

            $related_posts = $recent_posts = $exclude_posts = $related_posts_ids = [];
            $max_posts = 3;
            $related_posts_ids = $this->get_field( $this->post_type . '_related');

            if(!empty($related_posts_ids) && is_array($related_posts_ids)) {
                $related_posts = static::$collectionClass::posts_by_id($related_posts_ids);
                $exclude_posts = array_column($related_posts, 'ID');
            }

            if(count($related_posts) < $max_posts) {
                $recent_posts = static::$collectionClass::query([
                    'post__not_in' => array_merge($exclude_posts, [$this->ID]),
                    'posts_per_page' => $max_posts - count($related_posts)
                ]);
            }

            $this->_related = array_merge($related_posts, $recent_posts);
        }

        return $this->_related;
    }

    public function image(){
        if( ! $this->_image ) {
            $this->_image = $this->get_field( static::$postType . '_image');
        }

        return $this->_image;
    }

    public function label(){
        if( ! $this->_label ) {
            $this->_label = $this->get_field( static::$postType . '_label');
        }

        return $this->_label;
    }

    public function color(){
        if( ! $this->_color ) {
            $this->_color = $this->get_field( static::$postType . '_color');
        }

        return $this->_color;
    }

    public function share_title() {
        if( ! $this->_share_title ) {
            $this->_share_title = pll__('Deel op social media:');
        }

        return $this->_share_title;
    }

    public function labels() {
        if( ! $this->_labels ) {
            $labels = $this->terms(static::$postType . '_taxonomy');
            if(!empty($labels) && is_array($labels)) {
                foreach($labels as $label) {
                    $this->_labels[] = new ArticleTaxonomyTerm($label->ID);
                }
            }
        }

        return $this->_labels;
    }

    public function tags() {
        if( ! $this->_tags ) {
            $tags = $this->terms(static::$postType . '_tag');
            if(!empty($tags) && is_array($tags)) {
                foreach($tags as $tag) {
                    $this->_tags[] = new ArticleTagTerm($tag->ID);
                }
            }
        }

        return $this->_tags;
    }

    public function blog_sidebar_feeds() {
        if( ! $this->_blog_sidebar_feeds ) {
            $current_post_id = get_the_ID(); // Get the ID of the current post
            $getCustomBlogFeeds = \get_field( 'sidebar_feeds', get_the_ID());
            $getCountsBlogSidebarFeeds = \get_field( 'show_number_of_sidebar_feeds', get_the_ID());
            foreach($getCustomBlogFeeds as $postObject){
                $customFeedsPostIds[] = $postObject->ID; 
            }
            if(is_array($customFeedsPostIds) && !empty($customFeedsPostIds)){
                $args = array(
                    'post_type'      => 'blog_article',
                    'posts_per_page' =>  $getCountsBlogSidebarFeeds ? $getCountsBlogSidebarFeeds : 3, 
                    'post__not_in'   => array($current_post_id),
                    'post__in'   =>   $customFeedsPostIds,
                    'post_status'    => 'publish',
                    'orderby'        => 'post__in',
                    //'order'          => 'DESC'
                ); 
            }else{
                $args = array(
                    'post_type'      => 'blog_article',
                    'posts_per_page' =>  $getCountsBlogSidebarFeeds ? $getCountsBlogSidebarFeeds : 3, 
                    'post__not_in'   => array($current_post_id),
                    'post_status'    => 'publish',
                    'orderby'        => 'post_date',
                    'order'          => 'DESC'
                );
            }

            $recent_posts_query = new \WP_Query($args);

            if ($recent_posts_query->have_posts()) {
                while ($recent_posts_query->have_posts()) {
                    $recent_posts_query->the_post();
                    $tagsArray = [];
                    $terms = get_the_terms(get_the_ID(), 'blog_article_tag');
                    if ($terms && !is_wp_error($terms)) {
                        $term_names = array();
                        foreach ($terms as $term) {
                            $labelColor = get_field('blog_article_tag_color', $term->taxonomy . '_' . $term->term_id);
                            $tagsArray[get_term_link($term)] = [
                                'tagName' => $term->name,
                                'tagColor' => $labelColor
                            ];
                        }
                    }
                    $categoryArray = [];
                    /*$tags = get_the_terms(get_the_ID(), 'blog_article_tag');
                    if ($tags && !is_wp_error($tags)) {
                        $term_names = array();
                        foreach ($tags as $tag) {
                            $tagsArray[get_term_link($tag)] = $tag->name;
                        }
                    }*/
                    $featureImageID = \get_field( static::$postType . '_image', get_the_ID());
                    $imageURL = wp_get_attachment_image_src($featureImageID, 'full');
                    $this->_blog_sidebar_feeds[] = [
                        'image' => $featureImageID != '' ? $imageURL[0] : '',
                        'category' => $categoryArray,
                        'tags' => $tagsArray,
                        'post_title' => get_the_title(),
                        'post_url' => get_permalink(get_the_ID())
                    ];
                }
                wp_reset_query();
            }
        }

        return $this->_blog_sidebar_feeds;
    }

    public function recent_blogs() {
        if( ! $this->_recent_blogs ) {
            $current_post_id = get_the_ID(); // Get the ID of the current post
            $getCustomRecentBlogFeeds = \get_field( 'most_recent_blogs_feeds', get_the_ID());
            foreach($getCustomRecentBlogFeeds as $postObject){
                $customFeedsPostIds[] = $postObject->ID; 
            }
            if(is_array($customFeedsPostIds) && !empty($customFeedsPostIds)){
                $args = array(
                    'post_type'      => 'blog_article',
                    'posts_per_page' => -1,
                    'post__not_in'   => array($current_post_id),
                    'post__in'   => $customFeedsPostIds,
                    'post_status'    => 'publish',
                    'orderby'        => 'post__in',
                    //'order'          => 'DESC'
                );
            }else{
                $args = array(
                    'post_type'      => 'blog_article',
                    'posts_per_page' => -1,
                    'post__not_in'   => array($current_post_id),
                    'post_status'    => 'publish',
                    'orderby'        => 'date',
                    'order'          => 'DESC'
                );
            }

            $recent_posts_query = new \WP_Query($args);

            if ($recent_posts_query->have_posts()) {
                while ($recent_posts_query->have_posts()) {
                    $recent_posts_query->the_post();
                    $categoryArray = [];
                    $terms = get_the_terms(get_the_ID(), 'blog_article_taxonomy');
                    if ($terms && !is_wp_error($terms)) {
                        $term_names = array();
                        foreach ($terms as $term) {
                            $categoryArray[get_term_link($term)] = $term->name;
                        }
                    }
                    $tagsArray = [];
                    $tags = get_the_terms(get_the_ID(), 'blog_article_tag');
                    if ($tags && !is_wp_error($tags)) {
                        $term_names = array();
                        foreach ($tags as $tag) {
                            $tagsArray[get_term_link($tag)] = $tag->name;
                        }
                    }
                    $featureImageID = \get_field( static::$postType . '_image', get_the_ID());
                    $imageURL = wp_get_attachment_image_src($featureImageID, 'full');
                    $this->_recent_blogs[] = [
                        'image' => $featureImageID != '' ? $imageURL[0] : '',
                        'category' => $categoryArray,
                        'tags' => $tagsArray,
                        'post_title' => get_the_title(),
                        'post_url' => get_permalink(get_the_ID())
                    ];
                }
                wp_reset_query();
            }
        }
        return $this->_recent_blogs;
    }

    public function most_reads_blogs() {
        if( ! $this->_most_reads_blogs ) {
            $current_post_id = get_the_ID(); // Get the ID of the current post
            $getCustomPopularBlogFeeds = \get_field( 'most_popular_blogs_feeds', get_the_ID());
            foreach($getCustomPopularBlogFeeds as $postObject){
                $customFeedsPostIds[] = $postObject->ID; 
            }
            if(is_array($customFeedsPostIds) && !empty($customFeedsPostIds)){
                $args = array(
                    'post_type'      => 'blog_article',
                    'posts_per_page' => -1,
                    'post__not_in'   => array($current_post_id),
                    'post__in'       =>  $customFeedsPostIds,
                    'post_status'    => 'publish',
                    'orderby'        => 'post__in'
                );
            }else{
                $args = array(
                    'post_type'      => 'blog_article',
                    'posts_per_page' => -1,
                    'post__not_in'   => array($current_post_id),
                    'meta_key'       => 'popular_posts', 
                    'orderby'        => 'meta_value_num',
                    'post_status'    => 'publish',
                    'order'          => 'DESC'
                );
            }

            $recent_posts_query = new \WP_Query($args);

            if ($recent_posts_query->have_posts()) {
                while ($recent_posts_query->have_posts()) {
                    $recent_posts_query->the_post();
                    $count = get_post_meta(get_the_ID(), 'popular_posts', true);

                    $categoryArray = [];
                    $terms = get_the_terms(get_the_ID(), 'blog_article_taxonomy');
                    if ($terms && !is_wp_error($terms)) {
                        $term_names = array();
                        foreach ($terms as $term) {
                            $categoryArray[get_term_link($term)] = $term->name;
                        }
                    }
                    $tagsArray = [];
                    $tags = get_the_terms(get_the_ID(), 'blog_article_tag');
                    if ($tags && !is_wp_error($tags)) {
                        $term_names = array();
                        foreach ($tags as $tag) {
                            $tagsArray[get_term_link($tag)] = $tag->name;
                        }
                    }
                    $featureImageID = \get_field( static::$postType . '_image', get_the_ID());
                    $imageURL = wp_get_attachment_image_src($featureImageID, 'full');
                    $this->_most_reads_blogs[] = [
                        'image' => $featureImageID != '' ? $imageURL[0] : '',
                        'category' => $categoryArray,
                        'tags' => $tagsArray,
                        'post_title' => get_the_title(),
                        'post_url' => get_permalink(get_the_ID())
                    ];
                }
                wp_reset_query();
            }
        }
        return $this->_most_reads_blogs;
    }

    public function blog_feeds_titles() {
        if( ! $this->_blog_feeds_titles ) {
            $this->_blog_feeds_titles = [
                'sidebar_feeds_title' => \get_field( 'sidebar_feeds_title','option'),
                'most_recent_blog_title' => \get_field( 'most_recent_blog_carousel_title', 'option'),
                'most_popular_blog_title' => \get_field( 'most_popular_blog_carousel_title', 'option')
            ];
        }

        return $this->_blog_feeds_titles;
    }
}
