<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Agenda_View_Menubar_RB_HC_MVC extends _HC_MVC 
{
	public function render()
	{
		$menubar = $this->make('/html/view/container');

	// ADD
		$menubar->add(
			'add',
			$this->make('/html/view/link')
				->to('/bookings/new', array('--back' => 'agenda'))
				->add( $this->make('/html/view/icon')->icon('plus') )
				->add( HCM::__('New Booking') )
			);

		return $menubar;
	}
}
