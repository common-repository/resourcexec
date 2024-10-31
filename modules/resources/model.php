<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Model_RB_HC_MVC extends _HC_ORM
{
	protected $type = 'resource';
	protected $table = 'resources';
	// protected $fields = array('name', 'show_order', 'description', 'color');
	protected $default_order_by = array(
		'name'	=> 'ASC',
		);
}