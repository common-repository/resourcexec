<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Presenter_RB_HC_MVC extends _HC_MVC_Model_Presenter
{
	public function present_title_id()
	{
		$return = $this->present_title();
		$id = $this->data('id');

		$id_view = $this->make('/html/view/element')->tag('span')
			->add('id:' . $id)
			->add_style('font-size', -1)
			->add_style('mute')
			;

		$return = $return . ' ' . $id_view;
		return $return;
	}

	public function present_title()
	{
		$t = $this->make('/app/lib')->run('time');
		$return = array();

	// duration & time
		$time_view = $this->present_time();
		if( $time_view ){
			$time_view = '[' . $time_view . ']';
			$return[] = $time_view;
		}

	// date view
		$date_view = $this->present_date();
		if( $date_view ){
			$return[] = $date_view;
		}

		$return = join( ' ', $return );
		return $return;
	}

	public function present_date()
	{
		$t = $this->make('/app/lib')->run('time');

		$date = $this->data('date');
		$duration = $this->data('duration');

		$return = $t
			->setDateDb( $date )
			->formatDateFull()
			;

		list( $dura_qty, $dura_units ) = explode(' ', $duration);
		if( ! in_array($dura_units, array('minutes', 'hours')) ){
			// show end date too
			$t->modify('+ ' . $duration);
			$t->modify('-1 second');
			$end_date = $t->formatDateDb();
			$return = $t->formatDateRange( $date, $end_date );
		}

		return $return;
	}

	public function present_time()
	{
		$t = $this->make('/app/lib')->run('time');
		$return = array();

	// duration
		$duration = $this->data('duration');
		list( $dura_qty, $dura_units ) = explode(' ', $duration);

		// if( $duration !== NULL ){
			// $duration_view = $duration;
			// $return[] = $duration_view;
		// }

	// time
		$time_start = $this->data('time_start');
		if( $time_start !== NULL ){
			if( in_array($dura_units, array('minutes', 'hours')) ){
				$date = $this->data('date');
				$duration_seconds = $t->durationToSeconds($duration);

				$t->setDateDb( $date );
				$t->modify('+ ' . $time_start . ' seconds');

				$time_start_view = $t->formatTime( $duration_seconds );
			}
			else {
				$time_start_view = $t->formatTimeOfDay( $time_start );
				$time_start_view = '@' . $time_start_view;
			}

			$return[] = $time_start_view;
		}

		$return = join(' ', $return);
		return $return;
	}
}