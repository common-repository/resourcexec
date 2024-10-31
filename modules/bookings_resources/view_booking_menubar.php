<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_View_Booking_Menubar_RB_HC_MVC extends _HC_MVC 
{
	public function render( $model )
	{
		$p = $this->make('/bookings/presenter')
			->set_data($model)
			;

		$menubar = $this->make('/html/view/container');

		$title_view = $p->present_title_id();

		$link = $this->make('/html/view/link')
			->to('/bookings/zoom', array('id' => $model['id']))
			->add( $this->make('/html/view/icon')->icon('arrow-left') )
			->add( HCM::__('Booking') . ': ' . $title_view )
			->always_show()
			;
		$menubar->add(
			'schedule',
			$link
			);

		return $menubar;
	}
}