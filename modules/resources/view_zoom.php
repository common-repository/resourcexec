<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_View_Zoom_RB_HC_MVC extends _HC_MVC
{
	public function render( $model, $form )
	{
		$id = $model['id'];

		$link = $this->make('/html/view/link')
			->to('update', $id)
			->href()
			;

		$display_form = $this->make('/html/view/form')
			->add_attr('action', $link )
			->set_form( $form )
			;

		$inputs = $form->inputs();
		foreach( $inputs as $input_name => $input ){
			$input_view = $this->make('/html/view/label-input')
				->set_label( $input->label() )
				->set_content( $input )
				->set_error( $input->error() )
				;

			$display_form
				->add( $input_view )
				;
		}

		if( ! $form->readonly() ){
			$buttons = $this->run('prepare-actions', $model);
			$display_form->add( $buttons );
		}
		return $display_form;
	}

	public function prepare_actions( $model )
	{
		$buttons = $this->make('/html/view/list-inline');

		$buttons->add(
			'save',
			$this->make('/html/view/element')->tag('input')
				->add_attr('type', 'submit')
				->add_attr('title', HCM::__('Save') )
				->add_attr('value', HCM::__('Save') )
				->add_style('btn-primary')
			);

		$buttons->add(
			'delete',
			$this->make('/html/view/link')
				->to('delete', $model['id'])
				->add_attr('class', 'hcj2-confirm')
				->add( HCM::__('Delete') )
				->add_style('btn-danger')
			);

		return $buttons;
	}
}
?>