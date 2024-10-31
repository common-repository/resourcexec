<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_Controller_Zoom_RB_HC_MVC extends _HC_MVC
{
	public function route_index( $id )
	{
		$model = $this->run('prepare-model', $id);
		$values = $model
			->get()
			->response()
			;

		$form = $this->run('prepare-form', $values);
		return $this->run('prepare-view', $values, $form);
	}

	public function prepare_model( $id )
	{
		$model = $this->make('/http/lib/api')
			->request('/api/resources')
			->add_param('id', $id)
			;
		return $model;
	}

	public function prepare_form( $values, $options = array(), $errors = array() )
	{
		$form = $this->make('form/delete');
		$form
			->set_values( $values )
			->set_options( $options )
			->set_errors( $errors )
			;
		return $form;
	}

	public function prepare_view( $model, $form )
	{
		$view = $this->make('view/zoom/index')
			->run('render', $model, $form)
			;
		$view = $this->make('/layout/view/body')
			->set_content($view)
			;
		return $this->make('/http/view/response')
			->set_view($view) 
			;
	}
}