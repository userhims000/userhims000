<?php

$labels = array(
    'name'               => _x( 'Surgery Days', 'post type general name', 'faceland' ),
    'singular_name'      => _x( 'Surgery Day', 'post type singular name', 'faceland' ),
    'menu_name'          => _x( 'Surgery Days', 'admin menu', 'faceland' ),
    'name_admin_bar'     => _x( 'Surgery Day', 'add new on admin bar', 'faceland' ),
    'add_new'            => _x( 'Add new', 'book', 'faceland' ),
    'add_new_item'       => __( 'Add new', 'faceland' ),
    'new_item'           => __( 'New', 'faceland' ),
    'edit_item'          => __( 'Edit', 'faceland' ),
    'view_item'          => __( 'View', 'faceland' ),
    'all_items'          => __( 'All Surgery Days', 'faceland' ),
    'search_items'       => __( 'Search', 'faceland' ),
    'parent_item_colon'  => __( 'Parents:', 'faceland' ),
    'not_found'          => __( 'Not found.', 'faceland' ),
    'not_found_in_trash' => __( 'Not found in trash.', 'faceland' )
);

// Register post types
// For more info see rokit_register_posttype() function
rokit_register_posttype( 'surgery_day', array(

    // Add some default labels
    // When no labels are added labels will be generated in ENG
    'labels' => $labels,
    'has_archive' => 'surgery-days',
    'menu_icon'    => 'dashicons-portfolio',

    'admin_cols' => array(
		'taxonomy' => array(
            'title' => 'Type',
            'taxonomy' => 'surgery_day_type'
        ),
        'published' => array(
			'title'       => 'Published',
			'post_field'  => 'post_date',
			'date_format' => 'd/m/Y'
        )
    ),

	'admin_filters' => array(
        'month' => false,
        'seo' => false,
		'taxonomy' => array(
			'title'    => 'Type',
			'taxonomy' => 'surgery_day_type',
		),
	),

	'rewrite' => array(
		'permastruct' => '%surgery_day_slug%/%surgery_day_type%/%surgery_day%'
	),

));
