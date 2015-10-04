var map;
var route;

init()
function init() {
  if (!store.enabled) {
    alert('Local storage is not supported by your browser. Please disable "Private Mode", or upgrade to a modern browser.')
    return
  }
}

jQuery(document).ready(function($) {

  flush(); // Remove for pruduction

  $(".formStep1").validate({
    rules: {
      pickup: {
        required: true
      },
      dropoff: {
        required: true
      },
      date_pickup: {
        required: true
      },
      time_pickup: {
        required: true
      }
    },
    messages: {
      pickup: {
        required: "Select a pickup address"
      },
      dropoff: {
        required: "Select a dropoff address"
      },
      date_pickup: {
        required: "Select a date"
      },
      time_pickup: {
        required: "Select a time"
      }
    },
    errorClass: "errormessage",
    onkeyup: false,
    errorClass: 'error',
    validClass: 'valid',
    errorPlacement: function(error, element) {
      var elem = $(element)
      if(!error.is(':empty')) {
         elem.filter(':not(.valid)').qtip({
            overwrite: false,
            content: error,
            position: {
               my: 'bottom center',
               at: 'top center',
               viewport: $(window)
            },
            show: {
               event: false,
               ready: true
            },
            hide: false,
         })
         .qtip('option', 'content.text', error);
      }
      else { elem.qtip('destroy'); }
    },
    success: $.noop
  })

  $(".formStep3").validate({
    rules: {
      first_name: {
        required: true
      },
      last_name: {
        required: true
      },
      email: {
        required: true,
        email: true
      },
      phone: {
        required: true
      },
      payment: {
        required: true
      }
    },
    messages: {
      first_name: {
        required: "Enter your first name"
      },
      last_name: {
        required: "Enter your last name"
      },
      email: {
        required: "Enter your email address"
      },
      phone: {
        required: "Enter a contact phone"
      },
      payment: {
        required: "Please select a payment method"
      }
    },
    errorClass: "errormessage",
    onkeyup: false,
    errorClass: 'error',
    validClass: 'valid',
    errorPlacement: function(error, element) {
      var elem = $(element)
      if(!error.is(':empty')) {
         elem.filter(':not(.valid)').qtip({
            overwrite: false,
            content: error,
            position: {
               my: 'bottom center',
               at: 'top center',
               viewport: $(window)
            },
            show: {
               event: false,
               ready: true
            },
            hide: false,
         })
         .qtip('option', 'content.text', error);
      }
      else { elem.qtip('destroy'); }
    },
    success: $.noop
  })

  // Create map element
  map = new GMaps({
    el: '#map-canvas',
    lat: -12.043333,
    lng: -77.028333,
    zoom: 16,
    height: '500px',
  });

  // Geocomplete address fields
  $("#pickup").geocomplete();
  $("#dropoff").geocomplete();

  // Init for date-time fields
  $.datetimepicker.setLocale('en');
  $("#date_pickup").datetimepicker({
    timepicker:false,
    format:'d.m.Y',
    minDate:'0',
    maxDate: '+1970/01/30'
  });

  $("#time_pickup").datetimepicker({
    datepicker:false,
    format:'H:i'
  });

  $("#date_return").datetimepicker({
    timepicker:false,
    format:'d.m.Y',
    minDate:'0',
    maxDate: '+1970/01/30'
  });

  $("#time_return").datetimepicker({
    datepicker:false,
    format:'H:i'
  });

  // Show return date & time if selected
  $("#return").change(function(){
    $(".return_group").toggle(this.checked);
    set( 'return', '1' );
  })

  $(".route").on("click", function(e){
    e.preventDefault();
    var distance = 0;
    $("#route-info").hide().html('');
    var waypts = [];
    waypts.push({
      location: $('#pickup').val(),
      stopover: true
    });
    map.removeRoutes();
    map.getRoutes({
      origin: $('#base_location').val(),
      destination: $('#dropoff').val(),
      waypoints: waypts,
      travelMode: 'driving',
      callback: function(results){
        routes = results;
        distance = routes[0].legs[0].distance.value + routes[0].legs[1].distance.value;
        set('dist', distance);
        $("#route-info").show().html( '<i class="fa fa-map-o"></i> ' + (distance/1000).toFixed(2) + 'km' );
      }
    });
  })

  // Ajax handler for all buttons
  $(".btn").on("click", function(e){
    e.preventDefault();
    if( $(this).data("goto") == '2' && $(".formStep1").valid() ) {
      $(this).html('<i class="fa fa-spinner fa-pulse"></i> Working...');
      set( 'start', $("#pickup").val() );
      set( 'end', $("#dropoff").val() );
      set( 'pickup_date', $("#date_pickup").val() );
      set( 'pickup_time', $("#time_pickup").val() );
      if( get('return') == '1' ) {
        set( 'return_date', $("#date_return").val() );
        set( 'return_time', $("#time_return").val() );
      }
      // Form data
      var fd = new FormData();
      fd.append( "action", "get_cars" );
      fd.append( "distance", get('dist') );
      fd.append( "pickup_date", get('pickup_date') );
      fd.append( "return", get('return') );

      // ajax call
      $.ajax({
        url: booking.ajax_url,
        processData: false,
        contentType: false,
        data: fd,
        type: 'POST',
        responseType: 'html',
        dataType: 'html',
        success: function( response ) {
          $(".cars").html(response);
          $(".step1, .step2").slideToggle();
        }
      })
    } else if ( $(this).data("goto") == '3' ) {

      $(this).html('<i class="fa fa-spinner fa-pulse"></i> Working...');
      set('cost', $("input[name=cost]:checked").val() );
      set('car', $("input[name=cost]:checked").data("id") );
      // Toggle
      $(".step2, .step3").slideToggle();

    } else if ( $(this).data("goto") == '4' && $(".formStep3").valid() ) {

      $(this).html('<i class="fa fa-spinner fa-pulse"></i> Working...');

      set( 'first_name', $("#first_name").val() );
      set( 'last_name', $("#last_name").val() );
      set( 'email', $("#email").val() );
      set( 'phone', $("#phone").val() );
      set( 'notes', $("#comments").val() );
      set( 'payment', $("input[name=payment]:checked").val() );

      // Populate summary screen
      $("#s_full-name").html( get('first_name') + ' ' + get('last_name') );
      $("#s_email").html( get('email') );
      $("#s_phone").html( get('phone') );
      $("#s_comments").html( get('notes') );

      $("#s_pickup").html( get('start') );
      $("#s_dropoff").html( get('end') );

      $("#s_date-pickup").html( get('pickup_date') + ' - ' + get('pickup_time') );

      if( get('return') == '1' ) {
        $("#s_return").html( 'Yes' );
        $("#s_date-return").html( get('return_date') + ' - ' + get('return_time') );
      } else {
        $("#s_return").html( 'No' );
        $("#s_date-return").html( 'N/A' );
      }

      $("#s_cost").html( get('cost') );
      if( get('payment') == 'paypal' ) {
        $("#s_payment").html( 'PayPal' );
      } else {
        $("#s_payment").html( 'Cash' );
      }

      // Toggle
      $(".step3, .step4").slideToggle();

    } else if ( $(this).data("goto") == 'end' ) {

      $(this).html('<i class="fa fa-spinner fa-pulse"></i> Working...');

      // Form data
      var fd = new FormData();
      fd.append( "full_name", get('first_name') + ' ' + get('last_name') );
      fd.append( "email", get('email') );
      fd.append( "phone", get('phone') );
      fd.append( "payment", get('payment') );
      fd.append( "notes", get('notes') );
      fd.append( "cost", get('cost') );
      fd.append( "start", get('start') );
      fd.append( "end", get('end') );
      fd.append( "car", get('car') );
      fd.append( "pickup_date", get('pickup_date') );
      fd.append( "pickup_time", get('pickup_time') );
      fd.append( "return", get('return') );
      fd.append( "return_date", get('return_date') );
      fd.append( "return_time", get('return_time') );
      fd.append( "action", "create_booking" );
      fd.append( "distance", get('dist') );
      fd.append( "cost", get('cost') );
      fd.append( "nonce", $("#security").val() );

      // Ajax call to create booking
      $.ajax({
        url: booking.ajax_url,
        processData: false,
        contentType: false,
        data: fd,
        type: 'POST',
        responseType: 'json',
        dataType: 'json',
        success: function( booking_response ) {
          $(".final > .response").html(booking_response['text']);
          var booking_id = booking_response['id'];
          var booking_code = booking_response['code'];
          $(".step4, .final").slideToggle();
          console.log( booking_response['email'] );
          if( get('payment') == 'paypal' ) {
            var payment_data = new FormData();
            payment_data.append( "cost", get('cost') );
            payment_data.append( "id" , booking_id);
            payment_data.append( "code" , booking_code);
            payment_data.append( "action", "create_payment" );

            // Ajax call to create PayPal form
            $.ajax({
              url: booking.ajax_url,
              processData: false,
              contentType: false,
              data: payment_data,
              type: 'POST',
              responseType: 'html',
              dataType: 'html',
              success: function( paypal_response ) {
                $('.addon').html( paypal_response );
                $('.paypal > form').submit();
                flush();
              }
            })
          }
        }
      })

    }
  })

});

function set( key, data ) {
  store.set(key, data);
}

function get( key ) {
  data = store.get(key);
  return data;
}

function all() {
  store.forEach(function(key, val) {
    console.log(key, '==', val);
  })
}

function flush() {
  store.clear();
}