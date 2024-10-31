<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Conflicts_Model_Overlap_RB_HC_MVC extends _HC_MVC
{
	public function conflicts( $return, $args )
	{
		$my_return = array();
		$booking = array_shift( $args );
		$date = array_shift( $args );

		if( ! isset($booking['resources']) ){
			$api = $this->make('/http/lib/api')
				->request('/api/resources')
				->add_param('bookings', $booking['id'])
				;
			$resources = $api
				->get()
				->response()
				;
			$booking['resources'] = array();
			foreach( $resources as $r ){
				$booking['resources'][$r['id']] = $r;
			}
		}

		$this_rids = array_keys($booking['resources']);
		if( ! $this_rids ){
			return $return;
		}

		if( ! (isset($booking['ts_start']) && isset($booking['ts_end'])) ){
			return $return;
		}

		$my_ts_start = $booking['ts_start'];
		$my_ts_end = $booking['ts_end'];

		if( $date ){
			$t = $this->make('/app/lib')->run('time');
			$t->setDateDb( $date );
			$day_start = $t->getStartDay();
			$day_end = $t->getEndDay();

			if( $my_ts_start < $day_start ){
				$my_ts_start = $day_start;
			}
			if( $my_ts_end > $day_end ){
				$my_ts_end = $day_end;
			}
		}

		$api = $this->make('/http/lib/api')
			->request('/api/bookings')
			;

		$api
			->add_param('resources',	array('IN', $this_rids) )
			;
		if( isset($booking['id']) && $booking['id'] ){
			$api
				->add_param('id',	array('<>', $booking['id']) )
				;
		}

		if( ($my_ts_start !== NULL) && ($my_ts_end !== NULL) ){
			$api
				->add_param('ts_start',	array('<', $my_ts_end) )
				->add_param('ts_end',	array('>', $my_ts_start) )
				;
		}
		$api->get();

		$conflict_bookings = $api->response();

		foreach( $conflict_bookings as $cb ){
			if( ! isset($my_return['bookings']) ){
				$my_return['bookings'] = array();
			}
			$my_return['bookings'][$cb['id']] = $cb;
		}

		if( $my_return ){
			$return['overlap'] = $my_return;
		}

		return $return;
	}
}