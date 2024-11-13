<?php

/*-----------------------------------------------------------------------------------

    Copyright 2016 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP search-functions.php file
    This is the search functions file

-----------------------------------------------------------------------------------*/

/**
 * Redirect al search requests from s=query to pretty URL
 *
 * @param  string   $url            Default redirect URL to pretty search URL
 * @param  string   $search_base    Default search base permastruct
 * @param  string   $search_query   The search query
 * @return string
 */
function rokit_redirect_searchform($url, $search_base, $search_query) {
    $base_url = rtrim(pll_home_url(), '/');
    return sprintf('%s/%s/%s', $base_url, $search_base, urlencode(get_query_var('s')));
}

add_filter('rokit/core/search_redirect', 'rokit_redirect_searchform', 10, 3);

/**
 * Change default posts per page for Search WP results
 *
 * @param  integer  $posts_per_page     The default numer of posts per page
 * @param  string   $engine             The search engine in use
 * @param  array    $terms              The search query
 * @param  integer  $page               The page of search results being displayed
 * @return integer                      The adjusted number of posts per page
 */
function rokit_searchwp_posts_per_page( $posts_per_page, $engine, $terms, $page ) {
    return 10;
}

add_filter( 'searchwp_posts_per_page', 'rokit_searchwp_posts_per_page', 10, 4 );

/**
 * Filter some fields out to use for SearchWP highlight
 *
 * @param  array    $meta_keys          Array of fields to included for highlight
 * @return array                        Filtered array of fields to included for highlight
 */
function rokit_searchwp_th_meta_keys( $meta_keys ) {

    $ignore = ['_title', '_items', '_button', '_url', '_external', 'title', 'subtitle', 'ticket_slider'];

    if(!empty($meta_keys) && is_iterable($meta_keys)) {
        foreach($meta_keys as $key => $value) {

            array_walk($ignore, function($ignore_string) use (&$meta_keys, $key, $value) {
                if(strpos($value, $ignore_string) !== false) {
                    unset($meta_keys[$key]);
                }
            });

        }
    }

    return $meta_keys;
}

add_filter('searchwp_th_meta_keys', 'rokit_searchwp_th_meta_keys');

/**
 * Custom fork of the searchwp_term_highlight_get_the_excerpt_global
 *
 * @param   int     $post_id
 * @param   string  $custom_field
 * @param   null    $query
 * @return  string
 */
