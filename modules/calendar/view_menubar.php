<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Calendar_View_Menubar_RB_HC_MVC extends _HC_MVC 
{
	public function render()
	{
		$menubar = $this->make('/html/view/container');
		return $menubar;
	}
}
