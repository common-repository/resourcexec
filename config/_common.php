<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
$config['app_version'] = '1.0.2';
$config['dbprefix_version'] = 'v1';

$config['modules'] = array(
	'app',
	'utf8',
	'http',
	'html',
	'theme',
	'input',
	'form',
	'validate',
	'security',
	'encrypt',
	'session',

	'msgbus',
	'flashdata',
	'layout',
	'root',
	'setup',
	'acl',
	'icons',
	// 'icons-icomoon',
	// 'icons-chars',
	'icons-dashicons',

	'code-snippets',
	'conf',
	'auth',

	'calendar',
	'bookings',
	'agenda',
	'reports',

	'resources',
	// 'resource-types',
	// 'availability',
	'timeoff',
	// 'archive',
	'conflicts',
	// 'schedules',

	'recur-dates',

	'users',
	// 'testorm',
	// 'resources2users',
	// 'logaudit',

	'print',

	// 'evastorage',
	'ormrelations',
	);
