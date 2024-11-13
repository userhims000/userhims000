<?php

namespace Rokit\Frame\Seo;

use RodeskWP\Timber\Archives\Archive;

class RokitSeo {

    function __construct( $type = 'single' ) {

        if( !function_exists( 'rokit_timber_type_class' ) || !function_exists( 'rokit_timber_collection_class' ) ) {
            return;
        }

        $this->type = $type;

        // Get the correct post or collection (archive) controller
        if( $this->type == 'single' ) {

            $postClass = rokit_timber_type_class();
            $this->controller = new $postClass();

        } else {

            $collectionClass = rokit_timber_collection_class();
            $this->controller = new $collectionClass();

        }

        // Run some filter on the Yoast SEO plugin
        add_filter( 'wpseo_metadesc', array ($this, 'wpseo_metadesc_filter') );
        add_filter( 'wpseo_opengraph_desc', array ($this, 'wpseo_metadesc_filter') );
        add_filter( 'wpseo_twitter_image', array($this, 'wpseo_image_filter'), 100, 1 );
        add_filter( 'wpseo_opengraph_image', array($this, 'wpseo_image_filter'), 100, 1 );

    }

    function  wpseo_metadesc_filter( $metadesc ) {

        if( !empty( $metadesc ) ) {
            $this->metadesc = $metadesc;
        } else {
            if( $this->type == 'single' ) {
                $controllerDesc = $this->controller->seo_description;
            } else {
                $controllerDesc = $this->controller->seo_description();
            }

            if( !empty( $this->metadesc ) && !empty( $controllerDesc ) ) {
                $this->metadesc = strip_tags( rokit_truncate( $controllerDesc, '156' ) );
            } else {
                $this->metadesc = ' ';
            }
        }

        return $this->metadesc;
    }

    function  wpseo_image_filter( $image ) {

        if( $this->type == 'single' ) {
            $controllerImage = $this->controller->seo_image;
        } else {
            $controllerImage = $this->controller->seo_image();
        }

        if( !empty( $controllerImage ) ) {
            $image = $controllerImage;
        }

        return $image;
    }
}
