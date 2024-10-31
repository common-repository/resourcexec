<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Reports_Bootstrap_RB_HC_MVC extends _HC_MVC
{
	public function run()
	{
		$link = $this->make('/html/view/link')
			->to('/reports')
			->add( $this->make('/html/view/icon')->icon('report') )
			->add( HCM::__('Reports') )
			;

		$top_menu = $this->make('/html/view/top-menu')
			->add( $link )
			;
	}
}