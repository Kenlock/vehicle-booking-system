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

?>