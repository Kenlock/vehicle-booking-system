<?php

function calculateCost( $car_id, $distance, $date ) {

  // Get pricing for selected car
  $pricing = get_post_meta( $car_id, 'vbs_pricing', true);
  foreach ($pricing as $price) {
    if( $distance >= $price[0] && $distance < $price[1] ) {
      $cost = $distance * $price[2];
    }
  }

  // Get any matching surcharges
  $args = array(
    'posts_per_page' => -1,
    'post_type'   => 'surcharges',
    'post_status' => 'publish',
  );
  $query = get_posts( $args );
  foreach( $query as $sur ) {
    if( get_post_meta( $sur->ID, 'vbs_sur_start_date', true) == get_post_meta( $sur->ID, 'vbs_sur_end_date', true) ) {
      // Single Day Surcharge
      if( $date == get_post_meta( $sur->ID, 'vbs_sur_start_date', true) ) {
        if( get_post_meta( $sur->ID, 'vbs_sur_type', true) == 'fixed' ) {
          // Fixed amount
          $cost += get_post_meta( $sur->ID, 'vbs_sur_amount', true);
        } else {
          // Percentage
          $cost *= 1 + ( get_post_meta( $sur->ID, 'vbs_sur_amount', true) / 100 );
        }
      }
    } else {
      if( $date >= get_post_meta( $sur->ID, 'vbs_sur_start_date', true) && $date <= get_post_meta( $sur->ID, 'vbs_sur_end_date', true) ) {
        // Date range surcharge
        if( get_post_meta( $sur->ID, 'vbs_sur_type', true) == 'fixed' ) {
          // Fixed amount
          $cost += get_post_meta( $sur->ID, 'vbs_sur_amount', true);
        } else {
          // Percentage
          $cost *= 1 + ( get_post_meta( $sur->ID, 'vbs_sur_amount', true) / 100 );
        }
      }
    }
  }

  return $cost;
}

?>