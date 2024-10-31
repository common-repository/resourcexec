<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_View_Zoom_Menubar_RB_HC_MVC extends _HC_MVC
{
	public function render( $model )
	{
		$menubar = $this->make('/html/view/container');

		$date = $model['date'];

	// AGENDA
		$menubar->add(
			'agenda',
			$this->make('/html/view/link')
				->to('/agenda', array('-date' => $date))
				->add( $this->make('/html/view/icon')->icon('list') )
				->add( HCM::__('Agenda') )
			);

	// CALENDAR
		$menubar->add(
			'calendar',
			$this->make('/html/view/link')
				->to('/calendar', array('-date' => $date))
				->add( $this->make('/html/view/icon')->icon('calendar') )
				->add( HCM::__('Calendar') )
			);

		return $menubar;
	}
}