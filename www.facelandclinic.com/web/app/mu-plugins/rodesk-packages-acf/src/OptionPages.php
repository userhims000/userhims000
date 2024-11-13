<?php

// Set the namespace
namespace Rokit\Acf;

/**
 *
 * Rokit ACF options Class
 *
 * Class to load custom ACF options pages and subpages
 *
 * @author  Jasper Rooduijn
 * @since   1.0
 */

class OptionPages {

    /**
     * Define global options variable
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    private $options;

    /**
     * Contruct this class
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    public function __construct( array $options ) {

        // Check if the ACF plugin is installed
        if( !is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
            throw new Exception('ACF plugin not installed. Please run composer install', 123);
        }

        // Define the options for this class
        $this->options = $options;

        // Parse the passed option pages
        $this->parse_option_pages();

    }

    /**
     * Parse the passed option pages
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    private function parse_option_pages() {

        if( !empty( $this->options['pages'] ) ) {
            foreach( $this->options['pages'] as $page ) {
                $this->add_option_page( $page );
            }
        }

        if( !empty( $this->options['subpages'] ) ) {
            foreach( $this->options['subpages'] as $page ) {
                $this->add_option_subpage( $page );
            }
        }

    }

    /**
     * Add ACF option page
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     *
     * @param   array     $options    Array of options for this page
     */

    private function add_option_page( $page ) {
        if( function_exists( 'acf_add_options_page' ) ) {
            acf_add_options_page( $page );
        }
    }

    /**
     * Add ACF option subpage
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     *
     * @param   array     $subpage    Array of options for this subpage
     */

    private function add_option_subpage( $subpage ) {
        if( function_exists( 'acf_add_options_sub_page' ) ) {
            acf_add_options_sub_page( $subpage );
        }
    }

}

?>
