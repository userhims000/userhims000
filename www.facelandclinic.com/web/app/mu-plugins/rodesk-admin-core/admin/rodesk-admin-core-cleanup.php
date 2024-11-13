<?php
/**
 * Rodesk admin core cleanup.
 *
 * Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 *
 * @package   rodesk-admin-core
 * @author    Rodesk BV <interactie@rodesk.nl>
 * @link      http://rodesk.nl
 * @copyright 2015 Rodesk BV
 *
 */

class rodesk_admin_core_cleanup {

    // Set some vars
    protected $plugin_slug  = 'rodesk-admin-core';


    // construct the class
    public function __construct() {

        // Run the action
        add_action( 'init',                  array( &$this, 'rodesk_head_cleanup' ) );              // clean up the head section
        add_action( 'template_redirect',     array( &$this, 'rodesk_nice_search_redirect' ) );      // clean search URL

        // Run the filters
        add_filter( 'language_attributes',   array( &$this, 'rodesk_language_attributes' ) );       // Clean up lang atrributes in head
        add_filter( 'body_class',            array( &$this, 'rodesk_body_class' ) );                // Clean up the body classes
        add_filter( 'embed_oembed_html',     array( &$this, 'rodesk_embed_wrap') , 10, 4);
        add_filter( 'get_avatar',            array( &$this, 'rodesk_remove_self_closing_tags' ) );  // Clean up the clsing tags <img />
        add_filter( 'comment_id_fields',     array( &$this, 'rodesk_remove_self_closing_tags' ) );  // Clean up the clsing tags <input />
        add_filter( 'post_thumbnail_html',   array( &$this, 'rodesk_remove_self_closing_tags' ) );  // Clean up the clsing tags <img />
        add_filter( 'get_search_form',       array( &$this, 'rodesk_get_search_form' ) );           // Load searchform from the snippets folder
        add_filter( 'request',               array( &$this, 'rodesk_request_filter' ) );            // Fix empty search string redirect
        add_filter( 'tiny_mce_before_init',  array( &$this, 'rodesk_change_mce_options' ) );        // Add some extra Tiny MCE options
        add_filter( 'the_content',           array( &$this, 'rodesk_rel_external' ) );              // Replace target="_blank" with rel="external"
        add_filter( 'wp_nav_menu_items',     array( &$this, 'rodesk_rel_external' ) );              // Replace target="_blank" with rel="external"
        add_action( 'wp_footer',             array( &$this, 'rodesk_remove_scripts_footer' ) );

        add_action( 'after_setup_theme',     array( &$this, 'rodesk_remove_head_rest_api' ) );      // Remove the wp rest api meta tags from head
        add_action( 'after_setup_theme',     array( &$this, 'rodesk_remove_head_oembed' ) );        // Remove oembed meta tag from head
        add_action( 'init',                  array( &$this, 'rodesk_remove_head_rss' ) );           // Remove rss meta tags from head

        add_filter( 'the_generator', '__return_false'); // remove WP version from the RSS Feed

        // Always hide the admin bar on the frontend
        show_admin_bar(false);

        //Remove WP version from the rss feed
        add_filter('the_generator', '__return_false');
    }


