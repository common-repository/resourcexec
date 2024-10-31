<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Conflicts_Api_RB_HC_MVC extends _HC_MVC
{
	public function get( $where = NULL )
	{
		$args = hc2_parse_args( func_get_args(), TRUE );

		$return = array();

		if( ! isset($args['booking']) ){
			return $this->make('/http/view/response')
				->set_status_code('404')
				;
		}
		// if( ! isset($args['date']) ){
			// return $this->make('/http/view/response')
				// ->set_status_code('404')
				// ;
		// }

		$booking_id = $args['booking'];

		$booking = $this->make('/http/lib/api')
			->request('/api/bookings')
			->add_param('id', $booking_id)
			->add_param('with', 'resources')
			->get()
			->response()
			;

		$cm = $this->make('model/manager');
		$return = $cm->run('conflicts', $booking);

		$return = json_encode( $return );

		return $this->make('/http/view/response')
			->set_status_code('200')
			->set_view( $return )
			;

		return $return;
	}
}