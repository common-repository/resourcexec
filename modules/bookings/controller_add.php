<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Controller_Add_RB_HC_MVC extends _HC_MVC
{
	public function route_index()
	{
		$post = $this->make('/input/lib')->post();
		if( ! $post ){
			return;
		}

		$form = $this->make('form');
		$form->grab( $post );

		$valid = $form->validate();
		if( ! $valid ){
			$form_errors = array(
				$form->slug()	=> $form->errors()
				);
			$form_values = array(
				$form->slug()	=> $form->values()
				);

			$session = $this->make('/session/lib');
			$session
				->set_flashdata('form_errors', $form_errors)
				->set_flashdata('form_values', $form_values)
				;

			$redirect_to = $this->make('/html/view/link')
				->to('-referrer-')
				->href()
				;
			return $this->make('/http/view/response')
				->set_redirect($redirect_to) 
				;
		}

		$values = $form->values();
		$values = $form->run('to-model', $values);

	/* API */
		$api = $this->make('/http/lib/api')
			->request('/api/bookings')
			;
		$api->post( $values );

		$status_code = $api->response_code();
		$api_out = $api->response();

		if( $status_code != '201' ){
			$form_errors = array(
				$form->slug()	=> $api_out['errors']
				);
			$form_values = array(
				$form->slug()	=> $form->values()
				);

			$session = $this->make('/session/lib');
			$session
				->set_flashdata('form_errors', $form_errors)
				->set_flashdata('form_values', $form_values)
				;

			$redirect_to = $this->make('/html/view/link')
				->to('-referrer-')
				->href()
				;
			return $this->make('/http/view/response')
				->set_redirect($redirect_to) 
				;
		}

	// OK
		return $this->run('complete', $api_out, $post);
	}

	public function complete( $result )
	{
	// OK
		$new_id = $result['id'];

		$uri = $this->make('/http/lib/uri');
		$back = $uri->arg('back');

		switch( $back ){
			case 'agenda':
			case 'calendar':
				$redirect_to = $this->make('/html/view/link')
					->to('/' . $back, array('date' => $result['date']) )
					;
				break;
			default:
				$redirect_to = $this->make('/html/view/link')
					->to('zoom', $new_id)
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