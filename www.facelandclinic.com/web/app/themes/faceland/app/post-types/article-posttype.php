<?php

$labels = array(
	'name'               => _x( 'Updates', 'post type general name', 'faceland' ),
	'singular_name'      => _x( 'Update', 'post type singular name', 'faceland' ),
	'menu_name'          => _x( 'Updates', 'admin menu', 'faceland' ),
	'name_admin_bar'     => _x( 'Updates', 'add new on admin bar', 'faceland' ),
    'add_new'            => _x( 'Add new', 'book', 'faceland' ),
    'add_new_item'       => __( 'Add new', 'faceland' ),
    'new_item'           => __( 'New', 'faceland' ),
    'edit_item'          => __( 'Edit', 'faceland' ),
    'view_item'          => __( 'View', 'faceland' ),
    'all_items'          => __( 'All updates', 'faceland' ),
    'search_items'       => __( 'Search', 'faceland' ),
    'parent_item_colon'  => __( 'Parents:', 'faceland' ),
    'not_found'          => __( 'Not found.', 'faceland' ),
    'not_found_in_trash' => __( 'Not found in trash.', 'faceland' )
);

// Register post types
// For more info see rokit_register_posttype() function
rokit_register_posttype( 'article', array(

	// Add some default labels
	// When no labels are added labels will be generated in ENG
	'labels'        => $labels,
    'has_archive'   => 'nieuws/updates',
    'menu_icon'     => 'dashicons-media-document',

    'admin_cols' => array(
		'taxonomy' => array(
			'taxonomy' => 'article_taxonomy'
        ),
        'published' => array(
			'title'       => 'Published',
			'post_field'  => 'post_date',
			'date_format' => 'd/m/Y H:i:s'
        ),
    ),
    'supports'     => ['comments', 'title'],
    'rewrite' => array(
		'permastruct' => '%article_slug%/%article_taxonomy%/%article%'
	),

));
