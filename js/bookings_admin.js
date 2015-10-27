var map;
var route;

jQuery(document).ready(function($) {

	$('#vbs_dist-button').on("click", function(e) {
	  e.preventDefault();
    map.removeRoutes();
    if( $('#vbs_base').val() != '' ) {
      var waypts = [];
      waypts.push({
        location: $('#vbs_pickup').val(),
        stopover: false
      })
      map.getRoutes({
        origin: $('#vbs_base').val(),
        destination: $('#vbs_dropoff').val(),
        waypoints: waypts,
        travelMode: 'driving',
        callback: function(e){
          routes = e;
          $('#vbs_distance').val(((routes[0].legs[0].distance.value)/1000).toFixed(2));
          alert("Route Calclulated");
        }
      });
    } else {
      map.getRoutes({
        origin: $('#vbs_pickup').val(),
        destination: $('#vbs_dropoff').val(),
        travelMode: 'driving',
        callback: function(e){
          routes = e;
          $('#vbs_distance').val(((routes[0].legs[0].distance.value)/1000).toFixed(2));
          alert("Route Calclulated");
        }
      });
    }
	});

	$('#vbs_cost-button').on("click", function(e) {
	  e.preventDefault();

	  $.ajax({
      url: ajaxurl,
      type: 'post',
      responseType: 'json',
      dataType: 'json',
      cache: false,
      data: {
      	action : 'get_cost',
      	carid: $('#vbs_car').val(),
        total_distance: $('#vbs_distance').val(),
        date: $('input[name=vbs_pickup_date]').val(),
      },
      success: function(response){
	  		$('#vbs_cost').val(response);
        alert("Cost Updated");
      }
    });
	});

	map = new GMaps({
		el: '#map',
		lat: -12.043333,
		lng: -77.028333,
		zoom: 16,
		height: '500px',
	});

});