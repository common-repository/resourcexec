<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Validator_RB_HC_MVC extends _HC_Validator
{
	public function prepare( $values )
	{
		$return = array();

		$return['duration'] = array(
			'required'	=> array( $this->make('/validate/required') )
			);

		$return['date'] = array(
			'required'	=> array( $this->make('/validate/required') )
			);

		return $return;
	}
}