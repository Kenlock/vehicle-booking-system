<?php

function get_email_template( $id ) {
  global $booking;
  $body = file_get_contents( PLUGIN_DIR . 'templates/' . $booking['email_template'] . '/index.html' );
  $title = str_replace("[title]", $booking['email_title'], $body);
  $heading = str_replace("[heading]", $booking['email_heading'], $title);
  $intro = str_replace("[intro]", $booking['email_intro'], $heading);

  $banner = str_replace("[banner]", $booking['email_banner'], $intro);
  $logo = str_replace("[logo]", $booking['email_logo'], $banner);

  $link = str_replace("[link]", get_bloginfo('url'), $logo);

  $fb = str_replace("[fb_url]", $booking['facebook_url'], $link);
  $li = str_replace("[li_url]", $booking['linkedin_url'], $fb);
  $tw = str_replace("[tw_url]", $booking['twitter_url'], $li);

  $src = str_replace("[src]", PLUGIN_DIR_URL . 'templates/' . $booking['email_template'] . '/img/', $tw);

  $html = $src;
  $final = str_replace("[details]", get_details( $id ), $html);

  return $final;
}

function get_details( $id ) {
  global $booking;

  $details = '<ul style="list-style-type: none;">
  <li><b>Full Name: </b>' . get_post_meta($id, "vbs_full_name", true) . '</li>
  <li><b>Email: </b>' . get_post_meta($id, "vbs_email", true) . '</li>
  <li><b>Phone: </b>' . get_post_meta($id, "vbs_phone", true) . '</li>
  <li><b>Comments: </b>' . get_post_meta($id, "vbs_notes", true) . '</li>
  <li><br /></li>
  <li><b>Pickup Location: </b>' . get_post_meta($id, "vbs_pickup", true) . '</li>
  <li><b>Dropoff location: </b>' . get_post_meta($id, "vbs_dropoff", true) . '</li>
  <li><b>Date &amp; Time: </b>' . get_post_meta($id, "vbs_pickup_date", true) . ' @ ' . get_post_meta($id, "vbs_pickup_time", true) . '</li>
  <li><b>Return Date &amp; Time: </b>' . get_post_meta($id, "vbs_return_date", true) . ' @ ' . get_post_meta($id, "vbs_return_time", true) . '</li>
  <li><br /></li>
  <li><b>Total Cost: </b>' . $booking['currency_symbol'] . get_post_meta($id, "vbs_cost", true) . '</li>
  <li><b>Payment method: </b>' . get_post_meta($id, "vbs_payment", true) . '</li>
  </ul>';
  return $details;
}

function send_email( $address, $full_name, $booking_id ) {
  global $booking;
  if( $booking['email_mode'] ) {
    require PLUGIN_DIR . 'include/phpmailer/PHPMailerAutoload.php';

    $mail = new PHPMailer;

    $mail->isSMTP();
    $mail->Host = $booking['smtp_host'];
    if( $booking['smtp_auth'] ) {
      $mail->SMTPAuth = true;
      $mail->Username = $booking['smtp_login']['username'];
      $mail->Password = $booking['smtp_login']['password'];
      if( $booking['smtp_secure'] != 'none' ) {
        $mail->SMTPSecure = $booking['smtp_secure'];
      }
    } else {
      $mail->SMTPAuth = false;
    }
    $mail->Port = $booking['smtp_port'];

    $mail->setFrom($booking['default_email'], get_bloginfo('name') );
    $mail->addAddress($address, $full_name);
    $mail->isHTML(true);

    $mail->Subject = $booking['email_title'];
    $mail->Body    = get_email_template( $booking_id );

    if(!$mail->send()) {
      //echo 'Message could not be sent.';
      //echo 'Mailer Error: ' . $mail->ErrorInfo;
      return false;
    } else {
      return true;
    }

  } else {
    add_filter( 'wp_mail_content_type', 'set_html_content_type' );

    $headers = 'From: ' . get_bloginfo("name") . ' <' . $booking['default_email'] . '>' . "\r\n";
    $sent = wp_mail( $address, $booking['email_title'], get_email_template( $full_name, $booking_id ), $headers );

    remove_filter( 'wp_mail_content_type', 'set_html_content_type' );

    if( $sent ) {
      return true;
    } else {
      return false;
    }
  }
}

?>