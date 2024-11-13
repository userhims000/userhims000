<?php

namespace Rodesk\ReviewScraper\Scraper;

use Goutte\Client;
use Rodesk\ReviewScraper\Scraper\ScraperBase;
use Jenssegers\Date\Date;

/**
 * Review scraper class
 * this class scrapes a specific review page to grag all review data
 */
class Review extends ScraperBase {

    var $reviewLink;

    var $review;

    /**
     * Construct this class
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    function __construct(Client $client, $review) {
        $this->client = $client;
        $this->reviewLink = $review;
    }

    /**
     * Scrape a specific review page to grab all review data
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  array   Array with review data
     */
    public function scrape() {

        $types  = [];

        // Crawl the specific review page
        $crawler = $this->client->request('GET', $this->reviewLink);

        // Get the review ID from the URL
        $id = self::getReviewID($this->reviewLink);

        // Set a specific date format and language
        // Uses Jenssegers\Date\Date for easy date formatting
        Date::setLocale('nl');
        $date = Date::createFromFormat('d F Y', $crawler->filter('h3')->text());
        $date = $date->format('Ymd');

        // Grag the review username
        $name   = preg_replace(['/<span\b[^>]*>(.*?)<\/span>/i'], '', $crawler->filter('.profile-holder .user')->html());
        $name   = str_replace(' ', '', $name);

        // Grab the review title
        $title  = str_replace(['“','”'],'',$crawler->filter('.reviewTitle')->text());

        // Grab the review title
        $text   = preg_replace( "/\r|\n/", '', $crawler->filter('.contentWrapper p')->text());

        // Grab the review grade
        $grade  = $crawler->filter('.circleScore')->text();
        $grade = $grade == '10' ? '100' : $grade;

        // Grab and parse other review data (location, specialist, treament)
        $crawler->filter('.review-detail-p-xs, .review-detail-p')->each(function ($node) use (&$types) {

            $text = $node->text();

            if(strpos($text, 'Kliniek') !== false) {
                $location = str_replace('Kliniek:', '', $text);
                $location = $this->cleanString($location);
                $types['location'] = $location;
            }

            if(strpos($text, 'Specialist') !== false) {
                $specialist = str_replace('Specialist: ', '', $text);
                $specialist = preg_replace('/\([^)]+\)/','',$specialist);
                $specialist = $this->cleanString($specialist);
                $types['specialist'] = $specialist;
            }

            if(strpos($text, 'Behandeling') !== false) {
                $treatment = str_replace('Behandeling:', '', $text);
                $treatment = $this->cleanString($treatment);
                $types['treatment'] = $treatment;
            }

        });

        // Build custom review data bases on crawl data
        $this->review = [
            'review_url'   => $this->reviewLink,
            'review_id'    => $id,
            'review_title' => $title,
            'review_grade' => $grade,
            'review_date'  => $date,
            'review_name'  => $name,
            'review_text'  => $text
        ];

        if(!empty($types['specialist'])) {
            $this->review['review_specialist'] = $types['specialist'];
        }

        if(!empty($types['treatment'])) {
            $this->review['review_treatment'] = $types['treatment'];
        }

        if(!empty($types['location'])) {
            $this->review['review_location'] = $types['location'];
        }

        return $this->review;

    }

    /**
     * Clean a string (remove linebreaks and spaces)
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   string   $string  String to be cleaned
     * @return  string            Cleaned string
     */
    private function cleanString($string) {

        // Remove enters and linebreaks from string
        $string = preg_replace( "/\r|\n/", '', $string);

        // Remove whitespace from the begin/end of string
        $string = trim($string);

        return $string;

    }

}
