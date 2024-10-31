<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Agenda_View_Layout_RB_HC_MVC extends _HC_MVC
{
	public function render( $content )
	{
		$header = $this->make('view/header');
		$menubar = $this->make('view/menubar');

		$out = $this->make('/layout/view/content-header-menubar')
			->set_content( $content )
			->set_header( $header )
			->set_menubar( $menubar )
			;

		return $out;
	}
}