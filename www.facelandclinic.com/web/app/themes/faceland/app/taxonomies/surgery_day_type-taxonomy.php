<?php

$labels = array(
	'name'                       => _x( 'Types', 'taxonomy general name', 'faceland' ),
	'singular_name'              => _x( 'Type', 'taxonomy singular name', 'faceland' ),
	'menu_name'                  => __( 'Types','faceland' ),
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
rokit_register_taxonomy( 'surgery_day_type', 'surgery_day', array(

	// Add some default labels
	// When no labels are added labels will be generated in ENG
	'labels' 		=> $labels,
	'meta_box_cb' 	=> false,
    'rewrite' => [
        'slug' => '%post_type%'
    ]

));

function surgery_day_taxonomy_link_filter( $url, $term, $taxonomy ) {

    if($taxonomy == 'surgery_day_type') {
		$post_type_object = get_post_type_object('surgery_day');
		$slug = pll_translate_string($post_type_object->rewrite['slug'], pll_current_language());
        $url = str_replace('%post_type%', $slug, $url);
    }

    return $url;

}

add_filter('term_link', 'surgery_day_taxonomy_link_filter', 10, 3);

?>
