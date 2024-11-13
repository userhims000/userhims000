<?php

// Set the namespace
namespace Rokit\Controllers\Collections;

// Include Timber objects
use Timber;
use TimberPost;

class ReviewCollection extends PostCollection {

    protected static $postType = 'review';

    protected static $postClass = 'Rokit\Controllers\Types\Review';

    var $_detail_titles;

    /**
     * Calculate the average grade of reviews.
     *
     * @param null|array $reviews if is null it gets all the reviews if is not empty it uses the array given
     * @return float|int average number of the grade of all reviews
     */
    public static function average_review(array $reviews) {
        if (!empty($reviews) && is_array($reviews)){

            $grades = array_map(function($review){ return $review->grade; }, $reviews);

            if (!empty($grades) && is_array($grades)){
                return round( array_sum($grades) / count($grades), 1);
            }
        }

        return 0;
    }

    /**
     * Get all reviews with the same treatment object als $post_id
     *
     * @param $post_id int id of the treatment
     * @return array with reviews
     */
    public static function reviews_by_treatment($post_id) {

        $args = [
            'meta_key' => 'review_date',
            'orderby' => 'meta_value_num',
            'order' => 'DESC',
            'meta_query' => [
                [
                    'key' => 'review_treatment',
                    'value' => $post_id,
                    'compare' => '='
                ]
            ]
        ];

        return self::query($args);

    }

    public static function detail_titles(){
        return [
            'title' => get_field(static::$postType . '_default_title', 'option'),
            'subtitle' => get_field(static::$postType . '_default_subtitle', 'option')
        ];
    }
}
