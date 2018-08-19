<?php

/*
Plugin Name: UPS API
Plugin URI: jcarpizo.github.io
Description: Post Shipment details and print UPS Label
Version: 1.0
Author: Jasper Carpizo
Author URI: https://github.com/jcarpizo/wordpress-ups-api
*/

require_once 'vendor/autoload.php';
define( 'UPS_API_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
require_once( UPS_API_PLUGIN_DIR . 'class.ups-api.php' );
add_action( 'rest_api_init', array( 'UpsApi', 'init' ) );