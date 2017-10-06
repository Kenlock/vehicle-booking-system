# Vehicle Booking System for Wordpress
Taxi booking Plugin for Wordpress. Ideal for companies that calculate fares using route length.

## NOTE: Do not send emails asking for support, file an issue on github instead

Features:
* Google Maps API for distance calculation and Places
* Redux Framework
* Custom post types and Metaboxes
* AJAX form handling
* Simple multi-step form
* qTip 2 tooltips for error messages
* Car costs can be fixed or incremental
* Date based surcharges (fixed or percentage based)
* Locations can have extra charges

###Usage
This plugin uses 3 main shortcodes:
* [carlist] - Displays all cars currently in the system.
* [bookingform] - Displays the multi-step ajax-powered booking form.
* [my_bookings] - Displays the current logged in user's booking history.

###TODO
* More shortcodes
* More plugin options
* Better metabox handling
* Better admin styling

###Basic Roubleshooting
If you face issues with the calculation of the total price, check the following:
* Tier pricing for cars
* Surcharges

If you face problems with the calculation of route distance, check the following:
* Use google maps website (maps.google.com) and try the same route
* Make sure another plugin or theme does not interfere with this plugin
