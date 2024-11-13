<?php

namespace Rodesk\ReviewScraper\Parser;

/**
 * Parse reviews class
 * This class parses review data and inserts it into the WP database
 */
class Reviews {

    static $regularFields = [
        'review_title'      => 'field_5d1b6f253113a',
        'review_grade'      => 'field_5d1b6f313113b',
        'review_date'       => 'field_5d1b6eec31138',
        'review_name'       => 'field_5d1b6f0f31139',
        'review_text'       => 'field_5e282f758ae03',
        'review_url'        => 'field_5d1cbc889d3e0',
        'review_id'         => 'field_5d1cbca59d3e1',
        'review_location'   => 'field_5d1b6f443113c',
        'review_treatment'  => 'field_5d1b6f663113e',
        'review_specialist' => 'field_5d1b6f563113d'
    ];

    static $mappedFields = [
        'review_location' => [
            'controller'=> 'Rokit\Controllers\Collections\LocationCollection',
            'field'     => 'location_panorama_titles_title',
        ],
        'review_treatment' => [
            'controller'=> 'Rokit\Controllers\Collections\TreatmentCollection',
            'field'     => 'treatment_panorama_titles_title',
        ],
        'review_specialist' => [
            'controller'=> 'Rokit\Controllers\Collections\SpecialistCollection',
            'field'     => 'specialist_full_name',
        ]
    ];

    /**
     * Get ID's of existing review in database
     * This prevents reviews from getting interted while already existing
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  array   Array of review ID's
     */
    public static function getExistingReviews() {

        global $wpdb;

        $dbReviewIds = $wpdb->get_results("SELECT meta_value FROM rodesk_postmeta WHERE meta_key = 'review_id'");

        if(!empty($dbReviewIds) && is_iterable($dbReviewIds)){
            return array_column($dbReviewIds,'meta_value');
        }

        return [];

    }

    /**
     * Insert multiple reviews to the database
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   array   $reviews    Array of multiple reviews to be inserted
     * @param   array   $status     Status of the the post when inserted
     * @return  array               Array of review ID's that where inserted
     */
    public static function addMultiple(array $reviews, $status = 'draft') {

        $added = [];

        array_walk($reviews, function($review) use ($status, &$added) {
            $added[] = self::add($review, $status);
        });

        return $added;

    }

    /**
     * Insert a single review to the database
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   array   $review     Array of single reviews to be inserted
     * @param   array   $status     Status of the the post when inserted
     * @return  int|false           Post ID of the inserted post or false
     */
    public static function add(array $review, $status = 'draft') {

        // Define review title to use for custom title field
        $title = $review['review_title'];
        // Define review title to use for WP title (use shorter version here)
        $short_title = !empty($title) && strlen($title) > 40 ? substr($title,0,40).'...' : $title;

        // Define settings for the new post to be added
        $args = [
            'post_title'  => $short_title,
            'post_type'   => 'review',
            'post_status' => $status
        ];
        
        // Insert new post and check if new post is inserted
        if(!empty($new_post = wp_insert_post($args))) {

            $regularFields = self::$regularFields;
            $mappedFields = self::$mappedFields;


            // Map all data in the review and save it to custom fields
            array_walk($review, function($value, $key) use ($regularFields, $mappedFields, $new_post) {

                // Check if field key is defined in list of regular fields
                if(array_key_exists($key, $regularFields)) {

                    // Check if value needs to be mapped (Location, Treatment, Specialist)
                    // For these types we try to find a mathing relation with existing content
                    if(array_key_exists($key, $mappedFields)) {
                        $value = self::mapField($key, $value);
                    }

                    // Update field data
                    update_field($regularFields[$key], $value, $new_post);
                }
            });

            return $new_post;

        }

        return false;

    }

    /**
     * Insert a single review to the database
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   string   $key     Key of the custom field to be mapped
     * @param   string   $value   Value of the custom field to be mapped
     * @return  string            Modified (and mapped) value
     */
    public static function mapField($key, $value) {

        // Check if key is defined in mappedFields array
        if(empty($mappedField = static::$mappedFields[$key])) { return; }

        // Grab controller and field data from mappedFields array
        $controller = $mappedField['controller'];
        $field = $mappedField['field'];

        // Check if controller exists
        if(method_exists($controller,'all')) {

            // Get all posts from controller
            $posts = $controller::all();
            $posts = !empty($posts) ? $posts : [];

            // Split array to field data only
            $posts = array_column($posts, $field, 'ID');

            // Check if any match can be found between value and controller data
            return array_search($value, $posts);

        }

        return $value;

    }
}