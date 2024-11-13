<?php

/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP template-functions.php file
    This is the theme specific template functions file

-----------------------------------------------------------------------------------*/

use Rokit\Frame\Money\RokitMoney;

/**
 * Compile a piece of content with some variables
 *
 * @param   mixed   $content    String or array of contents
 * @param   array   $vars       Array of strings to replace
 * @return  void
 */
function rokit_compile($content, array $vars = []) {

    if(empty($content)) {
        return;
    }

    if(is_iterable($content)) {
        return array_map(function($content) use ($vars) {
            return Timber::compile_string($content, $vars);
        }, $content);
    } else {
        return Timber::compile_string($content, $vars);
    }
}

/**
 * Change required capabilities for redirection pluin
 *
 * @param   string $cap
 * @return  void
 */
function replace_redirection_cap($cap) {
    return 'edit_theme_options';
}
add_filter('redirection_role', 'replace_redirection_cap', 10, 1);

/**
 * Add redirection menu item to the dashboard menu
 * The Redirection plugin is installed in the tools menu
 * This menu is not allowed for client_admin user role
 * Therefor a custom menu item is required
 *
 */
function rokit_add_redirect_menu_icon(){
    add_menu_page( 'Redirects', 'Redirects', 'edit_theme_options', 'redirects_plugin_redirect', 'function', 'dashicons-admin-links', 100 );
}

add_action( 'admin_menu', 'rokit_add_redirect_menu_icon' );

function rokit_redirect_to_plugin() {

    $menu_redirect = isset($_GET['page']) ? $_GET['page'] : false;

    if($menu_redirect == 'redirects_plugin_redirect' ) {
        wp_safe_redirect( get_admin_url() . 'tools.php?page=redirection.php' );
        exit();
    }

}

add_action( 'admin_init', 'rokit_redirect_to_plugin', 1 );

/**
 * Checks the current page and check if footer border is needed
 * Return boolean
 */

function show_border_in_footer(){

    $singles = [
        'blog_article',
        'article',
        'treatment',
        'location',
        'ba_album',
        'offer',
        'specialist',
        'campaign'
    ];
    $archives = [
        'last_minute',
        'blog_article',
        'article',
        'offer',
        'last_minute',
        'academy',
        'faq',
        'video',
        'campaign'
    ];

    $taxonomies = ['ba_album_taxonomy'];
    $pages = [rokit_get_lang_id(1099), rokit_get_lang_id(143)]; // Use ID's inside rokit_get_lang_id()

    if (is_singular($singles) || is_post_type_archive($archives) || is_tax($taxonomies) || is_page($pages) || is_search()){
        return false;
    }

    return true;
}

/*
 * Check for existance of multiple keys in one array
 *
 * @param   array   $needles
 * @param   array   $haystack
 * @return  bool
 */
function array_keys_exist(array $needles, array $haystack){
    foreach ($needles as $needle){
        if ( ! array_key_exists($needle, $haystack)) return false;
    }

    return true;
}

/**
 * Format array of price details
 *
 * @param   array   $prices
 * @return  array
 */
function filter_prices_format(array $prices) {

    return array_map(function($price) {
        if(!empty($price['price'])) {
            $price['price'] = rokit_format_money($price['price']);
        }
        if(!empty($price['sale_price'])) {
            $price['sale_price'] = rokit_format_money($price['sale_price']);
        }

        return $price;
    }, $prices);

}

/**
 * Format a number to valid money format
 *
 * @param   string   $amount
 * @param   string   $locale
 * @return  string
 */
function rokit_format_money($amount, $locale=null) {
    $locale = !empty($locale) ? $locale : pll_current_language('locale');
    $locale = pll_current_language() == 'be' ? 'nl_NL': $locale;
    $locale = pll_current_language() == 'ch' ? 'FR_CH': $locale;

    $currency = pll_current_language() == 'ch' ? 'CHF': 'EUR';

    return rokitMoney::format($amount, $locale, $currency);
}

/**
 * Remove duplicates for multi dimensional array
 *
 * @param   array   $array
 * @return  array
 */
function rokit_array_unique(array $array) {
    return array_map("unserialize", array_unique(array_map("serialize", $array)));
}

/**
 * Check if post exists by slug.
 *
 * @param   string  $post_slug  The slug of the searched post
 * @param   string  $post_type  The post type of the searched post
 * @return  mixed               False if no posts exist; post ID otherwise.
 */
