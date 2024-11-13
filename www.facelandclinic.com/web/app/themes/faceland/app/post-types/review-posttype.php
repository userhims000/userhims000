<?php

$labels = array(
	'name'               => _x( 'Reviews', 'post type general name', 'faceland' ),
	'singular_name'      => _x( 'Review', 'post type singular name', 'faceland' ),
	'menu_name'          => _x( 'Reviews', 'admin menu', 'faceland' ),
	'name_admin_bar'     => _x( 'Reviews', 'add new on admin bar', 'faceland' ),
    'add_new'            => _x( 'Add new', 'book', 'faceland' ),
    'add_new_item'       => __( 'Add new', 'faceland' ),
    'new_item'           => __( 'New', 'faceland' ),
    'edit_item'          => __( 'Edit', 'faceland' ),
    'view_item'          => __( 'View', 'faceland' ),
    'all_items'          => __( 'All reviews', 'faceland' ),
    'search_items'       => __( 'Search', 'faceland' ),
    'parent_item_colon'  => __( 'Parents:', 'faceland' ),
    'not_found'          => __( 'Not found.', 'faceland' ),
    'not_found_in_trash' => __( 'Not found in trash.', 'faceland' )
);

// Register post types
// For more info see rokit_register_posttype() function
rokit_register_posttype( 'review', array(

	// Add some default labels
	// When no labels are added labels will be generated in ENG
	'labels'        => $labels,
    'menu_icon'     => 'dashicons-admin-comments',
    'has_archive'           => false,
    'publicly_queryable'    => false,

    'admin_cols' => array(
		'location' => array(
            'title'     => 'Location',
            'relation'  => 'review_location'
        ),
        'treatment' => array(
            'title'     => 'Treatment',
            'relation'  => 'review_treatment'
        ),
        'specialist' => array(
            'title'     => 'Specialist',
            'relation'  => 'review_specialist'
        ),
        'published' => array(
			'title'       => 'Published',
			'post_field'  => 'post_date',
			'date_format' => 'd/m/Y H:i:s'
        ),
    ),

    'admin_filters' => array(
        'month' => false,
        'seo' => false,
        'review_location' => array(
            'title'     => 'Select location',
            'meta_key' => 'review_location',
            'options_callback' => 'rodesk_review_filter',
            'value_as_key' => false
        ),
        'review_treatment' => array(
            'title'     => 'Select treatment',
            'meta_key' => 'review_treatment',
            'options_callback' => 'rodesk_review_filter',
            'value_as_key' => false
        ),
        'review_specialist' => array(
            'title'     => 'Select specialist',
            'meta_key' => 'review_specialist',
            'options_callback' => 'rodesk_review_filter',
            'value_as_key' => false
        )
    )

));

/**
 * Format review filter options
 *
 * @param   array   $options    Options for this filter
 * @param   string  $meta_key   The meta key of the custom field to be filtered
 * @return  void
 */
function rodesk_review_filter($options = [], $meta_key = '') {

    $formatted_options = [];

    if($meta_key == 'review_location') {
        $field = 'location_panorama_titles_title';
    } elseif($meta_key == 'review_treatment') {
        $field = 'treatment_panorama_titles_title';
    } elseif($meta_key == 'review_specialist') {
        $field = 'specialist_full_name';
    }

    if(!empty($field) && is_array($options)) {
        array_map(function($post_id) use (&$formatted_options, $field){
            $formatted_options[$post_id] = get_post_meta($post_id, $field, true);
        }, $options);
    }

    return $formatted_options;

}