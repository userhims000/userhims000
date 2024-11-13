<?php

// Set the namespace
namespace Rokit\Acf;

/**
 *
 * Rokit ACF Merge Tabs Class
 *
 * Class to merge multile groups with tabs on the same page
 *
 * @author  Jasper Rooduijn
 * @since   1.0
 */

class MergeTabs {

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

        // Add the JS from merge_acf_tabs function to the admin_footer hook
        add_action('admin_footer', [ $this, 'merge_acf_tabs'] );

    }

    /**
     * Generate JS to merge all tabs in seperate groups to the same group
     * This script merges all postboxes containing "tab field" to the
     * first one and removes left empty wrappers.
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    public function merge_acf_tabs() {

        if( !empty( $this->options ) && is_array( $this->options ) ) {

            $screen = get_current_screen();

            foreach( $this->options as $option_key => $option_value ) {
                if ( $screen->base == $option_key ) {

                    echo '
                    <script>

                        var allowedBoxes = ' . json_encode( $option_value ) . ',
                            $boxes = jQuery("#postbox-container-2 .postbox .acf-field-tab").parent(".inside");

                        if ( $boxes.length > 1 ) {

                            var $firstBox = $boxes.first();

                            $boxes.not($firstBox).each(function(){

                                var postboxID = jQuery(this).parent(".postbox").attr("id");

                                // Check if the ID for this box is in the allowed boxes
                                if( allowedBoxes.indexOf( postboxID ) >= 0 ) {
                                    jQuery(this).children().appendTo($firstBox);
                                    jQuery(this).parent(".postbox").remove();
                                }

                            });

                        }

                    </script>';

                }
            }

        }

    }

}

?>
