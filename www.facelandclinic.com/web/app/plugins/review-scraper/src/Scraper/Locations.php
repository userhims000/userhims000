<?php

namespace Rodesk\ReviewScraper\Scraper;

use Rodesk\ReviewScraper\Scraper\ScraperBase;

/**
 * Loaction Scraper class
 * This class scrapes the list of locations from kliniekervaringen.nl
 * and returns them when the 'run' method is called
 */
class Locations extends ScraperBase {

    var $locations = [];

    /**
     * Scrapes the list of locations from kliniekervaringen.nl
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   array    $locations     Array with predefined location names
     * @return  array                   Array with all the location data
     */
    public function scrape(array $locations = []) {

        // Get all (or predefied) location set
        $this->get($locations);

        // Count the reviews per location
        $this->getCount();

        // Define all the pages with reviews per location
        $this->getPages();

        // Return array with dataset of locations
        return $this->locations;

    }

    /**
     * Scrape locations from kliniekervaringen.nl
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   array   $locations  Array of location names to be scraped
     * @return  array               Array of all requested reviews
     */
    private function get(array $locations = []) {

        // Call to the main location page
        // Find all locations and loop them
        $this->client->request('GET', self::buildUrl('/organisatie/faceland-33'))->filter('.emp .title > a')->each(function ($node) use($locations) {

            // Get the location URL
            $href = $node->attr('href');
            // Generate location pages URL
            $locationUrl = $this->buildUrl($href . '/ervaringen');
            // Generate the location basename
            $locationName = basename($href);

            // If a predefined location is gives only scrape the specified location
            if(!empty($locations) && array_search($locationName, $locations) === false) {
                return;
            }

            // Define an array with location data
            $this->locations[$locationName] = [
                'name' => $locationName,
                'url' => $locationUrl
            ];

        });

        return $this->locations;

    }

    /**
     * Count the reviews per location
     * Scrape a specific location page and search for amount of reviews
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  array   Array of all locations with review count
     */
    private function getCount() {

        if(empty($this->locations)) { return; }

        array_walk($this->locations, function($location) {
            if(!empty($location['url']) && !empty($location['name'])) {
                $this->client->request('GET', $location['url'])->filter('.total .scoreWrapper .reviews-xs')->each(function ($node) use ($location) {
                    $this->locations[$location['name']]['count'] = (int) $node->text();
                });
            }
        });

        return $this->locations;

    }

    /**
     * Define all the pages with reviews per location
     * Scrape a specific location page and search for amount of reviews
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  array   Array of all locations with reviewpages
     */
    private function getPages() {

        if(empty($this->locations)) { return; }

        array_walk($this->locations, function($location, $key) {

            // Count the amount of pages needed
            $pages = !empty($location['count']) ? ceil((int) $location['count'] / 10) : 0;

            // Add pages information to locations
            $this->locations[$key]['page_amount'] = $pages;

            // Loop other pages and add them to list
            for ($i = 1; $i <= $pages; $i++) {

                // Add the page URL to the list of pages
                $locationReviewUrl = $this->locations[$key]['url'];
                $this->locations[$key]['pages'][] = $i == 1 ? $locationReviewUrl : sprintf('%s/%s', $locationReviewUrl, $i);

            }

        });

        return $this->locations;

    }
}
