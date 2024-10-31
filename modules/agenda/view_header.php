<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Agenda_View_Header_RB_HC_MVC extends _HC_MVC 
{
	public function render()
	{
		$return = HCM::__('Agenda');
		$return = $this->make('/html/view/element')->tag('h1')
			->add( $return )
			;
		return $return;
	}
}
