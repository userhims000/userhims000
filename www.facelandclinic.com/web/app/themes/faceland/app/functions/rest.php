<?php

/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP actions.php file
    This is the rokit theme Rest API functions file

-----------------------------------------------------------------------------------*/

function rokit_rest_url( $endpoint ) {
    return home_url() . '/wp-json/rokit/v2/' . $endpoint;
}

/**
 * Add Custom REST API endpoint for requesting course info
 */
add_action( 'rest_api_init', function() {
    // Register services endpoint
    register_rest_route( 'rokit/v2', '/menu', [
        'methods' => 'GET',
        'callback' => 'rokit_get_rest_menu',
    ]);

});

/**
 * Get array with all urls.
 *
 * @return string[][]
 */
function rokit_get_rest_menu() {

    return [
        [
            'slug'  => 'nl',
            'name'  => 'Nederland',
            'url'   => 'https://www.facelandclinic.com/nl/',
        ],
        [
            'slug'  => 'de',
            'name'  => 'Deutschland',
            'url'   => 'https://www.facelandclinic.com/de/betreibergesellschaft/',
        ],
        [
            'slug'  => 'be',
            'name'  => 'België',
            'url'   => 'https://www.facelandclinic.com/be/',
        ],
        [
            'slug'  => 'ch',
            'name'  => 'Schweiz',
            'url'   => 'https://www.facelandclinic.com/ch/',
        ]
    ];

}
