<?php

$labels = array(
	'name'               => _x( 'Campaigns', 'post type general name', 'faceland' ),
	'singular_name'      => _x( 'Campaign', 'post type singular name', 'faceland' ),
	'menu_name'          => _x( 'Campaigns', 'admin menu', 'faceland' ),
	'name_admin_bar'     => _x( 'Campaigns', 'add new on admin bar', 'faceland' ),
    'add_new'            => _x( 'Add new', 'book', 'faceland' ),
    'add_new_item'       => __( 'Add new', 'faceland' ),
    'new_item'           => __( 'New', 'faceland' ),
    'edit_item'          => __( 'Edit', 'faceland' ),
    'view_item'          => __( 'View', 'faceland' ),
    'all_items'          => __( 'All campaigns', 'faceland' ),
    'search_items'       => __( 'Search', 'faceland' ),
    'parent_item_colon'  => __( 'Parents:', 'faceland' ),
    'not_found'          => __( 'Not found.', 'faceland' ),
    'not_found_in_trash' => __( 'Not found in trash.', 'faceland' )
);

// Register post types
// For more info see rokit_register_posttype() function
rokit_register_posttype( 'campaign', array(

	// Add some default labels
	// When no labels are added labels will be generated in ENG
	'labels'        => $labels,
    'has_archive' => 'campagnes',
    'menu_icon'     => 'dashicons-megaphone'

));
