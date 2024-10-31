<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_Form_Booking_RB_HC_MVC extends _HC_Form
{
	private function _init_inputs( $booking )
	{
		$current_resources = ( isset($booking['resources']) ) ? $booking['resources'] : array();

	// get resources
		$api = $this->make('/http/lib/api')
			->request('/api/resources')
			->get()
			;
		$all_resources = $api->response();

		$p = $this->make('/resources/presenter');
		$free_resources = array();
		foreach( $all_resources as $r ){
			$free_resources[$r['id']] = $p->set_data($r)->present_name();
		}

		$input_resource = $this->make('/form/view/checkbox-set');

		if( $free_resources ){
			$input_resource->set_options( $free_resources );
		}

		$this
			->set_input( 'resources',
				$input_resource
					->set_label('-nolabel-')
				)
			;

		if( $current_resources ){
			$this->set_value('resources', array_keys($current_resources));
		}

		return $this;
	}

	public function set_model( $model )
	{
		$this->_init_inputs( $model );
		return parent::set_model( $model );
	}
}