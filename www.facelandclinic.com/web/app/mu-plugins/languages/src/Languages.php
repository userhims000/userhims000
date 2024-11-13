<?php

// Set the namespace
namespace Rokit\Languages;

use Timber\Twig_Function as Twig_Function;

/**
 *
 * Rokit Languages Class
 *
 * Class to manage and edit session data
 *
 * @author  Jasper Rooduijn
 * @since   1.0
 */
class Languages {

    protected static $acfFieldGroup;

    function __construct() {

        // Set Polylang default lang
        add_filter( 'acf/settings/default_language', array( __CLASS__, 'get_default_site_lang' ) );

        // Set Polylang current lang
        add_filter( 'acf/settings/current_language', array( __CLASS__, 'get_current_site_lang' ) );

        // Load default Polylang's option page value
        add_filter( 'acf/load_value', array( __CLASS__, 'set_default_value' ), 11, 3 );

        // Add language to title Polylang's option page value
        add_filter( 'acf/load_field', array( __CLASS__, 'set_field_lang' ), 11, 1 );

        // Change rule match system for post/page/taxonomy to also check for Polylang ID
        add_filter( 'acf/location/rule_match/post', array( __CLASS__, 'add_rule_match' ), 11, 3);
        add_filter( 'acf/location/rule_match/page', array( __CLASS__, 'add_rule_match' ), 11, 3);
        add_filter( 'acf/location/rule_match/post_taxonomy', array( __CLASS__, 'match_translated_taxonomy' ), 11, 3);

        // Add custom translatable string functions to Timber
        add_filter( 'timber/twig', [ $this, 'add_string_functions'] );

        // Add some language related data to timber
        add_filter('timber_context', [$this, 'extend_timber_context']);

        // Unset translation for acf field groups
        add_filter('pll_get_post_types', [ $this, 'unset_pll_post_types']);

        // Add a custom menu icon for polylang string translations for client_admin users
        add_action( 'admin_menu', array( $this, 'add_menu_item' ) );

        // Set default language for a user for client admin user role
        add_filter('wp_loaded', [$this, 'set_user_default_language']);

        // Remove all languages option from admin bar lang switch for client_admin role
        add_action( 'wp_before_admin_bar_render', array( $this, 'clean_admin_bar' ) );

        // Clean up tranlastion strings for client admin user role
        add_filter('pll_get_strings', [$this, 'cleanup_translation_strings']);

    }

    /**
     * Check if current user is a client admin
     * Assuming client admin users are all admin user except 'administrator'
     *
     * @author  Jasper Rooduijn
     * @since   1.0.1
     */
    private function is_client_admin() {

        if( is_user_logged_in() ) {

            $user = wp_get_current_user();

            if( !empty( $user ) && is_object( $user ) && !in_array( 'administrator', (array) $user->roles ) ) {
                return true;
            }

        }

        return false;

    }

    /**
     * Add some language related data to timber
     *
     * @author  Jasper Rooduijn
     * @since   1.0.0
     *
     * @param   array     $data   Actual timber context data
     * @return  array             Modified timber context data
     */
    public function extend_timber_context( $data ) {

        $languages      = apply_filters( 'rokit/langauges', pll_the_languages( array( 'raw' => 1 ) ) );
        $current_lang   = apply_filters( 'rokit/current_lang', pll_current_language() );

        // Add all avialable languages to TimberSite object
        $data['languages'] = $languages;

        // Add current lang to TimberSite object
        $data['current_lang'] = $current_lang;

        return $data;

    }

    /**
     * Add custom translatable string functions to Timber
     *
     * @author  Jasper Rooduijn
     * @since   1.0.0
     *
     * @param   array     $twig   Twig object
     * @return  array             Twig object
     */
    public function add_string_functions( $twig ) {

        $twig->addFunction( new Twig_Function( 'pll_e', 'pll_e' ) );
        $twig->addFunction( new Twig_Function( 'pll__', 'pll__' ) );

        return $twig;

    }

