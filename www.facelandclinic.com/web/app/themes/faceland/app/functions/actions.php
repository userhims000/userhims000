<?php

/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP actions.php file
    This is the rokit theme actions file

-----------------------------------------------------------------------------------*/
/**
* Add custom capability for surgery role
* This role is used to hide certain dashboard menu icons
*/
function rodesk_add_surgery_cap() {

    $roles = $GLOBALS['wp_roles'];
    $surgery_cap = 'rodesk_non_surgery';
    $surgery_role = 'client_admin_surgery';

    if(empty($roles->role_objects)) { return; }

    // Loop all user roles
    foreach($roles->role_objects as $key => $role) {
    // Skip is user role is equal to $surgery_role
    if($role->name == $surgery_role) { continue; }
        // Add $surgery_cap to user role
        $role->add_cap($surgery_cap);
    }
}

add_action('admin_init', 'rodesk_add_surgery_cap');

/**
 * Redirect users that are not logged in when they visit a page of a blacklisted language
 */
function rokit_redirect_user_not_logged_in() {

    if (!is_user_logged_in()){

        $redirect_lang = rokit_get_language_settings()['redirect'];
        $blacklist =[];
        foreach ($redirect_lang as $key => $value){
            if ((int)$value){
                $blacklist[] = $key;
            }
        }

        if (in_array(pll_current_language() , $blacklist)) {
            //wp_redirect(pll_home_url('nl'));
        }
    }
}

add_action('template_redirect', 'rokit_redirect_user_not_logged_in');

/**
  * Combine first and last name of a specialist
  * This hooks runs on save_post
  *
  * @param  int $post_id
  * @return void
  */
function rokit_save_specialist_fullname($post_id) {

    if(wp_is_post_revision( $post_id) || wp_is_post_autosave( $post_id )) {
        return;
    }

    $first_name = get_field('specialist_first_name', $post_id);
    $last_name = get_field('specialist_last_name', $post_id);

    if(!empty($first_name) && !empty($last_name)) {
        $first_name = str_replace('Dr. med. ', '', $first_name);
        $fullname = $first_name . ' ' . $last_name;
        update_post_meta($post_id, 'specialist_full_name', $fullname);
    }

    if(isset($_POST['acf']['field_5d5be5d781262']['field_5d5be5d781262_field_5d1daa43da223'])){
        update_field('page_panorama_show_image', $_POST['acf']['field_5d5be5d781262']['field_5d5be5d781262_field_5d1daa43da223'], $post_id);
    }
    if(isset($_POST['acf']['field_5d5be5d781262']['field_5d5be5d781262_field_5d1daa43da218'])){
        update_field('page_panorama_image', $_POST['acf']['field_5d5be5d781262']['field_5d5be5d781262_field_5d1daa43da218'], $post_id);
    }
}

add_action('save_post', 'rokit_save_specialist_fullname');

/**
 * Remove the 'description' column from the table in 'edit-tags.php'
 */

function rokit_hide_tax_desc_column() {

    $taxonomies = [
        'faq_topic_taxonomy',
        'faq_taxonomy',
        'location-country',
        'blog_taxonomy',
        'article_taxonomy',
        'treatment_bodypart',
        'ba_album_taxonomy',
        'treatment_type',
        'video_playlist',
        'price_type',
        'ba_type',
        'surgery_day_type'
    ];

    foreach($taxonomies as $taxonomy) {
        add_action("manage_edit-{$taxonomy}_columns", function($columns) {
            unset($columns['description']);
            return $columns;
        });
    }

}

add_action('admin_init', 'rokit_hide_tax_desc_column');

/**
 * Remove the 'description' textarea from the table in 'edit-tags.php'
 */

function rokit_hide_tax_desc_field() {

    global $current_screen;

    if (!empty( $current_screen->id ) ){

        $whitelist = [
            'edit-video-playlist',
            'edit-faq-categorie',
            'edit-location-country',
            'edit-blog_taxonomy',
            'edit-article_taxonomy',
            'edit-treatment_bodypart',
            'edit-ba_album_taxonomy',
            'edit-treatment_type',
            'edit-video_playlist',
            'edit-price_type',
            'edit-surgery_day_type',
            'edit-ba_type'
        ];

        if (in_array($current_screen->id , $whitelist)) {
            echo '<style>.term-description-wrap{display:none;}</style>';
        }
    }

}

