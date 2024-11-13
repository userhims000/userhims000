<?php

$labels = array(
	'name'               => _x( 'Prices', 'post type general name', 'faceland' ),
	'singular_name'      => _x( 'Price', 'post type singular name', 'faceland' ),
	'menu_name'          => _x( 'Prices', 'admin menu', 'faceland' ),
	'name_admin_bar'     => _x( 'Prices', 'add new on admin bar', 'faceland' ),
    'add_new'            => _x( 'Add new', 'book', 'faceland' ),
    'add_new_item'       => __( 'Add new', 'faceland' ),
    'new_item'           => __( 'New', 'faceland' ),
    'edit_item'          => __( 'Edit', 'faceland' ),
    'view_item'          => __( 'View', 'faceland' ),
    'all_items'          => __( 'All prices', 'faceland' ),
    'search_items'       => __( 'Search', 'faceland' ),
    'parent_item_colon'  => __( 'Parents:', 'faceland' ),
    'not_found'          => __( 'Not found.', 'faceland' ),
    'not_found_in_trash' => __( 'Not found in trash.', 'faceland' )
);

// Register post types
// For more info see rokit_register_posttype() function
rokit_register_posttype( 'price', array(

	// Add some default labels
	// When no labels are added labels will be generated in ENG
	'labels'        => $labels,
    'has_archive' => 'prijzen',
    'menu_icon'     => 'dashicons-images-alt2',

    'admin_cols' => array(
		'taxonomy' => array(
			'taxonomy' => 'price_type'
        ),
        'published' => array(
			'title'       => 'Date',
			'post_field'    => 'post_date',
			'date_format' => 'd/m/Y H:i:s'
        ),
    ),

	'rewrite' => array(
		'permastruct' => '%price_slug%/%price_type%/%price%'
	),

));
