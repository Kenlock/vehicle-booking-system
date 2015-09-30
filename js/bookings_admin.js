var map;
var route;

jQuery(document).ready(function($) {
  //console.log( "ready!" );

	$('#vbs_dist-button').on("click", function(e) {
	  e.preventDefault();
	  map.getRoutes({
		  origin: $('#vbs_pickup').val(),
		  destination: $('#vbs_dropoff').val(),
		  travelMode: 'driving',
		  callback: function(e){
		    routes = e;
		    //alert(routes[0].legs[0].distance.value);
		    $('#vbs_distance').val(((routes[0].legs[0].distance.value)/1000).toFixed(2))
		  }
		});
	  //$('#vbs_distance').val(distance);
	});

	$('#vbs_cost-button').on("click", function(e) {
	  e.preventDefault();
	  var car = $('#vbs_car').val();
	  $('#vbs_car_id').val(car);
	  var distance = $('#vbs_distance').val();
	  $.ajax({
      url: ajaxurl,
      type: 'post',
      data: {
      	action : 'get_meta',
      	postid: car,
      	field: 'vbs_cost_dist',
      },
      success: function(response){
	  		$('#vbs_cost').val(distance * response);
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