add_action( 'admin_head-term.php', 'rokit_hide_tax_desc_field' );
add_action( 'admin_head-edit-tags.php', 'rokit_hide_tax_desc_field' );

/**
 * Remove the 'slug' column from the table in 'edit-tags.php'
 */

function rokit_hide_tax_slug_field() {

    global $current_screen;

    if (!empty( $current_screen->id ) ){
        $whitelist = [
            'edit-video_playlist',
            'edit-faq-categorie'
        ];

        if (in_array($current_screen->id , $whitelist)) {
            echo '<style>.term-slug-wrap{display:none;}</style>';
        }
    }

}

add_action( 'admin_head-term.php', 'rokit_hide_tax_slug_field' );
add_action( 'admin_head-edit-tags.php', 'rokit_hide_tax_slug_field' );

/**
 * Remove the 'parent' column from the table in 'edit-tags.php'
 */

function rokit_hide_tax_parent_field() {

    global $current_screen;

    if (!empty( $current_screen->id ) ){
        $whitelist = [
            'edit-video-playlist',
            'edit-blog_taxonomy',
            'edit-location-country',
            'edit-treatment_bodypart',
            'edit-treatment_type',
            'edit-article_taxonomy',
            'edit-ba_type',
            'edit-lm_type',
            'edit-price_type',
            'edit-video_playlist',
            'edit-ba_treatment',
            'edit-surgery_day_type'
        ];

        if (in_array($current_screen->id , $whitelist)) {
            echo '<style>.term-parent-wrap{display:none;}</style>';
        }
    }

}

add_action( 'admin_head-term.php', 'rokit_hide_tax_parent_field' );
add_action( 'admin_head-edit-tags.php', 'rokit_hide_tax_parent_field' );

/**
 * Redirect archives to the first term in taxonomy
 */
function rokit_redirect_archive_taxonomy() {

    // Array of archive
    // With there taxonomies to redirect to
    $archives = [
        'ba_album'  => 'ba_album_taxonomy',
        'price'     => 'price_type',
        'location'  => 'location_country',
        'surgery_day'  => 'surgery_day_type',
    ];

    foreach($archives as $post_type => $taxonomy) {
        if(is_post_type_archive($post_type)) {

            $terms = get_terms($taxonomy);
            $first_term = array_shift($terms);

            if(!is_wp_error($first_term) && !empty($first_term->term_id)) {
                $redirect_url = get_term_link($first_term->term_id);
            } else {
                $redirect_url = get_home_url();
            }

            wp_redirect($redirect_url);
        }
    }
}

add_action('template_redirect', 'rokit_redirect_archive_taxonomy');

/**
 * Dont show Highlighted group if on overview page of taxonomies type.
 */

function rokit_hide_highlighted_tab() {

    global $current_screen;

//    if (!empty( $current_screen->id ) ){
//        $whitelist = [
//            'edit-treatment_type'
//        ];
//
//        if (in_array($current_screen->id , $whitelist)) {
//            echo '<style>';
//            echo '.acf-tab-wrap {display: none !important;}';
//            echo '.acf-field {display: none !important;}';
//            echo '</style>';
//        }
//    }
}

add_action( 'admin_head-edit-tags.php', 'rokit_hide_highlighted_tab' );

/**
* Force a custom upload directory and URL
* Attention: This will only work when no UPDATE constant is defined
*
*/

