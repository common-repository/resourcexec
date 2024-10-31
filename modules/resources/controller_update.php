<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Controller_Update_RB_HC_MVC extends _HC_MVC
{
	public function route_index( $id )
	{
		$post = $this->make('/input/lib')->post();
		if( ! $post ){
			return;
		}

		$form = $this->make('form');
		$form->grab( $post );

		$valid = $form->validate();
		if( ! $valid ){
			$values = array(
				'id'	=> $id
				);
			return $this->make('controller/zoom')
				->run('prepare-view', $values, $form)
				;
		}

		$values = $form->values();
		$values['id'] = $id;

	/* API */
		$api = $this->make('/http/lib/api')->request('/api/resources');

		$api->put( $id, $values );

		$status_code = $api->response_code();
		$api_out = $api->response();

		if( $status_code != '200' ){
			$form->set_errors( $api_out['errors'] );
			return $this->make('controller/zoom')
				->run('prepare-view', $values, $form)
				;
		}

	// OK
		$redirect_to = $this->make('/html/view/link')
			->to('zoom', $id)
			->href()
			;

		return $this->make('/http/view/response')
			->set_redirect($redirect_to) 
			;
	}
}