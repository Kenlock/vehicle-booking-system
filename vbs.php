<?php
/**
* Plugin Name: Vehicle Booking System
* Plugin URI: http://interactive-design.gr
* Description: A vehicle booking system for Cab rentals
* Version: 1.0
* Author: George Nikolopoulos
* Author URI: http://interactive-design.gr
**/

// Definitions
define( 'PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'PLUGIN_DIR_URL', plugin_dir_url( __FILE__ ) );

// Adds roles on plugin activation
function add_roles_on_plugin_activation() {
  add_role( 'clients', 'Client', array( 'read' => true, 'level_0' => true ) );
}
register_activation_hook( __FILE__, 'add_roles_on_plugin_activation' );

function contests_load_plugin_textdomain() {
  load_plugin_textdomain( 'contests', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'contests_load_plugin_textdomain' );

if(isset($_REQUEST['action']) && $_REQUEST['action']=='ajaxFunctionMethod'){
        do_action( 'wp_ajax_' . $_REQUEST['action'] );
        do_action( 'wp_ajax_nopriv_' . $_REQUEST['action'] );
}

// Include the Redux files
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/admin/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/admin/framework.php' );
}
require_once (dirname(__FILE__) . '/admin/admin-config.php');

// Change Elusive Icons to Font Awesome
function FAIconFont() {
  wp_deregister_style( 'redux-elusive-icon' );
  wp_deregister_style( 'redux-elusive-icon-ie7' );

  wp_register_style( 'redux-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), time(), 'all' );
  wp_enqueue_style( 'redux-font-awesome' );
}
add_action( 'redux/page/booking/enqueue', 'FAIconFont' );

if ( !class_exists( 'RW_Meta_Box' ) )
  require_once 'meta-box/meta-box.php';
include 'custom-post-types.php';
include 'meta-boxes.php';
include 'shortcodes.php';
include 'form_handler.php';
include 'helper.php';

// TGM activation class
require_once PLUGIN_DIR . 'tgm/tgm-init.php';

add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );
function add_admin_scripts( $hook ) {
    global $post;
    if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
        if ( 'bookings' === $post->post_type ) {
          wp_enqueue_style( 'admin-style', PLUGIN_DIR_URL . 'css/admin.css' );

          wp_enqueue_script(  'gmaps', PLUGIN_DIR_URL . 'js/gmaps.js', array('jquery','google-maps'), '0.4.18', true );
          wp_enqueue_script(  'bookings', PLUGIN_DIR_URL . 'js/bookings_admin.js', array('gmaps'), '1.0.0', true );
        }
    }
}

//Register and add scripts
add_action( 'wp_enqueue_scripts', 'add_scripts' );
function add_scripts() {
  // Styles
  wp_enqueue_style( 'style', PLUGIN_DIR_URL . 'css/style.css' );
  wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'datetime-css', PLUGIN_DIR_URL . 'css/jquery.datetimepicker.css' );

  // Scripts
  wp_enqueue_script( 'google-map', 'http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places', true );
  wp_enqueue_script( 'gmaps', PLUGIN_DIR_URL . 'js/gmaps.js', array('jquery','google-map'), '0.4.18', true );
  wp_enqueue_script( 'geocomplete', PLUGIN_DIR_URL . 'js/jquery.geocomplete.min.js', array('jquery'), '1.4.0', true );
  wp_enqueue_script( 'validate', PLUGIN_DIR_URL . 'js/jquery.validate.min.js', array('jquery'), '1.14.0', true );
  wp_enqueue_script( 'jquery-form', array('jquery'), false, true );

  wp_enqueue_script( 'store', PLUGIN_DIR_URL . 'js/store.js', array(), '1.0', true );

  wp_enqueue_script( 'datetime-js', PLUGIN_DIR_URL . 'js/jquery.datetimepicker.full.min.js', array('jquery'), '2.4.5', true );

  wp_enqueue_script( 'form', PLUGIN_DIR_URL . 'js/form.js', array('jquery','jquery-form', 'validate'), '1.0.8', true );
  wp_localize_script( 'form', 'booking', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}