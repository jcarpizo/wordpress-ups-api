<?php

/*
Plugin Name: Ups Restful Api
Plugin URI: jcarpizo.github.io
Description: Shipment details and print UPS Label
Version: 1.0
Author: Jasper Carpizo
Author URI: https://github.com/jcarpizo/wordpress-ups-api
*/


define( 'UPS_API_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once 'vendor/autoload.php';
require_once( UPS_API_PLUGIN_DIR . 'class.ups-api.php' );
require_once( UPS_API_PLUGIN_DIR . 'class.ups-api-table.php' );

register_activation_hook( __FILE__, array( 'UpsApiTable', 'plugin_activation' ) );
register_deactivation_hook( __FILE__, array( 'UpsApiTable', 'plugin_deactivation' ) );

add_action( 'rest_api_init', array( 'UpsApi', 'init' ) );
