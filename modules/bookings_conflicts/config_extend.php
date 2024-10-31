<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$after['/bookings/view/widget@prepare-view']	= 'view/bookings/widget@extend-prepare-view';
$after['/bookings/view/zoom/menubar@render']	= 'view/bookings/zoom/menubar@extend-render';
