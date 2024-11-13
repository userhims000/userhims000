<?php
/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP helpers.php file
    This is the main rokit theme helpers file

-----------------------------------------------------------------------------------*/

Use Rokit\Container\Container;
Use Rokit\PostTypes\PostType;
Use Rokit\PostTypes\PostTypeAdmin;
Use Rokit\PostTypes\Taxonomy;
Use Rokit\PostTypes\TaxonomyAdmin;

/**
 * Check for environment
 *
 */
function check_env() {
    return env('WP_ENV');
}

/**
 * Get the base path of the theme
 * Because WP thinks the theme root is in resources
 *
 */

function get_theme_base() {

    $theme_base = str_replace('resources', '', get_theme_file_path());

    return $theme_base;

}

/**
 * Get the rokit container.
 *
 * @param string    $abstract
 * @param array     $parameters
 * @param Container $container
 * @return Container|mixed
 */

function rokit($abstract = null, $parameters = [], Container $container = null) {

    $container = $container ?: Container::getInstance();

    if (!$abstract) {
        return $container;
    }

    return $container->bound($abstract)
        ? $container->makeWith($abstract, $parameters)
        : $container->makeWith("rokit.{$abstract}", $parameters);

}

/**
 * Get / set the specified configuration value.
 *
 * If an array is passed as the key, we will assume you want to set an array of values.
 *
 * @param array|string  $key
 * @param mixed         $default
 * @return mixed|\Rokit\Config\Config
 * @copyright           Taylor Otwell
 * @link https://github.com/laravel/framework/blob/c0970285/src/Illuminate/Foundation/helpers.php#L254-L265
 */

function config($key = null, $default = null) {

    if (is_null($key)) {
        return rokit('config');
    }

    if (is_array($key)) {
        return rokit('config')->set($key);
    }

    return rokit('config')->get($key, $default);
}

/**
 * Format date to a specific format and language
 * Use the WP mysql2date function
 *
 * @param  string   $format   ACF field object
 * @param  string   $date     ACF field object
 * @return string             Formatted date in correct language
 */

function rokit_dateformat( $date, $format ) {

    return mysql2date( $format, $date );

}

/**
 * Convert array of WP_Post objects to an array of timber objects
 *
 * @param  array    $post_array     Array of WP_Post objects
 * @return array                    Array of timber ojbects
 */

function rokit_convert_wp_posts( array $post_array ) {

    $converted_array = [];

    if( !empty( $post_array ) ) {
        foreach( $post_array as $post ) {
            $converted_array[] = rokit_convert_to_timber( $post );
        }
    }

    return $converted_array;

}

/**
 * Convert a WP_Post object to a timbet object
 *
 * @param  WP_Post  $post_obect     The WP_Post obejec to be converted
 * @return object                   Timber ojbect
 */

function rokit_convert_to_timber( WP_Post $post_object ) {

    if( $post_object->post_type && $post_object->ID ) {

        $post_type  = $post_object->post_type;
        $post_id    = $post_object->ID;

        $controller_type    = rokit_timber_collection_class( $post_type );
        $controller         = new $controller_type;
        $converted_post     = $controller::post( $post_id );

        return $converted_post;

    }

}

/**
 * Get the correct page template based on ID or slug
 *
 * @param  integer  $page_id    The ID of the page
 * @return boolean               True or false
 */
function rokit_get_page_template( $page_id = '' ) {

    global $post, $params;

    // Define page template location
    $template_path = rokit_get_template_folder('page');

    // If no page ID is defined try to grab it from global object
    if( empty( $page_id ) && !empty( $post->ID ) ) {
        $page_id = $post->ID;
    }

    // If this ia search page skip logics
    if( is_search() ) {

        $page_slug = 'search';

    } else {

        // Check if page ID is defined and get slug from that
        if( !empty( $page_id ) ) {

            // Check if multilang is defined
            // If needed request original post ID for default language
            if( function_exists('pll_get_post') ) {
                $page_id = pll_get_post( $page_id, pll_default_language() );
            }

            // Get post slug from ID
            $post_object    = get_post( $page_id );
            $page_slug      = $post_object->post_name;

        }

    }

    // First check if page by ID is found
    // Then check if page bij slug is found
    if( file_exists( TEMPLATEPATH . '/' . $template_path . $page_id . '.twig' ) ) {
        return $page_id;
    } elseif( file_exists( TEMPLATEPATH . '/' . $template_path . $page_slug . '.twig' ) ) {
        return $page_slug;
    }

    return false;

}

/**
 * Clean up the options of a dashboard filter options arrat
 *
 * @param  array   $options         A list of the avialbale options
 */
function rokit_filter_truefalse( $options ) {

    if( !empty( $options ) && is_array( $options ) ) {
        foreach( $options as $option ) {
            if( !empty( $option ) ) {
                $option_formatted[] = __('Ja', 'faceland');
            } else {
                $option_formatted[] = __('Nee', 'faceland');
            }
        }
    }

    if( !empty( $option_formatted ) ) {
        return $option_formatted;
    } else {
        return $options;
    }

}

/**
 * Return the content of the first content module that matches a specific type
 * The parsed fields should only include text fields
 *
 * @param  array   $modules             The content modules of a post
 * @param  array   $allowed_modules     A list of the allowed ontent modules (array with module name => module field)
 * @return string                       The content of the first module that matches one from the allowd modules list
 */

function rokit_return_first_content_module($modules, $allowed_modules =[ 'intro' => 'intro', 'title_text' => 'text' ] ) {

    $layouts = [];

    if(!empty($modules) && is_array($modules)) {

        foreach($modules as $module) {
            if(array_key_exists($module['acf_fc_layout'], $allowed_modules)) {
                $module_field   = $module[$allowed_modules[$module['acf_fc_layout']]];
                $layouts[]      = wp_strip_all_tags( $module_field );
            }
        }

        if( !empty( $layouts ) && is_array( $layouts ) ) {
            return $layouts[0];
        }

        return;

    }

    return;

}

/**
 * Return the image of the first images module that matches a specific type
 * The parsed fields should only include image fields
 *
 * @param  array   $modules             The content modules of a post
 * @param  array   $allowed_modules     A list ofthe allowed image modules
 * @return string                       The content of the first module that matches one from the allowd modules list
 */

function rokit_return_first_image_module( $modules, $allowed_modules = array( 'image' ) ) {

    $layouts = array();

    if ( !empty( $modules ) &&  is_array( $modules ) ) {

        foreach ( $modules as $module ) {

            if ( in_array( $module['acf_fc_layout'], $allowed_modules ) ) {

                if ( $module['acf_fc_layout'] == 'image' ) {

                    $layouts[] = wp_strip_all_tags( $module['image'] );

                }

            }

        }

        if( !empty( $layouts ) && is_array( $layouts ) ) {

            $layout = $layouts[0];

            return $layout;

        }

        return;

    }

    return;

}

/**
 * Return the summary fields of a post
 * This summary is grabbed from a custom field
 * This field can be filtered per post type (rokit/{$post_type}/postsummary)
 *
 * @param  integer $post_id The ID of the post
 * @return string           The name of the summary field
 */

function rokit_get_post_summary_field( $post_id = null ) {

    if( empty( $post_id ) || !is_numeric( $post_id ) ) {
        global $post;

        if( empty( $post ) || !is_object( $post ) ) {
            return;
        }

        $post_id = $post->ID;

    }

    $post_type      = get_post_type( $post_id );
    $summary_field  = 'intro_' . $post_type;
    $summary_field  = apply_filters( "rokit/{$post_type}/postsummary", $summary_field );

    if( !empty( $summary_field ) ) {
        return $summary_field;
    }

    return false;
}

