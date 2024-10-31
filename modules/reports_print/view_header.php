<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Reports_Print_View_Header_RB_HC_MVC extends _HC_MVC
{
	public function extend_render( $return )
	{
		$is_print_view = $this->make('/print/controller')->run('is-print-view');
		if( $is_print_view ){
			return $return;
		}

	// PRINTER
		$print_link = $this->make('/print/view/link')
			->add_style('right', 'sm')
			->add_style('block-link')
			;

		$return = $this->make('/html/view/grid')
			->set_scale('sm')
			->add( $return, 8 )
			->add( $print_link, 4)
			;

		return $return;
	}
}