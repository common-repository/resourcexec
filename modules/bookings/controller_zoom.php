<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Bookings_Controller_Zoom_RB_HC_MVC extends _HC_MVC
{
	public function route_index()
	{
		$args = hc2_parse_args( func_get_args() );
		$id = isset($args['id']) ? $args['id'] : 0;

		$model = $this->run('prepare-model', $id);
		// echo $model->url();

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
			->request('/api/bookings')
			->add_param('id', $id)
			->add_param('with', 'schedule')
			;
		return $model;
	}

	public function prepare_form( $values, $options = array(), $errors = array() )
	{
		$form = $this->make('form');
		$values = $form->run('from-model', $values);

		$form
			->set_values( $values )
			->set_options( $options )
			->set_errors( $errors )
			;
		return $form;
	}

	public function prepare_view( $model, $form )
	{
		$view = $this->make('view/zoom')
			->run('render', $model, $form)
			;
		$view = $this->make('view/zoom/layout')
			->run('render', $view, $model)
			;

		$view = $this->make('/layout/view/body')
			->set_content($view)
			;
		return $this->make('/http/view/response')
			->set_view($view) 
			;
	}
}