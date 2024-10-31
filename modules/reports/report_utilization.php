<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Reports_Report_Utilization_RB_HC_MVC extends _HC_MVC
{
	public function title()
	{
		return HCM::__('Resource Utilization');
	}

	public function render()
	{
		$t = $this->make('/app/lib')->run('time');

	// decide on arguments
		$args = array();
		$uri_args = $this->make('/http/lib/uri')
			->args()
			;

	// resource
		if( isset($uri_args['resource']) ){
			$args['resource'] = $uri_args['resource'];
		}

	// start/end date
		$range = isset($uri_args['range']) ? $uri_args['range'] : 'week';
		$date = isset($uri_args['date']) ? $uri_args['date'] : $t->setNow()->formatDate_Db();
		list( $start_date, $end_date ) = $t->getDatesRange( $date, $range );
		$args['start_date'] = $start_date;
		$args['end_date'] = $end_date;

	// sort
		if( isset($uri_args['sort']) ){
			$args['sort'] = $uri_args['sort'];
		}

		$header = $this->run('prepare-header', $args);
		$rows = $this->run('prepare-rows', $args);
		$sort = $this->run('prepare-sort', $args);

		$out = $this->make('/html/view/container');

		$table = $this->make('/html/view/sorted-table')
			->set_header( $header )
			->set_rows( $rows )
			->set_sort( $sort )
			;

		$table
			->add_cell_style('padding', 'x2', 'y2')
			;

		$date_nav = $this->make('/html/view/date-nav');
		// $date_nav = $this->make('/html/view/element')->tag('div')
			// ->add( $date_nav )
			// ->add_style('padding', 'y2')
			// ->add_style('border', 'bottom')
			// ;
		$out->add('date-nav', $date_nav);
		$out->add('report', $table );
		return $out;
	}

	public function prepare_header( $args )
	{
		$return = array();

		if( ! isset($args['resource']) ){
			$return['resource'] = HCM::__('Resource');
		}

		return $return;
	}

	public function prepare_sort()
	{
		$return = array(
			'resource'	=> 1
			);
		return $return;
	}

	public function prepare_rows( $args )
	{
		$return = array();
		$t = $this->make('/app/lib')->run('time');

		$start_date = isset($args['start_date']) ? $args['start_date'] : NULL;
		$end_date = isset($args['end_date']) ? $args['end_date'] : NULL;

	/* API */
		$api = $this->make('/http/lib/api')
			->request('/api/resources')
			;

		if( isset($args['resource'])){
			$api
				->add_param('id', $args['resource'])
				;
		}
		$api->get();
		$resources = $api->response();

		if( isset($args['resource'])){
			$resources = array( $resources['id'] => $resources );
		}

	/* END OF API */

		$resource_presenter = $this->make('/resources/presenter');
		foreach( $resources as $res ){
			$rid = $res['id'];
			$resource_presenter->set_data($res);
			$return[$rid] = array(
				'resource'		=> $res['name'],
				'resource_view'	=> $resource_presenter->present_title(),
				);
		}

		return $return;
	}
}