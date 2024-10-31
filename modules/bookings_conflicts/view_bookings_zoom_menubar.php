<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Conflicts_View_Bookings_Zoom_Menubar_RB_HC_MVC extends _HC_MVC
{
	public function extend_render( $return, $args )
	{
		$booking = array_shift( $args );

	// CONFLICTS
		$cm = $this->make('/conflicts/model/manager');
		$conflicts = $cm->run('conflicts', $booking);

		if( $conflicts ){
			$return->add(
				'conflicts',
				$this->make('/html/view/link')
					->to('/conflicts', array('booking' => $booking['id']))
					->add( $this->make('/html/view/icon')->icon('exclamation') )
					->add( HCM::__('Conflicts') )
					->add_style('color', 'red')
				);
		}

		return $return;
	}
}