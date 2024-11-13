<?php

/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP filters.php file
    This is the rokit theme filters file

-----------------------------------------------------------------------------------*/

use Rokit\Controllers\Collections\FaqCollection;

/**
  * Filter user role editor plugin restriced categories
  * This restriction must be skippe for ba and faq post typ
  *
  * @param  string  $post_type   The post type loaded in backend
  * @return void
  */
function rodesk_reset_ure_post_type($post_type) {

    $skip_filtering = ['ba', 'faq', 'surgery_day'];

    if(in_array($post_type, $skip_filtering)) { return false; }

    return $post_type;

}

add_filter('ure_restrict_edit_post_type', 'rodesk_reset_ure_post_type');

/**
  * Filter admin_core plugin client roles
  *
  * @param  array  $roles   Array of WordPress user roles
  * @return void
  */
function rodesk_reset_client_roles($roles) {
    $roles[] = 'client_admin_surgery';
    return $roles;
}

add_filter('rokit/core/client_roles', 'rodesk_reset_client_roles');

/**
 * Filter sitemap of yoast and remove all posts of BE and EN.
 *
 * First we get all the post_types then we get all the posts of post_types with the languages we want to filter out
 * then we make a array with all the IDS we want to filter out of the sitemap and then we return them.
 */
add_filter( 'wpseo_exclude_from_sitemap_by_post_ids', function () {

    $post_types = get_post_types( [
        'public'   => true,
        '_builtin' => false
    ], 'names' );

    array_push($post_types, 'page');

    $sitemap_lang = rokit_get_language_settings()['sitemap'];
    $sitemap =[];
    foreach ($sitemap_lang as $key => $value){
        if ((int)$value != 1){
            $sitemap[] = $key;
        }
    }


    $args = [
        'posts_per_page'    => -1,
        'lang'              =>  implode (", ", $sitemap),
        'post_type'         => $post_types
    ];

    $posts =\Timber\Timber::get_posts($args);

    $ids = [];

    if (is_array($posts)) {
        foreach ($posts as $post){
            $ids[] = $post->id;
        }
    }

    return $ids;
} );

/**
 *  Remove "nl-be" and "en" hreflang from the list of hreflangs.
 * @param $hreflangs array with all hreflangs
 * @return array with hreflangs that are allowed
 */
function rokit_filter_pll_rel_hreflang_attributes( $hreflangs ) {
    unset($hreflangs['en']);
    $hreflangs = hreflang_language_array_replace_key('nl-NL', 'nl-nl', $hreflangs);
    $hreflangs  = hreflang_language_array_replace_key('nl-BE', 'nl-be', $hreflangs);
    
    return $hreflangs;
};
add_filter( 'pll_rel_hreflang_attributes', 'rokit_filter_pll_rel_hreflang_attributes', 10, 1 );
add_filter( 'rokit_rel_hreflang_attributes', 'rokit_filter_pll_rel_hreflang_attributes', 10, 1 );

/**
 *  Replace language key with regions keys.
 * @param $hreflangs array with all hreflangs
 * @return array with hreflangs that are allowed
 */
function hreflang_language_array_replace_key($search, $replace, array $subject) {
    $updatedArray = [];

    foreach ($subject as $key => $value) {
        if (!is_array($value) && $key == $search) {
            $updatedArray = array_merge($updatedArray, [$replace => $value]);
            continue;
        }
        $updatedArray = array_merge($updatedArray, [$key => $value]);
    }

    return $updatedArray;
}


/**
 * Filter body classes
 * Add body--'current_language' class to body
 * @param array $classes
 * @return array
 */
function rokit_body_class($classes) {
    $classes[] = 'body--' . pll_current_language();

    return $classes;

}

add_filter('rodesk_body_classes', 'rokit_body_class');

/**
 * Filter the FAQ flex module
 * Loop all FAQ ID's and create FAQ controller instances of them
 *
 * @param   array   $module    The outputted flex module content
 * @return  array
 */

