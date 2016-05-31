<?php

add_action('wp_ajax_get_cost', 'ajax_calculateCost');
add_action('wp_ajax_nopriv_get_cost', 'ajax_calculateCost');
function ajax_calculateCost(){

  $cost = calculateCost($_POST['carid'], $_POST['total_distance'], $_POST['date'], '0', '0');

  echo json_encode( $cost );
  exit;

}

function calculateCost( $car_id, $distance, $date, $start_id, $end_id, $zip_start = nul, $zip_end = null ) {

  // Get pricing for selected car
  $pricing = get_post_meta( $car_id, 'vbs_pricing', true);
  foreach ($pricing as $price) {
    if( $distance >= $price[0] && $distance < $price[1] ) {
      $cost = $distance * $price[2];
    }
  }

  // Get any matching date surcharges and add cost (fixed/percentage)
  $args = array(
    'posts_per_page' => -1,
    'post_type'   => 'date_surcharges',
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

  // Get any matching postcode surcharges and add cost (fixed/percentage)
  $args = array(
    'posts_per_page' => -1,
    'post_type'   => 'postcode_surcharges',
    'post_status' => 'publish',
  );
  $query = get_posts( $args );
  foreach( $query as $sur ) {
    if( get_post_meta( $sur->ID, 'vbs_sur_postcode', true) == $zip_start || get_post_meta( $sur->ID, 'vbs_sur_postcode', true) == $zip_end ) {
      if( get_post_meta( $sur->ID, 'vbs_po_sur_type', true) == 'fixed' ) {
        // Fixed amount
        $cost += get_post_meta( $sur->ID, 'vbs_po_sur_amount', true);
      } else {
        // Percentage
        $cost *= 1 + ( get_post_meta( $sur->ID, 'vbs_po_sur_amount', true) / 100 );
      }
    }
  }

  // Get any matching locations and add cost (fixed/percentage)
  if($start_id != '0' || $end_id != '0') {
    $args = array(
      'posts_per_page' => -1,
      'post_type'   => 'locations',
      'post_status' => 'publish',
    );
    $query = get_posts( $args );
    foreach ( $query as $location ) {
      if( $location->ID == $start_id ) {
        if( get_post_meta( $location->ID, 'vbs_location_sur_type', true) == 'fixed' ) {
          // Fixed amount
          $cost += get_post_meta( $location->ID, 'vbs_location_charge', true);
        } else {
          // Percentage
          $cost *= 1 + ( get_post_meta( $location->ID, 'vbs_location_charge', true) / 100 );
        }
      }
      if( $location->ID == $end_id ) {
        if( get_post_meta( $location->ID, 'vbs_location_sur_type', true) == 'percent' ) {
          // Fixed amount
          $cost += get_post_meta( $location->ID, 'vbs_location_charge', true);
        } else {
          // Percentage
          $cost *= 1 + ( get_post_meta( $location->ID, 'vbs_location_charge', true) / 100 );
        }
      }
    }
  }

  return $cost;
}

?>