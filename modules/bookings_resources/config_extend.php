<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$after['/bookings/view/zoom/menubar@render'] = 'view/bookings/zoom/menubar@extend-render';
$after['/bookings/view/widget@prepare-view'] = 'view/bookings/widget@extend-prepare-view';

// add resource to the form if supplied in the url
$after['/bookings/form@-init'] = 'form/bookings@extend-init';
$after['/bookings/form@to-model'] = 'form/bookings@extend-to-model';
$after['/bookings/controller/add@prepare'] = 'controller/bookings/add@extend-prepare';
$after['/bookings/controller/add@complete'] = 'controller/bookings/add@extend-complete';