<?php

namespace Rodesk\ReviewScraper\Scraper;

use Goutte\Client;
use Rodesk\ReviewScraper\Scraper\Locations;
use Rodesk\ReviewScraper\Scraper\Reviews;
use Rodesk\ReviewScraper\Scraper\Review;

/**
 * Scrape class
 * This class gets locations, reviewlinks and reviews
 * and returns them when the 'run' method is called
 */
class Scrape {

    var $client;

    var $locations;

    var $reviewLinks;

    var $reviews;

    /**
     * Construct this class
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    function __construct() {
        $this->client = $this->setClient();
    }

    /**
     * Set the Guzzle client to be used for requests
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  Client   Guzzle client object
     */
    private function setClient() {
        return new Client();
    }

    /**
     * Get all the reviews for the requested locations
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   array   $locations  Array of location names to be scraped
     * @return  array               Array of all requested reviews
     */
    public function run(array $locations = []) {

        $this->locations    = $this->getLocations($locations);
        $this->reviewLinks  = $this->getReviewLinks();
        $this->reviews      = $this->getReviews();

        return $this->reviews;

    }

    /**
     * Get all the requested locations
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   array   $locations  Array of location names to be parsed
     * @return  array               Array of all requested locations
     */
    public function getLocations(array $locations = []) {
        return (new Locations($this->client))->scrape($locations);
    }

    /**
     * Get all the review links for a predefined set of locations
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  array               Array of all requested review links
     */
    public function getReviewLinks() {

        if(empty($this->locations)) {
            throw new \Exception('No locations found to be scraped');
        }

        return (new Reviews($this->client, $this->locations))->scrape();
    }

    /**
     * Get all the reviews for a predefined set of review links
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  array               Array of all requested reviews
     */
    public function getReviews() {

        $reviews = [];

        array_walk($this->reviewLinks, function($reviewLink) use (&$reviews) {
            $reviews[] = (new Review($this->client, $reviewLink))->scrape();
        });

        return $reviews;

    }
}