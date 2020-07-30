<?php
// Used to display user's bookings in a loop
foreach ($usr_bookings as $bookings):
?>
<div class="booking_entry container">
	<h4 class="pt-2">#<?php echo get_the_title($bookings->ID); ?></h4>
	<div class="row info">
		<div class="col-sm-6 pickup">
			<span>From</span>
			<p><?php echo get_post_meta($bookings->ID, 'vbs_pickup', true); ?></p>
		</div>
		<div class="col-sm-6 dropoff">
			<span>To</span>
			<p><?php echo get_post_meta($bookings->ID, 'vbs_dropoff', true); ?></p>
		</div>
	</div>
	<div class="row pt-4 details">
		<div class="col-sm-6 route">
			<p>Date: <?php echo get_post_meta($bookings->ID, 'vbs_pickup_date', true); ?> @ <?php echo get_post_meta($bookings->ID, 'vbs_pickup_time', true); ?></p>
			<p>Return: <?php echo get_post_meta($bookings->ID, 'vbs_return_date', true); ?> @ <?php echo get_post_meta($bookings->ID, 'vbs_return_time', true); ?></p>
			<p>Car: <?php echo get_the_title( get_post_meta($bookings->ID, 'vbs_car', true) ); ?></p>
			<p>Cost: <?php echo $booking['currency_symbol'] . get_post_meta($bookings->ID, 'vbs_cost', true); ?></p>
		</div>
		<div class="col-sm-6 status <?php echo get_post_meta($bookings->ID,'vbs_status',true); ?>">
			<span><?php echo get_post_meta($bookings->ID,'vbs_status',true); ?></span>
		</div>
	</div>
</div>

<?php endforeach; ?>