/**
 * Get the timber archive conteoller class to be used
 *
 * @param  string $post_type The post type to request the controller class for
 * @return string            The requested Timber class
 */

function rokit_timber_collection_class( $post_type = null ) {

    global $params;

    if ( ! $post_type ) {

        if( is_search() ) {
            $post_type = 'search';
        } else {
            $post_type = !empty( get_query_var( 'post_type' ) ) ? get_query_var( 'post_type' ) : get_post_type();
        }

    }
    // Define the namespace for archive controllers
    $namespace = 'Rokit\Controllers\Collections\\';

    // Define the archive controller class bases on post type name
    $archive_class = $namespace . rokit_camelize($post_type) . 'Collection';

    // Load default class if specified class is not found
    if ( ! class_exists( $archive_class ) ) {
        $archive_class = $namespace . 'PostCollection';
    }

    return $archive_class;

}


/**
 * Get the timber term controller class to be used
 *
 * @param  string $taxonomy     The taxonomy to request the controller class for
 * @return string               The requested Timber class
 */

function rokit_timber_term_class( $taxonomy = null ) {

    global $params;

    if ( ! $taxonomy ) {
        $taxonomy = get_query_var( 'taxonomy' );
    }

    // Define the namespace for archive controllers
    $namespace = 'Rokit\Controllers\Terms\\';

    // Define the archive controller class bases on post type name
    $taxonomy_class = $namespace . rokit_camelize( $taxonomy ) . 'Term';

    // Load default class if specified class is not found
    if ( ! class_exists( $taxonomy_class ) ) {
        $taxonomy_class = $namespace . 'Term';
    }

    return $taxonomy_class;

}

/**
 * Get the timber single controller class to be used
 *
 * @param  string $post_type The post type to request the controller class for
 * @return string            The requested Timber class
 */

function rokit_timber_type_class( $post_type = null ) {

    global $params, $post;

    if ( ! $post_type ) {
        $post_type = !empty( get_query_var( 'post_type' ) ) ? get_query_var( 'post_type' ) : get_post_type();
    }

    // Define the namespace for type controllers
    $namespace_posts = 'Rokit\Controllers\Types\\';
    $namespace_pages = 'Rokit\Controllers\Pages\\';


    // Find a better and more dynamic way to do this
    if( is_page() ) {

        $page_id = $post->ID;

        // If lang function is defined
        // Get the language independent page ID
        if( function_exists( 'rokit_get_lang_id' ) ) {
            $page_id = rokit_get_lang_id( $post->ID, 'post', pll_default_language() );
        }

        // If page load specific title based controller
        $post_class = $namespace_pages . 'Page' . rokit_camelize( $page_id );

    } else if( is_404() ) {

        // If 404 load specific controller
        $post_class = $namespace_pages . 'Page404';

    } else {

        // If post load specific post type based controller
        $post_class = $namespace_posts . rokit_camelize( $post_type );
    }

    // Load default class if specified class is not found
    if ( ! class_exists( $post_class ) ) {

        if( is_page() ) {

            // Load page controller for pages
            $post_class = $namespace_pages . 'Page';

        } else {

            // Load post controller for pages
            $post_class = $namespace_posts . 'Post';

        }
    }

    return $post_class;

}

/**
 * Locate and find the Rokit template folders
 *
 * @param  string   $type   [description]
 */
function rokit_get_template_folder( $type ) {

    if( $type == 'archive' ) {
        $type = 'archives/archive-';
    } elseif( $type == 'single' ) {
        $type = 'singles/single-';
    } elseif( $type == 'taxonomy' ) {
        $type = 'taxonomies/taxonomy-';
    } else {
        $type = 'pages/page-';
    }

    $type = apply_filters( "rokit/templates/", $type );

    return $type;

}

/**
 * Render the correct twig template
 *
 * @param  string $type     The type of template to render (archive, single, taxonomy, page)
 * @param  string $template The name of the template to render
 * @param  array  $data     The data object to be passed to the template
 */

function rokit_render_twig( $type, $template, $data = array() ) {

    $template_folder = rokit_get_template_folder( $type );


    if ( post_password_required() ) {
        $data['password_form'] = get_the_password_form();
        Timber::render( $template_folder . 'password-protected.twig', $data );
    }else{

        // Try to grab the needed timber template
        $render = Timber::render( $template_folder . $template . '.twig', $data );


        // If not defined load the default template
        if( empty( $render ) ) {
            Timber::render( $template_folder . 'default.twig', $data );
        }
    }
}

/**
 * Removes the default WYSIWYG editor from pages.
 *
 * @param string $post_type The post type that was registered.
 */

function rokit_modify_post_types( $post_type ) {

    // After the creating of the page post type, modify it
    if ( 'page' == $post_type ) {
        remove_post_type_support( $post_type, 'editor' );
    }

}

add_action( 'registered_post_type', 'rokit_modify_post_types', 10, 2 );

/**
 * Truncate a string and add ... if string is longer
 *
 * @param  string  $text  The input text
 * @param  integer $chars The max number of characters
 * @return string         The truncated string with ... appended is the string is longer than the max characters parameter
 */

function rokit_truncate( $text, $chars = 250, $dots = true ) {

    if ( strlen( $text ) >= $chars ) {

        $text = substr( $text, 0, $chars );
        $text = substr( $text, 0, strrpos( $text,' ' ) );

        if( !empty( $dots ) ) {
            $text = $text . " ...";
        }


    }

    return $text;

}

/**
 * Convert dashes to camelcase
 */

function rokit_camelize($input, $separator = null) {
    $separator = !empty($separator) ? $separator : ['-', '_'];
    $studly = ucwords(str_replace($separator, ' ', $input));
    return str_replace(' ', '', $studly);
}

/**
 * Format the assets path for a specific asset
 *
 * @param  string $asset The path of the requested asset.
 * @param  string $type  The type of value to return (uri|filename)
 * @return string        The full URL of the requested asset.
 */

 function rokit_asset_path( $asset, $type = 'uri' ) {

    $asset = ltrim( $asset ,'/');

    if( $type == 'filename' ) {
        $output = rokit('assets')->get( $asset );
    } else {
        $output = rokit('assets')->getUri( $asset );
    }

    $output = apply_filters( 'rokit/assets/path', $output );

    return $output;
}

/**
 * Get the HTML for a static image based on it's params
 *
 * @param  string   $src                The URL of the image
 * @param  string   $ratio              The ratio of the image (height/width)
 * @param  string   $title              The title to use for this image
 * @param  string   $class              The CSS class to use for this image
 * @param  bool     $lazyload           Lazyload this image or not
 * @return string                       URL or path to image
 */

function rokit_get_static_image($src, $ratio = '1', $title = null, $class = null, $lazyload = true) {

    if( !empty( $lazyload ) ) {

        // Add the lazy load class to the class string
        $class = $class . ' js-lazy-load';

        // Format the lazy load image string
        $image_string = '<img %1$s data-aspect="%2$s" data-src="%3$s" data-src-retina="%4$s" src="" %5$s>';

    } else {

        // Format the default image string
        $image_string = '<img %1$s src="%3$s" %5$s>';
    }

    $src        = rokit_asset_path($src);
    $class      = !empty($class) ? 'class="' . $class . '"' : '';
    $title      = !empty($title) ? 'alt="' . $title . '"' : '';

    $image = sprintf(
        $image_string,
        $class,
        $ratio,
        $src,
        $src,
        $title
    );

    return $image;

}

