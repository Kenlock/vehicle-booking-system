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

  // Surcharges Post Type
  $labels_sur = array(
    'name'               => _x( 'Surcharges', 'post type general name' ),
    'singular_name'      => _x( 'Surcharge', 'post type singular name' ),
    'add_new'            => _x( 'Add New', 'surcharge' ),
    'add_new_item'       => __( 'Add New Surcharge', 'vbs' ),
    'edit_item'          => __( 'Edit Surcharge', 'vbs' ),
    'new_item'           => __( 'New Surcharge', 'vbs' ),
    'all_items'          => __( 'Surcharges', 'vbs' ),
    'view_item'          => __( 'View Surcharges', 'vbs' ),
    'search_items'       => __( 'Search Surcharges', 'vbs' ),
    'not_found'          => __( 'No surcharges found', 'vbs' ),
    'not_found_in_trash' => __( 'No surcharges found in the Trash', 'vbs' ),
    'parent_item_colon'  => '',
    'menu_name'          => __('Surcharges', 'vbs')
  );
  $args_sur = array(
    'labels'        => $labels_sur,
    'description'   => __('Holds our Surcharge specific data', 'vbs'),
    'public'        => false,
    'supports'      => array( 'title' ),
    'has_archive'   => false,
    'menu_icon'     => 'dashicons-flag',
    'show_ui'       => true,
    'show_in_menu'  => 'vbs_admin_menu',
  );
  register_post_type( 'surcharges', $args_sur );

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
    'public'        => true,
    'supports'      => array( 'title' ),
    'has_archive'   => true,
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