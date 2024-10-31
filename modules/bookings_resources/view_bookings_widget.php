<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_View_Bookings_Widget_RB_HC_MVC extends _HC_MVC
{
	public function extend_prepare_view( $return, $args )
	{
		$booking = array_shift( $args );
		$date = array_shift( $args );
		$show_for_resource = array_shift( $args );

		if( ! array_key_exists('resources', $booking) ){
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
		}

		if( $show_for_resource && (count($booking['resources']) <= 1) ){
			// don't show resources if it's the only one
		}
		else {
			$p = $this->make('presenter');
			$p->set_data( $booking );
			$return['resources'] = $p->present_resources();
		}

		return $return;
	}
}