/**
 * Get get post permalink based on id
 *
 * @return  string  returns slug of current page
*/

function rokit_get_post_permalink( $post_id ) {

  return  get_post_permalink( $post_id );

}

/**
 * Get get query param from query string
 *
 * @return  string  returns slug of current page
*/

function rokit_is_decimal( $value ){
    return is_numeric($value) && floor($value) != $value;
}

/**
 * Get get query param from query string
 *
 * @return  string  returns slug of current page
*/

function rokit_get_query_param( $param ) {
    if (isset($_GET[$param])) {
        return $_GET[$param];
    }
    return null;
}

/**
 * Get news description from Content Modules - Intro section in blogs
 *
 * @return  string  returns slug of current page
*/

function rokit_get_news_description( $post_id ){

    $news_description = get_post_meta($post_id,'modules_0_intro',true);
    return $news_description;

}

/**
 * Get bodypart name by the treatment post in - from content module related treatment component
 *
 * @return  string  bodypart name
*/

function rokit_get_treatment_bodypart( $post_id ){

    // Get the terms associated with the post.
    $terms = wp_get_post_terms($post_id, 'treatment_bodypart');
    foreach ($terms as $term) {
        $termsArray[] = [
            'term_name' =>  $term->name,
            'term_url' =>  get_term_link($term)
        ];
    }
    return $termsArray;
}


/**
 * Checks current page's slug if it is an archive get post-type and as a fileback it generates a random number
 *
 * @return  string  returns slug of current page
 */
function rokit_get_view_name(){

    global $post;


    if ( is_archive() ) {

        $slug = get_post_type();

    }
    elseif (!empty($post) and $post->post_name == true ) {

        $slug=$post->post_name;

    }
    else {
        $slug = 'default';
    }

    return $slug;
}

/**
 * Get the HTML for a WP attachment image based on it's params
 *
 * @param  integer  $attachment_id      The WP post ID of the attachment
 * @param  string   $size               The size to use for this image
 * @param  string   $title              The title to use for this image
 * @param  string   $class              The CSS class to use for this image
 * @param  bool     $lazyload           Lazyload this image or not
 * @param  bool     $matchheight        Matchheight this image or not
 * @return string                       URL or path to image
 */

function rokit_get_image($attachment_id, $size = 'full', $title = null, $class = null, $lazyload = true, $matchheight = false) {

    if(empty($attachment_id)) {
        return;
    }

    if( !empty( $lazyload ) ) {

        // Add the lazy load class to the class string
        $class = $class . ' js-lazy-load';

        $image_dimensions = wp_get_attachment_image_src($attachment_id, 'full');

        $width = is_array($image_dimensions) ? esc_attr($image_dimensions[1]) : '';
        $height = is_array($image_dimensions) ? esc_attr($image_dimensions[2]) : '';

        // Format the lazy load image string
        $image_string = '<img %1$s data-aspect="%2$s" data-src="%3$s" data-src-retina="%4$s" %5$s %6$s src="" width="' . esc_attr($width) . '" height="' . esc_attr($height) . '">';

    } else {

        // Format the default image string
        $image_string = '<img %1$s src="%3$s" %5$s>';
    }

    $class              = !empty($class) ? 'class="' . $class . '"' : '';
    $title              = !empty($title) ? 'alt="' . $title . '"' : 'alt="' . rokit_get_image_alt($attachment_id) . '"';
    $ratio              = rokit_get_ratio( $size );
    $attachment         = rokit_get_attachment($attachment_id,$size);
    $attachment_retina  = rokit_get_attachment($attachment_id,$size . '-retina');
    $matchheight        = !empty($matchheight) ? 'data-trigger-matchheight="1"' : '';

    $image = sprintf(
        $image_string,
        $class,
        $ratio,
        $attachment,
        $attachment_retina,
        $title,
        $matchheight
    );

    return $image;

}

/**
 * Get the alt for a WP attachment image based on it's id
 *
 * @param  integer  $attachment_id      The WP post ID of the attachment
 * @return string                       alt tekst
 */
function rokit_get_image_alt($attachment_id) {

    if(empty($attachment_id)) {
        return;
    }

    return get_post_meta($attachment_id, '_wp_attachment_image_alt', true) ? get_post_meta($attachment_id, '_wp_attachment_image_alt', true) : get_the_title();

}

/**
 * Get attachment url from post meta field
 *
 * @param  integer  $attachment_id  The WP post ID of the attachment
 * @param  string   $size           Name of the image size (default:full)
 * @param  bolean   $responsive     True or False. Load seperate image for mobile devices (default:true)
 * @return string                   URL or path to image
 */

function rokit_get_attachment( $attachment_id, $size = 'full', $responsive = true ) {

    // Check if the given image size is defined
    // If not defined return full
    if (!rokit_check_image_size( $size )) {
        $size = 'full';
    }

    if ( $responsive == true && rodesk_is_mobile() && false === strpos( $size, '-mobile' ) ) {
        if( $size != 'full' ) {
            $size = $size . '-mobile';
        }
    }

    if( $attachment_id ) {
        $image  = wp_get_attachment_image_src( $attachment_id, $size );
        $image  = $image[0];
    }

    if( !empty( $image ) ) {
        return $image;
    }

    return false;

}


/**
 * Check if a given image size is defined
 *
 * @param  bolean   $string     The name of the image size
 * @return bolean
 */

function rokit_check_image_size( $size ) {

    if( empty( $size ) ) {
        return false;
    }

    $image_sizes = rokit_image_sizes();

    if( !empty( $image_sizes ) && is_array( $image_sizes ) ) {

        if( !empty( $image_sizes[ $size ] ) && is_array( $image_sizes[ $size ] ) ) {
            return true;
        }

    }

    return false;

}

/**
 * Get the ratio of an image
 * This is calculated by height / width

 * @param  string   $size   The WP images size (must be defined in wp first)
 * @return integer          Calculated image ratio
 */

function rokit_get_ratio( $size ) {

    $image_sizes = rokit_image_sizes();

    if( !empty( $image_sizes[ $size ] ) ) {

        $image_size = $image_sizes[ $size ];

        $width      = $image_size[ 'width' ];
        $height     = $image_size[ 'height' ];

        if( ( !empty( $width ) && is_numeric( $height ) ) && ( !empty( $height ) && is_numeric( $height ) ) ) {
            $ratio = $height / $width;
        }

    }

    if( !empty( $ratio ) ) {
        return $ratio;
    }

    return false;

}

/**
 * Get size information for all currently-registered image sizes.
 *
 * @global $_wp_additional_image_sizes
 * @uses   get_intermediate_image_sizes()
 * @return array $sizes Data for all currently-registered image sizes.
 */

function rokit_image_sizes() {
    global $_wp_additional_image_sizes;

    $sizes = array();

    foreach ( get_intermediate_image_sizes() as $_size ) {
        if ( in_array( $_size, array('thumbnail', 'medium', 'medium_large', 'large') ) ) {
            $sizes[ $_size ]['width']  = get_option( "{$_size}_size_w" );
            $sizes[ $_size ]['height'] = get_option( "{$_size}_size_h" );
            $sizes[ $_size ]['crop']   = (bool) get_option( "{$_size}_crop" );
        } elseif ( isset( $_wp_additional_image_sizes[ $_size ] ) ) {
            $sizes[ $_size ] = array(
                'width'  => $_wp_additional_image_sizes[ $_size ]['width'],
                'height' => $_wp_additional_image_sizes[ $_size ]['height'],
                'crop'   => $_wp_additional_image_sizes[ $_size ]['crop'],
            );
        }
    }

    return $sizes;
}

