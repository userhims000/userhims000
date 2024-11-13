<?php

/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP routes.php file
    This is the rokit theme routes file

-----------------------------------------------------------------------------------*/

use Rokit\Controllers\Types\Treatment;

function rokit_add_query_vars_filter( $vars ) {
    $vars[] = "pagetype";
    return $vars;
}

add_filter( 'query_vars', 'rokit_add_query_vars_filter' );

function rokit_route_treatment_subpage($params) {

    if(!empty(rokit_exists_by_slug($params['slug'], 'treatment'))) {
        $query = "post_type=treatment&name={$params['slug']}&pagetype={$params['pagetype']}";
        Routes::load('single.php', $params, $query);
    } else {
        Routes::load('404.php', $params, null, 404);
    }

}

function rokit_format_treatment_routes() {

    if(function_exists('pll_languages_list')) {

        $languages = pll_languages_list();

        array_walk($languages, function($language){

            $treatment = pll_translate_string('behandelingen', $language);

            $route_string = sprintf('%s/%s/:treatment_type/:slug/:pagetype', $language, $treatment);
            Routes::map($route_string, 'rokit_route_treatment_subpage');

        });
    }
}

add_action('init', 'rokit_format_treatment_routes');

function rokit_route_specialist_by_type($params) {
    if(!empty($params['treatmenttype']) && !empty(term_exists($params['treatmenttype'], 'treatment_type'))) {
        $query = "post_type=specialist&treatment_type={$params['treatmenttype']}";
        Routes::load('archive.php', $params, $query);
    } else {
        Routes::load('404.php', $params, null, 404);
    }

}

function rokit_format_specialist_routes() {

    if(function_exists('pll_languages_list')) {

        $languages = pll_languages_list();

        array_walk($languages, function($language){

            $specialist = pll_translate_string('over-ons/specialisten', $language);
            $kind       = pll_translate_string('soort', $language);

            $route_string = sprintf('%s/%s/%s/:treatmenttype', $language, $specialist, $kind);
            Routes::map($route_string, 'rokit_route_specialist_by_type');

        });
    }
}

add_action('init', 'rokit_format_specialist_routes');

function rokit_format_news_overview_routes() {

    if(function_exists('pll_languages_list')) {

        $languages = pll_languages_list();

        array_walk($languages, function($language){
            if($language === 'de'){
                $news = pll_translate_string('betreibergesellschaft/news', $language);
            }else{
                $news = pll_translate_string('nieuws', $language);
            }


            $route_string = sprintf('%s/%s/', $language, $news);
            Routes::map($route_string, function($params){
                $query = 'post_type=article&news_overview=true';
                Routes::load('archive.php', $params, $query);
            });

        });
    }
}

add_action('init', 'rokit_format_news_overview_routes');

function rokit_route_article_tag($params) {

    $taxonomy = 'article_tag';
    if(!empty(rokit_exists_taxonomy_by_name($params['slug'], $taxonomy))) {

        $query = "post_type=article&is_tag=true&type=article&name={$params['slug']}&term_name={$taxonomy}";
        Routes::load('archive.php', $params, $query);
    } else {
        Routes::load('404.php', $params, null, 404);
    }

}

function rokit_article_tag_routes() {

    if(function_exists('pll_languages_list')) {

        $languages = pll_languages_list();

        array_walk($languages, function($language){

            $news       = pll_translate_string('nieuws', $language);
            $updates    = pll_translate_string('updates', $language);
            $tags       = pll_translate_string('tags', $language);

            $route_string = sprintf('%s/%s/%s/%s/:slug', $language, $news, $updates, $tags);
            Routes::map($route_string, 'rokit_route_article_tag');

        });
    }
}

add_action('init', 'rokit_article_tag_routes');

function rokit_route_blog_article_tag($params) {

    $taxonomy = 'blog_article_tag';
    if(!empty(rokit_exists_taxonomy_by_name($params['slug'], $taxonomy))) {

        $query = "post_type=article&is_tag=true&type=blog_article&name={$params['slug']}&term_name={$taxonomy}";
        Routes::load('archive.php', $params, $query);
    } else {
        Routes::load('404.php', $params, null, 404);
    }

}

function rokit_blog_article_tag_routes() {

    if(function_exists('pll_languages_list')) {

        $languages = pll_languages_list();

        array_walk($languages, function($language){

            $news       = pll_translate_string('nieuws', $language);
            $updates    = pll_translate_string('blog', $language);
            $tags       = pll_translate_string('tags', $language);

            $route_string = sprintf('%s/%s/%s/%s/:slug', $language, $news, $updates, $tags);
            Routes::map($route_string, 'rokit_route_blog_article_tag');

        });
    }
}

add_action('init', 'rokit_blog_article_tag_routes');

//======================================================================
// All functions below are used to make WP, WP SEO and Polylang aware
// of some of the custom routes that are defined above
//======================================================================

