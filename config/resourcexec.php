<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
require( dirname(__FILE__) . '/_common.php' );

$config['nts_app_title'] = 'ResourcExec';

$config['modules'] = array_merge( $config['modules'], array(
	'wordpress',
	'silentsetup',
	)
);