    /**
     * Set default language for client admin user role
     *
     * @author  Jasper Rooduijn
     * @since   1.0.1
     *
     * @return  void
     */
    public function set_user_default_language() {

        if( !is_admin() ) {
            return;
        }

        // Only run for client admin user role
        if( $this->is_client_admin() ) {

            global $wp;

            $user_id        = get_current_user_id();
            $user_lang      = get_user_meta( $user_id, 'pll_filter_content', true );
            $default_lang   = $this->get_default_site_lang('slug');

            // If user no default language defined, define it
            if( !empty( $user_id ) && empty( $user_lang ) && !empty( $default_lang ) ) {
                update_user_meta( $user_id, 'pll_filter_content', $default_lang );
                wp_redirect( get_dashboard_url() );
            }

        }

    }

    /**
     * Cleanup translation strings for client admin user role
     *
     * @author  Jasper Rooduijn
     * @since   1.0.1
     *
     * @param   array   $strings    All translation strings
     * @return  array               Modified translation strings
     */
    public function cleanup_translation_strings( $strings ) {

        // Only run for client admin user role
        if( $this->is_client_admin() ) {

            $translation_domain = 'TTfP: ' . wp_get_theme()->template;

            $strings = array_filter($strings, function($arrayValue) use($translation_domain) {
                return $arrayValue['context'] == $translation_domain;
            });

        }

        return $strings;

    }

    /**
     * Remove 'all languages' option from admin bar lang switch for client_admin role
     * This will only work when a default language is set for a user
     * This is done in set_user_default_language() in this class
     *
     * @author  Jasper Rooduijn
     * @since   1.0.0
     *
     * @return  void
     */
    public function clean_admin_bar() {

        global $wp_admin_bar;

        // Remove the all languages option from admin bar menu when editing a post
        // There is no logical use case in switching languages there
        if ( $this->is_edit_page() ) {
            $wp_admin_bar->remove_node( 'languages' );
        }

        // Only run for client admin user role
        // The all langauges options is not usefull for client admin users
        if( $this->is_client_admin() ) {

            // Remove the all languages option from admin bar menu
            $wp_admin_bar->remove_node( 'all' );

        }

    }

    /**
     * Add a custom menu icon for polylang string translations for client_admin and client_super_admin users
     *
     * @author  Jasper Rooduijn
     * @since   1.0.0
     *
     * @return  void
     */
    public function add_menu_item() {

        $user = wp_get_current_user();
        $allowed_roles = apply_filters('rokit/langauges/translations_roles', ['client_admin', 'client_super_admin']);

        // Return if no rules are defined
        if(empty($user->roles)) { return; }

        // Add translations menu item for allowed roles
        if(array_intersect($user->roles, $allowed_roles) && function_exists( 'PLL' )) {
            add_menu_page( __( 'Translations' ), __( 'Translations' ), 'edit_posts', 'mlang_strings', array( PLL(), 'languages_page' ), 'dashicons-translation' );
        }

    }

    /**
     * Get default language for ACF to match a taxonomy term
     * In ACF a match for a certain taxonomy term can be defined. A problem is
     * that this can only be done by choosing a term in the default language.
     * In any other language than the default this match wil not return true and
     * the post metabox is not shown. This function finds the corresponding term
     * in the current language
     *
     * @author  Jasper Rooduijn
     * @since   1.4.0
     *
     * @return  void
     */
    public static function get_lang_term_to_match($acf_term) {

        if( !function_exists('acf_decode_term') ||
            !function_exists('acf_get_term') ||
            !function_exists('acf_encode_term') ||
            !function_exists('pll_default_language')) { return; }

        // Decode ACF term
        $acf_term = acf_decode_term($acf_term);
        $term = get_term_by( 'slug', $acf_term['slug'], $acf_term['taxonomy']);

        // If term is not found, because the current language is not the default language
        if(empty($term) && (!empty($acf_term['slug']) && !empty($acf_term['taxonomy']))) {

            // Get all terms for this taxonomy in the default language
            $terms = get_terms([
                'taxonomy' => $acf_term['taxonomy'],
                'hide_empty' => false,
                'lang' => pll_default_language()
            ]);

            // Return if no terms are found
            if(empty($terms)) { return $term; }

            // Get default language taxonomy term ID
            $default_term_id = array_search($acf_term['slug'], array_column($terms, 'slug', 'term_id'));

            // Get selected term default language taxonomy term ID
            $term = acf_get_term( $default_term_id );

        }

        if(!is_wp_error($term) && !empty($term->term_id)) {
            $current_term_id = pll_get_term($term->term_id);
            $current_term = get_term_by('id', $current_term_id, $acf_term['taxonomy']);
            
            if(!empty($current_term)) {
                return acf_encode_term($current_term);
            }
        }

    }

