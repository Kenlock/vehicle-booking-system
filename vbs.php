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

function vbs_load_plugin_textdomain() {
  load_plugin_textdomain( 'vbs', FALSE, basename( dirname( __FILE__ ) ) . '/languages/' );
}
add_action( 'plugins_loaded', 'vbs_load_plugin_textdomain' );

if(isset($_REQUEST['action']) && $_REQUEST['action']=='ajaxFunctionMethod'){
        do_action( 'wp_ajax_' . $_REQUEST['action'] );
        do_action( 'wp_ajax_nopriv_' . $_REQUEST['action'] );
}

// Include the Redux files
if ( !class_exists( 'ReduxFramework' ) && file_exists( dirname( __FILE__ ) . '/admin/framework.php' ) ) {
    require_once( dirname( __FILE__ ) . '/admin/framework.php' );
}
require_once (dirname(__FILE__) . '/admin/admin-config.php');
Redux::setExtensions( 'booking', dirname(__FILE__) . '/admin/vendor_support'  );

if ( !class_exists( 'RW_Meta_Box' ) )
  require_once 'include/meta-box/meta-box.php';
include 'custom-post-types.php';
include 'meta-boxes.php';
include 'shortcodes.php';
include 'form_handler.php';
include 'helper.php';

// TGM activation class
require_once PLUGIN_DIR . 'include/tgm/tgm-init.php';

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

// Add columns to custom post type edit screen
add_filter('manage_edit-bookings_columns', 'bookings_columns');
function bookings_columns($columns) {
  $columns['route'] = 'Route';
  $columns['datetime'] = 'Date / Time';
  $columns['full_name'] = 'Full Name';
  $columns['email'] = 'Email';
  $columns['status']  = 'Status';
  unset($columns['date']);
  return $columns;
}

add_action("manage_posts_custom_column",  "vbs_custom_columns");
function vbs_custom_columns($column){
  global $post;
  switch ($column) {
    case "route":
      echo '<b>From:</b> ' . rwmb_meta('vbs_pickup', $post->ID) . '<br/><b>To:</b> ' .rwmb_meta('vbs_dropoff', $post->ID);
      break;
    case "datetime":
      echo rwmb_meta('vbs_pickup_date', $post->ID) . ' @ ' . rwmb_meta('vbs_pickup_time', $post->ID);
      break;
    case "full_name":
      echo rwmb_meta('vbs_full_name', $post->ID);
      break;
    case "email":
      echo rwmb_meta('vbs_email', $post->ID);
      break;
    case "status":
      echo rwmb_meta('vbs_status', $post->ID);
      break;
  }
}

function calculateCost( $car_id, $distance ) {
  $pricing = rwmb_meta('vbs_pricing', $car_id);
    foreach ($pricing as $price) {
      if( $distance >= $price[0] && $distance < $price[1] ) {
        $cost = $distance * $price[2];
      }
    }
  return $cost;
}

add_action('paypal_ipn_for_wordpress_payment_status_completed', 'handle_ipn_update');
function handle_ipn_update( $posted ) {

  $status = isset($posted['payment_status']) ? $posted['payment_status'] : '';
  $item_number = isset($posted['item_number']) ? $posted['item_number'] : '';
  $trans_id = isset($posted['txn_id']) ? $posted['txn_id'] : '';
  $payer = isset($posted['payer_email']) ? $posted['payer_email'] : '';
  $total = isset($posted['payment_gross']) ? $posted['payment_gross'] : '';

  update_post_meta($item_number, "vbs_status", "valid");
  add_post_meta($item_number, "vbs_transaction", $trans_id);
  add_post_meta($item_number, "vbs_payer_email", $payer);
  add_post_meta($item_number, "vbs_pay_amount", $total);

}