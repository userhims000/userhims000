<?php
/*-----------------------------------------------------------------------------------

  	Copyright 2017 (C) Rokit-WP starter theme
  	Made by Rodesk B.V.
    E-mail  : hello@rodesk.nl
    Website : http://www.rodesk.nl

  	File: Rokit-WP setup.php file
  	This is the main rokit theme setup file

-----------------------------------------------------------------------------------*/

/**
 * Rokit theme setup and config
 */

 add_action('after_setup_theme', ['Rokit\Frame\Setup\RokitSetup', 'setup']);

 /**
 * Rokit theme add custom hooks
 */

 add_action('after_setup_theme', function () {

    // Add some custom hooks
    function rodesk_head() { do_action('rodesk_head'); }
    function rodesk_body() { do_action('rodesk_body'); }
    function rodesk_footer() { do_action('rodesk_footer'); }

});
