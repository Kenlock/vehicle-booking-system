<?php // Form renderer ?>
<div id="bookingForm">
	<form class="formStep1" method="POST" enctype="multipart/form-data">
		<div class="step1 container">
		    <div class="form-group row">
		    	<div class="col-sm-5 pl-0 select_pickup">
				    <input type="text" name="pickup" id="pickup" class="required form-control" placeholder="<?php _e('Pickup Location', 'vbs'); ?>" />
				    <select style="display: none;" id="pickup_location" class="form-control" name="pickup_location">
				      	<option value=""><?php _e('Select location...', 'vbs'); ?></option>
				      	<?php echo get_locations(); ?>
				    </select>
				</div>

				<div class="col-sm-5 pl-0 select_destination">
				    <input type="text" name="dropoff" id="dropoff" class="required form-control" placeholder="<?php _e('Dropoff Location', 'vbs'); ?>" />
				    <select style="display: none;" id="dropoff_location" class="form-control" name="dropoff_location">
				      	<option value=""><?php _e('Select location...', 'vbs'); ?></option>
				      	<?php echo get_locations(); ?>
				    </select>
				</div>

				<div class="col-sm-2 p-0">
			    	<button class="btn btn-success route" type="submit"><?php _e('Route!', 'vbs'); ?></button>
			    </div>
			</div>

		    <div class="form-group row selection">
		    	<div class="col-sm-5 pl-0">
		    		<button class="btn btn-success btn-block pick-loc-select" type="submit"><?php _e('Select Location', 'vbs'); ?></button>
		    	</div>

		    	<div class="col-sm-5 pl-0">
		    		<button class="btn btn-success btn-block drop-loc-select" type="submit"><?php _e('Select Location', 'vbs'); ?></button>
		    	</div>
		    </div>

		    <div class="form-group row select_date">
		    	<div class="col-sm-6 pl-0">
		    		<input type="text" name="date_pickup" id="date_pickup" class="required form-control" placeholder="<?php _e('Pickup Date', 'vbs'); ?>" />
		    	</div>

		    	<div class="col-sm-6 p-0">
		    		<input type="text" name="time_pickup" id="time_pickup" class="required form-control" placeholder="<?php _e('Pickup Time', 'vbs'); ?>" />
		    	</div>
		    </div>

		    <div class="form-group form-check row">
		    	<div class="col-sm-12 p-0">
		    		<input type="checkbox" name="return" class="form-check-input" id="return" />
		    		<label for="return" class="form-check-label"><?php _e('Return trip required?', 'vbs'); ?></label>
		    	</div>
		    </div>

		    <div class="form-group row return_group" style="display: none;">
		    	<div class="col-sm-6 pl-0">
		    		<input class="form-control" type="text" name="date_return" id="date_return" placeholder="<?php _e('Dropoff Date', 'vbs'); ?>" />
		    	</div>

		    	<div class="col-sm-6 pl-0">
		    		<input class="form-control" type="text" name="time_return" id="time_return" placeholder="<?php _e('Dropoff Time', 'vbs'); ?>" />
		    	</div>
		    </div>

		    <div class="form-group row" id="route-info" style="display: none;"></div>

			<div id="route_map" style="display: none;">
		  		<div id="map-canvas" class="col-sm-12" style="width: 500px !important; height: 500px !important;"></div>
		  	</div>

		    <div id="validation"></div>

		    <div class="row">
		    	<button class="btn btn-success" data-goto="2" type="submit"><i class="fa fa-arrow-right"></i> <?php _e('Select Car', 'vbs'); ?></button>
		    </div>

		    <div style="display: none;" class="details">
		    	<input type="hidden" id="orig_zip" name="orig_zip" data-orig="postal_code" value="" />
		    	<input type="hidden" id="dest_zip" name="dest_zip" data-dest="postal_code" value="" />
		    </div>

		</div> <!-- step1 end -->

	</form>

	<form id="bookingForm" class="formStep2" method="POST" enctype="multipart/form-data">

		<div class="step2 container" style="display: none;">

			<div class="row">
		  		<h3 class="col-sm-12 section"><?php _e('Select car', 'vbs'); ?></h3>
		  	</div>

		  	<div class="row">
		  		<div class="cars col-sm-12 p-0"></div>
		  	</div>

		  	<div class="row">
		  		<div class="col-sm-6 p-0">
		  			<button class="btn btn-success float-left" data-goto="2" type="submit"><i class="fa fa-arrow-left"></i> <?php _e('Back', 'vbs'); ?></button>
		  		</div>

		  		<div class="col-sm-6 p-0">
		  			<button class="btn btn-success float-right" data-goto="3" type="submit"><i class="fa fa-arrow-right"></i> <?php _e('Details', 'vbs'); ?></button>
		  		</div>
		  	</div>

		</div> <!-- step2 end -->

  	</form>

	<form id="bookingForm" class="formStep3" method="POST" enctype="multipart/form-data">

		<div class="step3 container" style="display: none;">

		  	<div class="info mb-3">
		  		<div class="row">
		  			<h3 class="col-sm-12 section"><?php _e('Contact info:', 'vbs'); ?></h3>
		  		</div>

		  		<?php
					if( is_user_logged_in() ):
				  		$user = wp_get_current_user();
				?>
				    <div class="form-group row">
				    	<div class="col-sm-6 pl-0">
				    		<label for="first_name" class="sr-only"><?php _e('First name', 'vbs'); ?></label>
				    		<input readonly type="text" name="first_name" id="first_name" class="required form-control" value="<?php echo $user->user_firstname; ?>" />
				    	</div>

				    	<div class="col-sm-6 p-0">
				    		<label for="last_name" class="sr-only"><?php _e('Last name', 'vbs'); ?></label>
				        	<input readonly type="text" name="last_name" id="last_name" class="required form-control" value="<?php echo $user->user_lastname; ?>" />
				        </div>
				    </div>

				    <div class="form-group row">
				    	<div class="col-sm-12 p-0">
				    		<label for="email" class="sr-only"><?php _e('Email', 'vbs'); ?></label>
				        	<input readonly type="text" name="email" id="email" class="required form-control" value="<?php echo $user->user_email; ?>" />
				        </div>
				    </div>

				    <div class="form-group row">
				        <div class="col-sm-12 p-0">
				        	<label for="phone" class="sr-only"><?php _e('Phone', 'vbs'); ?></label>
				        	<input type="text" name="phone" id="phone" class="required form-control" placeholder="<?php _e('Phone', 'vbs'); ?>" />
				        </div>
				    </div>

				<?php else: ?>

					<div class="form-group row">
				    	<div class="col-sm-6 pl-0">
				    		<label for="first_name" class="sr-only"><?php _e('First name', 'vbs'); ?></label>
				    		<input type="text" name="first_name" id="first_name" class="required form-control" placeholder="<?php _e('First name', 'vbs'); ?>" />
				    	</div>

				    	<div class="col-sm-6 p-0">
				    		<label for="last_name" class="sr-only"><?php _e('Last name', 'vbs'); ?></label>
				        	<input type="text" name="last_name" id="last_name" class="required form-control" placeholder="<?php _e('Last name', 'vbs'); ?>" />
				        </div>
				    </div>

				    <div class="form-group row">
				    	<div class="col-sm-12 p-0">
				    		<label for="email" class="sr-only"><?php _e('Email', 'vbs'); ?></label>
				        	<input type="text" name="email" id="email" class="required form-control" placeholder="<?php _e('Email', 'vbs'); ?>" />
				        </div>
				    </div>

				    <div class="form-group row">
				        <div class="col-sm-12 p-0">
				        	<label for="phone" class="sr-only"><?php _e('Phone', 'vbs'); ?></label>
				        	<input type="text" name="phone" id="phone" class="required form-control" placeholder="<?php _e('Phone', 'vbs'); ?>" />
				        </div>
				    </div>

				<?php endif; ?>

			    <div class="row">
			    	<h3 class="col-sm-12 section"><?php _e('I am booking for:', 'vbs'); ?></h3>
			    </div>
			    <div class="form-check form-check-inline row mr-4">
			    	<input type="radio" name="lead" id="self" class="required form-check-input" value="self" />
			        <label class="form-check-label" for="self"><?php _e( 'Myself', 'vbs'); ?></label>
			    </div>

			    <div class="form-check form-check-inline row">
			    	<input type="radio" name="lead" id="else" class="required form-check-input" value="else" />
			    	<label class="form-check-label" for="else"><?php _e( 'Someone else', 'vbs'); ?></label>
		        </div>

		        <div class="lead_passenger" style="display: none;">
		        	<div class="row">
		        		<h3 class="col-sm-12 section"><?php _e('Lead Passenger info:', 'vbs'); ?></h3>
		        	</div>
				    <div class="form-group row">
				    	<div class="col-sm-6 pl-0">
				    		<label for="lead_first_name" class="sr-only"><?php _e('First name', 'vbs'); ?></label>
				    		<input type="text" name="lead_first_name" id="lead_first_name" class="required form-control" value="<?php _e('First name', 'vbs'); ?>" />
				    	</div>

				    	<div class="col-sm-6 p-0">
				    		<label for="lead_last_name" class="sr-only"><?php _e('Last name', 'vbs'); ?></label>
				        	<input type="text" name="lead_last_name" id="lead_last_name" class="required form-control" value="<?php _e('Last name', 'vbs'); ?>" />
				        </div>
				    </div>

				    <div class="form-group row">
				    	<div class="col-sm-12 p-0">
				    		<label for="lead_email" class="sr-only"><?php _e('Email', 'vbs'); ?></label>
				        	<input type="text" name="lead_email" id="lead_email" class="required form-control" value="<?php _e('Email', 'vbs'); ?>" />
				        </div>
				    </div>

				    <div class="form-group row">
				        <div class="col-sm-12 p-0">
				        	<label for="lead_phone" class="sr-only"><?php _e('Phone', 'vbs'); ?></label>
				        	<input type="text" name="lead_phone" id="lead_phone" class="required form-control" placeholder="<?php _e('Phone', 'vbs'); ?>" />
				        </div>
				    </div>
		        </div>

		        <div class="row">
			    	<h3 class="col-sm-12 section"><?php _e('Passengers info:', 'vbs'); ?></h3>
			    </div>
			    <div class="form-group row">
			    	<label for="adults" class="col-sm-9 col-form-label"><?php _e('Adults', 'vbs'); ?></label>
			    	<div class="col-sm-3 p-0">
			        	<input type="number" min="1" name="adults" id="adults" class="required form-control" value="1" />
			        </div>
			    </div>

			    <div class="form-group row">
			    	<label for="kids" class="col-sm-9 col-form-label"><?php _e('Children', 'vbs'); ?></label>
			        <div class="col-sm-3 p-0">
			        	<input type="number" min="0" name="kids" id="kids" class="form-control" value="0" />
			        </div>
			    </div>

			    <div class="form-group row">
			    	<label for="luggage" class="col-sm-9 col-form-label"><?php _e('Luggage', 'vbs'); ?></label>
			        <div class="col-sm-3 p-0">
			        	<input type="number" min="0" name="luggage" id="luggage" class="form-control" value="0" />
			        </div>
			    </div>

			    <div class="form-group row">
			    	<label for="hand" class="col-sm-9 col-form-label"><?php _e('Handbags', 'vbs'); ?></label>
			        <div class="col-sm-3 p-0">
			        	<input type="number" min="0" name="hand" id="hand" class="form-control" value="0" />
			        </div>
			    </div>

		        <div class="form-group row">
		        	<div class="col-sm-12 p-0">
		        		<textarea name="comments" class="form-control" id="bookingcomments"><?php _e('Message to driver', 'vbs'); ?></textarea>
		        	</div>
		        </div>

		        <div class="row">
		        	<h3 class="col-sm-12 section"><?php _e('Total Cost:', 'vbs'); ?> <?php echo $booking['currency_symbol']; ?><span id="total_cost"></span></h3>
		        </div>

		        <div class="row">
		        	<h3 class="col-sm-12 section"><?php _e('Payment Method:', 'vbs'); ?></h3>
		        </div>
		        <div class="form-check form-check-inline row mr-4">
		        	<input type="radio" name="payment" id="paypal" class="required form-check-input" value="paypal" />
		        	<label class="form-check-label" for="paypal"><?php _e('Paypal', 'vbs'); ?></label>
			    </div>

			    <div class="form-check row form-check-inline">
			        <input type="radio" name="payment" id="cash" class="required form-check-input" value="cash" />
			        <label class="form-check-label" for="cash"><?php _e('Cash', 'vbs'); ?></label>
		        </div>

		  	</div>

		  	<div class="row">
		  		<div class="col-sm-6 p-0">
		  			<button class="btn btn-success float-left" data-goto="3" type="submit"><i class="fa fa-arrow-left"></i> <?php _e('Back', 'vbs'); ?></button>
		  		</div>

		  		<div class="col-sm-6 p-0">
		  			<button class="btn btn-success float-right" data-goto="4" type="submit"><i class="fa fa-arrow-right"></i> <?php _e('Summary', 'vbs'); ?></button>
		  		</div>
		  	</div>

		</div> <!-- step3 end -->

	</form>

	<form id="bookingForm" class="formStep4" method="POST" enctype="multipart/form-data">

		<div class="step4 container" style="display: none;">

			<div class="row">
		  		<h3 class="col-sm-12 section"><?php _e('Booking Summary', 'vbs'); ?></h3>
		  	</div>
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

		    <div class="row">
		    	<div class="col-sm-6 p-0">
		  			<button class="btn btn-success float-left" data-goto="4" type="submit"><i class="fa fa-arrow-left"></i> <?php _e('Back', 'vbs'); ?></button>
		  		</div>

		  		<div class="col-sm-6 p-0">
		  			<button class="btn btn-success float-right" data-goto="end" type="submit"><i class="fa fa-arrow-right"></i> <?php _e('Book!', 'vbs'); ?></button>
		  		</div>
		  	</div>

		</div> <!-- step4 end -->

		<input type="hidden" name="security" id="security" value="<?php echo wp_create_nonce( 'booking-nonce' ); ?>" />
		<input type="hidden" name="base_location" id="base_location" value="<?php echo $booking['base_location']; ?>" />

	</form>

	<div class="final" style="display: none;">

		<div class="response"></div> <!-- server response -->
		<div class="addon" style="display: none;"></div> <!-- additional data -->

	</div> <!-- result end -->

</div>