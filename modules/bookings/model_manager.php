<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Model_Manager_RB_HC_MVC extends _HC_MVC
{
	public function get_duration( $booking )
	{
		$return = $booking['duration'];
		if( ! $return ){
			$time_end = $booking['time_end'];
			$time_start = $booking['time_start'];

			if( $time_end > $time_start ){
				$return = $time_end - $time_start;
			}
			else {
				$return = $time_end + (24*60*60 - $time_start);
			}
		}
		return $return;
	}
}