/**
 * Reformat the url to translated version of a treatment
 * Above a custom route is defined for treatment subpages
 * This function is needed to make the language switch aware of the custom route
 *
 * @param   array   $languages  Array of langauges used for the language switch
 * @return  array
 */
function rokit_treatment_language_link($languages) {

    global $post;

    if(empty($post->post_type) || $post->post_type != 'treatment') { return $languages; }

    return array_map(function($language) use ($post){
        $language['url'] = rokit_adjust_treatment_link($post, $language);
        return $language;
    }, $languages);

}
add_filter('rokit/langauges', 'rokit_treatment_language_link');

/**
 * Reformat the url to translated version of a specialist category
 * Above a custom route is defined for specialist categories
 * This function is needed to make the language switch aware of the custom route
 *
 * @param   array   $languages  Array of langauges used for the language switch
 * @return  array
 */
function rokit_specialist_translated_links($languages) {

    global $wp_query, $params;

    if(empty($wp_query->query['post_type']) || $wp_query->query['post_type'] != 'specialist' || empty($params['treatmenttype'])) { return $languages; }

    return array_map(function($language) use ($params){
        $specialist = pll_translate_string('over-ons/specialisten', $language['slug']);
        $kind       = pll_translate_string('soort', $language['slug']);
        $language['url'] = sprintf('%s%s/%s/%s', trailingslashit(pll_home_url($language['slug'])), $specialist, $kind, $params['treatmenttype']);
        return $language;

    }, $languages);

}
add_filter('rokit/langauges', 'rokit_specialist_translated_links');

/**
 * Reformat the alternate href lang to translated version of a treatment
 * Above a custom route is defined for treatment subpages
 * This function is needed to make the language switch aware of the custom route
 *
 * @param   array   $alternates  Array of alternate/translated links of a treatment
 * @return  array
 */
function rokit_adjust_treatment_alternate_link($alternates) {

    global $post;

    if(!is_singular('treatment')) { return $alternates; }

    $modified_alternates = [];

    array_map(function($language) use (&$modified_alternates, $post) {
        if($url =rokit_adjust_treatment_link($post, $language, false)) {
            $modified_alternates[$language['locale']] = $url;
        }
    }, pll_the_languages(['raw' => 1]));

    // Run custom filter to remove certain languages
    return apply_filters('rokit_rel_hreflang_attributes', $modified_alternates);

}
add_filter('pll_rel_hreflang_attributes', 'rokit_adjust_treatment_alternate_link');

/**
 * Reformat the alternate href lang to translated version of a specialist category
 * Above a custom route is defined for specialist category pages
 * This function is needed to make the language switch aware of the custom route
 *
 * @param   array   $alternates  Array of alternate/translated links of a specialist category
 * @return  array
 */
function rokit_adjust_specialist_alternate_link($alternates) {

    global $wp_query, $params;

    if(empty($wp_query->query['post_type']) || $wp_query->query['post_type'] != 'specialist' || empty($params['treatmenttype'])) { return $alternates; }

    $languages = pll_the_languages(['raw' => 1]);
    $language_list = array_column($languages, 'slug', 'locale');

    array_map(function($language_key, $url) use ($language_list, $languages, $params, &$alternates){

        $language_slug = strpos($language_key, '-') != false ? $language_list[$language_key] : $language_key;
        $specialist = pll_translate_string('over-ons/specialisten', $language_slug);
        $kind       = pll_translate_string('soort', $language_slug);
        $alternates[$language_key] = sprintf('%s%s/%s/%s', trailingslashit(pll_home_url($language_slug)), $specialist, $kind, $params['treatmenttype']);

    }, array_keys($alternates), $alternates);

    return $alternates;

}
add_filter('pll_rel_hreflang_attributes', 'rokit_adjust_specialist_alternate_link');

/**
 * Adjusts the URL of a treatment bases on the page type
 * Above a custom route is defined for treatment subpages
 * This function is needed to add the page type to the custom route
 *
 * @param   object   $post      WP_Post object of the actual post
 * @param   array    $laguage   Array of info with the actual language
 * @return  string              String with a modified URL
 */
function rokit_adjust_treatment_link(WP_Post $post, $language, $return_empty = true) {

    if(!empty($alternate_lang_id = pll_get_post($post->ID, $language['slug']))) {

        $controller = new Treatment($alternate_lang_id);
        $page_type = $controller->page_type();
        $nav = $controller->nav();

        if(!empty($page_type['slug']) && $page_type['slug'] != 'de-behandeling' && empty($nav[$page_type['slug']]['disabled'])) {
            return trailingslashit($language['url']) . sanitize_title(pll_translate_string($page_type['default_label'], $language['slug']));
        }

    }

    if(!empty($return_empty)) { return $language['url'];}
}
