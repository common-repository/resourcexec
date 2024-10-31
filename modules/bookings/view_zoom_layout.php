<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_View_Zoom_Layout_RB_HC_MVC extends _HC_MVC
{
	public function render( $content, $model )
	{
		$menubar = $this->make('view/zoom/menubar')
			->run('render', $model)
			;
		$header = $this->make('view/zoom/header')
			->run('render', $model)
			;

		$out = $this->make('/layout/view/content-header-menubar')
			->set_content( $content )
			->set_header( $header )
			->set_menubar( $menubar )
			;

		return $out;
	}
}