/**
 * Check if request is AJAX request
 *
 * @return bolean returns true/false
 */

function rokit_is_ajax() {

    // Check if this is an AJAX request
    if ( !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest' ) {
        return true;
    }

    return false;
}

/**
 * Get page ID by slug
 *
 * @param  string   $page   The slug of the page
 * @return mixed            The ID of the page or false
 */

function rodesk_page_slug( $page_slug ) {

    if( empty( $page_slug ) ) {
        return;
    }

    $page = get_page_by_path( $page_slug );

    if( !empty( $page ) && is_object( $page ) ) {
        return $page->ID;
    }

    return false;
}

/**
 * Check if archive navigation is needed.
 *
 * @return bool Whether archive navigation is needed
 */

function rokit_show_posts_nav() {
    global $wp_query;
    return ($wp_query->max_num_pages > 1);
}

/**
 * Format a phone number for use in anchor elements.
 *
 * @param  string $number Phone number to format
 * @return string         Formatted phone number
 */

function rokit_tel_nr( $number ) {

    if( !isset( $number ) || empty( $number ) )
        return false;

    $number = str_replace('(0)', '', $number);
    return 'tel:' . preg_replace("/[^A-Za-z0-9]/", "", $number);
}

/**
 * Get a link to Google maps directions by company name.
 *
 * @return string URL to the directions page
 */

function rokit_maps_direction( $name ) {

    if( !isset( $name ) || empty( $name ) )
        return false;

    $google_maps_links = 'https://www.google.nl/maps/place/' . $name;
    return $google_maps_links;
}

function is_element_empty($element) {
    $element = trim($element);
    return empty($element) ? false : true;
}

/**
 * Slugify string
 * @param $text string to slugify
 * @return string string that is slugified
 */
function rokit_slugify($text){
    // replace non letter or digits by -
    $text = preg_replace('~[^\pL\d]+~u', '-', $text);

    // transliterate
    $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

    // remove unwanted characters
    $text = preg_replace('~[^-\w]+~', '', $text);

    // trim
    $text = trim($text, '-');

    // remove duplicate -
    $text = preg_replace('~-+~', '-', $text);

    // lowercase
    $text = strtolower($text);

    if (empty($text)) {
        return 'n-a';
    }

    return $text;
}

/**
 * Get information if Facecard needs to show
 * @return array with settings
 */
function rokit_price_settings(){

    $object_id = get_queried_object_id();

    if (empty($object_id)){
        return false;
    }


    $field_prefix = 'price_archive_';
    $post_fix = "";
    if ($object_id == 136){
        //botox
        $post_fix = 'botox';

    } elseif ($object_id == 137){
        //fillers
        $post_fix = 'filler';

    } elseif ($object_id == 138){
        //Surgery
        $post_fix = 'surgery';
    } elseif ($object_id == 476) {
        //christmas
        $post_fix = 'christmas';
    }
    
    return [
        'facecard'  => get_field($field_prefix . 'show_facecard', 'price_type' . '_' . $object_id),
        'toggle'    => get_field($field_prefix . 'show_toggle', 'price_type' . '_' . $object_id),
        'show_christmas_price_list' => get_field('price_show_type_christmas', 'price_type' . '_' . $object_id),
        'show_christmas_price_list_column' => get_field('show_christmas_column', 'price_type' . '_' . $object_id),
        'show_christmas_price_list_column_heading' => [
            'first' => get_field('christmas_column_heading_first', 'price_type' . '_' . $object_id),
            'second' => get_field('christmas_column_heading_two', 'price_type' . '_' . $object_id),
            'third' => get_field('christmas_column_heading_three', 'price_type' . '_' . $object_id),
            'fourth' => get_field('christmas_column_heading_four', 'price_type' . '_' . $object_id)
        ]
    ];
    /*return [
        'facecard'  => get_field( $field_prefix . 'facecard_show_' . $post_fix ,'option' ),
        'toggle'    => get_field( $field_prefix . 'toggle_' . $post_fix ,'option' )
    ];*/

}

/**
 * Added scripts per page for the NL language
 */
function set_scripts_per_pages() {
    global $post;
    $currentLanguage =  pll_current_language();
    if( $currentLanguage !== "nl" && $currentLanguage !== "ch" ){
        return;
    }
    if( is_page() === false && is_single() === false){
        return;
    } 
    $mapping = [
        'oorlel' => ['voor_na', 'oorlel' ],
        'full-face-treatment' => ['voor_na', 'fullface' ],
        'lydia-oostveen-bol' => ['voor_na', 'lydiabol' ],
        'david-yama-hamraz' => ['voor_na', 'davidhamraz' ],
        'alicja-samul' => ['voor_na', 'alicjasamul' ],
        'amit-atwal' => ['voor_na', 'amitatwal' ],
        'limke-strikkers' => ['voor_na', 'limkestrikkers' ],
        'nicoline-nijman' => ['voor_na', 'nicolinenijman' ],
        'dionne-deibel' => ['voor_na', 'dionnedeibel' ],
        'alexander-rakic' => ['voor_na', 'alexanderrakic' ],
        'britt-mesman' => ['voor_na', 'brittmesman' ],
        'nicoletta-daniolos' => ['voor_na', 'nicolettadaniolos' ],
        'broos-van-alphen' => ['voor_na', 'broosvanalphen' ],
        'aarent-brand' => ['voor_na', 'aarentbrand' ],
        'milad-fahim' => ['voor_na', 'miladfahim' ],
        'merel-laboyrie' => ['voor_na', 'merellaboyrie' ],
        'marvin-eyra' => ['voor_na', 'marvineyra'],
        'diana-al-hadidi' => ['voor_na', 'dianaalhadidi'],
        'barof-sanaan' => ['voor_na', 'barofsanaan']       
    ];
    if(isset($mapping[$post->post_name])) {
           return setFlowboxScripts($mapping[$post->post_name]);
    }
}
add_action('wp_enqueue_scripts', 'set_scripts_per_pages');

/**
 * Added common flobox script in the pages
 */
function setFlowboxScripts( $pageArgument ){
    ?>
        <script type="text/javascript">
            (function(d, id) {
            if (!window.flowbox) { var f = function () { f.q.push(arguments); }; f.q = []; window.flowbox = f; }
            if (d.getElementById(id)) {return;}
            var s = d.createElement('script'), fjs = d.scripts[d.scripts.length - 1]; s.id = id; s.async = true;
            s.src = ' https://connect.getflowbox.com/flowbox.js';
            fjs.parentNode.insertBefore(s, fjs);
            })(document, 'flowbox-js-embed');
        </script>
    <?php
}

/**
 * Redirect after appointment booked on the thank you page.
 */
