<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Conf_View_HC_MVC extends _HC_MVC
{
	public function render( $form )
	{
		$link = $this->make('/html/view/link')
			->to('update')
			->href()
			;

		$display_form = $this->make('/html/view/form')
			->add_attr('action', $link )
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
			$buttons = $this->make('/html/view/list-inline')
				;

			$buttons->add(
				$this->make('/html/view/element')->tag('input')
					->add_attr('type', 'submit')
					->add_attr('title', HCM::__('Save') )
					->add_attr('value', HCM::__('Save') )
					->add_style('btn-primary')
				);

			$display_form->add( $buttons );
		}

		return $display_form;
	}
}