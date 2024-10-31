<?php
/**
   Plugin Name: Recent Posts Video Icon
   Description: Display video icon of your choice next to Posts tagged 'video'.
   Plugin URI: http://www.experienced.com/recent-posts-video-icon/	
   Version: 1.1
   Author: Daniel Monaghan
   Author URI: http://www.experienced.com
   License: GPLv2 or later
 */

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) exit;

if ( ! class_exists( 'RPW_Video' ) ) :

class RPW_Video {

/**
* PHP5 constructor method.
*
* @since 0.1
*/
public function __construct() {

add_action( 'plugins_loaded', array( &$this, 'constants' ), 1 );

add_action( 'plugins_loaded', array( &$this, 'includes' ), 3 );

}

/**
* Defines constants used by the plugin.
*
* @since 0.1
*/
public function constants() {

define( 'RPVI_DIR', trailingslashit( plugin_dir_path( __FILE__ ) ) );

define( 'RPVI_URI', trailingslashit( plugin_dir_url( __FILE__ ) ) );

define( 'RPVI_INCLUDES', RPVI_DIR . trailingslashit( 'includes' ) );

}

/**
* Loads the initial files needed by the plugin.
*
* @since 0.1
*/
public function includes() {
require_once( RPVI_INCLUDES . 'widget-recent-posts-video-icon.php' );
}

}

new RPW_Video;
endif;
?>