function rokit_filter_faq($module) {

    $formatted_faqs = [];
    $faq = $module['faq'];

    if(!empty($faq) && is_iterable($faq)) {
        foreach($faq as $question) {
            $formatted_faqs[] = FaqCollection::post($question);
        }
    }

    $module['faq'] = $formatted_faqs;

    return $module;

}

add_filter('rokit/content_modules/faq', 'rokit_filter_faq');

/**
 * Format the themepath for TTFP plugin
 *
 * @param   string   $theme_path    The passed path
 * @return  string
 */
function filter_ttfp_themepath($theme_path) {

    if(strpos($theme_path, '/resources')) {
        $theme_path = str_replace('/resources', '', $theme_path);
    }

    return $theme_path;
}

add_filter('rokit/ttfp/theme_path','filter_ttfp_themepath');

/**
 * Add fields to ACF Bidirectional class
 *
 * @param   array   $fields Array of field to be bidirectional
 * @return  void
 */
function rokit_add_bidirectional_fields($fields) {

    $bidirectional_fields = [
        'treatment_specialist_relation',
        'treatment_location_relation',
        'treatment_faq_relation',
        'treatment_ba_relation',
        'treatment_price_relation',
        'specialist_treatment_relation',
        'specialist_location_relation',
        'location_treatment_relation',
        'location_specialist_relation',
        'faq_treatment_relation',
        'ba_treatment_relation',
        'price_treatment_relation'
    ];

    return array_merge($fields, $bidirectional_fields);
}

add_filter('rokit/acf/bidirectional/fields', 'rokit_add_bidirectional_fields');

/**
 * Protect ACF textfield with mailto content
 *
 * @return array    $field   Array with ACF field options
 */

function rokit_protect_email( $value ) {

    $prefix = 'mailto:';

    if( !is_admin() && strpos( $value, $prefix ) !== false ) {

        if( substr( $value, 0, strlen( $prefix ) ) == $prefix ) {
            $value = substr( $value, strlen( $prefix ) );
        }

        return $prefix . antispambot( $value );
    }

    return $value;

}

add_filter('acf/load_value/type=text', 'rokit_protect_email');

/**
 * Remove customizer options.
 *
 */

function rokit_remove_customizer_options( $wp_customize ) {
   $wp_customize->remove_section('static_front_page');
   $wp_customize->remove_section('title_tagline');
   $wp_customize->remove_section('nav');
   $wp_customize->remove_section('themes');
}

//add_action( 'customize_register', 'rokit_remove_customizer_options', 999 );

/*add_action( 'customize_preview_init', function() {
    die("The customizer is disabled. Please save and preview your site on the frontend.");
}, 1);*/

/**
 * Filter to remove target="_blank" and rel="noopener" and add custom attribute
 *
 * @param  string   $value      The value of the ACF field
 * @param  string   $post_id    The ID of the post
 * @param  array    $field      ACF field data
 * @return string               The filtered string
 *
 */

function rokit_filter_external_links( $value, $post_id, $field ) {

    if( strpos($value, 'rel="noopener"') !== false ) {

        $value = str_replace('target="_blank" rel="noopener"', 'rel="external" data-router-disabled', $value);
    }

    return $value;

}

add_filter('acf/load_value/type=wysiwyg', 'rokit_filter_external_links', 10, 3);

/**
 * Add image requirement description to image field
 *
 * @return array    $field   Array with ACF field options
 */

function rokit_scf_image_desc( $field ) {

    // Skip this function for ACF editing screen
    if( get_post_type() == 'acf-field-group' ) {
        return $field;
    }

    $width          = $field['min_width'];
    $height         = $field['min_height'];
    $description    = __('This image must be at least %s pixels wide and %s pixels high.');
    $old_description    = $field['instructions'];
    $new_description    = sprintf( $description, $width, $height );

    if( ( !empty( $width ) && is_numeric( $width ) ) && ( !empty( $height ) && is_numeric( $height ) ) ) {

        if( $old_description != $new_description ) {

            $final =  $old_description . ' ' . $new_description;
            $field['instructions'] = $final;

        }
    }

    return $field;

}

