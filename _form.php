<?php

// Check is contestant already exists
add_action('wp_ajax_get_cars', 'ajax_get_car_list');
add_action('wp_ajax_nopriv_get_cars', 'ajax_get_car_list');
function ajax_get_car_list() {

  check_ajax_referer( 'get-cars-nonce', 'nonce' );

  $pickup = $_POST['pickup'];
  $dropoff = $_POST['dropoff'];
  $distance = $_POST['distance'];

  $date_pickup = $_POST['date_pickup'];
  $time_pickup = $_POST['time_pickup'];

  $is_return = $_POST['return'];
  if( $is_return != '0' ) {
    $date_return = $_POST['date_return'];
    $time_return = $_POST['time_return'];
  }

  $args = array(
    'post_type'   => 'cars',
    'post_status' => 'publish',
  );
  $car_html = '';
  $query = new WP_Query( $args );
  if( $query->have_posts() ){
    while( $query->have_posts() ){
      $query->the_post();
      $image = rwmb_meta('vbs_car-image', 'type=plupload_image&size=thumbnail');
      foreach ($image as $img) {
        $src = $img['url'];
      }
      $pricing = rwmb_meta('vbs_pricing');
      foreach ($pricing as $price) {
        if( $distance >= $price[0] && $distance < $price[1] ) {
          $cost = $distance * $price[2];
        }
      }
      if( $is_return != '0' ) {
        $cost = $cost * 2;
      }
      $car_html .= '<div class="car_data">';
      $car_html .= '<div class="car_image"><img src="' . $src . '" /></div>';
      $car_html .= '<div class="car_info_right">';
      $car_html .= '<h4 class="car_name">' . get_the_title() . '</h4>';
      $car_html .= '<p class="car_cost"><span class="currency">€</span><span class="cost">'. $cost .'</span></p>';
      $car_html .= '<ul class="car_info">
<li><i class="fa fa-male"></i> ' . rwmb_meta('vbs_passengers') . '</li>
<li><i class="fa fa-suitcase"></i> ' . rwmb_meta('vbs_luggage') . '</li>
<li><i class="fa fa-briefcase"></i> ' . rwmb_meta('vbs_handbag') . '</li>
<li><i class="fa fa-child"></i> ' . rwmb_meta('vbs_child_seats') . '</li>
      </ul>';
      $car_html .= '</div>';
      $car_html .= '<div class="car_info_last"><button class="btn step2" data-cost="' . $cost . '" data-id="' . get_the_ID() . '" type="submit">' . __('Book', 'vbs') . '</button></div>';
      $car_html .= '</div>';
    }
    $car_html .= '<input type="hidden" name="cost" id="cost" />';
    $car_html .= '<input type="hidden" name="car" id="car" />';
    $car_html .= '<input type="hidden" name="security" id="security" value="' . wp_create_nonce( "info-nonce" ) .'" />';
  }
  wp_reset_query();

  //Create booking
  $postData = array(
    'post_title'  => 'BOOK-'.generateRandomString(5),
    'post_type'   => 'bookings',
    'post_status' => 'publish'
  );
  $post = wp_insert_post( $postData );
  if($post) {
    update_post_meta($post, "vbs_pickup", $pickup);
    update_post_meta($post, "vbs_dropoff", $dropoff);
    update_post_meta($post, "vbs_distance", $distance);
    update_post_meta($post, "vbs_pickup_date", $date_pickup);
    update_post_meta($post, "vbs_pickup_time", $time_pickup);
    if( $is_return != '0' ) {
      update_post_meta($post, "vbs_return_date", $date_return);
      update_post_meta($post, "vbs_return_time", $time_return);
    }
    $car_html .= '<input type="hidden" name="booking" id="booking" value="' . $post . '" />';
  }

  echo json_encode($car_html);
  exit;

}