function rodesk_upload_path() {

   $upload_path        = get_option('upload_path');
   $upload_url_path    = get_option('upload_url_path');
   $upload_directory   = 'assets';

   // Build new upload path and URL from
   $new_upload_dir     = trailingslashit( WP_CONTENT_DIR ) . $upload_directory;
   $new_upload_path    = trailingslashit( WP_CONTENT_URL ) . $upload_directory;

   // Check if new upload path and URL is equal to the ones in the DB
   // Else force an update with the new upload path and URL
   if( empty( $upload_url_path ) || $upload_url_path !== $new_upload_path ) {

       update_option( 'upload_path', $new_upload_dir );
       update_option( 'upload_url_path', $new_upload_path );

   }


    add_shortcode( 'cookie_declaration', 'cookieDeclarion' );
}

add_action('init', 'rodesk_upload_path');


/**
 * Redirect single page if post_type name is inside $redirects.
 * Inside $redirects are the post_types that need to redirect to theire archive page.
 */

function rokit_redirect_single_to_archive() {
    $postType = get_post_type_object(get_post_type());
    $current_postType = $postType ? $postType->name : false;

    $redirects = [
        'video',
        'ba',
        'faq',
        'last_minute',
        'surgery_day',
        'review',
        'academy'
    ];

    if(is_singular() && in_array($current_postType , $redirects)) {
        wp_redirect(get_post_type_archive_link( $current_postType ));
        die;
    }
}

add_action('template_redirect', 'rokit_redirect_single_to_archive');

/**
 * Remove the 'description' column from the table in 'edit-tags.php'
 * but only for the 'discover-type' taxonomy
 */

function rokit_hide_discover_type_desc() {

    global $current_screen;

    if (!empty( $current_screen->id ) ){
        $whitelist = [
            'edit-video-playlist',
            'edit-faq-categorie',
            'edit-location-country',
            'edit-blog_taxonomy',
            'edit-article_taxonomy',
            'edit-treatment_bodypart',
            'edit-treatment_type',
            'edit-lm_type',
            'edit-faq_taxonomy',
            'edit-ba_type'];

        if (in_array($current_screen->id , $whitelist)) {
            echo '<style>.term-description-wrap, .description{display:none;}</style>';
        }
    }

}

add_action( 'admin_head-term.php', 'rokit_hide_discover_type_desc' );
add_action( 'admin_head-edit-tags.php', 'rokit_hide_discover_type_desc' );

/**
 * Remove the 'slug' column from the table in 'edit-tags.php'
 * but only for the 'discover-type' taxonomy
 */

function rokit_hide_discover_type_slug() {

    global $current_screen;

    if (!empty( $current_screen->id ) ){
        $whitelist = [
            'edit-video-playlist',
            'edit-faq-categorie'];

        if (in_array($current_screen->id , $whitelist)) {
            echo '<style>.term-slug-wrap{display:none;}</style>';
        }
    }

}

add_action( 'admin_head-term.php', 'rokit_hide_discover_type_slug' );
add_action( 'admin_head-edit-tags.php', 'rokit_hide_discover_type_slug' );
/**
 * Remove the 'parent' column from the table in 'edit-tags.php'
 * but only for the 'discover-type' taxonomy
 */

function rokit_hide_discover_type_parent() {

    global $current_screen;

    if (!empty( $current_screen->id ) ){
        $whitelist = [
            'edit-video-playlist',
            'edit-blog_taxonomy',
            'edit-location-country',
            'edit-treatment_bodypart',
            'edit-treatment_type',
            'edit-article_taxonomy',
            'edit-ba_type',
            'edit-lm_type',
            'edit-ba_treatment'
        ];

        if (in_array($current_screen->id , $whitelist)) {
            echo '<style>.term-parent-wrap{display:none;}</style>';
        }
    }

}

add_action( 'admin_head-term.php', 'rokit_hide_discover_type_parent' );
add_action( 'admin_head-edit-tags.php', 'rokit_hide_discover_type_parent' );

/**
 * Insert custom styles for campaign singular pages
 *
 */
