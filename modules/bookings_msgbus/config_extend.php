<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$after['/bookings/model@save'] 		= 'controller/message@extend-message';
$after['/bookings/model@delete']	= 'controller/message@extend-message';