add_action( 'after_setup_theme', 'appointment_booked_after_redirection' );
function appointment_booked_after_redirection() {
    $current_url="//".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
    $parsed = parse_url($current_url);
    if(is_array($parsed) && array_key_exists("query",$parsed)){
        $query = $parsed['query'];
        parse_str($query, $params);
        if ( isset($params["location"]) && !empty($params["location"]) ) {
            ob_start();
            $params["location"] = "";
            $url_string = http_build_query($params);
            if( strpos($parsed['path'],'/nl') !== false ){
                $thankyoupage = 'nl/bedankpagina-afspraak';
            }else if( strpos($parsed['path'],'/ch') !== false ){
                $thankyoupage = 'ch/bestaetigung-buchung';
            }else if( strpos($parsed['path'],'/be') !== false ){
                $thankyoupage = 'be/boekingsbevestiging';
            }else if( strpos($parsed['path'],'/be-fr') !== false ){
                $thankyoupage = 'be-fr/page-de-remerciement-rendezvous';
            }else if( strpos($parsed['path'],'/en') !== false ){
                $thankyoupage = 'en/thank-you';
            }
            $page = get_page_by_path( substr($thankyoupage, strrpos($thankyoupage, '/') + 1) );
            $pagePostName = '';
            if(is_object($page) && !is_null($page)){
                $pagePostName = $page->post_name;
            }
            if($pagePostName == $thankyoupage){
                wp_redirect( home_url( '/' ).$thankyoupage.'/?'.$url_string);
                exit();
            }
            ob_clean();
        }
    }
}

/**
 * Added facebook domain verification metatag for the home page.
 */
add_action('wp_head', 'facebook_donain_verification');
function facebook_donain_verification() {
    if ( function_exists('yoast_breadcrumb') ) {
      yoast_breadcrumb( '','' );
    }
    if( is_front_page() ) { ?>
        <meta name="facebook-domain-verification" content="tuqzing89v6vs661huh4d5i4yquenj" />
    <?php }  
}

add_filter('wpseo_breadcrumb_output', 'custom_breadcrumb_output');
function custom_breadcrumb_output($output) {
  $output = preg_replace('/<span\b[^>]*>/', '', $output);
  $output = preg_replace('/<\/span>/', '', $output);
  return;
}

add_filter( 'wpseo_breadcrumb_links', 'custom_wpseo_breadcrumb_output' );
function custom_wpseo_breadcrumb_output( $links ){
    $lastElement = end($links);
    unset($lastElement['url']);
    array_pop($links);
    $links[] = $lastElement;
    $newLinksArray = [];
    foreach ($links as $key => $value) {
        if(empty($value['text']) && isset($value['url'])){
            $getLastParameterOfURL =  substr(strrchr(rtrim($value['url'], '/'), '/'), 1);
            $value['text'] = ucfirst($getLastParameterOfURL);
        }
        $newLinksArray[] = $value;
    }
    array_unshift($newLinksArray,"");
    unset($newLinksArray[0]);
    ?>
    <script type="application/ld+json">
        <?php
        $newJsonArray = [];
        foreach($newLinksArray as $key => $value){
            $arr = [
               '@type' => 'ListItem',
               'position' => $key,
               'name' => $value['text'],
            ];
            if(isset($value['url'])){
                $arr['item'] = $value['url'];
            }else{
                $arr;
            }
            $newJsonArray[] = array_filter($arr);
        } 
        $jsonData = json_encode($newJsonArray, JSON_UNESCAPED_SLASHES);
        ?>
        {
          "@context": "https://schema.org",
          "@type": "BreadcrumbList",
          "itemListElement": <?php echo $jsonData ?> 
        }
    </script>
    <?php
    return $newLinksArray;
}

function add_rokit_main_style( $html, $handle ) {
    if ( 'rokit_main_style' === $handle ) {
        return str_replace( "media='all'", " async media='all'", $html );
    }
    return $html;
}
add_filter( 'style_loader_tag', 'add_rokit_main_style', 10, 2 );
 

function filter__language_attributes($output){
    if(is_page_template('templates/page-worlwide.php')){
        $output = 'lang="en-EN"';
    }
    return $output;
}
add_filter( 'language_attributes', 'filter__language_attributes' );

function filter__wpseo_change_og_locale( $locale ) {
    if(is_page_template('templates/page-worlwide.php')){
        $locale = 'en_EN';
    }
    return $locale;
}
add_filter('wpseo_locale', 'filter__wpseo_change_og_locale');

function filter__wpseo_change_og_url($url) {
    if(is_page_template('templates/page-worlwide.php')){
        $url = str_replace('/nl','',$url);
    }
    return $url;
}
add_filter('wpseo_opengraph_url', 'filter__wpseo_change_og_url');

//** *Enable upload for webp image files.*/
function faceland_webp_upload_mimes($existing_mimes) {
    $existing_mimes['webp'] = 'image/webp';
    $existing_mimes['json'] = 'application/json';
    return $existing_mimes;
}
add_filter('mime_types', 'faceland_webp_upload_mimes');

//** * Enable preview / thumbnail for webp image files.*/
function faceland_webp_is_displayable($result, $path) {
    if ($result === false) {
        $displayable_image_types = array( IMAGETYPE_WEBP );
        $info = @getimagesize( $path );

        if (empty($info)) {
            $result = false;
        } elseif (!in_array($info[2], $displayable_image_types)) {
            $result = false;
        } else {
            $result = true;
        }
    }

    return $result;
}
add_filter('file_is_displayable_image', 'faceland_webp_is_displayable', 10, 2);


