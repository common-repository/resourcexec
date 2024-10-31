<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Controller_Delete_RB_HC_MVC extends _HC_MVC
{
	public function route_index()
	{
		$args = hc2_parse_args( func_get_args() );
		$id = isset($args['id']) ? $args['id'] : 0;

	/* API */
		$api = $this->make('/http/lib/api')
			->request('/api/bookings')
			;

		$booking = $api
			->add_param('id', $id)
			->get()
			->response()
			;


		$api = $this->make('/http/lib/api')
			->request('/api/bookings')
			;
		$api->delete( $id );

		$status_code = $api->response_code();
		$api_out = $api->response();

		if( $status_code != '204' ){
			echo $api_out['errors'];
			exit;
		}

		$uri = $this->make('/http/lib/uri');
		$back = $uri->arg('back');

		switch( $back ){
			case 'agenda':
			case 'calendar':
				$redirect_to = $this->make('/html/view/link')
					->to('/' . $back, array('date' => $booking['date']) )
					;
				break;
			default:
				$redirect_to = $this->make('/html/view/link')
					->to('/agenda')
					;
				;
		}

		$redirect_to = $redirect_to
			->href()
			;

		return $this->make('/http/view/response')
			->set_redirect($redirect_to) 
			;
	}
}