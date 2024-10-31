<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['/bookings/model']['has_many']['resources'] = array(
	'their_class'	=> '/resources/model',
	'my_name'		=> 'bookings',
	'relation_name'	=> 'resource_booking',
	);

$config['/resources/model']['belongs_to_many']['bookings'] = array(
	'their_class'	=> '/bookings/model',
	'my_name'		=> 'resources',
	'relation_name'	=> 'resource_booking',
	);
