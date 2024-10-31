<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_View_Booking_Layout_RB_HC_MVC extends _HC_MVC
{
	public function render( $content, $model )
	{
		$header = $this->make('view/booking/header')
			->run('render', $model)
			;
		$menubar = $this->make('view/booking/menubar')
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