<?php

namespace Rokit\Frame\Setup;

use Timber\Timber;
use Exception;

use Rokit\Config\Config;
use Rokit\Controllers\Site\RokitSite;
use Rokit\Assets\JsonManifest;
use Rokit\Acf\JsonFields;
use Rokit\Acf\Editor;
use Rokit\Acf\OptionPages;

/**
 * Init the global Rokit setup class
 */

class RokitSetup {

    /**
     * Setup Rokit theme
     */

    public static function setup() {

        self::config();            // Bootstrap the config
        self::timber_init();       // Bootstrap the timber class
        self::timber_templates();  // Set a custom Timber template directory
        self::timber_setup();      // Setup RokitSite object for timber
        self::manifest_setup();    // Setup the JSON manifest object
        self::image_sizes();       // Setup the theme image sies
        self::textdomain();        // Setup the theme textdomain
	    self::register_menus();    // Register theme menus

        // Setup some default ACF settings
        new JsonFields( config('acf.custom_fields') );
        new Editor( config('acf.custom_toolbars') );
        new OptionPages( config('acf.options') );

    }

    /**
     * Bind the global settings to the container
     */

    public static function config() {

        rokit()->bindIf('config', function () {

            return new Config([
                'base'      => require dirname(__DIR__, 2) . '/config/base.php',
                'assets'    => require dirname(__DIR__, 2) . '/config/assets.php',
                'acf'       => require dirname(__DIR__, 2) . '/config/acf.php',
            ]);

        }, true);

    }

    /**
     * Add custom image sizes for use in theme
     */

     public static function image_sizes() {

        $sizes = config('base.sizes');

        if( !empty($sizes) && is_array($sizes)) {
            foreach ($sizes as $type => $type_sizes) {

                // Format the type name of the image sizes
                $type = $type == 'regular' ? '' : $type;

                // Loop image sizes and load them to WP
                if( is_array($type_sizes) ) {
                    foreach ($type_sizes as $size_name => $size_formats) {

                        if(!empty($type)) {
                            $size_name = $size_name . '-' . $type;
                        }

                        if(!empty($size_formats['width']) && !empty($size_formats['height'])) {
                            add_image_size($size_name, $size_formats['width'], $size_formats['height'], true);
                        }

                    }
                }

            }
        }

    }

    /**
     * Add custom textdomain for use in theme
     */

    public static function textdomain() {

        // Set the textdomain for this theme
        load_theme_textdomain( config('base.textdomain'), config('base.langauges_folder'));

    }

    /**
     * Bootstrap timber class
     * For Rokit theme we use the timber library
     * This way we can use twig templates in our theme
     *
     */

    public static function timber_init() {

        if ( ! class_exists( '\Timber\Timber' ) ) {

            // Throw error that Timber is not installed
            throw new Exception('Timber not activated. Rokit will not work without Timber.');

        } else {

            // Init Timber
            new Timber();
        }

    }

    /**
     * Set timber template dirctory
     */

    public static function timber_templates() {

        Timber::$dirname = array(config('base.timber_templates'));

    }

    /**
     * Setup RokitSite object for timber
     */

    public static function timber_setup() {

        // Setup a new insatance of the RokitSite object
        new RokitSite();

    }

    /**
     * Setup the JSON manifest object
     */

    public static function manifest_setup() {

        rokit()->singleton('rokit.assets', function () {
            return new JsonManifest( config('assets.manifest'), config('assets.uri') );
        });

    }

	/**
	 * Register nav menus.
	 */
    public static function register_menus() {

    	register_nav_menus(array(
    		'shop_navigation' => __( 'Shop navigation' ),
            'worldwide_navigation' => __( 'Worldwide navigation' ),
            'mobile_navigation' => __( 'Mobile navigation' )
	    ));

    }

}
