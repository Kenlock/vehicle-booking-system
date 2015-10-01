<?php

// Cars List
function cars_list( $atts ) {
	$vars = shortcode_atts(array(
		'limit' 		=> -1,
		'category'  => '',
	), $atts );

	$args = array(
		'post_type' 	=> 'cars',
		'post_status' => 'publish',
		'limit'				=> $limit,
		'category_name'	=> '',
	);
	$html = '<ul>';
	$query = new WP_Query( $args );
		if( $query->have_posts() ){
			while( $query->have_posts() ){
				$query->the_post();
				$html .= '<li>' . get_the_title() . '</li>';
			}
		}
		wp_reset_query();
	$html .= '</ul>';
	return $html;
}
add_shortcode( 'carlist', 'cars_list' );

// Booking Form
function booking_form() {

	global $booking;

	$html = '<form action="" id="bookingForm" method="POST" enctype="multipart/form-data">

		<div class="step1">

	    <div class="form-group narrow">
	      <input type="text" name="pickup" id="pickup" class="required" placeholder="' . __('Pickup Location', 'vbs') . '" />
	      <input type="text" name="dropoff" id="dropoff" class="required" placeholder="' . __('Dropoff Location', 'vbs') . '" />
	      <button class="act route" type="submit">' . __('Route!', 'vbs') . '</button>
	    </div>

	    <div class="form-group">
	    	<input type="text" name="date_pickup" id="date_pickup" class="required" />
	    	<input type="text" name="time_pickup" id="time_pickup" class="required" />
	    </div>

	    <div class="form-group wide">
	    	<label for="return">' . __('Return trip required?', 'vbs') . '</label> <input type="checkbox" name="return" id="return" />
	    </div>

	    <div class="form-group return_group" style="display: none;">
	    	<input type="text" name="date_return" id="date_return" />
	    	<input type="text" name="time_return" id="time_return" />
	    </div>

	    <div class="form-group" id="route-info" style="display: none;"></div>

	    <button class="btn" data-goto="2" type="submit"><i class="fa fa-arrow-right"></i> ' . __('Select Car', 'vbs') . '</button>

	  </div> <!-- step1 end -->



	  <div class="step2" style="display: none;">

	  	<h3 class="section">' . __('Select car', 'vbs') . '</h3>
	  	<div class="cars"></div>

	  	<button class="btn" data-goto="3" type="submit"><i class="fa fa-arrow-right"></i> ' . __('Details', 'vbs') . '</button>

	  </div> <!-- step2 end -->



	  <div class="step3" style="display: none;">

	  	<div class="info">

	  		<h3 class="section">' . __('Contact info:', 'vbs') . '</h3>
	      <div class="form-group">
	        <input type="text" name="first_name" id="first_name" class="required" placeholder="' . __('First name', 'vbs') . '" />
	        <input type="text" name="last_name" id="last_name" class="required" placeholder="' . __('Last name', 'vbs') . '" />
	      </div>

	      <div class="form-group">
	        <input type="text" name="email" id="email" class="required" placeholder="' . __('Email', 'vbs') . '" />
	        <input type="text" name="phone" id="phone" class="required" placeholder="' . __('Phone', 'vbs') . '" />
	      </div>

	      <div class="form-group wide">
	        <textarea name="comments" id="comments">' . __('Message to driver', 'vbs') . '</textarea>
	      </div>

	      <div class="form-group">
	        <h3 class="section">' . __('Payment Method:', 'vbs') . '</h3>
	        Paypal <input type="radio" name="payment" id="payment" class="required" value="paypal" />
	        Cash <input type="radio" name="payment" id="payment" class="required" value="cash" />
	      </div>

	  	</div>

	  	<button class="btn" data-goto="4" type="submit"><i class="fa fa-arrow-right"></i> ' . __('Summary', 'vbs') . '</button>

	  </div> <!-- step3 end -->



	  <div class="step4" style="display: none;">

	  	<h3 class="section">' . __('Booking Summary', 'vbs') . '</h3>
	  	<ul class="summary">
        <li><b>Full Name: </b><span id="s_full-name"></span></li>
        <li><b>Email: </b><span id="s_email"></span></li>
        <li><b>Phone: </b><span id="s_phone"></span></li>
        <li><b>Comments: </b><span id="s_comments"></span></li>
        <li><br /></li>
        <li><b>Pickup Location: </b><span id="s_pickup"></span></li>
        <li><b>Dropoff location: </b><span id="s_dropoff"></span></li>
        <li><b>Date &amp; Time: </b><span id="s_date-pickup"></span></li>
        <li><b>Return Journey: </b><span id="s_return"></span></li>
        <li><b>Return Date &amp; Time: </b><span id="s_date-return"></span></li>
        <li><br /></li>
        <li><b>Total Cost: </b><span id="s_cost"></span></li>
        <li><b>Payment method: </b><span id="s_payment"></span></li>
      </ul>

	  	<button class="btn" data-goto="end" type="submit"><i class="fa fa-arrow-right"></i> ' . __('Book!', 'vbs') . '</button>

	  </div> <!-- step4 end -->



	  <div id="map-canvas" style="display: none;"></div>
	  <input type="hidden" name="security" id="security" value="' . wp_create_nonce( "booking-nonce" ) .'" />
	  <input type="hidden" name="base_location" id="base_location" value="' . $booking['base_location'] . '" />

</form>

<div class="final" style="display: none;">

	<div class="response"></div> <!-- server response -->
	<div class="addon" style="display: none;"></div> <!-- additional data -->

</div> <!-- result end -->';
return $html;
}
add_shortcode('bookingform', 'booking_form');

?>