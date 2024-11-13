<?php

// Set the namespace
namespace Rokit\Acf;

/**
 *
 * Rokit ACF editor class
 *
 * Class to load custom toolbars to the ACF Editor
 *
 * @author  Jasper Rooduijn
 * @since   1.0
 */

class Editor {

    /**
     * Define global toolbar variable
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    private $toolbars;

    /**
     * Contruct this class
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    public function __construct( array $toolbars ) {

        // Check if the ACF plugin is installed
        if( !is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
            throw new Exception('ACF plugin not installed. Please run composer install', 123);
        }

        // Define the toolbars for this class
        $this->toolbars = $toolbars;

        // Load custom toolbars to the ACF Editor
        add_filter('acf/fields/wysiwyg/toolbars', array($this, 'toolbars'));

    }

    /**
     * Load custom toolbars to the ACF Editor
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    public function toolbars( $toolbars ) {

        // Grab the custom toolbars
        $custom_toolbars = $this->toolbars;

        // Merge the default and custom toolbars
        $toolbars = array_merge( $toolbars, $custom_toolbars );

        return $toolbars;

    }

}

?>
