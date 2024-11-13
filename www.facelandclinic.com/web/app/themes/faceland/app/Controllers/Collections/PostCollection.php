<?php

namespace Rokit\Controllers\Collections;

use Timber;

/**
 * Setup default post type archive controller
 */

class PostCollection {

    protected static $postType = 'post';

    protected static $postClass = 'Rokit\Controllers\Types\Post';

    var $_headers;

    var $_panorama;

    var $_labels;

    var $_seo_description;

    var $_seo_image;

    /**
     * Return the post typ for this collection
     */

    public static function post_type() {
        return static::$postType;
    }

    /**
     * The default WP query for this custom post type
     */

    public static function posts() {

        $postClass = rokit_timber_type_class( static::$postType );

        return Timber::get_posts( false, $postClass );

    }

    /**
     * Get a specific posts of this custom post type
     *
     * @param  integer  $post_id    The WP ID of the requested post
     * @param  string   $postClass  The post class to use
     * @return object               Timber object with requested post
     */

    public static function post( $post_id = null, $postClass = null ) {

        if( empty( $postClass ) ) {
            $postClass = static::$postClass;
        }

        if ( ! empty( $post_id ) ) {
            return Timber::get_post( $post_id, $postClass );
        }

        return false;
    }

    /**
     * Get all published posts of this custom post type
     *
     * @param  integer  $perPage    Amount of posts per page
     * @param  integer  $paged      The paged number
     * @param  string   $postClass  The post class to use
     * @return object               Timber object with requested posts
     */

    public static function all( $perPage = -1, $paged = null, $postClass = null  ) {

        $args = [
            'post_type'         => static::$postType,
            'post_status'       => 'publish',
            'posts_per_page'    => $perPage,
            'orderby'           => 'menu_order',
            'order'             => 'ASC'
        ];

        if ( ! empty( $paged ) ) {
            $args['paged'] = $paged;
        }

        if( empty( $postClass ) ) {
            $postClass = static::$postClass;
        }

        return Timber::get_posts( $args, $postClass);
    }

    /**
     * Setup a custom query for posts from this custom post type
     *
     * This function takes a standard set of WP_Query arguments but mixes it with
     * arguments that mean we're selecting the right post type
     *
     * @param  array    $args       Array of default WP_Query arguments
     * @param  string   $postClass  Sting with the name of the postclass to be used
     * @return object               Timber object with requested posts
     */

    public static function query( $args = null, $postClass = null ) {

        $args = is_array($args) ? $args : [];

        // Set the correct post type
        $args = array_merge($args, ['post_type' => static::$postType]);

        if (!isset($args['post_status'])) {
            $args['post_status'] = 'publish';
        }

        if (!isset($args['posts_per_page'])) {
            $args['posts_per_page'] = '-1';
        }

        if( empty( $postClass ) ) {
            $postClass = static::$postClass;
        }

        return Timber::get_posts( $args, $postClass);
    }

    /**
     * Get multiple posts by there ID from this custom post type
     * This function takes an array of post ID's and loads all posts inside this post type
     *
     * @param  array    $ids        Array of valid WP_Post id's
     * @param  array    $args       Array of WP_Query args
     * @return object               Timber object with requested posts
     */

    static function posts_by_id(array $ids, array $args = []) {

        $default_args = [
            'post__in' => $ids,
            'orderby' => 'post__in'
        ];

        $args = array_merge($default_args, $args);

        return self::query($args);
    }

    /**
     * Setup a custom query for parent posts from this custom post type
     *
     * This function takes a standard set of WP_Query arguments but mixes it with
     * arguments that mean we're selecting the right post type
     *
     * @param  array    $args       Array of defaulp WP_Query arguments
     * @param  string   $postClass  Sting with the name of the postclass to be used
     * @return object               Timber object with requested posts
     */

    public static function parents( $args = null, $postClass = null ) {

        $args = is_array($args) ? $args : [];

        if (!isset($args['post_status'])) {
            $args['post_status'] = 'publish';
            $args['post_parent'] = '0';
        }

        return self::query( $args, $postClass );
    }

