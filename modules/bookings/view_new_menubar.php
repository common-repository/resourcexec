<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_View_New_Menubar_RB_HC_MVC extends _HC_MVC 
{
	public function render()
	{
		$menubar = $this->make('/html/view/container');

	// AGENDA
		$menubar->add(
			'agenda',
			$this->make('/html/view/link')
				->to('/agenda')
				->add( $this->make('/html/view/icon')->icon('list') )
				->add( HCM::__('Agenda') )
			);

	// CALENDAR
		$menubar->add(
			'calendar',
			$this->make('/html/view/link')
				->to('/calendar')
				->add( $this->make('/html/view/icon')->icon('calendar') )
				->add( HCM::__('Calendar') )
			);

		return $menubar;
	}
}
