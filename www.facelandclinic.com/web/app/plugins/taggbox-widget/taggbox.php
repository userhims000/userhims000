<?php
/**
 * Plugin Name:       Taggbox Widget
 * Plugin URI:        https://taggbox.com/widget/
 * Description:       Display your social media content with the Taggbox Wordpress plugin - including hashtags and user content - in a beautiful and richly interactive view.
 * Version:           2.9
 * Author:            Taggbox
 * Author URI:        https://taggbox.com/widget/
 */
?>
<?php

if (!defined('WPINC'))
    die;
/* BEGIN CREATE  CONSTANT */
if (!defined('TAGGBOX_PLUGIN_VERSION'))
    define('TAGGBOX_PLUGIN_VERSION', 2.9);
if (!defined('TAGGBOX_PLUGIN_DIR_PATH'))
    define('TAGGBOX_PLUGIN_DIR_PATH', plugin_dir_path(__FILE__));
if (!defined('TAGGBOX_PLUGIN_URL'))
    define('TAGGBOX_PLUGIN_URL', plugins_url() . "/taggbox-widget");
if (!defined('TAGGBOX_PLUGIN_REDIRECT_URL'))
    define('TAGGBOX_PLUGIN_REDIRECT_URL', get_admin_url(null, 'admin.php?page='));
if (!defined('TAGGBOX_PLUGIN_API_URL'))
    define('TAGGBOX_PLUGIN_API_URL', "https://app.taggbox.com/widget/v1/");
if (!defined('TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL'))
    define('TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL', admin_url() . "admin.php?page=taggbox");
/* END CREATE  CONSTANT */
/*  INCLUDE HELPER */
include_once TAGGBOX_PLUGIN_DIR_PATH . "helper/helper.php";

/* --BEGIN--Manage Setting Link */
function __taggbox__settingsLink($links) {
    array_unshift($links, '<a href="admin.php?page=taggbox">Settings</a>');
    return $links;
}
add_filter("plugin_action_links_" . plugin_basename(__FILE__), '__taggbox__settingsLink');
/* --END--Manage Setting Link */

/* BEGIN ADD JS AND CSS */