    /**
     * Setup a custom term query for posts from this custom post type
     *
     * This function takes an array of term ID's and loads all posts inside this post type
     *
     * @param  array    $terms      Array of taxonomies and terms ID's to load
     * @param  array    $args       Array of defaulp WP_Query arguments
     * @param  string   $postClass  Sting with the name of the postclass to be used
     * @return object               Timber object with requested posts
     */

    public static function query_by_terms( array $terms = null, $args = null, $postClass = null ) {

        if( empty( $terms ) || !is_array( $terms ) ) {
            return false;
        }

        $args = is_array($args) ? $args : [];

        $tax_query['relation'] = 'AND';

        foreach( $terms as $key => $value ) {
            if(!empty($value)) {
                $tax_query[] = [
                    'taxonomy' => $key,
                    'field'    => 'id',
                    'terms'    => $value
                ];
            }
        }

        // Set the correct post type
        $args = array_merge($args, [
            'post_type' => static::$postType,
            'tax_query' => $tax_query
        ]);

        if (!isset($args['post_status'])) {
            $args['post_status'] = 'publish';
        }

        if( empty( $postClass ) ) {
            $postClass = static::$postClass;
        }

        return Timber::get_posts( $args, $postClass);
    }

    public static function organize_by_terms($taxonomy, $args, $hide_empty = true) {

        $posts          = [];
        $terms          = get_terms( $taxonomy , ['hide_empty' => $hide_empty]);

        // Loop all the terms for this taxonomy
        if( !empty( $terms ) ) {
            foreach( $terms as $term ) {

                // Get the object for this term
                $termController = rokit_timber_term_class($taxonomy);
                $term = new $termController( rokit_get_lang_id( $term->term_id, 'term' ) );

                // Get all the posts for this term
                $term_posts = self::query_by_terms([$taxonomy => [ $term->ID ]], $args);

                // Setup the collection array
                $posts[ $term->slug ] = [
                    'term'      => $term,
                    'posts'     => $term_posts,
                ];

            }
        }

        return $posts;

    }

    /**
     * Setup default headers for the post type archive
     */

    public function headers() {

        if( ! $this->_headers ) {
            $headers = [
                'title' =>  get_field( static::$postType . '_archive_intro_title', 'option'),
                'intro' =>  get_field( static::$postType . '_archive_intro_subtitle', 'option'),
            ];

            $this->_headers = $headers;
        }

        return $this->_headers;
    }

    /**
     * Setup default panorama for the post type archive
     */

    public function panorama() {

        if( ! $this->_panorama ) {
            $panorama = [
                'title'     => get_field( static::$postType . '_archive_intro_title', 'option'),
                'subtitle'  => get_field( static::$postType . '_archive_intro_subtitle', 'option')
            ];

            $this->_panorama = $panorama;
        }

        return $this->_panorama;
    }

    /**
     * Setup some default post type labels to be used in twig archive templates
     */

    public function labels() {

        if( ! $this->_labels ) {

            // Request the post type object for this post type
            $postTypeObject = get_post_type_object( static::$postType );

            // Check if labels are defined for this post type
            if( !empty( $postTypeObject->labels ) && is_object( $postTypeObject->labels ) ) {

                // If labels are defined return them to the controller
                $this->_labels = array(
                    "plural" => $postTypeObject->labels->name,
                    "single" => $postTypeObject->labels->singular_name
                );

            }
        }

        return $this->_labels;
    }

    /**
     * Setup a default seo description for post type archive
     */

    public function seo_description() {

        if( ! $this->_seo_description ) {
            $this->_seo_description = $this->panorama()['subtitle'];
        }

        return $this->_seo_description;

    }

    /**
     * Setup a default seo description for post type archive
     */

    public function seo_image() {

        if(!empty(self::posts())) {
            $item = self::posts()[0];
            if ($item->thumbnail()) {
                $image_id = $item->thumbnail();

            } else if ($item->image()) {
                $image_id = $item->image();

            } else if (isset($item->panorama()['image'])) {
                $image_id = $item->panorama()['image'];

            }

            if (!empty($image_id)){
                $this->_seo_image = rokit_get_attachment( $image_id, 'social' );
            }
        }

        return $this->_seo_image;

    }

    public static function type() {
        return static::$postType;
    }

    public static function url() {
        return get_post_type_archive_link(static::$postType);
    }

    public static function active() {
        return is_post_type_archive(static::$postType);
    }

}