function rodesk_campaign_custom_style() {
    if(is_singular('campaign')) {

        $color_background   = get_field('campaign_color_background');
        $color_button       = get_field('campaign_color_button');
        $color_title        = get_field('campaign_color_title');
        $color_text         = get_field('campaign_color_text');

    } elseif (is_page(6331) || is_page(6330)){
        $color_background   = get_field('page_color_background');
        $color_button       = get_field('page_color_button');
        $color_title        = get_field('page_color_title');
        $color_text         = get_field('page_color_text');
    }

    if (!empty($color_background) && !empty($color_button) && !empty($color_title) && !empty($color_text)) {
        echo ' <style id="rokit-campaign-styles">
            .u-bg-campaign {
                background-color: '.$color_background.';
            }

            .u-bg-cta-campaign {
                background-color: '.$color_button.';
            }

            .u-title-campaign {
                color: '.$color_title.';
            }

            .u-text-campaign {
                color: '.$color_text.';
            }

            .c-mask--campaign .c-mask__background {
                fill:  '.$color_background.';
            }
        </style>';
    }
}

add_action('rodesk_head', 'rodesk_campaign_custom_style');


/**
 *  Add custom title for tags taxonomy in meta boxes.
 */
function change_meta_box_titles() {
    global $wp_meta_boxes;
    $wp_meta_boxes['blog_article']['side']['core']['tagsdiv-blog_article_tag']['title'] = 'Tags';
    $wp_meta_boxes['article']['side']['core']['tagsdiv-article_tag']['title'] = 'Tags';
}
add_action('add_meta_boxes', 'change_meta_box_titles');

/**
 *  Add marketingautomation script in head
 */
function rokit_add_marketingautomation_script() {
    ?>
    <script type="text/javascript">
        var _ss = _ss || [];
        _ss.push(['_setDomain', 'https://koi-3QNJIEKQ16.marketingautomation.services/net']);
        _ss.push(['_setAccount', 'KOI-489ZMZ0K08']);
        _ss.push(['_trackPageView']);
        (function() {
            var ss = document.createElement('script');
            ss.type = 'text/javascript'; ss.async = true;
            ss.src = ('https:' == document.location.protocol ? 'https://' : 'http://') + 'koi-3QNJIEKQ16.marketingautomation.services/client/ss.js?ver=2.3.1';
            var scr = document.getElementsByTagName('script')[0];
            scr.parentNode.insertBefore(ss, scr);
        })();
    </script>
    <?php
}
add_action('wp_head', 'rokit_add_marketingautomation_script');

/**
 * Redirect shop to webshop landingpage
 */
function rokit_redirect_shop_to_webshop() {

    if (is_archive('product')){
        if (get_queried_object()->name == 'product'){
            wp_redirect(get_permalink(5536));
        }
    }
}

add_action('template_redirect', 'rokit_redirect_shop_to_webshop');

/**
 * Check timestamp from transient and published all missed posts
 */
function rokit_wpmsp_init() {

    //Max amount of post to publish in a load
    $max_amount = 20;

    // Amount of minutes between intervals
    $interval = 15 * MINUTE_IN_SECONDS;

    //get transient to check last time
    $last_scheduled_missed_time = get_transient( 'rokit_scheduled_missed_time' );

    //get current time in a timestamp
    $time = current_time( 'timestamp', 0 );

    // Check if last interval was less then $interval if it is return
    if ( false !== $last_scheduled_missed_time && absint( $last_scheduled_missed_time ) > ( $time - $interval ) ) {
        return;
    }

    //Set new transient
    set_transient( 'rokit_scheduled_missed_time', $time, $interval );

    global $wpdb;

    $sql_query = "SELECT ID FROM {$wpdb->posts} WHERE ( ( post_date > 0 && post_date <= %s ) ) AND post_status = 'future' LIMIT 0,%d";

    $sql = $wpdb->prepare( $sql_query, current_time( 'mysql', 0 ), $max_amount );

    $scheduled_post_ids = $wpdb->get_col( $sql );

    if ( ! count( $scheduled_post_ids ) ) {
        return;
    }

    foreach ( $scheduled_post_ids as $scheduled_post_id ) {
        if ( ! $scheduled_post_id ) {
            continue;
        }

        wp_publish_post( $scheduled_post_id );
    }
}

add_action( 'init', 'rokit_wpmsp_init', 0 );

/**
 * Add meta tag for verification of google
 */
