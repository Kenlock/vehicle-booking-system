<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

/* Register custom post types */

add_action( 'init', 'add_post_types' );
function add_post_types() {
  // Cars Post Type
  $labels_cars = array(
    'name'               => _x( 'Cars', 'post type general name' ),
    'singular_name'      => _x( 'Car', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'car' ),
    'add_new_item'       => __( 'Add New Car', 'vbs' ),
    'edit_item'          => __( 'Edit Car', 'vbs' ),
    'new_item'           => __( 'New Car', 'vbs' ),
    'all_items'          => __( 'Cars', 'vbs' ),
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
    'show_ui'       => true,
    'show_in_menu'  => 'vbs_admin_menu',
  );
  register_post_type( 'cars', $args_cars );

  // Drivers Post Type
  $labels_dri = array(
    'name'               => _x( 'Drivers', 'post type general name' ),
    'singular_name'      => _x( 'Driver', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'driver' ),
    'add_new_item'       => __( 'Add New Driver', 'vbs' ),
    'edit_item'          => __( 'Edit Driver', 'vbs' ),
    'new_item'           => __( 'New Driver', 'vbs' ),
    'all_items'          => __( 'Drivers', 'vbs' ),
    'view_item'          => __( 'View Drivers', 'vbs' ),
    'search_items'       => __( 'Search Drivers', 'vbs' ),
    'not_found'          => __( 'No drivers found', 'vbs' ),
    'not_found_in_trash' => __( 'No drivers found in the Trash', 'vbs' ),
    'parent_item_colon'  => '',
    'menu_name'          => __('Drivers', 'vbs')
  );
  $args_dri = array(
    'labels'        => $labels_dri,
    'description'   => __('Holds our Drivers specific data', 'vbs'),
    'public'        => true,
    'supports'      => array( 'title', 'thumbnail' ),
    'has_archive'   => false,
    'menu_icon'     => 'dashicons-groups',
    'show_ui'       => true,
    'show_in_menu'  => 'vbs_admin_menu',
  );
  register_post_type( 'drivers', $args_dri );

  // Date Surcharges Post Type
  $labels_sur = array(
    'name'               => _x( 'Date Surcharges', 'post type general name' ),
    'singular_name'      => _x( 'Date Surcharge', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'surcharge' ),
    'add_new_item'       => __( 'Add New Date Surcharge', 'vbs' ),
    'edit_item'          => __( 'Edit Date Surcharge', 'vbs' ),
    'new_item'           => __( 'New Date Surcharge', 'vbs' ),
    'all_items'          => __( 'Date Surcharges', 'vbs' ),
    'view_item'          => __( 'View Date Surcharges', 'vbs' ),
    'search_items'       => __( 'Search Date Surcharges', 'vbs' ),
    'not_found'          => __( 'No date surcharges found', 'vbs' ),
    'not_found_in_trash' => __( 'No date surcharges found in the Trash', 'vbs' ),
    'parent_item_colon'  => '',
    'menu_name'          => __('Date Surcharges', 'vbs')
  );
  $args_sur = array(
    'labels'        => $labels_sur,
    'description'   => __('Holds our Date Surcharge specific data', 'vbs'),
    'public'        => false,
    'supports'      => array( 'title' ),
    'has_archive'   => false,
    'menu_icon'     => 'dashicons-flag',
    'show_ui'       => true,
    'show_in_menu'  => 'vbs_admin_menu',
  );
  register_post_type( 'date_surcharges', $args_sur );

  // Postcode Surcharges Post Type
  $labels_sur = array(
    'name'               => _x( 'Postcode Surcharges', 'post type general name' ),
    'singular_name'      => _x( 'Postcode Surcharge', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'surcharge' ),
    'add_new_item'       => __( 'Add New Postcode Surcharge', 'vbs' ),
    'edit_item'          => __( 'Edit Postcode Surcharge', 'vbs' ),
    'new_item'           => __( 'New Postcode Surcharge', 'vbs' ),
    'all_items'          => __( 'Postcode Surcharges', 'vbs' ),
    'view_item'          => __( 'View Postcode Surcharges', 'vbs' ),
    'search_items'       => __( 'Search Postcode Surcharges', 'vbs' ),
    'not_found'          => __( 'No postcode surcharges found', 'vbs' ),
    'not_found_in_trash' => __( 'No postcode surcharges found in the Trash', 'vbs' ),
    'parent_item_colon'  => '',
    'menu_name'          => __('Postcode Surcharges', 'vbs')
  );
  $args_sur = array(
    'labels'        => $labels_sur,
    'description'   => __('Holds our Postcode Surcharge specific data', 'vbs'),
    'public'        => false,
    'supports'      => array( 'title' ),
    'has_archive'   => false,
    'menu_icon'     => 'dashicons-flag',
    'show_ui'       => true,
    'show_in_menu'  => 'vbs_admin_menu',
  );
  register_post_type( 'postcode_surcharges', $args_sur );

  // Locations Post Type
  $labels_loc = array(
    'name'               => _x( 'Locations', 'post type general name' ),
    'singular_name'      => _x( 'Location', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'location' ),
    'add_new_item'       => __( 'Add New Location', 'vbs' ),
    'edit_item'          => __( 'Edit Location', 'vbs' ),
    'new_item'           => __( 'New Location', 'vbs' ),
    'all_items'          => __( 'Locations', 'vbs' ),
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
    'show_ui'       => true,
    'show_in_menu'  => 'vbs_admin_menu',
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
    'all_items'          => __( 'Bookings', 'vbs' ),
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
    'public'        => false,
    'supports'      => array( 'title' ),
    'has_archive'   => false,
    'menu_icon'     => 'dashicons-calendar-alt',
    'show_ui'       => true,
    'show_in_menu'  => 'vbs_admin_menu',
  );
  register_post_type( 'bookings', $args_book );
}

/* Cars post type custom taxonomy */
add_action( 'init', 'cars_categories_taxonomy');
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

?>