add_filter('acf/load_field/type=image', 'rokit_scf_image_desc');
add_filter('acf/load_field/type=gallery', 'rokit_scf_image_desc');

/**
 * Remove ID from menu items and add item based css class
 *
 * @param  array $classes array of classes
 * @param  array $item    array of menu item
 * @return array          new array of classes
 */

function rokit_nav_menu_css_class($classes, $item) {

    global $post;

    // Active menu class
    $active_menu_class = 'is-active';

    // Rewrite default WP active classes
    $slug       = sanitize_title($item->title);
    $classes    = preg_replace('/(current(-menu-|[-_]page[-_])(item|parent|ancestor))/', $active_menu_class, $classes);
    $classes    = preg_replace('/^((menu|page)[-_\w+]+)+/', '', $classes);
    $classes[]  = 'menu-' . $slug;

    // Getting the post type of the current post
    if( !empty( $post->post_type ) ) {
        $current_post_type = get_post_type_object( $post->post_type );
    }

    // If the menu item URL contains the current post types slug add the current-menu-item class
    if( !empty( $current_post_type->name ) && !empty( $item->_menu_item_object ) ) {
        if( ( $item->_menu_item_type == 'post_type_archive' ) && ( $item->_menu_item_object == $current_post_type->name ) ) {
            $classes[] = 'is-active';
        }
    }

    if( !empty( $post->post_type ) ) {

        // Fix active menu highlighting for blog_article and article post type
        if (($item->ID == 1015 || $item->ID == 2930) && (!empty($post->post_type) && in_array($post->post_type, ['blog_article', 'article']))) {
            $classes[] = 'is-active';
        }

        // Fix active menu highlighting for location and specialist post type
        if (($item->ID == 1389 || $item->ID == 3393) && (!empty($post->post_type) && in_array($post->post_type, ['location', 'specialist']))) {
            $classes[] = 'is-active';
        }
    }

    // Return unique array of classes
    $classes = array_filter( array_unique($classes), 'is_element_empty');

    // Fix double highlighting for speciliast pages
    if(($item->ID == 1696 || $item->ID == 2898 || $item->ID == 2916) && get_post_type() != 'treatment'){
        if(($key = array_search('is-active', $classes)) !== false) {
            unset($classes[$key]);
        }
    }

    // Remove hightlighting for search
    if(is_search() && ($key = array_search('is-active', $classes)) !== false) {
        unset($classes[$key]);
    }

    return $classes;

}

add_filter('nav_menu_css_class', 'rokit_nav_menu_css_class', 10, 2);
add_filter('nav_menu_item_id', '__return_null');

/**
 * Wrap oembed in container to user with fitvids
 * Use the '.video__container' class to bind fitvids to this container
 *
 * @return The output of the oEmbed filter wrapped in a container
 */

function rodesk_video_embed_fitvid( $output, $data, $url ) {

    $return = '<div class="video__container">'.$output.'</div>';
    return $return;
}

add_filter('embed_oembed_html', 'rodesk_video_embed_fitvid', 90, 3 );

/**
 * Change tinyMCE's paste-as-text functionality
 * Force the TinyMCE editor to always paste every pasted text as plain text
 *
 * @param  array    $mceInit   The TinyMCE object
 * @param  integer  $editor_id The ID of the editor
 * @return array    $mceInit   The adjusted TinyMCE object
 */

function rokit_default_paste_as_text($mceInit, $editor_id){

    $mceInit['paste_text_use_dialog'] = false;
    $mceInit['paste_as_text'] = true;

    return $mceInit;
}

add_filter('tiny_mce_before_init', 'rokit_default_paste_as_text', 1, 2);

/**
 * Add paste Rokit_load_paste_plugin
 * Force the TinyMCE editor to add paste plugin
 *
 * @param  array    $plugins    All plugins of TinyMCE
 * @return  array   $plugins    Return plugins of TinyMCE
 */

