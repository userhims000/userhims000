<?php

$labels = array(
	'name'                       => _x( 'Playlists', 'taxonomy general name', 'faceland' ),
	'singular_name'              => _x( 'Playlist', 'taxonomy singular name', 'faceland' ),
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
rokit_register_taxonomy( 'video_playlist', 'video', array(

	// Add some default labels
	// When no labels are added labels will be generated in ENG
	'labels' => $labels,
    'publicly_queryable' => false

));

?>
