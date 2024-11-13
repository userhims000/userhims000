<?php

namespace Rodesk\ReviewScraper\Parser;

use Rodesk\ReviewScraper\Parser\Reviews;

/**
 * Parse class
 * This class parses any review data to prepare it for DB inclusion
 */
class Parse {

    var $reviews;

    var $status;

    /**
     * Run the reviews class to upload review data to database
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  array   Array with ID's of inserted WP posts
     */
    public static function run(array $reviews = [], $status = 'draft') {
        return Reviews::addMultiple($reviews, $status);
    }

}