function rokit_load_paste_plugin($plugins) {
    $plugins[] = 'paste';
    return $plugins;
}

add_filter('teeny_mce_plugins', 'rokit_load_paste_plugin', 1, 2);

/**
 * Disabels fields so the user cant edit them
 */
function disable_acf_load_field( $field ) {

    $field['disabled'] = 1;
    return $field;

}

add_filter('acf/load_field/name=review_url', 'disable_acf_load_field');
add_filter('acf/load_field/name=review_id', 'disable_acf_load_field');

/**
 * Only show treatments within the same taxonomy (treatment type)
 */

function rokit_treatment_term_relation_query($args, $field, $post_id)
{

    $args['tax_query'] = [[
        'taxonomy' => 'treatment_type',
        'field'    => 'term_id',
        'terms'    => str_replace( 'term_', '', $post_id )
    ]];


    return $args;

}

add_filter('acf/fields/relationship/query/name=treatment_taxonomy_relation', 'rokit_treatment_term_relation_query', 100, 100);
/**
 * Only show treatments within the same taxonomy (treatment type)
 */

function rokit_faq_term_relation_query($args, $field, $post_id)
{

    $args['tax_query'] = [[
        'taxonomy' => 'faq_taxonomy',
        'field'    => 'term_id',
        'terms'    => str_replace( 'term_', '', $post_id )
    ]];


    return $args;

}

add_filter('acf/fields/relationship/query/name=faq_taxonomy_highlighted', 'rokit_faq_term_relation_query', 100, 100);

/**
 * Filter the upload size limit.
 *
 * @param string $size Upload size limit (in bytes).
 * @return int (maybe) Filtered size limit.
 */
function filter_site_upload_size_limit( $size ) {
    // 4 MB.
    $size = 1024 * 70000;
    return $size;
}
add_filter( 'upload_size_limit', 'filter_site_upload_size_limit', 20 );

/**
 * Filter class subfield from repeater of menu items
 *
 * @param   array $field    Array of ACF field properties
 * @return  void
 */
function rokit_filter_menufield_class($field) {

    if(is_admin() && !current_user_can('administrator')) {
        if(!empty($field['sub_fields']) && is_iterable($field['sub_fields'])) {
            $key = array_search('admin_class', array_column($field['sub_fields'], 'name'));
            unset($field['sub_fields'][$key]);
        }
    }

    return $field;

}

add_filter('acf/load_field/name=about_urls', 'rokit_filter_menufield_class');
add_filter('acf/load_field/name=info_urls', 'rokit_filter_menufield_class');
add_filter('acf/load_field/name=service_urls', 'rokit_filter_menufield_class');

/**
 * Update rokit_review_average option field if current saved post is a review and is published
 *
 * @param $post_id post id
 * @return void
 */
function rokit_update_average_on_save( $post_id ) {
    if (get_post_type() == 'review'){
        if (\Rokit\Controllers\Collections\ReviewCollection::post($post_id)->post_status == 'publish'){
            $reviews = \Rokit\Controllers\Collections\ReviewCollection::all();
            $grades = array_map(function($review){ return $review->grade; }, $reviews);

            if (!empty($grades) && is_array($grades)){
                $average =  round( array_sum($grades) / count($grades), 1);
                update_option('rokit_review_average', $average);
            }
        }
    }
}

add_action( 'save_post', 'rokit_update_average_on_save' );

/**
 * Prevent Wordpress from storing the ip when submitting a comment
 *
 * @param $comment_author_ip string of users IP
 * @return string empty string
 */
function rokit_remove_commentsip( $comment_author_ip ) {
    return '';
}
add_filter( 'pre_comment_user_ip', 'rokit_remove_commentsip' );

/**
 *  Add required field of optin for comments.
 */
function rokit_check_accepted_privacy() {
    if( isset( $_POST[ 'optin' ]) && $_POST[ 'optin' ] != 'optin')
        wp_die( __('Error: please accept the optin') );
}

add_action('pre_comment_on_post', 'rokit_check_accepted_privacy');


