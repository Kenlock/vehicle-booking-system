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
	ob_start();
	require_once PLUGIN_DIR . 'partials/form.php';
	return ob_get_clean();
}
add_shortcode('bookingform', 'booking_form');

function user_bookings() {
	if( is_user_logged_in() ) {
		global $booking;
		$current_user = wp_get_current_user();

		$args = array(
			'post_type'   		=> 'bookings',
			'post_status' 		=> 'publish',
			'posts_per_page'	=> -1,
			'meta_query' 		=> array(
				array(
					'key' => 'vbs_email',
					'value' => $current_user->user_email,
				)
			)
		);

		$usr_bookings = get_posts( $args );
		//$entries = '';
		if( $usr_bookings ) {
			ob_start();
			include PLUGIN_DIR . 'partials/bookings-loop.php';
		}
		return ob_get_clean();
	} else {
		return "You must be logged in to see your bookings";
	}
}
add_shortcode('my_bookings', 'user_bookings');
?>