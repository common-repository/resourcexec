<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Calendar_Bootstrap_RB_HC_MVC extends _HC_MVC
{
	public function run()
	{
		$link = $this->make('/html/view/link')
			->to('/calendar')
			->add( $this->make('/html/view/icon')->icon('calendar') )
			->add( HCM::__('Calendar') )
			;

		$top_menu = $this->make('/html/view/top-menu')
			->add( $link )
			;
	}
}