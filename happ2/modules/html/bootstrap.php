<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Html_Bootstrap_HC_MVC extends _HC_MVC
{
	public function run()
	{
		include_once( dirname(__FILE__) . '/view_element.php' );
	}
}
