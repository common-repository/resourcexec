<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Reports_Report_Utilization_RB_HC_MVC extends _HC_MVC
{
	public function extend_prepare_header( $return, $args, $src )
	{
		$my_return = array(
			'bookings' => HCM::__('Bookings')
			);

		$return = array_merge( $return, $my_return );
		return $return;
	}

	public function extend_prepare_sort( $return, $args, $src )
	{
		$my_return = array(
			'bookings' => 0
			);

		$return = array_merge( $return, $my_return );
		return $return;
	}

	public function extend_prepare_rows( $return, $src_args, $src )
	{
		$args = count($src_args) ? array_shift($src_args) : array();
		$t = $this->make('/app/lib')->run('time');

		$booking_manager = $this->make('/bookings/model/manager');

		$check_dates = array();
		if( isset($args['start_date']) && isset($args['end_date']) ){
			$t->setDateDb($args['start_date']);
			$rex_date = $t->formatDate_Db();

			if( $args['end_date'] ){
				while( $rex_date <= $args['end_date'] ){
					$check_dates[] = $rex_date;
					$t->modify('+1 day');
					$rex_date = $t->formatDate_Db();
				}
			}
			else {
				$check_dates[] = $rex_date;
			}
		}

		$rids = array_keys($return);

		foreach( $rids as $rid ){
			$return[$rid]['bookings'] = 0;
			$return[$rid]['bookings_days'] = 0;
			$return[$rid]['bookings_hours'] = 0;
			$return[$rid]['bookings_view'] = '-';

			reset( $check_dates );
			foreach( $check_dates as $check_date ){
				$t->setDateDb( $check_date );
				$ts_start = $t->getStartDay();
				$ts_end = $t->getEndDay();

				$api = $this->make('/http/lib/api')
					->request('/api/bookings')
					->add_param('ts_start', array('<', $ts_end))
					->add_param('ts_end', array('>=', $ts_start))
					->add_param('resources', $rid)
					;

				$bookings = $api
					->get()
					->response()
					;

				if( $bookings ){
					foreach( $bookings as $bk ){
						$duration = $bk['ts_end'] - $bk['ts_start'];
						$return[$rid]['bookings'] += $duration;
					}
				}
			}
		}

	// format duration
		foreach( $return as $rid => $rs ){
			if( $return[$rid]['bookings'] ){
				$return[$rid]['bookings_view'] = $t->formatPeriodShort($return[$rid]['bookings']);
			}
		}

		return $return;
	}
}