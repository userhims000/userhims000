<?php
/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP functions.php file
    This is the main rokit theme functions file

-----------------------------------------------------------------------------------*/

/**
 * Define the required inclusion files for Rokit
 *
 * This array determines the code library included in this theme.
 * Add or remove files to the array as needed. Supports child theme overrides.
 */

$rokit_includes = [

    // Include all global setup files
    'functions/helpers.php',
    'functions/setup.php',
    'functions/filters.php',
    'functions/actions.php',
    'functions/scripts.php',
    'functions/logs.php',
    'functions/routes.php',
    'functions/seo.php',
    'functions/acf-bidirectional.php',
    'functions/search-functions.php',
    'functions/comment-functions.php',
    'functions/rokit-cli.php',
    'functions/rest.php',

    // Include theme specific function
    'functions/template-functions.php',
    'functions/migration-functions.php',

    // Include custom post types
    'post-types/treatment-posttype.php',
    'post-types/specialist-posttype.php',
    'post-types/location-posttype.php',
    'post-types/faq-posttype.php',
    'post-types/ba-posttype.php',
    'post-types/last-minutes-posttype.php',
    'post-types/ba-album-posttype.php',
    'post-types/surgery-day-posttype.php',
    'post-types/academy-posttype.php',
    'post-types/brand-posttype.php',
    'post-types/review-posttype.php',
    'post-types/video-posttype.php',
    'post-types/article-posttype.php',
    'post-types/offer-posttype.php',
    'post-types/blog-posttype.php',
    'post-types/campaign-posttype.php',
    'post-types/price-posttype.php',

    // Include custom taxonomies
    'taxonomies/treatment_bodypart-taxonomy.php',
    'taxonomies/surgery_day_type-taxonomy.php',
    'taxonomies/treatment_type-taxonomy.php',
    'taxonomies/price_type-taxonomy.php',
    'taxonomies/faq_taxonomy.php',
    'taxonomies/faq_topic_taxonomy.php',
    'taxonomies/location_country_taxonomy.php',
    'taxonomies/video_playlist-taxonomy.php',
    'taxonomies/article-taxonomy.php',
    'taxonomies/blog_article-taxonomy.php',
    'taxonomies/ba_album-taxonomy.php',
    'taxonomies/surgery_day_type-taxonomy.php',


    // Include custom tags
    'taxonomies/article-tag.php',
    'taxonomies/blog_article-tag.php',

];

/**
 * Helper function for prettying up errors
 * This cannot be placed in helper functions file
 * Because it is the first thing that needs to be loaded
 *
 * @param string    $message    The message of this error
 * @param string    $subtitle   The subtitle of this error
 * @param string    $title      The title of this error
 */

function rokit_error( $message, $subtitle = '', $title = '' ) {

    $title      = $title ?: __('Rokit &rsaquo; Error', 'rokit');
    $footer     = '<a href="https://git.rodesk.nl/rodesk-wp-plugins/rokit-wp-theme">https://git.rodesk.nl/rodesk-wp-plugins/rokit-wp-theme</a>';
    $message    = "<h1>{$title}</h1><h2><br><small>{$subtitle}</small></h2><p>{$message}</p><p>{$footer}</p>";

    // Send the message to the browser
    wp_die($message, $title);

};

/**
 * Ensure compatible version of PHP is used
 * This version of Rokit works with min PHP 5.6
 */

if( version_compare('5.6', phpversion(), '>=') ) {
    rokit_error(__('You must be using PHP 5.6 or greater.', 'rokit'), __('Invalid PHP version', 'rokit' ) );
}

/**
 * Ensure compatible version of WordPress is used
 * This version of Rokit works with min Wp 4.7.0
 */

if( version_compare('4.7.0', phpversion(), '>=') ) {
    rokit_error(__('You must be using WordPress 4.7.0 or greater', 'rokit'), __('Invalid WordPress version', 'rokit' ) );
}

/**
 * Ensure composer dependencies are loaded
 * This version of Rokit heavily relies on Composer
 *
 * First check if the container class can be found
 * If not load try to load the Composer autoloader
 */

if( !class_exists('Rokit\\Container\\Container') ) {
    // Check if the composer autoload script is found
    if( !file_exists($composer = __DIR__.'/../vendor/autoload.php') ) {
        rokit_error(
            __('You must run <code>composer install</code> from the Rokit theme directory.', 'rokit'),
            __('Composer autoloader not found', 'rokit' )
        );

    }

    // Load composer
    require_once $composer;
}

/**
 * Include all files from the $rokit_includes array
 */

array_map( function ($file) {

    $file = "../app/{$file}";

    // Check if file is found
    if( !locate_template($file, true, true) ) {

        // If file is not found return error
        rokit_error(
            sprintf( __('Error locating <code>%s</code> for inclusion.', 'rokit'), $file ),
            __('File not found', 'rokit' )
        );
    }

}, $rokit_includes );

/**
 * We need to run this early. Before all other theme functions
 *
 * Here's what's happening with these hooks:
 * 1. WordPress detects theme in themes/themename
 * 2. When we activate, we tell WordPress that the theme is actually in themes/themename/templates
 * 3. When we call get_template_directory() or get_template_directory_uri(), we point it back to themes/themename/resources
 *
 * We do this so that the Template Hierarchy will look in themes/themename/templates for core WordPress themes
 * But functions.php, style.css, and index.php are all still located in themes/themename/resources
 *
 */

add_filter('template', function ($stylesheet) {
    return dirname($stylesheet);
});

add_action('after_switch_theme', function () {
    $stylesheet = get_option('template');
    if (basename($stylesheet) !== 'templates') {
        update_option('template', $stylesheet . '/templates');
    }
});

add_action ( 'wp_head', 'head_custom_data' );
function head_custom_data() {
}

