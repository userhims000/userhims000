<?php

$labels = [
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
];

// Register taxonomy
// For more info see rokit_register_taxonomy() function
rokit_register_taxonomy( 'ba_album_taxonomy', 'ba_album', [

	// Add some default labels
	// When no labels are added labels will be generated in ENG
    'labels' => $labels,
    'rewrite' => [
        'slug' => '%post_type%'
    ]

]);

function ba_album_taxonomy_link_filter( $url, $term, $taxonomy, $lang = '', $needle = '') {

    if($taxonomy == 'ba_album_taxonomy') {
		$lang = empty($lang) ? pll_current_language() : $lang;
		$needle = empty($needle) ? '%post_type%' : $needle;
		$post_type_object = get_post_type_object('ba_album');
		$slug = pll_translate_string($post_type_object->rewrite['slug'], $lang);
        $url = str_replace($needle, $slug, $url);
    }

    return $url;

}
add_filter('term_link', 'ba_album_taxonomy_link_filter', 20, 3);

add_filter('pll_term_link', function($url, $lang, $term) {
	return ba_album_taxonomy_link_filter( $url, $term->slug, $term->taxonomy, $lang->slug );
}, 10, 3);
?>
