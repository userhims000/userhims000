<?php

// Set the namespace
namespace Rokit\Acf;

/**
 *
 * Rokit ACF Flexible Content Modules Class
 *
 * Class to load flexbile layouts as modal boxes
 *
 * @author  Jasper Rooduijn
 * @since   1.0
 */

class FlexibleContentModals {

	// ACF version
    static private $version = '';

    static private $asset_path = '';

	/*
	*  Initialize function
	*/
	static public function init() {

        // Set the ACF version
        self::set_acf_version();

        // Set the asset path
        // In ACF 5.7 the JS API changed
        // Therefor other JS needs to be loaded
        self::asset_path();

        // Hooks
        add_action('admin_init', array(__CLASS__, 'admin_css'), 1, 999); // Init admin CSS
        add_action('admin_init', array(__CLASS__, 'admin_script'),1, 999); // Init admin JS
        add_action('admin_init', array(__CLASS__, 'localize'),1, 999); // Init admin JS
        add_action('admin_head', array(__CLASS__, 'add_post_status'),1, 999); // Add post type status to localized text
        add_action('admin_head', array(__CLASS__, 'add_posttype_label'),1, 999); // Add post type label to localized text
        add_filter('acf/fields/flexible_content/layout_title', array(__CLASS__, 'add_title_field'),1, 999); // Add title field to flexible_content if the group has a filled title field.

    }

    /**
     * Define ACF version
     *
     * @return void
     */
    static public function set_acf_version() {
        global $acf;

        if($acf && !empty($acf->version)) {
            self::$version = $acf->version;
        }
    }

    /* Load some localization strings
     *
     * @return void
     */
    static public function localize() {

        if(function_exists('acf_localize_text')) {

            // Add some strings to ACF for translation
            acf_localize_text([
                'Saving'            => __('Saving', 'rokit-acf'),
                'Close & Save Draft'=> __('Close & Save Draft', 'rokit-acf'),
                'Close & Update'    => __('Close & Update', 'rokit-acf'),
                'Close'             => __('Close', 'rokit-acf'),
                'Edit layout'       => __('Edit layout', 'rokit-acf')
            ]);

        }

    }

    /**
     * Add the post type label as a localized variable for use in JS
     *
     * @return string
     */
    static public function add_posttype_label() {

        global $post;

        if(function_exists('acf_localize_data')) {

            if(!empty($post->post_type)) {
                $post_type_object = get_post_type_object($post->post_type);
            }

            if(!empty($post_type_object->labels->singular_name)) {
                acf_localize_data(['post_label' => strtolower($post_type_object->labels->singular_name)]);
            }
        }

    }

    /**
     * Add the post status as a localized variable for use in JS
     *
     * @return string
     */
    static public function add_post_status() {

        global $post;

        if(function_exists('acf_localize_data')) {
            if(!empty($post->ID) && get_post_status($post->ID)) {
                acf_localize_data(['post_status' => get_post_status($post->ID)]);
            }
        }

    }

    /**
     * Set asset path
     * In ACF 5.7 the JS API changed
     * Therefor other JS needs to be loaded
     *
     * @return void
     */
    static function asset_path() {

        $base_path = 'assets';

        if(version_compare(self::$version, '5.7.0', '<')) {
            self::$asset_path = $base_path . '/5.6';
        } else {
            self::$asset_path = $base_path;
        }

    }
    /**
     * Add title field to flexible_content if the group has a filled title field.
     *
     * @param $title string default title
     * @param $field array field_group
     * @param $layout array all the flex modules
     * @param $i int current fieldgroup
     * @return string the new title
     */
    static public function add_title_field($title, $field, $layout, $i) {

        if(version_compare(self::$version, '5.7.0', '<')) { return $title; }

        if(!empty($layout['sub_fields']) && is_countable($layout['sub_fields'])) {
            foreach ($layout['sub_fields'] as $f) {
                if (!empty($f['name']) && $f['name'] == 'title') {

                    if(!empty($_POST['value'][$f['key']])) {
                        $title_value = $_POST['value'][$f['key']];
                    }

                    if (!empty($field['value'][$i][$f['key']])) {
                        $title_value = $field['value'][$i][$f['key']];
                    }

                    if(!empty($title_value)) {
                        $max_length = 50;

                        if (strlen($title_value) > $max_length) {
                            $title_value = sprintf('%s...', substr($title_value, 0, $max_length));
                        }
                    }

                }
            }

            if(!empty($title_value)) {
                $append = sprintf(" : <span class='layout-title'>%s</span>", $title_value);
                return sprintf('<span>%s %s</span>', $title, $append);
            }
        }

        return $title;

    }

	/*
	 *  Register Admin Stylesheets
     *
     * @return string
	 */
	static public function admin_css() {
        wp_enqueue_style('rokit_acf_fc_modal', plugins_url(self::$asset_path . '/css/rokit-acf.css', __FILE__), array('acf-pro-input'));
	}

	/*
    *  Register Admin Scripts
    *
    * @return string
    */
	static public function admin_script() {
        wp_enqueue_script('rokit_acf_fc_modal', plugins_url(self::$asset_path . '/js/rokit-acf.js', __FILE__), array('acf-pro-input'));
	}

}
?>
