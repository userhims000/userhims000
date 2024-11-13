<?php
/**
 * Rodesk admin core dashboard.
 *
 * Custom Rodesk setup for WordPress. This core plugins cleans up WP, adds custom dashboard functions, handle custom rewrite rules (for relative URL's), and uses a custom wpThumb fork for image handling.
 *
 * @package   rodesk-admin-core
 * @author    Rodesk BV <interactie@rodesk.nl>
 * @link      http://rodesk.nl
 * @copyright 2015 Rodesk BV
 */

class rodesk_admin_core_dashboard {

    // Set some vars
    protected $plugin_slug          =   'rodesk-admin-core';
    protected $client_role          =   array( 'client_admin', 'client_super_admin');
    protected $admin_role           =   'administrator';
    protected $use_comments         =   false; // choose whether or not to use built-in comments functions

    // construct the class
    public function __construct() {

        // Run the actions
        add_action( 'init',                     array( &$this , 'set_client_roles' ) ); // Set the filtered client admin roles
        add_action( 'init',                     array( &$this , 'rodesk_block_dashboard' ) ); // Hide dashboard for non admin users
        add_action( 'init',                     array( &$this , 'rodesk_hide_dashboard_update' ) , 2 ); // Remove update notice for all roles except "Administrator"
        add_action( 'admin_head',               array( &$this , 'rodesk_remove_help_tabs' ) ); // Remove help tab in dashboard top right
        add_action( 'wp_dashboard_setup',       array( &$this , 'rodesk_dashboard_tidy' ) ); // Clean up dashboard widgets
        add_action( 'wp_dashboard_setup',       array( &$this , 'rodesk_dashboard_welcome' ) ); // Load custom welcome message in the dashboard
        add_action( 'admin_head',               array( &$this , 'rodesk_welcome_panel_cleanup' ) ); // Cleanup custom welcome message in the dashboard
        add_action( 'admin_head',               array( &$this , 'rodesk_dashboard_remove_postboxes' ) ); // Cleanup custom welcome message in the dashboard
        add_action( 'dashboard_glance_items',   array( &$this , 'add_custom_post_counts' ) ); // Add custom "At a glance" widget
        add_action( 'admin_head',               array( &$this , 'add_custom_post_counts_css' ) ); // Add custom "At a glance" css
        add_action( 'manage_pages_columns',     array( &$this , 'rodesk_post_columns' ) ); // Remove comments from the page columns
        add_action( 'admin_menu',               array( &$this , 'rodesk_remove_menus' ) ); // Remove menu items for certain user roles
        add_action( 'admin_bar_menu',           array( &$this , 'rodesk_admin_bar' ), 999 ); // Customize the admin bar
        add_action( 'admin_head',               array( &$this , 'rodesk_bar_logo' )); // customise the admin bar
        add_action( 'user_has_cap',             array( &$this , 'rodesk_filter_welcome_caps' )); // customise the admin bar

        // Run the filters
        add_filter('admin_footer_text',         array( &$this , 'rodesk_footer_copy' ) ); // Add the copyright notice to the dashboard footer
        add_filter('screen_layout_columns',     array( &$this , 'rodesk_dashboard_columns' ) ); // Force 1 column dashboard layout
        add_filter('get_user_option_screen_layout_dashboard', array( &$this , 'rodesk_dashboard_layout_columns' ) ); // Force 1 column dashboard layout
        add_filter('user_contactmethods',       array( &$this , 'rodesk_contact_methods' ) ); // Remove some default user fields
        add_filter('hidden_meta_boxes',         array( &$this , 'rodesk_hide_page_attributes_metabox' ), 10, 2 );
        add_filter( 'admin_email_check_interval', '__return_false' ); // Turns of the Admin Email Verification Screen more info at https://make.wordpress.org/core/2019/10/17/wordpress-5-3-admin-email-verification-screen/

        // Plugin specifick functions
        add_filter( 'init', array( &$this , 'rodesk_clean_acf' ) );

    }

    public function set_client_roles() {
        $this->client_role = apply_filters('rokit/core/client_roles', $this->client_role);
    }

    // Hide dashboard for non admin users
    function rodesk_block_dashboard() {
        global $current_user;
        $user = new WP_User( $current_user->ID );

        if ( is_admin() && ! ( defined( 'DOING_AJAX' ) && DOING_AJAX ) ) {
            if( is_array( $user ) ):
                if( current_user_can( $this->admin_role ) || array_key_exists( 'administrator', $user->roles ) || empty($user->roles) ) {
                    return;
                } else {
                    wp_redirect( home_url() );
                    exit;
                }
            endif;
        }
    }