function rokit_exists_by_slug($post_slug, $post_type=null) {
    $post_type = !empty($post_type) ? $post_type : 'any';
    $query = new WP_Query(['post_type' => $post_type, 'post_status' => 'any', 'name' => $post_slug, 'posts_per_page' => 1, 'fields' => 'ids']);
    return ( $query->have_posts() ? $query->posts[0] : false );
}

/**
 * Check if taxonomy exists by name.
 *
 * @param string $name taxonomy name we must search
 * @param  string $taxonomy the taxonomy of the search for the given name
 * @return object return object of taxonomy we needed or returns false
 */
function rokit_exists_taxonomy_by_name($name, $taxonomy) {
    $taxonomy = !empty($taxonomy) ? $taxonomy : 'any';

    return get_term_by('name', $name, $taxonomy);
}

/**
 * Return Snap Pixel code
 *
 * @return  string  GA tracking codes
 */

function rokit_get_snap_pixel_code() {

    $id = 'd4dd88e0-a1fa-4557-a499-3103cc0def19';

    echo "<!-- Snap Pixel Code -->";
    echo "<script type='text/javascript'>";
    echo "(function(e,t,n){if(e.snaptr)return;var a=e.snaptr=function()";
    echo "{a.handleRequest?a.handleRequest.apply(a,arguments):a.queue.push(arguments)};";
    echo "a.queue=[];var s='script';r=t.createElement(s);r.async=!0;";
    echo "r.src=n;var u=t.getElementsByTagName(s)[0];";
    echo "u.parentNode.insertBefore(r,u);})(window,document,";
    echo "'https://sc-static.net/scevent.min.js');";
    echo "snaptr('init', '" . $id ."', {";
    echo "'user_email': '__INSERT_USER_EMAIL__'";
    echo "});";
    echo "snaptr('track', 'PAGE_VIEW');";
    echo "</script>";
    echo "<!-- End Snap Pixel Code -->";
}

add_action('rodesk_head','rokit_get_snap_pixel_code');

/**
 * Add TraceDock code.
 */
function rokit_add_trace_dock() {
    ?>
    <script>
        !function(e,t,n,r,o,i,u,c,a,l){a=n.getElementsByTagName("head")[0],(l=n.createElement("script")).async=1,l.src=t,a.appendChild(l),r=n.cookie;try{if(i=(" "+r).match(new RegExp("[; ]_tdbu=([^\\s;]*)")))for(u in o=decodeURI(i[1]).split("||"))(c=o[u].split("~~"))[1]&&(r.indexOf(c[0]+"=")>-1||(n.cookie=c[0]+"="+c[1]+";path=/;max-age=604800;domain=."+e,n.cookie="_1=1"))}catch(e){}
        }("facelandclinic.com","https://chef.facelandclinic.com/biuv.js",document)
    </script>
<?php
}

add_action('rodesk_head','rokit_add_trace_dock');

/**
 * $data is the data that contains data that might should be replaced
 * $find is the short-tag for the thing that should be replaced
 * $replace is the data that should be placed instead of $find
 *
 * Return data is de $data with the replaced content
 */

function rokit_replace_string_in_array($data, $find, $replace) {
    return str_ireplace($find, $replace, $data);
}


/**
 * Wordpress: Filter admin columns and remove yoast seo columns
 */
function yoast_seo_remove_columns( $columns ) {
    /* remove the Yoast SEO columns */
    unset( $columns['wpseo-score'] );
    unset( $columns['wpseo-title'] );
    unset( $columns['wpseo-metadesc'] );
    unset( $columns['wpseo-focuskw'] );
    unset( $columns['wpseo-score-readability'] );
    unset( $columns['wpseo-links'] );
    unset( $columns['wpseo-linked'] );
    return $columns;
}


function rokit_filter_yoast_columns() {

    $types = get_post_types(['public' => true]);

    foreach($types as $type) {
        $filter = "manage_edit-{$type}_columns";
        add_filter($filter, 'yoast_seo_remove_columns');
    }

}

add_action('admin_init', 'rokit_filter_yoast_columns');