    /**
     * Change ACF rule match system for taxonomy to also check for Polylang ID
     *
     * @author  Jasper Rooduijn
     * @since   1.4.0
     *
     * @param   bool    $result     The true / false variable (must be returned)
     * @param   array   $rule       The current rule that you are matching against
     * @param   array   $screen     Array of data about the current edit screen
     * @return  bool
     */
    public static function match_translated_taxonomy( $result, $rule, $screen ) {

        if(class_exists('acf_location_post_taxonomy')) {
            $rule['value'] = static::get_lang_term_to_match($rule['value']);
            $result = (new \acf_location_post_taxonomy())->rule_match( $result, $rule, $screen );
        }

        return $result;

    }

    /**
     * Change ACF rule match system for post/page to also check for Polylang ID
     *
     * @author  Jasper Rooduijn
     * @since   1.0.0
     *
     * @param   bool    $match      The true / false variable (must be returned)
     * @param   array   $rule       The current rule that you are matching against
     * @param   array   $options    Array of data about the current edit screen
     * @return  bool
     */
    public static function add_rule_match( $match, $rule, $options ) {

        if( empty( $options['post_type'] ) || empty( $options['post_id'] ) ) {
            return $match;
        }

        // vars
        $post_type  = $options['post_type'];
        $post_id    = $options['post_id'];

        if( function_exists( 'pll_get_post' ) ) {

            $selected_page  = (int) $rule['value'];
            $lang_id        = pll_get_post( $selected_page );

            if( $rule['operator'] == "==" ) {
                $match = ( $lang_id == $options['post_id'] );
            } elseif($rule['operator'] == "!=") {
                $match = ( $lang_id != $options['post_id'] );
            }

        }

        return $match;

    }

    /**
     * Get the default Polylang's locale
     *
     * @author  Jasper Rooduijn
     * @since   1.0.0
     *
     * @param   string    $value      The value to load (slug, name, id)
     * @return  string
     */
    public static function get_default_site_lang( $value = '' ) {
        $value = empty( $value ) ? 'locale' : $value;
        return function_exists( 'pll_default_language' ) ? pll_default_language( $value ) : '';
    }

    /**
     * Get the current Polylang's locale or the wp's one
     *
     * @author  Jasper Rooduijn
     * @since   1.0.0
     *
     * @param   string    $value      The value to load (slug, name, id)
     * @return  string
     */
    public static function get_current_site_lang( $value ) {
        $value = empty( $value ) ? 'locale' : $value;
        return function_exists( 'pll_current_language' ) ? pll_current_language( $value ) : get_locale();
    }

