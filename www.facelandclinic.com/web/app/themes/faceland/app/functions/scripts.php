<?php
/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP scripts.php file
    This is the rokit theme scripts file

-----------------------------------------------------------------------------------*/

/**
 * Register and enqueue all the scripts and styles
 */

add_action('wp_enqueue_scripts', 'rokit_scripts', 100);

function rokit_scripts() {

    // Register the stylesheets
    wp_register_style('rokit_main_style', rokit_asset_path( 'styles/style.css' ), false, '1.0', 'all');
    wp_register_style('rokit_mobile_style', rokit_asset_path( 'styles/style-mobile.css' ), false, '1.0', 'all');
    wp_register_style('rokit_style_ie', rokit_asset_path( 'styles/style-ie.css' ), false, '1.0', 'all');
    wp_register_style('rokit_style_print', rokit_asset_path('styles/print.css' ), false, '1.0', 'print');
    wp_register_style('rokit_utility_style', rokit_asset_path( 'styles/utility.css' ), false, '1.0', 'all');

    wp_enqueue_style('lightgallery-css', rokit_asset_path( 'styles/lightgallery.css' ), array(), '1.0.0', 'all');
    wp_enqueue_style('lightgallery-zoom-css', rokit_asset_path( 'styles/lg-zoom.css' ), array(), '1.0.0', 'all');
    wp_enqueue_style('lightgallery-thumbnail-css', rokit_asset_path( 'styles/lg-thumbnail.css' ), array(), '1.0.0', 'all');
    wp_enqueue_style('mCustomScrollbar-css', rokit_asset_path( 'styles/swiper-bundle.min.css' ), array(), '1.0.0', 'all');

    // Register the scripts
    wp_register_script('rokit_main', rokit_asset_path('scripts/main.js'), true, null, true);
    wp_register_script('rokit_mobile', rokit_asset_path('scripts/mobile.js'), true, null, true);
    wp_register_script('rokit_vendors', rokit_asset_path('scripts/vendors.js'), true, null, true);
    wp_register_script('rokit_vendors_main', rokit_asset_path('scripts/vendors-main.js'), true, null, true);
    wp_register_script('rokit_new_price_page_js', rokit_asset_path('scripts/new-price-page.js'), true, null, true);
    wp_register_script('rokit_scrollbar', rokit_asset_path('scripts/swiper-bundle.min.js'), true, null, true);
    //wp_register_script('rokit_polyfill', "https://cdn.polyfill.io/v2/polyfill.js?features=Object.values,Array.from,Set,Array.prototype.includes,URL", true, null, true);
    wp_register_script('rokit_fontawesome', rokit_asset_path('scripts/a076d05399.js'), true, null, true);
    wp_register_script('rokit_jquery_cookie', rokit_asset_path('scripts/jquery.cookie.min.js'), true, null, true);
    wp_register_script('rokit_lottie_js', rokit_asset_path('scripts/lottie.min.js'), true, null, false);
    wp_register_script('rokit_lightgallery', rokit_asset_path('scripts/lightgallery.umd.js'), true, null, true);
    wp_register_script('rokit_lightgallery_zoom', rokit_asset_path('scripts/lg-zoom.umd.js'), true, null, true);
    wp_register_script('rokit_lightgallery_thumbnail', rokit_asset_path('scripts/lg-thumbnail.umd.js'), true, null, true);

    // Replace the default WP jQuery version
    wp_deregister_script('jquery');
    wp_register_script('jquery', rokit_asset_path('scripts/jquery.js'), true, '1.11.0', true);

    // Add filter hook to make IE conditional stylesheets
    add_filter('style_loader_tag', 'my_style_loader_tag_function');

    // Load css styles (depending if is repsonsive or not)
    if( rodesk_is_desktop() ){
        wp_enqueue_style('rokit_main_style');
    } elseif(rodesk_is_tablet()) {
        wp_enqueue_style('rokit_mobile_style');
    }else {
        wp_enqueue_style('rokit_mobile_style');
    }
    wp_enqueue_style('rokit_utility_style');

    // Load print styles if is desktop
    if( rodesk_is_desktop() ){
        wp_enqueue_style('rokit_style_print');
        wp_enqueue_style('rokit_style_ie');
    }

    // Dequeue block script styles
    wp_dequeue_style( 'wp-block-library' );         // Wordpress core
    wp_dequeue_style( 'wp-block-library-theme' );   // Wordpress core
    wp_dequeue_style( 'wc-block-style' );           // WooCommerce

    if (is_single() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    // load the header JS
    wp_enqueue_script('rokit_head');

    // Load jQuery
    wp_enqueue_script('jquery');

    wp_enqueue_script('rokit_lottie_js');
    
    wp_enqueue_script('rokit_lightgallery');
    wp_enqueue_script('rokit_lightgallery_zoom');
    wp_enqueue_script('rokit_lightgallery_thumbnail');
    


    // Load main JS (depending if is repsonsive or not)
    if( rodesk_is_desktop()){
        wp_enqueue_script('rokit_vendors_main');
        wp_enqueue_script('rokit_new_price_page_js');
        wp_enqueue_script('rokit_scrollbar');
        wp_enqueue_script('rokit_main');
        wp_enqueue_script('rokit_fontawesome');            
    } elseif(rodesk_is_tablet()) {
        wp_enqueue_script('rokit_vendors');
        wp_enqueue_script('rokit_new_price_page_js');
        wp_enqueue_script('rokit_scrollbar');
        wp_enqueue_script('rokit_mobile');
        wp_enqueue_script('rokit_fontawesome');            
    }else{
        wp_enqueue_script('rokit_vendors');
        wp_enqueue_script('rokit_new_price_page_js');
        wp_enqueue_script('rokit_scrollbar');
        wp_enqueue_script('rokit_mobile');
        wp_enqueue_script('rokit_fontawesome');
    }
    wp_enqueue_script('rokit_jquery_cookie');

    if(is_front_page() and pll_current_language() == 'be' or is_front_page() and pll_current_language() == 'be-fr'){
        wp_enqueue_script('rokit_jquery_cookie');
    }

    //load polyfill
    wp_enqueue_script('rokit_polyfill');



    // Add basic URL details as localized var so it can be used in JS
    $js_variables = array(
        'baseurl'               => get_home_url(),
        'ajaxurl'               => admin_url( 'admin-ajax.php' ),
        'current_pt'            => get_post_type() ? get_post_type() : false,
        'pt_archive_url'        => get_post_type_archive_link( get_post_type() ),
        'pt_singular_url'       => is_singular() ? get_permalink() : false,
        'environment'           => !empty(WP_ENV) ? WP_ENV : 'unkown',
        'showDisclaimer'        => ( is_home() || is_front_page() ) ? true : false
    );

    wp_localize_script( 'rokit_main', 'siteInfo', $js_variables);
    wp_localize_script( 'rokit_mobile', 'siteInfo', $js_variables);

};

/**
 * Use custom conditional header to load !IE stylesheet
 * @param  string $css_html_tag The old CSS loader tag
 * @return string               The new formatted CSS loader tag
 */

function my_style_loader_tag_function($css_html_tag){

    $style = str_replace('/styles/', '', rokit_asset_path('/styles/style.css','filename'));
    $style_ie = str_replace('/styles/', '', rokit_asset_path('/styles/style-ie.css','filename'));

    if (strpos($css_html_tag, $style ) !== false) {
        return "<!--[if (gt IE 8) | (IEMobile)]><!-->\n\t".$css_html_tag."\t<!---<![endif]-->\n";
    } elseif(strpos($css_html_tag, $style_ie ) !== false) {
        return "\t<!--[if (lt IE 9) | (!IEMobile)]>\n\t".$css_html_tag."\t<![endif]-->\n";
    } else {
        return "\t" .$css_html_tag;
    }
}

/**
 * Debug the loading of scripts and styles
 */

// add_action('wp_footer', 'fb_urls_of_enqueued_stuff');
// add_action('admin_footer', 'fb_urls_of_enqueued_stuff');

function fb_urls_of_enqueued_stuff( $handles = array() ) {
    global $wp_scripts, $wp_styles;

    // scripts
    foreach ( $wp_scripts -> registered as $registered )
        $script_urls[ $registered -> handle ] = $registered -> src;
    // styles
    foreach ( $wp_styles -> registered as $registered )
        $style_urls[ $registered -> handle ] = $registered -> src;
    // if empty
    if ( empty( $handles ) ) {
        $handles = array_merge( $wp_scripts -> queue, $wp_styles -> queue );
        array_values( $handles );
    }
    // output of values
    $output = '';
    foreach ( $handles as $handle ) {
        if ( ! empty( $script_urls[ $handle ] ) )
            $output .= $script_urls[ $handle ] . '<br />';
        if ( ! empty( $style_urls[ $handle ] ) )
            $output .= $style_urls[ $handle ] . '<br />';
    }

    echo $output;
}

add_filter('script_loader_tag', 'polyfill_add_defer_attribute', 10, 2);
function polyfill_add_defer_attribute($tag, $handle) {
    // Add handles of scripts you want to add async or defer attributes to
    $scripts_to_async = array('rokit_polyfill');

    foreach ($scripts_to_async as $async_script) {
        if ($async_script === $handle) {
            return str_replace(' src', ' defer="defer" src', $tag);
        }
    }
    return $tag;
}