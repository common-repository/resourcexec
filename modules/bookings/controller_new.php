<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Controller_New_RB_HC_MVC extends _HC_MVC
{
	public function route_index()
	{
		$args = hc2_parse_args( func_get_args(), TRUE );
		
		$pass = array('date', 'resources');

		$values = array();
		foreach( $pass as $k ){
			if( array_key_exists($k, $args) ){
				$values[$k] = $args[$k];
			}
		}

		$form = $this->run('prepare-form', $values);
		return $this->run('prepare-view', $form);
	}

	public function prepare_form( $values = array(), $options = array(), $errors = array() )
	{
		$form = $this->make('form')
			->set_values( $values )
			->set_options( $options )
			->set_errors( $errors )
			;
		return $form;
	}

	public function prepare_view( $form )
	{
		$view = $this->make('view/new')
			->run('render', $form)
			;
		$view = $this->make('view/new/layout')
			->run('render', $view)
			;
		$view = $this->make('/layout/view/body')
			->set_content($view)
			;
		return $this->make('/http/view/response')
			->set_view($view)
			;
	}
}