add_action('wp_ajax_get_info', 'ajax_get_info');
add_action('wp_ajax_nopriv_get_info', 'ajax_get_info');
function ajax_get_info() {
  check_ajax_referer( 'info-nonce', 'nonce' );

  $booking_id = $_POST['booking'];
  $car_id = $_POST['car'];
  $cost = $_POST['cost'];
  // Update booking
  update_post_meta($booking_id, "vbs_car", $car_id);
  update_post_meta($booking_id, "vbs_cost", $cost);

  $info_html = '<h3 class="section">' . __('Contact info:', 'vbs') . '</h3>
      <div class="form-group">
        <input type="text" name="first_name" id="first_name" class="required" placeholder="' . __('First name', 'vbs') . '" />
        <input type="text" name="last_name" id="last_name" class="required" placeholder="' . __('Last name', 'vbs') . '" />
      </div>

      <div class="form-group">
        <input type="text" name="email" id="email" class="required" placeholder="' . __('Email', 'vbs') . '" />
        <input type="text" name="phone" id="phone" class="required" placeholder="' . __('Phone', 'vbs') . '" />
      </div>

      <div class="form-group wide">
        <input type="text" name="address" id="address" class="required" placeholder="' . __('Address', 'vbs') . '" />
      </div>

      <div class="form-group wide">
        <textarea name="comments" id="comments">' . __('Message to driver', 'vbs') . '</textarea>
      </div>

      <div class="form-group">
        <h3 class="section">' . __('Payment Method:', 'vbs') . '</h3>
        Paypal <input type="radio" name="payment" id="payment" class="required" value="paypal" />
        Cash <input type="radio" name="payment" id="payment" class="required" value="cash" />
      </div>

      <button class="btn step3" type="submit">' . __('Next: Confirm &amp; Pay', 'vbs') . '</button>';
  $info_html .= '<input type="hidden" name="security" id="security" value="' . wp_create_nonce( "summary-nonce" ) .'" />';
  $info_html .= '<input type="hidden" name="booking" id="booking" value="' . $booking_id . '" />';

  echo json_encode($info_html);
  exit;
}

add_action('wp_ajax_show_summary', 'ajax_summary');
add_action('wp_ajax_nopriv_show_summary', 'ajax_summary');
function ajax_summary() {
  check_ajax_referer( 'summary-nonce', 'nonce' );

  $booking_id = $_POST['booking'];
  $first_name = $_POST['fname'];
  $last_name = $_POST['lname'];
  $email = urldecode($_POST['email']);
  $phone = wp_strip_all_tags($_POST['phone']);
  $addr = wp_strip_all_tags($_POST['address']);
  $notes = wp_strip_all_tags($_POST['notes']);
  $payment = $_POST['payment'];

  if( !email_exists($email) ) {
    $pass =  wp_generate_password( $length=12, $include_standard_special_chars=false );
    $user_id = wp_create_user( $user_name, $pass, $email );
    $userdata = array(
      'ID' => $user_id,
      'first_name' => $first_name,
      'last_name' => $last_name,
      'role' => 'clients',
      'phone' => $phone,
      'address' => $address
    );
    wp_update_user($userdata);
  } else {
    $user_id = get_user_by('email', $email);
    $userdata = array(
      'ID' => $user_id->ID,
      'first_name' => $first_name,
      'last_name' => $last_name,
      'role' => 'clients',
      'phone' => $phone,
      'address' => $address
    );
    wp_update_user($userdata);
  }

  update_post_meta($booking_id, "vbs_user", $user_id);
  update_post_meta($booking_id, "vbs_notes", $notes);

  $summary = '<h3 class="section">' . __('Booking Summary', 'vbs') . '</h3>
      <ul class="summary">
        <li><b>Full Name: </b>' . $first_name . ' ' . $last_name . '</li>
        <li><b>Email: </b><span class="email">' . $email . '</span></li>
        <li><b>Address: </b><span class="address">' . $addr . '</span></li>
        <li><b>Comments: </b><span class="comments">' . $notes . '</span></li>
        <li><br /></li>
        <li><b>Pickup Location: </b><span class="pickup">' . get_post_meta($booking_id, "vbs_pickup", true) . '</span></li>
        <li><b>Dropoff location: </b><span class="dropoff">' . get_post_meta($booking_id, "vbs_dropoff", true) . '</span></li>
        <li><b>Date &amp; Time: </b><span class="date-pickup">' . get_post_meta($booking_id, "vbs_pickup_date", true) . '</span></li>
        <li><b>Return Journey: </b><span class="return"></span></li>
        <li><b>Return Date: </b><span class="date-return">123</span></li>
      </ul>

      <button class="btn" type="submit">' . __('Confirm!', 'vbs') . '</button>';

  echo json_encode($summary);
  exit;
}

?>