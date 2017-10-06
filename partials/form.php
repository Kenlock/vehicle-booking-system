<?php // Form renderer ?>
<div id="bookingForm">
	<form class="formStep1" method="POST" enctype="multipart/form-data">

		<div class="step1">

		    <div class="form-group narrow">
			    <input type="text" name="pickup" id="pickup" class="required" placeholder="<?php _e('Pickup Location', 'vbs'); ?>" />
			    <select style="display: none;" id="pickup_location" name="pickup_location">
			      	<option value=""><?php _e('Select location...', 'vbs'); ?></option>
			      	<?php echo get_locations(); ?>
			    </select>

			    <input type="text" name="dropoff" id="dropoff" class="required" placeholder="<?php _e('Dropoff Location', 'vbs'); ?>" />
			    <select style="display: none;" id="dropoff_location" name="dropoff_location">
			      	<option value=""><?php _e('Select location...', 'vbs'); ?></option>
			      	<?php echo get_locations(); ?>
			    </select>

			    <button class="act route" type="submit"><?php _e('Route!', 'vbs'); ?></button>
			</div>

		    <div class="form-group narrow selection">
		    	<button class="act pick-loc-select" type="submit"><?php _e('Select Location', 'vbs'); ?></button>
		    	<button class="act drop-loc-select" type="submit"><?php _e('Select Location', 'vbs'); ?></button>
		    </div>

		    <div class="form-group">
		    	<input type="text" name="date_pickup" id="date_pickup" class="required" placeholder="<?php _e('Pickup Date', 'vbs'); ?>" />
		    	<input type="text" name="time_pickup" id="time_pickup" class="required" placeholder="<?php _e('Pickup Time', 'vbs'); ?>" />
		    </div>

		    <div class="form-group wide">
		    	<label for="return"><?php _e('Return trip required?', 'vbs'); ?></label> <input type="checkbox" name="return" id="return" />
		    </div>

		    <div class="form-group return_group" style="display: none;">
		    	<input type="text" name="date_return" id="date_return" placeholder="<?php _e('Dropoff Date', 'vbs'); ?>" />
		    	<input type="text" name="time_return" id="time_return" placeholder="<?php _e('Dropoff Time', 'vbs'); ?>" />
		    </div>

		    <div class="form-group" id="route-info" style="display: none;"></div>

			<div id="route_map" style="display: none;">
		  		<div id="map-canvas" style="width: 500px !important; height: 500px !important;"></div>
		  	</div>

		    <div id="validation"></div>

		    <button class="btn" data-goto="2" type="submit"><i class="fa fa-arrow-right"></i> <?php _e('Select Car', 'vbs'); ?></button>

		    <div style="display: none;" class="details">
		    	<input type="hidden" id="orig_zip" name="orig_zip" data-orig="postal_code" value="" />
		    	<input type="hidden" id="dest_zip" name="dest_zip" data-dest="postal_code" value="" />
		    </div>

		</div> <!-- step1 end -->

	</form>

	<form id="bookingForm" class="formStep2" method="POST" enctype="multipart/form-data">

		<div class="step2" style="display: none;">

		  	<h3 class="section"><?php _e('Select car', 'vbs'); ?></h3>
		  	<div class="cars"></div>

		  	<button class="btn" data-goto="3" type="submit"><i class="fa fa-arrow-right"></i> <?php _e('Details', 'vbs'); ?></button>

		</div> <!-- step2 end -->

  	</form>

	<?php
		if( is_user_logged_in() ):
	  		$user = wp_get_current_user();
	?>

	<form id="bookingForm" class="formStep3" method="POST" enctype="multipart/form-data">

		<div class="step3" style="display: none;">

		  	<div class="info">

		  		<h3 class="section"><?php _e('Contact info:', 'vbs'); ?></h3>
			    <div class="form-group">
			    	<input readonly type="text" name="first_name" id="first_name" class="required" value="<?php echo $user->user_firstname; ?>" />
			        <input readonly type="text" name="last_name" id="last_name" class="required" value="<?php echo $user->user_lastname; ?>" />
			    </div>

			    <div class="form-group">
			        <input readonly type="text" name="email" id="email" class="required" value="<?php echo $user->user_email; ?>" />
			        <input type="text" name="phone" id="phone" class="required" placeholder="<?php _e('Phone', 'vbs'); ?>" />
			    </div>

			    <h3 class="section"><?php _e('I am booking for:', 'vbs'); ?></h3>
			    <div class="form-group">
			        <?php _e( 'Myself', 'vbs'); ?> <input type="radio" name="lead" id="lead" class="required" value="self" />
			        <?php _e( 'Someone else', 'vbs'); ?> <input type="radio" name="lead" id="lead" class="required" value="else" />
		        </div>

		        <div class="lead_passenger" style="display: none;">
		        	<h3 class="section"><?php _e('Lead Passenger info:', 'vbs'); ?></h3>
				    <div class="form-group">
				    	<input readonly type="text" name="lead_first_name" id="lead_first_name" class="required" value="<?php _e('First name', 'vbs'); ?>" />
				        <input readonly type="text" name="lead_last_name" id="lead_last_name" class="required" value="<?php _e('Last name', 'vbs'); ?>" />
				    </div>

				    <div class="form-group">
				        <input readonly type="text" name="lead_email" id="lead_email" class="required" value="<?php _e('Email', 'vbs'); ?>" />
				        <input type="text" name="lead_phone" id="lead_phone" class="required" placeholder="<?php _e('Phone', 'vbs'); ?>" />
				    </div>
		        </div>

			    <h3 class="section"><?php _e('Passengers info:', 'vbs'); ?></h3>
			    <div class="form-group">
			        <input type="text" min="1" name="adults" id="adults" class="required" value="1" placeholder="<?php _e('Adults', 'vbs'); ?>" />
			        <input type="text" min="0" name="kids" id="kids" class="" placeholder="<?php _e('Children', 'vbs'); ?>" />
			        <input type="text" min="0" name="luggage" id="luggage" class="" placeholder="<?php _e('Luggage', 'vbs'); ?>" />
			        <input type="text" min="0" name="hand" id="hand" class="" placeholder="<?php _e('Handbags', 'vbs'); ?>" />
			    </div>

		        <div class="form-group wide">
		        	<textarea name="comments" id="comments"><?php _e('Message to driver', 'vbs'); ?></textarea>
		        </div>

		        <h3 class="section"><?php _e('Total Cost:', 'vbs'); ?> <?php echo $booking['currency_symbol']; ?><span id="total_cost"></span></h3>

		        <h3 class="section"><?php _e('Payment Method:', 'vbs'); ?></h3>
		        <div class="form-group">
			        <?php _e('Paypal', 'vbs'); ?> <input type="radio" name="payment" id="payment" class="required" value="paypal" />
			        <?php _e('Cash', 'vbs'); ?> <input type="radio" name="payment" id="payment" class="required" value="cash" />
		        </div>

		  	</div>

		  	<button class="btn" data-goto="4" type="submit"><i class="fa fa-arrow-right"></i> <?php _e('Summary', 'vbs'); ?></button>

		</div> <!-- step3 end -->

	</form>

	<?php else: ?>

	<form id="bookingForm" class="formStep3" method="POST" enctype="multipart/form-data">

		<div class="step3" style="display: none;">

		 	<div class="info">

		  		<h3 class="section"><?php _e('Contact info:', 'vbs'); ?></h3>
		        <div class="form-group">
		        	<input type="text" name="first_name" id="first_name" class="required" placeholder="<?php _e('First name', 'vbs'); ?>" />
		        	<input type="text" name="last_name" id="last_name" class="required" placeholder="<?php _e('Last name', 'vbs'); ?>" />
		        </div>

		      	<div class="form-group">
		        	<input type="text" name="email" id="email" class="required" placeholder="<?php _e('Email', 'vbs'); ?>" />
		        	<input type="text" name="phone" id="phone" class="required" placeholder="<?php _e('Phone', 'vbs'); ?>" />
		        </div>

		        <h3 class="section"><?php _e('I am booking for:', 'vbs'); ?></h3>
			    <div class="form-group">
			        <?php _e( 'Myself', 'vbs'); ?> <input type="radio" name="lead" id="lead" class="required" checked="checked" value="self" />
			        <?php _e( 'Someone else', 'vbs'); ?> <input type="radio" name="lead" id="lead" class="required" value="else" />
		        </div>

		        <div class="lead_passenger" style="display: none;">
		        	<h3 class="section"><?php _e('Lead Passenger info:', 'vbs'); ?></h3>
				    <div class="form-group">
				    	<input type="text" name="lead_first_name" id="lead_first_name" class="required" value="<?php _e('First name', 'vbs'); ?>" />
				        <input type="text" name="lead_last_name" id="lead_last_name" class="required" value="<?php _e('Last name', 'vbs'); ?>" />
				    </div>

				    <div class="form-group">
				        <input type="text" name="lead_email" id="lead_email" class="required" value="<?php _e('Email', 'vbs'); ?>" />
				        <input type="text" name="lead_phone" id="lead_phone" class="required" placeholder="<?php _e('Phone', 'vbs'); ?>" />
				    </div>
		        </div>

		        <h3 class="section"><?php _e('Passengers info:', 'vbs'); ?></h3>
			    <div class="form-group 4col">
			        <input type="number" min="1" name="adults" id="adults" class="required" value="1" placeholder="<?php _e('Adults', 'vbs'); ?>" />
			        <input type="number" min="0" name="kids" id="kids" class="" placeholder="<?php _e('Children', 'vbs'); ?>" />
			        <input type="number" min="0" name="luggage" id="luggage" class="" placeholder="<?php _e('Luggage', 'vbs'); ?>" />
			        <input type="number" min="0" name="hand" id="hand" class="" placeholder="<?php _e('Handbags', 'vbs'); ?>" />
			    </div>

		      	<div class="form-group wide">
		        	<textarea name="comments" id="comments"><?php _e('Message to driver', 'vbs'); ?></textarea>
		      	</div>

		      	<h3 class="section"><?php _e('Total Cost:', 'vbs'); ?> <?php echo $booking['currency_symbol']; ?><span id="total_cost"></span></h3>

		      	<h3 class="section"><?php _e('Payment Method:', 'vbs'); ?></h3>
		        <div class="form-group">
			        <?php _e('Paypal', 'vbs'); ?> <input type="radio" name="payment" id="payment" class="required" value="paypal" />
			        <?php _e('Cash', 'vbs'); ?> <input type="radio" name="payment" id="payment" class="required" value="cash" />
		        </div>

			</div>

		  	<button class="btn" data-goto="4" type="submit"><i class="fa fa-arrow-right"></i> <?php _e('Summary', 'vbs'); ?></button>

		</div> <!-- step3 end -->

	</form>
	
	<?php endif; ?>

	<form id="bookingForm" class="formStep4" method="POST" enctype="multipart/form-data">

		<div class="step4" style="display: none;">

		  	<h3 class="section"><?php _e('Booking Summary', 'vbs'); ?></h3>
		  	<ul class="summary">
		        <li><b><?php _e('Full Name:', 'vbs'); ?> </b><span id="s_full-name"></span></li>
		        <li><b><?php _e('Email:', 'vbs'); ?> </b><span id="s_email"></span></li>
		        <li><b><?php _e('Phone:', 'vbs'); ?> </b><span id="s_phone"></span></li>
		        <li><b><?php _e('Comments:', 'vbs'); ?> </b><span id="s_comments"></span></li>
		        <li><br /></li>
		        <li class="lp"><?php _e('Lead passenger info:', 'vbs'); ?></li>
		        <li class="lp"><b><?php _e('Full Name:', 'vbs'); ?> </b><span id="lp_full-name"></span></li>
		        <li class="lp"><b><?php _e('Email:', 'vbs'); ?> </b><span id="lp_email"></span></li>
		        <li class="lp"><b><?php _e('Phone:', 'vbs'); ?> </b><span id="lp_phone"></span></li>
		        <li class="lp"><br /></li>
		        <li><?php _e('Paggengers info:', 'vbs'); ?></li>
		        <li><b><?php _e('Adults:', 'vbs'); ?> </b><span id="s_adults"></span></li>
		        <li><b><?php _e('Children:', 'vbs'); ?> </b><span id="s_kids"></span></li>
		        <li><b><?php _e('Luggage:', 'vbs'); ?> </b><span id="s_luggage"></span></li>
		        <li><b><?php _e('Handbags:', 'vbs'); ?> </b><span id="s_hand"></span></li>
		        <li><br /></li>
		        <li><b><?php _e('Pickup Location:', 'vbs'); ?> </b><span id="s_pickup"></span></li>
		        <li><b><?php _e('Dropoff location:', 'vbs'); ?> </b><span id="s_dropoff"></span></li>
		        <li><b><?php _e('Date &amp; Time:', 'vbs'); ?> </b><span id="s_date-pickup"></span></li>
		        <li class="round-trip"><b><?php _e('Return Journey:', 'vbs'); ?> </b><span id="s_return"></span></li>
		        <li class="round-trip"><b><?php _e('Return Date &amp; Time:', 'vbs'); ?> </b><span id="s_date-return"></span></li>
		        <li><br /></li>
		        <li><b><?php _e('Total Cost:', 'vbs'); ?> </b><?php echo $booking['currency_symbol']; ?><span id="s_cost"></span></li>
		        <li><b><?php _e('Payment method:', 'vbs'); ?> </b><span id="s_payment"></span></li>
		    </ul>

		  	<button class="btn" data-goto="end" type="submit"><i class="fa fa-arrow-right"></i> <?php _e('Book!', 'vbs'); ?></button>

		</div> <!-- step4 end -->

		<input type="hidden" name="security" id="security" value="<?php echo wp_create_nonce( 'booking-nonce' ); ?>" />
		<input type="hidden" name="base_location" id="base_location" value="<?php echo $booking['base_location']; ?>" />

	</form>

	<div class="final" style="display: none;">

		<div class="response"></div> <!-- server response -->
		<div class="addon" style="display: none;"></div> <!-- additional data -->

	</div> <!-- result end -->

</div>