<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Flashdata_Wordpress_Layout_Bootstrap_HC_MVC extends _HC_MVC
{
	public function run()
	{
		add_action( 'admin_notices', array($this, 'admin_notices') );
	}

	public function admin_notices()
	{
		$session = $this->make('/session/lib');

		$message = $session->flashdata('message');
		$error = $session->flashdata('error');
		$form_errors = $session->flashdata('form_errors');
		$debug = $session->flashdata('debug');

		$out = NULL;

		if( $form_errors ){
			$out = $this->make('/html/view/element')->tag('div')
				->add_attr('class', array('notice', 'notice-error', 'is-dismissible'))
				;
			$out
				->add(
					$this->make('/html/view/element')->tag('p')
						->add( HCM::__('Please correct the form errors and try again') )
					)
				;
		}

		if( $error ){
			if( ! is_array($error) ){
				$error = array( $error );
			}

			$out = $this->make('/html/view/element')->tag('div')
				->add_attr('class', array('notice', 'notice-error', 'is-dismissible'))
				;
			foreach( $error as $e ){
				$out
					->add(
						$this->make('/html/view/element')->tag('p')
							->add( $e )
						)
					;
			}
		}

		if( $message ){
			if( ! is_array($message) ){
				$message= array( $message );
			}

			$out = $this->make('/html/view/element')->tag('div')
				->add_attr('class', array('notice', 'notice-success', 'is-dismissible'))
				;

			foreach( $message as $e ){
				$out
					->add(
						$this->make('/html/view/element')->tag('p')
							->add( $e )
						)
					;
			}
		}

		if( $out ){
			echo $out;
		}
	}
}