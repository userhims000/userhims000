<?php

// Set the namespace
namespace Rokit\Frame\Share;


/**
 * Class to generate sharing links based on post title and custom summary field
 * Both a post ID and a summary field name (custom field) should be passes to the class
*/
class RokitShare {

    /**
     * Contruct the class
     * @param string    $summary_field The custom field to use for the summary
     * @param integer   $post_id       The WP post ID
     */

    public function __construct( $summary_field = null, $post_id = null ) {

        // Define the ID for this post
        $this->set_post_id( $post_id );

        // Define the summary field for this post
        $this->set_post_summary_field( $summary_field );

        // Define Bitly settings
        $this->set_twitter_user();

        // Define Twitter user
        $this->set_bitly_data();

        // Set social networks
        $this->set_social_networks();

        // Setup data
        $this->setup_data();

    }

    /**
     * Set the post ID for this class
     * If no post ID is passed grab the global ID from WP
     *
     * @param integer   $post_id    The ID of the WP post
     */

    private function set_post_id( $post_id ) {

        if ( empty( $post_id ) || ! is_numeric( $post_id ) ) {
            $this->post_id = get_the_ID();
        } else {
            $this->post_id = $post_id;
        }

    }

    /**
     * Set post summary field for this class
     * The summary field is the field name of a custom WP meta field
     *
     * @param string   $summary_field    The field name of a custom field
     */

    private function set_post_summary_field( $summary_field ) {

        if ( empty( $summary_field ) || ! is_numeric( $summary_field ) ) {
            $this->summary_field = $summary_field;
        }

    }

    /**
     * Set Twitter user
     */

    private function set_twitter_user() {

        if( get_field( 'sharing_twitter_user', 'options' ) ) {
            $this->twitter_user = str_replace( '@', '', get_field( 'sharing_twitter_user', 'options' ) );
        } else {

            // If no Twitter user is defined fallback on @rodesk
            $this->twitter_user = 'rodesk';
        }

    }

    /**
     * Set bilty API data
     * The settings for this data are grabbed from options (if defined)
     */

    private function set_bitly_data() {

        if( get_field( 'sharing_bitly_user', 'options' ) ) {
            $this->bitly_user = get_field( 'sharing_bitly_user', 'options' );
        }

        if( get_field( 'sharing_bitly_api_key', 'options' ) ) {
            $this->bitly_api_key = get_field( 'sharing_bitly_api_key', 'options' );
        }

    }

    /**
     * Get the post summary
     * Bases on the custom field name passed in set_post_summary_field
     */

    private function get_post_summary() {

        // Choose default field if no field is passed
        $summary_content = get_field( $this->summary_field, $this->post_id );

        if( !empty( $summary_content ) ){
            $summary_content = strip_tags( $summary_content );
        } else {
            $summary_content = 'No summary found';
        }

        return $summary_content;
    }

    /**
     * Set all social networks to be used by the class
     * The {} variables in this links will be replaced with actual data
     */

    private function set_social_networks() {

        $this->networks = [
            'facebook'  => 'https://facebook.com/sharer.php?u={url}',
            'twitter'   => 'https://twitter.com/intent/tweet?text={title}&url={short_url}&via={via}',
            'google'    => 'https://plus.google.com/share?url={url}',
            'pinterest' => 'https://pinterest.com/pin/create/button/?description={title}&url={short_url}',
            'linkedin'  => 'https://linkedin.com/shareArticle?mini=true&title={title}&url={url}',
            'mail'      => 'mailto:?subject={title_clean}&body={summary_clean} Read article: {url}',
            'whatsapp'  => 'https://api.whatsapp.com/send?text={title_clean} Read article: {url}'
        ];

    }

    /**
     * Build the share URL based on WP data and the social sharing link
     * The {} variables in the passed links will be replaced with actual data
     */

    private function build_query_url( $url, $data ) {

        $placeholders = array_keys( $data );

        foreach ($placeholders as &$placeholder) {
            $placeholder = "{{$placeholder}}";
        }

        return str_replace($placeholders, array_values( $data ), $url );

    }

    /**
     * Setup the sharing data to be used while building the sharing links
     */

    private function setup_data() {

        $this->data = array(
            'title'             => urlencode( get_the_title( $this->post_id ) ),
            'title_clean'       => get_the_title( $this->post_id ),
            'summary'           => urlencode( $this->get_post_summary( $this->post_id ) ),
            'summary_clean'     => $this->get_post_summary( $this->post_id ),
            'url'               => get_permalink( $this->post_id ),
            'short_url'         => $this->getBitly( get_permalink( $this->post_id ) ),
            'via'               => $this->twitter_user,
        );

    }

    /**
     * Get a specific sharing link
     */

    public function get_link( $type ) {

        if( !empty( $type ) ) {
            return $this->build_query_url( $this->networks[ $type ], $this->data );
        }

        return false;
    }

    /**
     * Generate a bitly short URL
     */

    private function getBitly( $url ) {

        if ( empty( $this->bitly_user ) || empty( $this->bitly_api_key ) ) {
            return $url;
        }

        $bitly = $this->get_url( 'http://api.bit.ly/v3/shorten?login=' . $this->bitly_user . '&apiKey=' . $this->bitly_api_key . '&longUrl=' . $url . '%2F&format=txt' );
        return $bitly;
    }

    /**
     * Get a URL with CURL
     */

    private function get_url( $url ) {
        $ch = curl_init();
        curl_setopt( $ch, CURLOPT_URL, $url );
        curl_setopt( $ch, CURLOPT_HEADER, FALSE );  // Return contents only
        curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );  // return results instead of outputting
        curl_setopt( $ch, CURLOPT_CONNECTTIMEOUT, 10 ); // Give up after connecting for 10 seconds
        curl_setopt( $ch, CURLOPT_TIMEOUT, 60 );  // Only execute 60s at most
        curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );  // Don't verify SSL cert
        $response = curl_exec( $ch );
        curl_close( $ch );
        return $response;
    }

}
