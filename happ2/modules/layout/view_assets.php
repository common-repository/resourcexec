<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Layout_View_Assets_HC_MVC extends _HC_MVC
{
	public function css()
	{
		if( defined('NTS_DEVELOPMENT2') ){
			$return = array(
				'reset'			=> 'happ2/assets/css/hc-1-reset.css',
				'utilities'		=> 'happ2/assets/css/hc-2-utilities.css',
				'bass'			=> 'happ2/assets/css/hc-3-bass.css',
				'style'			=> 'happ2/assets/css/hc-4-style.css',
				'form'			=> 'happ2/assets/css/hc-5-form.css',
				'grid'			=> 'happ2/assets/css/hc-6-grid.css',
				'javascript'	=> 'happ2/assets/css/hc-7-javascript.css',
				'datepicker'	=> 'happ2/assets/css/hc-8-datepicker.css',
				'schecal'		=> 'happ2/assets/css/hc-9-schecal.css',
				'animate'		=> 'happ2/assets/css/hc-10-animate.css',
				);
		}
		else {
			$return = array(
				'hc'	=> 'happ2/assets/css/hc.css',
				);
		}

		$return['font'] = 'https://fonts.googleapis.com/css?family=PT+Sans';
		return $return;
	}

	public function js()
	{
		$return = array(
			'hc'			=> 'happ2/assets/js/hc2.js',
			'datepicker'	=> 'happ2/assets/js/hc-datepicker2.js',
			);
		return $return;
	}
}