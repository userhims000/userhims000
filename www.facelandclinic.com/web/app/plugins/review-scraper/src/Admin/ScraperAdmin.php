<?php

namespace Rodesk\ReviewScraper\Admin;

use Rodesk\ReviewScraper\Scraper\Scrape;
use Rodesk\ReviewScraper\Parser\Parse;

/**
 * Admin class
 * This class handles all WP dashboard functionality
 */
class ScraperAdmin {

    var $reviews;

    var $parse;

    var $slug;

    /**
     * Construct this class
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @param   Scrape   $scraper  Link to the Scrape class object
     * @param   Parse    $parser   Link to the Parse class object
     * @return  void
     */
    public function __construct(Scrape $scraper, Parse $parser) {

        $this->scraper = $scraper;
        $this->parser = $parser;
        $this->slug = 'parse_reviews';

        add_action('admin_notices', [$this,'adminNotice']);
        add_action('admin_bar_menu', [$this, 'addMenuItem'], 999);
        add_action('admin_init', [$this, 'run']);

    }

    /**
     * Add a menu item to the WP dashboard admin bar
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    public function addMenuItem($wp_admin_bar) {
        if(current_user_can('manage_options')) {

            $url = wp_nonce_url(add_query_arg( $this->slug, 'scrape_reviews', admin_url()), '');

            $wp_admin_bar->add_node([
                'id'        => 'reviews',
                'title'     => 'Check reviews',
                'href'      => $url,
            ]);
        }
    }

    /**
     * Add a notice to the WP dashboard
     * Notice shows when some reviews are succesfully scraped and parsed
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    public function adminNotice() {

        if(!empty($_GET['parse_reviews_success'])) {
            $amount = !empty(!empty($_GET['amount'])) && is_numeric($_GET['amount']) ? $_GET['amount'] : 0;
            $message = sprintf(__('Done processing reviews! <strong>%s</strong> reviews processed', 'review-scraper'), $amount);
            echo sprintf('<div class="notice notice-success is-dismissible"><p>%s</p></div>', $message);
        }

    }
    
    /**
     * Runs the scraper
     * Only runs when a valid URL param and wp nonce are difined
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    public function run() {

        // Check if the correct URL param is defined
        if(empty($_GET[$this->slug]) || empty($_GET['_wpnonce'])) { return false; }

        // Check if the correct nonce is defined
        if(wp_verify_nonce($_GET['_wpnonce'],'scrape_reviews')) { return false; }

        // If both above apply, run the scraper
        $this->scrape();

    }

    /**
     * Scrape for reviews and inject them into the WP database
     * @since   1.0.0
     * @author  Jasper Rooduijn <jasper.rooduijn@rodesk.nl>
     *
     * @return  void
     */
    public function scrape() {

        // With this method a single location can be scraped
        // $this->reviews = $this->scraper->run(['faceland-barendrecht-947']);
        $this->reviews = $this->scraper->run();

        if(is_countable($this->reviews)) {
            $countAdded = $this->parser::run($this->reviews, 'draft');
        }

        $countReviews = is_countable($this->reviews) ? count($this->reviews) : 0;
        $countAdded = is_countable($countAdded) ? count($countAdded) : 0;

        // Add redirect
        $args = [ $this->slug . '_success' => 'true', 'amount' => $countAdded];
        wp_redirect(add_query_arg($args, admin_url()));

    }
}
