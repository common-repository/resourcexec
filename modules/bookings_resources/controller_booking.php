<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_Controller_Booking_RB_HC_MVC extends _HC_MVC
{
	public function route_index( $id )
	{
	/* API */
		$api = $this->make('/http/lib/api')
			->request('/api/bookings')
			->add_param('with', 'resources')
			->add_param('id', $id)
			->get()
			;
	/* END OF API */
		$booking = $api->response();

		$form = $this->make('form/booking')
			->set_model( $booking )
			;

		$view = $this->make('view/booking')
			->run('render', $booking, $form)
			;
		$view = $this->make('view/booking/layout')
			->run('render', $view, $booking)
			;
		$view = $this->make('/layout/view/body')
			->set_content($view)
			;
		return $this->make('/http/view/response')
			->set_view( $view )
			;
	}

	public function route_update( $id )
	{
	/* API */
		$api = $this->make('/http/lib/api')
			->request('/api/bookings')
			->add_param('with', 'resources')
			->add_param('id', $id)
			->get()
			;
	/* END OF API */
		$booking = $api->response();

		$form = $this->make('form/booking')
			->set_model( $booking )
			;

		$post = $this->make('/input/lib')->post();
		$form->grab( $post );
		$values = $form->values();

		$validator = $this->make('validator/booking');

		$valid = $validator->validate( $values );
		if( ! $valid ){
			$errors = $validator->errors();
			$form->set_errors( $errors );
			return $this->route_index( $id );
		}

	/* API */
		$values = array(
			'resources'	=> $values['resources']
			);

		$api = $this->make('/http/lib/api')
			->request('/api/bookings')
			->put( $id, $values )
			;
	/* END OF API */

		$status_code = $api->response_code();
		$api_out = $api->response();

		if( $status_code != '200' ){
			$this->form->set_errors( $api_out['errors'] );
			return $this->route_index( $id );
		}

		$redirect_to = $this->make('/html/view/link')
			->to('/bookings/zoom', array('id' => $id))
			->href()
			;
		return $this->make('/http/view/response')
			->set_redirect($redirect_to)
			;
	}
}