    // Clean up the head section
    public function rodesk_head_cleanup() {

      remove_action('wp_head', 'feed_links', 2);
      remove_action('wp_head', 'feed_links_extra', 3);
      remove_action('wp_head', 'rsd_link');
      remove_action('wp_head', 'wlwmanifest_link');
      remove_action('wp_head', 'adjacent_posts_rel_link_wp_head', 10, 0);
      remove_action('wp_head', 'wp_generator');

      remove_action( 'admin_print_styles', 'print_emoji_styles' );
      remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
      remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
      remove_action( 'wp_print_styles', 'print_emoji_styles' );
      remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
      remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
      remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

      // filter to remove TinyMCE emojis
      add_filter( 'tiny_mce_plugins', array( &$this, 'rodesk_disable_emojicons_tinymce' ) );

      global $wp_widget_factory;
      if ( isset( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'] ) ) {
        remove_action('wp_head', array($wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style'));
      }

      if (!class_exists('WPSEO_Frontend')) {
        remove_action('wp_head', 'rel_canonical');
        add_action('wp_head', array( &$this, 'rodesk_rel_canonical') );
      }
    }

    public function rodesk_disable_emojicons_tinymce( $plugins ) {
      if ( is_array( $plugins ) ) {
        return array_diff( $plugins, array( 'wpemoji' ) );
      } else {
        return array();
      }
    }

    // Create custom canonical rel
    public function rodesk_rel_canonical() {
        global $wp_the_query;
        if (!is_singular()) { return; }
        if (!$id = $wp_the_query->get_queried_object_id()) { return; }
        $link = get_permalink($id);
        echo "\t<link rel=\"canonical\" href=\"$link\">\n";
    }


    // Clean up the language attributes
    public function rodesk_language_attributes() {
        $attributes = array();
        $output = '';

        if (is_rtl()) {
        $attributes[] = 'dir="rtl"';
        }

        $lang = get_bloginfo('language');

        if ($lang) {
        $attributes[] = "lang=\"$lang\"";
        }

        $output = implode(' ', $attributes);
        $output = apply_filters('rodesk_language_attributes', $output);

        return $output;
    }


    public function rodesk_body_class($classes) {

        // Custom body classes matching with BEM class naming principles.
        // https://codex.wordpress.org/Function_Reference/body_class

        $rodesk_classes = array();

        // Add single class for pages
        if( get_post_type() && is_singular() && get_post_type() == 'page' ) {
          $rodesk_classes[] = 'body--page';

        } else // Add single class for all other than pages
        if( get_post_type() && is_singular() && get_post_type() != 'page' ) {
          $rodesk_classes[] = 'body--single';
          $rodesk_classes[] = 'body--single--' . get_post_type();

        // Add archive class
        } elseif( get_post_type() && is_post_type_archive( get_post_type() ) ) {
          $rodesk_classes[] = 'body--archive';
          $rodesk_classes[] = 'body--archive--' . get_post_type();
        }

        // Add post/page slug
        if (is_single() || is_page() && !is_front_page()) {
            $rodesk_classes[] = 'body--' . basename(get_permalink());
        }

        // Add homepage class
        if( is_front_page() ) {
          $rodesk_classes[] = 'body--home';
        }

        // Add 404 class
        if( is_404() ) {
          $rodesk_classes[] = 'body--404';
        }

        // Add 404 class
        if( is_search() ) {
          $rodesk_classes[] = 'body--search';
        }

        // Add 404 class
        if( is_user_logged_in() ) {
          $rodesk_classes[] = 'body--loggedin';
        }

        $rodesk_classes = apply_filters( 'rodesk_body_classes', $rodesk_classes );

        $classes = $rodesk_classes;

        return $classes;
    }

    /**
    * Replace target="_blank" with rel="external" for content and nav items
    */

    public function rodesk_rel_external( $content ) {
      $regexp = '/\<a[^\>]*(target="_([\w]*)")[^\>]*\>[^\<]*\<\/a>/smU';
      if( preg_match_all($regexp, $content, $matches) ){
        for ($m=0;$m<count($matches[0]);$m++) {
          if ($matches[2][$m] == 'blank') {
            $temp = str_replace($matches[1][$m], 'rel="external"', $matches[0][$m]);
            $content = str_replace($matches[0][$m], $temp, $content);
          } else if ($matches[2][$m] == 'self') {
            $temp = str_replace(' ' . $matches[1][$m], '', $matches[0][$m]);
            $content = str_replace($matches[0][$m], $temp, $content);
          }
        }
      }
      return $content;
    }


    /**
    * Wrap embedded media as suggested by Readability
    * @link https://gist.github.com/965956
    * @link http://www.readability.com/publishers/guidelines#publisher
    */

    public function rodesk_embed_wrap($cache, $url, $attr = '', $post_ID = '') {
      return '<div class="entry-content-asset">' . $cache . '</div>';
    }


    // Remove unnecessary self-closing tags
    public function rodesk_remove_self_closing_tags($input) {
        return str_replace(' />', '>', $input);
    }


    /**
     * Redirects search results from /?s=query to /search/query/, converts %20 to +
     *
     * @link http://txfx.net/wordpress-plugins/nice-search/
     */
    public function rodesk_nice_search_redirect() {
        global $wp_rewrite;

        if (!isset($wp_rewrite) || !is_object($wp_rewrite) || !$wp_rewrite->using_permalinks()) {
            return;
        }

        $search_base = $wp_rewrite->search_base;

        if (is_search() && !is_admin() && strpos($_SERVER['REQUEST_URI'], "/{$search_base}/") === false) {
            $redirect_url = home_url("/{$search_base}/" . urlencode(get_query_var('s')));
            $redirect_url = apply_filters( 'rokit/core/search_redirect', $redirect_url, $search_base, get_query_var('s'));

            if(!empty($redirect_url)) {
              wp_redirect($redirect_url);
              exit();
            }
        }
    }

    /**
     * Fix for empty search queries redirecting to home page
     *
     * @link http://wordpress.org/support/topic/blank-search-sends-you-to-the-homepage#post-1772565
     * @link http://core.trac.wordpress.org/ticket/11330
     */
    public function rodesk_request_filter($query_vars) {
      if (isset($_GET['s']) && empty($_GET['s'])) {
        $query_vars['s'] = ' ';
      }

      return $query_vars;
    }


    /**
     * Tell WordPress to use searchform.php from the templates/ directory
     */
    public function rodesk_get_search_form($form) {
      $form = '';
      locate_template('/snippets/searchform.php', true, false);
      return $form;
    }

    /**
     * Allow more tags in TinyMCE including <iframe> and <script>
     */
    public function rodesk_change_mce_options($options) {
        $ext = 'pre[id|name|class|style],iframe[align|longdesc|name|width|height|frameborder|scrolling|marginheight|marginwidth|src],script[charset|defer|language|src|type]';

        if (isset($initArray['extended_valid_elements'])) {
            $options['extended_valid_elements'] .= ',' . $ext;
        } else {
            $options['extended_valid_elements'] = $ext;
        }

        return $options;
    }


    /**
     * Remove scripts from wp_footer
     */
    public function rodesk_remove_scripts_footer(){
      wp_deregister_script( 'wp-embed' );
    }


    /**
     * Remove the wp rest api meta tags from head
     */
    public function rodesk_remove_head_rest_api() {
        remove_action( 'wp_head', 'rest_output_link_wp_head', 10 );
        remove_action( 'template_redirect', 'rest_output_link_header', 11, 0 );
    }


    /**
     * Remove oembed meta tag from head
     */
    public function rodesk_remove_head_oembed() {
        remove_action( 'wp_head', 'wp_oembed_add_discovery_links', 10 );
    }


    /**
     * Remove rss meta tags from head
     */
    public function rodesk_remove_head_rss() {
        remove_action('wp_head', 'feed_links_extra', 3 );
        remove_action('wp_head', 'feed_links', 2 );
    }



}
?>
