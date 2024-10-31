<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Presenter_RB_HC_MVC extends _HC_MVC_Model_Presenter
{
	public function present_name()
	{
		$return = $this->data('name') ? $this->data('name') : HCM::__('Unknown');
		return $return;
	}

	function present_title()
	{
		return $this->present_name();
	}
}