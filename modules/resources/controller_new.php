<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Controller_New_RB_HC_MVC extends _HC_MVC
{
	public function route_index()
	{
		$form = $this->run('prepare-form');
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