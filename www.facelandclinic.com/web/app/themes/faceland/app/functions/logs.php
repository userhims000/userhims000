<?php

/*-----------------------------------------------------------------------------------

    Copyright 2017 (C) Rokit-WP starter theme
    Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

    File: Rokit-WP logs.php file
    This is the rokit theme logs file

-----------------------------------------------------------------------------------*/

/**
 * Hide simple history menu item for client roles
 * The blogger section is based on custom Timber routes
 * See route-functions.php for more info
 *
 * @param  integer $blogger_slug    The slug of the blogger (Liveworker)
 * @return string                   A URL string
 */

add_filter("simple_history/view_history_capability", 'rokit_history_permissions');
function rokit_history_permissions( $capability ) {

    // Choose a role that no client admin has
    // The history should only be viewable by administrators
    $capability = "administrator";

    return $capability;
}

/**
 * Register custom mail logger
 */

add_action("simple_history/add_custom_logger", function($simpleHistory) {

    /**
     * Our logger is a class that extends the built in SimpleLogger-class
     */
    class SimpleMailLogger extends SimpleLogger {

        /**
         * The slug is used to identify this logger in various places.
         * We use the name of the class too keep it simple.
         * Please note that the slug must be max 30 chars long.
         */
        public $slug = __CLASS__;

        /**
         * Method that returns an array with information about this logger.
         * Simple History used this method to get info about the logger at various places.
         */
        function getInfo() {

            $arr_info = array(
                "name" => "WP Mail Logger",
                "description" => "Logs mail sent by WordPress using the wp_mail function"
            );

            return $arr_info;

        }

        /**
         * The loaded method is called automagically when Simple History is loaded.
         * Much of the init-code for a logger goes inside this method. To keep things
         * simple in this example, we add almost all our code inside this method.
         */
        function loaded() {

             /**
             * Use the "wp_mail" filter to log emails sent with wp_mail()
             */
            add_filter( 'wp_mail', array( $this, "on_wp_mail" ) );

        }

        function on_wp_mail($args) {

            $context = array(
                "email_to" => $args["to"],
                "email_subject" => $args["subject"],
                "email_message" => $args["message"]
            );

            $this->info("Sent an email to '{email_to}' with subject '{email_subject}' using wp_mail()", $context);

            return $args;

        }

    }


    // Tell Simple History that we have a new logger available
    $simpleHistory->register_logger("SimpleMailLogger");

});
