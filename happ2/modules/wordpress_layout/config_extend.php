<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$after['/layout/view/body@render'] = array(
	'view/full@extend-body'
	);

$after['/layout/view/assets@css']	= array(
	90	=> 'view/assets@extend-css',
	100	=> 'view/assets@extend-setpath'
	);
$after['/layout/view/assets@js'] = array(
	100	=> 'view/assets@extend-setpath',
	);