function rokit_add_delay_class($index){

    if(rodesk_is_tablet()) {
        if ($index % 2 == 0) {
            return 'a-delay';
        }
    } elseif(rodesk_is_desktop()) {
        if ($index % 2 == 0) {
            return 'a-delay';
        }
        if ($index % 3 == 0) {
            return 'a-delay-lg';
        }
    }
}

/**
 * If show is true and id is set it adds the script to add the chat
 */
function rokit_load_chat(){
    $show = get_field('chat', 'option');
    $id = get_field('chat_id', 'option');

    if ( $show && !empty($id) && WP_ENV != 'development' ) {
        echo '
        <script id="obi-bots-launcher" src="https://cloudstatic.obi4wan.com/ngbots/obi-launcher.bundle.js"></script>
        <script>OBI.bots("'.$id.'");</script>';
        //echo '<script id="obi-chat-launcher" src="https://cloudstatic.obi4wan.com/chat/obi-launcher.js" data-guid="'.$id.'"></script>';
        //2c9ab7a4-30bf-4ddf-939f-c4519b3ef2ce
        //f1b4f67c-fa0e-4cfd-ab6a-812f5b5a6371 - older
    }
}

add_action('rodesk_footer', 'rokit_load_chat');

/**
 * Based on the current language it returns a aen code and generates the attribute based on the code
 */
function rokit_get_attribute_aen_code(){
    $aen = pll_current_language() == 'ch' ? 'AEN1402-1' : 'AEN1402-2';
    return 'data-aen="' . $aen .'"';
}

/**
 * generates a tag with calltracker intergration for phone number if span is true it returns this with a span instead of a href
 * @param $phone
 * @param $span
 * @return string
 */
function rokit_get_a_tag_aen_code($phone, $span=null){

    $string = $span ?
        '<span class="calltracker" '. rokit_get_attribute_aen_code() .'>' . $phone . '</span>' :
        '<a href="tel:' . $phone . '" class="calltracker" '. rokit_get_attribute_aen_code() .' title="' . $phone . '">' . $phone . '</a>';
    return $string;
}

/**
 * Get settings for current language
 *
 * @return array with all settings for current language
 */
function rokit_get_language_settings() {

    // Treatment detail settings
    $language['treatment']['specialists']       = get_field('language_treatment_specialists_show','option');
    $language['treatment']['before_after']      = get_field('language_treatment_before_after_show','option');
    $language['treatment']['faq']               = get_field('language_treatment_faq_show','option');
    $language['treatment']['reviews']           = get_field('language_treatment_review_show','option');

    //Global settings
    $language['general']['last-minute']         = get_field('language_general_last_minute_show','option');
    $language['general']['academy']             = get_field('language_general_academy_show','option');

    //Social settings
    $socials = ['youtube', 'facebook', 'instagram', 'pinterest', 'linkedin', 'tiktok', 'facebook_group'];
    foreach ($socials as $social){
        $language['socials'][$social]     = get_field('language_socials_' . $social,'option');
    }

    $default_lang = pll_default_language();

    //Menu lang settings
    foreach (pll_the_languages(['raw'=>1]) as $lang){
        $locale = str_replace('-', '_', $lang['locale']);
        $language['menu'][$lang['slug']] = $default_lang == $lang['slug'] ? get_option('options_language_in_menu') :   get_option('options_' . $locale . '_language_in_menu');
    }

    //Redirect lang settings
    foreach (pll_the_languages(['raw'=>1]) as $lang){
        $locale = str_replace('-', '_', $lang['locale']);
        $language['redirect'][$lang['slug']] = $default_lang == $lang['slug'] ? get_option('options_language_redirect_not_logged_users') :   get_option('options_' . $locale . '_language_redirect_not_logged_users');
    }

    //Sitemap lang settings
    foreach (pll_the_languages(['raw'=>1]) as $lang){
        $locale = str_replace('-', '_', $lang['locale']);
        $language['sitemap'][$lang['slug']] = $default_lang == $lang['slug'] ? get_option('options_language_in_sitemap') :   get_option('options_' . $locale . '_language_in_sitemap');
    }

    return $language;
}

/**
 * Check if flag needs to be displayed
 *
 * @param $slug string slug of lang to check
 * @return bool to show vlag
 */
function rokit_check_menu_lang($slug){
    $menu = rokit_get_language_settings()['menu'];
    if (array_key_exists($slug, $menu)){
        if (!empty($menu[$slug])){
            return (int)$menu[$slug];
        }
    }

    return false;

}

