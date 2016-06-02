<?php

add_action('wp_ajax_get_cars', 'ajax_get_car_list');
add_action('wp_ajax_nopriv_get_cars', 'ajax_get_car_list');
function ajax_get_car_list() {
  $distance = ($_POST['distance'])/1000;
  $is_return = $_POST['return'];
  $date_pickup = $_POST['pickup_date'];
  $start_location_id = $_POST['start_id'];
  $end_location_id = $_POST['end_id'];
  $orig_zip = str_replace(' ', '', $_POST['orig_zip']);
  $dest_zip = str_replace(' ', '', $_POST['dest_zip']);

  $args = array(
    'posts_per_page' => -1,
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
      $cost = calculateCost( get_the_ID(), $distance, $date_pickup, $start_location_id, $end_location_id, $orig_zip, $dest_zip );
      if( $is_return == '1' ) {
        $cost = $cost * 2;
      }
      $car_html .= '<div class="car_data">';
      $car_html .= '<div class="car_image"><img src="' . $src . '" /></div>';
      $car_html .= '<div class="car_info_middle">';
      $car_html .= '<h4 class="car_name">' . get_the_title() . '</h4>';
      $car_html .= '<ul class="car_info">
<li><i class="fa fa-male"></i> ' . rwmb_meta('vbs_passengers') . '</li>
<li><i class="fa fa-suitcase"></i> ' . rwmb_meta('vbs_luggage') . '</li>
<li><i class="fa fa-briefcase"></i> ' . rwmb_meta('vbs_handbag') . '</li>
<li><i class="fa fa-child"></i> ' . rwmb_meta('vbs_child_seats') . '</li>
      </ul>';
      $car_html .= '</div>';
      $car_html .= '<div class="car_info_right"><h1 class="car_cost"><span class="currency">€</span><span class="cost">'. round($cost,2) .'</span></h1>';
      $car_html .= '<input class="selection" type="radio" data-id="' . get_the_ID() . '" name="cost" value="' . round($cost,2) . '" /> ' . __('Select', 'vbs') . '</div>';
      $car_html .= '</div>';
    }
  }
  wp_reset_query();

  echo $car_html;
  exit;
}