    // Remove some default user fields
    public function rodesk_contact_methods($profile_fields) {

        // Remove old fields
        unset($profile_fields['aim']);
        unset($profile_fields['yim']);
        unset($profile_fields['jabber']);

        return $profile_fields;
    }

    public function rodesk_add_page_attributes_capability() {

    }

    /**
     * Hide page attributes metabox on edit page screens
     * @param  boolean $hidden
     * @param  string  $screen
     * @return string
     */
    public function rodesk_hide_page_attributes_metabox( $hidden ) {
        global $current_user;

        $user = new WP_User( $current_user->ID );

        // Check if user is in the client_admin user roles
        if( array_key_exists( 'administrator', $user->roles ) || empty($user->roles) ) {

            // Check if user has the custom 'manage_page_attributes' capability
            if( !current_user_can( 'manage_page_attributes' ) ) {
                $hidden[] = 'pageparentdiv';
            }
        }

        return $hidden;

    }


    // Hide update messages for all roles except "Administrator"
    public function rodesk_hide_dashboard_update() {
        global $current_user;
        if ( !current_user_can( $this->admin_role )) {
            add_filter( 'pre_site_transient_update_core', '__return_null' );
        }
    }


    // Add footer copyright text
    public function rodesk_footer_copy() {
        echo  '<p id="footer-left" class="alignleft">' . __('Website & CMS by', $this->plugin_slug ) . ' <a href="http://www.rodesk.nl">' .  __( 'Rodesk' , $this->plugin_slug ) . '</a></p>';
        echo  '<p class="alignright">&nbsp;| ' . __('Website:',$this->plugin_slug ) . ' <a href="' .get_bloginfo('url'). '">' .preg_replace("/^(http:\/\/|https:\/\/)/", "", get_bloginfo('url')). '</a></p>';
    }


    // Force one-column dashboard (WP 3.8)
    public function rodesk_dashboard_columns($columns) {
        $columns['dashboard'] = 1;
        return $columns;
    }


    // Force one-column dashboard (WP 3.8)
    public function rodesk_dashboard_layout_columns() {
        return 1;
    }


    // Hide unused dashboard metabox postboxes.
    public function rodesk_dashboard_remove_postboxes() {
        echo '
        <style type="text/css">
            @media only screen and (max-width: 1800px) and (min-width: 1500px) {
                body.wp-admin #wpbody-content #dashboard-widgets #postbox-container-1 {
                    width: 100% !important;
                }
            }

