<?php

$labels = array(
	'name'               => _x( 'Blogs', 'post type general name', 'faceland' ),
	'singular_name'      => _x( 'Blog', 'post type singular name', 'faceland' ),
	'menu_name'          => _x( 'Blogs', 'admin menu', 'faceland' ),
	'name_admin_bar'     => _x( 'Blogs', 'add new on admin bar', 'faceland' ),
    'add_new'            => _x( 'Add new', 'book', 'faceland' ),
    'add_new_item'       => __( 'Add new', 'faceland' ),
    'new_item'           => __( 'New', 'faceland' ),
    'edit_item'          => __( 'Edit', 'faceland' ),
    'view_item'          => __( 'View', 'faceland' ),
    'all_items'          => __( 'All blogs', 'faceland' ),
    'search_items'       => __( 'Search', 'faceland' ),
    'parent_item_colon'  => __( 'Parents:', 'faceland' ),
    'not_found'          => __( 'Not found.', 'faceland' ),
    'not_found_in_trash' => __( 'Not found in trash.', 'faceland' )
);

// Register post types
// For more info see rokit_register_posttype() function
rokit_register_posttype( 'blog_article', array(

	// Add some default labels
	// When no labels are added labels will be generated in ENG
	'labels'        => $labels,
    'has_archive' => 'nieuws/blog',
    'menu_icon'     => 'dashicons-images-alt2',

    'admin_cols' => array(
		'taxonomy' => array(
			'taxonomy' => 'blog_article_taxonomy'
        ),
        'published' => array(
			'title'       => 'Date',
			'post_field'  => 'post_date',
			'date_format' => 'd/m/Y H:i:s'
        ),
    ),
    'supports'     => ['comments', 'title'],
	'rewrite' => array(
		'permastruct' => '%blog_article_slug%/%blog_article_taxonomy%/%blog_article%'
	),

));
