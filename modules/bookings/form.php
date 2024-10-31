<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Form_RB_HC_MVC extends _HC_Form
{
	public function _init()
	{
	// validator
		$validator = $this->make('validator/form');
		$this->add_validator( $validator );

		$inputs = array();

		$inputs['duration'] = $this->make('/form/view/duration2')
			->set_label( HCM::__('Duration') )
			;

		$inputs['time_start'] = $this->make('/form/view/time')
			->set_label( HCM::__('Time') )
			->set_observe('duration_units=minutes duration_units=hours')
			;

		$inputs['date'] = $this->make('/form/view/date')
			->set_label( HCM::__('Date') )
			;

		foreach( $inputs as $ik => $iv ){
			$this->set_input( $ik, $iv );
		}

		return $this;
	}

	public function from_model( $values )
	{
		$return = $values;

		if( array_key_exists('id', $values) ){
			$return['id'] = $values['id'];
		}

		$return['time_start'] = $values['time_start'];
		$return['date'] = $values['date'];
		$return['duration'] = $values['duration'];

		return $return;
	}

	public function to_model( $values )
	{
		$return = array();

		if( array_key_exists('id', $values) ){
			$return['id'] = $values['id'];
		}

		$return['date'] = $values['date'];
		$return['duration'] = $values['duration'];

		list( $duration_qty, $duration_units ) = explode(' ', $values['duration']);
		if( ! in_array($duration_units, array('minutes', 'hours')) ){
			$return['time_start'] = NULL;
		}
		else {
			$return['time_start'] = $values['time_start'];
		}

		return $return;
	}
}