/**
 * Get value of field of structure data
 * @param $field string fieldname
 * @return mixed data
 */
function rokit_get_structure_data_field($field){
    return get_field("structure_data_" . $field, 'option');
}

/**
 * Get structure data.
 *
 * @param $data array with data
 * @param $key string key for array
 * @param $field string fieldname
 * @return mixed data
 */
function rokit_get_structure_data($data, $key, $field)
{
    if ($value = rokit_get_structure_data_field($field)) {
        $data[$key] = $value;
    }
    return $data;
}

/**
 * Format price string
 *
 * @param $prefix string prefix of price
 * @param $price string price
 * @return string
 */
function rokit_get_lowest_price_string($prefix, $price){
    return sprintf('%s %s', $prefix, $price);
}

/**
 * get menu from master domain
 */
function rokit_get_menu(){
    $request = wp_remote_get( 'https://www.facelandclinic.com/wp-json/rokit/v2/menu' );
    if( is_wp_error( $request ) ) {
        return false; // Bail early
    }
    $language_array = json_decode(wp_remote_retrieve_body( $request ));
    $beFrLanguageURL = str_replace(['/nl', '/be', '/ch', '/de', '/en-gb', '-fr' ], [], home_url());

    $additional_language_array = [
        0 =>  (object) [
            'slug' => 'be-fr',
            'name' => 'Français',
            'url' => $beFrLanguageURL.'/be-fr/'
        ],
        1 => (object) [
            'slug' => 'en-gb',
            'name' => 'United Kingdom',
            'url' => $beFrLanguageURL.'/en-gb/'
        ]
    ];

    if(pll_current_language() == 'en-gb') {
        //unset($language_array[3]);        
    }

    $langArray = array_merge($language_array,$additional_language_array);
    if(pll_current_language() == 'nl' || pll_current_language() == 'de') {
        $newSwapArray4 = $langArray[4];
        $newSwapArray3 = $langArray[3];
        $langArray[3] = $newSwapArray4;
        $langArray[4] = $newSwapArray3;
    }

    if(pll_current_language() == 'be') {
        $newSwapArray3 = $langArray[3];
        $newSwapArray4 = $langArray[4];
        $newSwapArray1 = $langArray[1];
        $newSwapArray0 = $langArray[0];
        $langArray[3] = $newSwapArray4;
        $langArray[4] = $newSwapArray3;
        $langArray[1] = $langArray[3];
        $langArray[3] = $newSwapArray1;
        $langArray[0] = $langArray[1];
        $langArray[1] = $newSwapArray0;
    }

    if(pll_current_language() == 'be-fr') {
        $newSwapArray3 = $langArray[3];
        $newSwapArray4 = $langArray[4];
        $newSwapArray1 = $langArray[1];
        $newSwapArray0 = $langArray[0];
        $langArray[3] = $newSwapArray4;
        $langArray[4] = $newSwapArray3;
        $langArray[1] = $langArray[3];
        $langArray[3] = $newSwapArray1;
        $langArray[0] = $langArray[1];
        $langArray[1] = $newSwapArray0;
        $newSwap1Array = $langArray[1]; 
        $newSwap2Array = $langArray[2];
        $langArray[2] = $newSwap1Array;         
        $langArray[1] = $newSwap2Array;          
    }

    if(pll_current_language() == 'ch') {
        $newSwapArray3 = $langArray[3];
        $newSwapArray4 = $langArray[4];
        $newSwapArray1 = $langArray[1];
        $newSwapArray0 = $langArray[0];
        $langArray[3] = $newSwapArray4;
        $langArray[4] = $newSwapArray3;
        $langArray[1] = $langArray[3];
        $langArray[3] = $newSwapArray1;
        $langArray[0] = $langArray[1];
        $langArray[1] = $newSwapArray0;
        $newSwap1Array = $langArray[1]; 
        $newSwap2Array = $langArray[2];
        $langArray[2] = $newSwap1Array;         
        $langArray[1] = $newSwap2Array;
        $newSwap2NArray = $langArray[2];
        $newSwap2N1Array = $langArray[1];
        $newSwap2N0Array = $langArray[0];
        $langArray[0] = $newSwap2NArray;
        $langArray[1] = $newSwap2N1Array;
        $langArray[2] = $newSwap2N0Array;
    }
    
    return $langArray;
}