    /**
     * Add lang slug to options header when editing options
     *
     * @author  Jasper Rooduijn
     * @since   1.0.0
     *
     * @param   array    $field        The field object (actually an array)
     * @return  array
     */
    public static function set_field_lang( $field ) {

        if( !is_admin() ) {
            return $field;
        }

        if( !empty( $field['parent'] ) && function_exists('pll_current_language') && function_exists('pll_default_language') ) {

            if( empty( self::$acfFieldGroup ) ){

                self::$acfFieldGroup = $field['parent'];

                $current_screen = function_exists('get_current_screen') ? get_current_screen() : '';
                $actual_lang    = pll_current_language('slug');
                $default_lang   = pll_default_language('slug');
                $show_lang      = !empty( $actual_lang ) ? $actual_lang : $default_lang;

                if( !empty( $current_screen ) ) {

                    if( acf_get_options_pages() ) {
                        foreach( acf_get_options_pages() as $options_pages => $options_page ) {

                            if( empty( $options_page['menu_slug'] ) ) {
                                return;
                            }

                            $cleaned_title = str_replace('opties_page_', '', $options_page['menu_slug'] );

                            if( strpos( $current_screen->base, $cleaned_title ) !== false ) {

                                echo '
                                    <script type="text/javascript">
                                        var title = jQuery("#acf-' . self::$acfFieldGroup . '").find("h2");
                                        if( title.text().indexOf("(' . $show_lang . ')") <= 0 ) {
                                            title.append(" <span>(' . $show_lang . ')</span>");
                                        }
                                    </script>
                                ';

                            }
                        }
                    }

                }
            }
        }

        return $field;
    }

    /**
     * Load default language value in front, if no translated is found for an acf option
     *
     * @author  Jasper Rooduijn
     * @since   1.0.0
     *
     * @param   string      $value        The value of the field as found in the database
     * @param   integer     $post_id      The post id which the value was loaded from
     * @param   array       $field        The field object (actually an array)
     * @return  string
     */
    public static function set_default_value( $value, $post_id, $field ) {

        if ( is_admin() || false === strpos( $post_id, 'options' ) || ! function_exists( 'pll_current_language' ) ) {
            return $value;
        }

        /**
         * Check if this fields needs to be ignored
         * If true skip loading default value
         */

        $ignore = apply_filters( 'rokit/languages/igonore_acf_default', [] );

        if( in_array($field['name'], $ignore) ) {
            return $value;
        }

        /**
         * According to his type, check the value to be not an empty string.
         * While false or 0 could be returned, so "empty" method could not be here useful.
         */

        if ( ! is_null( $value ) ) {
            if ( is_array( $value ) ) {
                // Get from array all the not empty strings
                $is_empty = array_filter( $value, function ( $value_c ) {
                    return "" !== $value_c;
                } );
                if ( ! empty( $is_empty ) ) {
                    // Not an array of empty values
                    return $value;
                }
            } else {
                if ( "" !== $value ) {
                    // Not an empty string
                    return $value;
                }
            }
        }

        /**
         * Delete filters for loading "default" Polylang saved value
         * and for avoiding infinite looping on current filter
         */
        remove_filter( 'acf/settings/current_language', array( __CLASS__, 'get_current_site_lang' ) );
        remove_filter( 'acf/load_value', array( __CLASS__, 'set_default_value' ) );
        $value = acf_get_metadata( 'options', $field['name'] );
        // $value = get_field( $field['name'], 'option' );

        /**
         * Re-add deleted filters
         */
        add_filter( 'acf/settings/current_language', array( __CLASS__, 'get_current_site_lang' ) );
        add_filter( 'acf/load_value', array( __CLASS__, 'set_default_value' ), 10, 3 );

        return $value;
    }

	/**
	 * Unset translation for acf field groups
	 *
	 * @param  [string] $types  Post types
	 * @return [string]         Post types
	 */
    public function unset_pll_post_types($types) {
	    unset ($types['acf-field-group']);
	    return $types;
    }

    /**
     * is_edit_page
     * function to check if the current page is a post edit page
     *
     * @author Ohad Raz <admin@bainternet.info>
     *
     * @param  string  $new_edit what page to check for accepts new - new post page ,edit - edit post page, null for either
     * @return boolean
     */
    function is_edit_page($new_edit = null){
        global $pagenow;
        //make sure we are on the backend
        if (!is_admin()) return false;


        if($new_edit == "edit")
            return in_array( $pagenow, array( 'post.php',  ) );
        elseif($new_edit == "new") //check for new post page
            return in_array( $pagenow, array( 'post-new.php' ) );
        else //check for either new or edit
            return in_array( $pagenow, array( 'post.php', 'post-new.php' ) );
    }

}
