<?php

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