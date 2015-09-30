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

// Adds extra profile fields
function modify_contact_methods($profile_fields) {
  $profile_fields['phone'] = 'Phone';
  $profile_fields['address'] = 'Address';
  return $profile_fields;
}
add_filter('user_contactmethods', 'modify_contact_methods');

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

function add_post_types() {
	// Cars Post Type
	$labels_cars = array(
		'name'               => _x( 'Cars', 'post type general name' ),
		'singular_name'      => _x( 'Car', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'car' ),
		'add_new_item'       => __( 'Add New Car', 'vbs' ),
		'edit_item'          => __( 'Edit Car', 'vbs' ),
		'new_item'           => __( 'New Car', 'vbs' ),
		'all_items'          => __( 'All Cars', 'vbs' ),
		'view_item'          => __( 'View Cars', 'vbs' ),
		'search_items'       => __( 'Search Cars', 'vbs' ),
		'not_found'          => __( 'No cars found', 'vbs' ),
		'not_found_in_trash' => __( 'No cars found in the Trash', 'vbs' ),
		'parent_item_colon'  => '',
		'menu_name'          => __('Cars', 'vbs')
	);
	$args_cars = array(
		'labels'        => $labels_cars,
		'description'   => __('Holds our Cars specific data', 'vbs'),
		'public'        => true,
		'supports'      => array( 'title', 'thumbnail' ),
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-info',
	);
	register_post_type( 'cars', $args_cars );

	// Locations Post Type
	$labels_loc = array(
		'name'               => _x( 'Locations', 'post type general name' ),
		'singular_name'      => _x( 'Location', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'location' ),
		'add_new_item'       => __( 'Add New Location', 'vbs' ),
		'edit_item'          => __( 'Edit Location', 'vbs' ),
		'new_item'           => __( 'New Location', 'vbs' ),
		'all_items'          => __( 'All Locations', 'vbs' ),
		'view_item'          => __( 'View Locations', 'vbs' ),
		'search_items'       => __( 'Search Locations', 'vbs' ),
		'not_found'          => __( 'No locations found', 'vbs' ),
		'not_found_in_trash' => __( 'No locations found in the Trash', 'vbs' ),
		'parent_item_colon'  => '',
		'menu_name'          => __('Locations', 'vbs')
	);
	$args_loc = array(
		'labels'        => $labels_loc,
		'description'   => __('Holds our Locations specific data', 'vbs'),
		'public'        => true,
		'supports'      => array( 'title' ),
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-location',
	);
	register_post_type( 'locations', $args_loc );

	// Bookings Post Type
	$labels_book = array(
		'name'               => _x( 'Bookings', 'post type general name' ),
		'singular_name'      => _x( 'Booking', 'post type singular name' ),
		'add_new'            => _x( 'Add New', 'booking' ),
		'add_new_item'       => __( 'Add New Booking', 'vbs' ),
		'edit_item'          => __( 'Edit Booking', 'vbs' ),
		'new_item'           => __( 'New Booking', 'vbs' ),
		'all_items'          => __( 'All Bookings', 'vbs' ),
		'view_item'          => __( 'View Bookings', 'vbs' ),
		'search_items'       => __( 'Search Bookings', 'vbs' ),
		'not_found'          => __( 'No bookings found', 'vbs' ),
		'not_found_in_trash' => __( 'No bookings found in the Trash', 'vbs' ),
		'parent_item_colon'  => '',
		'menu_name'          => __('Bookings', 'vbs')
	);
	$args_book = array(
		'labels'        => $labels_book,
		'description'   => __('Holds our Bookings specific data', 'vbs'),
		'public'        => true,
		'supports'      => array( 'title' ),
		'has_archive'   => true,
		'menu_icon'     => 'dashicons-calendar-alt',
	);
	register_post_type( 'bookings', $args_book );

	// Include 3rd party scripts
	includer();
}
add_action( 'init', 'add_post_types' );

function cars_categories_taxonomy() {
	register_taxonomy(
		'type',
		'cars',
		array(
			'hierarchical' => true,
			'label' => 'Type',
			'query_var' => true,
			'rewrite' => array(
				'slug' => 'type',
				'with_front' => false
			)
		)
	);
}
add_action( 'init', 'cars_categories_taxonomy');

function includer() {
	if ( !class_exists( 'RW_Meta_Box' ) )
		require_once 'meta-box/meta-box.php';
	include 'meta-boxes.php';
	include 'settings.php';
	include 'shortcodes.php';
	include 'form.php';

	// TGM activation class
	require_once PLUGIN_DIR . 'tgm/tgm-init.php';
}

// Make cost and distance fields readonly
add_filter( 'rwmb_vbs_cost_html', 'prefix_input_readonly' );
add_filter( 'rwmb_vbs_distance_html', 'prefix_input_readonly' );
function prefix_input_readonly( $html ) {
	return str_replace( '<input', '<input readonly', $html );
}

function add_admin_scripts( $hook ) {
		global $post;
		if ( $hook == 'post-new.php' || $hook == 'post.php' ) {
				if ( 'bookings' === $post->post_type ) {
					wp_enqueue_script(  'gmaps', PLUGIN_DIR_URL . 'js/gmaps.js', array('jquery','google-maps'), '0.4.18', true );
					wp_enqueue_script(  'bookings', PLUGIN_DIR_URL . 'js/bookings_admin.js', array('gmaps'), '1.0.0', true );
				}
		}
}
add_action( 'admin_enqueue_scripts', 'add_admin_scripts', 10, 1 );

//Register and add scripts
function add_scripts() {
  // Styles
  wp_enqueue_style( 'style', PLUGIN_DIR_URL . 'css/style.css' );
  wp_enqueue_style( 'font-awesome', 'https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css' );
  wp_enqueue_style( 'datetime-css', PLUGIN_DIR_URL . 'css/jquery.datetimepicker.css' );

  // Scripts
  wp_enqueue_script( 'google-map', 'http://maps.googleapis.com/maps/api/js?sensor=false&libraries=places', true );
  wp_enqueue_script( 'geocomplete', PLUGIN_DIR_URL . 'js/jquery.geocomplete.min.js', array('jquery'), '1.4.0', true );
  wp_enqueue_script( 'validate', PLUGIN_DIR_URL . 'js/jquery.validate.min.js', array('jquery'), '1.14.0', true );
  wp_enqueue_script( 'jquery-form', array('jquery'), false, true );

  wp_enqueue_script( 'datetime-js', PLUGIN_DIR_URL . 'js/jquery.datetimepicker.full.min.js', array('jquery'), '2.4.5', true );

  wp_enqueue_script( 'form', PLUGIN_DIR_URL . 'js/form.js', array('jquery','jquery-form', 'validate'), '1.0.8', true );
  wp_localize_script( 'form', 'booking', array( 'ajax_url' => admin_url( 'admin-ajax.php' ) ) );
}
add_action( 'wp_enqueue_scripts', 'add_scripts' );

function add_map_element() {
	global $pagenow;
	if( $pagenow == 'post.php' )
		echo '<div id="map" style="display: none; width: 1px; height: 1px;"></div>';
}
add_action( 'admin_notices', 'add_map_element' );

function get_meta() {
  $postid = isset($_POST['postid']) ? $_POST['postid'] : '';
  $field = isset($_POST['field']) ? $_POST['field'] : '';
  if ( $postid && $field  ) {
    $result = get_post_meta($postid, $field, true);
  }
  echo $result;
  die();
}
add_action('wp_ajax_get_meta', 'get_meta');

function generateRandomString($length = 5) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}