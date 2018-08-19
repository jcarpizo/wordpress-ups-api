<?php

/*
Plugin Name: UPS API
Plugin URI: jcarpizo.github.io
Description: Used by millions, Akismet is quite possibly the best way in the world to <strong>protect your blog from spam</strong>. It keeps your site protected even while you sleep. To get started: activate the Akismet plugin and then go to your Akismet Settings page to set up your API key.
Version: 1.0
Author: Jasper Carpizo
Author URI: https://automattic.com/wordpress-plugins/
License: GPLv2 or later
Text Domain: akismet
*/
require_once 'vendor/autoload.php';

define( 'UPS_API_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );

require_once( UPS_API_PLUGIN_DIR . 'class.ups-api.php' );

//if ( is_admin() || ( defined( 'WP_CLI' ) && WP_CLI ) ) {
    //require_once( UPS_API_PLUGIN_DIR . 'class.ups-api.php' );
    add_action( 'rest_api_init', array( 'UpsApi', 'init' ) );
//}