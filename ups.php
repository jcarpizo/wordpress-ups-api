<?php

/*
Plugin Name: Digital Ape Dental Lab: UPS API
Plugin URI: https://github.com/jcarpizo/wordpress-ups-api
Description: Integrate powerful UPS Web-based shipping capabilities to your enterprise applications. The Shipping Application Programming Interface (API) allows you to integrate UPS shipping functionality directly into your website or enterprise system. Your customers will enjoy the depth of UPS services and capabilities, while your business becomes more efficient with improved processes
Version: 1.0
Author: Digital Ape Full Arch Solutions
Author URI: https://github.com/jcarpizo/wordpress-ups-api
*/


define( 'UPS_API_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once 'vendor/autoload.php';
require_once( UPS_API_PLUGIN_DIR . 'class.ups-api.php' );
require_once( UPS_API_PLUGIN_DIR . 'class.ups-api-table.php' );

register_activation_hook( __FILE__, array( 'UpsApiTable', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'UpsApiTable', 'plugin_deactivation' ) );

add_action( 'rest_api_init', array( 'UpsApi', 'init' ) );
