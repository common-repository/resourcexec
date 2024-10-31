<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Resources_Form_Bookings_RB_HC_MVC extends _HC_MVC
{
	public function extend_to_model( $return, $args )
	{
		$values = array_shift( $args );
		if( array_key_exists('resource', $values) ){
			$rid = $values['resource'];
			$resources = isset($return['resources']) ? $return['resources'] : array();
			if( ! in_array($rid, $resources) ){
				$resources[] = $rid;
			}
			$return['resources'] = $resources;
		}
		return $return;
	}

	public function extend_init( $return )
	{
		$id = $this->make('/http/lib/uri')
			->arg('resource')
			;
		if( ! $id ){
			return $return;
		}

		$api = $this->make('/http/lib/api')
			->request('/api/resources')
			->add_param('id', $id)
			;
		$resource = $api
			->get()
			->response()
			;
		$p = $this->make('/resources/presenter');
		$p->set_data( $resource );

		$inputs = array();
		$inputs['resource'] = $this->make('/form/view/hidden')
			->set_value( $id )
			;
		$inputs['resource_view'] = $this->make('/form/view/label')
			->set_label( HCM::__('Resource') )
			->set_value( $p->present_title() )
			;
		foreach( $inputs as $ik => $iv ){
			$return->set_input( $ik, $iv );
		}

		return $return;
	}
}