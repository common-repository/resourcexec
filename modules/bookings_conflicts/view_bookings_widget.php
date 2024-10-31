<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Conflicts_View_Bookings_Widget_RB_HC_MVC extends _HC_MVC
{
	public function extend_prepare_view( $return, $args )
	{
		$booking = array_shift( $args );
		$date = array_shift( $args );

		$conflicts_manager = $this->make('/conflicts/model/manager');
		$conflicts = $conflicts_manager->run('conflicts', $booking, $date);

		if( $conflicts ){
			$conflicts_view = array();
			$conflicts_view[] = $this->make('/html/view/icon')->icon('exclamation')
				->add_attr('title', HCM::__('Conflicts'))
				;
			// $conflicts_view[] = HCM::__('Conflicts');

			$conflicts_view = $this->make('/html/view/link')
				->to('/conflicts',
					array(
						'booking'	=> $booking['id'],
						)
					)
				->add( $conflicts_view )
				->add_style('color', 'red')
				;

			$return['conflicts'] = $conflicts_view;
		}
		else {
		}

		return $return;
	}
}