<?php

// Set the namespace
namespace Rokit\Acf;

/**
 *
 * Rokit JsonFields class
 *
 * Class to load and save endpoints for ACF JSON customfields
 *
 * @author  Jasper Rooduijn
 * @since   1.0
 */

class JsonFields {

    /**
     * Define global path variable
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    private $path;

    /**
     * Contruct this class
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    public function __construct( $path ) {

        if (!class_exists('acf')){
            throw new Exception('ACF not installed', 123);
        }
        // Check if the ACF plugin is installed
        if( !is_plugin_active('advanced-custom-fields-pro/acf.php') ) {
            throw new Exception('ACF plugin not installed. Please run composer install', 123);
        }

        // Define the custom fields path for this class
        $this->path = $path;

        // Verify if the required path excists and is writable
        add_action('admin_init', array($this, 'verifyPath'));

        // Add load and save JSON endpoints for ACF
        add_filter('acf/settings/load_json', array($this, 'load'));
        add_filter('acf/settings/save_json', array($this, 'save'));

    }

    /**
     * Verify if the required path excists and is writable
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    public function verifyPath() {

        $path = $this->path;

        if (! is_dir($path)) {
            var_dump( "Create directory" );
            mkdir($path, 0775, true);
        }

    }

    /**
     * Add load JSON endpoints for ACF
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    public function load($paths) {

        unset($paths[0]);
        $paths[] = $this->path;
        return $paths;

    }

    /**
     * Add save JSON endpoints for ACF
     *
     * @since   1.0
     * @author  Jasper Rooduijn
     */

    public function save($path) {
        
         return $this->path;
    }

}

?>
