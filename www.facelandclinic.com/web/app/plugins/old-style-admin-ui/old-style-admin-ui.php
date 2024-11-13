<?php
/*
Plugin Name: Old Style Admin UI
Plugin URI: https://designio.co.uk
Description: If you didn't like the new Wordpress 5.3 accessibility blue style for the buttons and other parts of the admin UI, this plugin is for you.
Version: 1.0.3
Author: Digital Shadow
Author URI: https://www.digital-shadow.com
License: GPL2
Old Style Admin UI is free software: you can redistribute it and/or modify it under the terms of the GNU General Public License as published by the Free Software Foundation, either version 2 of the License, or any later version. Old Style Admin UI is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the GNU General Public License for more details.
*/

if ( ! defined( 'ABSPATH' ) ) exit; 

// Let's load the old styles

add_action( 'admin_enqueue_scripts', 'oldstyle_admin_ui' );
add_action( 'login_head', 'oldstyle_admin_ui' );

function oldstyle_admin_ui() {
	$plugin_dir_uri = plugin_dir_url( __FILE__ );
	wp_enqueue_style( 'buttons_wp_admin_css', $plugin_dir_uri . 'css/oldstyle.css', false, '1.0.0' );
		if (class_exists('ACF')) {
	//  The ACF class exists, so let's load the css to extend the old style to ACF as well
	wp_enqueue_style( 'acf_css', $plugin_dir_uri . 'css/acf.css', false, '1.0.0' );
		}
}

// Comment the following line if you still want to keep the post 5.3 email verification nag
add_filter( 'admin_email_check_interval', '__return_false' );
?>