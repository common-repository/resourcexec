<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Controller_Add_RB_HC_MVC extends _HC_MVC
{
	public function route_index()
	{
		$post = $this->make('/input/lib')->post();

		$values = $this->run('prepare', $post);
		if( $values === NULL ){
			$redirect_to = $this->make('/html/view/link')
				->to('-referrer-')
				->href()
				;
			return $this->make('/http/view/response')
				->set_redirect($redirect_to) 
				;
		}

		$result = $this->run('submit', $values);
		if( $result === NULL ){
			$redirect_to = $this->make('/html/view/link')
				->to('-referrer-')
				->href()
				;
			return $this->make('/http/view/response')
				->set_redirect($redirect_to) 
				;
		}

	// OK
		return $this->run('complete', $result);
	}

	public function prepare( $post )
	{
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
			return;
		}

		$return = $form->values();
		return $return;
	}

	public function submit( $values )
	{
	/* API */
		$api = $this->make('/http/lib/api')
			->request('/api/resources')
			;
		$api->post( $values );

		$status_code = $api->response_code();
		$api_out = $api->response();

		if( $status_code != '201' ){
			$form = $this->make('form');
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
			return;
		}
		return $api_out;
	}

	public function complete( $result )
	{
		$redirect_to = $this->make('/html/view/link')
			->to('')
			->href()
			;
		return $this->make('/http/view/response')
			->set_redirect($redirect_to) 
			;
	}
}