(function($) {

  $("#pickup").geocomplete();
  $("#dropoff").geocomplete();

  $.datetimepicker.setLocale('en');
  $("#date_pickup").datetimepicker({
    timepicker:false,
    minDate:'0',
    maxDate: '+1970/01/30'
  });

  $("#time_pickup").datetimepicker({
    datepicker:false,
    format:'H:i'
  });

  $("#date_return").datetimepicker({
    timepicker:false,
    minDate:'0',
    maxDate: '+1970/01/30'
  });

  $("#time_return").datetimepicker({
    datepicker:false,
    format:'H:i'
  });

  $("#return").change(function(){
    $(".return_group").toggle(this.checked);
  })

  $("#date_return").datetimepicker({
    minDate:'0',
    maxDate: '+1970/01/30'
  });

  $("#pickup").on("change", function() {
    $("#route-info").show().innerHTML = "";
    calcRoute();
  })

  $("#dropoff").on("change", function() {
    $("#route-info").show().innerHTML = "";
    calcRoute();
  })

  $(".step1").on("click", function(e){
    e.preventDefault();
    var fd = new FormData();
    fd.append("action", "get_cars");
    fd.append("nonce", $("#security").val() );
    fd.append("pickup", $("#pickup").val() );
    fd.append("dropoff", $("#dropoff").val() );
    fd.append("distance", $("#distance").val() );
    fd.append("date_pickup", $("#date_pickup").val() );
    fd.append("time_pickup", $("#time_pickup").val() );
    if($("#return").is(':checked')) {
      fd.append("return", "1");
      fd.append("date_return", $("#date_return").val() );
      fd.append("time_return", $("#time_return").val() );
    }

    $('.step1').html('<i class="fa fa-spinner fa-pulse"></i> Wait...')

    $.ajax({
        url: booking.ajax_url,
        processData: false,
        contentType: false,
        data: fd,
        type: 'POST',
        responseType: 'json',
        dataType: 'json',
        success: function( response ) {
          $(".form_content").html(response);
        }
    })
  })

  $(document.body).on("click", ".step2", function(e){
    e.preventDefault();
    console.log( $(this).data("id") );
    $("#car").val( $(this).data("id") );
    $("#cost").val( $(this).data("cost") );
    var fd = new FormData();
    fd.append("action", "get_info");
    fd.append("nonce", $("#security").val() );
    fd.append("cost", $("#cost").val() );
    fd.append("car", $("#car").val() );

    $('.step2').html('<i class="fa fa-spinner fa-pulse"></i> Wait...')

    $.ajax({
        url: booking.ajax_url,
        processData: false,
        contentType: false,
        data: fd,
        type: 'POST',
        responseType: 'json',
        dataType: 'json',
        success: function( response ) {
          $(".form_content").html(response);
        }
    })
  })

  $(document.body).on("click", ".step3", function(e){
    e.preventDefault();
    var fd = new FormData();
    fd.append("action", "show_summary");
    fd.append("nonce", $("#security").val() );
    fd.append("booking", $("#booking").val() );
    fd.append("first_name", $("#first_name").val() );
    fd.append("last_name", $("#last_name").val() );
    fd.append("email", $("#email").val() );
    fd.append("notes", $("#comments").val() );
    fd.append("phone", $("#phone").val() );
    fd.append("address", $("#address").val() );
    fd.append("payment", $("input[name=payment]:checked").val() );

    $('.step3').html('<i class="fa fa-spinner fa-pulse"></i> Wait...')

    $.ajax({
        url: booking.ajax_url,
        processData: false,
        contentType: false,
        data: fd,
        type: 'POST',
        responseType: 'json',
        dataType: 'json',
        success: function( response ) {
          $(".form_content").html(response);
        }
    })
  })

})( jQuery );

var directionsDisplay;
var directionsService = new google.maps.DirectionsService();
var map;

function initialize() {
  directionsDisplay = new google.maps.DirectionsRenderer();
  var chicago = new google.maps.LatLng(41.850033, -87.6500523);
  var mapOptions = {
    zoom: 6,
    center: chicago
  }
  map = new google.maps.Map(document.getElementById('map-canvas'), mapOptions);
  directionsDisplay.setMap(map);
}

function calcRoute() {
  var start = document.getElementById('pickup').value;
  var end = document.getElementById('dropoff').value;
  var request = {
      origin: start,
      destination: end,
      optimizeWaypoints: true,
      travelMode: google.maps.TravelMode.DRIVING
  };

  directionsService.route(request, function(response, status) {
    if (status == google.maps.DirectionsStatus.OK) {
      //directionsDisplay.setDirections(response); // remove to not display route on map
      var route = response.routes[0];
      var total = 0;
      var total_time = 0;
      for (var i = 0; i < route.legs.length; i++) {
        var routeSegment = i + 1;
        total += route.legs[i].distance.value;
        total_time += route.legs[i].duration.value;
      }
      var dist = (total/1000).toFixed(1);
      var duration = (total_time/60).toFixed(1);
      document.getElementById("route-info").innerHTML = '<i class="fa fa-map-o"></i> ' + dist + 'km / <i class="fa fa-clock-o"></i> (approx. ' + duration + 'mins)';
      document.getElementById("distance").value = dist;
    }
  });
}

google.maps.event.addDomListener(window, 'load', initialize);