            #dashboard-widgets-wrap #dashboard-widgets #postbox-container-2,
            #dashboard-widgets-wrap #dashboard-widgets #postbox-container-3,
            #dashboard-widgets-wrap #dashboard-widgets #postbox-container-4 {
                display: none !important;
            }

        </style>';
    }

    // Clean up the dashboard widgets
    public function rodesk_dashboard_tidy() {
        global $wp_meta_boxes, $current_user;
        unset(
            // $wp_meta_boxes['dashboard']['normal']['core']['dashboard_right_now'],
            $wp_meta_boxes['dashboard']['normal']['core']['dashboard_activity'],
            $wp_meta_boxes['dashboard']['side']['core']['dashboard_quick_press'],
            $wp_meta_boxes['dashboard']['side']['core']['dashboard_primary']
        );
    }


    // Remove dashboard menu for certain roles
    public function rodesk_remove_menus() {
        global $menu;
        global $current_user;

        $user = new WP_User( $current_user->ID );

        // Check for client_role and client_super_admin user roles.
        if( array_key_exists( 'administrator', $user->roles ) || empty($user->roles) ) {
            $restricted = array(
                __( 'Posts', 'rodesk-admin-core' ),
                __( 'Links', 'rodesk-admin-core' ),
                __( 'Comments', 'rodesk-admin-core' ),
                __( 'Appearance', 'rodesk-admin-core' ),
                __( 'Plugins', 'rodesk-admin-core' ),
                __( 'Tools', 'rodesk-admin-core' ),
                __( 'Settings', 'rodesk-admin-core' ),
                __( 'Extra', 'rodesk-admin-core' )
            );
            end ($menu);
            while (prev($menu)){
                $value = explode(' ',$menu[key($menu)][0]);
                if(in_array($value[0] != NULL?$value[0]:"" , $restricted)){unset($menu[key($menu)]);}
            }
        }

        // Hide Posts and Coments admin menu's for ALL user roles/
        remove_menu_page( 'edit.php' );                   // Posts
        remove_menu_page( 'edit-comments.php' );          // Comments
    }


    // Remove help tab
    public function rodesk_remove_help_tabs() {
        $screen = get_current_screen();
        $screen->remove_help_tabs();
    }

    public function rodesk_filter_welcome_caps( $capabilities ) {

        global $pagenow;

        // If current screen is dashboard temp add 'edit_theme_options' to user
        // In this filter we allow the welcome screen for roles without edit_theme_options
        if( is_admin() && 'index.php' == $pagenow ) {
            if( empty( $capabilities['edit_theme_options'] ) ) {
                $capabilities['edit_theme_options'] = 1;
            }
        }

        return $capabilities;

    }

    // Init custom welcome panel
    public function rodesk_dashboard_welcome() {

        remove_action( 'welcome_panel', 'wp_welcome_panel' );
        add_action( 'welcome_panel', array( &$this , 'rodesk_welcome_panel' ) );

        // Always load the welcome panel for non administrator users
        $user_id = get_current_user_id();

        if ( rodesk_get_user_role_by_id( $user_id ) != 'administrator' ) {

            if ( get_user_meta( $user_id, 'show_welcome_panel', true ) != '1' ) {
                update_user_meta( $user_id, 'show_welcome_panel', 1 );
            }

        }

    }

    // Load custom welcome panel content
    public function rodesk_welcome_panel() {

        $support_link = '<a href="mailto:interactie@rodesk.nl">interactie@rodesk.nl</a>';

        include_once( plugin_dir_path( __FILE__ ) . '/rodesk-admin-core-dashboard-widget.php' );

    }

    // Cleanup custom welcome panel content
    public function rodesk_welcome_panel_cleanup() {
        echo '
        <style type="text/css">
            .welcome-panel-close {
                display: none;
            }
        </style>';
    }


    // Change "at a Glance' tp show al post types in this install
    public function add_custom_post_counts() {
        $excludes = array();
        $post_types = get_post_types( array( "public" => true , '_builtin' => false ) );
        foreach ($post_types as $pt) :
            $pt_info = get_post_type_object($pt); // get a specific CPT's details
            $num_posts = wp_count_posts($pt); // retrieve number of posts associated with this CPT
            $num = number_format_i18n($num_posts->publish); // number of published posts for this CPT
            $text = _n( $pt_info->labels->singular_name, $pt_info->labels->name, intval($num_posts->publish) ); // singular/plural text label for CPT
            echo '<li class="page-count custom-count '.$pt_info->name.'-count "><i class="dashicons ' . $pt_info->menu_icon . '"></i><a href="edit.php?post_type='.$pt.'">'.$num.' '.$text.'</a></li>';
        endforeach;
    }

    public function add_custom_post_counts_css() {
        echo '
        <style>

            #dashboard_right_now .comment-count,
            #dashboard_right_now .post-count {
                display: none;
            }

            #dashboard_right_now .custom-count a:before {
                display: none;
            }

            #dashboard_right_now .custom-count .dashicons {
                display: inline-block;
                margin-right: 10px;

            }

            #dashboard_right_now .custom-count .dashicons {
                display: inline-block;
                margin-right: 10px;
                color: #888;
                font-size: 18px;
            }
        </style>';
    }


    // Remove comments bubble from pages
    public function rodesk_post_columns($columns) {

        if( $this->use_comments == false ) {
            unset($columns['comments']);
        }

        return $columns;
    }


    // Customize the admin bar
    public function rodesk_admin_bar() {

        // get global vars
        global $wp_admin_bar;

        // Run the functions and sctions
        add_filter( 'admin_bar_menu', array( $this, 'rodesk_welcome_title' ), 25 );
        add_action( 'admin_bar_menu', array( $this, 'rodesk_bar_add_items' ), 100);

        // Remove unused parts of the admin bar
        $wp_admin_bar->remove_menu('new-content');
        $wp_admin_bar->remove_menu('comments');
        $wp_admin_bar->remove_menu('about');
        $wp_admin_bar->remove_menu('wporg');
        $wp_admin_bar->remove_menu('documentation');
        $wp_admin_bar->remove_menu('support-forums');
        $wp_admin_bar->remove_menu('feedback');

    }

    // Change admin bar welcome title
    public function rodesk_welcome_title( $wp_admin_bar ) {
        $my_account = $wp_admin_bar->get_node('my-account');
        $newtitle = str_replace( 'How are you,', __( 'Welcome', $this->plugin_slug ) , $my_account->title );
        $newtitle = str_replace( '?', '', $newtitle );
        $wp_admin_bar->add_node( array(
            'id' => 'my-account',
            'title' => $newtitle,
        ));
    }


    // Add some items
    public function rodesk_bar_add_items($admin_bar) {

        $admin_bar->add_menu(
            array(
                'id'        => 'wp-logo',
                'href'      => 'http://www.rodesk.nl',
                'title'     => 'rodesk',
                'meta'      => array(
                    'title' => __( 'Click Me', 'rodesk-admin-core' ),
                    'class' => 'rodesk-logo'
                ),
            )
        );

        $admin_bar->add_menu(
            array(
                'parent'    => 'wp-logo',
                'id'        => 'rodesk_about',
                'title'     => __( 'About rodesk', 'rodesk-admin-core' ),
                'href'      => 'http://www.rodesk.nl',
                'meta'      => array(
                    'title' => __( 'About rodesk', 'rodesk-admin-core' ),
                ),
            )
        );

        $admin_bar->add_menu(
            array(
                'parent'    => 'wp-logo',
                'id'        => 'rodesk_contact',
                'title'     => __( 'Contact rodesk', 'rodesk-admin-core' ),
                'href'      => 'http://www.rodesk.nl/contact',
                'meta'      => array(
                    'title' => __( 'Contact rodesk', 'rodesk-admin-core' ),
                ),
            )
        );


    }

    // Add some items
    public function rodesk_bar_logo() {
        echo '
        <style type="text/css">
            #wp-admin-bar-wp-logo.menupop > a {
                display: none;
            }

            .wp-admin #wpadminbar #wp-admin-bar-site-name > .ab-item::before {
                content: "";
                height: 20px;
                width: 20px;
                background-image: url(' . plugins_url( '' , __FILE__ ) . "/assets/robin.png" . ') !important;
                background-repeat: no-repeat;
                background-position: 0px 5px;
            }

            @media (-webkit-min-device-pixel-ratio: 2), (min-resolution: 192dpi) {
                .wp-admin #wpadminbar #wp-admin-bar-site-name > .ab-item::before {
                    background-image: url(' . plugins_url( '' , __FILE__ ) . "/assets/robin@2.png" . ') !important;
                    background-repeat: no-repeat;
                    background-position: 0px 5px;
                    background-size: 20px 20px;
                }
            }
        </style>';
    }

    // Clean up for ACF plugin
    public function rodesk_clean_acf() {

        global $admin_role;

        $plugin_slug = $this->plugin_slug;
        $admin_role = $this->admin_role;

        function rodesk_remove_acf_menu() {

            global $admin_role;

            /* if not our allowed users, hide menu */
            if ( !current_user_can( $admin_role ) ) {
                remove_menu_page('edit.php?post_type=acf-field-group');
            }
        }

        function rodesk_block_acf_screens() {
            global $current_screen, $plugin_slug, $admin_role;

            /* not our screen, do nothing */
            if(
                'edit-acf-field-group' != $current_screen->id &&
                'acf-field-group' != $current_screen->id &&
                'custom-fields_page_acf-settings' != $current_screen->id &&
                'extra-velden_page_acf-settings' != $current_screen->id &&
                'custom-fields_page_acf-settings-tools' != $current_screen->id &&
                'extra-velden_page_acf-settings-tools' != $current_screen->id &&
                'custom-fields_page_acf-settings-updates' != $current_screen->id &&
                'extra-velden_page_acf-settings-updates' != $current_screen->id
            )
                return;

            /* if not our allowed users, block access */
            if ( !current_user_can( $admin_role ) ) {
                wp_die( __('You dont have toe right permissions.', $plugin_slug ) );
            }

        }

        function acf_custom_acf_styles() {

            global $admin_role;

            echo '
            <style type="text/css">
                .acf_wysiwyg iframe {
                    min-height: 150px !important;
                }

                .acf_postbox .field textarea {
                    resize: vertical;
                    min-height: 90px;
                }

                ';

            if ( !current_user_can( $admin_role ) ) {
                echo ' .acf-postbox h2 a.acf-hndle-cog { display: none !important; } ';
            }
            echo '</style>';
        }

        add_action( 'admin_head', 'acf_custom_acf_styles');
        add_action( 'admin_menu', 'rodesk_remove_acf_menu', 9999 );
        add_action( 'admin_head-edit.php', 'rodesk_block_acf_screens' );
        add_action( 'admin_head-post-new.php', 'rodesk_block_acf_screens' );
        add_action( 'acf/input/admin_head', 'rodesk_block_acf_screens' );

    }
}
?>
