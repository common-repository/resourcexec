<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Controller_Delete_RB_HC_MVC extends _HC_MVC
{
	public function route_confirm( $id )
	{
		$post = $this->make('/input/lib')->post();
		if( ! $post ){
			return;
		}

		$form = $this->make('form/delete');
		$form->grab( $post );

		$valid = $form->validate();
		if( ! $valid ){
			$values = array(
				'id'	=> $id
				);
			return $this->make('controller/remove')
				->run('prepare-view', $values, $form)
				;
		}

		return $this->run('route-index', $id );
	}

	public function route_index( $id )
	{
	/* API */
		$api = $this->make('/http/lib/api')
			->request('/api/resources')
			;

		$api->delete( $id );

		$status_code = $api->response_code();
		$api_out = $api->response();

		if( $status_code != '204' ){
			echo $api_out['errors'];
			exit;
		}

	// OK
		$redirect_to = $this->make('/html/view/link')
			->to('')
			->href()
			;

		return $this->make('/http/view/response')
			->set_redirect($redirect_to) 
			;
	}
}