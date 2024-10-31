<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_View_Zoom_Menubar_RB_HC_MVC extends _HC_MVC 
{
	public function render( $model )
	{
		$menubar = $this->make('/html/view/container');
		return $menubar;
	}
}