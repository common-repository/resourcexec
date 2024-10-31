<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Reports_View_Header_RB_HC_MVC extends _HC_MVC 
{
	public function render()
	{
		$return = $this->make('/html/view/element')->tag('h1')
			->add( HCM::__('Reports') )
			;
		return $return;
	}
}