function rokit_add_script_google(){
    echo '<meta name="google-site-verification" content="jTpB1S5ZYSVNCav_uPsBasACRqFs_mrBlDL0I0p4E8o" />';
}

add_action( 'rodesk_head', 'rokit_add_script_google', 0 );/**

/**
 * Add structure data to location post_type
 */
function rokit_add_structure_data(){
    if (is_singular('location')) {
        $location = \Rokit\Controllers\Collections\LocationCollection::post(get_the_id());

        $structure = [];
        $structure = rokit_get_structure_data($structure, 'context', 'global_context' );
        $structure = rokit_get_structure_data($structure, '@type', 'global_type' );
        $structure = rokit_get_structure_data($structure, 'type', 'global_type' );
        $structure = rokit_get_structure_data($structure, 'id', 'global_id' );
        if (!empty($images = rokit_get_structure_data_field('global_images'))){
            foreach ($images as $image){
                $structure['image'][] = wp_get_attachment_image_src($image['image'], 'full')[0];
            }
        }

        $structure['name'] = $location->title;
        $structure['address']['@type'] = 'PostalAddress';
        $structure['address']['streetAddress'] = $location->street();
        $structure['address']['postalCode'] = $location->zipcode();
        $structure['address']['addressLocality'] = $location->city();

        if ( !empty($location->image()) ) {
            $structure['image'][] = $location->image();
        }

        if ( !empty($location->latitude()) && !empty($location->longitude()) ){
            $structure['geo']['@type'] = $location->city();

            if ( !empty($location->latitude()) ){
                $structure['geo']['latitude'] = $location->latitude();
            }
            if ( !empty($location->longitude()) ){
                $structure['geo']['longitude'] = $location->longitude();
            }
        }

        if (!empty($op_stucture_data = $location->op_stucture_data())){
            $data = [];
            foreach ($op_stucture_data as $op){

                $data[] = [
                    "@type"     => "OpeningHoursSpecification",
                    "opens"     => $op['open'],
                    "closes"    => $op['close'],
                    "dayOfWeek" => $op['days'],

                ];
            }

            $structure['openingHoursSpecification']  = $data;
        }

        echo '<script type="application/ld+json">';
        echo json_encode($structure);
        echo '</script>';
    }
}

add_action( 'rodesk_head', 'rokit_add_structure_data', 0 );


/**
 * Fix upload path with a fix for envoyer.
 */
function rokit_fix_upload_path()
{
    Env::init();
    $dotenv = new Dotenv\Dotenv(rokit_root_dir_path());

    if (file_exists(rokit_root_dir_path() . '/.env')) {
        $dotenv->load();
        $dotenv->required(['WP_UPLOAD_PATH']);
        if (!empty(env('WP_UPLOAD_PATH'))) {
            update_option('upload_path', env('WP_UPLOAD_PATH'));
        }
    }

}
add_action('admin_init', 'rokit_fix_upload_path');


/**
 * Redirect user if current lang DE and is not logged in.
 */
function rokit_redirect_de_lang() {


    if (!is_user_logged_in() && pll_current_language() == 'de'){

        global $wp;
        $slug = $wp->request;

        wp_redirect('http://www.facelandclinic.com/' . str_replace('de/', 'de/betreibergesellschaft', $slug));
        exit;

    }
}

//add_action('template_redirect', 'rokit_redirect_de_lang');

function cookieDeclarion( $atts ) {
    return "<script id='CookieDeclaration' data-culture='NL' src='https://consent.cookiebot.com/728663b3-18d1-4fa3-a804-5658e0e8c18d/cd.js' type='text/javascript' async></script>";
}


function rokit_redirect_chirurgie() {
    $obj = get_queried_object();
    if($obj->slug == 'chirurgie' && $obj->taxonomy == 'ba_album_taxonomy'){
        $term = get_term( 613, 'treatment_type' );
        $term_link = get_term_link( $term );
        wp_redirect($term_link);
        exit;
    }
}

//add_action('template_redirect', 'rokit_redirect_chirurgie');