function faq_meta_information() {
    $currentPageID = get_queried_object_id();
    $slug = get_post_field( 'post_name', $currentPageID );
    $term_taxonomy = '';
    $term = get_term( $currentPageID );
    if(is_object($term) && $currentPageID != 0){
        $term_taxonomy = $term->taxonomy;
    }
    $jsonData = '';
    if ($slug == 'faceland-deals') {
        $firstDealFAQ = get_field('page_behandelaar_information', $currentPageID);
        $secondDealFAQ = get_field('page_sc_deal_behandelaar_information', $currentPageID);
        $thirdDealFAQ = get_field('page_th_deal_behandelaar_information', $currentPageID);
        $fourthDealFAQ = get_field('page_ft_deal_behandelaar_information', $currentPageID);
        $termAndConditionFAQ = get_field('page_terms_and_condition_list', $currentPageID);
        $faqArray = array_merge((array)$firstDealFAQ,(array)$secondDealFAQ,(array)$thirdDealFAQ,(array)$fourthDealFAQ,(array)$termAndConditionFAQ);
        $newFaqArray = array_filter($faqArray);
        $newObj = [];
        foreach($newFaqArray as $value) {
            if(!empty($value) && is_array($value)){
                if(isset($value["title"]) && isset($value["description"])){
                    $newObj[] = [
                        "@type" => "Question",
                        "name" => !empty($value["title"]) ? $value["title"] : $value["terms_condition_title"]."?",
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => !empty($value["description"]) ? strip_tags(preg_replace('/\xc2\xa0/', '', html_entity_decode(str_replace("\n","",$value["description"])))) : ''
                        ]
                    ];
                }else{
                    $newObj[] = [
                        "@type" => "Question",
                        "name" => !empty($value["terms_condition_title"]) ? $value["terms_condition_title"] : ''."?",
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => !empty($value["terms_condition_description"]) ? strip_tags(preg_replace('/\xc2\xa0/', '', html_entity_decode(str_replace("\n","",$value["terms_condition_description"])))) : ''
                        ]
                    ];
                }
            }
        }
        if(is_array($newObj) || is_object($newObj)){
            $newFaqArray = array_filter($newObj);
            $jsonData = json_encode($newFaqArray, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
    }
    if($term_taxonomy == "faq_taxonomy"){
        $newFaqArray = faq_terms_list($currentPageID);
        $newObj = [];
        foreach($newFaqArray as $value) {
            if(!empty($value) && is_array($value)){
                if(isset($value["title"]) && isset($value["description"])){
                    $newObj[] = [
                        "@type" => "Question",
                        "name" => !empty($value["title"]) ? $value["title"] : ''."?",
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => !empty($value["description"]) ? strip_tags(preg_replace('/\xc2\xa0/', '', html_entity_decode(str_replace("\n","",$value["description"])))) : ''
                        ]
                    ];
                }
            }
        }
        if(is_array($newObj) || is_object($newObj)){
            $newFaqArray = array_filter($newObj);
            $jsonData = json_encode($newFaqArray, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
    }
    if(is_singular('treatment')){
        global $wpdb;
        $meta_value = 'field_627bd0f66a1c5';
        $metaValue = $wpdb->get_var( $wpdb->prepare("SELECT meta_key FROM $wpdb->postmeta WHERE meta_value = %s AND post_id = %s LIMIT 1" , $meta_value, $currentPageID) );
        $tabID = (int)filter_var($metaValue, FILTER_SANITIZE_NUMBER_INT);
        $i = 0;
        for($i == 0; $i < 50; $i++){
            $treatmentFaqs[$currentPageID][] = [
                'title' => get_post_meta($currentPageID,"modules_".$tabID."_tab_title_with_content_".$i."_title", true),
                'description' => get_post_meta($currentPageID,"modules_".$tabID."_tab_title_with_content_".$i."_content", true)
            ];
        }
        $treatmentFaqList = array_filter(array_map('array_filter', $treatmentFaqs[$currentPageID]));
        $newObj = [];
        foreach($treatmentFaqList as $value) {
            if(!empty($value) && is_array($value)){
                if(isset($value["title"]) && isset($value["description"])){
                    $newObj[] = [
                        "@type" => "Question",
                        "name" => !empty($value["title"]) ? $value["title"] : ''."?",
                        "acceptedAnswer" => [
                            "@type" => "Answer",
                            "text" => !empty($value["description"]) ? strip_tags(preg_replace('/\xc2\xa0/', '', html_entity_decode(str_replace("\n","",$value["description"])))) : ''
                        ]
                    ];
                }
            }
        }
        if(is_array($newObj) || is_object($newObj)){
            $newFaqArray = array_filter($newObj);
            $jsonData = json_encode($newFaqArray, JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES);
        }
    }
    if(!empty($jsonData)) {
        ?>
        <script type="application/ld+json">
        {
           "@context": "https://schema.org",
           "@type": "FAQPage",
           "mainEntity": <?php echo $jsonData; ?>
        }
        </script>
    <?php }
}
add_action('rodesk_head', 'faq_meta_information');


function faq_terms_list($term_id) {
    $args = [
        'post_type' => 'faq',
        'tax_query' => [
            [
                'taxonomy' => 'faq_taxonomy',
                'field' => 'term_id',
                'terms' => $term_id,
            ]
        ],
        'posts_per_page' => '-1',
        'order' => 'ASC',
        'orderby' => 'menu_order'
    ];
    $faqTermList = \Rokit\Controllers\Collections\FaqCollection::query($args);
    $newFaqTerm = [];
    foreach($faqTermList as $faqTerm){
        $newFaqTerm[] = [ 'title' => $faqTerm->custom['faq_title'], 'description' => $faqTerm->custom['faq_text'] ];
    }
    return $newFaqTerm;
}

if(isset($_GET['fetch_google_reviews']) && $_GET['fetch_google_reviews'] == true) {
    fetch_google_reviews();
}

function fetch_google_reviews() {
    $placeId = "ChIJEWH7A7oyxEcRu7RA-agecW4";
    $apiKey = "AIzaSyBhLr5Jjx_Qgu6n-4jyy8PLgZhqzqqj0Ks";
    $url = "https://maps.googleapis.com/maps/api/place/details/json?placeid=".$placeId."&key=".$apiKey."";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);  // Disable SSL verification
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL,$url);
    $result=curl_exec($ch);
    curl_close($ch);

    $json = json_decode($result);
    echo "<pre>"; print_r($json); echo "</pre>";
    //exit;
    //print json_encode($result, JSON_PRETTY_PRINT);
}

function jb_pre_get_posts( WP_Query $wp_query ) {
    if ( in_array( $wp_query->get( 'post_type' ), array( 'page', ) ) ) {
        $wp_query->set( 'update_post_meta_cache', false );
    }
}

// Only do this for admin.
if ( is_admin() ) {
    add_action( 'pre_get_posts', 'jb_pre_get_posts' );
}

add_action( 'template_redirect', 'price_page_redirect_post' );
function price_page_redirect_post() {
  if ( is_singular( 'price' ) ) :
    wp_redirect( home_url(), 301 );
    exit;
  endif;
}

add_action('the_seo_framework_rel_canonical_output','the_seo_framework_rel_canonical_output_data');
function the_seo_framework_rel_canonical_output_data($url){
    $url = '';
    return $url;   
}

add_action('the_seo_framework_indicator','the_seo_framework_plugin_indicator');
function the_seo_framework_plugin_indicator($status){
    $status = false;
    return $status;   
}

function faceland_popular_posts($post_id) {
    $count_key = 'popular_posts';
    $count = get_post_meta($post_id, $count_key, true);

    if ($count === '') {
        $count = 0;
        delete_post_meta($post_id, $count_key);
        add_post_meta($post_id, $count_key, '0');
    } else {
        $count++;
        update_post_meta($post_id, $count_key, $count);
    }
}

add_action('wp_head', 'faceland_track_posts');
function faceland_track_posts($post_id) {
    if (!is_singular('blog_article')) return; // Change post type to 'blog_article'
    if (empty($post_id)) {
        global $post;
        $post_id = $post->ID;
    }
    faceland_popular_posts($post_id);
}


function rokit_get_image_id($image_url) {
    global $wpdb;
    if(preg_replace('/-e\d+/', '', $image_url)){
        $image_url = preg_replace('/-e\d+/', '', $image_url);    
    }else{
        $image_url;
    }
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $image_url )); 
        return $attachment[0];
}

function rokit_get_image_id_img_carousel($image_url) {
    global $wpdb;
    $modifiedUrl = preg_replace('/-e\d+/', '', $image_url);
    $attachment = $wpdb->get_col($wpdb->prepare("SELECT ID FROM $wpdb->posts WHERE guid='%s';", $modifiedUrl )); 
        return $attachment[0]; 
}

function rokit_get_image_width_height_attr($image_url) {

    if(preg_replace('/-e\d+/', '', $image_url)){
        $image_url = preg_replace('/-e\d+/', '', $image_url);    
    }else{
        $image_url;
    }

    $attachment_id = attachment_url_to_postid($image_url);
    // Get the image dimensions
    $image_dimensions = wp_get_attachment_image_src($attachment_id, 'full');
    // Set $width to the value from the array if it exists, and an empty string otherwise
    $width = is_array($image_dimensions) ? esc_attr($image_dimensions[1]) : '';
    // Set $height to the value from the array if it exists, and an empty string otherwise
    $height = is_array($image_dimensions) ? esc_attr($image_dimensions[2]) : '';

    return [
        'width' => $width,
        'height' => $height
    ];
}

// Define your custom function to modify staging URLs
function my_custom_staging_urls_filter($urls) {
    // You can modify the $urls array as needed for staging
    // For example, append a query parameter to each URL
    foreach ($urls as &$url) {
        $url = add_query_arg('staging', 'true', $url);
    }

    return $urls;
}

// Hook your custom function into the nab_staging_urls filter
add_filter('nab_staging_urls', 'my_custom_staging_urls_filter');


function rokit_disable_faq_view_link($actions, $post){
    if ($post->post_type=='faq')
    {
        unset($actions['view']);
    }
    return $actions;
}
add_filter('page_row_actions', 'rokit_disable_faq_view_link', 10, 2);

