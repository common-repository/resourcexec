<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Reports_Controller_RB_HC_MVC extends _HC_MVC
{
	public function reports()
	{
		$return = array(
			'resource-utilization'	=> $this->make('report/utilization'),
			);
		return $return;
	}

	public function route_index()
	{
		$t = $this->make('/app/lib')->run('time');
		$args = hc2_parse_args( func_get_args() );

		if( isset($args['handle']) ){
			return $this->_handle_nav_post( $args['handle'], $args );
		}

		$reports = $this->run('reports');

		$uri = $this->make('/http/lib/uri');
		$rid = $uri->arg('report');
		if( ! $rid ){
			$rid = key($reports);
		}
		$report = $reports[$rid];

		$view = $this->make('view')
			->run('render', $report, $reports)
			;

		$header = $this->make('view/header');
		$menubar = $this->make('view/menubar')
			->run('render')
			;

		$view = $this->make('/layout/view/content-header-menubar')
			->set_content( $view )
			->set_header( $header )
			->set_menubar( $menubar )
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
					->set_by_array( $args )
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