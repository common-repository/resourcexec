<?php if (! defined('ABSPATH')) exit; // Exit if accessed directly
class Resources_View_Index_Menubar_RB_HC_MVC extends _HC_MVC 
{
	public function render()
	{
		$menubar = $this->make('/html/view/container');

	// ADD
		$menubar->add(
			'add',
			$this->make('/html/view/link')
				->to('new')
				->add( $this->make('/html/view/icon')->icon('plus') )
				->add( HCM::__('Add New Resource') )
			);

		return $menubar;
	}
}