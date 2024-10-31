<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Bootstrap_RB_HC_MVC extends _HC_MVC
{
	public function run()
	{
		$link = $this->make('/html/view/link')
			->to('/resources')
			->add( $this->make('/html/view/icon')->icon('resource') )
			->add( HCM::__('Resources') )
			;

		$top_menu = $this->make('/html/view/top-menu')
			->add( $link )
			;
	}
}