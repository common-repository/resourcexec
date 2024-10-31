<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Auth_View_Forgot_HC_MVC extends _HC_MVC
{
	public function render( $form )
	{
		$header = $this->make('/html/view/element')->tag('h1')
			->add( HCM::__('Lost your password?') )
			->add_style('margin', 'b2')
			;

		$link = $this->make('/html/view/link')
			->to('forgot/send')
			->href()
			;

		$display_form = $this->make('/html/view/form')
			->add_attr('action', $link )
			;

		if( $form->exists('email') ){
			$display_form->add(
				$this->make('/html/view/label-input')
					->set_content( 
						$form->input('email')
						)
					->set_error( $form->input('email')->error() )
				);
		}

		if( ! $form->readonly() ){
			$buttons = $this->make('/html/view/list-inline')
				;

			$buttons->add(
				$this->make('/html/view/element')->tag('input')
					->add_attr('type', 'submit')
					->add_attr('title', HCM::__('Get New Password') )
					->add_attr('value', HCM::__('Get New Password') )
					->add_style('btn-primary')
				);

			$display_form->add( $buttons );
		}

		$out = $this->make('/html/view/container');
		$out->add( $header );
		$out->add( $display_form );

		return $out;
	}
}