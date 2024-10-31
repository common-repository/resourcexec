<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Wordpress_Theme_View_Styler_HC_MVC extends Theme_View_Styler_HC_MVC
{
	function btn_success()
	{
		$return = $this->style( 
			array(
				'padding'	=> array('x2', 'y1'),
				)
			);
		$return[] = 'page-title-action';
		return $return;
	}

	function btn_primary()
	{
		$return = array('button', 'button-primary');
		return $return;
	}

	function btn_secondary()
	{
		$return = array('button', 'button-secondary');
		return $return;
	}

	function btn_danger()
	{
		$return = array('button', 'button-secondary');

		$style = array(
			'border-color'	=> array('red'),
			'color'			=> array('red'),
			);
		$my_return = $this->style($style);

		$return = array_merge( $return, $my_return );
		return $return;
	}
}