if (!is_singular('location')){
    add_filter( 'wpseo_json_ld_output', '__return_false' );
}

/**
 * Add class if current page had the campaing template.
 *
 * @param $classes array with classes
 * @return array with classes
 */
function rokit_add_body_class( $classes ) {

    if (is_page(6331) || is_page(6330)){
        $classes[] = 'body--single--campaign';
    }

    return $classes;

}
add_filter( 'body_class', 'rokit_add_body_class');


// Override the hreflang position from polylang
add_action( 'after_setup_theme', 'remove_hook' );
function remove_hook() {
    remove_filters_for_anonymous_class( 'wp_head', 'PLL_Frontend_Filters_Links', 'wp_head' );
}

function remove_filters_for_anonymous_class( $hook_name = '', $class_name ='', $method_name = '', $priority = 10 ) {
    global $wp_filter;
    if ( ! isset($wp_filter[$hook_name][$priority]) || ! is_array($wp_filter[$hook_name][$priority]) )
    return false;

    foreach( (array) $wp_filter[$hook_name][$priority] as $unique_id => $filter_array ) {

        if ( isset( $filter_array['function'] ) && is_array( $filter_array['function'] ) ) {

            if ( is_object( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) && get_class( $filter_array['function'][0] ) == $class_name && $filter_array['function'][1] == $method_name ) {
                  unset( $wp_filter[$hook_name]->callbacks[$priority][$unique_id] );
            }
        }

    }
    return true;
}

// Hreflang URL added on the pages
include(__DIR__.'/hreflang-template.php');

// Exclude sitemap URLs
include(__DIR__.'/non-indexed-urls.php');

function set_default_language_for_user($redirect_to, $request, $user) {
    // Check if the user is logged in and has the administrator role
    if (is_a($user, 'WP_User') && in_array('editor', $user->roles)) {
        // Check if the user is 's.kaufmann'
        if ($user->user_login === 's.kaufmann' || $user->user_login === 'Frauke.schmidt') {
            // Set the default language to 'de' (German) for 's.kaufmann'
            return home_url('/cms/wp-admin/?lang=de');
        } else if($user->user_login === 'l.moleri') {
            return home_url('/cms/wp-admin/?lang=it');
            // Set default language to another language for other administrators if needed
            // Example: pll_set_default_language('en'); // Set default language to English for other admins
        }else{

        }

        // Redirect the user to the admin dashboard or a specific page after login
        return admin_url();
    }
    return $redirect_to;
}
add_filter('login_redirect', 'set_default_language_for_user', 10, 3);


function admin_list_pll_languages($list){
    $current_user = wp_get_current_user();
    if($current_user->user_login == 's.kaufmann' || $user->user_login == 'Frauke.schmidt') {
        unset($list[0]);
        unset($list[1]);
        unset($list[2]);
        unset($list[4]);
        unset($list[5]);
        unset($list[7]);

        $allowed_languages = ['de', 'ch'];
        if (isset($_GET['lang']) && !in_array($_GET['lang'], $allowed_languages) ||  isset($_GET['new_lang']) && !in_array($_GET['new_lang'], $allowed_languages)) {
                wp_die(__('You do not have permission to access content in this language.'));
            }

        return $list;
    }elseif($current_user->user_login == 'l.moleri'){
        unset($list[0]);
        unset($list[1]);
        unset($list[2]);
        unset($list[3]);
        unset($list[4]);
        unset($list[5]);
        unset($list[6]);
        unset($list[7]);

        $allowed_languages = ['it'];
        if (isset($_GET['lang']) && !in_array($_GET['lang'], $allowed_languages) ||  isset($_GET['new_lang']) && !in_array($_GET['new_lang'], $allowed_languages) || pll_current_language() == 'nl') {
            wp_die(__('You do not have permission to access content in this language.'));
        }

        return $list;
    }else{
        return $list;
    }
}
add_filter('pll_admin_languages_filter', 'admin_list_pll_languages', 0, 2);