add_action('wp_ajax_create_booking', 'ajax_create_booking');
add_action('wp_ajax_nopriv_create_booking', 'ajax_create_booking');
function ajax_create_booking() {

  check_ajax_referer( 'booking-nonce', 'nonce' );

  // Grab POST data
  $pickup       = $_POST['start'];
  $dropoff      = $_POST['end'];
  $distance     = $_POST['distance']/1000;
  $car          = $_POST['car'];
  $cost         = $_POST['cost'];
  $date_pickup  = $_POST['pickup_date'];
  $time_pickup  = $_POST['pickup_time'];
  $is_return    = $_POST['return'];
  if( $is_return == '1' ) {
    $date_return = $_POST['return_date'];
    $time_return = $_POST['return_time'];
  }
  $full_name    = $_POST['full_name'];
  $phone        = $_POST['phone'];
  $email        = $_POST['email'];
  $lead         = $_POST['lead'];
  if( $lead != 'self' ) {
    $lead_full_name = $_POST['lead_full_name'];
    $lead_email     = $_POST['lead_email'];
    $lead_phone     = $_POST['lead_phone'];
  }
  $adults       = $_POST['adults'];
  $kids         = $_POST['kids'];
  $luggage      = $_POST['luggage'];
  $handbags     = $_POST['hand'];
  $notes        = $_POST['notes'];
  $payment      = $_POST['payment'];

  //Create booking
  $booking_code = 'BOOK-'.generateRandomString(5);

  $success['code'] = $booking_code;
  $error = "Not OK...";

  $postData = array(
    'post_title'  => $booking_code,
    'post_type'   => 'bookings',
    'post_status' => 'publish'
  );
  $post = wp_insert_post( $postData );
  if($post) {
    $success['id'] = $post;
    // Booking Details
    update_post_meta($post, "vbs_pickup", $pickup);
    update_post_meta($post, "vbs_dropoff", $dropoff);
    update_post_meta($post, "vbs_distance", $distance);
    update_post_meta($post, "vbs_pickup_date", $date_pickup);
    update_post_meta($post, "vbs_pickup_time", $time_pickup);
    if( $is_return == '1' ) {
      update_post_meta($post, "vbs_return_date", $date_return);
      update_post_meta($post, "vbs_return_time", $time_return);
    }
    update_post_meta($post, "vbs_car", $car);
    update_post_meta($post, "vbs_notes", $notes);

    // Client details
    update_post_meta($post, "vbs_full_name", $full_name);
    update_post_meta($post, 'vbs_email', $email);
    update_post_meta($post, 'vbs_phone', $phone);

    // Lead passenger details
    if( $lead != 'self' ) {
      update_post_meta($post, "vbs_lead_full_name", $lead_full_name );
      update_post_meta($post, "vbs_lead_email", $lead_email);
      update_post_meta($post, "vbs_lead_phone", $lead_phone);
    }

    update_post_meta($post, "vbs_adults", $adults );
    update_post_meta($post, "vbs_kids", $kids);
    update_post_meta($post, "vbs_luggage", $luggage);
    update_post_meta($post, "vbs_handbags", $handbags);

    update_post_meta($post, 'vbs_payment', $payment);
    update_post_meta($post, 'vbs_cost', $cost);

    if($payment == 'paypal') {
      $success['text'] = "Thanks for you booking. An email has been sent with details and payment information. You will now be reditected to PayPal to complete payment.";
    } else {
      $success['text'] = "Thanks for you booking. An email has been sent with details and payment information";
    }
    update_post_meta($post, 'vbs_status', "pending");

    // Add base location (if available)
    global $booking;
    if( $booking['use_base'] ) {
      update_post_meta($post, 'vbs_base', $booking['base_location']);
    }

    // Send email
    $send = send_email( $email, $full_name, $post );
    if( $send ) {
      $success['email'] = "OK";
    } else {
      $success['email'] = "Not sent";
    }

    echo json_encode($success);
  } else {
    echo json_encode($error);
  }

  exit;
}

add_action('wp_ajax_create_payment', 'ajax_create_payment');
add_action('wp_ajax_nopriv_create_payment', 'ajax_create_payment');
function ajax_create_payment() {

  $cost = $_POST['cost'];
  $id = $_POST['id'];
  $code = $_POST['code'];

  global $booking;
  if( $booking['paypal_mode'] ) {
    $paypal_url = "https://www.sandbox.paypal.com/cgi-bin/webscr";
  } else {
    $paypal_url = "https://www.paypal.com/cgi-bin/webscr";
  }

  $html = '<div class="paypal">
            <form action="' . $paypal_url . '" method="post">
            <input type="hidden" name="cmd" value="_xclick">
            <input type="hidden" name="business" value="' . $booking['paypal_email'] . '">
            <input type="hidden" name="item_name" value="' . $code . '">
            <input type="hidden" name="item_number" value="' . $id . '">
            <input type="hidden" name="amount" value="' . $cost . '">
            <input type="hidden" name="no_shipping" value="1">
            <input type="hidden" name="no_note" value="1">
            <input type="hidden" name="currency_code" value="' . $booking['currency_code'] . '">
            <input type="hidden" name="lc" value="US">
            <input type="hidden" name="bn" value="' . $booking['business_name'] . '">
            <input type="hidden" name="notify_url" value="' . get_bloginfo("url") . '/?AngellEYE_Paypal_Ipn_For_Wordpress&action=ipn_handler">
            <input type="hidden" name="return" value="' . get_permalink( $booking['return_page'] ) . '">
          </form>
          </div>';

  echo $html;
  exit;
}

?>