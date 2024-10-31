<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Calendar_Controller_RB_HC_MVC extends _HC_MVC
{
	public function route_index()
	{
		$t = $this->make('/app/lib')->run('time');

		$uri_args = $this->make('/http/lib/uri')
			->args()
			;

		if( isset($uri_args['handle']) ){
			return $this->_handle_nav_post( $uri_args['handle'], $uri_args );
		}

	// resource
		if( isset($uri_args['resource']) ){
			$args['resource'] = $uri_args['resource'];
		}

		$range = isset($uri_args['range']) ? $uri_args['range'] : 'week';
		$date = isset($uri_args['date']) ? $uri_args['date'] : $t->setNow()->formatDate_Db();
		list( $start_date, $end_date ) = $t->getDatesRange( $date, $range );

// echo "sd = '$start_date', ed = '$end_date', range = $range<br>";

		$bookings = array();
		$rex_date = $start_date;
		$t->setDateDb( $rex_date );

		while( $rex_date <= $end_date ){
			$t->setDateDb( $rex_date );
			$day_start = $t->getStartDay();
			$day_end = $t->getEndDay();

			$api = $this->run('prepare-model');

			$api
				->add_param('ts_start', array('<', $day_end))
				->add_param('ts_end', array('>', $day_start))
				;

			if( isset($args['resource']) ){
				$api
					->add_param('resources', $args['resource'])
					;
			}

			$this_bookings = $api
				->get()
				->response()
				;
			if( $this_bookings ){
				$bookings[$rex_date] = $this_bookings;
			}

			$t->setDateDb( $rex_date );
			$t->modify('+1 day');
			$rex_date = $t->formatDate_Db();
		}

		$api = $this->make('/http/lib/api')
			->request('/api/resources')
			;
		$resources = $api
			->get()
			->response()
			;

		$dates = array();
		$rex_date = $start_date;
		$t->setDateDb( $rex_date );
		while( $rex_date <= $end_date ){
			$dates[] = $rex_date;
			$t->setDateDb( $rex_date );
			$t->modify('+1 day');
			$rex_date = $t->formatDate_Db();
		}

		$return = $this->run('prepare-view', $resources, $dates, $bookings);
		return $return;
	}

	public function prepare_model()
	{
		$api = $this->make('/http/lib/api')
			->request('/api/bookings')
			->add_param('with', 'resources')
			;
		return $api;
	}

	public function prepare_view( $resources, $dates, $bookings )
	{
		$view = $this->make('view')
			->run('render-week', $resources, $dates, $bookings)
			;
		$view = $this->make('view/layout')
			->run('render', $view)
			;
		$view = $this->make('/layout/view/body')
			->set_content($view)
			;
		return $this->make('/http/view/response')
			->set_view($view)
			;
	}

	protected function _handle_nav_post( $handle, $args )
	{
		$post = $this->make('/input/lib')->post();
		$params = array();

		switch( $handle ){
			case 'date-nav':
				$date_nav = $this->make('/html/view/date-nav')
					->from_array( $args )
					;
				$params = $date_nav->grab( $post );
				break;
		}

		$params['handle'] = NULL;
		$real_params = array();
		foreach( $params as $k => $v ){
			$real_params['-' . $k] = $v;
		}

		$uri = $this->make('/http/lib/uri');
		$redirect_to = $uri->url('-', $real_params);

		return $this->make('/http/view/response')
			->set_redirect($redirect_to) 
			;
	}
}