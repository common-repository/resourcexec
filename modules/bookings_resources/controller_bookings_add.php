<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_Controller_Bookings_Add_RB_HC_MVC extends _HC_MVC
{
	public function extend_prepare( $return, $args, $src )
	{
		$post = array_shift( $args );
		$input_resource = $this->make('/form/view/hidden')
			->set_name('resource')
			;
		$resource = $input_resource
			->grab($post)
			->value()
			;

		if( ! $resource ){
			return $return;
		}

		$return['resources'] = array( $resource );
		return $return;
	}

	public function extend_complete( $return, $args, $src )
	{
		$booking = array_shift( $args );

		if( isset($booking['resources']) && $booking['resources'] ){
			return $return;
		}

	// redirect to assign resources
		$new_id = $booking['id'];
		$redirect_to = $this->make('/html/view/link')
			->to('booking', $new_id)
			->href()
			;
		return $this->make('/http/view/response')
			->set_redirect($redirect_to) 
			;
	}
}