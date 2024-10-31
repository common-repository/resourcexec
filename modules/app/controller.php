<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class App_Controller_RB_HC_MVC extends _HC_MVC
{
	public function set_default_route( $args, $src )
	{
		list( $slug, $params ) = $args;

		if( ! $slug ){
			$slug = 'calendar';
			$return = array( $slug, $params );
			return $return;
		}
	}
}