<?php
/*
Plugin Name: Faceland Review Scraper
Plugin URI: https://facelandclinic.com
Description: Scrape reviews
Author: Jasper Rooduijn (Rodesk BV)
Version: 1.0.3
Author URI: https://rodesk.com/
Text Domain: review-scraper
*/

use Rodesk\ReviewScraper\Admin\ScraperAdmin;
use Rodesk\ReviewScraper\Scraper\Scrape;
use Rodesk\ReviewScraper\Parser\Parse;

// If this file is called directly, abort.
if(!defined('WPINC')) {die;}

define('BASE_PATH', plugin_dir_path(__FILE__));
define('BASE_URL', plugin_dir_url(__FILE__));

/**
 * Main scraper class
 * This class inits on 'plugins_loaded'
 * and loads the scrape and parse classes to be used
 * Both and admin action (with url param) and WP CLI option are added
 */
class ReviewScraper {

    var $scraper;

    var $parser;

    /**
     * Construct this class
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    function __construct() {

        // If ACF plugin is not installed, this plugin cannot be used
        if (!class_exists('ACF')) { return; }

        $this->scraper = new Scrape();
        $this->parser = new Parse();

        if(!empty($this->scraper) && !empty($this->parser)) {
            $this->initAdmin();
            $this->initCli();
        }
    }

    /**
     * Init class by using singleton instance of own class
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    public static function init() {
        $class = __CLASS__;
        new $class;
    }

    /**
     * Init the scraper admin class
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    public function initAdmin() {
        $scraperAdmin = new ScraperAdmin($this->scraper, $this->parser);
    }

    /**
     * Add WP CLI to init the scraper with a CLI command
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return void
     */
    public function initCli() {
        if ( defined( 'WP_CLI' ) && WP_CLI ) {
            // @TODO add location param to scrape single location CLI
            WP_CLI::add_command( 'scrape_reviews', 'Rodesk\ReviewScraper\Cli\ScraperCLI' );
        }
    }
}

add_action('plugins_loaded', ['ReviewScraper', 'init']);