function rokit_disable_detailpage_permalink_option() {
    global $post;
    // Check if we are on the post editing page and if the post type is 'post'
    if ($post->post_type == 'faq') {
        ?>
        <style>
            #edit-slug-box {
                display: none;
            }
        </style>
        <?php
    }
}
add_action('post_submitbox_misc_actions', 'rokit_disable_detailpage_permalink_option');



// Step 1: Register the Setting
function custom_theme_settings_init() {
    register_setting( 'custom_theme_settings_group', 'custom_uploaded_file_path' ); // This line registers your setting
}
add_action( 'admin_init', 'custom_theme_settings_init' );

// Step 2: Create an Option Page
function custom_theme_settings_page() {
    add_options_page( 'Sitemap Upload Settings', 'Sitemap Upload Settings', 'manage_options', 'sitemap_upload_settings', 'custom_theme_settings_page_callback' );
}
add_action( 'admin_menu', 'custom_theme_settings_page' );

// Step 2: Add File Upload Field and Display Uploaded File Path
function custom_theme_settings_page_callback() {
    $root_dir = $_SERVER['DOCUMENT_ROOT']; // Get the root directory path

    // Allowed file names
    $allowed_filenames = array(
        'simple-sitemap-all.xml',
        'href-sitemap-all.xml'
    );

    // Check if file is uploaded
    if (isset($_FILES['custom_file_upload']) && isset($_FILES['custom_file_upload']['name'])) {
        $file = $_FILES['custom_file_upload'];
        $file_name = $file['name'];

        // Check if the uploaded file name matches any of the allowed file names
        if (!in_array($file_name, $allowed_filenames)) {
            echo '<div class="error"><p>Only specific these <b>"simple-sitemap-all.xml"</b>, <b>"href-sitemap-all.xml"</b>,file names are allowed for upload.</p></div>';
            return;
        }

        // Construct the file path
        $uploaded_file_path = $root_dir . '/' . $file_name;

        // Move the uploaded file to the root directory
        $uploaded = move_uploaded_file($file['tmp_name'], $uploaded_file_path);

        if ($uploaded) {
            // Store the uploaded file path in session
            echo '<div class="updated"><p>File uploaded successfully.</p></div>';
        } else {
            echo '<div class="error"><p>Failed to upload file.</p></div>';
        }
    }

    ?>
    <div class="wrap">
        <h2>Upload a sitemap directly to the server root directory</h2>
        <o><b>Note :-</b> Only allow to upload, below sitemap files to server.</o>
        <p>As per the below files name you need to rename from the hreflang sitemap files :- </p>
        <ol>
            <li>simple-sitemap-all.xml :- <b>simple-sitemap-all.xml</b></li>
            <li>href-sitemap-all.xml :- <b>href-sitemap-all.xml</b></li>
        </ol>
        <form method="post" action="" enctype="multipart/form-data">
            <?php if (!empty($uploaded_file_path)): ?>
                <p>Uploaded file path: <?php echo $uploaded_file_path; ?></p>
            <?php endif; ?>
            <input type="file" name="custom_file_upload" id="custom_file_upload">
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}

add_action('template_redirect', 'faq_be_redirect');
function faq_be_redirect() {
    if (is_singular('faq') && pll_current_language() == 'be' ) {
        wp_redirect('https://www.facelandclinic.com/be/faq/', 301);
        exit;
    }
}

// Function to modify the meta description for archive pages
function faceland_archive_page_meta_description($description) {
    // Ensure this only runs on the Dutch version of the site
    if (pll_current_language() == 'nl') {
        // Check the post type archive and set the corresponding description
        if (is_post_type_archive('treatment')) {
            $description = pll__('Faceland behandelingen: de sleutel tot een jeugdige uitstraling. Laat je verwennen door onze ervaren specialisten en ervaar het verschil zelf!');
        } elseif (is_post_type_archive('blog_article')) {
            $description = pll__('Blijf op de hoogte van de laatste ontwikkelingen op het gebied van schoonheid en cosmetische ingrepen met de Faceland Blogs. Lees nu en laat je inspireren!');
        } elseif (is_post_type_archive('academy')) {
            $description = pll__('Ontdek de beste behandelingen bij Faceland Academy voor een stralende huid en een frisse uitstraling. Boek nu jouw afspraak!');
        } elseif (is_post_type_archive('faq')) {
            $description = pll__('Op zoek naar antwoorden over Faceland? Bekijk onze veelgestelde vragen voor informatie over behandelingen en meer. Bezoek onze website voor alle details!');
        } elseif (is_post_type_archive('specialist')) {
            $description = pll__('Leer meer over onze ervaren specialisten bij Faceland en ontdek de perfecte oplossing voor jouw esthetische wensen.');
        }
    }

    if (pll_current_language() == 'be') {
        if (is_post_type_archive('treatment')) {
            $description = pll__('Ontdek de nieuwste behandelingen bij Faceland Clinic. Boek vandaag nog uw afspraak voor een stralende huid en een frisse uitstraling.');
        } elseif (is_post_type_archive('blog_article')) {
            $description = pll__('Ontdek de nieuwste trends en tips op het gebied van cosmetische behandelingen. Lees onze blog voor interessante artikelen en deskundig advies.');
        } elseif (is_post_type_archive('faq')) {
            $description = pll__('Vind antwoorden op veelgestelde vragen over cosmetische ingrepen en behandelingen bij Faceland Clinic. Lees meer op onze FAQ-pagina!');
        } elseif (is_post_type_archive('specialist')) {
            $description = pll__('Ontmoet onze deskundige specialisten bij FaceLand Clinic. Leer meer over hun ervaring en passie voor esthetische behandelingen. Maak vandaag nog een afspraak!');
        }
    }

    if (pll_current_language() == 'be-fr') {
        if (is_post_type_archive('blog_article')) {
            $description = pll__('Découvrez les dernières actualités et conseils beauté sur le blog de Faceland Clinic. Restez informé sur les tendances en matière de soins de la peau et de chirurgie esthétique.');
        } elseif (is_post_type_archive('specialist')) {
            $description = pll__('Rencontrez nos experts en chirurgie plastique sur le site de Faceland Clinic. Obtenez des informations détaillées et planifiez votre visite dès maintenant.');
        }
    }

    if (pll_current_language() == 'en') {
        if (is_post_type_archive('specialist')) {
            $description = pll__('Meet our dedicated specialists at Faceland, committed to delivering exceptional cosmetic services. Learn more about our expertise and book your appointment now!');
        }elseif(is_post_type_archive('faq')){
            $description = pll__('Looking for answers about cosmetic treatments? Find all the information you need at Faceland FAQ page. Get expert advice and make informed decisions today!');
        }elseif(is_post_type_archive('blog_article')){
            $description = pll__('Discover the latest news and trends in facial aesthetics on Faceland blog. Stay informed and up-to-date with our expert insights and advice.');
        }
    }

    if (pll_current_language() == 'de') {
        // Check the post type archive and set the corresponding title
        if (is_post_type_archive('treatment')) {
            $description = pll__('Faceland - Ihre erste Wahl für ästhetische Behandlungen. Erfahren Sie mehr über unsere Betreibergesellschaft und lassen Sie sich von unseren Experten verwöhnen.');
        }elseif (is_post_type_archive('specialist')) {
            $description = pll__('Besuchen Sie die Website von Faceland, um mehr über die Betreibergesellschaft und unsere Kooperationsärzte zu erfahren. Erhalten Sie alle relevanten Informationen hier!');
        }
    }

    return $description;
}