if(class_exists('SearchWPHighlighter') and class_exists('SearchWPIndexer')) {
    function rodesk_term_highlight_get_the_excerpt_global( $post_id = 0, $custom_field = '', $query = null ) {
        global $post;

        $highlighter = new SearchWPHighlighter();

        if ( empty( $post ) || is_null( $post ) || ! class_exists( 'SearchWPIndexer' ) ) {
            return '';
        }

        $original_post = $post;

        if ( empty( $post_id ) ) {
            if(isset( $post->ID )) {
                $post_id = $post->ID;
            } else {

                if ( function_exists( 'get_the_ID' ) ) {
                    $post_id = get_the_ID();
                } else {
                    // couldn't retrieve the post ID so we need to short circuit
                    return '';
                }

            }
        }

        if ( empty( $query ) ) {
            $query = get_search_query();
        }

        $query = $highlighter->prep_terms( $query );
        $excerpt = '';
        $default_excerpt = '';

        if ( empty( $custom_field ) ) {
            // retrieve the default excerpt
            $post_id = absint( $post_id );
            $post = get_post( $post_id );
            setup_postdata( $post );


            // grab all content (default excerpt and all Custom Fields) and concatenate it
            $excerpt = $default_excerpt = $highlighter->get_the_excerpt( $query, null, false );
        } else {
            // a custom field was specified so we're going to use that to generate the excerpt
            $custom_field = sanitize_text_field( $custom_field );
        }

        $indexer = new SearchWPIndexer();

        // exclude all the keys that are excluded in SearchWP itself
        $excluded_custom_field_keys = apply_filters( 'searchwp_excluded_highlight_custom_fields', array(
            '_edit_lock',
            '_wp_page_template',
            '_wp_attached_file',
            '_edit_last',
            '_wp_old_slug',
            '_searchwp_indexed',
            '_searchwp_last_index',
        ));
        $excluded_custom_field_keys = apply_filters( 'searchwp_excluded_custom_fields', $excluded_custom_field_keys);

        if ( empty( $custom_field ) && false === strpos( $excerpt, 'searchwp-highlight' ) ) {
            // wasn't found in the main excerpt, so we're going to loop through the Custom Fields until we find one
            // custom fields next

            $custom_field_keys = apply_filters( 'searchwp_th_meta_keys', get_post_custom_keys( $post_id ) );

            if ( ! empty( $custom_field_keys ) ) {
                $better_excerpt = false;
                $the_post = get_post( $post_id );
                foreach ( $custom_field_keys as $custom_field_key ) {

                    if ( function_exists( 'SWP' ) && method_exists( SWP(), 'is_used_meta_key' ) ) {
                        if ( ! SWP()->is_used_meta_key( $custom_field_key, $the_post ) ) {
                            continue;
                        }
                    }

                    if ( ! in_array( $custom_field_key, $excluded_custom_field_keys, true ) ) {

                        $meta_value = get_post_meta( $post_id, $custom_field_key );
                        $meta_value = apply_filters( 'searchwp_th_pre_process_meta_value', $meta_value, $custom_field_key, $post_id );

                        foreach ( $meta_value as $meta_value_entry ) {
                            // Find a reduced case of the target term(s)
                            $reduced_meta_value = (string) $indexer->parse_variable_for_terms( $meta_value_entry );

                            $this_custom_field_value = $highlighter->pre_process_content( $reduced_meta_value );
                            $excerpt = $highlighter->get_the_excerpt( $query, $this_custom_field_value, false );

                            if ( false !== strpos( $excerpt, 'searchwp-highlight' ) ) {

                                // Because we had to avoid using the output from pre_process_content() which destroys all formatting
                                // we could technically have any kind of data type here (e.g. multidimensional array) so we need to
                                // work around that by making the meta record a string if it's not one
                                if ( is_array( $meta_value_entry ) ) {
                                    $meta_value_entry = $highlighter->array_flatten( $meta_value_entry );
                                }

                                // Redefine to the original excerpt because right now it's the reduced value
                                $excerpt = $highlighter->get_the_excerpt( $query, $meta_value_entry, false );
                                $better_excerpt = true;

                                break;
                            }
                        }

                        // If we found a better excerpt in a custom field, break out
                        if ( ! empty( $better_excerpt ) ) {
                            break;
                        }
                    }
                }

                if ( ! $better_excerpt ) {
                    $excerpt = $default_excerpt;
                }
            }
        } elseif ( ! empty( $custom_field ) ) {
            $custom_field_value = get_post_meta( $post_id, $custom_field, true );
            $custom_field_value = $highlighter->pre_process_content( $custom_field_value );
            $excerpt = $highlighter->get_the_excerpt( $query, $custom_field_value, false );
        }

        // last resort: try to pluck an excerpt from the post content even when
        // a proper Excerpt was defined (but did not have a highlight match)
        $proper_excerpt = $excerpt; // save this for later in case the post
        // content doesn't have a match either
        if ( false === strpos( $excerpt, 'searchwp-highlight' ) ) {
            $post_content = isset( $post->post_content ) ? apply_filters( 'the_content', $post->post_content ) : $excerpt;
            $post_content = $highlighter->pre_process_content( $post_content );

            $excerpt = $highlighter->get_the_excerpt( $query, $post_content );

            // if the post content didn't have a match either, fall back to the proper Excerpt
            if ( false === strpos( $excerpt, 'searchwp-highlight' ) ) {
                $excerpt = $proper_excerpt;
            }
        }

        // reset the post object
        $post = $original_post;

        // return the best excerpt we could find...
        return $excerpt;
    }
}
