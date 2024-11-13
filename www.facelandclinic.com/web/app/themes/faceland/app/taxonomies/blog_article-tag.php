<?php

$labels = array(
	'name'                       => _x( 'Categories', 'taxonomy general name', 'faceland' ),
	'singular_name'              => _x( 'Categorie', 'taxonomy singular name', 'faceland' ),
    'search_items'               => __( 'Search', 'faceland' ),
    'popular_items'              => __( 'Popular', 'faceland' ),
    'all_items'                  => __( 'All', 'faceland' ),
    'parent_item'                => null,
    'parent_item_colon'          => null,
    'edit_item'                  => __( 'Edit', 'faceland' ),
    'update_item'                => __( 'Updating', 'faceland' ),
    'add_new_item'               => __( 'Voeg toe', 'faceland' ),
    'new_item_name'              => __( 'add', 'faceland' ),
    'separate_items_with_commas' => __( 'Comma separated', 'faceland' ),
);

// Register taxonomy
// For more info see rokit_register_taxonomy() function
rokit_register_taxonomy( 'blog_article_tag', 'blog_article', array(

	// Add some default labels
	// When no labels are added labels will be generated in ENG
    'labels' => $labels,
    'rewrite' => [
        'slug' => '%lang%/%post_type%/tags'
    ],
    'hierarchical' => false,

));

function blog_article_tag_link_filter( $url, $term, $taxonomy ) {

    if($taxonomy == 'blog_article_tag') {
        $post_type_object = get_post_type_object('blog_article');
        $slug = pll_translate_string($post_type_object->rewrite['slug'], pll_current_language());
        $url = str_replace('%post_type%', $slug, $url);
        $url = str_replace('%lang%', pll_current_language(), $url);
    }

    return $url;

}

add_filter('term_link', 'blog_article_tag_link_filter', 10, 3);

?>
