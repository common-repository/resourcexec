<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_View_Booking_Header_RB_HC_MVC extends _HC_MVC 
{
	public function render()
	{
		$return = HCM::__('Assign Resources');
		$return = $this->make('/html/view/element')->tag('h1')
			->add($return)
			;
		return $return;
	}
}