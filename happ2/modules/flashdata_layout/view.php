<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Flashdata_Layout_View_HC_MVC extends _HC_MVC
{
	public function render()
	{
		$flash_out = NULL;

		$session = $this->make('/session/lib');

		$message = $session->flashdata('message');
		$error = $session->flashdata('error');
		$form_errors = $session->flashdata('form_errors');
		$debug = $session->flashdata('debug');

		// $message = 'LALA';
		// $error = 'ERROR';
		// $debug = 'DEBUGME';

		if( $message OR $error OR $form_errors OR $debug ){
			$flash_out = $this->make('/html/view/container');

			if( $form_errors ){
				$out = $this->make('/html/view/element')->tag('div')
					->add_attr('class', 'hcj2-auto-dismiss')
					->add_attr('class', 'hcj2-alert')
					->add_style('margin', 'b2')
					->add_style('padding', 0)
					->add_style('border')
					;

				$msg_view = $this->make('/html/view/list')
					->add_style('margin', 0)
					->add_attr('style', 'border-width: 4px;')
					->add_style('border', 'left')
					->add_style('border-color', 'red')
					->add_style('display', 'block')
					;

				$msg_view2 = $this->make('/html/view/element')->tag('div')
					->add_style('padding', 2)
					->add( HCM::__('Please correct the form errors and try again') )
					->add(
						$this->make('/html/view/element')->tag('a')
							->add( $this->make('/html/view/icon')->icon('times') )
							->add_style('color', 'red')
							->add_style('closer')
							->add_attr('class', 'hcj2-alert-dismisser')
						)
					;
				$msg_view->add( $msg_view2 );

				$out->add( $msg_view );

				$flash_out->add( $out );
			}

			if( $message ){
				$out = $this->make('/html/view/element')->tag('div')
					->add_attr('class', 'hcj2-auto-dismiss')
					->add_attr('class', 'hcj2-alert')
					->add_style('margin', 'b2')
					->add_style('padding', 0)
					->add_style('border')
					;

				if( ! is_array($message) ){
					$message = array( $message );
				}

				$msg_view = $this->make('/html/view/element')->tag('div')
					->add_style('margin', 0)
					->add_attr('style', 'border-width: 4px;')
					->add_style('border', 'left')
					->add_style('border-color', 'olive')
					->add_style('display', 'block')
					;

				foreach( $message as $m ){
					$msg_view2 = $this->make('/html/view/element')->tag('div')
						->add_style('padding', 2)
						// ->add_style('bg-lighten', 4)

						->add( $m )
						->add(
							$this->make('/html/view/element')->tag('a')
								->add( $this->make('/html/view/icon')->icon('times') )
								->add_style('color', 'red')
								->add_style('closer')
								->add_attr('class', 'hcj2-alert-dismisser')
							)
						;
					$msg_view->add( $msg_view2 );
				}
				$out->add( $msg_view );

				$flash_out->add( $out );
			}

			if( $error ){
				$out = $this->make('/html/view/element')->tag('div')
					->add_attr('class', 'hcj2-auto-dismiss')
					->add_attr('class', 'hcj2-alert')
					->add_style('margin', 'b2')
					->add_style('padding', 0)
					->add_style('border')
					;

				if( ! is_array($error) ){
					$error = array( $error );
				}

				$msg_view = $this->make('/html/view/list')
					->add_style('margin', 0)
					->add_attr('style', 'border-width: 4px;')
					->add_style('border', 'left')
					->add_style('border-color', 'red')
					->add_style('display', 'block')
					;

				foreach( $error as $m ){
					$msg_view2 = $this->make('/html/view/element')->tag('div')
						->add_style('padding', 2)
						// ->add_style('bg-lighten', 4)

						->add( $m )
						->add(
							$this->make('/html/view/element')->tag('a')
								->add( $this->make('/html/view/icon')->icon('times') )
								->add_style('color', 'red')
								->add_style('closer')
								->add_attr('class', 'hcj2-alert-dismisser')
							)
						;
					$msg_view->add( $msg_view2 );
				}
				$out->add( $msg_view );

				$flash_out->add( $out );
			}

			if( $debug ){
				$out = $this->make('/html/view/element')->tag('div')
					->add_style('box')
					->add_style('border-color', 'orange')
					->add_style('border')
					;

				if( ! is_array($debug) ){
					$debug = array( $debug );
				}

				$msg_view = $this->make('/html/view/list')
					->add_style('margin', 0)
					;
				foreach( $error as $m ){
					$msg_view2 = $this->make('/html/view/element')->tag('div')
						->add_style('padding', 1)

						->add( $m )
						;
					$msg_view->add( $msg_view2 );
				}
				$out->add( $msg_view );

				$flash_out->add( $out );
			}
		}

		return $flash_out;
	}
}