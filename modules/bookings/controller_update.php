<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Controller_Update_RB_HC_MVC extends _HC_MVC
{
	public function route_index()
	{
		$args = hc2_parse_args( func_get_args() );
		$id = isset($args['id']) ? $args['id'] : 0;

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
		$values = $form->run('to-model', $values);

		$values['id'] = $id;

	/* API */
		$api = $this->make('/http/lib/api')
			->request('/api/bookings')
			;

		$api->put( $id, $values );

		$status_code = $api->response_code();
		$api_out = $api->response();

		if( $status_code != '200' ){
			$form->set_errors( $api_out['errors'] );
			return $this->make('controller/zoom')
				->run('prepare-view', $values, $form)
				;
		}

		$uri = $this->make('/http/lib/uri');
		$back = $uri->arg('back');

		switch( $back ){
			case 'agenda':
			case 'calendar':
				$redirect_to = $this->make('/html/view/link')
					->to('/' . $back, array('date' => $api_out['date']) )
					;
				break;
			default:
				$redirect_to = $this->make('/html/view/link')
					->to('-referrer-')
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