<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_View_Bookings_Zoom_Menubar_RB_HC_MVC extends _HC_MVC
{
	public function extend_render( $menubar, $args, $src )
	{
		$booking = array_shift( $args );

		$api = $this->make('/http/lib/api')
			->request('/api/resources')
			->add_param('bookings', $booking['id'])
			;
		$resources = $api
			->get()
			->response()
			;
		$booking['resources'] = array();
		foreach( $resources as $r ){
			$booking['resources'][$r['id']] = $r;
		}

		$p = $this->make('presenter');
		$p->set_data( $booking );
		$menu_title = $p->present_resources();

		$menubar->add(
			'resources',
			$this->make('/html/view/link')
				->to('booking', $booking['id'])
				->add( $menu_title )
			);
		return $menubar;
	}
}