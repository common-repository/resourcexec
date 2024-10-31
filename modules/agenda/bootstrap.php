<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Agenda_Bootstrap_RB_HC_MVC extends _HC_MVC
{
	public function run()
	{
		$link = $this->make('/html/view/link')
			->to('/agenda')
			->add( $this->make('/html/view/icon')->icon('list') )
			->add( HCM::__('Agenda') )
			;

		$top_menu = $this->make('/html/view/top-menu')
			->add( $link )
			;
	}
}