function taggbox_plugin_scripts_css() {
    /* css */
    if(is_admin()){
        wp_enqueue_style('wp_taggbox-style', TAGGBOX_PLUGIN_URL . '/assets/css/style.css', '', TAGGBOX_PLUGIN_VERSION );
        /* js */
        wp_enqueue_script('jquery');
        
        wp_enqueue_script('wp_taggbox-jquery-validate', TAGGBOX_PLUGIN_URL . '/assets/js/jquery.validate.min.js', array('jquery'), TAGGBOX_PLUGIN_VERSION, true);
        
        wp_enqueue_script('wp_taggbox-script', TAGGBOX_PLUGIN_URL . '/assets/js/script.js', array('jquery'), TAGGBOX_PLUGIN_VERSION, true);

        wp_localize_script( 'wp_taggbox-script', 'taggboxAjaxurl', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
    }

    if(is_admin()){  
        /* GUTENBERG JS */
        wp_enqueue_script('wp_taggbox-analystic', TAGGBOX_PLUGIN_URL . '/assets/js/taggbox.analystic.js', array('jquery'), TAGGBOX_PLUGIN_VERSION, true);

        /* BEGIN GUTENBERG */
        if (!function_exists("register_block_type")) {
            return;
        } else {
            wp_register_script("editor-js", TAGGBOX_PLUGIN_URL . '/assets/js/editor/editor.js', array("wp-blocks", "wp-element", "wp-block-editor", "wp-components", "wp-i18n", "wp-data", "wp-compose"), TAGGBOX_PLUGIN_VERSION );
            register_block_type("taggbox-block/taggbox", array(
                "editor_script" => "editor-js",
                "editor_style" => "editor-css",
                "style" => "editor-style-css"
            ));
        }
    /* END GUTENBERG */
    }
}
add_action("init", "taggbox_plugin_scripts_css");




add_filter('script_loader_tag', function ($tag, $handle) {
    if ('embbedJs' !== $handle)
        return $tag;
    return str_replace(' src', ' defer src', $tag);
}, 10, 2);
/* END ADD JS AND CSS */

/* BEGIN ADD MENUS */


function taggbox_plugin_menus() {
    ob_start();
    ?>
    <svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 141.4 141.4"
         width="200px" height="200px">
        <title>Taggbox Icon</title>
        <g id="Layer_2" data-name="Layer 2">
            <g id="Layer_1-2" data-name="Layer 1">
                <g id="Layer_2-2" data-name="Layer 2">
                    <path fill="#ccc"
                          d="M70.7,141.4a70.7,70.7,0,1,1,70.7-70.7A70.82,70.82,0,0,1,70.7,141.4Zm0-135.7a65,65,0,1,0,65,65A65,65,0,0,0,70.7,5.7Z"/>
                </g>
                <g id="Layer_3" data-name="Layer 3">
                    <path fill="#ccc" d="M133,70.7A62.4,62.4,0,1,1,70.6,8.3,62.42,62.42,0,0,1,133,70.7Z"/>
                </g>
                <g id="Layer_4" data-name="Layer 4">
                    <polygon
                        points="115.4 45.3 26 45.3 26 73.2 51.9 73.2 51.9 107.2 90.5 73.2 115.4 73.2 115.4 45.3"/>
                </g>
            </g>
        </g>
    </svg>
    <?php
    $svg = ob_get_clean();
    add_menu_page('Taggbox', 'Taggbox Widget', 'manage_options', 'taggbox', 'taggbox_view', 'data:image/svg+xml;base64,' . base64_encode($svg));
}

add_action("admin_menu", 'taggbox_plugin_menus');
/* END ADD  MENUS */

/* BEGIN ADD & MANAGE VIEWS */


function taggbox_view() {
    if (taggbox_user() && taggbox_user()->isLogin == 'yes') {
        include_once TAGGBOX_PLUGIN_DIR_PATH . "views/widgetView.php";
    } else {
        include_once TAGGBOX_PLUGIN_DIR_PATH . "views/loginView.php";
    }
}

/* END ADD & MANAGE VIEWS */

/* BEGIN AJAX CALLS */
add_action("wp_ajax_data", "taggbox_data_ajax_handler");

function taggbox_data_ajax_handler() {
    global $wpdb;
    /* BEGIN LOGIN */
    if ($_REQUEST['param'] == 'taggboxLogin') {
        $email = sanitize_email($_REQUEST['email']);
        $password = $_REQUEST['password'];
        if ($email != '' && $password != '') {
            /* BEGIN API CALL */
            $response = wpApiCall(TAGGBOX_PLUGIN_API_URL . 'plugin/api/login', ['email' => $email, 'password' => $password]);
            //print_r($response);die;
            /* END API CALL */
            if ($response->code == 200 && is_object($response->data)) {
                if (taggbox_login($response->data) == true) {
                    exitWithSuccess(["redirectUrl" => TAGGBOX_PLUGIN_API_URL . "plugin/webloginbyplugin?wpredirecturl=" . TAGGBOX_PLUGIN_SOCIAL_LOGIN_CALL_BACK_URL . "&email=" . base64_encode($email) . "&pass=" . base64_encode($password)]);
                } else {
                    exitWithDanger("Something went wrong please try after sometime");
                }
            } else {
                exitWithDanger($response->message);
            }
        } else {
            exitWithDanger("Something went wrong please try after sometime");
        }
    }
    /* END LOGIN */
    /* BEGIN LOGOUT */ elseif ($_REQUEST['param'] == 'taggboxLogout') {
        if (taggbox_logout() == true) {
            exitWithSuccess(["redirectUrl" => TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox']);
        } else {
            exitWithDanger();
        }
    } /* END LOGOUT */
    /* BEGIN UPDATE WIDGET ACCORDING USER */ elseif ($_REQUEST['param'] == 'updateWidgetAccordingUser') {
        $userDetails = taggbox_user();
        $email = sanitize_email($userDetails->email);
        $userId = sanitize_key($_REQUEST['userid']);
        if (taggbox_manageActiveWidgetsUser($userId) == true) {
            if ($userDetails->userId == $userId) {
                taggbox_manageWidget($email);
            } else {
                taggbox_manageWidget($email, $userId);
            }
            exitWithSuccess();
        } else {
            exitWithDanger();
        }
    }/* END UPDATE WIDGET ACCORDING USER */
    /* BEGIN REFRESH */ elseif ($_REQUEST['param'] == 'taggboxRefresh') {
        $user = taggbox_user();
        $email = sanitize_email($user->email);
        $userId = sanitize_key($user->userId);
        /* MANAGE USER WIDGET */
        taggbox_manageWidget($email);
        /* BEGIN API CALL */
        $response = wpApiCall(TAGGBOX_PLUGIN_API_URL . 'plugin/api/collaborator', ['user_id' => $userId], 'Authorization:' . $user->accessToken);
        /* END API CALL */
        if ($response->code == 200) {
            /* MANAGE COLLABORATOR */
            taggbox_manageCollaborator($response->collaborators, $userId);
            foreach ($response->collaborators as $res) {
                /* MANAGE COLLABORATOR WIDGET */
                taggbox_manageWidget($email, $res->id);
            }
        }
        /* MANAGE ACTIVE WIDGET USER */
        taggbox_manageActiveWidgetsUser($userId);
        exitWithSuccess();
    }/* END REFRESH */
    /* BEGIN WIDGET ANALYTIC */ elseif ($_REQUEST['param'] == 'embeddedPluginWidgetsAnalytics') {
        $user = taggbox_user();
        $siteUrl = sanitize_key($_REQUEST['siteUrl']);
        $wallIds = (explode(",", trim(sanitize_key($_REQUEST['wallIds']))));
        /* BEGIN API CALL */
        wpApiCall(TAGGBOX_PLUGIN_API_URL . 'plugin/api/embeddedpluginwidgetsanalytic', ['user_id' => $user->userId, 'siteUrl' => $siteUrl, 'wallIds' => $wallIds], 'Authorization:' . $user->accessToken);
        /* END API CALL */
        exitWithSuccess();
    }/* END WIDGET ANALYTIC */
    wp_die();
}

/* END AJAX CALLS */

/* BEGIN SOCIAL ACCOUNT LOGIN */
if (isset($_GET['code'])) {

    if ($_GET['code'] == 200) {

        if (IsBase64($_POST['response'])) {/* Validate base64 */
            $response = unserialize(base64_decode($_POST['response']));
            /* SANITIZE RESPONSE */
            $response['user_id'] = sanitize_key($response['user_id']);
            $response['owner'] = sanitize_key($response['owner']);
            $response['name'] = sanitize_text_field($response['name']);
            $response['firstName'] = sanitize_text_field($response['firstName']);
            $response['lastName'] = sanitize_text_field($response['lastName']);
            $response['emailId'] = sanitize_email($response['emailId']);
            $response['activeProduct'] = sanitize_key($response['activeProduct']);
            $response['accessToken'] = $response['accessToken'];
            $response['collaboratorlist'] = $response['collaboratorlist'];
            $response = (object) $response;

            if (taggbox_login($response) == true) {

                header('Location: ' . TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox');
                exit();
            }
        } else {
            header('Location: ' . TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox&error=social-login-error');
            exit();
        }
    } else {
        header('Location: ' . TAGGBOX_PLUGIN_REDIRECT_URL . 'taggbox&error=social-login-error');
        exit();
    }
}
/* END SOCIAL ACCOUNT LOGIN  */

/* BEGIN  LOGIN */


function taggbox_login($response) {

    global $wpdb;
    $return = '';
    $user = taggbox_user($response->emailId);
    if (empty($user->email)) {
        if ($wpdb->insert('wp_taggbox_user', array(
                "userId" => $response->user_id,
                "name" => $response->name,
                "email" => $response->emailId,
                "accessToken" => $response->accessToken,
                "isLogin" => "yes",))) {
            $return = true;
        } else {
            $return = false;
        }
    } else {
        if ($wpdb->update(
                'wp_taggbox_user', array(
                "userId" => $response->user_id,
                "name" => $response->name,
                "email" => $response->emailId,
                "accessToken" => $response->accessToken,
                "isLogin" => "yes",
                ), array('email' => $response->emailId))) {
            $return = true;
        } else {
            $return = false;
        }
    }

    if ($return == true) {
        /* MANAGE WIDGET */
        taggbox_manageWidget($response->emailId);
        /* MANAGE COLLABORATOR */
        //print_r($response->collaboratorlist);die;
        if (count(array($response->collaboratorlist))) {
            taggbox_manageCollaborator($response->collaboratorlist, $response->user_id);
            /* MANAGE COLLABORATOR WIDGET */
            foreach ($response->collaboratorlist as $collaborator) {
                taggbox_manageWidget($response->emailId, $collaborator->id);
            }
        }
        /* MANAGE ACTIVE WIDGET USER */
        taggbox_manageActiveWidgetsUser($response->user_id);
    }
    return $return;
}
/* END  LOGIN */

/* BEGIN  LOGOUT */


function taggbox_logout() {
    global $wpdb;
    $return = '';
    if ($wpdb->update('wp_taggbox_user', array("isLogin" => "no",), array("isLogin" => "yes",))) {
        $return = true;
    } else {
        $return = false;
    }
    return $return;
}


/* END  LOGOUT */

/* BEGIN GET USER DETAILS */


function taggbox_user($email = null) {
    $user = '';
    global $wpdb;
    if ($email == null) {
        $user = $wpdb->get_results("SELECT * FROM wp_taggbox_user WHERE(isLogin = 'yes')");
    } else {
        $user = $wpdb->get_results("SELECT * FROM wp_taggbox_user WHERE(email = '" . $email . "')");
    }
    $user = (!empty($user))? $user[0]: '' ;
    
    return $user;

}


/* END GET USER DETAILS */

/* BEGIN GET COLLABORATOR DETAILS */


function taggbox_collaborator($userId) {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM wp_taggbox_collaborator WHERE(userId = '" . $userId . "')");
}


/* END GET COLLABORATOR DETAILS */

/* BEGIN MANAGE COLLABORATOR */


function taggbox_manageCollaborator($collaboratorList, $userId) {
    global $wpdb;
    $prevCollaboratorList = convertObjectToArray(taggbox_collaborator($userId));
    $collaboratorList = convertObjectToArray($collaboratorList);
    $collaboratorListIds = [];
    if (is_array($collaboratorList)) {
        $collaboratorListIds = array_column($collaboratorList, 'id');
    }
    if (is_array($prevCollaboratorList)) {
        $prevCollaboratorListIds = array_column($prevCollaboratorList, 'collaboratorId');
        $commonCollaboratorIds = array_intersect($prevCollaboratorListIds, $collaboratorListIds);
        $prevCollaboratorListIds = array_diff($prevCollaboratorListIds, $commonCollaboratorIds); //del
        $collaboratorListIds = array_diff($collaboratorListIds, $commonCollaboratorIds); //insert
    } else {
        $prevCollaboratorListIds = [];
    }
    /* DELETE */
    if (count($prevCollaboratorListIds)) {
        foreach ($prevCollaboratorListIds as $delId) {
            if ($wpdb->delete('wp_taggbox_collaborator', array("collaboratorId" => $delId, "userId" => $userId))) {
                $wpdb->delete('wp_taggbox_widget', array("userId" => $delId));
            }
        }
    }
    /* INSERT NEW COLLABORATOR */
    foreach ($collaboratorList as $key => $collaborator) {
        if (in_array($collaborator['id'], $collaboratorListIds)) {
            $wpdb->insert('wp_taggbox_collaborator', array(
                "userId" => $userId,
                "collaboratorId" => $collaboratorList[$key]['id'],
                "name" => $collaboratorList[$key]['name'],
            ));
        }/* OLD COLLABORATOR UPDATE */ else if (in_array($collaborator['id'], $commonCollaboratorIds)) {
            $wpdb->update('wp_taggbox_collaborator', array(
                "userId" => $userId,
                "name" => $collaboratorList[$key]['name'],
                ), array('collaboratorId' => $collaborator['id'], "userId" => $userId));
        }
    }
    return true;
}


/* END BEGIN MANAGE COLLABORATOR */

/* BEGIN GET  WIDGET */


function taggbox_widget($userId) {
    global $wpdb;
    return $wpdb->get_results("SELECT * FROM wp_taggbox_widget WHERE(userId = '" . $userId . "')");
}


/* END GET  WIDGET */

/* BEGIN GET ACTIVE WIDGET USER  */


function taggbox_activeWidgetUser() {
    global $wpdb;
    $activeUsers = $wpdb->get_results("SELECT * FROM wp_taggbox_active_widget_user");
    return empty($activeUsers) ? 0 : $activeUsers[0]->userId;
}


/* END GET ACTIVE WIDGET USER   */

/* BEGIN MANAGE ACTIVE WIDGET USER */


function taggbox_manageActiveWidgetsUser($userId) {
    global $wpdb;
    $return = '';
    $activeWidgetUserId = taggbox_activeWidgetUser();
    if ($activeWidgetUserId == $userId) {
        $return = true;
    } else {
        if ($activeWidgetUserId == "") {
            if ($wpdb->insert('wp_taggbox_active_widget_user', array("userId" => $userId))) {
                $return = true;
            } else {
                $return = false;
            }
        } else {
            if ($wpdb->update(
                    'wp_taggbox_active_widget_user', array("userId" => $userId,), array('id' => 1))) {
                $return = true;
            } else {
                $return = false;
            }
        }
    }
    return $return;
}


/* END MANAGE ACTIVE WIDGET USER */

/* BEGIN MANAGE WIDGET */


function taggbox_manageWidget($userEmailId, $collaboratorId = null) {
    $userId = '';
    $user = taggbox_user($userEmailId);
    $userId = $user->userId;
    if ($user) {
        /* BEGIN API CALL */
        $response = wpApiCall(TAGGBOX_PLUGIN_API_URL . 'plugin/api/get_wall', ['user_id' => $userId, 'collaborator_id' => $collaboratorId], 'Authorization:' . $user->accessToken);
        /* END API CALL */
       //print_r($response);
        //die;
        if ($response->code == 200) {
            /* MANAGE USER */
            if ($collaboratorId != null && $collaboratorId != '') {
                $userId = $collaboratorId;
            }
            global $wpdb;
            $widgetData = convertObjectToArray($response->data);
            $widgetList = array_column($widgetData, "walls");
            $prevWidgetList = convertObjectToArray(taggbox_widget($userId));
            $widgetListIds = [];
            if (is_array($widgetList)) {
                $widgetListIds = array_column($widgetList, 'id');
            }
            if (is_array($prevWidgetList)) {
                $prevWidgetListIds = array_column($prevWidgetList, 'widgetId');
                $commonWidgetIds = array_intersect($prevWidgetListIds, $widgetListIds);
                $prevWidgetListIds = array_diff($prevWidgetListIds, $commonWidgetIds); //del
                $widgetListIds = array_diff($widgetListIds, $commonWidgetIds); //insert
            } else {
                $prevWidgetListIds = [];
            }
            /* DELETE */
            if (count($prevWidgetListIds)) {
                foreach ($prevWidgetListIds as $delId) {
                    $wpdb->delete('wp_taggbox_widget', array("widgetId" => $delId, "userId" => $userId));
                }
            }
            foreach ($widgetList as $key => $widget) {
                /* NEW WIDGET INSERT */
                if (in_array($widget['id'], $widgetListIds)) {
                    $wpdb->insert('wp_taggbox_widget', array(
                        "userId" => $userId,
                        "widgetId" => $widgetList[$key]['id'],
                        "name" => $widgetList[$key]['name'],
                        "widgetUrl" => $widgetList[$key]['url'],
                        "feedCount" => $widgetData[$key]['feed_count'],
                        "networkCount" => $widgetData[$key]['network_count'],
                        "status" => $widgetList[$key]['status'],
                    ));
                } /* OLD WIDGET UPDATE */ else if (in_array($widget['id'], $commonWidgetIds)) {
                    $wpdb->update('wp_taggbox_widget', array(
                        "userId" => $userId,
                        "name" => $widgetList[$key]['name'],
                        "widgetUrl" => $widgetList[$key]['url'],
                        "feedCount" => $widgetData[$key]['feed_count'],
                        "networkCount" => $widgetData[$key]['network_count'],
                        "status" => $widgetList[$key]['status'],
                        ), array('widgetId' => $widget['id']));
                }
            }
        }
    }
    return true;
}


/* END BEGIN MANAGE WIDGET */

/* * ** DATABASE *** */
/* BEGIN CREATE DATABASE TABLE */


function taggbox_create_database_table_for_plugin() {
    global $wpdb;
    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_taggbox_user` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                     `userId` varchar(100) NOT NULL,
                     `name` varchar(100) NOT NULL,
                     `email` varchar(100) NOT NULL,
                     `accessToken` varchar(255) NOT NULL,
                     `isLogin` enum('no', 'yes') NOT NULL,
                     PRIMARY KEY(`id`)
                    ) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_taggbox_collaborator` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                     `userId` varchar(100) NOT NULL,
                     `collaboratorId` varchar(100) NOT NULL,
                     `name` varchar(100) NOT NULL,
                      PRIMARY KEY(`id`)
                    ) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_taggbox_widget` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                     `widgetId` varchar(100) NOT NULL,
                     `userId` varchar(100) NOT NULL,
                     `name` varchar(100) NOT NULL,
                     `widgetUrl` varchar(100) NOT NULL,
                     `feedCount` varchar(100) NULL,
                     `networkCount` varchar(100) NULL,
                     `status` int(1) NULL,
                      PRIMARY KEY(`id`)
                    ) ENGINE = InnoDB DEFAULT CHARSET = latin1");
    $wpdb->query("CREATE TABLE  IF NOT EXISTS `wp_taggbox_active_widget_user` (
                `id` int(11) NOT NULL AUTO_INCREMENT,
                    `userId` varchar(100) NOT NULL,
                     PRIMARY KEY(`id`)
                    ) ENGINE = InnoDB DEFAULT CHARSET = latin1");
}


register_activation_hook(__FILE__, 'taggbox_create_database_table_for_plugin');
/* END CREATE  DATABASE TABLE */

/* BEGIN DROP   DATABASE TABLE */


function taggbox_drop_database_tables_for_plugin() {
    global $wpdb;
    $wpdb->query("DROP table IF EXISTS  wp_taggbox_user");
    $wpdb->query("DROP table IF EXISTS  wp_taggbox_collaborator");
    $wpdb->query("DROP table IF EXISTS  wp_taggbox_widget");
    $wpdb->query("DROP table IF EXISTS  wp_taggbox_active_widget_user");
}


register_uninstall_hook(__FILE__, 'taggbox_drop_database_tables_for_plugin');
register_deactivation_hook(__FILE__, 'taggbox_drop_database_tables_for_plugin');
/* END DROP  DATABASE TABLE */

/* BEGIN CREATE SHORT CODE */
add_shortcode("taggbox", "taggboxPluginShortCode");

function taggboxPluginShortCode($attr) {
    $options = shortcode_atts( array(
        'height' => '100%',
        'width' => '100%',
    ), $attr );

    $widgetId = (isset($attr['widgetid']) ? $attr['widgetid'] : '');
    // $width = (isset($options['width']) ? $options['width'] : '');
    // $height = (isset($options['height']) ? $options['height'] : '');
    $code = '';
    $code .= '<div class="taggbox" data-widget-id="' . $widgetId . '"></div>';
    $code .= '<script type="text/javascript" src="https://widget.taggbox.com/embed-lite.min.js"></script>';
    return $code;
}
/* END CREATE SHORT CODE */

/*
 * **BEGIN CREATE CUSTOME WIDGET***
 */

class taggbox_widget extends WP_Widget {

    function __construct() {
        parent::__construct(
            'taggbox_widget', 'Taggbox Widget', array('description' => 'Display your social media content with the Taggbox.')
        );
    }

    public $widgetUrl = 'https://widget.taggbox.com/';

    /* WIDGET BACKEND */

    public function form($instance) {
        /* BEGIN MANAGE USER WIDGETS LIST */
        $userId = taggbox_user()->userId;
        $widgets = taggbox_widget($userId);
        $collaborators = taggbox_collaborator($userId);
        if (count($collaborators)) {
            foreach ($collaborators as $key => $collaborator) {
                $collaboratorWidgets = taggbox_widget($collaborator->collaboratorId)[$key];
                    if ($collaboratorWidgets) {
                    $widgets[] = $collaboratorWidgets;
                }
            }
        }
        /* END MANAGE USER WIDGETS LIST */
        $widgetId = !empty($instance['widgetId']) ? $instance['widgetId'] : '';
        $height = !empty($instance['height']) ? $instance['height'] : '';
        $width = !empty($instance['width']) ? $instance['width'] : '';
        ?>
        <p>
            <label for="<?php echo $this->get_field_id('widgetId'); ?>">Widget</label>
            <select name="<?php echo $this->get_field_name('widgetId'); ?>"
                    id="<?php echo $this->get_field_id('widgetId'); ?>" class="text-capitalize widefat">
                <option disabled selected> Select Widget</option>
                <?php foreach ($widgets as $widget) { ?>
                    <option value="<?= $widget->widgetId; ?>" <?= (($widget->widgetId == $widgetId) ? "selected" : ""); ?> > <?= $widget->name; ?> </option>
                <?php } ?>
            </select>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('height'); ?>">Height</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('height'); ?>"name="<?php echo $this->get_field_name('height'); ?>"value="<?= ((empty($height)) ? "500px" : $height); ?>  "/>
        </p>
        <p>
            <label for="<?php echo $this->get_field_id('width'); ?>">Width</label>
            <input type="text" class="widefat" id="<?php echo $this->get_field_id('width'); ?>"name="<?php echo $this->get_field_name('width'); ?>"value="<?= ((empty($width)) ? "100%" : $width); ?> "/>
        </p>
        <?php
    }

    /* UPDATE WIDGET REPLACE OLD INSTANCES WITH NEW */

    public function update($new_instance, $old_instance) {
        $instance = array();
        $instance['widgetId'] = (!empty($new_instance['widgetId'])) ? strip_tags($new_instance['widgetId']) : '';
        $instance['width'] = (!empty($new_instance['width'])) ? strip_tags($new_instance['width']) : '';
        $instance['height'] = (!empty($new_instance['height'])) ? strip_tags($new_instance['height']) : '';
        return $instance;
    }

    /* WIDGET FORNTEND */

    public function widget($args, $instance) {
        $width = (!empty($instance['width']) ? ' width=' . trim($instance['width']) : '');
        $height = (!empty($instance['height']) ? ' height=' . trim($instance['height']) : '');
        $widgetId = (!empty($instance['widgetId']) ? ' widgetid=' . trim($instance['widgetId']) : '');
        $shortCode = (!empty($widgetId) ? "[taggbox" . $widgetId . $width . $height . "]" : "");
        echo do_shortcode($shortCode);
    }

}

/* BEGIN REGISTER WIDGET */

function register_taggbox_widget() {
    register_widget('taggbox_widget');
}

add_action('widgets_init', 'register_taggbox_widget');
/*END REGISTER WIDGET*/
/*
 ***END CREATE CUSTOME WIDGET***
 */