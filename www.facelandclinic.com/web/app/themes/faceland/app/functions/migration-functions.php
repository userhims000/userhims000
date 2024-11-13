<?php

/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP migration-functions.php file
    This is the theme specific migration functions file

-----------------------------------------------------------------------------------*/
/**
 * Programatically save all specialist post type items
 *
 * @return void
 */
function rokit_save_specialists() {

    if(empty($_GET['migrate_specialists']) || $_GET['migrate_specialists'] != 'true') {
        return;
    }

    $specialists = get_posts(['post_type' => 'specialist', 'posts_per_page' => '-1','lang' => '' ]);

    if(is_countable($specialists)) {
        foreach($specialists as $specialist) {
            wp_update_post(['ID' => $specialist->ID]);
        }
    }
    wp_die('Er zijn totaal ' . count($specialists) . ' specialisten bijgewerkt');

}

add_action('admin_init', 'rokit_save_specialists');

/**
 * migrate all data for a specific field, post_type, lang and value
 *
 * Example url https://faceland.test/cms/wp-admin/index.php?migrate_field_value=true&lang=nl&post_type=specialist&value=bignumbers&field=specialist_prefix_big_number
 */
function rokit_migrate_field_values() {
    if( !empty( $_GET["migrate_field_value"] ) && $_GET["migrate_field_value"] == true  ) {
        if( empty( $_GET["lang"] ) ) {
            var_dump('"lang" parameter is missing');
            exit;
        }

        if( empty( $_GET["field"] ) ) {
            var_dump('"field" parameter is missing');
            exit;
        }

        if( empty( $_GET["value"] ) ) {
            var_dump('"value" parameter is missing');
            exit;
        }

        if( empty( $_GET["post_type"] ) ) {
            var_dump('"post_type" parameter is missing');
            exit;
        }


        $posts = get_posts([
            'post_type'             => $_GET["post_type"],
            'lang'                  => $_GET["lang"],
            'numberposts'           => '-1'
        ] );


        if( empty( $posts ) ) {
            var_dump('no posts found is the post_type correct?');
            exit;
        }

        foreach ($posts as $post){
            update_field($_GET["field"], $_GET["value"], $post->ID);
        }

        var_dump(sprintf('Updated %s %s', count($posts), $_GET["post_type"]));
        exit;
    }
}
add_action( 'admin_init', 'rokit_migrate_field_values' );

