<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Conflicts_View_Index_Menubar_RB_HC_MVC extends _HC_MVC 
{
	public function render()
	{
		$menubar = $this->make('/html/view/container');

		$uri = $this->make('/http/lib/uri');

		$booking_id = $uri->arg('booking');
		if( $booking_id ){
			$booking = $this->make('/http/lib/api')
				->request('/api/bookings')
				->add_param($booking_id)
				->get()
				->response()
				;

			$p = $this->make('/bookings/presenter');
			$p->set_data( $booking );

			$menu_title = HCM::__('Booking') . ': ' . $p->present_title_id();

			$menubar->add(
				'booking',
				$this->make('/html/view/link')
					->to('/bookings/zoom', array('id' => $booking['id']))
					->add( $this->make('/html/view/icon')->icon('arrow-left') )
					->add( $menu_title )
				);
		}

		return $menubar;
	}
}