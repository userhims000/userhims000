<?php

namespace Rodesk\ReviewScraper\Scraper;

use Goutte\Client;

/**
 * Scraper base class
 */
class ScraperBase {

    var $client;

    static $baseUrl = 'https://www.kliniekervaringen.nl/';

    /**
     * Construct this class
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   Client   $client    Guzzle client object
     * @return  void
     */
    function __construct(Client $client) {
        $this->client = $client;
    }

    /**
     * Build a valid URL from a passes path
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   string   $path       String with URL path
     * @return  string               String with modified URL path
     */
    protected static function buildUrl($path) {
        // Add trailing slash if needed
        $baseURl = rtrim(self::$baseUrl, '/') . '/';
        // Trim leading slash from path if needed
        $path = ltrim($path, '/');
        // Merge URL with path
        return $baseURl . $path;
    }

    /**
     * Get the review ID from the review URL
     * The last (base) part of the URL is used as the ID
     * This ID is used to check if review is already defined in DB
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   string   $url        String with URL path
     * @return  string               String with review ID
     */
    protected static function getReviewID($url) {
        return basename($url);
    }
}