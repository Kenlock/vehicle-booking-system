<?php

// Adds extra profile fields
add_filter('user_contactmethods', 'modify_contact_methods');
function modify_contact_methods($profile_fields) {
  $profile_fields['phone'] = 'Phone';
  $profile_fields['address'] = 'Address';
  return $profile_fields;
}

// Add map to add booking edit page map element
add_action( 'admin_notices', 'add_map_element' );
function add_map_element() {
  global $pagenow;
  if( $pagenow == 'post.php' )
    echo '<div id="map" style="display: none; width: 1px; height: 1px;"></div>';
}

add_action('wp_ajax_get_meta', 'get_meta');
function get_meta() {
  $postid = isset($_POST['postid']) ? $_POST['postid'] : '';
  $field = isset($_POST['field']) ? $_POST['field'] : '';
  if ( $postid && $field  ) {
    $result = get_post_meta($postid, $field, true);
  }
  echo $result;
  die();
}

function generateRandomString($length = 5) {
    $characters = '0123456789';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

// Make cost and distance fields readonly
add_filter( 'rwmb_vbs_cost_html', 'prefix_input_readonly' );
add_filter( 'rwmb_vbs_distance_html', 'prefix_input_readonly' );
function prefix_input_readonly( $html ) {
  return str_replace( '<input', '<input readonly', $html );
}

// Change Elusive Icons to Font Awesome
function FAIconFont() {
  wp_deregister_style( 'redux-elusive-icon' );
  wp_deregister_style( 'redux-elusive-icon-ie7' );

  wp_register_style( 'redux-font-awesome', '//maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css', array(), time(), 'all' );
  wp_enqueue_style( 'redux-font-awesome' );
}
add_action( 'redux/page/booking/enqueue', 'FAIconFont' );

function set_html_content_type() {
  return 'text/html';
}

add_action( 'admin_menu', 'remove_redux_menu',12 );
function remove_redux_menu() {
  remove_submenu_page('tools.php','redux-about');
}

function get_locations() {
  $select = '';
  $args = array(
    'posts_per_page' => -1,
    'post_type'   => 'locations',
    'post_status' => 'publish',
  );
  $query = get_posts( $args );
  foreach ($query as $location) {
    $select .= '<option value="' . get_post_meta($location->ID, 'vbs_address', true) . '" data-id="' . $location->ID . '">' . get_the_title($location->ID) . '</option>';
  }
  return $select;
}

?>