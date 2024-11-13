<?php

namespace Rodesk\ReviewScraper\Scraper;

use Goutte\Client;
use Rodesk\ReviewScraper\Scraper\ScraperBase;
use Rodesk\ReviewScraper\Parser\Reviews as ReviewParser;

/**
 * Reviews scraper class
 * This class scrapes all review pages to find specific review page links
 */
class Reviews extends ScraperBase {

    var $locations = [];

    var $reviews = [];

    var $existingReviews = [];

    /**
     * Construct this class
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    function __construct(Client $client, array $locations) {
        $this->client = $client;
        $this->locations = $locations;
        $this->reviews = [];
        $this->existingReviews = ReviewParser::getExistingReviews();
    }

    /**
     * Scrape all location pages to get a list of page links for all reviews
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  array   Array with list of links for all pages
     */
    public function scrape() {

        // Loop all locations
        array_walk($this->locations, function($location) {

            // Return if no pages are defined for this location
            if(empty($location['pages'])) { return; }

            // Loop all pages for this location
            array_walk($location['pages'], function($page) {

                // Get the page URL and loop all reviews on the page
                $this->client->request('GET', $page)->filter('#reviewListing .review')->each(function ($node) {

                    // Get the review URL and build an ID from it
                    $reviewUrl = $this->buildUrl($node->filter('p > a')->attr('href'));
                    $reviewID = $this->getReviewID($reviewUrl);

                    // Check if the review ID is defined. If not add review.
                    if(!in_array($reviewID, $this->existingReviews)) {
                        $this->reviews[] = $reviewUrl;
                    }

                });

            });

        });

        return $this->reviews;

    }

}
