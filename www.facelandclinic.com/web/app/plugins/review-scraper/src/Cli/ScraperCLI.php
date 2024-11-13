<?php

namespace Rodesk\ReviewScraper\Cli;

use Rodesk\ReviewScraper\Scraper\Scrape;
use Rodesk\ReviewScraper\Parser\Parse;

use \WP_CLI as WP_CLI;

// This class can only run when WP_CLI is defined
if ( defined( 'WP_CLI' ) && WP_CLI ) {

    /**
     * Scraper CLI class
     * This class connect the WP CLI to the scraper
     */
    class ScraperCLI {

        var $scraper;

        var $parser;

        /**
         * 	Construct this class
         * 	@since   1.0.0
         * 	@author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
         *
         * 	@param   array    $args     Array with WP CLI arguments
         * 	@return  void
         */
        public function __construct() {
            $this->scraper = new Scrape();
            $this->parser = new Parse();
        }

        /**
         * 	Run the review scraper to grab reviews and inject them into database
		 *
		 * ## OPTIONS
		 *
		 * [--location=<location>]
		 * : Whether to load a specific location. This name can be grabbed from the location URL on the review website
		 *
		 * [--post_status=<post_status>]
		 * : The post status of the posts that should be injected into the WP database
		 *
		 * ## EXAMPLES
		 *
		 *  wp scrape_reviews --location=faceland-barendrecht-947
		 *  wp scrape_reviews --post_status=draft
         *
         *
         * 	@since   1.0.0
         * 	@author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
         * 	@param   array    $args          Array with WP CLI arguments
         * 	@param   array    $assoc_args    Array with associated WP CLI arguments
         * 	@return  void
         */
        public function __invoke(array $args = [], array $assoc_args = []) {

            $location = !empty($assoc_args['location']) ? [$assoc_args['location']] : [];
            $status = !empty($assoc_args['post_status']) ? $assoc_args['post_status'] : 'draft';

            $this->reviews = $this->scraper->run($location);

            if(is_countable($this->reviews)) {
                $countAdded = $this->parser::run($this->reviews, $status);
            }

            // give output
            $message = sprintf("Done processing reviews! %s reviews processed", count($countAdded));


            $this->rodesk_fire_cronjob([
                'client'        => 'Faceland',
                'api'           => 'Review scraper',
                'host'          => 'https://www.facelandclinic.com',
                'message'       => $message,
            ]);

            WP_CLI::success($message);

        }

        /**
         * Send cron event to debug database.
         *
         * @param $data
         * @return bool based on of the cron event is fired in the cms
         */
        public function rodesk_fire_cronjob($data){
            $url = 'http://debug-buddy.rodeskstudio.nl/api/v1/addCronjob';

            $data['timestamp']  = date('d-m-Y H:i:s');
            if (empty($data['host'])){
                $data['host'] = !empty( $_SERVER['HTTP_HOST'] ) ? $_SERVER['HTTP_HOST'] : '';
            }

            $response = wp_remote_post( $url, array('body' => $data));

            if ( is_wp_error( $response ) ) {
                $data['error'] = $response->get_error_message();
                mail('joeri@rodesk.com', 'Een cron kon niet ingeschoten worden', json_encode($data));
                return false;
            }
            return true;
        }

    }

}
