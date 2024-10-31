<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Conflicts_Controller_RB_HC_MVC extends _HC_MVC
{
	public function route_index()
	{
		$uri = $this->make('/http/lib/uri');
		$booking_id = $uri->arg('booking');

		$api = $this->make('/http/lib/api')
			->request('/api/conflicts')
			->add_param('booking', $booking_id)
			;

		$entries = $api
			->get()
			->response()
			;

		return $this->run('prepare-view', $entries );
	}

	public function prepare_view( $entries )
	{
		$view = $this->make('view/index')
			->run('render', $entries)
			;
		$view = $this->make('view/index/layout')
			->run('render', $view)
			;
		$view = $this->make('/layout/view/body')
			->set_content($view)
			;
		return $this->make('/http/view/response')
			->set_view($view)
			;
	}
}