<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_View_Index_Layout_RB_HC_MVC extends _HC_MVC
{
	public function render( $content )
	{
		$header = $this->make('view/index/header');
		$menubar = $this->make('view/index/menubar');

		$out = $this->make('/layout/view/content-header-menubar')
			->set_content( $content )
			->set_header( $header )
			->set_menubar( $menubar )
			;

		return $out;
	}
}