// Add filter for the Open Graph meta description
add_filter('wpseo_opengraph_desc', 'faceland_archive_page_meta_description');
add_filter('wpseo_metadesc', 'faceland_archive_page_meta_description');


// Add to your theme's functions.php file

// Function to modify the title for archive pages
function faceland_archive_page_title($title) {
    // Ensure this only runs on the Dutch version of the site
    if (pll_current_language() == 'nl') {
        // Check the post type archive and set the corresponding title
        if (is_post_type_archive('treatment')) {
            $title = pll__('Behandelingen | Face your beauty | Faceland');
        } elseif (is_post_type_archive('blog_article')) {
            $title = pll__('Blogs | Face your beauty | Faceland');
        } elseif (is_post_type_archive('academy')) {
            $title = pll__('Faceland Academy | Face your beauty | Faceland');
        } elseif (is_post_type_archive('faq')) {
            $title = pll__('Veelgestelde vragen | Face your beauty | Faceland');
        } elseif (is_post_type_archive('specialist')) {
            $title = pll__('Specialisten | Face your beauty | Faceland');
        }
    }

    if (pll_current_language() == 'be') {
        // Check the post type archive and set the corresponding title
        if (is_post_type_archive('treatment')) {
            $title = pll__('Behandelingen | Face your beauty | Faceland');
        } elseif (is_post_type_archive('blog_article')) {
            $title = pll__('Blogs | Face your beauty | Faceland');
        } elseif (is_post_type_archive('academy')) {
            $title = pll__('Faceland Academy | Face your beauty | Faceland');
        } elseif (is_post_type_archive('faq')) {
            $title = pll__('Veelgestelde vragen | Face your beauty | Faceland');
        } elseif (is_post_type_archive('specialist')) {
            $title = pll__('Specialisten | Face your beauty | Faceland');
        }
    }

    if (pll_current_language() == 'be-fr') {
        // Check the post type archive and set the corresponding title
        if (is_post_type_archive('blog_article')) {
            $title = pll__('Blogs | Face your beauty | Faceland');
        } elseif (is_post_type_archive('specialist')) {
            $title = pll__('Specialistes | Face your beauty | Faceland');
        }
    }

    if (pll_current_language() == 'en') {
        // Check the post type archive and set the corresponding title
        if (is_post_type_archive('specialist')) {
            $title = pll__('Specialista| Face your beauty | Faceland');
        }elseif(is_post_type_archive('faq')){
            $title = pll__('Freaquently asked questions | Face your beauty | Faceland');
        }elseif(is_post_type_archive('blog_article')){
            $title = pll__('Blogs | Face your beauty | Faceland');
        }
    }

    if (pll_current_language() == 'de') {
        // Check the post type archive and set the corresponding title
        if (is_post_type_archive('treatment')) {
            $title = pll__('Behandlungen | Face your beauty | Faceland');
        }elseif (is_post_type_archive('specialist')) {
            $title = pll__('Kooperationsärzte | Face your beauty | Faceland');
        }
    }
    return $title;
}

// Add filters for both SEO title and Open Graph title
add_filter('wpseo_title', 'faceland_archive_page_title');
add_filter('wpseo_opengraph_title', 'faceland_archive_page_title');

/*
* Added custom option to save the noindex and index for the Yoast SEO
*/
// Add a custom column for the Yoast SEO index status to all public post types and taxonomies.
add_action('init', 'add_yoast_seo_index_to_all_columns');
function add_yoast_seo_index_to_all_columns() {
    $post_types = get_post_types(['public' => true], 'names');
    foreach ($post_types as $post_type) {
        add_filter("manage_{$post_type}_posts_columns", 'add_yoast_seo_index_column', 10, 1);
        add_action("manage_{$post_type}_posts_custom_column", 'populate_yoast_seo_index_column', 10, 2);
    }

    $taxonomies = get_taxonomies(['public' => true], 'names');
    foreach ($taxonomies as $taxonomy) {
        add_filter("manage_edit-{$taxonomy}_columns", 'add_yoast_seo_index_column', 10, 1);
        add_action("manage_{$taxonomy}_custom_column", 'populate_yoast_seo_index_column', 10, 3);
    }
}

// Add the "SEO Index" column to the columns.
function add_yoast_seo_index_column($columns) {
    $columns['yoast_seo_index'] = 'SEO Index';
    return $columns;
}

// Populate the SEO index value in the custom column for all post types and taxonomies.
function populate_yoast_seo_index_column($column, $post_id) {
    if ($column === 'yoast_seo_index') {
        $noindex = get_post_meta($post_id, '_yoast_wpseo_meta-robots-noindex', true);
        echo ($noindex === '1') ? 'noindex' : 'index';
    }
}

// Add a Quick Edit field for the SEO index status to all public post types.
add_action('quick_edit_custom_box', 'faceland_yoast_seo_index_quick_edit_box_all', 10, 2);
function faceland_yoast_seo_index_quick_edit_box_all($column_name, $post_type) {
    if ($column_name !== 'yoast_seo_index') {
        return;
    }
    ?>
    <fieldset class="inline-edit-col-right">
        <div class="inline-edit-col">
            <label>
                <span class="title">SEO Index</span>
                <span class="input-text-wrap">
                    <select name="yoast_seo_index" class="yoast_seo_index">
                        <option value="0" <?php selected('0', get_post_meta(get_the_ID(), '_yoast_wpseo_meta-robots-noindex', true)); ?>>index</option>
                        <option value="1" <?php selected('1', get_post_meta(get_the_ID(), '_yoast_wpseo_meta-robots-noindex', true)); ?>>noindex</option>
                    </select>
                </span>
            </label>
        </div>
    </fieldset>
    <?php
}

// Save the value from the Quick Edit field for all post types.
add_action('save_post', 'faceland_save_yoast_seo_index_meta_all', 10, 2);
function faceland_save_yoast_seo_index_meta_all($post_id, $post) {
    if (isset($_POST['yoast_seo_index'])) {
        update_post_meta($post_id, '_yoast_wpseo_meta-robots-noindex', sanitize_text_field($_POST['yoast_seo_index']));
    }
}

// Add a Bulk Edit field for the SEO index status for all public post types.
add_action('bulk_edit_custom_box', 'faceland_yoast_seo_index_bulk_edit_box_all', 10, 2);
function faceland_yoast_seo_index_bulk_edit_box_all($column_name, $post_type) {
    if ($column_name !== 'yoast_seo_index') {
        return;
    }
    ?>
    <fieldset class="inline-edit-col-right">
        <div class="inline-edit-col">
            <label>
                <span class="title">SEO Index</span>
                <span class="input-text-wrap">
                    <select name="bulk_yoast_seo_index" class="bulk_yoast_seo_index">
                        <option value="">— No Change —</option>
                        <option value="0">index</option>
                        <option value="1">noindex</option>
                    </select>
                </span>
            </label>
        </div>
    </fieldset>
    <?php
}

// Save the value from the Bulk Edit field for all post types.
add_action('save_post', 'faceland_save_bulk_yoast_seo_index_meta_all', 10, 2);
function faceland_save_bulk_yoast_seo_index_meta_all($post_id, $post) {
    if (isset($_REQUEST['bulk_yoast_seo_index']) && $_REQUEST['bulk_yoast_seo_index'] !== '') {
        update_post_meta($post_id, '_yoast_wpseo_meta-robots-noindex', sanitize_text_field($_REQUEST['bulk_yoast_seo_index']));
    }
}
